<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Login &mdash; <?= ucwords($seting[0]['nama']) ?></title>

    <!-- Favicons -->
    <link href="/img/setting/<?= $seting[0]['icon'] ?>" rel="icon" class="img-avatar rounded-circle">

    <!-- General CSS Files -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

    <!-- CSS Libraries -->
    <!-- <link rel="stylesheet" href="../node_modules/bootstrap-social/bootstrap-social.css"> -->

    <!-- Template CSS -->
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/components.css">
</head>

<body>
    <div class="flash-data" data-flashdata="<?= session()->getFlashdata('msglogin'); ?>"></div>
    <div id="app">
        <section class="section">
            <div class="d-flex flex-wrap align-items-stretch">
                <div class="col-lg-8 col-12 order-lg-1 order-1 min-vh-100 background-walk-y position-relative overlay-gradient-bottom" data-background="/img/setting/<?= $seting[0]['images'] ?>">
                </div>
                <div class="col-lg-4 col-md-6 col-12 order-lg-2 min-vh-100 order-2 bg-white mt-5">
                    <div class="p-4 m-3 mt-5">
                        <!-- <img src="../assets/img/unsplash/login.jpg" alt="logo" width="80" height="80" class="shadow-light rounded-circle mb-3 mt-1"> -->
                        <h4 class="text-dark font-weight-normal">Welcome to <span class="font-weight-bold" style="font-family: 'Audiowide', cursive;"><?= ucwords($seting[0]['nama']) ?></span></h4>
                        <p class="text-muted">Before you get started, you must login.</p>
                        <!-- <form method="POST" action="#" class="needs-validation" novalidate=""> -->
                        <?= form_open('/auth//login/cek_login', ['class' => 'formlogin']) ?>
                        <?= csrf_field() ?>
                        <div class="form-group">
                            <label for="email">Username</label>
                            <input id="email" type="text" class="form-control" name="email" tabindex="1" placeholder="Username" autocomplete="off" autofocus>
                            <div class="invalid-feedback errEmail"></div>
                        </div>
                        <div class="form-group">
                            <div class="d-block">
                                <label for="password" class="control-label">Password</label>
                            </div>
                            <input id="password" type="password" class="form-control" name="password" placeholder="Password" tabindex="2">
                            <div class="invalid-feedback errPassword"></div>
                        </div>
                        <div class="form-group text-right">
                            <!-- <a href="javascript::void(0)" class="float-left mt-3">
                                    Forgot Password?
                                </a> -->
                            <button type="submit" class="btn btn-primary btnLogin btn-lg btn-icon icon-right" tabindex="4"><i class="fas fa-lock"></i>
                                Login
                            </button>
                        </div>

                        <!-- <div class="mt-5 text-center">
                            Don't have an account? <a href="javascript::void(0)">Create new one</a>
                        </div> -->
                        <!-- </form> -->
                        <?= form_close() ?>

                        <div class="text-center text-small mt-5">
                            Copyright &copy; 2020 - <?= date('Y') ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- General JS Scripts -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="/assets/js/stisla.js"></script>

    <!-- JS Libraies -->

    <!-- Template JS File -->
    <script src="/assets/js/scripts.js"></script>
    <script src="/assets/js/custom.js"></script>

    <!-- Page Specific JS File -->
    <script>
        $(document).ready(function() {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top',
                showConfirmButton: false,
                timer: 3000
            });

            const flashdata = $('.flash-data').data('flashdata');
            console.log(flashdata);

            if (flashdata) {
                Toast.fire({
                    icon: 'warning',
                    title: 'Session telah berakhir',
                    timer: false
                })
            }

            $('.formlogin').submit(function(e) {
                e.preventDefault();
                $.ajax({
                    type: "post",
                    url: $(this).attr('action'),
                    data: $(this).serialize(),
                    dataType: "json",
                    beforeSend: function() {
                        $('.btnLogin').prop('disabled', true);
                        $('.btnLogin').html('<i class="fas fa-spin fa-spinner"></i> Process');
                    },
                    complete: function() {
                        $('.btnLogin').prop('disabled', false);
                        $('.btnLogin').html('<i class="fas fa-lock"></i> Login');
                    },
                    success: function(response) {
                        if (response.sukses) {
                            Swal.fire({
                                html: '<br> You wil redirect in <b></b> second.',
                                timer: 1300,
                                timerProgressBar: true,
                                showConfirmButton: false,
                                onBeforeOpen: () => {
                                    Swal.showLoading()
                                    timerInterval = setInterval(() => {
                                        const content = Swal.getContent()
                                        if (content) {
                                            const b = content.querySelector('b')
                                            if (b) {
                                                b.textContent = Swal.getTimerLeft()
                                            }
                                        }
                                    }, 100)
                                },
                                onClose: () => {
                                    clearInterval(timerInterval)
                                    window.location = response.sukses.link
                                }
                            }).then((result) => {
                                /* Read more about handling dismissals below */
                                if (result.dismiss === Swal.DismissReason.timer) {
                                    console.log(result.flash)
                                }
                            })
                        } else if (response.errors) {
                            if (response.errors.email) {
                                $('#email').addClass('is-invalid');
                                $('.errEmail').html(response.errors.email);
                            } else {
                                $('#email').removeClass('is-invalid');
                                $('#email').addClass('is-valid');
                                $('.errEmail').html('');
                            }
                            if (response.errors.password) {
                                $('#password').addClass('is-invalid');
                                $('.errPassword').html(response.errors.password);
                            } else {
                                $('#password').removeClass('is-invalid');
                                $('#password').addClass('is-valid');
                                $('.errPassword').html('');
                            }
                        } else {
                            Toast.fire({
                                icon: 'error',
                                title: response.error
                            })
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                    }
                });
            });
        });
    </script>
</body>

</html>