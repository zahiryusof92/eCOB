@extends('layout.english_layout.default')

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
                    <div class="table-responsive">
                        <?php if ($update_permission == 1) { ?>
                            <button type="button" class="btn btn-primary margin-bottom-25" onclick="addAGMDetails()">
                                Add
                            </button>
                        <?php } ?>                                                                       
                        <table class="table table-hover nowrap" id="financial_report_list" width="100%">
                            <thead>
                                <tr>
                                    <th style="width:15%;text-align: center !important;">AGM Date</th>
                                    <th style="width:20%;">Meeting</th>
                                    <th style="width:5%;"></th>
                                    <th style="width:20%;">Copy & List</th>
                                    <th style="width:5%;"></th>
                                    <th style="width:20%;">Financial Report</th>
                                    <th style="width:5%;"></th>
                                    <?php if ($update_permission == 1) { ?>
                                        <th style="width:5%;">Action</th>
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
    </section>
    <!-- End -->
</div>

<div class="modal fade modal-size-large" id="add_agm_details" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Add AGM Details</h4>
            </div>            
            <div class="modal-body">
                <form>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label class="form-control-label"><span style="color: red; font-style: italic;">*</span> File No</label>
                        </div>
                        <div class="col-md-6">
                            <select id="file_id" class="form-control">
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
                                <input type="text" class="form-control" placeholder="AGM Date" id="agm_date"/>
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
                                <input type="text" class="form-control" placeholder="Start Date" id="audit_start"/>
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
                                <input type="text" class="form-control" placeholder="End Date" id="audit_end"/>
                                <span class="input-group-addon">
                                    <i class="icmn-calendar"></i>
                                </span>
                            </label>
                        </div>
                    </div>
                </form>
            </div> 
            <div class="modal-footer">
                <form>
                    <input type="hidden" id="audit_report_file_url"/>
                    <input type="hidden" id="letter_integrity_url"/>
                    <input type="hidden" id="letter_bankruptcy_url"/>
                    <button type="button" class="btn" data-dismiss="modal">
                        Close
                    </button>
                    <button type="button" class="btn btn-primary" onclick="addAGMDetail()">
                        Submit
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade modal-size-large" id="edit_agm_details" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Edit AGM Details</h4>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label class="form-control-label"><span style="color: red; font-style: italic;">*</span> File No</label>
                        </div>
                        <div class="col-md-6">
                            <select id="file_id" class="form-control">
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
                                <input type="text" class="form-control" placeholder="AGM Date" id="agm_date_edit"/>
                                <span class="input-group-addon">
                                    <i class="icmn-calendar"></i>
                                </span>
                            </label>
                        </div>
                    </div>
                </form>
                <div id="agmEdit"></div>
                <form>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label class="form-control-label">Financial Audit Start Date</label>
                        </div>
                        <div class="col-md-4">
                            <label class="input-group datepicker-only-init">
                                <input type="text" class="form-control" placeholder="Start Date" id="audit_start_edit"/>
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
                                <input type="text" class="form-control" placeholder="End Date" id="audit_end_edit"/>
                                <span class="input-group-addon">
                                    <i class="icmn-calendar"></i>
                                </span>
                            </label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <form>
                    <input type="hidden" id="agm_id_edit"/>
                    <input type="hidden" id="audit_report_file_url_edit"/>
                    <input type="hidden" id="letter_integrity_url_edit"/>
                    <input type="hidden" id="letter_bankruptcy_url_edit"/>
                    <button type="button" class="btn" data-dismiss="modal">
                        Close
                    </button>
                    <button type="button" class="btn btn-primary" onclick="editAGMDetail()">
                        Submit
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Page Scripts -->
<script>
    function getAGMDetails(id) {
        $.ajax({
            url: "{{ URL::action('AgmController@getMinuteDetails') }}",
            type: "POST",
            data: {
                id: id
            },
            success: function (data) {
                $("#agmEdit").html(data);
                $("#edit_agm_details").modal("show");
            }
        });
    }

    $(function () {
        $('#agm_date').datetimepicker({
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
        $('#agm_date_edit').datetimepicker({
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
        $('#audit_start').datetimepicker({
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
        $('#audit_start_edit').datetimepicker({
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
        $('#audit_end').datetimepicker({
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
        $('#audit_end_edit').datetimepicker({
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
    });

    $(document).ready(function () {
        $('#financial_report_list').DataTable({
            "sAjaxSource": "{{URL::action('AgmController@getMinutes')}}",
            "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            "order": [[0, "asc"]],
            "responsive": true,
            "aoColumnDefs": [
                {
                    "bSortable": false,
                    "aTargets": [-1]
                }
            ]
        });
    });

    function addAGMDetails() {
        $("#add_agm_details").modal("show");
    }
    function editAGMDetails() {
        $("#edit_agm_details").modal("show");
    }

    function addAGMDetail() {
        $("#loading").css("display", "inline-block");

        var agm,
                egm,
                minit_meeting,
                jmc_copy,
                ic_list,
                attendance_list,
                audited_financial_report;

        if (document.getElementById('agm').checked) {
            agm = $("#agm").val();
        } else {
            agm = 0;
        }
        if (document.getElementById('egm').checked) {
            egm = $("#egm").val();
        } else {
            egm = 0;
        }
        if (document.getElementById('minit_meeting').checked) {
            minit_meeting = $("#minit_meeting").val();
        } else {
            minit_meeting = 0;
        }
        if (document.getElementById('jmc_copy').checked) {
            jmc_copy = $("#jmc_copy").val();
        } else {
            jmc_copy = 0;
        }
        if (document.getElementById('ic_list').checked) {
            ic_list = $("#ic_list").val();
        } else {
            ic_list = 0;
        }
        if (document.getElementById('attendance_list').checked) {
            attendance_list = $("#attendance_list").val();
        } else {
            attendance_list = 0;
        }
        if (document.getElementById('audited_financial_report').checked) {
            audited_financial_report = $("#audited_financial_report").val();
        } else {
            audited_financial_report = 0;
        }

        var file_id = $("#file_id").val(),
                agm_date = $("#agm_date").val(),
                audit_report = $("#audit_report").val(),
                audit_start = $("#audit_start").val(),
                audit_end = $("#audit_end").val(),
                audit_report_file_url = $("#audit_report_file_url").val(),
                letter_integrity_url = $("#letter_integrity_url").val(),
                letter_bankruptcy_url = $("#letter_bankruptcy_url").val();

        var error = 0;

        if (error == 0) {
            $.ajax({
                url: "{{ URL::action('AgmController@addMinuteDetails') }}",
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
                    file_id: file_id
                },
                success: function (data) {
                    $("#loading").css("display", "none");
                    $("#submit_button").removeAttr("disabled");
                    $('#add_agm_details').modal('hide');
                    if (data.trim() == "true") {
                        $.notify({
                            message: '<p style="text-align: center; margin-bottom: 0px;">Successfully saved</p>',
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
        }
    }

    function editAGMDetail() {
        $("#loading").css("display", "inline-block");

        var agm,
                egm,
                minit_meeting,
                jmc_copy,
                ic_list,
                attendance_list,
                audited_financial_report;

        if (document.getElementById('agm_edit').checked) {
            agm = $("#agm_edit").val();
        } else {
            agm = 0;
        }
        if (document.getElementById('egm_edit').checked) {
            egm = $("#egm_edit").val();
        } else {
            egm = 0;
        }
        if (document.getElementById('minit_meeting_edit').checked) {
            minit_meeting = $("#minit_meeting_edit").val();
        } else {
            minit_meeting = 0;
        }
        if (document.getElementById('jmc_copy_edit').checked) {
            jmc_copy = $("#jmc_copy_edit").val();
        } else {
            jmc_copy = 0;
        }
        if (document.getElementById('ic_list_edit').checked) {
            ic_list = $("#ic_list_edit").val();
        } else {
            ic_list = 0;
        }
        if (document.getElementById('attendance_list_edit').checked) {
            attendance_list = $("#attendance_list_edit").val();
        } else {
            attendance_list = 0;
        }
        if (document.getElementById('audited_financial_report_edit').checked) {
            audited_financial_report = $("#audited_financial_report_edit").val();
        } else {
            audited_financial_report = 0;
        }

        var agm_id_edit = $("#agm_id_edit").val(),
                agm_date = $("#agm_date_edit").val(),
                audit_report = $("#audit_report_edit").val(),
                audit_start = $("#audit_start_edit").val(),
                audit_end = $("#audit_end_edit").val(),
                audit_report_file_url = $("#audit_report_file_url_edit").val(),
                letter_integrity_url = $("#letter_integrity_url_edit").val(),
                letter_bankruptcy_url = $("#letter_bankruptcy_url_edit").val();

        var error = 0;

        if (error == 0) {
            $.ajax({
                url: "{{ URL::action('AgmController@editMinuteDetails') }}",
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
                    id: agm_id_edit
                },
                success: function (data) {
                    $("#loading").css("display", "none");
                    $("#submit_button").removeAttr("disabled");
                    $('#edit_agm_details').modal('hide');
                    if (data.trim() == "true") {
                        $.notify({
                            message: '<p style="text-align: center; margin-bottom: 0px;">Successfully saved</p>',
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
        }
    }

    function deleteAGMDetails(id) {
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
                url: "{{ URL::action('AgmController@deleteMinuteDetails') }}",
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
    function clearAuditFileEdit() {
        $("#audit_report_file_edit").val("");
        $("#audit_report_file_url_edit").val("");
        $("#audit_report_file_edit").css("color", "grey");
        $("#clear_audit_report_file_edit").hide();
        $("#check_audit_report_file_edit").hide();
    }

    function clearLetterIntegrityEdit() {
        $("#letter_integrity_edit").val("");
        $("#letter_integrity_url_edit").val("");
        $("#letter_integrity_edit").css("color", "grey");
        $("#clear_letter_integrity_edit").hide();
        $("#check_letter_integrity_edit").hide();
    }

    function clearLetterBankruptcyEdit() {
        $("#letter_bankruptcy_edit").val("");
        $("#letter_bankruptcy_url_edit").val("");
        $("#letter_bankruptcy_edit").css("color", "grey");
        $("#clear_letter_bankruptcy_edit").hide();
        $("#check_letter_bankruptcy_edit").hide();
    }
</script>
<!-- End Page Scripts-->

@stop