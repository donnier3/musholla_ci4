<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/bootstrap.min.css">
    <link href="<?= base_url() ?>assets/css/main.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">
    <script src="<?= base_url() ?>assets/js/plugin/webfont/webfont.min.js"></script>
    <script>
        WebFont.load({
            google: {
                "families": ["Lato:300,400,700,900"]
            },
            custom: {
                "families": ["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"],
                urls: ['<?= base_url() ?>assets/css/fonts.min.css']
            },
            active: function() {
                sessionStorage.fonts = true;
            }
        });
    </script>
</head>

<body>
    <main style="font-family: Arial, Helvetica, sans-serif;">
        <div class="container">
            <div class="row">
                <main id="main">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-12 col-lg-10 col-xl-9 mb-5">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h4 style="font-size:x-large;">Invoice - <?= $kode_donasi ?></h4>
                                    </div>
                                </div>
                                <div class="page-divider"></div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card card-invoice">
                                            <div class="card-header">
                                                <div class="invoice-header">
                                                    <table width="100%">
                                                        <tr width="98%">
                                                            <td><?= ucwords($seting[0]['address']) ?></td>
                                                            <td rowspan="3"><?= $icon ?></td>
                                                        </tr>
                                                        <tr style="float: right;">
                                                            <td>Phone : +62<?= $seting[0]['phone'] ?></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <table width="100%" style="height:3px; margin-top:30px;">
                                                    <tr style="line-height: 0.1px; font-size: 14px; background-color:teal; color:white;">
                                                        <th width="30%">
                                                            <h4 class="sub">Date</h4>
                                                        </th>
                                                        <th width="30%">
                                                            <h4 class="sub">Invoice ID</h4>
                                                        </th>
                                                        <th width="40%">
                                                            <h4 class="sub">Invoice To</h4>
                                                        </th>
                                                    </tr>
                                                    <tr style="font-size: small;">
                                                        <td>
                                                            <p><?= date('d M Y', strtotime($created_at)) ?><br><?= date('H:i:s', strtotime($created_at)) ?></p>
                                                        </td>
                                                        <td>
                                                            <p><?= $kode_donasi ?></p>
                                                        </td>
                                                        <td>
                                                            <p><?= ucwords($nama_kategoridonasi) ?><br /><?= ucwords($nama_subkategoridonasi) ?></p>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div><br>
                                            <div class="card-footer">
                                                <div class="row">
                                                    <table width="100%">
                                                        <tr style="background-color:teal; color:white; line-height:0.1px;">
                                                            <th width="70%">
                                                                <h5 class="sub">Bank Transfer</h5>
                                                            </th>
                                                            <th>
                                                                <h5 class="sub">Total Amount</h5>
                                                            </th>
                                                        </tr>
                                                        <tr style="font-size: small;">
                                                            <td><span>Account Name:</span>&nbsp;<span><?= ucwords($nama_bank) ?></span></td>
                                                            <td>
                                                                <div class="price">Rp <?= number_format($jumlah_donasi, 0, ',', '.') ?></div>
                                                            </td>
                                                        </tr>
                                                        <tr style="font-size: small;">
                                                            <td><span>Account Number:</span>&nbsp;<span><?= $no_rekening ?></span></td>
                                                        </tr>
                                                        <tr style="font-size: small;">
                                                            <td><span>Code:</span>&nbsp;<span><?= $kode_bank ?></span></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                                <br><br>
                                                <h4 class="text-uppercase mt-4 mb-3 fw-bold">
                                                    Notes
                                                </h4>
                                                <p class="text-muted mb-0" style="font-size: small;">
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
            </div>
        </div>
    </main>

    <script src="<?= base_url() ?>assets/js/core/jquery.3.2.1.min.js"></script>
    <script src="<?= base_url() ?>assets/js/core/bootstrap.min.js"></script>
    <script src="<?= base_url() ?>assets/js/main.js"></script>
</body>

</html>