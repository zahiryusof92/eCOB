@extends('layout.english_layout.default')

@section('content')

<?php
$insert_permission = 0;
$update_permission = 0;

foreach ($user_permission as $permission) {
    if ($permission->submodule_id == 7) {
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
                    <button onclick="window.location = '{{ URL::action('AdminController@addMemo') }}'" type="button" class="btn btn-primary">
                        Add Memo
                    </button>
                    <br/><br/>
                    <?php } ?>
                    <div class="row">
                        <div class="form-group">
                            <label  class="col-md-offset-2 col-md-1 control-label">Memo Type:</label>
                            <div class="col-sm-3">
                                <select id="memo_type" class="form-control">
                                    <option value="">All</option>
                                    @foreach ($memotype as $memotypes) 
                                    <option value="{{$memotypes->description}}">{{$memotypes->description}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div> 
                    
                    <table class="table table-hover nowrap" id="memo" width="100%">
                        <thead>
                            <tr>
                                <th style="width:10%;">Memo Date</th>
                                <th style="width:20%;">Memo Type</th>
                                <th style="width:40%;">Subject</th>
                                <th style="width:10%;">Publish Date</th>
                                <th style="width:10%;">Expired Date</th>
                                <th style="width:10%;">Status</th>
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
        oTable = $('#memo').DataTable({
            "sAjaxSource": "{{URL::action('AdminController@getMemo')}}",
            "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            "order": [[ 0, "desc" ]],
            responsive: true,
            "aoColumnDefs": [
                {
                    "bSortable": false,
                    "aTargets": [-1]
                }
            ]
        });
    });  
    
    $('#memo_type').on('change', function (){
        oTable.columns(1).search(this.value).draw();
    });
    
    function inactiveMemo(id) {
        $.ajax({
            url: "{{ URL::action('AdminController@inactiveMemo') }}",
            type: "POST",
            data: {
                id: id
            },
            success: function(data) {
                if (data.trim() == "true") {
                    bootbox.alert("<span style='color:green;'>Status update successfully!</span>", function() {
                        window.location = "{{URL::action('AdminController@memo')}}";
                    });
                } else {
                    bootbox.alert("<span style='color:red;'>An error occured while processing. Please try again.</span>");
                }
            }
        });
    }

    function activeMemo(id) {
        $.ajax({
            url: "{{ URL::action('AdminController@activeMemo') }}",
            type: "POST",
            data: {
                id: id
            },
            success: function(data) {
                if (data.trim() == "true") {
                    bootbox.alert("<span style='color:green;'>Status update successfully!</span>", function() {
                        window.location = "{{URL::action('AdminController@memo')}}";
                    });
                } else {
                    bootbox.alert("<span style='color:red;'>An error occured while processing. Please try again.</span>");
                }
            }
        });
    }
    
    function deleteMemo (id) {
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
        function(){
            $.ajax({
                url: "{{ URL::action('AdminController@deleteMemo') }}",
                type: "POST",
                data: {
                    id: id
                },
                success: function(data) {
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