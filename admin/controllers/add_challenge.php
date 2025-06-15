<?php 
    require '../../admin_session.php';
    require_once '../../config.php';

    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_challenge'])) {

        $ch_name = mysqli_real_escape_string($conn, $_POST['title']);
        $ch_desc = mysqli_real_escape_string($conn, $_POST['description']);
        $ch_cat_id = mysqli_real_escape_string($conn, $_POST['cat_id']);
        $ch_score = mysqli_real_escape_string($conn, $_POST['score']);
        $ch_flag = mysqli_real_escape_string($conn, $_POST['flag']);

        // Query INSERT yang lebih aman dengan prepared statements
        $sql = "INSERT INTO challenges (title, description, score, cat_id, flag) VALUES (?, ?, ?, ?, ?)";
        
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssiis", $ch_name, $ch_desc, $ch_score, $ch_cat_id, $ch_flag);
        
        if(mysqli_stmt_execute($stmt)) {
            // --- INI BAGIAN YANG DIPERBAIKI ---
            // Menghapus /anton/ dari path redirect
            header('Location: /admin.php?p=challenges&add=success');
            exit(); // Menambahkan exit() setelah redirect adalah praktik terbaik
        } else {
            die("Error: " . mysqli_error($conn));
        }
    }
?>