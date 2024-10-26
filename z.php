<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facebook Post Example</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            padding: 20px;
        }
        .post {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 15px;
            margin-bottom: 20px;
        }
        .post-header {
            display: flex;
            align-items: center;
        }
        .profile-pic {
            border-radius: 50%;
            width: 50px;
            height: 50px;
            margin-right: 15px;
        }
        .post-content {
            margin-top: 10px;
        }
        .post-actions {
            margin-top: 15px;
        }
        .post-button {
            background-color: #e7e7e7;
            border: none;
            border-radius: 5px;
            padding: 8px 12px;
            cursor: pointer;
            margin-right: 5px;
        }
        .post-button:hover {
            background-color: #d4d4d4;
        }
    </style>
</head>
<body>

<div class="post">
    <div class="post-header">
        <img src="https://via.placeholder.com/50" alt="Profile Picture" class="profile-pic">
        <div>
            <strong>John Doe</strong><br>
            <span style="font-size: 12px; color: gray;">2 hours ago</span>
        </div>
    </div>
    <div class="post-content">
        <p>Had a great day at the beach! 🌊☀️ #sunnyday #beachlife</p>
        <img src="https://via.placeholder.com/500x300" alt="Beach" style="width: 100%; border-radius: 8px;">
    </div>
    <div class="post-actions">
        <button class="post-button">Like</button>
        <button class="post-button">Comment</button>
        <button class="post-button">Share</button>
    </div>
</div>

</body>
</html>