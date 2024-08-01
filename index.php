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
<h1>Hallo World!</h1>
</body>
</html>
