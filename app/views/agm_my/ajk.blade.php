@extends('layout.malay_layout.default')

@section('content')

<?php
$update_permission = 0;
$insert_permission = 0;

foreach ($user_permission as $permission) {
    if ($permission->submodule_id == 30) {
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
                <div class="col-lg-12 text-center">
                    <form>
                        <div class="row">
                            @if (Auth::user()->getAdmin())
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label>{{ trans('app.forms.cob') }}</label>
                                    <select id="company" class="form-control select2">
                                        <option value="">{{ trans('app.forms.please_select') }}</option>
                                        @foreach ($cob as $companies)
                                        <option value="{{ $companies->short_name }}">{{ $companies->name }} ({{ $companies->short_name }})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @endif
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label>{{ trans('app.forms.file_no') }}</label>
                                    <select id="file_no" class="form-control select2">
                                        <option value="">{{ trans('app.forms.please_select') }}</option>
                                        @foreach ($file_no as $files_no)
                                        <option value="{{ $files_no->file_no }}">{{ $files_no->file_no }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>{{ trans('app.forms.year') }}</label>
                                    <select id="year" class="form-control select2">
                                        <option value="">{{ trans('app.forms.please_select') }}</option>
                                        @for ($i = 2012; $i <= date('Y'); $i++)
                                        <option value="{{ $i }}">{{ $i}}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <hr/>

            <div class="row">
                <div class="col-lg-12">
                    <div class="table-responsive">
                        <?php if ($insert_permission == 1) { ?>
                            <button type="button" class="btn btn-primary margin-bottom-25" onclick="addAJKDetails()">
                                {{ trans('app.forms.add') }}
                                                </button>
                        <?php } ?>
                        <table class="table table-hover nowrap" id="ajk_details_list" width="100%">
                            <thead>
                                <tr>
                                    <th style="width:20%;">{{ trans('app.forms.file_no') }}</th>
                                    <th style="width:20%;">{{ trans('app.forms.designation') }}</th>
                                    <th style="width:20%;">{{ trans('app.forms.name') }}</th>
                                    <th style="width:10%;">{{ trans('app.forms.phone_number') }}</th>
                                    <th style="width:10%;">{{ trans('app.forms.cob') }}</th>
                                    <th style="width:10%;">{{ trans('app.forms.year') }}</th>
                                    <?php if ($update_permission == 1) { ?>
                                        <th style="width:10%;">{{ trans('app.forms.action') }}</th>
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
                <h4 class="modal-title" id="myModalLabel">{{ trans('app.buttons.add_ajk_details') }}</h4>
            </div>
            <form id="add_ajk">
                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-md-12">
                            <label class="form-control-label" style="color: red; font-style: italic;">* {{ trans('app.forms.mandatory_fields') }}</label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-4">
                            <label class="form-control-label"><span style="color: red; font-style: italic;">*</span> {{ trans('app.forms.file_no') }}</label>
                        </div>
                        <div class="col-md-8">
                            <select id="file_id" class="form-control">
                                <option value="">{{ trans('app.forms.please_select') }}</option>
                                @foreach ($files as $file)
                                <option value="{{$file->id}}">{{$file->file_no}}</option>
                                @endforeach
                            </select>
                            <div id="file_id_error" style="display:none;"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-4">
                            <label class="form-control-label"><span style="color: red; font-style: italic;">*</span> {{ trans('app.forms.designation') }}</label>
                        </div>
                        <div class="col-md-8">
                            <select id="ajk_designation" class="form-control">
                                <option value="">{{ trans('app.forms.please_select') }}</option>
                                @foreach ($designation as $designations)
                                <option value="{{$designations->id}}">{{$designations->description}}</option>
                                @endforeach
                            </select>
                            <div id="ajk_designation_error" style="display:none;"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-4">
                            <label class="form-control-label"><span style="color: red; font-style: italic;">*</span> {{ trans('app.forms.name') }}</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" placeholder="{{ trans('app.forms.name') }}" id="ajk_name"/>
                            <div id="ajk_name_error" style="display:none;"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-4">
                            <label class="form-control-label"><span style="color: red; font-style: italic;">*</span> {{ trans('app.forms.phone_number') }}</label>
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control" placeholder="{{ trans('app.forms.phone_number') }}" id="ajk_phone_no"/>
                            <div id="ajk_phone_no_error" style="display:none;"></div>
                            <div id="ajk_phone_no_invalid_error" style="display:none;"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-4">
                            <label class="form-control-label"><span style="color: red; font-style: italic;">*</span> {{ trans('app.forms.year') }}</label>
                        </div>
                        <div class="col-md-4">
                            <input type="text" class="form-control" placeholder="{{ trans('app.forms.year') }}" id="ajk_year"/>
                            <div id="ajk_year_error" style="display:none;"></div>
                            <div id="ajk_year_invalid_error" style="display:none;"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-4">
                            <label class="form-control-label">{{ trans('app.forms.remarks') }}</label>
                        </div>
                        <div class="col-md-8">
                            <textarea class="form-control" placeholder="{{ trans('app.forms.remarks') }}" id="ajk_remarks" rows="5"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn" data-dismiss="modal">
                        {{ trans('app.forms.close') }}
                    </button>
                    <?php if ($insert_permission == 1) { ?>
                        <button id="submit_button" onclick="addAJKDetail()" type="button" class="btn btn-primary">
                            {{ trans('app.forms.submit') }}
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
                <h4 class="modal-title" id="myModalLabel">{{ trans('app.buttons.edit_ajk_details') }}</h4>
            </div>
            <form id="edit_ajk">
                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-md-4">
                            <label class="form-control-label" style="color: red; font-style: italic;">* {{ trans('app.forms.mandatory_fields') }}</label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-4">
                            <label class="form-control-label"><span style="color: red; font-style: italic;">*</span> {{ trans('app.forms.file_no') }}</label>
                        </div>
                        <div class="col-md-8">
                            <select id="file_id_edit" class="form-control">
                                <option value="">{{ trans('app.forms.please_select') }}</option>
                                @foreach ($files as $file)
                                <option value="{{$file->id}}">{{$file->file_no}}</option>
                                @endforeach
                            </select>
                            <div id="file_id_edit_error" style="display:none;"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-4">
                            <label class="form-control-label"><span style="color: red; font-style: italic;">*</span> {{ trans('app.forms.designation') }}</label>
                        </div>
                        <div class="col-md-8">
                            <select id="ajk_designation_edit" class="form-control">
                                <option value="">{{ trans('app.forms.please_select') }}</option>
                                @foreach ($designation as $designations)
                                <option value="{{$designations->id}}">{{$designations->description}}</option>
                                @endforeach
                            </select>
                            <div id="ajk_designation_edit_error" style="display:none;"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-4">
                            <label class="form-control-label"><span style="color: red; font-style: italic;">*</span> {{ trans('app.forms.name') }}</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" placeholder="{{ trans('app.forms.name') }}" id="ajk_name_edit"/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-4">
                            <label class="form-control-label"><span style="color: red; font-style: italic;">*</span> {{ trans('app.forms.phone_number') }}</label>
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control" placeholder="{{ trans('app.forms.phone_number') }}" id="ajk_phone_no_edit"/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-4">
                            <label class="form-control-label"><span style="color: red; font-style: italic;">*</span> {{ trans('app.forms.year') }}</label>
                        </div>
                        <div class="col-md-4">
                            <input type="text" class="form-control" placeholder="{{ trans('app.forms.year') }}" id="ajk_year_edit"/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-4">
                            <label class="form-control-label">{{ trans('app.forms.remarks') }}</label>
                        </div>
                        <div class="col-md-8">
                            <textarea class="form-control" placeholder="{{ trans('app.forms.remarks') }}" id="ajk_remarks" rows="5"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="ajk_id_edit"/>
                    <button type="button" class="btn" data-dismiss="modal">
                        {{ trans('app.forms.close') }}
                    </button>
                    <?php if ($update_permission == 1) { ?>
                        <button id="submit_button" onclick="editAJK()" type="button" class="btn btn-primary">
                            {{ trans('app.forms.submit') }}
                                </button>
                    <?php } ?>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Page Scripts -->
<script>
    var oTable;
    $(document).ready(function () {
        oTable = $('#ajk_details_list').DataTable({
            "sAjaxSource": "{{URL::action('AgmController@getAJK')}}",
            "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            "order": [[5, 'desc'], [6, 'desc']],
            "responsive": true,
            "aoColumnDefs": [
                {
                    "bSortable": false,
                    "aTargets": [-1]
                }
            ]
        });

        $('#company').on('change', function () {
            oTable.columns(4).search(this.value).draw();
        });
        $('#file_no').on('change', function () {
            oTable.columns(0).search(this.value).draw();
        });
        $('#year').on('change', function () {
            oTable.columns(5).search(this.value).draw();
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
            $("#file_id_error").html('<span style="color:red;font-style:italic;font-size:13px;">{{ trans("app.errors.select", ["attribute"=>"File No"]) }}</span>');
            $("#file_id_error").css("display", "block");
            error = 1;
        }

        if (ajk_designation.trim() == "") {
            $("#ajk_designation_error").html('<span style="color:red;font-style:italic;font-size:13px;">{{ trans("app.errors.select", ["attribute"=>"Designation"]) }}</span>');
            $("#ajk_designation_error").css("display", "block");
            error = 1;
        }

        if (ajk_name.trim() == "") {
            $("#ajk_name_error").html('<span style="color:red;font-style:italic;font-size:13px;">{{ trans("app.errors.required", ["attribute"=>"Name"]) }}</span>');
            $("#ajk_name_error").css("display", "block");
            error = 1;
        }

        if (ajk_phone_no.trim() == "") {
            $("#ajk_phone_no_error").html('<span style="color:red;font-style:italic;font-size:13px;">{{ trans("app.errors.required", ["attribute"=>"Phone Number"]) }}</span>');
            $("#ajk_phone_no_error").css("display", "block");
            $("#ajk_phone_no_invalid_error").css("display", "none");
            error = 1;
        }

        if (isNaN(ajk_phone_no)) {
            $("#ajk_phone_no_invalid_error").html('<span style="color:red;font-style:italic;font-size:13px;">{{ trans("app.errors.required_valid", ["attribute"=>"Phone Number"]) }}</span>');
            $("#ajk_phone_no_invalid_error").css("display", "block");
            $("#ajk_phone_no_error").css("display", "none");
            error = 1;
        }

        if (ajk_year.trim() == "") {
            $("#ajk_year_error").html('<span style="color:red;font-style:italic;font-size:13px;">{{ trans("app.errors.required", ["attribute"=>"Year"]) }}</span>');
            $("#ajk_year_error").css("display", "block");
            $("#ajk_year_invalid_error").css("display", "none");
            error = 1;
        }

        if (isNaN(ajk_year)) {
            $("#ajk_year_invalid_error").html('<span style="color:red;font-style:italic;font-size:13px;">{{ trans("app.errors.required_valid", ["attribute"=>"Year"]) }}</span>');
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
                            message: '<p style="text-align: center; margin-bottom: 0px;">{{ trans("app.successes.saved_successfully") }}</p>',
                        }, {
                            type: 'success',
                            placement: {
                                align: "center"
                            }
                        });
                        location.reload();
                    } else {
                        bootbox.alert("<span style='color:red;'>{{ trans('app.errors.occurred') }}</span>");
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
            $("#ajk_designation_edit_error").html('<span style="color:red;font-style:italic;font-size:13px;">{{ trans("app.errors.select", ["attribute"=>"Designation"]) }}</span>');
            $("#ajk_designation_edit_error").css("display", "block");
            error = 1;
        }

        if (ajk_name.trim() == "") {
            $("#ajk_name_error").html('<span style="color:red;font-style:italic;font-size:13px;">{{ trans("app.errors.required", ["attribute"=>"Name"]) }}</span>');
            $("#ajk_name_error").css("display", "block");
            error = 1;
        }

        if (ajk_phone_no.trim() == "") {
            $("#ajk_phone_no_error").html('<span style="color:red;font-style:italic;font-size:13px;">{{ trans("app.errors.required", ["attribute"=>"Phone Number"]) }}</span>');
            $("#ajk_phone_no_error").css("display", "block");
            $("#ajk_phone_no_invalid_error").css("display", "none");
            error = 1;
        }

        if (isNaN(ajk_phone_no)) {
            $("#ajk_phone_no_invalid_error").html('<span style="color:red;font-style:italic;font-size:13px;">{{ trans("app.errors.required_valid", ["attribute"=>"Phone Number"]) }}</span>');
            $("#ajk_phone_no_invalid_error").css("display", "block");
            $("#ajk_phone_no_error").css("display", "none");
            error = 1;
        }

        if (ajk_year.trim() == "") {
            $("#ajk_year_error").html('<span style="color:red;font-style:italic;font-size:13px;">{{ trans("app.errors.required", ["attribute"=>"Year"]) }}</span>');
            $("#ajk_year_error").css("display", "block");
            $("#ajk_year_invalid_error").css("display", "none");
            error = 1;
        }

        if (isNaN(ajk_year)) {
            $("#ajk_year_invalid_error").html('<span style="color:red;font-style:italic;font-size:13px;">{{ trans("app.errors.required_valid", ["attribute"=>"Year"]) }}</span>');
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
                            message: '<p style="text-align: center; margin-bottom: 0px;">{{ trans("app.successes.saved_successfully") }}</p>',
                        }, {
                            type: 'success',
                            placement: {
                                align: "center"
                            }
                        });
                        location.reload();
                    } else {
                        bootbox.alert("<span style='color:red;'>{{ trans('app.errors.occurred') }}</span>");
                    }
                }
            });
        }
    }

    function deleteAJKDetails(id) {
        swal({
            title: "{{ trans('app.confirmation.are_you_sure') }}",
            text: "{{ trans('app.confirmation.no_recover_file') }}",
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
                            message: '<p style="text-align: center; margin-bottom: 0px;">{{ trans("app.successes.deleted_successfully") }}</p>'
                        }, {
                            type: 'success',
                            placement: {
                                align: "center"
                            }
                        });
                        location.reload();
                    } else {
                        bootbox.alert("<span style='color:red;'>{{ trans('app.errors.occurred') }}</span>");
                    }
                }
            });
        });
    }
</script>


<!-- End Page Scripts-->

@stop
