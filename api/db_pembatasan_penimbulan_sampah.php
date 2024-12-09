<?php

session_start();

include 'db_connection.php';
$username = $_SESSION['username'];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $role = $_POST['role'];
    $tanggal = $_POST['tanggal'];
    $sampahSebelum = $_POST['sampahSebelum'];
    $sampahSesudah = $_POST['sampahSesudah'];
    

    $sql = "INSERT INTO pembatasan (username, nama_tempat, tanggal, sampah_sebelum, sampah_sesudah) values ('$username', '$role', '$tanggal', '$sampahSebelum', '$sampahSesudah')";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['status'] = "Berhasil ditambahkan";
        $_SESSION['status_code'] = "success"; 
    } else {
        $_SESSION['status'] = "Gagal ditambahkan";
        $_SESSION['status_code'] = "error"; 
    }

    $conn->close();
    header("Location: ../pembatasan_penimbulan_sampah.php");
}