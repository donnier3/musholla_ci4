<!-- Modal -->
<div class="modal fade" id="modal-tambah" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary-gradient">
                <h5 class="modal-title text-white" id="staticBackdropLabel">Tambah Kategori</h5>
            </div>
            <?= form_open('/auth/kategoridonasi/tambahKategori', ['class' => 'frmtambahkategori']) ?>
            <div class="modal-body">
                <?= csrf_field() ?>
                <div class="form-group row">
                    <label for="nama_kategoridonasi" class="col-sm-3 col-form-label">Nama Kategori</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="nama_kategoridonasi" placeholder="Nama Kategori" id="nama_kategoridonasi">
                        <div class="invalid-feedback errNama">
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="jenis_kategoridonasi" class="col-sm-3 col-form-label">Jenis Kategori</label>
                    <div class="col-sm-9 form-check mt-2">
                        <label class="form-radio-label">
                            <input type="radio" class="form-radio-input jenis_kategoridonasi" value="0" name="jenis_kategoridonasi">
                            <span class="form-radio-sign">Offline</span>
                        </label>
                        <label class="form-radio-label">
                            <input type="radio" class="form-radio-input jenis_kategoridonasi" value="1" name="jenis_kategoridonasi">
                            <span class="form-radio-sign">Online</span>
                        </label>
                    </div>
                    <div class="invalid-feedback errJenis"></div>
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

        $('.frmtambahkategori').submit(function(e) {
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
                    if (response.error) {
                        if (response.error.nama_kategoridonasi) {
                            $('#nama_kategoridonasi').addClass('is-invalid');
                            $('.errNama').html(response.error.nama_kategoridonasi);
                        } else {
                            $('#nama_kategoridonasi').removeClass('is-invalid');
                            $('#nama_kategoridonasi').addClass('is-valid');
                            $('.errNama').html(response.error.nama_kategoridonasi);
                        }
                        if (response.error.jenis_kategoridonasi) {
                            $('.jenis_kategoridonasi').addClass('is-invalid');
                            $('.errJenis').html(response.error.jenis_kategoridonasi);
                        } else {
                            $('.jenis_kategoridonasi').removeClass('is-invalid');
                            $('.errJenis').html(response.error.jenis_kategoridonasi);
                        }
                    } else {
                        Toast.fire({
                            icon: 'success',
                            title: response.sukses
                        })
                        $('#modal-tambah').modal('hide');
                        data_kategoridonasi();
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