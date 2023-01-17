<?= $this->extend('branch/layOut'); ?>
<?= $this->section('body') ?>
<div class="col-lg-9 col-md-9 col-sm-12  pt-4">

	<div class="row justify-content-between">
		<div class="col-lg-12 col-md-12 col-sm-12 ">
			<div class="dashboard_wrap d-flex align-items-center justify-content-between">
				<div class="arion">
					<nav class="transparent">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="<?= site_url('branch/certificate'); ?>">Certificate</a></li>
							<li class="breadcrumb-item active" aria-current="page">New Certificate</li>
						</ol>
					</nav>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-xl-12 col-lg-12 col-md-12">
			<div class="dashboard_wrap">
				<div class="row">
					<div class="col-xl-12 col-lg-12 col-md-12 mb-2">
						<h6 class="m-0">Search Details</h6><hr>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6 mb-3">
						<form action="<?= site_url('branch/certificate/apply-new-certificate') ?>" method="get">
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
		<form action="<?= site_url('branch/certificate/apply-new-certificate'); ?>" id="formCertificate" accept-charset="UTF-8" autocomplete="off">

		<div class="row">
			<div class="col-xl-12 col-lg-12 col-md-12">
				<div class="dashboard_wrap">
					<div class="row">
						<div class="col-xl-12 col-lg-12 col-md-12 mb-2">
							<h6 class="m-0">Candidate Details</h6><hr>
						</div>
					</div>
					<div class="row justify-content-center">
						<div class="col-xl-12 col-lg-12 col-md-12">

							<div class="row">
								<div class="col-md-4 mb-3">
									<div class="form-group smalls">
										<label class="form-label">Candidate Name <span class="text-danger">*</span></label>
										<input type="text" class="form-control" name="candidate_name" id="candidate_name" placeholder="Enter candidate name" value="<?= ($details)?$details->student_name:''; ?>" readonly>
									</div>
								</div>
								<div class="col-md-4 mb-3">
									<div class="form-group smalls">
										<label class="form-label">Enrollment No. <span class="text-danger">*</span></label>
										<input type="text" class="form-control" name="enrollment_number" id="enrollment_number" placeholder="Enter candidate name" value="<?= ($details)?$details->enrollment_number:''; ?>" readonly>
									</div>
								</div>
								<div class="col-md-4 mb-3">
									<div class="form-group smalls">
										<label class="form-label">Generate Typing Ceritificate <span class="text-danger">*</span></label>
										<input type="text" class="form-control" value="<?= ($details->typing_test == 1)?'Yes':'No'; ?>" readonly>
									</div>
								</div>
								<div class="col-md-6 mb-3">
									<div class="form-group smalls">
										<label class="form-label">Father's Name <span class="text-danger">*</span></label>
										<input type="text" class="form-control" name="father_name" id="father_name" placeholder="Enter candidate name" value="<?= ($details)?$details->father_name:''; ?>" readonly>
									</div>
								</div>
								<div class="col-md-6 mb-3">
									<div class="form-group smalls">
										<label class="form-label">Course Name <span class="text-danger">*</span></label>
										<input type="text" class="form-control" value="<?= ($details)?$details->courseName.' ('.$details->short_name.')':''; ?>" readonly>
										<input type="hidden" name="course_id" class="form-control" value="<?= ($details)?$details->course_name:''; ?>">
									</div>
								</div>
								<div class="col-md-3 mb-3">
									<div class="form-group smalls">
										<label class="form-label">From Session <span class="text-danger">*</span></label>
										<input type="text" class="form-control" name="from_session" data-date="" id="from_session" placeholder="Select course session"  value="<?= ($details)?date('Y-m-d', $details->from_session):''; ?>" readonly>
									</div>
								</div>
								<div class="col-md-3 mb-3">
									<div class="form-group smalls">
										<label class="form-label">To Session <span class="text-danger">*</span></label>
										<input type="text" class="form-control" name="to_session" id="to_sessionn" placeholder="Select course session" value="<?= ($details)?date('Y-m-d', $details->to_session):''; ?>" readonly >
									</div>
								</div>
								<div class="col-md-3 mb-3">
									<div class="form-group smalls">
										<label class="form-label">Duration <span class="text-danger">*</span> <small>( In Months )</small></label>
										<input type="text" class="form-control numbers" name="duration" id="duration" placeholder="" readonly value="<?= ($details)?$details->course_duration:''; ?>">
									</div>
								</div>
								<?php if ($has_marksheet == 'Yes'): ?>
									<div class="col-md-3 mb-3">
										<div class="form-group smalls">
											<label class="form-label">Grade <span class="text-danger">*</span></label>
											<input type="text" class="form-control" name="grade" id="grade" placeholder="Enter Grade" value="<?= $msheetData->overall_grade; ?>" readonly>
										</div>
									</div>
								<?php else: ?>
									<div class="col-md-3 mb-3">
										<div class="form-group smalls">
											<label class="form-label">Grade <span class="text-danger">*</span></label>
											<select name="grade" id="grade" class="form-control selectNoSearch">
												<option value=""></option>
												<option value="A+">A+</option>
												<option value="A">A</option>
												<option value="B+">B+</option>
												<option value="B">B</option>
												<option value="C">C</option>
												<option value="FAILED">FAILED</option>
											</select>
										</div>
									</div>
								<?php endif ?>

								<?php if ($details->typing_test == 1): ?>
									<div class="col-md-12">
										<h6>Typing Skills</h6><hr>
									</div>
									<div class="col-md-3"><label class="form-label">Language <span class="text-danger">*</span></label></div>
									<div class="col-md-3"><label class="form-label">Speed <span class="text-danger">*</span></label></div>
									<div class="col-md-3"><label class="form-label">Accuracy <span class="text-danger">*</span></label></div>
									<div class="col-md-3"><label class="form-label">Time <span class="text-danger">*</span> <small>(In minute)</small></label></div>

									<div class="col-md-3 mb-3">
										<div class="form-group smalls" >
											<select name="type_lang[]" class="form-control selectNoSearch">
												<option value="">Select Language</option>
												<option value="English">English</option>
												<option value="Bengali">Bengali</option>
											</select>
											
										</div>
									</div>
									<div class="col-md-3 mb-3">
										<div class="form-group smalls">
											<input type="text" class="form-control numbers" name="type_speed[]" placeholder="Enter typing speed">
										</div>
									</div>
									<div class="col-md-3 mb-3">
										<div class="form-group smalls">
											<input type="text" class="form-control decimal" name="type_accuracy[]" placeholder="Enter typing accuracy">
										</div>
									</div> 
									<div class="col-md-3 mb-3">
										<div class="form-group smalls">
											<input type="text" class="form-control numbers" name="type_time[]" placeholder="Enter typing time">
										</div> 
									</div>
									<div class="col-md-3 mb-3">
										<div class="form-group smalls">
											<select name="type_lang[]" class="form-control selectNoSearch">
												<option value="">Select Language</option>
												<option value="English">English</option>
												<option value="Bengali">Bengali</option>
											</select>
											
										</div>
									</div>
									<div class="col-md-3 mb-3">
										<div class="form-group smalls">
											<input type="text" class="form-control numbers" name="type_speed[]" placeholder="Enter typing speed">
										</div>
									</div>
									<div class="col-md-3 mb-3">
										<div class="form-group smalls">
											<input type="text" class="form-control numbers" name="type_accuracy[]" placeholder="Enter typing accuracy">
										</div>
									</div>
									<div class="col-md-3 mb-3">
										<div class="form-group smalls">
											<input type="text" class="form-control numbers" name="type_time[]" placeholder="Enter typing time">
										</div>
									</div>
								<?php endif ?>

								
								<input type="hidden" name="student_photo" value="<?= ($details)?$details->student_photo:''; ?>" readonly> 
								<input type="hidden" name="short_name" value="<?= ($details)?$details->short_name:''; ?>" readonly>
								<input type="hidden" name="typing_test" value="<?= ($details)?$details->typing_test:''; ?>" readonly>
								<input type="hidden" class="form-control" name="admission_id" id="admission_id" placeholder="Enter candidate name" value="<?= ($details)?$details->id:''; ?>" readonly>
								<div class="col-md-12 mb-3 form-group smalls">
									<?= csrf_field(); ?>
									<button class="btn theme-bg text-white btnCertificate" data-continue="0" type="submit">Apply</button>								
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
