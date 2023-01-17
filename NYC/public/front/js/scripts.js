$(document).ready(()=>{
	"use strict";

	$(function(){
		$('#sidebar li a').each(function(){ 
			if(this.href == current){
				$(this).parents('li').addClass('active open');
			}
		})
	});
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

	$( document ).ajaxComplete(function() {
		$('[data-toggle="tooltip"]').tooltip({
			"html": true,
			"delay": {"show": 1000, "hide": 0},
		});
	});

});
