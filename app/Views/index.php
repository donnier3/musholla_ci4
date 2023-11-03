<?= $this->extend('template/main') ?>
<?= $this->section('content') ?>

<!-- ======= Intro Section ======= -->
<section id="home">
    <div class="intro intro-carousel">
        <div id="carousel" class="owl-carousel owl-theme">
            <?php foreach ($artikel as $ar) : ?>
                <div class="carousel-item-a intro-item bg-image" style="background-image: url(/img/artikel/<?= $ar['img_artikel'] ?>)">
                    <div class="overlay overlay-a"></div>
                    <div class="intro-content display-table">
                        <div class="table-cell">
                            <div class="container">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="intro-body">
                                            <h4 class="intro-title pb-4">
                                                <?= $ar['judul_artikel'] ?>
                                            </h4>
                                            <p class="intro-subtitle intro-price">
                                                <a href="/artikel/read/<?= $ar['slug_artikel'] ?>"><span class="price-a">Read more</span></a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    </div><!-- End Intro Section -->
</section>

<main id="main">

    <!-- ======= Jadwal Section ======= -->

    <section class="section-jadwal section-t3 mt-5" id="jadwal">
        <div class="container" data-aos="flip-up" data-aos-offset="300">
            <div class="row">
                <div class="col-12">
                    <div class="col-md-12">
                        <div class="title-wrap text-center">
                            <div class="title-box" style="margin-bottom: 30px;">
                                <h4 class="title-a">Jadwal Sholat</h4><strong>Wilayah DKI Jakarta dan Sekitarnya</strong>
                            </div>
                            <p style="font-size: 20px; margin-bottom:10px;" id="tglsholat"></p>
                            <div class="card-header-c mt-3">
                                <div class="ws card-box-ico">
                                    <div class="col-lg-12 col-md-6 col-sm-2">
                                        <script type="text/javascript" src="https://www.muslimpro.com/muslimprowidget.js?cityid=1642911&amp;language=id&amp;timeformat=24" async=""></script>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ======= End Jadwal Section ======= -->

    <!-- ======= Budget Section ======= -->
    <section class="section-budget section-t3" id="budget">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="col-md-12">
                        <div class="title-wrap d-flex justify-content-between">
                            <div class="title-box" data-aos="fade-right">
                                <h2 class="title-a">Pengumpulan Dana</h2>
                            </div>
                            <div class="title-link" data-aos="fade-left">
                                <a href="javascript:void()">Lihat Semua
                                    <span class="ion-ios-arrow-forward"></span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-group">
                <?php foreach ($donasi as $b) : ?>
                    <div class="col-sm-4 mb-3" data-aos="flip-left">
                        <div class="card-columns-fluid">
                            <div class="card">
                                <!-- <div class="card-title">
                                </div> -->
                                <div class="card-body text-justify box">
                                    <a href="javascript:void()" style="margin-top: -10px;">
                                        <p class="text-center font-weight-bold pl-3"><?= ucwords($b['nama_subkategoridonasi']) ?></p>
                                    </a>
                                    <div class="img-box">
                                        <img src="/img/budget/<?= $b['img_budget'] ?>" style="max-height: 200px; min-height:200px" class="card-img-top gambar">
                                    </div>
                                    <!-- </div>
                                <div class="card-footer"> -->
                                    <?php
                                    if (count($hitung) > 0) {
                                        $pr = round($b['Dana'] / $hitungbudget[0]['jumlah_budget'] * 100);
                                        if ($pr < 35) {
                                            $warna = "danger";
                                        } elseif ($pr < 75) {
                                            $warna = "warning";
                                        } elseif ($pr > 75) {
                                            $warna = "success";
                                        }
                                    } else {
                                        $pr = '0';
                                    }

                                    $tgl = new DateTime($b['tgl_target']);
                                    $now = new DateTime();
                                    $sisa = $now->diff($tgl)->days;
                                    ?>
                                    <div class="mt-3" style="font-size: 15px;">
                                        <p>Dana yang sudah terkumpul sebesar </p>
                                        <div class="row pl-2" style="margin-top: -10px;">
                                            <strong class="text-<?= $warna ?> font-weight-bold pl-2"> Rp <?= number_format($b['Dana'], 0, ',', '.'); ?></strong> &nbsp; Dari &nbsp;<p class="text-muted font-weight-bold"> Rp <?= number_format($b['jumlah_budget'], 0, ',', '.'); ?></p>
                                        </div>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar bg-<?= $warna ?>" role="progressbar" style="width: <?= $pr ?>%" aria-valuenow="<?= $pr ?>" aria-valuemin="0" aria-valuemax="100"><?= $pr ?> %</div>
                                    </div>
                                    <div class="d-flex justify-content-between mt-3" style="font-size: 13px;">
                                        <p><strong><?= $b['Donatur'] ?></strong>&nbsp;Donasi</P>
                                        <p>Sisa <strong> <?= $sisa ?>&nbsp; Hari</strong> Lagi</p>
                                    </div>
                                    <div class="col-sm-12">
                                        <button class="btn btn-b btn-xs w-100 btnDonasi" onclick="window.location.href= '/donasi/<?= $b['slug_subkategoridonasi'] ?>'"> Donasi Sekarang</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>
        </div>
    </section>

    <!-- ======= Artikel Section ======= -->
    <section class="section-properties section-t3">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="title-wrap d-flex justify-content-between">
                        <div class="title-box" data-aos="fade-right">
                            <h2 class="title-a">Artikel</h2>
                        </div>
                        <div class="title-link" data-aos="fade-left">
                            <a href="/artikel">Lihat Semua
                                <span class="ion-ios-arrow-forward"></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-group">
                <?php $no = 0;
                // if ($no <= 6) {
                foreach ($artikel as $ar) :  ?>
                    <div class="col-sm-4 mb-3" data-aos="flip-left">
                        <div class="card-columns-fluid">
                            <div class="card box">
                                <div class="img-box">
                                    <img src="/img/artikel/<?= $ar['img_artikel'] ?>" style="max-height: 200px; min-height:200px" class="card-img-top">
                                </div>
                                <div class="card-body text-justify">
                                    <p class="badge badge-success"><a href="/artikel/kategori/<?= $ar['slug_kategoriartikel'] ?>" class="linkkategori"><?= ucwords($ar['nama_kategoriartikel']) ?></a></p>
                                    <h5 class="card-title"><a href="/artikel/read/<?= $ar['slug_artikel'] ?>"> <?= ucwords($ar['judul_artikel']) ?></a></h5>
                                    <?php if (strlen($ar['isi_artikel']) <= 100) { ?>
                                        <p class="card-text"><?= ucfirst($ar['isi_artikel']) ?>.</p>
                                    <?php } else {
                                        echo substr($ar['isi_artikel'], 0, 100) . '....<br/><br/><a class="text-success" href="/artikel/read/' . $ar['slug_artikel'] . '">Read More</a>';
                                    } ?><br>
                                    <div class="d-flex justify-content-between">
                                        <small class="text-muted">Posting at <?= date('d M Y - H:i', strtotime($ar['posting_date'])) ?> WIB</small>
                                        <i class="far fa-eye fa-sm text-success" style="cursor: pointer;"> <?= number_format($ar['hits'], 0, ',', '.') ?></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                endforeach;
                // } 
                ?>
            </div>
        </div>
    </section>

    <!-- ======= End Artikel Section ======= -->

    <!-- ======= Latest News Section ======= -->
    <section class="section-news section-t3" id="kajian">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="title-wrap d-flex justify-content-between">
                        <div class="title-box" data-aos="fade-right">
                            <h2 class="title-a">Kajian</h2>
                        </div>
                        <div class="title-link" data-aos="fade-left">
                            <a href="/kajian">Lihat Semua
                                <span class="ion-ios-arrow-forward"></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div id="new-carousel" class="owl-carousel owl-theme">
                <?php foreach ($kajian as $k) : ?>
                    <div class="carousel-item-c" data-aos="flip-left">
                        <div class="card-box-b card-shadow news-box">
                            <div class="img-box-b">
                                <img src="img/kajian/<?= $k['img_kajian'] ?>" style="min-width: 350px !important; max-height:500px; min-height:500px !important;" class="img-fluid gambar">
                            </div>
                            <div class="card-overlay">
                                <div class="card-header-b">
                                    <div class="card-category-b">
                                        <a href="javascript:void(0)" class="category-b"><?= ucwords($k['pengisi_kajian']) ?></a>
                                    </div>
                                    <div class="card-title-b">
                                        <h2 class="title-2">
                                            <a href="javascript:void(0)"><?= ucwords($k['tema_kajian']) ?></a>
                                        </h2>
                                    </div>
                                    <div class="card-date">
                                        <span class="date-b"><?= date('d M Y', strtotime($k['tgl_kajian'])) ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>
        </div>
    </section>
    <!-- End Latest News Section -->



    <!-- ======= Latest News Section ======= -->
    <section class="section-news section-t3" id="video">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="title-wrap d-flex justify-content-between">
                        <div class="title-box" data-aos="fade-right">
                            <h2 class="title-a">Video</h2>
                        </div>
                        <div class="title-link" data-aos="fade-left">
                            <a href="/video">Lihat Semua
                                <span class="ion-ios-arrow-forward"></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div id="video-carousel" class="owl-carousel owl-theme">
                <?php foreach ($video as $k) : ?>
                    <div class="carousel-item-c box" data-aos="flip-left">
                        <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/<?= $k['link_video'] ?>" height="100%" width="100%" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen style="min-height: 300px;"></iframe>
                        <p class="title-2 text-center" style="font-size: 15px;">
                            <a href="javascript:void(0)"><?= ucwords($k['judul_video']) ?></a>
                        </p>
                    </div>
                <?php endforeach ?>
            </div>
        </div>
    </section>
    <!-- End Latest News Section -->
</main>
<?= $this->endSection() ?>