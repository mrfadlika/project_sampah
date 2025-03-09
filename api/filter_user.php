<?php
session_start();
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $table = $_POST['table'];
    $tanggal = isset($_POST['tanggal']) ? $_POST['tanggal'] : null;
    $username = $_SESSION['username'];

    $query = "";
    $headers = [];
    $data = [];
    $tableName = "";

    if ($table === 'pembatasan') {
        $query = "SELECT id, username, tanggal, sampah_sebelum, sampah_sesudah FROM pembatasan";
        $headers = ['No', 'Username', 'Tanggal', 'Sampah Sebelum', 'Sampah Sesudah', 'Actions'];
        $tableName = 'pembatasan';
    } elseif ($table === 'pemanfaatan') {
        $query = "SELECT id, username, jenis_sampah, botol_kaca, kemasan_plastik, kaleng_alumunium, kemasan_kaleng_cat, ban_bekas, sisa_makanan, tanggal FROM pemanfaatan";
        $headers = ['No', 'Username', 'Jenis Sampah', 'Botol Kaca', 'Kemasan Plastik', 'Kaleng Alumunium', 'Kaleng Cat', 'Ban Bekas', 'Sisa Makanan', 'Tanggal', 'Actions'];
        $tableName = 'pemanfaatan';
    } elseif ($table === 'daur_ulang') {
        $query = "SELECT id, username, jenis_sampah, kertas, karton, botol_plastik, besi, aluminium, lainnya_anorganik, pengomposan, eco_enzim, lainnya_organik, tanggal FROM daur_ulang";
        $headers = ['No', 'Username', 'Jenis Sampah', 'Kertas', 'Karton', 'Botol Plastik', 'Besi', 'Aluminium', 'Lainnya Anorganik', 'Pengomposan', 'Eco Enzim', 'Lainnya Organik', 'Tanggal', 'Actions'];
        $tableName = 'daur_ulang';
    }

    if ($tanggal) {
        $query .= " WHERE tanggal = ? AND username = ?";
    } else {
        $query .= " WHERE username = ?";
    }

    if ($stmt = $conn->prepare($query)) {
        if ($tanggal) {
            $stmt->bind_param("ss", $tanggal, $username); 
        } else {
            $stmt->bind_param("s", $username); 
        }

        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $row['table'] = $tableName;
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
