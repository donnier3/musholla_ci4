<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Donasi - <?= ucwords($seting[0]['nama']) ?></title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <!-- <link href="/assets/img/icon.png" rel="icon"> -->
    <link rel="icon" href="/img/setting/<?= $seting[0]['icon'] ?>" />
    <!-- <link href="/assets/img/icon.png" rel="apple-touch-icon"> -->
    <link rel="apple-touch-icon" href="/img/setting/<?= $seting[0]['icon'] ?>" />

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">

    <!-- Fonts and icons -->
    <script src="/assets/js/plugin/webfont/webfont.min.js"></script>
    <script>
        WebFont.load({
            google: {
                "families": ["Lato:300,400,700,900"]
            },
            custom: {
                "families": ["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"],
                urls: ['/assets/css/fonts.min.css']
            },
            active: function() {
                sessionStorage.fonts = true;
            }
        });
    </script>

    <!-- Vendor CSS Files -->
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
    <link href="/assets/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/vendor/datepicker/css/bootstrap-datepicker.min.css">

    <!-- Template Main CSS File -->
    <link href="/assets/css/main.css" rel="stylesheet">
</head>

<body>

    <!-- ======= Header/Navbar ======= -->
    <nav class="navbar navbar-expand-lg navbar-light navbar-default1 fixed-top">
        <div class="container">
            <a class="navbar-brand text-brand" href="/">
                <img src="/img/setting/<?= $seting[0]['icon'] ?>" alt="" width="70">
                <span class="color-b" style="font-family: 'Audiowide', cursive;"><?= ucwords($seting[0]['nama']) ?></span>
            </a>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <?= $page == 'Donasi' ? '<a href="/konfirmasi-donasi">Konfirmasi</a>' : '<a href="/donasi">Donasi</a>'; ?>
                </li>
            </ul>
        </div>
    </nav><!-- End Header/Navbar -->

    <?= $this->renderSection('content') ?>

    <footer class="<?= $page == 'Konfirmasi' ? 'fixed-bottom' : ''; ?>">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="socials-a">
                    </div>
                    <div class="copyright-footer">
                        <p class="copyright color-text-a">
                            &copy; Copyright
                            <span class="color-a"><a href="/" class="text-success" style="font-family: 'Audiowide', cursive;"><?= ucwords($seting[0]['nama']) ?></a></span> All Rights Reserved.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </footer><!-- End  Footer -->

    <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>
    <div id="preloader"></div>

    <!-- Vendor JS Files -->
    <script src="/assets/vendor/jquery/jquery.min.js"></script>
    <script src="/assets/js/core/popper.min.js"></script>
    <script src="/assets/js/core/bootstrap.min.js"></script>
    <script src="/assets/vendor/datepicker/js/bootstrap-datepicker.min.js"></script>
    <!-- Sweet Alert -->
    <script src="/assets/js/plugin/sweetalert/sweetalert.min.js"></script>

    <!-- Template Main JS File -->
    <script src="/assets/js/main.js"></script>
    <?= $this->renderSection('script') ?>
</body>

</html>