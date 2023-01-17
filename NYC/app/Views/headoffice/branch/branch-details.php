<?= $this->extend('headoffice/layOut'); ?>
<?= $this->section('body') ?>
<?php  
	$fileArr[] = array(
		'name' => 'NYCTA Logo',
		'file' => $details->nycta_logo,
		'url' => site_url('public/upload/files/branch/nycta-logo/'.$details->nycta_logo),
	);
	$fileArr[] = array(
		'name' => 'Authorization Letter',
		'file' => $details->auth_letter,
		'url' => site_url('public/upload/branch-files/auth-letter/'.$details->auth_letter),
	);
	$fileArr[] = array(
		'name' => 'Signature',
		'file' => $details->signature,
		'url' => site_url('public/upload/files/branch/signature/'.$details->signature),
	);
	$fileArr[] = array(
		'name' => 'Branch Logo',
		'file' => $details->branch_image,
		'url' => site_url('public/upload/files/branch/branch-image/'.$details->branch_image),
	);
?>

<div class="container-fluid">

	<!-- start page title -->
	<div class="row">
		<div class="col-12">
			<div class="page-title-box">
				<div class="page-title-right">
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="/head-office/branch">Branch</a></li>
						<li class="breadcrumb-item active">Branch Details</li>

					</ol>
				</div>
				<h4 class="page-title"><?= $title; ?></h4>
			</div>
		</div>
	</div>     
	<!-- end page title --> 

	
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-body">
				
			<br>
					<div class="accordion custom-accordion mb-4" id="custom-accordion">
						<div class="card mb-0">
							<div class="card-header" id="headimgOne">
								<h5 class="m-0">
									<a class="custom-accordion-title d-block py-1" data-bs-toggle="collapse" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">BRANCH DETAILS<i class="mdi mdi-chevron-down accordion-arrow"></i></a>
								</h5>
							</div>

							<div id="collapseOne" class="collapse show" aria-labelledby="headimgOne">
								<div class="card-body">
									<table class="table table-sm table-centered mb-0">
										<tbody>
											<tr>
												<td width="20%">Branch Code</td>
												<td class="text-end">:</td>
												<td><?= $details->branch_code; ?></td>
											</tr>
											<tr>
												<td width="20%">Branch Name</td>
												<td class="text-end">:</td>
												<td><?= $details->branch_name; ?></td>
											</tr>
											<tr>
												<td width="20%">Branch Email</td>
												<td class="text-end">:</td>
												<td><?= $details->branch_email; ?></td>
											</tr>
											<tr>
												<td width="20%">Date of Registration</td>
												<td class="text-end">:</td>
												<td><?= date('F j, Y', $details->date_of_registration); ?></td>
											</tr>											
										</tbody>
									</table>
								</div>
							</div>
						</div>
						<div class="card mb-0">
							<div class="card-header" id="headimgOne">
								<h5 class="m-0">
									<a class="custom-accordion-title d-block py-1" data-bs-toggle="collapse" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">ACADEMY DETAILS<i class="mdi mdi-chevron-down accordion-arrow"></i></a>
								</h5>
							</div>

							<div id="collapseTwo" class="collapse show" aria-labelledby="headimgOne">
								<div class="card-body">
									<table class="table table-sm table-centered mb-0">
										<tbody>
											<tr>
												<td width="20%">Academy Code</td>
												<td class="text-end">:</td>
												<td><?= $details->academy_code; ?></td>
											</tr>
											<tr>
												<td width="20%">Academy Name</td>
												<td class="text-end">:</td>
												<td><?= $details->academy_name; ?></td>
											</tr>
											<tr>
												<td width="20%">Academy Address</td>
												<td class="text-end">:</td>
												<td><?= $details->academy_address; ?></td>
											</tr>
											<tr>
												<td width="20%">Academy Phone</td>
												<td class="text-end">:</td>
												<td><?= $details->academy_phone; ?></td>
											</tr>											
										</tbody>
									</table>
								</div>
							</div>
						</div>
						<div class="card mb-0">
							<div class="card-header" id="headimgOne">
								<h5 class="m-0">
									<a class="custom-accordion-title d-block py-1" data-bs-toggle="collapse" href="#collapseThree" aria-expanded="true" aria-controls="collapseThree">OTHER DETAILS<i class="mdi mdi-chevron-down accordion-arrow"></i></a>
								</h5>
							</div>

							<div id="collapseThree" class="collapse show" aria-labelledby="headimgOne">
								<div class="card-body">
									<table class="table table-sm table-centered mb-0">
										<tbody>
											<tr>
												<td width="20%">Invoice Prefix</td>
												<td class="text-end">:</td>
												<td><?= $details->invoice_prefix; ?></td>
											</tr>
											<tr>
												<td width="20%">Student Enrollment Prefix</td>
												<td class="text-end">:</td>
												<td><?= $details->student_enrollment_prefix; ?></td>
											</tr>
											<tr>
												<td width="20%">Student Registration Prefix</td>
												<td class="text-end">:</td>
												<td><?= $details->student_registration_prefix; ?></td>
											</tr>
											<tr>
												<td width="20%">Certificate Prefix</td>
												<td class="text-end">:</td>
												<td><?= $details->certificate_prefix; ?></td>
											</tr>
											<tr>
												<td width="20%">Marksheet Prefix</td>
												<td class="text-end">:</td>
												<td><?= $details->marksheet_prefix; ?></td>
											</tr>											
										</tbody>
									</table>
								</div>
							</div>
						</div>
						<div class="card mb-0">
							<div class="card-header" id="headimgOne">
								<h5 class="m-0">
									<a class="custom-accordion-title d-block py-1" data-bs-toggle="collapse" href="#collapseFour" aria-expanded="true" aria-controls="collapseFour">Documents<i class="mdi mdi-chevron-down accordion-arrow"></i></a>
								</h5>
							</div>

							<div id="collapseFour" class="collapse show" aria-labelledby="headimgOne">
								<div class="card-body">
									<table class="table table-sm table-centered mb-0">
										<thead>
											<tr>
												<th scope="col" width="10%">#</th>
												<th scope="col">File Name</th>
												<th scope="col" width="18%">Action</th>
											</tr>
										</thead>
										<tbody>
											<?php if (!empty($fileArr)): $i = 1;?>
												<?php foreach ($fileArr as $file): 
													if (empty($file['file'])) {
														continue;
													}
													?>
													<tr>
														<th scope="row"><?= $i++; ?></th>
														<td><div class="smalls lg"><?= $file['name'] ?></div></td>
														<td>
															<a class="btn btn-success btn-sm btn-icon" href="<?= $file['url']; ?>" download="<?= strtolower(str_replace(' ', '-', $file['name'])) ?>" data-toggle="tooltip" title="Download"><i class="fa-solid fa-download"></i></a>
														</td>
													</tr>
												<?php endforeach ?>
											<?php endif ?>								
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
	<?= $this->endSection(); ?>