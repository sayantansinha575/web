<?= $this->extend('branch/layOut'); ?>
<?= $this->section('body') ?>
<?php $details = ''; ?>
<div class="col-lg-9 col-md-9 col-sm-12  pt-4">


	<div class="row">
		<div class="col-xl-12 col-lg-12 col-md-12">
			<div class="dashboard_wrap">
				<div class="row align-items-end">
					<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
						<div class="form-group">
							<label>Keyword</label>
							<div class="smalls">
								<div class="input-group">
									<input type="text" class="form-control" id="keywordPayment" name="keyword" placeholder="Enter keyword to auto search">
									
								</div>


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
					<table id="dtPaymentList" class="table dash_list shadow-lg">
						<thead>
							<tr>
								<th scope="col" width="1%">#</th>
                                <th scope="col">Student</th>
                                <th scope="col">Invoice</th>
                                <th scope="col">Course Fees</th>
                                <th scope="col">Amount Paid</th>
                                <th scope="col">Pending Amt.</th>
                                <th scope="col">Date</th>
                                <th scope="col">Action</th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<script src="<?= site_url('public/branch/js/page/ajax-datatable.js') ?>"></script>
<?= $this->endSection(); ?>
