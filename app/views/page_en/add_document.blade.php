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
                    <h6>File No: {{$files->file_no}}</h6>
                    <div id="update_files_lists">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link" href="{{URL::action('AdminController@house', $files->id)}}">Housing Scheme</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{URL::action('AdminController@strata', $files->id)}}">Developed Area (STRATA)</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{URL::action('AdminController@management', $files->id)}}">Management</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{URL::action('AdminController@monitoring', $files->id)}}">Monitoring</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{URL::action('AdminController@others', $files->id)}}">Others</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{URL::action('AdminController@scoring', $files->id)}}">Scoring Component Value</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{URL::action('AdminController@buyer', $files->id)}}">Buyer List</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active">Document</a>
                            </li>
                        </ul>
                        <div class="tab-content padding-vertical-20">
                            <div class="tab-pane active" id="document_tab" role="tabpanel">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <form id="documentSubmit" class="form-horizontal" enctype="multipart/form-data">
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
                                                        <label><span style="color: red;">*</span> Document Type</label>
                                                        <select id="document_type" class="form-control select2" name="document_type">
                                                            <option value="">Please Select</option>
                                                            @foreach ($documentType as $dt)
                                                            <option value="{{$dt->id}}">{{$dt->name}}</option>
                                                            @endforeach
                                                        </select>
                                                        <div id="document_type_error" style="display:none;"></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label"><span style="color: red; font-style: italic;">*</span> Document Name</label>
                                                        <input id="name" name="name" class="form-control" type="text" placeholder="Document Name">
                                                        <div id="name_error" style="display:none;"></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label">Remarks</label>
                                                        <textarea id="remarks" name="remarks" rows="5" class="form-control" placeholder="Remarks"></textarea>
                                                        <div id="name_error" style="display:none;"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>

                                        <form id="upload_document_file" enctype="multipart/form-data" method="post" action="{{ url('uploadDocumentFile') }}" autocomplete="off">                                           
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="form-label"><span style="color: red; font-style: italic;">*</span> Upload File</label>
                                                        <br/>
                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                                        <button type="button" id="clear_document_file" class="btn btn-xs btn-danger" onclick="clearDocumentFile()" style="display: none;"><i class="fa fa-times"></i></button>                                                        
                                                        &nbsp;<input type="file" name="document_file" id="document_file" /> 
                                                        <div id="validation-errors_document_file"></div>
                                                    </div>
                                                </div>
                                            </div>                                            
                                        </form>

                                        <form>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="form-label"><span style="color: red; font-style: italic;">*</span> Hidden</label>
                                                        <select id="is_hidden" class="form-control" name="is_hidden">
                                                            <option value="">Please Select</option>
                                                            <option value="1">Yes</option>
                                                            <option value="0">No</option>
                                                        </select>
                                                        <div id="is_hidden_error" style="display:none;"></div>
                                                    </div>                            
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="form-label"><span style="color: red; font-style: italic;">*</span> Read Only</label>
                                                        <select id="is_readonly" class="form-control" name="is_readonly">
                                                            <option value="">Please Select</option>
                                                            <option value="1">Yes</option>
                                                            <option value="0">No</option>
                                                        </select>
                                                        <div id="is_readonly_error" style="display:none;"></div>
                                                    </div>                            
                                                </div>
                                            </div>

                                            <div class="form-actions">
                                                <?php if ($update_permission == 1) { ?>
                                                    <input type="hidden" id="document_file_url" value=""/>
                                                    <button type="button" class="btn btn-primary" id="submit_button" onclick="submitAddDocument()">Submit</button>
                                                <?php } ?>
                                                <button type="button" class="btn btn-default" id="cancel_button" onclick="window.location = '{{ URL::action('AdminController@document', $files->id) }}'">Cancel</button>
                                                <img id="loading" style="display:none;" src="{{asset('assets/common/img/input-spinner.gif')}}"/>
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
        //upload
        var options = {
            beforeSubmit: showRequest,
            success: showResponse,
            dataType: 'json'
        };

        $('body').delegate('#document_file', 'change', function () {
            $('#upload_document_file').ajaxForm(options).submit();
        });
    });

    //upload document file
    function showRequest(formData, jqForm, options) {
        $("#validation-errors_document_file").hide().empty();
        return true;
    }
    function showResponse(response, statusText, xhr, $form) {
        if (response.success == false) {
            var arr = response.errors;
            $.each(arr, function (index, value) {
                if (value.length != 0) {
                    $("#validation-errors_document_file").append('<div class="alert alert-error"><strong>' + value + '</strong><div>');
                }
            });
            $("#validation-errors_document_file").show();
            $("#document_file").css("color", "red");
        } else {
            $("#clear_document_file").show();
            $("#validation-errors_document_file").html("<i class='fa fa-check' id='check_document_file' style='color:green;'></i>");
            $("#validation-errors_document_file").show();
            $("#document_file").css("color", "green");
            $("#document_file_url").val(response.file);
        }
    }

    function clearDocumentFile() {
        $("#document_file").val("");
        $("#clear_document_file").hide();
        $("#document_file").css("color", "grey");
        $("#check_document_file").hide();
    }

    function submitAddDocument() {
        $("#loading").css("display", "inline-block");
        $("#submit_button").attr("disabled", "disabled");
        $("#cancel_button").attr("disabled", "disabled");

        var document_type = $("#document_type").val(),
                name = $("#name").val(),
                remarks = $("#remarks").val(),
                document_url = $("#document_file_url").val(),
                is_hidden = $("#is_hidden").val(),
                is_readonly = $("#is_readonly").val();

        var error = 0;

        if (document_type.trim() == "") {
            $("#document_type_error").html('<span style="color:red;font-style:italic;font-size:13px;">Please select Document Type</span>');
            $("#document_type_error").css("display", "block");
            error = 1;
        }
        if (name.trim() == "") {
            $("#name_error").html('<span style="color:red;font-style:italic;font-size:13px;">Please enter Document Name</span>');
            $("#name_error").css("display", "block");
            error = 1;
        }
        if (document_url.trim() == "") {
            $("#validation-errors_document_file").html('<span style="color:red;font-style:italic;font-size:13px;">Please upload File</span>');
            $("#validation-errors_document_file").css("display", "block");
            error = 1;
        }
        if (is_hidden.trim() == "") {
            $("#is_hidden_error").html('<span style="color:red;font-style:italic;font-size:13px;">Please enter Sort No</span>');
            $("#is_hidden_error").css("display", "block");
            error = 1;
        }
        if (is_readonly.trim() == "") {
            $("#is_readonly_error").html('<span style="color:red;font-style:italic;font-size:13px;">Please select Status</span>');
            $("#is_readonly_error").css("display", "block");
            error = 1;
        }

        if (error == 0) {
            $.ajax({
                url: "{{ URL::action('AgmController@submitAddDocument') }}",
                type: "POST",
                data: {
                    file_id: '{{ $files->id }}',
                    document_type: document_type,
                    name: name,
                    remarks: remarks,
                    document_url: document_url,
                    is_hidden: is_hidden,
                    is_readonly: is_readonly
                },
                success: function (data) {
                    $("#loading").css("display", "none");
                    $("#submit_button").removeAttr("disabled");
                    $("#cancel_button").removeAttr("disabled");
                    if (data.trim() == "true") {
                        bootbox.alert("<span style='color:green;'>Document added successfully!</span>", function () {
                            window.location = '{{URL::action("AgmController@document") }}';
                        });
                    } else {
                        bootbox.alert("<span style='color:red;'>An error occured while processing. Please try again.</span>");
                    }
                }
            });
        } else {
            $("#file_id").focus();
            $("#loading").css("display", "none");
            $("#submit_button").removeAttr("disabled");
            $("#cancel_button").removeAttr("disabled");
        }
    }

    function deleteDocumentFile(id) {
        swal({
            title: "Are you sure?",
            text: "Your will not be able to recover this file!",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-warning",
            cancelButtonClass: "btn-default",
            confirmButtonText: "Delete",
            closeOnConfirm: true
        }, function () {
            $.ajax({
                url: "{{ URL::action('AgmController@deleteDocumentFile') }}",
                type: "POST",
                data: {
                    id: id
                },
                success: function (data) {
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
</script>
<!-- End Page Scripts-->

@stop