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
                    <h6>File No: {{$files->file_no}}</h6>
                    <div id="update_files_lists">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link" href="{{URL::action('AdminController@viewHouse', $files->id)}}">Skim Perumahan</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{URL::action('AdminController@viewStrata', $files->id)}}">Kawasan Pemajuan (STRATA)</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{URL::action('AdminController@viewManagement', $files->id)}}">Pihak Pengurusan</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{URL::action('AdminController@viewMonitoring', $files->id)}}">Pemantauan</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{URL::action('AdminController@viewOthers', $files->id)}}">Pelbagai</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{URL::action('AdminController@viewScoring', $files->id)}}">Pemarkahan Komponen Nilai</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{URL::action('AdminController@viewBuyer', $files->id)}}">Senarai Pembeli</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active">Pengesahan</a>
                            </li>
                        </ul>
                        <div class="tab-content padding-vertical-20">
                            <div class="tab-pane active" role="tabpanel">
                                <h4>Pengesahan Fail</h4>
                                @if ($files->status == 0)
                                @if ($role == 1)
                                <div class="row">
                                    <div class="col-lg-12">
                                        <!-- Form -->
                                        <form id="approval">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label style="color: red; font-style: italic;">* Medan Wajib Diisi</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label><span style="color: red;">*</span> Status</label>
                                                        <select class="form-control" id="approval_status">
                                                            <option value="-1">Sila pilih</option>                                                            
                                                            <option value="1" >Terima</option>
                                                            <option value="2" >Tolak</option>                                                            
                                                        </select>
                                                        <div id="approval_status_error" style="display:none;"></div>
                                                    </div>
                                                </div>
                                            </div> 
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <div class="form-group">
                                                        <label>Catatan</label>
                                                        <textarea class="form-control" rows="4" id="approval_remarks" placeholder="Catatan (jika ada)"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-actions">
                                                <button type="button" class="btn btn-primary" id="submit_button" onclick="submitFileApproval()">Simpan</button>
                                                <button type="button" class="btn btn-default" id="cancel_button" onclick="window.location ='{{URL::action('AdminController@fileList')}}'">Batal</button>
                                            </div>
                                        </form>
                                        <!-- End Form -->
                                    </div>
                                </div>
                                @else
                                <div class="row">
                                    <div class="col-lg-12">
                                        <dl class='dl-horizontal'>
                                            <dt>Status</dt>
                                            <dd>{{$status}}</dd>                                            
                                        </dl>
                                    </div>
                                </div>
                                @endif
                                @else                                
                                <dl class='dl-horizontal'>
                                    <dt>Status</dt>
                                    <dd>{{$status}}</dd>
                                    <dt>DIsahkan Oleh</dt>
                                    <dd>{{$approveBy->username != "" ? $approveBy->username : "-"}}</dd>
                                    <dt>Tarikh Disahkan</dt>
                                    <dd>{{$files->approved_at != "0000-00-00 00:00:00" ? $files->approved_at : "-"}}</dd>
                                    <dt>Catatan</dt>
                                    <dd>{{$files->remarks != "" ? $files->remarks : "-"}}</dd>
                                </dl>                                        
                                @endif
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
    function submitFileApproval() {
        $("#cancel_button").attr("disabled", "disabled");

        var approval_status = $("#approval_status").val(),
                approval_remarks = $("#approval_remarks").val();

        var error = 0;

        if (approval_status.trim() == "-1") {
            $("#approval_status_error").html('<span style="color:red;font-style:italic;font-size:13px;">Sila pilih Status</span>');
            $("#approval_status_error").css("display", "block");
            error = 1;
        }

        if (error == 0) {
            $.ajax({
                url: "{{ URL::action('AdminController@submitFileApproval') }}",
                type: "POST",
                data: {
                    approval_status: approval_status,
                    approval_remarks: approval_remarks,
                    id: '{{$files->id}}'
                },
                success: function (data) {
                    $("#cancel_button").removeAttr("disabled");
                    if (data.trim() == "true") {
                        bootbox.alert("<span style='color:green;'>Status berjaya dikemaskini!</span>", function () {
                            window.location = '{{ URL::action("AdminController@fileList") }}';
                        });
                    } else {
                        bootbox.alert("<span style='color:red;'>Ralat. Sila cuba lagi</span>");
                    }
                }
            });
        }
    }
</script>
<!-- End Page Scripts-->

@stop