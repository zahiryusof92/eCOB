@extends('layout.english_layout.default')

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
                <dt>Full Name</dt>
                <dd>{{($user->full_name != "" ? $user->full_name : "-")}}</dd>
                <dt>E-mail</dt>
                <dd>{{($user->email != "" ? $user->email : "-")}}</dd>
                <dt>Phone No.</dt>
                <dd>{{($user->phone_no != "" ? $user->phone_no : "-")}}</dd>
                <dt>COB</dt>
                <dd>{{($user->getCOB->name != "" ? $user->getCOB->name : "-")}}</dd>
                <dt>Access Group</dt>
                <dd>{{($user->getRole->name != "" ? $user->getRole->name : "-")}}</dd>                
                @if ($user->getRole->name == 'JMB' || $user->getRole->name == 'MC')
                <dt>Start Date</dt>
                <dd>{{($user->start_date != "" ? date('d-m-Y', strtotime($user->start_date)) : "-")}}</dd>
                <dt>End Date</dt>
                <dd>{{($user->end_date != "" ? date('d-m-Y', strtotime($user->end_date)) : "-")}}</dd>
                <dt>File No</dt>
                <dd>{{($user->getFile->file_no != "" ? $user->getFile->file_no : "-")}}</dd>
                @endif                
                <dt>Is Active</dt>
                <dd>{{ ($user->is_active == '1' ? 'Yes' : 'No') }}</dd>
                @if ($user->status == 0)
                <dt>Status</dt>
                <dd>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <select id="status" class="form-control">
                                    <option value="">Please choose</option>
                                    <option value="1">Approve</option>
                                    <option value="2">Reject</option>
                                </select>
                                <div id="status_error" style="display:none;"></div>
                            </div>
                        </div>
                    </div>
                </dd>
                <dt>Remarks</dt>
                <dd>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <textarea class="form-control" rows="3" placeholder="Remarks" id="remarks"></textarea>
                            </div>
                        </div>
                    </div>
                </dd>
                <div class="form-actions">
                    <dt>&nbsp;</dt>
                    <dd>
                        <?php if ($update_permission == 1) { ?>
                            <button type="button" class="btn btn-primary" id="submit_button" onclick="approvedUser()">Submit</button>
                        <?php } ?>
                        <button type="button" class="btn btn-default" id="cancel_button" onclick="window.location ='{{URL::action('AdminController@user')}}'">Cancel</button>
                    </dd>
                </div>
                @else      
                <?php $admin = User::find($user->approved_by); ?>
                @if ($user->status == 1)
                <dt>Status</dt>
                <dd>Approved</dd>
                <dt>Approved By</dt>
                <dd>{{($admin->full_name != "" ? $admin->full_name : "-")}}</dd>
                <dt>Approved Date</dt>
                <dd>{{($user->approved_at != "" ? date('d-m-Y', strtotime($user->approved_at)) : "-")}}</dd>
                <dt>Remarks</dt>
                <dd>{{($user->remarks != "" ? $user->remarks : "-")}}</dd>
                @else
                <dt>Status</dt>
                <dd>Rejected</dd>
                <dt>Rejected By</dt>
                <dd>{{($admin->full_name != "" ? $admin->full_name : "-")}}</dd>
                <dt>Rejected Date</dt>
                <dd>{{($user->approved_at != "" ? date('d-m-Y', strtotime($user->approved_at)) : "-")}}</dd>
                <dt>Catatan</dt>
                <dd>{{($user->remarks != "" ? $user->remarks : "-")}}</dd>
                @endif
                <div class="form-actions">
                    <dt>&nbsp;</dt>
                    <dd>
                        <button type="button" class="btn btn-default" id="cancel_button" onclick="window.history.back()">Back</button>
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
            $("#status_error").html('<span style="color:red;font-style:italic;font-size:13px;">Please choose Status</span>');
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
                        bootbox.alert("<span style='color:green;'>Update user succesfull!</span>", function () {
                            window.location = '{{URL::action("AdminController@user") }}';
                        });
                    } else {
                        bootbox.alert("<span style='color:red;'>An error occured while processing. Please try again.</span>");
                    }
                }
            });
        }
    }
</script>
<!-- End Page Scripts-->

@stop