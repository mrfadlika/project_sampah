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

    // Hapus session status setelah ditampilkan
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

            <li class="nav-item active">
                <a class="nav-link" href="tables.php">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Table User</span></a>
            </li>

            <li class="nav-item">
    <a class="nav-link" href="report_filter.php">
        <i class="fas fa-fw fa-file-alt"></i>
        <span>Report Data</span></a>
</li>

<li class="nav-item">
    <a class="nav-link" href="form_export.php">
        <i class="fas fa-fw fa-download"></i>
        <span>Export Excel</span></a>
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
                        <h1 class="h3 mb-0 text-gray-800">Admin Pages</h1>
                    </div>
                    <div class="container-fluid py-4">
                        <div class="card-header text-center bg-success text-white">
                            <h4 class="mb-0">Daftar User</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr class="text-center">
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Nomor HP</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    include "api/db_connection.php";
                                    $sql = "SELECT * FROM users";
                                    $result = mysqli_query($conn, $sql);

                                    if (mysqli_num_rows($result) > 0) {
                                        $no = 1;
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            echo "<tr class='text-center'>";
                                            echo "<td class='text-center'>" . $no . "</td>";
                                            echo "<td>" . htmlspecialchars($row['nama']) . "</td>";
                                            echo "<td>" . htmlspecialchars($row['username']) . "</td>";
                                            echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                                            echo "<td>" . htmlspecialchars($row['role']) . "</td>";
                                            echo "<td>" . htmlspecialchars($row['nomor_telp']) . "</td>";
                                            echo "<td class='text-center'>
                                                    <a href='edit_user.php?id=" . $row['id'] . "' class='btn btn-sm btn-primary'>Edit</a>
                                                    <a href='javascript:void(0)' class='btn btn-sm btn-danger' onclick='confirmDelete(" . $row['id'] . ")'>Delete</a>
                                                  </td>";
                                            echo "</tr>";
                                            $no++;
                                        }
                                    } else {
                                        echo "<tr><td colspan='7' class='text-center'>No users found</td></tr>";
                                    }

                                    mysqli_close($conn);
                                    ?>
                                </tbody>
                            </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SweetAlert Script -->
    <script>
        function confirmDelete(userId) {
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
                    window.location.href = `api/delete_user.php?id=${userId}`;
                }
            })
        }
    </script>

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
