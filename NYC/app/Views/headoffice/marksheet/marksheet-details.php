<?= $this->extend('headoffice/layOut'); ?>
<?= $this->section('body') ?>
<div class="container-fluid">

	<div class="row">
		<div class="col-12">
			<div class="page-title-box">
				<div class="page-title-right">
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="/head-office/marksheet">Marksheet</a></li>
						<li class="breadcrumb-item active">Marksheet Details</li>
					</ol>
				</div>
				<h4 class="page-title"><?= $title; ?></h4>
			</div>
		</div>
	</div>     

	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-body">
					<h4 class="header-title">Course Details</h4><br>
					<div class="accordion custom-accordion mb-4" id="custom-accordion">

						<div class="card mb-0">
							<div class="card-header" id="headimgOne">
								<h5 class="m-0">
									<a class="custom-accordion-title d-block py-1" data-bs-toggle="collapse" href="#collapseFour" aria-expanded="true" aria-controls="collapseFour">BASIC DETAILS<i class="mdi mdi-chevron-down accordion-arrow"></i></a>
								</h5>
							</div>

							<div id="collapseFour" class="collapse show" aria-labelledby="headimgOne">
								<div class="card-body">
									<table class="table table-sm table-centered mb-0">
										<tbody>
											<tr>
												<td width="20%">Marksheet No.</td>
												<td class="text-end">:</td>
												<td><?= $details->marksheet_no; ?></td>
											</tr>
											<tr>
												<td width="20%">Enrollment No.</td>
												<td class="text-end">:</td>
												<td><?= $details->enrollment_number; ?></td>
											</tr>
											<tr>
												<td width="20%">Candidate Name</td>
												<td class="text-end">:</td>
												<td><?= $details->candidate_name; ?></td>
											</tr>
											<tr>
												<td width="20%">Father's Name</td>
												<td class="text-end">:</td>
												<td><?= $details->father_name; ?></td>
											</tr>
											<tr>
												<td width="20%">A.T.P. Name</td>
												<td class="text-end">:</td>
												<td><?= $details->atp_name; ?></td>
											</tr>
											<tr>
												<td width="20%">Session</td>
												<td class="text-end">:</td>
												<td><?= date('M y', $details->from_session).'-'.date('M y', $details->to_session) ?></td>
											</tr>
											<tr>
												<td width="20%">Student Photo</td>
												<td class="text-end">:</td>
												<td><img src="<?= site_url('public/upload/branch-files/student/student-image/').$details->student_photo; ?>" alt="student photo" class="img-fluid img-responsive img-thumbnail" width="80px"></td>
											</tr>
											<tr>
												<td width="20%">Status</td>
												<td class="text-end">:</td>
												<td>
													<?php if ($details->status == 1): ?>
														<span class="badge badge-warning-lighten">Processing</span>
													<?php elseif ($details->status == 2): ?>
														<span class="badge badge-secondary-lighten">Under Preview</span>
													<?php elseif ($details->status == 4): ?>
														<span class="badge badge-success-lighten">Published</span>
													<?php else: ?>
														<span class="badge badge-danger-lighten">Rejected</span>
													<?php endif ?>
												</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>

						<div class="card mb-0">
							<div class="card-header" id="headingTwo">
								<h5 class="m-0">
									<a class="custom-accordion-title d-block py-1" data-bs-toggle="collapse" href="#CollapseTwo" aria-expanded="true" aria-controls="CollapseTwo">SUBJECTS & MARKS<i class="mdi mdi-chevron-down accordion-arrow"></i></a>
								</h5>
							</div>

							<div id="CollapseTwo" class="collapse show" aria-labelledby="headingTwo">
								<div class="card-body">
									<?php  
									if (!empty($details->subjects)) {
										$subjects = unserialize($details->subjects);
										$marks = unserialize($details->marks);
										$marks_obtained = unserialize($details->marks_obtained);
										$grade = unserialize($details->grade);
										$labels = $details->labels;
									}
									?>
									<table class="table table-sm table-centered mb-0">
										<thead>
											<tr>
												<th>Subject Semester</th>
												<th>Full Marks</th>
												<th>Marks Obtained</th>
												<th>Grade</th>
											</tr>
										</thead>
										<tbody>
											<?php if (!empty($subjects['subject'])): ?>
												<?php foreach ($subjects['subject'] as $key => $subs): ?>
													<tr>
														<td><b class="text-muted"><?= $subs ?></b></td>
														<td><?= $marks['marks'][$key]; ?></td>
														<td><?= $marks_obtained['marks_obtained'][$key]. ' ('.getGradeNPercentage($marks['marks'][$key], $marks_obtained['marks_obtained'][$key], 'P' ).'%)'; ?></td>
														<td><?= $grade['grade'][$key]; ?></td>
													</tr>
												<?php endforeach ?>
											<?php endif ?>

											<?php if (!empty($labels)): 
												$labels = unserialize($labels);
											?>
												<?php foreach ($labels as $key => $labs): $k = 0; ?>
													<tr>
														<td colspan="4"><b class="text-muted"><?= $labs ?></b></td>
													</tr>
													<?php foreach ($subjects[$key] as $subs): ?>
														<tr>
															<td><b class="text-muted"><?= $subs ?></b></td>
															<td><?= $marks[$key][$k]; ?></td>
															<td><?= $marks_obtained[$key][$k]. ' ('.getGradeNPercentage($marks[$key][$k], $marks_obtained[$key][$k], 'P' ).'%)'; ?></td>
															<td><?= $grade[$key][$k]; ?></td>
														</tr>
													<?php $k++; endforeach ?>
												<?php endforeach ?>
											<?php endif ?>
											<tr>
												<td></td>
												<td><b><?= $details->total_marks; ?></b></td>
												<td><b><?= $details->total_marks_obtained. ' ('.getGradeNPercentage($details->total_marks, $details->total_marks_obtained, 'P' ).'%)'; ?></b></td>
												<td><b><?= $details->overall_grade; ?></b></td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>

					</div>

					<?php $status = $details->status; ?>
					<?php if (($status == 1) || ($status == 3)): ?>
						<button class="btn btn-success m-1 approveMarksheet" type="button" data-id="<?= $details->id; ?>">Approve</button>
					<?php endif ?>
					<?php if (($status == 4) || ($status == 2)): ?>
						<button class="btn btn-success m-1 publishMarksheet" type="button" data-id="<?= $details->id; ?>" <?= ($status == 4)?'disabled':'' ?>><?= ($status == 4)?'Published':'Publish' ?></button>
					<?php endif ?>
					<?php if($status == 2){?>
						<a target="_blank" href="<?= site_url('public/upload/branch-files/student/marksheet/').$details->marksheet_file ?>">
							<button class="btn btn-secondary m-1" type="button" >Preview</button>
						</a>
					<?php } ?>
					<?php if($status == 4){?>
						<a download href="<?= site_url('public/upload/branch-files/student/marksheet/').$details->marksheet_file ?>">
							<button class="btn btn-success m-1" type="button" >Download</button>
						</a>
					<?php } ?>
					<?php if ($status != 4): ?>
						<button class="btn btn-danger m-1 rejectMarksheet" type="button" data-id="<?= $details->id; ?>" <?= ($details->status == 3)?'disabled':'' ?> ><?= ($details->status == 3)?'Rejected':'Reject' ?></button>
					<?php endif ?>
				</div>
			</div>
		</div>
	</div>
	
</div>
<?= $this->endSection(); ?>