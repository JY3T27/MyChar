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
    $_SESSION['donatingID'] = $fundID;
    $role = $_SESSION['role'];
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
    }

    ?>
    <main class="main">
        <section class="fundDetails section pt-5">
            <div class="container charityList-container col-md-10 py-5">
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
                <div class="row py-5">
                    <div class="col-md-6 pb-5">
                        <div class="card fundCard">
                            <div class="card-header">
                                <ul class="nav nav-tabs card-header-tabs" id="card-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="tab-home" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Details</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="tab-profile" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Updates</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="tab-question" data-toggle="tab" href="#question" role="tab" aria-controls="question" aria-selected="false">Questions</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-content" id="card-tabContent">
                                    <div class="fundCard-body tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="tab-home">
                                        <h3>Description</h3>
                                        <p><?= $desc ?></p>
                                        <h3>Date created</h3>
                                        <p><?= $date ?></p>
                                    </div>
                                    <div class="fundCard-body tab-pane fade" id="profile" role="tabpanel" aria-labelledby="tab-profile">
                                        <?php
                                        $sql = 'SELECT * FROM fundraising_update WHERE fundraising_id = ' . $fundID;
                                        $result = mysqli_query($conn, $sql);
                                        if ($result) {
                                            if (mysqli_num_rows($result) > 0) {
                                                $numrow = 1;
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    echo '  <h5>Update(' . $numrow . ')</h5>
                                                            <p>' . $row['update_desc'] . '</p>
                                                            <h5>Date updated</h5>
                                                            <p>' . $row['update_date'] . '</p><hr>';
                                                    $numrow++;
                                                }
                                            } else {
                                                echo "There is no update about the fundraising";
                                            }
                                        } else {
                                            echo "Error: " . mysqli_error($conn);
                                        }
                                        ?>
                                    </div>
                                    <div class="fundCard-body tab-pane fade" id="question" role="tabpanel" aria-labelledby="tab-question">
                                        <div class="row justify-content-between">
                                            <div class="col-5">
                                                <h3>Question</h3>
                                            </div>
                                            <?php if ($role == 'charity'): ?>
                                                <div class="col-4 m-1">
                                                    <a href="question_reply.php?id=<?= $fundID ?>" id="buttonAsk">Reply</a>
                                                </div>
                                            <?php else: ?>
                                                <div class="col-4 m-1">
                                                    <a href="question_create.php?id=<?= $fundID ?>" id="buttonAsk">Ask</a>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="question-section px-3">
                                            <?php
                                            $sql = 'SELECT * FROM question 
                                                    INNER JOIN donor ON question.donor_id = donor.donor_id
                                                    WHERE fundraising_id = ' . $fundID;
                                            $result = mysqli_query($conn, $sql);
                                            if ($result) {
                                                if (mysqli_num_rows($result) > 0) {
                                                    $numrow = 1;
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        if ($row["question_reply"] != "") {
                                                            echo '<div><h5>Question by ' . $row["donor_name"] . ' on ' . $row["question_textDate"] . ' </h5>
                                                                  <p>' . $row['question_text'] . '</p>
                                                                  <h5>Reply on ' . $row["question_replyDate"] . ': </h5>
                                                                  <p>' . $row['question_reply'] . '</p></div>';
                                                        } else {
                                                            echo '<div><h5>Question by ' . $row["donor_name"] . ' on ' . $row["question_textDate"] . ' </h5>
                                                                  <p>' . $row['question_text'] . '</p></div>';
                                                        }
                                                        $numrow++;
                                                    }
                                                } else {
                                                    echo "There is no question at the moment.";
                                                }
                                            } else {
                                                echo "Error: " . mysqli_error($conn);
                                            }
                                            ?>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 pb-5">
                        <div class="card fundCard-money">
                            <div class="card-body">
                                <h2 class="mb-4">Fund collected</h2>
                                <div class="progress-wrapper">
                                    <div class="progress">
                                        <div id="progressBar" class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <div id="progressPercentage" class="progress-percentage">0.00%</div>
                                </div>
                                <div class="donation-info">
                                    <p class="mb-1"><strong>Target:</strong> RM <span id="targetAmount"><?php echo number_format($target, 2); ?></span></p>
                                    <p><strong>Collected:</strong> RM <span id="collectedAmount"><?php echo number_format($collected, 2); ?></span></p>
                                </div>
                                <div class="row">
                                    <a href="donate.php?id=<?= $fundID ?>">Donate <i class="fa fa-money" aria-hidden="true"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <?php
        include 'layout/footer.php';
        ?>
    </main>
    <script>
        const target = <?php echo $target; ?>;
        const collected = <?php echo $collected; ?>;
        const progressPercentage = Math.min((collected / target) * 100, 100).toFixed(2); // Keep two decimal places
        const progressBar = document.getElementById('progressBar');
        const progressPercentageText = document.getElementById('progressPercentage');
        progressBar.style.width = progressPercentage + '%';
        progressBar.setAttribute('aria-valuenow', progressPercentage);
        progressPercentageText.textContent = progressPercentage + '%';
    </script>
</body>

</html>