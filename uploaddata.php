<?php
include 'config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Data Bahan Baku</title>
    <link rel="stylesheet" href="style2.css">
    <link rel="stylesheet" href="datatabel/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="datatabel/css/jquery.dataTables.css">
</head>
<body>
    <?php include "home.php"; ?>
    <div class="content_uploaddata">
        <div class="header">
            <center>
                <h1>Kelola Data Bahan Baku</h1>
                <form method="post" enctype="multipart/form-data" action="import.php">
                    <input name="file" type="file" required="required"> 
                    <input name="upload" type="submit" value="Import">
                </form>
                <a href="delete.php" class="text-center">Hapus Semua</a>
            </center>
            <div class="container-main">
                <div class="slider-container">
                    <div class="slider" id="slider">
                        <?php
                        $bulanArray = ['jan', 'feb', 'mart', 'apr', 'mei', 'jun'];
                        $bulanLabel = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni'];

                        foreach ($bulanArray as $index => $bulan) {
                            ?>
                            <div class="slide">
                                <h2><?php echo $bulanLabel[$index]; ?></h2>
                                <table class="tabel data" id="table_<?php echo $bulan; ?>">
                                    <thead>
                                        <tr>
                                            <th scope="col">NAMA BAHAN BAKU</th>
                                            <th scope="col">MINGGU 1</th>
                                            <th scope="col">MINGGU 2</th>
                                            <th scope="col">MINGGU 3</th>
                                            <th scope="col">MINGGU 4</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $query = "SELECT bahan_baku, 
                                                     {$bulan}_minggu1, {$bulan}_minggu2, {$bulan}_minggu3, {$bulan}_minggu4 
                                              FROM upload_data";
                                        $select = mysqli_query($conn, $query);
                                        if (!$select) {
                                            echo "Error: " . mysqli_error($conn);
                                        } else {
                                            while ($data = mysqli_fetch_array($select)) {
                                                ?>
                                                <tr>
                                                    <td><?php echo $data['bahan_baku'] ?></td>
                                                    <td><?php echo $data["{$bulan}_minggu1"] ?></td>
                                                    <td><?php echo $data["{$bulan}_minggu2"] ?></td>
                                                    <td><?php echo $data["{$bulan}_minggu3"] ?></td>
                                                    <td><?php echo $data["{$bulan}_minggu4"] ?></td>
                                                </tr>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                    <button class="prev" onclick="changeSlide(-1)">&#10094;</button>
                    <button class="next" onclick="changeSlide(1)">&#10095;</button>
                </div>
            </div>
        </div>
    </div>
    <script src="datatabel/js/jquery-3.7.0.min.js"></script>
    <script src="datatabel/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.tabel.data').DataTable();

            let currentSlide = 0;
            showSlide(currentSlide);

            function showSlide(n) {
                const slides = document.getElementsByClassName("slide");
                if (n >= slides.length) {
                    currentSlide = 0;
                }
                if (n < 0) {
                    currentSlide = slides.length - 1;
                }
                for (let i = 0; i < slides.length; i++) {
                    slides[i].style.display = "none";
                }
                slides[currentSlide].style.display = "block";
            }

            window.changeSlide = function(n) {
                showSlide(currentSlide += n);
            };
        });
    </script>
</body>
</html>
