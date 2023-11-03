<!-- Modal -->
<div class="modal fade" id="modal-tambah" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary-gradient">
                <h5 class="modal-title text-white" id="staticBackdropLabel">Tambah Users</h5>
            </div>
            <?= form_open('/auth/user/tambahUsers', ['class' => 'frmtambahuser']) ?>
            <div class="modal-body">
                <?= csrf_field() ?>
                <div class="form-group row">
                    <label for="nama_user" class="col-sm-2 col-form-label">Nama</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="nama_user" placeholder="Nama" id="nama_user">
                        <div class="invalid-feedback errNama">
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="username" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="username" placeholder="Email" id="username">
                        <div class="invalid-feedback errEmail">
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="password" class="col-sm-2 col-form-label">Password</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" name="password" placeholder="Passowrd" id="password">
                        <div class="invalid-feedback errPass">
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="level_user" class="col-sm-2 col-form-label">Level</label>
                    <div class="col-sm-10">
                        <select class="custom-select form-control" name="level_user" id="level_user">
                            <option selected disabled value="">Select Level</option>
                            <option value="administrator">Administrator</option>
                            <option value="admin">Admin</option>
                            <option value="user">User</option>
                        </select>
                        <div class="invalid-feedback errLvl">
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

        $('.frmtambahuser').submit(function(e) {
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
                        if (response.error.nama_user) {
                            $('#nama_user').addClass('is-invalid');
                            $('.errNama').html(response.error.nama_user);
                        } else {
                            $('#nama_user').removeClass('is-invalid');
                            $('#nama_user').addClass('is-valid');
                            $('.errNama').html(response.error.nama_user);
                        }
                        if (response.error.username) {
                            $('#username').addClass('is-invalid');
                            $('.errEmail').html(response.error.username);
                        } else {
                            $('#username').removeClass('is-invalid');
                            $('#username').addClass('is-valid');
                            $('.errEmail').html(response.error.username);
                        }
                        if (response.error.password) {
                            $('#password').addClass('is-invalid');
                            $('.errPass').html(response.error.password);
                        } else {
                            $('#password').removeClass('is-invalid');
                            $('#password').addClass('is-valid');
                            $('.errPass').html(response.error.password);
                        }
                        if (response.error.level_user) {
                            $('#level_user').addClass('is-invalid');
                            $('.errLvl').html(response.error.level_user);
                        } else {
                            $('#level_user').removeClass('is-invalid');
                            $('#level_user').addClass('is-valid');
                            $('.errLvl').html(response.error.level_user);
                        }
                    } else {
                        Toast.fire({
                            icon: 'success',
                            title: response.sukses
                        })
                        $('#modal-tambah').modal('hide');
                        data_user();
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