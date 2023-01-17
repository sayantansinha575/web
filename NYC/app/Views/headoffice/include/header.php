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
    <link href="<?= site_url() ?>public/headoffice/css/vendor/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <!-- third party css end -->
    <!-- third party css -->
    <link href="<?= site_url() ?>public/headoffice/css/vendor/dataTables.bootstrap5.css" rel="stylesheet" type="text/css" />
    <link href="<?= site_url() ?>public/headoffice/css/vendor/responsive.bootstrap5.css" rel="stylesheet" type="text/css" />
    <link href="<?= site_url() ?>public/headoffice/css/vendor/buttons.bootstrap5.css" rel="stylesheet" type="text/css" />
    <link href="<?= site_url() ?>public/headoffice/css/vendor/select.bootstrap5.css" rel="stylesheet" type="text/css" />
    <link href="<?= site_url() ?>public/headoffice/css/select2.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css"/>
    <!-- App css -->
    <link href="<?= site_url() ?>public/headoffice/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= site_url() ?>public/headoffice/css/app.min.css" rel="stylesheet" type="text/css" id="light-style" />
    <link href="<?= site_url() ?>public/headoffice/css/custom.css" rel="stylesheet" type="text/css" id="light-style" />
    <link href="<?= site_url() ?>public/headoffice/css/swall.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= site_url() ?>public/headoffice/css/vendor/quill.bubble.css" rel="stylesheet" type="text/css" />
    <link href="<?= site_url() ?>public/headoffice/css/vendor/quill.core.css" rel="stylesheet" type="text/css" />
    <link href="<?= site_url() ?>public/headoffice/css/vendor/quill.snow.css" rel="stylesheet" type="text/css" />
    <link href="<?= site_url() ?>public/headoffice/css/daterangepicker.css" rel="stylesheet" type="text/css" />
    <link href="<?= site_url() ?>public/headoffice/css/intlTelInput.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="<?= site_url('public/global/print/print/src/print.min.css') ?>">
    <link rel="stylesheet" href="<?= site_url('/public/headoffice/css/countdown.css') ?>">
    

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
                        <a  href="<?= site_url('head-office/dashboard') ?>"  class="side-nav-link">
                            <i class="uil-home-alt"></i>
                            <span class="badge bg-success float-end"></span>
                            <span> Dashboards </span>
                        </a>
                    </li>

                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#sidebarBranch" aria-expanded="false" aria-controls="sidebarBranch" class="side-nav-link collapsed">
                            <i class="fa-solid fa-code-branch"></i>
                            <span> Branch </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarBranch" style="">
                            <ul class="side-nav-second-level">
                                <li>
                                    <a href="/head-office/branch/add-branch">Add Branch</a>
                                </li>
                                <li>
                                    <a href="/head-office/branch">Manage Branch</a>
                                </li>
                                <li>
                                    <a href="/head-office/auth-letter">Auth Letter</a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#sidebarStudent" aria-expanded="false" aria-controls="sidebarStudent" class="side-nav-link collapsed">
                            <i class="fa-solid fa-user-graduate"></i>
                            <span> Student </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarStudent" style="">
                            <ul class="side-nav-second-level">
                                <li>
                                    <a href="/head-office/student">Manage Student</a>
                                </li>
                                <li>
                                    <a href="/head-office/student/manage-admission">Manage Admission</a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#sidebarCourse" aria-expanded="false" aria-controls="sidebarCourse" class="side-nav-link collapsed">
                            <i class="fa-solid fa-server"></i>
                            <span> Course </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarCourse" style="">
                            <ul class="side-nav-second-level">
                                <li>
                                    <a href="/head-office/course/add-course">Add Course</a>
                                </li>
                                <li>
                                    <a href="/head-office/course">Manage Course</a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#sidebarDocument" aria-expanded="false" aria-controls="sidebarDocument" class="side-nav-link collapsed">
                            <i class="fa-solid fa-file-pdf"></i>
                            <span> Documents </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarDocument" style="">
                            <ul class="side-nav-second-level">
                                <li>
                                    <a href="/head-office/document/study-materials">Study Material</a>
                                <li>
                                <li>
                                    <a href="/head-office/document/branch-document">Branch Document</a>
                                <li>
                            </ul>
                        </div>
                    </li>

                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#sidebarWallet" aria-expanded="false" aria-controls="sidebarWallet" class="side-nav-link collapsed">
                            <i class="fa-solid fa-wallet"></i>
                            <span> Wallet </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarWallet" style="">
                            <ul class="side-nav-second-level">
                                <li>
                                    <a href="/head-office/wallet/add-transaction">Add Transaction</a>
                                </li>
                                <li>
                                    <a href="/head-office/wallet">Manage Wallet</a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#sidebarPayment" aria-expanded="false" aria-controls="sidebarPayment" class="side-nav-link collapsed">
                            <i class="fa-solid fa-money-check-dollar"></i>
                            <span> Payment </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarPayment" style="">
                            <ul class="side-nav-second-level">
                                <li>
                                    <a href="/head-office/payment">Manage Transaction</a>
                                <li>
                            </ul>
                        </div>
                    </li>

               
                    <li class="side-nav-item">
                        <a  href="<?= site_url('head-office/admit') ?>"  class="side-nav-link">
                           <i class="fa-solid fa-address-card"></i>
                            <span class="badge bg-success float-end"></span>
                            <span> Manage Admits </span>
                        </a>
                    </li>

                    <li class="side-nav-item">
                        <a  href="<?= site_url('head-office/marksheet') ?>"  class="side-nav-link">
                            <i class="fa-solid fa-chalkboard-user"></i>
                            <span class="badge bg-success float-end"></span>
                            <span> Manage Marksheet </span>
                        </a>
                    </li>

                    <li class="side-nav-item">
                        <a  href="<?= site_url('head-office/certificate') ?>"  class="side-nav-link">
                            <i class="uil-book-alt"></i>
                            <span class="badge bg-success float-end"></span>
                            <span> Manage Certificate </span>
                        </a>
                    </li>

                    <li class="side-nav-item">
                        <a  href="<?= site_url('head-office/print-pdf') ?>"  class="side-nav-link">
                            <i class="fa-regular fa-file-pdf"></i>
                            <span class="badge bg-success float-end"></span>
                            <span> Print Combined PDF </span>
                        </a>
                    </li>
                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#exam-module-section" aria-expanded="false" aria-controls="sidebarSettings" class="side-nav-link collapsed">
                           <i class="uil-book-alt"></i>
                            <span> Exam Module </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="exam-module-section" style="">
                            <ul class="side-nav-second-level">
                                <li>
                                    <a href="/head-office/exam">Exam Setup</a>
                                <li>
                               
                            </ul>
                        </div>
                    </li>
                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#sidebarSettings" aria-expanded="false" aria-controls="sidebarSettings" class="side-nav-link collapsed">
                           <i class="fa-solid fa-gear fa-spin"></i>
                            <span> Settings </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarSettings" style="">
                            <ul class="side-nav-second-level">
                                <li>
                                    <a href="/head-office/setting">General Setting</a>
                                <li>
                                <li>
                                    <a href="/head-office/setting/media-setting">Media Setting</a>
                                <li>
                                <li>
                                    <a href="/head-office/setting/certificate-marksheet-setting">Certificate & Marksheet</a>
                                <li>
                                <li>
                                    <a href="/head-office/setting/meta-tags-setting">Meta Setting</a>
                                <li>
                            </ul>
                        </div>
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
                                <span class="account-user-name"><?= $this->session->userData['name'] ?></span>
                                <span class="account-position">Admin</span>
                            </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated topbar-dropdown-menu profile-dropdown">
                            <div class=" dropdown-header noti-title">
                                <h6 class="text-overflow m-0">Welcome !</h6>
                            </div>
                            <a href="javascript:void(0);" class="dropdown-item notify-item change-password" data-delete="<?= $this->session->userData['id'] ?>">
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