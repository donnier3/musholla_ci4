<!-- Modal -->
<div class="modal fade" id="modal-edit" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary-gradient">
                <h5 class="modal-title text-white" id="staticBackdropLabel">Edit Donasi</h5>
            </div>
            <?= form_open('/auth/donasi/updatedonasi', ['class' => 'frmupdatedonasi']) ?>
            <div class="modal-body">
                <?= csrf_field() ?>
                <div class="form-row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nama_donatur" class="col-sm-3 col-form-label">Nama Donatur</label>
                            <div class="col-sm-12">
                                <input type="hidden" name="id_donasi" value="<?= $id_donasi ?>">
                                <input type="hidden" name="id_donatur" value="<?= $id_donatur ?>">
                                <input type="hidden" name="id_konfirmasidonasi" value="<?= $id_konfirmasidonasi ?>">
                                <input type="text" class="form-control" name="nama_donatur" value="<?= $nama_donatur ?>" placeholder="Nama Donatur" id="nama_donatur">
                                <div class="invalid-feedback errNama">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="id_kategoridonasi" class="col-sm-3 col-form-label">Jenis Donasi</label>
                            <div class="col-sm-12">
                                <!-- <input type="text" class="form-control" name="id_kategoridonasi" placeholder="Email" id="id_kategoridonasi"> -->
                                <select name="id_kategoridonasi" id="id_kategoridonasi" class="form-control custom-select" style="width: 100%;">
                                    <option value="">Pilih Jenis Donasi</option>
                                    <?php foreach ($donasi as $d) : ?>
                                        <option value="<?= $d['id_kategoridonasi'] ?>" <?= $d['id_kategoridonasi'] == $id_kategoridonasi ? 'selected' : ''; ?>><?= $d['nama_kategoridonasi'] ?></option>
                                    <?php endforeach; ?>
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
                            <label for="hp_donatur" class="col-sm-3 col-form-label">Handphone</label>
                            <div class="input-group col-sm-12">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">+62</span>
                                </div>
                                <input type="text" class="form-control" name="hp_donatur" value="<?= $hp_donatur ?>" placeholder="Nomor Handphone" id="hp_donatur">
                                <div class="invalid-feedback errHp">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="id_subkategoridonasi" class="col-sm-3 col-form-label">Keterangan Donasi</label>
                            <div class="col-sm-12">
                                <!-- <input type="text" class="form-control" name="id_subkategoridonasi" placeholder="Email" id="id_subkategoridonasi"> -->
                                <select name="id_subkategoridonasi" id="id_subkategoridonasi" class="form-control custom-select" style="width: 100%;">
                                    <option>Pilih Keterangan Donasi</option>
                                    <?php foreach ($subkategori as $sub) : ?>
                                        <option value="<?= $sub['id_subkategoridonasi']; ?>" <?= $sub['id_subkategoridonasi'] == $id_subkategoridonasi ? 'selected' : ''; ?>> <?= $sub['nama_subkategoridonasi']; ?></option>
                                    <?php endforeach; ?>
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
                            <label for="email_donatur" class="col-sm-3 col-form-label">Email</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" name="email_donatur" value="<?= $email_donatur ?>" placeholder="Email donatur" id="email_donatur">
                                <div class="invalid-feedback errEmail">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="tgl_donasi" class="col-sm-3 col-form-label">Tanggal Donasi</label>
                            <div class="input-group col-sm-12" id="reservationdate" data-target-input="nearest">
                                <input type="text" class="form-control date" name="tgl_donasi" value="<?= $tgl_donasi ?>" data-date-format="yyyy-mm-dd" data-date-end-date="0d" placeholder="Tanggal Donasi" id="tgl_donasi" data-target="#reservationdate">
                                <div class="input-group-append">
                                    <div class="input-group-text" data-target="#reservationdate" data-toggle="datetimepicker" id="basic-addon2">
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
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="alamat" class="col-sm-3 col-form-label">Alamat</label>
                            <div class="col-sm-12">
                                <textarea name="alamat_donatur" class="form-control" id="alamat_donatur" placeholder="Alamat Donatur" cols="30" rows="2"><?= $alamat_donatur ?></textarea>
                                <div class="invalid-feedback errAlamat"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="jumlah_donasi" class="col-sm-3 col-form-label">Jumlah</label>
                            <div class="input-group col-sm-12">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp</span>
                                </div>
                                <input type="text" class="form-control" name="jumlah_donasi" value="<?= $jumlah_donasi ?>" id="jumlah_donasi">
                                <div class="invalid-feedback errJml">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-times-circle"></i> &nbsp; Batal</button>
                <button type="submit" class="btn btn-success btnSave"><i class="fas fa-save"></i> &nbsp; Simpan</button>
            </div>
            <?= form_close() ?>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {

        $('.select2').select2({
            placeholder: 'Pilih Jenis Donasi',
            allowClear: true
        });

        $('.date').datepicker({
            todayBtn: "linked",
            language: "id",
            autoclose: true,
            todayHighlight: true,
            toggleActive: true
        });

        const Toast = Swal.mixin({
            toast: true,
            position: 'top',
            showConfirmButton: false,
            timer: 3000
        });


        $('#id_kategoridonasi').on('change', function() {
            let optionText = $(this).val();
            if (optionText == "") {
                $('#id_subkategoridonasi').html('<option>Pilih Keterangan Donasi</option>');
                $('#id_subkategoridonasi').attr('disabled', true);
            } else {
                console.log('a ' + optionText);
                $('#id_subkategoridonasi').attr('disabled', false);
                $('#id_subkategoridonasi').empty();
                let id_kategoridonasi = $(this).val();
                $.ajax({
                    type: "GET",
                    url: "/auth/donasi/ambilkategori",
                    dataType: "json",
                    data: {
                        id_kategoridonasi: id_kategoridonasi
                    },
                    success: function(response) {
                        console.log(response);
                        if (response != null) {
                            for (let i = 0; i < response.length; i++) {
                                $('#id_subkategoridonasi').append($('<option>', {
                                    value: response[i]["id_subkategoridonasi"],
                                    text: response[i]["nama_subkategoridonasi"]
                                }, '</option>'));
                            }
                        } else {
                            swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: response,
                            })
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                    }
                });
            }
        });

        $('.frmupdatedonasi').submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: "post",
                url: $(this).attr('action'),
                data: $(this).serialize(),
                dataType: "json",
                beforeSend: function() {
                    $('.btnSave').attr('disabled', true);
                    $('.btnSave').html('<i class="fas fa-spin fa-spinner"></i> &nbsp; Proses..');
                },
                complete: function() {
                    $('.btnSave').attr('disabled', false);
                    $('.btnSave').html('<i class="fas fa-save"></i> &nbsp; Simpan ');
                },
                success: function(response) {
                    Toast.fire({
                        icon: 'success',
                        title: response.sukses
                    })
                    $('#modal-edit').modal('hide');
                    data_donasi();
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
            return false;
        });
    });
</script>