<?php

include("db.php");
$delete_id=$_GET['id'];
$query="delete from student where id=".$delete_id;
$sqlquery=mysqli_query($con,$query);

if($sqlquery){
	echo "<script>alert('Delete sucessfully !'); window.location.href='index.php'; </script>";
}
else{
	echo "<script>alert('Error !'); window.location.href='index.php'; </script>";
}
?>