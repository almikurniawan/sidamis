<?= $this->extend('frontend/default') ?>
<?= $this->section('content') ?>
  <!-- ======= Hero Section ======= -->
  <section id="hero">
    <div id="heroCarousel" class="carousel slide carousel-fade" data-ride="carousel">

      <ol class="carousel-indicators" id="hero-carousel-indicators"></ol>

      <div class="carousel-inner" role="listbox">

        <?php foreach($slide as $row):?>
        <!-- Slide 1 -->
        <div class="carousel-item active" style="background-image: url(<?php echo base_url();?>/uploads/slide/<?php echo $row->slide_foto;?>)">
          <div class="carousel-container">
            <div class="container">
              <h2 class="animate__animated animate__fadeInDown"><?php echo $row->slide_judul;?></h2>
              <p class="animate__animated animate__fadeInUp"><?php echo $row->slide_tag;?></p>
              <a href="<?php echo $row->slide_link;?>" class="btn-get-started animate__animated animate__fadeInUp scrollto">Read More</a>
            </div>
          </div>
        </div>
      <?php endforeach;?>





      </div>

      <a class="carousel-control-prev" href="#heroCarousel" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon icofont-simple-left" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>

      <a class="carousel-control-next" href="#heroCarousel" role="button" data-slide="next">
        <span class="carousel-control-next-icon icofont-simple-right" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>

    </div>
  </section><!-- End Hero -->

  <main id="main">

    <!-- ======= About Section ======= -->
    <section id="about" class="about">
      <div class="container">

        <div class="row content">
          <div class="col-lg-6">
            <h2>Kedudukan Tugas dan Fungsi</h2>
            <span style="color: rgb(112, 112, 112); font-family: Montserrat, sans-serif; border-width: 0px; border-style: solid; border-color: rgb(226, 232, 240); margin: 0px; padding: 0px; font-weight: bolder;">Pembangunan bidang kesejahteraan sosial&nbsp;</span><span style="color: rgb(112, 112, 112); font-family: Montserrat, sans-serif;">sebagai bagian tak terpisahkan dari pembangunan nasional telah mengambil peran aktif dalam meningkatkan kualitas hidup masyarakat untuk mewujudkan kehidupan yang layak dan bermartabat, memenuhi hak kebutuhan dasar yang diselenggarakan melalui peslide dan pengembangan kesejahteraan sosial secara terprogram, terarah, dan berkelanjutan sebagaimana diamanatkan oleh Undang-Undang RI Nomor 11 Tahun 2009 tentang Kesejahteraan Sosial Provinsi Jawa Tengah dengan fokus pada 7 (tujuh) permasalahan sosial yakni Kemiskinan, Keterlantaran, Kecacatan, Ketunaan Sosial dan Penyimpangan Perilaku, Keterpencilan, Korban Benc ana serta Tindak Korban Kekerasan dan Pekerja Migran , baik yang bersifat primer maupun akibat/dampak non sosial.</span>
          </div>
          <div class="col-lg-6 pt-4 pt-lg-0">
            <ul style="margin-bottom: 30px; color: rgb(102, 102, 102); font-family: &quot;Open Sans&quot;, Arial, Helvetica, sans-serif;"><li>Dinas Sosial merupakan unsur pelaksana urusan pemerintahan bidang sosial yang menjadi kewenangan daerah</li><li>Dinas Sosial sebagaimana dipimpin oleh Kepala Dinas yang berkedudukan di bawah dan bertanggung jawab kepada Bupati melalui Sekretaris Daerah.</li><li>Dinas Sosial sebagaimana mempunyai tugas membantu Bupati melaksanakan Urusan Pemerintahan dibidang sosial yang menjadi kewenangan daerah dan tugas pembantuan yang diberikan kepada kabupaten.</li><li>Dinas Sosial dalam melaksanakan tugas menyelenggarakan fungsi:<ol><li>perumusan kebijakan bidang sosial;</li><li>pelaksanaan kebijakan bidang sosial;</li><li>pelaksanaan evaluasi dan pelaporan bidang sosial;</li><li>pelaksanaan administrasi Dinas Sosial sesuai dengan lingkup tugasnya;</li><li>pelaksanaan fungsi lain yang diberikan oleh Bupati terkait dengan tugas dan fungsinya</li></ol></li></ul>
          </div>
        </div>

      </div>
    </section><!-- End About Section -->

    <!-- ======= Clients Section ======= -->
    <section id="clients" class="clients section-bg">
      <div class="container">

        <div class="row">
          <?php foreach($dinas as $row):?>
          <div class="col-lg-2 col-md-4 col-6 d-flex align-items-center justify-content-center">
            <a href="<?= $row->dinas_link;?>"><img src="<?php echo base_url();?>/uploads/dinas/<?= $row->dinas_logo;?>" class="img-fluid" alt=""></a>
          </div>
          <?php endforeach;?>

        </div>

      </div>
    </section><!-- End Clients Section -->

    <!-- ======= Services Section ======= -->
    <section id="services" class="services">
      <div class="container">

        <div class="section-title">
          <h2>Program</h2>
          <p>Layanan masyarakat kami</p>
        </div>

        <div class="row">
          <?php foreach($layanan as $row):?>
          <div class="col-md-6 mt-4 mt-md-0">
            <div class="icon-box">
              <?= $row->layanan_icon;?>
              <h4><a href="#">  <?= $row->layanan_nama;?></a></h4>
              <p>  <?= $row->layanan_deskripsi;?></p>
            </div>
          </div>
          <?php endforeach;?>

      </div>
    </section><!-- End Services Section -->

    <!-- ======= Portfolio Section ======= -->
    <section id="portfolio" class="portfolio">
      <div class="container">

        <div class="section-title">
          <h2>Gallery</h2>
          <p>Kegiatan</p>
        </div>

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
