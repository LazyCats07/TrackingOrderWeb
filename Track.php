<?php
  include 'connect.php';
  session_start();

  // Default query to show no records
  $query = "";
  $isSearch = false;

  if(isset($_POST['tombolsearch'])){
    $cari = $_POST['cari'];

    // Prepare a parameterized query to prevent SQL Injection
    $stmt = $conn->prepare("SELECT id_cust, nama_cust, jenis_pinjaman, status_order, created FROM data_order WHERE id_cust = ?");
    $stmt->bind_param("s", $cari); // 's' specifies the type of the parameter (string)
    $stmt->execute();
    $result = $stmt->get_result();
    $isSearch = true;
  } else {
    $stmt = $conn->prepare("SELECT id_cust, nama_cust, jenis_pinjaman, status_order, created FROM data_order");
    $stmt->execute();
    $result = $stmt->get_result();
  }
?>

<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FIFGROUP - Status Order | FIFGROUP - PT. Federal International Finance</title>
    <link rel="stylesheet" href="css/styleTrack.css">
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
</head>

<body>
<!-- Navbar -->
<nav class="navbar navbar-expand-lg bg-body-tertiary sticky-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="https://www.fifgroup.co.id/">
            <img src="img/icon/logofifgroup.png" alt="logo" style="margin-left: 50px; margin-top: 20px;">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="https://www.fifgroup.co.id/">Home</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Layanan Kami
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="https://www.fifgroup.co.id/fifastra">FIFASTRA</a></li>
                        <li><a class="dropdown-item" href="https://www.fifgroup.co.id/spektra">SPEKTRA</a></li>
                        <li><a class="dropdown-item" href="https://www.fifgroup.co.id/danastra">DANASTRA</a></li>
                        <li><a class="dropdown-item" href="https://www.fifgroup.co.id/finatra">FINATRA</a></li>
                        <li><a class="dropdown-item" href="https://www.fifgroup.co.id/amitra">AMITRA</a></li>
                        <li><a class="dropdown-item" href="https://www.fifgroup.co.id/fleet">FLEET</a></li>
                        <li><a class="dropdown-item" href="https://www.fifgroup.co.id/fifgroup-card">FIFGROUP CARD</a></li>
                        <li><a class="dropdown-item" href="https://www.fifgroup.co.id/fifgroup-mobile-customer">FIFGROUP MOBILE CUSTOMER</a></li>
                        <li><a class="dropdown-item" href="https://www.fifgroup.co.id/mitra-fifgroup">MITRA FIFGROUP</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Informasi Perusahaan
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="https://www.fifgroup.co.id/informasi-perusahaan/informasi-umum">Informasi Umum</a></li>
                        <li><a class="dropdown-item" href="https://www.fifgroup.co.id/informasi-perusahaan/hubungan-investor">Hubungan Investor</a></li>
                        <li><a class="dropdown-item" href="https://www.fifgroup.co.id/informasi-perusahaan/informasi-tata-kelola">Informasi Tata Kelola</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Berita Korporasi
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="https://www.fifgroup.co.id/berita/csr">BERITA CSR</a></li>
                        <li><a class="dropdown-item" href="https://www.fifgroup.co.id/berita/siaran-pers">SIARAN PERS</a></li>
                        <li><a class="dropdown-item" href="https://www.fifgroup.co.id/berita/artikel">ARTIKEL</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="https://karir-rise.fifgroup.co.id/?_gl=1*1mh1e5b*_gcl_au*MTMzMTkxNjY0MS4xNzIwMTcxMDcz*_ga*MzQyMzk0OTkzLjE3MjAxNzEwNzM.*_ga_21M28N9CND*MTcyMTI4OTgyNS4zMS4xLjE3MjEyOTA5NDAuNTQuMC4w">Karir</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<!-- Banner -->
<img src="img/icon/banner.png" alt="logo" style="max-width: 100%; height: auto;">



<!-- Search Page -->
<div class="container">
    <form id="cekStatusOrder" method="POST">
    <div class="input-group mb-3 searchButton" style="margin-top:20px; width:500px;">
        <!-- <input type="text" class="form-control sm" id="cari" name="cari" placeholder="Masukkan No. Order" required maxlength="10" aria-label="Recipient's username" aria-describedby="button-addon2"> -->
        <input type="text" class="form-control sm" id="cari" name="cari" placeholder="Masukkan No. Order" required maxlength="10" aria-label="Recipient's username" aria-describedby="button-addon2">
        <button class="btn btn-outline-primary" type="submit" name="tombolsearch" id="button-addon2">Search</button>
    </div>
    </form>
    <div id="result"></div>
</div>

<!-- Tabel Data Order -->
<?php if ($isSearch && $result && $result->num_rows > 0): ?>
<div class="table-responsive" style="margin-bottom: 100px;">
    <table id="dt" class="table align-middle table-hover border cell-border">
        <thead>
            <tr>
                <th scope="col"><Nav>No Order</Nav></th>
                <th scope="col">Nama</th>
                <th scope="col">Jenis Pinjaman</th>
                <th scope="col">Status Order</th>
                <th scope="col">Created</th>
            </tr>
        </thead>
        <tbody>
        <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['id_cust']); ?></td>
                <td><?php echo htmlspecialchars($row['nama_cust']); ?></td>
                <td><?php echo htmlspecialchars($row['jenis_pinjaman']); ?></td>
                <td><?php echo htmlspecialchars($row['status_order']); ?></td>
                <td><?php echo htmlspecialchars($row['created']); ?></td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>
<?php elseif ($isSearch): ?>
<div class="container">
    <p>Data tidak ditemukan.</p>
</div>
<?php endif; ?>

<script>
document.getElementById('cari').addEventListener('input', function (e) {
        const input = e.target;
        const value = input.value;

        // Hanya izinkan angka dan satu simbol "/" atau "-"
        const regex = /^[0-9]*([/-]{0,1}[0-9]*)*$/;

        // Simpan posisi kursor
        const cursorPos = input.selectionStart;

        if (!regex.test(value)) {
            // Jika input tidak sesuai, kembalikan ke nilai sebelumnya
            input.value = input.dataset.prevValue || '';
            // Kembalikan posisi kursor
            input.setSelectionRange(cursorPos - 1, cursorPos - 1);
        } else {
            // Simpan nilai yang valid
            input.dataset.prevValue = value;
        }
});
</script>
</body>
</html>
