<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Sailor Bootstrap Template - Index</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="<?php echo base_url();?>/frontend/assets/img/favicon.png" rel="icon">
  <link href="<?php echo base_url();?>/frontend/assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="<?php echo base_url();?>/frontend/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?php echo base_url();?>/frontend/assets/vendor/icofont/icofont.min.css" rel="stylesheet">
  <link href="<?php echo base_url();?>/frontend/assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="<?php echo base_url();?>/frontend/assets/vendor/animate.css/animate.min.css" rel="stylesheet">
  <link href="<?php echo base_url();?>/frontend/assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="<?php echo base_url();?>/frontend/assets/vendor/venobox/venobox.css" rel="stylesheet">
  <link href="<?php echo base_url();?>/frontend/assets/vendor/owl.carousel/assets/owl.carousel.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="<?php echo base_url();?>/frontend/assets/css/style.css" rel="stylesheet">
  <link rel="stylesheet" href="<?php echo base_url();?>/frontend/webfont/demo-files/demo.css">
  <link rel="stylesheet" href="<?php echo base_url();?>/frontend/webfont/style.css">
  <!--[if lt IE 8]><!-->
  <link rel="stylesheet" href="<?php echo base_url();?>/frontend/webfont/ie7/ie7.css">


  <!-- =======================================================
  * Template Name: Sailor - v2.2.0
  * Template URL: https://bootstrapmade.com/sailor-free-bootstrap-theme/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top ">
    <div class="container d-flex align-items-center">

      <h1 class="logo"><a href="<?php echo base_url();?>">Dinsos Kab. Kediri</a></h1>
      <!-- Uncomment below if you prefer to use an image logo -->
      <!-- <a href="index.html" class="logo"><img src="<?php echo base_url();?>/frontend/assets/img/logo.png" alt="" class="img-fluid"></a>-->

      <nav class="nav-menu d-none d-lg-block">

        <ul>
          <li class="active"><a href="<?php echo base_url();?>">Beranda</a></li>
          <li class="drop-down"><a href="#">Tentang</a>
            <ul>
              <li><a href="<?php echo base_url();?>/tentang/index/profil">Profil</a></li>
              <li><a href="<?php echo base_url();?>/tentang/index/tugas pokok dan fungsi">Tugas Pokok dan Fungsi</a></li>
              <li><a href="<?php echo base_url();?>/tentang/index/struktur organisasi">Struktur Organisasi</a></li>
            </ul>
          </li>
          <li><a href="<?php echo base_url();?>/informasi">Informasi umum</a></li>
          <li><a href="<?php echo base_url();?>/layanan">Layanan</a></li>
          <li><a href="<?php echo base_url();?>/gallery">Gallery</a></li>
          <li><a href="<?php echo base_url();?>/berita">Berita</a></li>

      </nav><!-- .nav-menu -->

      <a href="index.html" class="get-started-btn ml-auto">Kontak</a>

    </div>
  </header><!-- End Header -->

  <?= $this->renderSection('content') ?>


  <!-- ======= Footer ======= -->
  <footer id="footer">
    <div class="footer-top">
      <div class="container">
        <div class="row">

          <div class="col-lg-3 col-md-6">
            <div class="footer-info">
              <h3>Sailor</h3>
              <p>
                Jl. Mayor Bismo No.28, Mojoroto, Kec. Mojoroto, Kediri, Jawa Timur 64121 <br>
                Jawa Timur<br><br>
                <strong>Phone:</strong> (0354) 689626<br>
                <strong>Email:</strong> dinsos@dinsis.kedirikab.go.id<br>

              </p>
              <div class="social-links mt-3">
                <a href="#" class="twitter"><i class="bx bxl-twitter"></i></a>
                <a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>
                <a href="#" class="instagram"><i class="bx bxl-instagram"></i></a>
                <a href="#" class="google-plus"><i class="bx bxl-skype"></i></a>
                <a href="#" class="linkedin"><i class="bx bxl-linkedin"></i></a>
              </div>
            </div>
          </div>

          <div class="col-lg-2 col-md-6 footer-links">
            <h4>Links Bantuan</h4>
            <ul>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Beranda</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Tentang</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Profil</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Informasi Umum</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Layanan</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Gallery</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Berita</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Kontak</a></li>
            </ul>
          </div>

          <div class="col-lg-3 col-md-6 footer-links">
            <h4>Jam Layanan</h4>
              <table class="WgFkxc" style="margin-top: 3px; color: rgb(32, 33, 36); font-family: arial, sans-serif; background-color: rgb(255, 255, 255);"><tbody><tr class="K7Ltle" style="font-weight: bold; color: rgb(0, 0, 0);"><td class="SKNSIb" style="padding-right: 8px;">Selasa</td><td>08.00–15.00</td></tr><tr><td class="SKNSIb" style="padding-right: 8px;">Rabu</td><td>08.00–15.00</td></tr><tr><td class="SKNSIb" style="padding-right: 8px;">Kamis</td><td>08.00–15.00</td></tr><tr><td class="SKNSIb" style="padding-right: 8px;">Jumat</td><td>08.00–11.30</td></tr><tr><td class="SKNSIb" style="padding-right: 8px;">Sabtu</td><td>Tutup</td></tr><tr><td class="SKNSIb" style="padding-right: 8px;">Minggu</td><td>Tutup</td></tr><tr><td class="SKNSIb" style="padding-right: 8px;">Senin</td><td>08.00–15.00</td></tr></tbody></table>
          </div>

          <div class="col-lg-4 col-md-6 footer-newsletter">
            <h4>Langganan</h4>
            <p>Dapatkan informasi terbaru dari kami melalui email</p>
            <form action="" method="post">
              <input type="email" name="email"><input type="submit" value="Langganan">
            </form>

          </div>

        </div>
      </div>
    </div>

    <div class="container">
      <div class="copyright">
        &copy; Copyright 2020 <strong><span>Dinas Sosial Kabupaten Kediri</span></strong>. All Rights Reserved
      </div>
      <div class="credits">
        <!-- All the links in the footer should remain intact. -->
        <!-- You can delete the links only if you purchased the pro version. -->
        <!-- Licensing information: https://bootstrapmade.com/license/ -->
        <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/sailor-free-bootstrap-theme/ -->
      </div>
    </div>
  </footer><!-- End Footer -->


  <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>

  <!-- Vendor JS Files -->
  <script src="<?php echo base_url();?>/frontend/assets/vendor/jquery/jquery.min.js"></script>
  <script src="<?php echo base_url();?>/frontend/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="<?php echo base_url();?>/frontend/assets/vendor/jquery.easing/jquery.easing.min.js"></script>
  <script src="<?php echo base_url();?>/frontend/assets/vendor/php-email-form/validate.js"></script>
  <script src="<?php echo base_url();?>/frontend/assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="<?php echo base_url();?>/frontend/assets/vendor/venobox/venobox.min.js"></script>
  <script src="<?php echo base_url();?>/frontend/assets/vendor/waypoints/jquery.waypoints.min.js"></script>
  <script src="<?php echo base_url();?>/frontend/assets/vendor/owl.carousel/owl.carousel.min.js"></script>

  <!-- Template Main JS File -->
  <script src="<?php echo base_url();?>/frontend/assets/js/main.js"></script>

</body>

</html>
