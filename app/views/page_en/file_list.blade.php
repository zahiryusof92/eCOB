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
                                <th style="width:20%;">File Number</th>
                                <th style="width:10%;">Year</th>
                                <th style="width:30%;">Name</th>
                                <th style="width:10%;">Active</th>
                                <th style="width:10%;">Status</th>
                                <?php if ($update_permission == 1) { ?>
                                <th style="width:20%;">Action</th>
                                <?php } ?>
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
            "sAjaxSource": "{{URL::action('AdminController@getFileList')}}",
            "lengthMenu": [
                [15, 30, 50, 100, -1],
                [15, 30, 50, 100, "All"]
            ],
            "responsive": true,
            "aoColumnDefs": [
                {
                    "bSortable": false,
                    "aTargets": [-1]
                }
            ],
            "sorting": [
                [4, "asc"]
            ]
        });
    }); 
        
    function inactiveFileList(id) {
        $.ajax({
            url: "{{ URL::action('AdminController@inactiveFileList') }}",
            type: "POST",
            data: {
                id: id
            },
            success: function(data) {
                if (data.trim() == "true") {
                    bootbox.alert("<span style='color:green;'>Status update successfully!</span>", function() {
                        window.location = "{{URL::action('AdminController@fileList')}}";
                    });
                } else {
                    bootbox.alert("<span style='color:red;'>An error occured while processing. Please try again.</span>");
                }
            }
        });
    }

    function activeFileList(id) {
        $.ajax({
            url: "{{ URL::action('AdminController@activeFileList') }}",
            type: "POST",
            data: {
                id: id
            },
            success: function(data) {
                if (data.trim() == "true") {
                    bootbox.alert("<span style='color:green;'>Status update successfully!</span>", function() {
                        window.location = "{{URL::action('AdminController@fileList')}}";
                    });
                } else {
                    bootbox.alert("<span style='color:red;'>An error occured while processing. Please try again.</span>");
                }
            }
        });
    }
    
    function deleteFileList(id) {
        bootbox.confirm("Are you sure want to delete this file?", function(result){
            if (result) {
                $.ajax({
                    url: "{{ URL::action('AdminController@deleteFileList') }}",
                    type: "POST",
                    data: {
                        id: id
                    },
                    success: function(data) {
                        if (data.trim() == "true") {
                            bootbox.alert("<span style='color:green;'>Delete successfully!</span>", function() {
                                window.location = "{{URL::action('AdminController@fileList')}}";
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