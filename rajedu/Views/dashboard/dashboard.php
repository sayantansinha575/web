<?= $this->extend($config->viewLayout) ?>
<?= $this->section('content') ?>
<div class="app-content content">
	<div class="content-wrapper">
		<div class="content-wrapper-before"></div>
		<div class="content-header row"></div>
		<div class="content-body">
			<div class="row">
				<div class="col-lg-8 col-md-12">
					<div class="card">
						<div class="card-header">
							<h4 class="card-title">Project Revenue</h4>
							<a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
							<div class="heading-elements">
								<ul class="list-inline mb-0">
									<li><button type="button" class="btn btn-glow btn-round btn-bg-gradient-x-red-pink">More</button></li>
								</ul>
							</div>
						</div>
						<div class="card-content collapse show">
							<div class="card-body p-0 pb-0">
								<div class="chartist">
									<div id="project-stats" class="height-350 areaGradientShadow1"></div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-4 col-md-12">
					<div class="row">
						<div class="col-12">
							<div class="card pull-up">
								<div class="card-header">
									<h4 class="card-title float-left">Project X</h4><a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
									<span class="badge badge-pill badge-info float-right m-0">In Progress</span>
								</div>
								<div class="card-content collapse show">
									<div class="card-body pt-0 pb-1">
										<h6 class="text-muted font-small-3"> Completed Task : 4/10</h6>
										<div class="progress progress-sm mt-1 mb-0 box-shadow-2">
											<div class="progress-bar bg-gradient-x-info" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
										</div>
										<div class="media d-flex">
											<div class="align-self-center">
												<h6 class="text-bold-600 mt-2"> Client: <span class="info">Xeon Inc.</span></h6>
												<h6 class="text-bold-600 mt-1"> Deadline: <span class="blue-grey">5th June, 2018</span></h6>
											</div>
											<div class="media-body text-right mt-2">
												<ul class="list-unstyled users-list">
													<li data-toggle="tooltip" data-popup="tooltip-custom" data-original-title="John Doe" class="avatar avatar-sm pull-up">
														<img class="media-object rounded-circle" src="<?= ADMIN_ASSETS ?>images/portrait/small/avatar-s-19.png" alt="Avatar">
													</li>
													<li data-toggle="tooltip" data-popup="tooltip-custom" data-original-title="Katherine Nichols" class="avatar avatar-sm pull-up">
														<img class="media-object rounded-circle" src="<?= ADMIN_ASSETS ?>images/portrait/small/avatar-s-18.png" alt="Avatar">
													</li>
													<li data-toggle="tooltip" data-popup="tooltip-custom" data-original-title="Joseph Weaver" class="avatar avatar-sm pull-up">
														<img class="media-object rounded-circle" src="<?= ADMIN_ASSETS ?>images/portrait/small/avatar-s-17.png" alt="Avatar">
													</li>
												</ul>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-12">
							<div class="card pull-up bg-gradient-directional-danger">
								<div class="card-header bg-hexagons-danger">
									<h4 class="card-title white">Analytics</h4>
									<a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
									<div class="heading-elements">
										<ul class="list-inline mb-0">
											<li>
												<a class="btn btn-sm btn-white danger box-shadow-1 round btn-min-width pull-right" href="#" target="_blank">Report <i class="ft-bar-chart pl-1"></i></a>
											</li>
										</ul>
									</div>
								</div>
								<div class="card-content collapse show bg-hexagons-danger">
									<div class="card-body">
										<div class="media d-flex">
											<div class="align-self-center width-100">
												<div id="Analytics-donut-chart" class="height-100 donutShadow"></div>
											</div>
											<div class="media-body text-right mt-1">
												<h3 class="font-large-2 white">12,515</h3>
												<h6 class="mt-1"><span class="text-muted white">Analytics in the <a href="#" class="darken-2 white">last year.</a></span></h6>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12 col-lg-8">
					<div class="card">
						<div class="card-header p-1">
							<h4 class="card-title float-left">Project X - <span class="blue-grey lighten-2 font-small-3 mb-0">24 DEC 2017 - 09 APR 2019</span></h4>
							<span class="badge badge-pill badge-info float-right m-0">Approved</span>
						</div>
						<div class="card-content collapse show">
							<div class="card-footer text-center p-1">
								<div class="row">
									<div class="col-md-3 col-12 border-right-blue-grey border-right-lighten-5 text-center">
										<p class="blue-grey lighten-2 mb-0">Tasks</p>
										<p class="font-medium-5 text-bold-400">26</p>
									</div>
									<div class="col-md-3 col-12 border-right-blue-grey border-right-lighten-5 text-center">
										<p class="blue-grey lighten-2 mb-0">Completed</p>
										<p class="font-medium-5 text-bold-400">58%</p>
									</div>
									<div class="col-md-3 col-12 border-right-blue-grey border-right-lighten-5 text-center">
										<p class="blue-grey lighten-2 mb-0">Pending</p>
										<p class="font-medium-5 text-bold-400">42%</p>
									</div>
									<div class="col-md-3 col-12 text-center">
										<p class="blue-grey lighten-2 mb-0">Version</p>
										<p class="font-medium-5 text-bold-400">4.5</p>
									</div>
								</div>
								<hr>
								<span class="text-muted"><a href="#" class="danger darken-2">Project X</a> Statistics</span>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-12 col-lg-4">
					<div class="card pull-up border-top-info border-top-3 rounded-0">
						<div class="card-header">
							<h4 class="card-title">New Clients <span class="badge badge-pill badge-info float-right m-0">5+</span></h4>
						</div>
						<div class="card-content collapse show">
							<div class="card-body p-1">
								<h4 class="font-large-1 text-bold-400">18.5% <i class="ft-users float-right"></i></h4>
							</div>
							<div class="card-footer p-1">
								<span class="text-muted"><i class="la la-arrow-circle-o-up info"></i> 23.67% increase</span>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row match-height">
				<div class="col-xl-4 col-lg-6 col-md-12">
					<div class="card card-transparent">
						<div class="card-header bg-transparent pl-0">
							<h5 class="card-title text-bold-700">Project Income</h5>
							<a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
						</div>
						<div class="card-content">
							<div id="project-income-chart" class="height-450 BarChartShadow"></div>
						</div>
					</div>
				</div>
				<div class="col-xl-8 col-lg-6 col-md-12">
					<h5 class="card-title text-bold-700 my-2">Recent Projects</h5>
					<div class="card">            
						<div class="card-content">
							<div id="recent-projects" class="media-list position-relative">
								<div class="table-responsive">
									<table class="table table-padded table-xl mb-0" id="recent-project-table">
										<thead>
											<tr>
												<th class="border-top-0">Project Name</th>
												<th class="border-top-0">Assigned to</th>
												<th class="border-top-0">Deadline</th>
												<th class="border-top-0">Status</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td class="text-truncate align-middle">
													<a href="#">X Admin</a>
												</td>
												<td class="text-truncate">
													<ul class="list-unstyled users-list m-0">
														<li data-toggle="tooltip" data-popup="tooltip-custom" data-original-title="John Doe" class="avatar avatar-sm pull-up">
															<img class="media-object rounded-circle" src="<?= ADMIN_ASSETS ?>images/portrait/small/avatar-s-19.png" alt="Avatar">
														</li>
														<li data-toggle="tooltip" data-popup="tooltip-custom" data-original-title="Katherine Nichols" class="avatar avatar-sm pull-up">
															<img class="media-object rounded-circle" src="<?= ADMIN_ASSETS ?>images/portrait/small/avatar-s-18.png" alt="Avatar">
														</li>
														<li data-toggle="tooltip" data-popup="tooltip-custom" data-original-title="Joseph Weaver" class="avatar avatar-sm pull-up">
															<img class="media-object rounded-circle" src="<?= ADMIN_ASSETS ?>images/portrait/small/avatar-s-17.png" alt="Avatar">
														</li>
														<li class="avatar avatar-sm">
															<span class="badge badge-info">+2 more</span>
														</li>
													</ul>
												</td>
												<td class="text-truncate pb-0">
													<span>15th July, 2018</span>
													<p class="font-small-2 text-muted"> 1 day left</p>
												</td>
												<td>
													<div class="progress progress-sm mt-1 mb-0 box-shadow-2">
														<div class="progress-bar bg-gradient-x-success" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
													</div>
												</td>
											</tr>                                
											<tr>
												<td class="text-truncate align-middle">
													<a href="#">Analytics UI</a>
												</td>
												<td class="text-truncate">
													<ul class="list-unstyled users-list m-0">
														<li data-toggle="tooltip" data-popup="tooltip-custom" data-original-title="John Doe" class="avatar avatar-sm pull-up">
															<img class="media-object rounded-circle" src="<?= ADMIN_ASSETS ?>images/portrait/small/avatar-s-17.png" alt="Avatar">
														</li>
														<li data-toggle="tooltip" data-popup="tooltip-custom" data-original-title="Katherine Nichols" class="avatar avatar-sm pull-up">
															<img class="media-object rounded-circle" src="<?= ADMIN_ASSETS ?>images/portrait/small/avatar-s-14.png" alt="Avatar">
														</li>
													</ul>
												</td>
												<td class="text-truncate pb-0">
													<span>26th May, 2018</span>
													<p class="font-small-2 text-muted danger"> behind</p>
												</td>
												<td>
													<div class="progress progress-sm mt-1 mb-0 box-shadow-2">
														<div class="progress-bar bg-gradient-x-danger" role="progressbar" style="width: 85%" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100"></div>
													</div>
												</td>
											</tr>
											<tr>
												<td class="text-truncate align-middle">
													<a href="#">Traveltrip</a>
												</td>
												<td class="text-truncate">
													<ul class="list-unstyled users-list m-0">
														<li data-toggle="tooltip" data-popup="tooltip-custom" data-original-title="John Doe" class="avatar avatar-sm pull-up">
															<img class="media-object rounded-circle" src="<?= ADMIN_ASSETS ?>images/portrait/small/avatar-s-19.png" alt="Avatar">
														</li>
													</ul>
												</td>
												<td class="text-truncate pb-0">
													<span>23rd May, 2018</span>
													<p class="font-small-2 text-muted"> in 11 Days</p>
												</td>
												<td>
													<div class="progress progress-sm mt-1 mb-0 box-shadow-2">
														<div class="progress-bar bg-gradient-x-success" role="progressbar" style="width: 55%" aria-valuenow="55" aria-valuemin="0" aria-valuemax="100"></div>
													</div>
												</td>
											</tr>
											<tr>
												<td class="text-truncate align-middle">
													<a href="#">Apex Angular</a>
												</td>
												<td class="text-truncate">
													<ul class="list-unstyled users-list m-0">
														<li data-toggle="tooltip" data-popup="tooltip-custom" data-original-title="John Doe" class="avatar avatar-sm pull-up">
															<img class="media-object rounded-circle" src="<?= ADMIN_ASSETS ?>images/portrait/small/avatar-s-19.png" alt="Avatar">
														</li>
														<li data-toggle="tooltip" data-popup="tooltip-custom" data-original-title="Katherine Nichols" class="avatar avatar-sm pull-up">
															<img class="media-object rounded-circle" src="<?= ADMIN_ASSETS ?>images/portrait/small/avatar-s-18.png" alt="Avatar">
														</li>
														<li data-toggle="tooltip" data-popup="tooltip-custom" data-original-title="Joseph Weaver" class="avatar avatar-sm pull-up">
															<img class="media-object rounded-circle" src="<?= ADMIN_ASSETS ?>images/portrait/small/avatar-s-17.png" alt="Avatar">
														</li>
														<li class="avatar avatar-sm">
															<span class="badge badge-info">+1 more</span>
														</li>
													</ul>
												</td>
												<td class="text-truncate pb-0">
													<span>13th May, 2018</span>
													<p class="font-small-2 text-muted"> 1 month</p>
												</td>
												<td>
													<div class="progress progress-sm mt-1 mb-0 box-shadow-2">
														<div class="progress-bar bg-gradient-x-warning" role="progressbar" style="width: 85%" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100"></div>
													</div>
												</td>
											</tr>
											<tr>
												<td class="text-truncate align-middle">
													<a href="#">Chameleon Admin</a>
												</td>
												<td class="text-truncate">
													<ul class="list-unstyled users-list m-0">
														<li data-toggle="tooltip" data-popup="tooltip-custom" data-original-title="John Doe" class="avatar avatar-sm pull-up">
															<img class="media-object rounded-circle" src="<?= ADMIN_ASSETS ?>images/portrait/small/avatar-s-11.png" alt="Avatar">
														</li>
														<li data-toggle="tooltip" data-popup="tooltip-custom" data-original-title="Katherine Nichols" class="avatar avatar-sm pull-up">
															<img class="media-object rounded-circle" src="<?= ADMIN_ASSETS ?>images/portrait/small/avatar-s-12.png" alt="Avatar">
														</li>
													</ul>
												</td>
												<td class="text-truncate pb-0">
													<span>18th July, 2018</span>
													<p class="font-small-2 text-muted danger"> behind</p>
												</td>
												<td>
													<div class="progress progress-sm mt-1 mb-0 box-shadow-2">
														<div class="progress-bar bg-gradient-x-danger" role="progressbar" style="width: 45%" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100"></div>
													</div>
												</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row mt-1">
				<div class="col-md-12 col-lg-6 col-xl-8">
					<div class="card">
						<div class="card-header">
							<h4 class="card-title">New Projects</h4>
							<a class="heading-elements-toggle">
								<i class="la la-ellipsis-v font-medium-3"></i>
							</a>
							<div class="heading-elements">
								<ul class="list-inline mb-0">
									<li>
										<a data-action="reload">
											<i class="ft-rotate-cw"></i>
										</a>
									</li>
								</ul>
							</div>
						</div>
						<div class="card-content mt-1">
							<div id="new-projects" class="height-400 GradientlineShadow"></div>
						</div>
					</div>
				</div>
				<div class="col-md-12 col-lg-6 col-xl-4">
					<div class="card">
						<div class="card-header">
							<h4 class="card-title">Chat</h4>
							<a class="heading-elements-toggle">
								<i class="la la-ellipsis-v font-medium-3"></i>
							</a>
							<div class="heading-elements">
								<ul class="list-inline mb-0">
									<li>
										<a data-action="reload">
											<i class="ft-rotate-cw"></i>
										</a>
									</li>
								</ul>
							</div>
						</div>
						<div class="card-content">
							<div class="card-body chat-application">
								<div class="chats height-300">
									<div class="chats">
										<div class="chat">
											<div class="chat-avatar">
												<a class="avatar" data-toggle="tooltip" href="#" data-placement="right" title="" data-original-title="">
													<img src="<?= ADMIN_ASSETS ?>images/portrait/small/avatar-s-19.jpg" alt="avatar" />
												</a>
											</div>
											<div class="chat-body">
												<div class="chat-content">
													<p>How can we help? We're here for you!</p>
												</div>
											</div>
										</div>
										<div class="chat chat-left">
											<div class="chat-avatar">
												<a class="avatar" data-toggle="tooltip" href="#" data-placement="left" title="" data-original-title="">
													<img src="<?= ADMIN_ASSETS ?>images/portrait/small/avatar-s-15.jpg" alt="avatar" />
												</a>
											</div>
											<div class="chat-body">
												<div class="chat-content">
													<p>Hey Jacob, Could you please help me to find it out?</p>
												</div>
											</div>
										</div>
										<div class="chat">
											<div class="chat-avatar">
												<a class="avatar" data-toggle="tooltip" href="#" data-placement="right" title="" data-original-title="">
													<img src="<?= ADMIN_ASSETS ?>images/portrait/small/avatar-s-19.jpg" alt="avatar" />
												</a>
											</div>
											<div class="chat-body">
												<div class="chat-content">
													<p>Absolutely!</p>
												</div>
											</div>
										</div>
										<div class="chat chat-left">
											<div class="chat-avatar">
												<a class="avatar" data-toggle="tooltip" href="#" data-placement="left" title="" data-original-title="">
													<img src="<?= ADMIN_ASSETS ?>images/portrait/small/avatar-s-15.jpg" alt="avatar" />
												</a>
											</div>
											<div class="chat-body">
												<div class="chat-content">
													<p>I am looking for the best Angular admin template.</p>
													<p>It should be Bootstrap 4 compatible.</p>
												</div>
											</div>
										</div>
										<div class="chat">
											<div class="chat-avatar">
												<a class="avatar" data-toggle="tooltip" href="#" data-placement="right" title="" data-original-title="">
													<img src="<?= ADMIN_ASSETS ?>images/portrait/small/avatar-s-19.jpg" alt="avatar" />
												</a>
											</div>
											<div class="chat-body">
												<div class="chat-content">
													<p>Crest admin is the responsive Angular 5 bootstrap 4 admin template.</p>
												</div>
											</div>
										</div>
										<div class="chat chat-left">
											<div class="chat-avatar">
												<a class="avatar" data-toggle="tooltip" href="#" data-placement="left" title="" data-original-title="">
													<img src="<?= ADMIN_ASSETS ?>images/portrait/small/avatar-s-15.jpg" alt="avatar" />
												</a>
											</div>
											<div class="chat-body">
												<div class="chat-content">
													<p>Looks clean and fresh UI.</p>
												</div>
												<div class="chat-content">
													<p>It's perfect for my next project.</p>
												</div>
											</div>
										</div>
										<div class="chat">
											<div class="chat-avatar">
												<a class="avatar" data-toggle="tooltip" href="#" data-placement="right" title="" data-original-title="">
													<img src="<?= ADMIN_ASSETS ?>images/portrait/small/avatar-s-19.jpg" alt="avatar" />
												</a>
											</div>
											<div class="chat-body">
												<div class="chat-content">
													<p>Thanks a lot!</p>
												</div>
											</div>
										</div>
										<div class="chat chat-left">
											<div class="chat-avatar">
												<a class="avatar" data-toggle="tooltip" href="#" data-placement="left" title="" data-original-title="">
													<img src="<?= ADMIN_ASSETS ?>images/portrait/small/avatar-s-15.jpg" alt="avatar" />
												</a>
											</div>
											<div class="chat-body">
												<div class="chat-content">
													<p>How can I purchase it?</p>
												</div>
											</div>
										</div>
										<div class="chat">
											<div class="chat-avatar">
												<a class="avatar" data-toggle="tooltip" href="#" data-placement="right" title="" data-original-title="">
													<img src="<?= ADMIN_ASSETS ?>images/portrait/small/avatar-s-19.jpg" alt="avatar" />
												</a>
											</div>
											<div class="chat-body">
												<div class="chat-content">
													<p>From Wrapbootstrap.</p>
												</div>
											</div>
										</div>
										<div class="chat chat-left">
											<div class="chat-avatar">
												<a class="avatar" data-toggle="tooltip" href="#" data-placement="left" title="" data-original-title="">
													<img src="<?= ADMIN_ASSETS ?>images/portrait/small/avatar-s-15.jpg" alt="avatar" />
												</a>
											</div>
											<div class="chat-body">
												<div class="chat-content">
													<p>I will purchase it for sure.</p>
												</div>
												<div class="chat-content">
													<p>Thanks.</p>
												</div>
											</div>
										</div>
										<div class="chat">
											<div class="chat-avatar">
												<a class="avatar" data-toggle="tooltip" href="#" data-placement="right" title="" data-original-title="">
													<img src="<?= ADMIN_ASSETS ?>images/portrait/small/avatar-s-19.jpg" alt="avatar" />
												</a>
											</div>
											<div class="chat-body">
												<div class="chat-content">
													<p>Great!!</p>
												</div>
											</div>
										</div>
									</div>
								</div>
								<form class="chat-app-input mt-1 row">
									<div class="col-12">
										<fieldset>
											<div class="input-group position-relative has-icon-left">
												<div class="form-control-position">
													<span id="basic-addon3"><i class="ft-image"></i></span>
												</div>
												<input type="text" class="form-control" placeholder="Send message" aria-describedby="button-addon2">
												<div class="input-group-append">
													<button class="btn btn-primary" type="button">Send</button>
												</div>
											</div>
										</fieldset>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="customizer border-left-blue-grey border-left-lighten-4 d-none d-xl-block">
	<a class="customizer-close" href="#"><i class="ft-x font-medium-3"></i></a>
	<a class="customizer-toggle bg-primary box-shadow-3" href="#" id="customizer-toggle-setting"><i class="ft-settings font-medium-3 spinner white"></i></a>
	<div class="customizer-content p-2">
		<h5 class="mt-1 mb-1 text-bold-500">Navbar Color Options</h5>
		<div class="navbar-color-options clearfix">
			<div class="gradient-colors mb-1 clearfix">
				<div class="bg-gradient-x-purple-blue navbar-color-option" data-bg="bg-gradient-x-purple-blue" title="bg-gradient-x-purple-blue"></div>
				<div class="bg-gradient-x-purple-red navbar-color-option" data-bg="bg-gradient-x-purple-red" title="bg-gradient-x-purple-red"></div>
				<div class="bg-gradient-x-blue-green navbar-color-option" data-bg="bg-gradient-x-blue-green" title="bg-gradient-x-blue-green"></div>
				<div class="bg-gradient-x-orange-yellow navbar-color-option" data-bg="bg-gradient-x-orange-yellow" title="bg-gradient-x-orange-yellow"></div>
				<div class="bg-gradient-x-blue-cyan navbar-color-option" data-bg="bg-gradient-x-blue-cyan" title="bg-gradient-x-blue-cyan"></div>
				<div class="bg-gradient-x-red-pink navbar-color-option" data-bg="bg-gradient-x-red-pink" title="bg-gradient-x-red-pink"></div>
			</div>
			<div class="solid-colors clearfix">
				<div class="bg-primary navbar-color-option" data-bg="bg-primary" title="primary"></div>
				<div class="bg-success navbar-color-option" data-bg="bg-success" title="success"></div>
				<div class="bg-info navbar-color-option" data-bg="bg-info" title="info"></div>
				<div class="bg-warning navbar-color-option" data-bg="bg-warning" title="warning"></div>
				<div class="bg-danger navbar-color-option" data-bg="bg-danger" title="danger"></div>
				<div class="bg-blue navbar-color-option" data-bg="bg-blue" title="blue"></div>
			</div>
		</div>
		<hr>
		<h5 class="my-1 text-bold-500">Layout Options</h5>
		<div class="row">
			<div class="col-12">
				<div class="d-inline-block custom-control custom-radio mb-1 col-4">
					<input type="radio" class="custom-control-input bg-primary" name="layouts" id="default-layout" checked>
					<label class="custom-control-label" for="default-layout">Default</label>
				</div>
				<div class="d-inline-block custom-control custom-radio mb-1 col-4">
					<input type="radio" class="custom-control-input bg-primary" name="layouts" id="fixed-layout">
					<label class="custom-control-label" for="fixed-layout">Fixed</label>
				</div>
				<div class="d-inline-block custom-control custom-radio mb-1 col-4">
					<input type="radio" class="custom-control-input bg-primary" name="layouts" id="static-layout">
					<label class="custom-control-label" for="static-layout">Static</label>
				</div>
				<div class="d-inline-block custom-control custom-radio mb-1">
					<input type="radio" class="custom-control-input bg-primary" name="layouts" id="boxed-layout">
					<label class="custom-control-label" for="boxed-layout">Boxed</label>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-12">
				<div class="d-inline-block custom-control custom-checkbox mb-1">
					<input type="checkbox" class="custom-control-input bg-primary" name="right-side-icons" id="right-side-icons">
					<label class="custom-control-label" for="right-side-icons">Right Side Icons</label>
				</div>
			</div>
		</div>

		<hr>

		<h5 class="mt-1 mb-1 text-bold-500">Sidebar menu Background</h5>

		<div class="row sidebar-color-options ml-0">
			<label for="sidebar-color-option" class="card-title font-medium-2 mr-2">White Mode</label>
			<div class="text-center mb-1">
				<input type="checkbox" id="sidebar-color-option" class="switchery" data-size="xs"/>
			</div>
			<label for="sidebar-color-option" class="card-title font-medium-2 ml-2">Dark Mode</label>
		</div>

		<hr>

		<label for="collapsed-sidebar" class="font-medium-2">Menu Collapse</label>
		<div class="float-right">
			<input type="checkbox" id="collapsed-sidebar" class="switchery" data-size="xs"/>
		</div>

		<hr>

		<h5 class="mt-1 mb-1 text-bold-500">Sidebar Background Image</h5>
		<div class="cz-bg-image row">
			<div class="col mb-3">
				<img src="<?= ADMIN_ASSETS ?>images/backgrounds/04.jpg" class="rounded sidiebar-bg-img" width="50" height="100" alt="background image">
			</div>
			<div class="col mb-3">
				<img src="<?= ADMIN_ASSETS ?>images/backgrounds/01.jpg" class="rounded sidiebar-bg-img" width="50" height="100" alt="background image">
			</div>
			<div class="col mb-3">
				<img src="<?= ADMIN_ASSETS ?>images/backgrounds/02.jpg" class="rounded sidiebar-bg-img" width="50" height="100" alt="background image">
			</div>
			<div class="col mb-3">
				<img src="<?= ADMIN_ASSETS ?>images/backgrounds/05.jpg" class="rounded sidiebar-bg-img" width="50" height="100" alt="background image">
			</div>
		</div>

		<div class="sidebar-image-visibility">
			<div class="row ml-0">
				<label for="toggle-sidebar-bg-img" class="card-title font-medium-2 mr-2">Hide Image</label>
				<div class="text-center mb-1">
					<input type="checkbox" id="toggle-sidebar-bg-img" class="switchery" data-size="xs" checked/>
				</div>
				<label for="toggle-sidebar-bg-img" class="card-title font-medium-2 ml-2">Show Image</label>
			</div>
		</div>


		<hr>

		<div class="row mb-2">

			<div class="col">
				<a href="https://themeselection.com/" class="btn btn-primary btn-block box-shadow-1" target="_blank">More Themes</a>
			</div>
		</div>
		<div class="text-center">
			<button id="twitter" class="btn btn-social-icon btn-twitter sharrre mr-1"><i class="la la-twitter"></i></button>
			<button id="facebook" class="btn btn-social-icon btn-facebook sharrre mr-1"><i class="la la-facebook"></i></button>
			<button id="google" class="btn btn-social-icon btn-google sharrre"><i class="la la-google"></i></button>
		</div>
	</div>
</div>
<?= $this->section('css') ?>
<?= $this->endSection() ?>

<?= $this->section('js') ?>
	<script src="<?= ADMIN_ASSETS ?>vendors/js/charts/chartist.min.js"></script>
	<script src="<?= ADMIN_ASSETS ?>vendors/js/charts/chartist-plugin-tooltip.min.js"></script>
	<script src="<?= ADMIN_ASSETS ?>js/scripts/pages/dashboard-analytics.min.js"></script>
<?= $this->endSection() ?>
<?= $this->endSection() ?>