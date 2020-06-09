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
            <div class="row">
                <div class="col-lg-12">
                    <!-- Vertical Form -->
                    <form id="add_user">
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
                                    <label><span style="color: red; font-style: italic;">* </span>Nama Pengguna</label>
                                    <input type="text" class="form-control" placeholder="Nama Pengguna" id="username" value="{{$user->username}}" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label><span style="color: red; font-style: italic;">*</span> Full Name</label>
                                    <input type="text" class="form-control" placeholder="Name" id="name" value="{{$user->full_name}}">
                                    <div id="name_error" style="display:none;"></div>
                                </div>
                            </div>
                        </div>                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><span style="color: red; font-style: italic;">*</span> Email</label>
                                    <input type="text" class="form-control" placeholder="Email" id="email" value="{{$user->email}}">
                                    <div id="email_error" style="display:none;"></div>
                                </div>
                            </div>
                        </div> 
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Phone Number</label>
                                    <input type="text" class="form-control" placeholder="Phone Number" id="phone_no" value="{{$user->phone_no}}">
                                    <div id="phone_no_error" style="display:none;"></div>
                                </div>
                            </div>                            
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label><span style="color: red;">*</span> Access Group</label>
                                    <select id="role" class="form-control select2" onchange="showExpiryDate(this)">
                                        <option value="">Please Select</option>
                                        @foreach ($role as $roles)
                                        <option value="{{$roles->name}}" {{($user->role == $roles->id ? " selected" : "")}}>{{$roles->name}}</option>
                                        @endforeach
                                    </select>
                                    <div id="role_error" style="display:none;"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="expiry_date" style="display: none;">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label><span style="color: red;">*</span> Start Date</label>
                                    <label class="input-group">
                                        <input type="text" class="form-control" placeholder="Start Date" id="start_date_raw" value="{{ (!empty($user->start_date) ? date('d-m-Y', strtotime($user->start_date)) : '') }}"/>
                                        <span class="input-group-addon">
                                            <i class="icmn-calendar"></i>
                                        </span>
                                    </label>
                                    <input type="hidden" id="start_date" value=""/>
                                    <div id="start_date_error" style="display:none;"></div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label><span style="color: red;">*</span> End Date</label>
                                    <label class="input-group">
                                        <input type="text" class="form-control" placeholder="End Date" id="end_date_raw" value="{{ (!empty($user->end_date) ? date('d-m-Y', strtotime($user->end_date)) : '') }}"/>
                                        <span class="input-group-addon">
                                            <i class="icmn-calendar"></i>
                                        </span>
                                    </label>
                                    <input type="hidden" id="end_date" value="{{ $user->end_date }}"/>
                                    <div id="end_date_error" style="display:none;"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><span style="color: red;">*</span> COB</label>
                                    <select id="company" class="form-control select2" onchange="findFile()">
                                        <option value="">Please Select</option>
                                        @foreach ($company as $companies)
                                        <option value="{{$companies->id}}" {{ $user->company_id == $companies->id ? 'selected' : '' }}>{{$companies->name}} ({{$companies->short_name}})</option>
                                        @endforeach
                                    </select>
                                    <div id="company_error" style="display:none;"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="file_form" style="display: none;">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><span style="color: red;">*</span> Files</label>
                                    <select id="file_id" class="form-control select2">
                                        <option value="">Please Select</option>
                                        @foreach ($files as $file)
                                        <option value="{{$file->id}}" {{ $user->file_id == $file->id ? 'selected' : '' }}>{{ $file->file_no }}</option>
                                        @endforeach
                                    </select>
                                    <div id="file_id_error" style="display:none;"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label><span style="color: red;">*</span> Status</label>
                                    <select id="is_active" class="form-control">
                                        <option value="">Please Select</option>
                                        <option value="1" {{($user->is_active == 1 ? " selected" : "")}}>Active</option>
                                        <option value="0" {{($user->is_active == 0 ? " selected" : "")}}>Inactive</option>
                                    </select>
                                    <div id="is_active_error" style="display:none;"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>Remarks</label>
                                    <textarea class="form-control" rows="3" placeholder="Remarks" id="remarks">{{$user->remarks}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions">
                            <?php if ($update_permission == 1) { ?>
                                <button type="button" class="btn btn-primary" id="submit_button" onclick="updateUser()">Submit</button>
                            <?php } ?>
                            <button type="button" class="btn btn-default" id="cancel_button" onclick="window.location ='{{URL::action('AdminController@user')}}'">Cancel</button>
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
    $(document).ready(function ($) {
        var current_role = '<?php echo $user->getRole->name; ?>';

        viewExpiryDate(current_role);
    });

    function viewExpiryDate(role) {
        role.toUpperCase();

        if (role.trim() == 'JMB' || role.trim() == 'MC') {
            $("#expiry_date").fadeIn();
            $("#file_form").fadeIn();
        } else {
            $("#expiry_date").fadeOut();
            $("#file_form").fadeOut();
        }
    }

    function showExpiryDate(value) {
        var role = $("#role").val();
        role.toUpperCase();

        if (role.trim() == 'JMB' || role.trim() == 'MC') {
            $("#expiry_date").fadeIn();
            $("#file_form").fadeIn();
        } else {
            $("#expiry_date").fadeOut();
            $("#file_form").fadeOut();
        }
    }

    function findFile() {
        $.ajax({
            url: "{{ URL::action('AdminController@findFile') }}",
            type: "POST",
            data: {
                cob: $("#company").val()
            },
            success: function (data) {
                $("#file_id").html(data);
            }
        });
    }

    $("#start_date_raw").datetimepicker({
        widgetPositioning: {
            horizontal: 'left'
        },
        icons: {
            time: "fa fa-clock-o",
            date: "fa fa-calendar",
            up: "fa fa-arrow-up",
            down: "fa fa-arrow-down"
        },
        format: 'DD-MM-YYYY'
    }).on('dp.change', function () {
        let currentDate = $(this).val().split('-');
        $("#start_date").val(`${currentDate[2]}-${currentDate[1]}-${currentDate[0]}`);
    });

    $("#end_date_raw").datetimepicker({
        widgetPositioning: {
            horizontal: 'left'
        },
        icons: {
            time: "fa fa-clock-o",
            date: "fa fa-calendar",
            up: "fa fa-arrow-up",
            down: "fa fa-arrow-down"
        },
        format: 'DD-MM-YYYY'
    }).on('dp.change', function () {
        let currentDate = $(this).val().split('-');
        $("#end_date").val(`${currentDate[2]}-${currentDate[1]}-${currentDate[0]}`);
    });

    function updateUser() {
        $("#loading").css("display", "inline-block");
        $("#submit_button").attr("disabled", "disabled");
        $("#cancel_button").attr("disabled", "disabled");

        var name = $("#name").val(),
                role = $("#role").val(),
                start_date = $("#start_date").val(),
                end_date = $("#end_date").val(),
                file_id = $("#file_id").val(),
                company = $("#company").val(),
                email = $("#email").val(),
                phone_no = $("#phone_no").val(),
                remarks = $("#remarks").val(),
                is_active = $("#is_active").val();

        var error = 0;

        if (role == 'JMB' || role == 'MC') {
            if (start_date.trim() == "") {
                $("#start_date_error").html('<span style="color:red;font-style:italic;font-size:13px;">Please enter Start Date</span>');
                $("#start_date_error").css("display", "block");
                error = 1;
            }
            if (end_date.trim() == "") {
                $("#end_date_error").html('<span style="color:red;font-style:italic;font-size:13px;">Please enter End Date</span>');
                $("#end_date_error").css("display", "block");
                error = 1;
            }
            if (file_id.trim() == "") {
                $("#file_id_error").html('<span style="color:red;font-style:italic;font-size:13px;">Please select File</span>');
                $("#file_id_error").css("display", "block");
                error = 1;
            }
        }

        if (name.trim() == "") {
            $("#name_error").html('<span style="color:red;font-style:italic;font-size:13px;">Please enter Full Name</span>');
            $("#name_error").css("display", "block");
            error = 1;
        }
        if (email.trim() == "" || !IsEmail(email)) {
            $("#email_error").html('<span style="color:red;font-style:italic;font-size:13px;">Please enter valid Email</span>');
            $("#email_error").css("display", "block");
            error = 1;
        }
        if (role.trim() == "") {
            $("#role_error").html('<span style="color:red;font-style:italic;font-size:13px;">Please select Access Group</span>');
            $("#role_error").css("display", "block");
            error = 1;
        }
        if (company.trim() == "") {
            $("#company_error").html('<span style="color:red;font-style:italic;font-size:13px;">Please select Company</span>');
            $("#company_error").css("display", "block");
            error = 1;
        }
        if (is_active.trim() == "") {
            $("#is_active_error").html('<span style="color:red;font-style:italic;font-size:13px;">Please select Status</span>');
            $("#is_active_error").css("display", "block");
            error = 1;
        }

        if (error == 0) {
            $.ajax({
                url: "{{ URL::action('AdminController@submitUpdateUser') }}",
                type: "POST",
                data: {
                    name: name,
                    role: role,
                    start_date: start_date,
                    end_date: end_date,
                    file_id: file_id,
                    company: company,
                    email: email,
                    phone_no: phone_no,
                    remarks: remarks,
                    is_active: is_active,
                    id: '{{$user->id}}'
                },
                success: function (data) {
                    $("#loading").css("display", "none");
                    $("#submit_button").removeAttr("disabled");
                    $("#cancel_button").removeAttr("disabled");
                    if (data.trim() == "true") {
                        bootbox.alert("<span style='color:green;'>User updated successfully!</span>", function () {
                            window.location = '{{URL::action("AdminController@user") }}';
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

    function IsEmail(email) {
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        return regex.test(email);
    }
</script>
<!-- End Page Scripts-->

@stop