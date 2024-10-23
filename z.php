<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Preview Example</title>
    <style>
        /* Styling for the preview image */
        #image-preview {
            width: 200px;
            height: 200px;
            object-fit: cover;
            margin-bottom: 10px;
            display: none; /* Hide by default */
        }
    </style>
</head>
<body>

    <!-- Image Preview -->
    <img id="image-preview" alt="Image Preview">

    <!-- File input for image upload -->
    <input type="file" id="image-input" accept="image/*">

    <script>
        // Select the input and image elements
        const imageInput = document.getElementById('image-input');
        const imagePreview = document.getElementById('image-preview');

        // Add an event listener to detect file selection
        imageInput.addEventListener('change', function() {
            const file = imageInput.files[0]; // Get the selected file
            if (file) {
                // Create a URL for the file and set it as the src of the image preview
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result; // Set the image source to the uploaded file
                    imagePreview.style.display = 'block'; // Show the image preview
                };
                reader.readAsDataURL(file); // Read the file as a data URL (base64 encoded)
            }
        });
    </script>

</body>
</html>
