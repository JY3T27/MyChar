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
</head>

<body class="index-page">
    <?php
    include 'layout/nav.php';
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
    ?>

    <main class="main">
        <div class="container py-5">
            <div class="row justify-content-center py-5">
                <div class="profile-container col-md-8 py-5">
                    <div class="card py-4 px-3">
                        <form id="profile" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" enctype="multipart/form-data">
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
                            <?php if (strpos($result, $keyword) !== false): ?>
                                <button type="button" id="togglePassword" name="action" value="Obtain" class="btn shadow-none bg-transparent border-0">
                                    Proceed
                                </button>
                            <?php else: ?>
                                <button type="button" id="togglePassword" name="action" value="Back" class="btn shadow-none bg-transparent border-0">
                                    Back
                                </button>
                            <?php endif; ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php
    include 'layout/footer.php';
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $userID = $_SESSION['verifing'];
        $action = $_POST["action"];
        $doc = $_POST["fileName"];
        if ($action == "Obtain") {
            $sql = "UPDATE charity SET charity_verified = '1', charity_doc = '$doc' WHERE charity.user_id = '$userID'";
            if (mysqli_query($conn, $sql)) {
                unset($_SESSION);
                echo '<script>alert("Successfully obtained Verify Badge."); window.location.href = "profile.php?id=' . $userID . '";</script>';
            } else {
                echo '<script>alert("Error");</script>';
            }
        } elseif ($action == "Back") {
            echo 'window.location.href = "profile.php?id=' . $userID . '";</script>';
        } else {
            echo '<script>alert("Error");</script>';
        }
    }

    ?>
</body>

</html>