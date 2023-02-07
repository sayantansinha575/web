"use strict";

var editAssociateProfile = function () {
    // Elements
    var form, submitButton, btnHtml, form2, submitButton2, btnHtml2, form3, submitButton3, btnHtml3, modalEl, csrf,
        btnLoader = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="false"></span> Loading...';

    // Handle form
    var handleForm = function (e) {

        // FOR PERSONAL DETAILS
        form.submit(function (e) {
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
                        csrf.val(data.hash);
                        submitButton.prop('disabled', false).html(btnHtml);
                        showNotify(data.message, 'success', true);
                    } else {
                        csrf.val(data.hash);
                        $.each(data.errors, function (key, val) {
                            $('[name=' + key + ']').siblings('.error-feedback').html(val);
                        });
                        if (typeof data.message != 'undefined' && data.message != '') {
                            form.find('#form-feedback').html(data.message);
                        }
                        submitButton.prop('disabled', false).html(btnHtml);
                    }
                },
                error: function (response) {
                },
                processData: false,
                contentType: false,
                dataType: 'json',
            });
        });

        // CHANGE AVATAR
        form2.submit( function(e) {
            e.preventDefault();
            submitButton2.prop('disabled', true).html(btnLoader);
            $('.error-feedback').html('');
            var formData = new FormData(form2[0]);
            $.ajax({
                url: form2.attr('action'),
                type: 'POST',
                data: formData,
                async: true,
                success: function (data) {
                    if (data.success) {
                        csrf.val(data.hash);
                        submitButton2.prop('disabled', false).html(btnHtml2);
                        showNotify(data.message, 'success', true);
                    } else {
                        csrf.val(data.hash);
                        $.each(data.errors, function (key, val) {
                            $('[name=' + key + ']').siblings('.error-feedback').html(val);
                        });
                        if (typeof data.message != 'undefined' && data.message != '') {
                            form2.find('#form-feedback').html(data.message);
                        }
                        submitButton2.prop('disabled', false).html(btnHtml2);
                    }
                },
                error: function (response) {
                },
                processData: false,
                contentType: false,
                dataType: 'json',
            });
        });

       form3.submit( function(e) {
            e.preventDefault();
            
            submitButton3.prop('disabled', true).html(btnLoader);
            $('.error-feedback').html('');
            var formData = new FormData(form3[0]);
            $.ajax({
                url: form3.attr('action'),
                type: 'POST',
                data: formData,
                async: true,
                success: function (data) {
                    if (data.success) {
                        csrf.val(data.hash);
                        submitButton3.prop('disabled', false).html(btnHtml3);
                        closeModal(true);
                        showNotify(data.message, 'success', false);
                        datatable.draw();
                    } else {
                        csrf.val(data.hash);
                        $.each(data.errors, function (key, val) {
                            $('[name='+ key +']').siblings('.error-feedback').html(val);
                        });
                        if (typeof data.message != 'undefined' && data.message != '') {
                            form3.find('#form-feedback').html(data.message);
                        }
                        submitButton3.prop('disabled', false).html(btnHtml3);
                    }
                },
                error: function(response) {
                },
                processData: false,
                contentType: false,
                dataType: 'json',
            });
        });

    }

    var closeModal = (closeModal = false) => {
        const resetButton = document.querySelector('[data-type="reset"]');
        if (closeModal) {
            $(resetButton).click()
        }
        resetButton.addEventListener('click', function () {
            form.find('input:not([name="x_token"])').val('');
            form.find('select').val('').trigger('change');
            $('.error-feedback').html('');
            $(modalEl).modal('hide');
        });
    }



    return {
        // Initialization
        init: function () {
            // PERSONAL DETAILS
            form = $('#form-type-of-associate');
            submitButton = $('#btn-type-of-document');
            btnHtml = submitButton.html();

            // CHANGE AVATAR
            form2 = $('#form-changePassword');
            submitButton2 = $('#btn-changePassword');
            btnHtml2 = submitButton2.html();

            // BANK DETAILS
            form3 = $('#form-bank-details');
            submitButton3 = $('#btn-bank-details');
            btnHtml3 = submitButton3.html();

            // BANK DETAILS MODAL
            modalEl = document.querySelector('#modal-bank-details');


            csrf = $('[name=x_token]');
            handleForm();
            closeModal();
        }
    };
}();

// On document ready
$(function () {
    editAssociateProfile.init();
});
