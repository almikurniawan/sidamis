<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Portfolio Details - Sailor Bootstrap Template</title>
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

  <main id="main">

    <!-- ======= Portfolio Details Section ======= -->
    <section id="portfolio-details" class="portfolio-details">
      <div class="container">

        <div class="row">

          <?php foreach($gallery_detail as $row):?>
          <div class="col-lg-8">
            <h2 class="portfolio-title"><?= $row->gallery_nama;?></h2>
            <div class="owl-carousel portfolio-details-carousel">
              <img src="<?php echo base_url();?>/uploads/gallery/<?= $row->gallery_foto;?>" class="img-fluid" alt="">
            </div>
          </div>

          <div class="col-lg-4 portfolio-info">
            <h3><?= $row->gallery_nama;?></h3>
            <p>
              <?= $row->gallery_deskripsi;?>
            </p>
          </div>
          <?php endforeach;?>

        </div>

      </div>
    </section><!-- End Portfolio Details Section -->

  </main><!-- End #main -->

  <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>

  <?php include("js.php");?>

</body>

</html>
