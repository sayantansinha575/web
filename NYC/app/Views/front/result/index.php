<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<title>National Youth Computer Training Academy</title>
<link rel="icon" href="favicon.ico" type="image/x-icon">
<link rel="stylesheet" href="<?= site_url('public/front/plugins/bootstrap/css/bootstrap.min.css') ?>">
<link rel="stylesheet" href="<?= site_url('public/front/icon?family=Material+Icons') ?>">
<link rel="stylesheet" href="<?= site_url('public/front/css/main.css') ?>">
<link href="<?= site_url('public/front/css/login.css') ?>" rel="stylesheet">

<link rel="stylesheet" href="<?= site_url('public/front/css/themes/all-themes.css') ?>">
<style>
    #sign_up span{font-size:12px;}
</style>
</head>
<?php 
    $this->session = \Config\Services::session(); 
    $validation = \Config\Services::validation();
?>
<body class="login-page authentication">
<div class="container">
    <div class="card">
        <img src="/public/front/images/nycta-header-image.jpg" style="width:90%;"class="rounded mx-auto d-block" class="certificate-header-section">
        <h1 class="title text-center"><u><p class="text-danger">Verify Your Certificate</p></u></h1>
        <div class="col-sm-12">
            <form id="sign_up" method="get" action="result/certificate_details">           
                <div class="input-group">
                    <div class="form-line">
                        <input type="text" class="form-control" name="cno" placeholder="Enter Certificate No*" autofocus="" value="<?= old('cno') ?>">
                        <span class="text-danger"><?= $validation->getError('cno'); ?><?= session('cno-error') ?></span>
                    </div>
                </div>
                <div class="input-group">
                    <div class="form-line">
                        <input type="text" class="form-control" name="eno" placeholder="Enter Enrollment No*" value="<?= old('eno') ?>">
                        <span class="text-danger"><?= $validation->getError('eno'); ?><?= session('eno-error') ?></span>
                    </div>
                </div>
                <div class="input-group">
                    <div class="form-line">
                        <input type="text" class="form-control" name="fname"  placeholder="Enter Father's Name*" value="<?= old('fname') ?>">
                        <span class="text-danger"><?= $validation->getError('fname'); ?><?= session('fname-error') ?></span>
                    </div>
                </div>
                <input type="checkbox" name="before_june" id="before_june" class="chk-col-light-blue" value="1">
                <label for="before_june"><strong><p class="text-danger"><U>Click this box, if you were certified before JULY 2022.</U></p></strong></label>
                <div class="text-center">
                    <button type="submit"class="btn btn-raised g-bg-blush2 waves-effect">Verify Your Certificate</button>
                </div>
            </form>
        </div>
    </div>  
</div>

<script src="<?= site_url('public/front/css/bundles/libscripts.bundle.js') ?>"></script> <!-- Lib Scripts Plugin Js -->
<script src="<?= site_url('public/front/css/bundles/vendorscripts.bundle.js') ?>"></script> <!-- Lib Scripts Plugin Js -->
<script src="<?= site_url('public/front/css/bundles/mainscripts.bundle.js') ?>"></script><!-- Custom Js --> 
</body>
</html>
