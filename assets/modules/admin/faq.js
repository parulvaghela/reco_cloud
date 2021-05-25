var faq_list_table;
$(document).ready(function () {
    faq_list_table = $('#faq_list_table').DataTable({
        "ordering": true,
        "bLengthChange": false,
        "info": true,
        "bProcessing": true,
        "bServerSide": true,
        "iDisplayStart": 0,
        'sPaginationType': 'full_numbers',
        "bFilter": true,
        "sAjaxSource": base_url + "admin/faq_view_list",
        "sServerMethod": "POST",
         "fnServerParams": function (aoData)
        {
            var faq_status = $('#faq_status').val();
            aoData.push(
                    {"name": "faq_status", "value": faq_status}
            );
        },
        "aoColumns": [
            null,
            {"bSortable": false},
            {"bSortable": false},
            {"bSortable": false},
            {"bSortable": false}
        ],
        "order": [[0, "desc"]],
        dom: 'Bfrtip',
        lengthMenu: [
            [10, 20, 50, 100, -1],
            ['10 rows', '20 rows', '50 rows', '100 rows', 'Show all']
        ],
        buttons: [
            //'colvis', 'copy', 'csv', 'excel', 'pdf', 'print'
            'pageLength',
            'colvis',
            {
                extend: 'copyHtml5',
                exportOptions: {
                    columns: [0, ':visible']
                }
            },
            {
                extend: 'excelHtml5',
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'csvHtml5',
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'pdfHtml5',
                exportOptions: {
                    columns: ':visible'
                }
            }
        ]
    });

    
});
$('#faq_status').change(function(){
    faq_list_table.draw();
});
 $('.delete_faq').click(function(){
    alert();
});

function faq_status_change(item_id,status) {
   //alert(item_id,status);
    if (status == 1) {
        var r = confirm("Are you sure you want to Active this item?");
    } else {
        var r = confirm("Are you sure you want to De-Active this item?");
    }
    if (r == true) {
        $.ajax({
            type: "POST",
            url: base_url + "admin/deactive_faq",
            data: "id=" + item_id + "&status=" + status,
            dataType: "json",
            success: function (res) {
               console.log(res);
                if (res.status == 1)
                {
                    faq_list_table.draw();
                } else {
                    faq_list_table.draw();
                }
            }
        });
    }
}

function delete_faq(id){
    var d  = confirm("Are you sure you want to Active this item?");
    if(d == true){
    $.ajax({
            type: "POST",
            url: base_url + "admin/delete_faq",
            data: "id=" + id,
            dataType: "json",
            success: function (res) {
               console.log(res);
                if (res.status == 1)
                {
                    faq_list_table.draw();
                } else {
                    faq_list_table.draw();
                }
            }
        });
}
}