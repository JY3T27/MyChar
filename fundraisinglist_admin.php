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
    $id = $_GET["id"];
    ?>

    <main class="main">
        <section id="adminDashBoard" class="adminDashBoard section">
            <form id="profile" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                <div class="container history-container col-md-8 py-5 mb-5">
                    <div class="row pt-5">
                        <div class="col section-header">
                            <h2>Database</h2>
                        </div>
                    </div>
                    <div class="row px-5 pb-5">
                        <h3>Fundraising</h3>
                        <table class="table">
                            <tr>
                                <th width="5%">No</th>
                                <th>Fundraising Title</th>
                                <th width="15%">Date</th>
                                <th width="10%">Action</th>
                            </tr>
                            <?php
                            $sql = "SELECT * FROM fundraising 
                                INNER JOIN charity ON fundraising.charity_id = charity.charity_id
                                WHERE charity.charity_id = '$id'";
                            $result = mysqli_query($conn, $sql);
                            if ($result) {
                                if (mysqli_num_rows($result) > 0) {
                                    $numrow = 1;
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "<tr><td>" .  $numrow . "</td>";
                                        echo "<td id='title_col'>" . $row["fundraising_title"] . "</td><td>" . $row["fundraising_createDate"] . "</td>";
                                        echo "<td><button type='submit' id='togglePassword' onclick=\"return confirm('Confirm delete fundraising?')\" name='fundID' value='" . $row['fundraising_id'] . "' class='btn shadow-none bg-transparent border-0'>
                                            <i class='fa fa-trash fs-2' aria-hidden='true'></i></button></td>";
                                        echo "</tr>" . "\n\t\t";
                                        $numrow++;
                                    }
                                } else {
                                    echo '<tr><td colspan="5">0 results</td></tr>';
                                }
                            } else {
                                echo "Error: " . mysqli_error($conn);
                            }
                            ?>
                        </table>
                    </div>
                </div>
            </form>
        </section>

        <?php
        include 'layout/footer.php';
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $fundID = $_POST["fundID"];
            $sql = "DELETE FROM fundraising WHERE fundraising_id = '$fundID'";
            if (mysqli_query($conn, $sql)) {
                echo '<script>alert("Delete Successfully."); window.location.href = "userdatabase.php?type=charity";</script>';
            } else {
                echo '<script>alert("Error");</script>';
            }
        }
        ?>
    </main>
</body>

</html>