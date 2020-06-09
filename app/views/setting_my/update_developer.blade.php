@extends('layout.malay_layout.default')

@section('content')

<?php
$update_permission = 0;

foreach ($user_permission as $permission) {
    if ($permission->submodule_id == 14) {
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
                    <!-- Vertical Form -->
                    <form id="update_developer">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label style="color: red; font-style: italic;">* Medan Wajib Diisi</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label><span style="color: red;">*</span> Nama</label>
                                    <input type="text" class="form-control" placeholder="Nama" id="name" value="{{$developer->name}}">
                                    <div id="name_error" style="display:none;"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>Alamat</label>
                                    <input type="text" class="form-control" placeholder="Alamat 1" id="address1" value="{{$developer->address1}}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Alamat 2" id="address2" value="{{$developer->address2}}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Alamat 3" id="address3" value="{{$developer->address3}}">
                                    <div id="address_error" style="display:none;"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Bandar</label>
                                    <select class="form-control" id="city">
                                        <option value="">Sila pilih</option>
                                        @foreach ($city as $cities)
                                        <option value="{{$cities->id}}" {{($developer->city == $cities->id ? " selected" : "")}}>{{$cities->description}}</option>
                                        @endforeach
                                    </select>
                                    <div id="city_error" style="display:none;"></div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Poskod</label>
                                    <input type="text" class="form-control" placeholder="Poskod" id="poscode" value="{{$developer->poscode}}">
                                    <div id="poscode_error" style="display:none;"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Negeri</label>
                                    <select class="form-control" id="state">
                                        <option value="">Sila pilih</option>
                                        @foreach ($state as $states)
                                        <option value="{{$states->id}}" {{($developer->state == $states->id ? " selected" : "")}}>{{$states->name}}</option>
                                        @endforeach
                                    </select>
                                    <div id="state_error" style="display:none;"></div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Negara</label>
                                    <select class="form-control" id="country">
                                        <option value="">Sila pilih</option>
                                        @foreach ($country as $countries)
                                        <option value="{{$countries->id}}" {{($developer->country == $countries->id ? " selected" : "")}}>{{$countries->name}}</option>
                                        @endforeach
                                    </select>
                                    <div id="country_error" style="display:none;"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>No. Telefon</label>
                                    <input type="text" class="form-control" placeholder="No. Telefon" id="phone_no" value="{{$developer->phone_no}}">
                                    <div id="phone_no_error" style="display:none;"></div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>No. Fax</label>
                                    <input type="text" class="form-control" placeholder="No. Fax" id="fax_no" value="{{$developer->fax_no}}">
                                    <div id="fax_no_error" style="display:none;"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label><span style="color: red;">*</span> {{ trans('app.forms.admin_status') }}</label>
                                    <select id="is_active" class="form-control">
                                        <option value="">Sila pilih</option>
                                        <option value="1" {{($developer->is_active==1 ? " selected" : "")}}>Aktif</option>
                                        <option value="0" {{($developer->is_active==0 ? " selected" : "")}}>Tidak Aktif</option>
                                    </select>
                                    <div id="is_active_error" style="display:none;"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>Catatan</label>
                                    <textarea class="form-control" placeholder="Catatan" rows="3" id="remarks">{{$developer->remarks}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions">
                            <?php if ($update_permission == 1) { ?>
                            <button type="button" class="btn btn-primary" id="submit_button" onclick="updateDeveloper()">Simpan</button>
                            <?php } ?>
                            <button type="button" class="btn btn-default" id="cancel_button" onclick="window.location ='{{URL::action('AdminController@developer')}}'">Batal</button>
                        </div>
                    </form>
                    <!-- End Vertical Form -->
                </div>
            </div>
        </div>
    </section>
    <!-- End -->
</div>

<!-- Page Scripts -->
<script>
    function updateDeveloper() {
        $("#loading").css("display", "inline-block");

        var name = $("#name").val(),
                address1 = $("#address1").val(),
                address2 = $("#address2").val(),
                address3 = $("#address3").val(),
                city = $("#city").val(),
                poscode = $("#poscode").val(),
                state = $("#state").val(),
                country = $("#country").val(),
                phone_no = $("#phone_no").val(),
                fax_no = $("#fax_no").val(),
                remarks = $("#remarks").val(),
                is_active = $("#is_active").val();

        var error = 0;

        if (name.trim() == "") {
            $("#name_error").html('<span style="color:red;font-style:italic;font-size:13px;">Sila masukkan Nama</span>');
            $("#name_error").css("display", "block");
            error = 1;
        }

        if (is_active.trim() == "") {
            $("#is_active_error").html('<span style="color:red;font-style:italic;font-size:13px;">Sila pilih Status</span>');
            $("#is_active_error").css("display", "block");
            error = 1;
        }

        if (error == 0) {
            $.ajax({
                url: "{{ URL::action('AdminController@submitUpdateDeveloper') }}",
                type: "POST",
                data: {
                    name: name,
                    address1: address1,
                    address2: address2,
                    address3: address3,
                    city: city,
                    poscode: poscode,
                    state: state,
                    country: country,
                    phone_no: phone_no,
                    fax_no: fax_no,
                    remarks: remarks,
                    is_active: is_active,
                    id: '{{$developer->id}}'

                },
                success: function (data) {
                    $("#loading").css("display", "none");
                    $("#submit_button").removeAttr("disabled");
                    $("#cancel_button").removeAttr("disabled");
                    if (data.trim() == "true") {
                        bootbox.alert("<span style='color:green;'>Pemaju berjaya dikemaskini!</span>", function () {
                            window.location = '{{URL::action("AdminController@developer") }}';
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
