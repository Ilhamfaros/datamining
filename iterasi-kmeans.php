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

// Inisialisasi centroid awal (sesuai dengan hasil sebelumnya)
$centroids = [
    ['jm1' => 84, 'jm2' => 82, 'jm3' => 62, 'jm4' => 141], // Centroid awal
    ['jm1' => 127, 'jm2' => 96, 'jm3' => 91, 'jm4' => 214],
    ['jm1' => 217, 'jm2' => 305, 'jm3' => 385, 'jm4' => 490],
];

// Jumlah iterasi
$jumlahIterasi = 8;

// Cek apakah ada bulan yang dipilih
if (isset($_GET['bulan'])) {
    $bulan = $_GET['bulan'];

    // Proses iterasi K-means
    $iterasiData = [];
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
            $jarak = hitungJarak($dataPoint, $centroids[$centroidIndex], $bulan);
            $data[$dataPointIndex]['jarak'] = $jarak; // Simpan jarak pada data

            $iterasiData[$i][] = [
                'Data' => $dataPointIndex + 1,
                'Jarak ke Centroid' => $jarak,
                'Cluster' => 'Cluster ' . ($centroidIndex + 1) // Cluster index starts at 1
            ];
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
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iterasi K-Means</title>
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
                <div class="container-main">
                    <!-- Dropdown Pilihan Bulan -->
                    <form method="get">
                        <label for="bulan">Pilih Bulan:</label>
                        <select name="bulan" id="bulan">
                            <option value="jan">Januari</option>
                            <option value="feb">Februari</option>
                            <option value="mart">Maret</option>
                            <option value="apr">April</option>
                            <option value="mei">Mei</option>
                            <option value="jun">Juni</option>
                        </select>
                        <button type="submit">Lihat Data</button>
                    </form>

                    <!-- Tabel untuk hasil semua cluster -->
                    <table class="tabel data" id="clusterTable">
                        <thead>
                            <tr>
                                <th scope="col">Nama Bahan Baku</th>
                                <th scope="col">Minggu 1</th>
                                <th scope="col">Minggu 2</th>
                                <th scope="col">Minggu 3</th>
                                <th scope="col">Minggu 4</th>
                                <th scope="col">Jarak</th>
                                <th scope="col">Cluster</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (isset($bulan)) {
                                foreach ($data as $dataPointIndex => $dataPoint) {
                                    $centroidIndex = cariCentroidTerdekat($dataPoint, $centroids, $bulan);
                                    $clusterLabel = "Cluster " . ($centroidIndex + 1); // Cluster index starts at 1
                                    echo "<tr>";
                                    echo "<td>" . htmlspecialchars($dataPoint['bahan_baku']) . "</td>";
                                    echo "<td>" . htmlspecialchars($dataPoint["{$bulan}_minggu1"]) . "</td>";
                                    echo "<td>" . htmlspecialchars($dataPoint["{$bulan}_minggu2"]) . "</td>";
                                    echo "<td>" . htmlspecialchars($dataPoint["{$bulan}_minggu3"]) . "</td>";
                                    echo "<td>" . htmlspecialchars($dataPoint["{$bulan}_minggu4"]) . "</td>";
                                    echo "<td>" . htmlspecialchars($dataPoint['jarak']) . "</td>";
                                    echo "<td>" . htmlspecialchars($clusterLabel) . "</td>";
                                    echo "</tr>";
                                }
                            }
                            ?>
                        </tbody>
                    </table>

                    <br><br>

                    <!-- Tabel untuk hasil iterasi -->
                    <table class="tabel data" id="iterasiTable">
                        <thead>
                            <tr>
                                <th scope="col">Iterasi</th>
                                <th scope="col">Data</th>
                                <th scope="col">Jarak ke Centroid</th>
                                <th scope="col">Cluster</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($iterasiData)) : ?>
                                <?php foreach ($iterasiData as $iterasiIndex => $iterasi) : ?>
                                    <?php foreach ($iterasi as $data) : ?>
                                        <tr>
                                            <td>Iterasi <?php echo $iterasiIndex + 1; ?></td>
                                            <td>Data <?php echo $data['Data']; ?></td>
                                            <td><?php echo number_format($data['Jarak ke Centroid'], 2); ?></td>
                                            <td><?php echo $data['Cluster']; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>

                    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
                    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
                    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
                    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.flash.min.js"></script>
                    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
                    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
                    <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
                    <script>
                // Menginisialisasi DataTables untuk Cluster Table dan Iterasi Table
                $(document).ready(function() {
                    $('#clusterTable').DataTable({
                        responsive: true,
                        dom: 'Bfrtip',
                        buttons: [
                            'excel', 'print'
                        ]
                    });
                   });
                    $(document).ready(function() {
                    $('#iterasiTable').DataTable({
                        responsive: true,
                        dom: 'Bfrtip',
                        buttons: [
                            'excel', 'print'
                        ]
                    });
                });
            </script>
                </div>
            </main>
        </div>
    </div>
</body>
</html>
