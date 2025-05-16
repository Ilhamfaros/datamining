<?php
include 'config.php';


$bahan_baku = $_POST['bahan_baku'];
$jan = $_POST['jan'];
$feb = $_POST['feb'];
$mart = $_POST['mart'];
$apr = $_POST['apr'];
$mei = $_POST['mei'];
$jun = $_POST['jun'];

// Melakukan update data
$query = "UPDATE upload_data SET 
            bahan_baku='$bahan_baku', 
            jan='$jan', 
            feb='$feb', 
            mart='$mart', 
            apr='$apr', 
            mei='$mei', 
            jun='$jun' 
          WHERE id='$id'";

if (mysqli_query($conn, $query)) {
    $message = "Berhasil Mengedit data";
} else {
    $message = "Gagal mengedit data: " . mysqli_error($conn);
}

mysqli_close($conn);

echo "<script>
        alert('$message');
        window.location.href='your_page.php'; // Ganti dengan nama halaman Anda
      </script>";
?>
