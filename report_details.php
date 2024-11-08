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
    $reportID = $_GET['id'];
    if (isset($reportID) && !empty($reportID)) {
        $sql = 'SELECT * FROM report
                INNER JOIN users ON report.user_id = users.user_id   
                WHERE report_id = ' . $reportID;
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $email = $row["user_email"];
        $title = $row["report_title"];
        $content = $row["report_content"];
        $date = $row["report_date"];
        $status = $row["report_status"];
        if ($status == '1') {
            $statusText = "Done";
        } else {
            $statusText = "Incomplete";
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
                                    <h1>Report</h1>
                                </div>
                                <div class="profile-btn col">
                                    <?php if ($status == '1'): ?>
                                        <button type="submit" id="togglePassword" name="reportAction" value="changeNotDone" class="btn shadow-none bg-transparent border-0">
                                            <i class="fa fa-check-square-o fs-2" aria-hidden="true"></i></button>
                                    <?php else: ?>
                                        <button type="submit" id="togglePassword" name="reportAction" value="changeDone" onclick="return confirm('Confirm done reviewing this report?')" class="btn shadow-none bg-transparent border-0">
                                            <i class="fa fa-square-o fs-2" aria-hidden="true"></i></button>
                                    <?php endif; ?>
                                    <button type="submit" id="togglePassword" name="reportAction" value="Delete" onclick="return confirm('Confirm delete report?')" class="btn shadow-none bg-transparent border-0">
                                        <i class="fa fa-trash fs-2" aria-hidden="true"></i></button>
                                </div>
                            </div>
                            <div class="container">
                                <div class="row">
                                    <div class="col">
                                        <div class="row mb-3">
                                            <label for="report_id" class="col-md-4 col-form-label text-md-end">report ID</label>
                                            <div class="col-md-6">
                                                <input id="report_id" type="text" class="form-control" value="<?= $reportID ?>" disabled>
                                                <input id="report_id" type="text" name="report_id" value="<?= $_GET['id'] ?>" hidden>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="report_title" class="col-md-4 col-form-label text-md-end">Title</label>
                                            <div class="col-md-6">
                                                <input id="report_title" type="email" class="form-control" name="report_title" value="<?= $title ?>" required disabled>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="report_date" class="col-md-4 col-form-label text-md-end">Date</label>
                                            <div class="col-md-6">
                                                <input id="report_date" type="date" class="form-control" name="report_date" value="<?= $date ?>" disabled>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="report_content" class="col-md-4 col-form-label text-md-end">Content</label>
                                            <div class="col-md-6">
                                                <textarea id="report_content" type="text" class="form-control" rows="4" name="report_content" disabled><?= $content ?></textarea>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="report_donor" class="col-md-4 col-form-label text-md-end">Sent by</label>
                                            <div class="col-md-6">
                                                <input id="report_donor" type="text" class="form-control" name="report_donor" value="<?= $email ?>" disabled>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="report_status" class="col-md-4 col-form-label text-md-end">Status</label>
                                            <div class="col-md-6">
                                                <input id="report_status" type="text" class="form-control" name="report_status" value="<?= $statusText ?>" disabled>
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
            $action = $_POST["reportAction"];
            $reportID = $_POST["report_id"];
            if (isset($action)) {
                if ($action == "changeNotDone") {
                    $sql = "UPDATE report SET report_status = '0' WHERE report.report_id = '$reportID'";
                    if (mysqli_query($conn, $sql)) {
                        echo '<script>window.location.href = "admin_dashboard.php";</script>';
                    } else {
                        echo '<script>alert("Error in changing status.");</script>';
                    }
                } elseif ($action == "changeDone") {
                    $sql = "UPDATE report SET report_status = '1' WHERE report.report_id = '$reportID'";
                    if (mysqli_query($conn, $sql)) {
                        echo '<script>window.location.href = "admin_dashboard.php";</script>';
                    } else {
                        echo '<script>alert("Error in changing status.");</script>';
                    }
                } elseif ($action == "Delete") {
                    $sql = "DELETE FROM report WHERE report.report_id = '$reportID'";
                    if (mysqli_query($conn, $sql)) {
                        echo '<script>alert("Delete Successfully."); window.location.href = "admin_dashboard.php";</script>';
                    } else {
                        echo '<script>alert("Error in deleting.");</script>';
                    }
                } else {
                    echo '<script>alert("Error123.");</script>';
                }
            } else {
                echo '<script>alert("Error cannot find action.");</script>';
            } 
        }
        ?>
    </main>

</body>

</html>