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
                    <!-- <h4 class="text-center mt-3">Assalamu'alaikum</h4> -->
                    <div class="card-body row">
                        <div class="col-md-8">
                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email_donatur" class="col-sm-8 col-form-label">Nama</label>
                                        <div class="col-sm-12">
                                            <span><?= ucwords($nama_donatur) ?></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="id_kategoridonasi" class="col-sm-8 col-form-label">Jenis Donasi</label>
                                        <div class="col-sm-12">
                                            <span><?= ucwords($nama_kategoridonasi . ' - ' . $nama_subkategoridonasi) ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="hp_donatur" class="col-sm-8 col-form-label">Handphone</label>
                                        <div class="col-sm-12">
                                            <span>+62<?= $hp_donatur ?></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="id_subkategoridonasi" class="col-sm-8 col-form-label">Email Donatur</label>
                                        <div class="col-sm-12">
                                            <span><?= $email_donatur ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email_donatur" class="col-sm-8 col-form-label">Jumlah Donasi</label>
                                        <div class="col-sm-12">
                                            <span>Rp <?= number_format($jumlah_donasi, 0, '.', ',') ?></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="jumlah_donasi" class="col-sm-8 col-form-label">Bank Tujuan</label>
                                        <div class="col-sm-12">
                                            <span><?= ucwords($nama_bank . ' - (' . $kode_bank . ')' . $no_rekening) ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="alamat" class="col-sm-6 col-form-label">Alamat</label>
                                        <div class="col-sm-12">
                                            <span><?= ucwords($alamat_donatur) ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <?php if ($bukti_donasi == '') { ?>
                                <?= form_open_multipart('', ['class' => 'frmkirimbukti']) ?>
                                <input type="hidden" name="id_konfirmasidonasi" value="<?= $id_konfirmasidonasi ?>">
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="email_donatur" class="col-sm-8 col-form-label">Tanggal Donasi</label>
                                            <div class="input-group col-sm-12" data-target-input="nearest">
                                                <input type="text" class="form-control date" name="tgl_donasi" data-date-format="yyyy-mm-dd" data-date-end-date="0d" placeholder="Tanggal Donasi" id="tgl_donasi" data-target="#tgl_donasi">
                                                <div class="input-group-append">
                                                    <div class="input-group-text" data-target="#tgl_donasi" data-toggle="datetimepicker" id="basic-addon2">
                                                        <i class="fas fa-calendar-alt"></i>
                                                    </div>
                                                </div>
                                                <div class="invalid-feedback errTgl">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="bukti_donasi" class="col-sm-8 col-form-label">Upload Bukti</label>
                                            <div class="col-sm-12">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="bukti_donasi" name="bukti_donasi" onchange="previewPic()">
                                                    <div class="invalid-feedback errFile">
                                                    </div>
                                                    <label class="custom-file-label pic" for="bukti_donasi">Choose File..</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <div class="form-group preview">
                                            <label for="" class="col-sm-8 col-form-label">Preview Bukti</label>
                                            <div class="col-sm-12">
                                                <img style="max-width: 300px; max-height:300px;" class="rounded img-thumbnail img-preview">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <div class="col-sm-12">
                                            <button class="btn w-100 btn-outline-primary btnSave"><i class="fas fa-paper-plane"></i> Kirim</button>
                                        </div>
                                    </div>
                                </div>
                                <?= form_close() ?>
                            <?php } else { ?>
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="alamat" class="col-sm-6 col-form-label">Tanggal Donasi</label>
                                            <div class="col-sm-12">
                                                <span><?= ucwords($tgl_donasi) ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="alamat" class="col-sm-6 col-form-label">Bukti Donasi</label>
                                            <div class="col-sm-12">
                                                Anda belum <a href="/account/login" class="btn btn-sm btn-danger">Login</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <?php if ($bukti_donasi != '') { ?>
                        <span>
                            <p class="text-center">Jazakallahu Khairan Jaza Bpk/Ibu <?= ucwords($nama_donatur) ?> atas donasi yang telah diberikan</p>
                        </span>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</main>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
    function previewPic() {
        const bukti_donasi = document.querySelector('#bukti_donasi');
        const bukti_donasiLabel = document.querySelector('.pic');
        const imgPreview = document.querySelector('.img-preview');
        $('.preview').show();
        bukti_donasiLabel.textContent = bukti_donasi.files[0].name;

        const filebukti_donasi = new FileReader();
        filebukti_donasi.readAsDataURL(bukti_donasi.files[0]);

        filebukti_donasi.onload = function(e) {
            imgPreview.src = e.target.result;
            console.log(bukti_donasi);
        }
    }

    $(document).ready(function() {
        $('.preview').hide();
        $('.date').datepicker({
            todayBtn: "linked",
            language: "id",
            autoclose: true,
            todayHighlight: true,
            toggleActive: true
        });

        // $('.frmkirimbukti').submit(function(e) {
        $('.btnSave').on('click', function(e) {
            e.preventDefault();
            let form = $('.frmkirimbukti')[0];
            let data = new FormData(form);
            $.ajax({
                type: "post",
                url: "/home/kirim_bukti",
                data: data,
                enctype: 'multipart/form-data',
                processData: false,
                contentType: false,
                cache: false,
                dataType: "json",
                beforeSend: function() {
                    $('.btnSave').attr('disabled', true);
                    $('.btnSave').html('<i class="fas fa-spin fa-spinner"></i> &nbsp; Proses..');
                },
                complete: function() {
                    $('.btnSave').attr('disabled', false);
                    $('.btnSave').html('<i class="fas fa-paper-plane"></i> &nbsp; Kirim ');
                },
                success: function(response) {
                    if (response.error) {
                        if (response.error.tgl_donasi) {
                            $('#tgl_donasi').addClass('is-invalid');
                            $('.errTgl').html(response.error.tgl_donasi);
                        } else {
                            $('#tgl_donasi').removeClass('is-invalid');
                            $('.errTgl').html(response.error.tgl_donasi);
                        }
                        if (response.error.bukti_donasi) {
                            $('#bukti_donasi').addClass('is-invalid');
                            $('.errFile').html(response.error.bukti_donasi);
                        } else {
                            $('#bukti_donasi').removeClass('is-invalid');
                            $('.errFile').html(response.error.bukti_donasi);
                        }
                    } else {
                        Swal.fire({
                            title: response.sukses,
                            html: '<br> Anda akan dialihkan dalam <b></b> detik.',
                            timer: 3000,
                            timerProgressBar: true,
                            showConfirmButton: false,
                            onBeforeOpen: () => {
                                Swal.showLoading()
                                timerInterval = setInterval(() => {
                                    const content = Swal.getContent()
                                    if (content) {
                                        const b = content.querySelector('b')
                                        if (b) {
                                            b.textContent = Swal.getTimerLeft()
                                        }
                                    }
                                }, 100)
                            },
                            onClose: () => {
                                clearInterval(timerInterval)
                                window.location = response.link
                            }
                        }).then((result) => {
                            /* Read more about handling dismissals below */
                            if (result.dismiss === Swal.DismissReason.timer) {
                                console.log(result.flash)
                            }
                        })
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