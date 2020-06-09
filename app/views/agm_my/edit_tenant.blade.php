@extends('layout.malay_layout.default')

@section('content')

<?php
$update_permission = 0;

foreach ($user_permission as $permission) {
    if ($permission->submodule_id == 43) {
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
                    <!-- Buyer Form -->
                    <form id="edit_buyer">
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
                                    <select id="file_id" class="form-control">
                                        <option value="">Please select</option>
                                        @foreach ($files as $file) 
                                        <option value="{{$file->id}}" {{($file->id == $buyer->file_id ? " selected" : "")}}>{{$file->file_no}}</option>
                                        @endforeach
                                    </select>
                                    <div id="file_id_error" style="display:none;"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label><span style="color: red;">*</span> Unit Number</label>
                                    <input type="text" class="form-control" placeholder="Unit Number" id="unit_no" value="{{$buyer->unit_no}}">
                                    <div id="unit_no_error" style="display:none;"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label><span style="color: red;">*</span> Tenant Name</label>
                                    <input type="text" class="form-control" placeholder="Tenant Name" id="tenant_name" value="{{$buyer->tenant_name}}">
                                    <div id="tenant_name_error" style="display:none;"></div>
                                </div>
                            </div>
                        </div>                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>IC No / Company Number</label>
                                    <input type="text" class="form-control" placeholder="IC No / Company Number" id="ic_company_no" value="{{$buyer->ic_company_no}}">
                                    <div id="ic_company_no_error" style="display:none;"></div>
                                </div>
                            </div>
                        </div> 
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>Address</label>
                                    <textarea class="form-control" placeholder="Address" rows="3" id="address">{{$buyer->address}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Phone Number</label>
                                    <input type="text" class="form-control" placeholder="Phone Number" id="phone_no" value="{{$buyer->phone_no}}">
                                </div>
                            </div>                            
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" class="form-control" placeholder="Email" id="email" value="{{$buyer->email}}">
                                </div>
                            </div>                            
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label><span style="color: red;">*</span> Race</label>
                                    <select id="race" class="form-control select2">
                                        <option value="">Please select</option>
                                        @foreach ($race as $races) 
                                        <option value="{{ $races->id }}" {{($buyer->race_id == $races->id ? " selected" : "")}}>{{ $races->name }}</option>
                                        @endforeach
                                    </select>
                                    <div id="race_error" style="display:none;"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>Remarks</label>
                                    <textarea class="form-control" placeholder="Remarks" rows="3" id="remarks">{{$buyer->remarks}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions">
                            <?php if ($update_permission == 1) { ?>
                                <button type="button" class="btn btn-primary" id="submit_button" onclick="editTenant()">Submit</button>
                            <?php } ?>
                            <button type="button" class="btn btn-default" id="cancel_button" onclick="window.location ='{{URL::action('AgmController@tenant')}}'">Cancel</button>
                            <img id="loading" style="display:none;" src="{{asset('assets/common/img/input-spinner.gif')}}"/>
                        </div>
                    </form>
                    <!-- End Form -->
                </div>
            </div>
        </div>
    </section>
    <!-- End -->
</div>

<!-- Page Scripts -->
<script>
    function editTenant() {
        $("#loading").css("display", "inline-block");
        $("#submit_button").attr("disabled", "disabled");
        $("#cancel_button").attr("disabled", "disabled");
        $("#file_id_error").css("display", "none");
        $("#unit_no_error").css("display", "none");
        $("#tenant_name_error").css("display", "none");
        $("#race_error").css("display", "none");

        var file_id = $("#file_id").val(),
                unit_no = $("#unit_no").val(),
                tenant_name = $("#tenant_name").val(),
                ic_company_no = $("#ic_company_no").val(),
                address = $("#address").val(),
                phone_no = $("#phone_no").val(),
                email = $("#email").val(),
                race = $("#race").val(),
                remarks = $("#remarks").val();

        var error = 0;

        if (file_id.trim() == "") {
            $("#file_id_error").html('<span style="color:red;font-style:italic;font-size:13px;">Please select File</span>');
            $("#file_id_error").css("display", "block");
            error = 1;
        }
        if (unit_no.trim() == "") {
            $("#unit_no_error").html('<span style="color:red;font-style:italic;font-size:13px;">Please enter Unit Number</span>');
            $("#unit_no_error").css("display", "block");
            error = 1;
        }
        if (tenant_name.trim() == "") {
            $("#tenant_name_error").html('<span style="color:red;font-style:italic;font-size:13px;">Please enter Owner Name</span>');
            $("#tenant_name_error").css("display", "block");
            error = 1;
        }
        if (race.trim() == "") {
            $("#race_error").html('<span style="color:red;font-style:italic;font-size:13px;">Please select Race</span>');
            $("#race_error").css("display", "block");
            error = 1;
        }

        if (error == 0) {
            $.ajax({
                url: "{{ URL::action('AgmController@submitEditTenant') }}",
                type: "POST",
                data: {
                    unit_no: unit_no,
                    tenant_name: tenant_name,
                    ic_company_no: ic_company_no,
                    address: address,
                    phone_no: phone_no,
                    email: email,
                    remarks: remarks,
                    race: race,
                    file_id: file_id,
                    id: '{{$buyer->id}}'
                },
                success: function (data) {
                    $("#loading").css("display", "none");
                    $("#submit_button").removeAttr("disabled");
                    $("#cancel_button").removeAttr("disabled");
                    if (data.trim() == "true") {
                        bootbox.alert("<span style='color:green;'>Tenant added successfully!</span>", function () {
                            window.location = '{{URL::action("AgmController@tenant") }}';
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