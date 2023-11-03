<!-- Modal -->
<div class="modal fade" id="modal-edit" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary-gradient">
                <h5 class="modal-title text-white" id="staticBackdropLabel">Edit Subkategori</h5>
            </div>
            <?= form_open('/auth/subkategoridonasi/updateSubkategori', ['class' => 'frmupdatesubkategori']) ?>
            <div class="modal-body">
                <?= csrf_field() ?>
                <div class="form-group row">
                    <input type="hidden" name="id_subkategoridonasi" value="<?= $id_subkategoridonasi ?>">
                    <label for="id_kategoridonasi" class="col-sm-3 col-form-label">Kategori donasi</label>
                    <div class="col-sm-9">
                        <select name="id_kategoridonasi" id="id_kategoridonasi" class="form-control select2" style="width: 100%;">
                            <option></option>
                            <?php foreach ($kategoridonasi as $d) : ?>
                                <option value="<?= $d['id_kategoridonasi'] ?>" <?= $d['id_kategoridonasi'] == $id_kategoridonasi ? 'selected' : ''; ?>><?= $d['nama_kategoridonasi'] ?></option>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback errKat">
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="nama_subkategoridonasi" class="col-sm-3 col-form-label">Nama Subkategori</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="nama_subkategoridonasi" value="<?= $nama_subkategoridonasi ?>" placeholder="Nama Subkategori" id="nama_subkategoridonasi">
                        <div class="invalid-feedback errNama">
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
        const Toast = Swal.mixin({
            toast: true,
            position: 'top',
            showConfirmButton: false,
            timer: 3000
        });

        $('.select2').select2({
            placeholder: 'Pilih Kategori donasi',
            allowClear: true
        });

        $('.frmupdatesubkategori').submit(function(e) {
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
                    data_subkategoridonasi();
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
            return false;
        });

    });
</script>