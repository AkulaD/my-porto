<?php 
$server = "localhost";
$username = "root";
$password = "";
$database = "command_center";

// Membuat koneksi
$conn = mysqli_connect($server, $username, $password, $database);

// Memeriksa koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
