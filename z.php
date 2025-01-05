<?php
// Start the session if you want to use session variables (optional)
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dynamic Comment Section</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        #comment-section {
            margin-bottom: 20px;
        }

        .comment {
            padding: 10px;
            border-bottom: 1px solid #ccc;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Comment Section</h1>
        <div id="comment-section">
            <!-- Comments will be displayed here -->
        </div>
        <input type="text" id="comment-input" placeholder="Write a comment...">
        <button id="submit-comment">Send</button>
    </div>

    <script>
        document.getElementById('submit-comment').addEventListener('click', function() {
            const commentInput = document.getElementById('comment-input');
            const commentText = commentInput.value;

            if (commentText.trim() !== '') {
                // Create a new comment element
                const commentElement = document.createElement('div');
                commentElement.classList.add('comment');
                commentElement.textContent = commentText;

                // Append the new comment to the comment section
                document.getElementById('comment-section').appendChild(commentElement);

                // Clear the input field
                commentInput.value = '';
            } else {
                alert("Please enter a comment.");
            }
        });
    </script>
</body>
</html>