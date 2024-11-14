<?php
session_start();
include 'config.php';

if (!isset($_SESSION['UID'])) {
    $_SESSION['donating'] = 'donate.php';
    echo '<script>window.location.href = "login.php";</script>';
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    include 'layout/header.php';
    ?>
    <script>
        function payment_confirm() {
            if (!confirm("Have you done the payment?")) {
                alert("Please make the payment.");
                event.preventDefault();
                return false;
            }
            return true;
        }
    </script>
</head>

<body class="index-page">
    <?php
    include 'layout/nav.php';
    $userID = $_SESSION['UID'];
    $fundID = $_SESSION['donatingID'];
    if (isset($fundID) && !empty($fundID)) {
        $sql = 'SELECT * FROM fundraising 
                INNER JOIN charity ON fundraising.charity_id = charity.charity_id   
                WHERE fundraising_id = ' . $fundID;
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $charity = $row["charity_name"];
        $title = $row["fundraising_title"];
        $date = $row["fundraising_createDate"];
        $target = $row["fundraising_target"];
    }
    $sql = "SELECT donor_id FROM donor WHERE donor.user_id = '$userID' LIMIT 1";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $donor_id = $row['donor_id'];
    } else {
        echo "Error: " . mysqli_error($conn);
    }
    ?>
    <main class="main">
        <section class="donateCard section">
            <div class="container charityList-container col-md-8 py-5">
                <div class="row pt-5">
                    <div class="col section-header text-center">
                        <h2>Donate</h2>
                        <p>Securely donate and direct your impact.</p>
                    </div>
                </div>
                <div class="card mx-auto p-2">
                    <div class="row pt-3 px-3" id="donateTitle">
                        <h2 class="text-start">You are supporting <strong><?= $title ?></strong>.</h2>
                    </div>
                    <div class="row text-start px-5">
                        <p>Organized by <strong><?= $charity ?></strong>. Started from <?= $date ?>.</p>
                    </div>
                    <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data" onsubmit="return payment_confirm()">
                        <div class="row mt-3" style="margin-left: 10%;">
                            <h4>Donate Amount</h4>
                        </div>
                        <div class="row justify-content-center mb-5">
                            <div class="col-auto">
                                <h4>RM </h4>
                            </div>
                            <div class="col-5">
                                <input type="number" class="form-control" name="donateAmt" min="0" step="0.01" placeholder="0.00" required autofocus>
                            </div>
                        </div>
                        <div class="row mt-3" style="margin-left: 10%;">
                            <h4>Payment Method</h4>
                        </div>
                        <div class="row justify-content-center">
                            <label for="tng" class="col-6 radio-container">
                                <h5>TNG (E-wallet)</h5>
                                <input type="radio" id="tng" name="payment-method" value="Touch n Go" required>
                            </label>
                            <label for="fpx" class="col-6 radio-container">
                                <h5>FPX (Credit Card)</h5>
                                <input type="radio" id="fpx" name="payment-method" value="FPX ">
                            </label>
                        </div>
                        <div class="row justify-content-center my-3">
                            <div class="col-auto">
                                <button type="submit" value="Upload" class="btn profile-Editbtn" id="feedbackbtn">Donate</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>

        <?php
        include 'layout/footer.php';
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $amount = $_POST['donateAmt'];
            $method = $_POST['payment-method'];
            $uid = $_SESSION['UID'];
            $sql = "INSERT INTO donation (donation_id, donor_id, fundraising_id, donation_amount, donation_method, donation_date) 
                    VALUES ('', '$donor_id', '$fundID', '$amount', '$method', CURRENT_TIMESTAMP)";
            if (mysqli_query($conn, $sql)) {
                $_SESSION['successID'] = mysqli_insert_id($conn);
                unset($_SESSION['donatingID']);
                echo '<script>window.location.href = "payment_success.php";</script>';
            } else {
                echo '<script>alert("Error in processing donation.");</script>';
            }
        }
        ?>
    </main>
</body>

</html>