
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
                        <li class="breadcrumb-item active">Payment List</li>
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
                        <div class="col-md-6">
                           <h4 class="header-title"><?= $title.' list'; ?>
                            </h4>
                        </div>
                        <div class="col-md-6 text-end">
                            <div class="input-group mb-3 bind-datatable">
                                <span class="input-group-text">Keyword</span>
                                <input type="text" class="form-control" id="keywordPayment" name="keyword" placeholder="Enter keyword to search">
                                <span class="input-group-text" >Branch</span>
                                <select class="form-select" id="dtBranch">
                                    <option value="0">All</option>
                                    <?php if (!empty($branches)): ?>
                                        <?php foreach ($branches as $branch): ?>
                                            <option value="<?= $branch->id ?>"><?= $branch->branch_name ?></option>
                                        <?php endforeach ?>
                                    <?php endif ?>
                                </select>
                          </div>
                        </div>
                    </div>
                   
                    <br>
                    <table id="dtPaymentList" class="table table-centered table-striped dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th width="1%">#</th>
                                <th>Branch</th>
                                <th scope="col">Student</th>
                                <th scope="col">Invoice</th>
                                <th scope="col">Amount</th>
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
