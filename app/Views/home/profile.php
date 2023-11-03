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
                    <div class="title-box-d font-bold" style="margin-top: 70px;">
                        <h1 class="title-d title-1" style="font-size: 2.5rem;">Sejarah</h1>
                    </div>
                    <div class="row">
                        <div class="post-content color-text-a text-justify pr-3 col-sm-12 col-md-8">
                            <?= $seting[0]['about_me'] ?>
                        </div>
                        <div class="col-sm-12 col-md-4 col-lg-4 img-box">
                            <img src="/img/setting/<?= $seting[0]['images'] ?>" class="img-thumbnail" style="max-width: 300px; max-height:300px;">
                        </div>
                    </div>
                    <div class="title-box-d font-bold" style="margin-top: 70px;">
                        <h1 class="title-d title-1" style="font-size: 2.5rem;">Visi</h1>
                    </div>
                    <div class="post-content color-text-a text-justify">
                        <?= $seting[0]['visi'] ?>
                    </div>
                    <div class="title-box-d font-bold" style="margin-top: 70px;">
                        <h1 class="title-d title-1" style="font-size: 2.5rem;">Misi</h1>
                    </div>
                    <div class="post-content color-text-a text-justify" style="margin-left: -23px;">
                        <?= $seting[0]['misi'] ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?= $this->endSection() ?>