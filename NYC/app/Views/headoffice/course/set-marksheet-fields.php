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
						<li class="breadcrumb-item active"><?= empty($fieldsData)?'Add':'Edit'; ?> Marksheet Fields</li>
					</ol>
				</div>
				<h4 class="page-title"><?= $title; ?></h4>
			</div>
		</div>
	</div>     
	<!-- end page title --> 

	
	<form action="<?= site_url('head-office/course/set-marksheet-fields/'.$course->id); ?>" id="defaultForm" accept-charset="UTF-8" autocomplete="off">
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-body">
						<h4 class="header-title">Course Details</h4><hr>
						<br>
						<table class="table table-centered mb-0">
							<tbody>
								<tr>
									<td><b class="text-muted">Course Name</b></td>
									<td>:</td>
									<td><?= $course->course_name; ?></td>
								</tr>
								<tr>
									<td><b class="text-muted">Course Code</b></td>
									<td>:</td>
									<td><?= $course->course_code; ?></td>
								</tr>
								<tr>
									<td><b class="text-muted">Total Marks</b></td>
									<td>:</td>
									<td><?= $course->total_marks; ?></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>

				<div class="card">
					<div class="card-body">
						<h4 class="header-title">Set Marksheet Fields 
							<div class="btn-group" role="group">
								<button id="btnGroupDrop1" type="button" class="btn btn-success btn-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
									<i class="fa-solid fa-plus"></i>
								</button>
								<ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
									<li><a class="dropdown-item addMoreLabel" href="javascript:void(0)">Add Label</a></li>
									<li><a class="dropdown-item addMoreFields" href="javascript:void(0)">Add Field</a></li>
								</ul>
							</div>
						</h4><hr>
						<br>
						<div class="row">
							<fieldset class="fieldsContainer">
								<?php if (!empty($fieldsData)): ?>
									<?php
									$subjects = unserialize($fieldsData->subjects);
									$marks = unserialize($fieldsData->marks);
									$labels = $fieldsData->labels;
									?>

									<?php if (!empty($subjects['subject_name'])): ?>
										<?php foreach ($subjects['subject_name'] as $key => $subs): 
											$identifier = '<a href="javascript:void(0)" class="btn btn-danger btn-icon removeField" data-toggle="tooltip" title="Remove"><i class="fa-solid fa-minus"></i></a>';
											?>
											<div class="childContainer">
												<div class="col-md-12 mb-3">
													<div class="input-group flex-wrap">
														<input type="text" class="form-control subjectName" name="subject_name[]" placeholder="Enter subject name" value="<?= $subs ?>">
														<input type="text" class="form-control numbers fullMarks" name="full_marks[]" placeholder="Enter full marks" value="<?= $marks['full_marks'][$key] ?>">
														<?= $identifier; ?>
													</div>
												</div>
											</div>
										<?php endforeach ?>
									<?php endif ?>


									<?php if (!empty($labels)): 
										$labels = unserialize($labels);
										$i = 0; $j = 0; 
									?>
									<?php foreach ($labels as $key => $labs): 
									$i++; $j++; $k = 0;?>
										<fieldset class="labelContainer" id="1">
											<div class="col-md-12 mb-3">
												<div class="input-group flex-wrap">
													<input type="text" class="form-control" name="label_name[]" placeholder="Enter label name" value="<?= $labs ?>">
													<input type="hidden" class="identifier" name="identifier[]" value="<?= "UPDIDEN".$j ?>">
													<a href="javascript:void(0)" class="btn btn-danger btn-icon removeLabel" data-toggle="tooltip" title="Remove Label and fields under it"><i class="fa-solid fa-minus"></i></a>
												</div>
											</div>
											<?php foreach ($subjects[$key] as $subs): 
												$identifier = '<a href="javascript:void(0)" class="btn btn-danger btn-icon removeField" data-toggle="tooltip" title="Remove"><i class="fa-solid fa-minus"></i></a>';
												?>
												<div class="childContainer">
													<div class="col-md-12 mb-3">
														<div class="input-group flex-wrap">
															<input type="text" class="form-control subjectName" name="<?= "UPDIDEN".$j ?>subject_name[]" placeholder="Enter subject name" value="<?= $subs ?>">
															<input type="text" class="form-control numbers fullMarks" name="<?= "UPDIDEN".$j ?>full_marks[]" placeholder="Enter full marks" value="<?= $marks[$key][$k++] ?>">
															<?= $identifier; ?>
														</div>
													</div>
												</div>
											<?php endforeach ?>
										</fieldset>
									<?php endforeach ?>
									<?php endif ?>
								<?php endif ?>
							</fieldset>
						</div>
					</div>
					<div class="card-footer">
						<div class="row">
							<div class="col-md-12 text-end">
								<?= csrf_field(); ?>
								<input type="submit" class="btn btn-dark defaultBtn" value="<?= empty($fieldsData)?'Save':'Update'; ?>">
							</div>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
	<!-- <script src="<?= site_url(); ?>public/headoffice/js/pages/quill.bubble-editor.js"></script> -->
	<?= $this->endSection(); ?>