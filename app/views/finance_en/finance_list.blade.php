@extends('layout.english_layout.default')

@section('content')

<?php
$update_permission = 0;

foreach ($user_permission as $permission) {
    if ($permission->submodule_id == 3) {
        $update_permission = $permission->update_permission;
    }
}
?>

<div class="page-content-inner">
    <section class="panel panel-with-borders">
        <div class="panel-heading">
            <h3>{{$title}}</h3>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-lg-12">
                    <table class="table table-hover nowrap" id="filelist" width="100%">
                        <thead>
                            <tr>
                                <th style="width:30%;">Finance Management</th>
                                <th style="width:10%;">Strata</th>
                                <th style="width:10%;">Status</th>
                                <th style="width:10%;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>            
        </div>
    </section>    
    <!-- End  -->
</div>

<!-- Page Scripts -->
<script>
    var oTable;
    $(document).ready(function () {
        oTable = $('#filelist').DataTable({
            "sAjaxSource": "{{URL::action('FinanceController@getFinanceList')}}",
            "lengthMenu": [[15, 30, 50, -1], [15, 30, 50, "All"]],
            "order": [[3, "asc"]],
            responsive: true
        });
    });

    $('#year').on('change', function () {
        oTable.columns(1).search(this.value).draw();
    });
    $('#month').on('change', function () {
        oTable.columns(0).search(this.value).draw();
    });

    function inactiveFinanceList(id) {
        $.ajax({
            url: "{{ URL::action('FinanceController@inactiveFinanceList') }}",
            type: "POST",
            data: {
                id: id
            },
            success: function (data) {
                if (data.trim() == "true") {
                    bootbox.alert("<span style='color:green;'>Status update successfully!</span>", function () {
                        window.location = "{{URL::action('FinanceController@financeList')}}";
                    });
                } else {
                    bootbox.alert("<span style='color:red;'>An error occured while processing. Please try again.</span>");
                }
            }
        });
    }

    function activeFinanceList(id) {
        $.ajax({
            url: "{{ URL::action('FinanceController@activeFinanceList') }}",
            type: "POST",
            data: {
                id: id
            },
            success: function (data) {
                if (data.trim() == "true") {
                    bootbox.alert("<span style='color:green;'>Status update successfully!</span>", function () {
                        window.location = "{{URL::action('FinanceController@financeList')}}";
                    });
                } else {
                    bootbox.alert("<span style='color:red;'>An error occured while processing. Please try again.</span>");
                }
            }
        });
    }

    function deleteFileList(id) {
        bootbox.confirm("Are you sure want to delete this file?", function (result) {
            if (result) {
                $.ajax({
                    url: "{{ URL::action('FinanceController@deleteFinanceList') }}",
                    type: "POST",
                    data: {
                        id: id
                    },
                    success: function (data) {
                        if (data.trim() == "true") {
                            bootbox.alert("<span style='color:green;'>Delete successfully!</span>", function () {
                                window.location = "{{URL::action('FinanceController@financeList')}}";
                            });
                        } else {
                            bootbox.alert("<span style='color:red;'>An error occured while processing. Please try again.</span>");
                        }
                    }
                });
            }
        });
    }
</script>

@stop