<?= $this->extend('template/main') ?>
<?= $this->section('content') ?>
<section class="intro-single">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-lg-8 title-single-box" style="background-color: #eaf9f0;">
                <h1 class="title-single"><?= $page ?></h1>
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
                    <div class="card-group">
                        <?php foreach ($kajian as $k) : ?>
                            <div class="col-sm-4 mb-3">
                                <div class="card-columns-fluid">
                                    <div class="card box">
                                        <div class="img-box">
                                            <img src="/img/kajian/<?= $k['img_kajian'] ?>" class="card-img-top" style="min-width: 50px !important; max-height:300px; min-height:300px !important;">
                                        </div>
                                        <div class="card-body">
                                            <h5 class="card-title"><a href="javascript:void(0)"><?= ucwords($k['tema_kajian']) ?></a></h5>
                                            <p class="card-text">Materi akan di sampaikan oleh <strong><?= ucwords($k['pengisi_kajian']) ?></strong>.</p>
                                            <div class="d-flex justify-content-between">
                                                <p class="badge badge-success"><a href="/kajian/kategori/<?= $k['slug_kategoriartikel'] ?>" class="linkkategori"><?= ucwords($k['nama_kategoriartikel']) ?></a></p>
                                                <p class="card-text"><small class="text-muted">Tanggal : <?= date(' d M Y', strtotime($k['tgl_kajian'])) ?></small></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach  ?>
                    </div>
                    <?= $pager->links('kajian', 'style_page'); ?>
                </div>
            </div>
        </div>
    </section>
</main>

<?= $this->endSection() ?>