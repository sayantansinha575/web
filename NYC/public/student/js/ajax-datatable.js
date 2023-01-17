$(document).ready(function(){
	"use strict";
	var x_timer;

	/*BRANCH LIST AJAX DT BEGINS*/
	var dtStudPayment = $('#dtStudPayment').DataTable({
		lengthMenu: [
		[25, 50, 70, 100],
		[25, 50, 70, 100]
		],
		keys: !0,
		language: {
			paginate: {
				// previous: "<i class='fa-solid fa-angle-left'></i>",
				// next: "<i class='fa-solid fa-angle-right'></i>"
			}
		},
		drawCallback: function() {
			// $(".dataTables_paginate > .pagination").addClass("pagination-rounded")
		},
		'processing': true,
		'serverSide': true,
		'searching': false,
		'responsive': true,
		'searchDelay': 500,
		'lengthChange': true,
		'stateSave': true,
		'serverMethod': 'post',
		"info": true,
		"aaSorting": [[0,'desc']],
		'ajax': {
			'url':site_url+'student/payment/ajax-dt-get-payment-list',
			'data': function(data){
				var keyword = $('#studPayKeyword').val();
				var enrollNo = $('#studPayEnroll').find(':selected').val();
				data.csrf_token_name = $("[name='csrf_token_name']").val();
				data.enrollNo = enrollNo;
				data.keyword = keyword;
				return {
					data: data
				};
			},
			dataSrc: function(data){
				$("[name='csrf_token_name']").val(data.hash);
				return data.aaData;
			}
		},
		'columnDefs': [{
			'targets': [3,5], 
			'orderable': false, 
		}],
		'columns': [
		{ data: 'slNo' },
		{ data: 'invoice_no' },
		{ data: 'course_code' },
		{ 
			class: "indianCurrency",
			data: 'course_fees' 
		},
		{ 
			class: "indianCurrency",
			data: 'amount'
		},
		{ 
			class: "text-center",
			data: 'action' 
		},
		],
		"fnDrawCallback": function (oSettings) {
			if (oSettings._iDisplayLength > oSettings.fnRecordsDisplay()) {
                $(oSettings.nTableWrapper).find('.dataTables_paginate').hide();
            } else {
                $(oSettings.nTableWrapper).find('.dataTables_paginate').show();
            }
		}
	});

	$('#studPayKeyword').keyup(function(){
		clearTimeout(x_timer);
		x_timer = setTimeout(function(){
			dtStudPayment.draw();
		}, 1000);
	});

	$('#studPayCourse').change(function(){
		dtStudPayment.draw();
	});
	/*BRANCH LIST AJAX DT ENDS*/
});
