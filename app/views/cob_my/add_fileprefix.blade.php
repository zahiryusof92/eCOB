@extends('layout.malay_layout.default')

@section('content')

<?php
$insert_permission = 0;

foreach ($user_permission as $permission) {
    if ($permission->submodule_id == 1) {
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
                    <form id="add_fileprefix" class="form-horizontal" name="add_fileprefix">
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label class="form-control-label" style="color: red; font-style: italic;">* Medan Wajib Diisi</label>
                            </div>
                        </div>   
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label class="form-label"><span style="color: red; font-style: italic;">*</span> Penerangan</label>
                            </div>
                            <div class="col-md-4">
                                <input id="description" class="form-control" placeholder="Penerangan" type="text">
                                <div id="description_error" style="display:none;"></div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label class="form-label"><span style="color: red; font-style: italic;">*</span> Sort No</label>
                            </div>
                            <div class="col-md-2">
                                <input id="sort_no" class="form-control" placeholder="Sort No" type="number">
                                <div id="sort_no_error" style="display:none;"></div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label class="form-label"><span style="color: red; font-style: italic;">*</span> Status</label>
                            </div>    
                            <div class="col-md-4">
                                <select id="is_active" class="form-control">
                                    <option value="">Sila pilih</option>
                                    <option value="1">Aktif</option>
                                    <option value="0">Tidak Aktif</option>
                                </select>
                                <div id="is_active_error" style="display:none;"></div>
                            </div>                            
                        </div>                                               
                        <div class="form-actions">
                            <?php if ($insert_permission == 1) { ?>
                                <button type="button" class="btn btn-primary" id="submit_button" onclick="addFilePrefix()">Hantar</button>
                            <?php } ?>
                            <button type="button" class="btn btn-default" id="cancel_button" onclick="window.location ='{{URL::action('AdminController@filePrefix')}}'">Batal</button>
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
    function addFilePrefix() {
        $("#loading").css("display", "inline-block");
        $("#description_error").css("display", "none");
        $("#sort_no_error").css("display", "none");
        $("#is_active_error").css("display", "none");

        var description = $("#description").val(),
                sort_no = $("#sort_no").val(),
                is_active = $("#is_active").val();

        var error = 0;

        if (description.trim() == "") {
            $("#description_error").html('<span style="color:red;font-style:italic;font-size:13px;">Sila masukkan Penerangan</span>');
            $("#description_error").css("display", "block");
            error = 1;
        }

        if (sort_no.trim() <= 0) {
            $("#sort_no_error").html('<span style="color:red;font-style:italic;font-size:13px;">Please enter Sort No</span>');
            $("#sort_no_error").css("display", "block");
            error = 1;
        }

        if (is_active.trim() == "") {
            $("#is_active_error").html('<span style="color:red;font-style:italic;font-size:13px;">Sila pilih Status</span>');
            $("#is_active_error").css("display", "block");
            error = 1;
        }

        if (error == 0) {
            $.ajax({
                url: "{{ URL::action('AdminController@submitFilePrefix') }}",
                type: "POST",
                data: {
                    description: description,
                    sort_no: sort_no,
                    is_active: is_active

                },
                success: function (data) {
                    $("#loading").css("display", "none");
                    $("#submit_button").removeAttr("disabled");
                    $("#cancel_button").removeAttr("disabled");
                    if (data.trim() == "true") {
                        bootbox.alert("<span style='color:green;'>Tambah Awalan Fail COB berjaya!</span>", function () {
                            window.location = '{{URL::action("AdminController@filePrefix") }}';
                        });
                    } else {
                        bootbox.alert("<span style='color:red;'>Terdapat masalah ketika prosess. Sila cuba lagi.</span>");
                    }
                }
            });
        }
    }
</script>
<!-- End Page Scripts-->

@stop