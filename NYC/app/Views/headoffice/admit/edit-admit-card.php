<?= $this->extend('headoffice/layOut'); ?>
<?= $this->section('body') ?>
<div class="container-fluid">
	<!-- start page title -->
	<div class="row">
		<div class="col-12">
			<div class="page-title-box">
				<div class="page-title-right">
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="/head-office/admit">Admit</a></li>
						<li class="breadcrumb-item active"><?= empty($details)?'Add':'Edit'; ?> Admit</li>
					</ol>
				</div>
				<h4 class="page-title"><?= $title; ?></h4>
			</div>
		</div>
	</div>     
	<!-- end page title --> 

	
	<form action="<?= current_url(); ?>" id="formUpdateAdmit" accept-charset="UTF-8" autocomplete="off">
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-body">
						<h4 class="header-title">Admit Details</h4><hr>
						<br>
						<div class="row">
							<div class="col-md-10">
								<div class="row">
									<div class="col-md-6 mb-3">
										<label class="form-label">Candidate's Name <span class="text-danger">*</span></label>
										<input type="text" class="form-control" name="candidate_name" id="candidate_name" placeholder="Enter candidate's name" value="<?= ($details)?$details->candidate_name:''; ?>" readonly>
									</div>
									<div class="col-md-6 mb-3">
										<label class="form-label">Registration No. <span class="text-danger">*</span></label>
										<input type="text" class="form-control" name="registration_number" id="registration_number" placeholder="Enter registration number" value="<?= ($details)?$details->registration_number:''; ?>" readonly>
									</div>

									<div class="col-md-4 mb-3">
										<label class="form-label">Enrollment No. <span class="text-danger">*</span></label>
										<input type="text" class="form-control" name="enrollment_number" id="enrollment_number" placeholder="Enter enrollment number" value="<?= ($details)?$details->enrollment_number:''; ?>" readonly>
									</div>
									<div class="col-md-4 mb-3">
										<label class="form-label">Exam Name <span class="text-danger">*</span></label>
										<input type="text" class="form-control" name="exam_name" id="exam_name" placeholder="Enter exam name" value="<?= ($details)?$details->exam_name:''; ?>" readonly>
									</div>
									<div class="col-md-4 mb-3">
										<label class="form-label">Exam Branch Code <span class="text-danger">*</span></label>
										<input type="text" class="form-control" name="branch_code" id="branch_code" placeholder="Enter banch code" value="<?= ($details)?$details->branch_code:''; ?>" readonly>
									</div>

									<div class="col-md-4 mb-3">
										<label class="form-label">Exam Date <span class="text-danger">*</span></label>
										<input type="text" class="form-control transpDisabled" name="exam_date" id="exam_date" placeholder="Select Exam Date" value="<?= ($details)?date('Y-m-d', $details->exam_date):''; ?>" readonly>
									</div>
									<div class="col-md-4 mb-3">
										<label class="form-label">Exam Day <span class="text-danger">*</span></label>
										<input type="text" class="form-control" name="exam_day" id="exam_day" placeholder="Enter exam day" value="<?= ($details)?$details->exam_day:''; ?>" readonly>
									</div>
									<div class="col-md-4 mb-3">
										<label class="form-label">Exam Time <span class="text-danger">*</span></label>
										<input type="text" class="form-control transpDisabled" name="exam_time" id="exam_time" placeholder="Enter exam time" value="<?= ($details)?$details->exam_time:''; ?>" readonly>
									</div>
								</div>
							</div>
							<div class="col-md-2 d-flex align-items-center">
								<div class="card">
									<div class="card-body">
										<img src="<?= site_url('public/upload/branch-files/student/student-image/'.$details->student_photo) ?>" class="rounded img-fluid img-thumbnail" alt="...">
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="card-footer">
						<div class="row">
							<div class="col-md-12 text-end">
								<?= csrf_field(); ?>
								<input type="submit" class="btn btn-dark btnUpdateAdmit" value="<?= empty($details)?'Save':'Update'; ?>">
							</div>
						</div>
					</div>
				</div><!-- end col-->
			</div>
		</form>
	</div>
	<?= $this->endSection(); ?>