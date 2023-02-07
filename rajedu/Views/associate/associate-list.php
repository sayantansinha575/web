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
							<li class="breadcrumb-item"><a href="/">Dashboard</a>
							</li>
							<li class="breadcrumb-item"><a href="javascript:void(0)">Type of Associate</a>
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
								<h4 class="card-title">Custom styles
									<span>
										<button type="button" class="btn btn-icon btn-danger mr-1" data-toggle="modal" data-target="#modal-master-type-of-degree"><i class="ft-plus"></i></button>
									</span>
								</h4>
								
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
									<table id="dt-type-of-list" class="table table-white-space table-bordered table-striped row-grouping display no-wrap icheck table-middle dataTable no-footer">
										<thead>
											<tr>
												<th>#</th>
												<th>NAME</th>
												<th>EMAIL</th>
												<th>USER NAME</th>
												<th>STATUS</th>	
												<th class="text-center">ACTION</th>
											</tr>
										</thead>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>
	</div>
</div>

<div class="modal fade text-left" id="modal-master-type-of-degree" data-backdrop="false" tabindex="-1" role="dialog" aria-labelledby="master-type-of-degree-label" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title" id="master-type-of-degree-label"> Save Associate </h3>
			</div>
			<form action="<?= site_url('associate/save-associate') ?>" id="form-type-of-associate">
				<div class="modal-body">
					<div class="row">
						<div class="col-md-6 com-sm-12">
							<div class="form-group floating-label-form-group">
								<label for="test-name" class="form-label">Name <span class="text-danger">*</span></label>
								<input type="text" class="form-control" id="name" name="name" placeholder="Enter Name...">
								<div class="error-feedback"></div>
							</div>
						</div>
						<div class="col-md-6 com-sm-12">
							<div class="form-group floating-label-form-group">
								<label for="test-name" class="form-label">User Name <span class="text-danger">*</span></label>
								<input type="text" class="form-control" id="user_name" name="user_name" placeholder="Enter user name...">
								<div class="error-feedback"></div>
							</div>
						</div>
						<div class="col-md-6 col-sm-12">
							<div class="form-group floating-label-form-group">
								<label for="test-name" class="form-label">Email <span class="text-danger">*</span></label>
								<input type="email" class="form-control" id="email" name="email" placeholder="Enter Email...">
								<div class="error-feedback"></div>
							</div>
						</div>
						<div class="col-md-6 col-sm-12">
							<div class="form-group floating-label-form-group">
								<label for="test-name" class="form-label">Mobile <span class="text-danger">*</span></label>
								<input type="text" class="form-control" id="phone" name="phone" placeholder="Enter Mobile...">
								<div class="error-feedback"></div>
							</div>
						</div>

						<div class="col-md-6 col-sm-12">
							<div class="form-group floating-label-form-group">
								<label for="test-name" class="form-label">Alternative  Number<span class="text-danger"></span></label>
								<input type="text" class="form-control" id="number" name="number" placeholder="Enter number...">
								<div class="error-feedback"></div>
							</div>
						</div>
						<div class="col-md-6 col-sm-12">
							<div class="form-group floating-label-form-group">
								<label for="test-name" class="form-label">Date of Establishment <span class="text-danger"></span></label>
								<input type="date" class="form-control" id="date" name="date" placeholder="Enter date...">
								<div class="error-feedback"></div>
							</div>
						</div>

						<div class="col-md-6 col-sm-12">
							<div class="form-group floating-label-form-group">
								<label for="test-name" class="form-label">Password <span class="text-danger">*</span></label>
								<input type="password" class="form-control" id="password" name="password" placeholder="Enter Password...">
								<div class="error-feedback"></div>
							</div>
						</div>
						<div class="col-md-6 col-sm-12">
							<div class="form-group floating-label-form-group">
								<label for="test-name" class="form-label">Confirm Password <span class="text-danger">*</span></label>
								<input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm password...">
								<div class="error-feedback"></div>
							</div>
						</div>
						

						<div class="col-md-12">
							<div class="form-group floating-label-form-group">
								<label for="test-name" class="form-label">Address <span class="text-danger">*</span></label>
								<textarea   class="form-control" id="address" name="address" placeholder="Enter address..."></textarea>
								<div class="error-feedback"></div>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group floating-label-form-group">
								<label for="test-name" class="form-label">User Image <span class="text-danger"></span></label>
								<input type="file" class="form-control" id="file" name="file">
								<div class="error-feedback"></div>
							</div>
						</div>
					</div>

				<div class="modal-footer">
					<?= csrf_field(); ?>
					<input type="hidden" name="id" readonly id="id">
					<button type="button" data-type="reset" class="btn btn-secondary">Close</button>
					<button type="submit" class="btn btn-primary" id="btn-type-of-document">Save</button>
				</div>
			</form>
		</div>
	</div>
</div>
<?= $this->section('css') ?>
<?= $this->endSection() ?>
<?= $this->section('js') ?>
<?= script_tag(ADMIN_ASSETS.'js/pages/associate/associate-list.init.js?v='.filemtime('assets/js/pages/associate/associate-list.init.js')) ?>
<?= $this->endSection() ?>
<?= $this->endSection() ?>