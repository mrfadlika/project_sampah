<?php
session_start();
include 'api/edit_user.php';
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

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-success sidebar sidebar-dark accordion" id="accordionSidebar">

            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="admin.html">
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
                        <a class="collapse-item" href="admin_profile.php">Profile</a>
                        <a class="collapse-item" href="logout.php">Logout</a>
                    </div>
                </div>
            </li>

            <hr class="sidebar-divider">

            <div class="sidebar-heading">
                Halaman Admin
            </div>

            <li class="nav-item">
                <a class="nav-link" href="admin.php">
                    <i class="fas fa-fw fa-plus"></i>
                    <span>Tambah User</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="tables.php">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Table User</span></a>
            </li>

            <li class="nav-item">
    <a class="nav-link" href="report_filter.php">
        <i class="fas fa-fw fa-file-alt"></i>
        <span>Report Data</span></a>
</li>

            <hr class="sidebar-divider d-none d-md-block">
        </ul>
        <!-- Penutup Sidebar -->

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
                        <h1 class="h3 mb-0 text-gray-800">Admin Pages</h1>
                    </div>
                    <div class="container-fluid py-4">
                        <div class="card shadow mb-5">
                            <div class="card-header text-center bg-success text-white">
                                <h4 class="mb-0">Form Tambah User</h4>
                            </div>
                            <div class="card-body">
                                <form id="add_user" action="api/edit_user.php?id=<?php echo $baris['id'] ?>" method="post">
                                    <div class="mb-4">
                                        <label for="nama" class="form-label fw-semibold">Nama</label>
                                        <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $baris['nama'] ?>" placeholder="Input Nama" required>
                                    </div>
                    
                                    <div class="mb-4">
                                        <label for="email" class="form-label fw-semibold">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" value="<?php echo $baris['email'] ?>" placeholder="Input Email" required>
                                    </div>
                                    
                                    <div class="mb-4">
                                        <label for="nomor_telp" class="form-label fw-semibold">Nomor HP</l  abel>
                                        <input type="phonenumber" class="form-control" id="nomor_telp" name="nomor_telp" value="<?php echo $baris['nomor_telp'] ?>" placeholder="Input Nomor HP" required>
                                    </div>
                                    
                                    <div class="mb-4">
                                        <label for="username" class="form-label fw-semibold">Username</label>
                                        <input type="username" class="form-control" id="username" name="username" value="<?php echo $baris['username'] ?>" placeholder="Input Username" required>
                                        <p class="text-danger" style="margin-top: 5px; margin: 0px">Masukkan username dengan menggabungkan karakter (tanpa spasi)</p>
                                        <p class="text-danger" style="margin-top: 5px; margin: 0px">*Gunakan awalan admin untuk membuat username admin, contoh: admin_ashar</p>
                                        <p class="text-danger" style="margin-top: 5px; margin: 0px">*Gunakan awalan bank_sampah untuk membuat username bank sampah, contoh: bank_sampah_ashar</p>
                                    </div>

                                    <div class="mb-4">
                                        <label for="password" class="form-label fw-semibold">Password</label>
                                        <input type="password" class="form-control" id="password" name="password" value="<?php echo $baris['password'] ?>" placeholder="Input Password" required>
                                    </div>

                                    <div class="mb-4">
                                        <label for="lembaga" class="form-label fw-semibold">Nama Instansi</label>
                                        <input type="text" class="form-control" id="lembaga" name="lembaga" value="<?php echo $baris['instansi'] ?>" placeholder="Input Nama Instansi" required>
                                    </div>
                    
                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-success btn-lg">Edit Data User</button>
                                    </div>
                                </form>
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