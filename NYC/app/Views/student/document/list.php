
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
                           <th scope="col">File Name</th>
                           <th scope="col">Course Code</th>
                           <th scope="col">Enrollment No.</th>
                           <th scope="col" class="text-center">Status</th>
                           <th scope="col" class="text-center">Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php if (!empty($document)): $i = 1; ?>
                           <?php foreach ($document as $doc): ?>
                              <tr>
                                 <td><?= $i++; ?></td>
                                 <td><?= $doc['name']; ?></td>
                                 <td><?= $doc['courseCode']; ?></td>
                                 <td><?= $doc['enrollmentNo']; ?></td>
                                 <td class="text-center"><?= $doc['status'] ?></td>
                                 <td class="text-center">
                                    <?= $doc['fileUrl'] ?>
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