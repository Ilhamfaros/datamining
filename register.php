<?php

include 'config.php';

error_reporting(0);

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $cpassword = md5($_POST['cpassword']);
    $role = $_POST['role'];

    if ($password == $cpassword) {
        $sql = "SELECT * FROM users WHERE username='$username'";
        $result = mysqli_query($conn, $sql);
        if (!$result->num_rows > 0) {
            $sql = "INSERT INTO users (username, password, role)
                    VALUES ('$username', '$password', '$role')";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                echo "<script>alert('Registrasi Berhasil.')</script>";
                $username = "";
                $_POST['password'] = "";
                $_POST['cpassword'] = "";
                $_POST['role'] = "management"; // Atur default role ke "user"
            } else {
                echo "<script>alert('Ada Suatu Kesalahan.')</script>";
            }
        } else {
            echo "<script>alert('Username Sudah Terdaftar.')</script>";
        }

    } else {
        echo "<script>alert('Password Tidak Cocok')</script>";
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
	<title>Register Form</title>
</head>
<body>
    <div class="container">
        <form action="" method="POST" class="login-email">
            <!-- Formulir pendaftaran -->
            <div class="input-group">
                <input type="text" placeholder="Username" name="username" value="<?php echo $username; ?>" required>
            </div>
            <div class="input-group">
                <input type="password" placeholder="Password" name="password" value="<?php echo $_POST['password']; ?>" required>
            </div>
            <div class="input-group">
                <input type="password" placeholder="Confirm Password" name="cpassword" value="<?php echo $_POST['cpassword']; ?>" required>
            </div>
            <div class="input-group">
                <label for="role">Peran:</label>
                <select name="role" id="role">
                    <option value="admin">Admin</option>
                    <option value="management" selected>Management</option>
                </select>
            </div>
            <div class="input-group">
                <button name="submit" class="btn">Registrasi</button>
            </div>
        </form>
    </div>
</body>
</html>
