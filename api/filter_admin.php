<?php
session_start();
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $table = $_POST['table'];
    $tanggal = isset($_POST['tanggal']) ? $_POST['tanggal'] : null;
    $username = isset($_POST['username']) ? $_POST['username'] : null;
    $role = isset($_POST['role']) ? $_POST['role'] : null;

    $queries = [
        'pembatasan' => [
            'query' => "SELECT pembatasan.id, pembatasan.username, pembatasan.tanggal, pembatasan.sampah_sebelum, pembatasan.sampah_sesudah FROM pembatasan",
            'headers' => ['No', 'Username', 'Tanggal', 'Sampah Sebelum', 'Sampah Sesudah', 'Actions'],
            'table' => 'pembatasan'
        ],
        'pemanfaatan' => [
            'query' => "SELECT pemanfaatan.id, pemanfaatan.username, pemanfaatan.jenis_sampah, pemanfaatan.botol_kaca, pemanfaatan.kemasan_plastik, pemanfaatan.kaleng_alumunium, pemanfaatan.kemasan_kaleng_cat, pemanfaatan.ban_bekas, pemanfaatan.sisa_makanan, pemanfaatan.tanggal FROM pemanfaatan",
            'headers' => ['No', 'Username', 'Jenis Sampah', 'Botol Kaca', 'Kemasan Plastik', 'Kaleng Alumunium', 'Kaleng Cat', 'Ban Bekas', 'Sisa Makanan', 'Tanggal', 'Actions'],
            'table' => 'pemanfaatan'
        ],
        'daur_ulang' => [
            'query' => "SELECT daur_ulang.id, daur_ulang.username, daur_ulang.jenis_sampah, daur_ulang.kertas, daur_ulang.karton, daur_ulang.botol_plastik, daur_ulang.besi, daur_ulang.aluminium, daur_ulang.lainnya_anorganik, daur_ulang.pengomposan, daur_ulang.eco_enzim, daur_ulang.lainnya_organik, daur_ulang.tanggal FROM daur_ulang",
            'headers' => ['No', 'Username', 'Jenis Sampah', 'Kertas', 'Karton', 'Botol Plastik', 'Besi', 'Aluminium', 'Lainnya Anorganik', 'Pengomposan', 'Eco Enzim', 'Lainnya Organik', 'Tanggal', 'Actions'],
            'table' => 'daur_ulang'
        ],
        'bank_sampah' => [
            'query' => "SELECT bank_sampah.id, bank_sampah.username, bank_sampah.jenis_sampah, bank_sampah.kertas, bank_sampah.karton, bank_sampah.botol_pet, bank_sampah.aluminium, bank_sampah.plastik, bank_sampah.besi, bank_sampah.botol_kaca, bank_sampah.minyak_jelantah, bank_sampah.lainnya_anorganik, bank_sampah.pengomposan, bank_sampah.maggot, bank_sampah.eco_enzim, bank_sampah.tanggal FROM bank_sampah",
            'headers' => ['No', 'Username', 'Jenis Sampah', 'Kertas', 'Karton', 'Botol PET', 'Aluminium', 'Plastik', 'Besi', 'Botol Kaca', 'Minyak Jelantah', 'Lainnya Anorganik', 'Pengomposan','Maggot', 'Eco Enzim', 'Tanggal', 'Actions'],
            'table' => 'bank_sampah'
        ]
    ];

    // Validate table
    if (!isset($queries[$table])) {
        echo json_encode(['error' => 'Invalid table selection']);
        exit;
    }

    $query = $queries[$table]['query'];
    $headers = $queries[$table]['headers'];
    $tableName = $queries[$table]['table'];

    // Add JOIN to users table for role filter
    $query .= " JOIN users ON users.username = {$table}.username"; // This assumes 'username' is a common field between the tables
    
    // Apply role, username, and tanggal filters
    $conditions = [];
    if ($tanggal) {
        $conditions[] = "{$table}.tanggal = ?";
    }
    if ($username) {
        $conditions[] = "{$table}.username = ?";
    }
    if ($role) {
        $conditions[] = "users.role = ?"; // Assuming 'role' is in the 'users' table
    }

    if (count($conditions) > 0) {
        $query .= " WHERE " . implode(' AND ', $conditions);
    }

    if ($stmt = $conn->prepare($query)) {
        $types = '';
        $params = [];
        if ($tanggal) {
            $types .= 's';
            $params[] = $tanggal;
        }
        if ($username) {
            $types .= 's';
            $params[] = $username;
        }
        if ($role) {
            $types .= 's';
            $params[] = $role;
        }

        if ($types) {
            $stmt->bind_param($types, ...$params);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        $data = [];
        while ($row = $result->fetch_assoc()) {
            $row['table'] = $tableName;
            $data[] = $row;
        }

        $stmt->close();
    } else {
        echo json_encode(['error' => 'Query preparation failed']);
        exit;
    }

    $conn->close();

    echo json_encode([
        'headers' => $headers,
        'data' => $data
    ]);
}
?>
