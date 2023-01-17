<?= $this->extend('branch/layOut'); ?>
<?= $this->section('body') ?>
<div class="col-lg-9 col-md-9 col-sm-12">
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-body">
					<h6>Course Details</h6><hr><br>
					<div class="row">
						<div class="col-md-2 mb-2">
							<label for="">Course Name</label>
						</div>
						<div class="col-md-1 text-center mb-2">:</div>
						<div class="col-md-9 mb-2">
							<?= $details->course_name; ?>
						</div>
						<div class="col-md-2 mb-2">
							<label for="">Course type</label>
						</div>
						<div class="col-md-1 text-center mb-2">:</div>
						<div class="col-md-9 mb-2">
							<?= $details->courseTypeName; ?>
						</div>
						<div class="col-md-2 mb-2">
							<label for="">Branch Name</label>
						</div>
						<div class="col-md-1 text-center mb-2">:</div>
						<div class="col-md-9 mb-2">
							<?= $details->branch_name; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div> 
	<div class="row">
		<div class="col-xl-12 col-lg-12 col-md-12">
			<div class="dashboard_wrap">

				<div class="row">
					<div class="col-xl-12 col-lg-12 col-md-12 mb-2">
						<h6 class="m-0">File Details</h6><hr>
					</div>
				</div>

				<div class="row justify-content-center">
					<div class="col-xl-12 col-lg-12 col-md-12">
						<form action="<?= current_url(); ?>" id="formDefault" accept-charset="UTF-8" autocomplete="off">
							<div class="row">
								<div class="col-md-12 mb-3">
									<div class="form-group smalls">
										<label for="documents" class="form-label">Description</label>
										<?php
										include('ckeditor.php');
										$CKEditor->editor('description', $details->description);
										?>
									</div>
								</div>
								<div class="col-md-12 mb-3">
									<div class="form-group smalls">
										<label for="documents" class="form-label">Docuemnts</label>
										<input class="form-control" type="file" id="documents" name="documents[]" accept=".docx,.xlsx,.pdf" multiple>
									</div>
								</div>

								<div class="col-md-12">
									<table class="table table-sm table-centered mb-0 docsListTbl">
										<thead>
											<tr>
												<th width="5%">#</th>
												<th width="85%">Document</th>
												<th width="10%">Action</th>
											</tr>
										</thead>
										<tbody>
											<?php if (!empty($details)): 
												$desc = $details->description;
												$files = unserialize($details->documents);
												$i = 1;
												?>
												<?php foreach ($files as $Key => $file): ?>
													<tr>
														<td><?= $i++ ?></td>
														<td><?= $file ?></td>
														<td class="text-center">
															<div class="dropdown show">
																<a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
																	<i class="fas fa-ellipsis-h"></i>
																</a>
																<div class="drp-select dropdown-menu">
																	<a download href="<?= site_url('public/upload/files/branch/course-documents/'.$details->course_id.'/'.$details->branch_id.'/'.$file) ?>" class="dropdown-item">Download</a>
																	<a href="javascript:void(0)" class="dropdown-item deleteCourseMaterial" data-file="<?= $file.'||'.encrypt($details->course_id).'||'.encrypt($details->parent_id).'||'.encrypt($details->id) ?>" >Delete</a>
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

							<div class="form-group smalls">
								<?= csrf_field(); ?>
								<input type="hidden" name="course_id" value="<?= $details->course_id ?>">
								<button class="btn theme-bg text-white defaultSaveButton" type="submit">Update</button>								
							</div>
						</div>
					</form>
				</div>
			</div>

		</div>
	</div>

</div>
<?= $this->endSection(); ?>