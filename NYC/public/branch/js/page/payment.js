$(document).ready(function(){
	"use strict";
	var formProgress = 'formSubmitProgress';

	$(document).on('keyup drop',"#amountToBePaid", function(e){

		e.preventDefault();
		var amount = jQuery(this).val(),
		pendingAmount = $("#pendingAmount").val(),
		newAmount = pendingAmount - amount;
		
		if (amount > 0) {
			if (newAmount >= 0) {
				$('.btnProceedPayment').attr("disabled", false);
			}else{
				$(this).val('');
				$('.btnProceedPayment').attr("disabled", true);
				error("Amount can't be greater than pending amount");
			}
		}else{
			$(this).val('');
			$('.btnProceedPayment').attr("disabled", true);
		}
	});

	$('#formNewPayment').submit(function(e) {
		e.preventDefault();
		$('#formNewPayment').addClass(formProgress);
		var form = $(this);
		$.ajax({
			type: 'POST',
			url: form.attr('action'),
			data: form.serialize()
		}).done(function(data) {
			var JsonObject= JSON.parse(data);
			if (JsonObject.success == true) {
				$("[name='csrf_token_name']").val(JsonObject.hash);
				success(JsonObject.message);
				$('#formNewPayment').removeClass(formProgress);
			}else {
				$("[name='csrf_token_name']").val(JsonObject.hash);
				error(JsonObject.message);
				$('#formNewPayment').removeClass(formProgress);
			}
		}).fail(function(data) {
			error('Error occured');
			window.location.reload();
		});
	});
});