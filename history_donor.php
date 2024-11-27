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

    $userID = $_SESSION["UID"];
    $sql = "SELECT * FROM donor WHERE user_id = '$userID' LIMIT 1";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $donorID = $row['donor_id'];
    } else {
        echo "Error: " . mysqli_error($conn);
    }
    ?>

    <main class="main">
        <section id="adminDashBoard" class="adminDashBoard section">
            <div class="container history-container col-md-8 pt-5">
                <div class="row pt-5">
                    <div class="col section-header">
                        <h2>History</h2>
                        <p>Activities Done on MyChar</p>
                    </div>
                </div>
                <div class="row px-5 pb-5">
                    <h3>Donation</h3>
                    <table class="table">
                        <tr>
                            <th width="10%">No</th>
                            <th>Title</th>
                            <th width="30%">Date</th>
                        </tr>
                        <?php
                        $sql = "SELECT * FROM donation INNER JOIN fundraising ON donation.fundraising_id = fundraising.fundraising_id 
                                WHERE donor_id = '$donorID'";
                        $result = mysqli_query($conn, $sql);
                        if ($result) {
                            if (mysqli_num_rows($result) > 0) {
                                $numrow = 1;
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr><td>" .  $numrow . "</td>";
                                    echo "<td id='title_col'> <a href='donation_details.php?id=" . $row["donation_id"] . "'>" . $row["fundraising_title"] . "</a></td><td>" . $row["donation_date"] . "</td>";
                                    echo "</tr>" . "\n\t\t";
                                    $numrow++;
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
                <div class="row pb-5">
                    <div class="col-md-6 col-sm-12">
                        <h3>Donation</h3>
                        <table class="table">
                            <tr>
                                <th width="10%">No</th>
                                <th>Fundraising Title</th>
                                <th width="30%">Date</th>
                            </tr>
                            <?php
                            $sql = "SELECT * FROM donation INNER JOIN fundraising ON donation.fundraising_id = fundraising.fundraising_id 
                                WHERE donor_id = '$donorID'";
                            $result = mysqli_query($conn, $sql);
                            if ($result) {
                                if (mysqli_num_rows($result) > 0) {
                                    $numrow = 1;
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "<tr><td>" .  $numrow . "</td>";
                                        echo "<td id='title_col'> <a href='donation_details.php?id=" . $row["donation_id"] . "'>" . $row["fundraising_title"] . "</a></td><td>" . $row["donation_date"] . "</td>";
                                        echo "</tr>" . "\n\t\t";
                                        $numrow++;
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
                    <div class="col-md-6 col-sm-12">
                        <h3>Donation</h3>
                        <table class="table">
                            <tr>
                                <th width="10%">No</th>
                                <th>Title</th>
                                <th width="30%">Date</th>
                            </tr>
                            <?php
                            $sql = "SELECT * FROM donation INNER JOIN fundraising ON donation.fundraising_id = fundraising.fundraising_id 
                                WHERE donor_id = '$donorID'";
                            $result = mysqli_query($conn, $sql);
                            if ($result) {
                                if (mysqli_num_rows($result) > 0) {
                                    $numrow = 1;
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "<tr><td>" .  $numrow . "</td>";
                                        echo "<td id='title_col'> <a href='donation_details.php?id=" . $row["donation_id"] . "'>" . $row["fundraising_title"] . "</a></td><td>" . $row["donation_date"] . "</td>";
                                        echo "</tr>" . "\n\t\t";
                                        $numrow++;
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
            </div>
        </section>

        <?php
        include 'layout/footer.php';
        ?>
    </main>
</body>

</html>