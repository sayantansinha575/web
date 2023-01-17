<?= $this->extend('branch/layOut'); ?>
<?= $this->section('body') ?>
<div class="col-lg-9 col-md-9 col-sm-12  pt-4">


	<div class="row">
		<div class="col-xl-12 col-lg-12 col-md-12">
			<div class="dashboard_wrap">
				<div class="row align-items-end">
					<div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
						<div class="form-group">
							<label>Keyword</label>
							<div class="smalls">
								<input type="text" class="form-control" id="keywordMarksheet" name="keyword" placeholder="Enter keyword to search">
							</div>
						</div>
					</div>
					<div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
						<div class="form-group">
							<label>Status</label>
							<div class="smalls">
								<select name="status" class="form-control" id="marksheetStatus">
									<option value="">All</option>
									<option value="1">Processing</option>
									<option value="4">Published</option>
									<option value="3">Rejected</option>
								</select>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-xl-12 col-lg-12 col-md-12">
			<div class="dashboard_wrap">
				<div class="table-responsive">
					<table id="dtMarksheetList" class="table dash_list shadow-lg">
						<thead>
							<tr>
								<th scope="col" width="1%">#</th>
                                <th scope="col">Student</th>
                                <th scope="col">Marksheet</th>
                                <th scope="col">Course</th>
                                <th scope="col">Session</th>
                                <th scope="col">Status</th>
                                <th scope="col" width="1%" class="text-center">Action</th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<?= $this->endSection(); ?>