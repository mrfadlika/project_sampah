<?php
session_start();
include 'db_connection.php';

$nama_tempat = $_SESSION['username'];
$jenis_sampah = $_POST['jenis_sampah'];
$tanggal = $_POST['tanggal'];
$bukti = $_FILES['uploadFoto']['name'];

// Data untuk jenis sampah anorganik
$botol_kaca = isset($_POST['botol_kaca']) && $_POST['botol_kaca'] !== '' ? $_POST['botol_kaca'] : 0; 
$kemasan_plastik = isset($_POST['kemasan_plastik']) && $_POST['kemasan_plastik'] !== '' ? $_POST['kemasan_plastik'] : 0; 
$kaleng_alumunium = isset($_POST['kaleng_alumunium']) && $_POST['kaleng_alumunium'] !== '' ? $_POST['kaleng_alumunium'] : 0;
$kemasan_kaleng_cat = isset($_POST['kemasan_kaleng_cat']) && $_POST['kemasan_kaleng_cat'] !== '' ? $_POST['kemasan_kaleng_cat'] : 0;
$ban_bekas = isset($_POST['ban_bekas']) && $_POST['ban_bekas'] !== '' ? $_POST['ban_bekas'] : 0;

// Data untuk jenis sampah organik
$sisa_makanan = isset($_POST['sisa_makanan']) && $_POST['sisa_makanan'] !== '' ? $_POST['sisa_makanan'] : 0; 

// Pindahkan file yang diunggah ke direktori tertentu
$target_dir = "../uploads/";
$target_file = $target_dir . basename($bukti);

if (move_uploaded_file($_FILES['uploadFoto']['tmp_name'], $target_file)) {
    $stmt = $conn->prepare("INSERT INTO pemanfaatan 
        (username, jenis_sampah, botol_kaca, kemasan_plastik, kaleng_alumunium, kemasan_kaleng_cat, ban_bekas, sisa_makanan, tanggal, bukti) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    if (!$stmt) {
        die("Kesalahan pada prepare statement: " . $conn->error);
    }

    $stmt->bind_param("sssddddsss", 
        $nama_tempat, 
        $jenis_sampah, 
        $botol_kaca, 
        $kemasan_plastik, 
        $kaleng_alumunium, 
        $kemasan_kaleng_cat, 
        $ban_bekas, 
        $sisa_makanan, 
        $tanggal, 
        $bukti
    );

    if (!$stmt->execute()) {
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
header("Location: ../pemanfaatan_sampah.php");
exit();
?>
