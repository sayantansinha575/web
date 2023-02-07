"use strict";

var universities = function() {
    // Elements
    var form, submitButton, csrf, btnHtml, datatable, table, modalEl,
    btnLoader = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="false"></span> Loading...';

    // Handle form
    var handleForm = function(e) {
        
        $(document).on('submit', form, function(e){
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
                        closeModal(true);
                        showNotify(data.message, 'success', false);
                        datatable.draw();
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
                },
                processData: false,
                contentType: false,
                dataType: 'json',
            });
		});
    }

    var handleTypeOfDegreeListDT = function (e) {
        datatable = $(table).DataTable({
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
            handleEditRows();
            handleRowDeletion();
            handleStatusChange();
        });
    }

    var handleEditRows = () => {
        const editButtons = table.querySelectorAll('.edit-row');

        editButtons.forEach(ed => {
            ed.addEventListener('click', function (e) {
                e.preventDefault();
                $.ajax({
                    type: "POST",
                    url: site_url + 'associate/get-associate-details',
                    data: { id: $(ed).attr('data-id'), x_token: csrf.val()},
                    success: function(data) {
                        if (data.success) {
                            csrf.val(data.hash);
                            $('#user_img').val(data['result'].display_picture);
                            $('#date').val(data['result'].establishment_date);
                            $('#phone').val(data['result'].phone);
                            $('#name').val(data['result'].name);
                            $('#email').val(data['result'].email);
                            $('#user_name').val(data['result'].user_name);
                            $('#id').val(data['result'].id);
                            $(modalEl).modal('show');
                        } else {
                            csrf.val(data.hash);
                            showNotify(data.message, 'error');
                            datatable.draw();
                        }
                    },
                    error: function(response) {
                    },
                    dataType: 'json',
                });
            })
        });
    }

    var handleRowDeletion = () => {
        const deleteButtons = table.querySelectorAll('.delete-row');

        deleteButtons.forEach(d => {
            d.addEventListener('click', function (e) {
                e.preventDefault();

                const parent = e.target.closest('tr');

                const degreeName = parent.querySelectorAll('td')[1].innerText;

                Swal.fire({
                    text: "Are you sure you want to delete " + degreeName + "?",
                    icon: "warning",
                    showCancelButton: true,
                    buttonsStyling: false,
                    confirmButtonText: "Yes, delete!",
                    cancelButtonText: "No, cancel",
                    customClass: {
                        confirmButton: "btn fw-bold btn-danger",
                        cancelButton: "btn fw-bold btn-active-light-primary"
                    }
                }).then(function (result) {
                    if (result.value) {
                        $.ajax({
                            type: "POST",
                            url: site_url + 'university/delete-university-dt',
                            data: { ids: [$(d).attr('data-id')], x_token: csrf.val()},
                            success: function(data) {
                                if (data.success) {
                                    csrf.val(data.hash);
                                    showNotify(data.message, 'success');
                                    datatable.draw();
                                } else {
                                    csrf.val(data.hash);
                                    showNotify(data.message, 'error');
                                    datatable.draw();
                                }
                            },
                            error: function(response) {
                            },
                            dataType: 'json',
                        });
                    }
                });
            })
        });
    }

    var handleStatusChange = () => {
        const statusButtons = table.querySelectorAll('.change-status');

        statusButtons.forEach(d => {
            d.addEventListener('click', function (e) {
                e.preventDefault();

                const parent = e.target.closest('tr');

                const degreeName = parent.querySelectorAll('td')[1].innerText;

                Swal.fire({
                    text: "Are you sure you want to change status of " + degreeName + "?",
                    icon: "warning",
                    showCancelButton: true,
                    buttonsStyling: false,
                    confirmButtonText: "Yes, change!",
                    cancelButtonText: "No, cancel",
                    customClass: {
                        confirmButton: "btn fw-bold btn-danger",
                        cancelButton: "btn fw-bold btn-active-light-primary"
                    }
                }).then(function (result) {
                    if (result.value) {
                        $.ajax({
                            type: "POST",
                            url: site_url + 'associate/change-associate-type-status',
                            data: { id: $(d).attr('data-id'), status: $(d).attr('data-status'), x_token: csrf.val()},
                            success: function(data) {
                                if (data.success) {
                                    csrf.val(data.hash);
                                    showNotify(data.message, 'success');
                                    datatable.draw();
                                } else {
                                    csrf.val(data.hash);
                                    showNotify(data.message, 'error');
                                    datatable.draw();
                                }
                            },
                            error: function(response) {
                            },
                            dataType: 'json',
                        });
                    }
                });
            })
        });
    }


    var closeModal = (closeModal = false) => {
        const resetButton = document.querySelector('[data-type="reset"]');
        if (closeModal) {$(resetButton).click()}
        resetButton.addEventListener('click', function () {
            form.find('input:not([name="x_token"])').val('');
            form.find('select').val('').trigger('change');
            $('.error-feedback').html('');
            $(modalEl).modal('hide');
        });
    }


    return {
        // Initialization
        init: function() {
            form = $('#form-university-general-info');
            submitButton = $('#btn-university-general-info');
            btnHtml = submitButton.html();
            csrf = $('[name=x_token]');
            table = document.querySelector('#universityList');
            modalEl = document.querySelector('#modal-university-general-info');
            if (table) {
                handleTypeOfDegreeListDT();
            }

            handleForm();
            closeModal();
        }
    };
}();

// On document ready
$(function() {
    universities.init();
});
