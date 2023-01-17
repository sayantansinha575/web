<?= $this->extend('headoffice/layOut'); ?>
<?= $this->section('body') ?>
<div class="container-fluid">
	<!-- start page title -->
	<div class="row">
		<div class="col-12">
			<div class="page-title-box">
				<div class="page-title-right">
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="/head-office/ducments/study-materials">Study Materials</a></li>
						<li class="breadcrumb-item active"><?= empty($details)?'Add':'Edit'; ?> Documents</li>
					</ol>
				</div>
				<h4 class="page-title"><?= $title; ?></h4>
			</div>
		</div>
	</div>     
	<!-- end page title --> 	
	<form action="<?= current_url(); ?>" id="defaultForm" accept-charset="UTF-8" autocomplete="off">
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-body">
						<h4 class="header-title">Details</h4><hr>
						<br>
						<div class="row">
							<div class="col-md-12">
								<div class="row">
									<div class="col-md-4 mb-3">
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
									<div class="col-md-8 mb-2">
										<label class="form-label">Course Name <span class="text-danger">*</span></label>
										<select name="course_name" id="course_nameDD" class="form-control courseNameInvoke" disabled>
											<option value=""></option>
											<?php if (!empty($courses)): ?>
												<?php foreach ($courses as $crs): ?>
													<option <?= (!empty($details))?($details->course_id == $crs->id)?'selected':'':'' ?> value="<?= $crs->id; ?>"><?= $crs->course_name; ?></option>
												<?php endforeach ?>
											<?php endif ?>
										</select>
									</div>
									<?php if (!empty($details)): ?>
										<input type="hidden" name="branch" id="hiddenBranch" value="<?= $details->branch_id ?>">
										<input type="hidden" name="course_type" id="hiddenCourse_type" value="<?= $details->course_type ?>">
										<input type="hidden" name="course_name" id="hiddenCourse_name" value="<?= $details->course_id ?>">
									<?php endif ?>
									<div class="col-md-12 mb-2">
										<label for="documents" class="form-label">Description</label>
										<?php
										include('ckeditor.php');
										$CKEditor->editor('notes');
										?>
									</div>
									<div class="col-md-12 mb-2">
										<label for="documents" class="form-label">Docuemnts</label>
										<input class="form-control" type="file" id="documents" name="documents[]" accept=".docx,.xlsx,.pdf" multiple>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="card-footer">
						<div class="row">
							<div class="col-md-12 text-end">
								<?= csrf_field(); ?>
								<input type="submit" class="btn btn-dark defaultBtn" value="<?= empty($details)?'Save':'Update'; ?>">
							</div>
						</div>
					</div>
				</div><!-- end col-->
			</div>
		</div>
	</form>
</div>
<?= $this->endSection(); ?>