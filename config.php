<?php
// Informasi koneksi ke database hosting Anda
$servername = "localhost";
$username   = "tenesysp_ctf";
$password   = "Xixixi123"; // Pastikan ini password database Anda yang benar
$database   = "tenesysp_ctf";

// Membuat koneksi dan menyimpannya di variabel $conn
$conn = new mysqli($servername, $username, $password, $database);

// Mengecek apakah koneksi berhasil
if ($conn->connect_error) {
    // Jika koneksi gagal, hentikan script dan tampilkan pesan error
    die("Koneksi ke database GAGAL: " . $conn->connect_error);
} 
?>