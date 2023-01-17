
<?php $this->session = \Config\Services::session();  ?>
<!DOCTYPE html>
<html lang="en">
    
<head>
        <title>Log In | National Youth Computer Training Academy</title>
        <meta name="title" content="<?= config('SiteConfig')->meta['TITLE'] ?>">
        <meta name="description" content="<?= config('SiteConfig')->meta['DESCRIPTION'] ?>">
        <meta name="robots" content="noindex,nofollow">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="language" content="English">
        <meta name="author" content="NYCTA">
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
									<h4>Employer Registration</h4>
                                    <?= view('Auth\Views\_notifications') ?>
                                    <?php echo $this->session->getFlashdata('success'); ?>
                                    <?= \Config\Services::validation()->listErrors(); ?> 
                                </div>

                                <form method="POST" action="<?= site_url('employer/save-employe')?>" accept-charset="UTF-8">
                                    <?= csrf_field() ?>
                                	<div class="mb-3">
                                        <label for="emailaddress" class="form-label">Company Name</label>
                                        <input class="form-control" type="text" name="name" value="<?= old('name') ?>"  placeholder="Enter Company name">
                                    </div>
                                    <div class="mb-3">
                                        <label for="emailaddress" class="form-label">Email address</label>
                                        <input class="form-control" type="text" id="email" name="email" value="<?= old('email') ?>"  placeholder="user@example.com">
                                    </div>
                                    <div class="mb-3">
                                        <label for="emailaddress" class="form-label">Phone</label>
                                        <input class="form-control" type="text" id="mobile" name="mobile" value="<?= old('mobile') ?>"  placeholder="Enter Phone number">
                                    </div>

                                    <div class="mb-3">
                                        <label for="password" class="form-label">Password</label>
                                        <div class="input-group input-group-merge">
                                            <input type="password" name="password" id="password" class="form-control" placeholder="Enter your password">
                                            <div class="input-group-text" data-password="false">
                                                <span class="password-eye"></span>
                                            </div>
                                        </div>
                                    </div>
                                     <div class="mb-3">
                                        <label for="password" class="form-label">Confirm Password</label>
                                        <div class="input-group input-group-merge">
                                            <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Enter your password">
                                            <div class="input-group-text" data-password="false">
                                                <span class="password-eye"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3 mb-0 text-center">
                                  
                                         <button type="submit" class="btn btn-primary head-office-login-btn"><i class="mdi mdi-login"></i>
                                         	Sign Up
                                         </button>
                                    </div>

                                </form>
                            </div> <!-- end card-body -->
                        </div>
                        <!-- end card -->

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
