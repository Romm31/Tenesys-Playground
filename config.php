<?php
// Informasi koneksi ke database hosting Anda
$servername = "";
$username   = "";
$password   = ""; // Pastikan ini password database Anda yang benar
$database   = "";

// Membuat koneksi dan menyimpannya di variabel $conn
$conn = new mysqli($servername, $username, $password, $database);

// Mengecek apakah koneksi berhasil
if ($conn->connect_error) {
    // Jika koneksi gagal, hentikan script dan tampilkan pesan error
    die("Koneksi ke database GAGAL: " . $conn->connect_error);
} 
?>