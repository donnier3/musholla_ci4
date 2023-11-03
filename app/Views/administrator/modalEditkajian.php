<!-- Modal -->
<div class="modal fade" id="modal-edit" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary-gradient">
                <h5 class="modal-title text-white" id="staticBackdropLabel">Edit Kajian</h5>
            </div>
            <?= form_open_multipart('', ['class' => 'frmeditkajian']) ?>
            <div class="modal-body">
                <?= csrf_field() ?>
                <div class="form-row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="hidden" name="id_kajian" value="<?= $id_kajian ?>">
                            <input type="hidden" name="imgLama" value="<?= $img_kajian ?>">
                            <label for="tema_kajian" class="col-sm-3 col-form-label">Tema Kajian</label>
                            <div class="col-sm-12">
                                <input type="text" name="tema_kajian" id="tema_kajian" value="<?= $tema_kajian ?>" class="form-control" placeholder="Tema Kajian">
                                <div class="invalid-feedback errNama">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="tgl_kajian" class="col-sm-3 col-form-label">Tanggal Kajian</label>
                            <div class="input-group col-sm-12" id="reservationdate" data-target-input="nearest">
                                <input type="text" class="form-control date" name="tgl_kajian" value="<?= $tgl_kajian ?>" data-date-format="yyyy-mm-dd" data-date-start-date="0d" placeholder="Tanggal Kajian" id="tgl_kajian" data-target="#reservationdate">
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
                            <label for="pengisi_kajian" class="col-sm-3 col-form-label">Pengisi Kajian</label>
                            <div class="input-group col-sm-12">
                                <input type="text" class="form-control" name="pengisi_kajian" value="<?= $pengisi_kajian ?>" placeholder="Pengisi Kajian" id="pengisi_kajian">
                                <div class="invalid-feedback errPengisi">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="form-row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="img_kajian" class="col-sm-3 col-form-label">Gambar</label>
                            <div class="col-sm-12">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="img_kajian" name="img_kajian" onchange="previewPic()">
                                    <div class="invalid-feedback errFile">
                                    </div>
                                    <label class="custom-file-label pic" for="img_kajian"><?= $img_kajian ?></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6" style="margin-top: -109px;">
                        <div class="form-group">
                            <label for="" class="col-sm-3 col-form-label">Preview Gambar</label>
                            <div class="col-sm-12">
                                <img src="/img/kajian/<?= $img_kajian ?>" style="max-width: 300px; max-height:300px;" class="rounded img-thumbnail img-preview">
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
        const img_kajian = document.querySelector('#img_kajian');
        const img_kajianLabel = document.querySelector('.pic');
        const imgPreview = document.querySelector('.img-preview');

        img_kajianLabel.textContent = img_kajian.files[0].name;

        const fileimg_kajian = new FileReader();
        fileimg_kajian.readAsDataURL(img_kajian.files[0]);

        fileimg_kajian.onload = function(e) {
            imgPreview.src = e.target.result;
            console.log(img_kajian);
        }
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

        $('.btnSave').on('click', function(e) {
            e.preventDefault();
            let form = $('.frmeditkajian')[0];
            let data = new FormData(form);
            $.ajax({
                type: "post",
                url: '/auth/kajian/updatekajian',
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
                    data_kajian();
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
            return false;
        });
    });
</script>