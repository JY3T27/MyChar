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
            <div class="container charityList-container col-md-8 py-5 mb-5">
                <div class="row pt-5">
                    <div class="col section-header">
                        <h2>List of Charity</h2>
                        <p>Charities in Malaysia</p>
                    </div>
                </div>
                <div class="row justify-content-md-center pb-5 mb-5">
                    <?php
                    $sql = "SELECT charity_id, charity_name, charity_state, charity_profilepic FROM charity";
                    $result = mysqli_query($conn, $sql);
                    if ($result) {
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo '<div class="col-md-6">
                                        <div class="charitylist-container card p-2 mb-4" onclick="window.location.href=\'charity.php?id=' . $row["charity_id"] . '\';">
                                            <div class="row d-flex justify-content-md-center align-items-center pt-3">
                                                <div class="col d-flex justify-content-md-center align-items-center pb-3">';
                                if (isset($row["charity_profilepic"]) && !empty($row["charity_profilepic"]))
                                    echo '<img src="' . $row["charity_profilepic"] . '" alt="ProfilePic" id="image-charity" class="image-fluid">';
                                else
                                    echo '<img src="assets\img\profile_icon.jpg" alt="ProfilePic" id="image-charity" class="image-fluid">';
                                echo '</div><div class="col-md-6 px-3">
                                            <h5>' . $row["charity_name"] . '</h5>
                                            <p>' . $row["charity_state"] . '</p>
                                        </div></div></div></div>';
                            }
                        }
                    } else {
                        echo "Error: " . mysqli_error($conn);
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