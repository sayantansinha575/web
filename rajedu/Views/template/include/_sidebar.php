    <div class="main-menu menu-fixed menu-light menu-accordion    menu-shadow " data-scroll-to-active="true" data-img="<?= ADMIN_ASSETS ?>images/backgrounds/02.jpg">
      <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
          <li class="nav-item mr-auto"><a class="navbar-brand" href="index.html"><img class="brand-logo" alt="Chameleon admin logo" src="<?= ADMIN_ASSETS ?>images/logo/logo.png"/>
              <h3 class="brand-text">Rajedu</h3></a></li>
          <li class="nav-item d-md-none"><a class="nav-link close-navbar"><i class="ft-x"></i></a></li>
        </ul>
      </div>
      <div class="navigation-background"></div>
      <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">


          <li class="nav-item"><a href="<?= site_url('dashboard') ?>"><i class="ft-home"></i><span class="menu-title" data-i18n=""> Dashboard</span></a></li>
          <li class="nav-item"><a href="<?= site_url('search-student') ?>"><i class="ft-plus"></i><span class="menu-title" data-i18n=""> New Application</span></a></li>


         
          <li class=" nav-item"><a href="#"><i class="ft-layers"></i><span class="menu-title" data-i18n="">User Management</span></a>
            <ul class="menu-content">
              <li><a class="menu-item" href="<?= site_url('auth/groups-and-permissions') ?>">Groups & Permissions</a></li>
            </ul>
          </li>

         
          <li class=" nav-item"><a href="#"><i class="ft-layers"></i><span class="menu-title" data-i18n="">Master Forms</span></a>
            <ul class="menu-content">
              <li><a class="menu-item" href="<?= site_url('master/type-of-degree') ?>">Type of Degree</a></li>
              <li><a class="menu-item" href="<?= site_url('master/university-programs') ?>">University Programs</a></li>
              <li><a class="menu-item" href="<?= site_url('master/search-tags') ?>">Search Tags</a></li>
              <li><a class="menu-item" href="<?= site_url('master/intake') ?>">Intake</a></li>
              <li><a class="menu-item" href="<?= site_url('master/status') ?>">Status</a></li>
              <li><a class="menu-item" href="<?= site_url('master/type-of-exam') ?>">Type of Exam</a></li>
              <li><a class="menu-item" href="<?= site_url('master/test-type') ?>">Test Type</a></li>
              <li><a class="menu-item" href="<?= site_url('master/document-type') ?>">Document Type</a></li>
              <li><a class="menu-item" href="<?= site_url('master/cost-type') ?>">Cost Type</a></li>
              <li><a class="menu-item" href="<?= site_url('master/fee-type') ?>">Fee Type</a></li>
              <li><a class="menu-item" href="<?= site_url('master/currency') ?>">Currency</a></li>
            </ul>
          </li>

         
          <li class=" nav-item"><a href="#"><i class="ft-layers"></i><span class="menu-title" data-i18n="">Associate Profile</span></a>
            <ul class="menu-content">
              <li><a class="menu-item" href="<?= site_url('associate/list') ?>">Associates</a></li>
            </ul>
          </li>

         
          <li class=" nav-item"><a href="#"><i class="ft-layers"></i><span class="menu-title" data-i18n="">Universities</span></a>
            <ul class="menu-content">
              <li><a class="menu-item" href="<?= site_url('university/list') ?>">List</a></li>
            </ul>
          </li>

           <li class=" nav-item"><a href="#"><i class="ft-layers"></i><span class="menu-title" data-i18n="">Students </span></a>
            <ul class="menu-content">
              <li><a class="menu-item" href="<?= site_url('student/lists') ?>">list</a></li>
            </ul>
          </li>


        </ul>
      </div>
    </div>