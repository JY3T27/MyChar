<?php
session_start();
include 'config.php'
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    include 'layout/header.php'
    ?>
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
                        <h1>Create Admin</h1>
                        <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" class="register">
                            <div class="row mb-3">
                                <label for="email" class="col-md-4 col-form-label text-md-end">Email Address</label>
                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" name="email" value="" required autocomplete="email">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="password1" class="col-md-4 col-form-label text-md-end">Password</label>
                                <div class="col-md-6 position-relative">
                                    <input id="password1" type="password" class="form-control" name="password1" required autocomplete="new-password">
                                    <button type="button" id="togglePassword1" onclick="showPassword1()" class="btn shadow-none bg-transparent border-0 position-absolute top-0 end-0 me-1">
                                        <i class="fa fa-eye-slash fs-4" aria-hidden="true"></i></button>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="password2" class="col-md-4 col-form-label text-md-end">Confirm Password</label>
                                <div class="col-md-6 position-relative">
                                    <input id="password2" type="password" class="form-control" name="password2" required autocomplete="new-password">
                                    <button type="button" id="togglePassword2" onclick="showPassword2()" class="btn shadow-none bg-transparent border-0 position-absolute top-0 end-0 me-1">
                                        <i class="fa fa-eye-slash fs-4" aria-hidden="true"></i></button>
                                </div>
                            </div>
                            <div class="row mb-0">
                                <div class="col-md-11">
                                    <button type="submit" class="login-btn">Register</button>
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
            $email = $_POST['email'];
            $pwd = $_POST['password1'];
            $confirmPwd = $_POST['password2'];

            if ($pwd !== $confirmPwd) {
                echo '<script>alert("Password are not match");</script>';
            } else {
                $sql = "SELECT * FROM users WHERE user_email = '$email' LIMIT 1";
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) == 1) {
                    echo '<script>alert("User existed, please register a new user");</script>';
                } else {
                    $pwdHash = trim(password_hash($pwd, PASSWORD_DEFAULT));
                    $sql = "INSERT INTO users (user_id, user_email, user_password, user_joinDate, user_role) 
                    VALUES ('', '$email', '$pwdHash', CURRENT_TIMESTAMP, 'admin')";
                    if (mysqli_query($conn, $sql)) {
                            $lastInsertedId = mysqli_insert_id($conn);
                            $sql = "INSERT INTO admin (admin_id, user_id) VALUES ('','$lastInsertedId')";
                            if (mysqli_query($conn, $sql)) {
                                echo '<script>alert("Register Successfully. "); window.location.href = "admin_dashboard.php"</script>';
                            } else {
                                echo '<script>alert("Error");</script>';
                            }
                    } else {
                        echo '<script>alert("Error");</script>';
                    }
                }
            }
            mysqli_close($conn);
        }
        ?>
        <script>
            function showPassword1() {
                var x = document.getElementById("password1");
                let togglePassword = document.getElementById('togglePassword1')
                if (x.type === "password") {
                    x.type = "text";
                    togglePassword.innerHTML = '<i class="fa fa-eye fs-4" aria-hidden="true">';
                } else {
                    x.type = "password";
                    togglePassword.innerHTML = '<i class="fa fa-eye-slash fs-4" aria-hidden="true">';
                }
            }

            function showPassword2() {
                var x = document.getElementById("password2");
                let togglePassword = document.getElementById('togglePassword2')
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