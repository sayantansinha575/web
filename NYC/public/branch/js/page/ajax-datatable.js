$(document).ready(function(){
	"use strict";
	var x_timer;

	/*STUDENT LIST AJAX DT BEGINS*/
	var dtStudentList = $('#dtStudentList').DataTable({
		lengthMenu: [
		[20, 50, 70, 100],
		[20, 50, 70, 100]
		],
		keys: !0,
		language: {
			paginate: {
				previous: "<i class='fas fa-arrow-circle-left'></i>",
				next: "<i class='fas fa-arrow-circle-right'>"
			}
		},
		drawCallback: function(oSettings) {
			if (oSettings._iDisplayLength > oSettings.fnRecordsDisplay()) {
				$(oSettings.nTableWrapper).find('.dataTables_paginate').hide();
			} else {
				$(oSettings.nTableWrapper).find('.dataTables_paginate').show();
			}
			$(".dataTables_paginate > .pagination").addClass("pagination-rounded")
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
		'ajax': {
			'url':site_url+'branch/student/ajax-dt-get-student-list',
			'data': function(data){
				var keyword = $('#keywordStud').val(),
				stats = $('#statusTypeStud').find(':selected').val(),
				gender = $('#genderStud').find(':selected').val();

				data.csrf_token_name = $("[name='csrf_token_name']").val();
				data.status = stats;
				data.keyword = keyword;
				data.gender = gender;
				return {
					data: data
				};
			},
			dataSrc: function(data){
				$("[name='csrf_token_name']").val(data.hash);
				return data.aaData;
			}
		},
		'columnDefs': [ {
			'targets': [0,1,2,3,4,5], 
			'orderable': false, 
		}],
		'columns': [
		{ data: 'slNo' },
		{ data: 'student' },
		{ data: 'gender' },
		{ data: 'mobile' },
		{ data: 'status' },
		{ data: 'action' },
		],
	});

	$('#keywordStud').keyup(function(){
		clearTimeout(x_timer);
		x_timer = setTimeout(function(){
			dtStudentList.draw();
		}, 1000);
	});

	$('#statusTypeStud').change(function(){
		dtStudentList.draw();
	});

	$('#genderStud').change(function(){
		dtStudentList.draw();
	});
	/*STUDENT LIST AJAX DT ENDS*/

	/*ADMISSION LIST AJAX DT BEGINS*/
	var dtAdmissionList = $('#dtAdmissionList').DataTable({
		lengthMenu: [
		[20, 50, 70, 100],
		[20, 50, 70, 100]
		],
		keys: !0,
		language: {
			paginate: {
				previous: "<i class='fas fa-arrow-circle-left'></i>",
				next: "<i class='fas fa-arrow-circle-right'>"
			}
		},
		drawCallback: function(oSettings) {
			if (oSettings._iDisplayLength > oSettings.fnRecordsDisplay()) {
				$(oSettings.nTableWrapper).find('.dataTables_paginate').hide();
			} else {
				$(oSettings.nTableWrapper).find('.dataTables_paginate').show();
			}
			$(".dataTables_paginate > .pagination").addClass("pagination-rounded")
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
		'ajax': {
			'url':site_url+'branch/student/ajax-dt-get-admission-list',
			'data': function(data){
				var keyword = $('#keywordAdmission').val();
				var fromDate = $('#fromDate').val();
				var toDate = $('#toDate').val();

				data.csrf_token_name = $("[name='csrf_token_name']").val();
				data.keyword = keyword;
				data.fromDate = fromDate;
				data.toDate = toDate;
				return {
					data: data
				};
			},
			dataSrc: function(data){
				$("[name='csrf_token_name']").val(data.hash);
				return data.aaData;
			}
		},
		'columnDefs': [ {
			'targets': [0,1,2,3,4,5], 
			'orderable': false, 
		}],
		'columns': [
		{ data: 'slNo' },
		{ data: 'student' },
		{ data: 'course_name' },
		{ data: 'course_type' },
		{ data: 'course_duration' },
		{ data: 'action' },
		],
	});

	$(document).on('click', '.filterAdmission', function(e){
		dtAdmissionList.draw();
	});

	$(document).on('click', '.resetAdmission', function(e){
		$('#keywordAdmission, #fromDate, #toDate').val('');
		dtAdmissionList.draw();
	});
	/*ADMISSION LIST AJAX DT ENDS*/

	/*PAYMENT LIST AJAX DT BEGINS*/
	var dtPaymentList = $('#dtPaymentList').DataTable({
		lengthMenu: [
		[20, 50, 70, 100],
		[20, 50, 70, 100]
		],
		keys: !0,
		language: {
			paginate: {
				previous: "<i class='fas fa-arrow-circle-left'></i>",
				next: "<i class='fas fa-arrow-circle-right'>"
			}
		},
		drawCallback: function(oSettings) {
			if (oSettings._iDisplayLength > oSettings.fnRecordsDisplay()) {
				$(oSettings.nTableWrapper).find('.dataTables_paginate').hide();
			} else {
				$(oSettings.nTableWrapper).find('.dataTables_paginate').show();
			}
			$(".dataTables_paginate > .pagination").addClass("pagination-rounded")
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
		'ajax': {
			'url':site_url+'branch/payment/ajax-dt-get-payment-list',
			'data': function(data){
				var keyword = $('#keywordPayment').val();

				data.csrf_token_name = $("[name='csrf_token_name']").val();
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
		'columnDefs': [ {
			'targets': [0,1,2,3,4,5,6,7], 
			'orderable': false, 
		}],
		'columns': [
		{ data: 'slNo' },
		{ data: 'student_name' },
		{ data: 'invoice_number' },
		{ 
			class: "indianCurrency",
			data: 'course_fees' 
		},
		{ 
			class: "indianCurrency",
			data: 'amount_paid' 
		},
		{ 
			class: "indianCurrency",
			data: 'pending_amount' 
		},
		{ data: 'created_at' },
		{ data: 'action' },
		],
	});

	$('#keywordPayment').keyup(function(){
		clearTimeout(x_timer);
		x_timer = setTimeout(function(){
			dtPaymentList.draw();
		}, 1000);
	});


	/*MARKSHEET LIST AJAX DT BEGINS*/
	var dtMarksheetList = $('#dtMarksheetList').DataTable({
		lengthMenu: [
		[20, 50, 70, 100],
		[20, 50, 70, 100]
		],
		keys: !0,
		language: {
			paginate: {
				previous: "<i class='fas fa-arrow-circle-left'></i>",
				next: "<i class='fas fa-arrow-circle-right'>"
			}
		},
		drawCallback: function(oSettings) {
			if (oSettings._iDisplayLength > oSettings.fnRecordsDisplay()) {
				$(oSettings.nTableWrapper).find('.dataTables_paginate').hide();
			} else {
				$(oSettings.nTableWrapper).find('.dataTables_paginate').show();
			}
			$(".dataTables_paginate > .pagination").addClass("pagination-rounded")
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
		'ajax': {
			'url':site_url+'branch/marksheet/ajax-dt-get-marksheet-list',
			'data': function(data){
				var keyword = $('#keywordMarksheet').val();
				var status = $('#marksheetStatus').val();

				data.csrf_token_name = $("[name='csrf_token_name']").val();
				data.keyword = keyword;
				data.status = status;
				return {
					data: data
				};
			},
			dataSrc: function(data){
				$("[name='csrf_token_name']").val(data.hash);
				return data.aaData;
			}
		},
		'columnDefs': [ {
			'targets': [0,1,2,3,4,5,6], 
			'orderable': false, 
		}],
		'columns': [
		{ data: 'slNo' },
		{ data: 'student' },
		{ data: 'marksheet_number' },
		{ data: 'course' },
		{ data: 'session' },
		{ data: 'status' },
		{ data: 'action' },
		],
	});

	$('#keywordMarksheet').keyup(function(){
		clearTimeout(x_timer);
		x_timer = setTimeout(function(){
			dtMarksheetList.draw();
		}, 1000);
	});
	$('#marksheetStatus').change(function(){
		dtMarksheetList.draw();
	});
	/*MARKSHEET LIST AJAX DT ENDS*/

	/*CERTIFICATE LIST AJAX DT BEGINS*/
	var dtCertificateList = $('#dtCertificateList').DataTable({
		lengthMenu: [
		[20, 50, 70, 100],
		[20, 50, 70, 100]
		],
		keys: !0,
		language: {
			paginate: {
				previous: "<i class='fas fa-arrow-circle-left'></i>",
				next: "<i class='fas fa-arrow-circle-right'>"
			}
		},
		drawCallback: function(oSettings) {
			if (oSettings._iDisplayLength > oSettings.fnRecordsDisplay()) {
				$(oSettings.nTableWrapper).find('.dataTables_paginate').hide();
			} else {
				$(oSettings.nTableWrapper).find('.dataTables_paginate').show();
			}
			$(".dataTables_paginate > .pagination").addClass("pagination-rounded")
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
		'ajax': {
			'url':site_url+'branch/certificate/ajax-dt-get-certificate-list',
			'data': function(data){
				var keyword = $('#certKeyword').val();
				var status = $('#certStatus').val();

				data.csrf_token_name = $("[name='csrf_token_name']").val();
				data.keyword = keyword;
				data.status = status;
				return {
					data: data
				};
			},
			dataSrc: function(data){
				$("[name='csrf_token_name']").val(data.hash);
				return data.aaData;
			}
		},
		'columnDefs': [ {
			'targets': [0,1,2,3,4,5,6], 
			'orderable': false, 
		}],
		'columns': [
		{ data: 'slNo' },
		{ data: 'student' },
		{ data: 'certificate_no' },
		{ data: 'course' },
		{ data: 'grade' },
		{ data: 'status' },
		{ data: 'action' },
		],
	});

	$('#certKeyword').keyup(function(){
		clearTimeout(x_timer);
		x_timer = setTimeout(function(){
			dtCertificateList.draw();
		}, 1000);
	});
	$('#certStatus').change(function(){
		dtCertificateList.draw();
	});
	/*CERTIFICATE LIST AJAX DT ENDS*/

	/*ADMIT LIST AJAX DT BEGINS*/
	var dtAdmitList = $('#dtAdmitList').DataTable({
		lengthMenu: [
		[20, 50, 70, 100],
		[20, 50, 70, 100]
		],
		keys: !0,
		language: {
			paginate: {
				previous: "<i class='fas fa-arrow-circle-left'></i>",
				next: "<i class='fas fa-arrow-circle-right'>"
			}
		},
		drawCallback: function(oSettings) {
			if (oSettings._iDisplayLength > oSettings.fnRecordsDisplay()) {
				$(oSettings.nTableWrapper).find('.dataTables_paginate').hide();
			} else {
				$(oSettings.nTableWrapper).find('.dataTables_paginate').show();
			}
			$(".dataTables_paginate > .pagination").addClass("pagination-rounded")
		},
		'processing': true,
		'serverSide': true,
		'searching': false,
		'responsive': true,
		'searchDelay': 500,
		'lengthChange': true,
		'stateSave': false,
		'serverMethod': 'post',
		"info": true,
		'ajax': {
			'url':site_url+'branch/admit/ajax-dt-get-admit-list',
			'data': function(data){
				var keyword = $('#admitKeyword').val();

				data.csrf_token_name = $("[name='csrf_token_name']").val();
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
		'columnDefs': [ {
			'targets': [0,1,2,3,4,5], 
			'orderable': false, 
		}],
		'columns': [
		{ data: 'slNo' },
		{ data: 'student' },
		{ data: 'exam_name' },
		{ data: 'date' },
		{ data: 'time' },
		{ data: 'action' },
		],
	});

	$('#admitKeyword').keyup(function(){
		clearTimeout(x_timer);
		x_timer = setTimeout(function(){
			dtAdmitList.draw();
		}, 1000);
	});
	/*ADMIT LIST AJAX DT ENDS*/


	/*STUDY MATS LIST AJAX DT BEGINS*/
	var dtStudyMats = $('#dtStudyMats').DataTable({
		lengthMenu: [
		[20, 50, 70, 100],
		[20, 50, 70, 100]
		],
		keys: !0,
		language: {
			paginate: {
				previous: "<i class='fas fa-arrow-circle-left'></i>",
				next: "<i class='fas fa-arrow-circle-right'>"
			}
		},
		drawCallback: function(oSettings) {
			if (oSettings._iDisplayLength > oSettings.fnRecordsDisplay()) {
				$(oSettings.nTableWrapper).find('.dataTables_paginate').hide();
			} else {
				$(oSettings.nTableWrapper).find('.dataTables_paginate').show();
			}
			$(".dataTables_paginate > .pagination").addClass("pagination-rounded")
		},
		'processing': true,
		'serverSide': true,
		'searching': false,
		'responsive': true,
		'searchDelay': 500,
		'lengthChange': true,
		'stateSave': false,
		'serverMethod': 'post',
		"info": true,
		'ajax': {
			'url':site_url+'branch/document/ajax-dt-get-study-materials-list',
			'data': function(data){
				var keyword = $('#studyMatsKeyword').val();

				data.csrf_token_name = $("[name='csrf_token_name']").val();
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
		'columnDefs': [ {
			'targets': [0,1,2,3], 
			'orderable': false, 
		}],
		'columns': [
		{ data: 'slNo' },
		{ data: 'course_name' },
		{ data: 'course_type' },
		{ data: 'action' },
		],
	});

	$('#studyMatsKeyword').keyup(function(){
		clearTimeout(x_timer);
		x_timer = setTimeout(function(){
			dtStudyMats.draw();
		}, 1000);
	});
	/*STUDY MATS LIST AJAX DT ENDS*/

	/*HO DOCS LIST AJAX DT BEGINS*/
	var dtDocsByHo = $('#dtDocsByHo').DataTable({
		lengthMenu: [
		[20, 50, 70, 100],
		[20, 50, 70, 100]
		],
		keys: !0,
		language: {
			paginate: {
				previous: "<i class='fas fa-arrow-circle-left'></i>",
				next: "<i class='fas fa-arrow-circle-right'>"
			}
		},
		drawCallback: function(oSettings) {
			if (oSettings._iDisplayLength > oSettings.fnRecordsDisplay()) {
				$(oSettings.nTableWrapper).find('.dataTables_paginate').hide();
			} else {
				$(oSettings.nTableWrapper).find('.dataTables_paginate').show();
			}
			$(".dataTables_paginate > .pagination").addClass("pagination-rounded")
		},
		'processing': true,
		'serverSide': true,
		'searching': false,
		'responsive': true,
		'searchDelay': 500,
		'lengthChange': true,
		'stateSave': false,
		'serverMethod': 'post',
		"info": true,
		'ajax': {
			'url':site_url+'branch/document/ajax-dt-get-ho-docs-list',
			'data': function(data){
				var keyword = $('#studyMatsKeyword').val();

				data.csrf_token_name = $("[name='csrf_token_name']").val();
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
		'columnDefs': [ {
			'targets': [0,1,2,3], 
			'orderable': false, 
		}],
		'columns': [
		{ data: 'slNo' },
		{ data: 'title' },
		{ data: 'doc_count' },
		{ data: 'action' },
		],
	});
	/*HO DOCS LIST AJAX DT ENDS*/
});
