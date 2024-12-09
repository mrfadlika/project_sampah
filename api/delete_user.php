<?php
session_start();

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    include 'db_connection.php';

    $sql = "DELETE FROM users WHERE id=?";
    $stmt = $conn->prepare($sql);
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
    $_SESSION['status'] = "ID Tidak Diberikan";
    $_SESSION['status_code'] = "error"; 
}

header("Location: ../tables.php");
exit();
?>
