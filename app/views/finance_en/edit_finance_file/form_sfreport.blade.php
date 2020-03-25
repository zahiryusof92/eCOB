<?php
$prefix = 'sfr_';

$count = 0;
$sfr_total_income = 0;
$sfr_total_amount = 0;

$sfr_total_income += $sfreport['fee_sebulan'] + $sfreport['fee_semasa'];
?>

<div class="row">
    <div class="col-lg-12">

        <h6>2. LAPORAN RINGKAS PENCAPAIAN KUTIPAN KUMPULAN WANG PENJELAS (SINGKING FUND)</h6>

        <form id="formFinanceSfReport" class="form-horizontal" method="POST">                                
            <div class="row">
                <table class="table table-sm" style="font-size: 12px;">
                    <tbody>
                        <tr>
                            <td class="padding-table" width="30%">
                                <span style="color: red;">*</span>SINKING FUND SEBULAN (PER UNIT)
                            </td>
                            <td width="15%">
                                <input type="number" step="any" name="{{ $prefix }}fee_sebulan" class="form-control form-control-sm text-right" value="{{ $sfreport['fee_sebulan'] }}">
                            </td>
                            <td width="5%">&nbsp;</td>
                            <td class="padding-table" width="35%">
                                <span style="color: red;">*</span> JUMLAH UNIT
                            </td>
                            <td width="15%">
                                <input type="number" step="any" name="{{ $prefix }}unit" class="form-control form-control-sm text-right" value="{{ $sfreport['unit'] }}">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                JUMLAH DIKUTIP (TUNGGAKAN + SEMASA + ADVANCED [A])
                            </td>
                            <td>
                                <input type="number" step="any" id="{{ $prefix }}kutipan" name="{{ $prefix }}kutipan" class="form-control form-control-sm text-right" value="0.00" readonly="">
                            </td>
                            <td>&nbsp;</td>
                            <td class="padding-table">
                                <span style="color: red;">*</span>JUMLAH SINKING FUND SEPATUT DIKUTIP SEMASA
                            </td>
                            <td>
                                <input type="number" step="any" name="{{ $prefix }}fee_semasa" class="form-control form-control-sm text-right" value="{{ $sfreport['fee_semasa'] }}">
                            </td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <th class="padding-table">
                                JUMLAH SERVICE FEE BERJAYA DIKUTIP SEMASA
                            </th>
                            <th>
                                <input type="number" step="any" name="{{ $prefix }}total_income" class="form-control form-control-sm text-right" value="{{ $sfr_total_income }}" readonly="">
                            </th>
                        </tr>
                    </tbody>
                </table>
            </div>

            <hr>

            <div class="row">
                <table id="dynamic_form_sfr" class="table table-sm" style="font-size: 12px;">
                    <thead>
                        <tr>
                            <th width="20%" style="text-align: center">JUMLAH PERBELANJAAN</th>
                            <th width="65%" style="text-align: center">PERKARA</th>
                            <th width="15%" style="text-align: center">JUMLAH (RM)</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($reportSF as $reportSFs)
                        <?php                        
                        $sfr_total_amount += $reportSFs['amount'];
                        ?>
                        <tr id="sfr_row{{ ++$count }}">
                            <td><input type="hidden" name="{{ $prefix }}is_custom[]" value="{{ $reportSFs['is_custom'] }}"><input type="hidden" name="{{ $prefix }}report_key[]" value="{{ $reportSFs['report_key'] }}">&nbsp;</td>
                            <td><input type="text" name="{{ $prefix }}name[]" class="form-control form-control-sm" value="{{ $reportSFs['name'] }}" readonly=""></td>
                            <td><input type="number" step="any" id="{{ $prefix . $reportSFs['report_key'] }}" name="{{ $prefix }}amount[]" class="form-control form-control-sm text-right" value="{{ $reportSFs['amount'] }}" readonly=""></td>
                            @if ($reportSFs['is_custom'])
                            <td class="padding-table text-right"><a href="javascript:void(0);" onclick="deleteRowSFR('sfr_row<?php echo $count ?>')" class="btn btn-danger btn-xs">Remove</a></td>
                            @else
                            <td>&nbsp;</td>
                            @endif
                        </tr>
                        @endforeach

                        <tr>
                            <td class="padding-table text-right" colspan="5"><a href="javascript:void(0);" onclick="addRowSFR()" class="btn btn-success btn-xs">Add More</a></td>
                        </tr>

                        <tr>
                            <td>&nbsp;</td>
                            <td class="padding-form">JUMLAH TELAH BAYAR [B]</td>
                            <td><input type="number" step="any" id="{{ $prefix }}bayar_total" name="{{ $prefix }}bayar_total" class="form-control form-control-sm text-right" value="{{ $sfr_total_amount }}" readonly=""></td>
                        </tr>

                        <tr>
                            <td class="padding-table" colspan="2">LEBIHAN / KURANGAN PENDAPATAN (A) - (B)</td>
                            <td><input type="number" step="any" id="{{ $prefix }}lebihan_kurangan" name="{{ $prefix }}lebihan_kurangan" class="form-control form-control-sm text-right" value="0.00" readonly=""></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <hr/>

            <div class="row">
                <table class="table table-sm" style="font-size: 12px;">
                    <tbody>
                        <tr>
                            <td class="padding-table" width="20%">
                                <span style="color: red;">*</span> NO AKAUN
                            </td>
                            <td width="35%">
                                <input id="{{ $prefix }}no_akaun" name="{{ $prefix }}no_akaun" class="form-control form-control-sm" type="text" value="{{ $sfreport['no_akaun'] }}">
                                <small id="{{ $prefix }}no_akaun_err" style="display: none;"></small>
                            </td>
                            <td width="5%">&nbsp;</td>
                            <td class="padding-table" width="25%">  
                                <span style="color: red;">*</span> BAKI BANK (AWAL)
                            </td>
                            <td width="15%">  
                                <input type="number" step="any" name="{{ $prefix }}baki_bank_awal" class="form-control form-control-sm text-right" value="{{ $sfreport['baki_bank_awal'] }}">
                            </td>
                        </tr>
                        <tr>
                            <td class="padding-table">
                                <span style="color: red;">*</span> NAMA BANK
                            </td>
                            <td>
                                <input id="{{ $prefix }}nama_bank" name="{{ $prefix }}nama_bank" class="form-control form-control-sm" type="text" value="{{ $sfreport['nama_bank'] }}">
                                <small id="{{ $prefix }}nama_bank_err" style="display: none;"></small>
                            </td>
                            <td>&nbsp;</td>
                            <td class="padding-table">
                                <span style="color: red;">*</span> BAKI BANK (AKHIR)
                            </td>
                            <td>
                                <input type="number" step="any" name="{{ $prefix }}baki_bank_akhir" class="form-control form-control-sm text-right" value="{{ $sfreport['baki_bank_akhir'] }}">
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>                                                
            <?php if ($insert_permission == 1) { ?>
                <div class="form-actions">                
                    <input type="hidden" name="finance_file_id" value="{{ $finance_file_id }}">
                    <input type="submit" value="Submit" class="btn btn-primary submit_button">
                    <img class="loading" style="display:none;" src="{{asset('assets/common/img/input-spinner.gif')}}"/>
                </div>
            <?php } ?>
        </form>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        calculateSFR();
    });

    function calculateSFR() {
        var sfr_kutipan = $("#financeFileIncome [id=income_total_income_2]").val();
        $('#{{ $prefix }}kutipan').val(parseFloat(sfr_kutipan).toFixed(2));

        var sfr_repair = $("#financeRepairForm [id=repair_singkingfund_total_all]").val();
        $('#{{ $prefix }}repair').val(parseFloat(sfr_repair).toFixed(2));

        var sfr_vandalisme = $("#financeVandalForm [id=singkingfund_total_all]").val();
        $('#{{ $prefix }}vandalisme').val(parseFloat(sfr_vandalisme).toFixed(2));

        var sfr_bayar = document.getElementsByName("{{ $prefix }}amount[]");
        var sfr_bayar_total = 0;
        for (var i = 0; i < sfr_bayar.length; i++) {
            sfr_bayar_total += parseFloat(sfr_bayar[i].value);
            $('#' + sfr_bayar[i].id).val(parseFloat(sfr_bayar[i].value).toFixed(2));
        }
        $('#{{ $prefix }}bayar_total').val(parseFloat(sfr_bayar_total).toFixed(2));

        var sfr_lebihan_kurangan = parseFloat(sfr_kutipan) - parseFloat(sfr_bayar_total);
        $('#{{ $prefix }}lebihan_kurangan').val(parseFloat(sfr_lebihan_kurangan).toFixed(2));
    }

    function addRowSFR() {
        var rowSFRNo = $("#dynamic_form_sfr tr").length;
        rowSFRNo = rowSFRNo - 3;
        $("#dynamic_form_sfr tr:last").prev().prev().prev().after('<tr id="sfr_row' + rowSFRNo + '"><td><input type="hidden" name="{{ $prefix }}is_custom[]" value="1"><input type="hidden" name="{{ $prefix }}report_key[]" value="custom' + rowSFRNo + '">&nbsp;</td><td><input type="text" name="{{ $prefix }}name[]" class="form-control form-control-sm" value=""></td><td><input type="number" step="any" oninput="calculateSFR()" id="{{ $prefix }}amount_' + rowSFRNo + '" name="{{ $prefix }}amount[]" class="form-control form-control-sm text-right numeric-only" value="0"></td><td class="padding-table text-right"><a href="javascript:void(0);" onclick="deleteRowSFR(\'sfr_row' + rowSFRNo + '\')" class="btn btn-danger btn-xs">Remove</a></td></tr>');

        calculateSFR();
    }

    function deleteRowSFR(rowSFRNo) {
        $('#' + rowSFRNo).remove();

        calculateSFR();
    }

    $("#formFinanceSfReport").submit(function (e) {
        e.preventDefault();

        $(".loading").css("display", "inline-block");
        $(".submit_button").attr("disabled", "disabled");
        $("#{{ $prefix }}no_akaun_err").css("display", "none");
        $("#{{ $prefix }}nama_bank_err").css("display", "none");

        var error = 0;

        if ($("#{{ $prefix }}no_akaun").val().trim() == "") {
            $("#{{ $prefix }}no_akaun_err").html('<span style="color:red;font-style:italic;font-size:13px;">Please Enter Account No</span>');
            $("#{{ $prefix }}no_akaun_err").css("display", "block");
            error = 1;
        }

        if ($("#{{ $prefix }}nama_bank").val().trim() == "") {
            $("#{{ $prefix }}nama_bank_err").html('<span style="color:red;font-style:italic;font-size:13px;">Please Enter Bank Name</span>');
            $("#{{ $prefix }}nama_bank_err").css("display", "block");
            error = 1;
        }

        if (error == 0) {
            $.ajax({
                method: "POST",
                url: "{{ URL::action('FinanceController@updateFinanceFileReportSf') }}",
                data: $(this).serialize(),
                success: function (response) {
                    $(".loading").css("display", "none");
                    $(".submit_button").removeAttr("disabled");

                    if (response.trim() == "true") {
                        $.notify({
                            message: '<p style="text-align: center; margin-bottom: 0px;">Successfully saved</p>',
                        }, {
                            type: 'success',
                            placement: {
                                align: "center"
                            }
                        });
                        location = '{{URL::action("FinanceController@editFinanceFileList", [$finance_file_id, "sfreport"]) }}';
                    } else {
                        bootbox.alert("<span style='color:red;'>An error occured while processing. Please try again.</span>");
                    }
                }
            });
        } else {
            $(".loading").css("display", "none");
            $(".submit_button").removeAttr("disabled");
        }
    });
</script>
