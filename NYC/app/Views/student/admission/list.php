
<?= $this->extend('student/layOut'); ?>
<?= $this->section('body') ?>

<section class="content">
   <div class="container-fluid">
      <div class="block-header">
         <h2><?= $title; ?></h2>
      </div>
      <!-- Basic Examples -->
      <div class="row clearfix">
         <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">
               <div class="body table-responsive">
                  <table class="table table-bordered table-striped table-hover nycta-dt dataTable">
                     <thead>
                        <tr>
                           <th scope="col">#</th>
                           <th scope="col">Enroll. No.</th>
                           <th scope="col">Course Type</th>
                           <th scope="col">Course Name</th>
                           <th scope="col">Course Duration</th>
                           <th scope="col">Action</th>
                        </tr>
                     </thead>                            
                     <tbody>
                        <?php if (!empty($lists)): $i = 1; ?>
                           <?php foreach ($lists as $list): ?>
                              <tr>
                                 <td><?= $i++; ?></td>
                                 <td><?= $list->enrollment_number ?></td>
                                 <td><?= $list->courseTypeName ?></td>
                                 <td><?= $list->courseName; ?></td>
                                 <td><?= $list->course_duration.(($list->course_duration > 1)?' Months':'Month'); ?></td>
                                 <td class="text-center">
                                    <a href="<?= site_url('student/admission/details/'.encrypt($list->id)); ?>" class="btn btn-icon btn-raised bg-blue-grey waves-effect" title="View Details"><i class="zmdi zmdi-eye"></i></a>
                                    <a href="<?= site_url('student/admission/payment-list/'.encrypt($list->enrollment_number)); ?>" class="btn btn-icon btn-raised bg-deep-purple waves-effect" title="View Payment List"><i class="zmdi zmdi-money-box"></i></a>
                                    <a href="<?= site_url('student/admission/study-materials/'.encrypt($list->course_name)); ?>" class="btn btn-icon btn-raised bg-grey waves-effect" title="View Study Materials"><i class="zmdi zmdi-file"></i></a>
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
</section>

<?= $this->endSection() ?>