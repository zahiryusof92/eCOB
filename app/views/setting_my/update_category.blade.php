@extends('layout.malay_layout.default')

@section('content')

<?php
$update_permission = 0;

foreach ($user_permission as $permission) {
    if ($permission->submodule_id == 12) {
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
                    <form id="update_category" class="form-horizontal">
                        <div class="form-group row">
                            <div class="col-md-2">
                                <label class="form-control-label" style="color: red; font-style: italic;">* Medan Wajib Diisi.</label>
                            </div>
                        </div>   
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label class="form-label"><span style="color: red; font-style: italic;">*</span> Kategori</label>
                            </div>
                            <div class="col-md-4">
                                <input id="description" class="form-control" placeholder="Category" type="text" value="{{$category->description}}">
                                <div id="description_error" style="display:none;"></div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label class="form-label"><span style="color: red; font-style: italic;">*</span> Status</label>
                            </div>    
                            <div class="col-md-4">
                                <select id="is_active" class="form-control">
                                    <option value="">Sila pilih</option>
                                    <option value="1" {{($category->is_active==1 ? " selected" : "")}}>Aktif</option>
                                    <option value="0" {{($category->is_active==0 ? " selected" : "")}}>Tidak Aktif</option>
                                </select>
                                <div id="is_active_error" style="display:none;"></div>
                            </div>                            
                        </div>                                               
                        <div class="form-actions">
                            <?php if ($update_permission == 1) { ?>
                            <button type="button" class="btn btn-primary" id="submit_button" onclick="updateCategory()">Simpan</button>
                            <?php } ?>
                            <button type="button" class="btn btn-default" id="cancel_button" onclick="window.location ='{{ URL::action("AdminController@category") }}'" >Batal</button>
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
    
    function updateCategory() {
        $("#loading").css("display", "inline-block");

        var description = $("#description").val(),
            is_active = $("#is_active").val();

        var error = 0;
        
        if (description.trim() == "") {
            $("#description_error").html('<span style="color:red;font-style:italic;font-size:13px;">Sila masukkan Kategori</span>');
            $("#description_error").css("display", "block");
            error = 1;
        }
        
        if (is_active.trim() == "") {
            $("#is_active_error").html('<span style="color:red;font-style:italic;font-size:13px;">Sila pilih Status</span>');
            $("#is_active_error").css("display", "block");
            error = 1;
        }
        
        if (error == 0) {
            $.ajax({
                url: "{{ URL::action('AdminController@submitUpdateCategory') }}",
                type: "POST",
                data: {
                    description: description,
                    is_active: is_active,
                    id: "{{$category->id}}"
                },
                success: function (data) {
                    $("#loading").css("display", "none");
                    $("#submit_button").removeAttr("disabled");
                    $("#cancel_button").removeAttr("disabled");
                    if (data.trim() == "true") {
                        bootbox.alert("<span style='color:green;'>Kategori berjaya dikemaskini!</span>", function () {
                            window.location = '{{URL::action("AdminController@category") }}';
                        });
                    } else {
                        bootbox.alert("<span style='color:red;'>Ralat. Sila cuba lagi.</span>");
                    }
                }
            });
        }
    }
</script>
<!-- End Page Scripts-->

@stop