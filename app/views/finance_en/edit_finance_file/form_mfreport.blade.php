<?php
$prefix = 'mfr_';

$mfr_sebulan = (isset($mfreport['fee_sebulan'])) ? $mfreport['fee_sebulan'] : 0;
$mfr_unit = (isset($mfreport['unit'])) ? $mfreport['unit'] : 0;
$mfr_semasa = (isset($mfreport['fee_semasa'])) ? $mfreport['fee_semasa'] : 0;
$mfr_no_akaun = (isset($mfreport['no_akaun'])) ? $mfreport['no_akaun'] : '';
$mfr_nama_bank = (isset($mfreport['nama_bank'])) ? $mfreport['nama_bank'] : '';
$mfr_baki_bank_akhir = (isset($mfreport['baki_bank_akhir'])) ? $mfreport['baki_bank_akhir'] : '';
$mfr_baki_bank_awal = (isset($mfreport['baki_bank_awal'])) ? $mfreport['baki_bank_awal'] : '';

$mfr_total_amount = 0;
?>

<div class="row">
    <div class="col-lg-12">

        <h6>1. LAPORAN RINGKAS PENCAPAIAN KUTIPAN CAJ PENYENGGARAAN (MAINTENANCE FEE)</h6>

        <form id="formFinanceMfReport" class="form-horizontal" method="POST">                   
            <div class="row">
                <table class="table table-sm" style="font-size: 12px;">
                    <tbody>
                        <tr>
                            <td width="20%">
                                <span style="color: red;">*</span> MAINTENANCE FEE SEBULAN (PER UNIT)
                            </td>
                            <td width="30%">
                                <input name="{{ $prefix }}fee_sebulan" class="form-control form-control-sm" type="text" value="{{ number_format($mfr_sebulan, 2) }}">
                            </td>
                            <td width="5%">&nbsp;</td>
                            <td width="25%">
                                <span style="color: red;">*</span> JUMLAH UNIT
                            </td>
                            <td width="20%">
                                <input name="{{ $prefix }}unit" class="form-control form-control-sm" type="text" value="{{ $mfr_unit }}">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                JUMLAH DIKUTIP (TUNGGAKAN + SEMASA + ADVANCED [A])
                            </td>
                            <td>
                                <input name="{{ $prefix }}kutipan" class="form-control form-control-sm" type="text" value="0.00">
                            </td>
                            <td>&nbsp;</td>
                            <td>
                                <span style="color: red;">*</span> JUMLAH SERVICE FEE SEPATUT DIKUTIP SEMASA
                            </td>
                            <td>
                                <input name="{{ $prefix }}fee_semasa" class="form-control form-control-sm" type="text" value="{{ number_format($mfr_semasa, 2) }}">
                            </td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <th>
                                JUMLAH SERVICE FEE BERJAYA DIKUTIP SEMASA
                            </th>
                            <th>
                                <input name="{{ $prefix }}semasa_total" class="form-control form-control-sm" type="text" value="{{ number_format($mfr_semasa + $mfr_sebulan, 2) }}" readonly="">
                            </th>
                        </tr>
                    </tbody>
                </table>
            </div>

            <hr>

            <div class="row">
                <table class="table table-sm" style="font-size: 12px;">
                    <thead>
                        <tr>
                            <th width="20%" style="text-align: center">JUMLAH PERBELANJAAN</th>
                            <th width="60%" style="text-align: center">PERKARA</th>
                            <th width="20%" style="text-align: center">JUMLAH (RM)</th>
                        </tr>
                    </thead>
                    <tbody>

                        @for($i=0 ; $i < count($reportMF) ; $i++)
                        <?php
                        $mfr_name = (isset($reportMF[$i]['name'])) ? $reportMF[$i]['name'] : '';
                        $mfr_amount = (isset($reportMF[$i]['amount'])) ? $reportMF[$i]['amount'] : 0;

                        $mfr_total_amount += $mfr_amount;
                        ?>
                        <tr>
                            <td>&nbsp;</td>
                            <td><input type="text" name="{{ $prefix }}name[]" class="form-control form-control-sm" value="{{ $mfr_name }}" readonly=""></td>
                            <td><input type="text" name="{{ $prefix }}amount[]" class="form-control form-control-sm" value="{{ number_format($mfr_amount, 2) }}" readonly=""></td>
                        </tr>
                        @endfor

                        <tr>
                            <td>&nbsp;</td>
                            <td class="padding-form">JUMLAH TELAH BAYAR [B]</td>
                            <td><input type="text" name="{{ $prefix }}bayar_total" class="form-control form-control-sm" value="{{ number_format($mfr_total_amount, 2) }}" readonly=""></td>
                        </tr>

                        <tr>
                            <td class="padding-table" colspan="2">LEBIHAN / KURANGAN PENDAPATAN (A) - (B)</td>
                            <td><input type="text" name="{{ $prefix }}lebihan_kurangan" class="form-control form-control-sm" value="0.00" readonly=""></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <hr/>

            <div class="row">
                <table class="table table-sm" style="font-size: 12px;">
                    <tbody>
                        <tr>
                            <td width="20%">
                                <span style="color: red;">*</span> NO AKAUN
                            </td>
                            <td width="30%">
                                <input name="{{ $prefix }}no_akaun" class="form-control form-control-sm" type="text" value="{{ $mfr_no_akaun }}">
                            </td>
                            <td width="5%">&nbsp;</td>
                            <td width="25%">  
                                <span style="color: red;">*</span> BAKI BANK (AWAL)
                            </td>
                            <td width="20%">  
                                <input name="{{ $prefix }}baki_bank_awal" class="form-control form-control-sm" type="text" value="{{ $mfr_baki_bank_awal }}">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span style="color: red;">*</span> NAMA BANK
                            </td>
                            <td>
                                <input name="{{ $prefix }}nama_bank" class="form-control form-control-sm" type="text" value="{{ $mfr_nama_bank }}">
                            </td>
                            <td>&nbsp;</td>
                            <td>
                                <span style="color: red;">*</span> BAKI BANK (AKHIR)
                            </td>
                            <td>
                                <input name="{{ $prefix }}baki_bank_akhir" class="form-control form-control-sm" type="text" value="{{ $mfr_baki_bank_akhir }}">
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>                                        
            <div class="form-actions">                
                <?php if ($insert_permission == 1) { ?>
                    <input type="hidden" name="finance_file_id" value="{{ $finance_file_id }}">
                    <input type="submit" value="Submit" class="btn btn-primary submit_button">
                <?php } ?>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function () {
        let tunggakan = $("#formFinanceMfReport [name=mfr_kutipan]").val();
    });

    $("#formFinanceMfReport").submit(function (e) {
        e.preventDefault();

        $.ajax({
            method: "POST",
            url: "{{ URL::action('FinanceController@updateFinanceFileReportMf') }}",
            data: $(this).serialize(),
            beforeSend: function () {
                $(".submit_button").html('Loading').prop('disabled', true);
            },
            complete: function () {
                // Hide image container
                $(".submit_button").html('Submit').prop('disabled', false);
            },
            success: function (response) {
                if (response.trim() == "true") {
                    $.notify({
                        message: '<p style="text-align: center; margin-bottom: 0px;">Successfully saved</p>',
                    }, {
                        type: 'success',
                        placement: {
                            align: "center"
                        }
                    });
                    location.reload();
                } else {
                    bootbox.alert("<span style='color:red;'>An error occured while processing. Please try again.</span>");
                }
            }
        });
    });
</script>
