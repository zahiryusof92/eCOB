<div class="row">
    <div class="col-lg-12">
        <h6>Check</h6>
        <form id="financeCheckForm">              
            <div class="form-group row">
                <div class="col-md-6">                            
                    <label><span style="color: red;">*</span> Date</label>
                    <input id="date" class="form-control form-control-sm" type="text" placeholder="Date" value="{{ ($checkdata->date) ? date('d/m/Y', strtotime($checkdata->date)) : '' }}">
                    <input type="hidden" name="date" id="mirror_date" value="{{ $checkdata->date }}">
                    <div id="date_err" style="display:none;"></div>
                </div>
                <div class="col-md-6">
                    <label><span style="color: red;">*</span> Name</label>
                    <input name="name" id="name" class="form-control form-control-sm" type="text" placeholder="Name" value="{{ $checkdata->name }}">
                    <div id="name_err" style="display:none;"></div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-6">
                    <label><span style="color: red;">*</span> Position</label>
                    <input name="position" id="position" class="form-control form-control-sm" type="text" placeholder="Position" value="{{ $checkdata->position }}">
                    <div id="position_err" style="display:none;"></div>
                </div>
                <div class="col-md-6">
                    <label><span style="color: red;">*</span> Status</label>
                    <select name="is_active" id="is_active" class="form-control form-control-sm">
                        <option value="">Please Select</option>
                        <option value="1" {{ ($checkdata->is_active == 1) ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ ($checkdata->is_active == 0) ? 'selected' : '' }}>Inactive</option>
                    </select>
                    <div id="is_active_err" style="display:none;"></div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-12">
                    <label>Remarks</label>
                    <textarea name="remarks" id="remarks" rows="5" class="form-control form-control-sm" placeholder="Remarks">{{ $checkdata->remarks }}</textarea>
                </div>
            </div>                                                
            <?php if ($insert_permission == 1) { ?>
                <div class="form-actions">                
                    <input type="hidden" name="finance_file_id" value="{{ $finance_file_id }}">
                    <input type="submit" value="Submit" class="btn btn-primary submit_button">
                    <img class="loading" style="display:none;" src="{{asset('assets/common/img/input-spinner.gif')}}"/>
                </div>
            <?php } ?>
        </form>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
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
            format: 'DD/MM/YYYY'
        }).on('dp.change', function () {
            let currentDate = $(this).val().split('/');
            $("#mirror_date").val(`${currentDate[2]}-${currentDate[1]}-${currentDate[0]}`);
        });
    });

    $("#financeCheckForm").submit(function (e) {
        e.preventDefault();

        $(".loading").css("display", "inline-block");
        $(".submit_button").attr("disabled", "disabled");
        $("#name_err").css("display", "none");
        $("#date_err").css("display", "none");
        $("#position_err").css("display", "none");
        $("#is_active_err").css("display", "none");

        var error = 0;

        if ($("#name").val().trim() == "") {
            $("#name_err").html('<span style="color:red;font-style:italic;font-size:13px;">Please Input Name</span>');
            $("#name_err").css("display", "block");
            error = 1;
        }

        if ($("#mirror_date").val().trim() == "") {
            $("#date_err").html('<span style="color:red;font-style:italic;font-size:13px;">Please enter Date</span>');
            $("#date_err").css("display", "block");
            error = 1;
        }

        if ($("#position").val().trim() == "") {
            $("#position_err").html('<span style="color:red;font-style:italic;font-size:13px;">Please input Position</span>');
            $("#position_err").css("display", "block");
            error = 1;
        }

        if ($("#is_active").val().trim() == "") {
            $("#is_active_err").html('<span style="color:red;font-style:italic;font-size:13px;">Please input Status</span>');
            $("#is_active_err").css("display", "block");
            error = 1;
        }

        if (error == 0) {
            $.ajax({
                url: "{{ URL::action('FinanceController@updateFinanceCheck') }}",
                type: "POST",
                data: $(this).serialize(),
                success: function (data) {
                    $(".loading").css("display", "none");
                    $(".submit_button").removeAttr("disabled");
                    if (data.trim() == "true") {
                        $.notify({
                            message: '<p style="text-align: center; margin-bottom: 0px;">Successfully saved</p>',
                        }, {
                            type: 'success',
                            placement: {
                                align: "center"
                            }
                        });
                        location = '{{URL::action("FinanceController@editFinanceFileList", [$finance_file_id, "home"]) }}';
                    } else if (data.trim() == "file_already_exists") {
                        $("#file_already_exists_error").html('<span style="color:red;font-style:italic;font-size:13px;">This file already exist!</span>');
                        $("#file_already_exists_error").css("display", "block");
                    } else {
                        bootbox.alert("<span style='color:red;'>An error occured while processing. Please try again.</span>");
                    }
                }
            });
        } else {
            $(".loading").css("display", "none");
            $(".submit_button").removeAttr("disabled");
        }
    });
</script>