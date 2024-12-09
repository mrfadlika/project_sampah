<?php
session_start();
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

            <li class="nav-item active">
                <a class="nav-link" href="admin.php">
                    <i class="fas fa-fw fa-plus"></i>
                    <span>Tambah User</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="tables.php">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Table User</span></a>
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
                        <h1 class="h3 mb-0 text-gray-800">Admin Pages</h1>
                    </div>
                    <div class="container-fluid py-4">
                        <div class="card shadow mb-5">
                            <div class="card-header text-center bg-success text-white">
                                <h4 class="mb-0">Form Tambah User</h4>
                            </div>
                            <div class="card-body">
                                <form id="add_user" action="api/add_user.php" method="post">
                                    <div class="mb-4">
                                        <label for="nama" class="form-label fw-semibold">Nama</label>
                                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Input Nama" required>
                                    </div>
                    
                                    <div class="mb-4">
                                        <label for="email" class="form-label fw-semibold">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" placeholder="Input Email" required>
                                    </div>
                                    
                                    <div class="mb-4">
                                        <label for="nomor_telp" class="form-label fw-semibold">Nomor HP</l  abel>
                                        <input type="phonenumber" class="form-control" id="nomor_telp" name="nomor_telp" placeholder="Input Nomor HP" required>
                                    </div>
                                    
                                    <div class="mb-4">
                                        <label for="username" class="form-label fw-semibold">Username</label>
                                        <input type="username" class="form-control" id="username" name="username" placeholder="Input Username" required>
                                        <p class="text-danger" style="margin-top: 5px; margin: 0px">Masukkan username dengan menggabungkan karakter (tanpa spasi)</p>
                                        <p class="text-danger" style="margin-top: 5px; margin: 0px">*Gunakan awalan admin untuk membuat username admin, contoh: admin_ashar</p>
                                        <p class="text-danger" style="margin-top: 5px; margin: 0px">*Gunakan awalan bank_sampah untuk membuat username bank sampah, contoh: bank_sampah_ashar</p>
                                    </div>

                                    <div class="mb-4">
                                        <label for="password" class="form-label fw-semibold">Password</label>
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Input Password" required>
                                    </div>
                    
    
                                    <div class="mb-4">
                                        <label for="role" class="form-label fw-semibold">Role</label>
                                        <select class="form-select costum-select" id="role" name="role" required>
                                            <option value="" disabled selected>Pilih lokasi user</option>
                                            <option value="Sekolah">SEKOLAH</option>
                                            <option value="Perguruan Tinggi">PERGURUAN TINGGI</option>
                                            <option value="Pondok Pesantren">PONDOK PESANTREN</option>
                                            <option value="Perkantoran">PERKANTORAN</option>
                                            <option value="Pasar">PASAR</option>
                                            <option value="Rumah Sakit/Puskesmas">RS/PUSKESMAS</option>
                                            <option value="Resto">RUMAH MAKAN/RESTO</option>
                                            <option value="Industri">INDUSTRI</option>
                                            <option value="Lapas">LAPAS</option>
                                            <option value="Hotel">PENGINAPAN/HOTEL/WISMA</option>
                                            <option value="Terminal">TERMINAL</option>
                                            <option value="Pelabuhan">PELABUHAN PENUMPANG</option>
                                            <option value="Tempat Wisata">TEMPAT WISATA</option>
                                            <option value="Taman Kota/Hutan Kota">TAMAN KOTA/HUTAN KOTA</option>
                                            <option value="Pemukiman">PEMUKIMAN</option>
                                            <option value="Ritel Modern">RITEL MODERN</option>
                                            <option value="ADMIN">ADMIN</option>
                                        </select>
                                    </div>
                    
                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-success btn-lg">Tambah User</button>
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