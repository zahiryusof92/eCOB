@extends('layout.english_layout.default')

@section('content')

<?php
$insert_permission = 0;

foreach ($user_permission as $permission) {
    if ($permission->submodule_id == 35) {
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
                    <form id="formSubmit" class="form-horizontal">
                        <input type="hidden" name="id" value="{{ $form->id }}">
                        <div class="form-group row">
                            <div class="col-md-2">
                                <label class="form-control-label" style="color: red; font-style: italic;">* {{trans('general.label_mandatory')}}</label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><span style="color: red;">*</span> {{ trans('form.form.form_type') }}</label>
                                    <select id="form_type" class="form-control" name="form_type_id">
                                        <option value="">Please Select</option>
                                        @foreach ($formtype as $ft)
                                        <option value="{{$ft->id}}" 
                                        <?php
                                            if($form->form_type_id == $ft->id) echo 'selected';
                                        ?>    
                                        >{{$ft->bi_type}}</option>
                                        @endforeach
                                    </select>
                                    <div id="form_type_error" style="display:none;"></div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <label class="form-label"><span style="color: red; font-style: italic;">*</span> {{ trans('form.form.bi_name') }}</label>
                            </div>
                            <div class="col-md-6">
                                <input id="bi_name" name="bi_name" class="form-control" type="text" value="{{ $form->bi_name }}">
                                <div id="bi_error" style="display:none;"></div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <label class="form-label"><span style="color: red; font-style: italic;">*</span> {{ trans('form.form.bm_name') }}</label>
                            </div>
                            <div class="col-md-6">
                                <input id="bm_name" name="bm_name" class="form-control" type="text" value="{{ $form->bm_name }}">
                                <div id="bm_error" style="display:none;"></div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <label class="form-label"><span style="color: red; font-style: italic;">*</span> {{ trans('form.form.seq') }}</label>
                            </div>
                            <div class="col-md-6">
                                <input id="seq" class="form-control" name="seq" type="text" value="{{ $form->seq }}">
                                <div id="seq_error" style="display:none;"></div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <label class="form-label"><span style="color: red; font-style: italic;">*</span> Status</label>
                            </div>    
                            <div class="col-md-6">
                                <select id="is_active" class="form-control" name="is_active">
                                    <option value="">Please Select</option>
                                    <option value="1" {{($form->is_active==1 ? " selected" : "")}}>Active</option>
                                    <option value="0" {{($form->is_active==0 ? " selected" : "")}}>Inactive</option>
                                </select>
                                <div id="is_active_error" style="display:none;"></div>
                            </div>                            
                        </div>          

                        <div class="form-actions">
                            <button type="button" class="btn btn-default" id="cancel_button" onclick="window.location ='{{ URL::action("AdminController@form") }}'">Cancel</button>
                            <?php if ($insert_permission == 1) { ?>
                                <input type="submit" value="{{ trans('general.label_save') }}" class="btn btn-primary">
                            <?php } ?>
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
    $("#formSubmit").submit(function(e){
        e.preventDefault();
        $("#loading").css("display", "inline-block");
        
        let error = 0;

        if (error == 0) {
            $.ajax({
                url: "{{ URL::action('AdminController@submitUpdateForm') }}",
                type: "POST",
                data: $(this).serialize(),
                success: function (data) {
                    $("#loading").css("display", "none");
                    $("#submit_button").removeAttr("disabled");
                    $("#cancel_button").removeAttr("disabled");
                    if (data.trim() == "true") {
                        bootbox.alert("<span style='color:green;'>Form Updated successfully!</span>", function () {
                            window.location = '{{URL::action("AdminController@form") }}';
                        });
                    } else {
                        bootbox.alert("<span style='color:red;'>An error occured while processing. Please try again.</span>");
                    }
                }
            });
        }
    });
</script>
<script>
    function submitFormtype() {

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
                url: "{{ URL::action('AdminController@submitFormtype') }}",
                type: "POST",
                data: {
                    bi_type: bi,
                    bm_type: bm,
                    seq : seq,
                    is_active: is_active

                },
                success: function (data) {
                    $("#loading").css("display", "none");
                    $("#submit_button").removeAttr("disabled");
                    $("#cancel_button").removeAttr("disabled");
                    if (data.trim() == "true") {
                        bootbox.alert("<span style='color:green;'>Form Type added successfully!</span>", function () {
                            window.location = '{{URL::action("AdminController@form") }}';
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