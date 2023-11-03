<div class="row">
    <div class="col-md-12">
        <div class="card shadow-lg p-3 mb-5 bg-white rounded">
            <div class="card-header">
                <div class="d-flex align-items-center">
                    <h4 class="card-title">Tabel Bank</h4>
                    <button class="btn btn-primary btn-sm btn-round ml-auto btnAdd" data-toggle="modal" data-target="#addRowModal">
                        <i class="fa fa-plus-circle"></i> &nbsp; Add Bank
                    </button>
                </div>
            </div>
            <div class="card-body ">
                <div class="table-responsive">
                    <table id="tblbank" class="display table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Kode Bank</th>
                                <th>Nama Bank</th>
                                <th>Cabang</th>
                                <th>Nomor Rekening</th>
                                <th>Nama Rekening</th>
                                <th width="12%">Action</th>
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
    function daftarbank() {
        var table = $('#tblbank').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [],
            "ordering": false,
            "ajax": {
                "url": "/auth/bank/listbank",
                "type": "POST"
            },
            "oLanguage": {
                "sEmptyTable": "Tidak ada data pada tabel"
            },
            "columnDefs": [{
                "targets": [4],
                "ordering": false,
            }, {
                "targets": [0, 6],
                "orderable": false,
            }],
        })
    }

    $(document).ready(function() {
        daftarbank();

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
                url: "/auth/bank/modalTambahbank",
                dataType: "json",
                beforeSend: function() {
                    $('.btnAdd').attr('disabled', true);
                    $('.btnAdd').html('<i class="fas fa-spin fa-spinner"></i> Process..');
                },
                complete: function() {
                    $('.btnAdd').attr('disabled', false);
                    $('.btnAdd').html('<i class="fas fa-plus-circle"></i> &nbsp; Add bank ');
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

    function ajax_edit(id_bank) {
        $.ajax({
            type: "post",
            url: "/auth/bank/editbank",
            data: {
                id_bank: id_bank
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

    function ajax_delete(id_bank, nama_bank) {
        swal.fire({
            title: 'Apakah anda yakin?',
            text: "Menghapus bank " + nama_bank + " ?",
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
                    url: "/auth/bank/delete_bank",
                    data: {
                        id_bank: id_bank
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.sukses) {
                            Toast.fire({
                                icon: 'success',
                                title: response.sukses
                            })
                            data_bank();
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