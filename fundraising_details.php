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

    $userID = $_SESSION["UID"];
    $role = $_SESSION["role"];
    if (isset($_GET["id"]) && !empty($_GET["id"])) {
        $sql = 'SELECT * FROM fundraising 
                INNER JOIN charity ON fundraising.charity_id = charity.charity_id 
                WHERE fundraising_id = ' . $_GET["id"];
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
                    <div class="col-md-6">
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
                                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="tab-home">
                                        <h5 class="card-title">Description</h5>
                                        <p class="card-text"><?= $desc ?></p>
                                        <h5 class="card-title">Date created</h5>
                                        <p class="card-text"><?= $date ?></p>
                                        <h5 class="card-title">Target of the Fund</h5>
                                        <p class="card-text">RM <?= $target ?></p>
                                    </div>
                                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="tab-profile">
                                        <p class="card-text">Content for Profile tab.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">

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