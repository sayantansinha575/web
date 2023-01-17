<?= $this->extend('branch/layOut'); ?>
<?= $this->section('body') ?>
<div class="col-lg-9 col-md-9 col-sm-12  pt-4"> 
	<div class="row">
		<div class="col-xl-12 col-lg-12 col-md-12">
			<div class="dashboard_wrap">

				<div class="row">
					<div class="col-xl-12 col-lg-12 col-md-12 mb-2">
						<h6 class="m-0">Document Details</h6><hr>
					</div>
				</div>

				<div class="row justify-content-center">
					<div class="col-xl-12 col-lg-12 col-md-12">
							<div class="row">
								<div class="col-md-12 mb-3">
									<div class="form-group smalls">
										<label for="documents" class="form-label">Description</label>
										<p><?= $details->description ?></p>
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
											<?php if (unserialize($details->documents)): 
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
																	<a href="<?= site_url('public/upload/files/branch/branch-documents/'.$file) ?>" class="dropdown-item" download>Download</a>
																</div>
															</div>
														</td>
													</tr>
												<?php endforeach ?>
											<?php else: ?>
												<tr>
													<td colspan="3" class="text-center">No Documents Found</td>
												</tr>
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