<div class="row">
    <div class="col-md-12">
        <div class="card shadow-lg p-3 mb-5 bg-white rounded">
            <div class="card-header">
                <div class="d-flex align-items-center">
                    <h4 class="card-title">Tabel Donasi</h4>
                    <button class="btn btn-primary btn-sm btn-round ml-auto btnAdd" data-toggle="modal" data-target="#addRowModal">
                        <i class="fa fa-plus-circle"></i> &nbsp; Add Donasi
                    </button>
                </div>
            </div>
            <div class="card-body ">
                <div class="table-responsive">
                    <table id="tbldonasi" class="display table table-striped table-hover">
                        <thead class="text-center">
                            <tr>
                                <th>#</th>
                                <th>Nama Donatur</th>
                                <th>Nomor Handphone</th>
                                <th width="25%">Jenis Donasi</th>
                                <!-- <th>Tanggal Donasi</th> -->
                                <th>Jumlah Donasi</th>
                                <th>Bukti Donasi</th>
                                <th width="15%">Bank</th>
                                <th width="15%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function daftardonasi() {
        var table = $('#tbldonasi').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "/auth/donasi/listdonasi",
                "type": "POST"
            },
            "oLanguage": {
                "sEmptyTable": "Tidak ada data pada tabel"
            },
            "columnDefs": [{
                "targets": [0, 7],
                "orderable": false
            }],
        })
    }

    $(document).ready(function() {
        daftardonasi();

        $('.date').datepicker({
            todayBtn: "linked",
            language: "id",
            autoclose: true,
            todayHighlight: true,
            toggleActive: true,
            orientation: 'bottom'
        });

        $('.btnAdd').on('click', function(e) {
            $.ajax({
                url: "/auth/donasi/modalTambahdonasi",
                dataType: "json",
                beforeSend: function() {
                    $('.btnAdd').attr('disabled', true);
                    $('.btnAdd').html('<i class="fas fa-spin fa-spinner"></i> Process..');
                },
                complete: function() {
                    $('.btnAdd').attr('disabled', false);
                    $('.btnAdd').html('<i class="fas fa-plus-circle"></i> &nbsp; Add Donasi ');
                },
                success: function(response) {
                    $('.view-modal').html(response.data).show();
                    $('#modal-tambah').modal('show');
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        });
    });

    function ajax_edit(id_donasi) {
        $.ajax({
            type: "post",
            url: "/auth/donasi/editdonasi",
            data: {
                id_donasi: id_donasi
            },
            dataType: "json",
            success: function(response) {
                if (response.sukses) {
                    $('.view-modal').html(response.sukses).show();
                    $('#modal-edit').modal('show');
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    }

    function ajax_view(id_konfirmasidonasi) {
        $.ajax({
            type: "post",
            url: "/auth/donasi/viewbukti",
            data: {
                id_konfirmasidonasi: id_konfirmasidonasi
            },
            dataType: "json",
            success: function(response) {
                if (response.sukses) {
                    $('.view-modal').html(response.sukses).show();
                    $('#modal-view').modal('show');
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    }

    function ajax_upload(id_konfirmasidonasi) {
        $.ajax({
            type: "post",
            url: "/auth/donasi/uploadbuktidonasi",
            data: {
                id_konfirmasidonasi: id_konfirmasidonasi
            },
            dataType: "json",
            success: function(response) {
                if (response.sukses) {
                    $('.view-modal').html(response.sukses).show();
                    $('#modal-upload').modal('show');
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });

    }

    function ajax_delete(id_donasi, nama_donatur) {
        swal.fire({
            title: 'Apakah anda yakin?',
            text: "Menghapus " + nama_donatur + " ?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Delete!',
            cancelButtonText: "Tidak"
        }).then((result) => {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top',
                showConfirmButton: false,
                timer: 3000
            });
            if (result.value) {
                $.ajax({
                    type: "post",
                    url: "/auth/donasi/delete_donasi",
                    data: {
                        id_donasi: id_donasi
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.sukses) {
                            Toast.fire({
                                icon: 'success',
                                title: response.sukses
                            })
                            data_donasi();
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                    }
                });
            }
        });
    }
</script>