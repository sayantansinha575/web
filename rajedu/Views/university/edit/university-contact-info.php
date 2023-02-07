<form action="<?= site_url('university/save-university-contact') ?>" id="form-university-contact-info">
	<div class="card-body">
		<div class="row">
			<div class="col-md-6 com-sm-12">
				<label for="test-name" class="form-label">Type of Contact <span class="text-danger">*</span></label>
				<select class="form-control select-no-search" name="type_of_contact" id="intake">
					<option value="">Select Contact</option>
					<option <?= (empty($details) ? '' : (($details['type_of_contact']) == 'Accounts / Invoice' ? 'selected' : '')) ?> value="Accounts / Invoice">Accounts / Invoice</option>
					<option <?= (empty($details) ? '' : (($details['type_of_contact']) == 'Director' ? 'selected' : '')) ?> value="Director">Director</option>
					<option <?= (empty($details) ? '' : (($details['type_of_contact']) == 'For App Status' ? 'selected' : '')) ?> value="For App Status">For App Status</option>
					<option <?= (empty($details) ? '' : (($details['type_of_contact']) == 'Primary' ? 'selected' : '')) ?> value="Primary">Primary</option>
					<option <?= (empty($details) ? '' : (($details['type_of_contact']) == 'Secondary' ? 'selected' : '')) ?> value="Secondary">Secondary</option>
					<option <?= (empty($details) ? '' : (($details['type_of_contact']) == 'Third' ? 'selected' : '')) ?> value="Third">Third</option>
				</select>
				<div class="error-feedback"></div>
			</div>
			<div class="col-md-6 col-sm-12">
				<div class="form-group floating-label-form-group">
					<label for="test-name" class="form-label">Name <span class="text-danger">*</span></label>
					<input type="text" class="form-control" id="name" name="name" value="<?= empty($details) ? '' : $details['name'] ?>">
					<div class="error-feedback"></div>
				</div>
			</div>
			<div class="col-md-6 col-sm-12">
				<div class="form-group floating-label-form-group">
					<label for="test-name" class="form-label">Designation <span class="text-danger">*</span></label>
					<input type="text" class="form-control" id="designation" name="designation" value="<?= empty($details) ? '' : $details['designation'] ?>">
					<div class="error-feedback"></div>
				</div>
			</div>
			<div class="col-md-6 col-sm-12">
				<div class="form-group floating-label-form-group">
					<label for="test-name" class="form-label">Email <span class="text-danger">*</span></label>
					<input type="email" class="form-control" id="email" name="email" value="<?= empty($details) ? '' : $details['email'] ?>">
					<div class="error-feedback"></div>
				</div>
			</div>
			<div class="col-md-6 col-sm-12">
				<div class="form-group floating-label-form-group">
					<label for="test-name" class="form-label">Contact <span class="text-danger">*</span></label>
					<input type="text" class="form-control" id="contact" name="contact" value="<?= empty($details) ? '' : $details['contact'] ?>">
					<div class="error-feedback"></div>
				</div>
			</div>
			<div class="col-md-6 col-sm-12">
				<div class="form-group floating-label-form-group">
					<label for="test-name" class="form-label">Alternative Contact <span class="text-danger"></span></label>
					<input type="text" class="form-control" id="alternative_contact" name="alternative_contact" value="<?= empty($details) ? '' : $details['alternative_contact'] ?>">
					<div class="error-feedback"></div>
				</div>
			</div>
		</div>
	</div>
	<div class="modal-footer">
		<?= csrf_field(); ?>
		<input type="hidden" name="id" readonly id="id" value="<?= encrypt($result['id']) ?>">
		<button type="submit" class="btn btn-primary" id="btn-form-university-contact-info"><?= empty($details) ? 'Save' : 'Update'; ?></button>
		<?php if(!empty($details)): ?>
			<input type="hidden" name="sub_id" readonly id="sub_id" value="<?= encrypt($details['id']) ?>">
			<a href="<?= site_url('university/edit-university-contact-info/' . encrypt($result['id'])) ?>" class="btn btn-warning">Cancel</a>
		<?php else: ?>
			<a href="<?= site_url('university/edit-university-academic-program-info/' . encrypt($result['id'])) ?>" class="btn btn-dark">Next</a>
		<?php endif ?>
	</div>
</form>
<hr>
<div class="row">
	<div class="col-lg-12 col-sm-12 col-md-12">
		<table data-university="<?= $result['id'] ?>" id="universityContactInfo" class="table table-white-space table-bordered table-striped row-grouping display no-wrap icheck table-middle dataTable no-footer">
			<thead>
				<tr>

					<th>Type of Contact</th>
					<th>Name</th>
					<th>Designation</th>
					<th>Email</th>
					<th>Contact</th>
					<th class="text-center">Action</th>
				</tr>
			</thead>
		</table>
	</div>
</div>