<?php
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $table = $_POST['table'];
    $tanggal = isset($_POST['tanggal']) ? $_POST['tanggal'] : null;

    $query = "";
    $headers = [];
    $data = [];

    if ($table === 'pembatasan') {
        $query = "SELECT id, username, tanggal, sampah_sebelum, sampah_sesudah FROM pembatasan";
        $headers = ['No', 'Username', 'Tanggal', 'Sampah Sebelum', 'Sampah Sesudah', 'Actions'];
    } elseif ($table === 'pemanfaatan') {
        $query = "SELECT id, nama_tempat, jenis_sampah, botol_kaca, kemasan_plastik, kaleng_alumunium, kemasan_kaleng_cat, ban_bekas, sisa_makanan, tanggal FROM pemanfaatan";
        $headers = ['No', 'Username', 'Jenis Sampah', 'Botol Kaca', 'Kemasan Plastik', 'Kaleng Alumunium', 'Kaleng Cat', 'Ban Bekas', 'Sisa Makanan', 'Tanggal', 'Actions'];
    } elseif ($table === 'daur_ulang') {
        $query = "SELECT id, username, jenis_sampah, kertas, karton, botol_plastik, besi, aluminium, lainnya_anorganik, pengomposan, eco_enzim, lainnya_organik, tanggal FROM daur_ulang";
        $headers = ['No', 'Username', 'Jenis Sampah', 'Kertas', 'Karton', 'Botol Plastik', 'Besi', 'Aluminium', 'Lainnya Anorganik', 'Pengomposan', 'Eco Enzim', 'Lainnya Organik', 'Tanggal', 'Actions'];
    }

    if ($tanggal) {
        $query .= " WHERE tanggal = ?";
    }

    $stmt = $conn->prepare($query);
    if ($tanggal) {
        $stmt->bind_param("s", $tanggal);
    }
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
    $conn->close();

    echo json_encode([
        'headers' => $headers,
        'data' => $data
    ]);
}
?>
