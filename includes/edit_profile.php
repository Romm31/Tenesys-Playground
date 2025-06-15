<?php
// Masuk ke folder utama untuk menemukan session.php dan config.php
include '../session.php';
if (!isset($conn)) {
    include '../config.php';
}

// --- LOGIKA UNTUK MENGUBAH NAMA ---
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['change-name'])) {

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
            header("Location: ../dashboard.php?p=settings&update=success");
            exit();
        } else {
            header("Location: ../dashboard.php?p=settings&update=error");
            exit();
        }

    } else {
        // Jika nama dikosongkan, jangan lakukan apa-apa, langsung kembali
        header("Location: ../dashboard.php?p=settings&update=empty");
        exit();
    }
} 
// --- LOGIKA UNTUK MENGUBAH PASSWORD ---
else if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['change-password'])) {

    if(isset($_POST['old-password']) && isset($_POST['new-password']) && !empty($_POST['new-password'])) {

        $old_password = $_POST['old-password'];
        $new_password = $_POST['new-password'];
        $id = $login_user_id;

        // Ambil password saat ini dari database untuk verifikasi
        $sql_check = "SELECT password FROM users WHERE id = ?";
        $stmt_check = mysqli_prepare($conn, $sql_check);
        mysqli_stmt_bind_param($stmt_check, "i", $id);
        mysqli_stmt_execute($stmt_check);
        $result = mysqli_stmt_get_result($stmt_check);
        $row = mysqli_fetch_assoc($result);
        $current_password_in_db = $row['password'];

        // Karena proyek ini pakai teks biasa, kita bandingkan langsung
        if ($old_password == $current_password_in_db) {
            // Jika password lama cocok, update dengan password baru
            $new_password_escaped = mysqli_real_escape_string($conn, $new_password);
            $sql_update = "UPDATE users SET password = ? WHERE id = ?";
            $stmt_update = mysqli_prepare($conn, $sql_update);
            mysqli_stmt_bind_param($stmt_update, "si", $new_password_escaped, $id);
            mysqli_stmt_execute($stmt_update);

            header("Location: ../dashboard.php?p=settings&pass_update=success");
            exit();
        } else {
            // Jika password lama tidak cocok
            header("Location: ../dashboard.php?p=settings&pass_update=failed");
            exit();
        }
    } else {
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