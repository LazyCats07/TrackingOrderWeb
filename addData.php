<?php 
    include 'connect.php';
    // session_start();

    $id_cust = '';
    $nama_cust = '';
    $gender = '';
    $alamat = '';
    $jenis_pinjaman = '';
    $status_order = '';
    $created = '';
    $no = '';

    if (isset($_GET['ubah'])) { 
        $id_cust = $_GET['ubah'];
        $query = "SELECT * FROM data_order WHERE id_cust = '$id_cust';";
        $sql = mysqli_query($conn, $query);
        $result = mysqli_fetch_assoc($sql);
        
        $id_cust = $result['id_cust'];
        $nama_cust = $result['nama_cust'];
        $gender = $result['gender'];
        $alamat = $result['alamat'];
        $jenis_pinjaman = $result['jenis_pinjaman'];
        $status_order = $result['status_order'];
        $created = $result['created'];
        $no = $result['no'];
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MasterAdmin User</title>
    <!-- Favicon -->
    <link rel="shortcut icon" href="../img/icon/logo.png">
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.bundle.min.js"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
<!-- Bagian Pemberitahuan -->
<?php if(isset($_SESSION['error'])): ?>
    <div style="color: red; font-weight: bold;">
        <?php
            echo $_SESSION['error'];
            unset($_SESSION['error']); // Hapus session setelah ditampilkan
        ?>
    </div>
<?php endif; ?>

<?php if(isset($_SESSION['success'])): ?>
    <div style="color: green; font-weight: bold;">
        <?php
            echo $_SESSION['success'];
            unset($_SESSION['success']); // Hapus session setelah ditampilkan
        ?>
    </div>
<?php endif; ?>

<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="addData">
            <img src="img/icon/logofifgroup.png" alt="logo" style="margin-left: 50px; margin-top: 20px;">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            </ul>
        </div>
    </div>
</nav>

<!-- Judul Page -->
<div class="inputdata">
    <h1 class="me-auto">Input Data Customer</h1>
    <figure>
        <blockquote class="blockquote">
            <p>Berisi data yang ingin disimpan di Database</p>
        </blockquote>
        <figcaption class="blockquote-footer">
            <cite title="Source Title">Isikan data dengan Lengkap dan Sesuai!</cite>
        </figcaption>
    </figure>
</div>

<!-- Form -->
<div class="container">
    <form method="POST" action="process.php" enctype="multipart/form-data">
        <input type="hidden" value="<?php echo $no; ?>" name="no">
        <div class="mb-3 row">
            <label for="id_cust" class="col-sm-2 col-form-label">No Order</label>
            <div class="col-sm-10">
                <div class="form-floating">
                    <input type="text" required name="id_cust" class="form-control" id="id_cust" placeholder="Ex: 0000-0001" value="<?php echo $id_cust; ?>">
                    <label for="id_cust" class="text-body-tertiary">Ex: 0000-0001</label>
                </div>
            </div>
        </div>
        <div class="mb-3 row">
            <label for="nama" class="col-sm-2 col-form-label">Nama</label>
            <div class="col-sm-10">
                <div class="form-floating">
                    <input type="text" required name="nama_cust" class="form-control" id="nama" placeholder="Ex: Thoriq Halilintar" value="<?php echo $nama_cust; ?>"> 
                    <label for="nama" class="text-body-tertiary">Ex: Thoriq Halilintar</label>
                </div>
            </div>
        </div>
        <div class="mb-3 row">
            <label for="gender" class="col-sm-2 col-form-label">Gender</label>
            <div class="col-sm-10">
                <select name="gender" required class="form-select text-body-tertiary">
                    <option value="" disabled <?php echo ($gender == "") ? "selected" : ""; ?>>What is your Gender?</option>
                    <option value="Laki-Laki" <?php echo ($gender == "Laki-Laki") ? "selected" : ""; ?>>Laki-Laki</option>
                    <option value="Perempuan" <?php echo ($gender == "Perempuan") ? "selected" : ""; ?>>Perempuan</option>
                </select>
            </div>
        </div>
        <div class="mb-3 row">
            <label for="alamat" class="col-sm-2 col-form-label">Alamat Lengkap</label>
            <div class="col-sm-10">
                <div class="form-floating">
                    <textarea required class="form-control" name="alamat" id="alamat" rows="3" placeholder="Ketik Alamat Lengkap"><?php echo $alamat; ?></textarea>
                    <label for="alamat" class="text-body-tertiary">Ketik Alamat Lengkap</label>
                </div>
            </div>
        </div>
        <div class="mb-3 row">
            <label for="fileKTP" class="col-sm-2 col-form-label">Foto KTP</label>
            <div class="col-sm-10">
                <input <?php if (!isset($_GET['ubah'])) { echo "required"; } ?> name="ktp" class="form-control text-body-tertiary" type="file" id="fileKTP" accept="image/*">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="fileKK" class="col-sm-2 col-form-label">Foto KK</label>
            <div class="col-sm-10">
                <input name="kartu_keluarga" <?php if (!isset($_GET['ubah'])) { echo "required"; } ?> class="form-control text-body-tertiary" type="file" id="fileKK" accept="image/*">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="jenis_pinjaman" class="col-sm-2 col-form-label">Jenis Pinjaman</label>
            <div class="col-sm-10">
                <select name="jenis_pinjaman" required class="form-select text-body-tertiary">
                    <option value="" disabled <?php echo ($jenis_pinjaman == "") ? "selected" : ""; ?>>Open this select menu</option>
                    <option value="NMC" <?php echo ($jenis_pinjaman == "NMC") ? "selected" : ""; ?>>NMC</option>
                    <option value="Motor Bekas" <?php echo ($jenis_pinjaman == "Motor Bekas") ? "selected" : ""; ?>>Motor Bekas</option>
                    <option value="Multiproduk" <?php echo ($jenis_pinjaman == "Multiproduk") ? "selected" : ""; ?>>Multiproduk</option>
                    <option value="Microfinance" <?php echo ($jenis_pinjaman == "Microfinance") ? "selected" : ""; ?>>Microfinance</option>
                    <option value="Ibadah Haji" <?php echo ($jenis_pinjaman == "Ibadah Haji") ? "selected" : ""; ?>>Ibadah Haji</option>
                    <option value="Ibadah Umroh" <?php echo ($jenis_pinjaman == "Ibadah Umroh") ? "selected" : ""; ?>>Ibadah Umroh</option>
                </select>
            </div>
        </div>
        <div class="mb-3 row">
            <label for="status_order" class="col-sm-2 col-form-label">Status Order</label>
            <div class="col-sm-10">
                <select name="status_order" required class="form-select text-body-tertiary">
                    <option value="" disabled <?php echo ($status_order == "") ? "selected" : ""; ?>>Open this select menu</option>
                    <option value="New Order" <?php echo ($status_order == "New Order") ? "selected" : ""; ?>>New Order</option>
                    <option value="Order Pending" <?php echo ($status_order == "Order Pending") ? "selected" : ""; ?>>Order Pending</option>
                    <option value="PO Pending" <?php echo ($status_order == "PO Pending") ? "selected" : ""; ?>>PO Pending</option>
                    <option value="Kontrak" <?php echo ($status_order == "Kontrak") ? "selected" : ""; ?>>Kontrak</option>
                    <option value="Dishbursement" <?php echo ($status_order == "Dishbursement") ? "selected" : ""; ?>>Dishbursement</option>
                    <option value="Accepted" <?php echo ($status_order == "Accepted") ? "selected" : ""; ?>>Accepted</option>
                    <option value="Rejected" <?php echo ($status_order == "Rejected") ? "selected" : ""; ?>>Rejected</option>
                </select>
            </div>
        </div>

        <!-- Button -->
        <div class="row mb-3">
            <div class="col-sm-10 offset-sm-2" style="margin-bottom: 50px;">
                <?php if (isset($_GET['ubah'])) { ?>
                    <button type="submit" name="aksi" value="edit" class="btn btn-primary">
                        <i class="fa fa-floppy-o" aria-hidden="true"></i> Save Changes
                    </button>
                <?php } else { ?>
                    <button type="submit" name="aksi" value="add" class="btn btn-primary">
                        <i class="fa fa-floppy-o" aria-hidden="true"></i> Save
                    </button>
                <?php } ?>
                <a href="masterAdmin" class="btn btn-danger">
                    <i class="fa fa-reply" aria-hidden="true"></i> Back
                </a>
            </div>
        </div>
    </form>
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
</body>
</html>
