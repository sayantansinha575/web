
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
                        <li class="breadcrumb-item active">Wallet List</li>
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
                        <div class="col-md-4">
                           <h4 class="header-title"><?= $title.' list'; ?>
                            <span>&nbsp;&nbsp;&nbsp;<a class="btn btn-dark btn-sm" href="<?= site_url('head-office/wallet/add-transaction') ?>"><i class="fa-solid fa-plus"></i> Add</a></span>
                            </h4>
                        </div>
                        <div class="col-md-3"></div>
                        <div class="col-md-5">
                            <div class="input-group input-group-sm mb-3 bind-datatable">
                                <span class="input-group-text">Keyword</span>
                                <input type="text" class="form-control" id="keywordWallet" name="keyword" placeholder="Enter keyword to search">
                                <span class="input-group-text" >Status</span>
                                <select name="status" class="form-select" id="transTypeWallet">
                                    <option value="0">All</option>
                                    <option value="1">Credited</option>
                                    <option value="2">Debited</option>
                                </select>
                            </div>
                        </div>
                    </div>
                   
                    <br>
                    <table id="dtAjaxWallet" class="table table-centered table-striped dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th width="1%">#</th>
                                <th>Branch Name</th>
                                <th>Purpose</th>
                                <th>Amount</th>
                                <th>Type</th>
                                <th>Date</th>
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
