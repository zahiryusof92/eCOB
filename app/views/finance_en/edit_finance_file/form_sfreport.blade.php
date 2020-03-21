<?php
$prefix = 'sfr_';

$sf_sebulan = (isset($sfreport['sinkingfund_sebulan'])) ? $sfreport['sinkingfund_sebulan'] : 0;
$sf_unit = (isset($sfreport['unit'])) ? $sfreport['unit'] : 0;
$sf_semasa = (isset($sfreport['sinkingfund_semasa'])) ? $sfreport['sinkingfund_semasa'] : '';
$sf_no_akaun = (isset($sfreport['no_akaun'])) ? $sfreport['no_akaun'] : '';
$sf_nama_bank = (isset($sfreport['nama_bank'])) ? $sfreport['nama_bank'] : '';
$sf_baki_bank_akhir = (isset($sfreport['baki_bank_akhir'])) ? $sfreport['baki_bank_akhir'] : '';
$sf_baki_bank_awal = (isset($sfreport['baki_bank_awal'])) ? $sfreport['baki_bank_awal'] : '';

$sfr_total_amount = 0;
?>

<div class="row">
    <div class="col-lg-12">

        <h6>2. LAPORAN RINGKAS PENCAPAIAN KUTIPAN KUMPULAN WANG PENJELAS (SINGKING FUND)</h6>

        <form id="formFinanceSfReport" class="form-horizontal" method="POST">                                
            <div class="row">
                <table class="table table-sm">
                    <tbody>
                        <tr>
                            <td width="20%">
                                <span style="color: red;">*</span>SINKING FUND SEBULAN (PER UNIT)
                            </td>
                            <td width="30%">
                                <input name="{{ $prefix }}sinkingfund_sebulan" class="form-control" type="text" value="{{ number_format($sf_sebulan, 2) }}">
                            </td>
                            <td width="5%">&nbsp;</td>
                            <td width="25%">
                                <span style="color: red;">*</span> JUMLAH UNIT
                            </td>
                            <td width="20%">
                                <input name="{{ $prefix }}unit" class="form-control" type="text" value="{{ $sf_unit }}">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                JUMLAH DIKUTIP (TUNGGAKAN + SEMASA + ADVANCED [A])
                            </td>
                            <td>
                                <input name="{{ $prefix }}kutipan" class="form-control" type="text" value="0.00">
                            </td>
                            <td>&nbsp;</td>
                            <td>
                                <span style="color: red;">*</span>JUMLAH SINKING FUND SEPATUT DIKUTIP SEMASA
                            </td>
                            <td>
                                <input name="{{ $prefix }}semasa" class="form-control" type="text" value="{{ number_format($sf_semasa, 2) }}">
                            </td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>
                                JUMLAH SERVICE FEE BERJAYA DIKUTIP SEMASA
                            </td>
                            <td>
                                <input name="sinkingfund_semasa_total" class="form-control" type="text" value="{{ number_format($sf_semasa + $sf_sebulan, 2) }}" readonly="">
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <hr>

            <div class="row">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th width="20%" style="text-align: center">JUMLAH PERBELANJAAN</th>
                            <th width="60%" style="text-align: center">PERKARA</th>
                            <th width="20%" style="text-align: center">JUMLAH (RM)</th>
                        </tr>
                    </thead>
                    <tbody>

                        @for($i=0 ; $i < count($reportSF) ; $i++)
                        <?php
                        $sfr_name = (isset($reportSF[$i]['name'])) ? $reportSF[$i]['name'] : '';
                        $sfr_amount = (isset($reportSF[$i]['amount'])) ? $reportSF[$i]['amount'] : 0;

                        $sfr_total_amount += $sfr_amount;
                        ?>
                        <tr>
                            <td>&nbsp;</td>
                            <td><input type="text" name="sf_name[]" class="form-control" value="{{ $sfr_name }}" readonly=""></td>
                            <td><input type="text" name="sf_amount[]" class="form-control" value="{{ number_format($sfr_amount, 2) }}" readonly=""></td>
                        </tr>
                        @endfor

                        <tr>
                            <td>&nbsp;</td>
                            <td class="padding-form">JUMLAH TELAH BAYAR [B]</td>
                            <td><input type="text" name="{{ $prefix }}bayar_total" class="form-control" value="{{ number_format($sfr_total_amount, 2) }}" readonly=""></td>
                        </tr>

                        <tr>
                            <td class="padding-table" colspan="2">LEBIHAN / KURANGAN PENDAPATAN (A) - (B)</td>
                            <td><input type="text" name="{{ $prefix }}lebihan_kurangan" class="form-control" value="0.00" readonly=""></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <hr/>

            <div class="row">
                <table class="table table-sm">
                    <tbody>
                        <tr>
                            <td width="20%">
                                <span style="color: red;">*</span> NO AKAUN
                            </td>
                            <td width="30%">
                                <input name="sf_no_akaun" class="form-control" type="text" value="{{ $sf_no_akaun }}">
                            </td>
                            <td width="5%">&nbsp;</td>
                            <td width="25%">  
                                <span style="color: red;">*</span> BAKI BANK (AWAL)
                            </td>
                            <td width="20%">  
                                <input name="sf_baki_bank_awal" class="form-control" type="text" value="{{ $sf_baki_bank_awal }}">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span style="color: red;">*</span> NAMA BANK
                            </td>
                            <td>
                                <input name="sf_nama_bank" class="form-control" type="text" value="{{ $sf_nama_bank }}">
                            </td>
                            <td>&nbsp;</td>
                            <td>
                                <span style="color: red;">*</span> BAKI BANK (AKHIR)
                            </td>
                            <td>
                                <input name="sf_baki_bank_akhir" class="form-control" type="text" value="{{ $sf_baki_bank_akhir }}">
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>                                                
            <div class="form-actions">
                <input type="hidden" name="finance_file_id" value="{{ $finance_file_id }}">
                <?php if ($insert_permission == 1) { ?>
                    <input type="submit" value="Submit" class="btn btn-primary submit_button">
                <?php } ?>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function () {
        let tunggakan = $("#formFinanceSfReport [name=sfr_kutipan]").val();
    });

    $("#formFinanceSfReport").submit(function (e) {
        e.preventDefault();

        $.ajax({
            method: "POST",
            url: "{{ URL::action('FinanceController@updateFinanceFileReportSf') }}",
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
