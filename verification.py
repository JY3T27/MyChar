import pymupdf
import pytesseract
from PIL import Image
import sys
import os
import mimetypes
import spacy  # SpaCy
from spacy.pipeline import EntityRuler
import re
import requests
from bs4 import BeautifulSoup

pytesseract.pytesseract.tesseract_cmd = r'C:\Program Files\Tesseract-OCR\tesseract.exe'

def extract_text_pdf(file_path):
    with pymupdf.open(file_path) as doc:
        for page in doc:
            pix = page.get_pixmap()
            image_path = "temp.png"
            pix.save(image_path)
            text = pytesseract.image_to_string(Image.open(image_path))
            os.remove(image_path)
    return text

def extract_text_img(file_path):
    return pytesseract.image_to_string(Image.open(file_path))

def check_file_type(file_path):

    mime_type, _ = mimetypes.guess_type(file_path)
    if mime_type:
        if mime_type == "application/pdf":
            return extract_text_pdf(file_path)
        elif mime_type.startswith("image/"):
            return extract_text_img(file_path)
        else:
            return "Unknown File Type"
    else:
        return "Unknown File Type"

def extract_ros(info):
    start_keyword = "bahawa"
    end_keyword = "telah" 
    if start_keyword in info and end_keyword in info:
        start_index = info.find(start_keyword) + len(start_keyword)
        end_index = info.find(end_keyword)
        organization_name = info[start_index:end_index].strip()
        return organization_name
    else:
        return f"Name not found"

def find_organization(name):
    base_url = "https://www.ros.gov.my/www/portal-main/semakan2?search_keyword="
    search_url = f"{base_url}{name}"
    try:
        # Send a GET request to the website
        response = requests.get(search_url)
        response.raise_for_status()  # Check for HTTP request errors

        # Parse the response content with BeautifulSoup
        soup = BeautifulSoup(response.text, "html.parser")

        # Find the table with class="table"
        table = soup.find("table", class_="table")

        if table:
            # Extract rows from the table
            rows = table.find_all("tr")

            for row in rows:
                # Extract cells from each row
                cells = row.find_all("td")  # Only target <td> elements
                if len(cells) > 1:  # Ensure there is a second column
                    column_2_text = cells[1].get_text(strip=True)  # Get text from the second column
                    if (name == column_2_text):
                        return True
                    else:
                        print("No results found in the table.")
                        return False
        else:
            print("No table found with class 'table'.")
            return False

    except requests.RequestException as e:
        print("An error occurred while making the request:", e)
        return False

def separate_string(input_string):
    # Check if there are parentheses in the input string
    if '(' in input_string and ')' in input_string:
        # Split the string by double newlines first
        parts = input_string.split('\n\n')
        result = []
        
        for part in parts:
            # Use regex to capture the text before, inside, and after parentheses
            match = re.match(r'([^()]*)(\([^()]*\))(.*)', part)
            if match:
                before = match.group(1).strip()
                inside = match.group(2).strip()
                after = match.group(3).strip()
                
                # Add non-empty parts to the result
                if before:
                    result.append(before)
                if inside:
                    result.append(inside)
                if after:
                    result.append(after)
            else:
                # If no parentheses in this part, just add it as is
                result.append(part.strip())
        
        return result
    else:
        # If no parentheses, split into two parts based on double newlines
        return [part.strip() for part in input_string.split('\n\n') if part.strip()]

if __name__ == "__main__":
    if len(sys.argv) > 1:
        file_name = sys.argv[1]
        ner = spacy.load("xx_ent_wiki_sm")
        ruler = EntityRuler(ner, overwrite_ents=True)
        ruler.name = 'ruler_standard'
        ruler = ner.add_pipe("entity_ruler", name='ruler_standard', config={'overwrite_ents': True})
        patterns = [
            {"label": "SIJIL ROS", "pattern": "AKTA PERTUBUHAN"}
        ]
        ruler.add_patterns(patterns)

        name = "" 
        text = check_file_type(file_name)
        doc = ner(text)
        for ent in doc.ents:
            if ent.label_ == "SIJIL ROS":
                organization = extract_ros(text)
                part = separate_string(organization)
                name = part[0]
                break

        if (name == "" ):
            print("This is not ROS certificate.")
            sys.exit()

        if (find_organization(name)):
            print(f"Your organization name: \n\t{name}\nSuccessful found in ROS website.")
        else:
            print("The organization is not in the list.")

    else:
        print("Error. Nothing happened")


