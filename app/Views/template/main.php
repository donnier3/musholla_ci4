<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title><?= ucwords($seting[0]['nama']) ?></title>
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
  <link href="/assets/vendor/ionicons/css/ionicons.min.css" rel="stylesheet">
  <link href="/assets/vendor/animate.css/animate.min.css" rel="stylesheet">
  <link href="/assets/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <link href="/assets/vendor/owl.carousel/assets/owl.carousel.min.css" rel="stylesheet">
  <link rel="stylesheet" href="/assets/css/datatables.min.css">
  <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
  <!-- Template Main CSS File -->
  <link href="/assets/css/main.css" rel="stylesheet">

</head>

<body id="page-top" onload="displayDate()">

  <!-- ======= Header/Navbar ======= -->
  <nav class="navbar navbar-default navbar-trans navbar-expand-lg fixed-top" id="mainNav">
    <div class="container">
      <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarDefault" aria-controls="navbarDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span></span>
        <span></span>
        <span></span>
      </button>
      <a class="navbar-brand text-brand" href="/">
        <img src="/img/setting/<?= $seting[0]['icon'] ?>" alt="" width="70">
        <span class="color-b" style="font-family: 'Audiowide', cursive;"><?= ucwords($seting[0]['nama']) ?></span>
      </a>
      <div class="navbar-collapse collapse justify-content-end" id="navbarDefault">
        <ul class="navbar-nav">
          <li class="nav-item <?= $page == 'Home' ? 'active' : ''; ?>">
            <a class="nav-link" href="/">Home</a>
          </li>
          <li class="nav-item <?= $page == 'Profile' ? 'active' : ''; ?>">
            <a class="nav-link" href="/profile">Profile</a>
          </li>
          <li class="nav-item dropdown <?= $page == 'Artikel' ? 'active' : ''; ?>">
            <a class="nav-link" href="/artikel">Artikel</a>
          </li>
          <li class="nav-item <?= $page == 'Kajian' ? 'active' : ''; ?>">
            <a class="nav-link" href="/kajian">Kajian</a>
          </li>
          <li class="nav-item <?= $page == 'Video' ? 'active' : ''; ?>">
            <a class="nav-link" href="/video">Video</a>
          </li>
          <li class="nav-item <?= $page == 'Download' ? 'active' : ''; ?>">
            <a class="nav-link" href="/download">Download</a>
          </li>
          <li class="nav-item <?= $page == 'Contact' ? 'active' : ''; ?>">
            <a class="nav-link" href="/contact">Contact</a>
          </li>
          <li class="nav-item">
            <button class="btn btn-success" onclick="window.location.href='/donasi'">Donasi
            </button>
          </li>
        </ul>
      </div>
    </div>
  </nav><!-- End Header/Navbar -->

  <?= $this->renderSection('content') ?>

  <!-- ======= Footer ======= -->
  <section class="section-footer">
    <div class="container" data-aos="fade-up">
      <div class="row">
        <div class="col-sm-12 col-md-4">
          <div class="widget-a">
            <div class="w-header-a">
              <h3 class="w-title-a text-brand" style="font-family: 'Audiowide', cursive;"><?= ucwords($seting[0]['nama']) ?></h3>
            </div>
            <img src="/img/setting/<?= $seting[0]['icon'] ?>" alt="" style="max-height: 10rem;">
            <div class=" w-body-a mt-3">
              <p class="w-text-a color-text-a">
                Selamat datang di website <?= ucwords($seting[0]['nama']) ?>.
                Media dakwah dan persatuan umat
              </p>
            </div>
          </div>
        </div>
        <div class="col-sm-12 col-md-4 section-md-t3">
          <div class="widget-a">
            <div class="w-header-a">
              <h3 class="w-title-a text-brand">Daftar Menu</h3>
            </div>
            <div class="w-body-a">
              <div class="w-body-a">
                <ul class="list-unstyled">
                  <li class="item-list-a">
                    <i class="fa fa-angle-right"></i> <a href="/">Home</a>
                  </li>
                  <li class="item-list-a">
                    <i class="fa fa-angle-right"></i> <a href="/profile">Profile</a>
                  </li>
                  <li class="item-list-a">
                    <i class="fa fa-angle-right"></i> <a href="/kajian">Kajian</a>
                  </li>
                  <li class="item-list-a">
                    <i class="fa fa-angle-right"></i> <a href="/video">Video</a>
                  </li>
                  <li class="item-list-a">
                    <i class="fa fa-angle-right"></i> <a href="/download">Download</a>
                  </li>
                  <li class="item-list-a">
                    <i class="fa fa-angle-right"></i> <a href="/contact">Contact</a>
                  </li>
                  <li class="item-list-a">
                    <i class="fa fa-angle-right"></i> <a href="/donasi">Donasi</a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-12 col-md-4 section-md-t3">
          <div class="widget-a">
            <div class="w-header-a">
              <h3 class="w-title-a text-brand">Kontak</h3>
            </div>
            <div class="w-body-a">
              <div class="w-body-a">
                <ul class="list-unstyled pl-3">
                  <li class="color-a row">
                    <span class="color-text-a"><i class="fas fa-map-marked-alt"></i></span>&nbsp;
                    <?= ucwords($seting[0]['address']) ?>
                  </li>
                  <li class="color-a row">
                    <span class="color-text-a"><i class="fas fa-envelope"></i></span>&nbsp;
                    <?= $seting[0]['email'] ?>
                  </li>
                  <li class="color-a row">
                    <span class="color-text-a"><i class="fas fa-mobile-alt"></i></span>&nbsp;
                    +62<?= $seting[0]['phone'] ?>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <footer>
    <div class="container" data-aos="fade-up">
      <div class="row">
        <div class="col-md-12">
          <div class="socials-a">
            <ul class="list-inline">
              <li class="list-inline-item">
                <a href="https://web.facebook.com/<?= $seting[0]['fb'] ?>" target="_blank">
                  <i class="fa fa-facebook" aria-hidden="true"></i>
                </a>
              </li>
              <li class="list-inline-item">
                <a href="https://www.twitter.com/<?= $seting[0]['tw'] ?>" target="_blank">
                  <i class="fa fa-twitter" aria-hidden="true"></i>
                </a>
              </li>
              <li class="list-inline-item">
                <a href="https://www.instagram.com/<?= $seting[0]['ig'] ?>" target="_blank">
                  <i class="fa fa-instagram" aria-hidden="true"></i>
                </a>
              </li>
            </ul>
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
  <!-- <script src="/assets/vendor/jquery/jquery.min.js"></script> -->
  <script src="/assets/js/core/jquery.3.2.1.min.js"></script>
  <script src="/assets/js/core/popper.min.js"></script>
  <!-- <script src="/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script> -->
  <script src="/assets/js/core/bootstrap.min.js"></script>

  <script src="/assets/js/datatables.min.js"></script>
  <script src="/assets/vendor/jquery.easing/jquery.easing.min.js"></script>
  <script src="/assets/vendor/php-email-form/validate.js"></script>
  <script src="/assets/vendor/owl.carousel/owl.carousel.min.js"></script>
  <script src="/assets/vendor/scrollreveal/scrollreveal.min.js"></script>

  <!-- Sweet Alert -->
  <script src="/assets/js/plugin/sweetalert/sweetalert.min.js"></script>

  <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
  <script>
    AOS.init({
      once: true,
      duration: 1000,
    });
  </script>

  <!-- Template Main JS File -->
  <script src="/assets/js/main.js"></script>
  <?= $this->renderSection('script') ?>
  <script>
    function displayDate() {
      var display = new Date().toLocaleTimeString("id");
      var date = new Date();
      var options = {
        weekday: "long",
        year: "numeric",
        month: "long",
        day: "numeric",
      }
      // document.body.innerHTML = display;
      document.getElementById('tglsholat').innerHTML = date.toLocaleDateString("id-ID", options);
    }
  </script>
</body>

</html>