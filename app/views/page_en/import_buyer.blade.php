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
                                        {{ Form::open( array('url' => 'uploadBuyerCSVAction/'.$files->id, 'files' => true, 'class' => 'form-horizontal', 'role' => 'form') ) }}
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label>Import CSV File</label>
                                                    <br />
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                                    <input type="file" name="uploadedCSV" id="uploadedCSV" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <?php if ($update_permission == 1) { ?>
                                                    <button type="submit" class="btn btn-primary" id="upload_button">
                                                        Upload
                                                    </button>
                                                    <?php } ?>
                                                    <button type="button" class="btn btn-default" id="cancel_button" onclick="window.location ='{{URL::action('AdminController@buyer', $files->id)}}'">
                                                        Cancel
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        {{ Form::close() }}

                                        @if($Uploadmessage != '' && $Uploadmessage == 'success')
                                        @if($csvData=='No Data')
                                        <div class="row">
                                            <div class="col-md-8" style="color:red;font-style:italic;">
                                                The CSV file is empty
                                            </div>
                                        </div>
                                        @else                                        
                                        <br /><br/>
                                        <div class="table-responsive">
                                            <table class="table table-hover nowrap" id="buyerList" style="width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th style="width:10%;">File No</th>
                                                        <th style="width:5%;">Unit No</th>
                                                        <th style="width:5%;">Unit Share</th>
                                                        <th style="width:10%;">Owner Name</th>
                                                        <th style="width:10%;">IC No / Company No</th>
                                                        <th style="width:10%;">Address</th>
                                                        <th style="width:10%;">Phone Number</th>
                                                        <th style="width:10%;">Email</th>
                                                        <th style="width:10%;">Race</th>
                                                        <th style="width:10%;">Nationality</th>
                                                        <th style="width:10%;">Remarks</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($csvData as $buyer)
                                                    <tr>
                                                        <?php
                                                        for ($i = 0; $i < count($buyer) - 1; $i++) {
                                                            if (end($buyer) == "Success") {
                                                                print '<td>' . $buyer[$i] . '</td>';
                                                            }
                                                        }
                                                        ?>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <?php if ($update_permission == 1) { ?>
                                        <br/>
                                        <button id="submit_buyer_button" type="button" class="btn btn-primary" onclick="submitUploadBuyer()">Submit</button>
                                        <img id="loading" src="{{ asset('assets/common/img/input-spinner.gif') }}" style="display:none;"/>
                                        <?php } ?>
                                        @endif
                                        @else
                                        <div class="row">
                                            <div class="col-md-8" style="color:red;font-style:italic;">
                                                {{$Uploadmessage}}
                                            </div>
                                        </div>
                                        @endif
                                        <!-- End Buyer Form -->
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
    
    var oTable;
    $(function(){
        oTable = $('#buyerList').editableTableWidget();
    });
            
    function submitUploadBuyer() {
        changes = false;
        $("#upload_button").attr('disabled', 'disabled');
        $("#submit_buyer_button").attr('disabled', 'disabled');
        $("#loading").css('display', 'inline-block');
        
        
        var getAllBuyer = [];
        oTable.find('tr').each(function (rowIndex, r) {
            var cols = [];
            $(this).find('td').each(function (colIndex, c) {
                cols.push(c.textContent);
            });
            getAllBuyer.push(cols);            
        });       
        
        
        $.ajax({
            url: "{{ URL::action('AdminController@submitUploadBuyer', $files->id) }}",
            type: "POST",
            data: {
                getAllBuyer: getAllBuyer
            },
            success: function (data) {
                console.log(data);
                if (data.trim() == "true") {                       
                    $.notify({
                        message: '<p style="text-align: center; margin-bottom: 0px;">Successfully saved</p>',
                    },{
                        type: 'success',
                        placement: {
                            align: "center"
                        }
                    }); 
                    location = '{{ URL::action("AdminController@buyer", $files->id) }}';
                }
            }
        });
    }
</script>
<!-- End Page Scripts-->

@stop