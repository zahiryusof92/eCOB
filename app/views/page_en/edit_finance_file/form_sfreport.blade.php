<?php
    $prefix = 'sfr_';
    
    $sfreport = FinanceReportSf::where('finance_file_id', $finance_file_id)->first();
    if(!is_null($sfreport)){
        $sfreport->toArray();
    }
    $sf_sebulan = (isset($sfreport['sinkingfund_sebulan']))? $sfreport['sinkingfund_sebulan'] : 0;
    $sf_unit = (isset($sfreport['unit']))? $sfreport['unit'] : 0;
    $sf_semasa = (isset($sfreport['sinkingfund_semasa']))? $sfreport['sinkingfund_semasa'] : '';
    $sf_no_akaun = (isset($sfreport['no_akaun']))? $sfreport['no_akaun'] : '';
    $sf_nama_bank = (isset($sfreport['nama_bank']))? $sfreport['nama_bank'] : '';
    $sf_baki_bank_akhir = (isset($sfreport['baki_bank_akhir']))? $sfreport['baki_bank_akhir'] : '';
    $sf_baki_bank_awal = (isset($sfreport['baki_bank_awal']))? $sfreport['baki_bank_awal'] : '';

    $report = FinanceReportPerbelanjaan::where('finance_file_id', $finance_file_id)->where('type', 'sf')->orderBy('order', 'asc')->get()->toArray();
    $sfr_total_amount  = 0;
?>

<form id="formFinanceSfReport" method="POST">
    <input type="hidden" name="finance_file_id" value="{{ $finance_file_id }}">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label><span style="color: red;">*</span>JUMLAH UNIT</label>
                <input name="sfr_unit" class="form-control" type="text" value="{{ $sf_unit }}">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label><span style="color: red;">*</span>SINKING FUND SEBULAN (PER UNIT)</label>
                <input name="sfr_sinkingfund_sebulan" class="form-control" type="text" value="{{ $sf_sebulan }}">
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label><span style="color: red;">*</span>JUMLAH DIKUTIP -TUNGGAKAN + SEMASA+ADVANCED [A]</label>
                <input name="sfr_tunggakan" class="form-control" type="text" value="0">
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label><span style="color: red;">*</span>JUMLAH SINKING FUND SEPATUT DIKUTIP SEMASA</label>
                <input name="sfr_semasa" class="form-control" type="text" value="{{ $sf_semasa }}">
            </div>
        </div>

        <div class="col-md-offset-6 col-md-6">
            <div class="form-group">
                <label><span style="color: red;">*</span>JUMLAH SERVICE FEE BERJAYA DIKUTIP SEMASA</label>
                <input name="sinkingfund_semasa_total" class="form-control" type="text" value="{{ $sf_semasa + $sf_sebulan }}" disabled>
            </div>
        </div>

        <hr>
        <table class="table table-bordered">
            <thead>
              <tr>
                <th>JUMLAH PERBELANJAAN</th>
                <th>PERKARA</th>
                <th>JUMLAH (RM)</th>
              </tr>
            </thead>
            <tbody>

                @for($i=0 ; $i < 6 ; $i++)
                    <?php
                        $sfr_name = (isset($report[$i]['name']))? $report[$i]['name'] : '';
                        $sfr_amount = (isset($report[$i]['amount']))? $report[$i]['amount'] : 0;

                        $sfr_total_amount += $sfr_amount;
                    ?>
                    <tr>
                        <td></td>
                        <td><input type="text" name="sf_name[]" class="form-control" value="{{ $sfr_name }}"></td>
                        <td><input type="text" name="sf_amount[]" class="form-control" value="{{ $sfr_amount }}"></td>
                    </tr>
                @endfor
                
                <tr>
                    <td colspan="2" class="text-right">JUMLAH TELAT BAYAR [B]</td>
                    <td><input type="text" name="mfr_telat_total" class="form-control" value="{{ $sfr_total_amount }}" disabled></td>
                </tr>
                <tr>
                    <td colspan="2" class="text-right">LEBIHAN / KURANGAN PENDAPATAN (A) - (B)</td>
                    <td><input type="text" name="mfr_telat_total" class="form-control" value="0"></td>
                </tr>
            </tbody>
          </table>
        
        <div class="col-md-6">
            <div class="form-group">
                <label><span style="color: red;">*</span>NO AKAUN</label>
                <input name="sf_no_akaun" class="form-control" type="text" value="{{ $sf_no_akaun }}">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label><span style="color: red;">*</span>BAKI BANK (AWAL)</label>
                <input name="sf_baki_bank_awal" class="form-control" type="text" value="{{ $sf_baki_bank_awal }}">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label><span style="color: red;">*</span>NAMA BANK</label>
                <input name="sf_nama_bank" class="form-control" type="text" value="{{ $sf_nama_bank }}">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label><span style="color: red;">*</span>BAKI BANK (AKHIR)</label>
                <input name="sf_baki_bank_akhir" class="form-control" type="text" value="{{ $sf_baki_bank_akhir }}">
            </div>
        </div>
        
    </div>                                                
    <div class="form-actions">
        <?php if ($insert_permission == 1) { ?>
        <input type="submit" value="Submit" class="btn btn-primary">
         <?php } ?>
    </div>
</form>
<script>

    $(document).ready(function(){
        let tunggakan = 
        $("#formFinanceSfReport [name=sfr_tunggakan]").val(tunggakan);
    });
    $(".numeric-only").on('keypress', function(e){
        var keyCode = e.which ? e.which : e.keyCode;
        if (!(keyCode >= 48 && keyCode <= 57)) {
            return false;
        }
    });
    
    $("#formFinanceSfReport").submit(function(e){
        e.preventDefault();

        $.ajax({
            method: "POST",
            url: "{{ URL::action('FinanceController@updateFinanceFileReportSf') }}",
            data: $(this).serialize(),
            beforeSend : function(){
                $("#btnSubmitFileAdmin").html('Loading').prop('disabled', true);
            },
            complete:function(data){
                // Hide image container
                $("#btnSubmitFileAdmin").html('Submit').prop('disabled', false);
            },
            success: function (response) {
                if (response.trim() == "true") {
                    bootbox.alert("<span style='color:green;'>Finance Support SF added successfully!</span>");
                } else {
                    bootbox.alert("<span style='color:red;'>An error occured while processing. Please try again.</span>");
                }
                console.log(response);
            }
        });
    })
</script>
