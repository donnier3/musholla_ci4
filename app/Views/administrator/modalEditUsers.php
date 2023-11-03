<!-- Modal -->
<div class="modal fade" id="modal-edit" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title" id="staticBackdropLabel">Edit Users</h5>
            </div>
            <?= form_open('/auth/user/updateUsers', ['class' => 'frmupdateuser']) ?>
            <div class="modal-body">
                <?= csrf_field() ?>
                <div class="form-group row">
                    <label for="nama_user" class="col-sm-2 col-form-label">Nama User</label>
                    <div class="col-sm-10">
                        <input type="hidden" value="<?= $id_user ?>" name="id_user">
                        <input type="text" class="form-control" readonly name="nama_user" value="<?= $nama_user ?>" placeholder="Nama User" id="nama_user">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="username" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" readonly name="username" value="<?= $username ?>" placeholder="Nama User" id="username">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="level_user" class="col-sm-2 col-form-label">Level</label>
                    <div class="col-sm-10">
                        <select class="custom-select form-control" name="level_user" id="level_user">
                            <option selected disabled value="">Select Level</option>
                            <option value="administrator" <?= ($level_user == 'administrator') ? 'selected' : '' ?>>Administrator</option>
                            <option value="admin" <?= ($level_user == 'admin') ? 'selected' : '' ?>>Admin</option>
                            <option value="user" <?= ($level_user == 'user') ? 'selected' : '' ?>>User</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="status_user" class="col-sm-2 col-form-label">Status</label>
                    <div class="col-sm-10">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" value="<?= $status_user ?>" id="status_user">
                            <input type="hidden" name="status_user" id="sts">
                            <label class="custom-control-label" for="status_user" id="lblStatus"></label>
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

        $('#lblStatus').text('Inactive');

        let val = $('#status_user').val();
        $('#status_user').on('click', function() {
            if ($(this).is(':checked')) {
                $('.selectallid').prop('checked', true);
                $('#lblStatus').text('Active');
                $('#sts').val(1)
            } else {
                $('.selectallid').prop('checked', false);
                $('#lblStatus').text('Inactive');
                $('#sts').val(0)
            }
        });

        if (val == 1) {
            $('#status_user').prop('checked', true);
            $('#lblStatus').text('Active');
        } else {
            $('#status_user').prop('checked', false);
            $('#lblStatus').text('Inactive');
        }

        $('.frmupdateuser').submit(function(e) {
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
                    data_user();
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
            return false;
        });
    });
</script>