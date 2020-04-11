@extends('layout.malay_layout.default')

@section('content')

<?php
$insert_permission = 0;
$update_permission = 0;

foreach ($user_permission as $permission) {
    if ($permission->submodule_id == 17) {
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
                    <button onclick="window.location = '{{ URL::action('AdminController@addDun') }}'" type="button" class="btn btn-primary">
                        Tambah DUN
                    </button>
                    <br/><br/>
                    <?php } ?>
                    <div class="row">
                        <div class="form-group">
                            <label  class="col-md-offset-2 col-md-1 control-label">Parliament:</label>
                            <div class="col-sm-3">
                                <select id="parliaments" class="form-control">
                                    <option value="">Semua</option>
                                    @foreach ($parliament as $parliaments) 
                                    <option value="{{$parliaments->description}}">{{$parliaments->description}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div> 
                    
                    <table class="table table-hover nowrap" id="dun" width="100%">
                        <thead>
                            <tr>
                                <th style="width:40%;">DUN</th>
                                <th style="width:40%;">Parlimen</th>
                                <th style="width:10%;">Status</th>
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
        oTable = $('#dun').DataTable({
            "sAjaxSource": "{{URL::action('AdminController@getDun')}}",
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
    
    $('#parliaments').on('change', function (){
        oTable.columns(1).search(this.value).draw();
    });
    
    function inactiveDun(id) {
        $.ajax({
            url: "{{ URL::action('AdminController@inactiveDun') }}",
            type: "POST",
            data: {
                id: id
            },
            success: function(data) {
                if (data.trim() == "true") {
                    bootbox.alert("<span style='color:green;'>Status berjaya dikemaskini!</span>", function() {
                        window.location = "{{URL::action('AdminController@dun')}}";
                    });
                } else {
                    bootbox.alert("<span style='color:red;'>Ralat. Sila cuba lagi.</span>");
                }
            }
        });
    }

    function activeDun(id) {
        $.ajax({
            url: "{{ URL::action('AdminController@activeDun') }}",
            type: "POST",
            data: {
                id: id
            },
            success: function(data) {
                if (data.trim() == "true") {
                    bootbox.alert("<span style='color:green;'>Status berjaya dikemaskini!</span>", function() {
                        window.location = "{{URL::action('AdminController@dun')}}";
                    });
                } else {
                    bootbox.alert("<span style='color:red;'>Ralat. Sila cuba lagi.</span>");
                }
            }
        });
    }
    
    function deleteDun(id) {
        swal({
            title: "Anda pasti?",
            text: "Your will not be able to recover this file!",
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
                url: "{{ URL::action('AdminController@deleteDun') }}",
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