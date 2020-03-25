@extends('layout.english_layout.default')

@section('content')

<?php
$update_permission = 0;

foreach ($user_permission as $permission) {
    if ($permission->submodule_id == 22) {
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
                    <form id="update_formtype" class="form-horizontal">
                        <div class="form-group row">
                            <div class="col-md-2">
                                <label class="form-control-label" style="color: red; font-style: italic;">* Mandatory Fields.</label>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label class="form-label"><span style="color: red; font-style: italic;">*</span> Form Type (BI)</label>
                            </div>
                            <div class="col-md-4">
                                <input id="bi_type" class="form-control" type="text" value="{{ $formtype->bi_type }}">
                                <div id="bi_error" style="display:none;"></div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <label class="form-label"><span style="color: red; font-style: italic;">*</span> Form Type (BM)</label>
                            </div>
                            <div class="col-md-4">
                                <input id="bm_type" class="form-control" type="text" value="{{ $formtype->bm_type }}">
                                <div id="bm_error" style="display:none;"></div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <label class="form-label"><span style="color: red; font-style: italic;">*</span> Seq</label>
                            </div>
                            <div class="col-md-4">
                                <input id="seq" class="form-control" placeholder="Seq" type="text" value="{{ $formtype->seq }}">
                                <div id="seq_error" style="display:none;"></div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <label class="form-label"><span style="color: red; font-style: italic;">*</span> Status</label>
                            </div>    
                            <div class="col-md-4">
                                <select id="is_active" class="form-control">
                                    <option value="">Please Select</option>
                                    <option value="1" {{($formtype->is_active==1 ? " selected" : "")}}>Active</option>
                                    <option value="0" {{($formtype->is_active==0 ? " selected" : "")}}>Inactive</option>
                                </select>
                                <div id="is_active_error" style="display:none;"></div>
                            </div>                            
                        </div>                                               
                        <div class="form-actions">
                            <?php if ($update_permission == 1) { ?>
                            <button type="button" class="btn btn-primary" id="submit_button" onclick="updateFormtype()">Save</button>
                            <?php } ?>
                            <button type="button" class="btn btn-default" id="cancel_button" onclick="window.location ='{{ URL::action("AdminController@formtype") }}'" >Cancel</button>
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
    
    function updateFormtype() {
        $("#loading").css("display", "inline-block");

        let bi = $("#bi_type").val();
        let bm = $("#bm_type").val();
        let seq = $("#seq").val();
        let is_active = $("#is_active").val();

        var error = 0;
        
        if (bi.trim() == "") {
            $("#bi_error").html('<span style="color:red;font-style:italic;font-size:13px;">Please enter Form Type (BI) Name</span>');
            $("#bi_error").css("display", "block");
            error = 1;
        }

        if (bm.trim() == "") {
            $("#bm_error").html('<span style="color:red;font-style:italic;font-size:13px;">Please enter Form Type (BM)</span>');
            $("#bm_error").css("display", "block");
            error = 1;
        }

        if (seq.trim() == "") {
            $("#seq_error").html('<span style="color:red;font-style:italic;font-size:13px;">Please enter Sequence Number</span>');
            $("#seq_error").css("display", "block");
            error = 1;
        }
        
        if (is_active.trim() == "") {
            $("#is_active_error").html('<span style="color:red;font-style:italic;font-size:13px;">Please select Status</span>');
            $("#is_active_error").css("display", "block");
            error = 1;
        }
        
        if (error == 0) {
            $.ajax({
                url: "{{ URL::action('AdminController@submitUpdateFormtype') }}",
                type: "POST",
                data: {
                    bi_type: bi,
                    bm_type : bm,
                    seq : seq,
                    is_active: is_active,
                    id: "{{$formtype->id}}"
                },
                success: function (data) {
                    $("#loading").css("display", "none");
                    $("#submit_button").removeAttr("disabled");
                    $("#cancel_button").removeAttr("disabled");
                    if (data.trim() == "true") {
                        bootbox.alert("<span style='color:green;'>Form Type updated successfully!</span>", function () {
                            window.location = '{{URL::action("AdminController@formtype") }}';
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