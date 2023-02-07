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
							<li class="breadcrumb-item"><a href="javascript:void(0)">Type of Exam</a>
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
									<table id="dt-type-of-test" class="table table-white-space table-bordered table-striped row-grouping display no-wrap icheck table-middle dataTable no-footer">
										<thead>
											<tr>
												<th width="7%">ID</th>
												<th width="71%">TEST TYPE</th>
												<th width="15%">STATUS</th>
												<th width="7%" class="text-center">ACTION</th>
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
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title" id="master-type-of-degree-label"> Save Test Type</h3>
			</div>
			<form action="<?= site_url('master/save-test-type') ?>" id="form-type-of-test">
				<div class="modal-body">
					<div class="form-group floating-label-form-group">
						<label for="test-name" class="form-label">Test Type <span class="text-danger">*</span></label>
						<input type="text" class="form-control" id="test-type" name="test-type" placeholder="Enter test type...">
						<div class="error-feedback"></div>
					</div>
					<div class="form-group floating-label-form-group">
						<label for="title" class="form-label">Status <span class="text-danger">*</span></label>
						<select class="form-control" name="status" id="status">
							<option value="">Select Status</option>
							<option value="Active">Active</option>
							<option value="Inactive">Inactive</option>
						</select>
						<div class="error-feedback"></div>
					</div>
					<div class="form-group">
						<div id="form-feedback" class="error-feedback"></div>
					</div>
				</div>
				<div class="modal-footer">
					<?= csrf_field(); ?>
					<input type="hidden" name="id" readonly id="id">
					<button type="button" data-type="reset" class="btn btn-secondary">Close</button>
					<button type="submit" class="btn btn-primary" id="btn-type-of-test">Save</button>
				</div>
			</form>
		</div>
	</div>
</div>
<?= $this->section('css') ?>
<?= $this->endSection() ?>
<?= $this->section('js') ?>
<?= script_tag(ADMIN_ASSETS.'js/pages/master/test-type.init.js?v='.filemtime('assets/js/pages/master/test-type.init.js')) ?>
<?= $this->endSection() ?>
<?= $this->endSection() ?>