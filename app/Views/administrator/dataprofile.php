<div class="row">
    <div class="col-md-12">
        <div class="card shadow-lg p-3 mb-5 bg-white rounded">
            <div class="card-header">
                <div class="d-flex align-items-center">
                    <h4 class="card-title">Profile User</h4>
                </div>
            </div>
            <?= form_open_multipart('', ['class' => 'formprofile']) ?>
            <?= csrf_field() ?>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6 col-lg-12">
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label for="pemkab">Nama</label>
                                <input type="hidden" name="id_user" value="<?= $profile[0]['id_user'] ?>">
                                <input type="text" class="form-control" id="nama" name="nama_user" value="<?= $profile[0]['nama_user'] ?>" placeholder="Nama">
                                <div class="invalid-feedback errNama">
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="">Password <i class="fas fa-info-circle" style="color: #007bff;" data-toggle="tooltip" data-placement="right" title="Jika di isi, password akan berubah" style="cursor: pointer;"></i></label>
                                <input type="hidden" name="password_lama" value="<?= $profile[0]['password'] ?>">
                                <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                                <div class="invalid-feedback errEmail">
                                </div>
                                </div1>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="picture">Picture</label>
                                <div class="custom-file">
                                    <input type="hidden" name="picture_lama" value="<?= $profile[0]['picture'] ?>">
                                    <input type="file" class="custom-file-input" id="picture" name="picture" onchange="previewPic()">
                                    <div class="invalid-feedback errPic">
                                    </div>
                                    <label class="custom-file-label pic" for="picture"><?= $profile[0]['picture'] ?></label>
                                </div>
                            </div>
                            <div class="form-group col-md-11 mt-4 d-flex flex-row-reverse">
                                <img src="/img/profile/<?= $profile[0]['picture'] ?>" width="300" height="300" class="rounded img-thumbnail pic-preview" alt="">
                            </div>
                        </div>
                        <div style="margin-top: -70px;">
                            <button type="button" class="btn btn-danger ml-3 mt-5 btnCancel"><i class="fas fa-arrow-left"></i>&nbsp; Cancel</button>
                            <button type="submit" class="btn btn-primary ml-3 mt-5 btnSave"><i class="fas fa-save"></i>&nbsp; Save</button>
                        </div>
                    </div>
                </div>
            </div>
            <?= form_close() ?>
        </div>
    </div>
</div>

<script>
    $(function() {
        $('[data-toggle="tooltip"]').tooltip()
        // $('[data-toggle="popover"]').popover();
    })

    function previewPic() {
        const picture = document.querySelector('#picture');
        const pictureLabel = document.querySelector('.pic');
        const imgPreview = document.querySelector('.pic-preview');

        pictureLabel.textContent = picture.files[0].name;

        const filepicture = new FileReader();
        filepicture.readAsDataURL(picture.files[0]);

        filepicture.onload = function(e) {
            imgPreview.src = e.target.result;
            console.log(picture);
        }
    }

    $(document).ready(function() {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top',
            showConfirmButton: false,
            timer: 3000
        });

        $('.btnCancel').on('click', function(e) {
            data_profile();
        });

        $('.formprofile').submit(function(e) {
            e.preventDefault();
            let form = $('.formprofile')[0];
            let data = new FormData(form);
            $.ajax({
                type: "post",
                url: '/auth/profile/updateprofile',
                data: data,
                enctype: 'multipart/form-data',
                processData: false,
                contentType: false,
                cache: false,
                dataType: "json",
                beforeSend: function() {
                    $('.btnSave').prop('disabled', true);
                    $('.btnSave').html('<i class="fas fa-spin fa-spinner"></i> &nbsp; Proses..');
                },
                complete: function() {
                    $('.btnSave').prop('disabled', false);
                    $('.btnSave').html('<i class="fas fa-save"></i> &nbsp; Simpan ');
                },
                success: function(response) {
                    Toast.fire({
                        icon: 'success',
                        title: response.sukses
                    })
                    data_profile();
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
            return false;
        });
    });
</script>