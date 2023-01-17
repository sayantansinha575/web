<?= $this->extend('branch/layOut'); ?>
<?= $this->section('body') ?>
<?php  
if (!empty($details)) {
	$fileArr[] = array(
		'name' => "Student's Image",
		'file' => $details->student_photo,
		'url' => site_url('public/upload/branch-files/student/student-image/'.$details->student_photo),
	);
	$fileArr[] = array(
		'name' => $details->qualification_document_type,
		'file' => $details->qualification_file,
		'url' => site_url('public/upload/branch-files/student/qualification-file/'.$details->qualification_file),
	);
	$fileArr[] = array(
		'name' => $details->identity_card_type,
		'file' => $details->identity_proof,
		'url' => site_url('public/upload/branch-files/student/identity-proof-file/'.$details->identity_proof),
	);
}
?>
<div class="col-lg-9 col-md-9 col-sm-12  pt-4">
	<fieldset class="studentAdmissionContainer">
		<?php if (empty($details)): ?>
			<div class="row">
				<div class="col-xl-12 col-lg-12 col-md-12">
					<div class="dashboard_wrap">
						<div class="row">
							<div class="col-xl-12 col-lg-12 col-md-12 mb-2">
								<h6 class="m-0">Search Student</h6><hr>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6 mb-3">
								<div class="form-group smalls">
									<div class="input-group">
										<input type="text" class="form-control uppercase" id="studRegNo" placeholder="Search student by registration number">
										<div class="input-group-append">
											<button type="button" class="btn btn-dark" id="btnRegNo">Search</button>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php endif ?>
		<form action="<?= site_url('branch/student/new-admission') ?>" id="formAdmission">
			<div class="row" style="display: <?= (empty($details))?'none':'block'; ?>;" id="studDetContainer">
				<div class="col-xl-12 col-lg-12 col-md-12">
					<div class="dashboard_wrap">
						<div >
							<div class="row">
								<div class="col-xl-12 col-lg-12 col-md-12 mb-2">
									<h6 class="m-0">Student Details <span class="trip theme-cl theme-bg-light" id="editWhileNewAdmission"> <i class="fa-solid fa-pen"></i> Edit </span></h6> <hr>
								</div>
							</div>
							<div class="row justify-content-center">
								<div class="col-md-12 col-lg-12 col-sm-12">
									<div class="accordion">
										<div class="card">
											<div id="studentDetails" class="card-header bg-white shadow-sm border-0">
												<h6 class="mb-0 accordion_title"><a href="#" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne" class="d-block position-relative text-dark collapsible-link py-2">Student Details</a></h6>
											</div>
											<div id="collapseOne" aria-labelledby="studentDetails"  class="collapse show" style="">
												<div class="card-body pl-3 pr-3 pt-0">
													<ul class="lists-3 row">
														<li class="col-xl-4 col-lg-4 col-md-4 m-0"><b>Registration Number</b></li>
														<li class="text-right col-xl-1 col-lg-1 col-md-1 m-0">:</li>
														<li class="col-xl-4 col-lg-4 col-md-4 m-0" id="detRegNo"><?= ($details)?$details->registration_number:''; ?></li>
														<li class="col-xl-4 col-lg-4 col-md-4 m-0"><b>Student Name</b></li>
														<li class="text-right col-xl-1 col-lg-1 col-md-1 m-0">:</li>
														<li class="col-xl-4 col-lg-4 col-md-4 m-0" id="dtStudName"><?= ($details)?$details->student_name:''; ?></li>
														<li class="col-xl-4 col-lg-4 col-md-4 m-0"><b>Date of Birth</b></li>
														<li class="text-right col-xl-1 col-lg-1 col-md-1 m-0">:</li>
														<li class="col-xl-4 col-lg-4 col-md-4 m-0" id="dtStudDob"><?= ($details)?date('Y-m-d', $details->student_dob):''; ?></li>
														<li class="col-xl-4 col-lg-4 col-md-4 m-0"><b>Gender</b></li>
														<li class="text-right col-xl-1 col-lg-1 col-md-1 m-0">:</li>
														<li class="col-xl-4 col-lg-4 col-md-4 m-0" id="dtStudGender"><?= ($details)?$details->gender:''; ?></li>
														<li class="col-xl-4 col-lg-4 col-md-4 m-0"><b>Mobile Number</b></li>
														<li class="text-right col-xl-1 col-lg-1 col-md-1 m-0">:</li>
														<li class="col-xl-4 col-lg-4 col-md-4 m-0" id="dtStudMobile"><?= ($details)?$details->mobile:''; ?></li>
													</ul>
												</div>
											</div>
										</div>
										<div class="card">
											<div id="parentDetails" class="card-header bg-white shadow-sm border-0">
												<h6 class="mb-0 accordion_title"><a href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo" class="d-block position-relative text-dark collapsible-link py-2">Parent Details</a></h6>
											</div>
											<div id="collapseTwo" aria-labelledby="parentDetails"  class="collapse show" style="">
												<div class="card-body pl-3 pr-3 pt-0">
													<ul class="lists-3 row">
														<li class="col-xl-4 col-lg-4 col-md-4 m-0"><b>Father's Name</b></li>
														<li class="text-right col-xl-1 col-lg-1 col-md-1 m-0">:</li>
														<li class="col-xl-4 col-lg-4 col-md-4 m-0" id="dtStudFather"><?= ($details)?$details->father_name:''; ?></li>
														<li class="col-xl-4 col-lg-4 col-md-4 m-0"><b>Mother's Name</b></li>
														<li class="text-right col-xl-1 col-lg-1 col-md-1 m-0">:</li>
														<li class="col-xl-4 col-lg-4 col-md-4 m-0" id="dtStudMother"><?= ($details)?$details->mother_name:''; ?></li>
													</ul>
												</div>
											</div>
										</div>
										<div class="card">
											<div id="documents" class="card-header bg-white shadow-sm border-0">
												<h6 class="mb-0 accordion_title"><a href="#" data-toggle="collapse" data-target="#collapsFive" aria-expanded="true" aria-controls="collapsFive" class="d-block position-relative text-dark collapsible-link py-2">Documents</a></h6>
											</div>
											<div id="collapsFive" aria-labelledby="documents"  class="collapse show" style="">
												<div class="card-body pl-3 pr-3 pt-0">
													<div class="table-responsive">
														<table class="table dash_list">
															<thead>
																<tr>
																	<th scope="col" width="10%">#</th>
																	<th scope="col">File Name</th>
																	<th scope="col" width="18%">Action</th>
																</tr>
															</thead>
															<tbody>
																<?php if (!empty($fileArr)): ?>
																	<?php foreach ($fileArr as $file): 
																		if (empty($file['file'])) {
																			continue;
																		}
																		?>
																		<tr>
																			<th scope="row">1</th>
																			<td><div class="smalls lg"><?= $file['name'] ?></div></td>
																			<td>
																				<a class="btn btn-sm btn-icon btn-dark" href="<?= $file['url']; ?>" download><i class="fa-solid fa-download"></i></a>
																			</td>
																		</tr>
																	<?php endforeach ?>
																<?php endif ?>
															</tbody>
														</table>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row" style="display:none; ?>;" id="studDetEditContainer">
				<div class="col-xl-12 col-lg-12 col-md-12">
					<div class="dashboard_wrap">
						<div  >
							<div class="row">
								<div class="col-xl-12 col-lg-12 col-md-12 mb-2">
									<h6 class="m-0">Student Information</h6> <hr>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6 mb-3">
									<div class="form-group smalls">
										<label class="form-label">Name <span class="text-danger">*</span></label>
										<input type="text" class="form-control" name="student_name" id="student_name" placeholder="Enter student name" value="<?= ($details)?$details->student_name:''; ?>">
									</div>
								</div>
								<div class="col-md-6 mb-3">
									<div class="form-group smalls">
										<label class="form-label">Date of Birth <span class="text-danger">*</span></label>
										<input type="text" class="form-control dobPicker" name="student_dob" id="student_dob" placeholder="Enter student's D.O.B" value="<?= ($details)?date('Y-m-d', $details->student_dob):''; ?>">
									</div>
								</div>
								<div class="col-md-6 mb-3">
									<div class="form-group smalls">
										<label class="form-label">Gender <span class="text-danger">*</span></label>
										<select name="gender" id="gender" class="form-control selectNoSearch">
											<option value=""></option>
											<option <?= ($details)?($details->gender == 'Male')?'selected':'':''; ?> value="Male">Male</option>
											<option <?= ($details)?($details->gender == 'Female')?'selected':'':''; ?> value="Female">Female</option>
											<option <?= ($details)?($details->gender == 'Transgender')?'selected':'':''; ?> value="Transgender">Transgender</option>
										</select>
									</div>
								</div>
								<div class="col-md-6 mb-3">
									<div class="form-group smalls">
										<label class="form-label">Mobile <span class="text-danger">*</span></label>
										<input type="text" class="form-control" name="mobile" id="mobile" value="<?= ($details)?$details->mobile:''; ?>">
									</div>
								</div>
								<div class="col-md-6 mb-3">
									<div class="form-group ">
										<label class="form-label">Residential Address<span class="text-danger">*</span></label>
										<textarea name="residential_address" id="residential_address" rows="3" class="form-control"><?= ($details)?$details->residential_address:''; ?></textarea>
									</div>
								</div>
								<input type="hidden" id="registration_number" name="registration_number" value="<?= ($details)?$details->registration_number:''; ?>">
							</div>
							<div class="row">
								<div class="col-xl-12 col-lg-12 col-md-12 mb-2">
									<h6 class="header-title">Parents Details</h6><hr>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6 mb-3">
									<div class="form-group smalls">
										<label class="form-label">Father's Name <span class="text-danger">*</span></label>
										<input type="text" class="form-control" name="father_name" id="father_name" placeholder="Enter father's name" value="<?= ($details)?$details->father_name:''; ?>">
									</div>
								</div>
								<div class="col-md-6 mb-3">
									<div class="form-group smalls">
										<label class="form-label">Mother's Name <span class="text-danger">*</span></label>
										<input type="text" class="form-control" name="mother_name" id="mother_name" placeholder="Enter mother's name" value="<?= ($details)?$details->mother_name:''; ?>">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-xl-12 col-lg-12 col-md-12 mb-2">
									<h6 class="header-title">Documents</h6><hr>
								</div>
							</div>
							<div class="row holder">
								<div class="col-md-10 col-xl-10 col-lg-10 col-sm-12 mb-3">
									<div class="form-group smalls">
										<label>Student's Photo <small>(Recent photographs not more than 6 months old)</small></label>
										<div class="custom-file">
											<input type="file" class="custom-file-input hundredFiftyXhundredFifty file-size-valid" name="student_photo" id="student_photo"  accept=".jpeg,.jpg,.png">
											<label class="custom-file-label" for="customFile">Choose Student's Photograph</label>
										</div>
										<input type="hidden" name="oldStudentFile" id="oldStudentFile" value="<?= ($details)?$details->student_photo:''; ?>">
									</div>
								</div>
								<div class="col-md-2 col-xl-2 col-lg-2 col-sm-12 file-preview mb-3">
									<img src="<?= empty($details->student_photo)?site_url('public/headoffice/images/default/defaultImage.png'):site_url('public/upload/branch-files/student/student-image/'.$details->student_photo); ?>" alt="preview" class="img-fluid img-responsive img-thumbnail previewImg studentImage">
								</div>
							</div>
							<div class="row holder">
								<div class="col-md-4 col-xl-4 col-lg-4 col-sm-12 mb-3">
									<div class="form-group smalls">
										<label>Document Type</label>
										<select name="qualification_document_type" id="qualification_document_type" class="form-control selectNoSearch">
											<option value=""></option>
											<option <?= ($details)?($details->qualification_document_type == 'Marksheet')?'selected':'':''; ?> value="Marksheet">Marksheet</option>
											<option <?= ($details)?($details->qualification_document_type == 'Certificate')?'selected':'':''; ?> value="Certificate">Certificate</option>
										</select>
									</div>
								</div>
								<div class="col-md-6 col-xl-6 col-lg-6 col-sm-12 mb-3">
									<div class="form-group smalls">
										<label>Qualification <small>(Photocopy(xerox) of last educational qualification marksheet/certificate.)</small></label>
										<div class="custom-file">
											<input type="file" class="custom-file-input file-size-valid" name="qualification_file" id="qualification_file"  accept="image/*">
											<label class="custom-file-label" for="customFile">Choose Educational Qualification </label>
										</div>
										<input type="hidden" name="oldQualificationFile" id="oldQualificationFile" value="<?= ($details)?$details->qualification_file:''; ?>">
									</div>
								</div>
								<div class="col-md-2 col-xl-2 col-lg-2 col-sm-12 file-preview mb-3">
									<img src="<?= empty($details->qualification_file)?site_url('public/headoffice/images/default/defaultImage.png'):site_url('public/upload/branch-files/student/qualification-file/'.$details->qualification_file); ?>" alt="preview" class="img-fluid img-responsive img-thumbnail previewImg qualificationFile">
								</div>
							</div>
							<div class="row holder">
								<div class="col-md-4 col-xl-4 col-lg-4 col-sm-12 mb-3">
									<div class="form-group smalls">
										<label>Document Type</label>
										<select name="identity_card_type" id="identity_card_type" class="form-control selectNoSearch">
											<option value=""></option>
											<option <?= ($details)?($details->identity_card_type == 'Voter Card')?'selected':'':''; ?> value="Voter Card">Voter Card</option>
											<option <?= ($details)?($details->identity_card_type == 'Aadhar Card')?'selected':'':''; ?> value="Aadhar Card">Aadhar Card</option>
											<option <?= ($details)?($details->identity_card_type == 'PAN Card')?'selected':'':''; ?> value="PAN Card">PAN Card</option>
											<option <?= ($details)?($details->identity_card_type == 'School Identity Card')?'selected':'':''; ?> value="School Identity Card">School Identity Card</option>
										</select>
									</div>
								</div>
								<div class="col-md-6 col-xl-6 col-lg-6 col-sm-12 mb-3">
									<div class="form-group smalls">
										<label>Identity Proof</small></label>
										<div class="custom-file">
											<input type="file" class="custom-file-input" name="identity_proof" id="identity_proof"  accept="image/*">
											<label class="custom-file-label" for="customFile">Choose Idenity Proof</label>
										</div>
										<input type="hidden" name="oldIdentityFile" id="oldIdentityFile" value="<?= ($details)?$details->identity_proof:''; ?>">
									</div>
								</div>
								<div class="col-md-2 col-xl-2 col-lg-2 col-sm-12 file-preview mb-3">
									<img src="<?= empty($details->identity_proof)?site_url('public/headoffice/images/default/defaultImage.png'):site_url('public/upload/branch-files/student/identity-proof-file/'.$details->identity_proof); ?>" alt="preview" class="img-fluid img-responsive img-thumbnail previewImg identityFile">
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row" style="display: <?= (empty($details))?'none':'block'; ?>;" id="courseDetContainer">
				<div class="col-xl-12 col-lg-12 col-md-12">
					<div class="dashboard_wrap">
						<div class="row">
							<div class="col-xl-12 col-lg-12 col-md-12 mb-2">
								<h6 class="m-0">Course Details</h6><hr>
							</div>
						</div>
						<div class="row justify-content-center">
							<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
								<div class="row">
									<div class="col-md-3 mb-2">
										<div class="form-group smalls">
											<label class="form-label">Course Type <span class="text-danger">*</span></label>
											<select name="course_type" id="course_type" class="form-control">
												<option value=""></option>
												<?php if (!empty($courseType)): ?>
													<?php foreach ($courseType as $course): ?>
														<option value="<?= $course->id; ?>"><?= $course->course_type; ?></option>
													<?php endforeach ?>
												<?php endif ?>
											</select>
										</div>
									</div>
									<div class="col-md-6 mb-2">
										<div class="form-group smalls">
											<label class="form-label">Course Name <span class="text-danger">*</span></label>
											<select name="course_name" id="course_name" class="form-control" disabled>
												<option value=""></option>
											</select>
										</div>
									</div>
									<div class="col-md-3 mb-2">
										<div class="form-group smalls">
											<label class="form-label">Is Urgent Certificate Required?<span class="text-danger">*</span></label>
											<select id="is_urgent_certificate_required" name="is_urgent_certificate_required" class="form-control selectNoSearch">
												<option value=""></option>
												<option value="Yes">Yes (Rs.<?= number_format(config('SiteConfig')->general['URGENT_CERTIFICATE_CHARGE'], 2) ?> chargable.)</option>
												<option value="No">No</option>
											</select>
										</div>
									</div>
									<div class="col-md-4 mb-2">
										<div class="form-group smalls">
											<label class="form-label">Course Code</label>
											<input class="form-control" id="course_code" name="course_code" type="text" readonly>
										</div>
									</div>
									<div class="col-md-4 mb-2">
										<div class="form-group smalls">
											<label class="form-label">Course Duration <small>(In Months)</small></label>
											<input class="form-control" id="course_duration" maxlength="2" name="course_duration" type="text" readonly>
										</div>
									</div>
									<div class="col-md-4 mb-2">
										<div class="form-group smalls">
											<label class="form-label">Course Eligibility</label>
											<input class="form-control" id="course_eligibility" name="course_eligibility" type="text" readonly>
										</div>
									</div>
									<div class="col-md-3 mb-2">
										<div class="form-group smalls">
											<label class="form-label">I-Card Expiry Date <span class="text-danger">*</span></label>
											<input type="text" name="icard_expired_date" id="icard_expired_date" class="form-control singleDatePicker" placeholder="Enter expiry date">
										</div>
									</div>
									<div class="col-md-3 mb-2">
										<div class="form-group smalls">
											<label class="form-label">From Session <span class="text-danger">*</span></label>
											<input type="text" name="from_session" id="from_session" class="form-control" placeholder="Enter from session" readonly>
										</div>
									</div>
									<div class="col-md-3 mb-2">
										<div class="form-group smalls">
											<label class="form-label">To Session <span class="text-danger">*</span></label>
											<input type="text" name="to_session" id="to_session" class="form-control" placeholder="Enter to session" readonly>
										</div>
									</div>
									<div class="col-md-3 mb-2">
										<div class="form-group smalls">
											<label class="form-label">Admission Date <span class="text-danger">*</span></label>
											<input type="text" name="admission_date" id="admission_date" class="form-control silent" placeholder="Select Admission Date">
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row" style="display:  <?= (empty($details))?'none':'block'; ?>;" id="courseDetContainer">
				<div class="col-xl-12 col-lg-12 col-md-12">
					<div class="dashboard_wrap">
						<div class="row">
							<div class="col-xl-12 col-lg-12 col-md-12 mb-2">
								<h6 class="m-0">Course Payment</h6><hr>
							</div>
						</div>
						<div class="row justify-content-center">
							<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
								<div class="row">
									<div class="col-md-4 mb-2">
										<div class="form-group smalls">
											<label class="form-label">Course Fees <span class="text-danger">*</span></label>
											<input class="form-control decimal" id="course_fees" name="course_fees" type="text">
										</div>
									</div>
									<div class="col-md-4 mb-2">
										<div class="form-group smalls">
											<label class="form-label">Discount </label>
											<input class="form-control decimal" id="discount" name="discount" type="text" value="0">
										</div>
									</div>
									<div class="col-md-4 mb-2">
										<div class="form-group smalls">
											<label class="form-label">Amount Paid  <span class="text-danger">*</span></label>
											<input class="form-control decimal" id="amount_paid" name="amount_paid" type="text" value="0">
										</div>
									</div>
									<div class="col-md-12 mb-2">
										<div class="form-group smalls">
											<?= csrf_field(); ?>
											<button class="btn theme-bg text-white btnSaveAdmission" type="submit">Save</button>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</form>
	</fieldset>
</div>
<?= $this->endSection(); ?>