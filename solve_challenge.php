<?php
header('Content-Type: application/json'); // Memberitahu browser bahwa outputnya adalah JSON
include 'config.php';

// Fungsi untuk mengirim respons JSON dan menghentikan skrip
function send_response($status, $message) {
    echo json_encode(['status' => $status, 'message' => $message]);
    exit();
}

// Mengambil data JSON dari body request
$data = json_decode(file_get_contents("php://input"), true);

// 1. Validasi Input Awal
if (!isset($data['cid']) || !isset($data['userid']) || !isset($data['flag'])) {
    send_response(400, "Parameter tidak lengkap (cid, userid, flag dibutuhkan).");
}

$challenge_id = $data['cid'];
$user_id = $data['userid'];
$user_flag = $data['flag'];

// 2. Cek apakah challenge sudah pernah diselesaikan oleh user ini
$sql_check_solved = "SELECT s_id FROM scoreboard WHERE c_id = ? AND user_id = ?";
$stmt_check_solved = mysqli_prepare($conn, $sql_check_solved);
mysqli_stmt_bind_param($stmt_check_solved, "ii", $challenge_id, $user_id);
mysqli_stmt_execute($stmt_check_solved);
$result_check_solved = mysqli_stmt_get_result($stmt_check_solved);

if (mysqli_num_rows($result_check_solved) > 0) {
    send_response(200, "Solved");
}
mysqli_stmt_close($stmt_check_solved);

// 3. Ambil flag dan skor yang benar dari database
$sql_get_challenge = "SELECT flag, score FROM challenges WHERE id = ?";
$stmt_get_challenge = mysqli_prepare($conn, $sql_get_challenge);
mysqli_stmt_bind_param($stmt_get_challenge, "i", $challenge_id);
mysqli_stmt_execute($stmt_get_challenge);
$result_challenge = mysqli_stmt_get_result($stmt_get_challenge);

if (mysqli_num_rows($result_challenge) === 0) {
    send_response(404, "Challenge not found");
}

$challenge_data = mysqli_fetch_assoc($result_challenge);
$correct_flag = $challenge_data['flag'];
$challenge_score = $challenge_data['score'];
mysqli_stmt_close($stmt_get_challenge);

// 4. Bandingkan flag (case-insensitive)
if (strcasecmp($user_flag, $correct_flag) === 0) {
    // Jika Flag BENAR
    
    // a. Masukkan data ke tabel scoreboard
    $sql_insert_scoreboard = "INSERT INTO scoreboard (user_id, c_id) VALUES (?, ?)";
    $stmt_insert_scoreboard = mysqli_prepare($conn, $sql_insert_scoreboard);
    mysqli_stmt_bind_param($stmt_insert_scoreboard, "ii", $user_id, $challenge_id);
    mysqli_stmt_execute($stmt_insert_scoreboard);
    mysqli_stmt_close($stmt_insert_scoreboard);

    // b. Update total skor di tabel users (FITUR BARU)
    $sql_update_score = "UPDATE users SET score = score + ? WHERE id = ?";
    $stmt_update_score = mysqli_prepare($conn, $sql_update_score);
    mysqli_stmt_bind_param($stmt_update_score, "ii", $challenge_score, $user_id);
    mysqli_stmt_execute($stmt_update_score);
    mysqli_stmt_close($stmt_update_score);

    send_response(200, "Correct!");

} else {
    // Jika Flag SALAH
    send_response(400, "Incorrect!");
}

?>