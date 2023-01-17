<?php
use Config\Services;
$this->session = Services::session();
helper("custom");
if (!$this->session->isLoggedIn || !is_headoffice()) {
	$this->session->setFlashdata('message', 'Access Denied!');
	$this->session->setFlashdata('message_type', 'error');
	header('Location: '.site_url('head-office')); die;
}
?>

<?= view('headoffice/include/header'); ?>
<?= view('headoffice/include/js'); ?>
<?= $this->renderSection('body'); ?>
<?= view('headoffice/include/footer'); ?>
