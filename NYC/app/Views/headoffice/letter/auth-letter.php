
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
                       
                        <div class="col-md-6 text-end"><form method="get" action="<?= site_url('head-office/auth-letter') ?>" >
                            <div class="input-group mb-3 bind-datatable">
                               
                                    <input type="text" name="branch_code" id="branch_code" value="<?php echo @($code)?($code):''; ?>" class="form-control" placeholder="Enter branch code here.">
                                    <div class="input-group-append">
                                        <button class="btn btn-dark serach_branch" type="submit">Serach</button>
                                         <?php if($code != ''){?>
                                        <a href="<?= site_url('head-office/generate-authletter?branch_code=').$code; ?>"> <button class="btn btn-dark serach_branch" type="button">New Letter</button></a>
                                    <?php } ?>
                                    </div>
                               
                          </div></form>
                        </div> 

                    </div>
                   
                 

                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>

    <?php if( $code !='' ){?>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
              
                   
                    <br>
                    <table id="dtAuthtList" class="table table-centered table-striped dt-responsive nowrap w-100 shadow-lg">
                        <thead>
                            <tr>
                                <th width="1%">#</th>
                                <th>Branch</th>
                                <th scope="col">Registration Date</th>
                                <th scope="col">Issue Date</th>
                                <th scope="col">Renewal Date</th>
                                <th scope="col">Action</th>
                                
                            </tr>
                        </thead>
                    </table>

                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>

<?php } ?>

</div>
<script src="<?= site_url('public/headoffice/js/ajax-datatable.js') ?>"></script>
<?= $this->endSection() ?>
