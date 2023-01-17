<!doctype html>
<html lang="en">
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<!-- Bootstrap CSS -->
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">

		<title>Convert HTML to PDF using FPDF</title>
	</head>
	<body>
		<div class="container">
			<div class="row">
				<div class="col-lg-7 mx-auto">
					<h5 class="text-center mt-5 mb-5">Convert HTML to Pdf using Fpdf</h5>
					<form action="convert-pdf.php" method="post">
						<div class="mb-3">
							<label for="name" class="form-label">Name</label>
							<input type="text" class="form-control" id="name" name="name">
						</div>
						<div class="mb-3">
							<label for="email" class="form-label">Email</label>
							<input type="text" class="form-control" id="email" name="email">
						</div>
						<div class="mb-3">
							<label for="message" class="form-label">Message</label>
							<input type="text" class="form-control" id="message" name="message">
						</div>
						<div class="mb-3">
							<button type="submit" class="btn btn-primary mb-3">Submit</button>
						</div>
					</form>
				</div>

			</div>
		</div>

	</body>
</html>