@extends('layout.english_layout.default')

@section('content')

<?php
$insert_permission = 0;
$update_permission = 0;

foreach ($user_permission as $permission) {
    if ($permission->submodule_id == 33) {
        $insert_permission = $permission->insert_permission;
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
                    <?php if ($insert_permission == 1) { ?>
                        <button onclick="window.location = '{{ URL::action('AgmController@addDocument') }}'" type="button" class="btn btn-primary">
                            Add Document
                        </button>
                        <br/><br/>
                    <?php } ?>
                    <table class="table table-hover nowrap" id="document" width="100%">
                        <thead>
                            <tr>
                                <th style="width:20%;">File No</th>
                                <th style="width:15%;">Document Type</th>
                                <th style="width:35%;">Document Name</th>
                                <th style="width:10%;">Hidden</th>
                                <th style="width:10%;">Read Only</th>
                                <?php if ($update_permission == 1) { ?>
                                    <th style="width:10%;">Action</th>
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
        oTable = $('#document').DataTable({
            "sAjaxSource": "{{URL::action('AgmController@getDocument')}}",
            "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            "order": [[2, "asc"]],
            "responsive": true,
            "aoColumnDefs": [
                {
                    "bSortable": false,
                    "aTargets": [-1]
                }
            ]
        });
    });

    function inactiveDocument(id) {
        $.ajax({
            url: "{{ URL::action('AgmController@inactiveDocument') }}",
            type: "POST",
            data: {
                id: id
            },
            success: function (data) {
                if (data.trim() == "true") {
                    bootbox.alert("<span style='color:green;'>Status update successfully!</span>", function () {
                        window.location = "{{URL::action('AgmController@document')}}";
                    });
                } else {
                    bootbox.alert("<span style='color:red;'>An error occured while processing. Please try again.</span>");
                }
            }
        });
    }

    function activeDocument(id) {
        $.ajax({
            url: "{{ URL::action('AgmController@activeDocument') }}",
            type: "POST",
            data: {
                id: id
            },
            success: function (data) {
                if (data.trim() == "true") {
                    bootbox.alert("<span style='color:green;'>Status update successfully!</span>", function () {
                        window.location = "{{URL::action('AgmController@document')}}";
                    });
                } else {
                    bootbox.alert("<span style='color:red;'>An error occured while processing. Please try again.</span>");
                }
            }
        });
    }

    function deleteDocument(id) {
        swal({
            title: "Are you sure?",
            text: "Your will not be able to recover this file!",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-warning",
            cancelButtonClass: "btn-default",
            confirmButtonText: "Delete",
            closeOnConfirm: true
        }, function () {
            $.ajax({
                url: "{{ URL::action('AgmController@deleteDocument') }}",
                type: "POST",
                data: {
                    id: id
                },
                success: function (data) {
                    if (data.trim() == "true") {
                        swal({
                            title: "Deleted!",
                            text: "File has been deleted",
                            type: "success",
                            confirmButtonClass: "btn-success",
                            closeOnConfirm: false
                        });
                        location.reload();
                    } else {
                        bootbox.alert("<span style='color:red;'>An error occured while processing. Please try again.</span>");
                    }
                }
            });
        });
    }
</script>

@stop