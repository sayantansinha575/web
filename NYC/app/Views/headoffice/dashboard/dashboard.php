
<?= $this->extend('headoffice/layOut'); ?>
<?= $this->section('body') ?>
<?php helper('custom'); ?>

<!-- Start Content-->
<div class="container-fluid">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                    </ol>
                </div>
                <h4 class="page-title">Dashboard of National Youth Computer Training Academy</h4>
            </div>
        </div>
    </div>     
    <!-- end page title --> 

    <div class="row">
        <div class="col-lg-6 col-xl-3">
            <div class="card dash3">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-10">
                                    <h5 class="text-muted fw-normal mt-0 text-truncate" title="Campaign Sent">Total Students</h5>
                                </div>
                                <div class="col-2 tet-end">
                                    <a href="<?= site_url('head-office/student') ?>" data-toggle="tooltip" target="_blank" title="View List"><i class="fa-solid fa-up-right-from-square"></i></a>
                                </div>
                            </div>
                            
                            <h3 class="my-2 py-1"><?= studentsCount(); ?></h3>
                          
                        </div>
                    </div> <!-- end row-->
                </div> <!-- end card-body -->
            </div> <!-- end card -->
        </div> <!-- end col -->

        <div class="col-lg-6 col-xl-3">
            <div class="card dash2">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-10">
                                    <h5 class="text-muted fw-normal mt-0 text-truncate" title="Campaign Sent">Total Branch</h5>
                                </div>
                                <div class="col-2 tet-end">
                                    <a href="<?= site_url('head-office/branch') ?>" data-toggle="tooltip" target="_blank" title="View List"><i class="fa-solid fa-up-right-from-square"></i></a>
                                </div>
                            </div>
                            
                            <h3 class="my-2 py-1"><?= branchCount(); ?></h3>
                            
                            </p>
                        </div>
                    </div> <!-- end row-->
                </div> <!-- end card-body -->
            </div> <!-- end card -->
        </div> <!-- end col -->

        <div class="col-lg-6 col-xl-3">
            <div class="card dash1">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-10">
                                    <h5 class="text-muted fw-normal mt-0 text-truncate" title="Campaign Sent"> Total Course</h5>
                                </div>
                                <div class="col-2 tet-end">
                                    <a href="<?= site_url('head-office/course') ?>" data-toggle="tooltip" target="_blank" title="View List"><i class="fa-solid fa-up-right-from-square"></i></a>
                                </div>
                            </div>
                            
                            <h3 class="my-2 py-1"><?= courseCountHo(); ?></h3>
                            
                            </p>
                        </div>
                    </div> <!-- end row-->
                </div> <!-- end card-body -->
            </div> <!-- end card -->
        </div> <!-- end col -->

        <div class="col-lg-6 col-xl-3">
            <div class="card dash4">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-10">
                                    <h5 class="text-muted fw-normal mt-0 text-truncate" title="Campaign Sent">Total Enrollment</h5>
                                </div>
                                <div class="col-2 tet-end">
                                    <a href="<?= site_url('head-office/student/manage-admission') ?>" data-toggle="tooltip" target="_blank" title="View List"><i class="fa-solid fa-up-right-from-square"></i></a>
                                </div>
                            </div>
                            <h3 class="my-2 py-1"><?= admissionCount(); ?></h3>
                            
                        </div>
                    </div> <!-- end row-->
                </div> <!-- end card-body -->
            </div> <!-- end card -->
        </div> <!-- end col -->

        <div class="col-lg-6 col-xl-3">
            <div class="card dash1">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-10">
                                    <h5 class="text-muted fw-normal mt-0 text-truncate" title="Campaign Sent">Branch Payment</h5>
                                </div>
                                <div class="col-2 tet-end">
                                    <a href="<?= site_url('head-office/wallet') ?>" data-toggle="tooltip" target="_blank" title="View List"><i class="fa-solid fa-up-right-from-square"></i></a>
                                </div>
                            </div>
                            <h3 class="my-2 py-1"><i class="fa-solid fa-indian-rupee-sign"></i> <?= number_format(branchPayment(), 2); ?></h3>
                           
                        </div>
                    </div> <!-- end row-->
                </div> <!-- end card-body -->
            </div> <!-- end card -->
        </div> <!-- end col -->

        <div class="col-lg-6 col-xl-3">
            <div class="card dash1">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-10">
                                    <h5 class="text-muted fw-normal mt-0 text-truncate" title="Campaign Sent">Student Payment</h5>
                                </div>
                                <div class="col-2 tet-end">
                                    <a href="<?= site_url('head-office/payment') ?>" data-toggle="tooltip" target="_blank" title="View List"><i class="fa-solid fa-up-right-from-square"></i></a>
                                </div>
                            </div>
                            <h3 class="my-2 py-1"><i class="fa-solid fa-indian-rupee-sign"></i> <?= number_format(studentPayment(), 2); ?></h3>
                           
                        </div>
                    </div> <!-- end row-->
                </div> <!-- end card-body -->
            </div> <!-- end card -->
        </div> <!-- end col -->

        <div class="col-lg-6 col-xl-3">
            <div class="card dash2">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-10">
                                    <h5 class="text-muted fw-normal mt-0 text-truncate" title="Campaign Sent">Total Marksheet Issued </h5>
                                </div>
                                <div class="col-2 tet-end">
                                    <a href="<?= site_url('head-office/marksheet') ?>" data-toggle="tooltip" target="_blank" title="View List"><i class="fa-solid fa-up-right-from-square"></i></a>
                                </div>
                            </div>
                            <h3 class="my-2 py-1"><?= marksheetCount(); ?></h3>
                           
                        </div>
                    </div> <!-- end row-->
                </div> <!-- end card-body -->
            </div> <!-- end card -->
        </div> <!-- end col -->

        <div class="col-lg-6 col-xl-3">
            <div class="card dash2">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-10">
                                    <h5 class="text-muted fw-normal mt-0 text-truncate" title="Campaign Sent">Total Certificate Issued</h5>
                                </div>
                                <div class="col-2 tet-end">
                                    <a href="<?= site_url('head-office/certificate') ?>" data-toggle="tooltip" target="_blank" title="View List"><i class="fa-solid fa-up-right-from-square"></i></a>
                                </div>
                            </div>
                            <h3 class="my-2 py-1"><?= certificateCount(); ?></h3>
                           
                        </div>
                    </div> <!-- end row-->
                </div> <!-- end card-body -->
            </div> <!-- end card -->
        </div> <!-- end col -->
    </div>

</div> <!-- container -->

</div> <!-- content -->




       <!--  <script src="<?= site_url() ?>public/headoffice/js/vendor/apexcharts.min.js"></script>

        <script src="<?= site_url() ?>public/headoffice/js/ui/component.todo.js"></script>

        <script src="<?= site_url() ?>public/headoffice/js/pages/dashboard-crm.js"></script> -->
<?= $this->endSection() ?>