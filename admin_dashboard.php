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
    <style>
        .graph-col {
            flex: 1 1 400px;
            max-width: 100%; 
        }
    </style>
</head>

<body class="index-page">
    <?php
    include 'layout/nav.php';

    $sql = "SELECT DATE_FORMAT(user_joinDate, '%Y-%m') AS month, 
            (SELECT COUNT(user_id) FROM users AS total_users
            WHERE DATE_FORMAT(total_users.user_joinDate, '%Y-%m') <= DATE_FORMAT(users.user_joinDate, '%Y-%m') ) 
            AS total_users FROM users GROUP BY month ORDER BY month ASC;";
    $result = mysqli_query($conn, $sql);
    $months_user = [];
    $totals_user = [];
    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $months_user[] = $row['month'];
                $totals_user[] = $row['total_users'];
            }
        }
    } else {
        echo "Error: " . mysqli_error($conn);
    }
    $sql = "SELECT DATE_FORMAT(u.user_joinDate, '%Y-%m') AS month, SUM(COUNT(d.donor_id)) OVER (ORDER BY DATE_FORMAT(u.user_joinDate, '%Y-%m')) AS total_donors 
            FROM users u LEFT JOIN donor d ON u.user_id = d.user_id GROUP BY month ORDER BY month ASC;";
    $result = mysqli_query($conn, $sql);
    $months_donor = [];
    $totals_donor = [];
    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $months_donor[] = $row['month'];
                $totals_donor[] = $row['total_donors'];
            }
        }
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    $sql = "SELECT DATE_FORMAT(u.user_joinDate, '%Y-%m') AS month, SUM(COUNT(c.charity_id)) OVER (ORDER BY DATE_FORMAT(u.user_joinDate, '%Y-%m')) AS total_charity 
            FROM users u LEFT JOIN charity c ON u.user_id = c.user_id GROUP BY month ORDER BY month ASC;";
    $result = mysqli_query($conn, $sql);
    $months_charity = [];
    $totals_charity = [];
    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $months_charity[] = $row['month'];
                $totals_charity[] = $row['total_charity'];
            }
        }
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    $months_user_json = json_encode($months_user);
    $totals_user_json = json_encode($totals_user);
    $months_donor_json = json_encode($months_donor);
    $totals_donor_json = json_encode($totals_donor);
    $months_charity_json = json_encode($months_charity);
    $totals_charity_json = json_encode($totals_charity);
    ?>

    <main class="main">
        <section id="adminDashboard" class="section">
            <div class="container admin-container col-md-8 pt-5">
                <div class="row pt-5">
                    <div class="col section-header">
                        <h2>Admin Dashboard</h2>
                    </div>
                </div>
                <div class="row justify-content-center pb-5">
                    <div class="graph-col mb-3">
                        <div class="card">
                            <div class="card-header" id="admin-graph">
                                <div class="row justify-content-between">
                                    <div class="col-10">
                                        <h4 class="card-title">Number of User</h4>
                                        <p class="card-category">Since website launched</p>
                                    </div>
                                    <div class="col-2">
                                        <a href="userdatabase.php?type=user"><i class="fa fa-arrow-right fs-2" aria-hidden="true"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <canvas id="lineGraphUser" width="400" height="200"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="graph-col mb-3">
                        <div class="card">
                            <div class="card-header" id="admin-graph">
                                <div class="row justify-content-between">
                                    <div class="col-10">
                                        <h4 class="card-title">Number of Donor</h4>
                                        <p class="card-category">Since website launched</p>
                                    </div>
                                    <div class="col-2">
                                        <a href="userdatabase.php?type=donor"><i class="fa fa-arrow-right fs-2" aria-hidden="true"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <canvas id="lineGraphDonor"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="graph-col mb-3">
                        <div class="card">
                            <div class="card-header" id="admin-graph">
                                <div class="row justify-content-between">
                                    <div class="col-10">
                                        <h4 class="card-title">Number of Charity Joined</h4>
                                        <p class="card-category">Since website launched</p>
                                    </div>
                                    <div class="col-2">
                                        <a href="userdatabase.php?type=charity"><i class="fa fa-arrow-right fs-2" aria-hidden="true"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <canvas id="lineGraphCharity"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row px-5 pb-5">
                    <h3>Feedbacks & Reviews</h3>
                    <table class="table">
                        <tr>
                            <th width="10%">No</th>
                            <th>Title</th>
                            <th>Date</th>
                            <th width="5%">Status</th>
                            <th width="15%">Action</th>
                        </tr>
                        <?php
                        $sql = "SELECT * FROM feedback";
                        $result = mysqli_query($conn, $sql);
                        if ($result) {
                            if (mysqli_num_rows($result) > 0) {
                                $numrow = 1;
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr><td>" .  $numrow . "</td><td>" . $row["feedback_title"] . "</td><td>" . $row["feedback_date"] . "</td>";
                                    if ($row['feedback_status'] == 1)
                                        echo '<td id="tickbox"><input type="checkbox" checked disabled></td>';
                                    else
                                        echo '<td id="tickbox"><input type="checkbox" disabled></td>';
                                    echo '<td> <a href="feedback_details.php?id=' . $row["feedback_id"] . '">View</a></td>';
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
                <div class="row px-5 pb-5">
                    <h3>Reports</h3>
                    <table class="table">
                        <tr>
                            <th width="10%">No</th>
                            <th>Title</th>
                            <th>Charity</th>
                            <th>Date</th>
                            <th width="5%">Status</th>
                            <th width="15%">Action</th>
                        </tr>
                        <?php
                        $sql = "SELECT * FROM report INNER JOIN charity ON report.charity_id = charity.charity_id";
                        $result = mysqli_query($conn, $sql);
                        if ($result) {
                            if (mysqli_num_rows($result) > 0) {
                                $numrow = 1;
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr><td>" .  $numrow . "</td><td>" . $row["report_title"] . "</td><td>". $row["charity_name"] . "</td><td>" . $row["report_date"] . "</td>";
                                    if ($row['report_status'] == 1)
                                        echo '<td id="tickbox"><input type="checkbox" checked disabled></td>';
                                    else
                                        echo '<td id="tickbox"><input type="checkbox" disabled></td>';
                                    echo '<td> <a href="report_details.php?id=' . $row["report_id"] . '">View</a></td>';
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
        </section>

        <?php
        include 'layout/footer.php';
        ?>
    </main>
    <script>
        // Get data from PHP variables
        const monthsUser = <?php echo $months_user_json; ?>;
        const totalsUser = <?php echo $totals_user_json; ?>;
        const monthsDonor = <?php echo $months_donor_json; ?>;
        const totalsDonor = <?php echo $totals_donor_json; ?>;
        const monthsCharity = <?php echo $months_charity_json; ?>;
        const totalsCharity = <?php echo $totals_charity_json; ?>;

        const ctx1 = document.getElementById('lineGraphUser').getContext('2d');
        const userChart = new Chart(ctx1, {
            type: 'line',
            data: {
                labels: monthsUser,
                datasets: [{
                    label: 'Total Users per Month',
                    data: totalsUser,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderWidth: 2,
                    fill: true,
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        const ctx2 = document.getElementById('lineGraphDonor').getContext('2d');
        const donorChart = new Chart(ctx2, {
            type: 'line',
            data: {
                labels: monthsDonor,
                datasets: [{
                    label: 'Total Donors per Month',
                    data: totalsDonor,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderWidth: 2,
                    fill: true,
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        const ctx3 = document.getElementById('lineGraphCharity').getContext('2d');
        const charityChart = new Chart(ctx3, {
            type: 'line',
            data: {
                labels: monthsCharity,
                datasets: [{
                    label: 'Total Charities per Month',
                    data: totalsCharity,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderWidth: 2,
                    fill: true,
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>

</html>