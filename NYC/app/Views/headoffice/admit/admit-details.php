<?= $this->extend('headoffice/layOut'); ?>
<?= $this->section('body') ?>

<div class="container-fluid">

	<div class="row">
		<div class="col-12">
			<div class="page-title-box">
				<div class="page-title-right">
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="/head-officeadmit">Admit</a></li>
						<li class="breadcrumb-item active">Admit Details</li>
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
					<div class="accordion custom-accordion mb-4" id="custom-accordion">
						<div class="card mb-0">
							<div class="card-header" id="headimgOne">
								<h5 class="m-0">
									<a class="custom-accordion-title d-block py-1" data-bs-toggle="collapse" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">BASIC DETAILS<i class="mdi mdi-chevron-down accordion-arrow"></i></a>
								</h5>
							</div>

							<div id="collapseOne" class="collapse show" aria-labelledby="headimgOne">
								<div class="card-body">
									<table class="table table-sm table-centered mb-0">
										<tbody>
											<tr>
												<td width="20%"><Certi></Certi>Candidate Name</td>
												<td class="text-end">:</td>
												<td><?= $details->candidate_name; ?></td>
											</tr>
											<tr>
												<td width="20%">Enrollment No.</td>
												<td class="text-end">:</td>
												<td><?= $details->enrollment_number; ?></td>
											</tr>
											<tr>
												<td width="20%">Registration No.</td>
												<td class="text-end">:</td>
												<td><?= $details->registration_number; ?></td>
											</tr>
											<tr>
												<td width="20%">Brnach Code</td>
												<td class="text-end">:</td>
												<td><?= $details->branch_code; ?></td>
											</tr>
											<tr>
												<td width="20%">Student Photo</td>
												<td class="text-end">:</td>
												<td><img src="<?= site_url('public/upload/branch-files/student/student-image/').$details->student_photo; ?>" alt="student photo" class="img-fluid img-responsive img-thumbnail" width="80px"></td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
						<div class="card mb-0">
							<div class="card-header" id="headimgTwo">
								<h5 class="m-0">
									<a class="custom-accordion-title d-block py-1" data-bs-toggle="collapse" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">EXAM DETAILS<i class="mdi mdi-chevron-down accordion-arrow"></i></a>
								</h5>
							</div>

							<div id="collapseTwo" class="collapse show" aria-labelledby="headimgTwo">
								<div class="card-body">
									<table class="table table-sm table-centered mb-0">
										<tbody>
											<tr>
												<td width="20%"><Certi></Certi>Exam Name</td>
												<td class="text-end">:</td>
												<td><?= $details->exam_name; ?></td>
											</tr>
											<tr>
												<td width="20%">Exam Date</td>
												<td class="text-end">:</td>
												<td><?= date('F d, Y', $details->exam_date); ?></td>
											</tr>
											<tr>
												<td width="20%">Exam Day</td>
												<td class="text-end">:</td>
												<td><?= $details->exam_day; ?></td>
											</tr>
											<tr>
												<td width="20%">Exam Time</td>
												<td class="text-end">:</td>
												<td><?= $details->exam_time; ?></td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>

					
					<a download href="<?php echo site_url('public/upload/branch-files/student/admit/').$details->admit_file;?>">
						<button class="btn btn-success m-1" type="button" >Download</button>
					</a>
				</div>
			</div>
		</div>
	</div>
	
</div>
<?= $this->endSection(); ?>