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
    $type = $_GET["type"];
    ?>

    <main class="main">
        <section id="adminDashBoard" class="adminDashBoard section">
            <div class="container history-container col-md-8 py-5">
                <div class="row pt-5">
                    <div class="col section-header">
                        <h2>User Database</h2>
                    </div>
                </div>
                <div class="row px-5 pb-5">
                    <?php if ($type == 'user'): ?>
                    <table class="table">
                        <tr>
                            <th width="10%">ID</th>
                            <th>User Email</th>
                            <th width="30%">Join Date</th>
                            <th width="15%">Role</th>
                            <th width="10%">Action</th>
                        </tr>
                        <?php
                        $sql = "SELECT * FROM users";
                        $result = mysqli_query($conn, $sql);
                        if ($result) {
                            if (mysqli_num_rows($result) > 0) {
                                $numrow = 1;
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr id='table_content'><td>" .  $row['user_id'] . "</td>";
                                    echo "<td>" . $row['user_email'] . "</td><td>" . $row['user_joinDate'] . "</td><td>" . $row['user_role'] . "</td>";
                                    echo "<td><a href='profile_adminView.php?id=" . $row['user_id'] . "'>View</a></td>"; 
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
                    <?php endif; ?>
                </div>
            </div>
        </section>

        <?php
        include 'layout/footer.php';
        ?>
    </main>
</body>

</html>