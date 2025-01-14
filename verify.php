<?php
session_start();
include 'config.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    include 'layout/header.php';
    ?>
    <script>
        function backToProfile() {
            window.location.href = "profile.php?id=<?= $userID?>";
        }
    </script>
</head>

<body class="index-page">
    <?php
    include 'layout/nav.php';
    $userID = $_SESSION['verifing'];
    unset($_SESSION['verifing']);
    $keyword = 'ROS website';
    $target_dir = "assets/docs/uploads/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if ($check !== false || strtolower(pathinfo($target_file, PATHINFO_EXTENSION)) == 'pdf') {
        $uploadOk = 1;
    } else {
        $result = "File is not a valid image or PDF.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        $result = "Sorry, your file was not uploaded.";
    } else {
        // Move the uploaded file to the target directory
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            // Call the Python script to process the uploaded file
            $pythonPath = "C:\Python312\python.exe";
            $scriptPath = "verification.py"; // Use the full path to the script
            $command = escapeshellcmd("$pythonPath $scriptPath " . escapeshellarg($target_file));
            $output = shell_exec($command . " 2>&1"); // Redirect errors to output
            error_log("Command executed: $command");
            error_log("Output: $output");
            $result = $output;
        } else {
            $result = "Sorry, there was an error uploading your file.";
        }
    }

    if (strpos($result, $keyword) !== false) {
        $sql = "UPDATE charity SET charity_verified = '1', charity_doc = '$target_file' WHERE charity.user_id = '$userID'";
        if (mysqli_query($conn, $sql)) {
            echo '<script>alert("Successfully obtained Verify Badge."); window.location.href = "profile.php?id=' . $userID . '";</script>';
        } else {
            echo '<script>alert("Error");</script>';
        }
    }
    ?>

    <main class="main">
        <div class="container py-5">
            <div class="row justify-content-center py-5">
                <div class="profile-container col-md-8 py-5">
                    <div class="card py-4 px-3">
                        <div class="row">
                            <div class="col">
                                <h1>Verification</h1>
                            </div>
                        </div>
                        <div class="row justify-content-start mx-3 my-2">
                            <div class="col">
                                <h5><?= $result ?></h5>
                            </div>
                        </div>
                        <input type="text" id="fileName" name="fileName" value="<?= $target_file ?>" hidden>
                        <button type="submit" id="togglePassword" class="btn shadow-none bg-transparent border-0" onclick="backToProfile()">
                            Back
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php
    include 'layout/footer.php';
    ?>
</body>

</html>