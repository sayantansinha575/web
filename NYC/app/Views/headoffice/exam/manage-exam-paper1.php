
<?= $this->extend('headoffice/layOut'); ?>
<?= $this->section('body') ?>
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?= site_url('head-office/dashboard') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">Course List</li>
                    </ol>
                </div>
                <h4 class="page-title"><?= $title; ?></h4>
                
            </div>
        </div>
    </div>
    <!-- end page title -->

<form action="<?= site_url('head-office/exam/save-exam') ?>"  id="formExamDetails">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-7">
                          <select  name="course_id" class="form-control select-course">
                            <option value="">Select Course</option>
                             <?php if (!empty($courses)): $i =1;?>
                                <?php foreach ($courses as $course): ?>
                              

                              <option <?= (empty($course_id) ? '' : (($course_id) == $course['id'] ? 'selected' : '')) ?> value="<?= $course['id'] ?>"><?= $course['course_name'] ?></option>

                               <?php endforeach ?>
                            <?php endif ?>
                          </select>
                        </div>
                    </div>
                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>
    <?php if($course_id){?>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Exam Paper Details</h4>
                    <hr>
                    <div class="row">
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Paper Name: <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" value="<?= empty($details) ? '' : $details->paper_name; ?>" name="paper_name" id="paper_name" placeholder="Enter Paper Name" value="">
                        
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Total Number of Questions: <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" name="total_question" id="total_question" placeholder="Enter Total Question" value="<?= empty($details) ? '' : $details->total_question; ?>">
                        
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Total Marks: <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" name="mark_each_question" id="mark_each_question" placeholder="Enter Total Marks" value="<?= empty($details) ? '' : $details->mark_each_question; ?>">
                       
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Time: <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" name="total_time" id="total_time" placeholder="Enter time in minute" value="<?= empty($details) ? '' : $details->total_time; ?>">
                        
                    </div>
                    </div>
                </div> <!-- end card body-->
                <?= csrf_field(); ?>
                <div class="card-footer">
                        <div class="row">
                            <div class="col-md-12 text-end">
                               
                                 <input type="hidden" name="id"   value="<?= empty($details) ? '' : $details->id; ?>">                           
                               <button type="submit" class="btn btn-primary btnSaveExamDetails">Save</button>
                            </div>
                        </div>
                    </div>
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>
<?php } ?>
</form>
</div>
 <?php if($course_id){?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                      <table  id="examList" class="table table-centered table-striped dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th width="1%">#</th>
                                <th>Paper name</th>
                                <th>Total Question</th>
                                <th>Mark/Question</th>
                                <th>Time</th>
                                <th>Status</th>
                                <th width="1%" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (! empty($examList)): ?>
                                <?php foreach ($examList as $record): ?>        
                                    <tr>
                                        <td><?= $record->id ?></td>
                                        <td><?= $record->paper_name?></td>
                                        <td><?= $record->total_question?></td>
                                        <td><?= $record->mark_each_question ?></td>
                                        <td><?= $record->total_time ?></td>
                                        <td><?php if ($record->status == 1): ?>
                                                <a href="javascript:void(0)" data-toggle="tooltip" title="Click to inactive" class="changePaperStatus" data-id="<?= $record->id ?>" data-val="2"><span class="badge badge-success-lighten">Active</span></a>
                                            <?php else: ?>
                                                <a href="javascript:void(0)" data-toggle="tooltip" title="Click to Active" class="changePaperStatus" data-id="<?= $record->id ?>" data-val="1"><span class="badge badge-danger-lighten">Inactive</span></a>
                                            <?php endif ?></td>
          
                                        <td class="d-flex">
                                            <a href="<?= site_url('head-office/exam/'.$course_id.'/'.$record->id)?>" class="btn btn-dark btn-sm btn-icon" data-toggle="tooltip" title="Details"><i class="fa-solid fa-edit"></i></a>

                                            <a data-id="<?=$record->id;?>" href="javascript:void(0)" class="btn btn-danger btn-sm btn-icon deletePaper" data-toggle="tooltip" title="Details"><i class="fa-solid fa-trash"></i></a></td>

                                    </tr>
                                <?php endforeach ?> 
                            <?php endif ?>
                        </tbody>                       
                    </table>
                    </div>
                </div>
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>
<?php } ?>
<script type="text/javascript">
$('.select-course').change(function(){
    let id = $(this).val();
    window.location.href='/head-office/exam/'+id;
});


</script>





<?= $this->endSection() ?>
