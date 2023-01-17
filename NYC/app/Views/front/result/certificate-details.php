<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<title>National Youth Computer Training Academy</title>
<link rel="icon" href="favicon.ico" type="image/x-icon">
<link rel="stylesheet" href="<?= site_url('public/front/plugins/bootstrap/css/bootstrap.min.css') ?>">
<link rel="stylesheet" href="<?= site_url('public/front/icon?family=Material+Icons') ?>">
<link rel="stylesheet" href="<?= site_url('public/front/css/main.css') ?>">
<link href="<?= site_url('public/front/css/login.css') ?>" rel="stylesheet">

<link rel="stylesheet" href="<?= site_url('public/front/css/themes/all-themes.css') ?>">
</head>
<body class="login-page authentication">
<div class="container" id="print_certificate">
    <div class="card">
        <img src="/public/front/images/NYCTA-Header.png" style="width:100%;" class="certificate-header-section">

        <div class="row">
            <div class="col-sm-12">
                <h4 class="title-heading">On-line Certificate Verification</h4>
            </div>
        </div>
<?php if(!empty($details)){ ?>
        <div class="row">
            <div class="col-sm-12">
                <table class="table custom-table">
                    <tr>
                        <td class="text-center" colspan="2">
                            <?php if (!empty($details['image'])): ?>
                                <img src="data:image/png;base64,<?= base64_encode($details['image']) ?>" alt="" class="img-thumbnail">
                            <?php else: ?>
                                <img src="<?= site_url('public/upload/branch-files/student/student-image/').$details['dp'] ?>" alt="" class="img-thumbnail">
                            <?php endif ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Student Name</th>
                        <td><?php echo $details['candidate_name']; ?></td>
                    </tr>
                    <tr><th>Father's Name</th><td><?php echo $details['father_name']; ?></td></tr>
                    <tr><th>Certificate No.</th><td><?php echo $details['certificate_no']; ?></td></tr>
                    <tr><th>Course Name </th><td><?php echo $details['course_name']; ?></td></tr>
                </table>
            </div>
        </div>
    <?php }else{?>
            <div class="alert alert-danger" style="text-align:center;" role="alert">
     Student not found in our database.Please check your input. 
     <div>
     <button type="button" class="btn btn-warning"><a href="https://branch.nycta.in/result">Back to Search</a></button></div>
   </div>
    <?php } ?>
        <?php if(!empty($m_details)){ ?>
        <div class="row">
            <div class="col-sm-12">
                <table class="table custom-table table-2">
                    <tr>
                        <th>Total Marks</th>
                        <td><?php echo $m_details['total_marks']; ?></td>
                        <th>Marks Obtained</th>
                        <td><?php echo $m_details['total_marks_obtained']; ?></td>
                    </tr>
                     <tr>
                        <th>Percentage</th>
                        <td><?php echo $m_details['overall_percentage']; ?><?= strpos($m_details['overall_percentage'], '%')?'':'%' ?></td>
                        <th>Grade</th>
                        <td><?php echo $m_details['overall_grade']; ?></td>
                    </tr>
                </table>
            </div>
        </div>
    <?php } ?>
    <?php if (!empty($details)): ?>
       <div class="print">
           <button type="button"class="btn btn-raised g-bg-blush2 waves-effect" onclick="printDiv('print_certificate')">Print Your Details</button>
           <button type="button" class="btn btn-warning"><a href="https://branch.nycta.in/result">Back to Search</a></button>
       </div>
    <?php endif ?>
    </div>  
</div>

<script src="<?= site_url('public/front/css/bundles/libscripts.bundle.js') ?>"></script> <!-- Lib Scripts Plugin Js -->
<script src="<?= site_url('public/front/css/bundles/vendorscripts.bundle.js') ?>"></script> <!-- Lib Scripts Plugin Js -->
<script src="<?= site_url('public/front/css/bundles/mainscripts.bundle.js') ?>"></script><!-- Custom Js --> 
</body>
</html>


<style>
    .certificate-header-section{width: 100%;padding: 0 30px;}
    .login-page{width: 60%;}
    .container{max-width: 1000px;}
    .login-page{max-width: 100%;}
    .card{padding: 30px 0 40px 0;}
    .title-heading{text-align: center;margin-top: 80px;}
    .custom-table{text-align: end;width: 95%; margin: 0 auto;}
    .print{    text-align: center; margin-top: 20px;}
    .table-2 {
    margin-top: 60px;
    text-align: inherit;
}
</style>
<script>
 
    function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
}
</script>