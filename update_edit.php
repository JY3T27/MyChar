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
    $updateID = $_GET['id'];
    $sql = "SELECT * FROM fundraising_update 
            INNER JOIN fundraising ON fundraising_update.fundraising_id = fundraising.fundraising_id
            INNER JOIN charity ON fundraising.charity_id = charity.charity_id
            WHERE fundraising_update.update_id = '$updateID'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $text = $row['update_desc'];
        $textDate = $row['update_date'];
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
                        <div class="row justify-content-between align-items-center px-5 mb-1">
                            <div class="col">
                                <h4>Update on <?= $textDate ?></h4>
                            </div>
                            <div class="col-5">
                                <button type="button" id="togglePassword" onclick="enableEdit()" class="btn shadow-none bg-transparent border-0">
                                    <i class="fa fa-pencil-square-o fs-2" aria-hidden="true"></i></button>
                                <button type="submit" id="togglePassword" onclick="return confirm('Confirm delete reply?')" name="action" value="Delete" class="btn shadow-none bg-transparent border-0">
                                    <i class="fa fa-trash fs-2" aria-hidden="true"></i></button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-8">
                                <input id="fundraising_id" type="text" class="form-control" name="fundraising_id" value="<?= $fundID ?>" hidden>
                                <input id="update_id" type="text" class="form-control" name="update_id" value="<?= $updateID ?>" hidden>
                                <textarea rows="4" id="question-desc" name="question-desc" class="form-control" disabled><?= $text ?></textarea>
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
                            </div>
                        </div>
                    </form>
                </div>
        </section>

        <?php
        include 'layout/footer.php';
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $action = $_POST["action"];
            $updateID = $_POST['update_id'];
            $fundID = $_POST['fundraising_id'];
            if ($action == "Edit") {
                $text = $_POST['question-desc'];
                $sql = "UPDATE fundraising_update SET update_desc = '$text'
                        WHERE update_id = '$updateID'";
                if (mysqli_query($conn, $sql)) {
                    echo '<script>alert("Successfully edit update. ");window.location.href = "fundraising.php?id=' . $fundID . '";</script>';
                } else {
                    echo '<script>alert("Error");</script>';
                }
            } elseif ($action == "Delete") {
                $sql = "DELETE FROM fundraising_update WHERE update_id = '$updateID'";
                if (mysqli_query($conn, $sql)) {
                    echo '<script>alert("Successfully delete update. ");window.location.href = "fundraising.php?id=' . $fundID . '";</script>';
                } else {
                    echo '<script>alert("Error");</script>';
                }
            }
        }
        ?>
    </main>
</body>

</html>