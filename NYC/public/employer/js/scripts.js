$(document).ready(function(){
	"use strict";
	$(".basicDatatable").DataTable({lengthMenu: [[25, 50, 100, -1], [25, 50, 100, "All"]],keys:!0,language:{paginate:{previous:"<i class='mdi mdi-chevron-left'>",next:"<i class='mdi mdi-chevron-right'>"}},drawCallback:function(){$(".dataTables_paginate > .pagination").addClass("pagination-rounded")}});var a=$("#datatable-buttons").DataTable({lengthChange:!1,buttons:["copy","print"],language:{paginate:{previous:"<i class='mdi mdi-chevron-left'>",next:"<i class='mdi mdi-chevron-right'>"}},drawCallback:function(){$(".dataTables_paginate > .pagination").addClass("pagination-rounded")}});
	$(".basicBookCopyListDatatable").DataTable({lengthMenu: [[20, 50, 100, -1], [20, 50, 100, "All"]],keys:!0,language:{paginate:{previous:"<i class='mdi mdi-chevron-left'>",next:"<i class='mdi mdi-chevron-right'>"}},drawCallback:function(){$(".dataTables_paginate > .pagination").addClass("pagination-rounded")}});var a=$("#datatable-buttons").DataTable({lengthChange:!1,buttons:["copy","print"],language:{paginate:{previous:"<i class='mdi mdi-chevron-left'>",next:"<i class='mdi mdi-chevron-right'>"}},drawCallback:function(){$(".dataTables_paginate > .pagination").addClass("pagination-rounded")}});

	//tooltip
	$('[data-toggle="tooltip"]').tooltip();

	//select 2
	$('.select2').select2({
		placeholder: "Select a data",
		allowClear: false
	});

	$('.select2NoSearch').select2({
		placeholder: "Select an option",
		minimumResultsForSearch: -1,
		allowClear: false
	});

	$('#branchDD').select2({
		placeholder: "Select a Branch",
		allowClear: false
	});

	$('#course_typeDD').select2({
		placeholder: "Select a course type",
		minimumResultsForSearch: -1,
		allowClear: false
	});

	$('#course_nameDD').select2({
		placeholder: "Select a course name",
		allowClear: false
	});


	//single date picker
	$('.singleDatePicker').daterangepicker({
		drops: 'auto',
		singleDatePicker: true,
		autoUpdateInput: false,
		showDropdowns: true,
		minYear: 1700,
		maxYear: 2200,
		autoApply: true,
		locale: {
			format: 'YYYY-MM-DD',
			cancelLabel: 'Clear'
		}
	});
	$('.singleDatePicker').on('apply.daterangepicker', function(ev, picker) {
		$(this).val(picker.startDate.format('YYYY-MM-DD'));
	});


	$('.ageDatePicker').daterangepicker({
		singleDatePicker: true,
		autoUpdateInput: false,
		showDropdowns: true,
		minYear: 1800,
		maxDate: moment(),
		drops: 'auto',
		autoApply: true,
		locale: {
			format: 'YYYY-MM-DD',
			cancelLabel: 'Clear'
		}
	});
	$('.ageDatePicker').on('apply.daterangepicker', function(ev, picker) {
		var DOB = new Date(picker.startDate.format('YYYY-MM-DD'));
		var today = new Date();
		var age = today.getTime() - DOB.getTime();
		age = Math.floor(age / (1000 * 60 * 60 * 24 * 365.25));
		$("[name=age]").val(age);
		$(this).val(picker.startDate.format('YYYY-MM-DD'));
	});

	$('[data-bs-toggle="popover"]').popover({});

	$('body').on('click', function (e) {
		$('[data-bs-toggle=popover]').each(function () {
			if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
				$(this).popover('hide');
			}
		});
	});

	$(document).on('keypress', '.numbers', function(evt){
		if (evt.which != 8 && evt.which != 0 && evt.which < 46 || evt.which > 57)
		{
			evt.preventDefault();
		}
	});

	/*WILL KEEP TAB ACTIVE EVEN AFTER PAGE RELOAD*/
	$('a[data-bs-toggle="pill"]').on('show.bs.tab', function(e) {
		localStorage.setItem('activeTab', $(e.target).attr('href'));
	});
	var activeTab = localStorage.getItem('activeTab');
	if(activeTab){
		$('#v-pills-tab a[href="' + activeTab + '"]').tab('show');
	}

	$(document).on('keypress', '.numbers', function(evt){
		if (evt.which != 8 && evt.which != 0 && evt.which < 48 || evt.which > 57)
		{
			evt.preventDefault();
		}
	});

	$(".decimal").on("input", function(evt) {
		var self = $(this);
		self.val(self.val().replace(/[^0-9\.]/g, ''));
		if ((evt.which != 46 || self.val().indexOf('.') != -1) && (evt.which < 48 || evt.which > 57)) 
		{
			evt.preventDefault();
		}
	});

	$(document).on('keyup', '.user-name', function(evt){
		let $val = $(this).val();
		if ($val != '') {
			let $updatedVal = $val.replace(/\s+/, "");
			$(this).val($updatedVal);
		}
		// .
	});

	$(document).on('click', ".toggle-password", function () {
		$(this).toggleClass("fa-eye fa-eye-slash");
		let input = $(this).parents('div.password-container').find("input");
		if (input.attr("type") == "password") {
			input.attr("type", "text");
		} else {
			input.attr("type", "password");
		}
	});

	$(document).on('keyup', ".uppercase", function () {
		var $val = $(this).val();
		$(this).val($val.toUpperCase());
	});

	if ($('#academy_phone').length >= 1) {
		var input = document.querySelector("#academy_phone");
		var errorMap = ["Invalid number", "Invalid country code", "Number is Too short", "Number is Too long", "Invalid number"];
		var iti = window.intlTelInput(input, {
			allowDropdown:true,
			separateDialCode:false,
			formatOnDisplay: false,
			onlyCountries: ["in"],
			utilsScript: site_url+"public/headoffice/js/utils.js?1638200991544"
		});
		input.addEventListener('blur', function() {
			if (input.value.trim()) {
				if (iti.isValidNumber()) {
					var number = iti.getNumber(intlTelInputUtils.numberFormat.E164);
					var strPos = number.indexOf("+91")
					if (strPos < 0) {
						$.alert('Invalid Number');
						input.value = '';
					}else {
						input.value = number;	
					}
				} else {
					var errorCode = iti.getValidationError();
					input.value = '';
					if (parseInt(errorCode) > 0) {
						$.alert('Invalid Number');
					}else {
						$.alert(errorMap[errorCode]);
					}
				}
			}
		});
	};

	$('#exam_date').daterangepicker({
		drops: 'auto',
		singleDatePicker: true,
		autoUpdateInput: false,
		showDropdowns: true,
		minDate: new Date(),
		autoApply: true,
		locale: {
			format: 'YYYY-MM-DD',
			cancelLabel: 'Clear'
		}
	}).on('apply.daterangepicker', function(ev, picker) {
		$(this).val(picker.startDate.format('YYYY-MM-DD'));
		$('#exam_day').val(getDayName(picker.startDate.format('YYYY-MM-DD')));
	});

	$('#exam_time').daterangepicker({
		singleDatePicker: true,
		timePicker: true,
		autoUpdateInput: false,
		timePicker24Hour: false,
		timePickerIncrement: 1,
		timePickerSeconds: false,
		drops: 'auto',
		locale: {
			format: 'HH:mm A'
		}
	}).on('show.daterangepicker', function (ev, picker) {
		picker.container.find(".calendar-table").hide();
	}).on('apply.daterangepicker', function(ev, picker) {
		let hours = picker.startDate.format('HH'),
			minute = picker.startDate.format('mm'),
			ident = picker.startDate.format('A');

		if (hours == '00') {
			hours = 12;
		}
		$(this).val(hours+':'+minute+' '+ident);
	});

	function getDayName (dateString) {
		var days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
		var d = new Date(dateString);
		return days[d.getDay()];
	}

	$( document ).ajaxComplete(function() {
		$('[data-toggle="tooltip"]').tooltip({
			"html": true,
			"delay": {"show": 1000, "hide": 0},
		});
	});
});
