@extends('layout.malay_layout.default')

@section('content')

<?php
$insert_permission = 0;

foreach ($user_permission as $permission) {
    if ($permission->submodule_id == 32) {
        $insert_permission = $permission->insert_permission;
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
                                    <label style="color: red; font-style: italic;">* Mandatory Fields</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label class="form-control-label"><span style="color: red; font-style: italic;">*</span> File No</label>
                            </div>
                            <div class="col-md-6">
                                <select id="file_id" class="form-control select2">
                                    <option value="">Please select</option>
                                    @foreach ($files as $file) 
                                    <option value="{{$file->id}}">{{$file->file_no}}</option>
                                    @endforeach
                                </select>
                                <div id="file_id_error" style="display:none;"></div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label class="form-control-label">AGM Date</label>
                            </div>
                            <div class="col-md-4">
                                <label class="input-group datepicker-only-init">
                                    <input type="text" class="form-control datepicker" placeholder="AGM Date" id="agm_date"/>
                                    <span class="input-group-addon">
                                        <i class="icmn-calendar"></i>
                                    </span>
                                </label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label class="form-control-label">Anual General Meeting (AGM)</label>
                            </div>
                            <div class="col-md-2">
                                <input type="radio" id="agm" name="agm" value="1"> Yes
                            </div>
                            <div class="col-md-2">
                                <input type="radio" id="agm" name="agm" value="0"> No
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label class="form-control-label">Extraordinary General Meeting (EGM)</label>
                            </div>
                            <div class="col-md-2">
                                <input type="radio" id="egm" name="egm" value="1"> Yes
                            </div>
                            <div class="col-md-2">
                                <input type="radio" id="egm" name="egm" value="0"> No
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label class="form-control-label">Minit Meeting</label>
                            </div>
                            <div class="col-md-2">
                                <input type="radio" id="minit_meeting" name="minit_meeting" value="1"> Yes
                            </div>
                            <div class="col-md-2">
                                <input type="radio" id="minit_meeting" name="minit_meeting" value="0"> No
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label class="form-control-label">JMC SPA Copy</label>
                            </div>
                            <div class="col-md-2">
                                <input type="radio" id="jmc_copy" name="jmc_copy" value="1"> Yes
                            </div>
                            <div class="col-md-2">
                                <input type="radio" id="jmc_copy" name="jmc_copy" value="0"> No
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label class="form-control-label">Identity Card List</label>
                            </div>
                            <div class="col-md-2">
                                <input type="radio" id="ic_list" name="ic_list" value="1"> Yes
                            </div>
                            <div class="col-md-2">
                                <input type="radio" id="ic_list" name="ic_list" value="0"> No
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label class="form-control-label">Attendance List</label>
                            </div>
                            <div class="col-md-2">
                                <input type="radio" id="attendance_list" name="attendance_list" value="1"> Yes
                            </div>
                            <div class="col-md-2">
                                <input type="radio" id="attendance_list" name="attendance_list" value="0"> No
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label class="form-control-label">Audited Financial Report</label>
                            </div>
                            <div class="col-md-2">
                                <input type="radio" id="audited_financial_report" name="audited_financial_report" value="1"> Yes
                            </div>
                            <div class="col-md-2">
                                <input type="radio" id="audited_financial_report" name="audited_financial_report" value="0"> No
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label class="form-control-label">Financial Audit Report</label>
                            </div>
                            <div class="col-md-6">
                                <input type="text" class="form-control" placeholder="Financial Audit Report" id="audit_report"/>                            
                            </div>
                        </div>
                    </form>
                    <form id="upload_audit_report_file" enctype="multipart/form-data" method="post" action="{{ url('uploadAuditReportFile') }}" autocomplete="off">  
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label class="form-control-label">&nbsp;</label>
                            </div>
                            <div class="col-md-6">
                                <button type="button" id="clear_audit_report_file" class="btn btn-xs btn-danger" onclick="clearAuditFile()" style="display: none;"><i class="fa fa-times"></i></button>
                                &nbsp;
                                <input type="file" name="audit_report_file" id="audit_report_file">
                                <div id="validation-errors_audit_report_file"></div>
                            </div>
                        </div>
                    </form>
                    <form id="upload_letter_integrity" enctype="multipart/form-data" method="post" action="{{ url('uploadLetterIntegrity') }}" autocomplete="off">  
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label class="form-control-label">Pledge letter of integrity JMC</label>
                            </div>
                            <div class="col-md-6">
                                <button type="button" id="clear_letter_integrity" class="btn btn-xs btn-danger" onclick="clearLetterIntegrity()" style="display: none;"><i class="fa fa-times"></i></button>
                                &nbsp;
                                <input type="file" name="letter_integrity" id="letter_integrity">
                                <div id="validation-errors_letter_integrity"></div>
                            </div>
                        </div>
                    </form>
                    <form id="upload_letter_bankruptcy" enctype="multipart/form-data" method="post" action="{{ url('uploadLetterBankruptcy') }}" autocomplete="off">  
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label class="form-control-label">Declaration letter of non-bankruptcy</label>
                            </div>
                            <div class="col-md-6">
                                <button type="button" id="clear_letter_bankruptcy" class="btn btn-xs btn-danger" onclick="clearLetterBankruptcy()" style="display: none;"><i class="fa fa-times"></i></button>
                                &nbsp;
                                <input type="file" name="letter_bankruptcy" id="letter_bankruptcy">
                                <div id="validation-errors_letter_bankruptcy"></div>
                            </div>
                        </div>
                    </form>
                    <form>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label class="form-control-label">Financial Audit Start Date</label>
                            </div>
                            <div class="col-md-4">
                                <label class="input-group datepicker-only-init">
                                    <input type="text" class="form-control datepicker" placeholder="Start Date" id="audit_start"/>
                                    <span class="input-group-addon">
                                        <i class="icmn-calendar"></i>
                                    </span>
                                </label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label class="form-control-label">Financial Audit End Date</label>
                            </div>
                            <div class="col-md-4">
                                <label class="input-group datepicker-only-init">
                                    <input type="text" class="form-control datepicker" placeholder="End Date" id="audit_end"/>
                                    <span class="input-group-addon">
                                        <i class="icmn-calendar"></i>
                                    </span>
                                </label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label class="form-control-label">Remarks</label>
                            </div>
                            <div class="col-md-6">
                                <textarea class="form-control" placeholder="Remarks" id="remarks" rows="5"></textarea>                           
                            </div>
                        </div>
                        <div class="form-actions">
                            <?php if ($insert_permission == 1) { ?>
                                <input type="hidden" id="audit_report_file_url"/>
                                <input type="hidden" id="letter_integrity_url"/>
                                <input type="hidden" id="letter_bankruptcy_url"/>
                                <button type="button" class="btn btn-primary" id="submit_button" onclick="addMinutes()">Submit</button>
                            <?php } ?>
                            <button type="button" class="btn btn-default" id="cancel_button" onclick="window.location ='{{URL::action('AgmController@minutes')}}'">Cancel</button>
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
    $(document).ready(function () {
        //add
        var options1 = {
            beforeSubmit: showRequest1,
            success: showResponse1,
            dataType: 'json'
        };
        var options2 = {
            beforeSubmit: showRequest2,
            success: showResponse2,
            dataType: 'json'
        };
        var options3 = {
            beforeSubmit: showRequest3,
            success: showResponse3,
            dataType: 'json'
        };

        //add
        $('body').delegate('#audit_report_file', 'change', function () {
            $('#upload_audit_report_file').ajaxForm(options1).submit();
        });
        $('body').delegate('#letter_integrity', 'change', function () {
            $('#upload_letter_integrity').ajaxForm(options2).submit();
        });
        $('body').delegate('#letter_bankruptcy', 'change', function () {
            $('#upload_letter_bankruptcy').ajaxForm(options3).submit();
        });
    });

    //upload audit report file
    function showRequest1(formData, jqForm, options1) {
        $("#validation-errors_audit_report_file").hide().empty();
        return true;
    }
    function showResponse1(response, statusText, xhr, $form) {
        if (response.success == false)
        {
            var arr = response.errors;
            $.each(arr, function (index, value)
            {
                if (value.length != 0)
                {
                    $("#validation-errors_audit_report_file").append('<div class="alert alert-error"><strong>' + value + '</strong><div>');
                }
            });
            $("#validation-errors_audit_report_file").show();
            $("#audit_report_file").css("color", "red");
        } else {
            $("#validation-errors_audit_report_file").html("<i class='fa fa-check' id='check_audit_report_file' style='color:green;'></i>");
            $("#clear_audit_report_file").show();
            $("#validation-errors_audit_report_file").show();
            $("#audit_report_file").css("color", "green");
            $("#audit_report_file_url").val(response.file);
        }
    }

    //upload letter integrity
    function showRequest2(formData, jqForm, options2) {
        $("#validation-errors_letter_integrity").hide().empty();
        return true;
    }
    function showResponse2(response, statusText, xhr, $form) {
        if (response.success == false)
        {
            var arr = response.errors;
            $.each(arr, function (index, value)
            {
                if (value.length != 0)
                {
                    $("#validation-errors_letter_integrity").append('<div class="alert alert-error"><strong>' + value + '</strong><div>');
                }
            });
            $("#validation-errors_letter_integrity").show();
            $("#letter_integrity").css("color", "red");
        } else {
            $("#validation-errors_letter_integrity").html("<i class='fa fa-check' id='check_letter_integrity' style='color:green;'></i>");
            $("#clear_letter_integrity").show();
            $("#validation-errors_letter_integrity").show();
            $("#letter_integrity").css("color", "green");
            $("#letter_integrity_url").val(response.file);
        }
    }

    //upload letter bankruptcy
    function showRequest3(formData, jqForm, options3) {
        $("#validation-errors_letter_bankruptcy").hide().empty();
        return true;
    }
    function showResponse3(response, statusText, xhr, $form) {
        if (response.success == false)
        {
            var arr = response.errors;
            $.each(arr, function (index, value)
            {
                if (value.length != 0)
                {
                    $("#validation-errors_letter_bankruptcy").append('<div class="alert alert-error"><strong>' + value + '</strong><div>');
                }
            });
            $("#validation-errors_letter_bankruptcy").show();
            $("#letter_bankruptcy").css("color", "red");
        } else {
            $("#validation-errors_letter_bankruptcy").html("<i class='fa fa-check' id='check_letter_bankruptcy' style='color:green;'></i>");
            $("#clear_letter_bankruptcy").show();
            $("#validation-errors_letter_bankruptcy").show();
            $("#letter_bankruptcy").css("color", "green");
            $("#letter_bankruptcy_url").val(response.file);
        }
    }

    function deleteAuditReport(id) {
        swal({
            title: "Are you sure?",
            text: "Your will not be able to recover this file!",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-warning",
            cancelButtonClass: "btn-default",
            confirmButtonText: "Delete",
            closeOnConfirm: true
        }, function () {
            $.ajax({
                url: "{{ URL::action('AdminController@deleteAuditReport') }}",
                type: "POST",
                data: {
                    id: id
                },
                success: function (data) {
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

    function deleteLetterIntegrity(id) {
        swal({
            title: "Are you sure?",
            text: "Your will not be able to recover this file!",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-warning",
            cancelButtonClass: "btn-default",
            confirmButtonText: "Delete",
            closeOnConfirm: true
        }, function () {
            $.ajax({
                url: "{{ URL::action('AdminController@deleteLetterIntegrity') }}",
                type: "POST",
                data: {
                    id: id
                },
                success: function (data) {
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

    function deleteLetterBankruptcy(id) {
        swal({
            title: "Are you sure?",
            text: "Your will not be able to recover this file!",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-warning",
            cancelButtonClass: "btn-default",
            confirmButtonText: "Delete",
            closeOnConfirm: true
        }, function () {
            $.ajax({
                url: "{{ URL::action('AdminController@deleteLetterBankruptcy') }}",
                type: "POST",
                data: {
                    id: id
                },
                success: function (data) {
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

    function clearAuditFile() {
        $("#audit_report_file").val("");
        $("#audit_report_file_url").val("");
        $("#audit_report_file").css("color", "grey");
        $("#clear_audit_report_file").hide();
        $("#check_audit_report_file").hide();
    }

    function clearLetterIntegrity() {
        $("#letter_integrity").val("");
        $("#letter_integrity_url").val("");
        $("#letter_integrity").css("color", "grey");
        $("#clear_letter_integrity").hide();
        $("#check_letter_integrity").hide();
    }

    function clearLetterBankruptcy() {
        $("#letter_bankruptcy").val("");
        $("#letter_bankruptcy_url").val("");
        $("#letter_bankruptcy").css("color", "grey");
        $("#clear_letter_bankruptcy").hide();
        $("#check_letter_bankruptcy").hide();
    }

    function addMinutes() {
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
                audit_end = $("#audit_end").val(),
                audit_report_file_url = $("#audit_report_file_url").val(),
                letter_integrity_url = $("#letter_integrity_url").val(),
                letter_bankruptcy_url = $("#letter_bankruptcy_url").val(),
                remarks = $("#remarks").val();

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
            $("#file_id_error").html('<span style="color:red;font-style:italic;font-size:13px;">Please select File</span>');
            $("#file_id").focus();
            $("#file_id_error").css("display", "block");
            error = 1;
        }

        if (error == 0) {
            $.ajax({
                url: "{{ URL::action('AgmController@submitAddMinutes') }}",
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
                    audit_report_file_url: audit_report_file_url,
                    letter_integrity_url: letter_integrity_url,
                    letter_bankruptcy_url: letter_bankruptcy_url,
                    remarks: remarks,
                    file_id: file_id
                },
                success: function (data) {
                    $("#loading").css("display", "none");
                    $("#submit_button").removeAttr("disabled");
                    $("#cancel_button").removeAttr("disabled");

                    if (data.trim() == "true") {
                        bootbox.alert("<span style='color:green;'>Minutes added successfully!</span>", function () {
                            window.location = '{{URL::action("AgmController@minutes") }}';
                        });
                    } else {
                        bootbox.alert("<span style='color:red;'>An error occured while processing. Please try again.</span>");
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