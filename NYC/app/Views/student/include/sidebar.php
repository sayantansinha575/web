<?php 
$student_details = '';
$student_details =  fieldValue('student','student_photo', array('id'=>$this->session->studData['id'])); 
?>
<section> 
    <!-- Left Sidebar -->
    <aside id="leftsidebar" class="sidebar"> 
        <!-- User Info -->
        <div class="user-info">
            <?php if(strlen($student_details) > 0){?>
            <div class="admin-image"> <img src="<?= site_url('public/upload/branch-files/student/student-image/').$student_details; ?>" alt=""> </div>
        <?php }else{?>
            <div class="admin-image"> <img src="<?= site_url('public/upload/branch-files/student/student-image/student-no-image.png');?>" alt=""> </div>
        <?php } ?>

            <div class="admin-action-info"> <span>Welcome</span>
                <h3><?= $this->session->studData['studentName'] ?></h3>
            </div>
        </div>
        <!-- #User Info --> 
        <!-- Menu -->
        <div class="menu">
            <ul class="list" id="sidebar">
                <li class="header">MAIN MENU</li>

                <li><a href="<?= site_url('student/dashboard') ?>"><i class="zmdi zmdi-home"></i><span>Dashboard</span></a></li>
                <li><a href="<?= site_url('student/admission') ?>"><i class="zmdi zmdi-account"></i><span>Admission</span></a></li>
                <li><a href="<?= site_url('student/payment') ?>"><i class="zmdi zmdi-paypal"></i><span>Payments</span></a></li>
                <li><a href="<?= site_url('student/profile') ?>"><i class="zmdi zmdi-account"></i><span>Profile</span></a></li>
                <li><a href="<?= site_url('student/download') ?>"><i class="zmdi zmdi-download"></i><span>Download</span></a></li>
                <li><a href="<?= site_url('student/admission/study-materials') ?>"><i class="zmdi zmdi-book"></i><span>Study Materials</span></a></li>
                 <li><a title="upload-cv" href="javascript:void(0)" data-toggle="modal"   data-target="#modal-master-type-of-degree" class="upload-cv"><i class="zmdi zmdi-book"></i><span>Upload CV</span></a></li>

                <li><a title="Change Password" href="javascript:void(0)" class="change-password" data-pwd="<?= encrypt($this->session->studData['id']) ?>"><i class="zmdi zmdi-lock-open"></i><span>Password</span></a></li>
                <li><a href="<?= site_url('student-signout') ?>" ><i class="zmdi zmdi-sign-in"></i><span>Log out</span></a></li>
           
              
            </ul>
        </div>
        <!-- #Menu -->
    </aside>
    
</section>
<div class="modal fade text-left" id="modal-master-type-of-degree" data-backdrop="false" tabindex="-1" role="dialog" aria-labelledby="master-type-of-degree-label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="master-type-of-degree-label"> Upload CV</h3>
            </div>
            <form action="" id="form-cv"  enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group floating-label-form-group">
                        <label for="degree_type" class="form-label">Upload CV <span class="text-danger">*</span></label>
                        <input type="file" class="form-control" id="file" name="file" placeholder="">
                        
                    </div>
                   
                    <div class="form-group">
                        <div id="form-feedback" class="error-feedback"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <?= csrf_field(); ?>
                  
                    <button type="button" data-dismiss="modal" class="btn btn-raised bg-blue-grey waves-effect mr-2">Close</button>
                    <button type="submit" name="submit"  class="btn bg-black waves-effect waves-light">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script type="text/javascript">
    // Handle form
         $(function(){
                $("#form-cv").on('submit', function(e){
                    e.preventDefault();
                    $.ajax({
                        type: 'POST',
                        url: '<?= site_url('student/cv/save-cv')?>',
                        data: new FormData(this),
                        dataType: 'json',
                        contentType: false,
                        cache: false,
                        processData:false,
                      
                        success: function(response){

                            $('#modal-master-type-of-degree').modal('hide');
                         
                
                          
                        }
                    });
                });
            });
   
</script>