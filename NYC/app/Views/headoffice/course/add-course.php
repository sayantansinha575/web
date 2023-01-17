<?= $this->extend('headoffice/layOut'); ?>
<?= $this->section('body') ?>

<div class="container-fluid">

	<!-- start page title -->
	<div class="row">
		<div class="col-12">
			<div class="page-title-box">
				<div class="page-title-right">
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="/head-office/course">Course</a></li>
						<li class="breadcrumb-item active"><?= empty($details)?'Add':'Edit'; ?> Course</li>
					</ol>
				</div>
				<h4 class="page-title"><?= $title; ?></h4>
			</div>
		</div>
	</div>     
	<!-- end page title --> 

	
	<form action="<?= site_url('head-office/course/add-course'.$id); ?>" id="formCourse" accept-charset="UTF-8" autocomplete="off">
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-body">
						<h4 class="header-title">Course Details</h4><hr>
						<br>
						<div class="row">
							<div class="col-md-6 mb-3">
								<label class="form-label">Course Type <span class="text-danger">*</span></label>
								<select name="course_type" id="course_type" class="form-select select2NoSearch" >
									<option value=""></option>
									<?php if (!empty($courseType)): ?>
										<?php foreach ($courseType as $course): ?>
											<option <?= ($details)?($details->course_type == $course->id)?'selected':'':''; ?> value="<?= $course->id; ?>"><?= $course->course_type; ?></option>
										<?php endforeach ?>
									<?php endif ?>
								</select>
							</div>
							<div class="col-md-6 mb-3">
								<label class="form-label">Course Name <span class="text-danger">*</span></label>
								<input type="text" class="form-control" name="course_name" id="course_name" placeholder="Enter course name" value="<?= ($details)?$details->course_name:''; ?>">
							</div>
							<div class="col-md-4 mb-3">
								<label class="form-label">Short Name <span class="text-danger">*</span></label>
								<input type="text" class="form-control" name="short_name" id="short_name" placeholder="Enter course code" value="<?= ($details)?$details->short_name:''; ?>">
							</div>
							<div class="col-md-4 mb-3">
								<label class="form-label">Has Marksheet <span data-toggle="tooltip" title="Not all course needs marksheet, so select wisely"><i class="fa-solid fa-circle-info"></i></span>   		<span class="text-danger">*</span></label>
								<select name="has_marksheet" id="has_marksheet" class="form-select select2NoSearch">
									<option value=""></option>
									<option <?= ($details)?($details->has_marksheet == 'Yes')?'selected':'':''; ?> value="1">Yes</option>
									<option <?= ($details)?($details->has_marksheet == 'No')?'selected':'':''; ?> value="2">No</option>
								</select>
							</div>
							<div class="col-md-4 mb-3">
								<label class="form-label">Total Marks</label>
								<input type="text" class="form-control numbers" name="total_marks" id="total_marks" placeholder="Enter total marks" value="<?= ($details)?$details->total_marks:''; ?>"  <?= ($details)?($details->has_marksheet == 'No')?'readonly':'':''; ?>>
							</div>
							<div class="col-md-4 mb-3">
								<label class="form-label">Course Code <span class="text-danger">*</span></label>
								<input type="text" class="form-control uppercase" name="course_code" id="course_code" placeholder="Enter course code" value="<?= ($details)?$details->course_code:''; ?>">
							</div>
							<div class="col-md-4 mb-3">
								<label class="form-label">Duration <span class="text-danger">*</span> <small>(In months)</small></label>
								<input type="text" class="form-control numbers" name="course_duration" id="course_duration" placeholder="Enter course duration" maxlength="2" value="<?= ($details)?$details->course_duration:''; ?>">
							</div>
							<div class="col-md-4 mb-3">
								<label class="form-label">Eligibility <span class="text-danger">*</span></label>
								<input type="text" class="form-control" name="course_eligibility" id="course_eligibility" placeholder="Enter course eligibility" value="<?= ($details)?$details->course_eligibility:''; ?>">
							</div>
							<div class="col-md-12 mb-3">
								<label for="" class="form-label">Course Details  <span class="text-danger">*</span></label>
								<div id="bubble-editor" class="course_details" style="height: 300px;">
									<?= ($details)?$details->course_details:''; ?>
								</div>
							</div>
							<div class="col-md-4 mb-3">
								<label class="form-label"><input type="checkbox" <?php if($details && $details->typing_test){?> checked="checked" <?php } ?> name="typing_test" value="1"> Please check for typing test course. </label>
								
							</div>
						</div>
					</div>
					<div class="card-footer">
						<div class="row">
							<div class="col-md-12 text-end">
								<?= csrf_field(); ?>
								<input type="submit" class="btn btn-dark btnSaveCourse" value="<?= empty($details)?'Save':'Update'; ?>">
							</div>
						</div>
					</div>
				</div><!-- end col-->
			</div>
		</form>
	</div>
	<script src="<?= site_url(); ?>public/headoffice/js/pages/quill.bubble-editor.js"></script>
	<?= $this->endSection(); ?>