<?= $this->extend('headoffice/layOut'); ?>
<?= $this->section('body') ?>

<div class="container-fluid">

	<div class="row">
		<div class="col-12">
			<div class="page-title-box">
				<div class="page-title-right">
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="/head-office/student">Student</a></li>
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
												<td width="20%">Registration No.</td>
												<td class="text-end">:</td>
												<td><?= $details->registration_number; ?></td>
											</tr>
											<tr>
												<td width="20%">Name</td>
												<td class="text-end">:</td>
												<td><?= $details->student_name; ?></td>
											</tr>
											<tr>
												<td width="20%">D.O.B.</td>
												<td class="text-end">:</td>
												<td><?= date('F j, Y', $details->student_dob); ?></td>
											</tr>
											<tr>
												<td width="20%">Gender</td>
												<td class="text-end">:</td>
												<td><?= $details->gender; ?></td>
											</tr>
											<tr>
												<td width="20%">Mobile</td>
												<td class="text-end">:</td>
												<td><?= $details->mobile; ?></td>
											</tr>
											<tr>
												<td width="20%">Residential Address</td>
												<td class="text-end">:</td>
												<td><?= $details->residential_address; ?></td>
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
					</div>
				</div>
			</div>
		</div>
	</div>
	
</div>
<?= $this->endSection(); ?>