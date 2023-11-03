<?= $this->extend('template/main') ?>
<?= $this->section('content') ?>
<style>
    .card-body:hover {
        color: #2eca6a;
    }
</style>
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
                <div class="col-md-4 col-sm-12 mb-3">
                    <div class="card box">
                        <div class="card-body text-center">
                            <i class="fas fa-map-marked-alt fa-5x text-center"></i><br><br>
                        </div>
                        <p class="text-center"><?= ucwords($seting[0]['address']) ?></p>
                    </div>
                </div>
                <div class="col-md-4 col-sm-12 mb-3">
                    <div class="card box">
                        <div class="card-body text-center">
                            <i class="fas fa-mobile-alt fa-5x text-center"></i><br><br>
                        </div>
                        <p class="text-center">+62<?= ucwords($seting[0]['phone']) ?></p>
                    </div>
                </div>
                <div class="col-md-4 col-sm-12 mb-3">
                    <div class="card box">
                        <div class="card-body text-center">
                            <i class="far fa-envelope fa-5x text-center"></i><br><br>
                        </div>
                        <p class="text-center"><?= $seting[0]['email'] ?></p>
                    </div>
                </div>
                <div class="col-sm-12 mt-2" style="margin-bottom: -80px;">
                    <div class="contact-map">
                        <div id="map" class="contact-map">
                            <?= $seting[0]['maps'] ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 section-t8">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="title-wrap d-flex justify-content-between">
                                <div class="title-box-d">
                                    <h2 class="title-d">Saran</h2>
                                </div>
                            </div>
                            <div style="margin-top: -50px;">
                                <!-- <form action="home/kirim_pesan" method="post" role="form" class="php-email-form" style="margin-top: -50px;"> -->
                                <?= form_open('/home/kirim_pesan', ['class' => 'frmpesan']) ?>
                                <?= csrf_field() ?>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <input type="text" name="nama" class="form-control form-control-lg form-control-a" placeholder="Nama " id="nama">
                                            <div class="invalid-feedback errNama">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <input name="email" type="email" class="form-control form-control-lg form-control-a" placeholder="Email" id="email">
                                            <div class="invalid-feedback errEmail">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <div class="form-group">
                                            <input type="text" name="subject" class="form-control form-control-lg form-control-a" placeholder="Subject" id="subject">
                                            <div class="invalid-feedback errSub">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <textarea name="pesan" class="form-control form-control-a form-control-lg" name="message" cols="45" rows="8" id="pesan" placeholder="Pesan"></textarea>
                                            <div class="invalid-feedback errPes">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <div class="mb-3">
                                            <!-- <div class="loading">Loading</div>
                                        <div class="error-message"></div>
                                        <div class="sent-message">Your message has been sent. Thank you!</div> -->
                                        </div>
                                    </div>
                                    <div class="col-md-12 text-center">
                                        <button type="submit" class="btn btn-a btnSave">Send Message</button>
                                    </div>
                                </div>
                                <!-- </form> -->
                                <?= form_close() ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
    $(document).ready(function() {
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
        $('.frmpesan').submit(function(e) {
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
                    $('.btnSave').html('Send Message ');
                },
                success: function(response) {
                    if (response.error) {
                        if (response.error.nama) {
                            $('#nama').addClass('is-invalid');
                            $('.errNama').html(response.error.nama);
                        } else {
                            $('#nama').removeClass('is-invalid');
                            $('#nama').addClass('is-valid');
                            $('.errNama').html(response.error.nama);
                        }
                        if (response.error.email) {
                            $('#email').addClass('is-invalid');
                            $('.errEmail').html(response.error.email);
                        } else {
                            $('#email').removeClass('is-invalid');
                            $('#email').addClass('is-valid');
                            $('.errEmail').html(response.error.email);
                        }
                        if (response.error.subject) {
                            $('#subject').addClass('is-invalid');
                            $('.errSub').html(response.error.subject);
                        } else {
                            $('#subject').removeClass('is-invalid');
                            $('#subject').addClass('is-valid');
                            $('.errSub').html(response.error.subject);
                        }
                        if (response.error.pesan) {
                            $('#pesan').addClass('is-invalid');
                            $('.errPes').html(response.error.pesan);
                        } else {
                            $('#pesan').removeClass('is-invalid');
                            $('#pesan').addClass('is-valid');
                            $('.errPes').html(response.error.pesan);
                        }
                    } else {
                        Toast.fire({
                            icon: 'success',
                            title: response.sukses
                        });
                        $(".frmpesan")[0].reset();
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