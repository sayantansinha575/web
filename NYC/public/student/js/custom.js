	$(document).ready(function(){
		"use strict";
		var formProgress = 'formSubmitProgress',
		btnProgress = 'btn-progress',
		defaultImage = site_url+'assets/images/default/defaultImage.png',
		x_timer;

		$(document).on('click', '.change-password', function(e){
			e.preventDefault();
			var parent = jQuery(this);
			$('#form-change-password').attr('action', site_url+'student/users/change-password/'+parent.attr('data-pwd'));
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

	});
