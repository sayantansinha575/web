<?php $this->session = \Config\Services::session(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title><?= $title.' || '.config('SiteConfig')->general['PAGE_TITLE']; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="title" content="<?= config('SiteConfig')->meta['TITLE'] ?>">
    <meta name="description" content="<?= config('SiteConfig')->meta['DESCRIPTION'] ?>">
    <meta name="robots" content="noindex,nofollow">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="language" content="English">
    <meta name="author" content="NYCTA">
    <link rel="apple-touch-icon" sizes="180x180" href="<?= site_url('public/upload/settings/').config('SiteConfig')->general['APPLE_TOUCH_ICON'] ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= site_url('public/upload/settings/').config('SiteConfig')->general['FAV_ICON_32'] ?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= site_url('public/upload/settings/').config('SiteConfig')->general['FAV_ICON_16'] ?>">

    <!-- third party css -->
    <link href="<?= site_url() ?>public/employer/css/vendor/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <!-- third party css end -->
    <!-- third party css -->
    <link href="<?= site_url() ?>public/employer/css/vendor/dataTables.bootstrap5.css" rel="stylesheet" type="text/css" />
    <link href="<?= site_url() ?>public/employer/css/vendor/responsive.bootstrap5.css" rel="stylesheet" type="text/css" />
    <link href="<?= site_url() ?>public/employer/css/vendor/buttons.bootstrap5.css" rel="stylesheet" type="text/css" />
    <link href="<?= site_url() ?>public/employer/css/vendor/select.bootstrap5.css" rel="stylesheet" type="text/css" />
    <link href="<?= site_url() ?>public/employer/css/select2.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css"/>
    <!-- App css -->
    <link href="<?= site_url() ?>public/employer/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= site_url() ?>public/employer/css/app.min.css" rel="stylesheet" type="text/css" id="light-style" />
    <link href="<?= site_url() ?>public/employer/css/custom.css" rel="stylesheet" type="text/css" id="light-style" />
    <link href="<?= site_url() ?>public/employer/css/swall.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= site_url() ?>public/employer/css/vendor/quill.bubble.css" rel="stylesheet" type="text/css" />
    <link href="<?= site_url() ?>public/employer/css/vendor/quill.core.css" rel="stylesheet" type="text/css" />
    <link href="<?= site_url() ?>public/employer/css/vendor/quill.snow.css" rel="stylesheet" type="text/css" />
    <link href="<?= site_url() ?>public/employer/css/daterangepicker.css" rel="stylesheet" type="text/css" />
    <link href="<?= site_url() ?>public/employer/css/intlTelInput.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="<?= site_url('public/global/print/print/src/print.min.css') ?>">
    <link rel="stylesheet" href="<?= site_url('/public/employer/css/countdown.css') ?>">
    

</head>

<body class="loading" data-layout-config='{"leftSideBarTheme":"dark","layoutBoxed":false, "leftSidebarCondensed":false, "leftSidebarScrollable":true,"darkMode":false, "showRightSidebarOnStart": true}'>
    <!-- Pre-loader -->

    <div id="preloader">
        <div id="status">
            <div class="bouncing-loader"><div ></div><div ></div><div ></div></div>
        </div>
    </div>

    <!-- End Preloader-->

    <div class="wrapper">

        <div class="leftside-menu">
            <a href="<?= site_url('head-office/dashboard') ?>" class="logo text-center logo-light">
                <span class="logo-lg admin-logo-block">
                    <img class="admin-logo" src="<?= site_url('public/upload/settings/').config('SiteConfig')->general['LOGO'] ?>" alt="" width="100%">
                </span>
                <span class="logo-sm admin-logo-block">
                    <img class="admin-logo" src="<?= site_url() ?>public/upload/settings/logo.png" alt="" height="16">
                </span>
            </a>
            <a href="index.html" class="logo text-center logo-dark">
                <span class="logo-lg">
                    <img src="<?= site_url() ?>public/upload/settings/logo.png" alt="" height="16">
                </span>
                <span class="logo-sm">
                    <img src="<?= site_url() ?>public/upload/settings/logo.png" alt="" height="16">
                </span>
            </a>
            <div class="h-100" id="leftside-menu-container" data-simplebar>
                <ul class="side-nav">
                    <br>
                  
                     <li class="side-nav-item">
                        <a  href="/employer/student-lists"  class="side-nav-link">
                            <i class="fa-solid fa-user-graduate"></i>
                            <span class="badge bg-success float-end"></span>
                            <span> Students </span>
                        </a>
                    </li>

                  

                </ul>
                <div class="clearfix"></div>
            </div>
        </div>

        <div class="content-page">
            <div class="content">
                <div class="navbar-custom">
                    <ul class="list-unstyled topbar-menu float-end mb-0">
                        <li class="dropdown notification-list">
                            <a class="nav-link dropdown-toggle nav-user arrow-none me-0" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false"
                            aria-expanded="false">
                            <span>
                                <span class="account-user-name">Employer</span>
                                <span class="account-position">Admin</span>
                            </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated topbar-dropdown-menu profile-dropdown">
                            <div class=" dropdown-header noti-title">
                                <h6 class="text-overflow m-0">Welcome !</h6>
                            </div>
                            <a href="javascript:void(0);" class="dropdown-item notify-item change-password" data-delete="<?= $this->session->empData['id'] ?>">
                                <i class="mdi mdi-lock-outline me-1"></i>
                                <span>Update Password</span>
                            </a>
                            <a href="<?php echo base_url('/logout'); ?>" class="dropdown-item notify-item">
                                <i class="mdi mdi-logout me-1"></i>
                                <span>Logout</span>
                            </a>
                        </div>
                    </li>
                </ul>
                <button class="button-menu-mobile open-left">
                    <i class="mdi mdi-menu"></i>
                </button>
            </div>


            <div id="change-password-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="dark-header-modalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header modal-colored-header bg-dark">
                            <h4 class="modal-title" id="dark-header-modalLabel">Change Password</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                        </div>
                        <div class="modal-body">
                            <form action="" id="form-change-password">
                                <div class="mb-3">
                                    <label for="">Password <span class="text-danger">*</span></label>
                                    <input type="text" name="password" placeholder=" Enter password" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label for="">Confirm Password <span class="text-danger">*</span></label>
                                    <input type="text" name="confirm_pwd" placeholder="Enter confirm password" class="form-control">
                                </div>
                                <?= csrf_field(); ?>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-dark btn-change-password">Save</button>
                        </div>
                    </div>
                </div>
            </div>