
<?= $this->extend('student/layOut'); ?>
<?= $this->section('body') ?>

<section class="content">
   <div class="container-fluid">
      <div class="block-header">
         <h2><?= $title; ?></h2>
      </div>
      <div class="row clearfix" style="display:none;">
         <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">
               <div class="body">
                  <div class="row">
                     <div class="col-md-3">
                        <div class="form-group form-float form-group-sm">
                           <div class="form-line">
                              <input type="text" class="form-control" id="studPayKeyword">
                              <label class="form-label">KeyWord</label>
                           </div>
                        </div>
                     </div>
                     <div class="col-md-3">
                        <div class="form-group form-float form-group-sm">
                              <select class="form-control show-tick select2NoSearch" id="studPayEnroll">
                                 <option value=""></option>
                                <?php if (!empty($admissions)): ?>
                                   <?php foreach ($admissions as $val): ?>
                                      <option value="<?= $val->AdmissionId ?>"><?= $val->enrollment_number; ?></option>
                                   <?php endforeach ?>
                                <?php endif ?>
                              </select>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>

      <div class="row clearfix">
         <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">
               <div class="body table-responsive">
                  <table id="dtStudPayment" class="table table-bordered table-striped">
                     <thead>
                        <tr>
                           <th scope="col" width="1%">#</th>
                           <th scope="col">Invoice No.</th>
                           <th scope="col">Code</th>
                           <th scope="col">Fees</th>
                           <th scope="col">Payment</th>
                           <th scope="col" class="text-center" width="1%">Download</th>
                        </tr>
                     </thead>                            
                  </table>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>

<?= $this->endSection() ?>