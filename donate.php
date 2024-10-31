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
    ?>
    <main class="main">
        <section class="fundDetails section">
            <div class="container charityList-container col-md-8 py-5">
                <div class="row pt-5">
                    <div class="col section-header">
                        <h2>Donate</h2>
                        <p>Securely donate and direct your impact.</p>
                        <h1><?= $fundID ?></h1>
                    </div>
                </div>
                <div class="card">
                    <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data">

                    </form>
                </div>
            </div>
        </section>

        <?php
        include 'layout/footer.php';
        ?>
    </main>

</body>

</html>