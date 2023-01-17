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
            'url':site_url+'employer/student-lists/ajax-dt-get-student-list',
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



    



});


