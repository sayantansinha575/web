	<form action="<?= site_url('university/save-university-application-info') ?>" id="form-university-application-info">
		<div class="modal-body">
			<div class="row">
				<div class="col-md-4 com-sm-12 mb-2">
					<label for="test-name" class="form-label">Type of Degree <span class="text-danger">*</span></label>
					<select class="form-control"  <?= (empty($details) ? '' : (($details['used_in_registration']) == 'Yes' ? 'disabled' : '')) ?> name="type_of_degree" id="type_of_degree" data-type="select2">
						<option value=""></option>
						<?php if (! empty($typeOfDegree)): ?>
							<?php foreach ($typeOfDegree as $tog): ?>
								<option <?= (empty($details) ? '' : (($details['type_of_degree']) == $tog['id'] ? 'selected' : '')) ?> value="<?= $tog['id'] ?>"><?= $tog['title'] ?></option>
							<?php endforeach ?>
						<?php endif ?>
					</select>
					<div class="error-feedback"></div>
				</div>
				<div class="col-md-4 com-sm-12 mb-2">
					<label for="test-name" class="form-label">Fee Type <span class="text-danger">*</span></label>
					<select class="form-control" name="fee_type" id="fee_type" data-type="select2">
						<option value=""></option>
						<?php if (! empty($feeType)): ?>
							<?php foreach ($feeType as $fee): ?>
								<option <?= (empty($details) ? '' : (($details['fee_type']) == $fee['id'] ? 'selected' : '')) ?> value="<?= $fee['id'] ?>"><?= $fee['title'] ?></option>
							<?php endforeach ?>
						<?php endif ?>
					</select>
					<div class="error-feedback"></div>
				</div>
				<div class="col-md-4 com-sm-12 mb-2">
					<label for="test-name" class="form-label">Cost Type <span class="text-danger">*</span></label>
					<select class="form-control" name="cost_type" id="cost_type" data-type="select2">
						<option value=""></option>
						<?php if (! empty($costType)): ?>
							<?php foreach ($costType as $cost): ?>
								<option <?= (empty($details) ? '' : (($details['cost_type']) == $cost['id'] ? 'selected' : '')) ?> value="<?= $cost['id'] ?>"><?= $cost['title'] ?></option>
							<?php endforeach ?>
						<?php endif ?>
					</select>
					<div class="error-feedback"></div>
				</div>
				<div class="col-md-4 com-sm-12 mb-2">
					<label for="test-name" class="form-label">Currency Symbol <span class="text-danger">*</span></label>
					<select class="form-control" name="currency_symbol" id="currency_symbol" data-type="select2">
						<option value=""></option>
						<?php if (! empty($currency)): ?>
							<?php foreach ($currency as $curren): ?>
								<option <?= (empty($details) ? '' : (($details['currency_symbol']) == $curren['id'] ? 'selected' : '')) ?> value="<?= $curren['id'] ?>"><?= $curren['title'] ?></option>
							<?php endforeach ?>
						<?php endif ?>
					</select>
					<div class="error-feedback"></div>
				</div>
				<div class="col-md-4 com-sm-12 mb-2">
					<label for="test-name" class="form-label">Fee Amount <span class="text-danger">*</span></label>
					<input type="text" class="form-control" name="fee_amount" id="fee_amount" value="<?= empty($details) ? '' : $details['fee_amount'] ?>">
					<div class="error-feedback"></div>
				</div>
				<div class="col-md-4 com-sm-12 mb-2">
					<label for="test-name" class="form-label">Used in Registration <span class="text-danger">*</span></label>
					<select class="form-control select-no-search" <?= (empty($details) ? '' : (($details['used_in_registration']) == 'Yes' ? 'disabled' : '')) ?> name="used_in_registration" id="used_in_registration">
						<option value=""></option>
						<option <?= (empty($details) ? '' : (($details['used_in_registration']) == 'Yes' ? 'selected' : '')) ?> value="1">Yes</option>
						<option <?= (empty($details) ? '' : (($details['used_in_registration']) == 'No' ? 'selected' : '')) ?> value="2">No</option>
					</select>
					<div class="error-feedback"></div>
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<?= csrf_field(); ?>
			<input type="hidden" name="id" readonly id="id" value="<?= encrypt($result['id']) ?>">
			<button type="submit" class="btn btn-primary" id="btn-university-application-info"><?= empty($details) ? 'Save' : 'Update'; ?></button>
			<?php if(!empty($details)): ?>
				<?php if ($details['used_in_registration'] == 'Yes'): ?>
					<input type="hidden" name="used_in_registration" value="<?= $details['used_in_registration'] ?>">
					<input type="hidden" name="type_of_degree" value="<?= $details['type_of_degree'] ?>">
				<?php endif ?>
				<input type="hidden" name="sub_id" readonly id="sub_id" value="<?= encrypt($details['id']) ?>">
				<a href="<?= site_url('university/edit-university-application-info/' . encrypt($result['id'])) ?>" class="btn btn-warning">Cancel</a>
			<?php else: ?>
				<a href="<?= site_url('university/edit-university-documents-check-list/' . encrypt($result['id'])) ?>" class="btn btn-dark">Next</a>
			<?php endif ?>
		</div>
	</form>

	<hr>
	<div class="row mt-5">
		<div class="col-lg-12 col-sm-12 col-md-12">
			<table data-university="<?= encrypt($result['id']) ?>" id="applicationInfoTable" class="table table-bordered table-striped row-grouping display no-wrap icheck table-middle dataTable no-footer">
				<thead>
					<tr>
						<th>Degree Type</th>
						<th>Fee Type</th>
						<th>Cost Type</th>
						<th>Currency</th>
						<th>Fee</th>
						<th>Used In Registration</th>
						<th class="text-center">Action</th>
					</tr>
				</thead>
			</table>
		</div>
	</div>