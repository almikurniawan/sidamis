<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Blog - Sailor Bootstrap Template</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <?php include("css.php");?>

  <!-- =======================================================
  * Template Name: Sailor - v2.2.0
  * Template URL: https://bootstrapmade.com/sailor-free-bootstrap-theme/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  <?php include("header.php");?>

  <main id="main">

    <!-- ======= Breadcrumbs ======= -->
    <section id="breadcrumbs" class="breadcrumbs">
      <div class="container">

        <div class="d-flex justify-content-between align-items-center">
          <h2>informasi</h2>
          <ol>
            <li><a href="<?php echo base_url();?>">Beranda</a></li>
            <li>informasi</li>
          </ol>
        </div>

      </div>
    </section><!-- End Breadcrumbs -->

    <!-- ======= Blog Section ======= -->
    <section id="blog" class="blog">
      <div class="container">

        <div class="row">




           <?php foreach($informasi as $row):?>
          <div class="col-lg-12  col-md-6 d-flex align-items-stretch" data-aos="fade-up">
            <article class="entry">

              <div class="entry-img">
                <img src="<?php echo base_url();?>/uploads/informasi/<?= $row->informasi_foto;?>" alt="" class="img-fluid">
              </div>

              <h2 class="entry-title">
                <a href="<?php echo base_url();?>/informasi/detail/<?= $row->informasi_id;?>"><?= $row->informasi_nama;?></a>
              </h2>

              <div class="entry-meta">
                <ul>
                  <li class="d-flex align-items-center"><i class="icofont-user"></i> <a href="blog-single.html">Admin</a></li>
                  <li class="d-flex align-items-center"><i class="icofont-wall-clock"></i> <a href="<?php echo base_url();?>/informasi/detail/<?= $row->informasi_id;?>"><time datetime="2020-01-01"><?= $row->informasi_tanggal;?></time></a></li>
                </ul>
              </div>

              <div class="entry-content">
                <p>
                  <?= $row->informasi_isi;?>
                <div class="read-more">
                  <a href="<?php echo base_url();?>/informasi/detail/<?= $row->informasi_id;?>">Baca selengkapnya</a>
                </div>
              </div>
              <div class="social">
                <a href="<?php echo base_url();?>/uploads/informasi/<?= $row->informasi_file;?>"><h1><i class="icofont-download"></i></h1> Download file</a>
              </div>
            </article><!-- End blog entry -->
          </div>
        <?php endforeach;?>









        </div>

        <div class="blog-pagination" data-aos="fade-up">
          <ul class="justify-content-center">
            <li class="disabled"><i class="icofont-rounded-left"></i></li>
            <li><a href="#">1</a></li>
            <li class="active"><a href="#">2</a></li>
            <li><a href="#">3</a></li>
            <li><a href="#"><i class="icofont-rounded-right"></i></a></li>
          </ul>
        </div>

      </div>
    </section><!-- End Blog Section -->

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <?php include("footer.php");?>

  <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>

  <?php include("js.php");?>

</body>

</html>
