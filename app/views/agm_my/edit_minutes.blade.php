@extends('layout.malay_layout.default')

@section('content')

<?php
$update_permission = 0;

foreach ($user_permission as $permission) {
    if ($permission->submodule_id == 32) {
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
                    <form id="">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label style="color: red; font-style: italic;">* {{ trans('app.forms.mandatory_fields') }}</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label class="form-control-label"><span style="color: red; font-style: italic;">*</span> {{ trans('app.forms.file_no') }}</label>
                            </div>
                            <div class="col-md-6">
                                <select id="file_id" class="form-control">
                                    <option value="">{{ trans('app.forms.please_select') }}</option>
                                    @foreach ($files as $file)
                                    <option value="{{$file->id}}" {{($file->id == $meeting_doc->file_id ? " selected" : "")}}>{{$file->file_no}}</option>
                                    @endforeach
                                </select>
                                <div id="file_id_error" style="display:none;"></div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label class="form-control-label">{{ trans('app.forms.agm_date') }}</label>
                            </div>
                            <div class="col-md-4">
                                <label class="input-group datepicker-only-init">
                                    <input type="text" class="form-control datepicker" placeholder="{{ trans('app.forms.agm_date') }}" id="agm_date" value="{{ $meeting_doc->agm_date }}"/>
                                    <span class="input-group-addon">
                                        <i class="icmn-calendar"></i>
                                    </span>
                                </label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label class="form-control-label">{{ trans('app.forms.annual_general_meeting') }}</label>
                            </div>
                            <div class="col-md-2">
                                <input type="radio" id="agm" name="agm" value="1" {{($meeting_doc->agm == 1 ? " checked" : "")}}> {{ trans('app.forms.yes') }}
                            </div>
                            <div class="col-md-2">
                                <input type="radio" id="agm" name="agm" value="0" {{($meeting_doc->agm == 0 ? " checked" : "")}}> {{ trans('app.forms.no') }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label class="form-control-label">{{ trans('app.forms.extra_general_meeting') }}</label>
                            </div>
                            <div class="col-md-2">
                                <input type="radio" id="egm" name="egm" value="1" {{($meeting_doc->egm == 1 ? " checked" : "")}}> {{ trans('app.forms.yes') }}
                            </div>
                            <div class="col-md-2">
                                <input type="radio" id="egm" name="egm" value="0" {{($meeting_doc->egm == 0 ? " checked" : "")}}> {{ trans('app.forms.no') }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label class="form-control-label">{{ trans('app.forms.meeting_minutes') }}</label>
                            </div>
                            <div class="col-md-2">
                                <input type="radio" id="minit_meeting" name="minit_meeting" value="1" {{($meeting_doc->minit_meeting == 1 ? " checked" : "")}}> {{ trans('app.forms.yes') }}
                            </div>
                            <div class="col-md-2">
                                <input type="radio" id="minit_meeting" name="minit_meeting" value="0" {{($meeting_doc->minit_meeting == 0 ? " checked" : "")}}> {{ trans('app.forms.no') }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label class="form-control-label">{{ trans('app.forms.jmc_spa_copy') }}</label>
                            </div>
                            <div class="col-md-2">
                                <input type="radio" id="jmc_copy" name="jmc_copy" value="1" {{($meeting_doc->jmc_spa == 1 ? " checked" : "")}}> {{ trans('app.forms.yes') }}
                            </div>
                            <div class="col-md-2">
                                <input type="radio" id="jmc_copy" name="jmc_copy" value="0" {{($meeting_doc->jmc_spa == 0 ? " checked" : "")}}> {{ trans('app.forms.no') }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label class="form-control-label">{{ trans('app.forms.identity_card_list') }}</label>
                            </div>
                            <div class="col-md-2">
                                <input type="radio" id="ic_list" name="ic_list" value="1" {{($meeting_doc->identity_card == 1 ? " checked" : "")}}> {{ trans('app.forms.yes') }}
                            </div>
                            <div class="col-md-2">
                                <input type="radio" id="ic_list" name="ic_list" value="0" {{($meeting_doc->identity_card == 0 ? " checked" : "")}}> {{ trans('app.forms.no') }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label class="form-control-label">{{ trans('app.forms.attendance_list') }}</label>
                            </div>
                            <div class="col-md-2">
                                <input type="radio" id="attendance_list" name="attendance_list" value="1" {{($meeting_doc->attendance == 1 ? " checked" : "")}}> {{ trans('app.forms.yes') }}
                            </div>
                            <div class="col-md-2">
                                <input type="radio" id="attendance_list" name="attendance_list" value="0" {{($meeting_doc->attendance == 0 ? " checked" : "")}}> {{ trans('app.forms.no') }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label class="form-control-label">{{ trans('app.forms.audited_financial_report') }}</label>
                            </div>
                            <div class="col-md-2">
                                <input type="radio" id="audited_financial_report" name="audited_financial_report" value="1" {{($meeting_doc->financial_report == 1 ? " checked" : "")}}> {{ trans('app.forms.yes') }}
                            </div>
                            <div class="col-md-2">
                                <input type="radio" id="audited_financial_report" name="audited_financial_report" value="0" {{($meeting_doc->financial_report == 0 ? " checked" : "")}}> {{ trans('app.forms.no') }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label class="form-control-label">{{ trans('app.forms.financial_audit_start_date') }}</label>
                            </div>
                            <div class="col-md-4">
                                <label class="input-group datepicker-only-init">
                                    <input type="text" class="form-control datepicker" placeholder="Start Date" id="audit_start" value="{{ $meeting_doc->audit_start_date }}"/>
                                    <span class="input-group-addon">
                                        <i class="icmn-calendar"></i>
                                    </span>
                                </label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label class="form-control-label">{{ trans('app.forms.financial_audit_end_date') }}</label>
                            </div>
                            <div class="col-md-4">
                                <label class="input-group datepicker-only-init">
                                    <input type="text" class="form-control datepicker" placeholder="End Date" id="audit_end" value="{{ $meeting_doc->audit_end_date }}"/>
                                    <span class="input-group-addon">
                                        <i class="icmn-calendar"></i>
                                    </span>
                                </label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label class="form-control-label">{{ trans('app.forms.financial_audit_report') }}</label>
                            </div>
                            <div class="col-md-6">
                                <input type="text" class="form-control" placeholder="{{ trans('app.forms.financial_audit_report') }}" id="audit_report" value="{{ $meeting_doc->audit_report }}"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label class="form-control-label">{{ trans('app.forms.remarks') }}</label>
                            </div>
                            <div class="col-md-6">
                                <textarea class="form-control" placeholder="{{ trans('app.forms.remarks') }}" id="remarks" rows="5">{{ $meeting_doc->remarks }}</textarea>
                            </div>
                        </div>
                        <div class="form-actions">
                            <?php if ($update_permission == 1) { ?>
                                <button type="button" class="btn btn-primary" id="submit_button" onclick="editMinutes()">{{ trans('app.forms.submit') }}</button>
                            <?php } ?>
                            <button type="button" class="btn btn-default" id="cancel_button" onclick="window.location ='{{URL::action('AgmController@minutes')}}'">{{ trans('app.forms.cancel') }}</button>
                            <img id="loading" style="display:none;" src="{{asset('assets/common/img/input-spinner.gif')}}"/>
                        </div>
                    </form>
                    <!-- End Form -->
                </div>
            </div>
        </div>
    </section>
    <!-- End -->
</div>

<!-- Page Scripts -->
<script>
    function editMinutes() {
        $("#loading").css("display", "inline-block");
        $("#submit_button").attr("disabled", "disabled");
        $("#cancel_button").attr("disabled", "disabled");

        $("#file_id_error").css("display", "none");

        var agm,
                egm,
                minit_meeting,
                jmc_copy,
                ic_list,
                attendance_list,
                audited_financial_report,
                file_id = $("#file_id").val(),
                agm_date = $("#agm_date").val(),
                audit_report = $("#audit_report").val(),
                audit_start = $("#audit_start").val(),
                remarks = $("#remarks").val(),
                audit_end = $("#audit_end").val();

        if (document.getElementById('agm').checked) {
            agm = 1;
        } else {
            agm = 0;
        }
        if (document.getElementById('egm').checked) {
            egm = 1;
        } else {
            egm = 0;
        }
        if (document.getElementById('minit_meeting').checked) {
            minit_meeting = 1;
        } else {
            minit_meeting = 0;
        }
        if (document.getElementById('jmc_copy').checked) {
            jmc_copy = 1;
        } else {
            jmc_copy = 0;
        }
        if (document.getElementById('ic_list').checked) {
            ic_list = 1;
        } else {
            ic_list = 0;
        }
        if (document.getElementById('attendance_list').checked) {
            attendance_list = 1;
        } else {
            attendance_list = 0;
        }
        if (document.getElementById('audited_financial_report').checked) {
            audited_financial_report = 1;
        } else {
            audited_financial_report = 0;
        }

        var error = 0;

        if (file_id.trim() == "") {
            $("#file_id_error").html('<span style="color:red;font-style:italic;font-size:13px;">{{ trans("app.errors.select", ["attribute"=>"File"]) }}</span>');
            $("#file_id").focus();
            $("#file_id_error").css("display", "block");
            error = 1;
        }

        if (error == 0) {
            $.ajax({
                url: "{{ URL::action('AgmController@submitEditMinutes') }}",
                type: "POST",
                data: {
                    agm_date: agm_date,
                    agm: agm,
                    egm: egm,
                    minit_meeting: minit_meeting,
                    jmc_copy: jmc_copy,
                    ic_list: ic_list,
                    attendance_list: attendance_list,
                    audited_financial_report: audited_financial_report,
                    audit_report: audit_report,
                    audit_start: audit_start,
                    audit_end: audit_end,
                    remarks: remarks,
                    file_id: file_id,
                    id: '{{ $meeting_doc->id }}'
                },
                success: function (data) {
                    $("#loading").css("display", "none");
                    $("#submit_button").removeAttr("disabled");
                    $("#cancel_button").removeAttr("disabled");

                    if (data.trim() == "true") {
                        $.notify({
                            message: '<p style="text-align: center; margin-bottom: 0px;">Successfully updated</p>',
                        }, {
                            type: 'success',
                            placement: {
                                align: "center"
                            }
                        });
                        location = '{{ URL::action("AgmController@minutes") }}';
                    } else {
                        bootbox.alert("<span style='color:red;'>{{ trans('app.errors.occurred') }}</span>");
                    }
                }
            });
        } else {
            $("#loading").css("display", "none");
            $("#submit_button").removeAttr("disabled");
            $("#cancel_button").removeAttr("disabled");
        }
    }

    $('.datepicker').datetimepicker({
        widgetPositioning: {
            horizontal: 'left'
        },
        icons: {
            time: "fa fa-clock-o",
            date: "fa fa-calendar",
            up: "fa fa-arrow-up",
            down: "fa fa-arrow-down"
        },
        format: 'YYYY-MM-DD'
    });
</script>
<!-- End Page Scripts-->

@stop
