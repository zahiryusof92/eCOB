<?php
    $prefix = 'mfr_';
    
    $mfreport = FinanceReportMf::where('finance_file_id', $finance_file_id)->first();
    if(!is_null($mfreport)){
        $mfreport->toArray();
    }
    $mf_sebulan = (isset($mfreport['maintenance_fee_sebulan']))? $mfreport['maintenance_fee_sebulan'] : 0;
    $mf_unit = (isset($mfreport['unit']))? $mfreport['unit'] : 0;
    $mf_semasa = (isset($mfreport['servicefee_semasa']))? $mfreport['servicefee_semasa'] : '';
    $mf_no_akaun = (isset($mfreport['no_akaun']))? $mfreport['no_akaun'] : '';
    $mf_nama_bank = (isset($mfreport['nama_bank']))? $mfreport['nama_bank'] : '';
    $mf_baki_bank_akhir = (isset($mfreport['baki_bank_akhir']))? $mfreport['baki_bank_akhir'] : '';
    $mf_baki_bank_awal = (isset($mfreport['baki_bank_awal']))? $mfreport['baki_bank_awal'] : '';

    $report = FinanceReportPerbelanjaan::where('finance_file_id', $finance_file_id)->where('type', 'mf')->orderBy('order', 'asc')->get()->toArray();
    $mfr_total_amount  = 0;
?>

<form id="formFinanceMfReport" method="POST">
    <input type="hidden" name="finance_file_id" value="{{ $finance_file_id }}">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label><span style="color: red;">*</span>JUMLAH UNIT</label>
                <input name="mfr_unit" class="form-control" type="text" value="{{ $mf_unit }}">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label><span style="color: red;">*</span>MAINTENANCE FEE SEBULAN (PER UNIT)</label>
                <input name="mfr_maintenance_fee_sebulan" class="form-control" type="text" value="{{ $mf_sebulan }}">
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label><span style="color: red;">*</span>JUMLAH DIKUTIP -TUNGGAKAN + SEMASA+ADVANCED [A]</label>
                <input name="mfr_tunggakan" class="form-control" type="text" value="0">
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label><span style="color: red;">*</span>JUMLAH SERVICE FEE SEPATUT DIKUTIP SEMASA</label>
                <input name="mfr_semasa" class="form-control" type="text" value="{{ $mf_semasa }}" disabled>
            </div>
        </div>

        <div class="col-md-offset-6 col-md-6">
            <div class="form-group">
                <label><span style="color: red;">*</span>JUMLAH SERVICE FEE BERJAYA DIKUTIP SEMASA</label>
                <input name="maintenance_fee_semasa_total" class="form-control" type="text" value="{{ $mf_semasa + $mf_sebulan }}">
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
                        $mfr_name = (isset($report[$i]['name']))? $report[$i]['name'] : '';
                        $mfr_amount = (isset($report[$i]['amount']))? $report[$i]['amount'] : 0;

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
        <?php if ($insert_permission == 1) { ?>
        <input type="submit" value="Submit" class="btn btn-primary">
         <?php } ?>
    </div>
</form>
<script>
    $(".numeric-only").on('keypress', function(e){
        var keyCode = e.which ? e.which : e.keyCode;
        if (!(keyCode >= 48 && keyCode <= 57)) {
            return false;
        }
    });

    $("#formFinanceMfReport").submit(function(e){
        e.preventDefault();

        $.ajax({
            method: "POST",
            url: "{{ URL::action('FinanceController@updateFinanceFileReportMf') }}",
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
