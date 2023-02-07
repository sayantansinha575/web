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
					<div class="col-md-3">
						<div class="card">
							<div class="card-header pb-0">
								<div class="card-title-wrap bar-primary">
									<div class="card-title">Personal Information</div>
									<hr>
								</div>
							</div>
							<div class="card-content">
								<div class="card-body p-0 pt-0 pb-1">
									<ul class="list-unstyled base-timeline activity-timeline" style="margin-left: 24px;">
										<li>
											<div class="timeline-icon bg-primary">
												<i class="ft-monitor font-medium-1"></i>
											</div>
											<div class="base-timeline-info">
												<a href="<?= site_url('university/edit-university-info/'.encrypt($result['id'])); ?>" class="text-primary line-height-2">University Info</a>
											</div>
										</li>
										<li>
											<div class="timeline-icon bg-info">
												<i class="ft-feather font-medium-1"></i>
											</div>
											<div class="base-timeline-info">
												<a href="<?= site_url('university/edit-university-general-info/'.encrypt($result['id'])); ?>" class="text-info  line-height-2">General Info</a>
											</div>
										</li>
										<li>
											<div class="timeline-icon bg-info">
												<i class="ft-feather font-medium-1"></i>
											</div>
											<div class="base-timeline-info">
												<a href="<?= site_url('university/edit-university-contact-info/'.encrypt($result['id'])); ?>" class="text-info  line-height-2">Contact Info</a>
											</div>
										</li>
										<li>
											<div class="timeline-icon bg-info">
												<i class="ft-feather font-medium-1"></i>
											</div>
											<div class="base-timeline-info">
												<a href="<?= site_url('university/edit-university-academic-program-info/'.encrypt($result['id'])); ?>" class="text-info  line-height-2">Academic Program Info</a>
											</div>
										</li>
										<li>
											<div class="timeline-icon bg-info">
												<i class="ft-feather font-medium-1"></i>
											</div>
											<div class="base-timeline-info">
												<a href="<?= site_url('university/edit-university-minimum-required-score/'.encrypt($result['id'])); ?>" class="text-info line-height-2">Minimum Required Score</a>
											</div>
										</li>
										<li>
											<div class="timeline-icon bg-info">
												<i class="ft-feather font-medium-1"></i>
											</div>
											<div class="base-timeline-info">
												<a href="<?= site_url('university/edit-university-admission-info/'.encrypt($result['id'])); ?>" class="text-info  line-height-2">University Admission Info</a>
											</div>
										</li>
										<li>
											<div class="timeline-icon bg-info">
												<i class="ft-feather font-medium-1"></i>
											</div>
											<div class="base-timeline-info">
												<a href="<?= site_url('university/edit-university-deadline/'.encrypt($result['id'])); ?>" class="text-info   line-height-2">Dates Deadline</a>
											</div>
										</li>
										<li>
											<div class="timeline-icon bg-info">
												<i class="ft-feather font-medium-1"></i>
											</div>
											<div class="base-timeline-info">
												<a href="<?= site_url('university/edit-university-application-info/'.encrypt($result['id'])); ?>" class="text-info   line-height-2">Application Info</a>
											</div>
										</li>
										<li>
											<div class="timeline-icon bg-info">
												<i class="ft-feather font-medium-1"></i>
											</div>
											<div class="base-timeline-info">
												<a href="<?= site_url('university/edit-university-documents-check-list/'.encrypt($result['id'])); ?>" class="text-info   line-height-2">Documents Check List</a>
											</div>
										</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-9">
						<div class="card">
							<div class="card-header">
								<h4 class="card-title"><?=$title;?></h4>
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
									<?= $content; ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>
	</div>
</div>

<?= $this->section('css') ?>
<?= $this->endSection() ?>
<?= $this->section('js') ?>
<?= script_tag(ADMIN_ASSETS . 'js/pages/university/edit-university.init.js?v=' . filemtime('assets/js/pages/university/edit-university.init.js')) ?>
<?= $this->endSection() ?>
<?= $this->endSection() ?>