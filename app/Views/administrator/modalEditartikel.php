<style>
    .ck-editor__editable_inline {
        min-height: 500px !important;
    }
</style>
<!-- Modal -->
<div class="modal fade" id="modal-edit" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary-gradient">
                <h5 class="modal-title text-white" id="staticBackdropLabel">Edit Artikel</h5>
            </div>
            <?= form_open_multipart('', ['class' => 'frmeditartikel']) ?>
            <div class="modal-body">
                <?= csrf_field() ?>
                <div class="form-row">
                    <div class="col-4">
                        <input type="hidden" name="id_artikel" value="<?= $id_artikel ?>">
                        <input type="hidden" name="imgLama" value="<?= $img_artikel ?>">
                        <label for="penulis" class="col-sm-3 col-form-label">Penulis</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" value="<?= $penulis ?>" name="penulis" placeholder="Nama Penulis" id="penulis">
                            <div class="invalid-feedback errNama">
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <label for="id_kategoriartikel" class="col-sm-3 col-form-label">Kategori</label>
                        <div class="col-sm-12">
                            <!-- <input type="text" class="form-control" name="id_kategoriartikel" placeholder="Email" id="id_kategoriartikel"> -->
                            <select name="id_kategoriartikel" id="id_kategoriartikel" class="form-control select2" style="width: 100%;">
                                <option></option>
                                <?php foreach ($kategoriartikel as $d) : ?>
                                    <option value="<?= $d['id_kategoriartikel'] ?>" <?= $d['id_kategoriartikel'] == $id_kategoriartikel ? 'selected' : ''; ?>><?= $d['nama_kategoriartikel'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback errJenis">
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="col-12">
                            <label for="judul_artikel" class="col-sm-3 col-form-label">Judul</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" value="<?= $judul_artikel ?>" name="judul_artikel" placeholder="Judul Artikel" id="judul_artikel">
                                <div class="invalid-feedback errJudul">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <label for="isi_artikel" class="col-sm-3 col-form-label">Isi Artikel</label>
                    <div class="col-sm-12">
                        <textarea name="isi_artikel" class="form-control" id="isi_artikel"><?= $isi_artikel ?></textarea>
                        <div class="invalid-feedback errIsi">
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-6">
                        <label for="img_artikel" class="col-sm-3 col-form-label">Gambar Artikel</label>
                        <div class="col-sm-12">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="img_artikel" name="img_artikel">
                                <div class="invalid-feedback errFile">
                                </div>
                                <label class="custom-file-label" for="img_artikel"><?= $img_artikel ?></label>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <label for="status_artikel" class="col-sm-3 col-form-label">Status Artikel</label>
                        <div class="col-sm-12 form-check">
                            <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" value="<?= $status_artikel ?>" id="status_artikel">
                                <span class="form-check-sign" id="lbl">Setuju untuk di publish</span>
                                <input type="hidden" name="status_artikel" id="sts">
                            </label>
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
    ClassicEditor
        .create(document.querySelector('#isi_artikel'), {
            ckfinder: {
                uploadUrl: "/auth/artikel/uploadImg",
            },
        })
        .then(editor => {
            console.log(editor);
        })
        .catch(error => {
            console.error(error);
        });


    $(document).ready(function() {
        $('.select2').select2({
            placeholder: 'Pilih Kategori Artikel',
            allowClear: true
        });


        let val = $('#status_artikel').val();
        if (val == 1) {
            $('#status_artikel').prop('checked', true);
        } else {
            $('#status_artikel').prop('checked', false);
        }

        $('#status_artikel').on('change', function() {
            this.value = this.checked ? 1 : 0;
            $('#sts').val(this.value);
            console.log(this.value);
        }).change();

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

        $('.frmeditartikel').submit(function(e) {
            e.preventDefault();
            let form = $('.frmeditartikel')[0];
            let data = new FormData(form);
            $.ajax({
                type: "post",
                url: '/auth/artikel/updateartikel',
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
                    $('.btnSave').html('<i class="fas fa-save"></i> &nbsp; Simpan ');
                },
                success: function(response) {
                    if (response.error) {
                        if (response.error.img_artikel) {
                            $('#img_artikel').addClass('is-invalid');
                            $('.errFile').html(response.error.img_artikel);
                        } else {
                            $('#img_artikel').removeClass('is-invalid');
                            $('#img_artikel').addClass('is-valid');
                            $('.errFile').html(response.error.img_artikel);
                        }
                        if (response.error.penulis) {
                            $('#penulis').addClass('is-invalid');
                            $('.errNama').html(response.error.penulis);
                        } else {
                            $('#penulis').removeClass('is-invalid');
                            $('#penulis').addClass('is-valid');
                            $('.errNama').html(response.error.penulis);
                        }
                        if (response.error.judul_artikel) {
                            $('#judul_artikel').addClass('is-invalid');
                            $('.errJudul').html(response.error.judul_artikel);
                        } else {
                            $('#judul_artikel').removeClass('is-invalid');
                            $('#judul_artikel').addClass('is-valid');
                            $('.errJudul').html(response.error.judul_artikel);
                        }
                        if (response.error.id_kategoriartikel) {
                            $('#id_kategoriartikel').addClass('is-invalid');
                            $('.errJenis').html(response.error.id_kategoriartikel);
                        } else {
                            $('#id_kategoriartikel').removeClass('is-invalid');
                            $('#id_kategoriartikel').addClass('is-valid');
                            $('.errJenis').html(response.error.id_kategoriartikel);
                        }
                        if (response.error.isi_artikel) {
                            $('#isi_artikel').addClass('is-invalid');
                            $('.errIsi').html(response.error.isi_artikel);
                        } else {
                            $('#isi_artikel').removeClass('is-invalid');
                            $('#isi_artikel').addClass('is-valid');
                            $('.errIsi').html(response.error.isi_artikel);
                        }
                    } else {
                        Toast.fire({
                            icon: 'success',
                            title: response.sukses
                        })
                        $('#modal-edit').modal('hide');
                        data_artikel();
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