<?= $this->extend('branch/layOut'); ?>
<?= $this->section('body') ?>
<div class="col-lg-9 col-md-9 col-sm-12  pt-4">
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-body">
					<h6>Course Details</h6><hr><br>
					<div class="row">
						<div class="col-md-2 mb-2">
							<label for="">Course Name</label>
						</div>
						<div class="col-md-1 text-center mb-2">:</div>
						<div class="col-md-9 mb-2">
							<?= $details->course_name; ?>
						</div>
						<div class="col-md-2 mb-2">
							<label for="">Course type</label>
						</div>
						<div class="col-md-1 text-center mb-2">:</div>
						<div class="col-md-9 mb-2">
							<?= $details->courseTypeName; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div> 
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
								<div class="col-md-12 mb-3">
									<div class="form-group smalls">
										<label for="documents" class="form-label">Description</label>
										<?php
										include('ckeditor.php');
										$CKEditor->editor('description');
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
								<input type="hidden" name="course_id" value="<?= $details->course_id ?>">
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