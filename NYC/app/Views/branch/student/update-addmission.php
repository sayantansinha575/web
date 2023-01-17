<?= $this->extend('branch/layOut'); ?>
<?= $this->section('body') ?>
<div class="col-lg-9 col-md-9 col-sm-12  pt-4">

	<form action="<?= site_url('branch/student/update-admission/'.encrypt($id)) ?>" id="formDefault">			
		<div class="row">
			<div class="col-xl-12 col-lg-12 col-md-12">
				<div class="dashboard_wrap">
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
								<input type="text" class="form-control dobPicker" name="student_dob" id="student_dob" placeholder="Enter student's D.O.B" value="<?= (!empty($details->student_dob))?date('Y-m-d', $details->student_dob):''; ?>">
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
								<input type="text" class="form-control" name="mobile" id="mobile"  value="<?= ($details)?$details->mobile:''; ?>">
							</div>
						</div>
						<div class="col-md-6 mb-3">
							<div class="form-group">
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
									<input type="file" class="custom-file-input file-size-valid" name="identity_proof" id="identity_proof"  accept="image/*">
									<label class="custom-file-label" for="customFile">Choose Idenity Proof</label>
								</div>
								<input type="hidden" name="oldIdentityFile" id="oldIdentityFile" value="<?= ($details)?$details->identity_proof:''; ?>">
							</div>
						</div>
						<div class="col-md-2 col-xl-2 col-lg-2 col-sm-12 file-preview mb-3">
							<img src="<?= empty($details->identity_proof)?site_url('public/headoffice/images/default/defaultImage.png'):site_url('public/upload/branch-files/student/identity-proof-file/'.$details->identity_proof); ?>" alt="preview" class="img-fluid img-responsive img-thumbnail previewImg identityFile">
						</div>
					</div>
					<div class="row holder">
						<div class="col-md-10 col-xl-10 col-lg-10 col-sm-12 mb-3">
							<div class="form-group smalls">
								<label>Student's Photo <b>(150X150)</label></b>
								<div class="custom-file">
									<input type="file" class="custom-file-input hundredFiftyXhundredFifty" name="student_photo" id="student_photo"  accept=".jpg,.jpeg,.png">
									<label class="custom-file-label" for="customFile">Choose Student's Photograph</label>
								</div>
								<input type="hidden" name="oldStudentFile" id="oldStudentFile" value="<?= ($details)?$details->student_photo:''; ?>">
							</div>
						</div>
						<div class="col-md-2 col-xl-2 col-lg-2 col-sm-12 file-preview mb-3">
							<img src="<?= empty($details->student_photo)?site_url('public/headoffice/images/default/defaultImage.png'):site_url('public/upload/branch-files/student/student-image/'.$details->student_photo); ?>" alt="preview" class="img-fluid img-responsive img-thumbnail previewImg studentImage">
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
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
								<div class="col-md-3 mb-3">
									<div class="form-group smalls">
										<label class="form-label">Course Type <span class="text-danger">*</span></label>
										<select id="course_type" class="form-control" disabled>
											<option value=""></option>
											<?php if (!empty($courseType)): ?>
												<?php foreach ($courseType as $course): ?>
													<option <?= ($details->course_type == $course->id)?'Selected':''; ?> value="<?= $course->id; ?>"><?= $course->course_type; ?></option>
												<?php endforeach ?>
											<?php endif ?>
										</select>
									</div>
								</div>
								<div class="col-md-6 mb-2">
									<div class="form-group smalls">
										<label class="form-label">Course Name <span class="text-danger">*</span></label>
										<select id="course_name" class="form-control" disabled>
											<option value=""></option>
											<?php if (!empty($courseNames)): ?>
												<?php foreach ($courseNames as $cname): ?>
													<option <?= ($details->course_name == $cname->id)?'Selected':''; ?> value="<?= $cname->id; ?>"><?= $cname->course_name; ?></option>
												<?php endforeach ?>
											<?php endif ?>
										</select>
									</div>
								</div>
								<div class="col-md-3 mb-2">
									<div class="form-group smalls">
										<label class="form-label">Is Urgent Certificate Required? <span class="text-danger">*</span></label>
										<select id="is_urgent_certificate_required" name="is_urgent_certificate_required" class="form-control selectNoSearch">
											<option value=""></option>
											<option <?= ($details->is_urgent_certificate_required == 'Yes')?'Selected':''; ?> value="Yes">Yes (Rs.<?= number_format(config('SiteConfig')->general['URGENT_CERTIFICATE_CHARGE'], 2) ?> chargable.)</option>
											<option <?= ($details->is_urgent_certificate_required == 'No')?'Selected':''; ?> value="No">No</option>
										</select>
									</div>
								</div>
								<div class="col-md-4 mb-2">
									<div class="form-group smalls">
										<label class="form-label">Course Code</label>
										<input class="form-control" id="course_code" type="text" readonly value="<?= ($details)?$details->course_code:''; ?>">
									</div>
								</div>
								<div class="col-md-4 mb-2">
									<div class="form-group smalls">
										<label class="form-label">Course Duration <small>(In Months)</small></label>
										<input class="form-control" id="course_duration" maxlength="2" type="text" readonly value="<?= ($details)?$details->course_duration:''; ?>">
									</div>
								</div>
								<div class="col-md-4 mb-2">
									<div class="form-group smalls">
										<label class="form-label">Course Eligibility</label>
										<input class="form-control" id="course_eligibility" type="text" readonly value="<?= ($details)?$details->course_eligibility:''; ?>">
									</div>
								</div>
								<div class="col-md-3 mb-3">
									<div class="form-group smalls">
										<label class="form-label">I-Card Expiry Date <span class="text-danger">*</span></label>
										<input type="text" name="icard_expired_date" id="icard_expired_date" class="form-control singleDatePicker" placeholder="Enter expiry date" value="<?= (!empty($details->icard_expired_date))?date('Y-m-d', $details->icard_expired_date):''; ?>">
									</div>
								</div>
								<div class="col-md-3 mb-3">
									<div class="form-group smalls">
										<label class="form-label">From Session <span class="text-danger">*</span></label>
										<input type="text"  class="form-control" value="<?= (!empty($details->from_session))?date('Y-m-d', $details->from_session):''; ?>" readonly>
									</div>
								</div>
								<div class="col-md-3 mb-3">
									<div class="form-group smalls">
										<label class="form-label">To Session <span class="text-danger">*</span></label>
										<input type="text" class="form-control" value="<?= (!empty($details->to_session))?date('Y-m-d', $details->to_session):''; ?>" readonly>
									</div>
								</div>
								<div class="col-md-3 mb-2">
									<div class="form-group smalls">
										<label class="form-label">Admission Date <span class="text-danger">*</span></label>
										<input type="text" name="admission_date" id="admission_date" class="form-control silent" value="<?= (!empty($details->admission_date))?date('Y-m-d', $details->admission_date):''; ?>" placeholder="Select Admission Date">
									</div>
								</div>
								<div class="col-md-4 mb-2">
									<div class="form-group smalls">
										<label class="form-label">Course Fees <span class="text-danger">*</span></label>
										<input class="form-control decimal" type="text" value="<?= ($details)?$details->course_fees:''; ?>" readonly>
									</div>
								</div>
								<div class="col-md-4 mb-2">
									<div class="form-group smalls">
										<label class="form-label">Discount <span class="text-danger">*</span></label>
										<input class="form-control decimal" type="text" value="<?= ($details)?$details->discount:''; ?>" readonly>
									</div>
								</div>
								<div class="col-md-4 mb-2">
									<div class="form-group smalls">
										<label class="form-label">Initial Amount Paid</label>
										<input class="form-control decimal"  type="text" value="<?= ($details)?$details->amount:''; ?>" readonly>
									</div>
								</div>
								<div class="col-md-12 mb-2">
									<div class="form-group smalls">
										<?= csrf_field(); ?>
										<button class="btn theme-bg text-white defaultSaveButton" type="submit">Update</button>

									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>

</div>
<?= $this->endSection(); ?>
