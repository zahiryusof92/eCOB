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
                                <a class="nav-link" href="{{URL::action('AdminController@house', $file->id)}}">Skim Perumahan</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{URL::action('AdminController@strata', $file->id)}}">Kawasan Pemajuan (STRATA)</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" href="{{URL::action('AdminController@management', $file->id)}}">Pihak Pengurusan</a>
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
                                <a class="nav-link" href="{{URL::action('AdminController@document', $file->id)}}">Document</a>
                            </li>
                        </ul>
                        <div class="tab-content padding-vertical-20">                            
                            <div class="tab-pane active" id="management" role="tabpanel">
                                <form id="management">
                                    @if (count($management_jmb) <= 0)
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <input type="checkbox" name="is_jmb" id="is_jmb"/>
                                            <label><h4> Badan Pengurusan Bersama (JMB)</h4></label>
                                            <!-- jmb Form -->
                                            <div id="jmb_form" style="display:none">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Tarikh Penubuhan</label>
                                                            <label class="input-group datepicker-only-init">
                                                                <input type="text" class="form-control" placeholder="Tarikh Penubuhan" id="jmb_date_formed"/>
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
                                                            <input type="text" class="form-control" placeholder="No. Siri Sijil" id="jmb_certificate_no">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Nama</label>
                                                            <input type="text" class="form-control" placeholder="Nama" id="jmb_name">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            <label>Alamat</label>
                                                            <input type="text" class="form-control" placeholder="Alamat 1" id="jmb_address1">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" placeholder="Alamat 2" id="jmb_address2">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" placeholder="Alamat 3" id="jmb_address3">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Bandar</label>
                                                            <select class="form-control" id="jmb_city">
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
                                                            <input type="text" class="form-control" placeholder="Poskod" id="jmb_poscode">
                                                        </div>
                                                    </div>
                                                </div> 
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Negeri</label>
                                                            <select class="form-control" id="jmb_state">
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
                                                            <select class="form-control" id="jmb_country">
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
                                                            <input type="text" class="form-control" placeholder="No. Telefon" id="jmb_phone_no">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>No. Fax</label>
                                                            <input type="text" class="form-control" placeholder="No. Fax" id="jmb_fax_no">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Email</label>
                                                            <input type="email" class="form-control" placeholder="Email" id="jmb_email">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>                                            
                                        </div>
                                    </div>
                                    @else
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <input type="checkbox" name="is_jmb" id="is_jmb" {{($management->is_jmb == 1 ? " checked" : "")}}/>
                                            <label><h4> Badan Pengurusan Bersama (JMB)</h4></label>
                                            <!-- jmb Form -->
                                            <div id="jmb_form">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Tarikh Penubuhan</label>
                                                            <label class="input-group datepicker-only-init">
                                                                <input type="text" class="form-control" placeholder="Tarikh Penubuhan" id="jmb_date_formed" value="{{$management_jmb->date_formed}}"/>
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
                                                            <input type="text" class="form-control" placeholder="No. Siri Sijil" id="jmb_certificate_no" value="{{$management_jmb->certificate_no}}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Name</label>
                                                            <input type="text" class="form-control" placeholder="Name" id="jmb_name" value="{{$management_jmb->name}}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            <label>Alamat</label>
                                                            <input type="text" class="form-control" placeholder="Alamat 1" id="jmb_address1" value="{{$management_jmb->address1}}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" placeholder="Alamat 2" id="jmb_address2" value="{{$management_jmb->address2}}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" placeholder="Alamat 3" id="jmb_address3" value="{{$management_jmb->address3}}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Bandar</label>
                                                            <select class="form-control" id="jmb_city">
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
                                                            <input type="text" class="form-control" placeholder="Poskod" id="jmb_poscode" value="{{$management_jmb->poscode}}">
                                                        </div>
                                                    </div>
                                                </div> 
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>State</label>
                                                            <select class="form-control" id="jmb_state">
                                                                <option value="">Sila pilih</option>
                                                                @foreach ($state as $states)
                                                                <option value="{{$states->id}}" {{($management_jmb->state == $states->id ? " selected" : "")}}>{{$states->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Country</label>
                                                            <select class="form-control" id="jmb_country">
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
                                                            <input type="text" class="form-control" placeholder="No. Telefon" id="jmb_phone_no" value="{{$management_jmb->phone_no}}"> 
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>No. Fax</label>
                                                            <input type="text" class="form-control" placeholder="No. Fax" id="jmb_fax_no" value="{{$management_jmb->fax_no}}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Email</label>
                                                            <input type="email" class="form-control" placeholder="Email" id="jmb_email" value="{{$management_jmb->email}}">
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
                                            <input type="checkbox" name="is_mc" id="is_mc"/>
                                            <label><h4> Perbadanan Pengurusan (MC)</h4></label>
                                            <!-- jmb Form -->
                                            <div id="mc_form" style="display:none">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Tarikh Penubuhan</label>
                                                            <label class="input-group datepicker-only-init">
                                                                <input type="text" class="form-control" placeholder="Tarikh Penubuhan" id="mc_date_formed"/>
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
                                                            <label>Certificate Series Number</label>
                                                            <input type="text" class="form-control" placeholder="Certificate Series Number" id="mc_certificate_no">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Tarikh Mesyuarat Agong Pertama</label>
                                                            <label class="input-group datepicker-only-init">
                                                                <input type="text" class="form-control" placeholder="Tarikh Mesyuarat Agong Pertama" id="mc_first_agm"/>
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
                                                            <input type="text" class="form-control" placeholder="Nama" id="mc_name">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            <label>Alamat</label>
                                                            <input type="text" class="form-control" placeholder="Alamat 1" id="mc_address1">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" placeholder="Alamat 2" id="mc_address2">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" placeholder="Alamat 3" id="mc_address3">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Bandar</label>
                                                            <select class="form-control" id="mc_city">
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
                                                            <input type="text" class="form-control" placeholder="Poskod" id="mc_poscode">
                                                        </div>
                                                    </div>
                                                </div> 
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Negeri</label>
                                                            <select class="form-control" id="mc_state">
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
                                                            <select class="form-control" id="mc_country">
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
                                                            <input type="text" class="form-control" placeholder="No. Telefon" id="mc_phone_no">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>No. Fax</label>
                                                            <input type="text" class="form-control" placeholder="No. Fax" id="mc_fax_no">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Email</label>
                                                            <input type="email" class="form-control" placeholder="Email" id="mc_email">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>                                            
                                        </div>
                                    </div>
                                    @else
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <input type="checkbox" name="is_mc" id="is_mc" {{($management->is_mc == 1 ? " checked" : "")}}/>
                                            <label><h4> Perbadanan Pengurusan (MC)</h4></label>
                                            <!-- mc Form -->
                                            <div id="mc_form">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Tarikh Penubuhan</label>
                                                            <label class="input-group datepicker-only-init">
                                                                <input type="text" class="form-control" placeholder="Tarikh Penubuhan" id="mc_date_formed" value="{{$management_mc->date_formed}}"/>
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
                                                            <label>Certificate Series Number</label>
                                                            <input type="text" class="form-control" placeholder="Certificate Series Number" id="mc_certificate_no" value="{{$management_mc->certificate_no}}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Tarikh Mesyuarat Agong Pertama</label>
                                                            <label class="input-group datepicker-only-init">
                                                                <input type="text" class="form-control" placeholder="Tarikh Mesyuarat Agong Pertama" id="mc_first_agm" value="{{$management_mc->first_agm}}"/>
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
                                                            <input type="text" class="form-control" placeholder="Nama" id="mc_name" value="{{$management_mc->name}}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            <label>Alamat</label>
                                                            <input type="text" class="form-control" placeholder="Alamat 1" id="mc_address1" value="{{$management_mc->address1}}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" placeholder="Alamat 2" id="mc_address2" value="{{$management_mc->address2}}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" placeholder="Alamat 3" id="mc_address3" value="{{$management_mc->address3}}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Bandar</label>
                                                            <select class="form-control" id="mc_city">
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
                                                            <input type="text" class="form-control" placeholder="Poskod" id="mc_poscode" value="{{$management_mc->poscode}}">
                                                        </div>
                                                    </div>
                                                </div> 
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Negeri</label>
                                                            <select class="form-control" id="mc_state">
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
                                                            <select class="form-control" id="mc_country">
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
                                                            <input type="text" class="form-control" placeholder="No. Telefon" id="mc_phone_no" value="{{$management_mc->phone_no}}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>No. Fax</label>
                                                            <input type="text" class="form-control" placeholder="No. Fax" id="mc_fax_no" value="{{$management_mc->fax_no}}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Email</label>
                                                            <input type="email" class="form-control" placeholder="Email" id="mc_email" value="{{$management_mc->email}}">
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
                                            <input type="checkbox" name="is_agent" id="is_agent"/>
                                            <label><h4> Ejen</h4></label>
                                            <!-- agent Form -->
                                            <div id="agent_form" style="display:none">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Lantikan</label>
                                                            <select class="form-control" id="agent_selected_by">
                                                                <option value="">Sila pilih</option>                                                                
                                                                <option value="developer">Pemaju</option>
                                                                <option value="cob">COB</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Nama</label>
                                                            <select class="form-control" id="agent_name">
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
                                                            <input type="text" class="form-control" placeholder="Alamat 1" id="agent_address1">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" placeholder="Alamat 2" id="agent_address2">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" placeholder="Alamat 3" id="agent_address3">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Bandar</label>
                                                            <select class="form-control" id="agent_city">
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
                                                            <input type="text" class="form-control" placeholder="Poskod" id="agent_poscode">
                                                        </div>
                                                    </div>
                                                </div> 
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Negeri</label>
                                                            <select class="form-control" id="agent_state">
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
                                                            <select class="form-control" id="agent_country">
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
                                                            <input type="text" class="form-control" placeholder="No. Telefon" id="agent_phone_no">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>No. Fax</label>
                                                            <input type="text" class="form-control" placeholder="No. Fax" id="agent_fax_no">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Email</label>
                                                            <input type="email" class="form-control" placeholder="Email" id="agent_email">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>                                            
                                        </div>
                                    </div>
                                    @else
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <input type="checkbox" name="is_agent" id="is_agent" {{($management->is_agent == 1 ? " checked" : "")}}/>
                                            <label><h4> Ejen</h4></label>
                                            <!-- agent Form -->
                                            <div id="agent_form">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Lantikan</label>
                                                            <select class="form-control" id="agent_selected_by">
                                                                <option value="">Sila pilih</option>                                                                
                                                                <option value="developer" {{($management_agent->selected_by == "developer" ? " selected" : "")}}>Pemaju</option>
                                                                <option value="cob" {{($management_agent->selected_by == "cob" ? " selected" : "")}}>COB</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Nama</label>
                                                            <select class="form-control" id="agent_name">
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
                                                            <input type="text" class="form-control" placeholder="Alamat 1" id="agent_address1" value="{{$management_agent->address1}}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" placeholder="Alamat 2" id="agent_address2" value="{{$management_agent->address2}}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" placeholder="Alamat 3" id="agent_address3" value="{{$management_agent->address3}}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Bandar</label>
                                                            <select class="form-control" id="agent_city">
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
                                                            <input type="text" class="form-control" placeholder="Poskod" id="agent_poscode" value="{{$management_agent->address1}}">
                                                        </div>
                                                    </div>
                                                </div> 
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Negeri</label>
                                                            <select class="form-control" id="agent_state">
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
                                                            <select class="form-control" id="agent_country">
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
                                                            <input type="text" class="form-control" placeholder="No. Telefon" id="agent_phone_no" value="{{$management_agent->phone_no}}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>No. Fax</label>
                                                            <input type="text" class="form-control" placeholder="No. Fax" id="agent_fax_no" value="{{$management_agent->fax_no}}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Email</label>
                                                            <input type="email" class="form-control" placeholder="Email" id="agent_email" value="{{$management_agent->email}}">
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
                                            <input type="checkbox" name="is_others" id="is_others"/>
                                            <label><h4> Pelbagai</h4></label>
                                            <!-- jmb Form -->
                                            <div id="other_form" style="display:none">                                                
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Nama</label>
                                                            <input type="text" class="form-control" placeholder="Nama" id="others_name">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            <label>Alamat</label>
                                                            <input type="text" class="form-control" placeholder="Alamat 1" id="others_address1">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" placeholder="Alamat 2" id="others_address2">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" placeholder="Alamat 3" id="others_address3">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Bandar</label>
                                                            <select class="form-control" id="others_city">
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
                                                            <input type="text" class="form-control" placeholder="Poskod" id="others_poscode">
                                                        </div>
                                                    </div>
                                                </div> 
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Negeri</label>
                                                            <select class="form-control" id="others_state">
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
                                                            <select class="form-control" id="others_country">
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
                                                            <input type="text" class="form-control" placeholder="No. Telefon" id="others_phone_no">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>No. Fax</label>
                                                            <input type="text" class="form-control" placeholder="No. Fax" id="others_fax_no">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Email</label>
                                                            <input type="email" class="form-control" placeholder="Email" id="others_email">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>                                            
                                        </div>
                                    </div>
                                    @else
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <input type="checkbox" name="is_others" id="is_others" {{($management->is_others == 1 ? " checked" : "")}}/>
                                            <label><h4> Pelbagai</h4></label>
                                            <!-- jmb Form -->
                                            <div id="other_form">                                                
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Nama</label>
                                                            <input type="text" class="form-control" placeholder="Nama" id="others_name" value="{{$management_others->name}}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            <label>Alamat</label>
                                                            <input type="text" class="form-control" placeholder="Alamat 1" id="others_address1" value="{{$management_others->address1}}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" placeholder="Alamat 2" id="others_address2" value="{{$management_others->address2}}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" placeholder="Alamat 3" id="others_address3" value="{{$management_others->address3}}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Bandar</label>
                                                            <select class="form-control" id="others_city">
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
                                                            <input type="text" class="form-control" placeholder="Poskod" id="others_poscode" value="{{$management_others->poscode}}">
                                                        </div>
                                                    </div>
                                                </div> 
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Negeri</label>
                                                            <select class="form-control" id="others_state">
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
                                                            <select class="form-control" id="others_country">
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
                                                            <input type="text" class="form-control" placeholder="No. Telefon" id="others_phone_no" value="{{$management_others->phone_no}}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>No. Fax</label>
                                                            <input type="text" class="form-control" placeholder="No. Fax" id="others_fax_no" value="{{$management_others->fax_no}}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Email</label>
                                                            <input type="email" class="form-control" placeholder="Email" id="others_email" value="{{$management_others->email}}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>                                            
                                        </div>
                                    </div>
                                    @endif
                                    <div class="form-actions">
                                        <?php if ($update_permission == 1) { ?>
                                        <button type="button" class="btn btn-primary" id="submit_button" onclick="updateManagement()">Hantar</button>
                                        <?php } ?>
                                        <button type="button" class="btn btn-default" id="cancel_button" onclick="window.location ='{{URL::action('AdminController@fileList')}}'">Batal</button>
                                    </div>
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
    
    function updateManagement() {
        $("#loading").css("display", "inline-block");
        
        //jmb
        var jmb_date_formed = $("#jmb_date_formed").val(),
                jmb_certificate_no = $("#jmb_certificate_no").val(),
                jmb_name = $("#jmb_name").val(),                
                jmb_address1 = $("#jmb_address1").val(),
                jmb_address2 = $("#jmb_address2").val(),
                jmb_address3 = $("#jmb_address3").val(),
                jmb_city = $("#jmb_city").val(),
                jmb_poscode = $("#jmb_poscode").val(),
                jmb_state = $("#jmb_state").val(),
                jmb_country = $("#jmb_country").val(),
                jmb_phone_no = $("#jmb_phone_no").val(),
                jmb_fax_no = $("#jmb_fax_no").val(),
                jmb_email = $("#jmb_email").val();
        
        //mc
        var mc_date_formed = $("#mc_date_formed").val(),
                mc_certificate_no = $("#mc_certificate_no").val(),
                mc_first_agm = $("#mc_first_agm").val(),
                mc_name = $("#mc_name").val(),                
                mc_address1 = $("#mc_address1").val(),
                mc_address2 = $("#mc_address2").val(),
                mc_address3 = $("#mc_address3").val(),
                mc_city = $("#mc_city").val(),
                mc_poscode = $("#mc_poscode").val(),
                mc_state = $("#mc_state").val(),
                mc_country = $("#mc_country").val(),
                mc_phone_no = $("#mc_phone_no").val(),
                mc_fax_no = $("#mc_fax_no").val(),
                mc_email = $("#mc_email").val();
        
        //agent
        var agent_selected_by = $("#agent_selected_by").val(), 
                agent_name = $("#agent_name").val(),                
                agent_address1 = $("#agent_address1").val(),
                agent_address2 = $("#agent_address2").val(),
                agent_address3 = $("#agent_address3").val(),
                agent_city = $("#agent_city").val(),
                agent_poscode = $("#agent_poscode").val(),
                agent_state = $("#agent_state").val(),
                agent_country = $("#agent_country").val(),
                agent_phone_no = $("#agent_phone_no").val(),
                agent_fax_no = $("#agent_fax_no").val(),
                agent_email = $("#agent_email").val();
        
        //others
        var others_name = $("#others_name").val(),                
                others_address1 = $("#others_address1").val(),
                others_address2 = $("#others_address2").val(),
                others_address3 = $("#others_address3").val(),
                others_city = $("#others_city").val(),
                others_poscode = $("#others_poscode").val(),
                others_state = $("#others_state").val(),
                others_country = $("#others_country").val(),
                others_phone_no = $("#others_phone_no").val(),
                others_fax_no = $("#others_fax_no").val(),
                others_email = $("#others_email").val(),
                is_jmb,
                is_mc,
                is_agent,
                is_others;
        
        if (document.getElementById('is_jmb').checked){
            is_jmb = 1;
        } else {
            is_jmb = 0;
        }
        if (document.getElementById('is_mc').checked){
            is_mc = 1;
        } else {
            is_mc = 0;
        }
        if (document.getElementById('is_agent').checked){
            is_agent = 1;
        } else {
            is_agent = 0;
        }
        if (document.getElementById('is_others').checked){
            is_others = 1;
        } else {
            is_others = 0;
        }

        var error = 0;

        if (error == 0) {
            $.ajax({
                url: "{{ URL::action('AdminController@submitUpdateManagement') }}",
                type: "POST",
                data: {
                    //jmb
                    is_jmb: is_jmb,
                    jmb_date_formed: jmb_date_formed,
                    jmb_certificate_no: jmb_certificate_no,
                    jmb_name: jmb_name,
                    jmb_address1: jmb_address1,
                    jmb_address2: jmb_address2,
                    jmb_address3: jmb_address3,
                    jmb_city: jmb_city,
                    jmb_poscode: jmb_poscode,
                    jmb_state: jmb_state,
                    jmb_country: jmb_country,
                    jmb_phone_no: jmb_phone_no,
                    jmb_fax_no: jmb_fax_no,
                    jmb_email: jmb_email,
                    //mc
                    is_mc: is_mc,
                    mc_date_formed: mc_date_formed,
                    mc_certificate_no: mc_certificate_no,
                    mc_first_agm: mc_first_agm,
                    mc_name: mc_name,
                    mc_address1: mc_address1,
                    mc_address2: mc_address2,
                    mc_address3: mc_address3,
                    mc_city: mc_city,
                    mc_poscode: mc_poscode,
                    mc_state: mc_state,
                    mc_country: mc_country,
                    mc_phone_no: mc_phone_no,
                    mc_fax_no: mc_fax_no,
                    mc_email: mc_email,
                    //agent
                    is_agent: is_agent,
                    agent_selected_by: agent_selected_by,
                    agent_name: agent_name,
                    agent_address1: agent_address1,
                    agent_address2: agent_address2,
                    agent_address3: agent_address3,
                    agent_city: agent_city,
                    agent_poscode: agent_poscode,
                    agent_state: agent_state,
                    agent_country: agent_country,
                    agent_phone_no: agent_phone_no,
                    agent_fax_no: agent_fax_no,
                    agent_email: agent_email,
                    //others
                    is_others: is_others,
                    others_name: others_name,
                    others_address1: others_address1,
                    others_address2: others_address2,
                    others_address3: others_address3,
                    others_city: others_city,
                    others_poscode: others_poscode,
                    others_state: others_state,
                    others_country: others_country,
                    others_phone_no: others_phone_no,
                    others_fax_no: others_fax_no,
                    others_email: others_email,
                    //id
                    management_id: '{{$management->id}}',
                    file_id: '{{$file->id}}'
                },
                success: function (data) {
                    $("#loading").css("display", "none");
                    $("#submit_button").removeAttr("disabled");
                    $("#cancel_button").removeAttr("disabled");
                    if (data.trim() == "true") {
                        $.notify({
                            message: '<p style="text-align: center; margin-bottom: 0px;">Disimpan</p>',
                        },{
                            type: 'success',
                            placement: {
                                align: "center"
                            }
                        }); 
                        window.location = "{{URL::action('AdminController@monitoring', $file->id)}}";                      
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