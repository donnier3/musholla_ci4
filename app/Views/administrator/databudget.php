<div class="row">
    <div class="col-md-12">
        <div class="card shadow-lg p-3 mb-5 bg-white rounded">
            <div class="card-header">
                <div class="d-flex align-items-center">
                    <h4 class="card-title">Tabel Budget</h4>
                    <button class="btn btn-primary btn-sm btn-round ml-auto btnAdd" data-toggle="modal" data-target="#addRowModal">
                        <i class="fa fa-plus-circle"></i> &nbsp; Add Budget
                    </button>
                </div>
            </div>
            <div class="card-body ">
                <div class="table-responsive">
                    <table id="tblbudget" class="display table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Budget</th>
                                <th>Jumlah Budget</th>
                                <th>Dana Terkumpul</th>
                                <th>Batas Pengumpulan</th>
                                <th>Selisih</th>
                                <th>Percent</th>
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
    function daftarbudget() {
        var table = $('#tblbudget').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [],
            "ordering": false,
            "ajax": {
                "url": "/auth/budget/listbudget",
                "type": "POST"
            },
            "oLanguage": {
                "sEmptyTable": "Tidak ada data pada tabel"
            },
            "columnDefs": [{
                "targets": [4],
                "ordering": false,
                "type": "date",
                "render": function(data) {
                    return moment(data).locale('id').format('LL');
                },
            }, {
                "targets": [0, 7],
                "orderable": false,
            }],
        })
    }

    $(document).ready(function() {
        daftarbudget();

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
                url: "/auth/budget/modalTambahbudget",
                dataType: "json",
                beforeSend: function() {
                    $('.btnAdd').attr('disabled', true);
                    $('.btnAdd').html('<i class="fas fa-spin fa-spinner"></i> Process..');
                },
                complete: function() {
                    $('.btnAdd').attr('disabled', false);
                    $('.btnAdd').html('<i class="fas fa-plus-circle"></i> &nbsp; Add Budget ');
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

    function ajax_edit(id_budget) {
        $.ajax({
            type: "post",
            url: "/auth/budget/editbudget",
            data: {
                id_budget: id_budget
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

    function ajax_delete(id_budget, nama_donatur) {
        swal.fire({
            title: 'Apakah anda yakin?',
            text: "Menghapus budget " + nama_donatur + " ?",
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
                    url: "/auth/budget/delete_budget",
                    data: {
                        id_budget: id_budget
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.sukses) {
                            Toast.fire({
                                icon: 'success',
                                title: response.sukses
                            })
                            data_budget();
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