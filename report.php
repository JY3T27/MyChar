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
    $sql = "SELECT charity_id, charity_name FROM charity";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $charities[] = $row;
        }
    }
    ?>

    <main class="main">
        <section id="charityList" class="charityList section">
            <div class="container login-container col-md-6 pt-5">
                <div class="row pt-5">
                    <div class="col section-header">
                        <h2>Report</h2>
                        <p>Report any suspicious activity about a charity to help us ensure transparency and safety.</p>
                    </div>
                </div>
                <div class="card p-3 mb-5">
                    <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" class="login">
                        <div class="row px-5">
                            <h4>Title</h4>
                        </div>
                        <div class="row px-3 mb-4">
                            <input type="text" name="report-title" class="form-control" placeholder="Enter title of the report." autofocus>
                        </div>
                        <div class="row px-5">
                            <h4>Charity Name</h4>
                        </div>
                        <div class="row px-3 mb-4">
                            <select id="charityDropdown" name="charity" class="form-control">
                                <option value="">-- Select Charity --</option>
                                <?php foreach ($charities as $charity): ?>
                                    <option value="<?= htmlspecialchars($charity['charity_id']) ?>">
                                        <?= htmlspecialchars($charity['charity_name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="row px-5">
                            <h4>Description</h4>
                        </div>
                        <div class="row px-3 mb-4">
                            <textarea rows="7" id="report-desc" name="report-desc" class="form-control" placeholder="Enter your explaination."></textarea>
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
            $title = $_POST['report-title'];
            $charityID = $_POST['charity'];
            $content = $_POST['report-desc'];
            $sql = "INSERT INTO report (report_id, user_id, charity_id, report_title, report_content, report_date) 
                    VALUES('', '$userID', '$charityID', '$title', '$content', CURRENT_TIMESTAMP)";
            if (mysqli_query($conn, $sql)) {
                echo '<script>alert("Sent report Successfully. ");</script>';
            } else {
                echo '<script>alert("Error");</script>';
            }
        }
        ?>
    </main>
</body>

</html>