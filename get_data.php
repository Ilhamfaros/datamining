<?php
include 'config.php';

if (isset($_POST['bahan_baku'])) {
    $id = $_POST['bahan_baku'];
    $query = "SELECT * FROM upload_data WHERE bahan_baku = $bahan_baku";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $data = mysqli_fetch_assoc($result);
        echo json_encode($data);
    } else {
        echo json_encode(['error' => 'Data not found']);
    }
}
?>
