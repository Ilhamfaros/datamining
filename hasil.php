
<?php
include('config.php');

// Fungsi untuk menghitung jarak Euclidean antara dua titik
function hitungJarak($dataPoint, $centroid, $bulan) {
    return sqrt(
        pow(($centroid['jm1'] - $dataPoint["{$bulan}_minggu1"]), 2) + 
        pow(($centroid['jm2'] - $dataPoint["{$bulan}_minggu2"]), 2) + 
        pow(($centroid['jm3'] - $dataPoint["{$bulan}_minggu3"]), 2) + 
        pow(($centroid['jm4'] - $dataPoint["{$bulan}_minggu4"]), 2)
    );
}

// Fungsi untuk menentukan centroid terdekat dari sebuah data
function cariCentroidTerdekat($data, $centroids, $bulan) {
    $jarakTerdekat = INF;
    $centroidTerdekat = 0;

    foreach ($centroids as $index => $centroid) {
        $jarak = hitungJarak($data, $centroid, $bulan);

        if ($jarak < $jarakTerdekat) {
            $jarakTerdekat = $jarak;
            $centroidTerdekat = $index;
        }
    }

    return $centroidTerdekat;
}

// Data awal
$data = [];
$select = mysqli_query($conn, "SELECT * FROM upload_data");
while ($row = mysqli_fetch_assoc($select)) {
    $row['jarak'] = INF; // Inisialisasi jarak ke centroid
    $data[] = $row;
}

// Inisialisasi centroid awal
$initialCentroids = [
    ['jm1' => 84, 'jm2' => 82, 'jm3' => 62, 'jm4' => 141], // Centroid awal
    ['jm1' => 127, 'jm2' => 96, 'jm3' => 91, 'jm4' => 214],
    ['jm1' => 217, 'jm2' => 305, 'jm3' => 385, 'jm4' => 490],
];

// Jumlah iterasi
$jumlahIterasi = 8;

// Proses iterasi K-means untuk setiap bulan
$bulanArray = ['jan', 'feb', 'mart', 'apr', 'mei', 'jun'];
$clusterResults = [];

foreach ($bulanArray as $bulan) {
    // Salin centroid awal untuk setiap bulan
    $centroids = $initialCentroids;
    
    for ($i = 0; $i < $jumlahIterasi; $i++) {
        // Inisialisasi cluster
        $clusters = [];
        foreach ($centroids as $index => $centroid) {
            $clusters[$index] = [];
        }

        // Assign data ke centroid terdekat dan hitung jarak
        foreach ($data as $dataPointIndex => $dataPoint) {
            $centroidIndex = cariCentroidTerdekat($dataPoint, $centroids, $bulan);
            $clusters[$centroidIndex][] = $dataPointIndex; // Simpan index data pada cluster
        }

        // Hitung centroid baru
        foreach ($clusters as $index => $cluster) {
            $jumlahData = count($cluster);
            $sumJM1 = 0;
            $sumJM2 = 0;
            $sumJM3 = 0;
            $sumJM4 = 0;

            foreach ($cluster as $dataPointIndex) {
                $dataPoint = $data[$dataPointIndex];
                $sumJM1 += $dataPoint["{$bulan}_minggu1"];
                $sumJM2 += $dataPoint["{$bulan}_minggu2"];
                $sumJM3 += $dataPoint["{$bulan}_minggu3"];
                $sumJM4 += $dataPoint["{$bulan}_minggu4"];
            }

            if ($jumlahData > 0) {
                $centroids[$index]['jm1'] = $sumJM1 / $jumlahData;
                $centroids[$index]['jm2'] = $sumJM2 / $jumlahData;
                $centroids[$index]['jm3'] = $sumJM3 / $jumlahData;
                $centroids[$index]['jm4'] = $sumJM4 / $jumlahData;
            }
        }
    }

    // Simpan hasil cluster untuk setiap bulan
    foreach ($data as $dataPointIndex => $dataPoint) {
        $centroidIndex = cariCentroidTerdekat($dataPoint, $centroids, $bulan);
        $clusterResults[$dataPointIndex][$bulan] = $centroidIndex + 1; // Cluster index starts at 1
    }
}

// Menghitung rata-rata cluster untuk tiap bahan baku
$averageClusterResults = [];
foreach ($data as $dataPointIndex => $dataPoint) {
    $totalCluster = 0;
    $bulanCount = count($bulanArray);

    foreach ($bulanArray as $bulan) {
        $totalCluster += $clusterResults[$dataPointIndex][$bulan];
    }

    // Hitung rata-rata dan simpan hasil
    $averageCluster = round($totalCluster / $bulanCount);
    $averageClusterResults[$dataPointIndex] = $averageCluster;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Cluster Tiap Bulan</title>
    <link rel="stylesheet" href="style2.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.dataTables.min.css">
</head>
<body>
    <?php include "home.php"; ?>
    <div class="content_iterasi">
        <div class="header">
            <main>
                <h2>Hasil Cluster Tiap Bulan</h2>
                <table class="tabel data" id="hasilClusterTable">
                    <thead>
                        <tr>
                            <th scope="col">Nama Bahan Baku</th>
                            <th scope="col">Januari Cluster</th>
                            <th scope="col">Februari Cluster</th>
                            <th scope="col">Maret Cluster</th>
                            <th scope="col">April Cluster</th>
                            <th scope="col">Mei Cluster</th>
                            <th scope="col">Juni Cluster</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($data as $dataPointIndex => $dataPoint) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($dataPoint['bahan_baku']) . "</td>";

                            foreach ($bulanArray as $bulan) {
                                $clusterLabel = "Cluster " . htmlspecialchars($clusterResults[$dataPointIndex][$bulan]);
                                echo "<td>" . $clusterLabel . "</td>";
                            }

                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>

                <div class="keterangan-cluster">
                <p><strong>Cluster 1 Merupakan kelompok bahan baku persedian Non Prioritas </strong></p>
                <p><strong>Cluster 2 Merupakan kelompok bahan baku persedian Menengah </strong></p>
                <p><strong>Cluster 3 Merupakan kelompok bahan baku persedian prioritas. </strong> </p>
            </div>

            <br><br>
                <h2>Hasil Rata-Rata Cluster Bahan Baku</h2>
                <table class="tabel data" id="averageClusterTable">
                    <thead>
                        <tr>
                            <th scope="col">Nama Bahan Baku</th>
                            <th scope="col">Rata-Rata Cluster</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($data as $dataPointIndex => $dataPoint) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($dataPoint['bahan_baku']) . "</td>";
                            echo "<td>Cluster " . htmlspecialchars($averageClusterResults[$dataPointIndex]) . "</td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>


                <br><br>
                <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
                <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
                <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
                <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.flash.min.js"></script>
                <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.exel.min.js"></script>
            <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
            <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
                <script>
                    $(document).ready(function() {
                        $('#hasilClusterTable').DataTable({
                            responsive: true,
                            dom: 'Bfrtip',
                            buttons: [
                                'excel',
                                'print'
                            ]
                        });
                   
                        $('#averageClusterTable').DataTable({
                            responsive: true,
                            dom: 'Bfrtip',
                            buttons: [
                                'excel',
                                'print'
                            ]
                        });
                    });
                </script>
            </main>
        </div>
    </div>
</body>
</html>
