@extends('layout.english_layout.default')

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
                    <h6>File No: {{$file->file_no}}</h6>
                    <div id="update_files_lists">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active">Housing Scheme</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{URL::action('AdminController@viewStrata', $file->id)}}">Developed Area (STRATA)</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{URL::action('AdminController@viewManagement', $file->id)}}">Management</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{URL::action('AdminController@viewMonitoring', $file->id)}}">Monitoring</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{URL::action('AdminController@viewOthers', $file->id)}}">Others</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{URL::action('AdminController@viewScoring', $file->id)}}">Scoring Component Value</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{URL::action('AdminController@viewBuyer', $file->id)}}">Buyer List</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{URL::action('AdminController@fileApproval', $file->id)}}">Approval</a>
                            </li>
                        </ul>
                        <div class="tab-content padding-vertical-20">
                            <div class="tab-pane active" id="house_scheme" role="tabpanel">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <h4>Detail</h4>
                                        <!-- House Form -->
                                        <form id="house">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Name</label>
                                                        <input type="text" class="form-control" placeholder="Name" id="name" value="{{$house_scheme->name}}" readonly="">
                                                        <div id="name_error" style="display:none;"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Developer</label>
                                                        <select class="form-control" id="developer" disabled="">
                                                            <option value="">Please Select</option>
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
                                                        <label>Address</label>
                                                        <input type="text" class="form-control" placeholder="Address 1" id="address1" value="{{$house_scheme->address1}}" readonly="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" placeholder="Address 2" id="address2" value="{{$house_scheme->address2}}" readonly="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" placeholder="Address 3" id="address3" value="{{$house_scheme->address3}}" readonly="">
                                                        <div id="address_error" style="display:none;"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>City</label>
                                                        <select class="form-control" id="city" disabled="">
                                                            <option value="">Please Select</option>
                                                            @foreach ($city as $cities)
                                                            <option value="{{$cities->id}}" {{($house_scheme->city == $cities->id ? " selected" : "")}}>{{$cities->description}}</option>
                                                            @endforeach
                                                        </select>
                                                        <div id="city_error" style="display:none;"></div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Postcode</label>
                                                        <input type="text" class="form-control" placeholder="Postcode" id="poscode" value="{{$house_scheme->poscode}}" readonly="">
                                                        <div id="poscode_error" style="display:none;"></div>
                                                    </div>
                                                </div>
                                            </div> 
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>State</label>
                                                        <select class="form-control" id="state" disabled="">
                                                            <option value="">Please Select</option>
                                                            @foreach ($state as $states)
                                                            <option value="{{$states->id}}" {{($house_scheme->state == $states->id ? " selected" : "")}}>{{$states->name}}</option>
                                                            @endforeach
                                                        </select>
                                                        <div id="state_error" style="display:none;"></div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Country</label>
                                                        <select class="form-control" id="country" disabled="">
                                                            <option value="">Please Select</option>
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
                                                        <label>Phone Number</label>
                                                        <input type="text" class="form-control" placeholder="Phone Number" id="phone_no" value="{{$house_scheme->phone_no}}" readonly="">
                                                        <div id="phone_no_error" style="display:none;"></div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Fax Number</label>
                                                        <input type="text" class="form-control" placeholder="Fax Number" id="fax_no" value="{{$house_scheme->fax_no}}" readonly="">
                                                        <div id="fax_no_error" style="display:none;"></div>
                                                    </div>
                                                </div>
                                            </div> 
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Status</label>
                                                        <select id="is_active" class="form-control" disabled="">
                                                            <option value="">Please Select</option>
                                                            <option value="1" {{($house_scheme->is_active==1 ? " selected" : "")}}>Active</option>
                                                            <option value="0" {{($house_scheme->is_active==0 ? " selected" : "")}}>Inactive</option>
                                                        </select>
                                                        <div id="is_active_error" style="display:none;"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <div class="form-group">
                                                        <label>Remarks</label>
                                                        <textarea class="form-control" rows="3" id="remarks" readonly="">{{$house_scheme->remarks}}</textarea>
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