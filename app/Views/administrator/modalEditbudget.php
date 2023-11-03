<!-- Modal -->
<div class="modal fade" id="modal-edit" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary-gradient">
                <h5 class="modal-title text-white" id="staticBackdropLabel">Edit Budget</h5>
            </div>
            <?= form_open_multipart('', ['class' => 'frmupdatebudget']) ?>
            <div class="modal-body">
                <?= csrf_field() ?>
                <div class="form-group row">
                    <input type="hidden" name="id_budget" value="<?= $id_budget ?>">
                    <input type="hidden" name="fileLama" value="<?= $proposal ?>">
                    <input type="hidden" name="imgLama" value="<?= $img_budget ?>">
                    <label for="id_subkategoridonasi" class="col-sm-3 col-form-label">Budget</label>
                    <div class="col-sm-9">
                        <select name="id_subkategoridonasi" id="id_subkategoridonasi" class="form-control custom-select" style="width: 100%;">
                            <option value="">Pilih Nama Program</option>
                            <?php foreach ($sub as $s) : ?>
                                <option value="<?= $s['id_subkategoridonasi'] ?>" <?= $s['id_subkategoridonasi'] == $id_subkategoridonasi ? 'selected' : ''; ?>><?= $s['nama_subkategoridonasi'] ?></option>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback errNama">
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="jumlah_budget" class="col-sm-3 col-form-label">Jumlah Budget</label>
                    <div class="col-sm-9 input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Rp</span>
                        </div>
                        <input type="text" class="form-control" name="jumlah_budget" value="<?= $jumlah_budget ?>" placeholder="Jumlah Budget" id="jumlah_budget">
                        <div class="invalid-feedback errJml">
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="tgl_target" class="col-sm-3 col-form-label">Target</label>
                    <div class="input-group col-sm-9" id="reservationdate" data-target-input="nearest">
                        <input type="text" class="form-control date" name="tgl_target" value="<?= $tgl_target ?>" data-date-format="yyyy-mm-dd" data-date-start-date="0d" placeholder="Target" id="tgl_target" data-target="#reservationdate">
                        <div class="input-group-append">
                            <div class="input-group-text" data-target="#reservationdate" data-toggle="datetimepicker" id="basic-addon2">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                        </div>
                        <div class="invalid-feedback errTgl">
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="proposal" class="col-sm-3 col-form-label">Proposal</label>
                    <div class="col-sm-9">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" accept="application/pdf" id="proposal" name="proposal" onchange="viewFile()">
                            <div class="invalid-feedback errFile">
                            </div>
                            <label class="custom-file-label prop" for="proposal"><?= $proposal ?></label>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="img_budget" class="col-sm-3 col-form-label">Gambar</label>
                    <div class="col-sm-9">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="img_budget" name="img_budget" onchange="previewImg()">
                            <div class="invalid-feedback errImg">
                            </div>
                            <label class="custom-file-label img" for="img_budget"><?= $img_budget ?></label>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="preview" class="col-sm-3 col-form-label">Preview Gambar</label>
                    <div class="col-sm-9">
                        <img src="/img/budget/<?= $img_budget ?>" class="rounded img-thumbnail img-preview">
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
    function previewImg() {
        const img_budget = document.querySelector('#img_budget');
        const img_budgetLabel = document.querySelector('.img');
        const imgPreview = document.querySelector('.img-preview');

        img_budgetLabel.textContent = img_budget.files[0].name;

        const fileimg_budget = new FileReader();
        fileimg_budget.readAsDataURL(img_budget.files[0]);

        fileimg_budget.onload = function(e) {
            imgPreview.src = e.target.result;
            console.log(img_budget);
        }
    }

    function viewFile() {
        const proposalLabel = document.querySelector('.prop');
        proposalLabel.textContent = proposal.files[0].name;
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

        $('.frmupdatebudget').submit(function(e) {
            e.preventDefault();
            let form = $('.frmtambahbudget')[0];
            let data = new FormData(form);
            $.ajax({
                type: "post",
                url: '/auth/budget/updatebudget',
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
                    Toast.fire({
                        icon: 'success',
                        title: response.sukses
                    })
                    $('#modal-edit').modal('hide');
                    data_budget();

                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
            return false;
        });
    });
</script>