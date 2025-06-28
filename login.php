<?php 
include("config.php");
session_start();

// Cek Remember Me
if (!isset($_SESSION['login_user']) && isset($_COOKIE['remember_token'])) {
    $token = $_COOKIE['remember_token'];
    $stmt = $conn->prepare("SELECT id, email, role, name FROM users WHERE remember_token = ?");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows === 1) {
        $user = $result->fetch_assoc();
        $_SESSION['login_user'] = $user['email'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['id'] = $user['id'];
        $_SESSION['name'] = $user['name'];

        header("Location: dashboard.php");
        exit();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['login-submit'])) {
        $myEmail = trim($_POST['email']);
        $myPassword = $_POST['password'];
        $rememberMe = isset($_POST['remember_me']);

        $stmt = $conn->prepare("SELECT id, role, name, password FROM users WHERE email = ?");
        $stmt->bind_param("s", $myEmail);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows === 1) {
            $row = $result->fetch_assoc();

            if (password_verify($myPassword, $row['password'])) {
                $_SESSION['login_user'] = $myEmail;
                $_SESSION['role'] = $row['role'];
                $_SESSION['id'] = $row['id'];
                $_SESSION['name'] = $row['name'];

                if ($rememberMe) {
                    $token = bin2hex(random_bytes(32));
                    $stmt = $conn->prepare("UPDATE users SET remember_token = ? WHERE email = ?");
                    $stmt->bind_param("ss", $token, $myEmail);
                    $stmt->execute();
                    setcookie('remember_token', $token, time() + (86400 * 30), "/", "", false, true);
                }

                if ($row['role'] == 'admin') {
                    header("Location: admin.php");
                } else {
                    header("Location: dashboard.php");
                }
                exit();
            } else {
                header("Location: login.php?p=login#wrongpassword");
                exit();
            }
        } else {
            header("Location: login.php?p=login#nouser");
            exit();
        }
    }

    if (isset($_POST['signup-submit'])) {
        if (!isset($_POST['registration_code']) || $_POST['registration_code'] !== 'Tenesys Playground 2025') {
            echo "<script>alert('Invalid registration code. Please contact the administrator.');</script>";
            return;
        }

        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $password = $_POST['password'];

        $check = $conn->prepare("SELECT email FROM users WHERE email = ?");
        $check->bind_param("s", $email);
        $check->execute();
        $checkResult = $check->get_result();

        if ($checkResult->num_rows > 0) {
            echo "<script>alert('User already exists');</script>";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $name, $email, $hashed_password);
            $stmt->execute();
            echo "<script>alert('Registration successful! Please log in.'); window.location.href='login.php?p=login';</script>";
            exit();
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

    <div class="main-container">
        <div class="login-card animate-login">
            <!-- Welcome -->
            <div class="welcome-banner fade-in" style="text-align: center;">
                <img src="images/head.png" alt="Logo" style="width: 120px; margin-bottom: 0 px;">
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

<?php if (isset($_GET['p']) && $_GET['p'] === 'login'): ?>
<script>
    window.addEventListener('DOMContentLoaded', () => {
        const hash = window.location.hash;
        if (hash === "#wrongpassword") {
            alert("Incorrect password. Please try again.");
        } else if (hash === "#nouser") {
            alert("No user found with that email.");
        }
    });
</script>
<?php endif; ?>
</body>
</html>
