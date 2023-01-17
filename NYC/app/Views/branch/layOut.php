<?php
use Config\Services;
$this->session = Services::session();
helper("custom");
if (!$this->session->isBranchLoggedIn) {
	$this->session->setFlashdata('message', 'Access Denied!');
	$this->session->setFlashdata('message_type', 'error');
	header('Location: '.site_url('branch')); die;
}
?>

<?= view('branch/include/header'); ?>
<?= view('branch/include/sidebar'); ?>
<?= $this->renderSection('body'); ?>
<?= view('branch/include/js'); ?>
<?= view('branch/include/footer'); ?>
