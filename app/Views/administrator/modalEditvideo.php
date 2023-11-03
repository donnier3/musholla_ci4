<!-- Modal -->
<div class="modal fade" id="modal-edit" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary-gradient">
                <h5 class="modal-title text-white" id="staticBackdropLabel">Edit Video</h5>
            </div>
            <?= form_open('/auth/video/updatevideo', ['class' => 'frmupdatevideo']) ?>
            <div class="modal-body">
                <?= csrf_field() ?>
                <div class="form-group row">
                    <input type="hidden" name="id_video" value="<?= $id_video ?>">
                    <label for="id_kategoriartikel" class="col-sm-3 col-form-label">Kategori Video</label>
                    <div class="col-sm-9">
                        <select name="id_kategoriartikel" id="id_kategoriartikel" class="form-control custom-select" style="width: 100%;">
                            <option value="">Pilih Kategori</option>
                            <?php foreach ($kategori as $d) : ?>
                                <option value="<?= $d['id_kategoriartikel'] ?>" <?= $d['id_kategoriartikel'] == $id_kategoriartikel ? 'selected' : '' ?>><?= $d['nama_kategoriartikel'] ?></option>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback errId">
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="judul_video" class="col-sm-3 col-form-label">Judul Video</label>
                    <div class="col-sm-9">
                        <input type="text" name="judul_video" id="judul_video" value="<?= $judul_video ?>" class="form-control" placeholder="Judul Video">
                        <div class="invalid-feedback errJudul">
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="link_video" class="col-sm-3 col-form-label">Link Video</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="link_video" value="<?= $link_video ?>" placeholder="Link Video" id="link_video">
                        <div class="invalid-feedback errLink">
                        </div>
                        <small class="text-xs-left kecil">
                            <span>Contoh : www.youtube.com/watch?v=</span><strong class="text-danger">jVr6CYLhjQo</strong>
                        </small>
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

        $('.frmupdatevideo').submit(function(e) {
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
                    data_video();
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
            return false;
        });
    });
</script>