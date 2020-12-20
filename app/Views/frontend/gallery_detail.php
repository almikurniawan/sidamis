<?= $this->extend('frontend/default') ?>
<?= $this->section('content') ?>

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

<?= $this->endSection() ?>
