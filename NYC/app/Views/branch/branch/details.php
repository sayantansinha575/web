<?= $this->extend('branch/layOut'); ?>
<?= $this->section('body') ?>
<?php  
	// $fileArr[] = array(
	// 	'name' => 'NYCTA Logo',
	// 	'file' => $details->nycta_logo,
	// 	'url' => site_url('public/upload/files/branch/nycta-logo/'.$details->nycta_logo),
	// );
	if (!empty($details->auth_letter)) {
		$fileArr[] = array(
			'name' => 'Authorization Letter',
			'file' => $details->auth_letter,
			'url' => site_url('public/upload/branch-files/auth-letter/'.$details->auth_letter),
		);
	}
	
	$fileArr[] = array(
		'name' => 'Signature',
		'file' => $details->signature,
		'url' => site_url('public/upload/files/branch/signature/'.$details->signature),
	);
	$fileArr[] = array(
		'name' => 'Associate Image',
		'file' => $details->branch_image,
		'url' => site_url('public/upload/files/branch/branch-image/'.$details->branch_image),
	);

?>
<div class="col-lg-9 col-md-9 col-sm-12 pt-4" id="printSection">
	<div class="row justify-content-between hidePrint">
		<div class="col-lg-12 col-md-12 col-sm-12 ">
			<div class="dashboard_wrap d-flex align-items-center justify-content-between">
				<div class="arion">
					<nav class="transparent">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="<?= site_url('branch/dashboard') ?>">Branch</a></li>
							<li class="breadcrumb-item active" aria-current="page">Deatils</li>
						</ol>
					</nav>
				</div>
			</div>
		</div>
	</div>
	<!-- /Row -->
	<div class="row">
		<div class="col-xl-12 col-lg-12 col-md-12">
			<div class="dashboard_wrap">
				<div class="row card-header hidePrint">
					<div class="col-xl-6 col-lg-6 col-md-6 mb-4">
						<h6 class="m-0">Details</h6>
					</div>
					<div class="col-xl-6 col-lg-6 col-md-6 mb-4 text-right">
						<a href="javascript:void(0)" class="btn-sm btn-info" onclick="window.print();return false;"><i class="fa-solid fa-print"></i></a>
					</div>
					<hr>
				</div>
				<div class="row justify-content-center">
					<div class="col-md-12 col-lg-12 col-sm-12">
						<div class="text-center">
							<img src="<?= site_url('public/global/print/print-header/header.jpg') ?>" alt="" width="100%">
						</div>
						<div class="accordion">
							<div class="card">
								<div id="branchDetails" class="card-header bg-white shadow-sm border-0">
									<h6 class="mb-0 accordion_title"><a href="#" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne" class="d-block position-relative text-dark collapsible-link py-2">Branch Details</a></h6>
								</div>
								<div id="collapseOne" aria-labelledby="branchDetails"  class="collapse show" style="">
									<div class="card-body pl-3 pr-3 pt-0">
										<table class="table dash_list printableTbl">
											<tbody>
												<tr>
													<td width="40%"><b>Branch Code</b></td>
													<td width="1%">:</td>
													<td><?= $details->branch_code; ?></td>
												</tr>
												<tr>
													<td width="40%"><b>Branch Name</b></td>
													<td width="1%">:</td>
													<td><?= $details->branch_name; ?></td>
												</tr>
												<tr>
													<td width="40%"><b>Branch Email</b></td>
													<td width="1%">:</td>
													<td><?= $details->branch_email; ?></td>
												</tr>
												<tr>
													<td width="40%"><b>Date of Registration</b></td>
													<td width="1%">:</td>
													<td><?= date('F j, Y', $details->date_of_registration); ?></td>
												</tr>
												<tr>
													<td width="40%"><b>Branch Head</b></td>
													<td width="1%">:</td>
													<td><?= $details->branch_head; ?></td>
												</tr>
												<tr>
													<td width="40%"><b>User Name</b></td>
													<td width="1%">:</td>
													<td><?= $details->username; ?></td>
												</tr>
												<tr>
													<td width="40%"><b>Associate Image</b></td>
													<td width="1%">:</td>
													<td> <img style="width: 100px;" src="<?= site_url('public/upload/files/branch/branch-image/'.$details->branch_image); ?>"> </td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>

							<div class="card">
								<div id="academyDetails" class="card-header bg-white shadow-sm border-0">
									<h6 class="mb-0 accordion_title"><a href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo" class="d-block position-relative text-dark collapsible-link py-2">Academy Details</a></h6>
								</div>
								<div id="collapseTwo" aria-labelledby="academyDetails"  class="collapse show" style="">
									<div class="card-body pl-3 pr-3 pt-0">
										<table class="table dash_list printableTbl">
											<tbody>
												<tr>
													<td width="40%"><b>Academy Code</b></td>
													<td width="1%">:</td>
													<td><?= $details->academy_code; ?></td>
												</tr>
												<tr>
													<td width="40%"><b>Academy Name</b></td>
													<td width="1%">:</td>
													<td><?= $details->academy_name; ?></td>
												</tr>
												<tr>
													<td width="40%"><b>Academy Address</b></td>
													<td width="1%">:</td>
													<td><?= $details->academy_address; ?></td>
												</tr>
												<tr>
													<td width="40%"><b>Academy Phone</b></td>
													<td width="1%">:</td>
													<td><?= $details->academy_phone; ?></td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>

							<div class="card">
								<div id="otherDetails" class="card-header bg-white shadow-sm border-0">
									<h6 class="mb-0 accordion_title"><a href="#" data-toggle="collapse" data-target="#collapseFour" aria-expanded="true" aria-controls="collapseFour" class="d-block position-relative text-dark collapsible-link py-2">Other Details</a></h6>
								</div>
								<div id="collapseFour" aria-labelledby="otherDetails"  class="collapse show" style="">
									<div class="card-body pl-3 pr-3 pt-0">
										<table class="table dash_list printableTbl">
											<tbody>
												<tr>
													<td width="40%"><b>Invoice Prefix</b></td>
													<td width="1%">:</td>
													<td><?= $details->invoice_prefix; ?></td>
												</tr>
												<tr>
													<td width="40%"><b>Student Enrollment Prefix</b></td>
													<td width="1%">:</td>
													<td><?= $details->student_enrollment_prefix; ?></td>
												</tr>
												<tr>
													<td width="40%"><b>Student Registration Prefix</b></td>
													<td width="1%">:</td>
													<td><?= $details->student_registration_prefix; ?></td>
												</tr>
												<tr>
													<td width="40%"><b>Certificate Prefix</b></td>
													<td width="1%">:</td>
													<td><?= $details->certificate_prefix; ?></td>
												</tr>
												
											</tbody>
										</table>
									</div>
								</div>
							</div>
							<div class="card hidePrint">
								<div id="documents" class="card-header bg-white shadow-sm border-0">
									<h6 class="mb-0 accordion_title"><a href="#" data-toggle="collapse" data-target="#collapsFive" aria-expanded="true" aria-controls="collapsFive" class="d-block position-relative text-dark collapsible-link py-2">Documents</a></h6>
								</div>
								<div id="collapsFive" aria-labelledby="documents"  class="collapse show" style="">
									<div class="card-body pl-3 pr-3 pt-0">
										<div class="table-responsive">
											<table class="table dash_list printableTbl">
												<thead>
													<tr>
														<th scope="col" width="10%">#</th>
														<th scope="col">File Name</th>
														<th scope="col" width="18%" class="text-center">Action</th>
													</tr>
												</thead>
												<tbody>
													<?php if (!empty($fileArr)): $i = 1; ?>
														<?php foreach ($fileArr as $file): 
															if (empty($file['file'])) {
																continue;
															}
														?>
															<tr>
																<th scope="row"><?= $i++;  ?></th>
																<td><div class="smalls lg"><?= $file['name'] ?></div></td>
																<td class="text-center">
																	<div class="dropdown show">
																		<a class="btn-action" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
																			<i class="fas fa-ellipsis-h"></i>
																		</a>
																		<div class="drp-select dropdown-menu">
																			<a class="dropdown-item" href="<?= $file['url']; ?>" download>Download</a>
																		</div>
																	</div>
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
		</div>
	</div>
</div>
</div>
<link rel="stylesheet" href="<?= site_url('public/branch/css/print.min.css') ?>">
<?= $this->endSection(); ?>
