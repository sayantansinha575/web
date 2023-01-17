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

	
	<form action="<?= site_url('head-office/generate-authletter'); ?>" method="post" id="AuthLetter" accept-charset="UTF-8" autocomplete="off">
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-body">
				
						<div class="row">
							<div class="col-md-6 mb-3">
								<label class="form-label">Partner Name <span class="text-danger">*</span></label>
								<input type="text" class="form-control" name="owner_name" id="owner_name" placeholder="Enter branch name" value="<?= ($details)?$details->owner_name:''; ?>">
								<?php if( isset($_GET['letter_code']) ){?>
									<input type="hidden" value="<?php echo $_GET['letter_code']; ?>" name="letter_code">
								<?php }else{?>
									<input type="hidden" value="<?php echo $branch_details->id; ?>" name="branch_id">
								<?php } ?>
								<input type="hidden" value="<?php echo $branch_details->branch_code; ?>" name="branch_code">
								<input type="hidden" value="<?php echo $branch_details->academy_name; ?>" name="academy_name">
								 
							</div>
						
							<div class="col-md-6 mb-3">
								<div class="row holder">
									<div class="col-md-8">
										<label for="image" class="form-label">Partner Image<b>(150x150)</b> <span class="text-danger">*</span></label>
										<input class="form-control imgFile hundredFiftyXhundredFifty" type="file" accept="image/*" id="image" name="image">
										<input type="hidden" name="oldImage" value="<?= ($details)?$details->image:''; ?>">
									</div>
									<div class="col-md-4 file-preview">
										<img src="<?= empty($details->image)?site_url('public/headoffice/images/default/defaultImage.png'):site_url('public/upload/files/branch/branch-image/'.$details->image); ?>" alt="preview" class="img-fluid img-responsive img-thumbnail previewImg">
									</div>
								</div>
							</div>


							<div class="col-md-4 mb-3">
								<label class="form-label">Registration Date <span class="text-danger">*</span></label>
								<input type="text" class="form-control singleDatePicker" name="registration_date" id="registration_date" placeholder="Select date" value="<?= (!empty($details->registration_date))?date('Y-m-d', $details->registration_date):''; ?>">
							</div>

							<div class="col-md-4 mb-3">
								<label class="form-label">Next Renewal Date <span class="text-danger">*</span></label>
								<input type="text" class="form-control singleDatePicker" name="renewal_date" id="renewal_date" placeholder="Select date" value="<?= (!empty($details->renewal_date))?date('Y-m-d', $details->renewal_date):''; ?>">
							</div>

							<div class="col-md-4 mb-3">
								<label class="form-label">Issue Date <span class="text-danger">*</span></label>
								<input type="text" class="form-control singleDatePicker" name="issue_date" id="issue_date" placeholder="Select date" value="<?= (!empty($details->issue_date))?date('Y-m-d', $details->issue_date):''; ?>">
							</div>


						</div>
					</div>
					<div class="card-footer">
						<div class="row">
							<div class="col-md-12 text-end">
								<?= csrf_field(); ?>
								<input type="submit" class="btn btn-dark btnAuthLetter" value="<?= empty($details)?'Save':'Update'; ?>">
							</div>
						</div>
					</div>
				</div><!-- end col-->
			</div>
		</form>
	</div>
	<?= $this->endSection(); ?>