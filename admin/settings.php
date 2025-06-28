<?php
// Masuk ke folder utama untuk menemukan session.php
include '../session.php'; 

// Pastikan koneksi ada
if (!isset($conn)) {
    include '../config.php';
}

// --- LOGIKA UNTUK MENGUBAH NAMA ---
if (isset($_POST['change-name'])) {

    // Hanya proses jika input nama tidak kosong
    if (isset($_POST['username']) && !empty(trim($_POST['username']))) {
        
        $name = mysqli_real_escape_string($conn, $_POST['username']);
        $id = $login_user_id;
        
        $sql = "UPDATE users SET name = '$name' WHERE id = '$id'";
        
        if (mysqli_query($conn, $sql)) {
            // Jika berhasil, update juga session name agar langsung berubah di tampilan
            $_SESSION['name'] = $name;
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
if (isset($_POST['change-password'])) {
    
    $old_password = $_POST['old-password'];
    $new_password = $_POST['new-password'];
    $id = $login_user_id;

    // Ambil password saat ini dari database untuk verifikasi
    $sql_check = "SELECT password FROM users WHERE id = '$id'";
    $result = mysqli_query($conn, $sql_check);
    $row = mysqli_fetch_assoc($result);
    $current_password_in_db = $row['password'];

    // Karena proyek ini pakai teks biasa, kita bandingkan langsung
    if ($old_password == $current_password_in_db) {
        // Jika password lama cocok, update dengan password baru
        if (!empty($new_password)) {
            $new_password_escaped = mysqli_real_escape_string($conn, $new_password);
            $sql_update = "UPDATE users SET password = '$new_password_escaped' WHERE id = '$id'";
            mysqli_query($conn, $sql_update);
            header("Location: ../dashboard.php?p=settings&pass_update=success");
            exit();
        } else {
             header("Location: ../dashboard.php?p=settings&pass_update=empty");
             exit();
        }
    } else {
        // Jika password lama tidak cocok
        header("Location: ../dashboard.php?p=settings&pass_update=failed");
        exit();
    }
}

// Jika file diakses langsung, kembalikan ke halaman settings
header("Location: ../dashboard.php?p=settings");
exit();

?>