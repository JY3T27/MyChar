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

    $id = $_GET["id"];
    if (isset($id) && !empty($id)) {
        $sql = "SELECT * FROM users WHERE users.user_id = '$id' LIMIT 1";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            $row = mysqli_fetch_assoc($result);
            $role = $row['user_role'];
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }

    if ($role == 'donor') {
        $sql = "SELECT * FROM users INNER JOIN donor ON users.user_id = donor.user_id  
            WHERE users.user_id = '$id' LIMIT 1";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $profile_name = $row['donor_name'];
                $profile_email = $row['user_email'];
                $profile_joinDate = $row['user_joinDate'];
            }
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } elseif ($role == 'charity') {
        $sql = "SELECT * FROM users INNER JOIN charity ON users.user_id = charity.user_id  
            WHERE users.user_id = '$id' LIMIT 1";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $charityID = $row['charity_id'];
                $profile_name = $row['charity_name'];
                $profile_email = $row['user_email'];
                $profile_joinDate = $row['user_joinDate'];
                $profile_address = $row['charity_address'];
                $profile_state = $row['charity_state'];
                $profile_contactEmail = $row['charity_contactEmail'];
                $profile_phone = $row['charity_phoneNo'];
                $profile_url = $row['charity_websiteURL'];
                $profile_pic = $row['charity_profilepic'];
                $profile_desc = $row['charity_desc'];
            }
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "Error: " . mysqli_error($conn);
    }
    ?>
    <main class="main">
        <div class="container py-5">
            <form id="profile" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" enctype="multipart/form-data">
                <div class="row justify-content-center py-5">
                    <!--profile card -->
                    <div class="profile-container col-md-9 py-5">
                        <div class="card text-center py-4 px-3">
                            <div class="row">
                                <div class="col">
                                    <h1>Profile</h1>
                                </div>
                                <div class="profile-btn col">
                                    <button type="submit" id="togglePassword" onclick="return confirm('Confirm delete charity?')" name="action" value="DeleteCharity" class="btn shadow-none bg-transparent border-0">
                                        <i class="fa fa-trash fs-2" aria-hidden="true"></i></button>
                                </div>
                            </div>
                            <div class="container pb-5">
                                <div class="row">
                                    <input id="view_id" type="text" class="form-control" name="view_id" value="<?= $id ?>" hidden>
                                    <?php if ($role == 'charity'): ?>
                                        <div class="row">
                                            <div class="col">
                                                <?php if (isset($profile_pic) && !empty($profile_pic)): ?>
                                                    <div class="row pt-2 pb-4">
                                                        <div class="col">
                                                            <img src="<?= $profile_pic ?>" alt="ProfilePic" id="image-profile" class="avatar">
                                                        </div>
                                                    </div>
                                                <?php else: ?>
                                                    <div class="row pt-2 pb-4">
                                                        <div class="col">
                                                            <img src="assets\img\profile_icon.jpg" alt="ProfilePic" id="image-profile" class="avatar">
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                            <div class="row justify-content-md-center pb-4">
                                                <label class="col col-form-label text-md-center text-muted">Click <i class="fa fa-user-circle-o fs-4" aria-hidden="true"></i> button above to upload profile pic.</label>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    <div class="col">
                                        <div class="row mb-3">
                                            <label for="profile_name" class="col-md-4 col-form-label text-md-end">Name</label>
                                            <div class="col-md-6">
                                                <input id="profile_name" type="text" class="form-control" name="profile_name" value="<?= $profile_name ?>" disabled>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="profile_email" class="col-md-4 col-form-label text-md-end">Email</label>
                                            <div class="col-md-6">
                                                <input id="profile_email" type="email" class="form-control" name="profile_email" value="<?= $profile_email ?>" required autocomplete="email" disabled>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="profile_date" class="col-md-4 col-form-label text-md-end">Join Date</label>
                                            <div class="col-md-6">
                                                <input id="profile_date" type="date" class="form-control" name="profile_joinDate" value="<?= $profile_joinDate ?>" disabled>
                                            </div>
                                        </div>
                                        <?php if ($role == 'charity'): ?>
                                            <div class="row mb-3">
                                                <label for="profile_phone" class="col-md-4 col-form-label text-md-end">Phone No.</label>
                                                <div class="col-md-6">
                                                    <input id="profile_phone" type="text" class="form-control" name="profile_phone" value="<?= $profile_phone ?>" disabled>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label for="profile_contactEmail" class="col-md-4 col-form-label text-md-end">Contact Email</label>
                                                <div class="col-md-6">
                                                    <input id="profile_contactEmail" type="text" class="form-control" name="profile_contactEmail" value="<?= $profile_contactEmail ?>" disabled>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label for="profile_address" class="col-md-4 col-form-label text-md-end">Address</label>
                                                <div class="col-md-6">
                                                    <input id="profile_address" type="text" class="form-control" name="profile_address" value="<?= $profile_address ?>" disabled>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label for="profile_state" class="col-md-4 col-form-label text-md-end">State</label>
                                                <div class="col-md-6">
                                                    <input id="profile_state" type="text" class="form-control" name="profile_state" value="<?= $profile_state ?>" disabled>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label for="profile_URL" class="col-md-4 col-form-label text-md-end">Website URL</label>
                                                <div class="col-md-6">
                                                    <input id="profile_URL" type="text" class="form-control" name="profile_URL" value="<?= $profile_url ?>" disabled>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label for="profile_desc" class="col-md-4 col-form-label text-md-end">Description</label>
                                                <div class="col-md-6">
                                                    <input id="profile_desc" type="text" class="form-control" name="profile_desc" value="<?= $profile_desc ?>" disabled>
                                                </div>
                                            </div>
                                        <?php endif; ?>
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
                        </div>
                        <?php if ($role == 'charity'): ?>
                            <div class="post-option m-3">
                                <div class="row">
                                    <div class="col d-flex align-items-center">
                                        <h5>View fundraising campaigns organized</h5>
                                    </div>
                                    <div class="col-1">
                                        <a href="fundraisinglist_admin.php?id=<?= $charityID ?>"><i class="fa fa-chevron-right fs-2" aria-hidden="true"></i></a>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </form>
        </div>
        <?php
        include 'layout/footer.php';
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $action = $_POST["action"];
            $userID = $_POST["view_id"];
            if ($action == "DeleteCharity") {
                $sql = "DELETE FROM users WHERE users.user_id = '$userID'";
                if (mysqli_query($conn, $sql)) {
                    echo '<script>alert("Delete Successfully."); window.location.href = "userdatabase.php?type=charity";</script>';
                } else {
                    echo '<script>alert("Error");</script>';
                }
            } else {
                echo '<script>alert("Error");</script>';
            }
        }
        ?>
    </main>

</body>

</html>