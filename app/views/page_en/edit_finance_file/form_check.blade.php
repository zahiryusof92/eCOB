<?php
    $financeFileId  = '';
    $financeCheckId = '';
    $name = '';
    $date = '';
    $position = '';
    $status = '';
    $remark = '';
    if(!is_null($checkdata)){
        $financeFileId = $finance_file_id;
        $financeCheckId = $checkdata->id;
        $name = $checkdata->name;
        $date = $checkdata->date;
        $position = $checkdata->position;
        $status = $checkdata->status;
        $remark = $checkdata->remark;
    }
?>
<form id="financeCheckForm">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label style="color: red; font-style: italic;">* Mandatory Fields</label>
            </div>
        </div>
    </div>
    <input type="hidden" name="finance_check_id" value="{{ $financeCheckId }}">
    <input type="hidden" name="finance_file_id" value="{{ $finance_file_id }}">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label><span style="color: red;">*</span> Date</label>
                <input id="date" class="form-control" type="text" value="{{ date('d/m/Y', strtotime($date)) }}">
                <input type="hidden" name="date" id="mirror_date" value="{{ $date }}">
                <div id="date_err" style="display:none;"></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label><span style="color: red;">*</span> Name</label>
                <input name="name" class="form-control" type="text" value="{{ $name }}">
                <div id="name_err" style="display:none;"></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label><span style="color: red;">*</span> Position</label>
                <input name="position" class="form-control" type="text" value="{{ $position }}">
                <div id="position_err" style="display:none;"></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label><span style="color: red;">*</span> Status</label>
                <select name="status" class="form-control">
                    <option value="">Please Select</option>
                    <option value="1" <?php if($status ===1 ) echo 'selected' ?>>Active</option>
                    <option value="0" <?php if($status ===0 ) echo 'selected' ?>>Not Active</option>
                </select>
                <div id="status_err" style="display:none;"></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label><span style="color: red;">*</span> Remark</label>
                <textarea name="remark"  cols="30" rows="10" class="form-control">{{$remark}}</textarea>
                <div id="remark_err" style="display:none;"></div>
            </div>
        </div>
    </div>                                                
    <div class="form-actions">
        <?php if ($insert_permission == 1) { ?>
        <input type="submit" value="Submit" class="btn btn-primary">
         <?php } ?>
    </div>
</form>
<script>
     $(function(){
        $("#date").datetimepicker({
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

    $("#financeCheckForm").submit(function(e){
        e.preventDefault();
        console.log($(this).serialize());

        $("#loading").css("display", "inline-block");

        var error = 0;
        
        if ($("[name='name']").val().trim() == "") {
            $("#name_err").html('<span style="color:red;font-style:italic;font-size:13px;">Please Input Name</span>');
            $("#name_err").css("display", "block");
            error = 1;
        }

        if ($('[name=date]').val().trim() == "") {
            $("#date_err").html('<span style="color:red;font-style:italic;font-size:13px;">Please enter Date</span>');
            $("#date_err").css("display", "block");
            error = 1;
        }

        if ($('[name=position]').val().trim() == "") {
            $("#position_err").html('<span style="color:red;font-style:italic;font-size:13px;">Please input Position</span>');
            $("#position_err").css("display", "block");
            error = 1;
        }

        if ($('[name=status]').val().trim() == "") {
            $("#status_err").html('<span style="color:red;font-style:italic;font-size:13px;">Please input Status</span>');
            $("#status_err").css("display", "block");
            error = 1;
        }

        if (error == 0) {
            $.ajax({
                url: "{{ URL::action('FinanceController@updateFinanceCheck') }}",
                type: "POST",
                data: $(this).serialize(),
                success: function (data) {
                    $("#loading").css("display", "none");
                    $("#submit_button").removeAttr("disabled");
                    $("#cancel_button").removeAttr("disabled");
                    if (data.trim() == "true") {
                        bootbox.alert("<span style='color:green;'>Finance File updated successfully!</span>");
                    } else if (data.trim() == "file_already_exists") {
                        $("#file_already_exists_error").html('<span style="color:red;font-style:italic;font-size:13px;">This file already exist!</span>');
                        $("#file_already_exists_error").css("display", "block");
                    } else {
                        bootbox.alert("<span style='color:red;'>An error occured while processing. Please try again.</span>");
                    }
                }
            });
        }

    })
    
</script>