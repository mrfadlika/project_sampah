<?php
include 'api/edit_bank_sampah.php';
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

            <li class="nav-item">
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
                        <h1 class="h3 mb-0 text-gray-800">Edit Data Bank Sampah</h1>
                    </div>
                    <div class="container-fluid py-4">
                        <div class="card shadow mb-5">
                            <div class="card-header text-center bg-success text-white">
                                <h4 class="mb-0">Form Bank Sampah</h4>
                            </div>
                            <div class="card-body">
                                <form id="add_user" action="api/edit_bank_sampah.php?id=<?php echo $baris['id'] ?>" method="post">
                    
                                    <div class="mb-4">
                                        <label for="kertas" class="form-label fw-semibold">Kertas</label>
                                        <input type="number" class="form-control" id="kertas" name="kertas" value="<?php echo $baris['kertas'] ?>" placeholder="Input Kertas (KG)" required>
                                    </div>
                                    
                                    <div class="mb-4">
                                        <label for="karton" class="form-label fw-semibold">Karton</label>
                                        <input type="number" class="form-control" id="karton" name="karton" value="<?php echo $baris['karton'] ?>" placeholder="Input Karton (KG)" required>
                                    </div>
                                    
                                    <div class="mb-4">
                                        <label for="botolPlastik" class="form-label fw-semibold">Botol PET</label>
                                        <input type="number" class="form-control" id="botolPlastik" name="botol_pet" value="<?php echo $baris['botol_pet'] ?>" placeholder="Input Botol PET (KG)" required>
                                    </div>
                                    
                                    <div class="mb-4">
                                        <label for="aluminium" class="form-label fw-semibold">Botol PET</label>
                                        <input type="number" class="form-control" id="aluminium" name="aluminium" value="<?php echo $baris['aluminium'] ?>" placeholder="Input Aluminium (KG)" required>
                                    </div>

                                    <div class="mb-4">
                                        <label for="plastik" class="form-label fw-semibold">Botol PET</label>
                                        <input type="number" class="form-control" id="plastik" name="plastik" value="<?php echo $baris['plastik'] ?>" placeholder="Input Plastik (KG)" required>
                                    </div>

                                    <div class="mb-4">
                                        <label for="besi" class="form-label fw-semibold">Besi</label>
                                        <input type="number" class="form-control" id="besi" name="besi" value="<?php echo $baris['besi'] ?>" placeholder="Input Besi (KG)" required>
                                    </div>

                                    <div class="mb-4">
                                        <label for="botolKaca" class="form-label fw-semibold">Botol Kaca</label>
                                        <input type="number" class="form-control" id="botolKaca" name="botol_kaca" value="<?php echo $baris['botol_kaca'] ?>" placeholder="Input Botol (PCS)" required>
                                    </div>

                                    <div class="mb-4">
                                        <label for="minyakJelantah" class="form-label fw-semibold">Minyak Jelantah</label>
                                        <input type="number" class="form-control" id="minyakJelantah" name="minyak_jelantah" value="<?php echo $baris['minyak_jelantah'] ?>" placeholder="Input Minyak Jelantah (KG)" required>
                                    </div>

                                    <div class="mb-4">
                                        <label for="lainnyaAnorganik" class="form-label fw-semibold">Lainnya (Anorganik)</label>
                                        <input type="number" class="form-control" id="lainnyaAnorganik" name="lainnya_anorganik" value="<?php echo $baris['lainnya_anorganik'] ?>" placeholder="Input Lainnya (KG)" required>
                                    </div>

                                    <div class="mb-4">
                                        <label for="pengomposan" class="form-label fw-semibold">Pengomposan</label>
                                        <input type="number" class="form-control" id="pengomposan" name="pengomposan" value="<?php echo $baris['pengomposan'] ?>" placeholder="Input Pengomposan (KG)" required>
                                    </div>

                                    <div class="mb-4">
                                        <label for="maggot" class="form-label fw-semibold">Maggot</label>
                                        <input type="number" class="form-control" id="maggot" name="maggot" value="<?php echo $baris['maggot'] ?>" placeholder="Input Maggot (KG)" required>
                                    </div>

                                    <div class="mb-4">
                                        <label for="ecoEnzim" class="form-label fw-semibold">Eco Enzim</label>
                                        <input type="number" class="form-control" id="ecoEnzim" name="eco_enzim" value="<?php echo $baris['eco_enzim'] ?>" placeholder="Input Eco Enzim (KG)" required>
                                    </div>
                    
                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-success btn-lg">Update</button>
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