<?= $this->extend('branch/layOut'); ?>
<?= $this->section('body') ?>
<?php $details = ''; ?>
<div class="col-lg-9 col-md-9 col-sm-12 pt-4">


<div class="dashboard_wrap">
	<div class="row">
		
					<div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
						<div class="form-group">
							<label>Keyword</label>
							<div class="smalls">
								<input type="text" class="form-control" id="keywordStud" name="keyword" placeholder="Enter keyword to search">
							</div>
						</div>
					</div>
					<div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
						<div class="form-group">
							<label>Status</label>
							<div class="smalls">
								<select name="status" class="form-control" id="statusTypeStud">
                                    <option value="0">All</option>
                                    <option value="1">Active</option>
                                    <option value="2">Inactive</option>
                                </select>
							</div>
						</div>
					</div>
					<div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
						<div class="form-group">
							<label>Gender</label>
							<div class="smalls">
								<select name="gender" class="form-control" id="genderStud">
									<option value="0">All</option>
									<option value="Male">Male</option>
									<option value="Female">Female</option>
									<option value="Transgender">Transgender</option>
								</select>
							</div>
						</div>
					</div>
				
		
	</div>
</div>
	<div class="row">
		<div class="col-xl-12 col-lg-12 col-md-12">
			<div class="dashboard_wrap">
				<div class="table-responsive">
					<table id="dtStudentList" class="table dash_list shadow-lg">
						<thead>
							<tr>
								<th scope="col" width="1%">#</th>
                                <th scope="col">Student</th>
                                <th scope="col">Gender</th>
                                <th scope="col">Mobile</th>
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
