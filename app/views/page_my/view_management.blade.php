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
                                <a class="nav-link" href="{{URL::action('AdminController@viewHouse', $file->id)}}">Skim Perumahan</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{URL::action('AdminController@viewStrata', $file->id)}}">Kawasan Pemajuan (STRATA)</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active">Pihak Pengurusan</a>
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
                            <div class="tab-pane active" id="management" role="tabpanel">
                                <form id="management">
                                    @if (count($management_jmb) <= 0)
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <input type="checkbox" name="is_jmb" id="is_jmb" disabled=""/>
                                            <label><h4> Badan Pengurusan Bersama (JMB)</h4></label>
                                            <!-- jmb Form -->
                                            <div id="jmb_form" style="display:none">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Tarikh Penubuhan</label>
                                                            <label class="input-group datepicker-only-init">
                                                                <input type="text" class="form-control" placeholder="Tarikh Penubuhan" id="jmb_date_formed" readonly=""/>
                                                                <span class="input-group-addon">
                                                                    <i class="icmn-calendar"></i>
                                                                </span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>No. Siri Sijil</label>
                                                            <input type="text" class="form-control" placeholder="No. Siri Sijil" id="jmb_certificate_no" readonly="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Nama</label>
                                                            <input type="text" class="form-control" placeholder="Nama" id="jmb_name" readonly="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            <label>Alamat</label>
                                                            <input type="text" class="form-control" placeholder="Alamat 1" id="jmb_address1" readonly="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" placeholder="Alamat 2" id="jmb_address2" readonly="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" placeholder="Alamat 3" id="jmb_address3" readonly="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Bandar</label>
                                                            <select class="form-control" id="jmb_city" disabled="">
                                                                <option value="">Sila pilih</option>
                                                                @foreach ($city as $cities)
                                                                <option value="{{$cities->id}}">{{$cities->description}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Poskod</label>
                                                            <input type="text" class="form-control" placeholder="Poskod" id="jmb_poscode" readonly="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Negeri</label>
                                                            <select class="form-control" id="jmb_state" disabled="">
                                                                <option value="">Sila pilih</option>
                                                                @foreach ($state as $states)
                                                                <option value="{{$states->id}}">{{$states->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Negara</label>
                                                            <select class="form-control" id="jmb_country" disabled="">
                                                                <option value="">Sila pilih</option>
                                                                @foreach ($country as $countries)
                                                                <option value="{{$countries->id}}">{{$countries->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>No. Telefon</label>
                                                            <input type="text" class="form-control" placeholder="No. Telefon" id="jmb_phone_no" readonly="">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>No. Fax</label>
                                                            <input type="text" class="form-control" placeholder="No. Fax" id="jmb_fax_no" readonly="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @else
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <input type="checkbox" name="is_jmb" id="is_jmb" {{($management->is_jmb == 1 ? " checked" : "")}} disabled>
                                            <label><h4> Badan Pengurusan Bersama (JMB)</h4></label>
                                            <!-- jmb Form -->
                                            <div id="jmb_form">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Tarikh Penubuhan</label>
                                                            <label class="input-group datepicker-only-init">
                                                                <input type="text" class="form-control" placeholder="Tarikh Penubuhan" id="jmb_date_formed" value="{{$management_jmb->date_formed}}" readonly="">
                                                                <span class="input-group-addon">
                                                                    <i class="icmn-calendar"></i>
                                                                </span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>No. Siri Sijil</label>
                                                            <input type="text" class="form-control" placeholder="No. Siri Sijil" id="jmb_certificate_no" value="{{$management_jmb->certificate_no}}" readonly="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>{{ trans('app.forms.name') }}</label>
                                                            <input type="text" class="form-control" placeholder="{{ trans('app.forms.name') }}" id="jmb_name" value="{{$management_jmb->name}}" readonly="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            <label>Alamat</label>
                                                            <input type="text" class="form-control" placeholder="Alamat 1" id="jmb_address1" value="{{$management_jmb->address1}}" readonly="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" placeholder="Alamat 2" id="jmb_address2" value="{{$management_jmb->address2}}" readonly="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" placeholder="Alamat 3" id="jmb_address3" value="{{$management_jmb->address3}}" readonly="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Bandar</label>
                                                            <select class="form-control" id="jmb_city" disabled="">
                                                                <option value="">Sila pilih</option>
                                                                @foreach ($city as $cities)
                                                                <option value="{{$cities->id}}" {{($management_jmb->city == $cities->id ? " selected" : "")}}>{{$cities->description}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Poskod</label>
                                                            <input type="text" class="form-control" placeholder="Poskod" id="jmb_poscode" value="{{$management_jmb->poscode}}" readonly="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>{{ trans('app.forms.state') }}</label>
                                                            <select class="form-control" id="jmb_state" disabled="">
                                                                <option value="">Sila pilih</option>
                                                                @foreach ($state as $states)
                                                                <option value="{{$states->id}}" {{($management_jmb->state == $states->id ? " selected" : "")}}>{{$states->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>{{ trans('app.forms.country') }}</label>
                                                            <select class="form-control" id="jmb_country" disabled="">
                                                                <option value="">Sila pilih</option>
                                                                @foreach ($country as $countries)
                                                                <option value="{{$countries->id}}" {{($management_jmb->country == $countries->id ? " selected" : "")}}>{{$countries->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>No. Telefon</label>
                                                            <input type="text" class="form-control" placeholder="No. Telefon" id="jmb_phone_no" value="{{$management_jmb->phone_no}}" readonly="">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>No. Fax</label>
                                                            <input type="text" class="form-control" placeholder="No. Fax" id="jmb_fax_no" value="{{$management_jmb->fax_no}}" readonly="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    <hr/>
                                    @if (count($management_mc) <= 0)
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <input type="checkbox" name="is_mc" id="is_mc" disabled="">
                                            <label><h4> Perbadanan Pengurusan (MC)</h4></label>
                                            <!-- jmb Form -->
                                            <div id="mc_form" style="display:none">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Tarikh Penubuhan</label>
                                                            <label class="input-group datepicker-only-init">
                                                                <input type="text" class="form-control" placeholder="Tarikh Penubuhan" id="mc_date_formed" readonly="">
                                                                <span class="input-group-addon">
                                                                    <i class="icmn-calendar"></i>
                                                                </span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Tarikh Mesyuarat Agong Pertama</label>
                                                            <label class="input-group datepicker-only-init">
                                                                <input type="text" class="form-control" placeholder="Tarikh Mesyuarat Agong Pertama" id="mc_first_agm" readonly=""/>
                                                                <span class="input-group-addon">
                                                                    <i class="icmn-calendar"></i>
                                                                </span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Nama</label>
                                                            <input type="text" class="form-control" placeholder="Nama" id="mc_name" readonly="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            <label>Alamat</label>
                                                            <input type="text" class="form-control" placeholder="Alamat 1" id="mc_address1" readonly="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" placeholder="Alamat 2" id="mc_address2" readonly="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" placeholder="Alamat 3" id="mc_address3" readonly="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Bandar</label>
                                                            <select class="form-control" id="mc_city" disabled="">
                                                                <option value="">Sila pilih</option>
                                                                @foreach ($city as $cities)
                                                                <option value="{{$cities->id}}">{{$cities->description}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Poskod</label>
                                                            <input type="text" class="form-control" placeholder="Poskod" id="mc_poscode" readonly="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Negeri</label>
                                                            <select class="form-control" id="mc_state" disabled="">
                                                                <option value="">Sila pilih</option>
                                                                @foreach ($state as $states)
                                                                <option value="{{$states->id}}">{{$states->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Negara</label>
                                                            <select class="form-control" id="mc_country" disabled="">
                                                                <option value="">Sila pilih</option>
                                                                @foreach ($country as $countries)
                                                                <option value="{{$countries->id}}">{{$countries->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>No. Telefon</label>
                                                            <input type="text" class="form-control" placeholder="No. Telefon" id="mc_phone_no" readonly="">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>No. Fax</label>
                                                            <input type="text" class="form-control" placeholder="No. Fax" id="mc_fax_no" readonly="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @else
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <input type="checkbox" name="is_mc" id="is_mc" {{($management->is_mc == 1 ? " checked" : "")}} disabled>
                                            <label><h4> Perbadanan Pengurusan (MC)</h4></label>
                                            <!-- mc Form -->
                                            <div id="mc_form">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Tarikh Penubuhan</label>
                                                            <label class="input-group datepicker-only-init">
                                                                <input type="text" class="form-control" placeholder="Tarikh Penubuhan" id="mc_date_formed" value="{{$management_mc->date_formed}}" readonly="">
                                                                <span class="input-group-addon">
                                                                    <i class="icmn-calendar"></i>
                                                                </span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Tarikh Mesyuarat Agong Pertama</label>
                                                            <label class="input-group datepicker-only-init">
                                                                <input type="text" class="form-control" placeholder="Tarikh Mesyuarat Agong Pertama" id="mc_first_agm" value="{{$management_mc->first_agm}}" readonly="">
                                                                <span class="input-group-addon">
                                                                    <i class="icmn-calendar"></i>
                                                                </span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Nama</label>
                                                            <input type="text" class="form-control" placeholder="Nama" id="mc_name" value="{{$management_mc->name}}" readonly="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            <label>Alamat</label>
                                                            <input type="text" class="form-control" placeholder="Alamat 1" id="mc_address1" value="{{$management_mc->address1}}" readonly="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" placeholder="Alamat 2" id="mc_address2" value="{{$management_mc->address2}}" readonly="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" placeholder="Alamat 3" id="mc_address3" value="{{$management_mc->address3}}" readonly="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Bandar</label>
                                                            <select class="form-control" id="mc_city" disabled="">
                                                                <option value="">Sila pilih</option>
                                                                @foreach ($city as $cities)
                                                                <option value="{{$cities->id}}" {{($management_mc->city == $cities->id ? " selected" : "")}}>{{$cities->description}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Poskod</label>
                                                            <input type="text" class="form-control" placeholder="Poskod" id="mc_poscode" value="{{$management_mc->poscode}}" readonly="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Negeri</label>
                                                            <select class="form-control" id="mc_state" disabled="">
                                                                <option value="">Sila pilih</option>
                                                                @foreach ($state as $states)
                                                                <option value="{{$states->id}}" {{($management_mc->state == $states->id ? " selected" : "")}}>{{$states->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Negara</label>
                                                            <select class="form-control" id="mc_country" disabled="">
                                                                <option value="">Sila pilih</option>
                                                                @foreach ($country as $countries)
                                                                <option value="{{$countries->id}}" {{($management_mc->country == $countries->id ? " selected" : "")}}>{{$countries->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>No. Telefon</label>
                                                            <input type="text" class="form-control" placeholder="No. Telefon" id="mc_phone_no" value="{{$management_mc->phone_no}}" readonly="">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>No. Fax</label>
                                                            <input type="text" class="form-control" placeholder="No. Fax" id="mc_fax_no" value="{{$management_mc->fax_no}}" readonly="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    <hr/>
                                    @if(count($management_agent) <= 0)
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <input type="checkbox" name="is_agent" id="is_agent" disabled="">
                                            <label><h4> Ejen</h4></label>
                                            <!-- agent Form -->
                                            <div id="agent_form" style="display:none">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Lantikan</label>
                                                            <select class="form-control" id="agent_selected_by" disabled="">
                                                                <option value="">Sila pilih</option>
                                                                <option value="developer">Pemaju</option>
                                                                <option value="cob">{{ trans('app.forms.cob') }}</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Nama</label>
                                                            <select class="form-control" id="agent_name" disabled="">
                                                                <option value="">Sila pilih</option>
                                                                @foreach ($agent as $agents)
                                                                <option value="{{$agents->id}}">{{$agents->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            <label>Alamat</label>
                                                            <input type="text" class="form-control" placeholder="Alamat 1" id="agent_address1" readonly="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" placeholder="Alamat 2" id="agent_address2" readonly="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" placeholder="Alamat 3" id="agent_address3" readonly="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Bandar</label>
                                                            <select class="form-control" id="agent_city" disabled="">
                                                                <option value="">Sila pilih</option>
                                                                @foreach ($city as $cities)
                                                                <option value="{{$cities->id}}">{{$cities->description}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Poskod</label>
                                                            <input type="text" class="form-control" placeholder="Poskod" id="agent_poscode" readonly="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Negeri</label>
                                                            <select class="form-control" id="agent_state" disabled="">
                                                                <option value="">Sila pilih</option>
                                                                @foreach ($state as $states)
                                                                <option value="{{$states->id}}">{{$states->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Negara</label>
                                                            <select class="form-control" id="agent_country" disabled="">
                                                                <option value="">Sila pilih</option>
                                                                @foreach ($country as $countries)
                                                                <option value="{{$countries->id}}">{{$countries->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>No. Telefon</label>
                                                            <input type="text" class="form-control" placeholder="No. Telefon" id="agent_phone_no" readonly="">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>No. Fax</label>
                                                            <input type="text" class="form-control" placeholder="No. Fax" id="agent_fax_no" readonly="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @else
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <input type="checkbox" name="is_agent" id="is_agent" {{($management->is_agent == 1 ? " checked" : "")}} disabled>
                                            <label><h4> Ejen</h4></label>
                                            <!-- agent Form -->
                                            <div id="agent_form">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Lantikan</label>
                                                            <select class="form-control" id="agent_selected_by" disabled="">
                                                                <option value="">Sila pilih</option>
                                                                <option value="developer" {{($management_agent->selected_by == "developer" ? " selected" : "")}}>Pemaju</option>
                                                                <option value="cob" {{($management_agent->selected_by == "cob" ? " selected" : "")}}>{{ trans('app.forms.cob') }}</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Nama</label>
                                                            <select class="form-control" id="agent_name" disabled="">
                                                                <option value="">Sila pilih</option>
                                                                @foreach ($agent as $agents)
                                                                <option value="{{$agents->id}}" {{($management_agent->agent == $agents->id ? " selected" : "")}}>{{$agents->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            <label>Alamat</label>
                                                            <input type="text" class="form-control" placeholder="Alamat 1" id="agent_address1" value="{{$management_agent->address1}}" readonly="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" placeholder="Alamat 2" id="agent_address2" value="{{$management_agent->address2}}" readonly="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" placeholder="Alamat 3" id="agent_address3" value="{{$management_agent->address3}}" readonly="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Bandar</label>
                                                            <select class="form-control" id="agent_city" disabled="">
                                                                <option value="">Sila pilih</option>
                                                                @foreach ($city as $cities)
                                                                <option value="{{$cities->id}}" {{($management_agent->city == $cities->id ? " selected" : "")}}>{{$cities->description}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Poskod</label>
                                                            <input type="text" class="form-control" placeholder="Poskod" id="agent_poscode" value="{{$management_agent->address1}}" readonly="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Negeri</label>
                                                            <select class="form-control" id="agent_state" disabled="">
                                                                <option value="">Sila pilih</option>
                                                                @foreach ($state as $states)
                                                                <option value="{{$states->id}}" {{($management_agent->state == $states->id ? " selected" : "")}}>{{$states->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Negara</label>
                                                            <select class="form-control" id="agent_country" disabled="">
                                                                <option value="">Sila pilih</option>
                                                                @foreach ($country as $countries)
                                                                <option value="{{$countries->id}}" {{($management_agent->country == $countries->id ? " selected" : "")}}>{{$countries->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>No. Telefon</label>
                                                            <input type="text" class="form-control" placeholder="No. Telefon" id="agent_phone_no" value="{{$management_agent->phone_no}}" readonly="">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>No. Fax</label>
                                                            <input type="text" class="form-control" placeholder="No. Fax" id="agent_fax_no" value="{{$management_agent->fax_no}}" readonly="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    <hr/>
                                    @if (count($management_others) <= 0)
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <input type="checkbox" name="is_others" id="is_others" disabled=""/>
                                            <label><h4> Pelbagai</h4></label>
                                            <!-- jmb Form -->
                                            <div id="other_form" style="display:none">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Nama</label>
                                                            <input type="text" class="form-control" placeholder="Nama" id="others_name" readonly="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            <label>Alamat</label>
                                                            <input type="text" class="form-control" placeholder="Alamat 1" id="others_address1" readonly="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" placeholder="Alamat 2" id="others_address2" readonly="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" placeholder="Alamat 3" id="others_address3" readonly="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Bandar</label>
                                                            <select class="form-control" id="others_city" disabled="">
                                                                <option value="">Sila pilih</option>
                                                                @foreach ($city as $cities)
                                                                <option value="{{$cities->id}}">{{$cities->description}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Poskod</label>
                                                            <input type="text" class="form-control" placeholder="Poskod" id="others_poscode" disabled="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Negeri</label>
                                                            <select class="form-control" id="others_state" disabled="">
                                                                <option value="">Sila pilih</option>
                                                                @foreach ($state as $states)
                                                                <option value="{{$states->id}}">{{$states->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Negara</label>
                                                            <select class="form-control" id="others_country" disabled="">
                                                                <option value="">Sila pilih</option>
                                                                @foreach ($country as $countries)
                                                                <option value="{{$countries->id}}">{{$countries->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>No. Telefon</label>
                                                            <input type="text" class="form-control" placeholder="No. Telefon" id="others_phone_no" readonly="">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>No. Fax</label>
                                                            <input type="text" class="form-control" placeholder="No. Fax" id="others_fax_no" readonly="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @else
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <input type="checkbox" name="is_others" id="is_others" {{($management->is_others == 1 ? " checked" : "")}} disabled>
                                            <label><h4> Pelbagai</h4></label>
                                            <!-- jmb Form -->
                                            <div id="other_form">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Nama</label>
                                                            <input type="text" class="form-control" placeholder="Nama" id="others_name" value="{{$management_others->name}}" readonly="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            <label>Alamat</label>
                                                            <input type="text" class="form-control" placeholder="Alamat 1" id="others_address1" value="{{$management_others->address1}}" readonly="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" placeholder="Alamat 2" id="others_address2" value="{{$management_others->address2}}" readonly="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" placeholder="Alamat 3" id="others_address3" value="{{$management_others->address3}}" readonly="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Bandar</label>
                                                            <select class="form-control" id="others_city" disabled="">
                                                                <option value="">Sila pilih</option>
                                                                @foreach ($city as $cities)
                                                                <option value="{{$cities->id}}" {{($management_others->city == $cities->id ? " selected" : "")}}>{{$cities->description}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Poskod</label>
                                                            <input type="text" class="form-control" placeholder="Poskod" id="others_poscode" value="{{$management_others->poscode}}" readonly="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Negeri</label>
                                                            <select class="form-control" id="others_state" disabled="">
                                                                <option value="">Sila pilih</option>
                                                                @foreach ($state as $states)
                                                                <option value="{{$states->id}}" {{($management_others->state == $states->id ? " selected" : "")}}>{{$states->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Negara</label>
                                                            <select class="form-control" id="others_country" disabled="">
                                                                <option value="">Sila pilih</option>
                                                                @foreach ($country as $countries)
                                                                <option value="{{$countries->id}}" {{($management_others->country == $countries->id ? " selected" : "")}}>{{$countries->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>No. Telefon</label>
                                                            <input type="text" class="form-control" placeholder="No. Telefon" id="others_phone_no" value="{{$management_others->phone_no}}" readonly="">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>No. Fax</label>
                                                            <input type="text" class="form-control" placeholder="No. Fax" id="others_fax_no" value="{{$management_others->fax_no}}" readonly="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </form>
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
    $(function(){
        $('#jmb_date_formed').datetimepicker({
            widgetPositioning: {
                horizontal: 'left'
            },
            icons: {
                time: "fa fa-clock-o",
                date: "fa fa-calendar",
                up: "fa fa-arrow-up",
                down: "fa fa-arrow-down"
            },
            format: 'YYYY-MM-DD'
        });
        $('#mc_date_formed').datetimepicker({
            widgetPositioning: {
                horizontal: 'left'
            },
            icons: {
                time: "fa fa-clock-o",
                date: "fa fa-calendar",
                up: "fa fa-arrow-up",
                down: "fa fa-arrow-down"
            },
            format: 'YYYY-MM-DD'
        });
        $('#mc_first_agm').datetimepicker({
            widgetPositioning: {
                horizontal: 'left'
            },
            icons: {
                time: "fa fa-clock-o",
                date: "fa fa-calendar",
                up: "fa fa-arrow-up",
                down: "fa fa-arrow-down"
            },
            format: 'YYYY-MM-DD'
        });
        $("[data-toggle=tooltip]").tooltip();
    });

    $(document).ready(function () {
        $('#is_jmb').click(function() {
            if ($(this).is(':checked')) {
                $("#jmb_form").fadeIn(500);
            } else {
                $("#jmb_form").fadeOut(0);
            }
        });
        $('#is_mc').click(function() {
            if ($(this).is(':checked')) {
                $("#mc_form").fadeIn(500);
            } else {
                $("#mc_form").fadeOut(0);
            }
        });
        $('#is_agent').click(function() {
            if ($(this).is(':checked')) {
                $("#agent_form").fadeIn(500);
            } else {
                $("#agent_form").fadeOut(0);
            }
        });
        $('#is_others').click(function() {
            if ($(this).is(':checked')) {
                $("#other_form").fadeIn(500);
            } else {
                $("#other_form").fadeOut(0);
            }
        });
    });
</script>

<!-- End Page Scripts-->

@stop
