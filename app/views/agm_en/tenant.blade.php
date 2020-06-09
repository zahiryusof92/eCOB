@extends('layout.english_layout.default')

@section('content')

<?php
$insert_permission = 0;
$update_permission = 0;

foreach ($user_permission as $permission) {
    if ($permission->submodule_id == 43) {
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
                        <button onclick="window.location = '{{ URL::action('AgmController@addTenant') }}'" type="button" class="btn btn-primary">
                            Add Tenant
                        </button>
                        &nbsp;
                        
                        @if (strtoupper(Auth::user()->getRole->name) != 'JMB')
                        <button onclick="window.location = '{{ URL::action('AgmController@importTenant') }}'" type="button" class="btn btn-primary">
                            Import CSV
                        </button>
                        &nbsp;
                        <a href="{{asset('files/tenant_template.csv')}}" target="_blank">
                            <button type="button" class="btn btn-success pull-right">
                                Download CSV Template
                            </button>
                        </a> 
                        @endif
                        
                        <br/><br/>
                    <?php } ?>
                    <div class="table-responsive">
                        <table class="table table-hover nowrap" id="tenant" width="100%">
                            <thead>
                                <tr>
                                    <th style="width:10%;">Unit No</th>                                    
                                    <th style="width:20%;">Tenant</th>
                                    <th style="width:15%;">NRIC</th>
                                    <th style="width:15%;">Phone No</th>
                                    <th style="width:20%;">Email</th>
                                    <th style="width:10%;">Race</th>
                                    <th style="width:10%;">Action</th>
                                </tr>
                            </thead>
                            <tbody>  
                            </tbody>
                        </table>
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
        $('#tenant').DataTable({
            "sAjaxSource": "{{URL::action('AgmController@getTenant')}}",
            "order": [[0, "asc"]],
            "responsive": false,
            "aoColumnDefs": [
                {
                    "bSortable": false,
                    "aTargets": [-1]
                }
            ]
        });
    });

    function deleteTenant(id) {
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
                url: "{{ URL::action('AgmController@deleteTenant') }}",
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