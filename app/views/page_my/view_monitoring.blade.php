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
                                <a class="nav-link" href="{{URL::action('AdminController@viewHouse', $file->id)}}">Skim Perumahan</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{URL::action('AdminController@viewStrata', $file->id)}}">Kawasan Pemajuan (STRATA)</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{URL::action('AdminController@viewManagement', $file->id)}}">Pihak Pengurusan</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active">Pemantauan</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{URL::action('AdminController@viewOthers', $file->id)}}">Pelbagai</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{URL::action('AdminController@viewScoring', $file->id)}}">Pemarkahan Komponen Nilai</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{URL::action('AdminController@viewBuyer', $file->id)}}">Senarai Pembeli</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{URL::action('AdminController@fileApproval', $file->id)}}">Pengesahan</a>
                            </li>
                        </ul>
                        <div class="tab-content padding-vertical-20">                            
                            <div class="tab-pane active" id="monitoring" role="tabpanel">                                
                                <form id="monitoring">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <h4>Butiran</h4>
                                            <h6>1. Penghantaran Dokumen Kawasan Pemajuan</h6>
                                            <div class="form-group row">
                                                <div class="col-md-3">
                                                    <label class="form-control-label">Pelan Pra-Hitung</label>
                                                </div>
                                                <div class="col-md-1">
                                                    <input type="radio" id="precalculate_plan" name="precalculate_plan" value="1" {{($monitoring->pre_calculate == 1 ? " checked" : "")}} disabled>
                                                    Ada
                                                </div>
                                                <div class="col-md-1">
                                                    <input type="radio" id="precalculate_plan" name="precalculate_plan" value="0" {{($monitoring->pre_calculate == 0 ? " checked" : "")}} disabled>
                                                    Tiada
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-3">
                                                    <label class="form-control-label">Daftar Pembeli</label>
                                                </div>
                                                <div class="col-md-1">
                                                    <input type="radio" id="buyer_registration" name="buyer_registration" value="1" {{($monitoring->buyer_registration == 1 ? " checked" : "")}} disabled>
                                                    Ada
                                                </div>
                                                <div class="col-md-1">
                                                    <input type="radio" id="buyer_registration" name="buyer_registration" value="0" {{($monitoring->buyer_registration == 0 ? " checked" : "")}} disabled>
                                                    Tiada
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-3">
                                                    <label class="form-control-label">No. Siri Sijil</label>
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="text" class="form-control" placeholder="No. Siri Sijil" id="certificate_series_no" value="{{$monitoring->certificate_no}}" readonly=""/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr/>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <h6>2. Penghantaran Dokumen Setiap Kali Mesyuarat</h6>
                                            <div class="table-responsive">
                                                <div class="form-group row">
                                                    <div class="col-md-3">
                                                        <label class="form-control-label">Bulan Mula Laporan Kewangan</label>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <select class="form-control" id="commercial_sinking_fund_option">
                                                            <option value="0" selected="">Semua</option>
                                                            <option value="1">Januari</option>
                                                            <option value="2">Februari</option>
                                                            <option value="3">Mac</option>
                                                            <option value="4">April</option>
                                                            <option value="5">Mei</option>
                                                            <option value="6">Jun</option>
                                                            <option value="7">Julai</option>
                                                            <option value="8">Ogos</option>
                                                            <option value="9">September</option>
                                                            <option value="10">Oktober</option>
                                                            <option value="11">November</option>
                                                            <option value="12">Disember</option>
                                                        </select>
                                                    </div>
                                                </div>                                                 
                                                <table class="table table-hover nowrap" id="financial_report_list" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th style="width:15%;text-align: center !important;">Tarikh AGM</th>
                                                            <th style="width:20%;">Mesyuarat</th>
                                                            <th style="width:5%;"></th>
                                                            <th style="width:20%;">Salinan & Senarai</th>
                                                            <th style="width:5%;"></th>
                                                            <th style="width:20%;">Laporan Kewangan</th>
                                                            <th style="width:5%;"></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>                                                    
                                                    </tbody>
                                                </table>
                                            </div>                                                                                      
                                        </div>
                                    </div>
                                    <hr/>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <h6>Maklumat Tambahan</h6>   
                                            <div class="table-responsive">
                                                <table class="table table-hover nowrap" id="ajk_details_list" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th style="width:30%;text-align: center !important;">Jawatan</th>
                                                            <th style="width:30%;">Nama</th>
                                                            <th style="width:20%;">No. Telefon</th>
                                                            <th style="width:10%;">Tahun</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>                                                    
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <hr/>
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label class="form-control-label">Catatan</label>
                                        </div>
                                        <div class="col-md-4">
                                            <textarea class="form-control" rows="3" placeholder="Catatan" id="monitoring_remarks" readonly="">{{$monitoring->remarks}}</textarea>
                                        </div>
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
    function getAGMDetails(id) {
        $.ajax({
            url: "{{ URL::action('AdminController@getAGMDetails') }}",
            type: "POST",
            data: {
                id: id
            },
            success: function(data) {
                $("#agmEdit").html(data);
                $("#edit_agm_details").modal("show");
            }
        });
    }

    $(function () {
        $('#agm_date').datetimepicker({
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
        $('#agm_date_edit').datetimepicker({
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
        $('#audit_start').datetimepicker({
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
        $('#audit_start_edit').datetimepicker({
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
        $('#audit_end').datetimepicker({
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
        $('#audit_end_edit').datetimepicker({
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
    });

    $(document).ready(function () {
        $('#financial_report_list').DataTable({
            "sAjaxSource": "{{URL::action('AdminController@getAGM', $file->id)}}",
            "order": [[0, "desc"]]
        });
        $('#ajk_details_list').DataTable({
            "sAjaxSource": "{{URL::action('AdminController@getAJK', $file->id)}}",
            "order": [[0, "desc"]]
        });
    });

    $(document).ready(function () {
        //add
        var options1 = {
            beforeSubmit: showRequest1,
            success: showResponse1,
            dataType: 'json'
        };
        var options2 = {
            beforeSubmit: showRequest2,
            success: showResponse2,
            dataType: 'json'
        };
        var options3 = {
            beforeSubmit: showRequest3,
            success: showResponse3,
            dataType: 'json'
        };
        //edit        
        var options4 = {
            beforeSubmit: showRequest4,
            success: showResponse4,
            dataType: 'json'
        };
        var options5 = {
            beforeSubmit: showRequest5,
            success: showResponse5,
            dataType: 'json'
        };
        var options6 = {
            beforeSubmit: showRequest6,
            success: showResponse6,
            dataType: 'json'
        };


        //add
        $('body').delegate('#audit_report_file', 'change', function () {
            $('#upload_audit_report_file').ajaxForm(options1).submit();
        });
        $('body').delegate('#letter_integrity', 'change', function () {
            $('#upload_letter_integrity').ajaxForm(options2).submit();
        });
        $('body').delegate('#letter_bankruptcy', 'change', function () {
            $('#upload_letter_bankruptcy').ajaxForm(options3).submit();
        });
        //edit
        $('body').delegate('#audit_report_file_edit', 'change', function () {
            $('#upload_audit_report_file_edit').ajaxForm(options4).submit();
        });
        $('body').delegate('#letter_integrity_edit', 'change', function () {
            $('#upload_letter_integrity_edit').ajaxForm(options5).submit();
        });
        $('body').delegate('#letter_bankruptcy_edit', 'change', function () {
            $('#upload_letter_bankruptcy_edit').ajaxForm(options6).submit();
        });
    });

    //upload audit report file
    function showRequest1(formData, jqForm, options1) {
        $("#validation-errors_audit_report_file").hide().empty();
        return true;
    }
    function showResponse1(response, statusText, xhr, $form) {
        if (response.success == false)
        {
            var arr = response.errors;
            $.each(arr, function (index, value)
            {
                if (value.length != 0)
                {
                    $("#validation-errors_audit_report_file").append('<div class="alert alert-error"><strong>' + value + '</strong><div>');
                }
            });
            $("#validation-errors_audit_report_file").show();
            $("#audit_report_file").css("color", "red");
        } else {
            $("#validation-errors_audit_report_file").html("<i class='fa fa-check' id='check_audit_report_file' style='color:green;'></i>");
            $("#clear_audit_report_file").show();
            $("#validation-errors_audit_report_file").show();
            $("#audit_report_file").css("color", "green");
            $("#audit_report_file_url").val(response.file);
        }
    }

    //upload letter integrity
    function showRequest2(formData, jqForm, options2) {
        $("#validation-errors_letter_integrity").hide().empty();
        return true;
    }
    function showResponse2(response, statusText, xhr, $form) {
        if (response.success == false)
        {
            var arr = response.errors;
            $.each(arr, function (index, value)
            {
                if (value.length != 0)
                {
                    $("#validation-errors_letter_integrity").append('<div class="alert alert-error"><strong>' + value + '</strong><div>');
                }
            });
            $("#validation-errors_letter_integrity").show();
            $("#letter_integrity").css("color", "red");
        } else {
            $("#validation-errors_letter_integrity").html("<i class='fa fa-check' id='check_letter_integrity' style='color:green;'></i>");
            $("#clear_letter_integrity").show();
            $("#validation-errors_letter_integrity").show();
            $("#letter_integrity").css("color", "green");
            $("#letter_integrity_url").val(response.file);
        }
    }

    //upload letter bankruptcy
    function showRequest3(formData, jqForm, options3) {
        $("#validation-errors_letter_bankruptcy").hide().empty();
        return true;
    }
    function showResponse3(response, statusText, xhr, $form) {
        if (response.success == false)
        {
            var arr = response.errors;
            $.each(arr, function (index, value)
            {
                if (value.length != 0)
                {
                    $("#validation-errors_letter_bankruptcy").append('<div class="alert alert-error"><strong>' + value + '</strong><div>');
                }
            });
            $("#validation-errors_letter_bankruptcy").show();
            $("#letter_bankruptcy").css("color", "red");
        } else {
            $("#validation-errors_letter_bankruptcy").html("<i class='fa fa-check' id='check_letter_bankruptcy' style='color:green;'></i>");
            $("#clear_letter_bankruptcy").show();
            $("#validation-errors_letter_bankruptcy").show();
            $("#letter_bankruptcy").css("color", "green");
            $("#letter_bankruptcy_url").val(response.file);
        }
    }

    //upload audit report file edit
    function showRequest4(formData, jqForm, options4) {
        $("#validation-errors_audit_report_file_edit").hide().empty();
        return true;
    }
    function showResponse4(response, statusText, xhr, $form) {
        if (response.success == false)
        {
            var arr = response.errors;
            $.each(arr, function (index, value)
            {
                if (value.length != 0)
                {
                    $("#validation-errors_audit_report_file_edit").append('<div class="alert alert-error"><strong>' + value + '</strong><div>');
                }
            });
            $("#validation-errors_audit_report_file_edit").show();
            $("#audit_report_file_edit").css("color", "red");
        } else {
            $("#report_edit").hide();
            $("#validation-errors_audit_report_file_edit").html("<i class='fa fa-check' id='check_audit_report_file_edit' style='color:green;'></i>");
            $("#clear_audit_report_file_edit").show();
            $("#validation-errors_audit_report_file_edit").show();
            $("#audit_report_file_edit").css("color", "green");
            $("#audit_report_file_url_edit").val(response.file);
        }
    }

    //upload letter integrity edit
    function showRequest5(formData, jqForm, options5) {
        $("#validation-errors_letter_integrity_edit").hide().empty();
        return true;
    }
    function showResponse5(response, statusText, xhr, $form) {
        if (response.success == false)
        {
            var arr = response.errors;
            $.each(arr, function (index, value)
            {
                if (value.length != 0)
                {
                    $("#validation-errors_letter_integrity_edit").append('<div class="alert alert-error"><strong>' + value + '</strong><div>');
                }
            });
            $("#validation-errors_letter_integrity_edit").show();
            $("#letter_integrity_edit").css("color", "red");
        } else {
            $("#integrity_edit").hide();
            $("#validation-errors_letter_integrity_edit").html("<i class='fa fa-check' id='check_letter_integrity_edit' style='color:green;'></i>");
            $("#clear_letter_integrity_edit").show();
            $("#validation-errors_letter_integrity_edit").show();
            $("#letter_integrity_edit").css("color", "green");
            $("#letter_integrity_url_edit").val(response.file);
        }
    }

    //upload letter bankruptcy edit
    function showRequest6(formData, jqForm, options6) {
        $("#validation-errors_letter_bankruptcy_edit").hide().empty();
        return true;
    }
    function showResponse6(response, statusText, xhr, $form) {
        if (response.success == false)
        {
            var arr = response.errors;
            $.each(arr, function (index, value)
            {
                if (value.length != 0)
                {
                    $("#validation-errors_letter_bankruptcy_edit").append('<div class="alert alert-error"><strong>' + value + '</strong><div>');
                }
            });
            $("#validation-errors_letter_bankruptcy_edit").show();
            $("#letter_bankruptcy_edit").css("color", "red");
        } else {
            $("#bankruptcy_edit").hide();
            $("#validation-errors_letter_bankruptcy_edit").html("<i class='fa fa-check' id='check_letter_bankruptcy_edit' style='color:green;'></i>");
            $("#clear_letter_bankruptcy_edit").show();
            $("#validation-errors_letter_bankruptcy_edit").show();
            $("#letter_bankruptcy_edit").css("color", "green");
            $("#letter_bankruptcy_url_edit").val(response.file);
        }
    }

    $(document).on("click", '.edit_agm', function (e) {
        var agm_id = $(this).data('agm_id');
        var agm_date = $(this).data('agm_date');
        var audit_start_date = $(this).data('audit_start_date');
        var audit_end_date = $(this).data('audit_end_date');
        var audit_report_file_url = $(this).data('audit_report_file_url');
        var letter_integrity_url = $(this).data('letter_integrity_url');
        var letter_bankruptcy_url = $(this).data('letter_bankruptcy_url');

        $("#agm_id_edit").val(agm_id);
        if (agm_date == "0000-00-00 00:00:00") {
            $("#agm_date_edit").val("");
        } else {
            $("#agm_date_edit").val(agm_date);
        }
        if (audit_start_date == "0000-00-00 00:00:00") {
            $("#audit_start_edit").val("");
        } else {
            $("#audit_start_edit").val(audit_start_date);
        }
        if (audit_end_date == "0000-00-00 00:00:00") {
            $("#audit_end_edit").val("");
        } else {
            $("#audit_end_edit").val(audit_end_date);
        }
        $("#audit_report_file_url_edit").val(audit_report_file_url);
        $("#letter_integrity_url_edit").val(letter_integrity_url);
        $("#letter_bankruptcy_url_edit").val(letter_bankruptcy_url);
    });

    $(document).on("click", '.edit_ajk', function (e) {
        var ajk_id = $(this).data('ajk_id');
        var designation = $(this).data('designation');
        var name = $(this).data('name');
        var phone_no = $(this).data('phone_no');
        var year = $(this).data('year');

        $("#ajk_id_edit").val(ajk_id);
        $("#ajk_designation_edit").val(designation);
        $("#ajk_name_edit").val(name);
        $("#ajk_phone_no_edit").val(phone_no);
        $("#ajk_year_edit").val(year);
    });

    function addAGMDetails() {
        $("#add_agm_details").modal("show");
    }
    function editAGMDetails() {
        $("#edit_agm_details").modal("show");
    }

    function addAJKDetails() {
        $("#add_ajk_details").modal("show");
    }
    function editAJKDetails() {
        $("#edit_ajk_details").modal("show");
    }

    function clearAuditFile() {
        $("#audit_report_file").val("");
        $("#audit_report_file_url").val("");
        $("#audit_report_file").css("color", "grey");
        $("#clear_audit_report_file").hide();
        $("#check_audit_report_file").hide();
    }

    function clearLetterIntegrity() {
        $("#letter_integrity").val("");
        $("#letter_integrity_url").val("");
        $("#letter_integrity").css("color", "grey");
        $("#clear_letter_integrity").hide();
        $("#check_letter_integrity").hide();
    }

    function clearLetterBankruptcy() {
        $("#letter_bankruptcy").val("");
        $("#letter_bankruptcy_url").val("");
        $("#letter_bankruptcy").css("color", "grey");
        $("#clear_letter_bankruptcy").hide();
        $("#check_letter_bankruptcy").hide();
    }
    function clearAuditFileEdit() {
        $("#audit_report_file_edit").val("");
        $("#audit_report_file_url_edit").val("");
        $("#audit_report_file_edit").css("color", "grey");
        $("#clear_audit_report_file_edit").hide();
        $("#check_audit_report_file_edit").hide();
    }

    function clearLetterIntegrityEdit() {
        $("#letter_integrity_edit").val("");
        $("#letter_integrity_url_edit").val("");
        $("#letter_integrity_edit").css("color", "grey");
        $("#clear_letter_integrity_edit").hide();
        $("#check_letter_integrity_edit").hide();
    }

    function clearLetterBankruptcyEdit() {
        $("#letter_bankruptcy_edit").val("");
        $("#letter_bankruptcy_url_edit").val("");
        $("#letter_bankruptcy_edit").css("color", "grey");
        $("#clear_letter_bankruptcy_edit").hide();
        $("#check_letter_bankruptcy_edit").hide();
    }
</script>


<!-- End Page Scripts-->

@stop