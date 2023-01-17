
<?= $this->extend('student/layOut'); ?>
<?= $this->section('body') ?>

<section class="content">
   <div class="container-fluid">
      <div class="block-header">
         <h2><?= $title; ?></h2>
      </div>
      <div class="row clearfix">
         <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">
               <div class="body table-responsive">
                  <table class="table table-bordered table-striped nycta-dt dataTable">
                     <thead>
                        <tr>
                           <th scope="col" width="1%">#</th>
                           <th scope="col">Invoice No.</th>
                           <th scope="col">Course Fees</th>
                           <th scope="col">Discount</th>
                           <th scope="col">Amount Paid</th>
                           <th scope="col">Date</th>
                           <th scope="col" class="text-center">Action</th>
                        </tr>
                     </thead>                            
                     <tbody>
                        <?php if (!empty($payments)): $i = 1; ?>
                           <?php foreach ($payments as $pay): ?>
                              <tr>
                                 <td><?= $i++; ?></td>
                                 <td><?= $pay->invoice_no ?></td>
                                 <td class="indianCurrency"><?= number_format($pay->course_fees, 2) ?></td>
                                 <td class="indianCurrency"><?= number_format($pay->discount, 2); ?></td>
                                 <td class="indianCurrency"><?= number_format($pay->amount, 2) ?></td>
                                 <td><?= date('M j, Y', $pay->created_at) ?></td>
                                 <td class="text-center">
                                    <?php if (empty($pay->invoice_file)): ?>
                                       NA
                                    <?php else: ?>
                                       <a href="<?= site_url('public/upload/branch-files/student/invoice/'.$pay->invoice_file.'.pdf'); ?>" download="<?= decrypt($pay->invoice_file).'.pdf' ?>" title="Download Invoice"><i class="zmdi zmdi-download"></i></a>
                                    <?php endif ?>
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