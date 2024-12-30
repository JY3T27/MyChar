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
            const element = document.getElementById("fundraising_title");
            if (element.disabled) {
                document.getElementById("fundraising_title").disabled = false;
                document.getElementById("fundraising_desc").disabled = false;
                document.getElementById("updateBtn").style.display = "block";
                document.getElementById("resetBtn").style.display = "block";
            } else {
                document.getElementById("fundraising_title").disabled = true;
                document.getElementById("fundraising_desc").disabled = true;
                document.getElementById("updateBtn").style.display = "none";
                document.getElementById("resetBtn").style.display = "none";
            }
        }

        function confirmationDlt() {
            if (confirm("Are you sure you want to delete this fundraising?")) {
                const confirmationMessage = "Please CONFIRM that you deleting this fundraising? Type DELETE to confirm:";
                const userInput = prompt(confirmationMessage, "");
                if (userInput === "DELETE") {
                    return true;
                } else {
                    alert("Deletion cancelled.");
                    window.location.href = "fundraising_charity.php";
                    return false;
                }
            } else {
                return false;
            }
        }
    </script>
</head>

<body class="index-page">
    <?php
    include 'layout/nav.php';

    $fundID = $_GET["id"];
    $sql = "SELECT * FROM fundraising WHERE fundraising_id = '$fundID' LIMIT 1";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $title = $row["fundraising_title"];
            $desc = $row["fundraising_desc"];
            $img = $row["fundraising_image"];
            $date = $row["fundraising_createDate"];
            $target = $row["fundraising_target"];
            $fund = $row["fundraising_fund"];
            $status = $row["fundraising_status"];
        }
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    ?>
    <main class="main">
        <div class="container py-5">
            <div class="row justify-content-center py-5">
                <!--profile card -->
                <div class="profile-container col-md-8 py-5">
                    <div class="card text-center py-4 px-3">
                        <form id="profile" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col">
                                    <h1>Fundraising Organized</h1>
                                </div>
                                <div class="profile-btn col">
                                    <button type="button" id="togglePassword" onclick="enableEdit()" class="btn shadow-none bg-transparent border-0">
                                        <i class="fa fa-pencil-square-o fs-2" aria-hidden="true"></i></button>
                                    <button type="submit" id="togglePassword" onclick="return confirmationDlt()" name="action" value="Delete" class="btn shadow-none bg-transparent border-0">
                                        <i class="fa fa-trash fs-2" aria-hidden="true"></i></button>
                                </div>
                            </div>
                            <div class="container">
                                <div class="row">
                                    <div class="row">
                                        <div class="col">
                                            <?php if (isset($img) && !empty($img)): ?>
                                                <div class="row pt-2 pb-4">
                                                    <div class="col">
                                                        <img src="<?= $img ?>" alt="Picture for Fundraising" id="fundImg" class="image-fluid image-fundraising">
                                                    </div>
                                                </div>
                                            <?php else: ?>
                                                <div class="row pt-2 pb-4">
                                                    <div class="col">
                                                        <img src="assets\img\sample-content.png" alt="Picture for Fundraising" id="sample-img" class="image-fluid image-fundraising">
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="row mb-3">
                                            <label for="fundraising_title" class="col-md-4 col-form-label text-md-end">Title</label>
                                            <div class="col-md-6">
                                                <input id="fundraising_title" type="text" class="form-control" name="fundraising_title" value="<?= $title ?>" disabled>
                                                <input id="fundraising_id" type="text" class="form-control" name="fundraising_id" value="<?= $fundID ?>" hidden>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="fundraising_date" class="col-md-4 col-form-label text-md-end">Date created</label>
                                            <div class="col-md-6">
                                                <input id="fundraising_date" type="text" class="form-control" name="fundraising_date" value="<?= $date ?>" required autocomplete="email" disabled>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="fundraising_target" class="col-md-4 col-form-label text-md-end">Target</label>
                                            <div class="col-md-6">
                                                <input id="fundraising_target" type="text" class="form-control" name="fundraising_target" value="RM <?= $target ?>" disabled>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="fundraising_fund" class="col-md-4 col-form-label text-md-end">Fund Collected</label>
                                            <div class="col-md-6">
                                                <input id="fundraising_fund" type="text" class="form-control" name="fundraising_fund" value="RM <?= $fund ?>" disabled>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="fundraising_desc" class="col-md-4 col-form-label text-md-end">Description</label>
                                            <div class="col-md-6">
                                                <textarea rows="4" id="fundraising_desc" type="text" class="form-control" name="fundraising_desc" disabled><?= $desc ?></textarea>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row editBtn">
                                                    <button type="submit" value="Update" id="updateBtn" class="profile-Editbtn col" name="action">Update</button>
                                                    <button type="reset" value="Reset" id="resetBtn" class="profile-Editbtn col">Reset</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php
        include 'layout/footer.php';
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $action = $_POST["action"];
            $fundingID = $_POST['fundraising_id'];
            if ($action == "Update") {
                $edited_title = $_POST['fundraising_title'];
                $edited_desc = $_POST['fundraising_desc'];
                $sql = "UPDATE fundraising SET fundraising_title = '$edited_title', fundraising_desc = '$edited_desc'
                        WHERE fundraising_id = '$fundingID'";
                if (mysqli_query($conn, $sql)) {
                    echo '<script>alert("Edit Successfully."); window.location.href = "fundraising_charity.php";</script>';
                } else {
                    echo '<script>alert("Error");</script>';
                }
            } elseif ($action == "Delete") {
                $sql = "DELETE FROM fundraising_update WHERE fundraising_id = '$fundingID'
                        DELETE FROM donation WHERE fundraising_id = '$fundingID'
                        DELETE FROM fundraising WHERE fundraising_id = '$fundingID'";
                if (mysqli_query($conn, $sql)) {
                    echo '<script>alert("Delete Successfully."); window.location.href = "fundraising_charity.php";</script>';
                } else {
                    // Check for foreign key violation error (error code 1451)
                    if ($conn->errno == 1451) {
                        echo '<script>alert("The row can\'t be deleted due to it containing child rows.");</script>';
                    } else {
                        // General error handling
                        echo '<script>alert("Error: ' . $conn->error . '");</script>';
                    }
                }
            } elseif ($action == "ChangePP") {
                echo '<script>window.location.href = "profilePic.php";</script>';
            } else {
                echo '<script>alert("Error");</script>';
            }
        }
        ?>
    </main>

</body>

</html>