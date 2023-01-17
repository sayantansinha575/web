<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="title" content="<?= config('SiteConfig')->meta['TITLE'] ?>">
        <meta name="description" content="<?= config('SiteConfig')->meta['DESCRIPTION'] ?>">
        <meta name="robots" content="noindex,nofollow">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="language" content="English">
        <meta name="author" content="NYCTA">
        <title>Branch :: National Youth Computer Training Academy</title>
         
        <!-- Custom CSS -->
        <link href="<?= site_url('public/branch') ?>/css/styles.css" rel="stylesheet">
          <link href="<?= site_url() ?>public/global.css" rel="stylesheet" type="text/css" />

    </head>
    
    <body>
        <div id="main-wrapper" >
            <div class="clearfix"></div>
            <section>
                <div class="container">
                    <div class="row justify-content-center branch-login">
                    
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                            <form method="POST" action="<?= site_url('branch'); ?>" accept-charset="UTF-8">
                                <div class="crs_log_wrap">
                                    <div class="crs_log__caption">
                                        <div class="rcs_log_123">
                                            <div class="rcs_ico "><img src="<?= site_url() ?>public/branch/img/nycta-header-image.jpg" alt="" width="60px"></div>
                                        </div>
                                        
                                        <div class="rcs_log_124 pb-5">
                                            <div class="Lpo09">
                                                <h4>ASSOCIATE LOGIN</h4>
                                                
                                            </div>
                                            <div class="form-group pb-2">
                                                <label>User Name</label>
                                                <input type="text" name="email" class="form-control" placeholder="user@example.com" value="<?= old('email') ?>">
                                            </div>
                                            <div class="form-group pb-2">
                                                <label>Password</label>
                                                <input type="password" name="password" class="form-control" placeholder="*******">
                                            </div>
                                            <div class="form-grouppb-2">
                                                <?= csrf_field(); ?>
                                                <button type="submit" class="btn full-width btn-sm theme-bg text-white">Login</button>
                                            </div>
                                            <?= view('Auth\Views\_notifications') ?>
                                        </div>
                                    </div>
                                    <div class="crs_log__footer d-flex justify-content-between">
                                        <div class="fhg_45"><p class="musrt"><a href="<?= site_url('branch/forgot-password') ?>" class="text-danger">Forgot Password?</a></p></div>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </section>
            

        </div>
        <!-- ============================================================== -->
        <!-- End Wrapper -->
        <!-- ============================================================== -->

        <!-- ============================================================== -->
        <!-- All Jquery -->
        <!-- ============================================================== -->
        <script src="<?= site_url('public/branch') ?>/js/jquery.min.js"></script>
        <script src="<?= site_url('public/branch') ?>/js/popper.min.js"></script>
        <script src="<?= site_url('public/branch') ?>/js/bootstrap.min.js"></script>
        <script src="<?= site_url('public/branch') ?>/js/select2.min.js"></script>
        <script src="<?= site_url('public/branch') ?>/js/slick.js"></script>
        <script src="<?= site_url('public/branch') ?>/js/moment.min.js"></script>
        <script src="<?= site_url('public/branch') ?>/js/daterangepicker.js"></script> 
        <script src="<?= site_url('public/branch') ?>/js/summernote.min.js"></script>
        <script src="<?= site_url('public/branch') ?>/js/metisMenu.min.js"></script>  
        <script src="<?= site_url('public/branch') ?>/js/custom.js"></script>

    </body>
</html>

<style>
body{
background-image: url(<?= site_url('public/branch/img/')?>branch-background.jpg);
    background-size: cover;
    background-position: top center;
}
</style>
<script type="text/javascript">
$(document).ready(function(){

    var h = $(window).height();
    $('body').css("height", h);

})
</script>