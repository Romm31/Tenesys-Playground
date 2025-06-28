<?php
include '../session.php';
if (!isset($conn)) {
    include '../config.php';
}

// --- LOGIKA UNTUK MENGUBAH NAMA ---
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['change-name'])) {

    if (isset($_POST['username']) && !empty(trim($_POST['username']))) {
        $change_name = mysqli_real_escape_string($conn, $_POST['username']);
        $id = $login_user_id;

        $sql = "UPDATE users SET name = ? WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "si", $change_name, $id);

        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['name'] = $change_name;
            header("Location: ../dashboard.php?p=settings&update=success");
            exit();
        } else {
            header("Location: ../dashboard.php?p=settings&update=error");
            exit();
        }
    } else {
        header("Location: ../dashboard.php?p=settings&update=empty");
        exit();
    }
}

// --- LOGIKA UNTUK MENGUBAH PASSWORD ---
else if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['change-password'])) {

    if (
        isset($_POST['old-password']) &&
        isset($_POST['new-password']) &&
        !empty($_POST['new-password'])
    ) {
        $old_password = $_POST['old-password'];
        $new_password = $_POST['new-password'];
        $id = $login_user_id;

        // Ambil password hash dari database
        $sql_check = "SELECT password FROM users WHERE id = ?";
        $stmt_check = mysqli_prepare($conn, $sql_check);
        mysqli_stmt_bind_param($stmt_check, "i", $id);
        mysqli_stmt_execute($stmt_check);
        $result = mysqli_stmt_get_result($stmt_check);
        $row = mysqli_fetch_assoc($result);

        if ($row && password_verify($old_password, $row['password'])) {
            // Password cocok, hash password baru
            $hashed_new = password_hash($new_password, PASSWORD_DEFAULT);

            $sql_update = "UPDATE users SET password = ? WHERE id = ?";
            $stmt_update = mysqli_prepare($conn, $sql_update);
            mysqli_stmt_bind_param($stmt_update, "si", $hashed_new, $id);
            mysqli_stmt_execute($stmt_update);

            header("Location: ../dashboard.php?p=settings&pass_update=success");
            exit();
        } else {
            header("Location: ../dashboard.php?p=settings&pass_update=failed");
            exit();
        }
    } else {
        header("Location: ../dashboard.php?p=settings&pass_update=empty");
        exit();
    }
}

// --- Jika tidak valid ---
else {
    header("Location: ../dashboard.php?p=settings");
    exit();
}
