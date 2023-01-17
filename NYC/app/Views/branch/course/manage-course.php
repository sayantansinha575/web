<?= $this->extend('branch/layOut'); ?>
<?= $this->section('body') ?>
<div class="col-lg-9 col-md-9 col-sm-12">

	<div class="row justify-content-between">
		<div class="col-lg-12 col-md-12 col-sm-12 pt-4">
			<div class="dashboard_wrap d-flex align-items-center justify-content-between">
				<div class="arion">
					<nav class="transparent">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="<?= site_url('branch/dashboard'); ?>">Dashboard</a></li>
							<li class="breadcrumb-item active" aria-current="page">Manage Course</li>
						</ol>
					</nav>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-xl-12 col-lg-12 col-md-12 com-sm-12">
			<div class="dashboard_wrap">
				<div class="row justify-content-center">
					<div class="col-md-6 col-xl-6 col-lg-6 col-sm-12">
						<div class="row">
							<div class="col-xl-12 col-lg-12 col-md-12 mb-2">
								<h6 class="m-0">Available Courses</h6><hr>
							</div>
						</div>
						<div class="accordion">
							<div id="hoCourseContainer">
								<?php if (!empty($courseType)): ?>
									<?php foreach ($courseType as $type): 
										$acId = clean(strtolower($type->course_type));
										$i = 1;
										?>
										<div class="card">
											<div id="<?= $acId ?>" class="card-header bg-white shadow-sm border-0">
												<h6 class="mb-0 accordion_title"><a href="#" data-toggle="collapse" data-target="#collapse<?= $acId ?>" aria-expanded="true" aria-controls="collapse<?= $acId ?>" class="d-block position-relative text-dark collapsible-link py-2 text-muted"><?= $type->course_type.' Course'; ?></a></h6>
											</div>
											<div id="collapse<?= $acId ?>" aria-labelledby="<?= $acId ?>"  class="collapse show" style="">
												<div class="card-body pl-3 pr-3 pt-0">
													<ul class="lists row">
														<?php if (!empty($courses)): ?>
															<?php foreach ($courses as $course): ?>
																<?php 
																if (array_search($course->id, $courseId)) {
																	continue;
																}
																if ($course->course_type != $type->id) {
																	continue;
																} 
																$i++;
																?>
																<li class="col-xl-12 col-lg-12 col-md-12 m-1"><a href="javascript:coid(0)" class="assign-course" data-type-name="<?= $type->course_type.' Course'; ?>" data-type="<?= $type->id ?>" data-dest="<?= $acId.'Right' ?>" data-id="<?= encrypt($course->id); ?>"><?= $course->course_name.' ('.$course->course_code.')'; ?><button class="float-right btn-dark"><i class="fa-solid fa-plus"></i></button></a></li>
															<?php endforeach ?>
														<?php endif ?>
														<?php if ($i == 1): ?>
															<li class="col-12 m-1 noResults">No Courses Found</li>
														<?php endif ?>
													</ul>
												</div>
											</div>
										</div>
									<?php endforeach ?>
								<?php endif ?>
							</div>
						</div>
					</div>

					<div class="col-md-6 col-xl-6 col-lg-6 col-sm-12">
						<div class="row">
							<div class="col-xl-12 col-lg-12 col-md-12 mb-2">
								<h6 class="m-0">Active Courses</h6><hr>
							</div>
						</div>
						<div class="accordion">
							<form action="<?= site_url('branch/course/save-course-details') ?>" id="formDefault">
								<fieldset class="activeCoursesContainer">
									<?php if (!empty($modCourseType)): ?>
										<?php foreach ($modCourseType as $mct): 
											$acTitle = fieldValue('course_type', 'course_type', array('id' => $mct->course_type));
											$acIdMod = clean(strtolower(fieldValue('course_type', 'course_type', array('id' => $mct->course_type))));
											$i = 1;
											?>
											<div class="card">
												<div id="<?= $acIdMod ?>Right" class="card-header bg-white shadow-sm border-0">
													<h6 class="mb-0 accordion_title"><a href="#" data-toggle="collapse" data-target="#collapse<?= $acIdMod ?>Right" aria-expanded="true" aria-controls="collapse<?= $acIdMod ?>" class="d-block position-relative text-dark collapsible-link py-2 text-muted"><?= $acTitle.' Course'; ?></a></h6>
												</div>
												<div id="collapse<?= $acIdMod ?>Right" aria-labelledby="<?= $acIdMod ?>"  class="collapse show" style="">
													<div class="card-body pl-3 pr-3 pt-0">
														<ul class="lists row branch-course">
															<?php if (!empty($modCourses)): ?>
																<?php foreach ($modCourses as $mcr):
																	if ($mct->course_type != $mcr->course_type) {
																		continue;
																	}  
																	$courseName = fieldValue('course', 'course_name', array('id' => $mcr->course_id));
																	$courseCode = fieldValue('course', 'course_code', array('id' => $mcr->course_id));
																	?>
																	<li class="col-xl-12 col-lg-12 col-md-12 m-1">
																		<label><?= $courseName; ?> (<?= $courseCode; ?>)</label>
																		<div class="li-holder">
																			<input type="hidden" class="form-control" name="id[]" value="<?= encrypt($mcr->id); ?>" readonly>
																			<input type="hidden" class="form-control" name="course_id[]" value="<?= encrypt($mcr->course_id); ?>" readonly>
																			<input type="hidden" class="form-control" name="course_type[]" value="<?= $mcr->course_type; ?>" readonly>
																			<input type="text" class="form-control decimal" placeholder="Enter course fees" name="course_fees[]" value="<?= $mcr->course_fees ?>">
																			<button class=" removeCourse" type="button" data-type-name="<?= $acTitle.' Course'; ?>" data-type="<?= $mcr->course_type ?>" data-dest="<?= $acIdMod ?>" data-id="<?= encrypt($course->id); ?>" data-name="<?= $courseName; ?> (<?= $courseCode; ?>)"><i class="fa-solid fa-xmark "></i></button>
																		</div>
																	</li>
																<?php endforeach ?>
															<?php endif ?>
														</ul>
													</div>
												</div>
											</div>
										<?php endforeach ?>
									<?php endif ?>
								</fieldset>

								<div class="form-group smalls btnHolder" style="display: <?= !empty($modCourses)?'block':'none'; ?>;">
									<?= csrf_field(); ?>
									<button class="btn theme-bg text-white defaultSaveButton" type="submit">Save Change</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>

</div>
<?= $this->endSection(); ?>
