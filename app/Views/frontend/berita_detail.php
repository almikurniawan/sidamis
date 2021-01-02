<?= $this->extend('frontend/default') ?>
<?= $this->section('content') ?>

  <main id="main">

    <!-- ======= Breadcrumbs ======= -->
    <section id="breadcrumbs" class="breadcrumbs">
      <div class="container">

        <div class="d-flex justify-content-between align-items-center">
          <h2>Berita</h2>
          <ol>
            <li><a href="<?php echo base_url();?>">Beranda</a></li>
            <li>Berita</li>
          </ol>
        </div>

      </div>
    </section><!-- End Breadcrumbs -->

    <!-- ======= Blog Section ======= -->
    <section id="blog" class="blog">
      <div class="container">

        <div class="row">

          <div class="col-lg-8 entries">






            <?php foreach($berita_detail as $row):?>
            <article class="entry entry-single">

              <div class="entry-img">
                <img src="<?php echo base_url();?>/uploads/berita/<?= $row->berita_foto;?>" alt="" class="img-fluid">
              </div>

              <h2 class="entry-title">
                <a href="blog-single.html"><?= $row->berita_judul;?></a>
              </h2>

              <div class="entry-meta">
                <ul>
                  <li class="d-flex align-items-center"><i class="icofont-user"></i> <a href="blog-single.html">Admin</a></li>
                  <li class="d-flex align-items-center"><i class="icofont-wall-clock"></i> <a href="<?php echo base_url();?>/berita/detail/<?= $row->berita_id;?>"><time datetime="2020-01-01"><?= $row->berita_tanggal;?></time></a></li>
                </ul>
              </div>

              <div class="entry-content">
                <p>
                <?= $row->berita_konten;?>
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
                <form action="<?php echo base_url();?>/berita/search" method="get">
                  <input name="search" type="text">
                  <button type="submit"><i class="icofont-search"></i></button>
                </form>

              </div><!-- End sidebar search formn-->


              <h3 class="sidebar-title">Berita Posts</h3>
              <div class="sidebar-item recent-posts">

                <?php foreach($berita_random as $row):?>
                <div class="post-item clearfix">
                  <img src="<?php echo base_url();?>/uploads/berita/<?= $row->berita_foto;?>" alt="">
                  <h4><a href="<?php echo base_url();?>/berita/detail/<?= $row->berita_id;?>"><?= $row->berita_judul;?></a></h4>
                  <time datetime="2020-01-01"><?= $row->berita_tanggal;?></time>
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
