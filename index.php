<?php
session_start();
include 'api/check_sesi.php';
include 'api/db_check.php';
include 'api/db_connection.php';

$sesiBerlangsung = $_SESSION['username'];

$querySelector1 = "SELECT 
                      SUM(COALESCE(botol_kaca, 0)) AS total_botol_kaca,
                      SUM(COALESCE(kemasan_plastik, 0)) AS total_kemasan_plastik,
                      SUM(COALESCE(kaleng_alumunium, 0)) AS total_kaleng_alumunium,
                      SUM(COALESCE(kemasan_kaleng_cat, 0)) AS total_kemasan_kaleng_cat,
                      SUM(COALESCE(ban_bekas, 0)) AS total_ban_bekas,
                      SUM(COALESCE(sisa_makanan, 0)) AS total_sisa_makanan
                  FROM pemanfaatan
                  WHERE nama_tempat = '$sesiBerlangsung'";

$querySelector2 = "SELECT 
                      SUM(sampah_sebelum) AS total_sebelum,
                      SUM(sampah_sesudah) AS total_sesudah
                  FROM pembatasan
                  WHERE username = '$sesiBerlangsung'";

$querySelector3 = "SELECT 
                    sum(kertas) AS total_kertas, 
                    sum(karton) AS total_karton, 
                    sum(botol_plastik) AS total_botol_plastik, 
                    sum(besi) AS total_besi,
                    sum(aluminium) AS total_aluminium,
                    sum(lainnya_anorganik) AS total_lainnya_anorganik,
                    sum(pengomposan) AS total_pengomposan,
                    sum(eco_enzim) AS total_eco_enzim,
                    sum(lainnya_organik) AS total_lainnya_organik
                FROM daur_ulang
                WHERE username = '$sesiBerlangsung'";

$result1 = $conn->query($querySelector1);
if($result1 && $result1->num_rows > 0) {
    $data1 = $result1->fetch_assoc();
} else {
    $data1 = [
        'total_botol_kaca' => 0,
        'total_kemasan_plastik' => 0,
        'total_kaleng_alumunium' => 0,
        'total_kemasan_kaleng_cat' => 0,
        'total_ban_bekas' => 0,
        'total_sisa_makanan' => 0
    ];
}

// Menjalankan query kedua
$result2 = $conn->query($querySelector2);
if($result2 && $result2->num_rows > 0) {
    $data2 = $result2->fetch_assoc();
} else {
    $data2 = [
        'total_sebelum' => 0,
        'total_sesudah' => 0
    ];
}

$result3 = $conn->query($querySelector3);
if($result3 && $result3->num_rows > 0) {
    $data3 = $result3->fetch_assoc();
} else {
    $data3 = [
        'total_kertas' => 0,
        'total_karton' => 0,
        'total_botol_plastik' => 0,
        'total_besi' => 0,
        'total_aluminium' => 0,
        'total_lainnya_anorganik' => 0,
        'total_pengomposan' => 0,
        'total_eco_enzim' => 0,
        'total_lainnya_organik' => 0
    ];
}

$conn->close();

$total_sampah = $data1['total_botol_kaca'] + $data1['total_kemasan_plastik'] + 
                $data1['total_kaleng_alumunium'] + $data1['total_kemasan_kaleng_cat'] +
                $data1['total_ban_bekas'] + $data1['total_sisa_makanan'];

$total_daur_ulang_anorganik = $data3['total_kertas'] + $data3['total_karton'] + $data3['total_botol_plastik'] + $data3['total_besi'] + $data3['total_aluminium'] + $data3['total_lainnya_anorganik'];
$total_daur_ulang_organik =  $data3['total_pengomposan'] + $data3['total_eco_enzim'] + $data3['total_lainnya_organik'];

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

            <li class="nav-item active">
                <a class="nav-link" href="index.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <hr class="sidebar-divider">

            <div class="sidebar-heading">
                Form Pelaporan
            </div>

            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Laporan User</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
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

            <li class="nav-item">
                <a class="nav-link" href="kelola_data_user.php">
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

                    <ul class="navbar-nav ml-auto">

                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bell fa-fw"></i>
                                <span class="badge badge-danger badge-counter">2</span>
                            </a>
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="alertsDropdown">
                                <h6 class="dropdown-header">
                                    Alerts Center
                                </h6>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-primary">
                                            <i class="fas fa-file-alt text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 12, 2019</div>
                                        <span class="font-weight-bold">A new monthly report is ready to download!</span>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-success">
                                            <i class="fas fa-donate text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 7, 2019</div>
                                        $290.29 has been deposited into your account!
                                    </div>
                                </a>
                                <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
                            </div>
                        </li>

                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-envelope fa-fw"></i>
                                <span class="badge badge-danger badge-counter">1</span>
                            </a>
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="messagesDropdown">
                                <h6 class="dropdown-header">
                                    Message Center
                                </h6>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="img/undraw_profile_1.svg"
                                            alt="...">
                                        <div class="status-indicator bg-success"></div>
                                    </div>
                                    <div class="font-weight-bold">
                                        <div class="text-truncate">Hi there! I am wondering if you can help me with a
                                            problem I've been having.</div>
                                        <div class="small text-gray-500">Emily Fowler · 58m</div>
                                    </div>
                                    <a class="dropdown-item text-center small text-gray-500" href="#">Read More Messages</a>
                                </a>
                            </div>
                        </li>
                    </ul>

                </nav>
                <!-- Tutup topbar -->

                <div class="container-fluid">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Data Persampahan</h1>
                    </div>

                    <div class="row">
                        <div class="col-xl-3 col-md-6 mb-5">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class=" font-weight-bold text-center text-primary text-uppercase mb-3">
                                                Timbulan Sampah Sebelum Pembatasan
                                            </div>
                                            <h1 class="text-center font-weight-bold mb-3"><?= number_format($data2['total_sebelum']) ?></h1>
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
                                                Timbulan Sampah Setelah Pembatasan
                                            </div>
                                            <h1 class="text-center font-weight-bold mb-3"><?= number_format($data2['total_sesudah']) ?></h1>
                                            <div class="text-center font-weight-bold text-success text-uppercase">
                                                Kilogram/Tahun
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-5">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2 mt-2">
                                            <div class=" font-weight-bold text-center text-warning text-uppercase mb-4">
                                                Pemanfaatan Kembali
                                            </div>
                                            <h1 class="text-center font-weight-bold mb-4"><?php echo $total_sampah ?></h1>
                                            <div class="text-center font-weight-bold text-warning text-uppercase">
                                                Kilogram/Tahun
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-5">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2 mt-2">
                                            <div class=" font-weight-bold text-center text-info text-uppercase mb-4">
                                                Pendauran Ulang Anorganik
                                            </div>
                                            <h1 class="text-center font-weight-bold mb-4"><?php echo $total_daur_ulang_anorganik ?></h1>
                                            <div class="text-center font-weight-bold text-info text-uppercase">
                                                Kilogram/Tahun
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-xl-3 col-md-6 mb-5">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2 mt-2">
                                            <div class=" font-weight-bold text-center text-primary text-uppercase mb-4">
                                                Pendauran Ulang Organik
                                            </div>
                                            <h1 class="text-center font-weight-bold mb-4"><?php echo $total_daur_ulang_organik ?></h1>
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
                                        <div class="col mr-2 mt-2">
                                        <div class=" font-weight-bold text-center text-success text-uppercase mb-4">
                                            Pengunaan Kantong Plastik
                                        </div>
                                        <h1 class="text-center font-weight-bold mb-4">YYY</h1>
                                        <div class="text-center font-weight-bold text-success text-uppercase">
                                            Kilogram/Tahun
                                        </div>
                                    </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-5">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class=" font-weight-bold text-center text-warning text-uppercase mb-3">
                                                Pengelolahan di Bank Sampah Unit
                                            </div>
                                            <h1 class="text-center font-weight-bold mb-3">YYY</h1>
                                            <div class="text-center font-weight-bold text-warning text-uppercase">
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
    </div>

    
<script>
    <?php if (isset($_SESSION['username'])): ?>
        console.log("Username dalam sesi: <?php echo $_SESSION['username']; ?>");
    <?php else: ?>
        console.log("Sesi username tidak ditemukan.");
    <?php endif; ?>
</script>

<?php
session_start();

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