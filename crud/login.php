<?php
include("db.php");
session_start();
if(isset($_POST['sub'])){
	$data=array();
	$email=$_POST['email'];
	$phone=$_POST['phone'];
	$query="select * from student where eml='".$email."' and phone='".$phone."'";
	$sqlquery=mysqli_query($con,$query);
	$record=mysqli_fetch_array($sqlquery);
	$count=mysqli_num_rows($sqlquery);
	if($count>0){

		$data['id']=$record['id'];
		$data['name']=$record['firstname'];
		$session['name']=$data['name'];
		$cookie_name=$session['name'];
		$cookie_value=$email;
		setcookie($cookie_name,$cookie_value, time() + (86400 * 30), "/");
		header('location:dash.php?name='.$cookie_name.'');
	}
	else{

		echo"<script>alert('Error !'); window.location.href='login.php'; </script>";
	}
}



?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
	
</head>
<body>

	<div class="container my-4">
		<h1>Login here</h1>
	</div>
<form action="login.php" method="post">

  <div class=" container mb-3">
    <label for="exampleInputEmail1" class="form-label">Email address</label>
    <input type="email" class="form-control" placeholder="Enter your Email" name="email" id="exampleInputEmail1" >

 	 </div>
  <div class=" container mb-3">
    <label for="exampleInputPassword1" class="form-label">phone</label>
    <input type="text" class="form-control" placeholder="Enter your number" name="phone" id="exampleInputPassword1">
    <input type="submit" name="sub" value="Login" class="btn btn-primary my-4">
  </div>
  
  
</form>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>