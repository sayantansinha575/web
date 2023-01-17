<?php
use Config\Services;
$this->session = Services::session();
helper("custom");

?>
<?php if ($this->session->isStudLoggedIn && is_student()): ?>
	<?= view('student/include/header') ?> 
	<?= view('student/include/sidebar') ?> 
	<?= view('student/include/js') ?> 
	<?= $this->renderSection('body') ?> 
	<?= view('student/include/footer') ?>
<?php else: ?>
	<?php  
	$this->session->setFlashdata('message', 'Access Denied!');
	$this->session->setFlashdata('message_type', 'error');
	header('Location: '.site_url()); die;
	?>
<?php endif ?>

