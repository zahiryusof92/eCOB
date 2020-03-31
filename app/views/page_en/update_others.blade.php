@extends('layout.english_layout.default')

@section('content')

<?php
$update_permission = 0;

foreach ($user_permission as $permission) {
    if ($permission->submodule_id == 3) {
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
                    <h6>File No: {{$file->file_no}}</h6>
                    <div id="update_files_lists">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link" href="{{URL::action('AdminController@house', $file->id)}}">Housing Scheme</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{URL::action('AdminController@strata', $file->id)}}">Developed Area (STRATA)</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{URL::action('AdminController@management', $file->id)}}">Management</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{URL::action('AdminController@monitoring', $file->id)}}">Monitoring</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" href="{{URL::action('AdminController@others', $file->id)}}">Others</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{URL::action('AdminController@scoring', $file->id)}}">Scoring Component Value</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{URL::action('AdminController@buyer', $file->id)}}">Buyer List</a>
                            </li>
                        </ul>
                        <div class="tab-content padding-vertical-20">                            
                            <div class="tab-pane active" id="others_tab" role="tabpanel">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <h4>Detail</h4>
                                        <!-- Form -->
                                        <form id="others">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Name</label>
                                                        <input type="text" class="form-control" placeholder="Name" id="other_details_name" value="{{$other_details->name}}">
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                        <form id="upload_others_image" enctype="multipart/form-data" method="post" action="{{url('uploadOthersImage')}}" autocomplete="off">
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <div class="form-group">
                                                        <label>Photo</label>
                                                        <br />
                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                                        <button type="button" id="clear_image" data-toggle="tooltip" data-placement="top" title="Clear" class="btn btn-xs btn-danger" onclick="clearImage()" style="display: none;"><i class="fa fa-times"></i></button>
                                                        &nbsp;<input type="file" name="image" id="image" />
<!--                                                        <br />
                                                        <small>Max image size: MB</small>-->
                                                    </div>
                                                </div>
                                            </div>
                                            @if ($other_details->image_url != "")
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <div class="form-group">
                                                        <div id="others_image_output">
                                                            <a href="{{asset($other_details->image_url)}}" target="_blank"><img src="{{asset($other_details->image_url)}}" style="width:50%; cursor: pointer;"/></a>
                                                            <?php if ($update_permission == 1) { ?>
                                                            <button type="button" class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="right" title="Delete" onclick="deleteImageOthers('{{$other_details->id}}')"><i class="fa fa-times"></i></button>
                                                            <?php } ?>
                                                        </div>
                                                        <div id="validation-errors"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            @else
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <div class="form-group">
                                                        <div id="others_image_output"></div>
                                                        <div id="validation-errors"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                        </form>
                                        <form id="others">
                                            @if ($other_details->latitude == "0")
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Latitude </label>
                                                        <input type="text" class="form-control" placeholder="Latitude " id="latitude">
                                                    </div>
                                                </div>
                                            </div>
                                            @else
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Latitude </label>
                                                        <input type="text" class="form-control" placeholder="Latitude " id="latitude" value="{{$other_details->latitude}}">
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                            @if ($other_details->longitude == "0")
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Longitude </label>
                                                        <input type="text" class="form-control" placeholder="Longitude " id="longitude">
                                                    </div>
                                                </div>
                                            </div>
                                            @else
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Longitude </label>
                                                        <input type="text" class="form-control" placeholder="Longitude " id="longitude" value="{{$other_details->longitude}}">
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                            @if ($other_details->latitude != "0" && $other_details->longitude != "0")
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <a href="https://www.google.com.my/maps/preview?q={{$other_details->latitude}},{{$other_details->longitude}}" target="_blank">
                                                            <button type="button" class="btn btn-success">                                                                
                                                                <i class="fa fa-map-marker"> View Map</i>
                                                            </button>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Description</label>
                                                        <textarea class="form-control" rows="3" id="other_details_description" placeholder="Description">{{$other_details->description}}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>PMS System</label>
                                                        <input type="text" class="form-control" placeholder="PMS System" id="pms_system" value="{{$other_details->pms_system}}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label>Owner Occupied</label>
                                                        <select id="owner_occupied" class="form-control">
                                                            <option value="">Please Select</option>
                                                            <option value="1" {{ ($other_details->owner_occupied == '1' ? " selected" : "") }}>Yes</option>
                                                            <option value="0" {{ ($other_details->owner_occupied == '0' ? " selected" : "") }}>No</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label>Rented</label>
                                                        <select id="rented" class="form-control">
                                                            <option value="">Please Select</option>
                                                            <option value="1" {{ ($other_details->rented == '1' ? " selected" : "") }}>Yes</option>
                                                            <option value="0" {{ ($other_details->rented == '0' ? " selected" : "") }}>No</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label>Bantuan LPHS</label>
                                                        <select id="bantuan_lphs" class="form-control">
                                                            <option value="">Please Select</option>
                                                            <option value="1" {{ ($other_details->bantuan_lphs == '1' ? " selected" : "") }}>Yes</option>
                                                            <option value="0" {{ ($other_details->bantuan_lphs == '0' ? " selected" : "") }}>No</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label>Other Bantuan</label>
                                                        <select id="bantuan_others" class="form-control">
                                                            <option value="">Please Select</option>
                                                            <option value="1" {{ ($other_details->bantuan_others == '1' ? " selected" : "") }}>Yes</option>
                                                            <option value="0" {{ ($other_details->bantuan_others == '0' ? " selected" : "") }}>No</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label>Rumah Selangorku</label>
                                                        <select id="rsku" class="form-control">
                                                            <option value="">Please Select</option>
                                                            <option value="none" {{ ($other_details->rsku == 'none' ? " selected" : "") }}>- None -</option>
                                                            <option value="< 42,000" {{ ($other_details->rsku == '< 42,000' ? " selected" : "") }}>< 42,000</option>
                                                            <option value="< 100,000" {{ ($other_details->rsku == '< 100,000' ? " selected" : "") }}>< 100,000</option>
                                                            <option value="< 180,000" {{ ($other_details->rsku == '< 180,000' ? " selected" : "") }}>< 180,000</option>
                                                            <option value="< 250,000" {{ ($other_details->rsku == '< 250,000' ? " selected" : "") }}>< 250,000</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label>Water Meter</label>
                                                        <select id="water_meter" class="form-control">
                                                            <option value="">Please Select</option>
                                                            <option value="none" {{ ($other_details->water_meter == 'none' ? " selected" : "") }}>- None -</option>
                                                            <option value="BULK" {{ ($other_details->water_meter == 'BULK' ? " selected" : "") }}>BULK</option>
                                                            <option value="INDIVIDUAL" {{ ($other_details->water_meter == 'INDIVIDUAL' ? " selected" : "") }}>INDIVIDUAL</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label>Malay Composition</label>
                                                        <input type="number" step="0.01" class="form-control text-right" placeholder="Malay Composition" id="malay_composition" value="{{$other_details->malay_composition}}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label>Chinese Composition</label>
                                                        <input type="number" step="0.01" class="form-control text-right" placeholder="Chinese Composition" id="chinese_composition" value="{{$other_details->chinese_composition}}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label>Indian Composition</label>
                                                        <input type="number" step="0.01" class="form-control text-right" placeholder="Indian Composition" id="indian_composition" value="{{$other_details->indian_composition}}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label>Others Composition</label>
                                                        <input type="number" step="0.01" class="form-control text-right" placeholder="Others Composition" id="others_composition" value="{{$other_details->others_composition}}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label>Foreigner Composition</label>
                                                        <input type="number" step="0.01" class="form-control text-right" placeholder="Foreigner Composition" id="foreigner_composition" value="{{$other_details->foreigner_composition}}">
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="form-actions">
                                                <input type="hidden" id="others_image_url" value="{{$other_details->image_url}}"/>
                                                <?php if ($update_permission == 1) { ?>
                                                <button type="button" class="btn btn-primary" id="submit_button" onclick="updateOtherDetails()">Submit</button>
                                                <?php } ?>
                                                <button type="button" class="btn btn-default" id="cancel_button" onclick="window.location ='{{URL::action('AdminController@fileList')}}'">Cancel</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>                
            </div>
        </div>
    </section>
    <!-- End -->
</div>

<!-- Page Scripts -->

 <script>
    $(document).ready(function () {
        $(function() {
            $("#image").change(function() {
                $("#validation-errors").empty(); // To remove the previous error message
                var file = this.files[0];
                var imagefile = file.type;
                var match = ["image/jpeg", "image/png", "image/jpg", "image/gif"];
                if (!((imagefile == match[0]) || (imagefile == match[1]) || (imagefile == match[2]) || (imagefile == match[3]))) {
                    $("#validation-errors").html("<span id='error'>Please Select a valid Image File</span><br/>" + "<span id='error_message'>Only .jpeg, .jpg, .png and .gif images type allowed</span>");
                    $("#validation-errors").css("color", "red");
                    return false;
                }
                else {
                    var reader = new FileReader();
                    reader.onload = imageIsLoaded;
                    reader.readAsDataURL(this.files[0]);
                }
            });
        });

        function imageIsLoaded(e) {
            $("#clear_image").show();
            $("#image").css("color", "green");
            $('#others_image_output').css("display", "block");
            $("#others_image_output").html("<img id='previewing' style='width: 50%;'/>");
            $('#previewing').attr('src', e.target.result);
        };        
        
        //upload
        var options = {
            beforeSubmit: showRequest,
            success: showResponse,
            dataType: 'json'
        };

        $('body').delegate('#image', 'change', function () {
            $('#upload_others_image').ajaxForm(options).submit();
        });
    });

    function showRequest(formData, jqForm, options) {
        $("#validation-errors").css('display', 'none');
        return true;
    }
    function showResponse(response, statusText, xhr, $form) {
        if (response.success == false)
        {
            var arr = response.errors;
            $.each(arr, function (index, value)
            {
                if (value.length != 0)
                {
                    $("#validation-errors").append('<div class="alert alert-error"><strong>' + value + '</strong><div>');
                }
            });
            $("#validation-errors").show();
            $("#image").css("color", "red");
        } else {
            $("#others_image_url").val(response.file);           
        }
    }
    
    function updateOtherDetails(){
        $("#loading").css("display", "inline-block");
        
        var other_details_name = $("#other_details_name").val(),
                others_image_url = $("#others_image_url").val(),
                latitude = $("#latitude").val(),
                longitude = $("#longitude").val(),
                other_details_description = $("#other_details_description").val(),
                pms_system = $("#pms_system").val(),
                owner_occupied = $("#owner_occupied").val(),
                rented = $("#rented").val(),
                bantuan_lphs = $("#bantuan_lphs").val(),
                bantuan_others = $("#bantuan_others").val(),
                rsku = $("#rsku").val(),
                water_meter = $("#water_meter").val(),
                malay_composition = $("#malay_composition").val(),
                chinese_composition = $("#chinese_composition").val(),
                indian_composition = $("#indian_composition").val(),
                others_composition = $("#others_composition").val(),
                foreigner_composition = $("#foreigner_composition").val();

        var error = 0;        

        if (error == 0) {
            $.ajax({
                url: "{{ URL::action('AdminController@submitUpdateOtherDetails') }}",
                type: "POST",
                data: { 
                    other_details_name: other_details_name,
                    others_image_url: others_image_url,
                    latitude: latitude,
                    longitude: longitude,
                    other_details_description: other_details_description,
                    pms_system: pms_system,
                    owner_occupied: owner_occupied,
                    rented: rented,
                    bantuan_lphs: bantuan_lphs,
                    bantuan_others: bantuan_others,
                    rsku: rsku,
                    water_meter: water_meter,
                    malay_composition: malay_composition,
                    chinese_composition: chinese_composition,
                    indian_composition: indian_composition,
                    others_composition: others_composition,
                    foreigner_composition: foreigner_composition,
                    id: '{{$other_details->id}}'
                },
                success: function (data) {
                    $("#loading").css("display", "none");
                    $("#submit_button").removeAttr("disabled");
                    if (data.trim() == "true") {                        
                        $.notify({
                            message: '<p style="text-align: center; margin-bottom: 0px;">Successfully saved</p>',
                        },{
                            type: 'success',
                            placement: {
                                align: "center"
                            }
                        }); 
                        window.location = "{{URL::action('AdminController@scoring', $file->id)}}";  
                    } else {
                        bootbox.alert("<span style='color:red;'>An error occured while processing. Please try again.</span>");
                    }
                }
            });
        }
    }
    
    function clearImage() {
        $("#image").val("");
        $("#others_image_url").val("");
        $("#image").css("color", "grey");
        $("#clear_image").hide();
        $("#validation-errors").hide();
        $("#others_image_output").css('display', 'none');
    }
    
    function deleteImageOthers(id){
        swal({
            title: "Are you sure?",
            text: "Your will not be able to recover this file!",
            type: "warning",
            showCancelButton: true,            
            confirmButtonClass: "btn-warning",
            cancelButtonClass: "btn-default",
            confirmButtonText: "Delete",
            closeOnConfirm: true
        },
        function(){
            $.ajax({
                url: "{{ URL::action('AdminController@deleteImageOthers') }}",
                type: "POST",
                data: {
                    id: id
                },
                success: function(data) {
                    if (data.trim() == "true") {
                        swal({
                            title: "Deleted!",
                            text: "File has been deleted",
                            type: "success",
                            confirmButtonClass: "btn-success",
                            closeOnConfirm: false
                        });
                        location.reload();
                    } else {
                        bootbox.alert("<span style='color:red;'>An error occured while processing. Please try again.</span>");
                    }
                }
            });
        });
    }
    
    $(function () {
        $("[data-toggle=tooltip]").tooltip();
    });
</script>


<!-- End Page Scripts-->

@stop