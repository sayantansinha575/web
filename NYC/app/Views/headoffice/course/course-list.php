
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
                <?= csrf_field(); ?>
            </div>
        </div>
    </div>
    <!-- end page title -->


    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-7">
                           <h4 class="header-title"><?= $title.' list'; ?>
                            <span>&nbsp;&nbsp;&nbsp;<a class="btn btn-dark btn-sm" href="<?= site_url('head-office/course/add-course') ?>"><i class="fa-solid fa-plus"></i> Add</a></span>
                            </h4>
                        </div>
                    </div>
                   
                    <br>
                    <table class="basicDatatable table table-centered table-striped dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th width="1%">#</th>
                                <th>Course Name</th>
                                <th>Course Code</th>
                                <th>Course Type</th>
                                <th>Duration</th>
                                <th>Eligiblility</th>
                                <th>Status</th>
                                <th width="1%" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($courses)): $i =1;?>
                                <?php foreach ($courses as $course): ?>
                                    <tr>
                                        <td><?= $i++; ?></td>
                                        <td><?= $course->course_name; ?></td>
                                        <td><?= $course->course_code; ?></td>
                                        <td><?= $course->course_type_name; ?></td>
                                        <td><?= $course->course_duration ?><?= ($course->course_duration > 1)?' Months':' Month'; ?></td>
                                        <td><?= $course->course_eligibility ?></td>
                                        <td>
                                            <?php if ($course->status == 1): ?>
                                                <a href="javascript:void(0)" data-toggle="tooltip" title="Click to inactive" class="changeCourseStatus" data-id="<?= $course->id ?>" data-val="2"><span class="badge badge-success-lighten">Active</span></a>
                                            <?php else: ?>
                                                <a href="javascript:void(0)" data-toggle="tooltip" title="Click to Active" class="changeCourseStatus" data-id="<?= $course->id ?>" data-val="1"><span class="badge badge-danger-lighten">Inactive</span></a>
                                            <?php endif ?>
                                        </td>
                                        <td>
                                            <a href="<?= site_url('head-office/course/edit-course/').$course->id ?>" class="btn btn-dark btn-sm btn-icon" data-toggle="tooltip" title="Edit"><i class="fa-solid fa-pen-to-square"></i></a>
                                            <?php if ($course->has_marksheet == 'Yes'): ?>
                                                <a href="<?= site_url('head-office/course/set-marksheet-fields/').$course->id ?>" class="btn btn-info btn-sm btn-icon" data-toggle="tooltip" title="Set marksheet field"><i class="fa-solid fa-sliders"></i></a>
                                            <?php endif ?>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                            <?php endif ?>
                        </tbody>
                    </table>

                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>
</div>
<script src="<?= site_url('public/headoffice/js/ajax-datatable.js') ?>"></script>
<?= $this->endSection() ?>
