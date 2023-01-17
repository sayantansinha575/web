<!DOCTYPE html>
<html>
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=Edge">
   <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
   <meta name="title" content="<?= config('SiteConfig')->meta['TITLE'] ?>">
   <meta name="description" content="<?= config('SiteConfig')->meta['DESCRIPTION'] ?>">
   <meta name="robots" content="noindex,nofollow">
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
   <meta name="language" content="English">
   <meta name="author" content="NYCTA">
   <link rel="apple-touch-icon" sizes="180x180" href="<?= site_url('public/upload/settings/').config('SiteConfig')->general['APPLE_TOUCH_ICON'] ?>">
   <link rel="icon" type="image/png" sizes="32x32" href="<?= site_url('public/upload/settings/').config('SiteConfig')->general['FAV_ICON_32'] ?>">
   <link rel="icon" type="image/png" sizes="16x16" href="<?= site_url('public/upload/settings/').config('SiteConfig')->general['FAV_ICON_16'] ?>">
   <title><?= $title.' || '.config('SiteConfig')->general['PAGE_TITLE']; ?></title>
   <link rel="icon" href="favicon.ico" type="image/x-icon">
   <link rel="stylesheet" href="<?= site_url('public/student/') ?>plugins/bootstrap/css/bootstrap.min.css">
   <link rel="stylesheet" href="<?= site_url('public/student/icon/') ?>icon?family=Material+Icons">
   <link href="<?= site_url('public/student/') ?>plugins/jquery-datatable/dataTables.bootstrap4.min.css" rel="stylesheet">
   <link href="<?= site_url('public/student/plugins/select2/select2.min.css') ?>" rel="stylesheet">
   <link href="<?= site_url('public/student/css/custom.css') ?>" rel="stylesheet">

   <link rel="stylesheet" href="<?= site_url('public/student/') ?>css/main.css">

   <link rel="stylesheet" href="<?= site_url('public/student/') ?>css/themes/all-themes.css">
   
</head>

<body class="theme-blush">

   <div class="page-loader-wrapper">
      <div class="loader">
         <div class="preloader">
            <div class="spinner-layer pl-blush">
               <div class="circle-clipper left">
                  <div class="circle"></div>
               </div>
               <div class="circle-clipper right">
                  <div class="circle"></div>
               </div>
            </div>
         </div>
         <p>Please wait...</p>
      </div>
   </div>


   </div>
<?php 
$academy_name = '';
$academy_name =  fieldValue('branch','academy_name', array('id'=>$this->session->studData['branchId'])); 
?>

   <nav class="navbar clearHeader">
      <div class="col-12">
         <div class="navbar-header"> 
            <a href="javascript:void(0);" class="bars"></a> <a class="navbar-brand" href="<?= site_url('student/dashboard') ?>"><?php echo $academy_name ; ?></a> </div>
         
      </div>
   </nav>


