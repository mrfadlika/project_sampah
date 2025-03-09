<?php
session_start();
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tanggal = isset($_POST['tanggal']) ? $_POST['tanggal'] : null;
    $username = $_SESSION['username'];

    if (!$tanggal) {
        echo json_encode(['error' => 'Tanggal diperlukan']);
        exit;
    }

    $query = "SELECT id, username, nama_bank_sampah, saldo, tanggal FROM bank_sampah WHERE tanggal = ? AND username = ?";

    $headers = ['No', 'Username', 'Nama Bank Sampah', 'Saldo', 'Tanggal', 'Actions'];
    $data = [];

    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("ss", $tanggal, $username); 
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            foreach ($row as $key => $value) {
                if ($value === '0' || $value === 0) {
                    unset($row[$key]);
                }
            }
            $data[] = $row;
        }

        $stmt->close();
    } else {
        echo json_encode(['error' => 'Query preparation failed']);
    }

    $conn->close();

    echo json_encode([
        'headers' => $headers,
        'data' => $data
    ]);
}
?>
