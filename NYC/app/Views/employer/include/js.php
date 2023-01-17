<script>
	site_url = '<?= site_url() ?>';
</script>

<!-- bundle -->
<script src="<?= site_url() ?>public/employer/js/vendor.min.js"></script>
<script src="<?= site_url() ?>public/employer/js/app.min.js"></script>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script src="<?= site_url() ?>public/employer/js/swall.min.js"></script>
<script src="<?= site_url() ?>public/employer/js/custom/select2.min.js"></script>
<script src="<?= site_url() ?>public/employer/js/vendor/quill.min.js"></script>
<script src="<?= site_url() ?>public/employer/js/custom/daterangepicker.min.js"></script>

<!-- custom party js -->
<script src="<?= site_url() ?>public/employer/js/custom/jquery.imageReloader.js"></script>
<script src="<?= site_url() ?>public/employer/js/intlTelInput.min.js"></script>
<script src="<?= site_url('public/global/print/print/src/print.min.js') ?>"></script>


<script src="<?=site_url('public/employer/js/scripts.js')?>"></script>
<script src="<?=site_url('public/employer/js/custom.js?v=').filemtime($_SERVER['DOCUMENT_ROOT'].'/public/employer/js/custom.js')?>"></script>

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

	function printCombinedPdf(file) {
		printJS({
			printable: file, 
			type: 'pdf', 
			showModal: true
		})
	};
	function disable_autocomplete(form)
	{
		$(form).attr('autocomplete', 'off');
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


<!-- third party js -->
<script src="<?= site_url() ?>public/employer/js/vendor/jquery.dataTables.min.js"></script>
<script src="<?= site_url() ?>public/employer/js/vendor/dataTables.bootstrap5.js"></script>
<script src="<?= site_url() ?>public/employer/js/vendor/dataTables.responsive.min.js"></script>
<script src="<?= site_url() ?>public/employer/js/vendor/responsive.bootstrap5.min.js"></script>
<script src="<?= site_url() ?>public/employer/js/vendor/dataTables.buttons.min.js"></script>
<script src="<?= site_url() ?>public/employer/js/vendor/buttons.bootstrap5.min.js"></script>
<script src="<?= site_url() ?>public/employer/js/vendor/buttons.html5.min.js"></script>
<script src="<?= site_url() ?>public/employer/js/vendor/buttons.flash.min.js"></script>
<script src="<?= site_url() ?>public/employer/js/vendor/buttons.print.min.js"></script>
<script src="<?= site_url() ?>public/employer/js/vendor/dataTables.keyTable.min.js"></script>
<script src="<?= site_url() ?>public/employer/js/vendor/dataTables.select.min.js"></script>
<script src="<?= site_url() ?>/public/employer/js/countdown.js"></script>
<!-- third party js ends -->
