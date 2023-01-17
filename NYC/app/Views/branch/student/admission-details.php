<?= $this->extend('branch/layOut'); ?>
<?= $this->section('body') ?>
<?php  
   $fileArr[] = array(
      'name' => 'Qualification Proof',
      'file' => $details->qualification_file,
      'url' => site_url('public/upload/branch-files/student/qualification-file/'.$details->qualification_file),
   );
   $fileArr[] = array(
      'name' => 'Identity Proof',
      'file' => $details->identity_proof,
      'url' => site_url('public/upload/branch-files/student/identity-proof-file/'.$details->identity_proof),
   );
?>
<div class="col-lg-9 col-md-9 col-sm-12 pt-4" id="printSection">

	<div class="row">
		<div class="col-xl-12 col-lg-12 col-md-12">
			<div class="dashboard_wrap">
				<div class="row card-header hidePrint">
					<div class="col-xl-6 col-lg-6 col-md-6 mb-4">
						<h6 class="m-0">Details</h6>
					</div>
					<div class="col-xl-6 col-lg-6 col-md-6 mb-4 text-right">
						<a href="javascript:void(0)" class="btn btn-sm btn-info" onclick="window.print();return false;"><i class="fa-solid fa-print"></i></a>
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
								<div id="studentInfo" class="card-header bg-white shadow-sm border-0">
									<h6 class="mb-0 accordion_title"><a href="#" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne" class="d-block position-relative text-dark collapsible-link py-2 printableCollapse">Student Infomation</a></h6>
								</div>
								<div id="collapseOne" aria-labelledby="studentInfo"  class="collapse show" style="">
									<div class="card-body pl-3 pr-3 pt-0 printableCardBody">
										<table class="table dash_list printableTbl">
											<tbody>
												<tr>
													<td width="25%">Enrollment Number</td>
													<td width="2%">:</td>
													<td><?= $details->enrollment_number; ?></td>
												</tr>
												<tr>
													<td width="25%">Registration Number</td>
													<td width="2%">:</td>
													<td><?= $details->registration_number; ?></td>
												</tr>
												<tr>
													<td width="25%">Name</td>
													<td width="2%">:</td>
													<td><?= $details->student_name; ?></td>
												</tr>
												<tr>
													<td width="25%">Mother's Name</td>
													<td width="2%">:</td>
													<td><?= $details->mother_name; ?></td>
												</tr>
												<td width="25%">Father's Name</td>
												<td width="2%">:</td>
												<td><?= $details->father_name; ?></td>
											</tr>
											<tr>
												<td width="25%">Phone</td>
												<td width="2%">:</td>
												<td><?= $details->mobile; ?></td>
											</tr>
											<tr>
												<td width="25%">D.O.B.</td>
												<td width="2%">:</td>
												<td><?= date('M j, Y', $details->student_dob); ?></td>
											</tr>
											<tr>
												<td width="25%">Gender</td>
												<td width="2%">:</td>
												<td><?= $details->gender; ?></td>
											</tr>
											<tr>
												<td width="25%">Residential Address</td>
												<td width="2%">:</td>
												<td><?= $details->residential_address; ?></td>
											</tr>
											<tr>
												<td width="25%">Profile Picture</td>
												<td width="2%">:</td>
												<td>
													<img src="<?= site_url('public/upload/branch-files/student/student-image/').$details->student_photo ?>" alt="student photo" class="img-fluid img-responsive img-thumbnail" width="80px">
												</td>
											</tr>
										</tbody>
									</table>
									</div>
								</div>
							</div>

							<div class="card">
								<div id="courseDetails" class="card-header bg-white shadow-sm border-0">
									<h6 class="mb-0 accordion_title"><a href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo" class="d-block position-relative text-dark collapsible-link py-2 printableCollapse">Course Details</a></h6>
								</div>
								<div id="collapseTwo" aria-labelledby="courseDetails"  class="collapse show" style="">
									<div class="card-body pl-3 pr-3 pt-0 printableCardBody">
										<table class="table dash_list printableTbl">
											<tbody>
												<tr>
													<td width="25%">Course Name</td>
													<td width="2%">:</td>
													<td><?= $details->courseName; ?></td>
												</tr>
												<tr>
													<td width="25%">Course Code</td>
													<td width="2%">:</td>
													<td><?= $details->course_code; ?></td>
												</tr>
												<tr>
													<td width="25%">Course Type</td>
													<td width="2%">:</td>
													<td><?= $details->courseTypeName; ?></td>
												</tr>
												<tr>
													<td width="25%">Course Eligibility</td>
													<td width="2%">:</td>
													<td><?= $details->course_eligibility; ?></td>
												</tr>
												<tr>
													<td width="25%">Course Duration</td>
													<td width="2%">:</td>
													<td><?= $details->course_duration.(($details->course_duration > 1)?'Months':'Month'); ?></td>
												</tr>
												<tr>
													<td width="25%">Date of Admission</td>
													<td width="2%">:</td>
													<td><?= date('M j, Y', $details->admission_date); ?></td>
												</tr>
												<tr>
													<td width="25%">From Session</td>
													<td width="2%">:</td>
													<td><?= date('M j, Y', $details->from_session); ?></td>
												</tr>
												<tr>
													<td width="25%">To Session</td>
													<td width="2%">:</td>
													<td><?= date('M j, Y', $details->to_session); ?></td>
												</tr>

											</tbody>
										</table>
									</div>
								</div>
							</div>

							<div class="card">
								<div id="branchDetails" class="card-header bg-white shadow-sm border-0">
									<h6 class="mb-0 accordion_title"><a href="#" data-toggle="collapse" data-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree" class="d-block position-relative text-dark collapsible-link py-2 printableCollapse">Branch Details</a></h6>
								</div>
								<div id="collapseThree" aria-labelledby="branchDetails"  class="collapse show" style="">
									<div class="card-body pl-3 pr-3 pt-0 printableCardBody">
										<table class="table dash_list printableTbl">
											<tbody>
												<tr>
													<td width="25%">Branch Name</td>
													<td width="2%">:</td>
													<td><?= $details->branchName; ?></td>
												</tr>
												<tr>
													<td width="25%">Branch Code</td>
													<td width="2%">:</td>
													<td><?= $details->branchCode; ?></td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>

							<div class="card hidePrint">
								<div id="uploadedDocs" class="card-header bg-white shadow-sm border-0">
									<h6 class="mb-0 accordion_title"><a href="#" data-toggle="collapse" data-target="#collapseFour" aria-expanded="true" aria-controls="collapseFour" class="d-block position-relative text-dark collapsible-link py-2 printableCollapse">Uploaded Documents</a></h6>
								</div>
								<div id="collapseFour" aria-labelledby="uploadedDocs"  class="collapse show" style="">
									<div class="card-body pl-3 pr-3 pt-0">
										<table class="table">
											<thead>
												<tr>
													<th scope="col" width="10%">#</th>
													<th scope="col">File Name</th>
													<th scope="col" width="18%">Action</th>
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
															<th scope="row"><?= $i++; ?></th>
															<td><div class="smalls lg"><?= $file['name'] ?></div></td>
															<td>
																<a class="btn-sm btn-icon btn-success download-btn" href="<?= $file['url']; ?>" download><i class="fas fa-download"></i></a>
															</td>
														</tr>
													<?php endforeach ?>
												<?php endif ?>
											</tbody>
										</table>
									</div>
								</div>
							</div>

							<div class="card hidePrint">
								<div id="downloadDocs" class="card-header bg-white shadow-sm border-0">
									<h6 class="mb-0 accordion_title"><a href="#" data-toggle="collapse" data-target="#collapseFive" aria-expanded="true" aria-controls="collapseFive" class="d-block position-relative text-dark collapsible-link py-2 printableCollapse">Available Documents For Download</a></h6>
								</div>
								<div id="collapseFive" aria-labelledby="downloadDocs"  class="collapse show" style="">
									<div class="card-body pl-3 pr-3 pt-0">
									<?php if (!empty($details->nycta_icard) || (!empty($details->marksheet_file) && $details->has_marksheet == 'Yes') || !empty($details->certificate_file)): ?>
										<table class="table">
											<thead>
												<tr>
													<th scope="col" width="10%">#</th>
													<th scope="col">File Name</th>
													<th scope="col" width="18%">Action</th>
												</tr>
											</thead>
											<tbody>
												<?php $i = 1; ?>
												<?php if (!empty($details->nycta_icard)): ?>
													<tr>
														<td><?= $i++; ?></td>
														<td>I-Card</td>
														<td>
															<a class="btn-sm btn-icon btn-success download-btn" href="<?= site_url('public/upload/branch-files/student/identity-card/'.$details->nycta_icard.'.pdf'); ?>" download="<?= decrypt($details->nycta_icard).'.pdf'; ?>"><i class="fas fa-download"></i></a>
														</td>
													</tr>
												<?php endif ?>
												<?php if (!empty($details->marksheet_file) && $details->has_marksheet == 'Yes'): ?>
													<tr>
														<td><?= $i++; ?></td>
														<td>Marksheet</td>
														<td>
															<a class="btn-sm btn-icon btn-success download-btn" href="<?= site_url('public/upload/branch-files/student/marksheet/'.$details->marksheet_file); ?>" download><i class="fas fa-download"></i></a>
														</td>
													</tr>
												<?php endif ?>
												<?php if (!empty($details->certificate_file)): ?>
													<tr>
														<td><?= $i++; ?></td>
														<td>Certificate</td>
														<td>
															<a class="btn-sm btn-icon btn-success download-btn" href="<?= site_url('public/upload/branch-files/student/certificate/'.$details->certificate_file); ?>" download><i class="fas fa-download"></i></a>
														</td>
													</tr>
												<?php endif ?>
											</tbody>
										</table>
									<?php else: ?>
										<div class="text-center">
											<b class="text-muted">
												No Documents Found
											</b>
										</div>
									<?php endif ?>
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
