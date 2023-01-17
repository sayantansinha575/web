<?= $this->extend('headoffice/layOut'); ?>
<?= $this->section('body') ?>
<div class="container-fluid">
	<!-- start page title -->
	<div class="row">
		<div class="col-12">
			<div class="page-title-box">
				<div class="page-title-right">
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="/head-office/document/branch-document">Branch Documents</a></li>
						<li class="breadcrumb-item active"><?= empty($details)?'Add':'Edit'; ?> Documents</li>
					</ol>
				</div>
				<h4 class="page-title"><?= $title; ?></h4>
			</div>
		</div>
	</div>     
	<!-- end page title --> 	
	<form action="<?= current_url(); ?>" id="defaultForm" accept-charset="UTF-8" autocomplete="off">
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-body">
						<h4 class="header-title">Details</h4><hr>
						<br>
						<div class="row">
							<div class="col-md-12">
								<div class="row">
									<div class="col-md-12 mb-2">
										<label for="description" class="form-label">Description</label>
										<?php
										include('ckeditor.php');
										$CKEditor->editor('description', (empty($details))?'':$details->description);
										?>
									</div>
									<div class="col-md-12 mb-2">
										<label for="documents" class="form-label">Docuemnts</label>
										<input class="form-control" type="file" id="documents" name="documents[]" accept=".docx,.xlsx,.pdf" multiple>
									</div>
								</div>
							</div>

							<?php if (!empty($details) && !empty(unserialize($details->documents))): ?>
								<div class="col-md-12">
									<table class="table table-sm table-centered mb-0 docsListTbl">
										<thead>
											<tr>
												<th width="5%">#</th>
												<th width="85%">Document</th>
												<th width="10%">Action</th>
											</tr>
										</thead>
										<tbody>
											<?php
											$files = unserialize($details->documents);
											$i = 1;
											?>
											<?php foreach ($files as $Key => $file): ?>
												<tr>
													<td><?= $i++ ?></td>
													<td><?= $file ?></td>
													<td>
														<a href="<?= site_url('public/upload/files/branch/branch-documents/'.$file) ?>" class="btn btn-success btn-sm btn-icon" data-toggle="tooltip" title="<?= "Download $file" ?>"><i class="fa-solid fa-download"></i></a>
														<a href="javascript:void(0)" class="btn btn-danger btn-sm btn-icon deleteCourseMaterial" data-file="<?= "$file||0||0||$details->id||2" ?>" data-toggle="tooltip" title="<?= "Delete $file" ?>"><i class="fa-solid fa-trash-can"></i></a>
													</td>
												</tr>
											<?php endforeach ?>
										</tbody>
									</table>
								</div>
							<?php endif ?>
						</div>
					</div>
					<div class="card-footer">
						<div class="row">
							<div class="col-md-12 text-end">
								<?= csrf_field(); ?>
								<input type="submit" class="btn btn-dark defaultBtn" value="<?= empty($details)?'Save':'Update'; ?>">
							</div>
						</div>
					</div>
				</div><!-- end col-->
			</div>
		</div>
	</form>
</div>
<?= $this->endSection(); ?>