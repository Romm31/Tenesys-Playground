<?php
require_once '../../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Cek apakah challenge ada
    $check_sql = "SELECT id FROM challenges WHERE id = $id LIMIT 1";
    $check_result = mysqli_query($conn, $check_sql);

    if (mysqli_num_rows($check_result) === 0) {
        $message = 'Challenge not found.';
    } else {
        // Hapus challenge
        $delete_sql = "DELETE FROM challenges WHERE id = $id";
        if (mysqli_query($conn, $delete_sql)) {
            $message = 'Challenge deleted successfully.';
        } else {
            $message = 'Failed to delete challenge.';
        }
    }
} else {
    $message = 'Invalid request.';
}

// Redirect balik ke halaman admin/challenges.php dengan alert
echo "<script>
    alert('$message');
    window.location.href = '/admin.php?p=challenges';
</script>";
exit;
