<?php $this->session = \Config\Services::session(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="author" content="LoopCode">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $title ?> :: National Youth Computer Training Academy</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css"/>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <link href="<?= site_url('public/branch') ?>/css/styles.css" rel="stylesheet">
    <link href="<?= site_url() ?>/css/plugins/intlTelInput.min.css" rel="stylesheet">
 <link href="<?= site_url() ?>public/global.css" rel="stylesheet" type="text/css" />
 <link href="<?= site_url('public/branch') ?>/css/branch.css" rel="stylesheet" type="text/css" />
</head>

<body>
    <div id="main-wrapper">
        <div class="header header-light">
            <div class="container-fluid">
                <nav id="navigation" class="navigation navigation-landscape">

                    <div class="nav-header">
                       <img style="display:none;" src="https://ctc.phpblog.site/public/upload/settings/logo.png" class="logo sticky-header-logo" alt="NYCTA">
                        <div class="nav-toggle"></div>
                        <div class="mobile_nav" >
                            <ul>
                                 <li class="account-drop">
                                <a href="javascript:void(0);" class="crs_yuo12" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="embos_45"><span><?= renewalDateLeft(); ?></span>
                                </a>
                            </li>
                                <li class="account-drop">
                                    <a href="javascript:void(0);" class="crs_yuo12" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span class="embos_45"><i class="fa-solid fa-wallet"></i> <span> <i class="fa-solid fa-rupee-sign"></i><?= number_format(getWalletBalance()); ?></span>
                                    </a>
                                </li>
                                <li>
                                    <div class="btn-group account-drop">
                                        <a href="javascript:void(0);" class="crs_yuo12 btn btn-order-by-filt" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <img src="<?= site_url('public/upload/files/branch/branch-image/').$this->session->branchData['branch_image'] ?>" class="avater-img" alt="NYCTA">
                                        </a>
                                        <div class="dropdown-menu pull-right animated pulse">
                                            <div class="drp_menu_headr">
                                                <h4>Hi, <?= $this->session->branchData['branch_name'] ?></h4>
                                            </div>
                                            <ul>
                                                <li><a href="<?= site_url('branch/branch-details') ?>"><i class="fa fa-university" aria-hidden="true"></i>Branch Details</a></li>                                 
                                                <li><a href="<?= site_url('branch/course/manage-course') ?>"><i class="fas fa-shopping-basket"></i>Manage Courses<span class="notti_coun style-2"><?= activeBranchCourseCount(); ?></span></a></li>
                                                <li><a href="<?= site_url('branch/student') ?>"><i class="fa fa-envelope"></i>Manage Students<span class="notti_coun style-3"><?= branchSudentCount() ?></span></a></li>
                                                <li><a href="javascript:void(0)" class="change-password" data-pwd="<?= encrypt($this->session->branchData['id']) ?>"><i class="fas fa-fingerprint"></i>Change Password</a></li>
                                                <li><a href="<?= site_url('branch-signout') ?>"><i class="fa fa-unlock-alt"></i>Sign Out</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="nav-menus-wrapper" style="transition-property: none;">  

                    <?= view('branch/include/mobile-sidebar'); ?>


                        <ul class="nav-menu nav-menu-social align-to-right">
                             <li class="account-drop">
                                <a href="javascript:void(0);" class="crs_yuo12" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="embos_45"><span><?= renewalDateLeft(); ?></span>
                                </a>
                            </li>
                             <li class="account-drop">
                                    <a href="javascript:void(0);" class="crs_yuo12" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span class="embos_45"><i class="fa-solid fa-wallet"></i> <span> <i class="fa-solid fa-rupee-sign"></i><?= number_format(getWalletBalance()); ?></span>
                                    </a>
                                </li>
                            <li>
                                <div class="btn-group account-drop">
                                    <a href="javascript:void(0);" class="crs_yuo12 btn btn-order-by-filt" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <img src="<?= site_url('public/upload/files/branch/branch-image/').$this->session->branchData['branch_image'] ?>" class="avater-img" alt="NYCTA">
                                    </a>
                                    <div class="dropdown-menu pull-right animated pulse">
                                        <div class="drp_menu_headr">
                                            <h4>Hi, <?= $this->session->branchData['branch_name'] ?></h4>
                                        </div>
                                        <ul>
                                            <li><a href="<?= site_url('branch/branch-details') ?>"><i class="fa fa-university" aria-hidden="true"></i>Branch Details</a></li>                                 
                                            <li><a href="<?= site_url('branch/course/manage-course') ?>"><i class="fas fa-shopping-basket"></i>Manage Courses<span class="notti_coun style-2"><?= activeBranchCourseCount(); ?></span></a><li>
                                            <li><a href="<?= site_url('branch/student') ?>"><i class="fa fa-envelope"></i>Manage Students<span class="notti_coun style-3"><?= branchSudentCount() ?></span></a></li>
                                            <li><a href="javascript:void(0)" class="change-password" data-pwd="<?= encrypt($this->session->branchData['id']) ?>"><i class="fas fa-fingerprint"></i>Change Password</a></li>
                                            <li><a href="<?= site_url('branch-signout') ?>"><i class="fa fa-unlock-alt"></i>Sign Out</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>

        <div class="modal fade" id="change-password-modal" tabindex="-1" role="dialog" aria-labelledby="change-password-modalTitle" aria-hidden="true">
         <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLongTitle">Change Password</h5>
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
      
        <div class="clearfix"></div>
        <section class="gray pt-0 main-div">
            <div class="container-fluid">
                <div class="row">