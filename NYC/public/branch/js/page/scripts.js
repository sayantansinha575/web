$(document).ready(function(){
	"use strict";
	$(".basicDatatable").DataTable({
		lengthMenu: [[10, 50, 100, -1], [10, 50, 100, "All"]],
		keys:!0,language:{
			paginate:{
				previous:"<i class='fas fa-arrow-circle-left'></i>",
				next:"<i class='fas fa-arrow-circle-right'>"
			}
		},
		drawCallback:function(oSettings){
			if (oSettings._iDisplayLength > oSettings.fnRecordsDisplay()) {
				$(oSettings.nTableWrapper).find('.dataTables_paginate').hide();
			} else {
				$(oSettings.nTableWrapper).find('.dataTables_paginate').show();
			}
			$(".dataTables_paginate > .pagination").addClass("pagination-rounded")
		}});
	var a=$("#datatable-buttons").DataTable({lengthChange:!1,buttons:["copy","print"],language:{paginate:{previous:"<i class='mdi mdi-chevron-left'>",next:"<i class='mdi mdi-chevron-right'>"}},drawCallback:function(){$(".dataTables_paginate > .pagination").addClass("pagination-rounded")}});

	$(function(){
		$('#side-menu li a').each(function(){ 
			if(this.href == current){
				$(this).parent('li').addClass('active');
				$(this).parents('ul.nav-second-level').addClass('show');
				$(this).parents('li').addClass('active');
			}
		})
	});

	$(".custom-file-input").on("change", function() {
		var fileName = $(this).val().split("\\").pop(),
		$parent = jQuery(this),
		imageArray = [];
		let imagesfiles = event.target.files;
		for (var i = 0; i < event.target.files.length; i++) {
			imageArray.push(imagesfiles[i]);
		}
		if (imageArray.length) {
			for (var i = 0; i < imageArray.length; i++) {
				var row = imageArray[i].type;
				row = row.toString();
				var result = row.split('/');
				if (result[0] == 'video') {
					$.alert('Enter a valid file'); 
					$parent.val(''); 
					return false;
				}

				if ($parent.hasClass('file-size-valid')) {
					if (!validsize($parent, imageArray)) {
						$parent.val(''); return false;
					}
				}
			}
		}
		$(this).siblings(".custom-file-label").addClass("selected").html(fileName);
		invokeFilePreview(this);
	});

	$(".file-size-valid").change(function(event) {
		
	});

	/*File Preview Before Upload*/
	function validsize($parent, imageArray) {
		if (imageArray.length) {
			for (var i = 0; i < imageArray.length; i++) {
				if (imageArray[i].size > 4194304) {
					$.alert('File size can\'t be greater than 4MB.');
					return false;
				}
			}
			return true;
		}
	}
	function invokeFilePreview(input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function (e) {
				$('#'+input.id).parents('.holder').find('.file-preview').html('<embed src="'+e.target.result+'" width="116">');
			};
			reader.readAsDataURL(input.files[0]);
		}
	};

	$('.dobPicker').daterangepicker({
		drops: 'auto',
		singleDatePicker: true,
		autoUpdateInput: false,
		showDropdowns: true,
		minYear: 1900,
		maxDate: new Date(),
		autoApply: true,
		locale: {
			format: 'YYYY-MM-DD',
			cancelLabel: 'Clear'
		}
	});
	$('.dobPicker').on('apply.daterangepicker', function(ev, picker) {
		$(this).val(picker.startDate.format('YYYY-MM-DD'));
	});

	$('.singleDatePicker').daterangepicker({
		drops: 'auto',
		singleDatePicker: true,
		autoUpdateInput: false,
		showDropdowns: true,
		minYear: 1990,
		autoApply: true,
		locale: {
			format: 'YYYY-MM-DD',
			cancelLabel: 'Clear'
		}
	});
	$('.singleDatePicker').on('apply.daterangepicker', function(ev, picker) {
		$(this).val(picker.startDate.format('YYYY-MM-DD'));
	});

	$('#admission_date').daterangepicker({
		drops: 'auto',
		singleDatePicker: true,
		autoUpdateInput: true,
		showDropdowns: true,
		minYear: 1990,
		autoApply: true,
		locale: {
			format: 'YYYY-MM-DD',
			cancelLabel: 'Clear'
		}
	});
	$('#admission_date').on('apply.daterangepicker', function(ev, picker) {
		$(this).val(picker.startDate.format('YYYY-MM-DD'));
	});

	$('#fromDate').daterangepicker({
		drops: 'auto',
		singleDatePicker: true,
		autoUpdateInput: false,
		showDropdowns: true,
		minYear: 1990,
		maxDate: new Date(),
		autoApply: true,
		locale: {
			format: 'YYYY-MM-DD',
			cancelLabel: 'Clear'
		}
	});
	$('#fromDate').on('apply.daterangepicker', function(ev, picker) {
		$(this).val(picker.startDate.format('YYYY-MM-DD'));
		if ($('#toDate').val()) {
			if (picker.startDate.format('YYYY-MM-DD') > $('#toDate').val()) {
				$.alert('From date can\'t be greater than To date.');
				$('#toDate').val('');
			}
		}
	});

	$('#toDate').daterangepicker({
		drops: 'auto',
		singleDatePicker: true,
		autoUpdateInput: false,
		showDropdowns: true,
		minYear: 1990,
		maxDate: new Date(),
		autoApply: true,
		locale: {
			format: 'YYYY-MM-DD',
			cancelLabel: 'Clear'
		}
	});
	$('#toDate').on('apply.daterangepicker', function(ev, picker) {
		$(this).val(picker.startDate.format('YYYY-MM-DD'));
		if ($('#fromDate').val()) {
			if (picker.startDate.format('YYYY-MM-DD') < $('#fromDate').val()) {
				$.alert('To date can\'t be lesser than From date.');
				$('#toDate').val('');
			}
		}
	});

	$(document).on('keypress', '.numbers', function(evt){
		if (evt.which != 8 && evt.which != 0 && evt.which < 48 || evt.which > 57)
		{
			evt.preventDefault();
		}
	});

	$(document).on('keypress', '.decimal', function(evt){
		var self = $(this);
		self.val(self.val().replace(/[^0-9\.]/g, ''));
		if ((evt.which != 46 || self.val().indexOf('.') != -1) && (evt.which < 48 || evt.which > 57)) 
		{
			evt.preventDefault();
		}
	});

	$(document).on('keyup', ".uppercase", function () {
		var $val = $(this).val();
		$(this).val($val.toUpperCase());
	});

	// Show
	$('.selectNoSearch').select2({
		placeholder: "Select an option",
		minimumResultsForSearch: -1,
		allowClear: true
	});
	$('#course_type').select2({
		placeholder: "Select a course type",
		minimumResultsForSearch: -1,
		allowClear: false
	});
	$('#course_name').select2({
		placeholder: "Select a course name",
		allowClear: false
	});
	$('#typing_speed').select2({
		placeholder: "Select Typing Speed",
		allowClear: false
	});

	var errorMap = ["Invalid number", "Invalid country code", "Number is Too short", "Number is Too long", "Invalid number"];

	if ($('#academy_phone').length >= 1) {	
		var academyPhone = document.querySelector("#academy_phone");
		var iti = window.intlTelInput(academyPhone, {
			allowDropdown:true,
			separateDialCode:false,
			formatOnDisplay: false,
			onlyCountries: ["in"],
			utilsScript: site_url+"public/branch/js/utils.js?1638200991544"
		});
		academyPhone.addEventListener('blur', function() {
			if (academyPhone.value.trim()) {
				if (iti.isValidNumber()) {
					var number = iti.getNumber(intlTelInputUtils.numberFormat.E164);
					var strPos = number.indexOf("+91")
					if (strPos < 0) {
						$.alert('Invalid Number');
						academyPhone.value = '';
					}else {
						academyPhone.value = number;	
					}
				} else {
					var errorCode = iti.getValidationError();
					academyPhone.value = '';
					if (parseInt(errorCode) > 0) {
						$.alert('Invalid Number');
					}else {
						$.alert(errorMap[errorCode]);
					}
				}
			}
		});
	};

	if ($('#mobile').length >= 1) {	
		var mobile = document.querySelector("#mobile");
		var iti = window.intlTelInput(mobile, {
			allowDropdown:true,
			separateDialCode:false,
			formatOnDisplay: false,
			onlyCountries: ["in"],
			utilsScript: site_url+"public/branch/js/utils.js?1638200991544"
		});
		mobile.addEventListener('blur', function() {
			if (mobile.value.trim()) {
				if (iti.isValidNumber()) {
					var number = iti.getNumber(intlTelInputUtils.numberFormat.E164);
					var strPos = number.indexOf("+91")
					if (strPos < 0) {
						$.alert('Invalid Number');
						mobile.value = '';
					}else {
						mobile.value = number;	
					}
				} else {
					var errorCode = iti.getValidationError();
					mobile.value = '';
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
		drops: 'up',
		singleDatePicker: true,
		autoUpdateInput: false,
		showDropdowns: true,
		minDate: new Date('2016-01-01'),
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
		drops: 'auto',
		singleDatePicker: true,
		timePicker: true,
		autoUpdateInput: false,
		timePicker24Hour: false,
		timePickerIncrement: 1,
		timePickerSeconds: false,
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

	$('#course_typeDD').select2({
		placeholder: "Select a course type",
		minimumResultsForSearch: -1,
		allowClear: false
	});

	$('#course_nameDD').select2({
		placeholder: "Select a course name",
		allowClear: false
	});

	$('.pwd').on('keyup keypress',function (e) {
		if (e.which === 32){
			return false;
		}
		let val = $(this).val();
		$(this).val(val.replaceAll(/\s/g,''));		
	})
	$(document).on('keypress copy paste cut drag drop', '.silent', function(event){
		event.preventDefault();
		return false;
	});

	
});