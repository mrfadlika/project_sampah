<?php
include 'api/check_sesi.php';
include 'api/db_check.php';

if (isset($_SESSION['status']) && isset($_SESSION['status_code'])) {
    $status = $_SESSION['status'];
    $status_code = $_SESSION['status_code'];

    echo "
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: '$status_code',
                title: '$status',
                showConfirmButton: true,
                timer: 3000
            });
        });
    </script>
    ";

    unset($_SESSION['status']);
    unset($_SESSION['status_code']);
}

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

        <!-- Sidebar -->
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
                    <span>Dashboard</span></a>
            </li>

            <hr class="sidebar-divider">

            <div class="sidebar-heading">
                Form Pelaporan
            </div>

            <li class="nav-item active">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo">
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

            <li class="nav-item">
                <a class="nav-link" href="kelola_data_user.php">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Kelola Data</span></a>
            </li>

            <hr class="sidebar-divider d-none d-md-block">
        </ul>
        <!-- Penutup Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Form Pelaporan</h1>
                    </div>

                    <!-- Content Row -->
                    <div class="container-fluid d-flex justify-content-center align-items-center vh-20">
                        <div class="card shadow-lg" style="width: 100%; max-width: 600px;">
                            <div class="card-header text-center bg-success text-white">
                                <h4 class="mb-0">Pembatasan Penimbulan Sampah</h4>
                            </div>
                            <div class="card-body">
                                <form action="api/db_pembatasan_penimbulan_sampah.php" method="post">
                                    <div class="mb-3">
                                        <label for="role" class="form-label">Nama Tempat</label>
                                        <input type="text" class="form-control" id="role" name="role" value="<?php echo $row['role'] ?>" placeholder="Nama tempat sesuai akun" disabled>
                                    </div>
                                    <div class="mb-3">
                                        <label for="tanggal" class="form-label">Tanggal</label>
                                        <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="sampahSebelum" class="form-label">Jumlah Timbulan Sampah Sebelum Ada Pembatasan (KG)</label>
                                        <input type="number" class="form-control" id="sampahSebelum" name="sampahSebelum" placeholder="Masukkan jumlah (KG)" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="sampahSesudah" class="form-label">Jumlah Timbulan Sampah Sesudah Ada Pembatasan (KG)</label>
                                        <input type="number" class="form-control" id="sampahSesudah" name="sampahSesudah" placeholder="Masukkan jumlah (KG)" required>
                                    </div>
                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </form>
                                <p style="margin-top: 50px">Pembatasan timbulan sampah dapat dilakukan dengan:</p>
                                <p>- Menggunakan produk, kemasan produk, dan/atau wadah yang mudah diurai oleh proses alam dan yang menimbulkan sampah sesedikit mungkin.</p>
                                <p>- Menggunakan produk dari bahan yang dapat digunakan berulang kali.</p>
                            </div>
                        </div>
                    </div>
                
                </div>
            </div>
        </div>
    </div>

    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>
    <script src="vendor/chart.js/Chart.min.js"></script>
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>

</body>

</html>