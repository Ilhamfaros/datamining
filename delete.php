<?php
// Konfigurasi koneksi ke database
$server = "localhost";
$user = "root";
$pass = "";
$database = "datamining";

// Membuat koneksi ke database
$conn = new mysqli($server, $user, $pass, $database);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi ke database gagal: " . $conn->connect_error);
}

// Query untuk menghapus semua data
$query = "DELETE FROM upload_data";

if ($conn->query($query) === TRUE) {
    echo "Semua data berhasil dihapus.";
} else {
    echo "Error: " . $query . "<br>" . $conn->error;
}

// Menutup koneksi
$conn->close();
unlink($_FILES['file']['name']); 
header("location: uploaddata.php");
?>
