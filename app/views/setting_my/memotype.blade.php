@extends('layout.malay_layout.default')

@section('content')

<?php
$insert_permission = 0;
$update_permission = 0;

foreach ($user_permission as $permission) {
    if ($permission->submodule_id == 19) {
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
                    <button onclick="window.location = '{{ URL::action('AdminController@addMemoType') }}'" type="button" class="btn btn-primary">
                        Tambah Jenis Memo
                    </button>
                    <br/><br/>
                    <?php } ?>
                    <table class="table table-hover nowrap" id="memotype" width="100%">
                        <thead>
                            <tr>
                                <th style="width:70%;">Penerangan</th>
                                <th style="width:20%;">{{ trans('app.forms.status') }}</th>
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
        oTable = $('#memotype').DataTable({
            "sAjaxSource": "{{URL::action('AdminController@getMemoType')}}",
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

    function inactiveMemoType(id) {
        $.ajax({
            url: "{{ URL::action('AdminController@inactiveMemoType') }}",
            type: "POST",
            data: {
                id: id
            },
            success: function(data) {
                if (data.trim() == "true") {
                    bootbox.alert("<span style='color:green;'>Status berjaya dikemaskini!</span>", function() {
                        window.location = "{{URL::action('AdminController@memoType')}}";
                    });
                } else {
                    bootbox.alert("<span style='color:red;'>Ralat. Sila cuba lagi.</span>");
                }
            }
        });
    }

    function activeMemoType(id) {
        $.ajax({
            url: "{{ URL::action('AdminController@activeMemoType') }}",
            type: "POST",
            data: {
                id: id
            },
            success: function(data) {
                if (data.trim() == "true") {
                    bootbox.alert("<span style='color:green;'>Status berjaya dikemaskini!</span>", function() {
                        window.location = "{{URL::action('AdminController@memoType')}}";
                    });
                } else {
                    bootbox.alert("<span style='color:red;'>Ralat. Sila cuba lagi.</span>");
                }
            }
        });
    }

    function deleteMemoType (id) {
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
                url: "{{ URL::action('AdminController@deleteMemoType') }}",
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
