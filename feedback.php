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
    $userID = $_SESSION["UID"];
    $sql = "SELECT donor_id FROM donor WHERE donor.user_id = '$userID' LIMIT 1";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $donor_id = $row['donor_id'];
    } else {
        echo "Error: " . mysqli_error($conn);
    }
    ?>

    <main class="main">
        <section id="charityList" class="charityList section">
            <div class="container login-container col-md-6 pt-5">
                <div class="row pt-5">
                    <div class="col section-header">
                        <h2>Feedbacks & Reviews</h2>
                        <p>Share your feedback to help us improve and better serve you.</p>
                    </div>
                </div>
                <div class="card p-3 mb-5">
                    <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" class="login">
                        <div class="row px-5">
                            <h4>Title</h4>
                        </div>
                        <div class="row px-3 mb-4">
                            <input type="text" name="feedback-title" class="form-control" placeholder="Enter title of the feedback/review" autofocus>
                        </div>
                        <div class="row px-5">
                            <h4>Description</h4>
                        </div>
                        <div class="row px-3 mb-4">
                            <textarea rows="7" id="feedback-desc" name="feedback-desc" class="form-control" placeholder="Enter the feedback/review"></textarea>
                        </div>
                        <div class="row px-5">
                            <h4>Rating</h4>
                        </div>
                        <div class="row px-4 mx-1">
                            <div class="stars">
                                <input type="radio" id="star5" name="rating" value="5">
                                <label for="star5">★</label>

                                <input type="radio" id="star4" name="rating" value="4">
                                <label for="star4">★</label>

                                <input type="radio" id="star3" name="rating" value="3">
                                <label for="star3">★</label>

                                <input type="radio" id="star2" name="rating" value="2">
                                <label for="star2">★</label>

                                <input type="radio" id="star1" name="rating" value="1">
                                <label for="star1">★</label>
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
            $title = $_POST['feedback-title'];
            $content = $_POST['feedback-desc'];
            $rating = $_POST['rating'];
            $sql = "INSERT INTO feedback (feedback_id, donor_id, feedback_title, feedback_content, feedback_date, feedback_rating) 
                    VALUES('', '$donor_id', '$title', '$content', CURRENT_TIMESTAMP, '$rating')";
            if (mysqli_query($conn, $sql)) {
                echo '<script>alert("Sent Feedback Successfully. ");</script>';
            } else {
                echo '<script>alert("Error");</script>';
            }
        }
        ?>
    </main>
</body>

</html>