var list_user;
$(document).ready(function () {
    list_user = $('#user_list_table').DataTable({
        "ordering": true,
        "bLengthChange": false,
        "info": true,
        "bProcessing": true,
        "bServerSide": true,
        "iDisplayStart": 0,
        'sPaginationType': 'full_numbers',
        "bFilter": true,
        "sAjaxSource": base_url + "admin/user_list_view",
        "sServerMethod": "POST",
        "fnServerParams": function (aoData)
		{
			var role_id = $('#role_id').val(); 
			aoData.push(
					{"name": "data_id", "value": role_id}
			);
		},
        "aoColumns": [
            null,
            {"bSortable": false},
            {"bSortable": false},
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

    $('.show_transaction').on("click",function(){
        alert();
    });
});

function status_change(item_id, status) {
    //alert(item_id,status);
    if (status == 1) {
        var r = confirm("Are you sure you want to Active this item?");
    } else {
        var r = confirm("Are you sure you want to De-Active this item?");
    }
    if (r == true) {
        $.ajax({
            type: "POST",
            url: base_url + "deactive_user",
            data: "id=" + item_id + "&status=" + status,
            dataType: "json",
            success: function (res) {
                // console.log(res);
                if (res.status == 1)
                {
                    toastr.options = {
                        "closeButton": true,
                        "debug": false,
                        "newestOnTop": true,
                        "progressBar": false,
                        "positionClass": "toast-top-right",
                        "preventDuplicates": false,
                        "onclick": null,
                        "showDuration": "300",
                        "hideDuration": "1000",
                        "timeOut": "5000",
                        "extendedTimeOut": "1000",
                        "showEasing": "swing",
                        "hideEasing": "linear",
                        "showMethod": "fadeIn",
                        "hideMethod": "fadeOut",
                        "priority": 'success'
                    }
                    toastr.success(res.msg);
                    list_user.draw();
                } else {
                    toastr.options = {
                        "closeButton": true,
                        "debug": false,
                        "newestOnTop": true,
                        "progressBar": false,
                        "positionClass": "toast-top-right",
                        "preventDuplicates": false,
                        "onclick": null,
                        "showDuration": "300",
                        "hideDuration": "1000",
                        "timeOut": "5000",
                        "extendedTimeOut": "1000",
                        "showEasing": "swing",
                        "hideEasing": "linear",
                        "showMethod": "fadeIn",
                        "hideMethod": "fadeOut",
                        "priority": 'error'
                    }
                    toastr.error(res.msg);
                }
            }
        });
    }
}