<?php
include 'api/check_sesi.php';
include 'api/db_check.php';
include 'api/db_connection.php';

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
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
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

            <li class="nav-item active">
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
                        <h1 class="h3 mb-0 text-gray-800">Kelola Data</h1>
                    </div>
                    <div class="container-fluid py-4">
                    </div>
                    <div class="card-body">
                        <!-- Filter -->
                        <form id="filter-form" method="post">
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="tanggal" class="form-label">Tanggal</label>
                                    <input type="date" name="tanggal" id="tanggal" class="form-control">
                                </div>
                                <div class="col-md-4 d-flex align-items-end">
                                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                                </div>
                            </div>
                        </form>

                        <div id="table-hide" class="table-responsive">
                            <?php
                            $columns = [
                                'jenis_sampah' => false,
                                'kertas' => false,
                                'karton' => false,
                                'botol_pet' => false,
                                'aluminium' => false,
                                'plastik' => false,
                                'besi' => false,
                                'botol_kaca' => false,
                                'minyak_jelantah' => false,
                                'lainnya_anorganik' => false,
                                'pengomposan' => false,
                                'maggot' => false,
                                'eco_enzim' => false,
                            ];

                            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                                $tanggal = $_POST['tanggal'] ?? null;
                                if ($tanggal) {
                                    $sql = "SELECT * FROM bank_sampah WHERE tanggal = '$tanggal' ORDER BY tanggal DESC";
                                    $result = $conn->query($sql);

                                    if ($result->num_rows > 0) {
                                        $data = [];
                                        while ($row = $result->fetch_assoc()) {
                                            $data[] = $row;

                                            foreach ($columns as $key => &$show) {
                                                if (isset($row[$key]) && $row[$key] != 0) {
                                                    $show = true;
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                            ?>

                            <table class="table table-striped table-hover">
                                <thead id="table-head" class="text-center">
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <?php foreach ($columns as $key => $show): ?>
                                            <?php if ($show): ?>
                                                <th><?= ucfirst(str_replace('_', ' ', $key)) ?></th>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    <?php if (!empty($data)): ?>
                                        <?php $no = 1; ?>
                                        <?php foreach ($data as $row): ?>
                                            <tr>
                                                <td><?= $no++ ?></td>
                                                <td><?= $row['tanggal'] ?></td>
                                                <?php foreach ($columns as $key => $show): ?>
                                                    <?php if ($show): ?>
                                                        <td><?= $row[$key] ?></td>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                                <td>
                                                    <button class="btn btn-warning btn-sm"
                                                        onclick="editData('<?= $row['id'] ?>')">Edit</button>
                                                    <button class="btn btn-danger btn-sm"
                                                        onclick="deleteData('<?= $row['id'] ?>')">Delete</button>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="<?= count($columns) + 3 ?>">No data available</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>

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

    <script>
        function validateForm() {
            const tanggal = document.getElementById('tanggal').value;
            if (!tanggal) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Please select a date',
                    showConfirmButton: true
                });
                return false;
            }
            return true;
        }

        function deleteData(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = `api/delete_bank_sampah.php?id=${id}`;
                }
            });
        }

        function editData(id) {
            window.location.href = `edit_bank_sampah.php?id=${id}`;
        }
    </script>

    <script src="vendor/jquery/jquery.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>
    <script src="vendor/chart.js/Chart.min.js"></script>
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>

</body>

</html>