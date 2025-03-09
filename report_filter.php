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
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="css/page.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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

<li class="nav-item active">
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
                    <div class="card-body">
                    <form id="filter-form" method="get">
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="table-select" class="form-label">Pilih Tabel</label>
            <select class="form-select" name="table" id="table-select" required>
                <option value="pembatasan">Pembatasan Penimbulan Sampah</option>
                <option value="pemanfaatan">Pemanfaatan Kembali</option>
                <option value="daur_ulang">Daur Ulang Sampah</option>
                <option value="bank_sampah">Bank Sampah</option>
            </select>
        </div>
        <div class="col-md-4">
            <label for="role-select" class="form-label">Pilih Role</label>
            <select class="form-select" name="role" id="role-select" required>
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
                                            <option value="Admin">ADMIN</option>
                                            <option value="Bank Sampah">BANK SAMPAH</option>
            </select>
        </div>
        <div class="col-md-4">
            <label for="username-select" class="form-label">Pilih Username</label>
            <select class="form-select" name="username" id="username-select" required>
                <!-- Dynamic options for usernames will be populated here -->
            </select>
        </div>
        <div class="col-md-4">
            <label for="tanggal" class="form-label">Tanggal</label>
            <input type="date" name="tanggal" id="tanggal" class="form-control">
        </div>
        <div class="col-md-4 d-flex align-items-end">
            <button type="submit" class="btn btn-primary w-100">Filter</button>
        </div>
    </div>
</form>


                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead id="table-head" class="text-center"></thead>
                                <tbody id="table-body" class="text-center"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


<script>
    document.getElementById('role-select').addEventListener('change', function(e) {
    const role = e.target.value;
    const usernameSelect = document.getElementById('username-select');
    
    usernameSelect.innerHTML = '<option value="">Pilih Username</option>';

    if (role) {
        fetch(`api/get_username.php?role=${role}`)
            .then(response => response.json())
            .then(data => {
                data.forEach(user => {
                    const option = document.createElement('option');
                    option.value = user.username;
                    option.textContent = user.username;
                    usernameSelect.appendChild(option);
                });
            })
            .catch(err => console.error('Error fetching usernames:', err));
    }
});

</script>

<script>
document.getElementById('filter-form').addEventListener('submit', function (e) {
    e.preventDefault();  // Prevent form submission

    const formData = new FormData(this);  // Get form data

    // Send AJAX request with form data
    fetch('api/filter_admin.php', {
        method: 'POST', 
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        // Handle the filtered data (display in a table)
        displayFilteredData(data);
    })
    .catch(error => {
        console.error('Error submitting form data:', error);
    });
});

function displayFilteredData(response) {
    const tableHead = document.getElementById('table-head');
    const tableBody = document.getElementById('table-body');

    console.log("Response from PHP:", response);
    tableHead.innerHTML = ''; 
    tableBody.innerHTML = ''; 

    // Validate response structure
    if (!response || !response.data || response.data.length === 0) {
        console.log("No data to display.");
        tableBody.innerHTML = '<tr><td colspan="100%" class="text-center text-danger">No data found.</td></tr>';
        return;
    }

    // Create table headers
    const headers = response.headers;
    console.log("Headers:", headers);
    const headerRow = document.createElement('tr');

    headers.forEach(header => {
        const th = document.createElement('th');
        th.textContent = header;
        headerRow.appendChild(th);
    });

    tableHead.appendChild(headerRow);

    // Populate table body with data
    response.data.forEach((item, index) => {
        const row = document.createElement('tr');
        let hasData = false; // Flag to check if the row has data

        headers.forEach(header => {
            const td = document.createElement('td');
            if (header === 'No') {
                td.textContent = index + 1; // Add sequential number
                hasData = true;
            } else if (header === 'Actions') {
                // Create View button with dynamic link
                const viewButton = document.createElement('a');
                viewButton.textContent = 'View';
                viewButton.className = 'btn btn-info text-white'; // Add Bootstrap classes for styling
                const tableName = response.data[index].table;
                const itemId = item.id;
                viewButton.href = 'view_detail.php?table=' + tableName + '&id=' + itemId;
                td.appendChild(viewButton);
                hasData = true;
            } else {
                const key = header.replace(/\s+/g, '_').toLowerCase();
                td.textContent = item[key] || ''; // Use key to access item data
                if (item[key]) hasData = true; // If there is data, mark hasData as true
            }
            row.appendChild(td);
        });

        if (hasData) {
            tableBody.appendChild(row); // Append row to table only if it has data
        }
    });
}

</script>

<!-- <script>
    document.getElementById('filter-form').addEventListener('submit', function(e) {
    e.preventDefault();

    const formData = new FormData(e.target);
    fetch('api/filter_admin.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        const headers = data.headers;
        const rows = data.data;

        const tableHead = document.getElementById('table-head');
        tableHead.innerHTML = '';
        let headRow = '<tr>';
        headers.forEach(header => {
            if (header !== 'Actions') {
                headRow += `<th>${header}</th>`;
            }
        });
        headRow += '<th>Actions</th>';
        headRow += '</tr>';
        tableHead.innerHTML = headRow;

        const tableBody = document.getElementById('table-body');
        tableBody.innerHTML = '';
        rows.forEach((row, index) => {
            let bodyRow = `<tr data-id="${row.id}">`; 
            bodyRow += `<td>${index + 1}</td>`; 
            for (const key in row) {
                if (key !== 'id' && key !== 'table') {
                    bodyRow += `<td>${row[key]}</td>`;
                }
            }

            const tableParam = row.table || ''; 
            console.log('Table parameter:', tableParam);

            bodyRow += `
                <td>
                    <a href="javascript:void(0)" class="btn btn-primary btn-sm" onclick="viewDetail('${tableParam}', ${row.id})">View</button>
                </td>`;
            bodyRow += '</tr>';
            tableBody.innerHTML += bodyRow;
        });
    })
    .catch(err => console.error('Error:', err));
});

    function viewDetail(tableParam, id) {
        window.location.href = `view_detail.php?table=${tableParam}&id=${id}`;
    }

</script> -->

<script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>
    <script src="vendor/chart.js/Chart.min.js"></script>
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>
</body>
</html>
