@extends('layout.english_layout.default')

@section('content')

<?php
$insert_permission = 0;
$update_permission = 0;

foreach ($user_permission as $permission) {
    if ($permission->submodule_id == 40) {
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
                        <button onclick="window.location = '{{ URL::action('AdminController@addRating') }}'" type="button" class="btn btn-primary">
                            Add Rating
                        </button>
                        <br/><br/>
                    <?php } ?>
                    <table class="table table-hover nowrap" id="rating" width="100%">
                        <thead>
                            <tr>
                                <th style="width:30%;">File No</th>
                                <th style="width:15%;">Date</th>
                                <th style="width:5%;">A (%)</th>
                                <th style="width:5%;">B (%)</th>
                                <th style="width:5%;">C (%)</th>
                                <th style="width:5%;">D (%)</th>
                                <th style="width:5%;">E (%)</th>
                                <th style="width:10%;">Score (%)</th>
                                <th style="width:10%;">Rating</th>
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
        oTable = $('#rating').DataTable({
            "sAjaxSource": "{{URL::action('AdminController@getRating')}}",
            "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            "order": [[1, "desc"]],
            responsive: true,
            "aoColumnDefs": [
                {
                    "bSortable": false,
                    "aTargets": [-2, -1]
                }
            ]
        });
    });

    function deleteRating(id) {
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
                url: "{{ URL::action('AdminController@deleteRating') }}",
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