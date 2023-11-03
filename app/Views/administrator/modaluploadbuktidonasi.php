<!-- Modal -->
<div class="modal fade" id="modal-upload" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary-gradient">
                <h5 class="modal-title text-white" id="staticBackdropLabel">Upload Bukti Donasi</h5>
            </div>
            <?= form_open_multipart('', ['class' => 'frmuploaddonasi']) ?>
            <div class="modal-body">
                <?= csrf_field() ?>
                <div class="form-group row">
                    <input type="hidden" name="id_konfirmasidonasi" value="<?= $id_konfirmasidonasi ?>">
                    <label for="bukti_donasi" class="col-sm-3 col-form-label">Upload File</label>
                    <div class="col-sm-12">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="bukti_donasi" name="bukti_donasi">
                            <div class="invalid-feedback errFile">
                            </div>
                            <label class="custom-file-label" for="bukti_donasi">Choose File..</label>
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
        $(".custom-file-input").on("change", function() {
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });

        const Toast = Swal.mixin({
            toast: true,
            position: 'top',
            showConfirmButton: false,
            timer: 3000
        });

        $('.btnSave').on('click', function(e) {
            e.preventDefault();
            let form = $('.frmuploaddonasi')[0];
            let data = new FormData(form);
            $.ajax({
                type: "post",
                url: '/auth/donasi/uploaddonasi',
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
                        if (response.error.bukti_donasi) {
                            $('#bukti_donasi').addClass('is-invalid');
                            $('.errFile').html(response.error.bukti_donasi);
                        } else {
                            $('#bukti_donasi').removeClass('is-invalid');
                            $('#bukti_donasi').addClass('is-valid');
                            $('.errFile').html(response.error.bukti_donasi);
                        }
                    } else {
                        Toast.fire({
                            icon: 'success',
                            title: response.sukses
                        })
                        $('#modal-upload').modal('hide');
                        data_donasi();
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