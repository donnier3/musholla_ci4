<!-- Modal -->
<div class="modal fade" id="modal-tambah" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary-gradient">
                <h5 class="modal-title text-white" id="staticBackdropLabel">Tambah Subkategori</h5>
            </div>
            <?= form_open('/auth/subkategorikeluar/tambahSubkategori', ['class' => 'frmtambahsubkategori']) ?>
            <div class="modal-body">
                <?= csrf_field() ?>
                <div class="form-group row">
                    <label for="id_kategorikeluar" class="col-sm-3 col-form-label">Kategori keluar</label>
                    <div class="col-sm-9">
                        <select name="id_kategorikeluar" id="id_kategorikeluar" class="form-control select2" style="width: 100%;">
                            <option></option>
                            <?php foreach ($kategorikeluar as $d) : ?>
                                <option value="<?= $d['id_kategorikeluar'] ?>"><?= $d['nama_kategorikeluar'] ?></option>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback errKat">
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="nama_subkategorikeluar" class="col-sm-3 col-form-label">Nama Subkategori</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="nama_subkategorikeluar" placeholder="Nama Subkategori" id="nama_subkategorikeluar">
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
            placeholder: 'Pilih Kategori keluar',
            allowClear: true
        });

        $('.frmtambahsubkategori').submit(function(e) {
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
                        if (response.error.nama_subkategorikeluar) {
                            $('#nama_subkategorikeluar').addClass('is-invalid');
                            $('.errNama').html(response.error.nama_subkategorikeluar);
                        } else {
                            $('#nama_subkategorikeluar').removeClass('is-invalid');
                            $('#nama_subkategorikeluar').addClass('is-valid');
                            $('.errNama').html(response.error.nama_subkategorikeluar);
                        }
                        if (response.error.id_kategorikeluar) {
                            $('#id_kategorikeluar').addClass('is-invalid');
                            $('.errKat').html(response.error.id_kategorikeluar);
                        } else {
                            $('#id_kategorikeluar').removeClass('is-invalid');
                            $('#id_kategorikeluar').addClass('is-valid');
                            $('.errKat').html(response.error.id_kategorikeluar);
                        }
                    } else {
                        Toast.fire({
                            icon: 'success',
                            title: response.sukses
                        })
                        $('#modal-tambah').modal('hide');
                        data_subkategorikeluar();
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