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
    $feedbackID = $_GET['id'];
    if (isset($feedbackID) && !empty($feedbackID)) {
        $sql = 'SELECT * FROM feedback
                INNER JOIN users ON feedback.user_id = users.user_id   
                WHERE feedback_id = ' . $feedbackID;
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $owner_role = $row["user_role"];
        $owner_ID = $row["user_id"];
        $owner_email = $row["user_email"];
        $title = $row["feedback_title"];
        $content = $row["feedback_content"];
        $rating = $row["feedback_rating"];
        $date = $row["feedback_date"];
        $status = $row["feedback_status"];
        if ($status == '1') {
            $statusText = "Done";
        } else {
            $statusText = "Incomplete";
        }
        if ($owner_role == "donor") {
            $sql_donor = 'SELECT * FROM donor 
                    INNER JOIN users ON donor.user_id = users.user_id 
                    WHERE users.user_id = ' . $owner_ID;
            $result = mysqli_query($conn, $sql_donor);
            $row = mysqli_fetch_assoc($result);
            $role_ID = $row["donor_id"];
            $owner_name = $row["donor_name"];
        } elseif ($owner_role == "charity") {
            $sql_charity = 'SELECT * FROM users 
                    INNER JOIN charity ON users.user_id = charity.user_id 
                    WHERE users.user_id = ' . $owner_ID;
            $result = mysqli_query($conn, $sql_charity);
            $row = mysqli_fetch_assoc($result);
            $role_ID = $row["charity_id"];
            $owner_name = $row["charity_name"];
        } else {
            echo "Error Feedback owner role.";
        }
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
                                    <?php if ($_SESSION["role"] == 'admin'): ?>
                                        <?php if ($status == '1'): ?>
                                            <button type="submit" id="togglePassword" name="feedbackAction" value="changeNotDone" class="btn shadow-none bg-transparent border-0">
                                                <i class="fa fa-check-square-o fs-2" aria-hidden="true"></i></button>
                                        <?php else: ?>
                                            <button type="submit" id="togglePassword" name="feedbackAction" value="changeDone" onclick="return confirm('Confirm done reviewing this feedback?')" class="btn shadow-none bg-transparent border-0">
                                                <i class="fa fa-square-o fs-2" aria-hidden="true"></i></button>
                                        <?php endif; ?>
                                        <!-- <button type="submit" id="togglePassword" name="feedbackAction" value="SentEmail" class="btn shadow-none bg-transparent border-0">
                                        <i class="fa fa-envelope-o fs-2" aria-hidden="true"></i></button> -->
                                    <?php endif; ?>
                                    <button type="submit" id="togglePassword" name="feedbackAction" value="Delete" onclick="return confirm('Confirm delete feedback?')" class="btn shadow-none bg-transparent border-0">
                                        <i class="fa fa-trash fs-2" aria-hidden="true"></i></button>
                                </div>
                            </div>
                            <div class="container">
                                <div class="row">
                                    <div class="col">
                                        <?php if ($_SESSION["role"] == 'admin'): ?>
                                            <div class="row mb-3">
                                                <label for="feedback_id" class="col-md-4 col-form-label text-md-end">Feedback ID</label>
                                                <div class="col-md-6">
                                                    <input id="feedback_id" type="text" class="form-control" value="<?= $feedbackID ?>" disabled>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                        <div class="row mb-3">
                                            <label for="feedback_title" class="col-md-4 col-form-label text-md-end">Title</label>
                                            <div class="col-md-6">
                                                <input id="feedback_title" type="email" class="form-control" name="feedback_title" value="<?= $title ?>" required disabled>
                                                <input id="feedback_id" type="text" name="feedback_id" value="<?= $_GET['id'] ?>" hidden>
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
                                                <input id="feedback_donor" type="text" class="form-control" name="feedback_donor" value="<?= $owner_name ?>" disabled>
                                                <!-- <input id="feedback_email" type="text" class="form-control" name="feedback_email" value="<?= $owner_email ?>" hidden> -->
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="feedback_status" class="col-md-4 col-form-label text-md-end">Status</label>
                                            <div class="col-md-6">
                                                <input id="feedback_status" type="text" class="form-control" name="feedback_status" value="<?= $statusText ?>" disabled>
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
            $action = $_POST["feedbackAction"];
            $feedbackID = $_POST["feedback_id"];
            //$email = $_POST["feedback_email"];
            if (isset($action)) {
                if ($action == "changeNotDone") {
                    $sql = "UPDATE feedback SET feedback_status = '0' WHERE feedback.feedback_id = '$feedbackID'";
                    if (mysqli_query($conn, $sql)) {
                        echo '<script>window.location.href = "admin_dashboard.php";</script>';
                    } else {
                        echo '<script>alert("Error in changing status.");</script>';
                    }
                } elseif ($action == "changeDone") {
                    $sql = "UPDATE feedback SET feedback_status = '1' WHERE feedback.feedback_id = '$feedbackID'";
                    if (mysqli_query($conn, $sql)) {
                        echo '<script>window.location.href = "admin_dashboard.php";</script>';
                    } else {
                        echo '<script>alert("Error in changing status.");</script>';
                    }
                } /* elseif ($action == "SentEmail") {
                    echo "<script>alert('$email');
                                window.location.href = 'mailto:$email';
                            </script>";
                    exit();
                }*/ elseif ($action == "Delete") {
                    $sql = "DELETE FROM feedback WHERE feedback.feedback_id = '$feedbackID'";
                    if (mysqli_query($conn, $sql)) {
                        echo '<script>alert("Delete Successfully."); window.location.href = "admin_dashboard.php";</script>';
                    } else {
                        echo '<script>alert("Error in deleting.");</script>';
                    }
                } else {
                    echo '<script>alert("Error executed the action.");</script>';
                }
            } else {
                echo '<script>alert("Error cannot find action.");</script>';
            }
        }
        ?>
    </main>

</body>

</html>