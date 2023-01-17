
<?= $this->extend('student/layOut'); ?>
<?= $this->section('body') ?>

<section class="content">
   <div class="container-fluid">
      <div class="block-header">
         <h2>Study Materials <?= ((!empty($count && $count == 1)))?"for ".$materials[0]->course_name.' ('.$materials[0]->short_name.' :: '.$materials[0]->course_code.')':''; ?></h2>
      </div>
      <?php if ($count > 1): ?>         
      <div class="row clearfix">
         <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">
               <div class="body">
                  <form action="<?= site_url('student/admission/study-materials') ?>">
                     <div class="row">
                        <div class="col-md-5">
                           <select class="form-control select2NoSearch" name="matId">
                              <option value=""></option>
                              <?php if (!empty($course)): ?>
                                 <?php foreach ($course as $val): ?>
                                    <option <?= !empty($courseId)?($courseId == $val->course_name)?'selected':'':''; ?> value="<?= encrypt($val->course_name) ?>"><?= $val->courseName.' ('.$val->course_code.')'; ?></option>
                                 <?php endforeach ?>
                              <?php endif ?>
                           </select>
                        </div>
                        <div class="col-md-5">
                           <button type="submit" class="btn  btn-raised bg-blue-grey waves-effect">Search</button>
                           <a class="btn btn-raised bg-grey waves-effect" href="<?= site_url('student/admission/study-materials') ?>">Reset</a>
                        </div>
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
      <?php endif ?>
      
      <div class="row clearfix">
         <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">
               <div class="body">
                  <div class="row clearfix">
                     <div class="col-xs-12 ol-sm-12 col-md-12 col-lg-12">
                        <div class="panel-group" id="accordion_10" role="tablist" aria-multiselectable="true">
                           <?php if (!empty($materials)): ?>
                              <?php foreach ($materials as $mats): 
                                 $documents = unserialize($mats->documents);
                                 $addedBy = $mats->added_by;
                                 $i = 1;
                                 ?>
                                 <div class="panel panel-col-blue-grey">
                                    <div class="panel-heading" role="tab" id="heading<?= $mats->meddiaId; ?>">
                                       <h4 class="panel-title"> <a role="button" data-toggle="collapse" data-parent="#accordion_10" href="#collapse<?= $mats->meddiaId; ?>" aria-expanded="true" aria-controls="collapse<?= $mats->meddiaId; ?>"> <?= $mats->description; ?> </a> </h4>
                                    </div>
                                    <div id="collapse<?= $mats->meddiaId; ?>" class="panel-collapse in collapse show" role="tabpanel" aria-labelledby="heading<?= $mats->meddiaId; ?>" aria-expanded="true" style="">
                                       <div class="panel-body">
                                          <table class="table">
                                             <thead>
                                                <tr>
                                                   <th width="5%">#</th>
                                                   <th width="90%">Document Name</th>
                                                   <th width="5%">Action</th>
                                                </tr>
                                             </thead>
                                             <tbody>
                                                <?php if (!empty($documents)): ?>
                                                   <?php foreach ($documents as $Key => $doc): ?>
                                                      <tr>
                                                         <td><?= $i++ ?></td>
                                                         <td><?= $doc ?></td>
                                                         <td class="text-center">
                                                            <?php if (strtolower($addedBy) == 'branch'): ?>
                                                               <a download href="<?= site_url('public/upload/files/branch/course-documents/'.$mats->course_id.'/'.$mats->branch_id.'/'.$doc) ?>" ><i class="zmdi zmdi-download"></i></a>
                                                             <?php else: ?>  
                                                               <a download href="<?= site_url('public/upload/files/branch/course-documents/'.$mats->course_id.'/'.$doc) ?>" ><i class="zmdi zmdi-download"></i></a>
                                                            <?php endif ?>
                                                         </td>
                                                      </tr>
                                                   <?php endforeach ?>
                                                <?php else: ?>
                                                   <tr>
                                                      <td colspan="3" class="text-center"><span class="text-muted">No Records Found.</span></td>
                                                   </tr>
                                                <?php endif ?>
                                             </tbody>
                                          </table>
                                       </div>
                                    </div>
                                 </div>
                              <?php endforeach ?>
                           </div>
                           <?php else: ?>
                              <div class="row">
                                 <div class="col-md-12 text-center">
                                    <span class="text-muted">
                                       No Records Found.
                                    </span>
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
   </div>
</section>

<?= $this->endSection() ?>