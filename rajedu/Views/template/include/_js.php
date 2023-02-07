<script>
	site_url = '<?= site_url() ?>';
	var x_timer;
</script>

<?= $this->section('mainJs') ?>
<!-- BEGIN: Vendor JS-->
<script src="<?= ADMIN_ASSETS ?>vendors/js/vendors.min.js"></script>
<script src="<?= ADMIN_ASSETS ?>vendors/js/forms/toggle/switchery.min.js"></script>
<script src="<?= ADMIN_ASSETS ?>js/scripts/forms/switch.min.js"></script>
<!-- BEGIN Vendor JS-->

<script src="<?= ADMIN_ASSETS ?>vendors/js/tables/datatable/datatables.min.js"></script>
<script src="<?= ADMIN_ASSETS ?>vendors/js/editors/tinymce/tinymce.js"></script>
<script src="<?= ADMIN_ASSETS ?>vendors/js/forms/select/select2.full.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>



<!-- BEGIN: Theme JS-->
<script src="<?= ADMIN_ASSETS ?>js/core/app-menu.min.js"></script>
<script src="<?= ADMIN_ASSETS ?>js/core/app.min.js"></script>
<script src="<?= ADMIN_ASSETS ?>js/scripts/customizer.min.js"></script>
<script src="<?= ADMIN_ASSETS ?>vendors/js/jquery.sharrre.js"></script>
<script src="<?= ADMIN_ASSETS ?>vendors/js/swall.min.js"></script>

<script src="<?= ADMIN_ASSETS ?>vendors/js/forms/icheck/icheck.min.js"></script>
<script src="<?= ADMIN_ASSETS ?>js/scripts/forms/checkbox-radio.min.js"></script>
<!-- scrips -->
<?= script_tag(ADMIN_ASSETS . 'js/script.bundle.js?v=' . filemtime('assets/js/script.bundle.js')) ?>

<script>
	var Toast = Swal.mixin({
		toast: true,
		position: 'top-end',
		showConfirmButton: false,
		timer: 3500,
		timerProgressBar: true,
		didOpen: (toast) => {
			toast.addEventListener('mouseenter', Swal.stopTimer)
			toast.addEventListener('mouseleave', Swal.resumeTimer)
		}
	});

	function showNotify(message, icon, reload = false, red = false) {
		Toast.fire({
			icon: icon,
			title: message
		})

		if (reload) {
			setTimeout(function () {
				location.reload(true);
			}, 3500	);
		}
		if (red) {
			setTimeout(function () {
				window.location.href = red;
			}, 3500	);
		}
	}
</script>

<?= $this->endSection() ?>