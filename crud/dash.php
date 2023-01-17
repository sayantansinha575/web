
<?php

include("db.php");
session_start();
$name=$_GET['name'];

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>dashboard</title>
</head>
<body>
<div class="container my-4">
	<h1>Login Sucessful<?php echo $name; ?></h1>
</div>
</body>
</html>