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
                    <h6>File No: {{$files->file_no}}</h6>
                    <div id="update_files_lists">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link" href="{{URL::action('AdminController@house', $files->id)}}">Housing Scheme</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{URL::action('AdminController@strata', $files->id)}}">Developed Area (STRATA)</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{URL::action('AdminController@management', $files->id)}}">Management</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{URL::action('AdminController@monitoring', $files->id)}}">Monitoring</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{URL::action('AdminController@others', $files->id)}}">Others</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{URL::action('AdminController@scoring', $files->id)}}">Scoring Component Value</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{URL::action('AdminController@buyer', $files->id)}}">Buyer List</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active">Document</a>
                            </li>
                        </ul>
                        <div class="tab-content padding-vertical-20">
                            <div class="tab-pane active" id="document_tab" role="tabpanel">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="table-responsive">
                                            <?php if ($update_permission == 1) { ?>
                                                <button onclick="window.location = '{{ URL::action('AdminController@addDocument', $files->id) }}'" type="button" class="btn btn-primary">
                                                    Add Document
                                                </button>
                                                <br/><br/>
                                            <?php } ?>
                                            <table class="table table-hover nowrap" id="document" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th style="width:25%;">Document Type</th>
                                                        <th style="width:45%;">Document Name</th>
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
                            </div>
                        </div>
                    </div>
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
            "sAjaxSource": "{{URL::action('AdminController@getDocument', $files->id)}}",
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