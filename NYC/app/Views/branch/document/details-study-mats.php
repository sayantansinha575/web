<?= $this->extend('branch/layOut'); ?>
<?= $this->section('body') ?>
<div class="col-lg-9 col-md-9 col-sm-12  pt-4">
	<div class="row">
		<div class="col-xl-12 col-lg-12 col-md-12">
			<div class="dashboard_wrap">
				<div class="row">
					<div class="col-xl-12 col-lg-12 col-md-12 mb-4">
						<div class="row">
							<div class="col-md-12">
								<h6 class="m-0">Document List</h6>
								<div class="text-right">
									<a class="btn theme-bg text-white" href="<?= site_url('branch/document/add-files/'.encrypt($details->id)) ?>"><i class="fa-solid fa-plus"></i> Add</a>
								</div>
								<hr>
							</div>
						</div>
					</div>
				</div>
				<div class="row justify-content-center">
					<div class="col-md-12 col-lg-12 col-sm-12">
						<div class="card-body pl-3 pr-3 pt-0">
							<div class="table-responsive">
								<table class="table dash_list">
									<thead>
										<tr>
											<th scope="col" width="10%">#</th>
											<th scope="col">Description</th>
											<th scope="col">Added By</th>
											<th scope="col" width="18%" class="text-center">Action</th>
										</tr>
									</thead>
									<tbody>
										<?php if (!empty($details)): ?>
											<?php if (!empty($documents)): $i = 1;?>
												<?php foreach ($documents as $docs): 
													$desc = $docs->description;
													?>
													<tr>
														<td><?= $i++; ?></td>
														<td ><?= limitString($desc, 10); ?></td>
														<td>
															<?php if (strtolower($docs->added_by) == 'branch'): ?>
																<span class="trip gray"><?= $docs->added_by; ?></span>
															<?php else: ?>
																<span class="trip theme-cl theme-bg-light"><?= $docs->added_by; ?></span>
															<?php endif ?>
														</td>
														<td class="text-center">
															<div class="dropdown show">
																<a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
																	<i class="fas fa-ellipsis-h"></i>
																</a>
																<div class="drp-select dropdown-menu">
																	<?php if (strtolower($docs->added_by) == 'branch'): ?>
																		<a class="dropdown-item" href="<?= site_url('branch/document/view-study-material/'.encrypt($details->id).'/'.encrypt($docs->id)) ?>">View</a>
																		<a class="dropdown-item" href="<?= site_url('branch/document/edit-files/'.encrypt($details->id).'/'.encrypt($docs->id)) ?>" >Edit</a>
																		<a href="javascript:void(0)" class="dropdown-item deletedocsSection" data-file="<?= encrypt($docs->id).'||'.encrypt($details->course_id) ?>">Delete</a>
																	<?php else: ?>
																		<a class="dropdown-item" href="<?= site_url('branch/document/view-study-material/'.encrypt($details->id).'/'.encrypt($docs->id)) ?>">View</a>
																	<?php endif ?>
																</div>
															</div>
														</td>
													</tr>
												<?php endforeach ?>
											<?php endif ?>
										<?php endif ?>
										<?= csrf_field(); ?>
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