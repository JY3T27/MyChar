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
    ?>

    <main class="main">
        <section id="charityList" class="charityList section">
            <div class="container charityList-container col-md-8 pt-5">
                <div class="row pt-5">
                    <div class="col section-header">
                        <h2>Fundraising</h2>
                        <p>Campaigns organized by the charities</p>
                    </div>
                </div>
                <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'charity'): ?>
                    <div class="row post-option">
                        <div class="col d-flex align-items-center">
                            <h5>Commencing a new Fundraising Campaign</h5>
                        </div>
                        <div class="col-1">
                            <a href="fundraising_create.php"><i class="fa fa-chevron-right fs-2" aria-hidden="true"></i></a>
                        </div>
                    </div>
                <?php endif; ?>
                <?php
                $sql = "SELECT * FROM fundraising INNER JOIN charity ON fundraising.charity_id = charity.charity_id";
                $result = mysqli_query($conn, $sql);
                if ($result) {
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $percent = round(($row["fundraising_fund"] / $row["fundraising_target"]) * 100, 2);
                            echo '<div class="row fundraisingList" onclick="window.location.href=\'fundraising_details.php?id=' . $row["fundraising_id"] . '\'">
                                        <div class="col-4">';
                            if (isset($row["fundraising_image"]) && !empty($row["fundraising_image"]))
                                echo '<img src="' . $row["fundraising_image"] . '" alt="Picture for Fundraising" id="fundImg" class="image-fluid image-fundraising">';
                            else
                                echo '<img src="assets\img\sample-content.png" alt="Picture for Fundraising" id="fundImg" class="image-fluid image-fundraising">';
                            echo '</div><div class="col align-self-center">
                                        <h1>' . $row["fundraising_title"] . '</h1>
                                        <h5>Organized by: <strong>' . $row["charity_name"] . '</strong></h5>
                                        <h5>Target: <strong>RM ' . $row["fundraising_target"] . '</strong></h5>
                                        <h3><strong>' . $percent . '%</strong> of Fund Collected</h3>
                                    </div></div>';
                        }
                    }
                } else {
                    echo '<div class="row fundraisingList"><h2>Error: ' . mysqli_error($conn) . '</h2></div>';
                }
                ?>
            </div>
        </section>

        <?php
        include 'layout/footer.php';
        ?>
    </main>
</body>

</html>