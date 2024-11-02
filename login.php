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
        function passwordbox() {
            alert('Email and Password are incorrect.');
            window.history.back();
        }

        function noUser() {
            alert('User does not exist.');
            window.history.back();
        }
    </script>
</head>

<body>
    <?php
    include 'layout/nav.php'
    ?>
    <main class="main">
        <div class="container py-5">
            <div class="row justify-content-center py-5">
                <div class="login-container col-md-8 py-5">
                    <div class="card text-center py-4 px-3">
                        <h1> Login</h1>
                        <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" class="login">
                            <div class="row mb-3">
                                <label for="email-login" class="col-md-4 col-form-label text-md-end">Email Address</label>
                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" name="email" value="" required autocomplete="email" placeholder="abc123@email.com" autofocus>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="password-login" class="col-md-4 col-form-label text-md-end">Password</label>
                                <div class="col-md-6 position-relative">
                                    <input id="passwordInput" type="password" class="form-control" name="passwordInput" placeholder="Enter your password" required autocomplete="current-password">
                                    <button type="button" id="togglePassword" onclick="showPassword()" class="btn shadow-none bg-transparent border-0 position-absolute top-0 end-0 me-1">
                                        <i class="fa fa-eye-slash fs-4" aria-hidden="true"></i></button>
                                </div>
                            </div>
                            <div class="row mb-0">
                                <div class="col-md-11">
                                    <button type="submit" class="login-btn">Login</button>
                                </div>
                            </div>
                        </form>
                        <h5><span>OR</span></h5>
                        <p>If you don't have an account, please press <a href="register.php">here</a></p>
                    </div>
                </div>
            </div>
        </div>
        <?php
        include 'layout/footer.php';

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = $_POST['email'];
            $userPwd = $_POST['passwordInput'];
            $sql = "SELECT * FROM users WHERE user_email = '$email' LIMIT 1";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) == 1) {
                $row = mysqli_fetch_assoc($result);
                if (password_verify($userPwd, $row['user_password'])) {
                    $_SESSION["UID"] = $row["user_id"]; //the first record set, bind to userID
                    $_SESSION["role"] = $row["user_role"];
                    //set logged in time
                    $_SESSION['loggedin_time'] = time();
                    if ($_SESSION["role"] == 'admin') {
                        echo '<script>window.location.href = "admin_dashboard.php";</script>';
                        exit();
                    } else {
                        if (isset($_SESSION['donating'])) {
                            $redirect_url = $_SESSION['donating'];
                            unset($_SESSION['donating']);
                            echo '<script>window.location.href = "' . $redirect_url . '";</script>';
                            exit();
                        }
                        // Default redirection if no redirect URL is set
                        echo '<script>window.location.href = "index.php";</script>';
                        exit();
                    }
                } else {
                    echo '<script>passwordbox();</script>';
                }
            } else {
                echo '<script>noUser();</script>';
            }
            mysqli_close($conn);
        }
        ?>
        <script>
            function showPassword() {
                var x = document.getElementById("passwordInput");
                let togglePassword = document.getElementById('togglePassword')
                if (x.type === "password") {
                    x.type = "text";
                    togglePassword.innerHTML = '<i class="fa fa-eye fs-4" aria-hidden="true">';
                } else {
                    x.type = "password";
                    togglePassword.innerHTML = '<i class="fa fa-eye-slash fs-4" aria-hidden="true">';
                }
            }
        </script>
    </main>
</body>

</html>