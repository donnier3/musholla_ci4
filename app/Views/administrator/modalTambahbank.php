<!-- Modal -->
<div class="modal fade" id="modal-tambah" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary-gradient">
                <h5 class="modal-title text-white" id="staticBackdropLabel">Tambah Bank</h5>
            </div>
            <?= form_open_multipart('', ['class' => 'frmtambahbank']) ?>
            <div class="modal-body">
                <?= csrf_field() ?>
                <div class="form-row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="kode_bank" class="col-sm-3 col-form-label">Kode Bank</label>
                            <div class="col-sm-12">
                                <input type="text" name="kode_bank" id="kode_bank" class="form-control" placeholder="Kode">
                                <div class="invalid-feedback errKode">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="nama_bank" class="col-sm-3 col-form-label">Nama Bank</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control date" name="nama_bank" placeholder="Nama Bank" id="nama_bank">
                                <div class="invalid-feedback errNama">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="cabang" class="col-sm-3 col-form-label">Cabang</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" name="cabang" placeholder="Cabang" id="cabang">
                                <div class="invalid-feedback errCab"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="no_rekening" class="col-sm-3 col-form-label">Nomor Rekening</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" name="no_rekening" placeholder="Nomor Rekening" id="no_rekening">
                                <div class="invalid-feedback errNo">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="form-group">
                            <label for="nama_rekening" class="col-sm-3 col-form-label">Nama Rekening</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" name="nama_rekening" id="nama_rekening" placeholder="Nama Rekening">
                                <div class="invalid-feedback errRek"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="logo_bank" class="col-sm-3 col-form-label">Gambar</label>
                            <div class="col-sm-12">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="logo_bank" name="logo_bank" onchange="previewPic()">
                                    <div class="invalid-feedback errFile">
                                    </div>
                                    <label class="custom-file-label pic" for="logo_bank">Choose File..</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="col-sm-3 col-form-label">Preview Gambar</label>
                            <div class="col-sm-12">
                                <img src="/img/kajian/default.jpg" style="max-width: 300px; max-height:300px;" class="rounded img-thumbnail img-preview">
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
        const logo_bank = document.querySelector('#logo_bank');
        const logo_bankLabel = document.querySelector('.pic');
        const imgPreview = document.querySelector('.img-preview');

        logo_bankLabel.textContent = logo_bank.files[0].name;

        const filelogo_bank = new FileReader();
        filelogo_bank.readAsDataURL(logo_bank.files[0]);

        filelogo_bank.onload = function(e) {
            imgPreview.src = e.target.result;
            console.log(logo_bank);
        }
    }

    $(document).ready(function() {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top',
            showConfirmButton: false,
            timer: 3000
        });

        $('.btnSave').on('click', function(e) {
            e.preventDefault();
            let form = $('.frmtambahbank')[0];
            let data = new FormData(form);
            $.ajax({
                type: "post",
                url: '/auth/bank/tambahbank',
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
                        if (response.error.nama_bank) {
                            $('#nama_bank').addClass('is-invalid');
                            $('.errNama').html(response.error.nama_bank);
                        } else {
                            $('#nama_bank').removeClass('is-invalid');
                            $('#nama_bank').addClass('is-valid');
                            $('.errNama').html(response.error.nama_bank);
                        }
                        if (response.error.no_rekening) {
                            $('#no_rekening').addClass('is-invalid');
                            $('.errNo').html(response.error.no_rekening);
                        } else {
                            $('#no_rekening').removeClass('is-invalid');
                            $('#no_rekening').addClass('is-valid');
                            $('.errNo').html(response.error.no_rekening);
                        }
                        if (response.error.nama_rekening) {
                            $('#nama_rekening').addClass('is-invalid');
                            $('.errRek').html(response.error.nama_rekening);
                        } else {
                            $('#nama_rekening').removeClass('is-invalid');
                            $('#nama_rekening').addClass('is-valid');
                            $('.errRek').html(response.error.nama_rekening);
                        }
                        if (response.error.logo_bank) {
                            $('#logo_bank').addClass('is-invalid');
                            $('.errFile').html(response.error.logo_bank);
                        } else {
                            $('#logo_bank').removeClass('is-invalid');
                            $('#logo_bank').addClass('is-valid');
                            $('.errFile').html(response.error.logo_bank);
                        }
                    } else {
                        Toast.fire({
                            icon: 'success',
                            title: response.sukses
                        })
                        $('#modal-tambah').modal('hide');
                        data_bank();
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