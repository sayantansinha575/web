	$(document).ready(function(){
		"use strict";
		var formProgress = 'formSubmitProgress',
		btnProgress = 'btn-progress',
		defaultImage = site_url+'assets/images/default/defaultImage.png',
		x_timer;





		$(".btnAuthLetter").click("#AuthLetter", function (e) {
			event.preventDefault();
			$('#AuthLetter').addClass(formProgress);
			var formData = new FormData($("#AuthLetter")[0]);
			invokeFormSubmit('#AuthLetter', formData);
		});

		$(".btnSaveBranch").click("#formBranch", function (e) {
			event.preventDefault();
			$('#formBranch').addClass(formProgress);
			var formData = new FormData($("#formBranch")[0]);
			invokeFormSubmit('#formBranch', formData);
		});

		$(".defaultBtn").click("#defaultForm", function (e) {
			event.preventDefault();
			$('#defaultForm').addClass(formProgress);
			var formData = new FormData($("#defaultForm")[0]);

			$('.ckedCus').each(function(e){
				let $this = jQuery(this),
				$class = $this.attr('name');
				var description = CKEDITOR.instances[$class].getData()
				formData.append($class, description);
				clearTimeout(x_timer);

			});
			clearTimeout(x_timer);
			x_timer = setTimeout(function(){
				invokeFormSubmit('#defaultForm', formData);
			}, 1000);
		});

		$(".btnSectionDescription").click("#formSectionDescription", function (e) {
			event.preventDefault();
			$('#formSectionDescription').addClass(formProgress);
			var formData = new FormData($("#formSectionDescription")[0]);
			var description = CKEDITOR.instances['description'].getData()
			formData.append('description', description);
			invokeFormSubmit('#formSectionDescription', formData, '#sectionDescription');
		});

		$(".btnSaveCourse").click("#formCourse", function (e) {
			event.preventDefault();
			$('#formCourse').addClass(formProgress);
			var formData = new FormData($("#formCourse")[0]);
			if($("#bubble-editor").length == 1) {
				var bubble = quill.container.firstChild.innerHTML;
				formData.append("course_details", bubble);
			}
			invokeFormSubmit('#formCourse', formData);
		});	

		$(".btnSaveExamDetails").click(function (e) {
			e.preventDefault();
			$('#formExamDetails').addClass(formProgress);
			var formData = new FormData($("#formExamDetails")[0]);
			invokeFormSubmit('#formExamDetails', formData);
		});		

		$(".btnSaveTransaction").click("#formTransaction", function (e) {
			event.preventDefault();
			$.confirm({
				title: 'Confirm!',
				content: "Kindly make sure you have entered all the correct information before we proceed further as you won't be able to modify this later?",
				icon: 'fa fa-warning',
				type: 'dark',
				autoClose: 'No|5000',
				buttons: {
					omg: {
						text: 'Yes',
						btnClass: 'btn-dark',
						action: function () {
							var formData = new FormData($("#formTransaction")[0]);
							if($("#bubble-editor").length == 1) {
								var bubble = quill.container.firstChild.innerHTML;
								formData.append("notes", bubble);
							}
							$('#formTransaction').addClass(formProgress);
							invokeFormSubmit('#formTransaction', formData);
						}
					},
					No: function(){
					}
				}
			});
		});

		$(".imgFile").change(function () {
			invokeFilePreview(this);
		});

		$(document).on('click', '.changeBranchStatus', function(e){
			e.preventDefault();
			let $id = $(this).attr('data-id'),
			$val = $(this).attr('data-val');
			$.confirm({
				title: 'Confirm!',
				content: "Are you sure? You want to chhange status branch status?",
				icon: 'fa fa-warning',
				type: 'dark',
				autoClose: 'No|5000',
				buttons: {
					omg: {
						text: 'Yes',
						btnClass: 'btn-dark',
						action: function () {
							window.location.href = site_url+"head-office/branch/change-status/"+$id+"/"+$val;
						}
					},
					No: function(){
					}
				}
			});
		});

		$(document).on('click', '.changeCourseStatus', function(e){
			e.preventDefault();
			let $id = $(this).attr('data-id'),
			$val = $(this).attr('data-val');
			$.confirm({
				title: 'Confirm!',
				content: "Are you sure? You want to change course status?",
				icon: 'fa fa-warning',
				type: 'dark',
				autoClose: 'No|5000',
				buttons: {
					omg: {
						text: 'Yes',
						btnClass: 'btn-dark',
						action: function () {
							window.location.href = site_url+"head-office/course/change-status/"+$id+"/"+$val;
						}
					},
					No: function(){
					}
				}
			});
		});

		$(document).on('click', '.change-password', function(e){
			e.preventDefault();
			var parent = jQuery(this);
			$('#form-change-password').attr('action', site_url+'head-office/users/change-password/'+parent.attr('data-delete'));
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
							window.location.href = site_url+"head-office/student/change-status/"+$id+"/"+$val;
						}
					},
					No: function(){
					}
				}
			});
		});

		/* EXAM PAPER STATUS BEGIN*/

		$(document).on('click', '.changePaperStatus', function(e){
			e.preventDefault();
			let $id = $(this).attr('data-id'),
			$val = $(this).attr('data-val');
			$.confirm({
				title: 'Confirm!',
				content: "Are you sure? You want to change paper status?",
				icon: 'fa fa-warning',
				type: 'dark',
				autoClose: 'No|5000',
				buttons: {
					omg: {
						text: 'Yes',
						btnClass: 'btn-dark',
						action: function () {
							window.location.href = site_url+"head-office/exam/change-status/"+$id+"/"+$val;
						}
					},
					No: function(){
					}	
				}
			});
		});

		/* EXAM PAPER STATUS END*/


		$(document).on('click', '.deleteStud', function(e){
			e.preventDefault();
			let $id = $(this).attr('data-id');
			$.confirm({
				title: 'Confirm!',
				content: "Are you sure? You want to change student status?",
				icon: 'fa fa-warning',
				type: 'red',
				autoClose: 'No|5000',
				buttons: {
					omg: {
						text: 'Yes',
						btnClass: 'btn-danger',
						action: function () {
							window.location.href = site_url+"head-office/student/delete-student/"+$id;
						}
					},
					No: function(){
					}
				}
			});
		});

		/* DELETE EXAM PAPER */
	$(document).on('click', '.deletePaper', function(e){
			e.preventDefault();
			var parent = jQuery(this);
			parent.addClass('btn-progress');
			$.confirm({
				title: 'Confirm!',
				content: "Are you sure you want to delete this exam paper?",
				icon: 'fa fa-warning',
				type: 'red',
				buttons: {
					omg: {
						text: 'Confirm',
						btnClass: 'btn-red',
						action: function () {
							$.ajax({
								type: 'POST',
								url: site_url+'head-office/exam/delete-paper',
								data: {
									'paper_id': parent.attr('data-id'),
									csrf_token_name: $("[name='csrf_token_name']").val(),
								},
								success: function (data) {
									parent.removeClass('btn-progress');
									var JsonObject= JSON.parse(data);
									if (JsonObject.success) {
										$("[name='csrf_token_name']").val(JsonObject.hash);
										success(JsonObject.message);
										setTimeout(function() {
											parent.closest('tr').remove();
										}, 500);
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

		/* DELETE EXAM PAPER END */


		$(".btnUpdateAdmit").click("#formUpdateAdmit", function (e) {
			event.preventDefault();
			$.confirm({
				title: 'Confirm!',
				content: "Kindly make sure you have entered all the correct information before we proceed further.",
				icon: 'fa fa-warning',
				type: 'dark',
				autoClose: 'No|10000',
				buttons: {
					omg: {
						text: 'Yes',
						btnClass: 'btn-dark',
						action: function () {
							$('#formUpdateAdmit').addClass(formProgress);
							var formData = new FormData($("#formUpdateAdmit")[0]);
							invokeFormSubmit('#formUpdateAdmit', formData);
						}
					},
					No: function(){
					}
				}
			});
		});


		function invokeFormSubmit(formIdentifier, formData, isModal=false) {
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
						if (isModal) {
							$(isModal).modal('hide');
						}
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

		function invokeFilePreview(input) {
			if (input.files && input.files[0]) {
				var reader = new FileReader();
				reader.onload = function (e) {
					$('#'+input.id).parents('.holder').find('.file-preview').html('<embed src="'+e.target.result+'" width="116">');
				};
				reader.readAsDataURL(input.files[0]);
			}
		};

		$('#has_marksheet').on('select2:select', function (e) {
			e.preventDefault();
			$('.studentAdmissionContainer').addClass(formProgress);
			let data = e.params.data,
			val = data.id;
			if (val == 2) {
				$('#total_marks').attr('readonly', true).val('');
			}else {
				$('#total_marks').attr('readonly', false);
			}
		});

		$(document).on('click', '.addMoreLabel', function(e){
			e.preventDefault();

			var labelCount = $('.labelContainer').length;
			var dt = new Date();
			var time = dt.getHours().toString()+dt.getMinutes().toString()+dt.getSeconds().toString();
			let $html = '<fieldset class="labelContainer" id="'+time+'">';
			$html += '<div class="col-md-12 mb-3">';
			$html += '<div class="input-group flex-wrap">';
			$html += '<input type="text" class="form-control" name="label_name[]" placeholder="Enter label name">';
			$html += '<input type="hidden" class="identifier" name="identifier[]" value="IDEN'+time+'">';
			$html += '<a href="javascript:void(0)" class="btn btn-danger btn-icon removeLabel" data-toggle="tooltip" title="Remove Label and fields under it"><i class="fa-solid fa-minus"></i></a>';
			$html += '</div>';
			$html += '</div>';
			$html += '</fieldset>';
			$('.fieldsContainer').append($html);
		})

		$(document).on('click', '.addMoreFields', function(e){
			e.preventDefault();
			var iden = '';
			if ($('.fieldsContainer').children('.labelContainer').last().length == 1) {
				iden = $('.fieldsContainer').children('.labelContainer').last().find('.identifier').val();
			}
			let $html = '<div class="childContainer">';
			$html += '<div class="col-md-12 mb-3">';
			$html += '<div class="input-group flex-wrap">';
			$html += '<input type="text" class="form-control subjectName" name="'+iden+'subject_name[]" placeholder="Enter subject name">';
			$html += '<input type="text" class="form-control numbers fullMarks" name="'+iden+'full_marks[]" placeholder="Enter full marks">';
			$html += '<a href="javascript:void(0)" class="btn btn-danger btn-icon removeField" data-toggle="tooltip" title="Remove"><i class="fa-solid fa-minus"></i></a>';
			$html += '</div>';
			$html += '</div>';
			$html += '</div>';
			if ($('.fieldsContainer').children('.labelContainer').last().length == 1) {
				$('.fieldsContainer').children('.labelContainer').last().append($html);
			}else {
				$('.fieldsContainer').append($html);
			}
		})
		$(document).on('click', '.removeField', function(e){
			e.preventDefault();
			$(this).parents('.childContainer').remove();
		})
		$(document).on('click', '.removeLabel', function(e){
			e.preventDefault();
			$(this).parents('.labelContainer').remove();
		})


		$(document).on('click', '.approveMarksheet', function(e){
			e.preventDefault();
			let $parent = jQuery(this),
			id = $parent.attr('data-id');
			$.confirm({
			    title: 'Issue Date',
			    content: '' +
			    '<form action="" class="formName">' +
			    '<div class="form-group">' +
			    '<input type="date" placeholder="Select Issue Date." class="issue_date form-control" required />' +
			    '</div>' +
			    '</form>',
			    buttons: {
			        formSubmit: {
			            text: 'Submit',
			            btnClass: 'btn-blue',
			            action: function () {
			                var issue_date = this.$content.find('.issue_date').val();
			                if(!issue_date){
			                    $.alert('provide a valid date');
			                    return false;
			                }
			                $.confirm({
							title: 'Confirm!',
							content: "Are you sure you want to approve this marksheet?",
							icon: 'fa fa-warning',
							type: 'green',
							autoClose: 'No|8000',
							buttons: {
								omg: {
									text: 'Yes',
									btnClass: 'btn-success',
									action: function () {
										alert(issue_date);
										window.location.href = site_url+'head-office/marksheet/chnage-status/a/'+id+'?date='+issue_date;
									}
								},
								No: function(){
								}
							}
						});
			            }
			        },
			        cancel: function () {
			            //close
			        },
			    },
			    onContentReady: function () {
			        // bind to events
			        var jc = this;
			        this.$content.find('form').on('submit', function (e) {
			            // if the user submits the form by pressing enter in the field.
			            e.preventDefault();
			            jc.$$formSubmit.trigger('click'); // reference the button and click it
			        });
			    }
			});
			
		})

		$(document).on('click', '.approveMarksheet', function(e){
			e.preventDefault();
			let $parent = jQuery(this),
			id = $parent.attr('data-id');
			$.confirm({
			    title: 'Issue Date',
			    content: '' +
			    '<form action="" class="formName">' +
			    '<div class="form-group">' +
			    '<input type="date" placeholder="Select Issue Date." class="issue_date form-control" required />' +
			    '</div>' +
			    '</form>',
			    buttons: {
			        formSubmit: {
			            text: 'Submit',
			            btnClass: 'btn-blue',
			            action: function () {
			                var issue_date = this.$content.find('.issue_date').val();
			                if(!issue_date){
			                    $.alert('provide a valid date');
			                    return false;
			                }
			                $.confirm({
							title: 'Confirm!',
							content: "Are you sure you want to approve this marksheet?",
							icon: 'fa fa-warning',
							type: 'green',
							autoClose: 'No|8000',
							buttons: {
								omg: {
									text: 'Yes',
									btnClass: 'btn-success',
									action: function () {
										alert(issue_date);
										window.location.href = site_url+'head-office/marksheet/chnage-status/a/'+id+'?date='+issue_date;
									}
								},
								No: function(){
								}
							}
						});
			            }
			        },
			        cancel: function () {
			            //close
			        },
			    },
			    onContentReady: function () {
			        // bind to events
			        var jc = this;
			        this.$content.find('form').on('submit', function (e) {
			            // if the user submits the form by pressing enter in the field.
			            e.preventDefault();
			            jc.$$formSubmit.trigger('click'); // reference the button and click it
			        });
			    }
			});
			
		})


		$(document).on('click', '.publishMarksheet', function(e){
			e.preventDefault();
			let $parent = jQuery(this),
			id = $parent.attr('data-id');
			$.confirm({
				title: 'Confirm!',
				content: "Are you sure you want to publish this marksheet?",
				icon: 'fa fa-warning',
				type: 'green',
				autoClose: 'No|8000',
				buttons: {
					omg: {
						text: 'Yes',
						btnClass: 'btn-success',
						action: function () {
							window.location.href = site_url+'head-office/marksheet/chnage-status/p/'+id;
						}
					},
					No: function(){
					}
				}
			});
		})
		
		$(document).on('click', '.rejectMarksheet', function(e){
			e.preventDefault();
			let $parent = jQuery(this),
			id = $parent.attr('data-id');
			$.confirm({
				title: 'Confirm!',
				content: "Are you sure you want to reject this marksheet?",
				icon: 'fa fa-warning',
				type: 'red',
				autoClose: 'No|8000',
				buttons: {
					omg: {
						text: 'Yes',
						btnClass: 'btn-danger',
						action: function () {
							window.location.href = site_url+'head-office/marksheet/chnage-status/r/'+id;
						}
					},
					No: function(){
					}
				}
			});
		})


		// $(document).on('click', '.approveCert', function(e){
		// 	e.preventDefault();
		// 	let $parent = jQuery(this),
		// 	id = $parent.attr('data-id');
		// 	$.confirm({
		// 		title: 'Confirm!',
		// 		content: "Are you sure you want to approve this Certificate?",
		// 		icon: 'fa fa-warning',
		// 		type: 'green',
		// 		autoClose: 'No|8000',
		// 		buttons: {
		// 			omg: {
		// 				text: 'Yes',
		// 				btnClass: 'btn-success',
		// 				action: function () {
		// 					window.location.href = site_url+'head-office/certificate/chnage-status/a/'+id;
		// 				}
		// 			},
		// 			No: function(){
		// 			}
		// 		}
		// 	});
		// })


		$(document).on('click', '.approveCert', function(e){
			e.preventDefault();
			let $parent = jQuery(this),
			id = $parent.attr('data-id');
			$.confirm({
			    title: 'Issue Date',
			    content: '' +
			    '<form action="" class="formName">' +
			    '<div class="form-group">' +
			    '<input type="date" placeholder="Select Issue Date." class="issue_date form-control" required />' +
			    '</div>' +
			    '</form>',
			    buttons: {
			        formSubmit: {
			            text: 'Submit',
			            btnClass: 'btn-blue',
			            action: function () {
			                var issue_date = this.$content.find('.issue_date').val();
			                if(!issue_date){
			                    $.alert('provide a valid date');
			                    return false;
			                }
			                $.confirm({
							title: 'Confirm!',
							content: "Are you sure you want to approve this marksheet?",
							icon: 'fa fa-warning',
							type: 'green',
							autoClose: 'No|8000',
							buttons: {
								omg: {
									text: 'Yes',
									btnClass: 'btn-success',
									action: function () {
										alert(issue_date);
										window.location.href = site_url+'head-office/certificate/chnage-status/a/'+id+'?d='+issue_date; 
									}
								},
								No: function(){
								}
							}
						});
			            }
			        },
			        cancel: function () {
			            //close
			        },
			    },
			    onContentReady: function () {
			        // bind to events
			        var jc = this;
			        this.$content.find('form').on('submit', function (e) {
			            // if the user submits the form by pressing enter in the field.
			            e.preventDefault();
			            jc.$$formSubmit.trigger('click'); // reference the button and click it
			        });
			    }
			});
			
		})







		$(document).on('click', '.publishCert', function(e){
			e.preventDefault();
			let $parent = jQuery(this),
			id = $parent.attr('data-id');
			$.confirm({
				title: 'Confirm!',
				content: "Are you sure you want to publish this Certificate?",
				icon: 'fa fa-warning',
				type: 'green',
				autoClose: 'No|8000',
				buttons: {
					omg: {
						text: 'Yes',
						btnClass: 'btn-success',
						action: function () {
							window.location.href = site_url+'head-office/certificate/chnage-status/p/'+id;
						}
					},
					No: function(){
					}
				}
			});
		})

		$(document).on('click', '.rejectCert', function(e){
			e.preventDefault();
			let $parent = jQuery(this),
			id = $parent.attr('data-id');
			$.confirm({
				title: 'Confirm!',
				content: "Are you sure you want to reject this Certificate?",
				icon: 'fa fa-warning',
				type: 'red',
				autoClose: 'No|8000',
				buttons: {
					omg: {
						text: 'Yes',
						btnClass: 'btn-danger',
						action: function () {
							window.location.href = site_url+'head-office/certificate/chnage-status/r/'+id;
						}
					},
					No: function(){
					}
				}
			});
		});

		$('#course_typeDD').on('select2:select', function (e) {
			e.preventDefault();
			$('#defaultForm').addClass(formProgress);
			var data = e.params.data;
			$.ajax({
				type: 'POST',
				url: site_url+'head-office/document/ajax-get-course-by-type',
				data: { type: data.id},
				dataType: "json",
				success: function (data) {
					if (data.success) {		
						$('#course_nameDD').prop('disabled', false);		
						$('#course_nameDD').html(data.html);

						$('#defaultForm').attr('action', site_url+'head-office/document/add-study-material');
						$('.docsListTbl tbody').html('');
						$("#studyMatContainer").slideUp("slow");
						$('.defaultBtn').val('Save');
						$('#defaultForm').removeClass(formProgress);

						$('#defaultForm').removeClass(formProgress);

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
				url: site_url+'head-office/document/ajax-get-document-details-by-course',
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

		$(document).on('click', '.deleteCourseMaterial', function(e){
			e.preventDefault();
			var parent = jQuery(this);
			parent.addClass('btn-progress');
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
								url: site_url+'head-office/document/delete-study-material',
								data: {
									'data': parent.attr('data-file'),
									csrf_token_name: $("[name='csrf_token_name']").val(),
								},
								success: function (data) {
									parent.removeClass('btn-progress');
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

		$(document).on('click', '.deletedocsSection', function(e){
			e.preventDefault();
			var parent = jQuery(this);
			parent.addClass('btn-progress');
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
								url: site_url+'head-office/document/delete-study-material-section',
								data: {
									'data': parent.attr('data-file'),
									csrf_token_name: $("[name='csrf_token_name']").val(),
								},
								success: function (data) {
									parent.removeClass('btn-progress');
									var JsonObject= JSON.parse(data);
									if (JsonObject.success) {
										$("[name='csrf_token_name']").val(JsonObject.hash);
										success(JsonObject.message);
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


		$(document).on('click', '.deleteAdmit', function(e){
			e.preventDefault();
			var parent = jQuery(this);
			parent.addClass('btn-progress');
			$.confirm({
				title: 'Confirm!',
				content: "Are you sure you want to delete this admit card?",
				icon: 'fa fa-warning',
				type: 'red',
				buttons: {
					omg: {
						text: 'Confirm',
						btnClass: 'btn-red',
						action: function () {
							$.ajax({
								type: 'POST',
								url: site_url+'head-office/admit/delete-admit',
								data: {
									'data': parent.attr('data-id'),
									csrf_token_name: $("[name='csrf_token_name']").val(),
								},
								success: function (data) {
									parent.removeClass('btn-progress');
									var JsonObject= JSON.parse(data);
									if (JsonObject.success) {
										$("[name='csrf_token_name']").val(JsonObject.hash);
										success(JsonObject.message);
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
		$(".twohundredXtwohundred").change(function(e) {
			var file, img, parent  = jQuery(this);
			if ((file = this.files[0])) {
				img = new Image();
				img.src = e.target.result;
				img.onload = function() {
					if ((this.width != 200) || (this.height != 200)) {
						$.alert('Image size must be 200 X 200 pixels');
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


		$(document).on('click', '.deleteLetter', function(e){
			e.preventDefault();
			var parent = jQuery(this);
			parent.addClass('btn-progress');
			$.confirm({
				title: 'Confirm!',
				content: "Are you sure you want to delete this letter?",
				icon: 'fa fa-warning',
				type: 'red',
				buttons: {
					omg: {
						text: 'Confirm',
						btnClass: 'btn-red',
						action: function () {
							$.ajax({
								type: 'POST',
								url: site_url+'head-office/delete-auth-letter',
								data: {
									'data': parent.attr('data-id'),
									csrf_token_name: $("[name='csrf_token_name']").val(),
								},
								success: function (data) {
									parent.removeClass('btn-progress');
									var JsonObject= JSON.parse(data);
									if (JsonObject.success) {
										$("[name='csrf_token_name']").val(JsonObject.hash);
										success(JsonObject.message);
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


		$(document).on('click', '.deleteAllBranchDoc', function(e){
			e.preventDefault();
			var parent = jQuery(this);
			parent.addClass('btn-progress');
			$.confirm({
				title: 'Confirm!',
				content: "Along with the title all the files under it will be deleted permanently, are you sre you want to confirm?",
				icon: 'fa fa-warning',
				type: 'red',
				buttons: {
					omg: {
						text: 'Confirm',
						btnClass: 'btn-red',
						action: function () {
							$.ajax({
								type: 'POST',
								url: site_url+'head-office/document/delete-bulk-branch-docs',
								data: {
									'id': parent.attr('data-id'),
									csrf_token_name: $("[name='csrf_token_name']").val(),
								},
								success: function (data) {
									parent.removeClass('btn-progress');
									var JsonObject= JSON.parse(data);
									if (JsonObject.success) {
										$("[name='csrf_token_name']").val(JsonObject.hash);
										success(JsonObject.message);
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

		$(document).on('click', '.deleteCombinedPdf', function(e){
			e.preventDefault();
			let $id = $(this).attr('data-id');
			$.confirm({
				title: 'Confirm!',
				content: "Are you sure? You want to delete this combined PDF?",
				icon: 'fa fa-warning',
				type: 'red',
				autoClose: 'No|5000',
				buttons: {
					omg: {
						text: 'Yes',
						btnClass: 'btn-danger',
						action: function () {
							window.location.href = site_url+"head-office/branch/delete-combined-pdf/"+$id;
						}
					},
					No: function(){
					}
				}
			});
		});

		$(document).on('click', '.delete-branch', function(e){
			e.preventDefault();
			let $id = $(this).attr('data-delete');
			$.confirm({
				title: 'Confirm!',
				content: "Are you sure? You want to delete this branch?",
				icon: 'fa fa-warning',
				type: 'red',
				autoClose: 'No|5000',
				buttons: {
					omg: {
						text: 'Yes',
						btnClass: 'btn-danger',
						action: function () {
							window.location.href = site_url+"head-office/branch/delete-branch/"+$id;
						}
					},
					No: function(){
					}
				}
			});
		});
	});
