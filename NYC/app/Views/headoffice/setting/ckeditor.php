
<?php
	include_once $_SERVER['DOCUMENT_ROOT'].'/ckeditor/ckeditor_php5.php';
	// echo 'string'; die;
	$CKEditor = new CKEditor();
	$CKEditor->config['filebrowserBrowseUrl'] =  site_url('ckeditor/kcfinder/browse.php');
	$CKEditor->config['filebrowserImageBrowseUrl'] =  site_url('ckeditor/kcfinder/browse.php?type=Images');
	$CKEditor->config['filebrowserUploadUrl'] =   site_url('ckeditor/kcfinder/upload.php');
	$CKEditor->config['filebrowserImageUploadUrl'] =  site_url('ckeditor/kcfinder/upload.php?type=Images');
	$CKEditor->config['toolbar'] = array(
	array( 'Bold','Italic','Underline','Strike','Subscript','Superscript','-','RemoveFormat' ),
	array('Link', 'Unlink', 'Anchor' ),
	array('Image','Table','HorizontalRule','Smiley','SpecialChar','PageBreak','Iframe'),
	array('Source','-','NewPage','DocProps','Preview','Print','-','Templates'),
	array('Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo'),
	array( 'Find','Replace','-','SelectAll'),
	array( 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton','HiddenField'),
	array( 'NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote','CreateDiv', '-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-','BidiLtr','BidiRtl' ),
	array('Styles','Format','Font','FontSize' ),
	array('TextColor','BGColor'),
	array('Maximize','-', 'ShowBlocks')
	);
	$CKEditor->textareaAttributes = array("cols" => 80, "rows" => 10);
	$CKEditor->basePath = site_url('ckeditor/');
?>
							