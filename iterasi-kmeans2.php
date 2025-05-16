<?php include 'config.php'
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iterasi K-Means</title>
    <link rel="stylesheet" href="style2.css">
    <link rel="stylesheet" href="jquery.dataTables.min.css">
      
</head>
<body>
   <?php
      include "home.php";
   ?>
   <div class="content_iterasi">
        <div class="header">
        <?php

// Fungsi untuk menghitung jarak Euclidean antara dua data
function euclideanDistance($point1, $point2) {
    $sum = 0;
    $dimensions = count($point1);
    for ($i = 0; $i < $dimensions; $i++) {
        $sum += pow($point1[$i] - $point2[$i], 2);
    }
    return sqrt($sum);
}

// Fungsi untuk menghitung pusat cluster baru berdasarkan data dalam cluster
function calculateNewCenters($clusters) {
    $newCenters = array();

    foreach ($clusters as $cluster) {
        $numPoints = count($cluster);
        $numDimensions = count($cluster[0]);

        $center = array_fill(0, $numDimensions, 0);

        foreach ($cluster as $point) {
            for ($i = 0; $i < $numDimensions; $i++) {
                $center[$i] += $point[$i];
            }
        }

        for ($i = 0; $i < $numDimensions; $i++) {
            $center[$i] /= $numPoints;
        }

        $newCenters[] = $center;
    }

    return $newCenters;
}

// Data nilai_pengetahuan, nilai_sikap, dan skor_iq
$data = array(
    array(80, 70, 85),
    array(95, 85, 90),
    array(75, 80, 70),
    array(90, 80, 80),
    array(85, 75, 95),
    array(70, 90, 75)
);

// K-means parameters
$k = 3; // Jumlah cluster yang diinginkan
$max_iters = 10; // Jumlah maksimum iterasi

// Inisialisasi pusat cluster secara acak
$centers = array();
for ($i = 0; $i < $k; $i++) {
    $centers[] = $data[array_rand($data)];
}

// Iterasi K-means
$iterationResults = array(); // Menyimpan hasil iterasi
for ($iter = 0; $iter < $max_iters; $iter++) {
    // Inisialisasi clusters
    $clusters = array();
    for ($i = 0; $i < $k; $i++) {
        $clusters[$i] = array();
    }

    // Assign data ke cluster berdasarkan jarak terdekat dengan pusat cluster
    foreach ($data as $point) {
        $distances = array();
        foreach ($centers as $center) {
            $distances[] = euclideanDistance($point, $center);
        }

        $minDistance = min($distances);
        $clusterIndex = array_search($minDistance, $distances);
        $clusters[$clusterIndex][] = $point;
    }

    // Menghitung pusat cluster baru
    $newCenters = calculateNewCenters($clusters);

    // Menyimpan hasil iterasi
    $iterationResults[] = array(
        'iteration' => $iter + 1,
        'clusters' => $clusters,
        'centers' => $newCenters
    );

    // Jika pusat cluster tidak berubah, iterasi dihentikan
    if ($centers === $newCenters) {
        break;
    }

    $centers = $newCenters;
}

// Menampilkan hasil iterasi dalam bentuk tabel
echo "<table>";
echo "<thead>";
echo "<tr>";
echo "<th>Iterasi</th>";
echo "<th>Cluster 1</th>";
echo "<th>Cluster 2</th>";
echo "<th>Cluster 3</th>";
echo "</tr>";
echo "</thead>";
echo "<tbody>";
foreach ($iterationResults as $result) {
    echo "<tr>";
    echo "<td>" . $result['iteration'] . "</td>";
    foreach ($result['clusters'] as $cluster) {
        echo "<td>";
        foreach ($cluster as $point) {
            echo "Nilai Pengetahuan: " . $point[0] . "<br>";
            echo "Nilai Sikap: " . $point[1] . "<br>";
            echo "Skor IQ: " . $point[2] . "<br>";
            echo "<br>";
        }
        echo "</td>";
    }
    echo "</tr>";
}
echo "</tbody>";
echo "</table>";

?>

      </div>
     </div>
   <script src="jquery-3.5.1.min.js"></script>
   <script src="jquery.dataTables.min.js"></script>
   <script>
      $(document).ready(function () {
        $('#myTable').DataTable({
        scrollX: true,
        scrollY: '800px',
        scrollCollapse: true,
          });
      });
    </script> 

</body>
</html>