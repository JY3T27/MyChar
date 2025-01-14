<?php
session_start();
include 'config.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    include 'layout/header.php';
    $_SESSION['verifing'] = $_GET["id"];
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
        ?>
    </main>
</body>

</html>