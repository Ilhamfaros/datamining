<?php

include 'config.php';

session_start();

error_reporting(0);

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = md5($_POST['password']);

    $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $sql);
    if ($result->num_rows > 0) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['username'] = $row['username'];
        $_SESSION['role'] = $row['role']; // Menyimpan peran (role) pengguna dalam sesi
        if ($row['role'] == 'admin') {
            header("Location: home-admin.php");
        } else if ($row['role'] == 'management') {
            header("Location: home.php");
        }
    } else {
        echo "<script>alert('Perhatian: Username Atau Password anda Salah.')</script>";
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Warung Nasi Tugu Oncom</title>
    <link rel="icon" href="logo.ico" type="image/x-icon">

</head>
<body>
    <div class="container">
        <div class="logo">
            <img src="logo.png" alt="Image" height="180" width="190">
        </div>
        <div class="login-wrapper">
            <form action="" method="POST" class="login-email">
                <p class="login-text" style="font-size: 2rem; font-weight: 800;">LOGIN</p>
                <div class="input-group">
                    <input type="username" placeholder="username" name="username" value="<?php echo $username; ?>" required>
                </div>
                <div class="input-group">
                    <input type="password" placeholder="Password" name="password" value="<?php echo $_POST['password']; ?>" required>
                </div>
                <div class="input-group">
                    <button name="submit" class="btn">Login</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
