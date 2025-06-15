<?php 
include("config.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['login-submit'])) {
        $myEmail = mysqli_real_escape_string($conn, $_POST['email']);
        $myPassword = mysqli_real_escape_string($conn, $_POST['password']);

        $sql = "SELECT `id`, `role`, `name` FROM `users` WHERE `email` = '$myEmail' AND `password` = '$myPassword'";
        $result = mysqli_query($conn, $sql);

        if (!$result) {
            die('Error: '.mysqli_error($conn));
        }

        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        if (mysqli_num_rows($result) == 1) {
            $_SESSION['login_user'] = $myEmail;
            $_SESSION['role'] = $row['role'];
            $_SESSION['id'] = $row['id'];
            $_SESSION['name'] = $row['name'];

            if ($row['role'] == 'user') {
                header('Location: dashboard.php');
                exit();
            } else if ($row['role'] == 'admin') {
                header('Location: admin.php');
                exit();
            } else {
                header('Location: login.php?p=login#invalid');
                exit();
            }
        } else {
            header('Location: login.php?p=login#error');
            exit();
        }
    }

    if (isset($_POST['signup-submit'])) {
        if (!isset($_POST['registration_code']) || $_POST['registration_code'] !== 'Tenesys Playground 2025') {
            echo "<script>alert('Invalid registration code. Please contact the administrator.');</script>";
            return;
        }

        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);

        $check = mysqli_query($conn, "SELECT email FROM users WHERE email = '$email'");
        if (mysqli_num_rows($check) > 0) {
            echo "<script>alert('User already exists');</script>";
        } else {
            $insert = mysqli_query($conn, "INSERT INTO users(name, email, password) VALUES('$name', '$email', '$password')");
            if (!$insert) die(mysqli_error($conn));
        }
    }
}

$LOGIN = "login";
$SIGNUP = "signup";
$current_page = isset($_GET['p']) ? $_GET['p'] : 'login';
?>
<!DOCTYPE html>
<html>
<?php include 'includes/header.php'; ?>
<body>
    <div class="background"></div>
    <div class="foreground"></div>

  <!-- Login Card with Welcome -->
<div class="main-container">
    <div class="login-card animate-login">

        <!-- Welcome Banner moved inside -->
        <div class="welcome-banner fade-in" style="text-align: center;">
            <img src="images/head.png" alt="Logo" style="width: 60px; margin-bottom: 10px;">
            <div class="text">
                <h2 style="margin: 0;">Welcome to Tenesys Playground</h2>
                <p style="margin-top: 5px;">Login or sign up to get started</p>
            </div>
        </div>

        <!-- Tabs -->
        <div class="tabs">
            <ul>
                <li><a href="login.php?p=login" class="<?= $current_page == 'login' ? 'active' : '' ?>">Login</a></li>
                <li><a href="login.php?p=signup" class="<?= $current_page == 'signup' ? 'active' : '' ?>">Sign Up</a></li>
            </ul>
        </div>

        <!-- Dynamic Form -->
        <?php
            if ($current_page == $LOGIN) {
                include 'includes/login.php';
            } else if ($current_page == $SIGNUP){
                include 'includes/signup.php';
            }
        ?>
    </div>
</div>

</body>
</html>
