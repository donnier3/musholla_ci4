<?= $this->extend('template/main') ?>
<?= $this->section('content') ?>
<section class="intro-single">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-lg-8 title-single-box" style="background-color: #eaf9f0;">
                <h1 class="title-single"><?= $page ?> <small class="text-muted">- <?= ucwords($kategori) ?></small> </h1>
                <span class="color-text-a"></span>
            </div>
            <div class="col-md-12 col-lg-4" style="background-color: #eaf9f0;">
                <nav aria-label="breadcrumb" class="breadcrumb-box d-flex justify-content-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="/">Home</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            <?= $page ?>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section><!-- End Intro Single-->

<main id="main">
    <section class="news-single nav-arrow-b">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-4">
                    <?php if (!empty($artikel)) { ?>
                        <div class="card-group">
                            <?php foreach ($artikel as $k) : ?>
                                <div class="col-sm-4 mb-3">
                                    <div class="card-columns-fluid">
                                        <div class="card">
                                            <img src="/img/artikel/<?= $k['img_artikel'] ?>" class="card-img-top" style="min-width: 50px !important; max-height:300px; min-height:300px !important;">
                                            <div class="card-body text-justify">
                                                <p class="badge badge-success"><a href="/artikel/kategori/<?= $k['slug_kategoriartikel'] ?>" class="linkkategori"><?= ucwords($k['nama_kategoriartikel']) ?></a></p>
                                                <h5 class="card-title"><a href="/artikel/read/<?= $k['slug_artikel'] ?>"><?= ucwords($k['judul_artikel']) ?></a></h5>
                                                <?php if (strlen($k['isi_artikel']) <= 100) { ?>
                                                    <p class="card-text"><?= ucfirst($k['isi_artikel']) ?>.</p>
                                                <?php } else {
                                                    echo substr($k['isi_artikel'], 0, 100) . '....<br/><br/><a class="text-success" href="/artikel/read/' . $k['slug_artikel'] . '">Read More</a>';
                                                } ?><br>
                                                <div class="d-flex justify-content-between">
                                                    <small class="text-muted">Posting at <?= date('d M Y - H:i', strtotime($k['posting_date'])) ?> WIB</small>
                                                    <i class="far fa-eye fa-sm text-success" style="cursor: pointer;"> <?= number_format($k['hits'], 0, ',', '.') ?></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div> <?php
                                echo $pager->links('artikel', 'style_page');
                            } else {
                                echo '<div class="col-sm-12"><div class="card-body"><h3 class="text-center">{Artikel tidak ditemukan}</h3></div></div>';
                            } ?>
                </div>
            </div>
        </div>
        </div>
    </section>
</main>
<?= $this->endSection() ?>