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
                    <h6>File No: {{$file->file_no}}</h6>
                    <div id="update_files_lists">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link" href="{{URL::action('AdminController@house', $file->id)}}">Housing Scheme</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{URL::action('AdminController@strata', $file->id)}}">Developed Area (STRATA)</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{URL::action('AdminController@management', $file->id)}}">Management</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active">Monitoring</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{URL::action('AdminController@others', $file->id)}}">Others</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{URL::action('AdminController@scoring', $file->id)}}">Scoring Component Value</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{URL::action('AdminController@buyer', $file->id)}}">Buyer List</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{URL::action('AdminController@document', $file->id)}}">Document</a>
                            </li>
                        </ul>
                        <div class="tab-content padding-vertical-20">                            
                            <div class="tab-pane active" id="monitoring" role="tabpanel">                                
                                <form id="monitoring">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <h4>Detail</h4>
                                            <h6>1. Delivery Document of Development Area</h6>
                                            <div class="form-group row">
                                                <div class="col-md-3">
                                                    <label class="form-control-label">Pre-Calculate Plan</label>
                                                </div>
                                                <div class="col-md-1">
                                                    <input type="radio" id="precalculate_plan" name="precalculate_plan" value="1" {{($monitoring->pre_calculate == 1 ? " checked" : "")}}>
                                                    Yes
                                                </div>
                                                <div class="col-md-1">
                                                    <input type="radio" id="precalculate_plan" name="precalculate_plan" value="0" {{($monitoring->pre_calculate == 0 ? " checked" : "")}}>
                                                    No
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-3">
                                                    <label class="form-control-label">Buyer Registration</label>
                                                </div>
                                                <div class="col-md-1">
                                                    <input type="radio" id="buyer_registration" name="buyer_registration" value="1" {{($monitoring->buyer_registration == 1 ? " checked" : "")}}>
                                                    Yes
                                                </div>
                                                <div class="col-md-1">
                                                    <input type="radio" id="buyer_registration" name="buyer_registration" value="0" {{($monitoring->buyer_registration == 0 ? " checked" : "")}}>
                                                    No
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-3">
                                                    <label class="form-control-label">Certificate Series Number</label>
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="text" class="form-control" placeholder="Certificate Series Number" id="certificate_series_no" value="{{$monitoring->certificate_no}}"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr/>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <h6>2. Delivery Document for Each Meeting</h6>
                                            <div class="table-responsive">
                                                <?php if ($update_permission == 1) { ?>
                                                    <button type="button" class="btn btn-primary pull-right margin-bottom-25" onclick="addAGMDetails()">
                                                        Add
                                                    </button>
                                                    <br/><br/>
                                                <?php } ?>
                                                <div class="form-group row">
                                                    <div class="col-md-3">
                                                        <label class="form-control-label">Financial Report Start Month</label>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <select class="form-control" id="commercial_sinking_fund_option">
                                                            <option value="0" selected="">All</option>
                                                            <option value="1">January</option>
                                                            <option value="2">February</option>
                                                            <option value="3">March</option>
                                                            <option value="4">April</option>
                                                            <option value="5">May</option>
                                                            <option value="6">June</option>
                                                            <option value="7">July</option>
                                                            <option value="8">Augusts</option>
                                                            <option value="9">September</option>
                                                            <option value="10">October</option>
                                                            <option value="11">November</option>
                                                            <option value="12">December</option>
                                                        </select>
                                                    </div>
                                                </div>                                                 
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
                                    <hr/>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <h6>Additional Info</h6>   
                                            <div class="table-responsive">
                                                <?php if ($update_permission == 1) { ?>
                                                    <button type="button" class="btn btn-primary pull-right margin-bottom-25" onclick="addAJKDetails()">
                                                        Add
                                                    </button>
                                                    <br/><br/>
                                                <?php } ?>
                                                <table class="table table-hover nowrap" id="ajk_details_list" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th style="width:30%;text-align: center !important;">Designation</th>
                                                            <th style="width:30%;">Name</th>
                                                            <th style="width:20%;">Phone Number</th>
                                                            <th style="width:10%;">Year</th>
                                                            <?php if ($update_permission == 1) { ?>
                                                                <th style="width:10%;">Action</th>
                                                            <?php } ?>
                                                        </tr>
                                                    </thead>
                                                    <tbody>                                                    
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <hr/>
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label class="form-control-label">Remarks</label>
                                        </div>
                                        <div class="col-md-4">
                                            <textarea class="form-control" rows="3" id="monitoring_remarks">{{$monitoring->remarks}}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-actions">
                                        <?php if ($update_permission == 1) { ?>
                                            <button type="button" class="btn btn-primary" id="submit_button" onclick="updateMonitoring()">Submit</button>
                                        <?php } ?>
                                        <button type="button" class="btn btn-default" id="cancel_button" onclick="window.location ='{{URL::action('AdminController@fileList')}}'">Cancel</button>
                                    </div>
                                </form>
                            </div>
                        </div>
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
                    <div>
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
                    </div>
                </form>
                <div id="agmEdit"></div>
                <form>
                    <div>
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

<div class="modal fade modal" id="add_ajk_details" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Add AJK Details</h4>
            </div>
            <form id="add_ajk">
                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-md-4">
                            <label class="form-control-label" style="color: red; font-style: italic;">* Mandatory Fields.</label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-4">
                            <label class="form-control-label"><span style="color: red; font-style: italic;">*</span> Designation</label>
                        </div>
                        <div class="col-md-6">
                            <select id="ajk_designation" class="form-control">
                                <option value="">Please select</option>
                                @foreach ($designation as $designations) 
                                <option value="{{$designations->id}}">{{$designations->description}}</option>
                                @endforeach
                            </select>
                            <div id="ajk_designation_error" style="display:none;"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-4">
                            <label class="form-control-label"><span style="color: red; font-style: italic;">*</span> Name</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" placeholder="Name" id="ajk_name"/>
                            <div id="ajk_name_error" style="display:none;"></div>
                        </div>                    
                    </div> 
                    <div class="form-group row">
                        <div class="col-md-4">
                            <label class="form-control-label"><span style="color: red; font-style: italic;">*</span> Phone Number</label>
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control" placeholder="Phone Number" id="ajk_phone_no"/>
                            <div id="ajk_phone_no_error" style="display:none;"></div>
                            <div id="ajk_phone_no_invalid_error" style="display:none;"></div>
                        </div>                    
                    </div> 
                    <div class="form-group row">
                        <div class="col-md-4">
                            <label class="form-control-label"><span style="color: red; font-style: italic;">*</span> Year</label>
                        </div>
                        <div class="col-md-4">
                            <input type="text" class="form-control" placeholder="Year" id="ajk_year"/>
                            <div id="ajk_year_error" style="display:none;"></div>
                            <div id="ajk_year_invalid_error" style="display:none;"></div>
                        </div>                    
                    </div> 
                </div>                
                <div class="modal-footer">
                    <button type="button" class="btn" data-dismiss="modal">
                        Close
                    </button>
                    <button id="submit_button" onclick="addAJKDetail()" type="button" class="btn btn-primary">
                        Submit
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade modal" id="edit_ajk_details" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Edit AJK Details</h4>
            </div>
            <form id="edit_ajk">
                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-md-4">
                            <label class="form-control-label" style="color: red; font-style: italic;">* Mandatory Fields.</label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-4">
                            <label class="form-control-label"><span style="color: red; font-style: italic;">*</span> Designation</label>
                        </div>
                        <div class="col-md-6">
                            <select id="ajk_designation_edit" class="form-control">
                                <option value="">Please select</option>
                                @foreach ($designation as $designations) 
                                <option value="{{$designations->id}}">{{$designations->description}}</option>
                                @endforeach
                            </select>
                            <div id="ajk_designation_edit_error" style="display:none;"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-4">
                            <label class="form-control-label"><span style="color: red; font-style: italic;">*</span> Name</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" placeholder="Name" id="ajk_name_edit"/>
                        </div>                    
                    </div> 
                    <div class="form-group row">
                        <div class="col-md-4">
                            <label class="form-control-label"><span style="color: red; font-style: italic;">*</span> Phone Number</label>
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control" placeholder="Phone Number" id="ajk_phone_no_edit"/>
                        </div>                    
                    </div> 
                    <div class="form-group row">
                        <div class="col-md-4">
                            <label class="form-control-label"><span style="color: red; font-style: italic;">*</span> Year</label>
                        </div>
                        <div class="col-md-4">
                            <input type="text" class="form-control" placeholder="Year" id="ajk_year_edit"/>
                        </div>                    
                    </div> 
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="ajk_id_edit"/>
                    <button type="button" class="btn" data-dismiss="modal">
                        Close
                    </button>
                    <button id="submit_button" onclick="editAJK()" type="button" class="btn btn-primary">
                        Submit
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Page Scripts -->
<script>
    function getAGMDetails(id) {
        $.ajax({
            url: "{{ URL::action('AdminController@getAGMDetails') }}",
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
            "sAjaxSource": "{{URL::action('AdminController@getAGM', $file->id)}}",
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
        $('#ajk_details_list').DataTable({
            "sAjaxSource": "{{URL::action('AdminController@getAJK', $file->id)}}",
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
        //edit        
        var options4 = {
            beforeSubmit: showRequest4,
            success: showResponse4,
            dataType: 'json'
        };
        var options5 = {
            beforeSubmit: showRequest5,
            success: showResponse5,
            dataType: 'json'
        };
        var options6 = {
            beforeSubmit: showRequest6,
            success: showResponse6,
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
        //edit
        $('body').delegate('#audit_report_file_edit', 'change', function () {
            $('#upload_audit_report_file_edit').ajaxForm(options4).submit();
        });
        $('body').delegate('#letter_integrity_edit', 'change', function () {
            $('#upload_letter_integrity_edit').ajaxForm(options5).submit();
        });
        $('body').delegate('#letter_bankruptcy_edit', 'change', function () {
            $('#upload_letter_bankruptcy_edit').ajaxForm(options6).submit();
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

    //upload audit report file edit
    function showRequest4(formData, jqForm, options4) {
        $("#validation-errors_audit_report_file_edit").hide().empty();
        return true;
    }
    function showResponse4(response, statusText, xhr, $form) {
        if (response.success == false)
        {
            var arr = response.errors;
            $.each(arr, function (index, value)
            {
                if (value.length != 0)
                {
                    $("#validation-errors_audit_report_file_edit").append('<div class="alert alert-error"><strong>' + value + '</strong><div>');
                }
            });
            $("#validation-errors_audit_report_file_edit").show();
            $("#audit_report_file_edit").css("color", "red");
        } else {
            $("#report_edit").hide();
            $("#validation-errors_audit_report_file_edit").html("<i class='fa fa-check' id='check_audit_report_file_edit' style='color:green;'></i>");
            $("#clear_audit_report_file_edit").show();
            $("#validation-errors_audit_report_file_edit").show();
            $("#audit_report_file_edit").css("color", "green");
            $("#audit_report_file_url_edit").val(response.file);
        }
    }

    //upload letter integrity edit
    function showRequest5(formData, jqForm, options5) {
        $("#validation-errors_letter_integrity_edit").hide().empty();
        return true;
    }
    function showResponse5(response, statusText, xhr, $form) {
        if (response.success == false)
        {
            var arr = response.errors;
            $.each(arr, function (index, value)
            {
                if (value.length != 0)
                {
                    $("#validation-errors_letter_integrity_edit").append('<div class="alert alert-error"><strong>' + value + '</strong><div>');
                }
            });
            $("#validation-errors_letter_integrity_edit").show();
            $("#letter_integrity_edit").css("color", "red");
        } else {
            $("#integrity_edit").hide();
            $("#validation-errors_letter_integrity_edit").html("<i class='fa fa-check' id='check_letter_integrity_edit' style='color:green;'></i>");
            $("#clear_letter_integrity_edit").show();
            $("#validation-errors_letter_integrity_edit").show();
            $("#letter_integrity_edit").css("color", "green");
            $("#letter_integrity_url_edit").val(response.file);
        }
    }

    //upload letter bankruptcy edit
    function showRequest6(formData, jqForm, options6) {
        $("#validation-errors_letter_bankruptcy_edit").hide().empty();
        return true;
    }
    function showResponse6(response, statusText, xhr, $form) {
        if (response.success == false)
        {
            var arr = response.errors;
            $.each(arr, function (index, value)
            {
                if (value.length != 0)
                {
                    $("#validation-errors_letter_bankruptcy_edit").append('<div class="alert alert-error"><strong>' + value + '</strong><div>');
                }
            });
            $("#validation-errors_letter_bankruptcy_edit").show();
            $("#letter_bankruptcy_edit").css("color", "red");
        } else {
            $("#bankruptcy_edit").hide();
            $("#validation-errors_letter_bankruptcy_edit").html("<i class='fa fa-check' id='check_letter_bankruptcy_edit' style='color:green;'></i>");
            $("#clear_letter_bankruptcy_edit").show();
            $("#validation-errors_letter_bankruptcy_edit").show();
            $("#letter_bankruptcy_edit").css("color", "green");
            $("#letter_bankruptcy_url_edit").val(response.file);
        }
    }

    $(document).on("click", '.edit_agm', function (e) {
        var agm_id = $(this).data('agm_id');
        var agm_date = $(this).data('agm_date');
        var audit_start_date = $(this).data('audit_start_date');
        var audit_end_date = $(this).data('audit_end_date');
        var audit_report_file_url = $(this).data('audit_report_file_url');
        var letter_integrity_url = $(this).data('letter_integrity_url');
        var letter_bankruptcy_url = $(this).data('letter_bankruptcy_url');

        $("#agm_id_edit").val(agm_id);
        if (agm_date == "0000-00-00 00:00:00") {
            $("#agm_date_edit").val("");
        } else {
            $("#agm_date_edit").val(agm_date);
        }
        if (audit_start_date == "0000-00-00 00:00:00") {
            $("#audit_start_edit").val("");
        } else {
            $("#audit_start_edit").val(audit_start_date);
        }
        if (audit_end_date == "0000-00-00 00:00:00") {
            $("#audit_end_edit").val("");
        } else {
            $("#audit_end_edit").val(audit_end_date);
        }
        $("#audit_report_file_url_edit").val(audit_report_file_url);
        $("#letter_integrity_url_edit").val(letter_integrity_url);
        $("#letter_bankruptcy_url_edit").val(letter_bankruptcy_url);
    });

    $(document).on("click", '.edit_ajk', function (e) {
        var ajk_id = $(this).data('ajk_id');
        var designation = $(this).data('designation');
        var name = $(this).data('name');
        var phone_no = $(this).data('phone_no');
        var year = $(this).data('year');

        $("#ajk_id_edit").val(ajk_id);
        $("#ajk_designation_edit").val(designation);
        $("#ajk_name_edit").val(name);
        $("#ajk_phone_no_edit").val(phone_no);
        $("#ajk_year_edit").val(year);
    });

    function addAGMDetails() {
        $("#add_agm_details").modal("show");
    }
    function editAGMDetails() {
        $("#edit_agm_details").modal("show");
    }

    function addAJKDetails() {
        $("#add_ajk_details").modal("show");
    }
    function editAJKDetails() {
        $("#edit_ajk_details").modal("show");
    }

    function updateMonitoring() {
        $("#loading").css("display", "inline-block");

        var precalculate_plan;
        var buyer_registration;

        if (document.getElementById('precalculate_plan').checked) {
            precalculate_plan = 1;
        } else {
            precalculate_plan = 0;
        }
        if (document.getElementById('buyer_registration').checked) {
            buyer_registration = 1;
        } else {
            buyer_registration = 0;
        }

        var certificate_series_no = $("#certificate_series_no").val(),
                monitoring_remarks = $("#monitoring_remarks").val();

        var error = 0;

        if (error == 0) {
            $.ajax({
                url: "{{ URL::action('AdminController@submitUpdateMonitoring') }}",
                type: "POST",
                data: {
                    precalculate_plan: precalculate_plan,
                    buyer_registration: buyer_registration,
                    certificate_series_no: certificate_series_no,
                    monitoring_remarks: monitoring_remarks,
                    id: '{{$monitoring->id}}'
                },
                success: function (data) {
                    $("#loading").css("display", "none");
                    $("#submit_button").removeAttr("disabled");
                    if (data.trim() == "true") {
                        $.notify({
                            message: '<p style="text-align: center; margin-bottom: 0px;">Successfully saved</p>',
                        }, {
                            type: 'success',
                            placement: {
                                align: "center"
                            }
                        });
                        window.location = "{{URL::action('AdminController@others', $file->id)}}";
                    } else {
                        bootbox.alert("<span style='color:red;'>An error occured while processing. Please try again.</span>");
                    }
                }
            });
        }
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

        var agm_date = $("#agm_date").val(),
                audit_report = $("#audit_report").val(),
                audit_start = $("#audit_start").val(),
                audit_end = $("#audit_end").val(),
                audit_report_file_url = $("#audit_report_file_url").val(),
                letter_integrity_url = $("#letter_integrity_url").val(),
                letter_bankruptcy_url = $("#letter_bankruptcy_url").val();

        var error = 0;

        if (error == 0) {
            $.ajax({
                url: "{{ URL::action('AdminController@addAGMDetails') }}",
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
                    file_id: '{{$file->id}}'
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
                url: "{{ URL::action('AdminController@editAGMDetails') }}",
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

    function addAJKDetail() {
        $("#loading").css("display", "inline-block");

        var ajk_designation = $("#ajk_designation").val(),
                ajk_name = $("#ajk_name").val(),
                ajk_phone_no = $("#ajk_phone_no").val(),
                ajk_year = $("#ajk_year").val();

        var error = 0;

        if (ajk_designation.trim() == "") {
            $("#ajk_designation_error").html('<span style="color:red;font-style:italic;font-size:13px;">Please select Designation</span>');
            $("#ajk_designation_error").css("display", "block");
            error = 1;
        }

        if (ajk_name.trim() == "") {
            $("#ajk_name_error").html('<span style="color:red;font-style:italic;font-size:13px;">Please enter Name</span>');
            $("#ajk_name_error").css("display", "block");
            error = 1;
        }

        if (ajk_phone_no.trim() == "") {
            $("#ajk_phone_no_error").html('<span style="color:red;font-style:italic;font-size:13px;">Please enter Phone Number</span>');
            $("#ajk_phone_no_error").css("display", "block");
            $("#ajk_phone_no_invalid_error").css("display", "none");
            error = 1;
        }

        if (isNaN(ajk_phone_no)) {
            $("#ajk_phone_no_invalid_error").html('<span style="color:red;font-style:italic;font-size:13px;">Please enter valid Phone Number</span>');
            $("#ajk_phone_no_invalid_error").css("display", "block");
            $("#ajk_phone_no_error").css("display", "none");
            error = 1;
        }

        if (ajk_year.trim() == "") {
            $("#ajk_year_error").html('<span style="color:red;font-style:italic;font-size:13px;">Please enter Year</span>');
            $("#ajk_year_error").css("display", "block");
            $("#ajk_year_invalid_error").css("display", "none");
            error = 1;
        }

        if (isNaN(ajk_year)) {
            $("#ajk_year_invalid_error").html('<span style="color:red;font-style:italic;font-size:13px;">Please enter valid Year</span>');
            $("#ajk_year_invalid_error").css("display", "block");
            $("#ajk_year_error").css("display", "none");
            error = 1;
        }

        if (error == 0) {
            $.ajax({
                url: "{{ URL::action('AdminController@addAJKDetails') }}",
                type: "POST",
                data: {
                    ajk_designation: ajk_designation,
                    ajk_name: ajk_name,
                    ajk_phone_no: ajk_phone_no,
                    ajk_year: ajk_year,
                    file_id: '{{$file->id}}'
                },
                success: function (data) {
                    $("#loading").css("display", "none");
                    $("#submit_button").removeAttr("disabled");
                    $('#add_ajk_details').modal('hide');
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

    function editAJK() {
        $("#loading").css("display", "inline-block");

        var ajk_id_edit = $("#ajk_id_edit").val(),
                ajk_designation = $("#ajk_designation_edit").val(),
                ajk_name = $("#ajk_name_edit").val(),
                ajk_phone_no = $("#ajk_phone_no_edit").val(),
                ajk_year = $("#ajk_year_edit").val();

        var error = 0;

        if (ajk_designation.trim() == "") {
            $("#ajk_designation_edit_error").html('<span style="color:red;font-style:italic;font-size:13px;">Please select Designation</span>');
            $("#ajk_designation_edit_error").css("display", "block");
            error = 1;
        }

        if (ajk_name.trim() == "") {
            $("#ajk_name_error").html('<span style="color:red;font-style:italic;font-size:13px;">Please enter Name</span>');
            $("#ajk_name_error").css("display", "block");
            error = 1;
        }

        if (ajk_phone_no.trim() == "") {
            $("#ajk_phone_no_error").html('<span style="color:red;font-style:italic;font-size:13px;">Please enter Phone Number</span>');
            $("#ajk_phone_no_error").css("display", "block");
            $("#ajk_phone_no_invalid_error").css("display", "none");
            error = 1;
        }

        if (isNaN(ajk_phone_no)) {
            $("#ajk_phone_no_invalid_error").html('<span style="color:red;font-style:italic;font-size:13px;">Please enter valid Phone Number</span>');
            $("#ajk_phone_no_invalid_error").css("display", "block");
            $("#ajk_phone_no_error").css("display", "none");
            error = 1;
        }

        if (ajk_year.trim() == "") {
            $("#ajk_year_error").html('<span style="color:red;font-style:italic;font-size:13px;">Please enter Year</span>');
            $("#ajk_year_error").css("display", "block");
            $("#ajk_year_invalid_error").css("display", "none");
            error = 1;
        }

        if (isNaN(ajk_year)) {
            $("#ajk_year_invalid_error").html('<span style="color:red;font-style:italic;font-size:13px;">Please enter valid Year</span>');
            $("#ajk_year_invalid_error").css("display", "block");
            $("#ajk_year_error").css("display", "none");
            error = 1;
        }

        if (error == 0) {
            $.ajax({
                url: "{{ URL::action('AdminController@editAJKDetails') }}",
                type: "POST",
                data: {
                    ajk_designation: ajk_designation,
                    ajk_name: ajk_name,
                    ajk_phone_no: ajk_phone_no,
                    ajk_year: ajk_year,
                    ajk_id_edit: ajk_id_edit
                },
                success: function (data) {
                    $("#loading").css("display", "none");
                    $("#submit_button").removeAttr("disabled");
                    $('#edit_ajk_details').modal('hide');
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
                url: "{{ URL::action('AdminController@deleteAGMDetails') }}",
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

    function deleteAJKDetails(id) {
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
                url: "{{ URL::action('AdminController@deleteAJKDetails') }}",
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