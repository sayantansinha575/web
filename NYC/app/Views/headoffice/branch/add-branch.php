<?= $this->extend('headoffice/layOut'); ?>
<?= $this->section('body') ?>
<div class="container-fluid">

	<!-- start page title -->
	<div class="row">
		<div class="col-12">
			<div class="page-title-box">
				<div class="page-title-right">
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="/head-office/branch">Branch</a></li>
						<li class="breadcrumb-item active"><?= empty($details)?'Add':'Edit'; ?> Branch</li>
					</ol>
				</div>
				<h4 class="page-title"><?= $title; ?></h4>
			</div>
		</div>
	</div>     
	<!-- end page title --> 

	
	<form action="<?= site_url('head-office/branch/add-branch'.$id); ?>" id="formBranch" accept-charset="UTF-8" autocomplete="off">
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-body">	
						<h4 class="header-title">Branch Details</h4><hr>
						<br>
						<div class="row">
							<div class="col-md-6 mb-3">
								<label class="form-label">Branch Name <span class="text-danger">*</span></label>
								<input type="text" class="form-control" name="branch_name" id="branch_name" placeholder="Enter branch name" value="<?= ($details)?$details->branch_name:''; ?>">
							</div>
							<div class="col-md-6 mb-3">
								<label class="form-label">Branch Head <span class="text-danger">*</span></label>
								<input type="text" class="form-control" name="branch_head" id="branch_head" placeholder="Enter branch head" value="<?= ($details)?$details->branch_head:''; ?>">
							</div>
							<div class="col-md-6 mb-3">
								<label class="form-label">Branch Email <span class="text-danger">*</span></label>
								<input type="text" class="form-control" name="branch_email" id="branch_email" placeholder="Enter branch email" value="<?= ($details)?$details->branch_email:''; ?>">
							</div>

							<div class="col-md-3 mb-3">
								<label class="form-label">Branch Code <span class="text-danger">*</span></label>
								<input type="text" class="form-control uppercase" name="branch_code" id="branch_code" placeholder="Enter branch code" value="<?= ($details)?$details->branch_code:''; ?>">
							</div>
							<div class="col-md-3 mb-3">
								<label class="form-label">Registration Date <span class="text-danger">*</span></label>
								<input type="text" class="form-control singleDatePicker" name="date_of_registration" id="date_of_registration" placeholder="Select Registration date" value="<?= (!empty($details->date_of_registration))?date('Y-m-d', $details->date_of_registration):''; ?>">
							</div>
							<div class="col-md-3 mb-3">
								<label class="form-label">Renewal Days Left <span class="text-danger">*</span></label>
								<input type="text" class="form-control numbers" name="renewal_days_left" id="renewal_days_left" placeholder="Enter renewal days left count" value="<?= ($details)?$details->renewal_days_left:''; ?>">
							</div>
							<div class="col-md-3 mb-3">
								<label class="form-label">Max Enroll Number </label>
								<input type="text" class="form-control numbers" name="maxEnrollNumber" id="maxEnrollNumber" placeholder="Enter max enrollment number" value="<?= ($details)?$details->maxEnrollNumber:''; ?>">
							</div>

							<h4 class="header-title">Academy Details</h4><hr>
							<br>
							<div class="col-md-6 mb-3">
								<label class="form-label">Academy Code <span class="text-danger">*</span></label>
								<input type="text" class="form-control" name="academy_code" id="academy_code" placeholder="Enter academy code" value="<?= ($details)?$details->academy_code:''; ?>">
							</div>
							<div class="col-md-6 mb-3">
								<label class="form-label">Academy Name <span class="text-danger">*</span></label>
								<input type="text" class="form-control" name="academy_name" id="academy_name" placeholder="Enter academy name" value="<?= ($details)?$details->academy_name:''; ?>">
							</div>
							<div class="col-md-6 mb-3">
								<label class="form-label">Academy Address <span class="text-danger">*</span></label>
								<textarea name="academy_address" id="academy_address"  rows="1" class="form-control" placeholder="Enter academy address"><?= ($details)?$details->academy_address:''; ?></textarea>
							</div>
							<div class="col-md-6 mb-3">
								<label class="form-label">Academy Phone <span class="text-danger">*</span></label>
								<input type="text" class="form-control"  name="academy_phone" id="academy_phone" value="<?= ($details)?$details->academy_phone:''; ?>">
							</div>

							<h4 class="header-title">Login Credentials</h4><hr>
							<br>
							<div class="col-md-4 mb-3">
								<label class="form-label">Username <span class="text-danger">*</span></label>
								<input type="text" class="form-control user-name" name="username" id="username" placeholder="Enter username" value="<?= ($details)?$details->username:''; ?>">
							</div>
							<div class="col-md-4 mb-3">
								<label class="form-label">Password  <span class="text-danger">*</span></label>
								<div class="input-group input-group-merge password-container">
									<input type="password" name="password" id="password" class="form-control" placeholder="Enter your password" value="<?= ($details)?$details->visible_pwd:''; ?>">
									<span class="input-group-text"><i class="fa-solid fa-eye toggle-password"></i></span>
									<small>Minimum length 8 and should include at least one upper case letter, one number, and one special character.</small> 
								</div>
							</div>
							<div class="col-md-4 mb-3">
								<label class="form-label">Confirm Password <span class="text-danger">*</span></label>
								<div class="input-group input-group-merge password-container">
									<input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Enter your confirm password" value="<?= ($details)?$details->visible_pwd:''; ?>">
									<span class="input-group-text"><i class="fa-solid fa-eye toggle-password"></i></span>
								</div>
							</div>

							<h4 class="header-title">Other Details</h4><hr>
							<br>
							<div class="col-md-4 mb-3">
								<label class="form-label">Invoice Prefix <span class="text-danger">*</span></label>
								<input type="text" class="form-control uppercase" name="invoice_prefix" id="invoice_prefix" placeholder="Enter invoice prefix" value="<?= ($details)?$details->invoice_prefix:''; ?>">
							</div>
							<div class="col-md-4 mb-3">
								<label class="form-label">Student Enrollment Prefix <span class="text-danger">*</span></label>
								<input type="text" class="form-control uppercase" name="student_enrollment_prefix" id="student_enrollment_prefix" placeholder="Enter enrollment prefix" value="<?= ($details)?$details->student_enrollment_prefix:''; ?>">
							</div>
							<div class="col-md-4 mb-3">
								<label class="form-label">Marksheet Prefix <span class="text-danger">*</span></label>
								<input type="text" class="form-control uppercase" name="marksheet_prefix" id="marksheet_prefix" placeholder="Enter marksheet prefix" value="<?= ($details)?$details->marksheet_prefix:''; ?>">
							</div>
							<div class="col-md-6 mb-3">
								<label class="form-label">Student Registration Prefix <span class="text-danger">*</span></label>
								<input type="text" class="form-control uppercase" name="student_registration_prefix" id="student_registration_prefix" placeholder="Enter registration prefix" value="<?= ($details)?$details->student_registration_prefix:''; ?>">
							</div>
							<div class="col-md-6 mb-3">
								<label class="form-label">Certificate Prefix <span class="text-danger">*</span></label>
								<input type="text" class="form-control uppercase" name="certificate_prefix" id="certificate_prefix" placeholder="Enter certificate prefix" value="<?= ($details)?$details->certificate_prefix:''; ?>">
							</div>
							
							<!-- <div class="col-md-6 mb-3">
								<div class="row holder">
									<div class="col-md-8">
										<label for="nycta_logo" class="form-label">NYCTA Logo <span class="text-danger">*</span></label>
										<input class="form-control imgFile" type="file" accept="image/*" id="nycta_logo" name="nycta_logo">
										<input type="hidden" name="oldNyctaLogoFile" value="<?= ($details)?$details->nycta_logo:''; ?>">
									</div>
									<div class="col-md-4 file-preview">
										<img src="<?= empty($details->nycta_logo)?site_url('public/headoffice/images/default/defaultImage.png'):site_url('public/upload/files/branch/nycta-logo/'.$details->nycta_logo); ?>" alt="preview" class="img-fluid img-responsive img-thumbnail previewImg">
									</div>
								</div>
							</div> -->
							
							<div class="col-md-6 mb-3">
								<div class="row holder">
									<div class="col-md-8">
										<label for="signature" class="form-label">Signature <small>(200 X 100 px)</small> <span class="text-danger">*</span></label>
										<input class="form-control imgFile twohundredXhundred" type="file" accept="image/*" id="signature" name="signature">
										<input type="hidden" name="oldSignFile" value="<?= ($details)?$details->signature:''; ?>">
									</div>
									<div class="col-md-4 file-preview">
										<img src="<?= empty($details->signature)?site_url('public/headoffice/images/default/defaultImage.png'):site_url('public/upload/files/branch/signature/'.$details->signature); ?>" alt="preview" class="img-fluid img-responsive img-thumbnail previewImg">
									</div>
								</div>
							</div>
							<div class="col-md-6 mb-3">
								<div class="row holder">
									<div class="col-md-8">
										<label for="image" class="form-label">Associate Image <small>(200 X 200 px)</small></label>
										<input class="form-control imgFile twohundredXtwohundred" type="file" accept="image/*" id="image" name="image">
										<input type="hidden" name="oldBranchImageFile" value="<?= ($details)?$details->branch_image:''; ?>">
									</div>
									<div class="col-md-4 file-preview">
										<img src="<?= empty($details->branch_image)?site_url('public/headoffice/images/default/defaultImage.png'):site_url('public/upload/files/branch/branch-image/'.$details->branch_image); ?>" alt="preview" class="img-fluid img-responsive img-thumbnail previewImg">
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="card-footer">
						<div class="row">
							<div class="col-md-12 text-end">
								<?= csrf_field(); ?>
								<input type="submit" class="btn btn-dark btnSaveBranch" value="<?= empty($details)?'Save':'Update'; ?>">
							</div>
						</div>
					</div>
				</div><!-- end col-->
			</div>
		</form>
	</div>
	<?= $this->endSection(); ?>