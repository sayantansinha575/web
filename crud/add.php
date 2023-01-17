<?php

include("db.php");
if(isset($_POST['sub'])){
	$Firstname=$_POST['fname'];
	$lastname=$_POST['lname'];
	$dob=$_POST['dob'];
	$dateofbirth=date("y-m-d",strtotime($dob));
	$gender=$_POST['gender'];
	$mail=$_POST['email'];
	$phone=$_POST['phone'];
	$query="insert into student(firstname,lastname,dob,gender,eml,phone) value('".$Firstname."','".$lastname."','".$dateofbirth."','".$gender."','".$mail."','".$phone."')";
	$sqlquery=mysqli_query($con,$query);
	if(isset($sqlquery)){
		echo "<script>alert('user add sucessfully !'); window.location.href='index.php'; </script>";
	}
	else{
		echo "<script>alert('Error !'); window.location.href='index.php'; </script>";
	}
}


?>