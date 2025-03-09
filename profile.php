<?php
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
         <!-- Main Content -->
<div id="content-wrapper" class="d-flex flex-column">
    <div id="content">
    <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    

                </nav>
        <div class="container-fluid mt-4">

            <!-- Page Heading -->
            <h1 class="h3 mb-4 text-gray-800">Profil Pengguna</h1>

            <!-- Profile Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-success">Detail Profil</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-4 text-center">
                            <img src="./img/user-1.jpg" 
                                 alt="Foto Profil" 
                                 class="img-fluid rounded-circle mb-3" 
                                 style="width: 150px; height: 150px;">
                            <h5><?php echo $row['nama']; ?></h5>
                            <p class="text-muted"><?php echo $row['role']; ?></p>
                        </div>
                        <div class="col-lg-8">
                            <table class="table table-bordered">
                                <tr>
                                    <th>Nama Lengkap</th>
                                    <td><?php echo $row['nama']; ?></td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td><?php echo $row['email']; ?></td>
                                </tr>
                                <tr>
                                    <th>Username</th>
                                    <td><?php echo $row['username']; ?></td>
                                </tr>
                                <tr>
                                    <th>Role</th>
                                    <td><?php echo $row['role']; ?></td>
                                </tr>
                                <tr>
                                    <th>Nomor HP</th>
                                    <td><?php echo $row['nomor_telp']; ?></td>
                                </tr>
                                <tr>
                                    <th>Terdaftar Sejak</th>
                                    <td><?php echo date('d F Y', strtotime($row['created_at'])); ?></td>
                                </tr>
                            </table>
                            <p>Hubungi administrator jika terdapat data yang salah</p>
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

    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>
    <script src="vendor/chart.js/Chart.min.js"></script>
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>

</body>

</html>