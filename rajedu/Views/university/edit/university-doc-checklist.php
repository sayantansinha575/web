	<form action="<?= site_url('university/save-university-documents-check-list') ?>" id="form-university-documents-check-list">
		<div class="modal-body">
			<div class="row">
				<div class="col-md-6 com-sm-12 mb-2">
					<label for="test-name" class="form-label">Level of Degree <span class="text-danger">*</span></label>
					<select class="form-control" name="level_of_degree[]" id="level_of_degree" multiple>
						<option value=""></option>
						<?php if (! empty($details) && ! empty($levelOfDegree)): ?>
							<?php foreach ($levelOfDegree as $tog): ?>
								<option value="<?= $tog['id'] ?>" selected><?= $tog['title'] ?></option>
							<?php endforeach ?>
						<?php endif ?>
					</select>
					<div class="error-feedback"></div>
				</div>
				<div class="col-md-6 com-sm-12 mb-2">
					<label for="test-name" class="form-label">Document Name <span class="text-danger">*</span></label>
					<select class="form-control" name="document_name[]" id="document_name" multiple>
						<option value=""></option>
						<?php if (! empty($details) && ! empty($documentsName)): ?>
							<?php foreach ($documentsName as $doc): ?>
								<option value="<?= $doc['id'] ?>" selected><?= $doc['title'] ?></option>
							<?php endforeach ?>
						<?php endif ?>
					</select>
					<div class="error-feedback"></div>
				</div>
				<div class="col-md-6 com-sm-12 mb-2">
					<label for="mandatory" class="form-label">Mandatory <span class="text-danger">*</span></label>
					<select class="form-control select-no-search" name="mandatory" id="mandatory">
						<option value=""></option>
						<option <?= (empty($details) ? '' : (($details['mandatory']) == 'Yes' ? 'selected' : '')) ?> value="1">Yes</option>
						<option <?= (empty($details) ? '' : (($details['mandatory']) == 'No' ? 'selected' : '')) ?> value="2">No</option>
					</select>
					<div class="error-feedback"></div>
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<?= csrf_field(); ?>
			<input type="hidden" name="id" readonly id="id" value="<?= encrypt($result['id']) ?>">
			<button type="submit" class="btn btn-primary" id="btn-documents-check-list"><?= empty($details) ? 'Save' : 'Update'; ?></button>
			<?php if(!empty($details)): ?>
				<input type="hidden" name="sub_id" readonly id="sub_id" value="<?= encrypt($details['id']) ?>">
				<a href="<?= site_url('university/edit-university-documents-check-list/' . encrypt($result['id'])) ?>" class="btn btn-warning">Cancel</a>
			<?php else: ?>
				<a href="<?= site_url('university/list/') ?>" class="btn btn-dark">Finish</a>
			<?php endif ?>
		</div>
	</form>

	<hr>
	<div class="row mt-5">
		<div class="col-lg-12 col-sm-12 col-md-12">
			<table data-university="<?= encrypt($result['id']) ?>" id="docChecklistable" class="table table-bordered table-striped row-grouping display no-wrap icheck table-middle dataTable no-footer">
				<thead>
					<tr>
						<th>Level Of Degree</th>
						<th>Document Name</th>
						<th>Mandatory</th>
						<th class="text-center">Action</th>
					</tr>
				</thead>
			</table>
		</div>
	</div>