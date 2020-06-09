@extends('layout.malay_layout.default')

@section('content')

<?php
$update_permission = 0;

foreach ($user_permission as $permission) {
    if ($permission->submodule_id == 9) {
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
                    <h4>AGM</h4>
                    <div>
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" href="javascript: void(0);" data-toggle="tab" data-target="#tab1" role="tab">Peringatan AGM</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="javascript: void(0);" data-toggle="tab" data-target="#tab2" role="tab">Tiada AGM</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="javascript: void(0);" data-toggle="tab" data-target="#tab3" role="tab">> 12 Bulan</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="javascript: void(0);" data-toggle="tab" data-target="#tab4" role="tab">> 15 Bulan</a>
                            </li>
                        </ul>
                        <div class="tab-content padding-vertical-20">
                            <div class="tab-pane active" id="tab1" role="tabpanel">
                                <table class="table table-hover nowrap" id="agm_remainder" width="100%">
                                    <thead>
                                        <tr>
                                            <th style="width:10%;">COB</th> 
                                            <th style="width:50%;">No. Fail</th>
                                            <th style="width:30%;">Tarikh Akhir AGM</th>
                                            <?php if ($update_permission == 1) { ?>
                                                <th style="width:10%;">Aksi</th>
                                            <?php } ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane" id="tab2" role="tabpanel">
                                <table class="table table-hover nowrap" id="never_agm" width="100%">
                                    <thead>
                                        <tr>
                                            <th style="width:10%;">COB</th> 
                                            <th style="width:80%;">No. Fail</th>
                                            <?php if ($update_permission == 1) { ?>
                                                <th style="width:10%;">Aksi</th>
                                            <?php } ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane" id="tab3" role="tabpanel">
                                <table class="table table-hover nowrap" id="more_12months" width="100%">
                                    <thead>
                                        <tr>
                                            <th style="width:10%;">COB</th> 
                                            <th style="width:50%;">No. Fail</th>
                                            <th style="width:30%;">Tarikh Akhir AGM</th>
                                            <?php if ($update_permission == 1) { ?>
                                                <th style="width:10%;">Aksi</th>
                                            <?php } ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane" id="tab4" role="tabpanel">
                                <table class="table table-hover nowrap" id="more_15months" width="100%">
                                    <thead>
                                        <tr>
                                            <th style="width:10%;">COB</th> 
                                            <th style="width:50%;">No. Fail</th>
                                            <th style="width:30%;">Tarikh Akhir AGM</th>
                                            <?php if ($update_permission == 1) { ?>
                                                <th style="width:10%;">Aksi</th>
                                            <?php } ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <hr/>

            <div class="row">
                <div class="col-lg-12">                    
                    <h4>Designation</h4>
                    <div>
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" href="javascript: void(0);" data-toggle="tab" data-target="#tabDesignation1" role="tab">Designation Remainder</a>
                            </li>
                        </ul>
                        <div class="tab-content padding-vertical-20">
                            <div class="tab-pane active" id="tabDesignation1" role="tabpanel">
                                <table class="table table-hover nowrap" id="designation_remainder" width="100%">
                                    <thead>
                                        <tr>
                                            <th style="width:10%;">COB</th> 
                                            <th style="width:25%;">File No</th>
                                            <th style="width:10%;">Designation</th>
                                            <th style="width:25%;">Name</th>
                                            <th style="width:10%;">Phone No</th>
                                            <th style="width:10%;">Month</th>
                                            <th style="width:10%;">Year</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>                            
                        </div>
                    </div>
                </div>
            </div>

            <hr/>

            <div class="row">
                <div class="col-lg-12">
                    <h4>Memo</h4>
                    <table class="table table-hover nowrap" id="memo" width="100%">
                        <thead>
                            <tr>
                                <th style="width:70%;">Subjek</th>
                                <th style="width:20%;">Tarikh Memo</th>
                                <th style="width:10%;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>

            <hr/>

            <div class="row">
                <div class="col-lg-6">
                    <div class="margin-bottom-50">
                        <!--<h4 class="text-center">Maklumat Penakrifan Bintang Kawasan Pemajuan</h4>-->                            
                        <!--<div class="chart-pie-chart"></div>-->
                        <div id="rating_star"></div>
                        <br/>
                        <span>Bil Kawasan Pemajuan : {{$strata}}</span>
                        <br/>
                        @if ($strata == 0)
                        <span>Bil Sample & Peratusan : {{$rating}} (0%)</span>
                        @else
                        <span>Bil Sample & Peratusan : {{$rating}} ({{number_format((($rating/$strata)*100), 2)}}%)</span>
                        @endif
                        <br/>
                        <span>Tiada Maklumat : {{$strata - $rating}}</span>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="margin-bottom-50">
                        <!--<h4 class="text-center">Fail COB Mengikut Jenis Pengurusan</h4>-->
                        <!--<div class="pie-chart"></div>-->
                        <div id="management_type"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<div class="modal fade modal" id="memoDetailsModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content"></div>
    </div>
</div>

<script type="text/javascript">
    var oTable;
    $(document).ready(function () {
        oTable = $('#agm_remainder').DataTable({
            "sAjaxSource": "{{URL::action('AdminController@getAGMRemainder')}}",
            "lengthMenu": [[5, 10, 25, 50, 100, -1], [5, 10, 25, 50, 100, "All"]],
            "order": [[1, "desc"]],
            "pageLength": 5,
            "responsive": true,
            "aoColumnDefs": [
                {
                    "bSortable": false,
                    "aTargets": [-1]
                }
            ]
        });
    });
    var oTable2;
    var oTable1;
    $(document).ready(function () {
        oTable1 = $('#never_agm').DataTable({
            "sAjaxSource": "{{URL::action('AdminController@getNeverAGM')}}",
            "lengthMenu": [[5, 10, 25, 50, 100, -1], [5, 10, 25, 50, 100, "All"]],
            "order": [[0, "desc"]],
            "pageLength": 5,
            "responsive": true,
            "aoColumnDefs": [
                {
                    "bSortable": false,
                    "aTargets": [-1]
                }
            ]
        });
    });
    var oTable2;
    $(document).ready(function () {
        oTable2 = $('#more_12months').DataTable({
            "sAjaxSource": "{{URL::action('AdminController@getAGM12Months')}}",
            "lengthMenu": [[5, 10, 25, 50, 100, -1], [5, 10, 25, 50, 100, "All"]],
            "order": [[1, "desc"]],
            "pageLength": 5,
            "responsive": true,
            "aoColumnDefs": [
                {
                    "bSortable": false,
                    "aTargets": [-1]
                }
            ]
        });
    });
    var oTable3;
    $(document).ready(function () {
        oTable3 = $('#more_15months').DataTable({
            "sAjaxSource": "{{URL::action('AdminController@getAGM15Months')}}",
            "lengthMenu": [[5, 10, 25, 50, 100, -1], [5, 10, 25, 50, 100, "All"]],
            "order": [[1, "desc"]],
            "pageLength": 5,
            "responsive": true,
            "aoColumnDefs": [
                {
                    "bSortable": false,
                    "aTargets": [-1]
                }
            ]
        });
    });
    var oTable4;
    $(document).ready(function () {
        oTable4 = $('#memo').DataTable({
            "sAjaxSource": "{{URL::action('AdminController@getMemoHome')}}",
            "lengthMenu": [[5, 10, 25, 50, 100, -1], [5, 10, 25, 50, 100, "All"]],
            "order": [[1, "desc"]],
            "pageLength": 5,
            "responsive": true
        });
    });
    var oTable5;
    oTable5 = $('#designation_remainder').DataTable({
        "sAjaxSource": "{{URL::action('AgmController@getDesignationRemainder')}}",
        "lengthMenu": [[5, 10, 25, 50, 100, -1], [5, 10, 25, 50, 100, "All"]],
        "order": [[5, 'desc'], [6, 'desc']],
        "pageLength": 5,
        "responsive": true
    });

    function getMemoDetails(id) {
        $.ajax({
            url: "{{ URL::action('AdminController@getMemoDetails') }}",
            type: "POST",
            data: {
                id: id
            },
            success: function (data) {
                $(".modal-content").html(data);
                $("#memoDetailsModal").modal("show");
            }
        });
    }

    // Build the chart
    Highcharts.chart('management_type', {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: 'Fail COB Mengikut Jenis Pengurusan'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '{point.name}<br/><b>{point.percentage:.1f} %</b>',
                    distance: -50,
                    filter: {
                        property: 'percentage',
                        operator: '>',
                        value: 4
                    }
                },
                showInLegend: true
            }
        },
        series: [{
                name: 'Jenis Pengurusan',
                colorByPoint: true,
                data: [
                    {name: 'Pemaju', y: <?php echo $developer; ?>},
                    {name: 'JMB', y: <?php echo $jmb; ?>},
                    {name: 'MC', y: <?php echo $mc; ?>},
                    {name: 'Ejen', y: <?php echo $agent; ?>},
                    {name: 'Lain-lain', y: <?php echo $others; ?>}
                ]
            }]
    });

    Highcharts.chart('rating_star', {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: 'Maklumat Penakrifan Bintang Kawasan Pemajuan'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '{point.name}<br/><b>{point.percentage:.1f} %</b>',
                    distance: -50,
                    filter: {
                        property: 'percentage',
                        operator: '>',
                        value: 4
                    }
                },
                showInLegend: true
            }
        },
        series: [{
                name: 'Penakrifan Bintang',
                colorByPoint: true,
                data: [
                    {name: '1 Bintang', y: <?php echo $oneStar; ?>},
                    {name: '2 Bintang', y: <?php echo $twoStar; ?>},
                    {name: '3 Bintang', y: <?php echo $threeStar; ?>},
                    {name: '4 Bintang', y: <?php echo $fourStar; ?>},
                    {name: '5 Bintang', y: <?php echo $fiveStar; ?>}
                ]
            }]
    });
</script>

@stop