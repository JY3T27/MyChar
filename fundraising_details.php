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
    <script>

    </script>
</head>

<body class="index-page">
    <?php
    include 'layout/nav.php';
    $fundID = $_GET["id"];
    if (isset($fundID) && !empty($fundID)) {
        $sql = 'SELECT * FROM fundraising 
                INNER JOIN charity ON fundraising.charity_id = charity.charity_id   
                WHERE fundraising_id = ' . $fundID;
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $charity = $row["charity_name"];
        $title = $row["fundraising_title"];
        $desc = $row["fundraising_desc"];
        $img = $row["fundraising_image"];
        $date = $row["fundraising_createDate"];
        $target = $row["fundraising_target"];
        $status = $row["fundraising_status"];
    }

    ?>
    <main class="main">
        <section class="fundDetails section">
            <div class="container charityList-container col-md-8 py-5">
                <div class="row pt-5">
                    <div class="col section-header">
                        <h2>Fundraising</h2>
                        <p>Campaigns organized by the charities</p>
                    </div>
                </div>
                <div class="row fundDetails justify-content-center pb-5">
                    <div class="col-4">
                        <?php if (isset($img) && !empty($img)): ?>
                            <img src="<?= $img ?>" alt="Picture for Fundraising" id="fundImg" class="image-fluid image-fundraising">
                        <?php else: ?>
                            <img src="assets\img\sample-content.png" alt="Picture for Fundraising" id="fundImg" class="image-fluid image-fundraising">
                        <?php endif; ?>
                    </div>
                    <div class="col-6">
                        <div class="row">
                            <h1><?= $title ?></h1>
                        </div>
                        <div class="row">
                            <h3>By: <?= $charity ?></h3>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 pb-5">
                        <div class="card fundCard">
                            <div class="card-header">
                                <ul class="nav nav-tabs card-header-tabs" id="card-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="tab-home" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Details</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="tab-profile" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Updates</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-content" id="card-tabContent">
                                    <div class="fundCard-body tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="tab-home">
                                        <h5>Description</h5>
                                        <p><?= $desc ?></p>
                                        <h5>Date created</h5>
                                        <p><?= $date ?></p>
                                    </div>
                                    <div class="fundCard-body tab-pane fade" id="profile" role="tabpanel" aria-labelledby="tab-profile">
                                        <?php
                                        $sql = 'SELECT * FROM fundraising_update WHERE fundraising_id = ' . $_GET["id"];
                                        $result = mysqli_query($conn, $sql);
                                        if ($result) {
                                            if (mysqli_num_rows($result) > 0) {
                                                $numrow = 1;
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    echo '  <h5>Update(' . $numrow . ')</h5>
                                                            <p>' . $row['update_desc'] . '</p>
                                                            <h5>Date updated</h5>
                                                            <p>' . $row['update_date'] . '</p><hr>';
                                                    $numrow++;
                                                }
                                            } else {
                                                echo "There is no update about the fundraising";
                                            }
                                        } else {
                                            echo "Error: " . mysqli_error($conn);
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 pb-5">
                        <div class="card fundCard-money">
                            <div class="card-body">
                                <h2>Target of the fund</h2>
                                <h1>RM <?= $target ?></h1>
                                <div class="row">
                                <a href="donate.php?id=<?= $fundID ?>">Donate <i class="fa fa-money" aria-hidden="true"></i></a>
                                </div>
                            </div>
                        </div>
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