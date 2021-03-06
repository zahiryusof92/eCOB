@extends('layout.english_layout.default')

@section('content')

<div class="page-content-inner">
    <section class="panel panel-with-borders">
        <div class="panel-heading">
            <h3>{{$title}}</h3>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-lg-12">
                    <h6>File No: {{$files->file_no}}</h6>
                    <div id="update_files_lists">
                        <ul class="nav nav-pills nav-justified" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link" href="{{URL::action('AdminController@house', $files->id)}}">Housing Scheme</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{URL::action('AdminController@strata', $files->id)}}">Developed Area (STRATA)</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{URL::action('AdminController@management', $files->id)}}">Management</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{URL::action('AdminController@monitoring', $files->id)}}">Monitoring</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{URL::action('AdminController@others', $files->id)}}">Others</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{URL::action('AdminController@scoring', $files->id)}}">Scoring Component Value</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active">Buyer List</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{URL::action('AdminController@document', $files->id)}}">Document</a>
                            </li>
                        </ul>
                        <div class="tab-content padding-vertical-20">
                            <div class="tab-pane active" id="buyer_tab" role="tabpanel">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <!-- Buyer Form -->
                                        <form id="add_buyer">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label style="color: red; font-style: italic;">* Mandatory Fields</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label><span style="color: red;">*</span> Unit Number</label>
                                                        <input type="text" class="form-control" placeholder="Unit Number" id="unit_no">
                                                        <div id="unit_no_error" style="display:none;"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Unit Share</label>
                                                        <input type="text" class="form-control" placeholder="Unit Share" id="unit_share">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label><span style="color: red;">*</span> Owner Name</label>
                                                        <input type="text" class="form-control" placeholder="Owner Name" id="owner_name">
                                                        <div id="owner_name_error" style="display:none;"></div>
                                                    </div>
                                                </div>
                                            </div>                        
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>IC No / Company Number</label>
                                                        <input type="text" class="form-control" placeholder="IC No / Company Number" id="ic_company_no">
                                                        <div id="ic_company_no_error" style="display:none;"></div>
                                                    </div>
                                                </div>
                                            </div> 
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <div class="form-group">
                                                        <label>Address</label>
                                                        <textarea class="form-control" placeholder="Address" rows="3" id="address"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Phone Number</label>
                                                        <input type="text" class="form-control" placeholder="Phone Number" id="phone_no">
                                                    </div>
                                                </div>                            
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Email</label>
                                                        <input type="email" class="form-control" placeholder="Email" id="email">
                                                    </div>
                                                </div>                            
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label><span style="color: red;">*</span> Race</label>
                                                        <select id="race" class="form-control select2">
                                                            <option value="">Please select</option>
                                                            @foreach ($race as $races) 
                                                            <option value="{{ $races->id }}">{{ $races->name }}</option>
                                                            @endforeach
                                                        </select>
                                                        <div id="race_error" style="display:none;"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label><span style="color: red;">*</span> Nationality</label>
                                                        <select id="nationality" class="form-control select2">
                                                            <option value="">Please select</option>
                                                            @foreach ($nationality as $national) 
                                                            <option value="{{ $national->id }}">{{ $national->name }}</option>
                                                            @endforeach
                                                        </select>
                                                        <div id="nationality_error" style="display:none;"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <div class="form-group">
                                                        <label>Remarks</label>
                                                        <textarea class="form-control" placeholder="Remarks" rows="3" id="remarks"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-actions">
                                                <button type="button" class="btn btn-primary" id="submit_button" onclick="addBuyer()">Submit</button>
                                                <button type="button" class="btn btn-default" id="cancel_button" onclick="window.location ='{{URL::action('AdminController@buyer', $files->id)}}'">Cancel</button>
                                                <img id="loading" style="display:none;" src="{{asset('assets/common/img/input-spinner.gif')}}"/>
                                            </div>
                                        </form>
                                        <!-- End Form -->
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
    var changes = false;
    $('input, textarea, select').on('keypress change input', function () {
        changes = true;
    });

    $(window).on('beforeunload', function () {
        if (changes) {
            return "Data you have entered may not be saved, do you really want to leave?";
        }
    });
    
    function addBuyer() {
        changes = false;
        $("#submit_button").attr("disabled", "disabled");
        $("#unit_no_error").css("display", "none");
        $("#owner_name_error").css("display", "none");
        $("#race_error").css("display", "none");
        $("#nationality_error").css("display", "none");

        var unit_no = $("#unit_no").val(),
                unit_share = $("#unit_share").val(),
                owner_name = $("#owner_name").val(),
                ic_company_no = $("#ic_company_no").val(),
                address = $("#address").val(),
                phone_no = $("#phone_no").val(),
                email = $("#email").val(),
                race = $("#race").val(),
                nationality = $("#nationality").val(),
                remarks = $("#remarks").val();

        var error = 0;

        if (unit_no.trim() == "") {
            $("#unit_no_error").html('<span style="color:red;font-style:italic;font-size:13px;">Please enter Unit Number</span>');
            $("#unit_no_error").css("display", "block");
            error = 1;
        }
        if (owner_name.trim() == "") {
            $("#owner_name_error").html('<span style="color:red;font-style:italic;font-size:13px;">Please enter Owner Name</span>');
            $("#owner_name_error").css("display", "block");
            error = 1;
        }
        if (race.trim() == "") {
            $("#race_error").html('<span style="color:red;font-style:italic;font-size:13px;">Please select Race</span>');
            $("#race_error").css("display", "block");
            error = 1;
        }
        if (nationality.trim() == "") {
            $("#nationality_error").html('<span style="color:red;font-style:italic;font-size:13px;">Please select Nationality</span>');
            $("#nationality_error").css("display", "block");
            error = 1;
        }

        if (error == 0) {
            $.ajax({
                url: "{{ URL::action('AdminController@submitBuyer') }}",
                type: "POST",
                data: {
                    unit_no: unit_no,
                    unit_share: unit_share,
                    owner_name: owner_name,
                    ic_company_no: ic_company_no,
                    address: address,
                    phone_no: phone_no,
                    email: email,
                    remarks: remarks,
                    race: race,
                    nationality: nationality,
                    file_id: '{{$files->id}}'
                },
                success: function (data) {
                    $("#loading").css("display", "none");
                    $("#submit_button").removeAttr("disabled");
                    $("#cancel_button").removeAttr("disabled");
                    if (data.trim() == "true") {
                        $.notify({
                            message: '<p style="text-align: center; margin-bottom: 0px;">Successfully saved</p>',
                        }, {
                            type: 'success',
                            placement: {
                                align: "center"
                            }
                        });
                        location = '{{URL::action("AdminController@buyer", $files->id) }}';
                    } else {
                        bootbox.alert("<span style='color:red;'>An error occured while processing. Please try again.</span>");
                    }
                }
            });
        } else {
            $("#loading").css("display", "none");
            $("#submit_button").removeAttr("disabled");
        }
    }

    function IsEmail(email) {
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        return regex.test(email);
    }
</script>
<!-- End Page Scripts-->

@stop