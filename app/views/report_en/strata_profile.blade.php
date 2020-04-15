@extends('layout.english_layout.default')

@section('content')

<?php
$facilities = [
    'management_office' => 'Management Office',
    'pool' => 'Pool',
    'surau' => 'Surau',
    'hall' => 'Hall',
    'gym' => 'Gym',
    'lift' => 'Lift',
    'playground' => 'Play Ground',
    'guardhouse' => 'Guardhouse',
    'kindergarten' => 'Kindergarten',
    'openspace' => 'Openspace',
    'rubbish_room' => 'Rubbish Room',
    'gated' => 'Gated'
];
?>

<div class="page-content-inner">
    <section class="panel panel-with-borders">
        <div class="panel-heading">
            <h3>{{$title}}</h3>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-lg-12">
                    <form id="formSubmit" class="form-horizontal">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label style="color: red; font-style: italic;">* Mandatory Fields</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Parliament</label>
                                    <select class="form-control select2" id="parliament" onchange="findDUN()">
                                        <option value="">Please Select</option>
                                        @foreach ($parliament as $parliaments)
                                        <option value="{{$parliaments->id}}">{{$parliaments->description}}</option>
                                        @endforeach
                                    </select>
                                    <div id="parliament_error" style="display:none;"></div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>DUN</label>
                                    <select class="form-control select2" id="dun" onchange="findPark()">
                                        <option value="">Please Select</option>   
                                    </select>
                                    <div id="dun_error" style="display:none;"></div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Park</label>
                                    <select class="form-control select2" id="park"> 
                                        <option value="">Please Select</option> 
                                    </select>
                                    <div id="park_error" style="display:none;"></div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Land Title</label>
                                    <select class="form-control select2" id="land">
                                        <option value="">Please Select</option>
                                        @foreach ($land as $f)
                                        <option value="{{$f->id}}">{{$f->description}}</option>
                                        @endforeach
                                    </select>
                                    <div id="land_error" style="display:none;"></div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Category</label>
                                    <select class="form-control select2" id="category">
                                        <option value="">Please Select</option>
                                        @foreach ($category as $f)
                                        <option value="{{$f->id}}">{{$f->description}}</option>
                                        @endforeach
                                    </select>
                                    <div id="category_error" style="display:none;"></div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Strata</label>
                                    <input type="text" class="form-control" id="strata">
                                    <div id="strata_error" style="display:none;"></div>
                                </div>
                            </div>  
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Export To</label>
                                    <select class="form-control select2" id="export">
                                        <option value="pdf">PDF</option>
                                    </select>
                                    <div id="export_error" style="display:none;"></div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Bantuan LPHS</label>
                                    <select class="form-control select2" id="bantuan_lhps">
                                        <option value="all">- ALL - </option>
                                        <option value="yes">Yes</option>
                                        <option value="no">No</option>
                                    </select>
                                    <div id="bantuan_lhps_error" style="display:none;"></div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group">
                                <div class="col-md-6">
                                    <label>Facility</label>
                                </div>
                                <div class="col-md-12">
                                    @foreach ($facilities as $value => $facility)
                                    <div class="col-md-3">
                                        <label class="checkbox-inline">
                                            <input type="checkbox" value="{{ $value }}" name="facility[]">{{ $facility }}
                                        </label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <button type="button" class="btn btn-default" id="cancel_button" onclick="window.location ='{{ URL::action("ReportController@strataProfile") }}'">Cancel</button>
                            <img id="loading" style="display:none;" src="{{asset('assets/common/img/input-spinner.gif')}}"/>
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
    $("#formSubmit").submit(function (e) {
        e.preventDefault();
        $("#loading").css("display", "inline-block");
        $("#submit_button").attr("disabled", "disabled");
        $("#cancel_button").attr("disabled", "disabled");

        let error = 0;

        if (error == 0) {
            $.ajax({
                url: "{{ URL::action('ReportController@submitStrataProfile') }}",
                type: "POST",
                data: $(this).serialize(),
                success: function (data) {
                    $("#loading").css("display", "none");
                    $("#submit_button").removeAttr("disabled");
                    $("#cancel_button").removeAttr("disabled");
                    if (data.trim() == "true") {
                        bootbox.alert("<span style='color:green;'>File submitted successfully!</span>", function () {
                            window.location = '{{URL::action("ReportController@strataProfile") }}';
                        });
                    } else {
                        bootbox.alert("<span style='color:red;'>An error occured while processing. Please try again.</span>");
                    }
                }
            });
        } else {
            $("#loading").css("display", "none");
            $("#submit_button").removeAttr("disabled");
            $("#cancel_button").removeAttr("disabled");
        }
    });

    function findDUN() {
        $.ajax({
            url: "{{URL::action('AdminController@findDUN')}}",
            type: "POST",
            data: {
                parliament_id: $("#parliament").val()
            },
            success: function (data) {
                $("#dun").html(data);
                $("#park").html("<option value=''>Please Select</option>");
            }
        });
    }

    function findPark() {
        $.ajax({
            url: "{{URL::action('AdminController@findPark')}}",
            type: "POST",
            data: {
                dun_id: $("#dun").val()
            },
            success: function (data) {
                $("#park").html(data);
            }
        });
    }
</script>
<!-- End Page Scripts-->

@stop