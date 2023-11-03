<!-- Modal -->
<div class="modal fade" id="modal-edit" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary-gradient">
                <h5 class="modal-title text-white" id="staticBackdropLabel">Edit Pengeluaran</h5>
            </div>
            <?= form_open_multipart('', ['class' => 'frmupdatekeluar']) ?>
            <div class="modal-body">
                <?= csrf_field() ?>
                <div class="form-row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="id_kategorikeluar" class="col-sm-3 col-form-label">Jenis Pengeluaran</label>
                            <div class="col-sm-12">
                                <input type="hidden" name="id_pengeluaran" value="<?= $id_pengeluaran ?>">
                                <input type="hidden" name="buktiLama" value="<?= $bukti_keluar ?>">
                                <select name="id_kategorikeluar" id="id_kategorikeluar" class="form-control custom-select" style="width: 100%;">
                                    <?php foreach ($kategori as $k) : ?>
                                        <option value="<?= $k['id_kategorikeluar'] ?>" <?= $k['id_kategorikeluar'] == $id_kategorikeluar ? 'selected' : ''; ?>><?= $k['nama_kategorikeluar'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="id_subkategorikeluar" class="col-sm-3 col-form-label">Nama Pengeluaran</label>
                            <div class="col-sm-12">
                                <select name="id_subkategorikeluar" id="id_subkategorikeluar" class="form-control custom-select" style="width: 100%;">
                                    <?php foreach ($subkategori as $sub) : ?>
                                        <option value="<?= $sub['id_subkategorikeluar']; ?>" <?= $sub['id_subkategorikeluar'] == $id_subkategorikeluar ? 'selected' : ''; ?>> <?= $sub['nama_subkategorikeluar']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="jumlah_keluar" class="col-sm-3 col-form-label">Jumlah Pengeluaran</label>
                            <div class="input-group col-sm-12">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp</span>
                                </div>
                                <input type="text" class="form-control" value="<?= $jumlah_keluar ?>" name="jumlah_keluar" placeholder="Jumlah pengeluaran" id="jumlah_keluar">
                                <div class="invalid-feedback errJml">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="tgl_keluar" class="col-sm-3 col-form-label">Tanggal Pengeluaran</label>
                            <div class="input-group col-sm-12" id="reservationdate" data-target-input="nearest">
                                <input type="text" class="form-control date" value="<?= $tgl_keluar ?>" name="tgl_keluar" data-date-format="yyyy-mm-dd" data-date-end-date="0d" placeholder="Tanggal pengeluaran" id="tgl_keluar" data-target="#reservationdate">
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
                            <label for="bukti_keluar" class="col-sm-3 col-form-label">Bukti Pengeluaran</label>
                            <div class="col-sm-12">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="bukti_keluar" name="bukti_keluar" onchange="previewPic()">
                                    <div class="invalid-feedback errFile">
                                    </div>
                                    <label class="custom-file-label pic" for="bukti_keluar"><?= $bukti_keluar ?></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="col-sm-12">
                                <img src="/img/buktipengeluaran/<?= $bukti_keluar ?>" style="max-width: 300px; max-height:300px;" class="rounded img-thumbnail bukti-preview">
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
    function previewPic() {
        const bukti_keluar = document.querySelector('#bukti_keluar');
        const bukti_keluarLabel = document.querySelector('.pic');
        const imgPreview = document.querySelector('.bukti-preview');

        bukti_keluarLabel.textContent = bukti_keluar.files[0].name;

        const filebukti_keluar = new FileReader();
        filebukti_keluar.readAsDataURL(bukti_keluar.files[0]);

        filebukti_keluar.onload = function(e) {
            imgPreview.src = e.target.result;
            console.log(bukti_keluar);
        }
    }

    function getsub() {
        let id_kategorikeluar = $('#id_subkategorikeluar').val();
        $('#id_subkategorikeluar').empty();
        $.ajax({
            type: "GET",
            url: "/auth/pengeluaran/ambilkategori",
            dataType: "json",
            data: {
                id_kategorikeluar: id_kategorikeluar
            },
            success: function(response) {
                console.log(response);
                if (response != null) {
                    for (let i = 0; i < response.length; i++) {
                        $('#id_subkategorikeluar').append($('<option>', {
                            value: response[i]["id_subkategorikeluar"],
                            text: response[i]["nama_subkategorikeluar"]
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

    $(document).ready(function() {
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

        getsub();

        $('#id_kategorikeluar').on('change', function() {
            let optionText = $(this).val();
            if (optionText == "") {
                $('#id_subkategorikeluar').html('<option>Pilih Keterangan keluar</option>');
                $('#id_subkategorikeluar').attr('disabled', true);
            } else {
                console.log('a ' + optionText);
                $('#id_subkategorikeluar').attr('disabled', false);
                $('#id_subkategorikeluar').empty();
                let id_kategorikeluar = $(this).val();
                $.ajax({
                    type: "GET",
                    url: "/auth/pengeluaran/ambilkategori",
                    dataType: "json",
                    data: {
                        id_kategorikeluar: id_kategorikeluar
                    },
                    success: function(response) {
                        console.log(response);
                        if (response != null) {
                            for (let i = 0; i < response.length; i++) {
                                $('#id_subkategorikeluar').append($('<option>', {
                                    value: response[i]["id_subkategorikeluar"],
                                    text: response[i]["nama_subkategorikeluar"]
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

        // $('.frmupdatekeluar').submit(function(e) {
        $('.btnSave').on('click', function(e) {
            e.preventDefault();
            let form = $('.frmupdatekeluar')[0];
            let data = new FormData(form);
            $.ajax({
                type: "post",
                url: '/auth/pengeluaran/updatekeluar',
                data: data,
                enctype: 'multipart/form-data',
                processData: false,
                contentType: false,
                cache: false,
                // url: $(this).attr('action'),
                // data: $(this).serialize(),
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
                    if (response.error) {
                        if (response.error.jumlah_keluar) {
                            $('#jumlah_keluar').addClass('is-invalid');
                            $('.errJml').html(response.error.jumlah_keluar);
                        } else {
                            $('#jumlah_keluar').removeClass('is-invalid');
                            $('#jumlah_keluar').addClass('is-valid');
                            $('.errJml').html(response.error.jumlah_keluar);
                        }
                        if (response.error.tgl_keluar) {
                            $('#tgl_keluar').addClass('is-invalid');
                            $('.errTgl').html(response.error.tgl_keluar);
                        } else {
                            $('#tgl_keluar').removeClass('is-invalid');
                            $('#tgl_keluar').addClass('is-valid');
                            $('.errTgl').html(response.error.tgl_keluar);
                        }
                        if (response.error.bukti_keluar) {
                            $('#bukti_keluar').addClass('is-invalid');
                            $('.errFile').html(response.error.bukti_keluar);
                        } else {
                            $('#bukti_keluar').removeClass('is-invalid');
                            $('#bukti_keluar').addClass('is-valid');
                            $('.errFile').html(response.error.bukti_keluar);
                        }
                    } else {
                        Toast.fire({
                            icon: 'success',
                            title: response.sukses
                        })
                        $('#modal-edit').modal('hide');
                        data_pengeluaran();
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
            return false;
        });
    });
</script>