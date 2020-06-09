@extends('layout.malay_layout.default')

@section('content')

<?php
$update_permission = 0;

foreach ($user_permission as $permission) {
    if ($permission->submodule_id == 5) {
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
                    <form id="add_access_group">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label style="color: red; font-style: italic;">* Medan Wajib Diisi</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label"><span style="color: red; font-style: italic;">*</span> Nama</label>
                                    <input id="description" class="form-control" placeholder="Nama" type="text" value="{{$accessgroup->name}}">
                                    <div id="description_error" style="display:none;"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <table class="table margin-bottom-0" border="0">
                                    <thead>
                                        <tr>
                                            <th style="width:70%;text-align: center !important;">Halaman</th>
                                            <th style="width:10%;text-align: center !important;">Akses</th>
                                            <th style="width:10%;text-align: center !important;">Tambah</th>
                                            <th style="width:10%;text-align: center !important;">Kemaskini</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($module as $modules)
                                        <tr>
                                            <th colspan="5">{{strtoupper($modules->name_my)}}</th>
                                        </tr>
                                        <?php
                                        $submodule = SubModule::where('module_id', $modules->id)->get();
                                        ?>

                                        @foreach($submodule as $submodules)
                                        <?php
                                        $permission = AccessGroup::where('role_id', $accessgroup->id)->where('submodule_id', $submodules->id)->get();
                                        ?>
                                        @if ($modules->id == 4)
                                        <tr>
                                            <td> - {{$submodules->name_my}}</td>
                                            @if(count($permission)>0)
                                            @foreach($permission as $permissions)
                                            <td style="text-align: center;">
                                                <input type="checkbox" class="access" name="access[]" value="{{$submodules->id}}"
                                                       {{($permissions->submodule_id == $submodules->id && $permissions->access_permission == 1 ? " checked" : "")}}/>
                                            </td>
                                            @endforeach
                                            <td style="text-align: center;"></td>
                                            <td style="text-align: center;"></td>
                                            @else
                                            <td style="text-align: center;">
                                                <input type="checkbox" class="access" name="access[]" value="{{$submodules->id}}" />
                                            </td>
                                            <td style="text-align: center;"></td>
                                            <td style="text-align: center;"></td>
                                            @endif
                                        </tr>
                                        @elseif ($submodules->id == 2)
                                        <tr>
                                            <td> - {{$submodules->name_my}}</td>
                                            @if(count($permission)>0)
                                            @foreach($permission as $permissions)
                                            <td style="text-align: center;">
                                                <input type="checkbox" class="access" name="access[]" value="{{$submodules->id}}"
                                                       {{($permissions->submodule_id == $submodules->id && $permissions->access_permission == 1 ? " checked" : "")}}/>
                                            </td>
                                            @endforeach
                                            @foreach($permission as $permissions)
                                            <td style="text-align: center;">
                                                <input type="checkbox" class="insert" name="insert[]" value="{{$submodules->id}}"
                                                       {{($permissions->submodule_id == $submodules->id && $permissions->insert_permission == 1 ? " checked" : "")}}/>
                                            </td>
                                            @endforeach
                                            <td style="text-align: center;"></td>
                                            @else
                                            <td style="text-align: center;">
                                                <input type="checkbox" class="access" name="access[]" value="{{$submodules->id}}" />
                                            </td>
                                            <td style="text-align: center;">
                                                <input type="checkbox" class="insert" name="insert[]" value="{{$submodules->id}}" />
                                            </td>
                                            <td style="text-align: center;"></td>
                                            @endif
                                        </tr>
                                        @elseif ($submodules->id == 3)
                                        <tr>
                                            <td> - {{$submodules->name_my}}</td>
                                            @if(count($permission)>0)
                                            @foreach($permission as $permissions)
                                            <td style="text-align: center;">
                                                <input type="checkbox" class="access" name="access[]" value="{{$submodules->id}}"
                                                       {{($permissions->submodule_id == $submodules->id && $permissions->access_permission == 1 ? " checked" : "")}}/>
                                            </td>
                                            @endforeach
                                            <td style="text-align: center;"></td>
                                            @foreach($permission as $permissions)
                                            <td style="text-align: center;">
                                                <input type="checkbox" class="update" name="update[]" value="{{$submodules->id}}"
                                                       {{($permissions->submodule_id == $submodules->id && $permissions->update_permission == 1 ? " checked" : "")}}/>
                                            </td>
                                            @endforeach
                                            @else
                                            <td style="text-align: center;">
                                                <input type="checkbox" class="access" name="access[]" value="{{$submodules->id}}" />
                                            </td>
                                            <td style="text-align: center;"></td>
                                            <td style="text-align: center;">
                                                <input type="checkbox" class="update" name="update[]" value="{{$submodules->id}}" />
                                            </td>
                                            @endif
                                        </tr>
                                        @else
                                        <tr>
                                            <td> - {{$submodules->name_my}}</td>
                                            @if (count($permission) > 0)
                                            @foreach($permission as $permissions)
                                            <td style="text-align: center;">
                                                <input type="checkbox" class="access" name="access[]" value="{{$submodules->id}}"
                                                       {{($permissions->submodule_id == $submodules->id && $permissions->access_permission == 1 ? " checked" : "")}}/>
                                            </td>
                                            @endforeach
                                            @foreach($permission as $permissions)
                                            <td style="text-align: center;">
                                                <input type="checkbox" class="insert" name="insert[]" value="{{$submodules->id}}"
                                                       {{($permissions->submodule_id == $submodules->id && $permissions->insert_permission == 1 ? " checked" : "")}}/>
                                            </td>
                                            @endforeach
                                            @foreach($permission as $permissions)
                                            <td style="text-align: center;">
                                                <input type="checkbox" class="update" name="update[]" value="{{$submodules->id}}"
                                                       {{($permissions->submodule_id == $submodules->id && $permissions->update_permission == 1 ? " checked" : "")}}/>
                                            </td>
                                            @endforeach
                                            @else
                                            <td style="text-align: center;">
                                                <input type="checkbox" class="access" name="access[]" value="{{$submodules->id}}" />
                                            </td>
                                            <td style="text-align: center;">
                                                <input type="checkbox" class="insert" name="insert[]" value="{{$submodules->id}}" />
                                            </td>
                                            <td style="text-align: center;">
                                                <input type="checkbox" class="update" name="update[]" value="{{$submodules->id}}" />
                                            </td>
                                            @endif
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
                                    <label><span style="color: red;">*</span> {{ trans('app.forms.admin_status') }}</label>
                                    <select id="is_active" class="form-control">
                                        <option value="">Sila pilih</option>
                                        <option value="1" {{($accessgroup->is_active==1 ? " selected" : "")}}>Aktif</option>
                                        <option value="0" {{($accessgroup->is_active==0 ? " selected" : "")}}>|Tidak Aktif</option>
                                    </select>
                                    <div id="is_active_error" style="display:none;"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Catatan</label>
                                    <textarea class="form-control" rows="3" placeholder="Catatan" id="remarks">{{$accessgroup->remarks}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions">
                            <?php if ($update_permission == 1) { ?>
                            <button type="button" class="btn btn-primary" id="submit_button" onclick="updateAccessGroup()">Simpan</button>
                            <?php } ?>
                            <button type="button" class="btn btn-default" id="cancel_button" onclick="window.location ='{{ URL::action("AdminController@accessGroups") }}'">Batal</button>
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

    function updateAccessGroup() {
        $("#loading").css("display", "inline-block");

        var description = $("#description").val(),
                remarks = $("#remarks").val(),
                is_active = $("#is_active").val();

        var error = 0;

        if (description.trim() == "") {
            $("#description_error").html('<span style="color:red;font-style:italic;font-size:13px;">Sila masukkan Nama</span>');
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
                url: "{{ URL::action('AdminController@submitUpdateAccessGroup') }}",
                type: "POST",
                data: {
                    description: description,
                    selected_access: $('.access:checked').serialize(),
                    selected_insert: $('.insert:checked').serialize(),
                    selected_update: $('.update:checked').serialize(),
                    remarks: remarks,
                    is_active: is_active,
                    role_id: '{{$accessgroup->id}}'

                },
                success: function (data) {
                    $("#loading").css("display", "none");
                    $("#submit_button").removeAttr("disabled");
                    $("#cancel_button").removeAttr("disabled");
                    if (data.trim() == "true") {
                        bootbox.alert("<span style='color:green;'>Edit Akses Kumpulan berjaya!</span>", function () {
                            window.location = '{{URL::action("AdminController@accessGroups") }}';
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
