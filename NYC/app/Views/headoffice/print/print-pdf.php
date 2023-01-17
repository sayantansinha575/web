<?= $this->extend('headoffice/layOut'); ?>
<?= $this->section('body') ?>


<div class="container-fluid">

	<!-- start page title -->
	<div class="row">
		<div class="col-12">
			<div class="page-title-box">
				<div class="page-title-right">
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="/head-office/dashboard">Dashboard</a></li>
						<li class="breadcrumb-item active">Print Pdf</li>
					</ol>
				</div>
				<h4 class="page-title"><?= $title; ?></h4>
			</div>
		</div>
	</div>     
	<!-- end page title --> 
	<form action="<?= site_url('head-office/print/generate'); ?>" id="defaultForm">
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-body">
						<h4 class="header-title">Print Preference</h4><hr>
						<br>
						<div class="row row-cols-lg-auto g-3 align-items-center">
							<div class="col-12">
								<label class="form-label">Marksheet : </label>
							</div>
							<div class="col-12">
								<input type="checkbox" id="msheetSwitch" name="msheetSwitch" data-switch="success" <?= ($marksheetsCount == 0)?'disabled':''; ?> value="1">
								<label for="msheetSwitch" data-on-label="Yes" data-off-label="No"></label>
							</div>
							<div class="col-12">
								<label class="form-label">Certificate : </label>
							</div>
							<div class="col-12">
								<input type="checkbox" id="certSwitch" name="certSwitch" data-switch="success" <?= ($certificatesCount == 0)?'disabled':''; ?> value="1">
								<label for="certSwitch" data-on-label="Yes" data-off-label="No"></label>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="row" id="mainHolder" style="display: none;">
			<div class="col-12">
				<div class="card">
					<div class="card-body _mainHolder">
					</div>
					<div class="card-footer">
						<div class="row">
							<div class="col-md-12 text-end">
								<?= csrf_field(); ?>
								<input type="submit" class="btn btn-dark defaultBtn" value="Generate">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>

	<div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-7">
                           <h4 class="header-title">Combined PDF List</h4>
                        </div>
                        <div class="col-md-5 text-end">
                            <div class="input-group mb-3 bind-datatable">
                                <span class="input-group-text">Keyword</span>
                                <input type="text" class="form-control" id="comKeyword" name="keyword" placeholder="Enter keyword to search">
                          </div>
                        </div>
                    </div>
                   
                    <br>
                    <table id="dtCombinedPdfList" class="table table-centered table-striped dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th width="1%">#</th>
                                <th>Enroll. No. #1</th>
                                <th>Enroll. No. #2</th>
                                <th width="25%">Created At</th>
                                <th width="1%" class="text-center">Action</th>
                            </tr>
                        </thead>
                    </table>

                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>
</div>
<script>
	msheetHtml = "<?= $marksheets ?>";
	certHtml = "<?= $certificates ?>";
</script>


<script src="<?= '/public/headoffice/js/pages/print-pdf.js?v='.filemtime($_SERVER['DOCUMENT_ROOT'].'/public/headoffice/js/pages/print-pdf.js') ?>"></script>
<script src="<?= site_url('public/headoffice/js/ajax-datatable.js?v=').filemtime($_SERVER['DOCUMENT_ROOT'].'/public/headoffice/js/ajax-datatable.js') ?>"></script>

<?= $this->endSection(); ?>