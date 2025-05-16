<?php

session_start();

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
}
if ($_SESSION['role'] !== 'admin') {
   echo "<script>alert('Anda tidak memiliki izin untuk mengakses halaman ini.')</script>";
   header("Location: home-admin.php");
}

?>

<!DOCTYPE html>
<html lang="en">
 <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Warung Tutug Oncom</title>
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="style2.css">
  </head>
  <body>
      <header>
       <div class="container">
         <span>Sistem Prediksi Bahan baku</span>
       </div>
      </header>
      
      <nav class="sidebar" style="overflow-y:  height: 100%;">
         <div class="text">
            <div class="image">
               <img src="logo.png" alt="Image" style="height: 70px; width: 75px; margin-top: 10px;">
            </div><h3>Warung Nasi Tutug Oncom</h3>
            
         </div>
         <div class="content">
            
         </div>
         <ul>
            <li class="active"><a href="dashboard-admin.php"><i class="fa-solid fa-house" style="color: #ffffff;"></i> Dashboard</a></li>
            <li>
               <a href="kelola-admin.php" class="feat-btn"><i class="fa-solid fa-users-gear" style="color: #ffffff;"></i> Kelola Admin</a>
            </li>
            <li>
               <a href="logout.php" class="feed-btn"><i class="fa-solid fa-right-from-bracket" style="color: #ffffff;"></i>  Logout</a>
            </li>
         </ul>
      </nav>
     
    <script>
         $('.btn').click(function(){
            $(this).toggleClass("click");
            $('.sidebar').toggleClass("show");
            });

           $('.feat-btn').click(function(){
             $('nav ul .feat-show').toggleClass("show");
             $('nav ul .first').toggleClass("rotate");
           });
           $('.serv-btn').click(function(){
             $('nav ul .serv-show').toggleClass("show1");
             $('nav ul .second').toggleClass("rotate");
           });
           $('.prot-btn').click(function(){
            $('nav ul .prot-show').toggleClass("show2");
            $('nav ul .third').toggleClass('rotate');
           });
      </script>

  </body>  

</html>