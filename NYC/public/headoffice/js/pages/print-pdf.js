$(document).ready(function(){
	"use strict";
	var formProgress = 'formSubmitProgress',
	btnProgress = 'btn-progress',
	defaultImage = site_url+'assets/images/default/defaultImage.png',
	x_timer,
	msheetSwitch = false,
	certSwitch = false,
	mainHolder = jQuery('#mainHolder');

	$(document).on('change', '#msheetSwitch', function(e){
		e.preventDefault();
		let $parent = jQuery(this);
		if (this.checked) {
			msheetSwitch = true;
		} else {
			msheetSwitch = false;
		}
		if($("#certSwitch").prop('checked') == true){
			certSwitch = true;
		} else {
			certSwitch = false;			
		}
		toggleDropdown(msheetSwitch, certSwitch);
	});

	$(document).on('change', '#certSwitch', function(e){
		e.preventDefault();
		let $parent = jQuery(this);
		if (this.checked) {
			certSwitch = true;
		} else {
			certSwitch = false;
		}
		if($("#msheetSwitch").prop('checked') == true){
			msheetSwitch = true;
		} else {
			msheetSwitch = false;			
		}
		toggleDropdown(msheetSwitch, certSwitch);
	});

	function toggleDropdown(msheet, certif) {
		let holder = jQuery('._mainHolder');
		if (msheet && certif) {
			mainHolder.fadeIn(500);
			holder.html(singlePreference()).fadeIn(500);
			initSinglePreferenceSelect()
		} else if (!msheet && certif) {
			mainHolder.fadeIn();
			holder.html(multiPrefCertificate()).fadeIn(500);
			initMultisPreferenceSelectCertisSelect()		
		} else if (msheet && !certif) {
			mainHolder.fadeIn();
			holder.html(multiPrefMarksheet()).fadeIn(500);
			initMultisPreferenceSelectMsheetSelect()			
		} else if (!msheet && !certif) {
			mainHolder.fadeOut(500);
			holder.html('');
		}
	}


	function singlePreference() {
		let html = '<div class="row">';
			html += '<div class="col-md-6 mb-3">';
			html += '<label class="form-label">Marksheet <span class="text-danger">*</span></label>';
			html += '<select class="form-select singleMarksheet" name="marksheet">'+msheetHtml+'</select>';
			html += '</div>';
			html += '<div class="col-md-6 mb-3">';
			html += '<label class="form-label">Certificate <span class="text-danger">*</span></label>';
			html += '<select class="form-select singleCertificate" name="certificate">'+certHtml+'</select>';
			html += '</div>';
			html += '</div>';
		return html;
	}

	function multiPrefMarksheet() {
		let html = '<div class="row">';
		html += '<div class="col-md-12 mb-3 multisMarksheetContainer">';
		html += '<label class="form-label">Marksheet <span class="text-danger">*</span></label>';
		html += '<select class="form-select marksheet multisMarksheet" multiple name="marksheet[]">'+msheetHtml+'</select>';
		html += '</div>';
		html += '</div>';
		return html;
	}

	function multiPrefCertificate() {
		let html = '<div class="row">';
		html += '<div class="col-md-12 mb-3">';
		html += '<label class="form-label">Certificate <span class="text-danger">*</span></label>';
		html += '<select class="form-select multisCertificate" multiple name="certificate[]">'+certHtml+'</select>';
		html += '</div>';
		html += '</div>';
		return html;
	}

	function initSinglePreferenceSelect() {
		$('.singleMarksheet').select2({
			placeholder: "Select a marksheet",
			allowClear: false
		});

		$('.singleCertificate').select2({
			placeholder: "Select a certificate",
			allowClear: false
		});
	}

	function initMultisPreferenceSelectMsheetSelect() {
		$('.multisMarksheet').select2({
			placeholder: "Select a marksheet",
			width: 'resolve',
			maximumSelectionLength: 2,
			allowClear: false,
			theme: "classic",
		});
	}

	function initMultisPreferenceSelectCertisSelect() {
		$('.multisCertificate').select2({
			placeholder: "Select a certificate",
			width: 'resolve',
			maximumSelectionLength: 2,
			allowClear: false,
			theme: "classic",
		});
	}

});
