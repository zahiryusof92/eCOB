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
                                <a class="nav-link active">Buyer List</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{URL::action('AdminController@document', $files->id)}}">Document</a>
                            </li>
                        </ul>
                        <div class="tab-content padding-vertical-20">
                            <div class="tab-pane active" id="buyer_tab" role="tabpanel">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="table-responsive">
                                            <?php if ($update_permission == 1) { ?>
                                            <button onclick="window.location = '{{ URL::action('AdminController@addBuyer', $files->id) }}'" type="button" class="btn btn-primary">
                                                Add Buyer
                                            </button>
                                            &nbsp;
                                            <button onclick="window.location = '{{ URL::action('AdminController@importBuyer', $files->id) }}'" type="button" class="btn btn-primary">
                                                Import CSV
                                            </button>
                                            &nbsp;
                                            <a href="{{asset('files/buyer_template.csv')}}" target="_blank">
                                                <button type="button" class="btn btn-success pull-right">
                                                    Download CSV Template
                                                </button>
                                            </a> 
                                            <br/><br/>
                                            <?php } ?>
                                            <table class="table table-hover nowrap" id="buyer_list">
                                                <thead>
                                                    <tr>
                                                        <th style="width:5%;">No</th>
                                                        <th style="width:10%;">Unit No</th>
                                                        <th style="width:10%;">Unit Share</th>
                                                        <th style="width:50%;">Owner Name</th>
                                                        <th style="width:20%;">IC No / Company No</th>
                                                        <?php if ($update_permission == 1) { ?>
                                                        <th style="width:5%;">Action</th>
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
    <!-- End -->
</div>

<!-- Page Scripts -->
<script>
    $(document).ready(function () {
        $('#buyer_list').DataTable({
            "sAjaxSource": "{{URL::action('AdminController@getBuyerList', $files->id)}}",
            "order": [[0, "asc"]],
            "aoColumnDefs": [
                {
                    "bSortable": false,
                    "aTargets": [-1]
                }
            ]
        });
    });
    
    function deleteBuyer(id) {
        swal({
            title: "Are you sure?",
            text: "Your will not be able to recover this file!",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-warning",
            cancelButtonClass: "btn-default",
            confirmButtonText: "Delete",
            closeOnConfirm: true
        },
        function () {
            $.ajax({
                url: "{{ URL::action('AdminController@deleteBuyer') }}",
                type: "POST",
                data: {
                    id: id
                },
                success: function (data) {
                    if (data.trim() == "true") {
                        $.notify({
                            message: '<p style="text-align: center; margin-bottom: 0px;">Deleted Successfully</p>'
                        }, {
                            type: 'success',
                            placement: {
                                align: "center"
                            }
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
<!-- End Page Scripts-->

@stop