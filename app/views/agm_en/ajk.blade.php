@extends('layout.english_layout.default')

@section('content')

<?php
$update_permission = 0;
$insert_permission = 0;
$update_permission = 0;

foreach ($user_permission as $permission) {
    if ($permission->submodule_id == 30) {
        $access_permission = $permission->access_permission;
        $insert_permission = $permission->insert_permission;
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
                    <div class="table-responsive">
                        <?php if ($insert_permission == 1) { ?>
                            <button type="button" class="btn btn-primary margin-bottom-25" onclick="addAJKDetails()">
                                Add
                            </button>
                        <?php } ?>
                        <table class="table table-hover nowrap" id="ajk_details_list" width="100%">
                            <thead>
                                <tr>
                                    <th style="width:20%;">Designation</th>
                                    <th style="width:30%;">Name</th>
                                    <th style="width:20%;">Phone Number</th>
                                    <th style="width:10%;">Year</th>
                                    <?php if ($update_permission == 1) { ?>
                                        <th style="width:10%;">Action</th>
                                    <?php } ?>
                                </tr>
                            </thead>
                            <tbody>                                                    
                            </tbody>
                        </table>
                    </div>
                </div>
            </div> 
        </div>
    </section>
    <!-- End -->
</div>

<div class="modal fade modal" id="add_ajk_details" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Add AJK Details</h4>
            </div>
            <form id="add_ajk">
                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-md-12">
                            <label class="form-control-label" style="color: red; font-style: italic;">* Mandatory Fields.</label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-4">
                            <label class="form-control-label"><span style="color: red; font-style: italic;">*</span> File No</label>
                        </div>
                        <div class="col-md-8">
                            <select id="file_id" class="form-control">
                                <option value="">Please select</option>
                                @foreach ($files as $file) 
                                <option value="{{$file->id}}">{{$file->file_no}}</option>
                                @endforeach
                            </select>
                            <div id="file_id_error" style="display:none;"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-4">
                            <label class="form-control-label"><span style="color: red; font-style: italic;">*</span> Designation</label>
                        </div>
                        <div class="col-md-8">
                            <select id="ajk_designation" class="form-control">
                                <option value="">Please select</option>
                                @foreach ($designation as $designations) 
                                <option value="{{$designations->id}}">{{$designations->description}}</option>
                                @endforeach
                            </select>
                            <div id="ajk_designation_error" style="display:none;"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-4">
                            <label class="form-control-label"><span style="color: red; font-style: italic;">*</span> Name</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" placeholder="Name" id="ajk_name"/>
                            <div id="ajk_name_error" style="display:none;"></div>
                        </div>                    
                    </div> 
                    <div class="form-group row">
                        <div class="col-md-4">
                            <label class="form-control-label"><span style="color: red; font-style: italic;">*</span> Phone Number</label>
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control" placeholder="Phone Number" id="ajk_phone_no"/>
                            <div id="ajk_phone_no_error" style="display:none;"></div>
                            <div id="ajk_phone_no_invalid_error" style="display:none;"></div>
                        </div>                    
                    </div> 
                    <div class="form-group row">
                        <div class="col-md-4">
                            <label class="form-control-label"><span style="color: red; font-style: italic;">*</span> Year</label>
                        </div>
                        <div class="col-md-4">
                            <input type="text" class="form-control" placeholder="Year" id="ajk_year"/>
                            <div id="ajk_year_error" style="display:none;"></div>
                            <div id="ajk_year_invalid_error" style="display:none;"></div>
                        </div>                    
                    </div>
                    <div class="form-group row">
                        <div class="col-md-4">
                            <label class="form-control-label">Remarks</label>
                        </div>
                        <div class="col-md-8">
                            <textarea class="form-control" placeholder="Remarks" id="ajk_remarks" rows="5"></textarea>
                        </div>                    
                    </div> 
                </div>                
                <div class="modal-footer">
                    <button type="button" class="btn" data-dismiss="modal">
                        Close
                    </button>
                    <?php if ($insert_permission == 1) { ?>
                        <button id="submit_button" onclick="addAJKDetail()" type="button" class="btn btn-primary">
                            Submit
                        </button>
                    <?php } ?>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade modal" id="edit_ajk_details" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Edit AJK Details</h4>
            </div>
            <form id="edit_ajk">
                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-md-4">
                            <label class="form-control-label" style="color: red; font-style: italic;">* Mandatory Fields.</label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-4">
                            <label class="form-control-label"><span style="color: red; font-style: italic;">*</span> File No</label>
                        </div>
                        <div class="col-md-8">
                            <select id="file_id_edit" class="form-control">
                                <option value="">Please select</option>
                                @foreach ($files as $file) 
                                <option value="{{$file->id}}">{{$file->file_no}}</option>
                                @endforeach
                            </select>
                            <div id="file_id_edit_error" style="display:none;"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-4">
                            <label class="form-control-label"><span style="color: red; font-style: italic;">*</span> Designation</label>
                        </div>
                        <div class="col-md-8">
                            <select id="ajk_designation_edit" class="form-control">
                                <option value="">Please select</option>
                                @foreach ($designation as $designations) 
                                <option value="{{$designations->id}}">{{$designations->description}}</option>
                                @endforeach
                            </select>
                            <div id="ajk_designation_edit_error" style="display:none;"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-4">
                            <label class="form-control-label"><span style="color: red; font-style: italic;">*</span> Name</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" placeholder="Name" id="ajk_name_edit"/>
                        </div>                    
                    </div> 
                    <div class="form-group row">
                        <div class="col-md-4">
                            <label class="form-control-label"><span style="color: red; font-style: italic;">*</span> Phone Number</label>
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control" placeholder="Phone Number" id="ajk_phone_no_edit"/>
                        </div>                    
                    </div> 
                    <div class="form-group row">
                        <div class="col-md-4">
                            <label class="form-control-label"><span style="color: red; font-style: italic;">*</span> Year</label>
                        </div>
                        <div class="col-md-4">
                            <input type="text" class="form-control" placeholder="Year" id="ajk_year_edit"/>
                        </div>                    
                    </div>
                    <div class="form-group row">
                        <div class="col-md-4">
                            <label class="form-control-label">Remarks</label>
                        </div>
                        <div class="col-md-8">
                            <textarea class="form-control" placeholder="Remarks" id="ajk_remarks" rows="5"></textarea>
                        </div>                    
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="ajk_id_edit"/>
                    <button type="button" class="btn" data-dismiss="modal">
                        Close
                    </button>
                    <?php if ($update_permission == 1) { ?>
                        <button id="submit_button" onclick="editAJK()" type="button" class="btn btn-primary">
                            Submit
                        </button>
                    <?php } ?>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Page Scripts -->
<script>
    $(document).ready(function () {
        $('#ajk_details_list').DataTable({
            "sAjaxSource": "{{URL::action('AgmController@getAJK')}}",
            "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            "order": [[3, "desc"]],
            "responsive": true,
            "aoColumnDefs": [
                {
                    "bSortable": false,
                    "aTargets": [-1]
                }
            ]
        });
    });

    $(document).on("click", '.edit_ajk', function (e) {
        var ajk_id = $(this).data('ajk_id');
        var file_id = $(this).data('file_id');
        var designation = $(this).data('designation');
        var name = $(this).data('name');
        var phone_no = $(this).data('phone_no');
        var year = $(this).data('year');

        $("#ajk_id_edit").val(ajk_id);
        $("#file_id_edit").val(file_id);
        $("#ajk_designation_edit").val(designation);
        $("#ajk_name_edit").val(name);
        $("#ajk_phone_no_edit").val(phone_no);
        $("#ajk_year_edit").val(year);
    });

    function addAJKDetails() {
        $("#add_ajk_details").modal("show");
    }
    function editAJKDetails() {
        $("#edit_ajk_details").modal("show");
    }

    function addAJKDetail() {
        $("#loading").css("display", "inline-block");
        $("#file_id_error").css("display", "none");
        $("#ajk_designation_error").css("display", "none");
        $("#ajk_name_error").css("display", "none");
        $("#ajk_phone_no_error").css("display", "none");
        $("#ajk_phone_no_invalid_error").css("display", "none");
        $("#ajk_year_error").css("display", "none");
        $("#ajk_year_invalid_error").css("display", "none");

        var file_id = $("#file_id").val(),
                ajk_designation = $("#ajk_designation").val(),
                ajk_name = $("#ajk_name").val(),
                ajk_phone_no = $("#ajk_phone_no").val(),
                ajk_year = $("#ajk_year").val();

        var error = 0;

        if (file_id.trim() == "") {
            $("#file_id_error").html('<span style="color:red;font-style:italic;font-size:13px;">Please select File No</span>');
            $("#file_id_error").css("display", "block");
            error = 1;
        }

        if (ajk_designation.trim() == "") {
            $("#ajk_designation_error").html('<span style="color:red;font-style:italic;font-size:13px;">Please select Designation</span>');
            $("#ajk_designation_error").css("display", "block");
            error = 1;
        }

        if (ajk_name.trim() == "") {
            $("#ajk_name_error").html('<span style="color:red;font-style:italic;font-size:13px;">Please enter Name</span>');
            $("#ajk_name_error").css("display", "block");
            error = 1;
        }

        if (ajk_phone_no.trim() == "") {
            $("#ajk_phone_no_error").html('<span style="color:red;font-style:italic;font-size:13px;">Please enter Phone Number</span>');
            $("#ajk_phone_no_error").css("display", "block");
            $("#ajk_phone_no_invalid_error").css("display", "none");
            error = 1;
        }

        if (isNaN(ajk_phone_no)) {
            $("#ajk_phone_no_invalid_error").html('<span style="color:red;font-style:italic;font-size:13px;">Please enter valid Phone Number</span>');
            $("#ajk_phone_no_invalid_error").css("display", "block");
            $("#ajk_phone_no_error").css("display", "none");
            error = 1;
        }

        if (ajk_year.trim() == "") {
            $("#ajk_year_error").html('<span style="color:red;font-style:italic;font-size:13px;">Please enter Year</span>');
            $("#ajk_year_error").css("display", "block");
            $("#ajk_year_invalid_error").css("display", "none");
            error = 1;
        }

        if (isNaN(ajk_year)) {
            $("#ajk_year_invalid_error").html('<span style="color:red;font-style:italic;font-size:13px;">Please enter valid Year</span>');
            $("#ajk_year_invalid_error").css("display", "block");
            $("#ajk_year_error").css("display", "none");
            error = 1;
        }

        if (error == 0) {
            $.ajax({
                url: "{{ URL::action('AgmController@addAJK') }}",
                type: "POST",
                data: {
                    ajk_designation: ajk_designation,
                    ajk_name: ajk_name,
                    ajk_phone_no: ajk_phone_no,
                    ajk_year: ajk_year,
                    file_id: file_id
                },
                success: function (data) {
                    $("#loading").css("display", "none");
                    $("#submit_button").removeAttr("disabled");
                    $('#add_ajk_details').modal('hide');
                    if (data.trim() == "true") {
                        $.notify({
                            message: '<p style="text-align: center; margin-bottom: 0px;">Successfully saved</p>',
                        }, {
                            type: 'success',
                            placement: {
                                align: "center"
                            }
                        });
                        location.reload();
                    } else {
                        bootbox.alert("<span style='color:red;'>An error occured while processing. Please try again.</span>");
                    }
                }
            });
        }
    }

    function editAJK() {
        $("#loading").css("display", "inline-block");

        var ajk_id_edit = $("#ajk_id_edit").val(),
                ajk_designation = $("#ajk_designation_edit").val(),
                ajk_name = $("#ajk_name_edit").val(),
                ajk_phone_no = $("#ajk_phone_no_edit").val(),
                ajk_year = $("#ajk_year_edit").val();

        var error = 0;

        if (ajk_designation.trim() == "") {
            $("#ajk_designation_edit_error").html('<span style="color:red;font-style:italic;font-size:13px;">Please select Designation</span>');
            $("#ajk_designation_edit_error").css("display", "block");
            error = 1;
        }

        if (ajk_name.trim() == "") {
            $("#ajk_name_error").html('<span style="color:red;font-style:italic;font-size:13px;">Please enter Name</span>');
            $("#ajk_name_error").css("display", "block");
            error = 1;
        }

        if (ajk_phone_no.trim() == "") {
            $("#ajk_phone_no_error").html('<span style="color:red;font-style:italic;font-size:13px;">Please enter Phone Number</span>');
            $("#ajk_phone_no_error").css("display", "block");
            $("#ajk_phone_no_invalid_error").css("display", "none");
            error = 1;
        }

        if (isNaN(ajk_phone_no)) {
            $("#ajk_phone_no_invalid_error").html('<span style="color:red;font-style:italic;font-size:13px;">Please enter valid Phone Number</span>');
            $("#ajk_phone_no_invalid_error").css("display", "block");
            $("#ajk_phone_no_error").css("display", "none");
            error = 1;
        }

        if (ajk_year.trim() == "") {
            $("#ajk_year_error").html('<span style="color:red;font-style:italic;font-size:13px;">Please enter Year</span>');
            $("#ajk_year_error").css("display", "block");
            $("#ajk_year_invalid_error").css("display", "none");
            error = 1;
        }

        if (isNaN(ajk_year)) {
            $("#ajk_year_invalid_error").html('<span style="color:red;font-style:italic;font-size:13px;">Please enter valid Year</span>');
            $("#ajk_year_invalid_error").css("display", "block");
            $("#ajk_year_error").css("display", "none");
            error = 1;
        }

        if (error == 0) {
            $.ajax({
                url: "{{ URL::action('AgmController@editAJK') }}",
                type: "POST",
                data: {
                    ajk_designation: ajk_designation,
                    ajk_name: ajk_name,
                    ajk_phone_no: ajk_phone_no,
                    ajk_year: ajk_year,
                    ajk_id_edit: ajk_id_edit
                },
                success: function (data) {
                    $("#loading").css("display", "none");
                    $("#submit_button").removeAttr("disabled");
                    $('#edit_ajk_details').modal('hide');
                    if (data.trim() == "true") {
                        $.notify({
                            message: '<p style="text-align: center; margin-bottom: 0px;">Successfully saved</p>',
                        }, {
                            type: 'success',
                            placement: {
                                align: "center"
                            }
                        });
                        location.reload();
                    } else {
                        bootbox.alert("<span style='color:red;'>An error occured while processing. Please try again.</span>");
                    }
                }
            });
        }
    }

    function deleteAJKDetails(id) {
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
                url: "{{ URL::action('AgmController@deleteAJK') }}",
                type: "POST",
                data: {
                    id: id
                },
                success: function (data) {
                    if (data.trim() == "true") {
                        $.notify({
                            message: '<p style="text-align: center; margin-bottom: 0px;">Deleted Successfully</p>'
                        }, {
                            type: 'success',
                            placement: {
                                align: "center"
                            }
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