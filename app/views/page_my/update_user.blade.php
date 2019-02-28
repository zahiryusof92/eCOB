@extends('layout.malay_layout.default')

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
                                    <label style="color: red; font-style: italic;">* Medan Wajib Diisi</label>
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
                                    <label><span style="color: red; font-style: italic;">* </span>Nama Penuh</label>
                                    <input type="text" class="form-control" placeholder="Nama Penuh" id="name" value="{{$user->full_name}}">
                                    <div id="name_error" style="display:none;"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label><span style="color: red; font-style: italic;">* </span>Akses Kumpulan</label>
                                    <select id="role" class="form-control">
                                        <option value="">Sila pilih</option>
                                        @foreach ($role as $roles)
                                        <option value="{{$roles->id}}" {{($user->role == $roles->id ? " selected" : "")}}>{{$roles->name}}</option>
                                        @endforeach
                                    </select>
                                    <div id="role_error" style="display:none;"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><span style="color: red; font-style: italic;">* </span>E-mel</label>
                                    <input type="text" class="form-control" placeholder="E-mel" id="email" value="{{$user->email}}">
                                    <div id="email_error" style="display:none;"></div>
                                </div>
                            </div>
                        </div> 
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>No. Telefon</label>
                                    <input type="text" class="form-control" placeholder="No. Telefon" id="phone_no" value="{{$user->phone_no}}">
                                    <div id="phone_no_error" style="display:none;"></div>
                                </div>
                            </div>                            
                        </div> 
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label><span style="color: red; font-style: italic;">* </span>Status</label>
                                    <select id="is_active" class="form-control" {{($user->status == 0 ? " disabled" : "")}}>
                                        <option value="">Sila pilih</option>
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
                                    <label>Catatan</label>
                                    <textarea class="form-control" rows="3" placeholder="Catatan" id="remarks">{{$user->remarks}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions">
                            <?php if ($update_permission == 1) { ?>
                            <button type="button" class="btn btn-primary" id="submit_button" onclick="updateUser()">Simpan</button>
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

    function updateUser() {
        $("#loading").css("display", "inline-block");

        var name = $("#name").val(), 
                role = $("#role").val(),
                email = $("#email").val(),
                phone_no = $("#phone_no").val(),
                remarks = $("#remarks").val(),
                is_active = $("#is_active").val();

        var error = 0;        
       
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
        if (is_active.trim() == "") {
            $("#is_active_error").html('<span style="color:red;font-style:italic;font-size:13px;">Sila pilih Status</span>');
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
                        bootbox.alert("<span style='color:green;'>Edit Pengguna berjaya!</span>", function () {
                            window.location = '{{URL::action("AdminController@user") }}';
                        });
                    } else {
                        bootbox.alert("<span style='color:red;'>Ralat. Sila cuba lagi.</span>");
                    }
                }
            });
        }
    }
    
    function IsEmail(email) {
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        return regex.test(email);
    }
</script>
<!-- End Page Scripts-->

@stop