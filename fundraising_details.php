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
        $sql = 'SELECT * FROM fundraising WHERE fundraising_id = ' . $_GET["id"];
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $charity = $row["charity_id"];
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
            <div class="container charityList-container col-md-8 pt-5">
                <div class="row pt-5">
                    <div class="col section-header">
                        <h2>Fundraising</h2>
                        <p>Campaigns organized by the charities</p>
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