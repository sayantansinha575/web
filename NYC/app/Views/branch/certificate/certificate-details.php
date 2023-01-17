<?= $this->extend('branch/layOut'); ?>
<?= $this->section('body') ?>
<div class="col-lg-9 col-md-9 col-sm-12  pt-4">

	<div class="row">
		<div class="col-xl-12 col-lg-12 col-md-12">
			<div class="dashboard_wrap">
				<div class="row">
					<div class="col-xl-12 col-lg-12 col-md-12">
						<h6 class="m-0">Details</h6><hr>
					</div>
				</div>
				<div class="row justify-content-center">
					<div class="col-md-12 col-lg-12 col-sm-12">
						<div class="accordion">
							<div class="card">
								<div id="certificateDetails" class="card-header bg-white shadow-sm border-0">
									<h6 class="mb-0 accordion_title"><a href="#" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne" class="d-block position-relative text-dark collapsible-link py-2">Basic Details</a></h6>
								</div>
								<div id="collapseOne" aria-labelledby="certificateDetails"  class="collapse show" style="">
									<div class="card-body pl-3 pr-3 pt-0">
										<ul class="lists-3 row">
											<li class="col-xl-4 col-lg-4 col-md-4 m-0 mb-1"><b class="text-muted">Certificate No.</b></li>
											<li class="text-right col-xl-1 col-lg-1 col-md-1 m-0 mb-1">:</li>
											<li class="col-xl-4 col-lg-4 col-md-4 m-0 mb-1"><?= $details->certificate_no; ?></li>

											<li class="col-xl-4 col-lg-4 col-md-4 m-0 mb-1"><b class="text-muted">Enrollment No.</b></li>
											<li class="text-right col-xl-1 col-lg-1 col-md-1 m-0 mb-1">:</li>
											<li class="col-xl-4 col-lg-4 col-md-4 m-0 mb-1"><?= $details->enrollment_number; ?></li>

											<li class="col-xl-4 col-lg-4 col-md-4 m-0 mb-1"><b class="text-muted">Candidate Name</b></li>
											<li class="text-right col-xl-1 col-lg-1 col-md-1 m-0 mb-1">:</li>
											<li class="col-xl-4 col-lg-4 col-md-4 m-0 mb-1"><?= $details->candidate_name; ?></li>

											<li class="col-xl-4 col-lg-4 col-md-4 m-0 mb-1"><b class="text-muted">Father's Name</b></li>
											<li class="text-right col-xl-1 col-lg-1 col-md-1 m-0 mb-1">:</li>
											<li class="col-xl-4 col-lg-4 col-md-4 m-0 mb-1"><?= $details->father_name; ?></li>

											<li class="col-xl-4 col-lg-4 col-md-4 m-0 mb-1"><b class="text-muted">Session</b></li>
											<li class="text-right col-xl-1 col-lg-1 col-md-1 m-0 mb-1">:</li>
											<li class="col-xl-4 col-lg-4 col-md-4 m-0 mb-1"><?= date('M y', $details->from_session).'-'.date('M y', $details->to_session) ?></li>

											<li class="col-xl-4 col-lg-4 col-md-4 m-0 mb-1"><b class="text-muted">Duration</b></li>
											<li class="text-right col-xl-1 col-lg-1 col-md-1 m-0 mb-1">:</li>
											<li class="col-xl-4 col-lg-4 col-md-4 m-0 mb-1"><?= strtoupper(numbertoWords($details->duration)).' MONTHS' ?></li>

											<li class="col-xl-4 col-lg-4 col-md-4 m-0 mb-1"><b class="text-muted">Grade</b></li>
											<li class="text-right col-xl-1 col-lg-1 col-md-1 m-0 mb-1">:</li>
											<li class="col-xl-4 col-lg-4 col-md-4 m-0 mb-1"><?= $details->grade; ?></li>

											<li class="col-xl-4 col-lg-4 col-md-4 m-0 mb-1"><b class="text-muted">Student Photo</b></li>
											<li class="text-right col-xl-1 col-lg-1 col-md-1 m-0 mb-1">:</li>
											<li class="col-xl-4 col-lg-4 col-md-4 m-0 mb-1"><img src="<?= site_url('public/upload/branch-files/student/student-image/').$details->student_photo; ?>" alt="student photo" class="img-fluid img-responsive img-thumbnail" width="80px"></li>
										</ul>
									</div>
								</div>
							</div>

							<?php if ($details->typing_test == 1): ?>								
								<div class="card">
									<div id="certificateDetails" class="card-header bg-white shadow-sm border-0">
										<h6 class="mb-0 accordion_title"><a href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo" class="d-block position-relative text-dark collapsible-link py-2">Typing Skill Details</a></h6>
									</div>
									<div id="collapseTwo" aria-labelledby="certificateDetails"  class="collapse show" style="">
										<div class="card-body pl-3 pr-3 pt-0">
											<?php  
											$language = unserialize($details->language);
											$speed = unserialize($details->speed);
											$accuracy = unserialize($details->accuracy);
											$time = unserialize($details->time);
											?>
											<table class="table table-sm table-centered mb-0">
												<thead>
													<tr>
														<th scope="col">Language</th>
														<th scope="col">Speed</th>
														<th scope="col">Accuracy</th>
														<th scope="col">Time</th>
													</tr>
												</thead>
												<tbody>
													<?php if (!empty($language)): ?>
														<?php foreach ($language as $key => $val): ?>
															<tr>
																<td><b class="text-muted"><?= $val ?></b></td>
																<td><?= $speed[$key]. ' W.P.M'; ?></td>
																<td><?= $accuracy[$key].'%'; ?></td>
																<td><?= $time[$key].' Minute'; ?></td>
															</tr>
														<?php endforeach ?>
													<?php endif ?>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							<?php endif ?>


							<div class="card">
								<div id="certificateDetails" class="card-header bg-white shadow-sm border-0">
									<h6 class="mb-0 accordion_title"><a href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo" class="d-block position-relative text-dark collapsible-link py-2">Certificate Status</a></h6>
								</div>
								<div id="collapseTwo" aria-labelledby="certificateDetails"  class="collapse show" style="">
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
												<li class="col-xl-4 col-lg-4 col-md-4 m-0 mb-1"><b class="text-muted">Download</b></li>
												<li class="text-right col-xl-1 col-lg-1 col-md-1 m-0 mb-1">:</li>
												<li class="col-xl-4 col-lg-4 col-md-4 m-0 mb-1">
													<a href="<?= site_url('public/upload/branch-files/student/certificate/').$details->certificate_file;?>" class="btn-sm download-btn" download="<?= $details->certificate_file;?>"><i class="ti-download"></i></a>
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
