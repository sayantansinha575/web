<!DOCTYPE html>
<html lang="en">
    
<head>
        <meta charset="utf-8" />
        <title>Forgot Password | National Youth Computer Training Academy</title>
        <!-- App favicon -->
        <link rel="shortcut icon" href="<?= site_url() ?>public/headoffice/images/favicon.ico">
        
        <!-- App css -->
         <link href="<?= site_url() ?>public/headoffice/css/icons.min.css" rel="stylesheet" type="text/css" />
         <link href="<?= site_url() ?>public/headoffice/css/app.min.css" rel="stylesheet" type="text/css" id="light-style" />
         <link href="<?= site_url() ?>public/headoffice/css/custom.css" rel="stylesheet" type="text/css" />
         <link href="<?= site_url() ?>public/global.css" rel="stylesheet" type="text/css" />

    </head>

    <body class="loading authentication-bg head-office-login-page" data-layout-config='{"leftSideBarTheme":"dark","layoutBoxed":false, "leftSidebarCondensed":false, "leftSidebarScrollable":false,"darkMode":false, "showRightSidebarOnStart": true}'>
        <div class="account-pages pt-2 pt-sm-5 pb-4 pb-sm-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xxl-4 col-lg-4">
                        <div class="card">

                            <!-- Logo -->
                            <div class="card-header text-center bg-primary" >
                                <a href="<?= site_url('head-office') ?>">
									<span><img class="logo-image headoffice-login-logo" src="<?= site_url() ?>public/upload/settings/nycta-header-image.jpg" alt=""></span>
                                </a>
                            </div>

                            <div class="card-body ">
                                <div class="text-center w-75 m-auto">
                                    <h4 class="text-dark-50 text-center mt-0 fw-bold">Reset Password</h4>
                                    <p class="text-muted mb-4">Enter your email address and we'll send you an email with instructions to reset your password.</p>
                                </div>

                                <form method="POST" action="<?= site_url('head-office/forgot-password'); ?>" onsubmit="submitButton.disabled = true; return true;" accept-charset="UTF-8">
                                    <div class="mb-3">
                                        <label for="emailaddress" class="form-label">Email address</label>
                                        <input class="form-control" type="text" id="emailaddress" name="email" value="<?= old('email') ?>" placeholder="user@example.com">
                                    </div>
                                    <div class="mb-3 mb-0 text-center">
                                         <?= csrf_field() ?>
                                         <button type="submit" class="btn btn-primary head-office-login-btn"> RESET PASSWORD </button>
                                         <?= view('Auth\Views\_notifications') ?>
                                    </div>

                                </form>
                            </div> <!-- end card-body -->
                        </div>
                        <!-- end card -->
                        <div class="row mt-3">
                            <div class="col-12 text-center">
                                <p class="text-muted">Back to <a href="<?= site_url('head-office') ?>" class="text-muted ms-1"><b>Log In</b></a></p>
                            </div> <!-- end col -->
                        </div>

                    </div> <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end page -->

        <footer class="footer footer-alt">
           National Youth Computer Training Academy
        </footer>

        <!-- bundle -->
        <script src="<?= site_url() ?>public/headoffice/js/vendor.min.js"></script>
        <script src="<?= site_url() ?>public/headoffice/js/app.min.js"></script>
        
    </body>

</html>
