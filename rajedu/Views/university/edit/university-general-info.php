<form action="<?= site_url('university/update-university-general-info') ?>" id="form-university-general-info">
	<div class="modal-body">
		<div class="row">

			<div class="col-md-12 col-sm-12">
				<div class="form-group floating-label-form-group">
					<label for="test-name" class="form-label">About University <span class="text-danger">*</span></label>
					<textarea class="form-control editor" rows="7" id="about_university" name="about_university" ><?= $result['about_university']; ?></textarea>
					<div class="error-feedback"></div>
				</div>
			</div>
				<div class="col-md-12 col-sm-12">
				<div class="form-group floating-label-form-group">
					<label for="test-name" class="form-label">App Procedure <span class="text-danger">*</span></label>
					<textarea class="form-control editor" rows="7" id="app_procedure" name="app_procedure"><?= $result['app_procedure']; ?></textarea>
					<div class="error-feedback"></div>
				</div>
			</div>
				<div class="col-md-12 col-sm-12">
				<div class="form-group floating-label-form-group">
					<label for="test-name" class="form-label">Follow up Procedure <span class="text-danger">*</span></label>
					<textarea class="form-control editor" rows="7" id="follow_up_procedure" name="follow_up_procedure" ><?= $result['follow_up_procedure']; ?></textarea>
					<div class="error-feedback"></div>
				</div>
			</div>
				<div class="col-md-12 col-sm-12">
				<div class="form-group floating-label-form-group">
					<label for="test-name" class="form-label">Deferment Procedure <span class="text-danger">*</span></label>
					<textarea class="form-control editor" rows="7" id="deferment_procedure" name="deferment_procedure" ><?= $result['deferment_procedure']; ?></textarea>
					<div class="error-feedback"></div>
				</div>
			</div>

		</div>
	</div>
	<div class="modal-footer">
		<?= csrf_field(); ?>
		<input type="hidden" name="id" readonly id="id" value="<?= encrypt($result['id']) ?>">
		<button type="submit" class="btn btn-primary" id="btn-form-university-general-info">Save & Next</button>
	</div>
</form>