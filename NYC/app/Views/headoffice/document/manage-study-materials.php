
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
                        <li class="breadcrumb-item active">Study Materials</li>
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
                        <div class="col-md-10 col-lg-10 cm-sm-10 col-xl-10">
                            <form class="row gy-2 gx-2 align-items-center justify-content-xl-start justify-content-between">
                                <div class="col-auto">
                                    <input type="search" class="form-control" id="studyMatsKeyword" name="keyword" placeholder="Search...">
                                </div>
                            </form>                            
                        </div>
                        <div class="col-md-2 col-lg-2 cm-sm-2 col-xl-2 text-end">
                            <a class="btn btn-dark btn-sm" href="<?= site_url('head-office/document/add-study-material') ?>"><i class="fa-solid fa-plus"></i> Add</a>
                        </div>
                    </div>
                  
                   
                    <br>
                    <table id="dtStudyMats" class="table table-centered table-striped dt-responsive nowrap w-100 shadow-lg">
                        <thead>
                            <tr>
                                <th scope="col" width="1%">#</th>
                                <th scope="col">Course Name</th>
                                <th scope="col">Course Type</th>
                                <th scope="col" width="1%" class="text-center">Action</th>
                            </tr>
                        </thead>
                    </table>
                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>
</div>
<script src="<?= site_url('public/headoffice/js/ajax-datatable.js?v=').filemtime($_SERVER['DOCUMENT_ROOT'].'/public/headoffice/js/ajax-datatable.js') ?>"></script>
<?= $this->endSection() ?>
