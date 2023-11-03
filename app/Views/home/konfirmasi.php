<?= $this->extend('template/read') ?>
<?= $this->section('content') ?>

<section class="intro-single">
    <div class="container mt--5">
        <div class="row">
            <div class="col-12">
                <div class="card p-3 mb-1" style="background-color: #57d487;">
                    <h2 class="text-center text-white"><strong>Konfirmasi Donasi</strong></h2>
                </div>
            </div>
        </div>
    </div>
</section><!-- End Intro Single-->


<main id="main">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="card mb-5">
                    <div class="container">
                        <?= form_open('/home/getkonfirmasi', ['class' => 'frmgetkonfirmasi']) ?>
                        <!-- <form action="/konfirmasi" method="POST"> -->
                        <?= csrf_field() ?>
                        <div class="form-row mt-5 mb-4 d-flex justify-content-center">
                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" name="kode_donasi" placeholder="Masukan Kode Donasi" id="kode_donasi" autofocus>
                                    <div class="invalid-feedback errKode"></div>
                                </div>
                            </div>&nbsp;&nbsp;&nbsp;
                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <button class="btn btn-outline-success btnCari" type="submit"><i class="fas fa-search"></i> Cari</button>
                                </div>
                            </div>
                        </div>
                        <!-- </form> -->
                        <?= form_close() ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
    $(document).ready(function() {
        $('.frmgetkonfirmasi').submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: "post",
                url: $(this).attr('action'),
                data: $(this).serialize(),
                dataType: "json",
                beforeSend: function() {
                    $('.btnCari').attr('disabled', true);
                    $('.btnCari').html('<i class="fas fa-spin fa-spinner"></i> &nbsp; Mencari..');
                },
                complete: function() {
                    $('.btnCari').attr('disabled', false);
                    $('.btnCari').html('<i class="fas fa-search"></i> Cari');
                },
                success: function(response) {
                    if (response.error) {
                        if (response.error.kode_donasi) {
                            $('#kode_donasi').addClass('is-invalid');
                            $('.errKode').html(response.error.kode_donasi);
                        } else {
                            $('#kode_donasi').removeClass('is-invalid');
                            $('#kode_donasi').addClass('is-valid');
                            $('.errKode').html(response.error.kode_donasi);
                        }
                    } else if (response.eror) {
                        $('#kode_donasi').addClass('is-invalid');
                        $('.errKode').html(response.eror.kode_donasi);
                    } else {
                        window.location.href = response.link
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        })
    });
</script>
<?= $this->endSection() ?>