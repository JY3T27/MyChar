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
    if (isset($_SESSION['successID']) && !empty($_SESSION['successID'])) {
        $sql = 'SELECT donor.donor_name, fundraising.fundraising_title, donation.donation_amount, donation.donation_method, donation.donation_date, fundraising.fundraising_id
                FROM donation 
                INNER JOIN donor ON donation.donor_id = donor.donor_id
                INNER JOIN fundraising ON donation.fundraising_id = fundraising.fundraising_id
                WHERE donation_id = ' . $_SESSION['successID'];
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $donor = $row["donor_name"];
        $title = $row["fundraising_title"];
        $amount = $row["donation_amount"];
        $date = $row["donation_date"];
        $method = $row["donation_method"];
        $fundID = $row["fundraising_id"];
    } else {
        $donor = 'error';
    }

    $update_sql = "UPDATE fundraising SET fundraising_fund = ( 
                   SELECT SUM(donation_amount) FROM donation WHERE fundraising_id ='$fundID'  ) 
                   WHERE fundraising_id = '$fundID';";
    $result = mysqli_query($conn, $update_sql);
    if (!$result) {
        echo "Error: " . mysqli_error($conn);
    }

    $update_sql = "UPDATE fundraising SET fundraising_status = 1
                   WHERE fundraising_fund >= fundraising_target AND fundraising_id = '$fundID';";
    $result = mysqli_query($conn, $update_sql);
    if (!$result) {
    echo "Error: " . mysqli_error($conn);
    }
    ?>
    <main class="main">
        <section class="donateCard section py-5">
            <div class="container charityList-container col-md-8 py-5">
                <div class="card successCard">
                    <div class="row">
                        <h1><strong>Thank you, <?= $donor ?></strong></h1>
                    </div>
                    <div class="row">
                        <p>On behalf of our organization and the communities who are touched by your generosity, <br>
                            we extstart our heartfelt gratitude for your invaluable contribution. Your support makes a meaningful difference.</p>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-5 text-start">
                            <h5>Donated to: </h5>
                        </div>
                        <div class="col-md-auto text-start">
                            <h5>&nbsp;<?= $title ?></h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-5 text-start">
                            <h5>Payment Method: </h5>
                        </div>
                        <div class="col-md-auto text-start">
                            <h5>&nbsp;<?= $method ?></h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-5 text-start">
                            <h5>Payment Amount: </h5>
                        </div>
                        <div class="col-md-auto text-start">
                            <h5>&nbsp;RM <?= $amount ?></h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-5 text-start">
                            <h5>Date: </h5>
                        </div>
                        <div class="col-md-auto text-start">
                            <h5>&nbsp;<?= $date ?></h5>
                        </div>
                    </div>
                    <div class="row pt-3 justify-content-center">
                        <div class="col-md-7">
                            <button class="btn profile-Editbtn" onclick="backToMain()">Back to Main Page</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <?php
        include 'layout/footer.php';
        ?>
    </main>
    <script>
        function backToMain() {
            window.location.href = "index.php";
        }
    </script>
</body>

</html>