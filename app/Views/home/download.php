<?= $this->extend('template/main') ?>
<?= $this->section('content') ?>
<section class="intro-single">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-lg-8 title-single-box" style="background-color: #eaf9f0;">
                <h1 class="title-single"><?= $page ?></h1>
                <span class="color-text-a"></span>
            </div>
            <div class="col-md-12 col-lg-4" style="background-color: #eaf9f0;">
                <nav aria-label="breadcrumb" class="breadcrumb-box d-flex justify-content-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="/">Home</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            <?= $page ?>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section><!-- End Intro Single-->

<main id="main">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table id="tbldownload" class="table tab-bordered table-hover w-100" style="font-size: 15px;">
                        <thead class="text-white" style="background-color: #2eca6a;">
                            <tr>
                                <th width="7%">No</th>
                                <th width="40%">Judul</th>
                                <th width="30%">Pemateri</th>
                                <th width="15%">Total Download</th>
                                <th width="7%">Download</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
    function download() {
        $('#tbldownload').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "/home/listdownload",
                "type": "POST"
            },
            "oLanguage": {
                "sEmptyTable": "Tidak ada data pada tabel"
            },
            "columnDefs": [{
                "targets": [0, 4],
                "orderable": false
            }],
        });
    }

    $(document).ready(function() {
        download();
    });
</script>
<?= $this->endSection() ?>