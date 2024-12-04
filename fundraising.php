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
        function enableEdit() {
            const element = document.getElementById("profile_name");
            var userRole = "<?php echo $_SESSION["role"] ?>";
            if (element.disabled) {
                document.getElementById("profile_name").disabled = false;
                document.getElementById("updateBtn").style.display = "block";
                document.getElementById("resetBtn").style.display = "block";
                if (userRole == "charity") {
                    document.getElementById("profile_phone").disabled = false;
                    document.getElementById("profile_contactEmail").disabled = false;
                    document.getElementById("profile_address").disabled = false;
                    document.getElementById("profile_state").disabled = false;
                    document.getElementById("profile_URL").disabled = false;
                    document.getElementById("profile_code").disabled = false;
                    document.getElementById("profile_desc").disabled = false;
                } else if (userRole == "admin") {
                    document.getElementById("website_address1").disabled = false;
                    document.getElementById("website_address2").disabled = false;
                    document.getElementById("website_phone").disabled = false;
                    document.getElementById("website_email").disabled = false;
                }
            } else {
                document.getElementById("profile_name").disabled = true;
                document.getElementById("updateBtn").style.display = "none";
                document.getElementById("resetBtn").style.display = "none";
                if (userRole == "charity") {
                    document.getElementById("profile_phone").disabled = true;
                    document.getElementById("profile_contactEmail").disabled = true;
                    document.getElementById("profile_address").disabled = true;
                    document.getElementById("profile_state").disabled = true;
                    document.getElementById("profile_URL").disabled = true;
                    document.getElementById("profile_code").disabled = true;
                    document.getElementById("profile_desc").disabled = true;
                } else if (userRole == "admin") {
                    document.getElementById("website_address1").disabled = true;
                    document.getElementById("website_address2").disabled = true;
                    document.getElementById("website_phone").disabled = true;
                    document.getElementById("website_email").disabled = true;
                }
            }
        }

        function confirmationDlt() {
            if (confirm("Are you sure you want to delete your account?")) {
                return true;
            } else {
                return false;
            }
        }
    </script>
</head>

<body class="index-page">
    <?php
    include 'layout/nav.php';

    $fundID = $_GET["id"];
    $sql = "SELECT * FROM fundraising WHERE fundraising_id = '$fundID' LIMIT 1";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $title = $row["fundraising_title"];
            $desc = $row["fundraising_desc"];
            $img = $row["fundraising_image"];
            $date = $row["fundraising_createDate"];
            $target = $row["fundraising_target"];
            $fund = $row["fundraising_fund"];
            $status = $row["fundraising_status"];
        }
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    ?>
    <main class="main">
        <div class="container py-5">
            <div class="row justify-content-center py-5">
                <!--profile card -->
                <div class="profile-container col-md-8 py-5">
                    <div class="card text-center py-4 px-3">
                        <form id="profile" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col">
                                    <h1>Fundraising Organized</h1>
                                </div>
                                <div class="profile-btn col">
                                    <button type="button" id="togglePassword" onclick="enableEdit()" class="btn shadow-none bg-transparent border-0">
                                        <i class="fa fa-pencil-square-o fs-2" aria-hidden="true"></i></button>
                                    <button type="submit" id="togglePassword" onclick="return confirm('Confirm delete account?')" name="action" value="Delete" class="btn shadow-none bg-transparent border-0">
                                        <i class="fa fa-trash fs-2" aria-hidden="true"></i></button>
                                </div>
                            </div>
                            <div class="container">
                                <div class="row">
                                    <div class="row">
                                        <div class="col">
                                            <?php if (isset($img) && !empty($img)): ?>
                                                <div class="row pt-2 pb-4">
                                                    <div class="col">
                                                        <img src="<?= $img ?>" alt="Picture for Fundraising" id="fundImg" class="image-fluid image-fundraising">
                                                    </div>
                                                </div>
                                            <?php else: ?>
                                                <div class="row pt-2 pb-4">
                                                    <div class="col">
                                                        <img src="assets\img\sample-content.png" alt="Picture for Fundraising" id="sample-img" class="image-fluid image-fundraising">
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="row mb-3">
                                            <label for="fundraising_title" class="col-md-4 col-form-label text-md-end">Title</label>
                                            <div class="col-md-6">
                                                <input id="fundraising_title" type="text" class="form-control" name="fundraising_title" value="<?= $title ?>" disabled>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="fundraising_date" class="col-md-4 col-form-label text-md-end">Date created</label>
                                            <div class="col-md-6">
                                                <input id="fundraising_date" type="date" class="form-control" name="fundraising_date" value="<?= $date ?>" required autocomplete="email" disabled>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="fundraising_target" class="col-md-4 col-form-label text-md-end">Target</label>
                                            <div class="col-md-6">
                                                <input id="fundraising_target" type="text" class="form-control" name="fundraising_target" value="RM <?= $target ?>" disabled>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="fundraising_fund" class="col-md-4 col-form-label text-md-end">Fund Collected</label>
                                            <div class="col-md-6">
                                                <input id="fundraising_fund" type="text" class="form-control" name="fundraising_fund" value="RM <?= $fund ?>" disabled>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="fundraising_desc" class="col-md-4 col-form-label text-md-end">Description</label>
                                            <div class="col-md-6">
                                                <textarea rows="4" id="fundraising_desc" type="text" class="form-control" name="fundraising_desc" disabled><?= $desc ?></textarea>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row editBtn">
                                                    <button type="submit" value="Update" id="updateBtn" class="profile-Editbtn col" name="action">Update</button>
                                                    <button type="reset" value="Reset" id="resetBtn" class="profile-Editbtn col">Reset</button>
                                                </div>
                                            </div>
                                        </div>
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
            if ($action == "Update") {
                if ($role == 'donor') {
                    $edited_name = $_POST['profile_name'];
                    $sql = "UPDATE donor SET donor_name = '$edited_name' WHERE donor.user_id = '$userID'";
                    if (mysqli_query($conn, $sql)) {
                        echo '<script>alert("Edit Successfully."); window.location.href = "profile.php";</script>';
                    } else {
                        echo '<script>alert("Error");</script>';
                    }
                } elseif ($role == 'charity') {
                    $edited_name = $_POST['profile_name'];
                    $edited_phone = $_POST['profile_phone'];
                    $edited_email = $_POST['profile_contactEmail'];
                    $edited_address = $_POST['profile_address'];
                    $edited_state = $_POST['profile_state'];
                    $edited_URL = $_POST['profile_URL'];
                    $edited_code = $_POST['profile_code'];
                    $edited_desc = $_POST['profile_desc'];
                    $sql = "UPDATE charity SET charity_name = '$edited_name', charity_phoneNo = '$edited_phone', charity_contactEmail = '$edited_email', 
                            charity_address = '$edited_address', charity_state = '$edited_state', charity_websiteURL = '$edited_URL', 
                            charity_code = '$edited_code', charity_desc = '$edited_desc'
                            WHERE charity.user_id = '$userID'";
                    if (mysqli_query($conn, $sql)) {
                        echo '<script>alert("Edit Successfully."); window.location.href = "profile.php";</script>';
                    } else {
                        echo '<script>alert("Error");</script>';
                    }
                } elseif ($role == 'admin') {
                    $edited_name = $_POST['profile_name'];
                    $edited_address1 = $_POST['website_address1'];
                    $edited_address2 = $_POST['website_address2'];
                    $edited_phone = $_POST['website_phone'];
                    $edited_email = $_POST['website_email'];
                    $sql = "UPDATE admin SET admin_name = '$edited_name', website_phoneNo = '$edited_phone', website_email = '$edited_email', 
                            website_address1 = '$edited_address1', website_address2 = '$edited_address2'   
                            WHERE admin.user_id = '$userID'";
                    if (mysqli_query($conn, $sql)) {
                        echo '<script>alert("Edit Successfully."); window.location.href = "profile.php";</script>';
                    } else {
                        echo '<script>alert("Error");</script>';
                    }
                } else {
                    echo '<script>alert("Error");</script>';
                }
            } elseif ($action == "Delete") {
                $sql = "DELETE FROM users WHERE users.user_id = '$userID'";
                if (mysqli_query($conn, $sql)) {
                    echo '<script>alert("Delete Successfully."); window.location.href = "logout.php";</script>';
                } else {
                    echo '<script>alert("Error");</script>';
                }
            } elseif ($action == "ChangePP") {
                echo '<script>window.location.href = "profilePic.php";</script>';
            } else {
                echo '<script>alert("Error");</script>';
            }
        }
        ?>
    </main>

</body>

</html>