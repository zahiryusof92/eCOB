@extends('layout.malay_layout.default')

@section('content')

<?php
$update_permission = 0;

foreach ($user_permission as $permission) {
    if ($permission->submodule_id == 6) {
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
            <dl class="dl-horizontal">
                <dt>Username</dt>
                <dd>{{($user->username != "" ? $user->username : "-")}}</dd>
                <dt>Nama Penuh</dt>
                <dd>{{($user->full_name != "" ? $user->full_name : "-")}}</dd>
                <dt>E-mel</dt>
                <dd>{{($user->email != "" ? $user->email : "-")}}</dd>
                <dt>No. Telefon</dt>
                <dd>{{($user->phone_no != "" ? $user->phone_no : "-")}}</dd>
                <dt>Aktif</dt>
                @if ($user->is_active == 1)
                <dd>Ya</dd>
                @else
                <dd>Tidak</dd>
                @endif

                @if ($user->status == 0)
                <dt>{{ trans('app.forms.status') }}</dt>
                <dd>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <select id="status" class="form-control">
                                    <option value="">Sila pilih</option>
                                    <option value="1">Terima</option>
                                    <option value="2">Tolak</option>
                                </select>
                                <div id="status_error" style="display:none;"></div>
                            </div>
                        </div>
                    </div>
                </dd>
                <dt>Catatan</dt>
                <dd>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <textarea class="form-control" rows="3" placeholder="Catatan" id="remarks"></textarea>
                            </div>
                        </div>
                    </div>
                </dd>
                <div class="form-actions">
                    <dt>&nbsp;</dt>
                    <dd>
                        <?php if ($update_permission == 1) { ?>
                            <button type="button" class="btn btn-primary" id="submit_button" onclick="approvedUser()">Simpan</button>
                        <?php } ?>
                        <button type="button" class="btn btn-default" id="cancel_button" onclick="window.location ='{{URL::action('AdminController@user')}}'">Batal</button>
                    </dd>
                </div>
                @else
                <?php $admin = User::find($user->approved_by); ?>
                @if ($user->status == 1)
                <dt>{{ trans('app.forms.status') }}</dt>
                <dd>Diterima</dd>
                <dt>Diterima Oleh</dt>
                <dd>{{($admin->full_name != "" ? $admin->full_name : "-")}}</dd>
                <dt>Tarikh Diterima</dt>
                <dd>{{(date('Y-m-d', strtotime($user->approved_at)) != "" ? date('Y-m-d', strtotime($user->approved_at)) : "-")}}</dd>
                <dt>Catatan</dt>
                <dd>{{($user->remarks != "" ? $user->remarks : "-")}}</dd>
                @else
                <dt>{{ trans('app.forms.status') }}</dt>
                <dd>Ditolak</dd>
                <dt>Ditolak Oleh</dt>
                <dd>{{($admin->full_name != "" ? $admin->full_name : "-")}}</dd>
                <dt>Tarikh Ditolak</dt>
                <dd>{{(date('Y-m-d', strtotime($user->approved_at)) != "" ? date('Y-m-d', strtotime($user->approved_at)) : "-")}}</dd>
                <dt>Catatan</dt>
                <dd>{{($user->remarks != "" ? $user->remarks : "-")}}</dd>
                @endif
                <div class="form-actions">
                    <dt>&nbsp;</dt>
                    <dd>
                        <button type="button" class="btn btn-default" id="cancel_button" onclick="window.history.back()">Kembali</button>
                    </dd>
                </div>
                @endif
            </dl>
        </div>
    </section>
    <!-- End -->
</div>

<!-- Page Scripts -->
<script>

    function approvedUser() {
        $("#loading").css("display", "inline-block");
        $("#status_error").css("display", "none");

        var status = $("#status").val(),
                remarks = $("#remarks").val();

        var error = 0;

        if (status.trim() === "") {
            $("#status_error").html('<span style="color:red;font-style:italic;font-size:13px;">Sila pilih Status</span>');
            $("#status_error").css("display", "block");
            error = 1;
        }

        if (error === 0) {
            $.ajax({
                url: "{{ URL::action('AdminController@submitApprovedUser') }}",
                type: "POST",
                data: {
                    status: status,
                    remarks: remarks,
                    id: '{{$user->id}}'
                },
                success: function (data) {
                    $("#loading").css("display", "none");
                    $("#submit_button").removeAttr("disabled");
                    $("#cancel_button").removeAttr("disabled");
                    if (data.trim() === "true") {
                        bootbox.alert("<span style='color:green;'>Edit Pengguna berjaya!</span>", function () {
                            window.location = '{{URL::action("AdminController@user") }}';
                        });
                    } else {
                        bootbox.alert("<span style='color:red;'>Ralat. Sila cuba lagi.</span>");
                    }
                }
            });
        }
    }
</script>
<!-- End Page Scripts-->

@stop
