<?php
include 'config.php';
include 'excel_reader2.php';

$target = basename($_FILES['file']['name']);
$ext = pathinfo($target, PATHINFO_EXTENSION);

// Periksa apakah file yang diunggah memiliki format Excel yang valid
if ($ext !== 'xls' && $ext !== 'xlsx') {
    echo "<script>alert('Format file salah. Harap unggah file dengan format .xls atau .xlsx.'); window.location.href='uploaddata.php';</script>";
} else {
    move_uploaded_file($_FILES['file']['tmp_name'], $target);
    chmod($target, 0777);

    $data = new Spreadsheet_Excel_Reader($target, false);
    $jumlah_baris = $data->rowcount($sheet_index = 0);

    $berhasil = 0;
    for ($i = 2; $i <= $jumlah_baris; $i++) {
        $bahan_baku = $data->val($i, 1);
        $jan_minggu1 = $data->val($i, 2);
        $jan_minggu2 = $data->val($i, 3);
        $jan_minggu3 = $data->val($i, 4);
        $jan_minggu4 = $data->val($i, 5);
        $feb_minggu1 = $data->val($i, 6);
        $feb_minggu2 = $data->val($i, 7);
        $feb_minggu3 = $data->val($i, 8);
        $feb_minggu4 = $data->val($i, 9);
        $mart_minggu1 = $data->val($i, 10);
        $mart_minggu2 = $data->val($i, 11);
        $mart_minggu3 = $data->val($i, 12);
        $mart_minggu4 = $data->val($i, 13);
        $apr_minggu1 = $data->val($i, 14);
        $apr_minggu2 = $data->val($i, 15);
        $apr_minggu3 = $data->val($i, 16);
        $apr_minggu4 = $data->val($i, 17);
        $mei_minggu1 = $data->val($i, 18);
        $mei_minggu2 = $data->val($i, 19);
        $mei_minggu3 = $data->val($i, 20);
        $mei_minggu4 = $data->val($i, 21);
        $jun_minggu1 = $data->val($i, 22);
        $jun_minggu2 = $data->val($i, 23);
        $jun_minggu3 = $data->val($i, 24);
        $jun_minggu4 = $data->val($i, 25);

        if ($bahan_baku != "") {
            $hasil = mysqli_query($conn, "INSERT INTO upload_data (bahan_baku, jan_minggu1, jan_minggu2, jan_minggu3, jan_minggu4, feb_minggu1, feb_minggu2, feb_minggu3, feb_minggu4, mart_minggu1, mart_minggu2, mart_minggu3, mart_minggu4, apr_minggu1, apr_minggu2, apr_minggu3, apr_minggu4, mei_minggu1, mei_minggu2, mei_minggu3, mei_minggu4, jun_minggu1, jun_minggu2, jun_minggu3, jun_minggu4) 
            VALUES ('$bahan_baku','$jan_minggu1','$jan_minggu2','$jan_minggu3','$jan_minggu4','$feb_minggu1','$feb_minggu2','$feb_minggu3','$feb_minggu4','$mart_minggu1','$mart_minggu2','$mart_minggu3','$mart_minggu4','$apr_minggu1','$apr_minggu2','$apr_minggu3','$apr_minggu4','$mei_minggu1','$mei_minggu2','$mei_minggu3','$mei_minggu4','$jun_minggu1','$jun_minggu2','$jun_minggu3','$jun_minggu4')");
            
            if ($hasil) {
                $berhasil++;
            }
        }
    }
    unlink($target);

    if ($berhasil > 0) {
        echo "<script>alert('$berhasil Data Berhasil Diimpor.'); window.location.href='uploaddata.php';</script>";
    } else {
        echo "<script>alert('Tidak ada data yang berhasil diimpor.'); window.location.href='uploaddata.php';</script>";
    }
}
?>
