@extends('layout.english_layout.default')

@section('content')

<?php
$insert_permission = 0;
$update_permission = 0;

foreach ($user_permission as $permission) {
    if ($permission->submodule_id == 2) {        
        $access_permission = $permission->access_permission;
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
                    <form id="add_fileprefix">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label style="color: red; font-style: italic;">* Mandatory Fields</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label><span style="color: red;">*</span> File No.</label>
                                    <select id="file_id" class="form-control">
                                        <option value="">Please Select</option>
                                        @foreach ($file_no as $files)
                                        <option value="{{$files->id}}">{{$files->file_no}}</option>
                                        @endforeach                                    
                                    </select>
                                    <div id="file_no_error" style="display:none;"></div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label><span style="color: red;">*</span> Name</label>
                                    <input id="name" class="form-control" type="text">
                                    <div id="name_error" style="display:none;"></div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label><span style="color: red;">*</span> Date</label>
                                    <input id="date" class="form-control" type="text">
                                    <input type="hidden" name="mirror_date" id="mirror_date">
                                    <div id="date_error" style="display:none;"></div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label><span style="color: red;">*</span> Amount</label>
                                    <input id="amount" class="form-control" placeholder="0.00" type="text">
                                    <div id="amount_error" style="display:none;"></div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label><span style="color: red;">*</span> Remark</label>
                                    <textarea name="remark" id="remark" class="form-control"></textarea>
                                    <div id="remark_error" style="display:none;"></div>
                                </div>
                            </div>
                        </div>                                                
                        <div class="form-actions">
                            <?php if ($insert_permission == 1) { ?>
                            <button type="button" class="btn btn-primary" id="submit_button" onclick="submitFinanceSupport()">Submit</button>
                             <?php } ?>
                            <button type="button" class="btn btn-default" id="cancel_button" onclick="window.location ='{{URL::action('AdminController@addFinanceSupport')}}'">Cancel</button>
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
    $(function(){
        $('#date').datetimepicker({
            widgetPositioning: {
                horizontal: 'left'
            },
            icons: {
                time: "fa fa-clock-o",
                date: "fa fa-calendar",
                up: "fa fa-arrow-up",
                down: "fa fa-arrow-down"
            },
            format: 'DD/MM/YYYY',
        }).on('dp.change', function(){
            let currentDate = $(this).val().split('/');
            console.log(currentDate);
            $("#mirror_date").val(`${currentDate[2]}-${currentDate[1]}-${currentDate[0]}`);
        });        
    });
    
    function submitFinanceSupport() {
        $("#loading").css("display", "inline-block");

        var file_no = $("#file_id").val(),
            date = $("#mirror_date").val(),
            name = $("#name").val(),
            amount = $("#amount").val(),
            remark = $("#remark").val();

        var error = 0;
        
        if (file_no.trim() == "") {
            $("#file_no_error").html('<span style="color:red;font-style:italic;font-size:13px;">Please select File Number</span>');
            $("#file_no_error").css("display", "block");
            error = 1;
        }
        
        if (date.trim() == "") {
            $("#date_error").html('<span style="color:red;font-style:italic;font-size:13px;">Please Enter Date</span>');
            $("#date_error").css("display", "block");
            error = 1;
        }

        if (amount.trim() == "") {
            $("#amount_error").html('<span style="color:red;font-style:italic;font-size:13px;">Please Enter Amount</span>');
            $("#amount_error").css("display", "block");
            error = 1;
        }

        if (remark.trim() == "") {
            $("#remark_error").html('<span style="color:red;font-style:italic;font-size:13px;">Please Enter Remark</span>');
            $("#remark_error").css("display", "block");
            error = 1;
        }
        
        if (error == 0) {
            $.ajax({
                url: "{{ URL::action('AdminController@submitFinanceSupport') }}",
                type: "POST",
                data: {
                    file_id: file_no,
                    date: date,
                    name : name,
                    remark :remark,
                    amount : amount,
                    is_active : 1
                },
                success: function (data) {
                    $("#loading").css("display", "none");
                    $("#submit_button").removeAttr("disabled");
                    $("#cancel_button").removeAttr("disabled");
                    if (data.trim() == "true") {
                        bootbox.alert("<span style='color:green;'>Finance File added successfully!</span>", function () {
                            window.location = '{{URL::action("AdminController@financeSupport") }}';
                        });
                    } else if (data.trim() == "file_already_exists") {
                        $("#file_already_exists_error").html('<span style="color:red;font-style:italic;font-size:13px;">This file already exist!</span>');
                        $("#file_already_exists_error").css("display", "block");
                    } else {
                        bootbox.alert("<span style='color:red;'>An error occured while processing. Please try again.</span>");
                    }
                }
            });
        }
    }
</script>

@stop