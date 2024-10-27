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
                        <form id="profile" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col">
                                    <h1>Profile Pic Upload</h1>
                                </div>
                            </div>
                            <div class="row">
                                <div class="profile pb-5">
                                    <?php
                                    //Check if the user has a profile picture
                                    if (isset($profile_pic) && !empty($profile_pic)) {
                                        echo '<img src="' . $profile_pic . '" id="image-preview" alt="ProfilePic">';
                                    } else {
                                        //Display a default image if no profile picture
                                        echo '<img class="image" id="image-preview" src="assets\img\profile_icon.jpg" alt="ProfilePic" class="avatar">';
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="row">
                                <label for="profile_date" class="col-md-4 col-form-label text-md-end">Upload Pictures</label>
                                <div class="col-md-6">
                                    <input type="file" id="pic_input" class="form-control" name="pic_input" classname="profile_picture" accept="image/*">
                                </div>
                            </div>
                            <div class="row py-2">
                                <div class="col-md-4">
                                </div>
                                <div class="col-md-6">
                                    <div class="row editBtn">
                                        <button type="submit" value="Upload" id="uploadBtn" class="profile-Editbtn col" name="action">Update</button>
                                        <input type="button" value="Cancel" onclick="goBack()" class="profile-Editbtn col"></input>
                                    </div>
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
            $action = $_POST["action"];
            $userID = $_SESSION["UID"];
            $role = $_SESSION["role"];
            if ($action == "Upload") {
                if (isset($_FILES['pic_input']) && $_FILES['pic_input']['error'] === UPLOAD_ERR_OK) {
                    $uploadDir = "assets/img/uploads/";
                    $uploadFile = $uploadDir . basename($_FILES['pic_input']['name']);
                    if (move_uploaded_file($_FILES['pic_input']['tmp_name'], $uploadFile)) {
                        $sqlImage = "UPDATE charity SET charity_profilepic = '$uploadFile' WHERE charity.user_id = '$userID'";
                        mysqli_query($conn, $sqlImage);
                        echo '<script>alert("Edit Successfully."); window.location.href = "profile.php";</script>';
                    } else
                        echo '<script>alert("Error in uploading");</script>';
                } else
                    echo '<script>alert("Picture is not chosen.");</script>';
            } else
                echo '<script>alert("Error2");</script>';
        }
        ?>
        <script>
            const imageInput = document.getElementById('pic_input');
            const imagePreview = document.getElementById('image-preview');

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
            
            function goBack() {
                window.history.back();
            }
        </script>
    </main>
</body>

</html>