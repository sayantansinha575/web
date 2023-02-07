<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
	<title>Login - Chameleon Admin - Modern Bootstrap 4 WebApp & Dashboard HTML Template + UI Kit</title>
	<link rel="apple-touch-icon" href="<?= ADMIN_ASSETS ?>images/ico/apple-icon-120.png">
	<link rel="shortcut icon" type="image/x-icon" href="https://demos.themeselection.com/chameleon-admin-template/<?= ADMIN_ASSETS ?>images/ico/favicon.ico">
	<link href="https://fonts.googleapis.com/css?family=Muli:300,300i,400,400i,600,600i,700,700i%7CComfortaa:300,400,700" rel="stylesheet">

	<link rel="stylesheet" href="<?= ADMIN_ASSETS ?>vendors/css/vendors.min.css">
	<link rel="stylesheet" href="<?= ADMIN_ASSETS ?>vendors/css/forms/toggle/switchery.min.css">
	<link rel="stylesheet" href="<?= ADMIN_ASSETS ?>css/plugins/forms/switch.min.css">
	<link rel="stylesheet" href="<?= ADMIN_ASSETS ?>css/core/colors/palette-switch.min.css">    

	<link rel="stylesheet" href="<?= ADMIN_ASSETS ?>css/bootstrap.min.css">
	<link rel="stylesheet" href="<?= ADMIN_ASSETS ?>css/bootstrap-extended.min.css">
	<link rel="stylesheet" href="<?= ADMIN_ASSETS ?>css/colors.min.css">
	<link rel="stylesheet" href="<?= ADMIN_ASSETS ?>css/components.min.css">    

	<link rel="stylesheet" href="<?= ADMIN_ASSETS ?>css/core/menu/menu-types/vertical-menu.min.css">
	<link rel="stylesheet" href="<?= ADMIN_ASSETS ?>css/core/colors/palette-gradient.min.css">
	<link rel="stylesheet" href="<?= ADMIN_ASSETS ?>css/pages/login-register.min.css">    

	<link rel="stylesheet" href="<?= ADMIN_ASSETS ?>css/style.css">    

</head>  

<body class="vertical-layout vertical-menu 1-column  bg-full-screen-image blank-page blank-page" data-open="click" data-menu="vertical-menu" data-color="bg-gradient-x-purple-blue" data-col="1-column">    
	<div class="app-content content">
		<div class="content-wrapper">
			<div class="content-wrapper-before"></div>
			<div class="content-header row">
			</div>
			<div class="content-body">
				<?= $this->renderSection('content') ?>
			</div>
		</div>
	</div>    

	<script>
		var site_url = '<?= site_url(); ?>';
	</script>
	<script src="<?= ADMIN_ASSETS ?>vendors/js/vendors.min.js"></script>
	<script src="<?= ADMIN_ASSETS ?>vendors/js/forms/toggle/switchery.min.js"></script>
	<script src="<?= ADMIN_ASSETS ?>js/scripts/forms/switch.min.js"></script>    

	<script src="<?= ADMIN_ASSETS ?>vendors/js/forms/validation/jqBootstrapValidation.js"></script>    

	<script src="<?= ADMIN_ASSETS ?>js/core/app-menu.min.js"></script>
	<script src="<?= ADMIN_ASSETS ?>js/core/app.min.js"></script>    

	<script src="<?= ADMIN_ASSETS ?>js/scripts/forms/form-login-register.min.js"></script>    
	<?= $this->renderSection('js') ?>
</body>

</html>