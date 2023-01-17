<?= $this->extend('branch/layOut'); ?>
<?= $this->section('body') ?>
<div class="col-lg-9 col-md-9 col-sm-12  pt-4">
	<div class="row">
		<div class="col-xl-12 col-lg-12 col-md-12">
			<div class="dashboard_wrap">
				<div class="row">
					<div class="col-xl-12 col-lg-12 col-md-12 mb-2">
						<h6 class="m-0">Search Enrollment Details</h6><hr>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6 mb-3">
						<form action="<?= site_url('branch/marksheet/apply-new-marksheet') ?>" method="get">
							<div class="form-group smalls">
								<div class="input-group">
									<input autocomplete="false" type="text" class="form-control uppercase" name="enrollNo" placeholder="Search details by enrollment number" value="<?= !empty($_REQUEST['enrollNo'])?$_REQUEST['enrollNo']:''; ?>">
									<div class="input-group-append">
										<button type="submit" class="btn btn-dark">Search</button>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php if (!empty($details)): ?>
		<form action="<?= site_url('branch/marksheet/apply-new-marksheet'); ?>" id="formMarksheet" accept-charset="UTF-8" autocomplete="off">

		<div class="row">
			<div class="col-xl-12 col-lg-12 col-md-12">
				<div class="dashboard_wrap">
					<div class="row">
						<div class="col-xl-12 col-lg-12 col-md-12 mb-2">
							<h6 class="m-0">Candidate Details</h6><hr>
						</div>
					</div>
					<div class="row justify-content-center">
						<div class="col-xl-12 col-lg-12 col-md-12">

							<div class="row">
								<div class="col-md-6 mb-3">
									<div class="form-group smalls">
										<label class="form-label">Candidate Name <span class="text-danger">*</span></label>
										<input type="text" class="form-control" name="candidate_name" id="candidate_name" placeholder="Enter candidate name" value="<?= ($details)?$details->student_name:''; ?>" readonly>
									</div>
								</div>
								<div class="col-md-6 mb-3">
									<div class="form-group smalls">
										<label class="form-label">Enrollment No. <span class="text-danger">*</span></label>
										<input type="text" class="form-control" name="enrollment_number" id="enrollment_number" placeholder="Enter candidate name" value="<?= ($details)?$details->enrollment_number:''; ?>" readonly>
									</div>
								</div>
								<div class="col-md-6 mb-3">
									<div class="form-group smalls">
										<label class="form-label">Father's Name <span class="text-danger">*</span></label>
										<input type="text" class="form-control" name="father_name" id="father_name" placeholder="Enter candidate name" value="<?= ($details)?$details->father_name:''; ?>" readonly>
									</div>
								</div>
								<div class="col-md-6 mb-3">
									<div class="form-group smalls">
										<label class="form-label">Course Name <span class="text-danger">*</span></label>
										<input type="text" class="form-control" value="<?= ($details)?$details->courseName.' ('.$details->short_name.')':''; ?>" readonly>
										<input type="hidden" name="course_id" class="form-control" value="<?= ($details)?$details->course_name:''; ?>">
									</div>
								</div>
								<div class="col-md-6 mb-3">
									<div class="form-group smalls">
										<label class="form-label">From Session <span class="text-danger">*</span></label>
										<input type="text" onkeydown="return false" class="form-control" name="from_session" data-date="" id="from_session" placeholder="Select from session" value="<?= ($details)?date('Y-m-d', $details->from_session):''; ?>" readonly>
									</div>
								</div>
								<div class="col-md-6 mb-3">
									<div class="form-group smalls">
										<label class="form-label">To Session <span class="text-danger">*</span></label>
										<input type="text" class="form-control" name="to_session" id="to_session" placeholder="Select course session" value="<?= ($details)?date('Y-m-d', $details->to_session):''; ?>" readonly>
									</div>
								</div>
								<div class="col-md-6 mb-3">
									<div class="form-group smalls">
										<label class="form-label">A.T.P. Name <span class="text-danger">*</span></label>
										<input type="text" class="form-control" name="atp_name" id="atp_name" placeholder="Enter candidate name" value="<?= ($details)?$details->branch_name:''; ?>" readonly>
										<input type="hidden" class="form-control" name="admission_id" id="admission_id" placeholder="Enter candidate name" value="<?= ($details)?$details->id:''; ?>" readonly>
									</div>
								</div>
								<div class="col-md-6 mb-3">
									<div class="form-group smalls">
										<label class="form-label">Typing Speed <span class="text-danger">*</span></label>
										<select name="typing_speed" id="typing_speed" class="form-control">
											<option value=""></option>
											<?php for ($i = 25; $i <= 40 ; $i++) { ?>
												<option value="<?= $i ?>"><?= $i ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
								<input type="hidden" name="student_photo" value="<?= ($details)?$details->student_photo:''; ?>" readonly> 
								<input type="hidden" name="short_name" value="<?= ($details)?$details->short_name:''; ?>" readonly> 
								<input type="hidden" name="totalMarks" value="<?= ($details)?$details->totalMarks:''; ?>" readonly> 
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
							<h6 class="m-0">Subjects & Marks Details</h6><hr>
						</div>
					</div>
					<div class="row">
						<?php if (!empty($details->subjects)): 
							$subjects = unserialize($details->subjects);
							$marks = unserialize($details->marks);
							$labels = $details->labels;
							?>
							<?php if (!empty($subjects['subject_name'])): ?>
								<?php foreach ($subjects['subject_name'] as $key => $subs): 
									?>
									<div class="subjectsDetailsContainer col-md-12">
										<div class="row">
											<div class="col-md-5 mb-3">
												<label for="" class="form-label">Subject <span class="text-danger">*</span></label>
												<input type="text" name="subject[]" class="form-control subjectName" value="<?= $subs ?>" readonly>
											</div>
											<div class="col-md-3 mb-3">
												<label for="" class="form-label">Full Marks <span class="text-danger">*</span></label>
												<input type="text" name="marks[]" class="form-control numbers totalMarks" value="<?= $marks['full_marks'][$key] ?>" readonly>
											</div>
											<div class="col-md-3 mb-3">
												<label for="" class="form-label">Marks Obtained <span class="text-danger">*</span></label>
												<input type="text" name="marks_obtained[]" class="form-control numbers obtainedMarks" value="" placeholder="Enter obtained mark">
											</div>
											<div class="col-md-1 mb-3">
												<label for="" class="form-label">Grade <span class="text-danger">*</span></label>
												<input type="text" name="grade[]" class="form-control gradation" value="" readonly>
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
										<div class="col-md-12">
											<h5 class="text-muted"><?= $labs ?></h5><hr>
											<input type="hidden" class="form-control" name="label_name[]" value="<?= $labs ?>">
											<input type="hidden" class="identifier" name="identifier[]" value="<?= "IDEN".$j ?>">
										</div>
										
										<?php foreach ($subjects[$key] as $subs): ?>
											<div class="subjectsDetailsContainer col-md-12">

												<div class="row">
													<div class="col-md-5 mb-3">
														<label for="" class="form-label">Subject <span class="text-danger">*</span></label>
														<input type="text" name="<?= "IDEN".$j ?>subject[]" class="form-control subjectName" value="<?= $subs ?>" readonly>
													</div>
													<div class="col-md-3 mb-3">
														<label for="" class="form-label">Full Marks <span class="text-danger">*</span></label>
														<input type="text" name="<?= "IDEN".$j ?>marks[]" class="form-control numbers totalMarks" value="<?= $marks[$key][$k++] ?>" readonly>
													</div>
													<div class="col-md-3 mb-3">
														<label for="" class="form-label">Marks Obtained <span class="text-danger">*</span></label>
														<input type="text" name="<?= "IDEN".$j ?>marks_obtained[]" class="form-control numbers obtainedMarks" value="" placeholder="Enter obtained mark">
													</div>
													<div class="col-md-1 mb-3">
														<label for="" class="form-label">Grade <span class="text-danger">*</span></label>
														<input type="text" name="<?= "IDEN".$j ?>grade[]" class="form-control gradation" value="" readonly>
													</div>
												</div>
											</div>

									<?php endforeach ?>
								<?php endforeach ?>
							<?php endif ?>

						<?php endif ?>
					</div>

					<div class="form-group smalls">
						<?= csrf_field(); ?>
						<button class="btn theme-bg text-white btnMarksheet" data-continue="0" type="submit">Apply</button>								
					</div>
				</div>
			</div>
		</div>

	</form>
	<?php endif ?>
<?= $this->endSection(); ?>
