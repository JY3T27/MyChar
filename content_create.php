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
                        <h1>Post new Content</h1>
                        <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" class="register">
                            <div class="row">
                                <div class="content-image p-5">
                                    <img class="image-content" id="sample-img" src="assets\img\sample-content.png" alt="ContentPic" class="avatar">
                                </div>
                            </div>
                            <div class="row px-5">
                                <h4>Title</h4>
                            </div>
                            <div class="row px-3 mb-4">
                                <input type="text" name="content-title" class="form-control" placeholder="Enter title of the content" autofocus>
                            </div>
                            <div class="row px-5">
                                <h4>Description</h4>
                            </div>
                            <div class="row px-3 mb-4">
                                <textarea rows="7" id="content-desc" name="content-desc" class="form-control" placeholder="Enter the descriptions"></textarea>
                            </div>
                            <div class="row px-5">
                                <h4>Upload Pictures</h4>
                            </div>
                            <div class="row justify-content-start px-3 mb-4">
                                <div class="col-8">
                                    <input type="file" id="pic_input" class="form-control" name="pic_input" classname="content-image" accept="image/*">
                                </div>
                            </div>
                            <div class="row px-5">
                                <h4>Fundraising Target</h4>
                            </div>
                            <div class="row justify-content-start px-3 mb-4">
                                <div class="col-2 text-end">
                                    <span class="currency-symbol">RM</span>
                                </div>
                                <div class="col-6">
                                    <input type="number" id="fund-target" name="fund-target" min="0" step="0.01" placeholder="0.00" required>
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
            $title = $_POST['content-title'];
            $desc = $_POST['content-desc'];
            $target = $_POST['fund-target'];
            $sql = "INSERT INTO content (content_id, charity_id, content_title, content_desc, content_createDate, content_target) 
                    VALUES('', '$charity_id', '$title', '$desc', CURRENT_TIMESTAMP, '$target')";
            if (mysqli_query($conn, $sql)) {
                echo '<script>alert("Sent Feedback Successfully. ");</script>';
            } else {
                echo '<script>alert("Error");</script>';
            }

            if (isset($_FILES['pic_input']) && $_FILES['pic_input']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = "assets/img/uploads/content/";
                $uploadFile = $uploadDir . basename($_FILES['pic_input']['name']);

                if (move_uploaded_file($_FILES['pic_input']['tmp_name'], $uploadFile)) {
                    $sqlImage = "UPDATE charity SET charity_profilepic = '$uploadFile' WHERE charity.user_id = '$userID'";
                    mysqli_query($conn, $sqlImage);
                    echo '<script>alert("Edit Successfully."); window.location.href = "content.php";</script>';
                } else {
                    echo '<script>alert("Error in uploading");</script>';
                }
            } else {
                echo '<script>alert("Picture is not chosen.");</script>';
            }
        }

        ?>
        <script>
            const imageInput = document.getElementById('pic_input');
            const imagePreview = document.getElementById('sample-img');

            // Add an event listener to detect file selection
            imageInput.addEventListener('change', function() {
                const file = imageInput.files[0]; // Get the selected file
                if (file) {
                    // Create a URL for the file and set it as the src of the image preview
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        imagePreview.src = e.target.result; // Set the image source to the uploaded file// Show the image preview
                    };
                    reader.readAsDataURL(file); // Read the file as a data URL (base64 encoded)
                }
            });
        </script>
    </main>
</body>

</html>