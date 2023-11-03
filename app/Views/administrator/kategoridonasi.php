<?= $this->extend('template/administrator') ?>
<?= $this->section('content') ?>
<div class="content">
    <div class="panel-header bg-primary-gradient">
        <div class="page-inner py-5">
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
                <div class="text-white">
                    <h2 class="text-white pb-2 fw-bold">Daftar Kategori Donasi</h2>
                </div>
            </div>
        </div>
    </div>
    <div class="page-inner mt--5">
        <div class="mt--3">
            <div class="view-data"></div>
        </div>
    </div>
</div>
<div class="view-modal" style="display: none;"></div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
    function data_kategoridonasi() {
        $.ajax({
            url: "/auth/kategoridonasi/ambildatakategoridonasi",
            dataType: "json",
            success: function(response) {
                $('.view-data').html(response.data);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    }

    $(document).ready(function() {
        data_kategoridonasi();
    });
</script>
<?= $this->endSection() ?>