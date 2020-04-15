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
                    <form action="{{ url('/reporting/submitOwnerTenant') }}" method="POST" class="form-horizontal">
                    <!--<form id="ownerTenant" class="form-horizontal">-->
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
                                    <label>File No</label>
                                    <select class="form-control select2" id="file_no" name="file_no">
                                        <option value="">Please Select</option>
                                        @foreach ($files as $file)
                                        <option value="{{$file->id}}">{{$file->file_no}}</option>
                                        @endforeach
                                    </select>
                                    <div id="file_no_error" style="display:none;"></div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Type</label>
                                    <select class="form-control select2" id="type" name="type">
                                        <option value="">Please Select</option>
                                        <option value="owner">Owner</option>
                                        <option value="tenant">Tenant</option>
                                    </select>
                                    <div id="type_error" style="display:none;"></div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Race</label>
                                    <select class="form-control select2" id="race" name="race">
                                        <option value="">Please Select</option>
                                        @foreach ($race as $races)
                                        <option value="{{$races->id}}">{{$races->name}}</option>
                                        @endforeach
                                    </select>
                                    <div id="race_error" style="display:none;"></div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Export To</label>
                                    <select class="form-control select2" id="export" name="export">
                                        <option value="pdf">PDF</option>
                                    </select>
                                    <div id="export_error" style="display:none;"></div>
                                </div>
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary" id="submit_button">Submit</button>
                            <button type="button" class="btn btn-default" id="cancel_button" onclick="location.reload();">Cancel</button>
                            <img id="loading" style="display: none;" src="{{asset('assets/common/img/input-spinner.gif')}}"/>
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
    $("#ownerTenant").submit(function (e) {
        e.preventDefault();
        $("#loading").css("display", "inline-block");
        $("#submit_button").attr("disabled", "disabled");
        $("#cancel_button").attr("disabled", "disabled");

        var file_no = $("#file_no").val(),
                type = $("#type").val(),
                race = $("#race").val();

        var error = 0;

        if (file_no.trim() === '') {
            $("#file_no_error").html('<span style="color:red;font-style:italic;font-size:13px;">Please select File No</span>');
            $("#file_no_error").css("display", "block");
            error = 1;
        }
        if (type.trim() === '') {
            $("#type_error").html('<span style="color:red;font-style:italic;font-size:13px;">Please select Type</span>');
            $("#type_error").css("display", "block");
            error = 1;
        }
        if (race.trim() === '') {
            $("#race_error").html('<span style="color:red;font-style:italic;font-size:13px;">Please select Race</span>');
            $("#race_error").css("display", "block");
            error = 1;
        }

        if (error === 0) {
            $.ajax({
                url: "{{ URL::action('ReportController@submitOwnerTenant') }}",
                type: "POST",
                data: $(this).serialize(),
                success: function (data) {
                    console.log(data);

                    $("#loading").css("display", "none");
                    $("#submit_button").removeAttr("disabled");
                    $("#cancel_button").removeAttr("disabled");
                    if (data) {
                        bootbox.alert("<span style='color:green;'>Report submitted successfully!</span>", function () {
                            location.reload();
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
</script>
<!-- End Page Scripts-->

@stop