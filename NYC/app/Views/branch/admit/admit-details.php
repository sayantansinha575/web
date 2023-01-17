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
								<div id="examDetails" class="card-header bg-white shadow-sm border-0">
									<h6 class="mb-0 accordion_title"><a href="#" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne" class="d-block position-relative text-dark collapsible-link py-2">Basic Details</a></h6>
								</div>
								<div id="collapseOne" aria-labelledby="examDetails"  class="collapse show" style="">
									<div class="card-body pl-3 pr-3 pt-0">
										<ul class="lists-3 row">

											<li class="col-xl-4 col-lg-4 col-md-4 m-0 mb-1"><b class="text-muted">Candidate Name</b></li>
											<li class="text-right col-xl-1 col-lg-1 col-md-1 m-0 mb-1">:</li>
											<li class="col-xl-4 col-lg-4 col-md-4 m-0 mb-1"><?= $details->candidate_name; ?></li>

											<li class="col-xl-4 col-lg-4 col-md-4 m-0 mb-1"><b class="text-muted">Enrollment No.</b></li>
											<li class="text-right col-xl-1 col-lg-1 col-md-1 m-0 mb-1">:</li>
											<li class="col-xl-4 col-lg-4 col-md-4 m-0 mb-1"><?= $details->enrollment_number; ?></li>

											<li class="col-xl-4 col-lg-4 col-md-4 m-0 mb-1"><b class="text-muted">Registration No.</b></li>
											<li class="text-right col-xl-1 col-lg-1 col-md-1 m-0 mb-1">:</li>
											<li class="col-xl-4 col-lg-4 col-md-4 m-0 mb-1"><?= $details->registration_number; ?></li>

											<li class="col-xl-4 col-lg-4 col-md-4 m-0 mb-1"><b class="text-muted">Brnach Code</b></li>
											<li class="text-right col-xl-1 col-lg-1 col-md-1 m-0 mb-1">:</li>
											<li class="col-xl-4 col-lg-4 col-md-4 m-0 mb-1"><?= $details->branch_code; ?></li>

											<li class="col-xl-4 col-lg-4 col-md-4 m-0 mb-1"><b class="text-muted">Student Photo</b></li>
											<li class="text-right col-xl-1 col-lg-1 col-md-1 m-0 mb-1">:</li>
											<li class="col-xl-4 col-lg-4 col-md-4 m-0 mb-1"><img src="<?= site_url('public/upload/branch-files/student/student-image/').$details->student_photo; ?>" alt="student photo" class="img-fluid img-responsive img-thumbnail" width="80px"></li>

										</ul>
									</div>
								</div>
							</div>

							<div class="card">
								<div id="examDetails" class="card-header bg-white shadow-sm border-0">
									<h6 class="mb-0 accordion_title"><a href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo" class="d-block position-relative text-dark collapsible-link py-2">Exam Details</a></h6>
								</div>
								<div id="collapseTwo" aria-labelledby="examDetails"  class="collapse show" style="">
									<div class="card-body pl-3 pr-3 pt-0">
										<ul class="lists-3 row">

											<li class="col-xl-4 col-lg-4 col-md-4 m-0 mb-1"><b class="text-muted">Exam Name</b></li>
											<li class="text-right col-xl-1 col-lg-1 col-md-1 m-0 mb-1">:</li>
											<li class="col-xl-4 col-lg-4 col-md-4 m-0 mb-1"><?= $details->exam_name; ?></li>

											<li class="col-xl-4 col-lg-4 col-md-4 m-0 mb-1"><b class="text-muted">Exam Date</b></li>
											<li class="text-right col-xl-1 col-lg-1 col-md-1 m-0 mb-1">:</li>
											<li class="col-xl-4 col-lg-4 col-md-4 m-0 mb-1"><?= date('F d, Y', $details->exam_date); ?></li>

											<li class="col-xl-4 col-lg-4 col-md-4 m-0 mb-1"><b class="text-muted">Exam Day</b></li>
											<li class="text-right col-xl-1 col-lg-1 col-md-1 m-0 mb-1">:</li>
											<li class="col-xl-4 col-lg-4 col-md-4 m-0 mb-1"><?= $details->exam_day; ?></li>

											<li class="col-xl-4 col-lg-4 col-md-4 m-0 mb-1"><b class="text-muted">Exam Time</b></li>
											<li class="text-right col-xl-1 col-lg-1 col-md-1 m-0 mb-1">:</li>
											<li class="col-xl-4 col-lg-4 col-md-4 m-0 mb-1"><?= $details->exam_time; ?></li>

											<li class="col-xl-4 col-lg-4 col-md-4 m-0 mb-1"><b class="text-muted">Exam Fees</b></li>
											<li class="text-right col-xl-1 col-lg-1 col-md-1 m-0 mb-1">:</li>
											<li class="col-xl-4 col-lg-4 col-md-4 m-0 mb-1"> <i class="fas fa-rupee-sign"></i> <?= number_format($details->exam_fees, 2); ?></li>

										</ul>
									</div>
								</div>
							</div>

							<div class="card">
								<div id="examDetails" class="card-header bg-white shadow-sm border-0">
									<h6 class="mb-0 accordion_title"><a href="#" data-toggle="collapse" data-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree" class="d-block position-relative text-dark collapsible-link py-2">Download Admit</a></h6>
								</div>
								<div id="collapseThree" aria-labelledby="examDetails"  class="collapse show" style="">
									<div class="card-body pl-3 pr-3 pt-0">
										<ul class="lists-3 row">
											<li class="col-xl-4 col-lg-4 col-md-4 m-0 mb-1"><b class="text-muted">Download</b></li>
											<li class="text-right col-xl-1 col-lg-1 col-md-1 m-0 mb-1">:</li>
											<li class="col-xl-4 col-lg-4 col-md-4 m-0 mb-1">
												<a href="<?= site_url('public/upload/branch-files/student/admit/').$details->admit_file;?>" class="btn-sm download-btn" download><i class="ti-download"></i></a>
											</li>
										</ul>
									</div>
								</div>
							</div>

						</div>
						<p><b class="text-muted">P.S. - If you want to make further chnages, please contact Head Office or call 9903333223.</b></p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
<?= $this->endSection(); ?>
