<?php
session_start();

include 'db_connection.php';
$username = $_SESSION['username'];
$jenis_sampah = $_POST['jenis_sampah'];
$tanggal = $_POST['tanggal'];
$bukti = $_FILES['uploadFoto']['name'];

//Data untuk jenis sampah anorganik
$kertas = isset($_POST['kertas']) && $_POST['kertas'] !== '' ? $_POST['kertas'] : 0; 
$karton = isset($_POST['karton']) && $_POST['karton'] !== '' ? $_POST['karton'] : 0; 
$botol_pet = isset($_POST['botol_pet']) && $_POST['botol_pet'] !== '' ? $_POST['botol_pet'] : 0; 
$aluminium = isset($_POST['aluminium']) && $_POST['aluminium'] !== '' ? $_POST['aluminium'] : 0; 
$plastik = isset($_POST['plastik']) && $_POST['plastik'] !== '' ? $_POST['plastik'] : 0; 
$besi = isset($_POST['besi']) && $_POST['besi'] !== '' ? $_POST['besi'] : 0; 
$botol_kaca = isset($_POST['botol_kaca']) && $_POST['botol_kaca'] !== '' ? $_POST['botol_kaca'] : 0;
$minyak_jelantah = isset($_POST['minyak_jelantah']) && $_POST['minyak_jelantah'] !== '' ? $_POST['minyak_jelantah'] : 0;
$lainnya_anorganik = isset($_POST['lainnya_anorganik']) && $_POST['lainnya_anorganik'] !== '' ? $_POST['lainnya_anorganik'] : 0; 

//Data untuk jenis sampah organik
$pengomposan = isset($_POST['pengomposan']) && $_POST['pengomposan'] !== '' ? $_POST['pengomposan'] : 0; 
$maggot = isset($_POST['maggot']) && $_POST['maggot'] !== '' ? $_POST['maggot'] : 0;
$eco_enzim = isset($_POST['eco_enzim']) && $_POST['eco_enzim'] !== '' ? $_POST['eco_enzim'] : 0; 

$target_dir = "../uploads/";
$target_file = $target_dir . basename($bukti);

if(move_uploaded_file($_FILES['uploadFoto']['tmp_name'], $target_file)) {
    $stmt = $conn->prepare("INSERT INTO bank_sampah (username, jenis_sampah, tanggal, kertas, karton, botol_pet, besi, aluminium, plastik, botol_kaca, minyak_jelantah, lainnya_anorganik, pengomposan, eco_enzim, maggot, bukti) 
        VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
    if(!$stmt) {
        die("Kesalahan pada prepare statement: " . $conn->error);
    }

    $stmt->bind_param("ssssssssssssssss", $username, $jenis_sampah, $tanggal, $kertas, $karton, $botol_pet, $besi, $aluminium, $plastik, $botol_kaca, $minyak_jelantah ,$lainnya_anorganik, $pengomposan, $eco_enzim, $maggot, $bukti);

    if(!$stmt->execute()) {
        $_SESSION['status'] = "Data gagal disimpan!";
        $_SESSION['status_code'] = "error";
    } else {
        $_SESSION['status'] = "Data berhasil disimpan!";
        $_SESSION['status_code'] = "success";
    }
    
    $stmt->close();
} else {
    $_SESSION['status'] = "Gagal mengunggah file!";
    $_SESSION['status_code'] = "error";
}

$conn->close();
header("Location: ../bank_sampah.php");
exit();

?>