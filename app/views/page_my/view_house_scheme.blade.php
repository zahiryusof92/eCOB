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
                                <a class="nav-link active">Skim Perumahan</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{URL::action('AdminController@viewStrata', $file->id)}}">Kawasan Pemajuan (STRATA)</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{URL::action('AdminController@viewManagement', $file->id)}}">Pihak Pengurusan</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{URL::action('AdminController@viewMonitoring', $file->id)}}">Pemantauan</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{URL::action('AdminController@viewOthers', $file->id)}}">Pelbagai</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{URL::action('AdminController@viewScoring', $file->id)}}">Pemarkahan Komponen Nilai</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{URL::action('AdminController@viewBuyer', $file->id)}}">Senarai Pembeli</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{URL::action('AdminController@fileApproval', $file->id)}}">Pengesahan</a>
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
                                                        <label>Nama</label>
                                                        <input type="text" class="form-control" placeholder="Nama" id="name" value="{{$house_scheme->name}}" readonly="">
                                                        <div id="name_error" style="display:none;"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Pemaju</label>
                                                        <select class="form-control" id="developer" disabled="">
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
                                                        <input type="text" class="form-control" placeholder="Alamat 1" id="address1" value="{{$house_scheme->address1}}" readonly="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" placeholder="Alamat 2" id="address2" value="{{$house_scheme->address2}}" readonly="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" placeholder="Alamat 3" id="address3" value="{{$house_scheme->address3}}" readonly="">
                                                        <div id="address_error" style="display:none;"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Bandar</label>
                                                        <select class="form-control" id="city" disabled="">
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
                                                        <input type="text" class="form-control" placeholder="Poskod" id="poscode" value="{{$house_scheme->poscode}}" readonly="">
                                                        <div id="poscode_error" style="display:none;"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Negeri</label>
                                                        <select class="form-control" id="state" disabled="">
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
                                                        <select class="form-control" id="country" disabled="">
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
                                                        <input type="text" class="form-control" placeholder="No. Telefon" id="phone_no" value="{{$house_scheme->phone_no}}" readonly="">
                                                        <div id="phone_no_error" style="display:none;"></div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>No. Fax</label>
                                                        <input type="text" class="form-control" placeholder="No. Fax" id="fax_no" value="{{$house_scheme->fax_no}}" readonly="">
                                                        <div id="fax_no_error" style="display:none;"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>{{ trans('app.forms.admin_status') }}</label>
                                                        <select id="is_active" class="form-control" disabled="">
                                                            <option value="">{{ trans('app.forms.please_select') }}</option>
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
                                                        <textarea class="form-control" rows="3" id="remarks" placeholder="Catatan" readonly="">{{$house_scheme->remarks}}</textarea>
                                                    </div>
                                                </div>
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


@stop
