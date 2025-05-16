<?php

include 'config.php';

if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    // Pastikan bahwa pengguna dengan peran 'admin' tidak bisa dihapus
    $sql = "DELETE FROM users WHERE id = '$delete_id' AND role = 'user'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        echo "<script>alert('Pengguna berhasil dihapus.')</script>";
    } else {
        echo "<script>alert('Gagal menghapus pengguna.')</script>";
    }
}

$sql = "SELECT * FROM users";
$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Admin</title>
    <link rel="stylesheet" href="style2.css">
    <link rel="stylesheet" href="datatabel/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="datatabel/css/jquery.dataTables.css">
</head>
<body>
    <?php
      include "home-admin.php";
    ?>
    <div class="content_uploaddata">
        <center>
        <h1>KELOLA SEMUA USER</h1>
        </center>
        <table class="tabel data" id="userTable">
            <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Role</th>
                <th>Aksi</th>
            </tr>
            </thead>
            <tbody>
            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['username'] . "</td>";
                    echo "<td>" . $row['role'] . "</td>";
                    echo "<td><a href=\"?delete_id=" . $row['id'] . "\">Hapus</a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>Tidak ada data pengguna.</td></tr>";
            }?>
            </tbody>
        </table>
    <a href="register.php"><button>Registrasi</button></a>
    </div>

    <script src="datatabel/js/jquery-3.7.0.min.js"></script>
   <script src="datatabel/js/jquery.dataTables.min.js"></script>
   <script>
new DataTable('#userTable');
    </script> 

</body>
</html>
