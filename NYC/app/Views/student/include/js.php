	
<script>
	site_url = '<?= site_url() ?>';
	current = '<?= current_url() ?>';
</script>

<!-- <script src="<?= site_url('public/student/') ?>vendors/jquery/js/jquery.min.js"></script> -->
<script src="<?= site_url('public/student/') ?>bundles/libscripts.bundle.js"></script> <!-- Lib Scripts Plugin Js -->
<script src="<?= site_url('public/student/') ?>bundles/vendorscripts.bundle.js"></script> <!-- Lib Scripts Plugin Js -->
<!--<script src="<?= site_url('public/student/') ?>bundles/morphingsearchscripts.bundle.js"></script>  Main top morphing search -->
<script src="<?= site_url('public/student/') ?>plugins/jquery-sparkline/jquery.sparkline.min.js"></script> <!-- Sparkline Plugin Js -->
<script src="<?= site_url('public/student/') ?>plugins/chartjs/Chart.bundle.min.js"></script> <!-- Chart Plugins Js --> 

<script src="<?= site_url('public/student/') ?>bundles/datatablescripts.bundle.js"></script>
<script src="<?= site_url('public/student/') ?>plugins/jquery-datatable/buttons/dataTables.buttons.min.js"></script>
<script src="<?= site_url('public/student/') ?>plugins/jquery-datatable/buttons/dataTables.buttons.min.js"></script>
<script src="<?= site_url('public/student/') ?>plugins/jquery-datatable/buttons/buttons.bootstrap4.min.js"></script>
<script src="<?= site_url('public/student/') ?>plugins/jquery-datatable/buttons/buttons.colVis.min.js"></script>
<script src="<?= site_url('public/student/') ?>plugins/jquery-datatable/buttons/buttons.flash.min.js"></script>
<script src="<?= site_url('public/student/') ?>plugins/jquery-datatable/buttons/buttons.html5.min.js"></script>
<script src="<?= site_url('public/student/') ?>plugins/jquery-datatable/buttons/buttons.print.min.js"></script>

<script src="<?= site_url('public/student/') ?>js/pages/tables/jquery-datatable.js"></script>
<script src="<?= site_url('public/student/') ?>bundles/mainscripts.bundle.js"></script>



<!-- bundle -->
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script src="<?= site_url() ?>public/headoffice/js/swall.min.js"></script>
<script src="<?= site_url() ?>public/headoffice/js/custom/select2.min.js"></script>
<script src="<?= site_url() ?>public/headoffice/js/vendor/quill.min.js"></script>
<script src="<?= site_url() ?>public/headoffice/js/custom/daterangepicker.min.js"></script>
<script src="<?= site_url('public/student/plugins/select2/select2.min.js') ?>"></script>

<!-- custom party js -->
<script src="<?= site_url() ?>public/headoffice/js/intlTelInput.min.js"></script>

<script src="<?=site_url('public/student/js/ajax-datatable.js')?>"></script>
<script src="<?=site_url('public/student/js/scripts.js')?>"></script>
<script src="<?=site_url('public/student/js/custom.js')?>"></script> 
<!-- custom party js ends -->


<script>
	//sweet alert
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

	function success(message, reload = 1, red = false) {
		Toast.fire({
			icon: 'success',
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
	
	function error(message) {
		Toast.fire({
			icon: 'error',
			title: message
		})
	}
	
</script>

<?php if($this->session->getFlashdata('message') && $this->session->getFlashdata('message_type') == 'success'){ ?>
	<script>
		$(document).ready(function(){
			Toast.fire({
				icon: 'success',
				title: "<?=$this->session->getFlashdata('message');?>"
			})
		});
		
	</script>
<?php } elseif ($this->session->getFlashdata('message') && $this->session->getFlashdata('message_type') == 'error') { ?>
	<script>
		$(document).ready(function(){
			Toast.fire({
				icon: 'error',
				title: "<?=$this->session->getFlashdata('message');?>"
			})
		});
		
	</script>
<?php } unset($_SESSION['message']); ?>

<!-- <script type="text/javascript">
	document.addEventListener('contextmenu', function(e) {
		e.preventDefault();
	});
	document.onkeydown = function(e) {
		if(event.keyCode == 123) {
			return false;
		}
		if(e.ctrlKey && e.shiftKey && e.keyCode == 'I'.charCodeAt(0)) {
			return false;
		}
		if(e.ctrlKey && e.shiftKey && e.keyCode == 'C'.charCodeAt(0)) {
			return false;
		}
		if(e.ctrlKey && e.shiftKey && e.keyCode == 'J'.charCodeAt(0)) {
			return false;
		}
		if(e.ctrlKey && e.keyCode == 'U'.charCodeAt(0)) {
			return false;
		}
	}
</script> -->
