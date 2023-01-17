<?= $this->extend('branch/layOut'); ?>
<?= $this->section('body') ?>
<div class="col-lg-9 col-md-9 col-sm-12 pt-4">
	<div class="row">
		<div class="col-xl-12 col-lg-12 col-md-12">
			<div class="dashboard_wrap">

				<div class="row">
					<div class="col-xl-12 col-lg-12 col-md-12 mb-2">
						<h6 class="m-0">File Details</h6><hr>
					</div>
				</div>

				<div class="row justify-content-center">
					<div class="col-xl-12 col-lg-12 col-md-12">
						<form action="<?= current_url(); ?>" id="formDefault" accept-charset="UTF-8" autocomplete="off">
							<div class="row">
								<div class="col-md-6 mb-3">
									<div class="form-group smalls">
										<label class="form-label">Course Type <span class="text-danger">*</span></label>
										<select name="course_type" id="course_typeDD" class="form-control">
											<option value=""></option>
											<?php if (!empty($courseType)): ?>
												<?php foreach ($courseType as $courseT): ?>
													<option <?= (!empty($details))?($details->course_type == $courseT->id)?'selected':'':'' ?> value="<?= $courseT->id; ?>"><?= $courseT->course_type; ?></option>
												<?php endforeach ?>
											<?php endif ?>
										</select>
									</div>
								</div>
								<div class="col-md-6 mb-3">
									<div class="form-group smalls">
										<label class="form-label">Course Name <span class="text-danger">*</span></label>
										<select name="course_name" id="course_nameDD" class="form-control courseNameInvoke" disabled>
											<option value=""></option>
										</select>
									</div>
								</div>
								<div class="col-md-12 mb-3">
									<div class="form-group smalls">
										<label for="documents" class="form-label">Description</label>
										<?php
										include('ckeditor.php');
										$CKEditor->editor('notes');
										?>
									</div>
								</div>
								<div class="col-md-12 mb-3">
									<div class="form-group smalls">
										<label for="documents" class="form-label">Docuemnts</label>
										<input class="form-control" type="file" id="documents" name="documents[]" accept=".docx,.xlsx,.pdf" multiple>
									</div>
								</div>
							</div>

							<div class="form-group smalls">
								<?= csrf_field(); ?>
								<button class="btn theme-bg text-white defaultSaveButton" type="submit">Add</button>								
							</div>
						</div>
					</form>
				</div>
			</div>

		</div>
	</div>

</div>
<?= $this->endSection(); ?>
