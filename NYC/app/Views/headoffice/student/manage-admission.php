
<?= $this->extend('headoffice/layOut'); ?>
<?= $this->section('body') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?= site_url('head-office/dashboard') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">Admission List</li>
                    </ol>
                </div>
                <h4 class="page-title"><?= $title; ?></h4>
                <?= csrf_field(); ?>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <h4 class="header-title"><?= $title.' list'; ?></h4>
                        </div>
                        <div class="col-md-4 text-end">
                            <div class="input-group input-group-sm mb-3 bind-datatable">
                                <span class="input-group-text">Keyword</span>
                                <input type="text" class="form-control" id="keywordAdmission" name="keyword" placeholder="Enter keyword to search">
                            </div>
                        </div>
                    </div>

                    <br>
                    <table id="dtAdmissionList" class="table table-centered table-striped dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th scope="col" width="1%">#</th>
                                <th scope="col">Branch</th>
                                <th scope="col">Enroll. No.</th>
                                <th scope="col">Student Name</th>
                                <th scope="col">Course Name</th>
                                <th scope="col">Course Code</th>
                                <th scope="col">Course Type</th>
                                <th scope="col">Course Duration</th>
                            </tr>
                        </thead>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?= site_url('public/headoffice/js/ajax-datatable.js') ?>"></script>
<?= $this->endSection() ?>
