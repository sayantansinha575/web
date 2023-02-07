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
										<button type="button" class="btn btn-icon btn-danger mr-1" data-toggle="modal" data-target="#modal-university-general-info"><i class="ft-plus"></i></button>
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
									<table id="universityList" class="table table-white-space table-bordered table-striped row-grouping display no-wrap icheck table-middle dataTable no-footer">
										<thead>
											<tr>
												<th>#</th>
												<th>University Name</th>
												<th>Country</th>
												<th>State</th>
												<th>Address</th>
												<th>Intake</th>
												<th>Year of Establishment</th>
												<th class="text-center">Action</th>
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

<div class="modal fade text-left" id="modal-university-general-info" data-backdrop="false" tabindex="-1" role="dialog" aria-labelledby="university-general-info-label" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title" id="university-general-info-label"> Save University </h3>
			</div>
			<form action="<?= site_url('university/save-university') ?>" id="form-university-general-info">
				<div class="modal-body">
					<div class="row">
						<div class="col-md-6 com-sm-12">
							<div class="form-group floating-label-form-group">
								<label for="test-name" class="form-label">Univercity Name <span class="text-danger">*</span></label>
								<input type="text" class="form-control" id="university_name" name="university_name" placeholder="Enter Univercity Name...">
								<div class="error-feedback"></div>
							</div>
						</div>
							<div class="col-md-6 com-sm-12">
							<div class="form-group floating-label-form-group">
								<label for="test-name" class="form-label">Upload Logo <span class="text-danger">*</span></label>
								<input type="file" class="form-control" id="university_logo" name="university_logo">
								<div class="error-feedback"></div>
							</div>
						</div>
						<div class="col-md-6 col-sm-12">
							<div class="form-group floating-label-form-group">
								<label for="test-name" class="form-label">Country <span class="text-danger">*</span></label>
								<select name="country" id="country" class="form-control country-list">
									<option value=""></option>
								</select>
								<div class="error-feedback"></div>
							</div>
						</div>
						<div class="col-md-6 col-sm-12">
							<div class="form-group floating-label-form-group">
								<label for="test-name" class="form-label">State <span class="text-danger">*</span></label>
								<select name="state" id="state" class="form-control state-list">
									<option value=""></option>
								</select>
								<div class="error-feedback"></div>
							</div>
						</div>
						<div class="col-md-6 col-sm-12">
							<div class="form-group floating-label-form-group">
								<label for="test-name" class="form-label">City <span class="text-danger">*</span></label>
								<select name="city" id="city" class="form-control city-list">
									<option value=""></option>
								</select>
								<div class="error-feedback"></div>
							</div>
						</div>
						<div class="col-md-6 col-sm-12">
							<div class="form-group floating-label-form-group">
								<label for="test-name" class="form-label">Region<span class="text-danger"></span></label>
								<input type="text" class="form-control" id="region" name="region" placeholder="Enter Regioun...">
								<div class="error-feedback"></div>
							</div>
						</div>
						<div class="col-md-6 col-sm-12">
							<div class="form-group floating-label-form-group">
								<label for="test-name" class="form-label">Address <span class="text-danger">*</span></label>
								<textarea class="form-control" id="address" name="address" placeholder="Enter Address..."></textarea>
								<div class="error-feedback"></div>
							</div>
						</div>
					<div class="col-md-6 com-sm-12">
							<label for="test-name" class="form-label">Intake <span class="text-danger">*</span></label>
							<select class="form-control select-no-search" name="intake" id="intake">
								<option value="">Select Intake</option>
								<option value="Fall">Fall</option>
								<option value="Spring">Spring</option>
								<option value="Summer">Summer</option>
							</select>
							<div class="error-feedback"></div>
						</div>
						<div class="col-md-6 col-sm-12">
							<div class="form-group floating-label-form-group">
								<label for="test-name" class="form-label">Year of Establishment <span class="text-danger">*</span></label>
								<input type="date" class="form-control" id="date_of_establishment" name="date_of_establishment">
								<div class="error-feedback"></div>
							</div>
						</div>
						<div class="col-md-6 col-sm-12">
							<div class="form-group floating-label-form-group">
								<label for="test-name" class="form-label">Total Students (count)<span class="text-danger"></span></label>
								<input type="text" class="form-control" id="total_students" name="total_students" placeholder="Enter Total Students...">
								<div class="error-feedback"></div>
							</div>
						</div>
						<div class="col-md-6 col-sm-12">
							<div class="form-group floating-label-form-group">
								<label for="test-name" class="form-label">Under Graduate (count)<span class="text-danger"></span></label>
								<input type="text" class="form-control" id="under_graduate" name="under_graduate" placeholder="Enter Under Graduate...">
								<div class="error-feedback"></div>
							</div>
						</div>
						<div class="col-md-6 col-sm-12">
							<div class="form-group floating-label-form-group">
								<label for="test-name" class="form-label">Graduate (count) <span class="text-danger"></span></label>
								<input type="text" class="form-control" id="graduate" name="graduate" placeholder="Enter Graduate...">
								<div class="error-feedback"></div>
							</div>
						</div>
				</div>
				<div class="modal-footer">
					<?= csrf_field(); ?>
					<input type="hidden" name="id" readonly id="id">
					<button type="button" data-type="reset" class="btn btn-secondary">Close</button>
					<button type="submit" class="btn btn-primary" id="btn-university-general-info">Save</button>
				</div>
			</form>
		</div>
	</div>
</div>
<?= $this->section('css') ?>
<?= $this->endSection() ?>
<?= $this->section('js') ?>
<?= script_tag(ADMIN_ASSETS.'js/pages/university/university-list.init.js?v='.filemtime('assets/js/pages/university/university-list.init.js')) ?>
<?= $this->endSection() ?>
<?= $this->endSection() ?>