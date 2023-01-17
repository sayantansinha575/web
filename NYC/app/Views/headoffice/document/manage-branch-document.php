
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
                        <li class="breadcrumb-item active">Branch Documents</li>
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
                        <div class="col-md-2 col-lg-2 cm-sm-2 col-xl-2">
                            <a class="btn btn-dark btn-sm" href="<?= site_url('head-office/document/add-branch-document') ?>"><i class="fa-solid fa-plus"></i> Add</a>
                        </div>
                    </div>
                  
                   
                    <br>
                    <table id="dtBranchDocs" class="table table-centered table-striped dt-responsive nowrap w-100 shadow-lg">
                        <thead>
                            <tr>
                                <th scope="col" width="1%">#</th>
                                <th scope="col">Title</th>
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
