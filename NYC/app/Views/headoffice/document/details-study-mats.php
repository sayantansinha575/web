<?= $this->extend('headoffice/layOut'); ?>
<?= $this->section('body') ?>
<div class="container-fluid">
	<!-- start page title -->
	<div class="row">
		<div class="col-12">
			<div class="page-title-box">
				<div class="page-title-right">
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="/head-office/ducments/study-materials">Study Materials</a></li>
						<li class="breadcrumb-item active">Documents Details</li>
					</ol>
				</div>
				<h4 class="page-title"><?= $title; ?></h4>
			</div>
		</div>
	</div>     
	<!-- end page title --> 

	<div class="row" id="studyMatContainer" style="display: <?= empty($details)?'none':''; ?>;">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<div class="row">
						<div class="col-md-4">
							<h5>Document List</h5>
						</div>
						<div class="col-md-8 text-end">
							<a class="btn btn-dark btn-sm" href="<?= site_url('head-office/document/add-files/'.$details->id) ?>"><i class="fa-solid fa-plus"></i> Add</a>
						</div>
					</div>
				</div>
				<div class="card-body">
					<table class="table table-sm table-centered mb-0 docsListTbl">
						<thead>
							<tr>
								<th width="5%">#</th>
								<th width="85%">Description</th>
								<th width="10%">Action</th>
							</tr>
						</thead>
						<tbody>
							<?php if (!empty($details)): ?>
								<?php if (!empty($documents)): $i = 1;?>
									<?php foreach ($documents as $docs): 
										$desc = $docs->description;
										?>
										<tr>
											<td><?= $i++; ?></td>
											<td ><?= $desc ?></td>
											<td>
												<a href="<?= site_url('head-office/document/edit-files/'.$details->id.'/'.$docs->id) ?>" class="btn btn-dark btn-sm btn-icon" data-toggle="tooltip" title="<?= "Edit Description" ?>"><i class="fa-solid fa-pen-to-square"></i></a>
												<a href="javascript:void(0)" class="btn btn-danger btn-sm btn-icon deletedocsSection" data-file="<?= "$docs->id||$details->course_id" ?>" data-toggle="tooltip" title="Delete Description"><i class="fa-solid fa-trash-can"></i></a>
											</td>
										</tr>
									<?php endforeach ?>
								<?php endif ?>
							<?php endif ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<?= $this->endSection(); ?>