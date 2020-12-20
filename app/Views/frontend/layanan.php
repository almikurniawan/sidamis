
<?= $this->extend('frontend/default') ?>
<?= $this->section('content') ?>
<main id="main">

  <!-- ======= Breadcrumbs ======= -->
  <section id="breadcrumbs" class="breadcrumbs">
    <div class="container">

      <div class="d-flex justify-content-between align-items-center">
        <h2>Layanan</h2>
        <ol>
          <li><a href="<?= base_url();?>">Home</a></li>
          <li>Layanan</li>
        </ol>
      </div>

    </div>
  </section><!-- End Breadcrumbs -->

  <!-- ======= Services Section ======= -->
  <section id="services" class="services">
    <div class="container">
      <div class="section-title">
        <h2>Layanan</h2>
        <p>Layanan Dinas Sosial</p>
      </div>
      <div class="row">

        <?php foreach($layanan as $row):?>
        <div class="col-md-6 mt-4 mt-md-0">
          <div class="icon-box">
            <?= $row->layanan_icon;?>

            <h4><a href="<?php echo base_url();?>/layanan/detail/<?= $row->layanan_id;?>"><?= $row->layanan_nama;?></a></h4>
            <p><?= $row->layanan_deskripsi;?></p>
          </div>
        </div>
      <?php endforeach;?>

      </div>

    </div>
  </section><!-- End Services Section -->


</main><!-- End #main -->
<?= $this->endSection() ?>
