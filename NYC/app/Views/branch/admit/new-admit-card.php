<?= $this->extend('branch/layOut'); ?>
<?= $this->section('body') ?>
<div class="col-lg-9 col-md-9 col-sm-12  pt-4">

	<div class="row">
		<div class="col-xl-12 col-lg-12 col-md-12">
			<div class="dashboard_wrap">
				<div class="row">
					<div class="col-xl-12 col-lg-12 col-md-12">
						<h6 class="m-0">Search Details</h6><hr>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6 mb-3">
						<form action="<?= site_url('branch/admit/new-admit-card') ?>" method="get">
							<div class="form-group smalls">
								<div class="input-group">
									<input autocomplete="false" type="text" class="form-control uppercase" name="enrollNo" placeholder="Search details by enrollment number" value="<?= !empty($_REQUEST['enrollNo'])?$_REQUEST['enrollNo']:''; ?>">
									<div class="input-group-append">
										<button type="submit" class="btn btn-dark">Search</button>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php if (!empty($details)): ?>
		<form action="<?= site_url('branch/admit/new-admit-card'); ?>" id="formAdmit" accept-charset="UTF-8" autocomplete="off">

		<div class="row">
			<div class="col-xl-12 col-lg-12 col-md-12">
				<div class="dashboard_wrap">
					<div class="row">
						<div class="col-xl-12 col-lg-12 col-md-12 mb-2">
							<h6 class="m-0">Admit Details</h6><hr>
						</div>
					</div>
					<div class="row justify-content-center">
						<div class="col-xl-10 col-lg-10 col-md-10">

							<div class="row">
								<div class="col-md-4 mb-3">
									<div class="form-group smalls">
										<label class="form-label">Candidate's Name <span class="text-danger">*</span></label>
										<input type="text" class="form-control" name="candidate_name" id="candidate_name" placeholder="Enter candidate name" value="<?= ($details)?$details->student_name:''; ?>" readonly>
									</div>
								</div>
								<div class="col-md-4 mb-3">
									<div class="form-group smalls">
										<label class="form-label">Registration No. <span class="text-danger">*</span></label>
										<input type="text" class="form-control" name="registration_number" id="registration_number" placeholder="Enter Registration Number" value="<?= ($details)?$details->registration_number:''; ?>" readonly>
									</div>
								</div>
								<div class="col-md-4 mb-3">
									<div class="form-group smalls">
										<label class="form-label">Enrollment No. <span class="text-danger">*</span></label>
										<input type="text" class="form-control" name="enrollment_number" id="enrollment_number" placeholder="Enter Enrollment Number" value="<?= ($details)?$details->enrollment_number:''; ?>" readonly>
									</div>
								</div>
								<div class="col-md-4 mb-3">
									<div class="form-group smalls">
										<label class="form-label">Examination Name <span class="text-danger">*</span></label>
										<input type="text" class="form-control" name="exam_name" id="exam_name" placeholder="Enter Exam Name" value="<?= ($details)?$details->short_name:''; ?>" readonly>
									</div>
								</div>
								<div class="col-md-4 mb-3">
									<div class="form-group smalls">
										<label class="form-label">Examination Branch Code <span class="text-danger">*</span></label>
										<input type="text" class="form-control" name="branch_code" id="branch_code" placeholder="Enter Examination Branch Code" value="<?= ($details)?$details->branch_code:''; ?>" readonly>
									</div>
								</div>

								<div class="col-md-4 mb-3">
									<div class="form-group smalls">
										<label class="form-label">Examination Date <span class="text-danger">*</span></label>
										<input type="text" class="form-control transpDisabled" name="exam_date" id="exam_date" placeholder="Select Exam Date" readonly>
									</div>
								</div>
								<div class="col-md-4 mb-3">
									<div class="form-group smalls">
										<label class="form-label">Examination Day <span class="text-danger">*</span></label>
										<input type="text" class="form-control" name="exam_day" id="exam_day" readonly>
									</div>
								</div>
								<div class="col-md-4 mb-3">
									<div class="form-group smalls">
										<label class="form-label">Examination Time <span class="text-danger">*</span></label>
										<input type="text" class="form-control transpDisabled" name="exam_time" id="exam_time" placeholder="Select Exam Time" readonly>
									</div>
								</div>
								<div class="col-md-4 mb-3">
									<div class="form-group smalls">
										<label class="form-label">Examination Fees <span class="text-danger">*</span></label>
										<select name="exam_fees" id="exam_fees" class="form-control selectNoSearch">
											<option value=""></option>
											<option value="0">0</option>
											<option value="50">50</option>
											<option value="100">100</option>
											<option value="150">150</option>
											<option value="200">200</option>
											<option value="250">250</option>
										</select>
									</div>
								</div>
								
								<input type="hidden" name="student_photo" value="<?= ($details)?$details->student_photo:''; ?>" readonly> 
								<input type="hidden" class="form-control" name="admission_id" id="admission_id" value="<?= ($details)?$details->id:''; ?>" readonly>
								<input type="hidden" class="form-control" name="course_id" id="course_id" value="<?= ($details)?$details->courseId:''; ?>" readonly>
								<div class="col-md-12 mb-3 form-group smalls">
									<?= csrf_field(); ?>
									<button class="btn theme-bg text-white btnAdmit" data-continue="0" type="submit">Generate Admit Card</button>								
								</div>
							</div>
						</div>
						<div class="col-xl-2 col-lg-2 col-md-2 d-flex align-items-center">
							<div class="card">
								<div class="card-body">
									<img src="<?= site_url('public/upload/branch-files/student/student-image/'.$details->student_photo) ?>" class="rounded img-fluid img-thumbnail" alt="...">
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>
	<?php endif ?>
<?= $this->endSection(); ?>
