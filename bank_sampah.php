<?php
include 'api/check_sesi.php';
include 'api/db_check.php';
include 'api/db_connection.php';

$sesiBerlangsung = $_SESSION['username'];

$querySelector1 = "SELECT 
                      SUM(COALESCE(kertas, 0)) AS total_kertas,
                      SUM(COALESCE(karton, 0)) AS total_karton,
                      SUM(COALESCE(botol_pet, 0)) AS total_botol_pet,
                      SUM(COALESCE(besi, 0)) AS total_besi,
                      SUM(COALESCE(aluminium, 0)) AS total_aluminium,
                      SUM(COALESCE(plastik, 0)) AS total_plastik,
                      SUM(COALESCE(lainnya_anorganik, 0)) AS total_lainnya_anorganik
                  FROM bank_sampah
                  WHERE username = '$sesiBerlangsung'";

$querySelector2 = "SELECT 
                      SUM(COALESCE(pengomposan, 0)) AS total_pengomposan,
                      SUM(COALESCE(eco_enzim, 0)) AS total_eco_enzim,
                      SUM(COALESCE(maggot, 0)) AS total_maggot
                  FROM bank_sampah
                  WHERE username = '$sesiBerlangsung'";

$result1 = $conn->query($querySelector1);
if($result1 && $result1->num_rows > 0) {
    $data1 = $result1->fetch_assoc();
} else {
    $data1 = [
        'total_kertas' => 0,
        'total_karton' => 0,
        'total_botol_pet' => 0,
        'total_besi' => 0,
        'total_aluminium' => 0,
        'total_plastik' => 0,
        'total_lainnya_anorganik' => 0,
        'total_pengomposan' => 0,
        'total_eco_enzim' => 0,
        'total_maggot' => 0
    ];
}

$result2 = $conn->query($querySelector2);
if($result2 && $result2->num_rows > 0) {
    $data2 = $result2->fetch_assoc();
} else {
    $data2 = [
        'total_pengomposan' => 0,
        'total_eco_enzim' => 0,
        'total_maggot' => 0
    ];
}

$conn->close();

$total_bank_sampah_anorganik = $data1['total_kertas'] + $data1['total_karton'] + $data1['total_botol_pet'] + $data1['total_besi'] + $data1['total_aluminium'] + $data1['total_plastik'] + $data1['total_lainnya_anorganik'];
$total_bank_sampah_organik = $data2['total_pengomposan'] + $data2['total_eco_enzim'] + $data2['total_maggot'];

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
                        <a class="collapse-item" href="bank_sampah_profile.php">Profile</a>
                        <a class="collapse-item" href="logout.php">Logout</a>
                    </div>
                </div>
            </li>

            <hr class="sidebar-divider">

            <div class="sidebar-heading">
                Dashboard
            </div>

            <li class="nav-item active">
                <a class="nav-link" href="bank_sampah.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <hr class="sidebar-divider">
            
            <div class="sidebar-heading">
                Bank Sampah
            </div>

            <li class="nav-item">
                <a class="nav-link" href="add_bank_sampah.php">
                    <i class="fas fa-fw fa-plus"></i>
                    <span>Tambah Data</span></a>
            </li>

            <hr class="sidebar-divider">

            <div class="sidebar-heading">
                Hasil Laporan
            </div>

            <li class="nav-item">
                <a class="nav-link" href="kelola_bank_sampah.php">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Kelola Data</span></a>
            </li>

            <hr class="sidebar-divider d-none d-md-block">
        </ul>
        <!-- Penutup sidebar -->

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    

                </nav>
                <!-- Tutup topbar -->

                <div class="container-fluid">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Data Bank Sampah</h1>
                    </div>

                    <div class="row">
                        <div class="col-xl-3 col-md-6 mb-5">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class=" font-weight-bold text-center text-primary text-uppercase mb-3">
                                                Total Bank Sampah Anorganik
                                            </div>
                                            <h1 class="text-center font-weight-bold mb-3"><?php echo $total_bank_sampah_anorganik ?></h1>
                                            <div class="text-center font-weight-bold text-primary text-uppercase">
                                                Kilogram/Tahun
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-xl-3 col-md-6 mb-5">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class=" font-weight-bold text-center text-success text-uppercase mb-3">
                                                Total Bank Sampah Organik
                                            </div>
                                            <h1 class="text-center font-weight-bold mb-3"><?php echo $total_bank_sampah_organik ?></h1>
                                            <div class="text-center font-weight-bold text-success text-uppercase">
                                                Kilogram/Tahun
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                </div>
            </div>
        </div>
    </div>

    
<script>
    <?php if (isset($_SESSION['username'])): ?>
        console.log("Username dalam sesi: <?php echo $_SESSION['username']; ?>");
    <?php else: ?>
        console.log("Sesi username tidak ditemukan.");
    <?php endif; ?>
</script>

<?php

if (isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], 'login.php') !== false) {
    if (isset($_SESSION['success'])) {
        echo "
            <script>
                console.log('SweetAlert2 dipanggil');
                Swal.fire({
                    title: 'Berhasil',
                    text: '" . $_SESSION['success'] . "',
                    icon: 'success',
                    timer: 3000,
                    showConfirmButton: false
                });
            </script>
        ";
        unset($_SESSION['success']);
    }
} else {
    echo "
        <script>
            console.log('Akses tidak sah.');
        </script>
    ";
}
?>

    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>
    <script src="vendor/chart.js/Chart.min.js"></script>
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>

</body>

</html>