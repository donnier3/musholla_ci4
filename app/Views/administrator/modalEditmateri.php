<!-- Modal -->
<div class="modal fade" id="modal-edit" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary-gradient">
                <h5 class="modal-title text-white" id="staticBackdropLabel">Edit Materi</h5>
            </div>
            <?= form_open_multipart('', ['class' => 'frmupdatemateri']) ?>
            <div class="modal-body">
                <?= csrf_field() ?>
                <div class="form-group row">
                    <input type="hidden" name="id_materi" value="<?= $id_materi ?>">
                    <input type="hidden" name="fileLama" value="<?= $file_materi ?>">
                    <input type="hidden" name="slug_materi" value="<?= $slug_materi ?>">
                    <label for="judul_materi" class="col-sm-3 col-form-label">Judul Materi</label>
                    <div class="col-sm-9">
                        <input type="text" name="judul_materi" id="judul_materi" value="<?= $judul_materi ?>" class="form-control" placeholder="Judul Materi">
                        <div class="invalid-feedback errJudul">
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="pemateri" class="col-sm-3 col-form-label">Pemateri</label>
                    <div class="input-group col-sm-9">
                        <input type="text" class="form-control" name="pemateri" value="<?= $pemateri ?>" placeholder="Pemateri" id="pemateri">
                        <div class="invalid-feedback errPengisi">
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="file_materi" class="col-sm-3 col-form-label">File Materi</label>
                    <div class="col-sm-9">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="file_materi" accept="application/pdf" name="file_materi" onchange="viewFile()">
                            <div class="invalid-feedback errFile">
                            </div>
                            <label class="custom-file-label" for="file_materi"><?= $file_materi ?></label>
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
    function viewFile() {
        const file_materiLabel = document.querySelector('.custom-file-label');
        file_materiLabel.textContent = file_materi.files[0].name;
    }

    $(document).ready(function() {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top',
            showConfirmButton: false,
            timer: 3000
        });

        // $('.frmtambahmateri').submit(function(e) {
        $('.btnSave').on('click', function(e) {
            e.preventDefault();
            let form = $('.frmupdatemateri')[0];
            let data = new FormData(form);
            $.ajax({
                type: "post",
                // url: $(this).attr('action'),
                // data: $(this).serialize(),
                url: '/auth/materi/updatemateri',
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
                    Toast.fire({
                        icon: 'success',
                        title: response.sukses
                    })
                    $('#modal-edit').modal('hide');
                    data_materi();
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
            return false;
        });

    });
</script>