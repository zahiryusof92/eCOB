@extends('layout.malay_layout.default')

@section('content')

<?php
$insert_permission = 0;

foreach ($user_permission as $permission) {
    if ($permission->submodule_id == 33) {
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
                    <form class="form-horizontal">
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
                                        <option value="">Please select</option>
                                        @foreach ($files as $file) 
                                        <option value="{{$file->id}}">{{$file->file_no}}</option>
                                        @endforeach
                                    </select>
                                    <div id="file_id_error" style="display:none;"></div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-control-label"><span style="color: red; font-style: italic;">*</span> Designation</label>
                                    <select id="designation" class="form-control select2">
                                        <option value="">Please select</option>
                                        @foreach ($designation as $designations) 
                                        <option value="{{$designations->id}}">{{$designations->description}}</option>
                                        @endforeach
                                    </select>
                                    <div id="designation_error" style="display:none;"></div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label class="form-control-label"><span style="color: red; font-style: italic;">*</span> Name</label>
                                    <input type="text" class="form-control" placeholder="Name" id="name"/>
                                    <div id="name_error" style="display:none;"></div>
                                </div>                    
                            </div> 
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="form-control-label"><span style="color: red; font-style: italic;">*</span> Phone Number</label>                   
                                    <input type="text" class="form-control" placeholder="Phone Number" id="phone_no"/>
                                    <div id="phone_no_error" style="display:none;"></div>
                                    <div id="phone_no_invalid_error" style="display:none;"></div>
                                </div>                    
                            </div> 
                        </div>

                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="form-control-label"><span style="color: red; font-style: italic;">*</span> Year</label>
                                    <input type="text" class="form-control" placeholder="Year" id="year"/>
                                    <div id="year_error" style="display:none;"></div>
                                    <div id="year_invalid_error" style="display:none;"></div>
                                </div>                    
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-control-label">Remarks</label>
                                    <textarea class="form-control" placeholder="Remarks" id="remarks" rows="5"></textarea>
                                </div>                    
                            </div>
                        </div>

                        <div class="form-actions">
                            <?php if ($insert_permission == 1) { ?>
                                <button type="button" class="btn btn-primary" id="submit_button" onclick="addAJKDetail()">Submit</button>
                            <?php } ?>
                            <button type="button" class="btn btn-default" id="cancel_button" onclick="window.location = '{{ URL::action('AgmController@AJK') }}'">Cancel</button>
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
    function addAJKDetail() {
        $("#loading").css("display", "inline-block");
        $("#submit_button").attr("disabled", "disabled");
        $("#cancel_button").attr("disabled", "disabled");
        $("#file_id_error").css("display", "none");
        $("#designation_error").css("display", "none");
        $("#name_error").css("display", "none");
        $("#phone_no_error").css("display", "none");
        $("#phone_no_invalid_error").css("display", "none");
        $("#year_error").css("display", "none");
        $("#year_invalid_error").css("display", "none");

        var file_id = $("#file_id").val(),
                designation = $("#designation").val(),
                name = $("#name").val(),
                phone_no = $("#phone_no").val(),
                year = $("#year").val(),
                remarks = $("#remarks").val();

        var error = 0;

        if (file_id.trim() == "") {
            $("#file_id_error").html('<span style="color:red;font-style:italic;font-size:13px;">Please select File No</span>');
            $("#file_id_error").css("display", "block");
            error = 1;
        }

        if (designation.trim() == "") {
            $("#designation_error").html('<span style="color:red;font-style:italic;font-size:13px;">Please select Designation</span>');
            $("#designation_error").css("display", "block");
            error = 1;
        }

        if (name.trim() == "") {
            $("#name_error").html('<span style="color:red;font-style:italic;font-size:13px;">Please enter Name</span>');
            $("#name_error").css("display", "block");
            error = 1;
        }

        if (phone_no.trim() == "") {
            $("#phone_no_error").html('<span style="color:red;font-style:italic;font-size:13px;">Please enter Phone Number</span>');
            $("#phone_no_error").css("display", "block");
            $("#phone_no_invalid_error").css("display", "none");
            error = 1;
        }

        if (isNaN(phone_no)) {
            $("#phone_no_invalid_error").html('<span style="color:red;font-style:italic;font-size:13px;">Please enter valid Phone Number</span>');
            $("#phone_no_invalid_error").css("display", "block");
            $("#phone_no_error").css("display", "none");
            error = 1;
        }

        if (year.trim() == "") {
            $("#year_error").html('<span style="color:red;font-style:italic;font-size:13px;">Please enter Year</span>');
            $("#year_error").css("display", "block");
            $("#year_invalid_error").css("display", "none");
            error = 1;
        }

        if (isNaN(year)) {
            $("#year_invalid_error").html('<span style="color:red;font-style:italic;font-size:13px;">Please enter valid Year</span>');
            $("#year_invalid_error").css("display", "block");
            $("#year_error").css("display", "none");
            error = 1;
        }

        if (error == 0) {
            $.ajax({
                url: "{{ URL::action('AgmController@submitAddAJK') }}",
                type: "POST",
                data: {
                    file_id: file_id,
                    designation: designation,
                    name: name,
                    phone_no: phone_no,
                    year: year,
                    remarks: remarks
                },
                success: function (data) {
                    $("#loading").css("display", "none");
                    $("#submit_button").removeAttr("disabled");
                    $("#cancel_button").removeAttr("disabled");
                    if (data.trim() == "true") {
                        bootbox.alert("<span style='color:green;'>AJK added successfully!</span>", function () {
                            window.location = '{{URL::action("AgmController@AJK") }}';
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