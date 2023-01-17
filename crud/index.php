<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>php bootstap</title>
	<!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

	
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New User</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
<!--model body-->
<form action="add.php" method="post" onsubmit="">
     <div class="modal-body">
        <div class="form-group">
    <label for="completename" class="form-label">First Name</label>
    <input type="text" class="form-control" name="fname" id="exampleInputEmail1" placeholder="Enter your FirstName" >
  </div>
      
        <div class="form-group">
    <label for="completemail" class="form-label">Last Name</label>
    <input type="text" class="form-control" name="lname" id="exampleInputEmail1" placeholder="Enter your LastName" >
  </div>
     
        <div class="form-group">
    <label for="completemobile" class="form-label">DOB</label>
    <input type="date" class="form-control" name="dob" id="exampleInputEmail1" placeholder="Enter your Date of Birth" >
  </div>
     <div class="form-check">
      <label class="form-check-label" for="flexCheckDefault">Gender</label>
</br>
  <input class="form-check-input" type="radio" name="gender" value="Male" id="flexCheckDefault">Male
</br>
  <input class="form-check-input" type="radio" name="gender" value="Female" id="flexCheckDefault">Female
  
</div>
         <div class="form-group">
    <label for="completemobile" class="form-label">Email</label>
    <input type="email" class="form-control" name="email" id="exampleInputEmail1" placeholder="Enter your Email" >
  </div>
         <div class="form-group">
    <label for="completemobile" class="form-label">Phone</label>
    <input type="text" class="form-control" name="phone" id="exampleInputEmail1" placeholder="Enter your phone" >
  </div>
      </div>
      <div class="modal-footer">
         <input class="btn btn-dark" type="submit" name="sub" value="Submit" />
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
 </form>

    <div class="container my-3">
		<h1 class="text-center">PHP crud operation</h1>
		<button type="button" class="btn btn-success mt-4"  data-bs-toggle="modal" data-bs-target="#exampleModal">
  add new user
</button>
<a href="login.php"><button type="button" class="btn btn-primary mt-4"  data-bs-target="#login">
  Login
</button></a>
	</div>
 
    
 





<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
include("db.php");
$query="select * from student";
$sqlquery=mysqli_query($con, $query);

?>
<!DOCTYPE html>
<html>

<body>
<table class="table">
  <thead class="table-dark">

    <tr>
      <th>id</th>
      <th>FirstName</th>
      <th>LastName</th>
      <th>DOB</th>
      <th>gender</th>
      <th>email</th>
      <th>phone</th>
      <th colspan="2">Action</th>
  </tr> 
  </thead>  
<tbody>
<?php if(!empty($sqlquery)){ ?>
<?php foreach ($sqlquery as  $value){?>

      <tr>
      <td><?php echo $value['id'] ?></td>
      <td><?php echo $value['firstname'] ?></td>
      <td><?php echo $value['lastname'] ?></td>
      <td><?php echo $value['dob'] ?></td>
      <td><?php echo $value['gender'] ?></td>
      <td><?php echo $value['eml'] ?></td>
      <td><?php echo $value['phone'] ?></td>
      <td><a href="update.php?id=<?php echo $value['id'] ?>"><button class='btn btn-primary'>update</button></a></td>
      <td><a href="delete.php?id=<?php echo $value['id'] ?>"><button class='btn btn-danger'>delete</button></a></td>
      </tr>
<?php } ?>
<?php } ?>


</tbody>
 </table>
</body>
</html>
