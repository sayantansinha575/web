$(function () {
    $(".nycta-dt").DataTable({
        lengthMenu: [[25, 50, 100, -1], [25, 50, 100, "All"]],
        keys:!0,
        language:{
            // paginate:{
            //     previous:"<i class='zmdi zmdi-chevron-left'></i>",
            //     next:"<i class='zmdi zmdi-chevron-right'></i>"
            // }
        },
        drawCallback:function(oSettings){
            if (oSettings._iDisplayLength > oSettings.fnRecordsDisplay()) {
                $(oSettings.nTableWrapper).find('.dataTables_paginate').hide();
            } else {
                $(oSettings.nTableWrapper).find('.dataTables_paginate').show();
            }
        }});

    //Exportable table
    $('.js-exportable').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
});