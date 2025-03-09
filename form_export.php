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
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link href="css/page.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body id="page-top">

    <div id="wrapper">

        <ul class="navbar-nav bg-gradient-success sidebar sidebar-dark accordion" id="accordionSidebar">
            <!-- Sidebar content sama seperti sebelumnya -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="admin.html">
                <div class="sidebar-brand-text mx-1" style="height: 1px;">SISTEM INFORMASI PENGELOLAAN SAMPAH</div>
            </a>

            <hr class="sidebar-divider my-6" style="margin-top: 60px;">

            <li class="nav-item dropdown no-arrow">
                <span class="text-white">
                    <h6 style="text-align: center;"><?php echo $row['nama'] ?></h6>
                </span>
                <a class="nav-link collapsed d-flex align-items-center justify-content-center p-0" href="#"
                    data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseTwo">
                    <div style="text-align: center;">
                        <span>
                            <p class="my-2 mr-2 mb-2"><?php echo $row['role'] ?></p>
                        </span>
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

            <li class="nav-item active">
                <a class="nav-link" href="form_export.php">
                    <i class="fas fa-fw fa-download"></i>
                    <span>Export Excel</span></a>
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
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Export Data Laporan</h6>
                        </div>
                        <div class="card-body">
                            <form id="exportForm" action="api/process_export.php" method="POST">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="tanggal_awal" class="form-label">Tanggal Awal</label>
                                        <input type="date" class="form-control" name="tanggal_awal" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="tanggal_akhir" class="form-label">Tanggal Akhir</label>
                                        <input type="date" class="form-control" name="tanggal_akhir" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="role" class="form-label">Pilih Lokasi User</label>
                                        <select class="form-select" name="role" required>
                                            <option value="" disabled selected>Pilih lokasi user</option>
                                            <option value="Sekolah">SEKOLAH</option>
                                            <option value="Perguruan Tinggi">PERGURUAN TINGGI</option>
                                            <option value="Pondok Pesantren">PONDOK PESANTREN</option>
                                            <option value="Perkantoran">PERKANTORAN</option>
                                            <option value="Pasar">PASAR</option>
                                            <option value="Rumah Sakit">RS/PUSKESMAS</option>
                                            <option value="Resto">RUMAH MAKAN/RESTO</option>
                                            <option value="Industri">INDUSTRI</option>
                                            <option value="Lapas">LAPAS</option>
                                            <option value="Hotel">PENGINAPAN/HOTEL/WISMA</option>
                                            <option value="Terminal">TERMINAL</option>
                                            <option value="Pelabuhan">PELABUHAN PENUMPANG</option>
                                            <option value="Tempat Wisata">TEMPAT WISATA</option>
                                            <option value="Taman Kota">TAMAN KOTA/HUTAN KOTA</option>
                                            <option value="Pemukiman">PEMUKIMAN</option>
                                            <option value="Ritel Modern">RITEL MODERN</option>
                                            <option value="Bank Sampah">BANK SAMPAH</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6" style="align-self: flex-end; margin-top: 15px;">
                                        <label class="form-label">
                                            <input type="checkbox" id="exportCheckbox"> Satukan data
                                        </label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <button type="submit" class="btn btn-primary"
                                            onclick="updateFormAction()">Export ke Excel</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function updateFormAction() {
            const checkbox = document.getElementById('exportCheckbox');
            const form = document.getElementById('exportForm');

            // Periksa apakah checkbox dicentang
            if (checkbox.checked) {
                form.action = 'api/process_export2.php';
            } else {
                form.action = 'api/process_export.php';
            }
        }
    </script>

    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>