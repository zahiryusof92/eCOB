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
                                <a class="nav-link active" href="{{URL::action('AdminController@strata', $file->id)}}">Kawasan Pemajuan (STRATA)</a>
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
                                <a class="nav-link" href="{{URL::action('AdminController@document', $file->id)}}">Document</a>
                            </li>
                        </ul>
                        <div class="tab-content padding-vertical-20">
                            <div class="tab-pane active" id="strata" role="tabpanel">                                
                                <!-- strata Form -->                                
                                <div class="row">
                                    <div class="col-lg-12">
                                        <h4>Butiran</h4>   
                                        <form id="strata">
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
                                                        <label><span style="color: red; font-style: italic;">* </span> Nama</label>
                                                        <input type="text" class="form-control" placeholder="Nama" id="strata_name" value="{{$strata->name}}">
                                                        <div id="strata_name_error" style="display:none;"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label><span style="color: red; font-style: italic;">* </span>Parlimen</label>
                                                        <select class="form-control" id="strata_parliament" onchange="findDUN()">
                                                            <option value="">Sila pilih</option>
                                                            @foreach ($parliament as $parliaments)
                                                            <option value="{{$parliaments->id}}" {{($strata->parliament == $parliaments->id ? " selected" : "")}}>{{$parliaments->description}}</option>
                                                            @endforeach
                                                        </select>
                                                        <div id="strata_parliament_error" style="display:none;"></div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label><span style="color: red; font-style: italic;">* </span>DUN</label>
                                                        <select class="form-control" id="strata_dun" onchange="findPark()">
                                                            <option value="">Sila pilih</option>                                                             
                                                            @foreach ($dun as $duns)
                                                            <option value="{{$duns->id}}" {{($strata->dun == $duns->id ? " selected" : "")}}>{{$duns->description}}</option>
                                                            @endforeach  
                                                        </select>
                                                        <div id="strata_dun_error" style="display:none;"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label><span style="color: red; font-style: italic;">* </span>Taman</label>
                                                        <select class="form-control" id="strata_park"> 
                                                            <option value="">Sila pilih</option>  
                                                            @foreach ($park as $parks)
                                                            <option value="{{$parks->id}}" {{($strata->park == $parks->id ? " selected" : "")}}>{{$parks->description}}</option>
                                                            @endforeach 
                                                        </select>
                                                        <div id="strata_park_error" style="display:none;"></div>
                                                    </div>
                                                </div>
                                            </div>                                      
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <div class="form-group">
                                                        <label>Alamat</label>
                                                        <input type="text" class="form-control" placeholder="Alamat 1" id="strata_address1" value="{{$strata->address1}}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" placeholder="Alamat 2" id="strata_address2" value="{{$strata->address2}}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" placeholder="Alamat 3" id="strata_address3" value="{{$strata->address3}}">
                                                        <div id="strata_address_error" style="display:none;"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Bandar</label>
                                                        <select class="form-control" id="strata_city">
                                                            <option value="">Sila pilih</option>
                                                            @foreach ($city as $cities)
                                                            <option value="{{$cities->id}}" {{($strata->city == $cities->id ? " selected" : "")}}>{{$cities->description}}</option>
                                                            @endforeach
                                                        </select>
                                                        <div id="strata_city_error" style="display:none;"></div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Poskod</label>
                                                        <input type="text" class="form-control" placeholder="Poskod" id="strata_poscode" value="{{$strata->poscode}}">
                                                        <div id="strata_poscode_error" style="display:none;"></div>
                                                    </div>
                                                </div>
                                            </div> 
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Negeri</label>
                                                        <select class="form-control" id="strata_state">
                                                            <option value="">Sila pilih</option>
                                                            @foreach ($state as $states)
                                                            <option value="{{$states->id}}" {{($strata->state == $states->id ? " selected" : "")}}>{{$states->name}}</option>
                                                            @endforeach
                                                        </select>
                                                        <div id="strata_state_error" style="display:none;"></div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Negara</label>
                                                        <select class="form-control" id="strata_country">
                                                            <option value="">Sila pilih</option>
                                                            @foreach ($country as $countries)
                                                            <option value="{{$countries->id}}" {{($strata->country == $countries->id ? " selected" : "")}}>{{$countries->name}}</option>
                                                            @endforeach
                                                        </select>
                                                        <div id="starta_country_error" style="display:none;"></div>
                                                    </div>
                                                </div>
                                            </div>        
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Bilangan Blok</label>
                                                        <input type="text" class="form-control" placeholder="Bilangan Blok" id="strata_block_no" value="{{$strata->block_no}}">
                                                        <div id="strata_block_no_error" style="display:none;"></div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>No. Hakmilik</label>
                                                        <input type="text" class="form-control" placeholder="No. Hakmilik" id="strata_ownership_no" value="{{$strata->ownership_no}}">
                                                        <div id="strata_ownership_no_error" style="display:none;"></div>
                                                    </div>
                                                </div>
                                            </div> 
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Bandar / Pekan / Mukim</label>
                                                        <select class="form-control" id="strata_town">
                                                            <option value="">Sila pilih</option>
                                                            @foreach ($city as $cities)
                                                            <option value="{{$cities->id}}" {{($strata->town == $cities->id ? " selected" : "")}}>{{$cities->description}}</option>
                                                            @endforeach
                                                        </select>
                                                        <div id="strata_town_error" style="display:none;"></div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Daerah</label>
                                                        <select class="form-control" id="strata_area">
                                                            <option value="">Sila pilih</option>
                                                            @foreach ($area as $areas)
                                                            <option value="{{$areas->id}}" {{($strata->area == $areas->id ? " selected" : "")}}>{{$areas->description}}</option>
                                                            @endforeach
                                                        </select>
                                                        <div id="strata_area_error" style="display:none;"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Luas Tanah</label>
                                                        <div class="form-inline">
                                                            <input type="text" class="form-control" placeholder="Luas Tanah" id="strata_land_area" value="{{$strata->land_area}}">                               
                                                            <select class="form-control" id="strata_land_area_unit">
                                                                @foreach ($unit as $units)
                                                                <option value="{{$units->id}}" {{($strata->land_area_unit == $units->id ? " selected" : "")}}>{{$units->description}} &nbsp;&nbsp;</option>
                                                                @endforeach
                                                            </select>
                                                            <div id="strata_land_area_error" style="display:none;"></div> 
                                                        </div> 
                                                    </div>
                                                </div>
                                            </div> 
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>No. Lot</label>
                                                        <input type="text" class="form-control" placeholder="No. Lot" id="strata_lot_no" value="{{$strata->lot_no}}">   
                                                        <div id="starta_lot_no_error" style="display:none;"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Tarikh (VP)</label>
                                                        <label class="input-group datepicker-only-init">
                                                            <input type="text" class="form-control" placeholder="Tarikh (VP)" id="strata_date" value="{{$strata->date}}"/>
                                                            <span class="input-group-addon">
                                                                <i class="icmn-calendar"></i>
                                                            </span>
                                                        </label>
                                                        <div id="strata_date_error" style="display:block;"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Jenis Tanah</label>
                                                        <select class="form-control" id="strata_land_title">
                                                            <option value="">Sila pilih</option>
                                                            @foreach ($land_title as $land_titles)
                                                            <option value="{{$land_titles->id}}" {{($strata->land_title == $land_titles->id ? " selected" : "")}}>{{$land_titles->description}}</option>
                                                            @endforeach
                                                        </select>
                                                        <div id="starta_land_title_error" style="display:none;"></div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Kategori</label>
                                                        <select class="form-control" id="strata_category">
                                                            <option value="">Sila pilih</option>
                                                            @foreach ($category as $categories)
                                                            <option value="{{$categories->id}}" {{($strata->category == $categories->id ? " selected" : "")}}>{{$categories->description}}</option>
                                                            @endforeach
                                                        </select>
                                                        <div id="starta_category_error" style="display:none;"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Perimeter</label>
                                                        <select class="form-control" id="strata_perimeter">
                                                            <option value="">Sila pilih</option>
                                                            @foreach ($perimeter as $perimeters)
                                                            <option value="{{$perimeters->id}}" {{($strata->perimeter == $perimeters->id ? " selected" : "")}}>{{$perimeters->description_my}}</option>
                                                            @endforeach
                                                        </select>
                                                        <div id="starta_perimeter_error" style="display:none;"></div>                                                        
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Total Share Unit</label>
                                                        <input type="text" class="form-control" placeholder="Total Share Unit" id="strata_total_share_unit" value="{{$strata->total_share_unit}}">                                                        
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>CCC No.</label>
                                                        <input type="text" class="form-control" placeholder="CCC No" id="strata_ccc_no" value="{{$strata->ccc_no}}">                                                        
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Date CCC</label>
                                                        <label class="input-group datepicker-only-init">
                                                            <input type="text" class="form-control" placeholder="Date CCC" id="strata_ccc_date" value="{{ ($strata->ccc_date != '0000-00-00' ? $strata->ccc_date : '') }}"/>
                                                            <span class="input-group-addon">
                                                                <i class="icmn-calendar"></i>
                                                            </span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                        <form id="upload_strata_file" enctype="multipart/form-data" method="post" action="{{ url('uploadStrataFile') }}" autocomplete="off">                                           
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Muat Naik Fail</label>
                                                        <br/>
                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                                        <button type="button" id="clear_strata_file" class="btn btn-xs btn-danger" onclick="clearStrataFile()" style="display: none;"><i class="fa fa-times"></i></button>                                                        
                                                        &nbsp;<input type="file" name="strata_file" id="strata_file" /> 
                                                        <div id="validation-errors_strata_file"></div>
                                                        @if ($strata->file_url != "")
                                                        <br/>
                                                        <a href="{{asset($strata->file_url)}}" target="_blank"><button button type="button" class="btn btn-xs btn-primary" data-toggle="tooltip" data-placement="bottom" title="Download File"><i class="icmn-file-download2"></i> Download</button></a>
                                                        <?php if ($update_permission == 1) { ?>
                                                        <button type="button" class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="bottom" title="Padam Fail" onclick="deleteStrataFile('{{$strata->id}}')"><i class="fa fa-times"></i></button>
                                                        <?php } ?>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>                                            
                                        </form>
                                    </div>
                                </div>
                                <hr/>
                                <form>
                                    @if (count($residential) <= 0)
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <input type="checkbox" name="residential" id="residential"/>
                                            <label><h4> Blok kediaman</h4></label>
                                            <!-- residential Form -->
                                            <div id="residential_form" style="display:none">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Bilangan Unit Kediaman</label>
                                                            <input type="text" class="form-control" placeholder="Bilangan Unit Kediaman" id="residential_unit_no">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Caj Selenggaran (RM)</label>
                                                            <div class="form-inline">
                                                                <input type="text" class="form-control" placeholder="Caj Selenggaran (RM)" id="residential_maintenance_fee">                               
                                                                <select class="form-control" id="residential_maintenance_fee_option">
                                                                    @foreach ($unitoption as $unitoptions)
                                                                    <option value="{{$unitoptions->id}}">{{$unitoptions->description}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Sinking Fund (RM)</label>
                                                            <div class="form-inline">
                                                                <input type="text" class="form-control" placeholder="Sinking Fund (RM)" id="residential_sinking_fund">                              
                                                                <select class="form-control" id="residential_sinking_fund_option">
                                                                    @foreach ($unitoption as $unitoptions)
                                                                    <option value="{{$unitoptions->id}}">{{$unitoptions->description}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>                                            
                                        </div>
                                    </div>
                                    <hr/>
                                    @else
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <input type="checkbox" name="residential" id="residential" {{($strata->is_residential == 1 ? " checked" : "")}}/>
                                            <label><h4> Blok kediaman</h4></label>
                                            <!-- residential Form -->
                                            <div id="residential_form">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Bilangan Unit Kediaman</label>
                                                            <input type="text" class="form-control" placeholder="Bilangan Unit Kediaman" id="residential_unit_no" value="{{$residential->unit_no}}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Caj Selenggaran (RM)</label>
                                                            <div class="form-inline">
                                                                <input type="text" class="form-control" placeholder="Caj Selenggaran (RM)" id="residential_maintenance_fee" value="{{$residential->maintenance_fee}}">                               
                                                                <select class="form-control" id="residential_maintenance_fee_option">
                                                                    @foreach ($unitoption as $unitoptions)
                                                                    <option value="{{$unitoptions->id}}" {{($residential->maintenance_fee_option == $unitoptions->id ? " selected" : "")}}>{{$unitoptions->description}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Sinking Fund (RM)</label>
                                                            <div class="form-inline">
                                                                <input type="text" class="form-control" placeholder="Sinking Fund (RM)" id="residential_sinking_fund" value="{{$residential->sinking_fund}}">                              
                                                                <select class="form-control" id="residential_sinking_fund_option">
                                                                    @foreach ($unitoption as $unitoptions)
                                                                    <option value="{{$unitoptions->id}}" {{($residential->sinking_fund_option == $unitoptions->id ? " selected" : "")}}>{{$unitoptions->description}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>                                    
                                    <hr/>
                                    @endif
                                    @if (count($commercial) <= 0)
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <input type="checkbox" name="commercial" id="commercial"/>
                                            <label><h4> Jenis Blok Komersial</h4></label>
                                            <!-- residential Form -->
                                            <div id="commercial_form" style="display:none">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Bilangan Unit Komersial</label>
                                                            <input type="text" class="form-control" placeholder="Bilangan Unit Komersial" id="commercial_unit_no">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Caj Selenggaran (RM)</label>
                                                            <div class="form-inline">
                                                                <input type="text" class="form-control" placeholder="Caj Selenggaran (RM)" id="commercial_maintenance_fee">                               
                                                                <select class="form-control" id="commercial_maintenance_fee_option">
                                                                    @foreach ($unitoption as $unitoptions)
                                                                    <option value="{{$unitoptions->id}}">{{$unitoptions->description}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Sinking Fund (RM)</label>
                                                            <div class="form-inline">
                                                                <input type="text" class="form-control" placeholder="Sinking Fund (RM)" id="commercial_sinking_fund">                              
                                                                <select class="form-control" id="commercial_sinking_fund_option">
                                                                    @foreach ($unitoption as $unitoptions)
                                                                    <option value="{{$unitoptions->id}}">{{$unitoptions->description}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr/>
                                    @else
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <input type="checkbox" name="commercial" id="commercial" {{($strata->is_commercial == 1 ? " checked" : "")}}/>
                                            <label><h4> Jenis Blok Komersial</h4></label>
                                            <!-- residential Form -->
                                            <div id="commercial_form">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Bilangan Unit Komersial</label>
                                                            <input type="text" class="form-control" placeholder="Bilangan Unit Komersial" id="commercial_unit_no" value="{{$commercial->unit_no}}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Caj Selenggaran (RM)</label>
                                                            <div class="form-inline">
                                                                <input type="text" class="form-control" placeholder="Caj Selenggaran (RM)" id="commercial_maintenance_fee" value="{{$commercial->maintenance_fee}}">                               
                                                                <select class="form-control" id="commercial_maintenance_fee_option">
                                                                    @foreach ($unitoption as $unitoptions)
                                                                    <option value="{{$unitoptions->id}}" {{($commercial->maintenance_fee_option == $unitoptions->id ? " selected" : "")}}>{{$unitoptions->description}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Sinking Fund (RM)</label>
                                                            <div class="form-inline">
                                                                <input type="text" class="form-control" placeholder="Sinking Fund (RM)" id="commercial_sinking_fund" value="{{$commercial->sinking_fund}}">                              
                                                                <select class="form-control" id="commercial_sinking_fund_option">
                                                                    @foreach ($unitoption as $unitoptions)
                                                                    <option value="{{$unitoptions->id}}" {{($commercial->sinking_fund_option == $unitoptions->id ? " selected" : "")}}>{{$unitoptions->description}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr/>
                                    @endif
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <h4>Fasiliti / Kemudahan Bersama</h4>
                                            <div class="form-group row">
                                                <div class="col-md-2">
                                                    <label class="form-control-label">Pejabat Pengurusan</label>
                                                </div>
                                                <div class="col-md-1">
                                                    <input type="radio" id="management_office" name="management_office" value="1" {{($facility->management_office == 1 ? " checked" : "")}}>
                                                    Ada
                                                </div>
                                                <div class="col-md-1">
                                                    <input type="radio" id="management_office" name="management_office" value="0" {{($facility->management_office == 0 ? " checked" : "")}}>
                                                    Tiada
                                                </div>
                                                <div class="col-md-1">
                                                    <select class="form-control select2" id="management_office_unit">
                                                        @for ($x = 0; $x <= 50; $x++)
                                                        <option value="{{ $x }}" {{ ($facility->management_office_unit == $x ? 'selected' : '') }}>{{ $x }}</option>
                                                        @endfor
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-2">
                                                    <label class="form-control-label">Kolam Renang</label>
                                                </div>
                                                <div class="col-md-1">
                                                    <input type="radio" id="swimming_pool" name="swimming_pool" value="1" {{($facility->swimming_pool == 1 ? " checked" : "")}}>
                                                    Ada
                                                </div>
                                                <div class="col-md-1">
                                                    <input type="radio" id="swimming_pool" name="swimming_pool" value="0" {{($facility->swimming_pool == 0 ? " checked" : "")}}>
                                                    Tiada
                                                </div>
                                                <div class="col-md-1">
                                                    <select class="form-control select2" id="swimming_pool_unit">
                                                        @for ($x = 0; $x <= 50; $x++)
                                                        <option value="{{ $x }}" {{ ($facility->swimming_pool_unit == $x ? 'selected' : '') }}>{{ $x }}</option>
                                                        @endfor
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-2">
                                                    <label class="form-control-label">Surau</label>
                                                </div>
                                                <div class="col-md-1">
                                                    <input type="radio" id="surau" name="surau" value="1" {{($facility->surau == 1 ? " checked" : "")}}>
                                                    Ada
                                                </div>
                                                <div class="col-md-1">
                                                    <input type="radio" id="surau" name="surau" value="0" {{($facility->surau == 0 ? " checked" : "")}}>
                                                    Tiada
                                                </div>
                                                <div class="col-md-1">
                                                    <select class="form-control select2" id="surau_unit">
                                                        @for ($x = 0; $x <= 50; $x++)
                                                        <option value="{{ $x }}" {{ ($facility->surau_unit == $x ? 'selected' : '') }}>{{ $x }}</option>
                                                        @endfor
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-2">
                                                    <label class="form-control-label">Dewan Serbaguna</label>
                                                </div>
                                                <div class="col-md-1">
                                                    <input type="radio" id="multipurpose_hall" name="multipurpose_hall" value="1" {{($facility->multipurpose_hall == 1 ? " checked" : "")}}>
                                                    Ada
                                                </div>
                                                <div class="col-md-1">
                                                    <input type="radio" id="multipurpose_hall" name="multipurpose_hall" value="0" {{($facility->multipurpose_hall == 0 ? " checked" : "")}}>
                                                    Tiada
                                                </div>
                                                <div class="col-md-1">
                                                    <select class="form-control select2" id="multipurpose_hall_unit">
                                                        @for ($x = 0; $x <= 50; $x++)
                                                        <option value="{{ $x }}" {{ ($facility->multipurpose_hall_unit == $x ? 'selected' : '') }}>{{ $x }}</option>
                                                        @endfor
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-2">
                                                    <label class="form-control-label">Gym</label>
                                                </div>
                                                <div class="col-md-1">
                                                    <input type="radio" id="gym" name="gym" value="1" {{($facility->gym == 1 ? " checked" : "")}}>
                                                    Ada
                                                </div>
                                                <div class="col-md-1">
                                                    <input type="radio" id="gym" name="gym" value="0" {{($facility->gym == 0 ? " checked" : "")}}>
                                                    Tiada
                                                </div>
                                                <div class="col-md-1">
                                                    <select class="form-control select2" id="gym_unit">
                                                        @for ($x = 0; $x <= 50; $x++)
                                                        <option value="{{ $x }}" {{ ($facility->gym_unit == $x ? 'selected' : '') }}>{{ $x }}</option>
                                                        @endfor
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-2">
                                                    <label class="form-control-label">Taman permainan</label>
                                                </div>
                                                <div class="col-md-1">
                                                    <input type="radio" id="playground" name="playground" value="1" {{($facility->playground == 1 ? " checked" : "")}}>
                                                    Ada
                                                </div>
                                                <div class="col-md-1">
                                                    <input type="radio" id="playground" name="playground" value="0" {{($facility->playground == 0 ? " checked" : "")}}>
                                                    Tiada
                                                </div>
                                                <div class="col-md-1">
                                                    <select class="form-control select2" id="playground_unit">
                                                        @for ($x = 0; $x <= 50; $x++)
                                                        <option value="{{ $x }}" {{ ($facility->playground_unit == $x ? 'selected' : '') }}>{{ $x }}</option>
                                                        @endfor
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-2">
                                                    <label class="form-control-label">Pondok Pengawal</label>
                                                </div>
                                                <div class="col-md-1">
                                                    <input type="radio" id="guardhouse" name="guardhouse" value="1" {{($facility->guardhouse == 1 ? " checked" : "")}}>
                                                    Ada
                                                </div>
                                                <div class="col-md-1">
                                                    <input type="radio" id="guardhouse" name="guardhouse" value="0" {{($facility->guardhouse == 0 ? " checked" : "")}}>
                                                    Tiada
                                                </div>
                                                <div class="col-md-1">
                                                    <select class="form-control select2" id="guardhouse_unit">
                                                        @for ($x = 0; $x <= 50; $x++)
                                                        <option value="{{ $x }}" {{ ($facility->guardhouse_unit == $x ? 'selected' : '') }}>{{ $x }}</option>
                                                        @endfor
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-2">
                                                    <label class="form-control-label">Tadika</label>
                                                </div>
                                                <div class="col-md-1">
                                                    <input type="radio" id="kindergarten" name="kindergarten" value="1" {{($facility->kindergarten == 1 ? " checked" : "")}}>
                                                    Ada
                                                </div>
                                                <div class="col-md-1">
                                                    <input type="radio" id="kindergarten" name="kindergarten" value="0" {{($facility->kindergarten == 0 ? " checked" : "")}}>
                                                    Tiada
                                                </div>
                                                <div class="col-md-1">
                                                    <select class="form-control select2" id="kindergarten_unit">
                                                        @for ($x = 0; $x <= 50; $x++)
                                                        <option value="{{ $x }}" {{ ($facility->kindergarten_unit == $x ? 'selected' : '') }}>{{ $x }}</option>
                                                        @endfor
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-2">
                                                    <label class="form-control-label">Kawasan Lapang</label>
                                                </div>
                                                <div class="col-md-1">
                                                    <input type="radio" id="open_space" name="open_space" value="1" {{($facility->open_space == 1 ? " checked" : "")}}>
                                                    Ada
                                                </div>
                                                <div class="col-md-1">
                                                    <input type="radio" id="open_space" name="open_space" value="0" {{($facility->open_space == 0 ? " checked" : "")}}>
                                                    Tiada
                                                </div>
                                                <div class="col-md-1">
                                                    <select class="form-control select2" id="open_space_unit">
                                                        @for ($x = 0; $x <= 50; $x++)
                                                        <option value="{{ $x }}" {{ ($facility->open_space_unit == $x ? 'selected' : '') }}>{{ $x }}</option>
                                                        @endfor
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-2">
                                                    <label class="form-control-label">Lif</label>
                                                </div>
                                                <div class="col-md-1">
                                                    <input type="radio" id="lift" name="lift" value="1" {{($facility->lift == 1 ? " checked" : "")}}>
                                                    Ada
                                                </div>
                                                <div class="col-md-1">
                                                    <input type="radio" id="lift" name="lift" value="0" {{($facility->lift == 0 ? " checked" : "")}}>
                                                    Tiada
                                                </div>
                                                <div class="col-md-1">
                                                    <select class="form-control select2" id="lift_unit">
                                                        @for ($x = 0; $x <= 50; $x++)
                                                        <option value="{{ $x }}" {{ ($facility->lift_unit == $x ? 'selected' : '') }}>{{ $x }}</option>
                                                        @endfor
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-2">
                                                    <label class="form-control-label">Bilik Sampah</label>
                                                </div>
                                                <div class="col-md-1">
                                                    <input type="radio" id="rubbish_room" name="rubbish_room" value="1" {{($facility->rubbish_room == 1 ? " checked" : "")}}>
                                                    Ada
                                                </div>
                                                <div class="col-md-1">
                                                    <input type="radio" id="rubbish_room" name="rubbish_room" value="0" {{($facility->rubbish_room == 0 ? " checked" : "")}}>
                                                    Tiada
                                                </div>
                                                <div class="col-md-1">
                                                    <select class="form-control select2" id="rubbish_room_unit">
                                                        @for ($x = 0; $x <= 50; $x++)
                                                        <option value="{{ $x }}" {{ ($facility->rubbish_room_unit == $x ? 'selected' : '') }}>{{ $x }}</option>
                                                        @endfor
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-2">
                                                    <label class="form-control-label">Berpagar</label>
                                                </div>
                                                <div class="col-md-1">
                                                    <input type="radio" id="gated" name="gated" value="1" {{($facility->gated == 1 ? " checked" : "")}}>
                                                    Ada
                                                </div>
                                                <div class="col-md-1">
                                                    <input type="radio" id="gated" name="gated" value="0" {{($facility->gated == 0 ? " checked" : "")}}>
                                                    Tiada
                                                </div>
                                                <div class="col-md-1">
                                                    <select class="form-control select2" id="gated_unit">
                                                        @for ($x = 0; $x <= 50; $x++)
                                                        <option value="{{ $x }}" {{ ($facility->gated_unit == $x ? 'selected' : '') }}>{{ $x }}</option>
                                                        @endfor
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-2">
                                                    <label class="form-control-label">Pelbagai</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <textarea class="form-control" rows="3" id="others" placeholder="Pelbagai">{{$facility->others}}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-actions">
                                        <input type="hidden" id="strata_file_url" value="{{$strata->file_url}}"/>
                                        <?php if ($update_permission == 1) { ?>
                                        <button type="button" class="btn btn-primary" id="submit_button" onclick="updateStrata()">Simpan</button>
                                        <?php } ?>
                                        <button type="button" class="btn btn-default" id="cancel_button" onclick="window.location ='{{URL::action('AdminController@fileList')}}'">Batal</button>
                                    </div>
                                </form>
                            </div>
                            <!-- End Form -->
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
    $(document).ready(function () {
        //upload
        var options = {
            beforeSubmit: showRequest,
            success: showResponse,
            dataType: 'json'
        };

        $('body').delegate('#strata_file', 'change', function () {
            $('#upload_strata_file').ajaxForm(options).submit();
        });
    });

    //upload strata file
    function showRequest(formData, jqForm, options) {
        $("#validation-errors_strata_file").hide().empty();
        return true;
    }
    
    function showResponse(response, statusText, xhr, $form) {
        if (response.success == false)
        {
            var arr = response.errors;
            $.each(arr, function (index, value)
            {
                if (value.length != 0)
                {
                    $("#validation-errors_strata_file").append('<div class="alert alert-error"><strong>' + value + '</strong><div>');
                }
            });
            $("#validation-errors_strata_file").show();
            $("#strata_file").css("color", "red");
        } else {
            $("#clear_strata_file").show();
            $("#validation-errors_strata_file").html("<i class='fa fa-check' id='check_strata_file' style='color:green;'></i>");
            $("#validation-errors_strata_file").show();
            $("#strata_file").css("color", "green");
            $("#strata_file_url").val(response.file);
        }
    }

    $(function () {
        $('#strata_date, #strata_ccc_date').datetimepicker({
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
        $('#residential').click(function () {
            if ($(this).is(':checked')) {
                $("#residential_form").fadeIn(500);
            } else {
                $("#residential_form").fadeOut(0);
            }
        });
        $('#commercial').click(function () {
            if ($(this).is(':checked')) {
                $("#commercial_form").fadeIn(500);
            } else {
                $("#commercial_form").fadeOut(0);
            }
        });
    });

    function updateStrata() {
        $("#loading").css("display", "inline-block");

        var strata_name = $("#strata_name").val(),
                strata_parliament = $("#strata_parliament").val(),
                strata_dun = $("#strata_dun").val(),
                strata_park = $("#strata_park").val(),
                strata_address1 = $("#strata_address1").val(),
                strata_address2 = $("#strata_address2").val(),
                strata_address3 = $("#strata_address3").val(),
                strata_city = $("#strata_city").val(),
                strata_poscode = $("#strata_poscode").val(),
                strata_state = $("#strata_state").val(),
                strata_country = $("#strata_country").val(),
                strata_block_no = $("#strata_block_no").val(),
                strata_ownership_no = $("#strata_ownership_no").val(),
                strata_town = $("#strata_town").val(),
                strata_land_area = $("#strata_land_area").val(),
                strata_land_area_unit = $("#strata_land_area_unit").val(),
                strata_lot_no = $("#strata_lot_no").val(),
                strata_date = $("#strata_date").val(),
                strata_land_title = $("#strata_land_title").val(),
                strata_category = $("#strata_category").val(),
                strata_perimeter = $("#strata_perimeter").val(),
                strata_area = $("#strata_area").val(),
                strata_file_url = $("#strata_file_url").val(),
                strata_total_share_unit = $("#strata_total_share_unit").val(),
                strata_ccc_no = $("#strata_ccc_no").val(),
                strata_ccc_date = $("#strata_ccc_date").val(),
                //residential
                residential_unit_no = $("#residential_unit_no").val(),
                residential_maintenance_fee = $("#residential_maintenance_fee").val(),
                residential_maintenance_fee_option = $("#residential_maintenance_fee_option").val(),
                residential_sinking_fund = $("#residential_sinking_fund").val(),
                residential_sinking_fund_option = $("#residential_sinking_fund_option").val(),
                //commercial
                commercial_unit_no = $("#commercial_unit_no").val(),
                commercial_maintenance_fee = $("#commercial_maintenance_fee").val(),
                commercial_maintenance_fee_option = $("#commercial_maintenance_fee_option").val(),
                commercial_sinking_fund = $("#commercial_sinking_fund").val(),
                commercial_sinking_fund_option = $("#commercial_sinking_fund_option").val(),
                //facility
                management_office = $("#management_office:checked").val(),
                management_office_unit = $("#management_office_unit").val(),
                swimming_pool = $("#swimming_pool:checked").val(),
                swimming_pool_unit = $("#swimming_pool_unit").val(),
                surau = $("#surau:checked").val(),
                surau_unit = $("#surau_unit").val(),
                gym = $("#gym:checked").val(),
                gym_unit = $("#gym_unit").val(),
                playground = $("#playground:checked").val(),
                playground_unit = $("#playground_unit").val(),
                multipurpose_hall = $("#multipurpose_hall:checked").val(),
                multipurpose_hall_unit = $("#multipurpose_hall_unit").val(),
                guardhouse = $("#guardhouse:checked").val(),
                guardhouse_unit = $("#guardhouse_unit").val(),
                kindergarten = $("#kindergarten:checked").val(),
                kindergarten_unit = $("#kindergarten_unit").val(),
                open_space = $("#open_space:checked").val(),
                open_space_unit = $("#open_space_unit").val(),
                lift = $("#lift:checked").val(),
                lift_unit = $("#lift_unit").val(),
                rubbish_room = $("#rubbish_room:checked").val(),
                rubbish_room_unit = $("#rubbish_room_unit").val(),
                gated = $("#gated:checked").val(),
                gated_unit = $("#gated_unit").val(),
                others = $("#others").val();

        var is_commercial;
        var is_residential;
        if (document.getElementById('residential').checked) {
            is_residential = 1;
        } else {
            is_residential = 0;
        }
        if (document.getElementById('commercial').checked) {
            is_commercial = 1;
        } else {
            is_commercial = 0;
        }

        var error = 0;
        
        if (strata_name.trim() == "") {
            $("#strata_name_error").html('<span style="color:red;font-style:italic;font-size:13px;">Sila masukkan Nama</span>');
            $("#strata_name_error").css("display", "block");
            error = 1;
        }
        if (strata_parliament.trim() == "") {
            $("#strata_parliament_error").html('<span style="color:red;font-style:italic;font-size:13px;">Sila pilih Parlimen</span>');
            $("#strata_parliament_error").css("display", "block");
            error = 1;
        }
        if (strata_dun.trim() == "") {
            $("#strata_dun_error").html('<span style="color:red;font-style:italic;font-size:13px;">Sila pilih DUN</span>');
            $("#strata_dun_error").css("display", "block");
            error = 1;
        }
        if (strata_park.trim() == "") {
            $("#strata_park_error").html('<span style="color:red;font-style:italic;font-size:13px;">Sila pilih Taman</span>');
            $("#strata_park_error").css("display", "block");
            error = 1;
        }

        if (error == 0) {
            $.ajax({
                url: "{{ URL::action('AdminController@submitUpdateStrata') }}",
                type: "POST",
                data: {
                    file_id: '{{$file->id}}',
                    strata_name: strata_name,
                    strata_parliament: strata_parliament,
                    strata_dun: strata_dun,
                    strata_park: strata_park,
                    strata_address1: strata_address1,
                    strata_address2: strata_address2,
                    strata_address3: strata_address3,
                    strata_city: strata_city,
                    strata_poscode: strata_poscode,
                    strata_state: strata_state,
                    strata_country: strata_country,
                    strata_block_no: strata_block_no,
                    strata_ownership_no: strata_ownership_no,
                    strata_town: strata_town,
                    strata_land_area: strata_land_area,
                    strata_land_area_unit: strata_land_area_unit,
                    strata_lot_no: strata_lot_no,
                    strata_date: strata_date,
                    strata_land_title: strata_land_title,
                    strata_category: strata_category,
                    strata_perimeter: strata_perimeter,
                    strata_area: strata_area,
                    strata_total_share_unit: strata_total_share_unit,
                    strata_ccc_no: strata_ccc_no,
                    strata_ccc_date: strata_ccc_date,
                    is_residential: is_residential,
                    is_commercial: is_commercial,
                    strata_file_url: strata_file_url,
                    strata_id: '{{$strata->id}}',
                    //residential                    
                    residential_unit_no: residential_unit_no,
                    residential_maintenance_fee: residential_maintenance_fee,
                    residential_maintenance_fee_option: residential_maintenance_fee_option,
                    residential_sinking_fund: residential_sinking_fund,
                    residential_sinking_fund_option: residential_sinking_fund_option,
                    //commercial                    
                    commercial_unit_no: commercial_unit_no,
                    commercial_maintenance_fee: commercial_maintenance_fee,
                    commercial_maintenance_fee_option: commercial_maintenance_fee_option,
                    commercial_sinking_fund: commercial_sinking_fund,
                    commercial_sinking_fund_option: commercial_sinking_fund_option,
                    //facility
                    management_office: management_office,
                    management_office_unit: management_office_unit,
                    swimming_pool: swimming_pool,
                    swimming_pool_unit: swimming_pool_unit,
                    surau: surau,
                    surau_unit: surau_unit,
                    multipurpose_hall: multipurpose_hall,
                    multipurpose_hall_unit: multipurpose_hall_unit,
                    gym: gym,
                    gym_unit: gym_unit,
                    playground: playground,
                    playground_unit: playground_unit,
                    guardhouse: guardhouse,
                    guardhouse_unit: guardhouse_unit,
                    kindergarten: kindergarten,
                    kindergarten_unit: kindergarten_unit,
                    open_space: open_space,
                    open_space_unit: open_space_unit,
                    lift: lift,
                    lift_unit: lift_unit,
                    rubbish_room: rubbish_room,
                    rubbish_room_unit: rubbish_room_unit,
                    gated: gated,
                    gated_unit: gated_unit,
                    others: others,
                    facility_id: '{{$facility->id}}'
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
                        window.location = "{{URL::action('AdminController@management', $file->id)}}";                        
                    } else {
                        bootbox.alert("<span style='color:red;'>Terdapat masalah ketika prosess. Sila cuba lagi.</span>");
                    }
                }
            });
        }
    }
    
    function findDUN() {
        $.ajax({
            url: "{{URL::action('AdminController@findDUN')}}",
            type: "POST",
            data: {
                parliament_id: $("#strata_parliament").val()
            },
            success: function (data) {
                $("#strata_dun").html(data);
                $("#strata_park").html("<option value=''>Sila pilih</option>");
            }
        });
    }
    
    function findPark() {
        $.ajax({
            url: "{{URL::action('AdminController@findPark')}}",
            type: "POST",
            data: {
                dun_id: $("#strata_dun").val()
            },
            success: function (data) {
                $("#strata_park").html(data);
            }
        });
    }
    
    function deleteStrataFile(id) {
        swal({
            title: "Anda pasti?",
            text: "Your will not be able to recover this file!",
            type: "warning",
            showCancelButton: true,            
            confirmButtonClass: "btn-warning",
            cancelButtonClass: "btn-default",
            confirmButtonText: "Delete",
            closeOnConfirm: true
        },function(){
            $.ajax({
                url: "{{ URL::action('AdminController@deleteStrataFile') }}",
                type: "POST",
                data: {
                    id: id
                },
                success: function(data) {
                    if (data.trim() == "true") {
                        swal({
                            title: "Dipadam!",
                            text: "Fail berjaya dipadam",
                            type: "success",
                            confirmButtonClass: "btn-success",
                            closeOnConfirm: false
                        });
                        location.reload();
                    } else {
                        bootbox.alert("<span style='color:red;'>Terdapat masalah ketika prosess. Sila cuba lagi.</span>");
                    }
                }
            });
        });
    }
    
    function clearStrataFile() {
        $("#strata_file").val("");
        $("#clear_strata_file").hide();
        $("#strata_file").css("color", "grey");
        $("#check_strata_file").hide();
    }
</script>
<!-- End Page Scripts-->

@stop