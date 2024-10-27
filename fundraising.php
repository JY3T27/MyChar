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
            </div>
        </section>

        <?php
        include 'layout/footer.php';
        ?>
    </main>
</body>

</html>