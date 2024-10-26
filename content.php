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
                        <h2>Discover</h2>
                        <p>Activites conducted by Charity or Sharing from Charity</p>
                    </div>
                </div>
                <div class="row post-option">
                    <div class="col">
                        <h5>Feel free to post any news and activities</h5>
                    </div>
                    <div class="col-1">
                        <a href="content_create.php"><i class="fa fa-chevron-right fs-2" aria-hidden="true"></i></a>
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