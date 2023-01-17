
<?= $this->extend('student/layOut'); ?>
<?= $this->section('body') ?>
<?php helper('custom'); ?>
<section class="content home">
   <div class="container-fluid">
      <div class="block-header">
         <div class="d-sm-flex justify-content-between">
            <div>
               <h2>Student Dashboard</h2>
            </div>
           
         </div>
      </div>

      <div class="row clearfix top-report row-deck">
         <div class="col-lg-3 col-sm-6 col-md-6">
            <div class="card">
               <div class="body">
                  <div class="row">
                     <div class="col-md-10">
                        <h5>Enrollment</h5>
                     </div>
                     <div class="col-md-2">
                        <a href="<?= site_url('student/admission') ?>"><i class="zmdi zmdi-link" title="View List"></i></a>
                     </div>
                  </div>
                  <br>
                  <h3 class="text-muted"><?= admissionCount(); ?></h3>
               </div>
            </div>
         </div>

         <div class="col-lg-3 col-sm-6 col-md-6">
            <div class="card">
               <div class="body">
                  <div class="row">
                     <div class="col-md-10">
                        <h5>Marksheet</h5>
                     </div>
                     <div class="col-md-2">
                        <a href="<?= site_url('student/download') ?>"><i class="zmdi zmdi-link" title="View List"></i></a>
                     </div>
                  </div>
                  <br>
                  <h3 class="text-muted"><?= marksheetCountStudPane(); ?></h3>
               </div>
            </div>
         </div>
         
         <div class="col-lg-3 col-sm-6 col-md-6">
            <div class="card">
               <div class="body">
                  <div class="row">
                     <div class="col-md-10">
                        <h5>Certificate</h5> 
                     </div>
                     <div class="col-md-2">
                        <a href="<?= site_url('student/download') ?>"><i class="zmdi zmdi-link" title="View List"></i></a>
                     </div>
                  </div>
                  <br>
                  <h3 class="text-muted"><?= certificateCountStudPane(); ?></h3>
               </div>
            </div>
         </div> 
         
         <div class="col-lg-3 col-sm-6 col-md-6">
            <div class="card">
               <div class="body">
                  <div class="row">
                     <div class="col-md-10">
                        <h5>Admit</h5> 
                     </div>
                     <div class="col-md-2">
                        <a href="<?= site_url('student/download') ?>"><i class="zmdi zmdi-link" title="View List"></i></a>
                     </div>
                  </div>
                  <br>
                  <h3 class="text-muted"><?= admitCountStudPane(); ?></h3>
               </div>
            </div>
         </div>
         
         <div class="col-lg-3 col-sm-6 col-md-6">
            <div class="card">
               <div class="body">
                  <div class="row">
                     <div class="col-md-10">
                        <h5>Amount Paid</h5> 
                     </div>
                     <div class="col-md-2">
                        <a href="<?= site_url('student/payment') ?>"><i class="zmdi zmdi-link" title="View List"></i></a>
                     </div>
                  </div>
                  <br>
                  <h3 class="text-muted"><?= number_format(totalAmountPaidStudPane(), 2); ?></h3>
               </div>
            </div>
         </div>           
      </div>
   </div>
</section>
<?= $this->endSection() ?>