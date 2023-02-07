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
							<li class="breadcrumb-item"><a href="javascript:void(0)">University Programs</a>
							<li>
						</ol>
					</div>
				</div>
			</div>
		</div>
		<div class="content-body">
			<section id="search-website" class="card overflow-hidden">
    <div class="card-header">
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
                    <a data-action="reload">
                        <i class="ft-rotate-cw"></i>
                    </a>
                </li>
                <li>
                    <a data-action="expand">
                        <i class="ft-maximize"></i>
                    </a>
                </li>
                <li>
                    <a data-action="close">
                        <i class="ft-x"></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="card-content collapse show">
        <div class="card-body pb-0">
            <div class="row">
            <div class="col-md-8">
                <fieldset class="form-group position-relative mb-0">
                <input type="text" class="form-control form-control-xl input-xl" id="iconLeft1" placeholder="Search Here ...">
                <div class="form-control-position">
                    <i class="ft-search font-medium-4"></i>
                </div>
            </fieldset>
            </div>
            <div class="col-md-4">
                <button type="button" data-toggle="modal" data-target="#registration" class="new-registration btn btn-info btn-min-width  mr-1 pb-1 pt-1"><i class="ft-plus"></i> New Registration</button>
            </div>
            </div>

        </div>
        <div id="search-results" class="card-body">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-8">
                    <ul class="media-list p-0">
                        <li class="media">
                            <div class="media-body">
                                <p>
                                    <span class="text-muted skin-square"><input type="radio" name="input-radio-2" id="input-radio-5"></span>
                                    <span class="text-muted">Arunangshu Pradhan</span>
                                    <span class="text-muted">STU10004 </span>
                                    <span class="text-muted">arun@gmail.com</span>
                                 </p>
                            </div>
                        </li>
                    </ul>
                  <a href="new-application"><button type="button" class="btn btn-info btn-min-width  mr-1 pb-1 pt-1"> Select Existing Student </button></a>
                </div>
            </div>
        </div>
    </div>
</section>
		</div>
	</div>
</div>
<div class="modal fade text-left" id="registration" tabindex="-1" role="dialog" aria-labelledby="myModalLabel9" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header btn-info white">
                <h4 class="modal-title white" id="myModalLabel9"><i class="la la-tree"></i> New Student</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= site_url('student/save-info') ?>" id="form-application-student-info">
                <div class="form-body ml-1 mt-1 mr-1">
                    <div class="form-group">
                        <label for="complaintinput3">Student Name</label>
                        <input name="name" placeholder="Enter student Name" class="form-control  border-radious-10" id="name" type="text">
                        <div class="error-feedback"></div>
                    </div>
                    <div class="form-group">
                        <label for="complaintinput3">Student Email</label>
                        <input type="text" id="email" class="form-control  border-radious-10" placeholder="Entr student Email" name="email">
                        <div class="error-feedback"></div>
                    </div>
                    <div class="form-group">
                        <label for="complaintinput3">Student Phone</label>
                        <input type="text" id="phone" class="form-control  border-radious-10" placeholder="Enter student Phone" name="phone">
                        <div class="error-feedback"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <?= csrf_field(); ?>
                    <input type="hidden" name="id" readonly id="id">
                    <button type="button" class="btn grey btn-danger" data-type="reset" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="btn-form-application-student-info">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->section('css') ?>
<?= $this->endSection() ?>
<?= $this->section('js') ?>
<?= script_tag(ADMIN_ASSETS.'js/pages/student/student.init.js?v='.filemtime('assets/js/pages/student/student.init.js')) ?>
<?= $this->endSection() ?>
<?= $this->endSection() ?>