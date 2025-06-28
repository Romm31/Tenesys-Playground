<?php
session_start();
include("config.php"); // Tambahkan agar koneksi DB bisa digunakan

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['logout-yes'])) {
        // Hapus token remember_token dari database
        if (isset($_SESSION['login_user'])) {
            $email = $_SESSION['login_user'];
            $stmt = $conn->prepare("UPDATE users SET remember_token = NULL WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
        }

        // Hapus cookie remember_token dari browser
        setcookie('remember_token', '', time() - 3600, "/");

        // Hapus semua sesi login
        session_destroy();
        header("Location: login.php");
        exit();
    } elseif (isset($_POST['logout-no'])) {
        header("Location: dashboard.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<?php include 'includes/header.php'; ?>
<body>
    <div class="background"></div>
    <div class="foreground"></div>

    <div class="main-container">
        <div class="login-card animate-login">

            <!-- Welcome Banner -->
            <div class="welcome-banner fade-in" style="text-align: center;">
                <img src="images/head.png" alt="Logo" style="width: 60px; margin-bottom: 10px;">
                <div class="text">
                    <h2 style="margin: 0;">Exit the Playground</h2>
                    <p style="margin-top: 5px;">Are you sure you want to log out and leave the game?</p>
                </div>
            </div>

            <!-- Logout Confirmation Form -->
            <form method="post" style="margin-top: 30px; display: flex; justify-content: center; gap: 20px;">
                <button type="submit" name="logout-yes" class="btn-primary">Yes, log me out</button>
                <button type="submit" name="logout-no" class="btn-secondary">No, take me back</button>
            </form>

        </div>
    </div>

    <style>
        /* Tambahan style agar tombol konsisten dengan tema */
        .btn-primary, .btn-secondary {
            color: #fff;
            background: linear-gradient(90deg, #3fa7ff 0%, #1e3c72 100%);
            padding: 10px 32px;
            border-radius: 5px;
            border: none;
            font-size: 1em;
            font-weight: bold;
            box-shadow: 0 2px 8px rgba(63, 167, 255, 0.15);
            cursor: pointer;
            transition: background 0.3s, color 0.3s, transform 0.2s, box-shadow 0.2s;
            outline: none;
            position: relative;
            overflow: hidden;
        }
        .btn-secondary {
            background: linear-gradient(90deg, #1e3c72 0%, #3fa7ff 100%);
        }
        .btn-primary:hover, .btn-secondary:hover {
            background: linear-gradient(90deg, #1e3c72 0%, #3fa7ff 100%);
            color: #e0e6ed;
            transform: scale(1.08) rotate(-2deg);
            box-shadow: 0 4px 20px #3fa7ff55;
        }
        .btn-primary:focus, .btn-secondary:focus {
            box-shadow: 0 0 0 3px #3fa7ff77;
        }
    </style>
</body>
</html>
