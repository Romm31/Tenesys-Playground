<?php 
    require '../../admin_session.php';
    require_once '../../config.php';

    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_category'])) {

        $cat_name = mysqli_real_escape_string($conn,$_POST['title']);
        $sql = "insert into category (name) values (\"".$cat_name."\")";
        
        if(! $conn ) {
            die('Could not connect: ' . mysqli_error());
        }

        $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
        
        // --- INI BAGIAN YANG DIPERBAIKI ---
        // Menghapus /anton/ dari path redirect agar sesuai dengan lokasi file Anda
        header('Location: /admin.php?p=categories&add=success');
        exit(); // Menambahkan exit() setelah redirect adalah praktik terbaik
    }
?>