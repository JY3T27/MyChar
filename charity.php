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

    $charityID = $_GET["id"];
    if (isset($charityID) && !empty($charityID)) {
        $sql = "SELECT * FROM users INNER JOIN charity ON users.user_id = charity.user_id  
            WHERE charity.charity_id = '$charityID' LIMIT 1";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $name = $row['charity_name'];
        $date = $row['user_joinDate'];
        $address = $row['charity_address'];
        $state = $row['charity_state'];
        $contactEmail = $row['charity_contactEmail'];
        $phone = $row['charity_phoneNo'];
        $url = $row['charity_websiteURL'];
        $profile_pic = $row['charity_profilepic'];
        $code = $row['charity_code'];
        $desc = $row['charity_desc'];
    }
    ?>
    <main class="main">
        <div class="container my-4 py-5">
            <div class="charity-view py-5">
                <div class="charity-title row align-items-center p-4 rounded py-5">
                    <div class="col-md-auto text-center text-md-start">
                        <?php if (isset($profile_pic) && !empty($profile_pic)): ?>
                            <img src="<?= $profile_pic ?>" alt="ProfilePic" id="image-profile" class="avatar">
                        <?php else: ?>
                            <img src="assets\img\profile_icon.jpg" alt="ProfilePic" id="image-profile" class="avatar">
                        <?php endif; ?>
                    </div>
                    <div class="col">
                        <h1 class="mb-0"><?= $name ?></h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5 my-4">
                        <h3>About Us</h3>
                        <p><?= $desc ?></p>
                    </div>
                    <div class="col-md-5 my-4">
                        <h4>Contact Us</h4>
                        <p>
                            <strong>Website:</strong> <?= $url ?><br>
                            <strong>Email:</strong> <?= $contactEmail ?><br>
                            <strong>Phone:</strong> <?= $phone ?><br>
                            <strong>Address:</strong> <?= $address ?> <?= $state ?>
                        </p>
                    </div>
                </div>
                <div class="my-4">
                    <h3>Our Fundraising Campaigns</h3>
                    <div class="row">
                        <?php
                        $sql = "SELECT * FROM fundraising WHERE charity_id = " . $charityID;
                        $result = mysqli_query($conn, $sql);
                        if ($result) {
                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo '<div class="col-md-6">
                                            <div class="card mb-4">
                                                <div class="card-body">
                                                    <h5 class="card-title">' . $row["fundraising_title"] . ' </h5>
                                                    <p class="card-text">' . $row["fundraising_desc"] . '</p>
                                                    <button onclick="window.location.href=\'fundraising_details.php?id=' . $row["fundraising_id"] . '\'" class="profile-Editbtn col" id="charitybtn">Learn More</button>
                                                </div>
                                            </div>
                                        </div>';
                                }
                            }
                        } else {
                            echo "Error: " . mysqli_error($conn);
                        }
                        ?>
                    </div>
                </div>
            </div>

        </div>
        <?php
        include 'layout/footer.php';
        ?>
    </main>

</body>

</html>