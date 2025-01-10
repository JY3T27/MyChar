<?php
session_start();
include 'config.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    include 'layout/header.php';
    $userID = $_SESSION["UID"];
    $sql = "SELECT * FROM  charity WHERE charity.user_id = '$userID' LIMIT 1";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $profile_pic = $row['charity_profilepic'];
        }
    } else {
        echo "Error: " . mysqli_error($conn);
    }
    ?>
</head>

<body class="index-page">
    <?php
    include 'layout/nav.php';
    ?>
    <main class="main">
        <div class="container py-5">
            <div class="row justify-content-center py-5">
                <div class="profile-container col-md-8 py-5">
                    <div class="card text-center py-4 px-3">
                        <form id="profile" action="verify.php" method="POST" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col">
                                    <h1>Verification</h1>
                                </div>
                            </div>
                            <div class="row justify-content-start mx-3 my-2">
                                <div class="col-4">
                                    <h5>Select file to upload:</h5>
                                </div>
                                <div class="col-4">
                                    <input type="file" name="fileToUpload" id="fileToUpload" required>
                                </div>
                            </div>
                            <div class="row justify-content-start mx-3 my-2">
                                <div class="col-3"></div>
                                <div class="col-4">
                                    <button type="submit" class="login-btn" id="verifyBtn">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <?php
        include 'layout/footer.php';

        // Check if the uploaded file is an actual file
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_FILES['fileToUpload']) && $_FILES['fileToUpload']['error'] === UPLOAD_ERR_OK) {
                $target_dir = "assets/docs/uploads/";
                $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
                $uploadOk = 1;
                $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
                if ($check !== false || strtolower(pathinfo($target_file, PATHINFO_EXTENSION)) == 'pdf') {
                    $uploadOk = 1;
                } else {
                    echo "File is not a valid image or PDF.";
                    $uploadOk = 0;
                }

                // Check if $uploadOk is set to 0 by an error
                if ($uploadOk == 0) {
                    echo "Sorry, your file was not uploaded.";
                } else {
                    // Move the uploaded file to the target directory
                    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                        // Call the Python script to process the uploaded file
                        $command = escapeshellcmd("python verification.py " . escapeshellarg($target_file));
                        $output = shell_exec($command);
                        echo "Output from Python: " . $output;
                    } else {
                        echo "Sorry, there was an error uploading your file.";
                    }
                }
            } else
                echo '<script>alert("Picture is not chosen.");</script>';
        }
        ?>
    </main>
</body>

</html>