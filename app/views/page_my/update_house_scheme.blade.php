@extends('layout.malay_layout.default')

@section('content')

<?php
$update_permission = 0;

foreach ($user_permission as $permission) {
    if ($permission->submodule_id == 3) {
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
                    <h6>No. Fail: {{$file->file_no}}</h6>
                    <div id="update_files_lists">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" href="{{URL::action('AdminController@house', $file->id)}}">Skim Perumahan</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{URL::action('AdminController@strata', $file->id)}}">Kawasan Pemajuan (STRATA)</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{URL::action('AdminController@management', $file->id)}}">Pihak Pengurusan</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{URL::action('AdminController@monitoring', $file->id)}}">Pemantauan</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{URL::action('AdminController@others', $file->id)}}">Pelbagai</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{URL::action('AdminController@scoring', $file->id)}}">Pemarkahan Komponen Nilai</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{URL::action('AdminController@buyer', $file->id)}}">Senarai Pembeli</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{URL::action('AdminController@document', $file->id)}}">{{ trans('app.forms.document') }}</a>
                            </li>
                        </ul>
                        <div class="tab-content padding-vertical-20">
                            <div class="tab-pane active" id="house_scheme" role="tabpanel">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <h4>Butiran</h4>
                                        <!-- House Form -->
                                        <form id="house">
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
                                                        <label><span style="color: red;">*</span> Nama</label>
                                                        <input type="text" class="form-control" placeholder="Nama" id="name" value="{{$house_scheme->name}}">
                                                        <div id="name_error" style="display:none;"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Pemaju</label>
                                                        <select class="form-control" id="developer">
                                                            <option value="">Sila pilih</option>
                                                            @foreach ($developer as $developers)
                                                            <option value="{{$developers->id}}" {{($house_scheme->developer == $developers->id ? " selected" : "")}}>{{$developers->name}}</option>
                                                            @endforeach
                                                        </select>
                                                        <div id="developer_error" style="display:none;"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <div class="form-group">
                                                        <label>Alamat</label>
                                                        <input type="text" class="form-control" placeholder="Alamat 1" id="address1" value="{{$house_scheme->address1}}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" placeholder="Alamat 2" id="address2" value="{{$house_scheme->address2}}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" placeholder="Alamat 3" id="address3" value="{{$house_scheme->address3}}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" placeholder="{{ trans('app.forms.address4') }}" id="address4" value="{{$house_scheme->address4}}">
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
                                                            <option value="{{$cities->id}}" {{($house_scheme->city == $cities->id ? " selected" : "")}}>{{$cities->description}}</option>
                                                            @endforeach
                                                        </select>
                                                        <div id="city_error" style="display:none;"></div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Poskod</label>
                                                        <input type="text" class="form-control" placeholder="Poskod" id="poscode" value="{{$house_scheme->poscode}}">
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
                                                            <option value="{{$states->id}}" {{($house_scheme->state == $states->id ? " selected" : "")}}>{{$states->name}}</option>
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
                                                            <option value="{{$countries->id}}" {{($house_scheme->country == $countries->id ? " selected" : "")}}>{{$countries->name}}</option>
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
                                                        <input type="text" class="form-control" placeholder="No. Telefon" id="phone_no" value="{{$house_scheme->phone_no}}">
                                                        <div id="phone_no_error" style="display:none;"></div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>No. Fax</label>
                                                        <input type="text" class="form-control" placeholder="No. Fax" id="fax_no" value="{{$house_scheme->fax_no}}">
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
                                                            <option value="1" {{($house_scheme->is_active==1 ? " selected" : "")}}>Aktif</option>
                                                            <option value="0" {{($house_scheme->is_active==0 ? " selected" : "")}}>Tidak Aktif</option>
                                                        </select>
                                                        <div id="is_active_error" style="display:none;"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <div class="form-group">
                                                        <label>Catatan</label>
                                                        <textarea class="form-control" rows="3" placeholder="Catatan" id="remarks">{{$house_scheme->remarks}}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-actions">
                                                <?php if ($update_permission == 1) { ?>
                                                    <button type="button" class="btn btn-primary" id="submit_button" onclick="updateHouseScheme()">Hantar</button>
                                                <?php } ?>
                                                <button type="button" class="btn btn-default" id="cancel_button" onclick="window.location ='{{URL::action('AdminController@fileList')}}'">Batal</button>
                                            </div>
                                        </form>
                                        <!-- End House Form -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End -->
</div>

<!-- Page Scripts -->
<script>
    function updateHouseScheme() {
        $("#loading").css("display", "inline-block");

        var name = $("#name").val(),
                developer = $("#developer").val(),
                address1 = $("#address1").val(),
                address2 = $("#address2").val(),
                address3 = $("#address3").val(),
                address4 = $("#address4").val(),
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
                url: "{{ URL::action('AdminController@submitUpdateHouseScheme') }}",
                type: "POST",
                data: {
                    name: name,
                    developer: developer,
                    address1: address1,
                    address2: address2,
                    address3: address3,
                    address4: address4,
                    city: city,
                    poscode: poscode,
                    state: state,
                    country: country,
                    phone_no: phone_no,
                    fax_no: fax_no,
                    remarks: remarks,
                    is_active: is_active,
                    id: '{{$house_scheme->id}}'
                },
                success: function (data) {
                    $("#loading").css("display", "none");
                    $("#submit_button").removeAttr("disabled");
                    $("#cancel_button").removeAttr("disabled");
                    if (data.trim() == "true") {
                        $.notify({
                            message: '<p style="text-align: center; margin-bottom: 0px;">Disimpan</p>',
                        }, {
                            type: 'success',
                            placement: {
                                align: "center"
                            }
                        });
                        window.location = "{{URL::action('AdminController@strata', $file->id)}}";
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
