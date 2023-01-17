<?php
use Config\Services;
$this->session = Services::session();
helper("custom");
if (!$this->session->isEmpLoggedIn || !is_employer()) {
	$this->session->setFlashdata('message', 'Access Denied!');
	$this->session->setFlashdata('message_type', 'error');
	header('Location: '.site_url('head-office')); die;
}
?>

<?= view('employer/include/header'); ?>
<?= view('employer/include/js'); ?>
<?= $this->renderSection('body'); ?>
<?= view('employer/include/footer'); ?>
