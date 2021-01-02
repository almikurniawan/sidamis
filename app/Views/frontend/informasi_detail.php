<?= $this->extend('frontend/default') ?>
<?= $this->section('content') ?>

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

          <div class="col-lg-8 entries">






            <?php foreach($informasi_detail as $row):?>
            <article class="entry entry-single">

              <div class="entry-img">
                <img src="<?php echo base_url();?>/uploads/informasi/<?= $row->informasi_foto;?>" alt="" class="img-fluid">
              </div>

              <h2 class="entry-title">
                <a href="blog-single.html"><?= $row->informasi_nama;?></a>
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
              <div class="sidebar-item search-form" >
                <form action="<?php echo base_url();?>/informasi/search" method="get">
                  <input name="search" type="text">
                  <button type="submit"><i class="icofont-search"></i></button>
                </form>

              </div><!-- End sidebar search formn-->


              <h3 class="sidebar-title">informasi Posts</h3>
              <div class="sidebar-item recent-posts">

                <?php foreach($informasi_random as $row):?>
                <div class="post-item clearfix">
                  <img src="<?php echo base_url();?>/uploads/informasi/<?= $row->informasi_foto;?>" alt="">
                  <h4><a href="<?php echo base_url();?>/informasi/detail/<?= $row->informasi_id;?>"><?= $row->informasi_nama;?></a></h4>
                  <time datetime="2020-01-01"><?= $row->informasi_tanggal;?></time>
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
