<?php
<<<<<<< HEAD
=======
// Masuk ke folder utama untuk menemukan session.php dan config.php
>>>>>>> 219c0d84be18af48f1d4c831999d5e6e4aa0e12c
include '../session.php';
if (!isset($conn)) {
    include '../config.php';
}

// --- LOGIKA UNTUK MENGUBAH NAMA ---
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['change-name'])) {

<<<<<<< HEAD
    if (isset($_POST['username']) && !empty(trim($_POST['username']))) {
        $change_name = mysqli_real_escape_string($conn, $_POST['username']);
        $id = $login_user_id;

        $sql = "UPDATE users SET name = ? WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "si", $change_name, $id);

        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['name'] = $change_name;
=======
    // Hanya proses jika input nama ada dan tidak kosong
    if (isset($_POST['username']) && !empty(trim($_POST['username']))) {
        
        // Menggunakan fungsi yang benar: mysqli_real_escape_string($conn, ...)
        $change_name = mysqli_real_escape_string($conn, $_POST['username']);
        $id = $login_user_id;
        
        $sql = "UPDATE users SET name = ? WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "si", $change_name, $id);
        
        if (mysqli_stmt_execute($stmt)) {
            // Jika berhasil, update juga session name agar langsung berubah di tampilan
            $_SESSION['name'] = $change_name;
            // Redirect ke path yang benar
>>>>>>> 219c0d84be18af48f1d4c831999d5e6e4aa0e12c
            header("Location: ../dashboard.php?p=settings&update=success");
            exit();
        } else {
            header("Location: ../dashboard.php?p=settings&update=error");
            exit();
        }
<<<<<<< HEAD
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
=======

    } else {
        // Jika nama dikosongkan, jangan lakukan apa-apa, langsung kembali
        header("Location: ../dashboard.php?p=settings&update=empty");
        exit();
    }
} 
// --- LOGIKA UNTUK MENGUBAH PASSWORD ---
else if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['change-password'])) {

    if(isset($_POST['old-password']) && isset($_POST['new-password']) && !empty($_POST['new-password'])) {

>>>>>>> 219c0d84be18af48f1d4c831999d5e6e4aa0e12c
        $old_password = $_POST['old-password'];
        $new_password = $_POST['new-password'];
        $id = $login_user_id;

<<<<<<< HEAD
        // Ambil password hash dari database
=======
        // Ambil password saat ini dari database untuk verifikasi
>>>>>>> 219c0d84be18af48f1d4c831999d5e6e4aa0e12c
        $sql_check = "SELECT password FROM users WHERE id = ?";
        $stmt_check = mysqli_prepare($conn, $sql_check);
        mysqli_stmt_bind_param($stmt_check, "i", $id);
        mysqli_stmt_execute($stmt_check);
        $result = mysqli_stmt_get_result($stmt_check);
        $row = mysqli_fetch_assoc($result);
<<<<<<< HEAD

        if ($row && password_verify($old_password, $row['password'])) {
            // Password cocok, hash password baru
            $hashed_new = password_hash($new_password, PASSWORD_DEFAULT);

            $sql_update = "UPDATE users SET password = ? WHERE id = ?";
            $stmt_update = mysqli_prepare($conn, $sql_update);
            mysqli_stmt_bind_param($stmt_update, "si", $hashed_new, $id);
=======
        $current_password_in_db = $row['password'];

        // Karena proyek ini pakai teks biasa, kita bandingkan langsung
        if ($old_password == $current_password_in_db) {
            // Jika password lama cocok, update dengan password baru
            $new_password_escaped = mysqli_real_escape_string($conn, $new_password);
            $sql_update = "UPDATE users SET password = ? WHERE id = ?";
            $stmt_update = mysqli_prepare($conn, $sql_update);
            mysqli_stmt_bind_param($stmt_update, "si", $new_password_escaped, $id);
>>>>>>> 219c0d84be18af48f1d4c831999d5e6e4aa0e12c
            mysqli_stmt_execute($stmt_update);

            header("Location: ../dashboard.php?p=settings&pass_update=success");
            exit();
        } else {
<<<<<<< HEAD
=======
            // Jika password lama tidak cocok
>>>>>>> 219c0d84be18af48f1d4c831999d5e6e4aa0e12c
            header("Location: ../dashboard.php?p=settings&pass_update=failed");
            exit();
        }
    } else {
<<<<<<< HEAD
        header("Location: ../dashboard.php?p=settings&pass_update=empty");
        exit();
    }
}

// --- Jika tidak valid ---
else {
    header("Location: ../dashboard.php?p=settings");
    exit();
}
=======
        // Jika password baru kosong
        header("Location: ../dashboard.php?p=settings&pass_update=empty");
        exit();
    }
} 
else {
    // Jika file diakses langsung, kembalikan ke halaman settings
    header("Location: ../dashboard.php?p=settings");
    exit();
}
?>
>>>>>>> 219c0d84be18af48f1d4c831999d5e6e4aa0e12c
