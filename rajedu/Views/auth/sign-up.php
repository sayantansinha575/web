<?= $this->extend($config->authLayout) ?>
<?= $this->section('content') ?>
<div class="d-flex flex-column flex-root" id="kt_app_page">	
	<div class="d-flex flex-column flex-lg-row flex-column-fluid">		
		<div class="d-flex flex-column flex-lg-row-auto bg-primary w-xl-600px positon-xl-relative">			
			<div class="d-flex flex-column position-xl-fixed top-0 bottom-0 w-xl-600px scroll-y">				
				<div class="d-flex flex-row-fluid flex-column text-center p-10 pt-lg-20">					
					<a href="<?= site_url() ?>" class="py-9 pt-lg-20">
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
				<div class="w-lg-600px p-10 p-lg-15 mx-auto">					
					<form class="form w-100" novalidate="novalidate" id="sign-up-form">						
						<div class="mb-10 text-center">							
							<h1 class="text-dark mb-3">Create an Account</h1>														
							<div class="text-gray-400 fw-bold fs-4">Already have an account? 
							<a href="/login" class="link-primary fw-bolder">Sign in here</a></div>							
						</div>											
						<div class="row fv-row mb-7">							
							<div class="col-xl-6 field-holder">
								<label class="form-label fw-bolder text-dark fs-6">First Name</label>
								<input class="form-control form-control-lg form-control-solid" type="text" placeholder="" name="first-name" id="first-name" autocomplete="off">
								<div class="fv-plugins-message-container invalid-feedback"></div>
							</div>														
							<div class="col-xl-6 field-holder">
								<label class="form-label fw-bolder text-dark fs-6">Last Name</label>
								<input class="form-control form-control-lg form-control-solid" type="text" placeholder="" name="last-name" id="last-name" autocomplete="off">
								<div class="fv-plugins-message-container invalid-feedback"></div>
							</div>							
						</div>												
						<div class="fv-row mb-7 field-holder">
							<label class="form-label fw-bolder text-dark fs-6">Email</label>
							<input class="form-control form-control-lg form-control-solid" type="email" placeholder="" name="email" id="email" autocomplete="off">
							<div class="fv-plugins-message-container invalid-feedback"></div>
						</div>												
						<div class="mb-10 fv-row field-holder" data-it-password-meter="true">							
							<div class="mb-1">								
								<label class="form-label fw-bolder text-dark fs-6">Password</label>																
								<div class="position-relative mb-3">
									<input class="form-control form-control-lg form-control-solid" type="password" placeholder="" name="password" autocomplete id="password" autocomplete="off">
									<span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2" data-it-password-meter-control="visibility">
										<i class="bi bi-eye-slash fs-2"></i>
										<i class="bi bi-eye fs-2 d-none"></i>
									</span>
								</div>																
								<div class="d-flex align-items-center mb-3" data-it-password-meter-control="highlight">
									<div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
									<div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
									<div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
									<div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px"></div>
								</div>								
							</div>														
							<div class="text-muted">Use 8 or more characters with a mix of letters, numbers &amp; symbols.</div>
                            <div class="fv-plugins-message-container invalid-feedback"></div>							
						</div>												
						<div class="fv-row mb-5 field-holder">
							<label class="form-label fw-bolder text-dark fs-6">Confirm Password</label>
							<input class="form-control form-control-lg form-control-solid" type="password" placeholder="" name="confirm-password" id="confirm-password" autocomplete="off">
                            <div class="fv-plugins-message-container invalid-feedback"></div>
						</div>												
						<div class="fv-row mb-10 field-holder">
							<label class="form-check form-check-custom form-check-solid form-check-inline">
								<input class="form-check-input" type="checkbox" name="toc" id="toc" value="1">
								<span class="form-check-label fw-bold text-gray-700 fs-6">I Agree 
								<a href="#" class="ms-1 link-primary">Terms and conditions</a>.</span>
							</label>
                            <div class="fv-plugins-message-container invalid-feedback"></div>
						</div>
						<div class="fv-row">
                            <div class="fv-plugins-message-container invalid-feedback form-feedback"></div>
                        </div>												
						<div class="text-center">
							<button type="submit" id="sign-up-submit" class="btn btn-lg btn-primary">
								<span class="indicator-label">Submit</span>
								<span class="indicator-progress">Please wait... 
								<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
							</button>
						</div>	
						<?= csrf_field(); ?>					
					</form>					
				</div>				
			</div>									
		</div>		
	</div>	
</div>
<?= $this->section('js') ?>
<script src="<?= ADMIN_ASSETS ?>assets/js/custom/authentication/sign-up/general.js"></script>
<?= $this->endSection() ?>
<?= $this->endSection() ?>