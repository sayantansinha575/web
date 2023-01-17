<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=Edge">
		<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
		<meta name="title" content="<?= config('SiteConfig')->meta['TITLE'] ?>">
		<meta name="description" content="<?= config('SiteConfig')->meta['DESCRIPTION'] ?>">
		<meta name="robots" content="noindex,nofollow">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta name="language" content="English">
		<meta name="author" content="NYCTA">
		<title>Student :: National Youth Computer Training Academy</title>
		<!-- Favicon-->
		<link rel="icon" href="favicon.ico" type="image/x-icon">
		<link rel="stylesheet" href="<?= site_url('public/student/') ?>plugins/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="<?= site_url('public/student/icon/') ?>icon?family=Material+Icons">
		<!-- Custom Css -->
		<link rel="stylesheet" href="<?= site_url('public/student/') ?>css/main.css">
		<link href="<?= site_url('public/student/') ?>css/login.css" rel="stylesheet">

		<link rel="stylesheet" href="<?= site_url('public/student/') ?>css/themes/all-themes.css">
	</head>
	<body class="login-page authentication student-login-screen">

		<div class="container">
			<div class="card-top"></div>
			<div class="card">
				<img  src="<?= site_url('public/student/') ?>images/nycta-header-image.jpg">
				<h1 class="title">Student Login</h1>
				<div class="col-sm-12">
					<form id="sign_in" method="POST" action="<?= site_url('student'); ?>">
						<div class="input-group">
							<span class="input-group-addon">
								<i class="zmdi zmdi-account"></i> </span>
							<div class="form-line">
								<input type="text" class="form-control" name="registration_number" id="registration_number" placeholder="Username" required="" autofocus="">
							</div>
						</div>
						<div class="input-group">
							<span class="input-group-addon">
								<i class="zmdi zmdi-lock"></i> </span>
							<div class="form-line">
								<input type="password" class="form-control" name="password" id="password" type="password" placeholder="Enter your Password">
							</div>
						</div>
						<?= csrf_field(); ?>
						<div class="text-center">
							<button class="btn btn-raised waves-effect g-bg-blush2" type="submit">SIGN IN</button>
						</div>
						
						<span class="msg"><?= view('Auth\Views\_notifications') ?></span>
					</form>
				</div>
			</div>
		</div>
		
	</body>
</html>