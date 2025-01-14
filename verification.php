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
    $sql = "SELECT * FROM users INNER JOIN charity ON users.user_id = charity.user_id  
            WHERE users.user_id = " . $_SESSION['verifing'] . " LIMIT 1";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $charity_id = $row['charity_id'];
                $charity_name = $row['charity_name'];
                $verified = $row['charity_verified'];
                $doc = $row['charity_doc'];
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
                    <div class="card py-4 px-3" style="margin-bottom: 50px;">
                        <form id="profile" action="verify.php" method="POST" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col">
                                    <h1>Verification</h1>
                                </div>
                            </div>
                            <?php if($verified == 0): ?>
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
                            <?php else: ?>
                                <div class="row mx-3 my-2">
                                    <div class="col">
                                        <h3>Your organization has been verified.</h3>
                                    </div>
                                </div>
                                <div class="row mx-3 my-2">
                                    <div class="col">
                                        <h5>The document uploaded:</h5>
                                        <p style="padding-left: 5%;"><?= $doc?></p>
                                    </div>
                                </div>
                            <?php endif;?>
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