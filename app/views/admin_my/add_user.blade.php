@extends('layout.malay_layout.default')

@section('content')

<?php
$insert_permission = 0;

foreach ($user_permission as $permission) {
    if ($permission->submodule_id == 6) {
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
                    <!-- Vertical Form -->
                    <form id="add_user">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label style="color: red; font-style: italic;">* Medan Wajib Diisi</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label><span style="color: red; font-style: italic;">* </span>Nama Pengguna</label>
                                    <input type="text" class="form-control" placeholder="Nama Pengguna" id="username" autocomplete="off">
                                    <div id="username_error" style="display:none;"></div>
                                    <div id="username_in_use" style="display:none"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label><span style="color: red; font-style: italic;">* </span>Kata Laluan</label>
                                    <input type="password" class="form-control" placeholder="Kata Laluan" id="password" autocomplete="new-password">
                                    <div id="password_error" style="display:none;"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label><span style="color: red; font-style: italic;">* </span>Nama Penuh</label>
                                    <input type="text" class="form-control" placeholder="Nama Penuh" id="name">
                                    <div id="name_error" style="display:none;"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><span style="color: red; font-style: italic;">* </span>E-mel</label>
                                    <input type="text" class="form-control" placeholder="E-mel" id="email">
                                    <div id="email_error" style="display:none;"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>No. Telefon</label>
                                    <input type="text" class="form-control" placeholder="No. Telefon" id="phone_no">
                                    <div id="phone_no_error" style="display:none;"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label><span style="color: red; font-style: italic;">* </span>Akses Kumpulan</label>
                                    <select id="role" class="form-control select2" onchange="showExpiryDate(this)">
                                        <option value="">Sila pilih</option>
                                        @foreach ($role as $roles)
                                        <option value="{{$roles->id}}">{{$roles->name}}</option>
                                        @endforeach
                                    </select>
                                    <div id="role_error" style="display:none;"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="expiry_date" style="display: none;">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label><span style="color: red;">*</span> {{ trans("app.forms.date_start") }}</label>
                                    <label class="input-group">
                                        <input type="text" class="form-control" placeholder="Start Date" id="start_date_raw"/>
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
                                    <label><span style="color: red;">*</span> {{ trans("app.forms.date_end") }}</label>
                                    <label class="input-group">
                                        <input type="text" class="form-control" placeholder="End Date" id="end_date_raw"/>
                                        <span class="input-group-addon">
                                            <i class="icmn-calendar"></i>
                                        </span>
                                    </label>
                                    <input type="hidden" id="end_date" value=""/>
                                    <div id="end_date_error" style="display:none;"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><span style="color: red;">*</span> {{ trans('app.forms.cob') }}</label>
                                    <select id="company" class="form-control select2" onchange="findFile()">
                                        <option value="">{{ trans('app.forms.please_select') }}</option>
                                        @foreach ($company as $companies)
                                        <option value="{{$companies->id}}">{{$companies->name}} ({{$companies->short_name}})</option>
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
                                        <option value="">{{ trans('app.forms.please_select') }}</option>
                                    </select>
                                    <div id="file_id_error" style="display:none;"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label><span style="color: red;">*</span> {{ trans('app.forms.admin_status') }}</label>
                                    <select id="is_active" class="form-control">
                                        <option value="">Sila pilih</option>
                                        <option value="1">Aktif</option>
                                        <option value="0">Tidak Aktif</option>
                                    </select>
                                    <div id="is_active_error" style="display:none;"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>Catatan</label>
                                    <textarea class="form-control" rows="3" placeholder="Catatan" id="remarks"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions">
                            <?php if ($insert_permission == 1) { ?>
                                <button type="button" class="btn btn-primary" id="submit_button" onclick="addUser()">Simpan</button>
                            <?php } ?>
                            <button type="button" class="btn btn-default" id="cancel_button" onclick="window.location ='{{URL::action('AdminController@user')}}'">Batal</button>
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

    function addUser() {
        $("#loading").css("display", "inline-block");
        $("#submit_button").attr("disabled", "disabled");
        $("#cancel_button").attr("disabled", "disabled");

        var username = $("#username").val(),
                password = $("#password").val(),
                name = $("#name").val(),
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
                $("#file_id_error").html('<span style="color:red;font-style:italic;font-size:13px;">{{ trans("app.errors.select", ["attribute"=>"File"]) }}</span>');
                $("#file_id_error").css("display", "block");
                error = 1;
            }
        }

        if (username.trim() == "") {
            $("#username_error").html('<span style="color:red;font-style:italic;font-size:13px;">Sila masukkan Nama Pengguna</span>');
            $("#username_error").css("display", "block");
            $("#username_in_use").css("display", "none");
            error = 1;
        }
        if (password.trim() == "") {
            $("#password_error").html('<span style="color:red;font-style:italic;font-size:13px;">Sila masukkan Kata Laluan</span>');
            $("#password_error").css("display", "block");
            error = 1;
        }
        if (name.trim() == "") {
            $("#name_error").html('<span style="color:red;font-style:italic;font-size:13px;">Sila masukkan Nama Penuh</span>');
            $("#name_error").css("display", "block");
            error = 1;
        }
        if (email.trim() == "" || !IsEmail(email)) {
            $("#email_error").html('<span style="color:red;font-style:italic;font-size:13px;">Sila masukkan E-mel</span>');
            $("#email_error").css("display", "block");
            error = 1;
        }
        if (role.trim() == "") {
            $("#role_error").html('<span style="color:red;font-style:italic;font-size:13px;">SIla pilih Akses Kumpulan</span>');
            $("#role_error").css("display", "block");
            error = 1;
        }
        if (company.trim() == "") {
            $("#company_error").html('<span style="color:red;font-style:italic;font-size:13px;">Please select Company</span>');
            $("#company_error").css("display", "block");
            error = 1;
        }
        if (is_active.trim() == "") {
            $("#is_active_error").html('<span style="color:red;font-style:italic;font-size:13px;">Sila pilih Status</span>');
            $("#is_active_error").css("display", "block");
            error = 1;
        }

        if (error == 0) {
            $.ajax({
                url: "{{ URL::action('AdminController@submitUser') }}",
                type: "POST",
                data: {
                    username: username,
                    password: password,
                    name: name,
                    role: role,
                    start_date: start_date,
                    end_date: end_date,
                    file_id: file_id,
                    company: company,
                    email: email,
                    phone_no: phone_no,
                    remarks: remarks,
                    is_active: is_active
                },
                success: function (data) {
                    $("#loading").css("display", "none");
                    $("#submit_button").removeAttr("disabled");
                    $("#cancel_button").removeAttr("disabled");
                    if (data.trim() == "true") {
                        bootbox.alert("<span style='color:green;'>Tambah pengguna berjaya!</span>", function () {
                            window.location = '{{URL::action("AdminController@user") }}';
                        });
                    } else if (data.trim() == "username_in_use") {
                        $("#username_in_use").html('<span style="color:red;font-style:italic;font-size:13px;">Nama pengguna ini telah wujud</span>');
                        $("#username_in_use").css("display", "block");
                        $("#username_error").css("display", "none");
                    } else {
                        bootbox.alert("<span style='color:red;'>Ralat. Sila cuba lagi.</span>");
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
