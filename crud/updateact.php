<?php

include('db.php');
if($_POST['sub']){
	$updateid=$_POST['id'];
	$fname=$_POST['fname'];
	$lname=$_POST['lname'];
	$dob=$_POST['dob'];
	$date=date("y-m-d", strtotime($dob));
	$gender=$_POST['gender'];
	$mail=$_POST['email'];
	$ph=$_POST['phone'];
	$query="update student set firstname='".$fname."', lastname='".$lname."', dob='".$date."', gender='".$gender."', eml='".$mail."', phone='".$ph."' where id=".$updateid;
	$sqlquery=mysqli_query($con,$query);
	if($sqlquery){
		echo "<script>alert('update sucessfully !'); window.location.href='index.php'; </script>";
	}
	else{

		echo "<script>alert('Wrong Cradential !'); window.location.href='index.php'; </script>";
	}
}
?>