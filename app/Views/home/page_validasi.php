<?= $this->extend('template/read') ?>
<?= $this->section('content') ?>

<main id="main" style="padding-top: 110px;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10 col-xl-9 mb-5">
                <div class="row align-items-center">
                    <div class="col">
                        <h6 class="page-pretitle">
                            Payments
                        </h6>
                        <h4 class="page-title">Invoice <?= $kode_donasi ?></h4>
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-a btnDownload" onclick="window.location.href = '/donasi/validation/download/kode=<?= $kode_donasi ?>'"><i class="fas fa-download"></i> Invoice</button>
                        <button class="btn btn-b ml-2" onclick="window.location.href = '/konfirmasi-donasi/kode=<?= $kode_donasi ?>'"><i class="fas fa-check-circle"></i> Konfirmasi</button>
                    </div>
                </div>
                <div class="page-divider"></div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-invoice">
                            <div class="card-header">
                                <div class="invoice-header mb-2">
                                    <h3 class="invoice-title">
                                        Invoice
                                    </h3>
                                    <div class="invoice-logo">
                                        <img src="/img/setting/<?= $seting[0]['icon'] ?>" alt="company logo" width="10%">
                                    </div>
                                </div>
                                <div class="invoice-desc">
                                    <?= ucwords($seting[0]['address']) ?><br />
                                    Phone : +62<?= $seting[0]['phone'] ?>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="separator-solid"></div>
                                <div class="row">
                                    <div class="col-md-4 info-invoice">
                                        <h5 class="sub">Date</h5>
                                        <p><?= date('d M Y', strtotime($created_at)) ?><br><?= date('H:i:s', strtotime($created_at)) ?></p>
                                    </div>
                                    <div class="col-md-4 info-invoice">
                                        <h5 class="sub">Invoice ID</h5>
                                        <p><?= $kode_donasi ?></p>
                                    </div>
                                    <div class="col-md-4 info-invoice">
                                        <h5 class="sub">Invoice To</h5>
                                        <p>
                                            <?= ucwords($nama_kategoridonasi) ?><br /><?= ucwords($nama_subkategoridonasi) ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-sm-8 col-md-6 mb-4 mb-md-0 transfer-to">
                                        <h5 class="sub">Bank Transfer</h5>
                                        <div class="account-transfer">
                                            <div><span>Account Name:</span>&nbsp;<span><?= ucwords($nama_bank) ?></span></div>
                                            <div><span>Account Number:</span>&nbsp;<span><?= $no_rekening ?></span></div>
                                            <div><span>Code:</span>&nbsp;<span><?= $kode_bank ?></span></div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-md-6 transfer-total">
                                        <h5 class="sub">Total Amount</h5>
                                        <div class="price">Rp <?= number_format($jumlah_donasi, 0, ',', '.') ?></div>
                                    </div>
                                </div>
                                <div class="separator-solid"></div>
                                <h6 class="text-uppercase mt-4 mb-3 fw-bold">
                                    Notes
                                </h6>
                                <p class="text-muted mb-0">
                                    Terima kasih telah melakukan donasi untuk <strong><?= ucwords($nama_subkategoridonasi) ?></strong>. Semoga Allah SWT membalas kebaikan Bpk/Ibu <?= ucwords($nama_donatur) ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?= $this->endSection() ?>