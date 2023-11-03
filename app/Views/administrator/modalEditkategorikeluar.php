<!-- Modal -->
<div class="modal fade" id="modal-edit" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary-gradient">
                <h5 class="modal-title text-white" id="staticBackdropLabel">Edit Kategori</h5>
            </div>
            <?= form_open('/auth/kategorikeluar/updateKategori', ['class' => 'frmupdatekategori']) ?>
            <div class="modal-body">
                <?= csrf_field() ?>
                <div class="form-group row">
                    <label for="nama_kategorikeluar" class="col-sm-3 col-form-label">Nama Kategori</label>
                    <div class="col-sm-9">
                        <input type="hidden" name="id_kategorikeluar" value="<?= $id_kategorikeluar ?>">
                        <input type="hidden" name="slug_kategorikeluar" value="<?= $slug_kategorikeluar ?>">
                        <input type="text" class="form-control" value="<?= $nama_kategorikeluar ?>" name="nama_kategorikeluar" placeholder="Nama Kategori" id="nama_kategorikeluar" autofocus>
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

        $('.frmupdatekategori').submit(function(e) {
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
                    data_kategorikeluar();
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
            return false;
        });
    });
</script>