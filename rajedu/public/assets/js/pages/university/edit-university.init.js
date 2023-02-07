"use strict";

var editAssociateProfile = function () {
    // Elements
    var form, submitButton, btnHtml, form2, submitButton2, btnHtml2, form3, submitButton3, btnHtml3, uniContactDatatable, contactTable, csrf,
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
                        showNotify(data.message, 'success', 0, data.redirect);
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


        form2.submit(function (e) {
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
                        showNotify(data.message, 'success', 0, data.redirect);
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

        form3.submit(function (e) {
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
                        showNotify(data.message, 'success', 0, data.redirect);
                    } else {
                        csrf.val(data.hash);
                        $.each(data.errors, function (key, val) {
                            $('[name=' + key + ']').siblings('.error-feedback').html(val);
                        });
                        if (typeof data.message != 'undefined' && data.message != '') {
                            form3.find('#form-feedback').html(data.message);
                        }
                        submitButton3.prop('disabled', false).html(btnHtml3);
                    }
                },
                error: function (response) {
                },
                processData: false,
                contentType: false,
                dataType: 'json',
            });
        });

    }

    var handleUniversityContactDt = function (e) {
        uniContactDatatable = $(table).DataTable({
            lengthMenu: [
            [20, 50, 100, 250],
            [20, 50, 100, 250]
            ],
            keys: !0,
            'processing': true,
            'serverSide': true,
            'searching': true,
            'responsive': true,
            'searchDelay': 1500,
            'lengthChange': true,
            'stateSave': false,
            'serverMethod': 'post',
            "info": true,
            "fixedHeader": true,    
            "language": {

            },
            'ajax': {
                url: site_url+'university/university-list-dt',
                data: function(data){
                    data.x_token = csrf.val();
                    data.keyword = $('[data-filter="search"]').val();
                },
                dataSrc: function(data){
                    csrf.val(data.hash);
                    return data.aaData;
                }
            },
            'columnDefs': [ {
                'targets': [7],
                'orderable': false,
            }],
            'columns': [
            { data: 'id' },
            { data: 'university_name' },
            { data: 'country' },
            { data: 'state' },
            { data: 'address' },
            { data: 'intake' },
            { data: 'date_of_establishment' },
            { class: 'text-center', data: 'action' },
            ],
        }).on('draw', function () {
        });
    }


    return {
        // Initialization
        init: function () {
            // UNIVERSITY INFO
            form = $('#form-update-university');
            submitButton = $('#btn-form-university');
            btnHtml = submitButton.html();

            // UNIVERSITY GENERAL INFO
            form2 = $('#form-university-general-info');
            submitButton2 = $('#btn-form-university-general-info');
            btnHtml2 = submitButton2.html();

            // UNIVERSITY CONTACT INFO
            form3 = $('#form-university-contact-info');
            submitButton3 = $('#btn-form-university-contact-info');
            btnHtml3 = submitButton3.html();
            contactTable = document.querySelector('#universityList');
            if (contactTable) {
                handleTypeOfDegreeListDThandleUniversityContactDt();
            }


            csrf = $('[name=x_token]');
            handleForm();
        }
    };
}();

// On document ready
$(function () {
    editAssociateProfile.init();
});
