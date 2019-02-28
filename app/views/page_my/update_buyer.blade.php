@extends('layout.malay_layout.default')

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
                    <h6>No. Fail: {{$files->file_no}}</h6>
                    <div id="update_files_lists">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link" href="{{URL::action('AdminController@house', $files->id)}}">Skim Perumahan</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{URL::action('AdminController@strata', $files->id)}}">Kawasan Pemajuan (STRATA)</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{URL::action('AdminController@management', $files->id)}}">Pihak Pengurusan</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{URL::action('AdminController@monitoring', $files->id)}}">Pemantauan</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{URL::action('AdminController@others', $files->id)}}">Pelbagai</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{URL::action('AdminController@scoring', $files->id)}}">Pemarkahan Komponen Nilai</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" href="{{URL::action('AdminController@buyer', $files->id)}}">Senarai Pembeli</a>
                            </li>
                        </ul>
                        <div class="tab-content padding-vertical-20">
                            <div class="tab-pane active" id="buyer_tab" role="tabpanel">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="table-responsive">
                                            <?php if ($update_permission == 1) { ?>
                                            <button onclick="window.location = '{{ URL::action('AdminController@addBuyer', $files->id) }}'" type="button" class="btn btn-primary">
                                                Tambah Pembeli
                                            </button>
                                            &nbsp;
                                            <button onclick="window.location = '{{ URL::action('AdminController@importBuyer', $files->id) }}'" type="button" class="btn btn-primary">
                                                Import CSV
                                            </button>
                                            &nbsp;
                                            <a href="{{asset('files/buyer_template.csv')}}" target="_blank">
                                                <button type="button" class="btn btn-success pull-right">
                                                    Muat Turun Template CSV
                                                </button>
                                            </a>                                            
                                            <br/><br/>
                                            <?php } ?>
                                            <table class="table table-hover nowrap" id="buyer_list">
                                                <thead>
                                                    <tr>
                                                        <th style="width:5%;">No.</th>
                                                        <th style="width:10%;">No. Unit</th>
                                                        <th style="width:10%;">Unit Syer</th>
                                                        <th style="width:50%;">Nama Pemilik</th>
                                                        <th style="width:20%;">No. IC / No. Syarikat</th>
                                                        <?php if ($update_permission == 1) { ?>
                                                        <th style="width:5%;">Aksi</th>
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
            title: "Anda pasti ingin memadam pembeli ini?",
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