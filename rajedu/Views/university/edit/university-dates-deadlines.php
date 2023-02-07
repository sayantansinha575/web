	<form action="<?= site_url('university/save-university-deadline-info') ?>" id="form-university-deadline-info">
		<div class="modal-body">
			<div class="row">
				<div class="col-md-4 com-sm-12">
					<label for="test-name" class="form-label">Deadline Type <span class="text-danger">*</span></label>
					<select class="form-control select-no-search" name="deadline_type" id="deadline_type">
						<option value=""></option>
						<option <?= (empty($details) ? '' : (($details['deadline_type']) == 'Early' ? 'selected' : '')) ?> value="1">Early</option>
						<option <?= (empty($details) ? '' : (($details['deadline_type']) == 'Regular' ? 'selected' : '')) ?> value="2">Regular</option>
					</select>
					<div class="error-feedback"></div>
				</div>
				<div class="col-md-4 com-sm-12">
					<label for="test-name" class="form-label">Deadlines intake <span class="text-danger">*</span></label>
					<select class="form-control select-no-search" data-placeholder="Select deadlines intake" name="deadline_intake" id="deadline_intake">
						<option value=""></option>
						<option <?= (empty($details) ? '' : (($details['deadline_intake']) == 'Fall' ? 'selected' : '')) ?> value="Fall">Fall</option>
						<option <?= (empty($details) ? '' : (($details['deadline_intake']) == 'Spring' ? 'selected' : '')) ?> value="Spring">Spring</option>
						<option <?= (empty($details) ? '' : (($details['deadline_intake']) == 'Summer' ? 'selected' : '')) ?> value="Summer">Summer</option>
					</select>
					<div class="error-feedback"></div>
				</div>
				<div class="col-md-4 col-sm-12">
					<div class="form-group floating-label-form-group">
						<label for="test-name" class="form-label">Date <span class="text-danger">*</span></label>
						<input type="text" class="form-control flatpicker" id="date" name="date" value="<?= empty($details) ? '' : date('Y-m-d', $details['date']); ?>">
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
				<a href="<?= site_url('university/edit-university-deadline/' . encrypt($result['id'])) ?>" class="btn btn-warning">Cancel</a>
			<?php else: ?>
				<a href="<?= site_url('university/edit-university-application-info/' . encrypt($result['id'])) ?>" class="btn btn-dark">Next</a>
			<?php endif ?>
		</div>
	</form>

	<hr>
	<div class="row mt-5">
		<div class="col-lg-12 col-sm-12 col-md-12">
			<table data-university="<?= encrypt($result['id']) ?>" id="dtUniDeadlines" class="table table-bordered table-striped row-grouping display no-wrap icheck table-middle dataTable no-footer">
				<thead>
					<tr>
						<th>Type</th>
						<th>Intake</th>
						<th>Date</th>
						<th class="text-center">Action</th>
					</tr>
				</thead>
			</table>
		</div>
	</div>