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
    $sql = "SELECT * FROM charity WHERE user_id = '$userID' LIMIT 1";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $charityID = $row['charity_id'];
    } else {
        echo "Error: " . mysqli_error($conn);
    }
    ?>

    <main class="main">
        <section id="adminDashBoard" class="adminDashBoard section pb-5 mb-5">
            <div class="container history-container col-md-8 py-5">
                <div class="row pt-5">
                    <div class="col section-header">
                        <h2>History</h2>
                        <p>Activities Done on MyChar</p>
                    </div>
                </div>
                <div class="row pb-5">
                    <h3>Feedback</h3>
                    <table class="table">
                        <tr>
                            <th width="10%">No</th>
                            <th>Title</th>
                            <th width="10%">Rating</th>
                            <th width="30%">Date</th>
                        </tr>
                        <?php
                        $sql = "SELECT * FROM feedback WHERE user_id = '$userID'";
                        $result = mysqli_query($conn, $sql);
                        if ($result) {
                            if (mysqli_num_rows($result) > 0) {
                                $numrow = 1;
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr><td>" .  $numrow . "</td>";
                                    echo "<td id='title_col'> <a href='feedback_details.php?id=" . $row["feedback_id"] . "'>" . $row["feedback_title"] . "</a></td>
                                        <td>" . $row["feedback_rating"] . "</td><td>" . $row["feedback_date"] . "</td></tr>" . "\n\t\t";
                                    $numrow++;
                                }
                            } else {
                                echo '<tr><td colspan="4">0 results</td></tr>';
                            }
                        } else {
                            echo "Error: " . mysqli_error($conn);
                        }
                        ?>
                    </table>
                </div>
            </div>
        </section>

        <?php
        include 'layout/footer.php';
        ?>
    </main>
</body>

</html>