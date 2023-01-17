
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
         <small class="text-muted"></small>
      </div>        
      <div class="row clearfix">
         <div class="col-lg-4 col-md-12 col-sm-12">
            <div class="card text-center">
               <img src="<?= site_url('public/upload/branch-files/student/student-image/').$details->student_photo ?>" class="img-fluid" alt="">                              
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
                           <h4>Course Details</h4>
                           <div class="body p-l-0 p-r-0">
                              <div class="table-responsive">
                                 <table class="table dashboard-task-infos">
                                    <tbody>
                                       <tr>
                                          <td width="25%">Course Name</td>
                                          <td width="1%">:</td>
                                          <td><?= $details->courseName; ?></td>
                                       </tr>
                                       <tr>
                                          <td width="25%">Course Code</td>
                                          <td width="1%">:</td>
                                          <td><?= $details->course_code; ?></td>
                                       </tr>
                                       <tr>
                                          <td width="25%">Course Type</td>
                                          <td width="1%">:</td>
                                          <td><?= $details->courseTypeName ?></td>
                                       </tr>
                                       <tr>
                                          <td width="25%">Course Eligibility</td>
                                          <td width="1%">:</td>
                                          <td><?= $details->course_eligibility ?></td>
                                       </tr>
                                       <tr>
                                          <td width="25%">Course Duration</td>
                                          <td width="1%">:</td>
                                          <td><?= $details->course_duration.(($details->course_duration > 1)?'Months':'Month'); ?></td>
                                       </tr>
                                       <tr>
                                          <td width="25%">Date of Admission</td>
                                          <td width="1%">:</td>
                                          <td><?= date('M j, Y', $details->admission_date); ?></td>
                                       </tr>
                                       <tr>
                                          <td width="25%">From Session</td>
                                          <td width="1%">:</td>
                                          <td><?= date('M j, Y', $details->from_session); ?></td>
                                       </tr>
                                       <tr>
                                          <td width="25%">To Session</td>
                                          <td width="1%">:</td>
                                          <td><?= date('M j, Y', $details->to_session); ?></td>
                                       </tr>
                                    </tbody>
                                 </table>
                              </div>
                           </div>
                        </div>
                        <div class="post-box">
                           <h4>Uploaded Documents</h4>                                        
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

                        <?php if ((!empty($details->nycta_icard)) || (!empty($details->marksheet_file && $details->has_marksheet == 'Yes')) || (!empty($details->certificate_file))): ?>
                           <div class="post-box">
                              <h4>Available Documents For Download</h4>                                        
                              <div class="body p-l-0 p-r-0">
                                 <div class="table-responsive">
                                    <table class="table dashboard-task-infos">
                                       <thead>
                                          <tr>
                                             <th scope="col" width="10%">#</th>
                                             <th scope="col">File Name</th>
                                             <th scope="col" width="10%" class="text-center">Action</th>
                                          </tr>
                                       </thead>
                                       <tbody>
                                          <?php $i = 1; ?>
                                          <?php if (!empty($details->nycta_icard)): ?>
                                             <tr>
                                                <td><?= $i++; ?></td>
                                                <td>I-Card</td>
                                                <td class="text-center">
                                                   <a href="<?= site_url('public/upload/branch-files/student/identity-card/'.$details->nycta_icard.'.pdf'); ?>" download="<?= decrypt($details->nycta_icard).'.pdf'; ?>" title="Downloadd"><i class="zmdi zmdi-download"></i></a>
                                                </td>
                                             </tr>
                                          <?php endif ?>
                                          <?php if (!empty($details->marksheet_file && $details->has_marksheet == 'Yes')): ?>
                                             <tr>
                                                <td><?= $i++; ?></td>
                                                <td>Marksheet</td>
                                                <td class="text-center">
                                                   <a href="<?= site_url('public/upload/branch-files/student/marksheet/'.$details->marksheet_file); ?>" title="Downloadd" download><i class="zmdi zmdi-download"></i></a>
                                                </td>
                                             </tr>
                                          <?php endif ?>
                                          <?php if (!empty($details->certificate_file)): ?>
                                             <tr>
                                                <td><?= $i++; ?></td>
                                                <td>Certificate</td>
                                                <td class="text-center">
                                                   <a href="<?= site_url('public/upload/branch-files/student/certificate/'.$details->certificate_file); ?>" title="Downloadd" download><i class="zmdi zmdi-download"></i></a>
                                                </td>
                                             </tr>
                                          <?php endif ?>
                                       </tbody>
                                    </table>
                                 </div>
                              </div>
                           </div>
                        <?php endif ?>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>

<?= $this->endSection() ?>