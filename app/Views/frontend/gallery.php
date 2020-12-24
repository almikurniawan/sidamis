<?= $this->extend('frontend/default') ?>
<?= $this->section('content') ?>

  <main id="main">

    <!-- ======= Breadcrumbs ======= -->
    <section id="breadcrumbs" class="breadcrumbs">
      <div class="container">

        <div class="d-flex justify-content-between align-items-center">
          <h2>Gallery</h2>
          <ol>
            <li><a href="<?php echo base_url();?>">Beranda</a></li>
            <li>Gallery</li>
          </ol>
        </div>

      </div>
    </section><!-- End Breadcrumbs -->

    <!-- ======= Portfolio Section ======= -->
    <section id="portfolio" class="portfolio">
      <div class="container">

        <div class="row">
          <div class="col-lg-12 d-flex justify-content-center">
            <ul id="portfolio-flters">
              <li data-filter="*" class="filter-active">All</li>
              <li data-filter=".filter-kegiatan">Kegiatan</li>
              <li data-filter=".filter-event">Event</li>
            </ul>
          </div>
        </div>

        <div class="row portfolio-container">

           <?php foreach($gallery as $row):?>
                <?php
                if($row->gallery_kategori_nama=="KEGIATAN"){
                 ?>
                  <div class="col-lg-4 col-md-6 portfolio-item filter-kegiatan">
                    <div class="portfolio-wrap">
                      <img src="<?php echo base_url();?>/uploads/gallery/<?= $row->gallery_foto;?>" class="img-fluid" alt="">
                      <div class="portfolio-info">
                        <h4><?= $row->gallery_nama;?></h4>
                        <div class="portfolio-links">
                          <a href="<?php echo base_url();?>/uploads/gallery/<?= $row->gallery_foto;?>" data-gall="portfolioGallery" class="venobox" title="App 1"><i class="bx bx-plus"></i></a>
                          <a href="<?php echo base_url();?>/gallery/detail/<?= $row->gallery_id;?>" data-gall="portfolioDetailsGallery" data-vbtype="iframe" class="venobox" title="Portfolio Details"><i class="bx bx-link"></i></a>
                        </div>
                      </div>
                    </div>
                  </div>
              <?php
            }else if($row->gallery_kategori_nama=="EVENT"){
              ?>
             <div class="col-lg-4 col-md-6 portfolio-item filter-event">
               <div class="portfolio-wrap">
                 <img src="<?php echo base_url();?>/uploads/gallery/<?= $row->gallery_foto;?>" class="img-fluid" alt="">
                 <div class="portfolio-info">
                   <h4><?= $row->gallery_nama;?></h4>
                   <div class="portfolio-links">
                     <a href="<?php echo base_url();?>/uploads/gallery/<?= $row->gallery_foto;?>" data-gall="portfolioGallery" class="venobox" title="App 1"><i class="bx bx-plus"></i></a>
                     <a href="<?php echo base_url();?>/gallery/detail/<?= $row->gallery_id;?>"  data-vbtype="iframe" class="venobox" title="Portfolio Details"><i class="bx bx-link"></i></a>
                   </div>
                 </div>
               </div>
             </div>
              <?php
              }
              ?>
          <?php endforeach;?>





        </div>

      </div>
    </section><!-- End Portfolio Section -->

  </main><!-- End #main -->

<?= $this->endSection() ?>
