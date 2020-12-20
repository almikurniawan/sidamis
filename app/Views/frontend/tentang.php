<?= $this->extend('frontend/default') ?>
<?= $this->section('content') ?>

  <main id="main">

    <!-- ======= Breadcrumbs ======= -->
    <section id="breadcrumbs" class="breadcrumbs">
      <div class="container">

        <div class="d-flex justify-content-between align-items-center">
          <h2>Tentang</h2>
          <ol>
            <li><a href="<?php echo base_url();?>">Beranda</a></li>
            <li>Tentang</li>
          </ol>
        </div>

      </div>
    </section><!-- End Breadcrumbs -->

    <!-- ======= Blog Section ======= -->
    <section id="blog" class="blog">
      <div class="container">

        <div class="row">




           <?php foreach($tentang as $row):?>
          <div class="col-lg-12  col-md-6 d-flex align-items-stretch" data-aos="fade-up">
            <article class="entry">


              <h2 class="entry-title">
                <a href="<?php echo base_url();?>/tentang/detail/<?= $row->tentang_id;?>"><?= $row->tentang_judul;?></a>
              </h2>


              <div class="entry-content">
                <p>
                  <?= $row->tentang_konten;?>
              </div>
              <div class="social">
                <a href="<?php echo base_url();?>/uploads/tentang/<?= $row->tentang_file;?>"><h1><i class="icofont-download"></i></h1> Download file</a>
              </div>
            </article><!-- End blog entry -->
          </div>
        <?php endforeach;?>









        </div>


      </div>
    </section><!-- End Blog Section -->

  </main><!-- End #main -->

<?= $this->endSection() ?>
