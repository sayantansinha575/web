<?= $this->extend('branch/layOut'); ?>
<?= $this->section('body') ?>
<?php 
	$this->session = \Config\Services::session(); 
	$validation = \Config\Services::validation();
?>
<div class="col-lg-9 col-md-9 col-sm-12">
	<div class="row pt-4">
		<div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
			<div class="dashboard_stats_wrap dash">
				<div class="rounded-circle p-4 p-sm-4 d-inline-flex align-items-center justify-content-center bg-warning mb-2"><div class="position-absolute text-white h5 mb-0"><i class="fas fa-users"></i></div></div>
				<div class="dashboard_stats_wrap_content text-secondary"><h5><?= studentsCount() ?></h5> <span><strong>Number of Students</strong></span></div>
			</div>	
		</div>
		<div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
			<div class="dashboard_stats_wrap dash">
				<div class="rounded-circle p-4 p-sm-4 d-inline-flex align-items-center justify-content-center bg-warning mb-2"><div class="position-absolute text-white h5 mb-0"><i class="fa fa-book"></i></div></div>
				<div class="dashboard_stats_wrap_content text-secondary"><h5><?= get_count('branch_to_course', ['branch_id' =>  $this->session->branchData['id'],'status'=>1]); ?></h5> <span><strong>Selected Courses</strong></span></div>
			</div>	
		</div>
		<div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
			<div class="dashboard_stats_wrap dash">
				<div class="rounded-circle p-4 p-sm-4 d-inline-flex align-items-center justify-content-center bg-warning mb-2"><div class="position-absolute text-white h5 mb-0"><i class="fas fa-user-plus"></i></div></div>
				<div class="dashboard_stats_wrap_content text-secondary"><h5><?= admissionCount(); ?></h5> <span><strong>Number of Enrollment</strong></span></div>
			</div>	
		</div>
		<div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
			<div class="dashboard_stats_wrap dash">
				<div class="rounded-circle p-4 p-sm-4 d-inline-flex align-items-center justify-content-center bg-warning mb-2"><div class="position-absolute text-white h5 mb-0"><i class="fas fa-chalkboard-teacher"></i></div></div>
				<div class="dashboard_stats_wrap_content text-secondary"><h5><?= marksheetCount(); ?></h5> <span><strong>Number of Marksheets</strong></span></div>
			</div>	
		</div>
		<div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
			<div class="dashboard_stats_wrap dash">
				<div class="rounded-circle p-4 p-sm-4 d-inline-flex align-items-center justify-content-center bg-warning mb-2"><div class="position-absolute text-white h5 mb-0"><i class="fa fa-certificate"></i></div></div>
				<div class="dashboard_stats_wrap_content text-secondary"><h5><?= certificateCount(); ?></h5> <span><strong>Number of Certificates</strong></span></div>
			</div>	
		</div>
		<div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
			<div class="dashboard_stats_wrap dash">
				<div class="rounded-circle p-4 p-sm-4 d-inline-flex align-items-center justify-content-center bg-warning mb-2"><div class="position-absolute text-white h5 mb-0"><i class="fa fa-inr"></i></div></div>
				<div class="dashboard_stats_wrap_content text-secondary"><h5 ><i class="fa fa-inr"></i><a href="javascript:void(0)" data-toggle="modal"   data-target="#modal-master-type-of-degree"><?= number_format(studentPayment(), 2); ?></a></h5> <span><strong>Student Payment Received</strong></span></div>
			</div>	
		</div>
		<div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
			<div class="dashboard_stats_wrap dash">
				<div class="rounded-circle p-4 p-sm-4 d-inline-flex align-items-center justify-content-center bg-warning mb-2"><div class="position-absolute text-white h5 mb-0"><i class="fa fa-book"></i></div></div>
				<div class="dashboard_stats_wrap_content text-secondary"><h5 ><?= get_count('course', ['status'=>1]); ?></h5> <span><strong>Total Course</strong></span></div>
			</div>	
		</div>
		<div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
			<div class="dashboard_stats_wrap dash">
				<div class="rounded-circle p-4 p-sm-4 d-inline-flex align-items-center justify-content-center bg-warning mb-2"><div class="position-absolute text-white h5 mb-0"><i class="fa fa-id-card"></i></div></div>
				<div class="dashboard_stats_wrap_content text-secondary"><h5 > <?= get_count('admits', ['branch_id' =>  $this->session->branchData['id']]); ?></h5> <span><strong>Number of Admits</strong></span></div>
			</div>	
		</div>
		<div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
			<div class="dashboard_stats_wrap dash">
				<div class="rounded-circle p-4 p-sm-4 d-inline-flex align-items-center justify-content-center bg-warning mb-2"><div class="position-absolute text-white h5 mb-0"><i class="fa fa-inr"></i></div></div>
				<div class="dashboard_stats_wrap_content text-secondary"><h5><i class="fa fa-inr"></i> <?= number_format(totalDueAmount(), 2); ?></h5> <span><strong>Student's Total Due Amount</strong></span></div>
			</div>	
		</div>
		<div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
			<div class="dashboard_stats_wrap dash">
				<div class="rounded-circle p-4 p-sm-4 d-inline-flex align-items-center justify-content-center bg-warning mb-2"><div class="position-absolute text-white h5 mb-0"><i class="fa fa-inr"></i></div></div>
				<div class="dashboard_stats_wrap_content text-secondary"><h5><i class="fa fa-inr"></i> <?= number_format(totalAmtPaidToHO(), 2); ?></h5> <span><strong>Total Amount Paid to H.O.</strong></span></div>
			</div>	
		</div>
	</div>
	
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 pt-4">
			<div class="dashboard_wrap">
				<div class="row justify-content-center">
					<div class="col-xl-12 col-lg-12 col-md-12"><strong><h5><u><p class="text-secondary text-center">Send Your Query to Head Office:</p></u></h5></strong>
	</div>

	<div class="row">
		<div class="col-xl-12 col-lg-12 col-md-12 pt-4">
			<div class="dashboard_wrap">
				<div class="row justify-content-center">
					<div class="col-xl-12 col-lg-12 col-md-12">
						<form action="<?= site_url('send-mail/branch-to-any') ?>" method="post" accept-charset="UTF-8" autocomplete="off">
							<div class="form-group mb-3">
								<label>Recipients <span class="text-danger">*</span><small>(For multiple recipient add comma)</small></label>
								<textarea name="recipient" class="form-control" rows="2"><?= old('recipient') ?></textarea>
								<span class="text-danger"><?= $validation->getError('recipient'); ?><?= session('recipient-error') ?></span>
							</div>
							<div class="form-group mb-3">
								<label>Subject <span class="text-danger">*</span></label>
								<input type="text" class="form-control" value="<?= old('subject') ?>" name="subject">
								<span class="text-danger"><?= $validation->getError('subject'); ?><?= session('subject-error') ?></span>
							</div>
							<div class="form-group smalls mb-3">
								<label>Mail Body <span class="text-danger">*</span></label>
								<textarea name="body" id="summernote"><?= old('body') ?></textarea>
								<span class="text-danger"><?= $validation->getError('body'); ?><?= session('body-error') ?></span>
							</div>
							<div class="form-group smalls text-right">
								<?= csrf_field(); ?>							
								<button class="btn theme-bg text-white" type="submit">Send E-mail</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade text-left" id="modal-master-type-of-degree" data-backdrop="false" tabindex="-1" role="dialog" aria-labelledby="master-type-of-degree-label" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title" id="master-type-of-degree-label"> Enter Password</h3>
			</div>
			<form action="<?= site_url('master/save-type-of-degree') ?>" id="form-type-of-degree">
				<div class="modal-body">
					<div class="form-group floating-label-form-group">
						<label for="degree_type" class="form-label">Enter Password<span class="text-danger">*</span></label>
						<input type="text" class="form-control" id="degree_type" name="degree_type" placeholder="Enter Password..">
						<div class="error-feedback"></div>
					</div>
				
					<div class="form-group">
						<div id="form-feedback" class="error-feedback"></div>
					</div>
				</div>
				<div class="modal-footer">
					<?= csrf_field(); ?>
					<input type="hidden" name="id" readonly id="id">
					<button type="button" data-type="reset" class="btn btn-secondary">Close</button>
					<button type="submit" class="btn btn-primary" id="btn-type-of-degree">Save</button>
				</div>
			</form>
		</div>
	</div>
</div>
<?= $this->endSection(); ?>