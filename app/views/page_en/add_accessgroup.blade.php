@extends('layout.english_layout.default')

@section('content')

<?php
$insert_permission = 0;

foreach ($user_permission as $permission) {
    if ($permission->submodule_id == 5) {
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
                    <form id="add_access_group">
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
                                    <label class="form-label"><span style="color: red; font-style: italic;">*</span> Name</label>                            
                                    <input id="description" class="form-control" placeholder="Name" type="text">
                                    <div id="description_error" style="display:none;"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <table class="table margin-bottom-0" border="0">
                                    <thead>
                                        <tr>
                                            <th style="width:70%;text-align: center !important;">Page</th>
                                            <th style="width:10%;text-align: center !important;">Access</th>
                                            <th style="width:10%;text-align: center !important;">Insert</th>
                                            <th style="width:10%;text-align: center !important;">Update</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($module as $modules)
                                        <tr>
                                            <th colspan="5">{{strtoupper($modules->name_en)}}</th>
                                        </tr>
                                            <?php
                                            $submodule = SubModule::where('module_id', $modules->id)->get();
                                            ?>
                                            @foreach($submodule as $submodules)
                                            @if ($modules->id == 4)
                                            <tr>
                                                <td> - {{$submodules->name_en}}</td>
                                                <td style="text-align: center;">
                                                    <input type="checkbox" class="access" name="access[]" value="{{$submodules->id}}" />
                                                </td>
                                                <td style="text-align: center;"></td>
                                                <td style="text-align: center;"></td>
                                            </tr>
                                            @elseif ($submodules->id == 2)
                                            <tr>
                                                <td> - {{$submodules->name_en}}</td>
                                                <td style="text-align: center;">
                                                    <input type="checkbox" class="access" name="access[]" value="{{$submodules->id}}" />
                                                </td>
                                                <td style="text-align: center;">
                                                    <input type="checkbox" class="insert" name="insert[]" value="{{$submodules->id}}" />
                                                </td>
                                                <td style="text-align: center;"></td>
                                            </tr>
                                            @elseif ($submodules->id == 3)
                                            <tr>
                                                <td> - {{$submodules->name_en}}</td>
                                                <td style="text-align: center;">
                                                    <input type="checkbox" class="access" name="access[]" value="{{$submodules->id}}" />
                                                </td>
                                                <td style="text-align: center;"></td>
                                                <td style="text-align: center;">
                                                    <input type="checkbox" class="update" name="update[]" value="{{$submodules->id}}" />
                                                </td>
                                            </tr>
                                            @elseif ($submodules->id == 4)
                                            <tr>
                                                <td> - {{$submodules->name_en}}</td>
                                                <td style="text-align: center;">
                                                    <input type="checkbox" class="access" name="access[]" value="{{$submodules->id}}" />
                                                </td>
                                                <td style="text-align: center;"></td>
                                                <td style="text-align: center;">
                                                    <input type="checkbox" class="update" name="update[]" value="{{$submodules->id}}" />
                                                </td>
                                            </tr>
                                            @else
                                            <tr>
                                                <td> - {{$submodules->name_en}}</td>
                                                <td style="text-align: center;">
                                                    <input type="checkbox" class="access" name="access[]" value="{{$submodules->id}}" />
                                                </td>
                                                <td style="text-align: center;">
                                                    <input type="checkbox" class="insert" name="insert[]" value="{{$submodules->id}}" />
                                                </td>
                                                <td style="text-align: center;">
                                                    <input type="checkbox" class="update" name="update[]" value="{{$submodules->id}}" />
                                                </td>
                                            </tr>
                                            @endif
                                            @endforeach

                                        @endforeach
                                    </tbody>
                                </table>
                            </div>                            
                        </div>
                        <hr/>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label><span style="color: red;">*</span> Status</label>
                                    <select id="is_active" class="form-control">
                                        <option value="">Please Select</option>
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                    <div id="is_active_error" style="display:none;"></div>
                                </div>
                            </div>
                        </div>   
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Remarks</label>
                                    <textarea class="form-control" rows="3" id="remarks"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions">
                            <?php if ($insert_permission == 1) { ?>
                            <button type="button" class="btn btn-primary" id="submit_button" onclick="addAccessGroup()">Submit</button>
                            <?php } ?>
                            <button type="button" class="btn btn-default" id="cancel_button" onclick="window.location ='{{ URL::action("AdminController@accessGroups") }}'">Cancel</button>
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
    
    function addAccessGroup() {
        $("#loading").css("display", "inline-block");

        var description = $("#description").val(),
                remarks = $("#remarks").val(),
                is_active = $("#is_active").val();

        var error = 0;

        if (description.trim() == "") {
            $("#description_error").html('<span style="color:red;font-style:italic;font-size:13px;">Please enter name</span>');
            $("#description_error").css("display", "block");
            error = 1;
        }
               
        if (is_active.trim() == "") {
            $("#is_active_error").html('<span style="color:red;font-style:italic;font-size:13px;">Please select status</span>');
            $("#is_active_error").css("display", "block");
            error = 1;
        }

        if (error == 0) {
            $.ajax({
                url: "{{ URL::action('AdminController@submitAccessGroup') }}",
                type: "POST",
                data: {
                    description: description,
                    selected_access: $('.access:checked').serialize(),
                    selected_insert: $('.insert:checked').serialize(),
                    selected_update: $('.update:checked').serialize(),
                    remarks: remarks,
                    is_active: is_active

                },
                success: function (data) {
                    $("#loading").css("display", "none");
                    $("#submit_button").removeAttr("disabled");
                    $("#cancel_button").removeAttr("disabled");
                    if (data.trim() == "true") {
                        bootbox.alert("<span style='color:green;'>Access Group added successfully!</span>", function () {
                            window.location = '{{URL::action("AdminController@accessGroups") }}';
                        });
                    } else {
                        bootbox.alert("<span style='color:red;'>An error occured while processing. Please try again.</span>");
                    }
                }
            });
        }
    }
</script>
<!-- End Page Scripts-->

@stop