@extends('layout.malay_layout.default')

@section('content')

<?php
$insert_permission = 0;
$update_permission = 0;

foreach ($user_permission as $permission) {
    if ($permission->submodule_id == 5) {
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
                    <button onclick="window.location = '{{ URL::action('AdminController@addAccessGroup') }}'" type="button" class="btn btn-primary">
                        Tambah Akses Kumpulan
                    </button>
                    <br/><br/>
                    <?php } ?>
                    <table class="table table-hover nowrap" id="accessgroup" width="100%">
                        <thead>
                            <tr>
                                <th style="width:40%;">Nama</th>
                                <th style="width:40%;">Catatan</th>
                                <th style="width:10%;">{{ trans('app.forms.status') }}</th>
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
        oTable = $('#accessgroup').DataTable({
            "sAjaxSource": "{{URL::action('AdminController@getAccessGroups')}}",
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

    function inactiveAccessGroup(id) {
        $.ajax({
            url: "{{ URL::action('AdminController@inactiveAccessGroup') }}",
            type: "POST",
            data: {
                id: id
            },
            success: function(data) {
                if (data.trim() == "true") {
                    bootbox.alert("<span style='color:green;'>Kemaskini status berjaya!</span>", function() {
                        window.location = "{{URL::action('AdminController@accessGroups')}}";
                    });
                } else {
                    bootbox.alert("<span style='color:red;'>Ralat. Sila cuba lagi.</span>");
                }
            }
        });
    }

    function activeAccessGroup(id) {
        $.ajax({
            url: "{{ URL::action('AdminController@activeAccessGroup') }}",
            type: "POST",
            data: {
                id: id
            },
            success: function(data) {
                if (data.trim() == "true") {
                    bootbox.alert("<span style='color:green;'>Kemaskini status berjaya!</span>", function() {
                        window.location = "{{URL::action('AdminController@accessGroups')}}";
                    });
                } else {
                    bootbox.alert("<span style='color:red;'>Ralat. Sila cuba lagi.</span>");
                }
            }
        });
    }

    function deleteAccessGroup (id) {
        swal({
            title: "Anda pasti?",
            text: "{{ trans('app.confirmation.no_recover_file') }}",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-warning",
            cancelButtonClass: "btn-default",
            cancelButtonText: "Batal",
            confirmButtonText: "Padam",
            closeOnConfirm: true
        },
        function(){
            $.ajax({
                url: "{{ URL::action('AdminController@deleteAccessGroup') }}",
                type: "POST",
                data: {
                    id: id
                },
                success: function(data) {
                    if (data.trim() == "true") {
                        swal({
                            title: "Dipadam!",
                            text: "Fail telah dipadam",
                            type: "success",
                            confirmButtonClass: "btn-success",
                            closeOnConfirm: false
                        });
                        location.reload();
                    } else {
                        bootbox.alert("<span style='color:red;'>Ralat. Sila cuba lagi.</span>");
                    }
                }
            });
        });
    }
</script>

@stop
