<?= $this->extend('headoffice/layOut'); ?>
<?= $this->section('body') ?>

<div class="container-fluid">

	<!-- start page title -->
	<div class="row">
		<div class="col-12">
			<div class="page-title-box">
				<div class="page-title-right">
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="/head-office/wallet">Wallet</a></li>
						<li class="breadcrumb-item active">Add Transaction</li>
					</ol>
				</div>
				<h4 class="page-title"><?= $title; ?></h4>
			</div>
		</div>
	</div>     
	<!-- end page title --> 

	
	<form action="<?= site_url('head-office/wallet/add-transaction'); ?>" id="formTransaction" accept-charset="UTF-8" autocomplete="off">
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-body">
						<h4 class="header-title">Transaction Details</h4><hr>
						<br>
						<div class="row">
							<div class="col-md-6 mb-3">
								<label class="form-label">Branch <span class="text-danger">*</span></label>
								<select name="branch" id="branch" class="form-select select2NoSearch">
									<option value=""></option>
									<?php if (!empty($branches)): ?>
										<?php foreach ($branches as $branch): ?>
											<option value="<?= $branch->id; ?>"><?= $branch->branch_name; ?></option>
										<?php endforeach ?>
									<?php endif ?>
									
								</select>
							</div>
							<div class="col-md-6 mb-3">
								<label class="form-label">Transaction Type <span class="text-danger">*</span></label>
								<select name="transaction_type" id="transaction_type" class="form-select select2NoSearch">
									<option value=""></option>
									<option value="1">Credit</option>
									<option value="2">Debit</option>
								</select>
							</div>
							<div class="col-md-12 mb-3">
								<label class="form-label">Amount <span class="text-danger">*</span> <small>(In Indian currency)</small></label>
								<input type="text" class="form-control decimal" name="amount" id="amount" placeholder="Enter amount">
							</div>
							<div class="col-md-12 mb-3">
								<label for="" class="form-label">Notes </label>
								<div id="bubble-editor" class="notes" style="height: 300px;">
								</div>
							</div>
						</div>
					</div>
					<div class="card-footer">
						<div class="row">
							<div class="col-md-12 text-end">
								<?= csrf_field(); ?>
								<input type="submit" class="btn btn-dark btnSaveTransaction" value="Save">
							</div>
						</div>
					</div>
				</div><!-- end col-->
			</div>
		</form>
	</div>
	<script src="<?= site_url(); ?>public/headoffice/js/pages/quill.bubble-editor.js"></script>
	<?= $this->endSection(); ?>