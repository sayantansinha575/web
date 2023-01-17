
<?= $this->extend('student/layOut'); ?>
<?= $this->section('body') ?>
<?php helper('custom'); ?>
<?php  
$fileArr[] = array(
   'name' => 'Qualification Proof',
   'file' => $details->qualification_file,
   'url' => site_url('public/upload/branch-files/student/qualification-file/'.$details->qualification_file),
);
$fileArr[] = array(
   'name' => 'Identity Proof',
   'file' => $details->identity_proof,
   'url' => site_url('public/upload/branch-files/student/identity-proof-file/'.$details->identity_proof),
);
?>
<section class="content profile-page">
   <div class="container-fluid">
      <div class="block-header">
         <h2><?= $title; ?></h2>
      </div>        
      <div class="row clearfix">
         <div class="col-lg-4 col-md-12 col-sm-12">
            <div class="card text-center profile-image">
             

                <?php if(isset($details->student_photo) && strlen($details->student_photo) > 0){?>
                   <img src="<?= site_url('public/upload/branch-files/student/student-image/').$details->student_photo; ?>" alt="">
              <?php }else{?>
                 <img src="<?= site_url('public/upload/branch-files/student/student-image/student-no-image.png');?>" alt="">
              <?php } ?>


            </div>
            <div class="card">
               <div class="header">
                  <h2>Personal Infomation</h2>
               </div>
               <div class="body">
                  <strong>Registration Number</strong>
                  <p><?= $details->registration_number; ?></p>
                  <strong>Name</strong>
                  <p><?= $details->student_name; ?></p>
                  <strong>Mother's Name</strong>
                  <p><?= $details->mother_name; ?></p>
                  <strong>Father's Name</strong>
                  <p><?= $details->father_name; ?></p>
                  <strong>Phone</strong>
                  <p><?= $details->mobile; ?></p>
                  <strong>Gender</strong>
                  <p><?= $details->gender; ?></p>
                  <strong>D.O.B.</strong>
                  <p><?= date('M j, Y', $details->student_dob); ?></p>
                  <hr>
                  <strong>Residential Address</strong>
                  <address><?= $details->residential_address; ?></address>
               </div>
            </div>
         </div>
         <div class="col-lg-8 col-md-12 col-sm-12">
            <div class="card">
               <div class="body"> 
                  <div class="wrap-reset">
                     <div class="mypost-list">
                        <div class="post-box">
                           <h4>Branch Details</h4>
                           <div class="body p-l-0 p-r-0">
                              <div class="table-responsive">
                                 <table class="table dashboard-task-infos">
                                    <tbody>
                                       <tr>
                                          <td width="25%">Branch Name</td>
                                          <td width="1%">:</td>
                                          <td><?= $details->branch_name; ?></td>
                                       </tr>
                                       <tr>
                                          <td width="25%">Branch Code</td>
                                          <td width="1%">:</td>
                                          <td><?= $details->branch_code; ?></td>
                                       </tr>
                                       <tr>
                                          <td width="25%">Branch Email</td>
                                          <td width="1%">:</td>
                                          <td><?= $details->branch_email ?></td>
                                       </tr>
                                       <tr>
                                          <td width="25%">Branch Phone</td>
                                          <td width="1%">:</td>
                                          <td><?= $details->academy_phone ?></td>
                                       </tr>
                                       <tr>
                                          <td width="25%">Branch Address</td>
                                          <td width="1%">:</td>
                                          <td><?= $details->academy_address ?></td>
                                       </tr>
                                    </tbody>
                                 </table>
                              </div>
                           </div>
                        </div>
                        <div class="post-box">
                           <h4> Documents</h4>                                        
                           <div class="body p-l-0 p-r-0">
                              <div class="table-responsive">
                                 <table class="table dashboard-task-infos">
                                    <thead>
                                       <tr>
                                          <th>#</th>
                                          <th>File Name</th>
                                          <th width="10%" class="text-center">Action</th>
                                       </tr>
                                    </thead>
                                    <tbody>
                                       <?php if (!empty($fileArr)): $i = 1; ?>
                                          <?php foreach ($fileArr as $file): 
                                             if (empty($file['file'])) {
                                                continue;
                                             }
                                             ?>
                                             <tr>
                                                <th scope="row"><?= $i++; ?></th>
                                                <td><div class="smalls lg"><?= $file['name'] ?></div></td>
                                                <td class="text-center">
                                                   <a href="<?= $file['url']; ?>" title="Download" download><i class="zmdi zmdi-download"></i></a>
                                                </td>
                                             </tr>
                                          <?php endforeach ?>
                                       <?php endif ?>
                                    </tbody>
                                 </table>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>

<?= $this->endSection() ?>