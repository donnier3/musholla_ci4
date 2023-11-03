<div class="row">
    <div class="col-md-12">
        <div class="card shadow-lg p-3 mb-5 bg-white rounded">
            <div class="card-header">
                <div class="d-flex align-items-center">
                    <h4 class="card-title">Tabel Subkateogri Donasi</h4>
                    <button class="btn btn-primary btn-sm btn-round ml-auto btnAdd" data-toggle="modal" data-target="#addRowModal">
                        <i class="fa fa-plus-circle"></i> &nbsp; Add Subkateogri
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="tblsubkategoridonasi" class="display table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Subkategori</th>
                                <th>Nama Kategori</th>
                                <th>Created</th>
                                <th>Action</th>
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
    function daftarsubkategoridonasi() {
        var table = $('#tblsubkategoridonasi').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "/auth/subkategoridonasi/listsubkategoridonasi",
                "type": "POST"
            },
            "columnDefs": [{
                "targets": [0, 4],
                "orderable": false
            }],
        })
    }

    $(document).ready(function() {
        daftarsubkategoridonasi();

        $('.btnAdd').on('click', function(e) {
            $.ajax({
                url: "/auth/subkategoridonasi/modalTambahsubkategoridonasi",
                dataType: "json",
                beforeSend: function() {
                    $('.btnAdd').attr('disabled', true);
                    $('.btnAdd').html('<i class="fas fa-spin fa-spinner"></i> Process..');
                },
                complete: function() {
                    $('.btnAdd').attr('disabled', false);
                    $('.btnAdd').html('<i class="fas fa-plus-circle"></i> &nbsp; Add Row ');
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

    function ajax_edit(id_subkategoridonasi) {
        $.ajax({
            type: "post",
            url: "/auth/subkategoridonasi/editsubkategoridonasi",
            data: {
                id_subkategoridonasi: id_subkategoridonasi
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

    function ajax_delete(id_subkategoridonasi, nama_subkategoridonasi) {
        swal.fire({
            title: 'Apakah anda yakin?',
            text: "Menghapus " + nama_subkategoridonasi + " ?",
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
                    url: "/auth/subkategoridonasi/delete_subkategoridonasi",
                    data: {
                        id_subkategoridonasi: id_subkategoridonasi
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.sukses) {
                            Toast.fire({
                                icon: 'success',
                                title: response.sukses
                            })
                            data_subkategoridonasi();
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