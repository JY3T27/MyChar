<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Custom Checkbox with Colored Checkmark</title>
    <style>
        /* Hide the default checkbox */
        .custom-checkbox input[type="checkbox"] {
            display: none;
        }

        /* Style the custom checkbox container */
        .custom-checkbox span {
            width: 20px;
            height: 20px;
            display: inline-block;
            background-color: #ddd;
            border: 2px solid #888;
            border-radius: 3px;
            position: relative;
            cursor: pointer;
        }

        /* Style the checkmark */
        .custom-checkbox input[type="checkbox"]:checked + span::after {
            content: "";
            position: absolute;
            left: 6px;
            top: 2px;
            width: 6px;
            height: 12px;
            border: solid #4CAF50; /* Color of the checkmark */
            border-width: 0 2px 2px 0;
            transform: rotate(45deg);
        }

        /* Style when checkbox is disabled */
        .custom-checkbox input[type="checkbox"]:disabled + span {
            background-color: #f0f0f0;
            border-color: #bbb;
            cursor: not-allowed;
        }
        /* Style the disabled checkmark color */
        .custom-checkbox input[type="checkbox"]:checked:disabled + span::after {
            border-color: white; /* Gray color for disabled checkmark */
        }
    </style>
</head>
<body>
    <label class="custom-checkbox">
        <input type="checkbox" checked disabled>
        <span></span> I agree to the terms
    </label>
</body>
</html>
