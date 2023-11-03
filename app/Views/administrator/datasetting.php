<style>
    .ck-editor__editable_inline {
        min-height: 107px !important;
        min-width: 595px !important;
    }
</style>
<?= form_open_multipart('', ['class' => 'formsetting']) ?>
<?= csrf_field() ?>
<div class="card shadow-lg p-3 mb-5 bg-white rounded">
    <div class="card-header ">
        <div class="card-title">Form Setting</div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-sm-6 col-md-6 col-lg-6">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="pemkab">Nama</label>
                        <input type="hidden" name="id_setting" value="<?= $setting[0]['id_setting'] ?>">
                        <input type="text" class="form-control" id="nama" name="nama" value="<?= $setting[0]['nama'] ?>" placeholder="Nama">
                        <div class="invalid-feedback errNama">
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="email">Email</label>
                        <input type="text" class="form-control" id="email" name="email" value="<?= $setting[0]['email'] ?>" placeholder="Email">
                        <div class="invalid-feedback errEmail">
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="address">Alamat</label>
                        <!-- <input type="text" class="form-control" name="alamat" placeholder="Nama Kepala Desa" id="alamat"> -->
                        <textarea name="address" class="form-control" id="address" rows="3" placeholder="Alamat"><?= $setting[0]['address'] ?></textarea>
                        <div class="invalid-feedback errAddress">
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="phone">Telepon</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">+62</span>
                            </div>
                            <input type="text" class="form-control" id="phone" name="phone" value="<?= $setting[0]['phone'] ?>" placeholder="Nomor Telepon" aria-describedby="basic-addon1">
                            <div class="invalid-feedback errTlp">
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="fb">Facebook</label>
                        <input type="text" class="form-control" name="fb" id="fb" value="<?= $setting[0]['fb'] ?>">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="ig">Instagram</label>
                        <input type="text" class="form-control" name="ig" id="ig" value="<?= $setting[0]['ig'] ?>">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="tw">Twitter</label>
                        <input type="text" class="form-control" name="tw" id="tw" value="<?= $setting[0]['tw'] ?>">
                    </div>

                </div>
            </div>
            <div class="col-sm-6 col-md-6 col-lg-6">
                <div class="form-row">
                    <div class="form-group">
                        <ul class="nav nav-pills nav-primary" id="pills-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="about_me-tab" data-toggle="pill" href="#about_me" role="tab" aria-controls="about_me" aria-selected="true">About Me</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="visi-tab" data-toggle="pill" href="#visi_me" role="tab" aria-controls="visi" aria-selected="false">Visi</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="misi-tab" data-toggle="pill" href="#misi_me" role="tab" aria-controls="misi" aria-selected="false">Misi</a>
                            </li>
                        </ul>
                        <div class="tab-content mt-2 mb-3" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="about_me" role="tabpanel" aria-labelledby="about_me-tab">
                                <textarea name="about_me" id="about" class="form-control about"><?= $setting[0]['about_me'] ?></textarea>
                                <div class="invalid-feedback errAbout">
                                </div>
                            </div>
                            <div class="tab-pane fade" id="visi_me" role="tabpanel" aria-labelledby="visi-tab">
                                <textarea name="visi" id="visi" class="form-control about"><?= $setting[0]['visi'] ?></textarea>
                                <div class="invalid-feedback errVisi">
                                </div>
                            </div>
                            <div class="tab-pane fade" id="misi_me" role="tabpanel" aria-labelledby="misi-tab">
                                <textarea name="misi" id="misi" class="form-control about"><?= $setting[0]['misi'] ?></textarea>
                                <div class="invalid-feedback errMisi">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 mb-2">
                <div class="form-group col-md-12">
                    <label for="maps">Google Map</label>&nbsp;<i class="fas fa-info-circle text-info" data-toggle="tooltip" data-placement="right" title="Ganti width menjadi 100%"></i>
                    <textarea name="maps" class="form-control" id="maps" cols="30" rows="2"><?= $setting[0]['maps'] ?></textarea>
                    <div class="invalid-feedback errMaps">
                    </div>
                </div>
            </div>
            <div class="col-12 row">
                <div class="form-row col-md-6">
                    <div class="form-group col-md-7">
                        <label for="icon">Icon</label>
                        <div class="custom-file">
                            <input type="hidden" name="icon_lama" value="<?= $setting[0]['icon'] ?>">
                            <input type="file" class="custom-file-input" id="icon" name="icon" onchange="previewIcon()">
                            <div class="invalid-feedback errIcon">
                            </div>
                            <label class="custom-file-label icon" for="icon"><?= $setting[0]['icon'] ?></label>
                        </div>
                    </div>
                    <div class="form-group col-md-5" style="margin-top: 30px;">
                        <img src="/img/setting/<?= $setting[0]['icon'] ?>" class="img-thumbnail icon-preview">
                    </div>
                </div>
                <div class="form-row col-md-6">
                    <div class="form-group col-md-7">
                        <label for="images">Gambar</label>
                        <div class="custom-file">
                            <input type="hidden" name="images_lama" value="<?= $setting[0]['images'] ?>">
                            <input type="file" class="custom-file-input" value="<?= $setting[0]['images'] ?>" id="images" name="images" onchange="previewImg()">
                            <div class="invalid-feedback errImages">
                            </div>
                            <label class="custom-file-label images" for="img"><?= $setting[0]['images'] ?></label>
                        </div>
                    </div>
                    <div class="form-group col-md-5" style="margin-top: 30px;">
                        <img src="/img/setting/<?= $setting[0]['images'] ?>" class="img-thumbnail img-preview">
                    </div>
                </div>
            </div>

            <button type="button" class="btn btn-danger ml-3 mt-5 btnCancel"><i class="fas fa-arrow-left"></i>&nbsp; Cancel</button>
            <button type="submit" class="btn btn-primary ml-3 mt-5 btnSave"><i class="fas fa-save"></i>&nbsp; Save</button>
        </div>
    </div>
</div>
<?= form_close() ?>

<script>
    ClassicEditor.defaultConfig = {
        toolbar: {
            items: [
                'heading',
                '|',
                'bold',
                'italic',
                '|',
                'bulletedList',
                'numberedList',
                '|',
                'insertTable',
                '|',
                'undo',
                'redo'
            ]
        },
        table: {
            contentToolbar: ['tableColumn', 'tableRow', 'mergeTableCells']
        },
        language: 'en'
    };

    $(function() {
        $('[data-toggle="tooltip"]').tooltip()
    })


    // ClassicEditor
    //     .create(document.querySelector('#about'))
    //     .then(editor => {
    //         console.log(editor);
    //     })
    //     .catch(error => {
    //         console.error(error);
    //     });
    var allEditors = document.querySelectorAll('.about')
    for (var i = 0; i < allEditors.length; ++i) {
        ClassicEditor.create(allEditors[i]);
    }

    function previewImg() {
        const images = document.querySelector('#images');
        const imagesLabel = document.querySelector('.images');
        const imgPreview = document.querySelector('.img-preview');

        imagesLabel.textContent = images.files[0].name;

        const fileimages = new FileReader();
        fileimages.readAsDataURL(images.files[0]);

        fileimages.onload = function(e) {
            imgPreview.src = e.target.result;
            console.log(images);
        }
    }

    function previewIcon() {
        const icon = document.querySelector('#icon');
        const iconLabel = document.querySelector('.icon');
        const imgPreview = document.querySelector('.icon-preview');

        iconLabel.textContent = icon.files[0].name;

        const fileicon = new FileReader();
        fileicon.readAsDataURL(icon.files[0]);

        fileicon.onload = function(e) {
            imgPreview.src = e.target.result;
            console.log(icon);
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
            data_setting();
        });

        $('.formsetting').submit(function(e) {
            e.preventDefault();
            let form = $('.formsetting')[0];
            let data = new FormData(form);
            $.ajax({
                type: "post",
                url: '/auth/setting/updatesetting',
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
                    if (response.error) {
                        if (response.error.nama) {
                            $('#nama').addClass('is-invalid');
                            $('.errNama').html(response.error.nama);
                        } else {
                            $('#nama').removeClass('is-invalid');
                            $('.errNama').html('');
                        }
                        if (response.error.email) {
                            $('#email').addClass('is-invalid');
                            $('.errEmail').html(response.error.email);
                        } else {
                            $('#email').removeClass('is-invalid');
                            $('.errEmail').html('');
                        }
                        if (response.error.address) {
                            $('#address').addClass('is-invalid');
                            $('.errAddress').html(response.error.address);
                        } else {
                            $('#address').removeClass('is-invalid');
                            $('.errAddress').html('');
                        }
                        if (response.error.phone) {
                            $('#phone').addClass('is-invalid');
                            $('.errTlp').html(response.error.phone);
                        } else {
                            $('#phone').removeClass('is-invalid');
                            $('.errTlp').html('');
                        }
                        if (response.error.about_me) {
                            $('#about').addClass('is-invalid');
                            $('.errAbout').html(response.error.about_me);
                        } else {
                            $('#about').removeClass('is-invalid');
                            $('.errAbout').html('');
                        }
                        if (response.error.visi) {
                            $('#visi').addClass('is-invalid');
                            $('.errVisi').html(response.error.visi);
                        } else {
                            $('#visi').removeClass('is-invalid');
                            $('.errVisi').html('');
                        }
                        if (response.error.misi) {
                            $('#misi').addClass('is-invalid');
                            $('.errMisi').html(response.error.misi);
                        } else {
                            $('#misi').removeClass('is-invalid');
                            $('.errMisi').html('');
                        }
                    } else {
                        Toast.fire({
                            icon: 'success',
                            title: response.sukses
                        })
                        data_setting();
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
            // return false;
        });
    });
</script>