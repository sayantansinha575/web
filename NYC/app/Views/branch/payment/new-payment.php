<?= $this->extend('branch/layOut'); ?>
<?= $this->section('body') ?>
<div class="col-lg-9 col-md-9 col-sm-12 newPaymentContainer  pt-4">

	<div class="row justify-content-between">
		<div class="col-lg-12 col-md-12 col-sm-12">
			<div class="dashboard_wrap d-flex align-items-center justify-content-between">
				<div class="arion">
					<nav class="transparent">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="<?= site_url('branch/payment'); ?>">Payments</a></li>
							<li class="breadcrumb-item active" aria-current="page">New Payment</li>
						</ol>
					</nav>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-xl-12 col-lg-12 col-md-12">
			<div class="dashboard_wrap">
				<div class="row">
					<div class="col-xl-12 col-lg-12 col-md-12">
						<h6 class="m-0">Payment details</h6><hr>
					</div>
				</div>
				<div class="row">
					<div class="col-xl-6 col-lg-6 col-md-6">
						<form action="<?= site_url('branch/payment/new-payment') ?>" method="get">
						<div class="form-group smalls">
							<label for="">Enrollment No. <span class="text-danger">*</span></label>
							<div class="input-group">
								<input type="text" class="form-control" placeholder="Enter enrollment no......" name="enrollNo" id="enrollment_number" value="<?= (!empty($_GET['enrollNo']))?$_GET['enrollNo']:'' ?>">
								<div class="input-group-append">
									<button class="btn btn-dark" type="submit">Serach</button>
								</div>
							</div>
						</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="row paymentHistoryContainer" style="display: <?= (!empty($details['tblData']))?'block':'none'; ?>;">
		<div class="col-xl-12 col-lg-12 col-md-12">
			<div class="dashboard_wrap">
				<div class="row">
					<div class="col-xl-12 col-lg-12 col-md-12 mb-2">
						<h6 class="m-0">Payment History</h6><hr>
					</div>
				</div>
				<div class="row">
					<div class="col-xl-12 col-lg-12 col-md-12">
						<div class="dashboard_wrap">
							<div class="table-responsive">
								<table  class="table dash_list">
									<thead>
										<tr>
											<th scope="col" width="1%">#</th>
											<th scope="col">Invoice. No.</th>
											<th scope="col">Course Fees</th>
											<th scope="col">Discount</th>
											<th scope="col">Amount Paid</th>
											<th scope="col">Date</th>
										</tr>
									</thead>
									<tbody>
										<?php if (!empty($details['tblData'])): ?>
											<?= $details['tblData']; ?>
										<?php else: ?>
											<tr>
												<td colspan="6" class="text-center text-muted">No Payments History Found</td>
											</tr>
										<?php endif ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>


	<?php if (!empty($details) && $details['pendingAmount'] > 0): ?>					
	<div class="row">
		<div class="col-xl-12 col-lg-12 col-md-12">
			<div class="dashboard_wrap">
				<div class="row">
					<div class="col-xl-12 col-lg-12 col-md-12 mb-2">
						<h6 class="m-0">Payment Details</h6><hr>
					</div>
				</div>
				<div class="row justify-content-center">
					<div class="col-xl-12 col-lg-12 col-md-12">
						<form action="<?= site_url('branch/payment/proceed-payment') ?>" id="formNewPayment" accept-charset="UTF-8" autocomplete="off">
							<div class="row">
								<div class="col-md-6 mb-3">
									<div class="form-group smalls">
										<label for="">Course Fees</label>
										<input type="text" class="form-control" id="totalCourseFees" readonly value="<?= empty($details)?'':$details['totalCourseFees'] ?>">
									</div>
								</div>

								<div class="col-md-6 mb-3">
									<div class="form-group smalls">
										<label for="">Total Amount Paid</label>
										<input type="text" class="form-control" id="totsAmountPaid" readonly value="<?= empty($details)?'':$details['totalAmountPaid'] ?>">
									</div>
								</div>
								<div class="col-md-4 mb-3">
									<div class="form-group smalls">
										<label for="">Total Discount Provided</label>
										<input type="text" class="form-control" id="totsDiscount" readonly value="<?= empty($details)?'':$details['totalDiscount'] ?>">
									</div>
								</div>
								<div class="col-md-4 mb-3">
									<div class="form-group smalls">
										<label for="">Pending Amount</label>
										<input type="text" class="form-control" name="pending_amount" id="pendingAmount" readonly value="<?= empty($details)?'':$details['pendingAmount'] ?>">
									</div>
								</div>
								<div class="col-md-4 mb-3">
									<div class="form-group smalls">
										<label for="">Amount To Be Paid <span class="text-danger">*</span></label>
										<input type="text" class="form-control decimal" name="amount" id="amountToBePaid" <?= empty($details)?'disabled':'' ?>>
									</div>
								</div>
								
							</div>
							<?= csrf_field(); ?>
							<div class="form-group smalls">
								<input type="hidden" readonly name="admission_id" id="admissionId" value="<?= empty($details)?'':$details['admission_id'] ?>">
								<button class="btn theme-bg text-white btnProceedPayment" type="submit" disabled>Save</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php endif ?>

</div>
<?= $this->endSection(); ?>
