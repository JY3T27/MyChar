<?php
session_start();
include 'config.php';

if (!isset($_SESSION['UID'])) {
    $_SESSION['donating'] = 'question_create.php';
    echo '<script>window.location.href = "login.php";</script>';
    exit();
}
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
    $userID = $_SESSION['UID'];
    if (isset($userID) && !empty($userID)) {
        $sql = 'SELECT * FROM donor
                INNER JOIN users ON donor.user_id = users.user_id   
                WHERE users.user_id = ' . $userID;
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $donorID = $row["donor_id"];
    }
    $fundID = $_SESSION['donatingID'];
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
                            <h4>Question for the fundraising</h4>
                        </div>
                        <div class="row px-5 mb-1">
                            <div class="col-8">
                                <textarea rows="4" id="question-desc" name="question-desc" class="form-control" placeholder="Type in the question."></textarea>
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
            $userID = $_SESSION['UID'];
            $text = $_POST['question-desc'];
            $sql = "INSERT INTO question (question_id, donor_id, fundraising_id, question_text, question_textDate) 
                    VALUES('', '$donorID', '$fundID', '$text', CURRENT_TIMESTAMP)";
            if (mysqli_query($conn, $sql)) {
                unset($_SESSION['donatingID']);
                echo '<script>alert("Successfully ask question. ");window.location.href = "fundraising_details.php?id=' . $fundID . '";</script>';
            } else {
                echo '<script>alert("Error");</script>';
            }
        }
        ?>
    </main>
</body>

</html>