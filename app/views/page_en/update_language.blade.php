@extends('layout.english_layout.default')

@section('content')

<?php
$update_permission = 0;

foreach ($user_permission as $permission) {
    if ($permission->submodule_id == 36) {
        $update_permission = $permission->update_permission;
    }
}

$fields = [
    'code' => 'Language Code', 
    'en_gen_desc' => 'ENG General Description',
    'en_long_desc' => 'ENG Long Description',
    'en_short_desc' => 'ENG Short Description',
    'bm_gen_desc' => 'BM General Description',
    'bm_long_desc' => 'BM Long Description',
    'bm_short_desc' => 'BM Short Description',
];
?>

<div class="page-content-inner">
    <section class="panel panel-with-borders">
        <div class="panel-heading">
            <h3>{{$title}}</h3>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-lg-12">
                    <form id="language_form" class="form-horizontal" method="POST">
                        <div class="form-group row">
                            <div class="col-md-2">
                                <label class="form-control-label" style="color: red; font-style: italic;">* Mandatory Fields.</label>
                            </div>
                        </div>
                        <input type="hidden" name="id" value="{{ $language->id }}">
                        
                        @foreach ($fields as $key => $val)
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label class="form-label"><span style="color: red; font-style: italic;">*</span> {{$val}}</label>
                                </div>
                                <div class="col-md-4">
                                    <input id="{{$key}}" class="form-control" type="text" value="{{ $language->{$key} }}" name="{{$key}}">
                                    <div id="{{$key}}_err" style="display:none;"></div>
                                </div>
                            </div>
                        @endforeach

                        <div class="form-group row">
                            <div class="col-md-12">
                                <label class="form-label"><span style="color: red; font-style: italic;">*</span> Status</label>
                            </div>    
                            <div class="col-md-4">
                                <select id="is_active" class="form-control" name="is_active">
                                    <option value="">Please Select</option>
                                    <option value="1" {{($language->is_active==1 ? " selected" : "")}}>Active</option>
                                    <option value="0" {{($language->is_active==0 ? " selected" : "")}}>Inactive</option>
                                </select>
                                <div id="is_active_error" style="display:none;"></div>
                            </div>                            
                        </div>                                               
                        <div class="form-actions">
                            <?php if ($update_permission == 1) { ?>
                            <input type="submit" value="Save" class="btn btn-primary" id="submit-button">
                            <?php } ?>
                            <button type="button" class="btn btn-default" id="cancel_button" onclick="window.location ='{{ URL::action("AdminController@language") }}'" >Cancel</button>
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

    $("#language_form").submit(function(e){
        e.preventDefault();
        var data = $(this).serialize();
        
        $("#loading").css("display", "inline-block");

        let code =  $("#code").val();
        let en_gen_desc = $("#en_gen_desc").val();
        let en_long_desc = $("#en_long_desc").val();
        let en_short_desc = $("#en_short_desc").val();
        let bm_gen_desc = $("#bm_gen_desc").val();
        let bm_long_desc = $("#bm_long_desc").val();
        let bm_short_desc = $("#bm_short_desc").val();

        var error = 0;
        
        if ($("#code").val().trim() == "") {
            $("#code_error").html('<span style="color:red;font-style:italic;font-size:13px;">Please enter Language Code</span>');
            $("#code_error").css("display", "block");
            error = 1;
        }

        if ($("[name=en_gen_desc]").val().trim() == "") {
            $("#en_gen_desc_err").html('<span style="color:red;font-style:italic;font-size:13px;">Please enter English General Description</span>');
            $("#en_gen_desc_err").css("display", "block");
            error = 1;
        }

        if ($("[bm=en_gen_desc]").val().trim() == "") {
            $("#bm_gen_desc_err").html('<span style="color:red;font-style:italic;font-size:13px;">Please enter BM General Description</span>');
            $("#bm_gen_desc_err").css("display", "block");
            error = 1;
        }
        
        if (error == 0) {
            $.ajax({
                url: "{{ URL::action('AdminController@submitUpdateLanguage') }}",
                type: "POST",
                data: data,
                success: function (data) {
                    $("#loading").css("display", "none");
                    $("#submit_button").removeAttr("disabled");
                    $("#cancel_button").removeAttr("disabled");
                    if (data.trim() == "true") {
                        bootbox.alert("<span style='color:green;'>Language updated successfully!</span>", function () {
                            window.location = '{{URL::action("AdminController@language") }}';
                        });
                    } else {
                        bootbox.alert("<span style='color:red;'>An error occured while processing. Please try again.</span>");
                    }
                }
            });
        }

    })
    
    function updateLanguage() {
        
    }
</script>
<!-- End Page Scripts-->

@stop