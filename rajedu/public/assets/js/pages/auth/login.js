"use strict";

// Class definition
var indexSignIn = function() {
    // Elements
    var form, submitButton, csrf, btnHtml,
    btnLoader = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="false"></span> Loading...';

    // Handle form
    var handleForm = function(e) {
        // Handle form submit
        $(document).on('submit', form, function(e){
            // Prevent button default action
            e.preventDefault();
            
            submitButton.prop('disabled', true).html(btnLoader);
            $('.error-feedback').html('');
            var formData = new FormData(form[0]);
            $.ajax({
                url: form.attr('action'),
                type: 'POST',
                data: formData,
                async: true,
                success: function (data) {
                    if (data.success) {
                        submitButton.prop('disabled', false).html(btnHtml);

                        window.location.href = data.redirect;
                    } else {
                        csrf.val(data.hash);
                        $.each(data.errors, function (key, val) {
                            $('[name='+ key +']').siblings('.error-feedback').html(val);
                        });
                        if (typeof data.message != 'undefined' && data.message != '') {
                            form.find('#form-feedback').html(data.message);
                        }
                        submitButton.prop('disabled', false).html(btnHtml);
                    }
                },
                error: function(response) {
                   submitButton.prop('disabled', false).html(btnHtml);
                },
                processData: false,
                contentType: false,
                dataType: 'json',
            });
		});
    }

    // Public functions
    return {
        // Initialization
        init: function() {
            form = $('#login-form');
            submitButton = $('#login-submit');
            btnHtml = submitButton.html();
            csrf = $('[name=x_token]');
            
            handleForm();
        }
    };
}();

// On document ready
$(function() {
    indexSignIn.init();
});
