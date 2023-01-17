
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
                        <li class="breadcrumb-item active">Admit</li>
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
                        <div class="col-xl-10">
                            <form class="row gy-2 gx-2 align-items-center justify-content-xl-start justify-content-between">
                                <div class="col-auto">
                                    <input type="search" class="form-control" id="admitKeyword" name="keyword" placeholder="Search...">
                                </div>
                                <div class="col-auto">
                                    <div class="d-flex align-items-center">
                                          <select class="form-select" id="admitBranch">
                                            <option value="0">All</option>
                                            <?php if (!empty($branches)): ?>
                                                <?php foreach ($branches as $branch): ?>
                                                    <option value="<?= $branch->id ?>"><?= $branch->branch_name.' ('.$branch->branch_code.')' ?></option>
                                                <?php endforeach ?>
                                            <?php endif ?>
                                        </select>
                                    </div>
                                </div>
                            </form>                            
                        </div>
                    </div>
                  
                   
                    <br>
                    <table id="dtAdmitList" class="table table-centered table-striped dt-responsive nowrap w-100 shadow-lg">
                        <thead>
                            <tr>
                                <th scope="col" width="1%">#</th>
                                <th scope="col">Student</th>
                                <th scope="col">Branch Code</th>
                                <th scope="col">Exam Name</th>
                                <th scope="col">Date</th>
                                <th scope="col">Time</th>
                                <th scope="col" width="1%" class="text-center">Action</th>
                            </tr>
                        </thead>
                    </table>
                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>
</div>
<script src="<?= site_url('public/headoffice/js/ajax-datatable.js') ?>"></script>
<?= $this->endSection() ?>
