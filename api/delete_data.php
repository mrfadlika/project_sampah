<?php
session_start();
include 'db_connection.php';

if (isset($_GET['table']) && isset($_GET['id'])) {
    $table = $_GET['table'];
    $id = $_GET['id'];

    $deleteQuery = "DELETE FROM $table WHERE id = ?";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        $_SESSION['status'] = "Berhasil dihapus";
        $_SESSION['status_code'] = "success";
    } else {
        $_SESSION['status'] = "Gagal dihapus";
        $_SESSION['status_code'] = "error";
    }

    $stmt->close();
    $conn->close();
    
} else {
    $_SESSION['status'] = "Parameter Salah";
    $_SESSION['status_code'] = "error";
}
header('Location: ../kelola_data_user.php');
exit();
?>
