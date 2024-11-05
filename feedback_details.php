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
                                        <button type="submit" id="togglePassword" name="action" value="changeNotDone" class="btn shadow-none bg-transparent border-0">
                                            <i class="fa fa-check-square-o" aria-hidden="true"></i></button>
                                    <?php else: ?>
                                        <button type="submit" id="togglePassword" name="action" value="changeDone" onclick="return confirm('Confirm done reviewing this feedback?')" class="btn shadow-none bg-transparent border-0">
                                            <i class="fa fa-square-o" aria-hidden="true"></i></button>
                                    <?php endif; ?>
                                    <button type="submit" id="togglePassword" name="action" value="Delete" onclick="return confirm('Confirm delete feedback?')" class="btn shadow-none bg-transparent border-0">
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
            //$feedbackID = $_GET['id'];
            if ($action == "changeNotDone") {
                $sql = "UPDATE feedback SET feedback_status = '0' WHERE feedback_id = '$feedbackID'";
                if (mysqli_query($conn, $sql)) {
                    echo '<script>window.location.href = "feedback_details.php?id=' . $feedbackID . '</script>';
                } else {
                    echo '<script>alert("Error in changing status.");</script>';
                }
            } elseif ($action == "changeDone") {
                $sql = "UPDATE feedback SET feedback_status = '1' WHERE feedback_id = '$feedbackID'";
                if (mysqli_query($conn, $sql)) {
                    echo '<script>window.location.href = "feedback_details.php?id=' . $feedbackID . '</script>';
                } else {
                    echo '<script>alert("Error in changing status.");</script>';
                }
            } elseif ($action == "Delete") {
                $sql = "DELETE FROM feedback WHERE feedback_id = '$feedbackID'";
                if (mysqli_query($conn, $sql)) {
                    echo '<script>alert("Delete Successfully."); window.location.href = "admin_dashboard.php";</script>';
                } else {
                    echo '<script>alert("Error in deleting.");</script>';
                }
            } else {
                echo '<script>alert("Error123.");</script>';
            }
        }
        ?>
    </main>

</body>

</html>