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
    $fundID = $_GET["id"];
    $sql = "SELECT * FROM donation 
            INNER JOIN fundraising ON donation.fundraising_id = fundraising.fundraising_id  
            WHERE donation.fundraising_id = '$fundID' LIMIT 1";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $fund_title = $row['fundraising_title'];
    } else {
        echo "Error: " . mysqli_error($conn);
    }
    ?>

    <main class="main">
        <section id="adminDashBoard" class="adminDashBoard section py-5">
            <div class="container history-container col-md-8 py-5 mb-5">
                <div class="adminViewDonation row pt-5 py-2">
                    <h1>Donation Received</h1>
                    <h3>For <?= $fund_title ?></h3>
                </div>
                <div class="row px-5 pb-5">
                    <table class="table">
                        <tr>
                            <th width="10%">ID</th>
                            <th width="30%">Date</th>
                            <th width="20%">Amount(RM)</th>
                            <th width="30%">Donated By</th>
                            <th width="10%">Action</th>
                        </tr>
                        <?php
                        $sql = "SELECT * FROM donation 
                                INNER JOIN donor ON donation.donor_id = donor.donor_id  
                                WHERE donation.fundraising_id = '$fundID' LIMIT 1";
                        $result = mysqli_query($conn, $sql);
                        if ($result) {
                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr id='table_content'><td>" .  $row['donation_id'] . "</td>";
                                    echo "<td>" . $row['donor_name'] . "</td><td>" . $row['donation_amount'] . "</td>";
                                    echo "<td>" . $row['donation_method'] . "</td><td>" . $row['donation_date'] . "</td>";
                                    echo "</tr>" . "\n\t\t";
                                }
                            } else {
                                echo '<tr><td colspan="5">0 results</td></tr>';
                            }
                        } else {
                            echo "Error: " . mysqli_error($conn);
                        }
                        ?>
                    </table>
                </div>
            </div>
        </section>

        <?php
        include 'layout/footer.php';
        ?>
    </main>
</body>

</html>