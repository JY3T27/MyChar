<?php
$target = 8888.88;
$collected = 888;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dynamic Donation Progress</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .donation-container {
            max-width: 500px;
            margin: 50px auto;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .progress-wrapper {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .progress {
            flex-grow: 1;
            margin-right: 10px;
            height: 30px;
        }

        .progress-percentage {
            font-size: 1rem;
            font-weight: bold;
        }
    </style>
</head>

<body class="bg-light">

    <div class="donation-container">
        <h1 class="mb-4">Donation Progress</h1>
        <div class="progress-wrapper">
            <div class="progress">
                <div id="progressBar" class="progress-bar bg-success" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <div id="progressPercentage" class="progress-percentage">0.00%</div>
        </div>
        <div class="donation-info">
            <p class="mb-1"><strong>Target:</strong> $<span id="targetAmount"><?php echo number_format($target, 2); ?></span></p>
            <p><strong>Collected:</strong> $<span id="collectedAmount"><?php echo number_format($collected, 2); ?></span></p>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- JavaScript -->
    <script>
        // Pass PHP values to JavaScript
        const target = <?php echo $target; ?>;
        const collected = <?php echo $collected; ?>;

        // Calculate progress percentage
        const progressPercentage = Math.min((collected / target) * 100, 100).toFixed(2); // Keep two decimal places

        // Update the progress bar dynamically
        const progressBar = document.getElementById('progressBar');
        const progressPercentageText = document.getElementById('progressPercentage');

        progressBar.style.width = progressPercentage + '%';
        progressBar.setAttribute('aria-valuenow', progressPercentage);
        progressPercentageText.textContent = progressPercentage + '%';
    </script>
</body>

</html>