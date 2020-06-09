@extends('layout.malay_layout.default')

@section('content')

<?php
$insert_permission = 0;

foreach ($user_permission as $permission) {
    if ($permission->submodule_id == 31) {
        $insert_permission = $permission->insert_permission;
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
                    <!-- Buyer Form -->
                    {{ Form::open( array('url' => 'uploadPurchaserCSVAction', 'files' => true, 'class' => 'form-horizontal', 'role' => 'form') ) }}
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
                                <?php if ($insert_permission == 1) { ?>
                                    <button type="submit" class="btn btn-primary" id="upload_button">
                                        Upload
                                    </button>
                                <?php } ?>
                                <button type="button" class="btn btn-default" id="cancel_button" onclick="window.location ='{{URL::action('AgmController@purchaser')}}'">
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
                        <table class="table table-hover nowrap" id="purchaser">
                            <thead>
                                <tr>
                                    <th style="width:15%;">File No</th>
                                    <th style="width:5%;">Unit No</th>
                                    <th style="width:5%;">Unit Share</th>
                                    <th style="width:15%;">Owner Name</th>
                                    <th style="width:10%;">IC No / Company No</th>
                                    <th style="width:15%;">Address</th>
                                    <th style="width:10%;">Phone Number</th>
                                    <th style="width:15%;">Email</th>
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
                    <?php if ($insert_permission == 1) { ?>
                        <br/>
                        <button id="submit_buyer_button" type="button" class="btn btn-primary" onclick="submitUploadPurchaser()">Submit</button>
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
    </section>
    <!-- End -->
</div>

<!-- Page Scripts -->

<script>
    var oTable;
    $(function () {
        oTable = $('#purchaser').editableTableWidget();
    });

    function submitUploadPurchaser() {
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
            url: "{{ URL::action('AgmController@submitUploadPurchaser') }}",
            type: "POST",
            data: {
                getAllBuyer: getAllBuyer
            },
            success: function (data) {
                console.log(data);
                if (data.trim() == "true") {
                    $.notify({
                        message: '<p style="text-align: center; margin-bottom: 0px;">Successfully saved</p>',
                    }, {
                        type: 'success',
                        placement: {
                            align: "center"
                        }
                    });
                    location = '{{ URL::action("AgmController@purchaser") }}';
                }
            }
        });
    }
</script>
<!-- End Page Scripts-->

@stop