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
    if (isset($id) && !empty($id)) {
        $sql = "SELECT * FROM users INNER JOIN admin ON admin.user_id = users.user_id
                WHERE admin.admin_id = '$id' LIMIT 1";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            $row = mysqli_fetch_assoc($result);
            $userID = $row['user_id'];
            $email = $row['user_email'];
            $date = $row['user_joinDate'];
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "Error: " . mysqli_error($conn);
    }
    ?>
    <main class="main">
        <div class="container py-5">
            <form id="profile" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" enctype="multipart/form-data">
                <div class="row justify-content-center py-5">
                    <!--profile card -->
                    <div class="profile-container col-md-9 py-5">
                        <div class="card text-center py-4 px-3">
                            <div class="row">
                                <div class="col">
                                    <h1>Admin</h1>
                                </div>
                                <div class="profile-btn col">
                                    <button type="submit" id="togglePassword" onclick="return confirm('Confirm delete admin?')" name="action" value="Delete" class="btn shadow-none bg-transparent border-0">
                                        <i class="fa fa-trash fs-2" aria-hidden="true"></i></button>
                                </div>
                            </div>
                            <div class="container pb-5">
                                <div class="row">
                                    <input id="view_id" type="text" class="form-control" name="view_id" value="<?= $userID ?>" hidden>
                                    <div class="col">
                                        <div class="row mb-3">
                                            <label for="profile_email" class="col-md-4 col-form-label text-md-end">Email</label>
                                            <div class="col-md-6">
                                                <input id="profile_email" type="text" class="form-control" name="profile_email" value="<?= $email ?>" disabled>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="profile_date" class="col-md-4 col-form-label text-md-end">Created Date</label>
                                            <div class="col-md-6">
                                                <input id="profile_date" type="date" class="form-control" name="profile_joinDate" value="<?= $date ?>" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <?php
        include 'layout/footer.php';
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $action = $_POST["action"];
            $userID = $_POST["view_id"];
            if ($action == "Delete") {
                $sql = "DELETE FROM users WHERE user_id = '$userID'";
                if (mysqli_query($conn, $sql)) {
                    echo '<script>alert("Delete Successfully."); window.location.href = "profile.php";</script>';
                } else {
                    echo '<script>alert("Error");</script>';
                }
            } else {
                echo '<script>alert("Error");</script>';
            }
        }
        ?>
    </main>

</body>

</html>