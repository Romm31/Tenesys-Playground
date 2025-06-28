<?php
require '../../admin_session.php';
require_once '../../config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_challenge'])) {
    $id = intval($_POST['id']);
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $desc = mysqli_real_escape_string($conn, $_POST['description']);
    $cat_id = intval($_POST['cat_id']);
    $score = intval($_POST['score']);
    $flag = mysqli_real_escape_string($conn, $_POST['flag']);

    $sql = "UPDATE challenges SET title = ?, description = ?, score = ?, cat_id = ?, flag = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssiisi", $title, $desc, $score, $cat_id, $flag, $id);

    if (mysqli_stmt_execute($stmt)) {
        header('Location: /admin.php?p=challenges&update=success');
        exit();
    } else {
        die("Update failed: " . mysqli_error($conn));
    }
}
?>
