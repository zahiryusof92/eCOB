@extends('layout.malay_layout.default')

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
                    <h6>No. Fail: {{$file->file_no}}</h6>
                    <div id="update_files_lists">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link" href="{{URL::action('AdminController@viewScoring', $file->id)}}">Skim Perumahan</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{URL::action('AdminController@viewStrata', $file->id)}}">Kawasan Pemajuan (STRATA)</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{URL::action('AdminController@viewManagement', $file->id)}}">Pihak Pengurusan</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{URL::action('AdminController@viewMonitoring', $file->id)}}">Pemantauan</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active">Pelbagai</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{URL::action('AdminController@viewScoring', $file->id)}}">Pemarkahan Komponen Nilai</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{URL::action('AdminController@viewBuyer', $file->id)}}">Senarai Pembeli</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{URL::action('AdminController@fileApproval', $file->id)}}">Pengesahan</a>
                            </li>
                        </ul>
                        <div class="tab-content padding-vertical-20">                            
                            <div class="tab-pane active" id="others_tab" role="tabpanel">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <h4>Butiran</h4>
                                        <!-- Form -->
                                        <form id="others">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Nama</label>
                                                        <input type="text" class="form-control" placeholder="Nama" id="other_details_name" value="{{$other_details->name}}" readonly="">
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                        <form id="upload_others_image" enctype="multipart/form-data" method="post" action="{{url('uploadOthersImage')}}" autocomplete="off">
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <div class="form-group">
                                                        <label>Gambar</label>
                                                        <br />
                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                                        <button type="button" id="clear_image" data-toggle="tooltip" data-placement="top" title="Padam" class="btn btn-xs btn-danger" onclick="clearImage()" style="display: none;"><i class="fa fa-times"></i></button>
                                                        <!--&nbsp;<input type="file" name="image" id="image" />-->
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
                                                            
                                                        </div>
                                                        <div id="validation-errors"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            @else
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <div class="form-group">
                                                        <div id="others_image_output">
                                                            <span>Tiada gambar</span>
                                                        </div>                                                        
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
                                                        <label>Latitud</label>
                                                        <input type="text" class="form-control" placeholder="Latitud" id="latitude" readonly="">
                                                    </div>
                                                </div>
                                            </div>
                                            @else
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Latitud</label>
                                                        <input type="text" class="form-control" placeholder="Latitud" id="latitude" value="{{$other_details->latitude}}" readonly="">
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                            @if ($other_details->longitude == "0")
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Longitud</label>
                                                        <input type="text" class="form-control" placeholder="Longitud" id="longitude" readonly="">
                                                    </div>
                                                </div>
                                            </div>
                                            @else
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Longitud</label>
                                                        <input type="text" class="form-control" placeholder="Longitud" id="longitude" value="{{$other_details->longitude}}" readonly="">
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
                                                                <i class="fa fa-map-marker"> Lihat Peta</i>
                                                            </button>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Penerangan</label>
                                                        <textarea class="form-control" rows="3" id="other_details_description" placeholder="Penerangan" readonly="">{{$other_details->description}}</textarea>
                                                    </div>
                                                </div>
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
                other_details_description = $("#other_details_description").val();

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