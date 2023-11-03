<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Al Jannah - Admin Page</title>
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <link rel="icon" href="/img/setting/<?= $seting[0]['icon'] ?>" />

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
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Audiowide&family=Open+Sans&display=swap" rel="stylesheet">

    <!-- CSS Files -->
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/atlantis.min.css">
    <link rel="stylesheet" href="/assets/css/select2.min.css">
    <link rel="stylesheet" href="/assets/vendor/datepicker/css/bootstrap-datepicker.min.css">
</head>

<body onload="displayClock()">
    <div class="wrapper overlay-sidebar">
        <div class="main-header">
            <!-- Logo Header -->
            <div class="logo-header" data-background-color="blue2">

                <a href="/auth/administrator" class="logo" style="font-size: 25px; color:white; text-align:center; font-family: 'Audiowide', cursive; text-decoration:none;">
                    <!-- <img src="/assets/img/logo.svg" alt="navbar brand" class="navbar-brand"> -->
                    <?= ucwords($seting[0]['nama']) ?>
                </a>
                <button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse" data-target="collapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon">
                        <i class="icon-menu"></i>
                    </span>
                </button>
                <button class="topbar-toggler more"><i class="icon-options-vertical"></i></button>
                <div class="nav-toggle">
                    <button class="btn btn-toggle sidenav-overlay-toggler">
                        <i class="icon-menu"></i>
                    </button>
                </div>
            </div>
            <!-- End Logo Header -->

            <!-- Navbar Header -->
            <nav class="navbar navbar-header navbar-expand-lg" data-background-color="blue2">
                <div class="container-fluid">
                    <span id="clock" class="text-white navbar-nav topbar-nav mb-md-3 mb-sm-3 mb-xs-3 mb-lg-auto"></span>
                    <ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
                        <li class="nav-item dropdown hidden-caret pr-3">
                            <a href="/auth/administrator/setting" class="href">
                                <i class="fas fa-wrench fa-lg text-white" data-toggle="tooltip" title="Setting" data-placement="bottom"></i>
                            </a>
                        </li>
                        <li class="pr-3 nav-item dropdown hidden-caret" class="href">
                            <a href="/auth/administrator/profile" data-toggle="tooltip" title="Profile" data-placement="bottom">
                                <i class="fas fa-user fa-lg text-white"></i>
                            </a>
                        </li>
                        <li class="nav-item dropdown hidden-caret" class="href">
                            <i class="fas fa-power-off fa-lg text-white" id="logout" style="cursor: pointer;" data-toggle="tooltip" title="Logout" data-placement="bottom"></i>
                        </li>
                    </ul>
                </div>
            </nav>
            <!-- End Navbar -->
        </div>

        <!-- Sidebar -->
        <div class="sidebar sidebar-style-2">
            <div class="sidebar-wrapper scrollbar scrollbar-inner">
                <div class="sidebar-content">
                    <div class="user">
                        <div class="avatar-sm avatar avatar-online float-left mr-2">
                            <img src="/img/profile/<?= $profile[0]['picture'] ?>" alt="..." class="avatar-img rounded-circle">
                        </div>
                        <div class="info">
                            <a data-toggle="collapse" href="#collapseExample" aria-expanded="true">
                                <span>
                                    <?= ucwords($_SESSION['nama_user']) ?>
                                    <span class="user-level">Administrator</span>
                                </span>
                            </a>
                            <div class="clearfix"></div>

                        </div>
                    </div>
                    <ul class="nav nav-primary">
                        <li class="nav-section">
                            <span class="sidebar-mini-icon">
                                <i class="fa fa-ellipsis-h"></i>
                            </span>
                            <h4 class="text-section">Menus</h4>
                        </li>
                        <li class="nav-item">
                            <a href="/auth/administrator/dashboard" class="href">
                                <i class="fas fa-desktop"></i>
                                <p>Dashboard</p>
                            </a>
                            <a href="/auth/administrator/users" class="href">
                                <i class="fas fa-user-alt"></i>
                                <p>Users</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/auth/administrator/bank" class="href">
                                <i class="fas fa-building"></i>
                                <p>Bank</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/auth/administrator/budget" class="href">
                                <i class="fas fa-wallet"></i>
                                <p>Budgeting</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a data-toggle="collapse" href="#pengeluaran">
                                <i class="fas fa-chart-line"></i>
                                <p>Pengeluaran</p>
                                <span class="caret"></span>
                            </a>
                            <div class="collapse" id="pengeluaran">
                                <ul class="nav nav-collapse">
                                    <li>
                                        <a href="/auth/administrator/pengeluaran/kategori" class="href">
                                            <span class="sub-item">Kategori</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/auth/administrator/pengeluaran/sub-kategori" class="href">
                                            <span class="sub-item">Sub Kategori</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/auth/administrator/pengeluaran/pengeluaran" class="href">
                                            <span class="sub-item">Pengeluaran</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a data-toggle="collapse" href="#pemasukan">
                                <i class="fas fa-money-bill-wave"></i>
                                <p>Pemasukan</p>
                                <span class="caret"></span>
                            </a>
                            <div class="collapse" id="pemasukan">
                                <ul class="nav nav-collapse">
                                    <li>
                                        <a href="/auth/administrator/pemasukan/kategori" class="href">
                                            <span class="sub-item">Kategori</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/auth/administrator/pemasukan/sub-kategori" class="href">
                                            <span class="sub-item">Sub Kategori</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/auth/administrator/pemasukan/donasi" class="href">
                                            <span class="sub-item">Donasi</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a data-toggle="collapse" href="#blog">
                                <i class="fas fa-tags"></i>
                                <p>Blog</p>
                                <span class="caret"></span>
                            </a>
                            <div class="collapse" id="blog">
                                <ul class="nav nav-collapse">
                                    <li>
                                        <a href="/auth/administrator/blog/kategori" class="href">
                                            <span class="sub-item">Kategori</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/auth/administrator/blog/artikel" class="href">
                                            <span class="sub-item">Artikel</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/auth/administrator/blog/materi" class="href">
                                            <span class="sub-item">Materi</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/auth/administrator/blog/video" class="href">
                                            <span class="sub-item">Video</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a href="/auth/administrator/kajian" class="href">
                                <i class="fas fa-calendar-check"></i>
                                <p>Kajian</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- End Sidebar -->

        <div class="main-panel">

            <?= $this->renderSection('content') ?>

            <footer class="footer">
                <div class="container-fluid">
                    <div class="copyright ml-auto">
                        Copyright &copy; <a href="/" style="text-decoration:none;">BaitiJannaty</a> 2018 - <?= date('Y') ?>
                    </div>
                </div>
            </footer>
        </div>

    </div>
    <!--   Core JS Files   -->
    <script src="/assets/js/core/jquery.3.2.1.min.js"></script>
    <script src="/assets/js/core/popper.min.js"></script>
    <script src="/assets/js/core/bootstrap.min.js"></script>

    <!-- jQuery UI -->
    <script src="/assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
    <script src="/assets/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js"></script>

    <!-- Highcharts -->
    <script src="/assets/vendor/highcharts/highcharts.src.js"></script>

    <!-- select2 -->
    <script src="/assets/js/select2.full.min.js"></script>

    <!-- Moment JS -->
    <script src="/assets/js/moment.js"></script>
    <!-- jQuery Scrollbar -->
    <script src="/assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>

    <!-- Datatables -->
    <script src="/assets/js/plugin/datatables/datatables.min.js"></script>
    <script src="/assets/js/plugin/datatables/dataTables.bootstrap4.min.js"></script>
    <script src="/assets/js/plugin/datatables/dataTables.buttons.min.js"></script>
    <script src="/assets/js/plugin/datatables/pdfmake.min.js"></script>
    <script src="/assets/js/plugin/datatables/buttons.html5.min.js"></script>
    <script src="/assets/js/plugin/datatables/vfs_fonts.js"></script>

    <!-- Sweet Alert -->
    <script src="/assets/js/plugin/sweetalert/sweetalert.min.js"></script>

    <!-- daterangepicker  -->
    <script src="/assets/vendor/datepicker/js/bootstrap-datepicker.min.js"></script>

    <!-- Atlantis JS -->
    <script src="/assets/js/atlantis.min.js"></script>

    <!-- CkEditor -->
    <script src="/assets/ckeditor5/ckeditor.js"></script>

    <?= $this->renderSection('script') ?>
    <script>
        function displayClock() {
            var display = new Date().toLocaleTimeString("id");
            var date = new Date();
            var options = {
                weekday: "long",
                year: "numeric",
                month: "long",
                day: "numeric",
            }
            // document.body.innerHTML = display;
            document.getElementById('clock').innerHTML = date.toLocaleDateString("id-ID", options) + " - " + display;
            setTimeout(displayClock, 1000);
        }

        $('#logout').on('click', function(e) {
            e.preventDefault();
            swal.fire({
                title: 'Apakah anda yakin?',
                text: 'Ingin keluar dari aplikasi ini?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Logout!'
            }).then((result) => {
                if (result.value) {
                    document.location.href = "/auth/logout";
                }
            })
        });
    </script>
</body>

</html>