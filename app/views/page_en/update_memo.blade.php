@extends('layout.english_layout.default')

@section('content')

<?php
$update_permission = 0;

foreach ($user_permission as $permission) {
    if ($permission->submodule_id == 7) {
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
                    <!-- Vertical Form -->
                    <form id="add_memo">
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
                                    <label><span style="color: red;">*</span> Memo Type</label>
                                    <select id="memo_type" class="form-control">
                                        <option value="">Please Select</option>
                                        @foreach ($memotype as $memotypes)
                                        <option value="{{$memotypes->id}}" {{($memo->memo_type_id == $memotypes->id ? " selected" : "")}}>{{$memotypes->description}}</option>
                                        @endforeach
                                    </select>
                                    <div id="memo_type_error" style="display:none;"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label><span style="color: red;">*</span> Memo Date</label>
                                    <label class="input-group datepicker-only-init">
                                        <input type="text" class="form-control" placeholder="Memo Date" id="memo_date" value="{{$memo->memo_date}}"/>
                                        <span class="input-group-addon">
                                            <i class="icmn-calendar"></i>
                                        </span>
                                    </label>
                                    <div id="memo_date_error" style="display:block;"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label><span style="color: red;">*</span> Publish Date</label>
                                    <label class="input-group datepicker-only-init">
                                        <input type="text" class="form-control" placeholder="Publish Date" id="publish_date" value="{{$memo->publish_date}}"/>
                                        <span class="input-group-addon">
                                            <i class="icmn-calendar"></i>
                                        </span>
                                    </label>
                                    <div id="publish_date_error" style="display:block;"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Expired Date</label>
                                    <label class="input-group datepicker-only-init">
                                        <input type="text" class="form-control" placeholder="Expired Date" id="expired_date" value="{{$memo->expired_date}}"/>
                                        <span class="input-group-addon">
                                            <i class="icmn-calendar"></i>
                                        </span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label><span style="color: red;">*</span> Subject</label>
                                    <input type="text" class="form-control" placeholder="Subject" id="subject" value="{{$memo->subject}}">
                                    <div id="subject_error" style="display:none;"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label><span style="color: red;">*</span> Description</label>
                                    <textarea id="description">{{$memo->description}}</textarea>
                                    <div id="description_error" style="display:none;"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label><span style="color: red;">*</span> Status</label>
                                    <select id="is_active" class="form-control">
                                        <option value="">Please Select</option>
                                        <option value="1" {{($memo->is_active==1 ? " selected" : "")}}>Active</option>
                                        <option value="0" {{($memo->is_active==0 ? " selected" : "")}}>Inactive</option>
                                    </select>
                                    <div id="is_active_error" style="display:none;"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>Remarks</label>
                                    <textarea class="form-control" rows="3" id="remarks">{{$memo->remarks}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions">
                            <?php if ($update_permission == 1) { ?>
                                <button type="button" class="btn btn-primary" id="submit_button" onclick="updateMemo()">Submit</button>
                            <?php } ?>
                            <button type="button" class="btn btn-default" id="cancel_button" onclick="window.location ='{{URL::action('AdminController@memo')}}'">Cancel</button>
                            <div class="text-center" id="loading" style="display:none;">
                                <img src="{{asset('assets/common/img/input-spinner.gif')}}"/>
                            </div>
                        </div>
                    </form>
                    <!-- End Vertical Form -->
                </div>                
            </div>
        </div>
    </section>
    <!-- End -->
</div>

<!-- Page Scripts -->
<script>
    $(function () {
        $('#memo_date').datetimepicker({
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
        $('#publish_date').datetimepicker({
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
        $('#expired_date').datetimepicker({
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
        $('#description').summernote({
            height: 250
        });
    });

    function updateMemo() {
        $("#loading").css("display", "inline-block");
        $("#submit_button").attr("disabled", "disabled");
        $("#cancel_button").attr("disabled", "disabled");

        var memo_type = $("#memo_type").val(),
                memo_date = $("#memo_date").val(),
                publish_date = $("#publish_date").val(),
                expired_date = $("#expired_date").val(),
                subject = $("#subject").val(),
                description = $("#description").val(),
                remarks = $("#remarks").val(),
                is_active = $("#is_active").val();

        var error = 0;

        if (memo_type.trim() == "") {
            $("#memo_type_error").html('<span style="color:red;font-style:italic;font-size:13px;">Please select Memo Type</span>');
            $("#memo_type_error").css("display", "block");
            error = 1;
        }
        if (memo_date.trim() == "") {
            $("#memo_date_error").html('<span style="color:red;font-style:italic;font-size:13px;">Please enter Memo Date</span>');
            $("#memo_date_error").css("display", "block");
            error = 1;
        }
        if (publish_date.trim() == "") {
            $("#publish_date_error").html('<span style="color:red;font-style:italic;font-size:13px;">Please enter Publish Date</span>');
            $("#publish_date_error").css("display", "block");
            error = 1;
        }
        if (subject.trim() == "") {
            $("#subject_error").html('<span style="color:red;font-style:italic;font-size:13px;">Please enter Subject</span>');
            $("#subject_error").css("display", "block");
            error = 1;
        }
        if (description.trim() == "") {
            $("#description_error").html('<span style="color:red;font-style:italic;font-size:13px;">Please enter Description</span>');
            $("#description_error").css("display", "block");
            error = 1;
        }
        if (is_active.trim() == "") {
            $("#is_active_error").html('<span style="color:red;font-style:italic;font-size:13px;">Please select Status</span>');
            $("#is_active_error").css("display", "block");
            error = 1;
        }

        if (error == 0) {

            $.ajax({
                url: "{{ URL::action('AdminController@submitUpdateMemo') }}",
                type: "POST",
                data: {
                    memo_type: memo_type,
                    memo_date: memo_date,
                    publish_date: publish_date,
                    expired_date: expired_date,
                    subject: subject,
                    description: description,
                    remarks: remarks,
                    is_active: is_active,
                    id: '{{$memo->id}}'
                },
                success: function (data) {
                    $("#loading").css("display", "none");
                    $("#submit_button").removeAttr("disabled");
                    $("#cancel_button").removeAttr("disabled");
                    if (data.trim() == "true") {
                        bootbox.alert("<span style='color:green;'>Memo updated successfully!</span>", function () {
                            window.location = '{{URL::action("AdminController@memo") }}';
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
</script>
<!-- End Page Scripts-->

@stop