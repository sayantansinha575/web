
	<div class="dashboard-navbar mobile-sidebar" style="display:none;">
		 <a class="nav-brand" href="<?= site_url('branch/dashboard') ?>">
                            <img src="<?= site_url() ?>public/upload/settings/logo.png" class="logo" alt="NYCTA">
                        </a>
		<div class="d-navigation">
			<ul id="mobile-side-menu">
				<li><a href="<?= site_url('branch/dashboard') ?>"><i class="fas fa-th"></i>Dashboard</a></li>
			
				<li class="dropdown">
					<a href="javascript:void(0);"><i class="fa fa-university" aria-hidden="true"></i>Branch<span class="ti-angle-left"></span></a>
					<ul class="nav nav-second-level ml-4">
						<li><a href="<?= site_url('branch/branch-details') ?>">Branch Details</a></li>
						<!-- <li><a href="<?= site_url('branch/ammend-branch-details') ?>">Modify Branch Details</a></li> -->
					</ul>
				</li>
			
				<li class="dropdown">
					<a href="javascript:void(0);"><i class="fa-solid fa-server"></i>Course<span class="ti-angle-left"></span></a>
					<ul class="nav nav-second-level ml-4">
						<li><a href="<?= site_url('branch/course/manage-course') ?>">Manage Course</a></li>
						<li><a href="<?= site_url('branch/document/add-study-materials') ?>">Add Study Materials</a></li>
						<li><a href="<?= site_url('branch/document/manage-study-materials') ?>">Manage Study Materials</a></li>
					</ul>
				</li>

				<li class="dropdown">
					<a href="javascript:void(0);"><i class="fa-solid fa-user-graduate"></i>Students<span class="ti-angle-left"></span></a>
					<ul class="nav nav-second-level ml-4">
						<li><a href="<?= site_url('branch/student/registration') ?>">New Registration</a></li>
						<li><a href="<?= site_url('branch/student') ?>">Manage Student</a></li>
					</ul>
				</li>
				<li class="dropdown">
					<a href="javascript:void(0);"><i class="fas fa-file-signature"></i></i>Manage Admission<span class="ti-angle-left"></span></a>
					<ul class="nav nav-second-level ml-4">
						<li><a href="<?= site_url('branch/student/new-admission') ?>">New Admission</a></li>
						<li><a href="<?= site_url('branch/student/manage-admission') ?>">All Admissions</a></li>
					</ul>
				</li>
				<li class="dropdown">
					<a href="javascript:void(0);"><i class="fa-solid fa-money-check-dollar"></i>Payment<span class="ti-angle-left"></span></a>
					<ul class="nav nav-second-level ml-4">
						<li><a href="<?= site_url('branch/payment/new-payment') ?>">New Payment</a></li>
						<li><a href="<?= site_url('branch/payment') ?>">Manage Payment</a></li>
					</ul>
				</li>



				<li class="dropdown">
					<a href="javascript:void(0);"><i class="fas fa-address-card"></i>Admit<span class="ti-angle-left"></span></a>
					<ul class="nav nav-second-level ml-4">
						<li><a href="<?= site_url('branch/admit/new-admit-card') ?>">New Admit</a></li>
						<li><a href="<?= site_url('branch/admit') ?>">Manage Admit</a></li>
					</ul>
				</li>

				<li class="dropdown">
					<a href="javascript:void(0);"><i class="fas fa-chalkboard-teacher"></i></i>Marksheet<span class="ti-angle-left"></span></a>
					<ul class="nav nav-second-level ml-4">
						<li><a href="<?= site_url('branch/marksheet/apply-new-marksheet') ?>">Apply Marksheet</a></li>
						<li><a href="<?= site_url('branch/marksheet') ?>">Manage Marksheets</a></li>
					</ul>
				</li>

				<li class="dropdown">
					<a href="javascript:void(0);"><i class="fa-solid fa-list-check"></i>Certificate<span class="ti-angle-left"></span></a>
					<ul class="nav nav-second-level ml-4">
						<li><a href="<?= site_url('branch/certificate/apply-new-certificate') ?>">Apply Certificate</a></li>
						<li><a href="<?= site_url('branch/certificate') ?>">Manage Certificate</a></li>
					</ul>
				</li>

				<li><a href="<?= site_url('branch/document/docs-from-head-office') ?>"><?= (site_url('branch/document/docs-from-head-office') == current_url())?'<i class="far fa-folder-open"></i>':'<i class="far fa-folder"></i>'; ?> HO Documents</a></li>


			</ul>
		</div>
	</div>
