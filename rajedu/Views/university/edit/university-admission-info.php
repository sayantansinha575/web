<form action="<?= site_url('university/save-university-admission-info') ?>" id="form-university-admission-info">
	<div class="modal-body">
		<div class="row">
			<div class="col-md-6 col-sm-12">
				<div class="form-group floating-label-form-group">
					<label for="test-name" class="form-label">University ETScode <span class="text-danger">*</span></label>
					<input type="text" class="form-control" value="<?= empty($details) ? '' : $details['ets_score'] ?>" id="ets_score" name="ets_score" >
					<div class="error-feedback"></div>
				</div>
			</div>
			<div class="col-md-6 col-sm-12">
				<div class="form-group floating-label-form-group">
					<label for="test-name" class="form-label">Application Type <span class="text-danger">*</span></label>
					<select class="form-control select-no-search" name="application_type" id="application_type">
						<option value=""></option>
						<option <?= (empty($details) ? '' : (($details['application_type'] == 'Online') ? 'selected' : '')) ?> value="1">Online</option>
						<option <?= (empty($details) ? '' : (($details['application_type'] == 'Paper') ? 'selected' : '')) ?> value="2">Paper</option>
					</select>
					<div class="error-feedback"></div>
				</div>
			</div>
			<div class="col-md-6 col-sm-12">
				<div class="form-group floating-label-form-group">
					<label for="test-name" class="form-label">Min Academic Percentage <span class="text-danger">*</span></label>
					<input type="text" class="form-control" id="min_acc_percentage" name="min_acc_percentage" value="<?= empty($details) ? '' : $details['min_acc_percentage'] ?>">
					<div class="error-feedback"></div>
				</div>
			</div>
			<div class="col-md-6 col-sm-12">
				<div class="form-group floating-label-form-group">
					<label for="test-name" class="form-label">Max Back logs Allowed <span class="text-danger">*</span></label>
					<input type="text" class="form-control" id="max_back_logs" name="max_back_logs" value="<?= empty($details) ? '' : $details['max_back_logs'] ?>">
					<div class="error-feedback"></div>
				</div>
			</div>
			<div class="col-md-6 col-sm-12">
				<div class="form-group floating-label-form-group">
					<label for="test-name" class="form-label">Amount Bank Statement Req <span class="text-danger">*</span></label>
					<input type="text" class="form-control" id="amount" name="amount" value="<?= empty($details) ? '' : $details['amount'] ?>">
					<div class="error-feedback"></div>
				</div>
			</div>
			<div class="col-md-6 com-sm-12">
				<label for="test-name" class="form-label">Photo Copis of test scores Accepted <span class="text-danger">*</span></label>
				<select class="form-control select-no-search" name="test_score_photo_copy" id="test_score_photo_copy">
					<option value="">Select Accepted</option>
					<option <?= (empty($details) ? '' : (($details['test_score_photo_copy'] == 'Yes') ? 'selected' : '')) ?> value="1">Yes</option>
					<option <?= (empty($details) ? '' : (($details['test_score_photo_copy'] == 'No') ? 'selected' : '')) ?> value="2">No</option>
				</select>
				<div class="error-feedback"></div>
			</div>
			<div class="col-md-6 com-sm-12">
				<label for="test-name" class="form-label">Mode of Dispatch(MOD) <span class="text-danger">*</span></label>
				<select class="form-control select-no-search" name="dispatch_mode" id="dispatch_mode">
					<option value="">/option>
					<option <?= (empty($details) ? '' : (($details['dispatch_mode'] == 'Email') ? 'selected' : '')) ?> value="1">Email</option>
					<option <?= (empty($details) ? '' : (($details['dispatch_mode'] == 'Upload') ? 'selected' : '')) ?> value="2">Upload</option>
					<option <?= (empty($details) ? '' : (($details['dispatch_mode'] == 'Courier') ? 'selected' : '')) ?> value="3">Courier</option>
				</select>
				<div class="error-feedback"></div>
			</div>
			<div class="col-md-6 col-sm-12">
				<div class="form-group floating-label-form-group">
					<label for="test-name" class="form-label">Comments <span class="text-danger"></span></label>
					<textarea class="form-control" rows="3" id="comment" name="comment" ><?= empty($details) ? '' : $details['comment'] ?></textarea>
					<div class="error-feedback"></div>
				</div>
			</div>

		</div>
		<div class="modal-footer">
			<?= csrf_field(); ?>
			<input type="hidden" name="id" readonly id="id" value="<?= encrypt($result['id']); ?>">
			<?php if (!empty($details)): ?>
				<input type="hidden" name="sub_id" readonly id="sub_id" value="<?= encrypt($details['id']) ?>">
			<?php endif ?>
			<button type="submit" class="btn btn-primary" id="btn-form-university-admission-info">Save & Next</button>

		</div>
	</form>

