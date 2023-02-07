<form action="<?= site_url('university/update-university') ?>" id="form-update-university">
	<div class="modal-body">
		<div class="row">
			<div class="col-md-6 com-sm-12">
				<div class="form-group floating-label-form-group">
					<label for="test-name" class="form-label">Univercity Name <span class="text-danger">*</span></label>
					<input type="text" class="form-control" id="university_name" value="<?= $result['university_name']; ?>" name="university_name" placeholder="Enter Univercity Name...">
					<div class="error-feedback"></div>
				</div>
			</div>
			<div class="col-md-6 com-sm-12">
				<div class="form-group floating-label-form-group">
					<label for="test-name" class="form-label">Upload Logo <span class="text-danger">*</span></label>
					<input type="file" class="form-control" id="university_logo" name="university_logo">
					<div class="error-feedback"></div>
				</div>
			</div>
			<div class="col-md-6 col-sm-12">
				<div class="form-group floating-label-form-group">
					<label for="test-name" class="form-label">Country <span class="text-danger">*</span></label>
					<select name="country" id="country" class="form-control country-list">
						<option value=""></option>
					</select>
					<div class="error-feedback"></div>
				</div>
			</div>
			<div class="col-md-6 col-sm-12">
				<div class="form-group floating-label-form-group">
					<label for="test-name" class="form-label">State <span class="text-danger">*</span></label>
					<select name="state" id="state" class="form-control state-list">
						<option value=""></option>
					</select>
					<div class="error-feedback"></div>
				</div>
			</div>
			<div class="col-md-6 col-sm-12">
				<div class="form-group floating-label-form-group">
					<label for="test-name" class="form-label">City <span class="text-danger">*</span></label>
					<select name="city" id="city" class="form-control city-list">
						<option value=""></option>
					</select>
					<div class="error-feedback"></div>
				</div>
			</div>
			<div class="col-md-6 col-sm-12">
				<div class="form-group floating-label-form-group">
					<label for="test-name" class="form-label">Region <span class="text-danger"></span></label>
					<input type="text"  value="<?= $result['region']; ?>" class="form-control" id="region" name="region" placeholder="Enter region...">
					<div class="error-feedback"></div>
				</div>
			</div>
			<div class="col-md-6 col-sm-12">
				<div class="form-group floating-label-form-group">
					<label for="test-name" class="form-label">Address <span class="text-danger">*</span></label>
					<textarea class="form-control" 	id="address" name="address" placeholder="Enter Address..."><?= $result['address']; ?></textarea>
					<div class="error-feedback"></div>
				</div>
			</div>
			<div class="col-md-6 com-sm-12">
				<label for="test-name" class="form-label">Intake <span class="text-danger">*</span></label>
				<select class="form-control select-no-search" name="intake" id="intake">
					<option value="">Select Intake</option>
					<option <?= ($result['intake'] == 'Fall') ? 'selected' : '';  ?> value="Fall">Fall</option>
					<option <?= ($result['intake'] == 'Spring') ? 'selected' : '';  ?> value="Spring">Spring</option> 
					<option <?= ($result['intake'] == 'Summer') ? 'selected' : '';  ?> value="Summer">Summer</option>
				</select>
				<div class="error-feedback"></div>
			</div>
			<div class="col-md-6 col-sm-12">
				<div class="form-group floating-label-form-group">
					<label for="test-name" class="form-label">Year of Establishment <span class="text-danger">*</span></label>
					<input type="date" class="form-control flatpicker" id="date_of_establishment" value="<?= date('Y-m-d', $result['date_of_establishment']); ?>" name="date_of_establishment">
					<div class="error-feedback"></div>
				</div>
			</div> 
			<div class="col-md-6 col-sm-12">
				<div class="form-group floating-label-form-group">
					<label for="test-name" class="form-label">Total Students (count)<span class="text-danger"></span></label>
					<input type="text" class="form-control" id="total_students"  value="<?= $result['total_students']; ?>" name="total_students" placeholder="Enter Total Students...">
					<div class="error-feedback"></div>
				</div>
			</div>
			<div class="col-md-6 col-sm-12">
				<div class="form-group floating-label-form-group">
					<label for="test-name" class="form-label">Under Graduate (count)<span class="text-danger"></span></label>
					<input type="text"  value="<?= $result['under_graduate']; ?>" class="form-control" id="under_graduate" name="under_graduate" placeholder="Enter Under Graduate...">
					<div class="error-feedback"></div>
				</div>
			</div>
			<div class="col-md-6 col-sm-12">
				<div class="form-group floating-label-form-group">
					<label for="test-name" class="form-label">Graduate (count) <span class="text-danger"></span></label>
					<input type="text"  value="<?= $result['graduate']; ?>" class="form-control" id="graduate" name="graduate" placeholder="Enter Graduate...">
					<div class="error-feedback"></div>
				</div>
			</div>
		</div>
	</div>
	<div class="modal-footer">
		<?= csrf_field(); ?>
		<input type="hidden" name="id" readonly id="id" value="<?= encrypt($result['id']) ?>">
		<button type="submit" class="btn btn-primary" id="btn-form-university">Update & Next</button>
	</div>
</form>