<?= $this->extend($config->viewLayout) ?>
<?= $this->section('content') ?>


 <div class="app-content content">
      <div class="content-wrapper">
        <div class="content-wrapper-before"></div>
        <div class="content-header row">
        </div>
        <div class="content-body"><div id="user-profile">
  <div class="row">
    <div class="col-sm-12 col-xl-8">
      <div class="media d-flex m-1 ">
        <div class="align-left p-1">
          <a href="#" class="profile-image">
            <img src="<?= ADMIN_ASSETS ?>images/portrait/small/avatar-s-1.png" class="rounded-circle img-border height-100" alt="Card image">
          </a>
        </div>
        <div class="media-body text-left  mt-1">
          <h3 class="font-large-1 white">Thomas Cruise IV
            <span class="font-medium-1 white">(Project manager)</span>
          </h3>
          <p class="white">
            <i class="ft-map-pin white"> </i> New York, USA </p>
          <p class="white text-bold-300 d-none d-sm-block">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc sed odio risus. Integer sit amet dolor elit. Suspendisse
            ac neque in lacus venenatis convallis. Sed eu lacus odio</p>
          <ul class="list-inline">
            <li class="pr-1 line-height-1">
              <a href="#" class="font-medium-4 white ">
                <span class="ft-facebook"></span>
              </a>
            </li>
            <li class="pr-1 line-height-1">
              <a href="#" class="font-medium-4 white ">
                <span class="ft-twitter white"></span>
              </a>
            </li>
            <li class="line-height-1">
              <a href="#" class="font-medium-4 white ">
                <span class="ft-instagram"></span>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-xl-3 col-lg-5 col-md-12">


         <div class="card application-steps">
        <div class="card-header pb-0">
          <div class="card-title-wrap bar-primary">
            <div class="card-title">Application Steps</div>
            <hr>
          </div>
        </div>
        <div class="card-content">
          <div class="card-body p-0 pt-0 pb-1">
           <ul class="list-unstyled base-timeline activity-timeline">

                  <li><a href="/new-application">
                    <div class="base-timeline-info">
                      <div class="btn btn-primary">Profile</div>
                    </div></a>
                  </li>
                  <li><a href="">
                    <div class="base-timeline-info">
                      <div class="btn btn-outline-primary toast-toggler">Applications</div>
                    </div></a>
                  </li>
                  <li><a href="">
                    <div class="base-timeline-info">
                      <div class="btn btn-outline-primary toast-toggler">Documents</div>
                    </div></a>
                  </li>
                  <li><a href="">
                    <div class="base-timeline-info">
                      <div class="btn btn-outline-primary toast-toggler">Payments</div>
                    </div></a>
                  </li>
                </ul>
          </div>
        </div>

      </div>


      <div class="card">
        <div class="card-header pb-0">
          <div class="card-title-wrap bar-primary">
            <div class="card-title">Personal Information</div>
            <hr>
          </div>
        </div>
        <div class="card-content">
          <div class="card-body p-0 pt-0 pb-1">
           <ul class="list-unstyled base-timeline activity-timeline" style="margin-left: 24px;">

                  <li>
                    <div class="timeline-icon bg-primary">
                      <i class="ft-monitor font-medium-1"></i>
                    </div>
                    
                    <div class="base-timeline-info">
                      <a href="<?php echo base_url(); ?>/new-application" class="text-primary line-height-2">Information</a>
                      
                    </div>
                    
                    
                  </li><li>
                    <div class="timeline-icon bg-info">
                      <i class="ft-feather font-medium-1"></i>
                    </div>
                    
                    <div class="base-timeline-info">
                      <a href="<?php echo base_url(); ?>/new-application/mailing-address" class="text-info  line-height-2">Mailing Address</a>
                      
                    </div>
                    
                    
                  </li><li>
                    <div class="timeline-icon bg-info">
                      <i class="ft-feather font-medium-1"></i>
                    </div>
                    
                    <div class="base-timeline-info">
                      <a href="<?php echo base_url(); ?>/new-application/permanent-address" class="text-info  line-height-2">Permanent Address</a>
                      
                    </div>
                    
                    
                  </li><li>
                    <div class="timeline-icon bg-info">
                      <i class="ft-feather font-medium-1"></i>
                    </div>
                    
                    <div class="base-timeline-info">
                      <a href="<?php echo base_url(); ?>/new-application/passport-information" class="text-info  line-height-2">Passport Information</a>
                      
                    </div>
                    
                    
                  </li><li>
                    <div class="timeline-icon bg-info">
                      <i class="ft-feather font-medium-1"></i>
                    </div>
                    
                    <div class="base-timeline-info">
                      <a href="<?php echo base_url(); ?>/new-application/nationality" class="text-info line-height-2">Nationality</a>
                      
                    </div>
                    
                    
                  </li><li>
                    <div class="timeline-icon bg-info">
                      <i class="ft-feather font-medium-1"></i>
                    </div>
                    
                    <div class="base-timeline-info">
                      <a href="<?php echo base_url(); ?>/new-application/background-info" class="text-info  line-height-2">Background Info</a>
                      
                    </div>
                    
                    
                  </li><li>
                    <div class="timeline-icon bg-info">
                      <i class="ft-feather font-medium-1"></i>
                    </div>
                    
                    <div class="base-timeline-info">
                      <a href="<?php echo base_url(); ?>/new-application/alternate-contact" class="text-info   line-height-2">Alternate Contact</a>
                      
                    </div>
                    
                    
                  </li>
                </ul>
          </div>
        </div>

      </div>
      <div class="card">
        <div class="card-header pb-0">
          <div class="card-title-wrap bar-primary">
            <div class="card-title">Academic Qualification</div>
            <hr>
          </div>
        </div>
        <div class="card-content">
          <div class="card-body p-0 pt-0 pb-1">
           <ul class="list-unstyled base-timeline activity-timeline" style="margin-left: 24px;">

                  <li>
                    <div class="timeline-icon bg-primary">
                      <i class="ft-monitor font-medium-1"></i>
                    </div>
                    
                    <div class="base-timeline-info">
                      <a href="<?php echo base_url(); ?>/new-application/education-summery" class="text-primary line-height-2">Education Summary</a>
                      
                    </div>
                    
                    
                  </li>
                  <li>
                    <div class="timeline-icon bg-info">
                      <i class="ft-feather font-medium-1"></i>
                    </div>
                    
                    <div class="base-timeline-info">
                      <a href="#" class="text-info line-height-2">Undergraduate</a>
                      
                    </div>
                    
                    
                  </li><li>
                    <div class="timeline-icon bg-info">
                      <i class="ft-feather font-medium-1"></i>
                    </div>
                    
                    <div class="base-timeline-info">
                      <a href="#" class="text-info line-height-2">Grade 12th or equivalent</a>
                      
                    </div>
                    
                    
                  </li><li>
                    <div class="timeline-icon bg-info">
                      <i class="ft-feather font-medium-1"></i>
                    </div>
                    
                    <div class="base-timeline-info">
                      <a href="#" class="text-info   line-height-2">Grade 10th or equivalent</a>
                      
                    </div>
                </ul>
          </div>
        </div>

      </div>
       <div class="card">
        <div class="card-header pb-0">
          <div class="card-title-wrap bar-primary">
            <div class="card-title">Work Experience</div>
            <hr>
          </div>
        </div>
        <div class="card-content">
          <div class="card-body p-0 pt-0 pb-1">
           <ul class="list-unstyled base-timeline activity-timeline" style="margin-left: 24px;">

                  <li>
                    <div class="timeline-icon bg-primary">
                      <i class="ft-monitor font-medium-1"></i>
                    </div>
                    <div class="base-timeline-info">
                      <a href="<?php echo base_url(); ?>/new-application/experience-details" class="text-primary line-height-2">Experience Details</a>
                    </div>
                  </li>

                   <li>
                    <div class="timeline-icon bg-primary">
                      <i class="ft-monitor font-medium-1"></i>
                    </div>
                    <div class="base-timeline-info">
                      <a href="#" class="text-primary line-height-2">Junior Developer</a>
                    </div>
                  </li>
                   <li>
                    <div class="timeline-icon bg-primary">
                      <i class="ft-monitor font-medium-1"></i>
                    </div>
                    <div class="base-timeline-info">
                      <a href="#" class="text-primary line-height-2">Senior Developer</a>
                    </div>
                  </li>


                 
                </ul>
          </div>
        </div>

      </div>

       <div class="card">
        <div class="card-header pb-0">
          <div class="card-title-wrap bar-primary">
            <div class="card-title">Tests</div>
            <hr>
          </div>
        </div>
        <div class="card-content">
          <div class="card-body p-0 pt-0 pb-1">
           <ul class="list-unstyled base-timeline activity-timeline" style="margin-left: 24px;">

                  <li>
                    <div class="timeline-icon bg-primary">
                      <i class="ft-monitor font-medium-1"></i>
                    </div>
                    <div class="base-timeline-info">
                      <a href="/new-application/test-score" class="text-primary line-height-2">Test List</a>
                    </div>
                  </li>

                  <li>
                    <div class="timeline-icon bg-primary">
                      <i class="ft-monitor font-medium-1"></i>
                    </div>
                    
                    <div class="base-timeline-info">
                      <a href="#" class="text-primary line-height-2">TOEFL</a>
                      
                    </div>
                    
                    
                  </li>
                 
                </ul>
          </div>
        </div>

      </div>

    </div>
    <div class="col-xl-9 col-lg-7 col-md-12">
      <div id="timeline">
      
      </div>
    </div>
  </div>
</div>

        </div>
      </div>
    </div>

<?= $this->section('css') ?>
<?= $this->endSection() ?>
<?= $this->section('js') ?>
<?= script_tag(ADMIN_ASSETS.'js/pages/master/intake.init.js?v='.filemtime('assets/js/pages/master/intake.init.js')) ?>
<?= $this->endSection() ?>
<?= $this->endSection() ?> 