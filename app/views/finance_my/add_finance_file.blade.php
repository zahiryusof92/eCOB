@extends('layout.malay_layout.default')

@section('content')

<?php
$insert_permission = 0;
$update_permission = 0;

foreach ($user_permission as $permission) {
    if ($permission->submodule_id == 37) {
        $access_permission = $permission->access_permission;
        $insert_permission = $permission->insert_permission;
    }
}

$month = [
    1 => 'JAN',
    2 => 'FEB',
    3 => 'MAR',
    4 => 'APR',
    5 => 'MAY',
    6 => 'JUN',
    7 => 'JUL',
    8 => 'AUG',
    9 => 'SEP',
    10 => 'OCT',
    11 => 'NOV',
    12 => 'DEC'
];
?>

<div class="page-content-inner">
    <section class="panel panel-with-borders">
        <div class="panel-heading">
            <h3>{{$title}}</h3>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-lg-12">
                    <form id="add_fileprefix">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label style="color: red; font-style: italic;">* Mandatory Fields</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><span style="color: red;">*</span> File No</label>
                                    <select id="file_id" class="form-control select2">
                                        <option value="">Please Select</option>
                                        @foreach ($file_no as $files)
                                        <option value="{{ $files->id }}">{{ $files->file_no }}</option>
                                        @endforeach                                    
                                    </select>
                                    <div id="file_no_error" style="display:none;"></div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label><span style="color: red;">*</span> Year</label>
                                    <select id="year" class="form-control select2">
                                        <option value="">Please Select</option>
                                        @for ($i = 2012; $i <= date('Y'); $i++)
                                        <option value="{{ $i }}">{{ $i}}</option>
                                        @endfor
                                    </select>
                                    <div id="year_error" style="display:none;"></div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label><span style="color: red;">*</span> Month</label>
                                    <select id="month" class="form-control select2">
                                        <option value="">Please Select</option>
                                        @foreach ($month as $value => $months)
                                        <option value="{{ $value }}">{{ $months }}</option>
                                        @endforeach
                                    </select>
                                    <div id="month_error" style="display:none;"></div>
                                </div>
                            </div>
                        </div>                                                
                        <div class="row">
                            <div class="col-md-4">
                                <div id="file_already_exists_error" style="display: none;"></div>
                            </div>
                        </div>
                        <div class="form-actions">
                            <?php if ($insert_permission) { ?>
                                <button type="button" class="btn btn-primary" id="submit_button" onclick="submitAddFinanceFile()">Submit</button>
                            <?php } ?>
                            <button type="button" class="btn btn-default" id="cancel_button" onclick="window.location ='{{URL::action('FinanceController@addFinanceFileList')}}'">Cancel</button>
                            <img id="loading" style="display:none;" src="{{asset('assets/common/img/input-spinner.gif')}}"/>
                        </div>
                    </form>
                </div>                
            </div>
        </div>
    </section>
    <!-- End -->
</div>

<!-- Page Scripts -->
<script>
    function submitAddFinanceFile() {
        $("#loading").css("display", "inline-block");
        $("#submit_button").attr("disabled", "disabled");
        $("#cancel_button").attr("disabled", "disabled");
        $("#file_no_error").css("display", "none");
        $("#month_error").css("display", "none");
        $("#year_error").css("display", "none");
        $("#file_already_exists_error").css("display", "none");

        var file_no = $("#file_id").val(),
                month = $("#month").val(),
                year = $("#year").val();

        var error = 0;

        if (file_no.trim() == "") {
            $("#file_no_error").html('<span style="color:red;font-style:italic;font-size:13px;">Please select File No</span>');
            $("#file_no_error").css("display", "block");
            error = 1;
        }

        if (month.trim() == "") {
            $("#month_error").html('<span style="color:red;font-style:italic;font-size:13px;">Please Enter Month</span>');
            $("#month_error").css("display", "block");
            error = 1;
        }

        if (year.trim() == "") {
            $("#year_error").html('<span style="color:red;font-style:italic;font-size:13px;">Please Enter Year</span>');
            $("#year_error").css("display", "block");
            error = 1;
        }

        if (error == 0) {
            $.ajax({
                url: "{{ URL::action('FinanceController@submitAddFinanceFile') }}",
                type: "POST",
                data: {
                    file_id: file_no,
                    month: month,
                    year: year
                },
                success: function (data) {
                    $("#loading").css("display", "none");
                    $("#submit_button").removeAttr("disabled");
                    $("#cancel_button").removeAttr("disabled");

                    if (data.trim() == "true") {
                        bootbox.alert("<span style='color:green;'>Finance File added successfully!</span>", function () {
                            window.location = '{{URL::action("FinanceController@financeList") }}';
                        });
                    } else if (data.trim() == "file_already_exists") {
                        $("#file_already_exists_error").html('<span style="color:red;font-style:italic;font-size:13px;">This file already exist!</span>');
                        $("#file_already_exists_error").css("display", "block");
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
</script>

@stop