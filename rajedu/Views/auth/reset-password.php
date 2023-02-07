<?= $this->extend($config->authLayout) ?>
<?= $this->section('content') ?>
<div class="d-flex flex-column flex-root" id="kt_app_page">	
	<div class="d-flex flex-column flex-lg-row flex-column-fluid">		
		<div class="d-flex flex-column flex-lg-row-auto bg-primary w-xl-600px positon-xl-relative">			
			<div class="d-flex flex-column position-xl-fixed top-0 bottom-0 w-xl-600px scroll-y">				
				<div class="d-flex flex-row-fluid flex-column text-center p-10 pt-lg-20">					
					<a href="<?= site_url('dashboard') ?>" class="py-9 pt-lg-20">
						<img alt="Logo" src="<?= ADMIN_ASSETS ?>assets/media/logos/default.svg" class="h-40px">
					</a>										
					<h1 class="fw-bolder text-white fs-2qx pb-5 pb-md-10">Welcome to Invest</h1>										
					<p class="fw-bold fs-2 text-white">Plan your blog post by choosing a topic creating 
					<br>an outline and checking facts</p>					
				</div>								
				<div class="d-flex flex-row-auto bgi-no-repeat bgi-position-x-center bgi-size-contain bgi-position-y-bottom min-h-100px min-h-lg-350px" style="background-image: url(<?= ADMIN_ASSETS ?>assets/media/illustrations/sketchy-1/2.png)"></div>				
			</div>			
		</div>				
		<div class="d-flex flex-column flex-lg-row-fluid py-10">			
			<div class="d-flex flex-center flex-column flex-column-fluid">				
				<div class="w-lg-500px p-10 p-lg-15 mx-auto">					
					<form class="form w-100" novalidate="novalidate" action="<?= site_url('password-reset-verification') ?>" id="password-reset-form">						
						<div class="text-center mb-10">							
							<h1 class="text-dark mb-3">Forgot Password ?</h1>														
							<div class="text-gray-400 fw-bold fs-4">Enter your email to reset your password.</div>							
						</div>												
						<div class="fv-row mb-10 field-holder">
							<label class="form-label fw-bolder text-gray-900 fs-6">Email</label>
							<input class="form-control form-control-solid" type="email" placeholder="" name="email" id="email" autocomplete="off">
							<div class="fv-plugins-message-container invalid-feedback"></div>
						</div>	
						<div class="fv-row">
                            <div class="fv-plugins-message-container invalid-feedback form-feedback"></div>
                        </div>												
						<div class="d-flex flex-wrap justify-content-center pb-lg-0">
							<button type="submit" id="password-reset-submit" class="btn btn-lg btn-primary fw-bolder me-4">
								<span class="indicator-label">Submit</span>
								<span class="indicator-progress">Please wait... 
								<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
							</button>
							<a href="/login" class="btn btn-lg btn-light-primary fw-bolder">Cancel</a>
						</div>
						<?= csrf_field(); ?>						
					</form>					
				</div>				
			</div>								
		</div>		
	</div>	
</div>
<?= $this->section('js') ?>
<script src="<?= ADMIN_ASSETS ?>assets/js/custom/authentication/password-reset/password-reset.js"></script>
<?= $this->endSection() ?>
<?= $this->endSection() ?>