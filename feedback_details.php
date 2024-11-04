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
    $feedbackID = $_GET['id'];
    if (isset($feedbackID) && !empty($feedbackID)) {
        $sql = 'SELECT * FROM feedback
                INNER JOIN donor ON feedback.donor_id = donor.donor_id   
                WHERE feedback_id = ' . $feedbackID;
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $donor = $row["donor_name"];
        $title = $row["feedback_title"];
        $content = $row["feedback_content"];
        $rating = $row["feedback_rating"];
        $date = $row["feedback_date"];
        $status = $row["feedback_status"];
    }
    ?>
    <main class="main">
        <div class="container py-5">
            <div class="row justify-content-center py-5">
                <div class="profile-container col-md-8 py-5">
                    <div class="card text-center py-4 px-3">
                        <form id="profile" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col">
                                    <h1>Feedback</h1>
                                </div>
                                <div class="profile-btn col">
                                    <?php if ($status == '1'): ?>
                                        <button type="submit" id="togglePassword" value="changeStatisus" class="btn shadow-none bg-transparent border-0">
                                            <i class="fa fa-check-square-o" aria-hidden="true"></i></button>
                                    <?php else: ?>
                                        <button type="submit" id="togglePassword" value="changeStatisus" onclick="return confirm('Confirm done reviewing this feedback?')" class="btn shadow-none bg-transparent border-0">
                                            <i class="fa fa-square-o" aria-hidden="true"></i></button>
                                    <?php endif; ?>
                                    <button type="submit" id="togglePassword" onclick="return confirm('Confirm delete account?')" name="action" value="Delete" class="btn shadow-none bg-transparent border-0">
                                        <i class="fa fa-trash fs-2" aria-hidden="true"></i></button>
                                </div>
                            </div>
                            <div class="container">
                                <div class="row">
                                    <div class="col">
                                        <div class="row mb-3">
                                            <label for="feedback_id" class="col-md-4 col-form-label text-md-end">Feedback ID</label>
                                            <div class="col-md-6">
                                                <input id="feedback_id" type="text" class="form-control" name="feedback_id" value="<?= $feedbackID ?>" disabled>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="feedback_title" class="col-md-4 col-form-label text-md-end">Title</label>
                                            <div class="col-md-6">
                                                <input id="feedback_title" type="email" class="form-control" name="feedback_title" value="<?= $title ?>" required disabled>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="feedback_date" class="col-md-4 col-form-label text-md-end">Date</label>
                                            <div class="col-md-6">
                                                <input id="feedback_date" type="date" class="form-control" name="feedback_date" value="<?= $date ?>" disabled>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="feedback_content" class="col-md-4 col-form-label text-md-end">Content</label>
                                            <div class="col-md-6">
                                                <textarea id="feedback_content" type="text" class="form-control" rows="4" name="feedback_content" disabled><?= $content ?></textarea>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="feedback_rating" class="col-md-4 col-form-label text-md-end">Rating</label>
                                            <div class="col-md-6">
                                                <input id="feedback_rating" type="number" class="form-control" name="feedback_rating" min="0" max="5" value="<?= $rating ?>" disabled>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="feedback_donor" class="col-md-4 col-form-label text-md-end">Sent by</label>
                                            <div class="col-md-6">
                                                <input id="feedback_donor" type="text" class="form-control" name="feedback_donor" value="<?= $donor ?>" disabled>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="feedback_status" class="col-md-4 col-form-label text-md-end">Status</label>
                                            <div class="col-md-6">
                                                <input id="feedback_status" type="text" class="form-control" name="feedback_status" value="<?= $status ?>" disabled>
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