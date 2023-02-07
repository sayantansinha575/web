	<form action="<?= site_url('university/save-university-required-score-info') ?>" id="form-university-required-score-info">
		<div class="modal-body">
			<div class="row">
				<div class="col-md-6 com-sm-12">
					<label for="test-name" class="form-label">Type of Exam <span class="text-danger">*</span></label>
					<select class="form-control" name="exam_type" id="exam_type">
						<option value="">Select Exam</option>
						<?php if (! empty($exams)): ?>
							<?php foreach ($exams as $exam): ?>
								<option selected value="<?= $exam['id']; ?>"><?= $exam['title']; ?></option>
							<?php endforeach ?>
						<?php endif ?>
					</select>
					<div class="error-feedback"></div>
				</div>
				<div class="col-md-6 col-sm-12">
					<div class="form-group floating-label-form-group">
						<label for="test-name" class="form-label">Minimum Score <span class="text-danger">*</span></label>
						<input type="text" class="form-control" id="minimum_score" name="minimum_score" value="<?= empty($details) ? '' : abs($details['minimum_score']) ?>">
						<div class="error-feedback"></div>
					</div>
				</div>
				<div class="col-md-6 col-sm-12">
					<div class="form-group floating-label-form-group">
						<label for="test-name" class="form-label">Average Score <span class="text-danger"></span></label>
						<input type="text" class="form-control" id="average_score" name="average_score" value="<?= empty($details) ? '' : abs($details['average_score']) ?>">
						<div class="error-feedback"></div>
					</div>
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
				<input type="hidden" name="id" readonly id="id" value="<?= encrypt($result['id']) ?>">
				<button type="submit" class="btn btn-primary" id="btn-form-university-required-score-info"><?= empty($details) ? 'Save' : 'Update'; ?></button>

				<?php if(!empty($details)): ?>
					<input type="hidden" name="sub_id" readonly id="sub_id" value="<?= encrypt($details['id']) ?>">
					<a href="<?= site_url('university/edit-university-minimum-required-score/' . encrypt($result['id'])) ?>" class="btn btn-warning">Cancel</a>
				<?php else: ?>
					<a href="<?= site_url('university/edit-university-admission-info/' . encrypt($result['id'])) ?>" class="btn btn-dark">Next</a>
				<?php endif ?>
			</div>
		</form>
		<hr>
		<div class="row">
			<div class="col-lg-12 col-sm-12 col-md-12">
				<table data-university="<?= $result['id'] ?>" id="requiredScoreInfo" class="table table-bordered table-striped row-grouping display no-wrap icheck table-middle dataTable no-footer">
					<thead>
						<tr>
							<th>Type of Exam</th>
							<th>Minimum Score</th>
							<th>Average Score</th>
							<th>Comments</th>
							<th class="text-center">Action</th>
						</tr>
					</thead>
				</table>
			</div>
		</div>