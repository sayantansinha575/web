<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="author" content="LoopCode">
        <meta name="viewport" content="width=device-width, initial-scale=1">
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
                            <form method="POST" action="<?= site_url('branch/reset-password'); ?>" accept-charset="UTF-8">
                                <div class="crs_log_wrap">
                                    <div class="crs_log__caption">
                                        <div class="rcs_log_123">
                                            <div class="rcs_ico "><img src="<?= site_url() ?>public/branch/img/nycta-header-image.jpg" alt="" width="60px"></div>
                                        </div>
                                        
                                        <div class="rcs_log_124 pb-5">
                                            <div class="Lpo09">
                                                <h4>SET NEW PASSWORD</h4>
                                                
                                            </div>
                                            <div class="form-group pb-2">
                                                <label>New Pasword</label>
                                                <input type="password" name="password" class="form-control" placeholder="*******">
                                            </div>
                                            <div class="form-group pb-2">
                                                <label>Confirm Password</label>
                                                <input type="password" name="password_confirm" class="form-control" placeholder="*******">
                                            </div>
                                            <div class="form-grouppb-2">
                                                <?= csrf_field(); ?>
                                                <input type="hidden" name="token" value="<?= $_GET['token'] ?>" />
                                                <button type="submit" class="btn full-width btn-sm theme-bg text-white">Save</button>
                                            </div>
                                            <?= view('Auth\Views\_notifications') ?>
                                        </div>
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