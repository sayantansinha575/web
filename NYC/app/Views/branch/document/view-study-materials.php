<?= $this->extend('branch/layOut'); ?>
<?= $this->section('body') ?>
<div class="col-lg-9 col-md-9 col-sm-12  pt-4">
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-body">
					<h6>Study Material Details</h6><hr><br>
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
							<label for="">Description</label>
						</div>
						<div class="col-md-1 text-center mb-2">:</div>
						<div class="col-md-9 mb-2">
							<?= $details->description; ?>
						</div>
						<div class="col-md-2 mb-2">
							<label for="">Documents</label>
						</div>
						<div class="col-md-1 text-center mb-2">:</div>
						<div class="col-md-9 mb-2">
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
<?= $this->endSection(); ?>