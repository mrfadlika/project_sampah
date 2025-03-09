<?php
include 'api/db_connection.php';

if (isset($_GET['table']) && isset($_GET['id'])) {
    $table = $_GET['table'];
    $id = $_GET['id'];

    if($table == 'pembatasan') {
        $query = "SELECT * FROM pembatasan WHERE id = ?";
        $columns = [
            'sampah_sebelum', 'sampah_sesudah',
        ];
    } elseif ($table == 'pemanfaatan') {
        $query = "SELECT * FROM pemanfaatan WHERE id = ?";
        $columns = [
            'botol_kaca', 'kemasan_plastik',
            'kaleng_alumunium', 'kemasan_kaleng_cat', 'ban_bekas', 'sisa_makanan'
        ];
    } elseif ($table == 'daur_ulang') {
        $query = "SELECT * FROM daur_ulang WHERE id = ?";
        $columns = [
            'kertas', 'karton', 'botol_plastik',
            'besi', 'aluminium', 'lainnya_anorganik', 'pengomposan', 'eco_enzim',
            'lainnya_organik'
        ];
    } else {
        echo "Tabel tidak valid.";
        exit();
    }

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $form_data = [];
        foreach ($columns as $column) {
            $form_data[$column] = $_POST[$column];
        }

        $set_query = '';
        foreach ($columns as $column) {
            $set_query .= "$column = ?, ";
        }
        $set_query = rtrim($set_query, ', ');

        $updateQuery = "UPDATE $table SET $set_query WHERE id = ?";
        $updateStmt = $conn->prepare($updateQuery);
        
        $types = str_repeat('s', count($columns)) . 'i';
        $values = array_values($form_data);
        $values[] = $id;
        $updateStmt->bind_param($types, ...$values);
        $updateStmt->execute();

        header('Location: kelola_data_user.php');
        exit();
    }
} else {
    echo "Parameter tidak lengkap.";
    exit();
}

$conn->close();

include 'api/check_sesi.php';
include 'api/db_check.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Pengegolah Sampah</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="css/page.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body id="page-top">
    <div id="wrapper">
        <ul class="navbar-nav bg-gradient-success sidebar sidebar-dark accordion" id="accordionSidebar">
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
                <div class="sidebar-brand-text mx-1" style="height: 1px;">SISTEM INFORMASI PENGELOLAAN SAMPAH</div>
            </a>
            <hr class="sidebar-divider my-6" style="margin-top: 60px;">
            <li class="nav-item dropdown no-arrow">
                <span class="text-white"><h6 style="text-align: center;"><?php echo $row['nama'] ?></h6></span>
                <a class="nav-link collapsed d-flex align-items-center justify-content-center p-0" href="#" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseTwo">
                    <div style="text-align: center;">
                        <span><p class="my-2 mr-2 mb-2"><?php echo $row['role'] ?></p></span>
                    </div>
                </a>
                <div id="collapseOne" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="profile.php">Profile</a>
                        <a class="collapse-item" href="logout.php">Logout</a>
                    </div>
                </div>
            </li>
            <hr class="sidebar-divider">
            <div class="sidebar-heading">
                Dashboard
            </div>
            <li class="nav-item">
                <a class="nav-link" href="index.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <hr class="sidebar-divider">
            <div class="sidebar-heading">
                Form Pelaporan
            </div>
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Laporan User</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded ">
                        <h6 class="collapse-header">Pilih Jenis Laporan :</h6>
                        <a class="collapse-item" href="pembatasan_penimbulan_sampah.php">Pembatasan Penimbulan <br>Sampah</a>
                        <a class="collapse-item" href="pemanfaatan_sampah.php">Pemanfaatan Sampah</a>
                        <a class="collapse-item" href="daur_ulang_sampah.php">Daur Ulang Sampah</a>
                    </div>
                </div>
            </li>
            <hr class="sidebar-divider">

            <div class="sidebar-heading">
                Hasil Laporan
            </div>

            <li class="nav-item active">
                <a class="nav-link" href="kelola_data_user.php">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Kelola Data</span></a>
            </li>

            <hr class="sidebar-divider d-none d-md-block">
        </ul>

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                   
                </nav>

                <div class="container-fluid">
                    <div class="container-fluid d-flex justify-content-center align-items-center vh-20">
                        <div class="card shadow-lg" style="width: 100%; max-width: 600px;">
                            <div class="card-header bg-success text-white">
                                <h4 class="mb-0 text-center">Edit Data</h4>
                            </div>
                            <div class="card-body">
                                    <form method="POST" class="user">
                                        <?php foreach ($columns as $column): ?>
                                            <div class="form-group mb-3">
                                                <label for="<?php echo $column; ?>"><?php echo ucfirst(str_replace('_', ' ', $column)); ?></label>
                                                <input type="text" class="form-control form-control-user" id="<?php echo $column; ?>" name="<?php echo $column; ?>" value="<?php echo htmlspecialchars($data[$column]); ?>" required>
                                            </div>
                                            <?php endforeach; ?>
                                            <div class="d-grid">
                                                <button type="submit" class="btn btn-success btn-user btn-block">Update Data</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>
</body>
</html>
