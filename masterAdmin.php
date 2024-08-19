<?php
include 'connect.php';
session_start();

if (!isset($_SESSION['session_username'])) {
    header("location:login");
    exit();
}

// Query to fetch data from the database
$query = "SELECT * FROM data_order;";
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();
$no = 0;
?>

<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>masterAdmin User</title>
    <!-- Favicon -->
    <link rel="shortcut icon" href="..\img\icon\logo.png">
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css"/>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
    <script src="https://kit.fontawesome.com/e56a8fc2bc.js" crossorigin="anonymous"></script>
    <style>
        .list-footer {
            font-size: 12px;
            margin-bottom: auto;
            color: #76a5af;
        }
        .logout-btn {
            border: 2px solid blue;
            color: blue;
            background-color: white;
            text-decoration: none;
        }
        .logout-btn:hover {
            background-color: red;
            color: white;
        }
        .logout-btn:active {
            font-weight: bold;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg bg-body-tertiary sticky-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="">
            <img src="img/icon/logofifgroup.png" alt="logo" style="margin-left: 50px; margin-top: 20px;">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="masterAdmin">Admin</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="Track">Track</a>
                </li>
            </ul>
            <form class="d-flex" role="search">
                <a href="logout" class="btn logout-btn" onclick="handleLogoutClick(event)">Logout</a>
            </form>
        </div>
    </div>
</nav>

<!-- Content -->
<div class="container">
    <h1 class="me-auto">Data Customer</h1>
    <figure>
        <blockquote class="blockquote">
            <p>Berisi data yang telah disimpan di Database</p>
        </blockquote>
        <figcaption class="blockquote-footer">
            CRUD <cite title="Source Title">Create Read Update Delete</cite>
        </figcaption>
    </figure>
    <a href="addData" type="button" class="btn btn-primary mb-2">
        <i class="fa fa-plus"></i> Tambah Data
    </a>

    <!-- Alert -->
    <?php
    $message = $_SESSION['eksekusi'] ?? $_SESSION['hapus'] ?? $_SESSION['edit'] ?? "";
    ?>

    <?php if (!empty($message)): ?>
    <div id="myAlert" class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fa fa-check" aria-hidden="true"></i>
        <strong><?php echo htmlspecialchars($message); ?></strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

    <script>
        setTimeout(function() {
            document.querySelector('#myAlert').remove();
        }, 3000);
    </script>
    <?php endif; ?>
    <?php session_unset(); ?>
    <!-- Table -->
    <div class="table-responsive">
        <table id="dt" class="table align-middle table-hover border cell-border">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">No Order</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Gender</th>
                    <th scope="col">Alamat</th>
                    <th scope="col">KTP</th>
                    <th scope="col">KK</th>
                    <th scope="col">Jenis Pinjaman</th>
                    <th scope="col">Status Order</th>
                    <th scope="col">Created</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <th scope="row"><?php echo ++$no; ?></th>
                    <td><?php echo htmlspecialchars($row['id_cust']); ?></td>
                    <td><?php echo htmlspecialchars($row['nama_cust']); ?></td>
                    <td><?php echo htmlspecialchars($row['gender']); ?></td>
                    <td><?php echo htmlspecialchars($row['alamat']); ?></td>
                    <td><img src="img/data_image/ktp/<?php echo htmlspecialchars($row['ktp']); ?>" alt="ktp" style="width: 150px;"></td>
                    <td><img src="img/data_image/kk/<?php echo htmlspecialchars($row['kartu_keluarga']); ?>" alt="kk" style="width: 150px;"></td>
                    <td><?php echo htmlspecialchars($row['jenis_pinjaman']); ?></td>
                    <td><?php echo htmlspecialchars($row['status_order']); ?></td>
                    <td><?php echo htmlspecialchars($row['created']); ?></td>
                    <td>
                        <a href="addData?ubah=<?php echo htmlspecialchars($row['id_cust']); ?>" type="button" class="btn btn-primary btn-sm">
                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit
                        </a>
                        <a href="process.php?hapus=<?php echo htmlspecialchars($row['id_cust']); ?>" type="button" class="btn btn-danger btn-sm" onclick="return confirm('Apakah anda yakin ingin menghapus data tersebut?')">
                            <i class="fa fa-trash-o" aria-hidden="true"></i> Delete
                        </a>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Copyright -->
<footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top Copyright" style="margin-bottom: 0 !important; padding-bottom: 0 !important; background-color: #4a4a4a; color: white; justify-content: flex-end;">
    <div class="col-md-4 d-flex align-items-center">
      <a href="/" class="mb-3 me-2 mb-md-0 text-body-secondary text-decoration-none lh-1">
        <svg class="bi" width="30" height="24"><use xlink:href="#bootstrap"/></svg>
      </a>
      <p class="mb-3 mb-md-0" style="font-size: 12px; color: white;">&copy; PT Federal International Finance "FIFGROUP" 2024, Berizin dan diawasi oleh Otoritas Jasa Keuangan</p>
    </div>
    <ul class="nav col-md-4 justify-content-end list-unstyled d-flex">
      <li class="ms-3" style="margin-right: 50px; font-size: 12px;">
        <p>
          <a href="https://www.fifgroup.co.id/kebijakan-privasi" style="color: white;">Privacy Policy</a> | 
          <a href="https://www.fifgroup.co.id/" style="color: white;">Terms of Services</a>
        </p>
      </li>
    </ul>
</footer>  
<!-- Copyright -->

<!-- Scripts -->
<script>
    $(document).ready(function () {
        $('#dt').DataTable();
    });

    function handleLogoutClick(event) {
        event.preventDefault(); // Prevent the default anchor action
        if (confirm('Are you sure you want to log out?')) {
            // If the user confirms, proceed with logout
            window.location.href = 'logout';
        }
    }
</script>
</body>
</html>
