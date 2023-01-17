$(document).ready(function(){
	"use strict";
	var x_timer;

	/*BRANCH LIST AJAX DT BEGINS*/
	var dtBranchList = $('#dtBranchList').DataTable({
		lengthMenu: [
		[20, 50, 70, 100],
		[20, 50, 70, 100]
		],
		keys: !0,
		language: {
			paginate: {
				previous: "<i class='fa-solid fa-angle-left'></i>",
				next: "<i class='fa-solid fa-angle-right'></i>"
			}
		},
		drawCallback: function() {
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
			'url':site_url+'head-office/ajax-dt-get-branch-list',
			'data': function(data){
				var keyword = $('#keyword').val();
				var stats = $('#statusType').find(':selected').val();
				data.csrf_token_name = $("[name='csrf_token_name']").val();
				data.status = stats;
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
		{ data: 'branch_name' },
		{ data: 'academy_name' },
		{ data: 'branch_email' },
		{ data: 'status' },
		{ data: 'action' },
		],
		"fnDrawCallback": function (oSettings) {
			$('[data-toggle="tooltip"]').tooltip();
		}
	});

	$('#keyword').keyup(function(){
		clearTimeout(x_timer);
		x_timer = setTimeout(function(){
			dtBranchList.draw();
		}, 1000);
	});

	$('#statusType').change(function(){
		dtBranchList.draw();
	});
	/*BRANCH LIST AJAX DT ENDS*/

	/*STUDENT LIST AJAX DT BEGINS*/
	var dtStudentList = $('#dtStudentList').DataTable({
		lengthMenu: [
		[20, 50, 70, 100],
		[20, 50, 70, 100]
		],
		keys: !0,
		language: {
			paginate: {
				previous: "<i class='fa-solid fa-angle-left'></i>",
				next: "<i class='fa-solid fa-angle-right'></i>"
			}
		},
		drawCallback: function() {
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
			'url':site_url+'head-office/ajax-dt-get-student-list',
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
			'targets': [0,1,2,3,4,5,6,7], 
			'orderable': false, 
		}],
		'columns': [
		{ data: 'slNo' },
		{ data: 'registration_number' },
		{ data: 'student_name' },
		{ data: 'gender' },
		{ data: 'mobile' },
		{ data: 'branch_name' },
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
				previous: "<i class='fa-solid fa-angle-left'></i>",
				next: "<i class='fa-solid fa-angle-right'></i>"
			}
		},
		drawCallback: function() {
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
			'url':site_url+'head-office/ajax-dt-get-admission-list',
			'data': function(data){
				var keyword = $('#keywordAdmission').val();

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
		{ data: 'branch_name' },
		{ data: 'enrollment_number' },
		{ data: 'student_name' },
		{ data: 'course_name' },
		{ data: 'course_code' },
		{ data: 'course_type' },
		{ data: 'course_duration' },
		],
	});

	$('#keywordAdmission').keyup(function(){
		clearTimeout(x_timer);
		x_timer = setTimeout(function(){
			dtAdmissionList.draw();
		}, 1000);
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
				previous: "<i class='fa-solid fa-angle-left'></i>",
				next: "<i class='fa-solid fa-angle-right'></i>"
			}
		},
		drawCallback: function() {
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
			'url':site_url+'head-office/ajax-dt-get-payment-list',
			'data': function(data){
				var keyword = $('#keywordPayment').val(),
				branchId = $('#dtBranch').find(':selected').val();


				data.csrf_token_name = $("[name='csrf_token_name']").val();
				data.keyword = keyword;
				data.branchId = branchId;
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
			'targets': [0,1,2,3,4], 
			'orderable': false, 
		}],
		'columns': [
			{ data: 'slNo' },
			{ data: 'branch_name' },
			{ data: 'student_name' },
			{ data: 'invoice_number' },
			{ 
				class: "indianCurrency",
				data: 'amount' 
			},
		],
	});

	/*AUTHORIZATION LETTER LIST AJAX DT BEGINS*/
	var dtPaymentList = $('#dtAuthtList').DataTable({
		lengthMenu: [
		[20, 50, 70, 100],
		[20, 50, 70, 100]
		],
		keys: !0,
		language: {
			paginate: {
				previous: "<i class='fa-solid fa-angle-left'></i>",
				next: "<i class='fa-solid fa-angle-right'></i>"
			}
		},
		drawCallback: function() {
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
			'url':site_url+'head-office/ajax-dt-get-authletter-list',
			'data': function(data){
				var keyword = '',
				branchCode = $('#branch_code').val();
				data.csrf_token_name = $("[name='csrf_token_name']").val();
				data.keyword = keyword;
				data.branchCode = branchCode; 
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
			{ data: 'branch_name' },
			{ data: 'registration_date' },
			{ data: 'renewal_date' },
			{ data: 'issue_date' },
			{ data: 'action' },
		],
	});

	$('#keywordPayment').keyup(function(){
		clearTimeout(x_timer);
		x_timer = setTimeout(function(){
			dtPaymentList.draw();
		}, 1000);
	});
	$('#dtBranch').change(function(){
		dtPaymentList.draw();
	});
	/*PAYMENT LIST AJAX DT ENDS*/

	/*MARKSHEET LIST AJAX DT BEGINS*/
	var dtMarksheetList = $('#dtMarksheetList').DataTable({
		lengthMenu: [
		[20, 50, 70, 100],
		[20, 50, 70, 100]
		],
		keys: !0,
		language: {
			paginate: {
				previous: "<i class='fa-solid fa-angle-left'></i>",
				next: "<i class='fa-solid fa-angle-right'></i>"
			}
		},
		drawCallback: function() {
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
			'url':site_url+'head-office/marksheet/ajax-dt-get-marksheet-list',
			'data': function(data){
				var keyword = $('#keywordMarksheet').val();
				var status = $('#msheetStatus').val();
				var branch = $('#msheetBranch').val();

				data.csrf_token_name = $("[name='csrf_token_name']").val();
				data.keyword = keyword;
				data.status = status;
				data.branch = branch;
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
	$('#msheetStatus').change(function(){
		dtMarksheetList.draw();
	});
	$('#msheetBranch').change(function(){
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
				previous: "<i class='fa-solid fa-angle-left'></i>",
				next: "<i class='fa-solid fa-angle-right'></i>"
			}
		},
		drawCallback: function() {
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
			'url':site_url+'head-office/certificate/ajax-dt-get-certificate-list',
			'data': function(data){
				var keyword = $('#certKeyword').val();
				var status = $('#certStatus').val();
				var branch = $('#certBranch').val();

				data.csrf_token_name = $("[name='csrf_token_name']").val();
				data.keyword = keyword;
				data.status = status;
				data.branch = branch;
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
		{ data: 'certificate' },
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
	$('#certBranch').change(function(){
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
				previous: "<i class='fa-solid fa-angle-left'></i>",
				next: "<i class='fa-solid fa-angle-right'></i>"
			}
		},
		drawCallback: function() {
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
			'url':site_url+'head-office/admit/ajax-dt-get-admit-list',
			'data': function(data){
				var keyword = $('#admitKeyword').val();
				var branch = $('#admitBranch').val();

				data.csrf_token_name = $("[name='csrf_token_name']").val();
				data.keyword = keyword;
				data.branch = branch;
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
		{ data: 'branch_code' },
		{ data: 'exam_name' },
		{ data: 'date' },
		{ data: 'time' },
		{ data: 'action' },
		],
	});

	$(document).on('keyup change', '#admitKeyword', function(){
		clearTimeout(x_timer);
		x_timer = setTimeout(function(){
			dtAdmitList.draw();
		}, 1000);
	});
	$('#admitBranch').change(function(){
		dtAdmitList.draw();
	});
	/*ADMIT LIST AJAX DT ENDS*/

	/*STUDY MATERIAL LIST AJAX DT BEGINS*/
	var dtStudyMats = $('#dtStudyMats').DataTable({
		lengthMenu: [
		[20, 50, 70, 100],
		[20, 50, 70, 100]
		],
		keys: !0,
		language: {
			paginate: {
				previous: "<i class='fa-solid fa-angle-left'></i>",
				next: "<i class='fa-solid fa-angle-right'></i>"
			}
		},
		drawCallback: function() {
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
			'url':site_url+'head-office/document/ajax-dt-get-study-materials-list',
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

	$(document).on('keyup change', '#studyMatsKeyword', function(){
		clearTimeout(x_timer);
		x_timer = setTimeout(function(){
			dtStudyMats.draw();
		}, 1000);
	});
	/*STUDY MATERIAL LIST AJAX DT ENDS*/

	/*COMBINED PDF LIST AJAX DT BEGINS*/
	var dtCombinedPdfList = $('#dtCombinedPdfList').DataTable({
		lengthMenu: [
		[15, 30, 60, 100],
		[15, 30, 60, 100]
		],
		keys: !0,
		language: {
			paginate: {
				previous: "<i class='fa-solid fa-angle-left'></i>",
				next: "<i class='fa-solid fa-angle-right'></i>"
			}
		},
		drawCallback: function() {
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
			'url':site_url+'head-office/prints/ajax-dt-get-combined-pdf-list',
			'data': function(data){
				var keyword = $('#comKeyword').val();

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
			'targets': [0,1,2,3,4], 
			'orderable': false, 
		}],
		'columns': [
		{ data: 'slNo' },
		{ data: 'enrollment_number_1' },
		{ data: 'enrollment_number_2' },
		{ data: 'created_at' },
		{ data: 'action' },
		],
	});

	$(document).on('keyup change', '#comKeyword', function(){
		clearTimeout(x_timer);
		x_timer = setTimeout(function(){
			dtCombinedPdfList.draw();
		}, 1000);
	});
	/*COMBINED PDF LIST AJAX DT ENDS*/

	/*BRANCH DOCS LIST AJAX DT BEGINS*/
	var dtBranchDocs = $('#dtBranchDocs').DataTable({
		lengthMenu: [
		[20, 50, 70, 100],
		[20, 50, 70, 100]
		],
		keys: !0,
		language: {
			paginate: {
				previous: "<i class='fa-solid fa-angle-left'></i>",
				next: "<i class='fa-solid fa-angle-right'></i>"
			}
		},
		drawCallback: function() {
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
			'url':site_url+'head-office/document/ajax-dt-get-branch-doc-list',
			'data': function(data){
				data.csrf_token_name = $("[name='csrf_token_name']").val();
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
			'targets': [0,1,2], 
			'orderable': false, 
		}],
		'columns': [
		{ data: 'slNo' },
		{ data: 'title' },
		{ data: 'action' }
		],
	});
	/*BRANCH DOCS LIST AJAX DT ENDS*/

	/*ADMIT LIST AJAX DT BEGINS*/
	var dtAjaxWallet = $('#dtAjaxWallet').DataTable({
		lengthMenu: [
		[20, 50, 70, 100],
		[20, 50, 70, 100]
		],
		keys: !0,
		language: {
			paginate: {
				previous: "<i class='fa-solid fa-angle-left'></i>",
				next: "<i class='fa-solid fa-angle-right'></i>"
			}
		},
		drawCallback: function() {
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
			'url':site_url+'head-office/wallet/ajax-dt-get-wallet-list',
			'data': function(data){
				var keyword = $('#keywordWallet').val();
				var type = $('#transTypeWallet').val();

				data.csrf_token_name = $("[name='csrf_token_name']").val();
				data.keyword = keyword;
				data.type = type;
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
			'targets': [1,2,4], 
			'orderable': false, 
		}],
		'columns': [
		{ data: 'slNo' },
		{ data: 'branch_name' },
		{ data: 'purpose' },
		{ 
			class: "indianCurrency",
			data: 'amount' 
		},
		{ data: 'type' },
		{ data: 'date' },
		],
	});

	$(document).on('keyup change', '#keywordWallet', function(){
		clearTimeout(x_timer);
		x_timer = setTimeout(function(){
			dtAjaxWallet.draw();
		}, 1000);
	});
	$('#transTypeWallet').change(function(){
		dtAjaxWallet.draw();
	});
	/*ADMIT LIST AJAX DT ENDS*/

	



});


