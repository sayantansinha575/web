<?= $this->extend('branch/layOut'); ?>
<?= $this->section('body');?>

<div class="col-lg-9 col-md-9 col-sm-12">

	<div class="row">
		<div class="col-xl-12 col-lg-12 col-md-12 pt-4">
			<div class="dashboard_wrap">

				<div class="row">
					<div class="col-xl-12 col-lg-12 col-md-12 mb-2">
						<h6 class="m-0">Student Details</h6><hr>
					</div>
				</div>

				<div class="row justify-content-center">
					<div class="col-xl-12 col-lg-12 col-md-12">
						<form action="<?= site_url('branch/student/registration').$id; ?>" id="formEnroll" accept-charset="UTF-8" autocomplete="off">
							<div class="row">
								<div class="col-md-6 mb-3">
									<div class="form-group smalls">
										<label class="form-label">Name <span class="text-danger">*</span></label>
										<input type="text" class="form-control uppercase" name="student_name" id="student_name" placeholder="Enter student name" value="<?= ($details)?$details->student_name:''; ?>">
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
										<input type="text" class="form-control" name="mobile" id="mobile" value="<?= ($details)?$details->mobile:''; ?>" autocomplete="off">
									</div>
								</div>
								<div class="col-md-12 mb-3">
									<div class="form-group">
										<label class="form-label">Residential Address<span class="text-danger">*</span></label>
										<textarea name="residential_address" id="residential_address" rows="3" class="form-control" placeholder="Enter recidential address"><?= ($details)?$details->residential_address:''; ?></textarea>
									</div>
								</div>
								<div class="col-md-6 mb-3">
									<div class="form-group smalls">
										<label class="form-label">Password <?= (empty($details)?'<span class="text-danger">*</span>':'<small>(Leave it as it is if you do not want to change your password)</small>') ?></label>
										<input type="text" class="form-control pwd" name="password" id="password" value="" autocomplete="off">
										<small><b> Minimum length 8 and should include at least one upper case letter, one number, and one special character. </b></small>
									</div>
								</div>
								<div class="col-md-6 mb-3">
									<div class="form-group smalls">
										<label class="form-label">Confirm Password <?= (empty($details)?'<span class="text-danger">*</span>':'<small>(Leave it as it is if you do not want to change your password)</small>') ?></label>
										<input type="text" class="form-control pwd" name="confirm_password" id="confirm_password" value="" autocomplete="off">
									</div>
								</div>
								
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
										<input type="text" class="form-control uppercase" name="father_name" id="father_name" placeholder="Enter father's name" value="<?= ($details)?$details->father_name:''; ?>">
									</div>
								</div>
								<div class="col-md-6 mb-3">
									<div class="form-group smalls">
										<label class="form-label">Mother's Name <span class="text-danger">*</span></label>
										<input type="text" class="form-control uppercase" name="mother_name" id="mother_name" placeholder="Enter mother's name" value="<?= ($details)?$details->mother_name:''; ?>">
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-xl-12 col-lg-12 col-md-12 mb-2">
									<h6 class="header-title">Documents</h6><hr>
								</div>
							</div>

						
							<div class="row holder">
								<div class="col-md-3 col-xl-3 col-lg-3 col-sm-12 mb-3">
									<div class="form-group smalls">
										<label>Document Type <span class="text-danger">*</span></label>
										<select name="qualification_document_type" id="qualification_document_type" class="form-control selectNoSearch">
											<option value=""></option>
											<option <?= ($details)?($details->qualification_document_type == 'Marksheet')?'selected':'':''; ?> value="Marksheet">Marksheet</option>
											<option <?= ($details)?($details->qualification_document_type == 'Certificate')?'selected':'':''; ?> value="Certificate">Certificate</option>
										</select>
									</div>
								</div>
								<div class="col-md-7 col-xl-7 col-lg-7 col-sm-12 mb-3">
									<div class="form-group smalls">
										<label>Qualification <small> <span class="text-danger">*</span> (Photocopy(xerox) of last educational qualification marksheet/certificate.)</small></label>
										<div class="custom-file">
											<input type="file" class="custom-file-input file-size-valid" name="qualification_file" id="qualification_file"  accept="image/*">
											<label class="custom-file-label" for="customFile">Choose Educational Qualification </label>
										</div>
										<input type="hidden" name="oldQualificationFile" value="<?= ($details)?$details->qualification_file:''; ?>">
									</div>
								</div>
								<div class="col-md-2 col-xl-2 col-lg-2 col-sm-12 file-preview mb-3">
									<img src="<?= empty($details->qualification_file)?site_url('public/headoffice/images/default/defaultImage.png'):site_url('public/upload/branch-files/student/qualification-file/'.$details->qualification_file); ?>" alt="preview" class="img-fluid img-responsive img-thumbnail previewImg">
								</div>
							</div>
							<div class="row holder">
								<div class="col-md-3 col-xl-3 col-lg-3 col-sm-12 mb-3">
									<div class="form-group smalls">
										<label>Document Type <span class="text-danger">*</span></label>
										<select name="identity_card_type" id="identity_card_type" class="form-control selectNoSearch">
											<option value=""></option>
											<option <?= ($details)?($details->identity_card_type == 'Voter Card')?'selected':'':''; ?> value="Voter Card">Voter Card</option>
											<option <?= ($details)?($details->identity_card_type == 'Aadhar Card')?'selected':'':''; ?> value="Aadhar Card">Aadhar Card</option>
											<option <?= ($details)?($details->identity_card_type == 'PAN Card')?'selected':'':''; ?> value="PAN Card">PAN Card</option>
											<option <?= ($details)?($details->identity_card_type == 'School Identity Card')?'selected':'':''; ?> value="School Identity Card">School Identity Card</option>
										</select>
									</div>
								</div>
								<div class="col-md-7 col-xl-7 col-lg-7 col-sm-12 mb-3">
									<div class="form-group smalls">
										<label>Identity Proof <span class="text-danger">*</span></small></label>
										<div class="custom-file">
											<input type="file" class="custom-file-input file-size-valid" name="identity_proof" id="identity_proof"  accept="image/*">
											<label class="custom-file-label" for="customFile">Choose Idenity Proof</label>
										</div>
										<input type="hidden" name="oldIdentityFile" value="<?= ($details)?$details->identity_proof:''; ?>">
									</div>
								</div>
								<div class="col-md-2 col-xl-2 col-lg-2 col-sm-12 file-preview mb-3">
									<img src="<?= empty($details->identity_proof)?site_url('public/headoffice/images/default/defaultImage.png'):site_url('public/upload/branch-files/student/identity-proof-file/'.$details->identity_proof); ?>" alt="preview" class="img-fluid img-responsive img-thumbnail previewImg">
								</div>
							</div>
							<div class="row holder">
								<div class="col-md-10 col-xl-10 col-lg-10 col-sm-12 mb-3">
									<div class="form-group smalls">
										<label>Student's Photo<b> (150X150 px) </b> <span class="text-danger">*</span><small></small></label>
										<div class="custom-file">
											<input type="file" class="custom-file-input hundredFiftyXhundredFifty" name="student_photo" id="student_photo"  accept=".jpg,.jpeg,.png">
											<label class="custom-file-label" for="customFile">Choose Student's Photograph</label>
										</div>
										<input type="hidden" name="oldStudentFile" value="<?= ($details)?$details->student_photo:''; ?>">
									</div>
								</div>
								<div class="col-md-2 col-xl-2 col-lg-2 col-sm-12 file-preview mb-3">
									<img src="<?= empty($details->student_photo)?site_url('public/headoffice/images/default/defaultImage.png'):site_url('public/upload/branch-files/student/student-image/'.$details->student_photo); ?>" alt="preview" class="img-fluid img-responsive img-thumbnail previewImg">
								</div>
							</div>
							<div class="form-group smalls">
								<?= csrf_field(); ?>
								<button class="btn theme-bg text-white btnSaveStudentEnroll" data-continue="0" type="submit"><?= empty($details)?'Save Details':'Update'; ?></button>
								<button class="btn theme-bg text-white btnSaveStudentEnroll" data-continue="1" type="submit"><?= empty($details)?'Add & Enroll':'Update & Enroll'; ?></button>
								
							</div>
						</div>
					</form>
				</div>
			</div>

		</div>
	</div>

</div>
<?= $this->endSection(); ?>
