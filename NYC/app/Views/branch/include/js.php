<script>
	site_url = '<?= site_url() ?>';
	current = '<?= current_url() ?>';
	walletBal = <?= getWalletBalance() ?>;
	certificateCharge = <?= config('SiteConfig')->general['CERTIFICATE_GENERATE_CHARGE'] ?>;
	urgentCertificateCharge = <?= config('SiteConfig')->general['URGENT_CERTIFICATE_CHARGE'] ?>;
</script>


<script src="<?= site_url() ?>public/branch/js/jquery.min.js"></script>
<script src="<?= site_url() ?>public/branch/js/popper.min.js"></script>
<script src="<?= site_url() ?>public/branch/js/bootstrap.min.js"></script>
<script src="<?= site_url() ?>public/branch/js/select2.min.js"></script>
<script src="<?= site_url() ?>public/branch/js/slick.js"></script>
<script src="<?= site_url() ?>public/branch/js/moment.min.js"></script>
<script src="<?= site_url() ?>public/branch/js/daterangepicker.js"></script> 
<script src="<?= site_url() ?>public/branch/js/summernote.min.js"></script>
<script src="<?= site_url() ?>public/branch/js/metisMenu.min.js"></script>
<script src="<?= site_url() ?>public/branch/js/swall.min.js"></script>	
<script src="<?= site_url() ?>public/branch/js/jquery.dataTables.min.js"></script>	
<script src="<?= site_url() ?>public/branch/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= site_url() ?>public/branch/js/bootstrap-datepicker.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>	
<script src="<?= site_url() ?>public/branch/js/intlTelInput.min.js"></script>
<script src="<?=site_url('public/branch/js/custom.js')?>"></script>


<!-- custom js -->
<script src="<?=site_url('public/branch/js/page/scripts.js')?>"></script>
<script src="<?=site_url('public/branch/js/page/common.js')?>"></script>
<script src="<?=site_url('public/branch/js/page/ajax-datatable.js')?>"></script>
<script src="<?= site_url('public/branch/js/page/payment.js') ?>"></script>
<script src="<?= site_url('public/branch/js/page/countdown.js') ?>"></script>
<script src="<?= site_url('public/common/countdown.js') ?>"></script>



<script>
	//sweet alert
	var Toast = Swal.mixin({
		toast: true,
		position: 'top-right',
		showConfirmButton: false,
		timer: 5500,
		timerProgressBar: true,
		didOpen: (toast) => {
			toast.addEventListener('mouseenter', Swal.stopTimer)
			toast.addEventListener('mouseleave', Swal.resumeTimer)
		}
	});

	function success(message, reload = 1, red=false) {
		Toast.fire({
			icon: 'success',
			title: message
		})

		if (reload) {
			setTimeout(function () {
				location.reload(true);
			}, 5500	);
		}
		if (red) {
			setTimeout(function () {
				window.location.href = red;
			}, 5500	);
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
		Toast.fire({
			icon: 'success',
			title: "<?=$this->session->getFlashdata('message');?>"
		})
	</script>
<?php } elseif ($this->session->getFlashdata('message') && $this->session->getFlashdata('message_type') == 'error') { ?>
	<script type="text/javascript">
		Toast.fire({
			icon: 'error',
			title: "<?=$this->session->getFlashdata('message');?>"
		})
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

