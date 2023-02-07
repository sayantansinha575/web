<?= $this->extend($config->authLayout) ?>
<?= $this->section('content') ?>
<section class="flexbox-container">
    <div class="col-12 d-flex align-items-center justify-content-center">
        <div class="col-lg-4 col-md-6 col-10 box-shadow-2 p-0">
            <div class="card border-grey border-lighten-3 px-1 py-1 m-0">
                <div class="card-header border-0">
                    <div class="text-center mb-1">
                        <img src="<?= ADMIN_ASSETS ?>images/logo/logo.png" alt="branding logo">
                    </div>
                    <div class="font-large-1  text-center">                       
                        Raj Edu Member Login
                    </div>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form class="form-horizontal" action="<?= site_url('login') ?>" id="login-form">
                            <fieldset class="form-group position-relative has-icon-left">
                                <input type="text" class="form-control round" id="username" name="username" placeholder="Your Username...">
                                <div class="form-control-position">
                                    <i class="ft-user"></i>
                                </div>
                                <div class="error-feedback"></div>
                            </fieldset>
                            <fieldset class="form-group position-relative has-icon-left">
                                <input type="password" class="form-control round" id="password" name="password" placeholder="Enter Password...">
                                <div class="form-control-position">
                                    <i class="ft-lock"></i>
                                </div>
                                <div class="error-feedback"></div>
                            </fieldset>
                            <div class="form-group row">
                                <div class="col-md-6 col-12 text-center text-sm-left">

                                </div>
                                <div class="col-md-6 col-12 float-sm-left text-center text-sm-right"><a href="recover-password.php" class="card-link">Forgot Password?</a></div>
                            </div>
                            <div class="form-group">
                                <div id="form-feedback" class="error-feedback"></div>
                            </div>
                            <div class="form-group text-center">
                                <?= csrf_field(); ?>
                                <button type="submit" class="btn round btn-block btn-glow btn-bg-gradient-x-purple-blue col-12 mr-1 mb-1" id="login-submit">Login</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->section('js') ?>
    <script src="<?= ADMIN_ASSETS ?>js/pages/auth/login.js?v=<?= filemtime('assets/js/pages/auth/login.js') ?>"></script>
<?= $this->endSection() ?>
<?= $this->endSection() ?>
