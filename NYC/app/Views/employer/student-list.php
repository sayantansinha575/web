
<?= $this->extend('employer/layOut'); ?>
<?= $this->section('body') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?= site_url('head-office/dashboard') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">Student List</li>
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
                        <div class="col-md-4">
                            <h4 class="header-title"><?= $title.' list'; ?></h4>
                        </div>
                        <div class="col-md-8 text-end">
                            <div class="input-group input-group-sm mb-3 bind-datatable">
                                <span class="input-group-text">Keyword</span>
                                <input type="text" class="form-control" id="keywordStud" name="keyword" placeholder="Enter keyword to search">
                                <span class="input-group-text" >Status</span>
                                <select name="status" class="form-select" id="statusTypeStud">
                                    <option value="0">All</option>
                                    <option value="1">Active</option>
                                    <option value="2">Inactive</option>
                                </select>
                                <span class="input-group-text" >Gender</span>
                                <select name="gender" class="form-select" id="genderStud">
                                    <option value="0">All</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Transgender">Transgender</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <br>
                    <table id="dtStudentList" class="table table-centered table-striped dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th width="1%">#</th>
                                <th>Reg. No.</th>
                                <th>Student Name</th>
                                <th>Gender</th>
                                <th>Mobile</th>
                                <th>Branch</th>
                                <th>Status</th>
                                <th width="1%" class="text-center">Action</th>
                            </tr>
                        </thead>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?= site_url('public/employer/js/ajax-datatable.js') ?>"></script>
<?= $this->endSection() ?>
