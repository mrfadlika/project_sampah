<?php
session_start();

include 'db_connection.php';
$username = $_SESSION['username'];
$jenis_sampah = $_POST['jenis_sampah'];
$tanggal = $_POST['tanggal'];

//Data untuk jenis sampah anorganik
$kertas = isset($_POST['kertas']) && $_POST['kertas'] !== '' ? $_POST['kertas'] : 0; 
$karton = isset($_POST['karton']) && $_POST['karton'] !== '' ? $_POST['karton'] : 0; 
$botol_plastik = isset($_POST['botol_plastik']) && $_POST['botol_plastik'] !== '' ? $_POST['botol_plastik'] : 0; 
$besi = isset($_POST['besi']) && $_POST['besi'] !== '' ? $_POST['besi'] : 0; 
$aluminium = isset($_POST['aluminium']) && $_POST['aluminium'] !== '' ? $_POST['aluminium'] : 0; 
$lainnya_anorganik = isset($_POST['lainnya_anorganik']) && $_POST['lainnya_anorganik'] !== '' ? $_POST['lainnya_anorganik'] : 0; 

//Data untuk jenis sampah organik
$pengomposan = isset($_POST['pengomposan']) && $_POST['pengomposan'] !== '' ? $_POST['pengomposan'] : 0; 
$eco_enzim = isset($_POST['eco_enzim']) && $_POST['eco_enzim'] !== '' ? $_POST['eco_enzim'] : 0; 
$lainnya_organik = isset($_POST['lainnya_organik']) && $_POST['lainnya_organik'] !== '' ? $_POST['lainnya_organik'] : 0;

$sql = "INSERT INTO daur_ulang (username, jenis_sampah, tanggal, kertas, karton, botol_plastik, besi, aluminium, lainnya_anorganik, pengomposan, eco_enzim, lainnya_organik) 
        VALUES ('$username', '$jenis_sampah', '$tanggal', '$kertas', '$karton', '$botol_plastik', '$besi', '$aluminium', '$lainnya_anorganik', '$pengomposan', '$eco_enzim', '$lainnya_organik')";

if($conn->query($sql) === true) {
    $_SESSION['status'] = "Data berhasil ditambahkan";
    $_SESSION['status_code'] = "success";
} else {
    $_SESSION['status'] = "Data gagal ditambahkan: " . $conn->error;
    $_SESSION['status_code'] = "error";
}

$conn->close();

header("Location: ../daur_ulang_sampah.php");
exit();

?>