<?= $this->extend('template/main') ?>
<?= $this->section('content') ?>

<section class="intro-single">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-lg-8 title-single-box" style="background-color: #eaf9f0;">
                <h1 class="title-single"><?= ucwords($artikel->judul_artikel) ?></h1>
                <span class="color-text-a"></span>
            </div>
            <div class="col-md-12 col-lg-4" style="background-color: #eaf9f0;">
                <nav aria-label="breadcrumb" class="breadcrumb-box d-flex justify-content-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="/">Home</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Artikel
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
                <div class="col-12">
                    <div class="news-img-box">
                        <img src="/img/artikel/<?= $artikel->img_artikel ?>" width="100%" class="img-fluid">
                    </div>
                </div>
                <div class="col-md-9 col-lg-9 col-sm-12">
                    <div class="post-information">
                        <ul class="list-inline color-a">
                            <li class="list-inline-item mr-4" style="cursor: pointer;">
                                <i class="fas fa-user-edit text-success"></i>
                                <span class="color-text-a"><?= ucwords($artikel->penulis) ?></span>
                            </li>
                            <li class="list-inline-item mr-4" style="cursor: pointer;">
                                <i class="fas fa-folder-open text-success"></i>
                                <span class="color-text-a"><?= ucwords($artikel->nama_kategoriartikel) ?></span>
                            </li>
                            <li class="list-inline-item mr-4" style="cursor: pointer;">
                                <i class="fas fa-calendar text-success"></i>
                                <span class="color-text-a"><?= date('d M Y', strtotime($artikel->created_at)) ?></span>
                            </li>
                        </ul>
                    </div>
                    <div class="post-content color-text-a text-justify">
                        <?= $artikel->isi_artikel ?>
                    </div>
                    <div class="post-footer">
                        <div class="post-share">
                            <span>Share: </span>&nbsp;
                            <ul class="list-inline socials">
                                <li class="list-inline-item">
                                    <a class="btn" style="background-color: rgb(24, 119, 242); width:2.7rem;" href="http://www.facebook.com/sharer.php?u=<?= base_url() ?>/artikel/read/<?= $artikel->slug_artikel ?>/t=<?= $artikel->judul_artikel ?>" data-togle="tooltip" title="Share : &quot;<?= $artikel->judul_artikel ?>&quot;" target="_blank">
                                        <i class="fa fa-facebook-f text-white" style="font-size: 20px;" aria-hidden="true"></i>
                                    </a>
                                    <a class="btn" style="background-color: rgb(85, 172, 238); width:2.7rem;" href="http://twitter.com/share?url=<?= base_url() ?>/artikel/<?= $artikel->slug_artikel ?>" data-togle="tooltip" title="Share : &quot;<?= $artikel->judul_artikel ?>&quot;" target="_blank">
                                        <i class="fa fa-twitter text-white" style="font-size: 20px;" aria-hidden="true"></i>
                                    </a>
                                    <a class="btn" style="background-color: rgb(18, 175, 10); width:2.7rem;" href="https://api.whatsapp.com/send?text=<?= $artikel->judul_artikel . " " . base_url() ?>/artikel/<?= $artikel->slug_artikel ?>" data-action="share/whatsapp/share" data-togle="tooltip" title="Share : &quot;<?= $artikel->judul_artikel ?>&quot;" target="_blank">
                                        <i class="fa fa-whatsapp text-white" style="font-size: 20px;" aria-hidden="true"></i>
                                    </a>
                                    <a class="btn" style="background-color: rgb(44, 165, 224); width:2.7rem;" href="https://telegram.me/share/url?url=<?= base_url() ?>/artikel/<?= $artikel->slug_artikel ?>&text=<?= $artikel->judul_artikel ?>" data-togle="tooltip" title="Share : &quot;<?= $artikel->judul_artikel ?>&quot;" target="_blank">
                                        <i class="fab fa-telegram-plane text-white" style="font-size: 20px;" aria-hidden="true"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4">
                    <div style="margin-top: 80px; padding-left:20px;">
                        <div class="title-box-d text-center font-bold">
                            <h3 class="title-d title-2 mt-3" style="font-size: 24px;">Kategori Artikel</h3>
                        </div>
                        <div class="mt--5">
                            <ul class="list-unstyled pl-2">
                                <?php foreach ($katartikel as $k) : ?>
                                    <li class="item-list-a" style="margin-top: -10px;">
                                        <i class="fa fa-angle-right text-success"></i> <a href="/artikel/kategori/<?= $k['nama_kategoriartikel'] ?>" class="title-b"><?= ucwords($k['nama_kategoriartikel']) ?></a>
                                        <hr>
                                    </li>
                                <?php endforeach ?>
                            </ul>
                        </div>
                    </div>

                    <div style="margin-top: 80px; padding-left:20px;">
                        <div class="title-box-d text-center font-bold">
                            <h3 class="title-d title-2 mt-3" style="font-size: 24px;">Artikel Terpopuler</h3>
                        </div>
                        <div class="mt--5">
                            <ul class="list-unstyled pl-3">
                                <?php foreach ($news as $k) : ?>
                                    <li class="item-list-a" style="margin-top: -10px;">
                                        <img src="/img/artikel/<?= $k['img_artikel'] ?>" width="75%"><br>
                                        <a href="/artikel/read/<?= $k['slug_artikel'] ?>"><small class="text-justify mt-1"><?= ucwords($k['judul_artikel']) ?></small></a><br>
                                        <i class="far fa-eye text-success" style="font-size: 13px;"> <?= $k['hits'] ?> Dilihat</i>
                                        <hr>
                                    </li>
                                <?php endforeach ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-12">

                <div class="view-komentar"></div>

                <div class="form-comments komentar">
                    <div class="title-box-d">
                        <h3 class="title-d"> Berikan komentar</h3>
                    </div>
                    <!-- <form class="form-a"> -->
                    <?= form_open('/home/kirim_komentar', ['class' => 'frmkomentar']) ?>
                    <?= csrf_field() ?>
                    <div class="row">
                        <input type="hidden" name="id_artikel" id="id_artikel" value="<?= $artikel->id_artikel ?>">
                        <input type="hidden" name="id_komentar" value="0" class="id_komentar">
                        <input type="hidden" name="parent_id_komentar" value="" class="id_komentar">
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="nama">Enter name</label>
                                <input type="text" class="form-control form-control form-control-a nama" id="nama" placeholder="Name *" name="nama">
                                <div class="invalid-feedback errNama"></div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="email">Enter email</label>
                                <input type="email" class="form-control form-control form-control-a " id="email" placeholder="Email *" name="email">
                                <div class="invalid-feedback errEmail"></div>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="form-group">
                                <label for="komentar">Enter message</label>
                                <textarea id="komentar" class="form-control isi_komen rep" placeholder="Comment *" cols="45" rows="3" name="komentar"></textarea>
                                <div class="invalid-feedback errKom"></div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-a btnSave"><i class="fas fa-paper-plane"></i> Send Message</button>
                        </div>
                    </div>
                    <!-- </form> -->
                    <?= form_close() ?>
                </div>
            </div>
    </section><!-- End Blog Single-->
</main>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
    function getkomentar() {
        let id_artikel = $('#id_artikel').val();
        $.ajax({
            url: "/home/getkomentar",
            data: {
                id_artikel: id_artikel
            },
            dataType: "json",
            success: function(response) {
                $('.view-komentar').html(response.data);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    }

    $(document).on('click', '.btnReply', function() {
        let id_komentar = $(this).attr("id");
        $(".frmkomentar")[0].reset();
        $('#nama').removeClass('is-invalid');
        $('#email').removeClass('is-invalid');
        $('#komentar').removeClass('is-invalid');
        $('.frmkomentar').attr('action', '/home/kirim_balasan');
        $(".nama").focus();
        $('.id_komentar').val(id_komentar);
    });


    $(document).ready(function() {

        getkomentar();

        const Toast = Swal.mixin({
            toast: true,
            position: 'center',
            showConfirmButton: false,
            iconColor: '#ffffff',
            background: '#2eca6a',
            customClass: {
                title: 'text-white',
            },
            timer: 3000
        });

        // $('.btnSave').on('click', function(e) {
        $('.frmkomentar').submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: "post",
                url: $(this).attr('action'),
                data: $(this).serialize(),
                dataType: "json",
                beforeSend: function() {
                    $('.btnSave').attr('disabled', true);
                    $('.btnSave').html('<i class="fas fa-spin fa-spinner"></i> &nbsp; Sending..');
                },
                complete: function() {
                    $('.btnSave').attr('disabled', false);
                    $('.btnSave').html('<i class="fas fa-paper-plane"></i> &nbsp; Send Message');
                },
                success: function(response) {
                    if (response.error) {
                        if (response.error.nama) {
                            $('#nama').addClass('is-invalid');
                            $('.errNama').html(response.error.nama);
                        } else {
                            $('#nama').removeClass('is-invalid');
                            $('.errNama').html(response.error.nama);
                        }
                        if (response.error.email) {
                            $('#email').addClass('is-invalid');
                            $('.errEmail').html(response.error.email);
                        } else {
                            $('#email').removeClass('is-invalid');
                            $('.errEmail').html(response.error.email);
                        }
                        if (response.error.komentar) {
                            $('.isi_komen').addClass('is-invalid');
                            $('.errKom').html(response.error.komentar);
                        } else {
                            $('.isi_komen').removeClass('is-invalid');
                            $('.errKom').html(response.error.komentar);
                        }
                    } else {
                        Toast.fire({
                            icon: 'success',
                            title: response.sukses
                        });
                        $(".frmkomentar")[0].reset();
                        getkomentar();
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        });
    });
</script>
<?= $this->endSection() ?>