<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Card Example</title>
    <style>
        /* Card container */
        .card {
            width: 300px;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            background-color: #f8f9fa; /* Card background color */
            color: #333;               /* Text color */
            text-align: center;
            transition: background-color 0.3s;
        }

        /* Change color on hover */
        .card:hover {
            background-color: #007bff; /* New color on hover */
            color: #fff;               /* Text color on hover */
        }
    </style>
</head>
<body>
    <div class="card">
        <h3>Card Title</h3>
        <p>This is a simple card example. Hover over the card to change its color.</p>
    </div>
</body>
</html>
