<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=Edge">
		<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
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
				<h1 class="title">FORGOT PASSWORD? <div class="msg">Enter your e-mail address below to reset your password.</div></h1>
				<div class="col-sm-12">
					<form id="sign_in" method="POST" action="<?= site_url('forgot-password'); ?>">
						<div class="input-group"> <span class="input-group-addon"> <i class="zmdi zmdi-email"></i> </span>
							<div class="form-line">
								<input type="email" class="form-control" name="email" placeholder="Email" autofocus="">
							</div>
						</div>
						<?= csrf_field(); ?>
						<div class="text-center">
							<button class="btn btn-raised waves-effect g-bg-blush2" type="submit">RESET MY PASSWORD</button>
						</div>
						<div class="col-sm-12 text-center"> <a href="<?= site_url('') ?>">Sign In!</a> </div>
						<span class="msg"><?= view('Auth\Views\_notifications') ?></span>
					</form>
				</div>
			</div>
		</div>
		
	</body>
</html>