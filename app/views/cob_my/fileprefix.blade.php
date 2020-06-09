@extends('layout.malay_layout.default')

@section('content')

<?php
$insert_permission = 0;
$update_permission = 0;

foreach ($user_permission as $permission) {
    if ($permission->submodule_id == 1) {
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
                    <button onclick="window.location = '{{ URL::action('AdminController@addFilePrefix') }}'" type="button" class="btn btn-primary">
                        Tambah Awalan Fail COB
                    </button>
                    <br/><br/>
                    <?php } ?>
                    <table class="table table-hover nowrap" id="fileprefix" width="100%">
                        <thead>
                            <tr>
                                <th style="width:70%;">Penerangan</th>
                                <th style="width:30%;">Status</th>
                                <?php if ($update_permission == 1) { ?>
                                <th style="width:10%;">Aksi</th>
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
        oTable = $('#fileprefix').DataTable({
            "sAjaxSource": "{{URL::action('AdminController@getFilePrefix')}}",
            "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            "order": [[ 0, "asc" ]],
            responsive: true,
            "aoColumnDefs": [
                {
                    "bSortable": false,
                    "aTargets": [-1]
                }
            ]
        });
    }); 
    
    function inactiveFilePrefix(id) {
        $.ajax({
            url: "{{ URL::action('AdminController@inactiveFilePrefix') }}",
            type: "POST",
            data: {
                id: id
            },
            success: function(data) {
                if (data.trim() == "true") {
                    bootbox.alert("<span style='color:green;'>Kemaskini Status berjaya!</span>", function() {
                        window.location = "{{URL::action('AdminController@filePrefix')}}";
                    });
                } else {
                    bootbox.alert("<span style='color:red;'>Terdapat masalah ketika prosess. Sila cuba lagi.</span>");
                }
            }
        });
    }

    function activeFilePrefix(id) {
        $.ajax({
            url: "{{ URL::action('AdminController@activeFilePrefix') }}",
            type: "POST",
            data: {
                id: id
            },
            success: function(data) {
                if (data.trim() == "true") {
                    bootbox.alert("<span style='color:green;'>Kemaskini Status berjaya!</span>", function() {
                        window.location = "{{URL::action('AdminController@filePrefix')}}";
                    });
                } else {
                    bootbox.alert("<span style='color:red;'Terdapat masalah ketika prosess. Sila cuba lagi.</span>");
                }
            }
        });
    }
    
    function deleteFilePrefix (id) {
        swal({
            title: "Anda pasti?",
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
                url: "{{ URL::action('AdminController@deleteFilePrefix') }}",
                type: "POST",
                data: {
                    id: id
                },
                success: function(data) {
                    if (data.trim() == "true") {
                        swal({
                            title: "Padam!",
                            text: "Fail telah dipadam",
                            type: "success",
                            confirmButtonClass: "btn-success",
                            closeOnConfirm: false
                        });
                        location.reload();
                    } else {
                        bootbox.alert("<span style='color:red;'>Terdapat masalah ketika prosess. Sila cuba lagi.</span>");
                    }
                }
            });
        });
    }
</script>

@stop