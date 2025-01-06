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
        function enableEdit() {
            const element = document.getElementById("question-desc");
            if (element.disabled) {
                document.getElementById("question-desc").disabled = false;
                document.getElementById("updateBtn").style.display = "block";
                document.getElementById("resetBtn").style.display = "block";
            } else {
                document.getElementById("question-desc").disabled = true;
                document.getElementById("updateBtn").style.display = "none";
                document.getElementById("resetBtn").style.display = "none";
            }
        }
    </script>
</head>

<body class="index-page">
    <?php
    include 'layout/nav.php';
    $userID = $_SESSION['UID'];
    if (isset($userID) && !empty($userID)) {
        $sql = 'SELECT * FROM charity
                INNER JOIN users ON charity.user_id = charity.user_id   
                WHERE users.user_id = ' . $userID;
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $charityID = $row["charity_id"];
    }
    $replyID = $_GET['id'];
    $sql = "SELECT * FROM question 
            INNER JOIN donor ON question.donor_id = donor.donor_id
            INNER JOIN fundraising ON question.fundraising_id = fundraising.fundraising_id
            INNER JOIN charity ON fundraising.charity_id = charity.charity_id
            WHERE question.question_id = '$replyID'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $text = $row['question_text'];
        $textDate = $row['question_textDate'];
        if (isset($row['question_reply']) && !empty($row['question_reply'])) {
            $reply = $row['question_reply'];
            $replyDate = $row['question_replyDate'];
        }
        $donorName = $row['donor_name'];
        $charityID = $row["charity_id"];
        $charity = $row["charity_name"];
        $fundID = $row["fundraising_id"];
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
                            <h4>Question from Donor <?= $donorName ?> on <?= $textDate ?></h4>
                            <p><?= $text ?></p>
                        </div>
                        <div class="row justify-content-between align-items-center px-5 mb-1">
                            <div class="col">
                                <h4>Reply</h4>
                            </div>
                            <?php if (isset($reply) && !empty($reply)): ?>
                                <div class="col">
                                    <button type="button" id="togglePassword" onclick="enableEdit()" class="btn shadow-none bg-transparent border-0">
                                        <i class="fa fa-pencil-square-o fs-2" aria-hidden="true"></i></button>
                                    <button type="submit" id="togglePassword" onclick="return confirm('Confirm delete reply?')" name="action" value="Delete" class="btn shadow-none bg-transparent border-0">
                                        <i class="fa fa-trash fs-2" aria-hidden="true"></i></button>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="row">
                            <div class="col-8">
                                <input id="fundraising_id" type="text" class="form-control" name="fundraising_id" value="<?= $fundID ?>" hidden>
                                <input id="reply_id" type="text" class="form-control" name="reply_id" value="<?= $replyID ?>" hidden>
                                <?php if (isset($reply) && !empty($reply)): ?>
                                    <textarea rows="4" id="question-desc" name="question-desc" class="form-control" disabled><?= $reply ?></textarea>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row editBtn">
                                                <button type="submit" value="Edit" id="updateBtn" class="profile-Editbtn col" name="action">Update</button>
                                                <button type="reset" value="Reset" id="resetBtn" class="profile-Editbtn col">Reset</button>
                                            </div>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <textarea rows="4" id="question-desc" name="question-desc" class="form-control" placeholder="Write your charity reply on this question."></textarea>
                                    <div class="row justify-content-md-center mt-3 px-5">
                                        <div class="col">
                                            <button type="submit" value="Reply" class="profile-Editbtn" id="feedbackbtn" name="action">Sent</button>
                                            <button type="reset" value="Reset" class="profile-Editbtn" id="feedbackbtn">Reset</button>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                    </form>
                </div>
        </section>

        <?php
        include 'layout/footer.php';
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $action = $_POST["action"];
            $replyID = $_POST['reply_id'];
            $fundID = $_POST['fundraising_id'];
            if ($action == "Edit") {
                $text = $_POST['question-desc'];
                $sql = "UPDATE question SET question_reply = '$text'
                    WHERE question_id = '$replyID'";
                if (mysqli_query($conn, $sql)) {
                    echo '<script>alert("Successfully edit reply. ");window.location.href = "fundraising.php?id=' . $fundID . '";</script>';
                } else {
                    echo '<script>alert("Error");</script>';
                }
            } elseif ($action == "Reply") {
                $text = $_POST['question-desc'];
                $sql = "UPDATE question SET question_reply = '$text', question_replyDate = CURRENT_TIMESTAMP
                        WHERE question_id = '$replyID'";
                if (mysqli_query($conn, $sql)) {
                    echo '<script>alert("Successfully reply to question. ");window.location.href = "fundraising.php?id=' . $fundID . '";</script>';
                } else {
                    echo '<script>alert("Error");</script>';
                }
            } elseif ($action == "Delete") {
                $sql = "UPDATE question SET question_reply = '', question_replyDate = ''
                        WHERE question_id = '$replyID'";
                if (mysqli_query($conn, $sql)) {
                    echo '<script>alert("Successfully delete reply. ");window.location.href = "fundraising.php?id=' . $fundID . '";</script>';
                } else {
                    echo '<script>alert("Error");</script>';
                }
            }
        }
        ?>
    </main>
</body>

</html>