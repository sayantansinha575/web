<?= $this->extend('headoffice/layOut'); ?>
<?= $this->section('body') ?>
<div class="container-fluid">

	<!-- start page title -->
	<div class="row">
		<div class="col-12">
			<div class="page-title-box">
				<div class="page-title-right">
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="/head-officedashboard">Dashboard</a></li>
						<li class="breadcrumb-item active"><?= $title; ?></li>
					</ol>
				</div>
				<h4 class="page-title"><?= $title; ?></h4>
			</div>
		</div>
	</div>     
	<!-- end page title --> 

	
	<form action="<?= $url; ?>" id="defaultForm" accept-charset="UTF-8" autocomplete="off">
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-body">
						<h4 class="header-title"><?= $title; ?></h4><hr>
						<br>
						<div class="row">
							<?php if (!empty($settings)): ?>
								<?php foreach ($settings as $sett): ?>
									<?php if ($sett->type == 0): ?>
										<div class="<?= $sett->class; ?> mb-2">
											<label class="form-label"><?= $sett->label; ?>   <span class="text-danger">*</span>   <?= (!empty($sett->notes))?'<span data-toggle="tooltip" title="'.$sett->notes.'"><i class="fa-solid fa-circle-info"></i></span>':''; ?></label>
											<input type="text" class="form-control <?= $sett->field_class; ?>"  value="<?=($sett->value)?($sett->value):''; ?>" name="<?= strtolower($sett->name) ; ?>" >
										</div>
									<?php endif ?>

									<?php if ($sett->type == 1): ?>
										<div class="<?= $sett->class; ?> mt-2">
											<label class="form-label"><?= $sett->label; ?>   <span class="text-danger">*</span>   <?= (!empty($sett->notes))?'<span data-toggle="tooltip" title="'.$sett->notes.'"><i class="fa-solid fa-circle-info"></i></span>':''; ?></label>
											<textarea rows="3" class="form-control <?= $sett->field_class; ?>" name="<?= strtolower($sett->name); ?>"><?= ($sett->value)?($sett->value):''; ?></textarea>
										</div>
									<?php endif ?>

									<?php if ($sett->type == 3): ?>
										<div class="<?= $sett->class; ?> mt-3">
											<label class="form-label"><?= $sett->label; ?>   <span class="text-danger">*</span>   <?= (!empty($sett->notes))?'<span data-toggle="tooltip" title="'.$sett->notes.'"><i class="fa-solid fa-circle-info"></i></span>':''; ?></label>
											<?php
												include('ckeditor.php');
												$CKEditor->editor(strtolower($sett->name), ($sett->value)?($sett->value):'');
											?>
										</div>
									<?php endif ?>

									<?php if ($sett->type == 2): ?>
										<div class="col-md-<?= (empty($sett->value))?6:4; ?> mb-2">
											<label class="form-label"><?= $sett->label; ?>   <span class="text-danger">*</span>   <?= (!empty($sett->notes))?'<span data-toggle="tooltip" title="'.$sett->notes.'"><i class="fa-solid fa-circle-info"></i></span>':''; ?></label>
											<input class="form-control <?= $sett->field_class; ?>" type="file" accept="image/*" name="<?= strtolower($sett->name); ?>">
										</div>
										<?php if (!empty($sett->value)): ?>
											<div class="col-md-2 mt-3">
												<label>&nbsp;</label>
												<img class="img-thumbnail img-responsive" src="<?= site_url('public/upload/settings/'). $sett->value ?>" style="max-width: 50%;"/>
											</div>

										<?php endif ?>
									<?php endif ?>

								<?php endforeach ?>
							<?php endif ?>
						</div>
					</div>
					<div class="card-footer">
						<div class="row">
							<div class="col-md-12 text-end">
								<?= csrf_field(); ?>
								<input type="submit" class="btn btn-dark defaultBtn" value="Save">
							</div>
						</div>
					</div>
				</div><!-- end col-->
			</div>
		</form>
	</div>
	<?= $this->endSection(); ?>