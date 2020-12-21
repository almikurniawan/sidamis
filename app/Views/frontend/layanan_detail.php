<?= $this->extend('frontend/default') ?>
<?= $this->section('content') ?>

  <main id="main">

    <!-- ======= Breadcrumbs ======= -->
    <section id="breadcrumbs" class="breadcrumbs">
      <div class="container">

        <div class="d-flex justify-content-between align-items-center">
          <h2>layanan</h2>
          <ol>
            <li><a href="<?php echo base_url();?>">Beranda</a></li>
            <li>layanan</li>
          </ol>
        </div>

      </div>
    </section><!-- End Breadcrumbs -->

    <!-- ======= Blog Section ======= -->
    <section id="blog" class="blog">
      <div class="container">

        <div class="row">

          <div class="col-lg-8 entries">






            <?php foreach($layanan_detail as $row):?>
            <article class="entry entry-single">

              <div class="entry-img">
                <img src="<?php echo base_url();?>/uploads/layanan/<?= $row->layanan_foto;?>" alt="" class="img-fluid">
              </div>

              <h2 class="entry-title">
                <a href="blog-single.html"><?= $row->layanan_nama;?></a>
              </h2>

              <div class="entry-content">
                <p>
                <?= $row->layanan_deskripsi;?>
                </p>

              </div>

              <div class="entry-footer clearfix">

                <div class="float-right share">
                  <a href="" title="Share on Twitter"><i class="icofont-twitter"></i></a>
                  <a href="" title="Share on Facebook"><i class="icofont-facebook"></i></a>
                  <a href="" title="Share on Instagram"><i class="icofont-instagram"></i></a>
                </div>

              </div>

            </article><!-- End blog entry -->
          <?php endforeach;?>








          </div><!-- End blog entries list -->

          <div class="col-lg-4">

            <div class="sidebar">

              <h3 class="sidebar-title">Search</h3>
              <div class="sidebar-item search-form">
                <form action="">
                  <input type="text">
                  <button type="submit"><i class="icofont-search"></i></button>
                </form>

              </div><!-- End sidebar search formn-->


              <h3 class="sidebar-title">layanan Posts</h3>
              <div class="sidebar-item recent-posts">

                <?php foreach($layanan_random as $row):?>
                <div class="post-item clearfix">
                  <img src="<?php echo base_url();?>/uploads/layanan/<?= $row->layanan_foto;?>" alt="">
                  <h4><a href="<?php echo base_url();?>/layanan/detail/<?= $row->layanan_id;?>"><?= $row->layanan_nama;?></a></h4>
                </div>
                <?php endforeach;?>

              </div><!-- End sidebar recent posts-->


            </div><!-- End sidebar -->

          </div><!-- End blog sidebar -->

        </div>

      </div>
    </section><!-- End Blog Section -->

  </main><!-- End #main -->

<?= $this->endSection() ?>
