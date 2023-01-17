<?php

include('db.php');
$getupdate= $_GET['id'];
// echo $getupdate;die();
$query="select * from student where id=".$getupdate;
$sqlquery=mysqli_query($con,$query);
$record=mysqli_fetch_array($sqlquery);
$count=mysqli_num_rows($sqlquery);
if($count>0){

}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>update</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
	<div class="container my-4">
		<h1>Update Here</h1>
	</div>
<form action="updateact.php" method="post" onsubmit="">
     <div class="modal-body container my-4">
        <div class="form-group">
    <label for="completename" class="form-label">First Name</label>
    <input type="text" class="form-control" name="fname" value="<?php echo $record[1]; ?>" id="exampleInputEmail1" placeholder="Enter your FirstName" >
  </div>
      
        <div class="form-group">
    <label for="completemail" class="form-label">Last Name</label>
    <input type="text" class="form-control" name="lname" value="<?php echo $record[2]; ?>" id="exampleInputEmail1" placeholder="Enter your LastName" >
  </div>
     
        <div class="form-group">
    <label for="completemobile" class="form-label">DOB</label>
    <input type="date" class="form-control" name="dob" value="<?php echo $record[3]; ?>" id="exampleInputEmail1" placeholder="Enter your Date of Birth" >
<!--   </div>
     <div class="form-check">
      <label class="form-check-label" for="flexCheckDefault">Gender</label>
</br>
  <input class="form-check-input" type="radio" name="gender" value="<?php //echo $record[4]; ?>" <?php //if($record[4]=='Male'){echo 'checked'; } ?>>Male
</br>
  <input class="form-check-input" type="radio" name="gender" value="<?php //echo $record[4]; ?>"<?php //if($record[4]=='Female'){echo 'checked'; }?>>Female 
  
</div>-->
         <div class="form-group">
    <label for="completemobile" class="form-label">Email</label>
    <input type="email" class="form-control" name="email" value="<?php echo $record[5]; ?>"  id="exampleInputEmail1" placeholder="Enter your Email" >
  </div>
         <div class="form-group">
    <label for="completemobile" class="form-label">Phone</label>
    <input type="text" class="form-control" name="phone" value="<?php echo $record[6]; ?>"  id="exampleInputEmail1" placeholder="Enter your phone" >
  </div>
  <input type="text" name="id" value="<?php echo $record[0]; ?>" hidden>
 <br/>
  <input class="btn btn-dark " type="submit" name="sub" value="update" />

      </div>
      
         
       
      
    </div>
  </div>
</div>
 </form>
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>