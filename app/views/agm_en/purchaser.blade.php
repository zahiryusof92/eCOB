@extends('layout.english_layout.default')

@section('content')

<?php
$insert_permission = 0;
$update_permission = 0;

foreach ($user_permission as $permission) {
    if ($permission->submodule_id == 31) {
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
                        <button onclick="window.location = '{{ URL::action('AgmController@addPurchaser') }}'" type="button" class="btn btn-primary">
                            Add Purchaser
                        </button>
                        &nbsp;
                        <button onclick="window.location = '{{ URL::action('AgmController@importPurchaser') }}'" type="button" class="btn btn-primary">
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
                    <div class="table-responsive">
                        <table class="table table-hover nowrap" id="purchaser" style="font-size: 13px;">
                            <thead>
                                <tr>
                                    <!--<th style="width:5%;">No</th>-->
                                    <th style="width:10%;">Unit No</th>
                                    <th style="width:10%;">Share Unit</th>
                                    <th style="width:20%;">Buyer</th>
                                    <th style="width:15%;">NRIC</th>
                                    <th style="width:10%;">Phone No</th>
                                    <th style="width:20%;">Email</th>
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
        $('#purchaser').DataTable({
            "sAjaxSource": "{{URL::action('AgmController@getPurchaser')}}",
            "order": [[0, "asc"]],
            "responsive": false
        });
    });
    
    function deletePurchaser(id) {
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
    url: "{{ URL::action('AgmController@deletePurchaser') }}",
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