<?= $this->extend('branch/layOut'); ?>
<?= $this->section('body') ?>
<div class="col-lg-9 col-md-9 col-sm-12  pt-4">
	<div class="row">
		<div class="col-xl-12 col-lg-12 col-md-12">
			<div class="dashboard_wrap">
				<div class="row align-items-end">
					<div class="col-xl-6 col-lg-4 col-md-6 col-sm-6">
						<div class="form-group">
							<label>Keyword</label>
							<div class="smalls">
								<input type="text" class="form-control" id="admitKeyword" name="keyword" placeholder="Enter keyword to search">
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
					<table id="dtAdmitList" class="table dash_list shadow-lg">
						<thead>
							<tr>
								<th scope="col" width="1%">#</th>
                                <th scope="col">Student</th>
                                <th scope="col">Exam Name</th>
                                <th scope="col">Date</th>
                                <th scope="col">Time</th>
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