<?php
$prefix = 'mfr_';
$tableField = [
    'utiliti' => 'UTILITI (BAHAGIAN A SAHAJA)',
    'penyenggaraan' => 'PENYENGGARAAN',
    'perbelanjaan1' => 'PEMBAIKAN/PENGGANTIAN/PEMBELIAN/NAIKTARAF/PEMBAHARUAN',
    'perbelanjaan2' => 'PEMBAIKAN/PENGGANTIAN/PEMBELIAN (VANDALISME)',
    'pekerja' => 'PEKERJA',
    'pentadbiran' => 'PENTADBIRAN',
    'jumlah' => 'JUMLAH TELAH BAYAR [B]'
];


$mfreport = FinanceReportMf::where('finance_file_id', $finance_file_id)->first();
if (!is_null($mfreport)) {
    $mfreport->toArray();
}
$mf_sebulan = (isset($mfreport['maintenance_fee_sebulan'])) ? $mfreport['maintenance_fee_sebulan'] : 0;
$mf_unit = (isset($mfreport['unit'])) ? $mfreport['unit'] : 0;
$mf_semasa = (isset($mfreport['servicefee_semasa'])) ? $mfreport['servicefee_semasa'] : '';
$mf_no_akaun = (isset($mfreport['no_akaun'])) ? $mfreport['no_akaun'] : '';
$mf_nama_bank = (isset($mfreport['nama_bank'])) ? $mfreport['nama_bank'] : '';
$mf_baki_bank_akhir = (isset($mfreport['baki_bank_akhir'])) ? $mfreport['baki_bank_akhir'] : '';
$mf_baki_bank_awal = (isset($mfreport['baki_bank_awal'])) ? $mfreport['baki_bank_awal'] : '';

$report = FinanceReportPerbelanjaan::where('finance_file_id', $finance_file_id)->where('type', 'mf')->orderBy('order', 'asc')->get()->toArray();
$mfr_total_amount = 0;
?>

<div class="tab-content padding-vertical-20">
    <div class="tab-pane active" id="buyer_tab" role="tabpanel">
        <div class="row">
            <div class="col-lg-12">

                <h6>1. LAPORAN RINGKAS PENCAPAIAN KUTIPAN CAJ PENYENGGARAAN (MAINTENANCE FEE)</h6>

                <form id="formFinanceMfReport" class="form-horizontal" method="POST">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label style="color: red; font-style: italic;">* Mandatory Fields</label>
                            </div>
                        </div>
                    </div>                    
                    <div class="row">
                        <table class="table table-sm">
                            <tbody>
                                <tr>
                                    <td width="30%">
                                        <span style="color: red;">*</span> MAINTENANCE FEE SEBULAN (PER UNIT)
                                    </td>
                                    <td width="20%">
                                        <input name="mfr_maintenance_fee_sebulan" class="form-control" type="text" value="{{ $mf_sebulan }}">
                                    </td>
                                    <td width="5%">&nbsp;</td>
                                    <td width="25%">
                                        <span style="color: red;">*</span> JUMLAH UNIT
                                    </td>
                                    <td width="20%">
                                        <input name="mfr_unit" class="form-control" type="text" value="{{ $mf_unit }}">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        JUMLAH DIKUTIP -TUNGGAKAN + SEMASA+ADVANCED [A]
                                    </td>
                                    <td>
                                        <input name="mfr_tunggakan" class="form-control" type="text" value="0">
                                    </td>
                                    <td>&nbsp;</td>
                                    <td>
                                        <span style="color: red;">*</span> JUMLAH SERVICE FEE SEPATUT DIKUTIP SEMASA
                                    </td>
                                    <td>
                                        <input name="mfr_semasa" class="form-control" type="text" value="{{ $mf_semasa }}">
                                    </td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>
                                        <span style="color: red;">*</span> JUMLAH SERVICE FEE BERJAYA DIKUTIP SEMASA
                                    </td>
                                    <td>
                                        <input name="maintenance_fee_semasa_total" class="form-control" type="text" value="{{ $mf_semasa + $mf_sebulan }}" disabled="">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <hr>

                    <div class="row">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th width="30%">JUMLAH PERBELANJAAN</th>
                                    <th width="50%">PERKARA</th>
                                    <th width="20%">JUMLAH (RM)</th>
                                </tr>
                            </thead>
                            <tbody>

                                @for($i=0 ; $i < 6 ; $i++)
                                <?php
                                $mfr_name = (isset($report[$i]['name'])) ? $report[$i]['name'] : '';
                                $mfr_amount = (isset($report[$i]['amount'])) ? $report[$i]['amount'] : 0;

                                $mfr_total_amount += $mfr_amount;
                                ?>
                                <tr>
                                    <td></td>
                                    <td><input type="text" name="mf_name[]" class="form-control" value="{{ $mfr_name }}"></td>
                                    <td><input type="text" name="mf_amount[]" class="form-control" value="{{ $mfr_amount }}"></td>
                                </tr>
                                @endfor

                                <tr>
                                    <td colspan="2" class="text-right">JUMLAH TELAT BAYAR [B]</td>
                                    <td><input type="text" name="mfr_telat_total" class="form-control" value="{{ $mfr_total_amount }}" disabled></td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="text-right">LEBIHAN / KURANGAN PENDAPATAN (A) - (B)</td>
                                    <td><input type="text" name="mfr_telat_total" class="form-control" value="0"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label><span style="color: red;">*</span>NO AKAUN</label>
                            <input name="mf_no_akaun" class="form-control" type="text" value="{{ $mf_no_akaun }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><span style="color: red;">*</span>BAKI BANK (AWAL)</label>
                            <input name="mf_baki_bank_awal" class="form-control" type="text" value="{{ $mf_baki_bank_awal }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><span style="color: red;">*</span>NAMA BANK</label>
                            <input name="mf_nama_bank" class="form-control" type="text" value="{{ $mf_nama_bank }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><span style="color: red;">*</span>BAKI BANK (AKHIR)</label>
                            <input name="mf_baki_bank_akhir" class="form-control" type="text" value="{{ $mf_baki_bank_akhir }}">
                        </div>
                    </div>

            </div>                                                
            <div class="form-actions">
                <input type="hidden" name="finance_file_id" value="{{ $finance_file_id }}">
                <?php if ($insert_permission == 1) { ?>
                    <input type="submit" value="Submit" class="btn btn-primary">
                <?php } ?>
            </div>
            </form>
        </div>
    </div>
</div>
</div>

<script>
    $(".numeric-only").on('keypress', function (e) {
        var keyCode = e.which ? e.which : e.keyCode;
        if (!(keyCode >= 48 && keyCode <= 57)) {
            return false;
        }
    });

    $("#formFinanceMfReport").submit(function (e) {
        e.preventDefault();

        $.ajax({
            method: "POST",
            url: "{{ URL::action('FinanceController@updateFinanceFileReportMf') }}",
            data: $(this).serialize(),
            beforeSend: function () {
                $("#btnSubmitFileAdmin").html('Loading').prop('disabled', true);
            },
            complete: function (data) {
                // Hide image container
                $("#btnSubmitFileAdmin").html('Submit').prop('disabled', false);
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
                console.log(response);
            }
        });
    })
</script>
