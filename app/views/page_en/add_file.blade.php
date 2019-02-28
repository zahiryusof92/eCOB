@extends('layout.english_layout.default')

@section('content')

<?php
$insert_permission = 0;
$update_permission = 0;

foreach ($user_permission as $permission) {
    if ($permission->submodule_id == 2) {        
        $access_permission = $permission->access_permission;
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
                    <form id="add_fileprefix">
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
                                    <label><span style="color: red;">*</span> File Number</label>
                                    <select id="file_no" class="form-control">
                                        <option value="">Please Select</option>
                                        @foreach ($file_no as $files)
                                        <option value="{{$files->description}}">{{$files->description}}</option>
                                        @endforeach                                    
                                    </select>
                                    <div id="file_no_error" style="display:none;"></div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label><span style="color: red;">*</span> Description</label>
                                    <input id="description" class="form-control" placeholder="Description" type="text">
                                    <div id="description_error" style="display:none;"></div>
                                </div>
                            </div>
                        </div>                                                
                        <div class="row">
                            <div class="col-md-4">
                                <div id="file_already_exists_error" style="display: none;"></div>
                            </div>
                        </div>
                        <div class="form-actions">
                            <?php if ($insert_permission == 1) { ?>
                            <button type="button" class="btn btn-primary" id="submit_button" onclick="addFile()">Submit</button>
                             <?php } ?>
                            <button type="button" class="btn btn-default" id="cancel_button" onclick="window.location ='{{URL::action('AdminController@addFile')}}'">Cancel</button>
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
    
    function addFile() {
        $("#loading").css("display", "inline-block");

        var file_no = $("#file_no").val(),
            description = $("#description").val();

        var error = 0;
        
        if (file_no.trim() == "") {
            $("#file_no_error").html('<span style="color:red;font-style:italic;font-size:13px;">Please select File Number</span>');
            $("#file_no_error").css("display", "block");
            error = 1;
        }
        
        if (description.trim() == "") {
            $("#description_error").html('<span style="color:red;font-style:italic;font-size:13px;">Please enter Description</span>');
            $("#description_error").css("display", "block");
            error = 1;
        }
        
        if (error == 0) {
            $.ajax({
                url: "{{ URL::action('AdminController@submitFile') }}",
                type: "POST",
                data: {
                    file_no: file_no,
                    description: description
                },
                success: function (data) {
                    $("#loading").css("display", "none");
                    $("#submit_button").removeAttr("disabled");
                    $("#cancel_button").removeAttr("disabled");
                    if (data.trim() == "true") {
                        bootbox.alert("<span style='color:green;'>File added successfully!</span>", function () {
                            window.location = '{{URL::action("AdminController@fileList") }}';
                        });
                    } else if (data.trim() == "file_already_exists") {
                        $("#file_already_exists_error").html('<span style="color:red;font-style:italic;font-size:13px;">This file already exist!</span>');
                        $("#file_already_exists_error").css("display", "block");
                    } else {
                        bootbox.alert("<span style='color:red;'>An error occured while processing. Please try again.</span>");
                    }
                }
            });
        }
    }
</script>

@stop