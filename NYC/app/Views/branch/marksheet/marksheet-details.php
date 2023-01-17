<?= $this->extend('branch/layOut'); ?>
<?= $this->section('body') ?>
<div class="col-lg-9 col-md-9 col-sm-12  pt-4">

	<div class="row">
		<div class="col-xl-12 col-lg-12 col-md-12">
			<div class="dashboard_wrap">
				<div class="row">
					<div class="col-xl-12 col-lg-12 col-md-12 mb-4">
						<h6 class="m-0">Details</h6><hr>
					</div>
				</div>
				<div class="row justify-content-center">
					<div class="col-md-12 col-lg-12 col-sm-12">
						<div class="accordion">
							<div class="card">
								<div id="branchDetails" class="card-header bg-white shadow-sm border-0">
									<h6 class="mb-0 accordion_title"><a href="#" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne" class="d-block position-relative text-dark collapsible-link py-2">Basic Details</a></h6>
								</div>
								<div id="collapseOne" aria-labelledby="branchDetails"  class="collapse show" style="">
									<div class="card-body pl-3 pr-3 pt-0">
										<ul class="lists-3 row">
											<li class="col-xl-4 col-lg-4 col-md-4 m-0 mb-1"><b class="text-muted">Marksheet No.</b></li>
											<li class="text-right col-xl-1 col-lg-1 col-md-1 m-0 mb-1">:</li>
											<li class="col-xl-4 col-lg-4 col-md-4 m-0 mb-1"><?= $details->marksheet_no; ?></li>

											<li class="col-xl-4 col-lg-4 col-md-4 m-0 mb-1"><b class="text-muted">Enrollment No.</b></li>
											<li class="text-right col-xl-1 col-lg-1 col-md-1 m-0 mb-1">:</li>
											<li class="col-xl-4 col-lg-4 col-md-4 m-0 mb-1"><?= $details->enrollment_number; ?></li>

											<li class="col-xl-4 col-lg-4 col-md-4 m-0 mb-1"><b class="text-muted">Candidate Name</b></li>
											<li class="text-right col-xl-1 col-lg-1 col-md-1 m-0 mb-1">:</li>
											<li class="col-xl-4 col-lg-4 col-md-4 m-0 mb-1"><?= $details->candidate_name; ?></li>

											<li class="col-xl-4 col-lg-4 col-md-4 m-0 mb-1"><b class="text-muted">Father's Name</b></li>
											<li class="text-right col-xl-1 col-lg-1 col-md-1 m-0 mb-1">:</li>
											<li class="col-xl-4 col-lg-4 col-md-4 m-0 mb-1"><?= $details->father_name; ?></li>

											<li class="col-xl-4 col-lg-4 col-md-4 m-0 mb-1"><b class="text-muted">A.T.P. Name</b></li>
											<li class="text-right col-xl-1 col-lg-1 col-md-1 m-0 mb-1">:</li>
											<li class="col-xl-4 col-lg-4 col-md-4 m-0 mb-1"><?= $details->atp_name; ?></li>

											<li class="col-xl-4 col-lg-4 col-md-4 m-0 mb-1"><b class="text-muted">Session</b></li>
											<li class="text-right col-xl-1 col-lg-1 col-md-1 m-0 mb-1">:</li>
											<li class="col-xl-4 col-lg-4 col-md-4 m-0 mb-1"><?= date('M y', $details->from_session).'-'.date('M y', $details->to_session) ?></li>

											<li class="col-xl-4 col-lg-4 col-md-4 m-0 mb-1"><b class="text-muted">Student Photo</b></li>
											<li class="text-right col-xl-1 col-lg-1 col-md-1 m-0 mb-1">:</li>
											<li class="col-xl-4 col-lg-4 col-md-4 m-0 mb-1"><img src="<?= site_url('public/upload/branch-files/student/student-image/').$details->student_photo; ?>" alt="student photo" class="img-fluid img-responsive img-thumbnail" width="80px"></li>
										</ul>
									</div>
								</div>
							</div>

							<div class="card">
								<div id="branchDetails" class="card-header bg-white shadow-sm border-0">
									<h6 class="mb-0 accordion_title"><a href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo" class="d-block position-relative text-dark collapsible-link py-2">Subjects & Marks</a></h6>
								</div>
								<div id="collapseTwo" aria-labelledby="branchDetails"  class="collapse show" style="">
									<div class="card-body pl-3 pr-3 pt-0">
										<?php  
										if (!empty($details->subjects)) {
											$subjects = unserialize($details->subjects);
											$marks = unserialize($details->marks);
											$marks_obtained = unserialize($details->marks_obtained);
											$grade = unserialize($details->grade);
											$labels = $details->labels;
										}
										?>
										<div class="table-responsive">
											<table class="table dash_list">
												<thead>
													<tr>
														<th scope="col">Subject</th>
														<th scope="col">Full Marks</th>
														<th scope="col">Marks Obtained</th>
														<th scope="col">Grade</th>
													</tr>
												</thead>
												<tbody>
													<?php if (!empty($subjects['subject'])): ?>
														<?php foreach ($subjects['subject'] as $key => $subs): ?>
															<tr>
																<td><b class="text-muted"><?= $subs ?></b></td>
																<td><?= $marks['marks'][$key]; ?></td>
																<td><?= $marks_obtained['marks_obtained'][$key]; ?></td>
																<td><?= $grade['grade'][$key]; ?></td>
															</tr>
														<?php endforeach ?>
													<?php endif ?>

													<?php if (!empty($labels)): 
														$labels = unserialize($labels);
														?>
														<?php foreach ($labels as $key => $labs): 
															$k = 0;
														?>
															<tr>
																<td colspan="4"><b class="text-muted"><?= $labs ?></b></td>
															</tr>
															<?php foreach ($subjects[$key] as $subs): ?>
																<tr>
																	<td><b class="text-muted"><?= $subs ?></b></td>
																	<td><?= $marks[$key][$k]; ?></td>
																	<td><?= $marks_obtained[$key][$k]; ?></td>
																	<td><?= $grade[$key][$k]; ?></td>
																</tr>
															<?php $k++; endforeach ?>
														<?php endforeach ?>
													<?php endif ?>
													<tr>
														<td></td>
														<td><b><?= $details->total_marks; ?></b></td>
														<td><b><?= $details->total_marks_obtained; ?></b></td>
														<td><b><?= $details->overall_grade; ?></b></td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>

							<div class="card">
								<div id="branchDetails" class="card-header bg-white shadow-sm border-0">
									<h6 class="mb-0 accordion_title"><a href="#" data-toggle="collapse" data-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree" class="d-block position-relative text-dark collapsible-link py-2">Marksheet Status</a></h6>
								</div>
								<div id="collapseThree" aria-labelledby="branchDetails"  class="collapse show" style="">
									<div class="card-body pl-3 pr-3 pt-0">
										<ul class="lists-3 row">
											<li class="col-xl-4 col-lg-4 col-md-4 m-0 mb-1"><b class="text-muted">Status</b></li>
											<li class="text-right col-xl-1 col-lg-1 col-md-1 m-0 mb-1">:</li>
											<?php if ($details->status == 1): ?>
												<li class="col-xl-4 col-lg-4 col-md-4 m-0 mb-1"><span class="trip text-warning bg-light-warning">Processing</span></li>
											<?php elseif ($details->status == 2): ?>
												<li class="col-xl-4 col-lg-4 col-md-4 m-0 mb-1"><span class="trip gray">Under Preview</span></li>
											<?php elseif ($details->status == 4): ?>
												<li class="col-xl-4 col-lg-4 col-md-4 m-0 mb-1"><span class="trip theme-cl theme-bg-light">Published</span></li>
											<?php else: ?>
												<li class="col-xl-4 col-lg-4 col-md-4 m-0 mb-1"><span class="trip text-danger bg-light-danger">Rejected</span></li>
											<?php endif ?>
											<?php if ($details->status == 4): ?>
												<li class="col-xl-4 col-lg-4 col-md-4 m-0 mb-1"><b class="text-muted">Status</b></li>
												<li class="text-right col-xl-1 col-lg-1 col-md-1 m-0 mb-1">:</li>
												<li class="col-xl-4 col-lg-4 col-md-4 m-0 mb-1">
													<a href="<?= site_url('public/upload/branch-files/student/marksheet/').$details->marksheet_file; ?>" class="btn btn-sm btn-success" download="<?= $details->marksheet_file; ?>"><i class="ti-download"></i></a>
												</li>
											<?php endif ?>
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
<?= $this->endSection(); ?>
