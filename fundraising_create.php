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
    $sql = "SELECT charity_id FROM  charity WHERE charity.user_id = '$userID' LIMIT 1";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $charity_id = $row['charity_id'];
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
                <div class="login-container col-md-8 py-5">
                    <div class="card py-4 px-3">
                        <h1>Organizing New Campaign</h1>
                        <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" class="register" enctype="multipart/form-data">
                            <div class="row">
                                <div class="fundraising-image p-5">
                                    <img class="image-fundraising" id="sample-img" src="assets\img\sample-content.png" alt="fundraisingPic" class="avatar">
                                </div>
                            </div>
                            <div class="row px-5">
                                <h4>Title</h4>
                            </div>
                            <div class="row px-3 mb-4">
                                <input type="text" name="fundraising-title" class="form-control" placeholder="Enter title of the fundraising" autofocus>
                            </div>
                            <div class="row px-5">
                                <h4>Description</h4>
                            </div>
                            <div class="row px-3 mb-4">
                                <textarea rows="7" id="fundraising-desc" name="fundraising-desc" class="form-control" placeholder="Enter the descriptions"></textarea>
                            </div>
                            <div class="row px-5">
                                <h4>Upload Pictures</h4>
                            </div>
                            <div class="row justify-content-start px-3 mb-4">
                                <div class="col-8">
                                    <input type="file" id="pic-input" class="form-control" name="pic-input" classname="fundraising-image" accept="image/*">
                                </div>
                            </div>
                            <div class="row px-5">
                                <h4>Fundraising Target</h4>
                            </div>
                            <div class="row justify-content-start px-3 mb-4">
                                <div class="col-2 text-end">
                                    <span class="currency-symbol">RM</span>
                                </div>
                                <div class="col-4">
                                    <input type="number" class="form-control" id="fund-target" name="fund-target" min="0" step="0.01" placeholder="0.00" required>
                                </div>
                            </div>
                            <div class="row justify-content-md-center mt-3 px-5">
                                <div class="col">
                                    <button type="submit" value="Upload" class="profile-Editbtn" id="feedbackbtn">Create</button>
                                    <button type="reset" value="Reset" class="profile-Editbtn" id="feedbackbtn">Reset</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <?php
        include 'layout/footer.php';
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $userID = $_SESSION["UID"];
            $title = $_POST['fundraising-title'];
            $desc = $_POST['fundraising-desc'];
            $target = $_POST['fund-target'];
            $sql = "INSERT INTO fundraising (fundraising_id, charity_id, fundraising_title, fundraising_desc, fundraising_createDate, fundraising_target) 
                    VALUES('', '$charity_id', '$title', '$desc', CURRENT_TIMESTAMP, '$target')";
            if (mysqli_query($conn, $sql)) {
                $lastInsertedId = mysqli_insert_id($conn);
                if (isset($_FILES["pic-input"]) && $_FILES["pic-input"]['error'] === UPLOAD_ERR_OK) {
                    $uploadDir = "assets/img/uploads/fundraising/";
                    $uploadFile = $uploadDir . basename($_FILES['pic-input']['name']);
                    if (move_uploaded_file($_FILES['pic-input']['tmp_name'], $uploadFile)) {
                        $sqlImage = "UPDATE fundraising SET fundraising_image = '$uploadFile' WHERE fundraising_id = '$lastInsertedId'";
                        mysqli_query($conn, $sqlImage);
                        echo '<script>alert("Fundraising is created successfully."); window.location.href = "fundraising.php";</script>';
                    } else
                        echo '<script>alert("Error in uploading");</script>';
                } else
                    echo '<script>alert("Picture is not chosen.");</script>';
            } else
                echo '<script>alert("Error1");</script>';
        }

        ?>
        <script>
            const imageInput = document.getElementById('pic-input');
            const imagePreview = document.getElementById('sample-img');

            imageInput.addEventListener('change', function() {
                const file = imageInput.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        imagePreview.src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                }
            });
        </script>
    </main>
</body>

</html>