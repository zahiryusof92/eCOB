@extends('layout.malay_layout.default')

@section('content')

<?php
$company = Company::first();
?>

<div class="page-content-inner">
    <section class="panel panel-with-borders">
        <div class="panel-heading">
            <h3>{{$title}}</h3>
        </div>
        <div class="panel-body">
            <div class="invoice-block">
                <div class="row">
                    <table width="100%">
                        <tr>
                            <td class="text-center">
                                <h4 class="margin-bottom-0">
                                    <img src="{{asset($company->image_url)}}" height="100px;" alt="">
                                </h4> 
                            </td>
                            <td>
                                <h5 class="margin-bottom-10">
                                    {{$company->name}}
                                </h5>
                                <h6 class="margin-bottom-0">
                                    {{$title}}
                                </h6>
                            </td>
                            <td class="text-center">
                                <a href="{{URL::action('PrintController@printAuditTrail')}}" target="_blank">
                                    <button type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Cetak"><i class="fa fa-print"></i></button>
                                </a>
                            </td>
                        </tr>
                    </table>
                </div>                
                <hr/>
                <br/>
                <div class="row text-center">
                    <div class="col-lg-12">
                        <span style="font-size: 12px;"><b>Tarikh Diaudit: </b></span>&nbsp;                        
                        <input style="font-size: 12px;" id="date_from" type="text" class="form-control width-150 display-inline-block" value="{{date('Y/m/d', strtotime('now'))}}" placeholder="Daripada"/>
                        <span style="font-size: 12px;" class="margin-right-10">—</span>
                        <input style="font-size: 12px;" id="date_to" type="text" class="form-control width-150 display-inline-block" placeholder="Hingga"/>
                        <button style="font-size: 12px;" type="button" class="form-control btn btn-primary width-100 display-inline-block" id="submit_button">Cari</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <br/>
                        <table class="table" id="audit_trail" width="100%" style="font-size: 12px;">
                            <thead>
                                <tr>
                                    <th style="width:20%; text-align: center !important;">Modul</th>
                                    <th style="width:40%; text-align: center !important;">Aktiviti</th>
                                    <th style="width:20%; text-align: center !important;">Tindakan Daripada</th>
                                    <th style="width:20%; text-align: center !important;">Tarikh Tindakan</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>           
        </div>
    </section>    
    <!-- End  -->
</div>

<!-- Page Scripts -->
<script>
    var oTable;

    $.fn.dataTableExt.afnFiltering.push(
            function (oSettings, aData, iDataIndex) {

                var date_from = $("#date_from").val();
                var date_to = $("#date_to").val();

                var iMin = date_from;
                var iMax = date_to;
                var iDate = 3; //using column 4

                var startDate = iMin.substring(0, 4) + iMin.substring(5, 7) + iMin.substring(11, 8);
                var endDate = iMax.substring(0, 4) + iMax.substring(5, 7) + iMax.substring(11, 8);
                var tableDate = aData[iDate].substring(0, 4) + aData[iDate].substring(5, 7) + aData[iDate].substring(11, 8);

//            alert (tableDate);

                if (startDate === "" && endDate === "")
                {
                    return true;
                } else if (startDate <= tableDate && endDate === "")
                {
                    return true;
                } else if (endDate >= tableDate && startDate === "")
                {
                    return true;
                } else if (startDate <= tableDate && endDate >= tableDate)
                {
                    return true;
                } else {
                    return false;
                }
            }
    );

    $(document).ready(function () {
        oTable = $('#audit_trail').DataTable({
            "sAjaxSource": "{{URL::action('AdminController@getAuditTrail')}}",
            "order": [[3, "desc"]],
            "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            "pageLength": 25,
            "scrollX": true,
            "fixedColumns": true
        });
        // Add event listeners to the two range filtering inputs
        $('#date_from').click(function () {
            $('#date_to').val("");
        });
        $('#submit_button').click(function () {
            oTable.draw();
        });
    });

    $(function () {
        $('#date_from').datetimepicker({
            widgetPositioning: {
                horizontal: 'left'
            },
            icons: {
                time: "fa fa-clock-o",
                date: "fa fa-calendar",
                up: "fa fa-arrow-up",
                down: "fa fa-arrow-down"
            },
            format: 'YYYY/MM/DD'
        });
        $('#date_to').datetimepicker({
            widgetPositioning: {
                horizontal: 'left'
            },
            icons: {
                time: "fa fa-clock-o",
                date: "fa fa-calendar",
                up: "fa fa-arrow-up",
                down: "fa fa-arrow-down"
            },
            format: 'YYYY/MM/DD'
        });

        $("[data-toggle=tooltip]").tooltip();
    });
</script>

@stop