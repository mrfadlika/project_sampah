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

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                

                </nav>

                <div class="container-fluid">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Form Pelaporan</h1>
                    </div>

                    <div class="container-fluid d-flex justify-content-center align-items-center vh-20">
                        <div class="card shadow-lg" style="width: 100%; max-width: 800px;">
                            <div class="card-header text-center bg-success text-white">
                                <h4 class="mb-0">Daur Ulang Sampah</h4>
                            </div>
                            <div class="card-body">
                                <form action="api/db_daur_ulang.php" method="post" enctype="multipart/form-data">
                                    <!-- Nama Tempat -->
                                    <div class="mb-4">
                                        <label for="namaTempat" class="form-label fw-semibold">Nama Tempat</label>
                                        <input type="text" class="form-control" id="namaTempat" value="<?php echo $row['role'] ?>" disabled>
                                    </div>
                    
                                    <!-- Pilihan Jenis Sampah -->
                                    <div class="mb-4">
                                        <label for="jenisSampah" class="form-label fw-semibold">Jenis Sampah</label>
                                        <select class="form-select" id="jenisSampah" name="jenis_sampah" required onchange="toggleFormFields()">
                                            <option value="" disabled selected>Pilih Jenis Sampah</option>
                                            <option value="anorganik">Anorganik</option>
                                            <option value="organik">Organik</option>
                                        </select>
                                    </div>
                    
                                    <!-- Tanggal -->
                                    <div class="mb-4">
                                        <label for="tanggal" class="form-label fw-semibold">Tanggal</label>
                                        <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                                    </div>
                    
                                    <!-- Form Anorganik -->
                                    <div id="formAnorganik" class="d-none">
                                        <h5 class="fw-semibold">Anorganik</h5>
                                        <p>Pendauran ulang sampah anorganik dapat dikelola melalui Bank Sampah. Unit, Bank Sampah Pusat, Vendor yang menyediakan jasa pengumpulan sampah anorganik atau melalui kegiatan sedekah sampah</p>
                                        <div class="mb-3">
                                            <label for="kertas" class="form-label">Kertas</label>
                                            <input type="number" class="form-control" id="kertas" name="kertas" placeholder="Masukkan jumlah (KG)">
                                        </div>
                                        <div class="mb-3">
                                            <label for="karton" class="form-label">Karton</label>
                                            <input type="number" class="form-control" id="karton" name="karton" placeholder="Masukkan jumlah (KG)">
                                        </div>
                                        <div class="mb-3">
                                            <label for="botolPlastik" class="form-label">Botol/Gelas Plastik</label>
                                            <input type="number" class="form-control" id="botolPlastik" name="botol_plastik" placeholder="Masukkan jumlah (KG)">
                                        </div>
                                        <div class="mb-3">
                                            <label for="besi" class="form-label">Besi</label>
                                            <input type="number" class="form-control" id="besi" name="besi" placeholder="Masukkan jumlah (KG)">
                                        </div>
                                        <div class="mb-3">
                                            <label for="aluminium" class="form-label">Aluminium</label>
                                            <input type="number" class="form-control" id="aluminium" name="aluminium" placeholder="Masukkan jumlah (KG)">
                                        </div>
                                        <div class="mb-3">
                                            <label for="lainnyaAnorganik" class="form-label">Lainnya</label>
                                            <input type="number" class="form-control" id="lainnyaAnorganik" name="lainnya_anorganik" placeholder="Masukkan jumlah (KG)">
                                        </div>
                                    </div>
                    
                                    <!-- Form Organik -->
                                    <div id="formOrganik" class="d-none">
                                        <h5 class="fw-semibold">Organik</h5>
                                        <p>Pendauran ulang sampah organik dapat dilakukan dengan pengomposan</p>
                                        <div class="mb-3">
                                            <label for="pengomposan" class="form-label">Pengomposan</label>
                                            <input type="number" class="form-control" id="spengomposan" name="pengomposan" placeholder="Masukkan jumlah (KG)">
                                        </div>
                                        <div class="mb-3">
                                            <label for="ecoEnzim" class="form-label">Eco Enzim</label>
                                            <input type="number" class="form-control" id="ecoEnzim" name="eco_enzim" placeholder="Masukkan jumlah (KG)">
                                        </div>
                                        <div class="mb-3">
                                            <label for="lainnyaOrganik" class="form-label">Lainnya</label>
                                            <input type="number" class="form-control" id="lainnyaOrganik" name="lainnya_organik" placeholder="Masukkan jumlah (KG)">
                                        </div>
                                    </div>

                                    <div class="mb-4">
                      <label for="uploadFoto" class="form-label fw-semibold"
                        >Unggah Foto Bukti</label
                      >
                      <input
                        type="file"
                        class="form-control"
                        id="uploadFoto"
                        name="uploadFoto"
                        accept=".jpg, .jpeg, .png"
                        required
                      />
                      <small class="text-muted"
                        >Hanya diperbolehkan file gambar (.jpg, .jpeg,
                        .png)</small
                      >
                    </div>
                    
                                    <!-- Tombol Submit -->
                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-primary btn-lg">Submit</button>
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

    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>
    <script src="vendor/chart.js/Chart.min.js"></script>
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>

    <script>
        function toggleFormFields() {
            const jenisSampah = document.getElementById('jenisSampah').value;
            const formAnorganik = document.getElementById('formAnorganik');
            const formOrganik = document.getElementById('formOrganik');
    
            if (jenisSampah === 'anorganik') {
                formAnorganik.classList.remove('d-none');
                formOrganik.classList.add('d-none');
            } else if (jenisSampah === 'organik') {
                formOrganik.classList.remove('d-none');
                formAnorganik.classList.add('d-none');
            } else {
                formAnorganik.classList.add('d-none');
                formOrganik.classList.add('d-none');
            }
        }
    </script>

</body>

</html>