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
    $fundID = $_GET['id'];
    if (isset($fundID) && !empty($fundID)) {
        $sql = 'SELECT * FROM fundraising 
                INNER JOIN charity ON fundraising.charity_id = charity.charity_id   
                WHERE fundraising_id = ' . $fundID;
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $charityID = $row["charity_id"];
        $charity = $row["charity_name"];
        $title = $row["fundraising_title"];
        $desc = $row["fundraising_desc"];
        $img = $row["fundraising_image"];
        $date = $row["fundraising_createDate"];
        $target = $row["fundraising_target"];
        $collected = $row["fundraising_fund"];
        $status = $row["fundraising_status"];
        if ($status == "0") {
            $statusText = "Active";
        } else {
            $statusText = "Not Active";
        }
    }
    ?>
    <main class="main">
        <section id="charityList" class="charityList section">
            <div class="container question-create col-md-10 pt-5 mt-5">
                <div class="charity-title row align-items-center p-4 m-4 rounded">
                    <div class="col-md-auto text-center text-md-start">
                        <?php if (isset($img) && !empty($img)): ?>
                            <img src="<?= $img ?>" alt="Picture for Fundraising" id="fundImg" class="image-fluid image-fundraising">
                        <?php else: ?>
                            <img src="assets\img\sample-content.png" alt="Picture for Fundraising" id="fundImg" class="image-fluid image-fundraising">
                        <?php endif; ?>
                    </div>
                    <div class="col">
                        <div class="row">
                            <h1><?= $title ?></h1>
                        </div>
                        <div class="row">
                            <h3>By: <a href="charity.php?id=<?= $charityID ?>"><?= $charity ?></a> </h3>
                        </div>
                    </div>
                </div>
                <div class="row px-5">
                    <div class="col">
                        <h4>Description</h4>
                        <p><?= $desc ?></p>
                        <h4>Date created</h4>
                        <p> <?= $date ?></p>
                    </div>
                    <div class="col">
                        <h4>Status</h4>
                        <p><?= $statusText ?></p>
                        <h4>Target</h4>
                        <p>RM <?= $target ?></p>
                        <h4>Fund collected</h4>
                        <p>RM <?= $collected ?></p>
                    </div>
                </div>
                <div class="card p-3 mb-5">
                    <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" class="login">
                        <div class="row px-5">
                            <h4>Update for the fundraising</h4>
                        </div>
                        <div class="row px-5 mb-1">
                            <div class="col-8">
                                <input type="text" id="update_id" name="update_id" class="form-control" value="<?= $fundID ?>" hidden>
                                <textarea rows="4" id="question-desc" name="question-desc" class="form-control" placeholder="Type in the update."></textarea>
                            </div>
                        </div>
                        <div class="row justify-content-md-center mt-3 px-5">
                            <div class="col">
                                <button type="submit" value="Update" class="profile-Editbtn" id="feedbackbtn">Sent</button>
                                <button type="reset" value="Reset" class="profile-Editbtn" id="feedbackbtn">Reset</button>
                            </div>
                        </div>
                    </form>
                </div>
        </section>
        <?php
        include 'layout/footer.php';
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $fundID = $_POST['update_id'];
            $text = $_POST['question-desc'];
            $sql = "INSERT INTO fundraising_update (update_id, fundraising_id, update_desc, update_date) 
                    VALUES('', '$fundID', '$text', CURRENT_TIMESTAMP)";
            if (mysqli_query($conn, $sql)) {
                echo '<script>alert("Successfully add update. ");window.location.href = "fundraising.php?id=' . $fundID . '";</script>';
            } else {
                echo '<script>alert("Error");</script>';
            }
        }
        ?>
    </main>
</body>

</html>