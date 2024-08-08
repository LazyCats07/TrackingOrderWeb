<?php
include 'connect.php';
session_start();

// Default query to show no records
$query = "";
$isSearch = false;

if (isset($_POST['tombolsearch'])) {
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
    <link rel="shortcut icon" href="../img/icon/logo.png">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css"/>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
    <script src="https://kit.fontawesome.com/e56a8fc2bc.js" crossorigin="anonymous"></script>
    <!-- Bootsrap FAQ Style -->
    <style>
        .title {
            color: #2676ae;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        }
        .lf {
            font-size: 12px;
            margin-bottom: 1.5px;
            color: #76a5af;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        }
    </style>
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
                    <li class="nav-item"><a class="nav-link" href="https://www.fifgroup.co.id/">Home</a></li>
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
            <div class="input-group mb-3 searchButton" style="margin-top:20px;">
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
    <?php else: ?>
    <div style="margin-top: 50px; text-align: center;">
        <span class="lf">No results found. Please try a different search.</span>
    </div>
    <?php endif; ?>

<!-- FAQ -->
<section class="bsb-faq-3 py-3 py-md-5 py-xl-8" style="margin-top: 150px;">
  <div class="container">
    <div class="row justify-content-md-center">
      <div class="col-12 col-md-10 col-lg-8 col-xl-7 col-xxl-6">
        <h2 class="mb-4 display-5 text-center"><i>Frequently Asked Questions</i></h2>
        <p class="text-secondary text-center lead fs-4">Selamat datang di halaman FAQ kami, sumber informasi lengkap untuk jawaban atas pertanyaan umum.</p>
        <p class="mb-5 text-center">Baik Anda pelanggan baru yang ingin mempelajari lebih lanjut tentang apa yang kami tawarkan dan status order yang anda ajukan atau pengguna lama yang mencari klarifikasi tentang topik tertentu, halaman ini memiliki informasi yang jelas dan ringkas tentang produk dan layanan kami.</p>
        <hr class="w-50 mx-auto mb-5 mb-xl-9 border-dark-subtle">
      </div>
    </div>
  </div>

  <!-- FAQs: Placing an Order -->
  <div class="mb-8">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-11 col-xl-10">
          <div class="d-flex align-items-end mb-5">
            <i class="bi bi-cart-plus me-3 lh-1 display-5"></i>
            <h3 class="m-0">Menempatkan Pesanan</h3>
          </div>
        </div>
        <div class="col-11 col-xl-10">
          <div class="accordion accordion-flush" id="faqOrder">
            <div class="accordion-item bg-transparent border-top border-bottom py-3">
              <h2 class="accordion-header" id="faqOrderHeading1">
                <button class="accordion-button collapsed bg-transparent fw-bold shadow-none link-primary" type="button" data-bs-toggle="collapse" data-bs-target="#faqOrderCollapse1" aria-expanded="false" aria-controls="faqOrderCollapse1">
                Bagaimana Saya Dapat Mengetahui Status Permohonan yang Telah Saya Kirim?
                </button>
              </h2>
              <div id="faqOrderCollapse1" class="accordion-collapse collapse" aria-labelledby="faqOrderHeading1">
                <div class="accordion-body">
                  <p>Anda dapat melacak status aplikasi pengajuan melalui <a href="track">https://fifgroup.co.id/cek-pengajuan</a> dengan memasukan nomor handphone yang terdaftar saat pengajuan, atau Anda dapat melacak melalui tautan yang dikirimkan melalui whatsaap saat pengajuan berhasil dikirim.</p>
                </div>
              </div>
            </div>
            <div class="accordion-item bg-transparent border-bottom py-3">
              <h2 class="accordion-header" id="faqOrderHeading2">
                <button class="accordion-button collapsed bg-transparent fw-bold shadow-none link-primary" type="button" data-bs-toggle="collapse" data-bs-target="#faqOrderCollapse2" aria-expanded="false" aria-controls="faqOrderCollapse2">
                Kapan saya akan dihubungi untuk verifikasi?
                </button>
              </h2>
              <div id="faqOrderCollapse2" class="accordion-collapse collapse" aria-labelledby="faqOrderHeading2">
                <div class="accordion-body">
                  <p>Anda akan dihubungi oleh tim kami untuk dilakukan verifikasi data dalam waktu maksimal 3 hari kerja.</p>
                </div>
              </div>
            </div>
            <div class="accordion-item bg-transparent border-bottom py-3">
              <h2 class="accordion-header" id="faqOrderHeading3">
                <button class="accordion-button collapsed bg-transparent fw-bold shadow-none link-primary" type="button" data-bs-toggle="collapse" data-bs-target="#faqOrderCollapse3" aria-expanded="false" aria-controls="faqOrderCollapse3">
                Apa saja yang perlu Anda persiapkan selama menunggu proses verifikasi?
                </button>
              </h2>
              <div id="faqOrderCollapse3" class="accordion-collapse collapse" aria-labelledby="faqOrderHeading3">
                <div class="accordion-body">
                  <p>Pastikan nomor handphone Anda aktif selama proses pengajuan pembiayaan agar memudahkan tim kami dalam proses verifikasi.</p>
                </div>
              </div>
            </div>
            <div class="accordion-item bg-transparent border-bottom py-3">
              <h2 class="accordion-header" id="faqOrderHeading4">
                <button class="accordion-button collapsed bg-transparent fw-bold shadow-none link-primary" type="button" data-bs-toggle="collapse" data-bs-target="#faqOrderCollapse4" aria-expanded="false" aria-controls="faqOrderCollapse4">
                Bagaimana cara membatalkan permohonan saya?
                </button>
              </h2>
              <div id="faqOrderCollapse4" class="accordion-collapse collapse" aria-labelledby="faqOrderHeading4">
                <div class="accordion-body">
                  <p>Hubungi customer support kami melalui nomor telepon 1500-343 atau melalui email halofif@fifgroup.astra.co.id.</p>
                </div>
              </div>
            </div>
            <div class="accordion-item bg-transparent border-bottom py-3">
              <h2 class="accordion-header" id="faqOrderHeading5">
                <button class="accordion-button collapsed bg-transparent fw-bold shadow-none link-primary" type="button" data-bs-toggle="collapse" data-bs-target="#faqOrderCollapse5" aria-expanded="false" aria-controls="faqOrderCollapse5">
                Bagaimana jika permohonan saya tidak disetujui?
                </button>
              </h2>
              <div id="faqOrderCollapse5" class="accordion-collapse collapse" aria-labelledby="faqOrderHeading5">
                <div class="accordion-body">
                  <p>Anda dapat melalukan pengajuan kembali melalui form yang kami sediakan di halaman website FIFGROUP.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- FAQ -->




<!-- Footer -->
  <!-- Section: Links  -->
  <section style="margin-top: 100px;">
    <div class="container text-center text-md-start mt-4">
      <!-- Grid row -->
      <div class="row mt-3">
        <!-- Grid column -->
        <div class="col-md-3 col-lg-4 col-xl-3 mx-auto ">
          <!-- Content -->
          <h6 class="text-uppercase fw-bold mb-3 title">
            PT Federal International Finance “FIFGROUP”
          </h6>
          <!-- <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4"> -->
            <!-- Links -->
            <!-- <h6 class="text-uppercase fw-bold mb-4">Contact</h6> -->
            <p style="color:#4a4a4a; font-size:12px;">
                <i class="fas fa-home me-3" ></i> 
                Menara FIF Jl. T.B. Simatupang Kav.15 Cilandak. Jakarta Selatan 12440 
            </p>
            <p style="color:#4a4a4a;">
              <i class="fas fa-envelope me-3"></i>
              <a href="mailto:halofif@fifgroup.astra.co.id" style="color:black; text-decoration:none; font-size:12px;">HALOFIF@FIFGROUP.ASTRA.CO.ID</a>
            </p>
          <!-- </div> -->
          <h6 class="text-uppercase fw-bold mb-3 title">
            Hubungi Kami
          </h6>
          <div class="mb-3" style="color:#4a4a4a;">
              <a href="https://www.facebook.com/FIFCLUB/" style="text-decoration: none;" class="me-4 text-reset">
                <i class="fab fa-facebook-f"></i>
              </a>
              <a href="https://www.twitter.com/fifclub" style="text-decoration: none;" class="me-4 text-reset">
                <i class="fab fa-twitter"></i>
              </a>
              <a href="https://g.co/kgs/n5tZhnY" style="text-decoration: none;" class="me-4 text-reset">
                <i class="fab fa-google"></i>
              </a>
              <a href="https://www.youtube.com/user/fifgroup" style="text-decoration: none;" class="me-4 text-reset">
                <i class="fa-brands fa-youtube"></i>
              </a>
              <a href="https://www.instagram.com/fifclub" style="text-decoration: none;" class="me-4 text-reset">
                <i class="fab fa-instagram"></i>
              </a>
              <a href="https://www.linkedin.com/company/pt.-federal-international-finance/" style="text-decoration: none;" class="me-4 text-reset">
                <i class="fa-brands fa-linkedin"></i>
              </a>
          </div>
        </div>
        <!-- Grid column -->

        <!-- Grid column -->
        <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4">
          <!-- Links -->
          <h6 class="text-uppercase fw-bold title">
            TENTANG KAMI
          </h6>
          <p class="lf">
            <a href="https://www.fifgroup.co.id/informasi-perusahaan/informasi-umum#profil-perusahaan" class="text-reset list-footer" style="text-decoration: none;">Profil Perusahaan</a>
          </p>
          <p class="lf">
            <a href="https://www.fifgroup.co.id/informasi-perusahaan/informasi-umum#struktur-organisasi" class="text-reset list-footer" style="text-decoration: none;">Struktur Organisasi</a>
          </p>
          <p class="lf">
            <a href="https://www.fifgroup.co.id/informasi-perusahaan/informasi-umum#struktur-kepemilikan" class="text-reset list-footer" style="text-decoration: none;">Struktur Kepemilikan</a>
          </p>
          <p class="lf">
            <a href="https://www.fifgroup.co.id/informasi-perusahaan/informasi-umum#struktur-group-pt-astra-international-tbk" class="text-reset list-footer" style="text-decoration: none;">Struktur Group PT Astra International Tbk.</a>
          </p>
          <p class="lf">
            <a href="https://www.fifgroup.co.id/informasi-perusahaan/informasi-umum#profil-direksi-dewan-komisaris" class="text-reset list-footer" style="text-decoration: none;">Profil Direksi</a>
          </p>
          <p class="lf">
            <a href="https://www.fifgroup.co.id/informasi-perusahaan/informasi-umum#profil-direksi-dewan-komisaris" class="text-reset list-footer" style="text-decoration: none;">Profil Dewan Komisaris</a>
          </p>
          <p class="lf">
            <a href="#!" class="text-reset list-footer" style="text-decoration: none;">Profil Komite</a>
          </p>
          <p class="lf">
            <a href="https://www.fifgroup.co.id/informasi-perusahaan/informasi-umum#profil-direksi-dewan-komisaris" class="text-reset list-footer" style="text-decoration: none;">Profil Sekretaris Perusahaan</a>
          </p>
          <p class="lf">
            <a href="https://www.fifgroup.co.id/informasi-perusahaan/informasi-umum#profil-direksi-dewan-komisaris" class="text-reset list-footer" style="text-decoration: none;">Profil Komite</a>
          </p>
          <p class="lf">
            <a href="https://www.fifgroup.co.id/informasi-perusahaan/informasi-umum#profesi-penunjang" class="text-reset list-footer" style="text-decoration: none;">Nama & Alamat Profesi Pendukung</a>
          </p>
          <p class="lf mb-3">
            <a href="https://www.fifgroup.co.id/informasi-perusahaan/informasi-umum#dokumen-anggaran-dasar" class="text-reset list-footer" style="text-decoration: none;">Dokumen Anggaran Dasar</a>
          </p>

          <h6 class="text-uppercase fw-bold title">
            PRODUCT SERVICES
          </h6>
          <p class="lf">
            <a href="https://www.fifgroup.co.id/fifastra" class="text-reset list-footer" style="text-decoration: none;">FIFASTRA</a>
          </p>
          <p class="lf">
            <a href="https://www.fifgroup.co.id/spektra" class="text-reset list-footer" style="text-decoration: none;">SPEKTRA</a>
          </p>
          <p class="lf">
            <a href="https://www.fifgroup.co.id/danastra" class="text-reset list-footer" style="text-decoration: none;">DANASTRA</a>
          </p>
          <p class="lf">
            <a href="https://www.fifgroup.co.id/amitra" class="text-reset list-footer" style="text-decoration: none;">AMITRA</a>
          </p>
          <p class="lf mb-3">
            <a href="https://www.fifgroup.co.id/finatra" class="text-reset list-footer" style="text-decoration: none;">FINATRA</a>
          </p>
        </div>
        
        <!-- Grid column -->

        <!-- Grid column -->
        <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">
          <!-- Links -->
          <h6 class="text-uppercase fw-bold title">
            HUBUNGAN INVESTOR
          </h6>
          <p class="lf">
            <a href="https://www.fifgroup.co.id/informasi-perusahaan/hubungan-investor#dokumen-prospektus" class="text-reset list-footer" style="text-decoration: none;">Dokumen Prospektus</a>
          </p>
          <p class="lf">
            <a href="https://www.fifgroup.co.id/informasi-perusahaan/hubungan-investor#laporan-tahunan" class="text-reset list-footer" style="text-decoration: none;">Laporan Tahunan</a>
          </p>
          <p class="lf">
            <a href="https://www.fifgroup.co.id/informasi-perusahaan/hubungan-investor#informasi-keuangan" class="text-reset list-footer" style="text-decoration: none;">Informasi Keuangan</a>
          </p>
          <p class="lf">
            <a href="https://www.fifgroup.co.id/informasi-perusahaan/hubungan-investor#rapat-umum-pemegang-saham" class="text-reset list-footer" style="text-decoration: none;">Informasi Rapat umum Pemegang Saham</a>
          </p>
          <p class="lf">
            <a href="https://www.fifgroup.co.id/informasi-perusahaan/hubungan-investor#informasi-obligasi" class="text-reset list-footer" style="text-decoration: none;">Informasi Obligasi</a>
          </p>
          <p class="lf">
            <a href="https://www.fifgroup.co.id/informasi-perusahaan/hubungan-investor#informasi-deviden" class="text-reset list-footer" style="text-decoration: none;">Informasi Deviden</a>
          </p>
          <p class="lf">
            <a href="https://www.fifgroup.co.id/informasi-perusahaan/hubungan-investor#informasi-aksi-korporasi" class="text-reset list-footer" style="text-decoration: none;">Informasi Aksi Korporasi</a>
          </p>
          <p class="lf mb-3">
            <a href="https://www.fifgroup.co.id/informasi-perusahaan/hubungan-investor#informasi-lain" class="text-reset list-footer" style="text-decoration: none;">Informasi Lain</a>
          </p>

          <h6 class="text-uppercase fw-bold title">
            OTHER LINK 
          </h6>
          <p class="lf">
            <a href="https://karir-rise.fifgroup.co.id/?_gl=1*1vuptjn*_gcl_au*MTMzMTkxNjY0MS4xNzIwMTcxMDcz*_ga*OTMxNjY1MjcyLjE3MjI1MTgxNjQ.*_ga_21M28N9CND*MTcyMjg0OTE2MC4xLjEuMTcyMjg1MDE4NS4zMC4wLjA.#/beranda" class="text-reset list-footer" style="text-decoration: none;">Karir</a>
          </p>
          <p class="lf">
            <a href="https://www.fifgroup.co.id/kontak-kami" class="text-reset list-footer" style="text-decoration: none;">Kontak Kami</a>
          </p>
          <p class="lf">
            <a href="https://www.fifgroup.co.id/daftar-mitra" class="text-reset list-footer" style="text-decoration: none;">Daftar Mitra</a>
          </p>
          <p class="lf">
            <a href="https://www.fifgroup.co.id/branch-location" class="text-reset list-footer" style="text-decoration: none;">Lokasi Cabang</a>
          </p>
          <p class="lf">
            <a href="https://www.fifgroup.co.id/cek-pengajuan" class="text-reset list-footer" style="text-decoration: none;">Cek Pengajuan</a>
          </p>
          <p class="lf">
            <a href="#!" class="text-reset list-footer" style="text-decoration: none;">Lokasi Cabang</a>
          </p>
          <p class="lf">
            <a href="https://www.fifgroup.co.id/cek-pengajuan" class="text-reset list-footer" style="text-decoration: none;">Cek Pengajuan</a>
          </p>
          <p class="lf">
            <a href="https://e-calendar.fifgroup.co.id/?utm_source=linkFooter&utm_medium=website&utm_campaign=ecalendarLink&_gl=1*15f1d46*_gcl_au*MTMzMTkxNjY0MS4xNzIwMTcxMDcz*_ga*OTMxNjY1MjcyLjE3MjI1MTgxNjQ.*_ga_21M28N9CND*MTcyMjg0OTE2MC4xLjEuMTcyMjg0OTc0My4xMC4wLjA." class="text-reset list-footer" style="text-decoration: none;">E-Calendar</a>
          </p>
          <p class="lf">
            <a href="https://fifgroup.co.id/tanya-jawab-seputar-prosedur-layanan-pengaduan?_gl=1*smonvd*_gcl_au*MTMzMTkxNjY0MS4xNzIwMTcxMDcz*_ga*OTMxNjY1MjcyLjE3MjI1MTgxNjQ.*_ga_21M28N9CND*MTcyMjg0OTE2MC4xLjEuMTcyMjg0OTc0NS44LjAuMA.." class="text-reset list-footer" style="text-decoration: none;">Layanan Pengaduan</a>
          </p>
          <p class="lf mb-3">
            <a href="https://fifgroup.co.id/publikasi-penanganan-pengaduan-2022?_gl=1*smonvd*_gcl_au*MTMzMTkxNjY0MS4xNzIwMTcxMDcz*_ga*OTMxNjY1MjcyLjE3MjI1MTgxNjQ.*_ga_21M28N9CND*MTcyMjg0OTE2MC4xLjEuMTcyMjg0OTc0NS44LjAuMA.." class="text-reset list-footer" style="text-decoration: none;">Publikasi Layanan Pengaduan</a>
          </p>
        </div>
        <!-- Grid column -->

        <!-- Grid column -->
        <div class="col-md-3 col-lg-2 col-xl-3 mx-auto mb-1">
          <!-- Links -->
          <h6 class="text-uppercase fw-bold title">CORPORATE GOVERNANCE INFORMATION</h6>
          <p class="lf">
            <a href="https://www.fifgroup.co.id/informasi-perusahaan/informasi-tata-kelola#pedoman-kerja-direksi-komisaris" class="text-reset list-footer" style="text-decoration: none;">Pedoman Kerja Direksi & Dewan Komisaris</a>
          </p>
          <p class="lf">
            <a href="https://www.fifgroup.co.id/informasi-perusahaan/informasi-tata-kelola#sekretaris-perusahaan" class="text-reset list-footer" style="text-decoration: none;">Sekertaris Perusahaan</a>
          </p>
          <p class="lf">
            <a href="https://www.fifgroup.co.id/informasi-perusahaan/informasi-tata-kelola#pedoman-tata-kelola" class="text-reset list-footer" style="text-decoration: none;">Pedoman tata Kelola</a>
          </p>
          <p class="lf">
            <a href="https://www.fifgroup.co.id/informasi-perusahaan/informasi-tata-kelola#komite-pemantau-resiko" class="text-reset list-footer" style="text-decoration: none;">Komite Pemantau Resiko</a>
          </p>
          <p class="lf">
            <a href="https://www.fifgroup.co.id/informasi-perusahaan/informasi-tata-kelola#kebijakan-nominasi-remunerasi" class="text-reset list-footer" style="text-decoration: none;">Kebijakan Nominasi & Remunerasi</a>
          </p>
          <p class="lf">
            <a href="https://www.fifgroup.co.id/informasi-perusahaan/informasi-tata-kelola#kebijakan-manajemen-resiko" class="text-reset list-footer" style="text-decoration: none;">Kebijakan Manajemen Risiko</a>
          </p>
          <p class="lf mb-3">
            <a href="https://www.fifgroup.co.id/informasi-perusahaan/informasi-tata-kelola#sistem-pelaporan" class="text-reset list-footer" style="text-decoration: none;">Sistem Pelaporan</a>
          </p>
        </div>
        <!-- Grid column -->
      </div>
      <!-- Grid row -->
    </div>
  </section>
  <!-- Section: Links  -->
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




</body>
</html>
