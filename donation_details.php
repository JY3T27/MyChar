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
    $donateID = $_GET['id'];
    if (isset($donateID) && !empty($donateID)) {
        $sql = 'SELECT * FROM donation
                INNER JOIN fundraising ON donation.fundraising_id = fundraising.fundraising_id
                INNER JOIN charity ON fundraising.charity_id = charity.charity_id
                INNER JOIN donor ON donation.donor_id = donor.donor_id   
                WHERE donation_id = ' . $donateID;
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $amt = $row["donation_amount"];
        $method = $row["donation_method"];
        $date = $row["donation_date"];
        $title = $row["fundraising_title"];
        $fundID = $row["fundraising_id"];
        $charity = $row["charity_id"];
        $charityName = $row["charity_name"];
        $donorName = $row["donor_name"];
        $status = $row["donation_status"];
        if ($status == '1') {
            $statusText = "Received";
        } else {
            $statusText = "Waiting for confirmation";
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
                                    <h1>Donation</h1>
                                </div>
                                <div class="profile-btn col">
                                    <?php if ($_SESSION["role"] == 'charity'): ?>
                                        <?php if ($status == '1'): ?>
                                            <button type="submit" id="togglePassword" name="donationAction" value="changeNotDone" class="btn shadow-none bg-transparent border-0">
                                                <i class="fa fa-check-square-o fs-2" aria-hidden="true"></i></button>
                                        <?php else: ?>
                                            <button type="submit" id="togglePassword" name="donationAction" value="changeDone" onclick="return confirm('Confirm done received donation?')" class="btn shadow-none bg-transparent border-0">
                                                <i class="fa fa-square-o fs-2" aria-hidden="true"></i></button>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <button type="submit" id="togglePassword" name="donationAction" value="Delete" onclick="return confirm('Confirm delete donation?')" class="btn shadow-none bg-transparent border-0">
                                            <i class="fa fa-trash fs-2" aria-hidden="true"></i></button>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="container">
                                <div class="row">
                                    <div class="col">
                                        <div class="row mb-3">
                                            <label for="fundraising_title" class="col-md-4 col-form-label text-md-end">Donated to</label>

                                            <div class="col-md-6">
                                                <input id="fundraising_title" type="email" class="form-control" name="fundraising_title" value="<?= $title ?>" required disabled>
                                            </div>
                                        </div>
                                        <?php if ($_SESSION["role"] == 'charity'): ?>
                                            <div class="row mb-3">
                                                <label for="donor_name" class="col-md-4 col-form-label text-md-end">Donated by</label>
                                                <div class="col-md-6">
                                                    <input id="donor_name" type="text" class="form-control" name="donor_name" value="<?= $donorName ?>" disabled>
                                                </div>
                                            </div>
                                        <?php else: ?>
                                            <div class="row mb-3">
                                                <label for="charity_name" class="col-md-4 col-form-label text-md-end">Organized by</label>
                                                <div class="col-md-6">
                                                    <input id="charity_name" type="text" class="form-control" name="charity_name" value="<?= $charityName ?>" disabled>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                        <div class="row mb-3">
                                            <label for="donation_date" class="col-md-4 col-form-label text-md-end">Date</label>
                                            <div class="col-md-6">
                                                <input id="donation_date" type="date" class="form-control" name="donation_date" value="<?= $date ?>" disabled>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="donation_id" class="col-md-4 col-form-label text-md-end">Donation ID</label>
                                            <div class="col-md-6">
                                                <input id="donation_id" type="text" class="form-control" name="donation_id" value="<?= $donateID ?>" disabled>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="donation_amt" class="col-md-4 col-form-label text-md-end">Donation Amount</label>
                                            <div class="col-md-6">
                                                <input id="donation_amt" type="text" class="form-control" name="donation_amt" value="RM <?= $amt ?>" disabled>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="donation_method" class="col-md-4 col-form-label text-md-end">Payment Method</label>
                                            <div class="col-md-6">
                                                <input id="donation_method" type="text" class="form-control" name="donation_method" value="<?= $method ?>" disabled>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="donation_status" class="col-md-4 col-form-label text-md-end">Status</label>
                                            <div class="col-md-6">
                                                <input id="donation_status" type="text" class="form-control" name="donation_status" value="<?= $statusText ?>" disabled>
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
            $action = $_POST["donationAction"];
            $donationID = $_POST["donation_id"];
            if (isset($action)) {
                if ($action == "changeNotDone") {
                    $sql = "UPDATE donation SET donation_status = '0' WHERE donation.donation_id = '$donationID'";
                    if (mysqli_query($conn, $sql)) {
                        echo '<script>window.location.href = "history_charity.php";</script>';
                    } else {
                        echo '<script>alert("Error in changing status.");</script>';
                    }
                } elseif ($action == "changeDone") {
                    $sql = "UPDATE donation SET donation_status = '1' WHERE donation.donation_id = '$donationID'";
                    if (mysqli_query($conn, $sql)) {
                        echo '<script>window.location.href = "history_charity.php";</script>';
                    } else {
                        echo '<script>alert("Error in changing status.");</script>';
                    }
                } elseif ($action == "Delete") {
                    $sql = "DELETE FROM donation WHERE donation.donation_id = '$donationID'";
                    if (mysqli_query($conn, $sql)) {
                        echo '<script>alert("Delete Successfully.");</script>';
                        if ($_SESSION["role"] == 'admin') {
                            echo '<script>window.location.href = "admin_dashboard.php";</script>';
                        } else {
                            echo '<script>window.location.href = "history_donor.php";</script>';
                        }
                    } else {
                        echo '<script>alert("Error in deleting.");</script>';
                    }
                } else {
                    echo '<script>alert("Error execute the action.");</script>';
                }
            } else {
                echo '<script>alert("Error cannot find action.");</script>';
            }
        }
        ?>
    </main>

</body>

</html>