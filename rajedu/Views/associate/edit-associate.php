<?= $this->extend($config->viewLayout) ?>
<?= $this->section('content') ?>
<div class="app-content content">
	<div class="content-wrapper">
		<div class="content-wrapper-before"></div>
		<div class="content-header row">
			<div class="content-header-left col-md-4 col-12 mb-2">
				<h3 class="content-header-title"><?= $title; ?></h3>
			</div>
			<div class="content-header-right col-md-8 col-12">
				<div class="breadcrumbs-top float-md-right">
					<div class="breadcrumb-wrapper mr-1">
						<ol class="breadcrumb">
							<li class="breadcrumb-item">
								<a href="/">Dashboard</a>
							</li>
							<li class="breadcrumb-item">
								<a href="javascript:void(0)">Type of Associate</a>
							<li>
						</ol>
					</div>
				</div>
			</div>
		</div>
		<div class="content-body">
			<section class="input-validation">
				<div class="row">
					<div class="col-md-12">
						<div class="card">
							<div class="card-header">
								<h4 class="card-title">Custom styles</h4>
								<a class="heading-elements-toggle">
									<i class="la la-ellipsis-v font-medium-3"></i>
								</a>
								<div class="heading-elements">
									<ul class="list-inline mb-0">
										<li>
											<a data-action="collapse">
												<i class="ft-minus"></i>
											</a>
										</li>
										<li>
											<a data-action="expand">
												<i class="ft-maximize"></i>
											</a>
										</li>
									</ul>
								</div>
							</div>
							<div class="card-content collapse show">
								<div class="card-body">
									<ul class="nav nav-tabs">
										<li class="nav-item">
											<a class="nav-link active" id="personal-info-tab" data-toggle="tab" aria-controls="personalInfo" href="#personalInfo" aria-expanded="true"><i class="ft-aperture"></i> Personal Info</a>
										</li>
										<li class="nav-item">
											<a class="nav-link" id="change-password-tab" data-toggle="tab" aria-controls="changePassword" href="#changePassword" aria-expanded="false"><i class="ft-bell"></i> Change Password</a>
										</li>
										<li class="nav-item">
											<a class="nav-link" id="bank-details-tab" data-toggle="tab" aria-controls="bankDetails" href="#bankDetails" aria-expanded="false"><i class="ft-compass"></i> Bank Details</a>
										</li>
									</ul>
									<div class="tab-content px-1 pt-1">
										<div role="tabpanel" class="tab-pane active" id="personalInfo" aria-expanded="true" aria-labelledby="personal-info-tab">
											<form action="<?= site_url('associate/save-associate') ?>" id="form-type-of-associate">
												<div class="modal-body">
													<div class="row">
														<div class="col-md-6 com-sm-12">
															<div class="form-group floating-label-form-group">
																<label for="test-name" class="form-label">Name <span class="text-danger">*</span></label>
																<input type="text" class="form-control" id="name" name="name" placeholder="Enter Name..." value="<?= $result['name']; ?>">
																<div class="error-feedback"></div>
															</div>
														</div>
														<div class="col-md-6 com-sm-12">
															<div class="form-group floating-label-form-group">
																<label for="test-name" class="form-label">User Name <span class="text-danger">*</span></label>
																<input type="text" class="form-control" id="user_name" name="user_name" placeholder="Enter user name..." value="<?= $result['user_name']; ?>">
																<div class="error-feedback"></div>
															</div>
														</div>
														<div class="col-md-6 col-sm-12">
															<div class="form-group floating-label-form-group">
																<label for="test-name" class="form-label">Email <span class="text-danger">*</span></label>
																<input type="email" class="form-control" id="email" name="email" placeholder="Enter Email..." value="<?= $result['email']; ?>">
																<div class="error-feedback"></div>
															</div>
														</div>
														<div class="col-md-6 col-sm-12">
															<div class="form-group floating-label-form-group">
																<label for="test-name" class="form-label">Mobile <span class="text-danger">*</span></label>
																<input type="text" class="form-control" id="phone" name="phone" placeholder="Enter Mobile..." value="<?= $result['phone']; ?>">
																<div class="error-feedback"></div>
															</div>
														</div>

														<div class="col-md-6 col-sm-12">
															<div class="form-group floating-label-form-group">
																<label for="test-name" class="form-label">Alternative Number<span class="text-danger"></span></label>
																<input type="text" class="form-control" id="number" name="number" placeholder="Enter number..." value="<?= $result['alternative_phone'] ?>">
																<div class="error-feedback"></div>
															</div>
														</div>
														<div class="col-md-6 col-sm-12">
															<div class="form-group floating-label-form-group">
																<label for="test-name" class="form-label">Date of Establishment <span class="text-danger"></span></label>
																<input type="date" class="form-control" id="date" name="date" placeholder="Enter date..." value="<?= date('y-m-d', $result['establishment_date']); ?>">
																<div class="error-feedback"></div>
															</div>
														</div>

														<div class="col-md-12">
															<div class="form-group floating-label-form-group">
																<label for="test-name" class="form-label">Address <span class="text-danger">*</span></label>
																<textarea class="form-control" id="address" name="address" placeholder="Enter address..."><?= $result['address']; ?></textarea>
																<div class="error-feedback"></div>
															</div>
														</div>
															<div class="col-md-12">
													<img src="<?= ADMIN_ASSETS . 'uploads/dp/'.$result['display_picture'];?>" class="rounded-circle img-border height-100" id="user_img" alt="Card image">
													<div class="form-group floating-label-form-group">
														<label for="test-name" class="form-label">User Image <span class="text-danger"></span></label>
														<input type="file" class="form-control" id="file" name="file">
														<div class="error-feedback"></div>
													</div>
												</div>
													</div>

													<div class="modal-footer">
														<?= csrf_field(); ?>
														<input type="hidden" name="id" readonly value="<?= $result['id']; ?>">
														<button type="submit" class="btn btn-primary" id="btn-type-of-document">Save</button>
													</div>
												</div>
											</form>
										</div>
										<div class="tab-pane" id="changePassword" aria-labelledby="change-password-tab">
											<form action="<?= site_url('associate/update-password'); ?>" id="form-changePassword" >
												<div class="row">
													<div class="col-md-6 col-sm-12">
														<div class="form-group floating-label-form-group">
															<label for="test-name" class="form-label">Password <span class="text-danger">*</span></label>
															<input type="password" class="form-control" id="password" name="update_password" placeholder="Enter Password...">
															<div class="error-feedback"></div>
														</div>
													</div>
													<div class="col-md-6 col-sm-12">
														<div class="form-group floating-label-form-group">
															<label for="test-name" class="form-label">Confirm Password <span class="text-danger">*</span></label>
															<input type="update_password" class="form-control" id="confirm_password" name="update_confirm_password" placeholder="Confirm password...">
															<div class="error-feedback"></div>
														</div>
													</div>
												</div>
												<div class="col-md-6 col-sm-12">
													<div class="form-group floating-label-form-group">
														<input type="hidden" name="id" readonly value="<?= $result['id']; ?>">
														<div class="error-feedback"></div>
													</div>
												</div>

												<div class="modal-footer">
													<?= csrf_field(); ?>
													<button type="submit" class="btn btn-primary" id="btn-changePassword">Save</button>
												</div>
											</form>
										</div>
										<div class="tab-pane" id="bankDetails" aria-labelledby="bank-details-tab">
											<div class="timeline">
												<h4>Bank Details</h4>
												<hr>
												<div class="col-md-12 text-center">
													<button type="button" class="mr-1 mb-1 btn btn-outline-info btn-min-width"  data-toggle="modal" data-backdrop="false" data-target="#modal-bank-details"><i class="la la-plus-circle"></i> Add New Bank Details</button>
												</div>
												<table id="dt-type-of-list" class="table table-white-space table-bordered table-striped row-grouping display no-wrap icheck table-middle dataTable no-footer">
													<thead>
														<tr>
															<th>A/C No</th>
															<th>Account Name</th>
															<th>IFSC Code</th>
															<th>PAN Card</th>
															<th>Used as Primary</th>	
															<th class="text-center">ACTION</th>
														</tr>
													</thead>
													<tbody>
														<?php if (! empty($bankAccounts)): ?>
															<?php foreach ($bankAccounts as $ac): ?>
																<tr>
																	<td><?= $ac['account_no']; ?> </td>
																	<td><?= $ac['account_name']; ?></td>
																	<td><?= $ac['ifsc_code']; ?></td>
																	<td><?= $ac['pan_no']; ?></td>
																	<td><?= $ac['is_primary']; ?></td>
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
			</section>
		</div>
	</div>
</div>

<div class="modal fade text-left" id="modal-bank-details" data-backdrop="false" tabindex="-1" role="dialog" aria-labelledby="modal-bank-details-label" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title" id="modal-bank-details-label"> Save Bank Details </h3>
			</div>
			<form action="<?= site_url('associate/save-bank-details') ?>" id="form-bank-details">
				<div class="modal-body">
					<div class="row">
						<div class="col-md-6 com-sm-12">
							<div class="form-group floating-label-form-group">
								<label for="test-name" class="form-label">A/C No <span class="text-danger">*</span></label>
								<input type="text" class="form-control" id="account_no" name="account_no" placeholder="Enter A/C No...">
								<div class="error-feedback"></div>
							</div>
						</div>
						<div class="col-md-6 com-sm-12">
							<div class="form-group floating-label-form-group">
								<label for="test-name" class="form-label">Account Name <span class="text-danger">*</span></label>
								<input type="text" class="form-control" id="account_name" name="account_name" placeholder="Enter Account Name...">
								<div class="error-feedback"></div>
							</div>
						</div>
						<div class="col-md-6 com-sm-12">
							<div class="form-group floating-label-form-group">
								<label for="test-name" class="form-label">IFSC Code <span class="text-danger">*</span></label>
								<input type="text" class="form-control" id="ifsc_code" name="ifsc_code" placeholder="Enter IFSC Code...">
								<div class="error-feedback"></div>
							</div>
						</div>
						<div class="col-md-6 com-sm-12">
							<div class="form-group floating-label-form-group">
								<label for="test-name" class="form-label">PAN Card No <span class="text-danger">*</span></label>
								<input type="text" class="form-control" id="pan_card" name="pan_card" placeholder="Enter PAN  Card No...">
								<div class="error-feedback"></div>
							</div>
						</div>
						<div class="col-md-6 com-sm-12">
							<div class="form-group floating-label-form-group">
								<label for="test-name" class="form-label">Upload PAN Card <span class="text-danger"></span></label>
								<input type="file" class="form-control" id="pan_card_file" name="pan_card_file">
								<div class="error-feedback"></div>
							</div>
						</div>
						<div class="col-md-6 com-sm-12">
							<label for="test-name" class="form-label">Used as Primary <span class="text-danger"></span></label>
							<select class="form-control" name="is_primary" id="is_primary">
								<option value="">Select Primary</option>
								<option value="Yes">YES</option>
								<option value="No">NO</option> 
							</select>
							<div class="error-feedback"></div>
						</div>
					</div>

				<div class="modal-footer">
					<?= csrf_field(); ?>
					<input type="hidden" name="id" readonly value="<?= $result['id'] ?>">
					<button type="button" data-type="reset" class="btn btn-secondary">Close</button>
					<button type="submit" class="btn btn-primary" id="btn-t-bank-details">Save</button>
				</div>
			</form>
		</div>
	</div>
</div>

<?= $this->section('css') ?>
<?= $this->endSection() ?>
<?= $this->section('js') ?>
<?= script_tag(ADMIN_ASSETS . 'js/pages/associate/edit-associate.init.js?v=' . filemtime('assets/js/pages/associate/edit-associate.init.js')) ?>
<?= $this->endSection() ?>
<?= $this->endSection() ?>