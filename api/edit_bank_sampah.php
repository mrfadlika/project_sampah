<?php
session_start();
include 'db_connection.php';

$id = $_GET['id'];
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $sql1 = "SELECT * from bank_sampah WHERE id = ?";
    $stmt = $conn->prepare($sql1);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0){
        $row = $result->fetch_assoc();
        $current_kertas = $row['kertas'];
        $current_karton = $row['karton'];
        $current_botol_pet = $row['botol_pet'];
        $current_aluminium = $row['aluminium'];
        $current_plastik = $row['plastik'];
        $current_besi = $row['besi'];
        $current_lainnya_anorganik = $row['lainnya_anorganik'];
        $current_pengomposan = $row['pengomposan'];
        $current_maggot = $row['maggot'];
        $current_eco_enzim = $row['eco_enzim'];
    }
    $kertas_baru = isset($_POST['kertas']) ? htmlspecialchars($_POST['kertas'], ENT_QUOTES, 'UTF-8') : $current_kertas;
    $karton_baru = isset($_POST['karton']) ? htmlspecialchars($_POST['karton'], ENT_QUOTES, 'UTF-8') : $current_karton;
    $botol_pet_baru = isset($_POST['botol_pet']) ? htmlspecialchars($_POST['botol_pet'], ENT_QUOTES, 'UTF-8') : $current_botol_pet;
    $aluminium_baru = isset($_POST['aluminium']) ? htmlspecialchars($_POST['aluminium'], ENT_QUOTES, 'UTF-8') : $current_aluminium;
    $plastik_baru = isset($_POST['plastik']) ? htmlspecialchars($_POST['plastik'], ENT_QUOTES, 'UTF-8') : $current_plastik;
    $besi_baru = isset($_POST['besi']) ? htmlspecialchars($_POST['besi'], ENT_QUOTES, 'UTF-8') : $current_besi;
    $lainnya_anorganik_baru = isset($_POST['lainnya_anorganik']) ? htmlspecialchars($_POST['lainnya_anorganik'], ENT_QUOTES, 'UTF-8') : $current_lainnya_anorganik;
    $pengomposan_baru = isset($_POST['pengomposan']) ? htmlspecialchars($_POST['pengomposan'], ENT_QUOTES, 'UTF-8') : $current_pengomposan;
    $maggot_baru = isset($_POST['maggot']) ? htmlspecialchars($_POST['maggot'], ENT_QUOTES, 'UTF-8') : $current_maggot;
    $eco_enzim_baru = isset($_POST['eco_enzim']) ? htmlspecialchars($_POST['eco_enzim'], ENT_QUOTES, 'UTF-8') : $current_eco_enzim;

    $query = "UPDATE bank_sampah SET 
              kertas = ?, karton = ?, botol_pet = ?, aluminium = ?, 
              plastik = ?, besi = ?, lainnya_anorganik = ?, 
              pengomposan = ?, maggot = ?, eco_enzim = ? 
              WHERE id = ?";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ddddddddddi", 
        $kertas_baru, $karton_baru, $botol_pet_baru, $aluminium_baru, 
        $plastik_baru, $besi_baru, $lainnya_anorganik_baru, 
        $pengomposan_baru, $maggot_baru, $eco_enzim_baru, $id);

    if($stmt->execute()) {
        $_SESSION['status'] = "Data berhasil disimpan!";
        $_SESSION['status_code'] = "success";
        header("Location: ../kelola_bank_sampah.php");
        exit();
    } else {
        $_SESSION['status'] = "Data gagal disimpan!";
        $_SESSION['status_code'] = "error";
        echo "Error: " . $stmt->error;
        header("Location: ../edit_bank_sampah.php?id=" . $id );
        exit();
    }
    $stmt->close();
}

$sql = "SELECT * FROM bank_sampah WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows > 0){
  $baris = $result->fetch_assoc();
} else {
  exit;
}

$conn->close();
?>
