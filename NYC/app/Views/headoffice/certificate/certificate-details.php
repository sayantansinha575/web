<?= $this->extend('headoffice/layOut'); ?>
<?= $this->section('body') ?>

<div class="container-fluid">

	<div class="row">
		<div class="col-12">
			<div class="page-title-box">
				<div class="page-title-right">
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="/head-office/certificate">Certificate</a></li>
						<li class="breadcrumb-item active">Certificate Details</li>
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
												<td width="20%"><Certi></Certi>Certificate No.</td>
												<td class="text-end">:</td>
												<td><?= $details->certificate_no; ?></td>
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
												<td width="20%">Course</td>
												<td class="text-end">:</td>
												<td><?= fieldValue('course', 'course_name', array('id' => $details->course_id)).' ('.fieldValue('course', 'short_name', array('id' => $details->course_id)).')' ?></td>
											</tr>
											<tr>
												<td width="20%">Branch Name</td>
												<td class="text-end">:</td>
												<td><?= fieldValue('branch', 'branch_name', array('id' => $details->branch_id)) ?></td>
											</tr>
											<tr>
												<td width="20%">Session</td>
												<td class="text-end">:</td>
												<td><?= date('M y', $details->from_session).'-'.date('M y', $details->to_session) ?></td>
											</tr>
											<tr>
												<td width="20%">Duration</td>
												<td class="text-end">:</td>
												<td><?= strtoupper(numbertoWords($details->duration)). ' MONTHS' ?></td>
											</tr>
											<tr>
												<td width="20%">Grade</td>
												<td class="text-end">:</td>
												<td><?= $details->grade; ?></td>
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
						
						<?php if ($details->typing_test == 1): ?>
							<div class="card mb-0">
								<div class="card-header" id="headingThree">
									<h5 class="m-0">
										<a class="custom-accordion-title d-block py-1" data-bs-toggle="collapse" href="#CollapseThree" aria-expanded="true" aria-controls="CollapseThree">Typing Skill<i class="mdi mdi-chevron-down accordion-arrow"></i></a>
									</h5>
								</div>

								<div id="CollapseThree" class="collapse show" aria-labelledby="headingThree">
									<div class="card-body">
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
					</div>
					<?php $status = $details->status; ?>
					<?php if (($status == 1) || ($status == 3)): ?>
						<button class="btn btn-success m-1 approveCert" type="button" data-id="<?= $details->id; ?>">Approve</button>
					<?php endif ?>
					<?php if (($status == 4) || ($status == 2)): ?>
						<button class="btn btn-success m-1 publishCert" type="button" data-id="<?= $details->id; ?>" <?= ($status == 4)?'disabled':'' ?>><?= ($status == 4)?'Published':'Publish' ?></button>
					<?php endif ?>
					<?php if($status == 2){?>
						<a target="_blank" href="<?php echo site_url('public/upload/branch-files/student/certificate/').$details->certificate_file;?>">
							<button class="btn btn-secondary m-1" type="button" >Preview</button>
						</a>
					<?php } ?>
					<?php if($status == 4){?>
						<a download href="<?php echo site_url('public/upload/branch-files/student/certificate/').$details->certificate_file;?>">
							<button class="btn btn-success m-1" type="button" >Download</button>
						</a>
					<?php } ?>
					<?php if ($status != 4): ?>
						<button class="btn btn-danger m-1 rejectCert" type="button" data-id="<?= $details->id; ?>" <?= ($details->status == 3)?'disabled':'' ?> ><?= ($details->status == 3)?'Rejected':'Reject' ?></button>
					<?php endif ?>
				</div>
			</div>
		</div>
	</div>
	
</div>
<?= $this->endSection(); ?>