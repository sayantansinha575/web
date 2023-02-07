	<form action="<?= site_url('university/save-university-academic-info') ?>" id="form-university-academic-info">
		<div class="modal-body">
			<div class="row">
				<div class="col-md-12 col-sm-12 mb-2">
					<label for="test-name" class="form-label">Type of Degree <span class="text-danger">*</span></label>
					<select class="form-control" name="type_of_degree[]" id="type_of_degree" multiple>
						<option value=""></option>
						<?php if (! empty($typeOfDegree)): ?>
							<?php foreach ($typeOfDegree as $tog): ?>
								<option value="<?= $tog['id'] ?>" selected><?= $tog['title'] ?></option>
							<?php endforeach ?>
						<?php endif ?>
					</select>
					<div class="error-feedback"></div>
				</div>
				<div class="col-md-4 col-sm-12 mb-2">
					<label for="test-name" class="form-label">Preffred Program <span class="text-danger">*</span></label>
					<select class="form-control select-no-search" name="preferred_program" id="preferred_program">
						<option value="">Select Program</option>
						<option <?= (empty($details) ? '' : (($details['preferred_program']) == 'Yes' ? 'selected' : '')) ?> value="1">Yes</option>
						<option <?= (empty($details) ? '' : (($details['preferred_program']) == 'No' ? 'selected' : '')) ?> value="2">No</option>
					</select>
					<div class="error-feedback"></div>
				</div>
				<div class="col-md-8 col-sm-12 mb-2">
					<label for="test-name" class="form-label">Select from the Programs (Available) <span class="text-danger">*</span></label>
					<select class="form-control" name="programs[]" id="programs" multiple>
						<option value=""></option>
						<?php if (! empty($programs)): ?>
							<?php foreach ($programs as $prog): ?>
								<option value="<?= $prog['id'] ?>" selected><?= $prog['title'] ?></option>
							<?php endforeach ?>
						<?php endif ?>
					</select>
					<div class="error-feedback"></div>
				</div>
			</div>

		</div>
		<div class="modal-footer">
			<?= csrf_field(); ?>
			<input type="hidden" name="id" readonly id="id" value="<?= encrypt($result['id']) ?>">
			<button type="submit" class="btn btn-primary" id="btn-form-university-academic-info"><?= empty($details) ? 'Save' : 'Update'; ?></button>

			<?php if(!empty($details)): ?>
				<input type="hidden" name="sub_id" readonly id="sub_id" value="<?= encrypt($details['id']) ?>">
				<a href="<?= site_url('university/edit-university-academic-program-info/' . encrypt($result['id'])) ?>" class="btn btn-warning">Cancel</a>
			<?php else: ?>
				<a href="<?= site_url('university/edit-university-minimum-required-score/' . encrypt($result['id'])) ?>" class="btn btn-dark">Next</a>
			<?php endif ?>
		</div>
	</form>
	<hr>
	<div class="row">
		<div class="col-lg-12 col-sm-12 col-md-12">
			<table data-university="<?= $result['id'] ?>" id="academicInfo" class="table table-bordered table-striped row-grouping display no-wrap icheck table-middle dataTable no-footer">
				<thead>
					<tr>
						<th>Type of Degree</th>
						<th>Select from the Programs (Available)</th>
						<th>Preffred Program</th>
						<th class="text-center">Action</th>
					</tr>
				</thead>
			</table>
		</div>
	</div>