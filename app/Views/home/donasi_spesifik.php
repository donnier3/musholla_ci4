<?= $this->extend('template/read') ?>
<?= $this->section('content') ?>

<main id="main" style="padding-top: 100px;">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="card p-3 mb-1" style="background-color: #57d487;">
                    <h2 class="text-center text-white"><strong>Donasi</strong></h2>
                </div>
                <div class="card mb-5">
                    <?= form_open('/home/kirim_donasi', ['class' => 'frmberdonasi']) ?>
                    <?= csrf_field() ?>
                    <?php $kode_donasi = date('YmdHis') ?>
                    <div class="card-body row">
                        <div class="col-md-8">
                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nama_donatur" class="col-sm-6 col-form-label">Nama Donatur</label>
                                        <div class="col-sm-12">
                                            <input type="hidden" name="kode_donasi" value="<?= $kode_donasi ?>">
                                            <input type="text" class="form-control" name="nama_donatur" placeholder="Nama Donatur" id="nama_donatur">
                                            <div class="invalid-feedback errNama">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="id_kategoridonasi" class="col-sm-6 col-form-label">Jenis Donasi</label>
                                        <div class="col-sm-12">
                                            <!-- <input type="text" class="form-control" name="id_kategoridonasi" placeholder="Email" id="id_kategoridonasi"> -->
                                            <select name="id_kategoridonasi" id="id_kategoridonasi" class="form-control custom-select" style="width: 100%;" readonly>
                                                <option value="<?= $donasi[0]['id_kategoridonasi'] ?>"><?= $donasi[0]['nama_kategoridonasi'] ?></option>
                                            </select>
                                            <div class="invalid-feedback errJenis">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="hp_donatur" class="col-sm-6 col-form-label">Handphone</label>
                                        <div class="input-group col-sm-12">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">+62</span>
                                            </div>
                                            <input type="text" class="form-control" name="hp_donatur" placeholder="Nomor Handphone" id="hp_donatur">
                                            <div class="invalid-feedback errHp">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="id_subkategoridonasi" class="col-sm-8 col-form-label">Keterangan Donasi</label>
                                        <div class="col-sm-12">
                                            <div id="loading"></div>
                                            <select name="id_subkategoridonasi" id="id_subkategoridonasi" class="form-control custom-select" style="width: 100%;" readonly>
                                                <option value="<?= $sub['id_subkategoridonasi'] ?>"><?= $sub['nama_subkategoridonasi'] ?></option>
                                            </select>
                                            <div class="invalid-feedback errSub">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email_donatur" class="col-sm-6 col-form-label">Email</label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" name="email_donatur" placeholder="Email donatur" id="email_donatur">
                                            <div class="invalid-feedback errEmail">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="jumlah_donasi" class="col-sm-6 col-form-label">Jumlah</label>
                                        <div class="input-group col-sm-12">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Rp</span>
                                            </div>
                                            <input type="text" class="form-control" name="jumlah_donasi" id="jumlah_donasi">
                                            <div class="invalid-feedback errJml">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="alamat" class="col-sm-6 col-form-label">Alamat</label>
                                        <div class="col-sm-12">
                                            <textarea name="alamat_donatur" class="form-control" id="alamat_donatur" placeholder="Alamat Donatur" cols="30" rows="2"></textarea>
                                            <div class="invalid-feedback errAlamat"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <h4 class="text-center mt-3" style="color: tomato;">Metode Pembayaran</h4>
                            <div class="card-body">
                                <p class="errBank">Silakan pilih Bank yang dituju :</p>

                                <?php foreach ($bank as $b) : ?>
                                    <div class="custom-control custom-checkbox">
                                        <label class="">
                                            <input class="form-check-input" type="radio" name="id_bank" id="id_bank" value="<?= $b['id_bank'] ?>">
                                            <img src="/img/bank/<?= $b['logo_bank'] ?>" width="100">
                                        </label>
                                        <div class="invalid-feedback errBank"></div>
                                    </div>
                                <?php endforeach ?>
                            </div>
                            <button type="submit" class="btn btn-warning w-100 btnSave"> Donasi Sekarang</button>
                        </div>
                    </div>
                    <?= form_close() ?>
                </div>
            </div>
        </div>
    </div>
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
            customClass: {
                title: 'text-white',
                background: 'bg-success',
            },
            timer: 3000
        });

        // $('.btnSave').on('click', function(e) {
        $('.frmberdonasi').submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: "post",
                url: $(this).attr('action'),
                data: $(this).serialize(),
                dataType: "json",
                beforeSend: function() {
                    $('.btnSave').attr('disabled', true);
                    $('.btnSave').html('<i class="fas fa-spin fa-spinner"></i> &nbsp; Process...');
                },
                complete: function() {
                    $('.btnSave').attr('disabled', false);
                    $('.btnSave').html('Donasi Sekarang');
                },
                success: function(response) {
                    if (response.error) {
                        if (response.error.nama_donatur) {
                            $('#nama_donatur').addClass('is-invalid');
                            $('.errNama').html(response.error.nama_donatur);
                        } else {
                            $('#nama_donatur').removeClass('is-invalid');
                            $('#nama_donatur').addClass('is-valid');
                            $('.errNama').html(response.error.nama_donatur);
                        }
                        if (response.error.hp_donatur) {
                            $('#hp_donatur').addClass('is-invalid');
                            $('.errHp').html(response.error.hp_donatur);
                        } else {
                            $('#hp_donatur').removeClass('is-invalid');
                            $('#hp_donatur').addClass('is-valid');
                            $('.errHp').html(response.error.hp_donatur);
                        }
                        if (response.error.jumlah_donasi) {
                            $('#jumlah_donasi').addClass('is-invalid');
                            $('.errJml').html(response.error.jumlah_donasi);
                        } else {
                            $('#jumlah_donasi').removeClass('is-invalid');
                            $('#jumlah_donasi').addClass('is-valid');
                            $('.errJml').html(response.error.jumlah_donasi);
                        }
                        if (response.error.email_donatur) {
                            $('#email_donatur').addClass('is-invalid');
                            $('.errEmail').html(response.error.email_donatur);
                        } else {
                            $('#email_donatur').removeClass('is-invalid');
                            $('#email_donatur').addClass('is-valid');
                            $('.errEmail').html(response.error.email_donatur);
                        }

                        if (response.error.id_bank) {
                            $('#id_bank').addClass('is-invalid');
                            $('.errBank').html(response.error.id_bank);
                        } else {
                            $('#id_bank').removeClass('is-invalid');
                            $('#id_bank').addClass('is-valid');
                            $('.errBank').html(response.error.id_bank);
                        }
                    } else {
                        Toast.fire({
                            icon: 'success',
                            title: response.sukses
                        });
                        $(".frmberdonasi")[0].reset();
                        window.location.href = response.link

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