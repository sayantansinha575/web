	$(document).ready(function(){
		"use strict";
		var formProgress = 'formSubmitProgress',
		x_timer,
		defaultImage = site_url+'assets/images/default/defaultImage.png';

		$(".btnSaveBranch").click("#formBranch", function (e) {
			event.preventDefault();
			var formData = new FormData($("#formBranch")[0]);
			invokeFormSubmit('#formBranch', formData);
		});

		$(".btnSaveAdmission").click("#formAdmission", function (e) {
			event.preventDefault();
			var formData = new FormData($("#formAdmission")[0]);
			invokeFormSubmit('#formAdmission', formData);
		});

		$(".defaultSaveButton").click("#formDefault", function (e) {
			event.preventDefault();
			$('#formDefault').addClass(formProgress);
			var formData = new FormData($("#formDefault")[0]);

			$('.ckedCus').each(function(e){
				let $this = jQuery(this),
				$class = $this.attr('name');
				var description = CKEDITOR.instances[$class].getData()
				formData.append($class, description);
				clearTimeout(x_timer);

			});
			clearTimeout(x_timer);
			x_timer = setTimeout(function(){
				invokeFormSubmit('#formDefault', formData);
			}, 1000);
		});

		$(".btnMarksheet").click("#formMarksheet", function (e) {
			event.preventDefault();
			$.confirm({
				title: 'Confirm!',
				content: "Kindly make sure you have entered all the correct information before we proceed further as you won't be able to modify this later?",
				icon: 'fa fa-warning',
				type: 'dark',
				autoClose: 'No|10000',
				buttons: {
					omg: {
						text: 'Yes',
						btnClass: 'btn-dark',
						action: function () {
							var formData = new FormData($("#formMarksheet")[0]);
							invokeFormSubmit('#formMarksheet', formData);
						}
					},
					No: function(){
					}
				}
			});
		});

		$(".btnCertificate").click("#formCertificate", function (e) {
			event.preventDefault();
			if (walletBal < certificateCharge) {
				$.confirm({
					title: 'Confirm!',
					content: "You do not have sufficient wallet balance to get approval of certificate, do you wish to continue?",
					icon: 'fa fa-warning',
					type: 'red',
					autoClose: 'No|10000',
					buttons: {
						omg: {
							text: 'Yes',
							btnClass: 'btn-danger',
							action: function () {
								$.confirm({
									title: 'Confirm!',
									content: "Kindly make sure you have entered all the correct information before we proceed further as you won't be able to modify this later?",
									icon: 'fa fa-warning',
									type: 'dark',
									autoClose: 'No|10000',
									buttons: {
										omg: {
											text: 'Yes',
											btnClass: 'btn-dark',
											action: function () {
												var formData = new FormData($("#formCertificate")[0]);
												invokeFormSubmit('#formCertificate', formData);
											}
										},
										No: function(){
										}
									}
								});
							}
						},
						No: function(){
						}
					}
				});
			} else {
				$.confirm({
					title: 'Confirm!',
					content: "Kindly make sure you have entered all the correct information before we proceed further as you won't be able to modify this later?",
					icon: 'fa fa-warning',
					type: 'dark',
					autoClose: 'No|10000',
					buttons: {
						omg: {
							text: 'Yes',
							btnClass: 'btn-dark',
							action: function () {
								var formData = new FormData($("#formCertificate")[0]);
								invokeFormSubmit('#formCertificate', formData);
							}
						},
						No: function(){
						}
					}
				});
			};
		});

		$(".btnSaveStudentEnroll").click("#formEnroll", function (e) {
			event.preventDefault();
			var $continue = $(this).attr('data-continue');
			var formData = new FormData($("#formEnroll")[0]);
			formData.append("is_continue", $continue);
			$('.studentAdmissionContainer').addClass(formProgress);
			$.ajax({
				url: $('#formEnroll').attr('action'),
				type: 'POST',
				data: formData,
				async: true,
				success: function (data) {
					var JsonObject= JSON.parse(data);
					if (JsonObject.success) {
						$("[name='csrf_token_name']").val(JsonObject.hash);
						$('.studentAdmissionContainer').removeClass(formProgress);
						if (JsonObject.is_continue) {
							success(JsonObject.message, 0, JsonObject.is_continue);
						}else{
							success(JsonObject.message);
						}
					} else {
						$("[name='csrf_token_name']").val(JsonObject.hash);
						$('.studentAdmissionContainer').removeClass(formProgress);
						if (JsonObject.name != '') {
							$(JsonObject.tab).click();
							setTimeout(function() {
								$(JsonObject.id).focus();
							}, 500);
						}
						error(JsonObject.message);
					}
				},
				cache: false,
				contentType: false,
				processData: false
			});
		});



		$(".btnAdmit").click("#formAdmit", function (e) {
			event.preventDefault();
			$.confirm({
				title: 'Confirm!',
				content: "Kindly make sure you have entered all the correct information before we proceed further as you won't be able to modify this later.",
				icon: 'fa fa-warning',
				type: 'dark',
				autoClose: 'No|10000',
				buttons: {
					omg: {
						text: 'Yes',
						btnClass: 'btn-dark',
						action: function () {
							var formData = new FormData($("#formAdmit")[0]);
							invokeFormSubmit('#formAdmit', formData);
						}
					},
					No: function(){
					}
				}
			});
		});

		/*Form Submit Common Invoker*/
		function invokeFormSubmit(formIdentifier, formData) {
			$(formIdentifier).addClass(formProgress);
			$.ajax({
				url: $(formIdentifier).attr('action'),
				type: 'POST',
				data: formData,
				async: true,
				success: function (data) {
					var JsonObject= JSON.parse(data);
					if (JsonObject.success) {
						$("[name='csrf_token_name']").val(JsonObject.hash);
						$(formIdentifier).removeClass(formProgress);
						success(JsonObject.message, JsonObject.reload, JsonObject.redirect);
					} else {
						$("[name='csrf_token_name']").val(JsonObject.hash);
						$(formIdentifier).removeClass(formProgress);
						if (JsonObject.name != '') {
							$(JsonObject.tab).click();
							setTimeout(function() {
								$(JsonObject.id).focus();
							}, 500);
						}
						error(JsonObject.message);
					}
				},
				cache: false,
				contentType: false,
				processData: false
			});
		};


		$(document).on('click', '.changeStudentStatus', function(e){
			e.preventDefault();
			let $id = $(this).attr('data-id'),
			$val = $(this).attr('data-val');
			$.confirm({
				title: 'Confirm!',
				content: "Are you sure? You want to change student status?",
				icon: 'fa fa-warning',
				type: 'dark',
				autoClose: 'No|5000',
				buttons: {
					omg: {
						text: 'Yes',
						btnClass: 'btn-dark',
						action: function () {
							window.location.href = site_url+"branch/student/change-status/"+$id+"/"+$val;
						}
					},
					No: function(){
					}
				}
			});
		});

		$(document).on('click', '.deleteStud', function(e){
			e.preventDefault();
			let $id = $(this).attr('data-id');
			$.confirm({
				title: 'Confirm!',
				content: "Are you sure? You want to delete this student data?",
				icon: 'fa fa-warning',
				type: 'red',
				autoClose: 'No|5000',
				buttons: {
					omg: {
						text: 'Yes',
						btnClass: 'btn-danger',
						action: function () {
							window.location.href = site_url+"branch/student/delete-student/"+$id;
						}
					},
					No: function(){
					}
				}
			});
		});

		$(document).on('click', '.deleteStudAdmission', function(e){
			e.preventDefault();
			let $id = $(this).attr('data-id');
			$.confirm({
				title: 'Confirm!',
				content: "Are you sure? You want to delete this admission details?",
				icon: 'fa fa-warning',
				type: 'red',
				autoClose: 'No|5000',
				buttons: {
					omg: {
						text: 'Yes',
						btnClass: 'btn-danger',
						action: function () {
							window.location.href = site_url+"branch/student/delete-admission/"+$id;
						}
					},
					No: function(){
					}
				}
			});
		});

		$('#course_type').on('select2:select', function (e) {
			e.preventDefault();
			$('.studentAdmissionContainer').addClass(formProgress);
			$('#course_code, #course_duration, #course_eligibility').val('');
			var data = e.params.data;
			$.ajax({
				type: 'POST',
				url: site_url+'branch/student/ajax-get-course-by-type',
				data: { type: data.id},
				dataType: "json",
				success: function (data) {
					if (data.success) {		
						$('#course_name').prop('disabled', false);		
						$('#course_name').html(data.html);
						$('.studentAdmissionContainer').removeClass(formProgress);		
					}
				}
			});
		});

		$('#course_name').on('select2:select', function (e) {
			e.preventDefault();
			$('.studentAdmissionContainer').addClass(formProgress);
			var data = e.params.data;
			$.ajax({
				type: 'POST',
				url: site_url+'branch/student/ajax-get-course-by-id',
				data: { id: data.id},
				dataType: "json",
				success: function (data) {
					if (data.success) {
						$('#course_code').val(data.details['course_code']);
						$('#course_duration').val(data.details['course_duration']);
						$('#course_eligibility').val(data.details['course_eligibility']);
						$('#course_fees').val(data.details['modCourseFees']);
						$('#from_session, #to_session').val('');
						$("#from_session" ).datepicker('destroy');
						const $duration = parseInt(data.details['course_duration']) - 1;
						$('#from_session').datepicker({
							autoclose: true,
							format: "yyyy-mm-dd",
							startDate: new Date(data.prevDate),
							endDate: new Date(),
						}).on('changeDate', function(ev) {
							$('#to_session').attr('readonly', false).val('');
							const date = new Date(ev.format())
							date.setMonth(date.getMonth() + $duration)
							$( "#to_session" ).datepicker('destroy');
							$( "#to_session" ).datepicker({
								autoclose: true,
								format: "yyyy-mm-dd",
								startDate: new Date(ev.format()),
							}).datepicker("update", date);;
						});
						$('#from_session').attr('readonly', false);
						$('.studentAdmissionContainer').removeClass(formProgress);		
					}
				}
			});
		});

		$('#from_session').on('change', function(){
			event.preventDefault();
			let $parent = jQuery(this),
			$val = $parent.val(),
			$checkVal = $('#to_session').val(),
			duration = $('#course_duration').val();
			if ($checkVal != '') {
				let $startMonth = new Date($val),
				$endDate = new Date($checkVal);
				var firstDay = new Date($startMonth.getFullYear(), $startMonth.getMonth(), 1);
				var lastDay = new Date($endDate.getFullYear(), $endDate.getMonth() + 1, 0);
				var $difference = monthDiff(firstDay, lastDay) + 1;
				
				if ($difference != duration) {
					$.alert('Duration between "From Session & To Session" is '+$difference+' months, it can not be more than '+duration+ ' months.')
					$('#from_session, #to_session, #duration').val('');
				}
				
			}
		});

		$('#to_session').on('change', function(){
			event.preventDefault();
			let $parent = jQuery(this),
			$val = $parent.val(),
			$checkVal = $('#from_session').val(),
			duration = $('#course_duration').val();
			if ($checkVal != '') {
				let $startMonth = new Date($checkVal),
				$endDate = new Date($val);
				var firstDay = new Date($startMonth.getFullYear(), $startMonth.getMonth(), 1);
				var lastDay = new Date($endDate.getFullYear(), $endDate.getMonth() + 1, 0);
				var $difference = monthDiff(firstDay, lastDay) + 1;
				if ($('#duration').length == 1) {
					$('#duration').val($difference);
				}
				if ($difference != duration) {
					$.alert('Duration between "From Session & To Session" is '+$difference+' months, it can not be more or less than '+duration+ ' months.')
					$('#to_session').val('');
				}

			}
		});


		$(document).on('keyup', '#studRegNo', function(e){
			e.preventDefault();
			let $parent = jQuery(this),
			$val = $parent.val();
			if (e.which == 13) {
				invokeStudentsAdmission($val);
				$('.studentAdmissionContainer').addClass(formProgress);
			}
		});

		$(document).on('click', '#btnRegNo', function(e){
			e.preventDefault();
			let $val = $('#studRegNo').val();
			invokeStudentsAdmission($val);
			$('.studentAdmissionContainer').addClass(formProgress);
		})

		function invokeStudentsAdmission(val) {
			$('#formAdmission').trigger('reset');
			$.ajax({
				type: 'POST',
				url: site_url+'common/encrypt-data',
				data: { string: val},
				dataType: "json",
				success: function (data) {
					if (data.success) {
						window.location.href = site_url+'branch/student/new-admission/'+data.data;
					}
				}
			});
		}

		$(document).on('click', '#editWhileNewAdmission', function(e){
			e.preventDefault();
			$("#studDetContainer").slideUp("slow");
			$("#studDetEditContainer").slideDown("slow");
		});

		$(document).on('click', '.assign-course', function(e){
			e.preventDefault();
			let parent = jQuery(this),
			$courseId = parent.attr('data-id'),
			$acDest = parent.attr('data-dest'),
			$courseTypeName = parent.attr('data-type-name'),
			$courseType = parent.attr('data-type'),
			text = parent.text(),
			$valContainer = '#collapse'+$acDest,
			container = $('.activeCoursesContainer'),
			$html = '',
			$tHtml = '';

			if ($('.activeCoursesContainer #'+$acDest).length === 0) {
				$html += '<div class="card">';
				$html +='<div id="'+$acDest+'" class="card-header bg-white shadow-sm border-0">'
				$html += '<h6 class="mb-0 accordion_title"><a href="#" data-toggle="collapse" data-target="#collapse'+$acDest+'" aria-expanded="true" aria-controls="collapse'+$acDest+'" class="d-block position-relative text-dark collapsible-link py-2 text-muted">'+$courseTypeName+'</a></h6>';
				$html += '</div>';
				$html += '<div id="collapse'+$acDest+'" aria-labelledby="'+$acDest+'"  class="collapse show" style="">';
				$html += '<div class="card-body pl-3 pr-3 pt-0">';
				$html += '<ul class="lists row branch-course">';
				$html += '</ul>';
				$html += '</div>';
				$html += '</div>';
				$html += '</div>';
				container.append($html);
				$('.btnHolder').show();
			}

			$tHtml += '<li class="col-xl-12 col-lg-12 col-md-12 m-1">';
			$tHtml += '<label>'+text+'</label>';
			$tHtml += '<div class="li-holder">';
			$tHtml += '<input type="hidden" class="form-control" name="id[]" value="SWxmQldReDlocUlTcVZBb1cwNUNqZz09">';
			$tHtml += '<input type="hidden" class="form-control" name="course_id[]" value="'+$courseId+'">';
			$tHtml += '<input type="hidden" class="form-control" name="course_type[]" value="'+$courseType+'">';
			$tHtml += '<input type="text" class="form-control decimal" placeholder="Enter course fees" name="course_fees[]">';
			$tHtml += '<button class="btn-danger removeCourse" type="button"><i class="fa-solid fa-xmark"></i></button>';
			$tHtml += '</div>';
			$tHtml += '</li>';

			$($valContainer).find('ul').append($tHtml);
			parent.parent('li').remove();

		});

		$(document).on('click', '.removeCourse', function(e){
			e.preventDefault();
			let parent = jQuery(this),
			$courseId = parent.attr('data-id'),
			$acDest = parent.attr('data-dest'),
			$courseTypeName = parent.attr('data-type-name'),
			$courseType = parent.attr('data-type'),
			text = parent.attr('data-name'),
			$valContainer = '#collapse'+$acDest,
			container = $('.hoCourseContainer'),
			$html = '';
			$html += '<li class="col-xl-12 col-lg-12 col-md-12 m-1">';
			$html += '<a href="javascript:coid(0)" class="assign-course" data-type-name="'+$courseTypeName+'" data-type="3" data-dest="'+$acDest+'Right" data-id="'+$courseId+'">';
			$html += text;
			$html += '<button class="float-right btn-dark"><i class="fa-solid fa-plus"></i></button>';
			$html += '</a>';
			$html += '</li>';
			$($valContainer).find('ul li.noResults').remove();
			$($valContainer).find('ul').append($html);
			parent.parents('li').remove();

		});

		$('.obtainedMarks').on('keyup paste drop', function(){
			event.preventDefault();
			clearTimeout(x_timer);
			let $parent = jQuery(this),
			$val = $parent.val(),
			$marksLimit = $parent.parents('.subjectsDetailsContainer ').find('input.totalMarks').val(),
			$subjectName = $parent.parents('.subjectsDetailsContainer ').find('input.subjectName').val();

			x_timer = setTimeout(function(){
				if ($val > parseInt($marksLimit)) {
					$.alert('Obtained marks of "'+$subjectName+'" can not be greater than '+$marksLimit+'.');
					$parent.val('');
					$parent.parents('.subjectsDetailsContainer ').find('input.gradation').val('');
				}else{
					if ($val != '' && $val > 0) {
						$parent.parents('.subjectsDetailsContainer ').find('input.gradation').val(getGradeNPercentage($marksLimit, $val));
					}
				}
			}, 500);
		});

		function getGradeNPercentage($totalNumbers = 0, $obtainedMarks = 0, $type = 'G')
		{
			let $percentage = ($obtainedMarks / $totalNumbers) * 100;
			if ($type.toUpperCase() == 'P') {
				return $percentage;
			}else{
				if ($percentage >= 80){
					return 'A+';
				}else if ($percentage >= 70) {
					return 'A';
				}else if ($percentage >= 60) {
					return 'B+';
				}else if ($percentage >= 50) {
					return 'B';
				}else if ($percentage >= 40) {
					return 'C';
				}else {
					return 'D';
				}
			}
		}

		function monthDiff(dateFrom, dateTo) {
			return dateTo.getMonth() - dateFrom.getMonth() + 
			(12 * (dateTo.getFullYear() - dateFrom.getFullYear()))
		}


		$(document).on('click', '.deletedocsSection', function(e){
			e.preventDefault();
			var parent = jQuery(this);
			$.confirm({
				title: 'Confirm!',
				content: "Along with the description all the files under it will be deleted permanently, are you sre you want to confirm?",
				icon: 'fa fa-warning',
				type: 'red',
				buttons: {
					omg: {
						text: 'Confirm',
						btnClass: 'btn-red',
						action: function () {
							$.ajax({
								type: 'POST',
								url: site_url+'branch/document/delete-study-material-section',
								data: {
									'data': parent.attr('data-file'),
									csrf_token_name: $("[name='csrf_token_name']").val(),
								},
								success: function (data) {
									var JsonObject= JSON.parse(data);
									if (JsonObject.success) {
										$("[name='csrf_token_name']").val(JsonObject.hash);
										success(JsonObject.message);
									} else {
										$("[name='csrf_token_name']").val(JsonObject.hash);
										error(JsonObject.message);
										$("[name='csrf_token_name']").val(JsonObject.hash);
									}
								}
							},'json');
						}
					},
					close: function(){
						parent.removeClass('btn-progress');
					}
				}
			});
		});


		$(document).on('click', '.deleteCourseMaterial', function(e){
			e.preventDefault();
			var parent = jQuery(this);
			$.confirm({
				title: 'Confirm!',
				content: "Are you sure you want to delete this doucment?",
				icon: 'fa fa-warning',
				type: 'red',
				buttons: {
					omg: {
						text: 'Confirm',
						btnClass: 'btn-red',
						action: function () {
							$.ajax({
								type: 'POST',
								url: site_url+'branch/document/delete-study-material',
								data: {
									'data': parent.attr('data-file'),
									csrf_token_name: $("[name='csrf_token_name']").val(),
								},
								success: function (data) {
									var JsonObject= JSON.parse(data);
									if (JsonObject.success) {
										$("[name='csrf_token_name']").val(JsonObject.hash);
										success(JsonObject.message, 0);
										setTimeout(function() {
											parent.closest('tr').remove();
										}, 1500);
									} else {
										$("[name='csrf_token_name']").val(JsonObject.hash);
										error(JsonObject.message);
										$("[name='csrf_token_name']").val(JsonObject.hash);
									}
								}
							},'json');
						}
					},
					close: function(){
						parent.removeClass('btn-progress');
					}
				}
			});
		});


		$('#course_typeDD').on('select2:select', function (e) {
			e.preventDefault();
			$('#formDefault').addClass(formProgress);
			var data = e.params.data;
			$.ajax({
				type: 'POST',
				url: site_url+'branch/document/ajax-get-course-by-type',
				data: { type: data.id, csrf_token_name: $("[name='csrf_token_name']").val()},
				dataType: "json",
				success: function (data) {
					if (data.success) {		
						$("[name='csrf_token_name']").val(data.hash);
						$('#course_nameDD').prop('disabled', false);		
						$('#course_nameDD').html(data.html);
						$('#formDefault').removeClass(formProgress);
					}
				}
			});
		});


		$('.courseNameInvoke').on('select2:select', function (e) {
			e.preventDefault();
			$('#defaultForm').addClass(formProgress);
			let courseTypeID = $('#course_typeDD').find(':selected').val();
			var data = e.params.data;
			$.ajax({
				type: 'POST',
				url: site_url+'branch/document/ajax-get-document-details-by-course',
				data: { courseId: data.id, courseTypeID:courseTypeID, csrf_token_name: $("[name='csrf_token_name']").val()},
				dataType: "json",
				success: function (data) {
					if (data.success) {	
						$("[name='csrf_token_name']").val(data.hash);	
						$('#defaultForm').removeClass(formProgress);
						$.confirm({
							title: 'Confirm!',
							content: "This branch has existing documents under respective course, hence you can not add.",
							icon: 'fa fa-warning',
							type: 'dark',
							autoClose: 'No|8000',
							buttons: {
								omg: {
									text: 'Check',
									btnClass: 'btn-dark',
									action: function () {
										window.open(data.redirect, '_blank'); 
										$('#course_nameDD').prop('selectedIndex',0).change();
									}
								},
								No: function(){
									$('#course_nameDD').prop('selectedIndex',0).change();
								}
							}
						});		
					}else {
						$("[name='csrf_token_name']").val(data.hash);	
						// history.pushState(null, '', site_url+'head-office/document/add-study-material');
						$('#defaultForm').removeClass(formProgress);								
					}
				}
			});
		});

		$(document).on('click', '.change-password', function(e){
			e.preventDefault();
			var parent = jQuery(this);
			$('#form-change-password').attr('action', site_url+'branch/users/change-password/'+parent.attr('data-pwd'));
			$('#change-password-modal').modal('show');
		});

		$(document).on('click','.btn-change-password', function(e){
			e.preventDefault();
			var parent = jQuery(this);
			parent.addClass('btn-progress');
			const formData = new FormData($("#form-change-password")[0]);
			$.confirm({
				title: 'Confirm!',
				content: "Are you sure? You want to reset password for this user.",
				icon: 'fa fa-warning',
				type: 'dark',
				buttons: {
					omg: {
						text: 'Yes',
						btnClass: 'btn-dark',
						action: function () {
							$.ajax({
								url: $('#form-change-password').attr('action'),
								type: 'POST',
								data: formData,
								async: false,
								success: function (data) {
									var JsonObject= JSON.parse(data);
									if (JsonObject.success) {
										parent.removeClass('btn-progress');
										success(JsonObject.message);
										$('#change-password-modal').modal('hide');
									} else {
										$("[name='csrf_token_name']").val(JsonObject.hash);
										parent.removeClass('btn-progress');
										error(JsonObject.message);
									}
								},
								cache: false,
								contentType: false,
								processData: false
							});
						}
					},
					No: function(){
						parent.removeClass('btn-progress').attr("disabled", false);
						$('#change-password-modal').modal('hide');
					}
				}
			});
		});

		var _URL = window.URL || window.webkitURL;
		$(".twohundredXhundred").change(function(e) {
			var file, img, parent  = jQuery(this);
			if ((file = this.files[0])) {
				img = new Image();
				img.src = e.target.result;
				img.onload = function() {
					if ((this.width != 200) || (this.height != 100)) {
						$.alert('Image size must be 200 X 100 pixels');
						parent.val('');
						if (parent.parents('.holder').find('embed').length > 0) {
							parent.parents('.holder').find('embed').attr('src', site_url+'public/headoffice/images/default/defaultImage.png');
						}
					}
				};
				img.onerror = function() {
					$.alert( "not a valid file: " + file.type);
					parent.val('');
					if (parent.parents('.holder').find('embed').length > 0) {
						parent.parents('.holder').find('embed').attr('src', site_url+'public/headoffice/images/default/defaultImage.png');
					}
				};
				img.src = _URL.createObjectURL(file);
			}
		});
		$(".hundredFiftyXhundredFifty").change(function(e) {
			var file, img, parent  = jQuery(this);
			if ((file = this.files[0])) {
				img = new Image();
				img.src = e.target.result;
				img.onload = function() {
					if ((this.width != 150) || (this.height != 150)) {
						$.alert('Image size must be 150 X 150 pixels');
						parent.val('');
						if (parent.parents('.holder').find('embed').length > 0) {
							parent.parents('.holder').find('embed').attr('src', site_url+'public/headoffice/images/default/defaultImage.png');
							parent.parents('.holder').find('.custom-file-label').text('Select an image to upload');
						}
					}
				};
				img.onerror = function() {
					$.alert( "not a valid file: " + file.type);
					parent.val('');
					if (parent.parents('.holder').find('embed').length > 0) {
						parent.parents('.holder').find('embed').attr('src', site_url+'public/headoffice/images/default/defaultImage.png');
						parent.parents('.holder').find('.custom-file-label').text('Select an image to upload');
					}
				};
				img.src = _URL.createObjectURL(file);
			}
		});


	});