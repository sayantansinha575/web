<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>404 Page Not Found</title>
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css" rel="stylesheet" type="text/css" />
	<style>
		@import url("https://fonts.googleapis.com/css?family=Montserrat:400,400i,700");
		*,
		*:after,
		*:before {
			box-sizing: border-box;
		}

		body {
			background-color: #313942;
			font-family: "Montserrat", sans-serif;
			overflow: hidden;
		}

		main {
			align-items: center;
			display: flex;
			flex-direction: column;
			height: 100vh;
			justify-content: center;
			text-align: center;
		}

		h1 {
			color: #e7ebf2;
			font-size: 12.5rem;
			letter-spacing: 0.1em;
			margin: 0.025em 0;
			text-shadow: 0.05em 0.05em 0 rgba(0, 0, 0, 0.25);
			white-space: nowrap;
		}
		@media (max-width: 30rem) {
			h1 {
				font-size: 8.5rem;
			}
		}
		h1 > span {
			-webkit-animation: spooky 2s alternate infinite linear;
			animation: spooky 2s alternate infinite linear;
			color: #528cce;
			display: inline-block;
		}

		h2 {
			color: #e7ebf2;
			margin-bottom: 0.4em;
		}

		p {
			color: #ccc;
			margin-top: 0;
		}

		@-webkit-keyframes spooky {
			from {
				transform: translatey(0.15em) scaley(0.95);
			}
			to {
				transform: translatey(-0.15em);
			}
		}

		@keyframes spooky {
			from {
				transform: translatey(0.15em) scaley(0.95);
			}
			to {
				transform: translatey(-0.15em);
			}
		}

		.error__button {
			min-width: 7em;
			margin-top: 3em;
			margin-right: 0.5em;
			padding: 0.5em 2em;
			outline: none;
			border: 2px solid #2f3640;
			background-color: transparent;
			border-radius: 8em;
			color: #576375;
			cursor: pointer;
			transition-duration: 0.2s;
			font-size: 0.75em;
			font-family: "Montserrat", sans-serif;
		}

		.error__button:hover {
			color: #21252c;
		}

		.error__button--active {
			background-color: #e67e22;
			border: 2px solid #e67e22;
			color: white;
		}

		.error__button--active:hover {
			box-shadow: 0px 0px 8px 0px rgba(0,0,0,0.5);
			color: white;
		}
		a{
			text-decoration: none;
		}
	</style>
</head>
<body id="body">
	<div class="wrap">
		<main>
			<h1>4<span><i class="fas fa-ghost"></i></span>4</h1>
			<h2>Error: 404 page not found</h2>
			<p>Sorry, the page you're looking for cannot be accessed</p>
			<a href="<?= site_url('dashboard') ?>" class="error__button error__button--active">Home</a>
		</main>
	</div>
</body>

</html>
