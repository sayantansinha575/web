<?= $this->extend('branch/layOut'); ?>
<?= $this->section('body') ?>
<?php $details = ''; ?>
<div class="col-lg-9 col-md-9 col-sm-12  pt-4">
	<div class="row">
		<div class="col-xl-12 col-lg-12 col-md-12">
			<div class="dashboard_wrap">
				<div class="row align-items-end">
					<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
						<div class="form-group">
							<label>Keyword</label>
							<div class="smalls">
								<input type="text" class="form-control" id="keywordAdmission" name="keyword" placeholder="Enter keyword to search">
							</div>
						</div>
					</div>
					<div class="col-xl-2 col-lg-2 col-md-2 col-sm-12">
						<div class="form-group">
							<label>From Date</label>
							<div class="smalls">
								<input type="text" class="form-control" id="fromDate" name="keyword" placeholder="Select Date" readonly>
							</div>
						</div>
					</div>
					<div class="col-xl-2 col-lg-2 col-md-2 col-sm-12">
						<div class="form-group">
							<label>To Date</label>
							<div class="smalls">
								<input type="text" class="form-control" id="toDate" placeholder="Select Date" readonly>
							</div>
						</div>
					</div>
					<div class="col-xl-2 col-lg-2 col-md-2 col-sm-12">
						<div class="btn-group" role="group" aria-label="Basic mixed styles example">
							<button type="button" class="btn btn-success filterAdmission">Search</button>
							<button class="btn theme-bg text-white resetAdmission" type="button">Reset</button>
						</div>
						<!-- <div class="form-group smalls">
							<button class="btn theme-bg text-white filterAdmission" type="button">Search</button>								
						</div> -->
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-xl-12 col-lg-12 col-md-12">
			<div class="dashboard_wrap">
				<div class="table-responsive">
					<table id="dtAdmissionList" class="table dash_list shadow-lg">
						<thead>
							<tr>
								<th scope="col" width="1%">#</th>
                                <th scope="col">Student</th>
                                <th scope="col">Course</th>
                                <th scope="col">Type</th>
                                <th scope="col">Duration</th>
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