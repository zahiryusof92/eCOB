<?php
$prefix = 'repair_maintenancefee_';
$prefix2 = 'repair_singkingfund_';
?>

<div class="row">
    <div class="col-lg-12">
        <form id="financeRepairForm" method="POST">
            
            <h6>4.3 PEMBAIKAN/PENGGANTIAN/PEMBELIAN/NAIKTARAF/PEMBAHARUAN a. Guna Duit Maintenance Fee</h6>
            
            <div class="row">
                <table class="table table-sm" id="dynamic_form_repair_a" style="font-size: 12px;">
                    <thead>
                        <tr>
                            <th width="5%">&nbsp;</th>
                            <th width="40%" style="text-align: center;">PERKARA</th>
                            <th width="10%" style="text-align: center;">TUNGGAKAN BULAN-BULAN TERDAHULU<br/>A</th>
                            <th width="10%" style="text-align: center;">BULAN SEMASA<br/>B</th>
                            <th width="10%" style="text-align: center;">BULAN HADAPAN<br/>C</th>
                            <th width="10%" style="text-align: center;">JUMLAH<br/>A + B + C</th>
                            <th width="10%" style="text-align: center;">JUMLAH<br/>BAKI BAYARAN MASIH TERTUNGGAK<br/>(BELUM BAYAR)</th>
                            <td width="5%" style="text-align: center;">&nbsp;</td> 
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $count = 0;
                        $total_tunggakan = 0;
                        $total_semasa = 0;
                        $total_hadapan = 0;
                        $total_tertunggak = 0;
                        $total_all = 0;
                        ?>

                        @foreach ($repaira as $repairas)
                        <?php
                        $total_tunggakan += $repairas['tunggakan'];
                        $total_semasa += $repairas['semasa'];
                        $total_hadapan += $repairas['hadapan'];
                        $total_tertunggak += $repairas['tertunggak'];
                        $total_income = $repairas['tunggakan'] + $repairas['semasa'] + $repairas['hadapan'];
                        $total_all += $total_income;
                        ?>                        
                        <tr id="repaira_row{{ ++$count }}">
                            <td class="text-center padding-table">{{ $count }}</td>
                            <td><input type="text" name="{{ $prefix }}name[]" class="form-control form-control-sm" value="{{ $repairas['name'] }}" readonly=""></td>
                            <td><input type="text" name="{{ $prefix }}tunggakan[]" class="form-control form-control-sm text-right numeric-only" value="{{ number_format($repairas['tunggakan'], 2) }}"></td>
                            <td><input type="text" name="{{ $prefix }}semasa[]" class="form-control form-control-sm text-right numeric-only" value="{{ number_format($repairas['semasa'], 2) }}"></td>
                            <td><input type="text" name="{{ $prefix }}hadapan[]" class="form-control form-control-sm text-right numeric-only" value="{{ number_format($repairas['hadapan'], 2) }}"></td>
                            <td><input type="text" name="{{ $prefix }}total_all[]" class="form-control form-control-sm text-right numeric-only" value="{{ number_format($total_income, 2) }}" readonly=""></td>
                            <td><input type="text" name="{{ $prefix }}tertunggak[]" class="form-control form-control-sm text-right numeric-only" value="{{ number_format($repairas['tertunggak'], 2) }}"></td>
                            <td>&nbsp;</td>
                        </tr>
                        @endforeach
                        
                        <tr id="repaira_row{{ ++$count }}">
                            <td class="text-center padding-table">{{ $count }}</td>
                            <td><input type="text" name="{{ $prefix }}name[]" class="form-control form-control-sm" value=""></td>
                            <td><input type="text" name="{{ $prefix }}tunggakan[]" class="form-control form-control-sm text-right numeric-only" value="{{ number_format(0, 2) }}"></td>
                            <td><input type="text" name="{{ $prefix }}semasa[]" class="form-control form-control-sm text-right numeric-only" value="{{ number_format(0, 2) }}"></td>
                            <td><input type="text" name="{{ $prefix }}hadapan[]" class="form-control form-control-sm text-right numeric-only" value="{{ number_format(0, 2) }}"></td>
                            <td><input type="text" name="{{ $prefix }}total_all[]" class="form-control form-control-sm text-right numeric-only" value="{{ number_format(0, 2) }}" readonly=""></td>
                            <td><input type="text" name="{{ $prefix }}tertunggak[]" class="form-control form-control-sm text-right numeric-only" value="{{ number_format(0, 2) }}"></td>
                            <td class="padding-table"><a href="javascript:void(0);" onclick="addRowRepairA()" class="btn btn-primary btn-xs">Add More</a></td>
                        </tr>

                        <tr>
                            <td>&nbsp;</td>
                            <td class="padding-form">JUMLAH</td>
                            <td><input type="text" class="form-control form-control-sm text-right" value="{{ number_format($total_tunggakan, 2) }}" readonly=""></td>
                            <td><input type="text" class="form-control form-control-sm text-right" value="{{ number_format($total_semasa, 2) }}" readonly=""></td>
                            <td><input type="text" class="form-control form-control-sm text-right" value="{{ number_format($total_hadapan, 2) }}" readonly=""></td>
                            <td><input type="text" class="form-control form-control-sm text-right" value="{{ number_format($total_all, 2) }}" readonly=""></td>
                            <td><input type="text" class="form-control form-control-sm text-right" value="{{ number_format($total_tertunggak, 2) }}" readonly=""></td>
                            <td>&nbsp;</td>
                        </tr>
                    </tbody>
                </table> 
            </div>

            <hr/>

            <h6>4.3 PEMBAIKAN/PENGGANTIAN/PEMBELIAN/NAIKTARAF/PEMBAHARUAN b. Guna Duit Sinking Fund</h6>
            
            <div class="row">
                <table class="table table-sm" id="dynamic_form_repair_b" style="font-size: 12px;">
                    <thead>
                        <tr>
                            <th width="5%">&nbsp;</th>
                            <th width="40%" style="text-align: center;">PERKARA</th>
                            <th width="10%" style="text-align: center;">TUNGGAKAN BULAN-BULAN TERDAHULU<br/>A</th>
                            <th width="10%" style="text-align: center;">BULAN SEMASA<br/>B</th>
                            <th width="10%" style="text-align: center;">BULAN HADAPAN<br/>C</th>
                            <th width="10%" style="text-align: center;">JUMLAH<br/>A + B + C</th>
                            <th width="10%" style="text-align: center;">JUMLAH<br/>BAKI BAYARAN MASIH TERTUNGGAK<br/>(BELUM BAYAR)</th>
                            <td width="5%" style="text-align: center;">&nbsp;</td> 
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $countb = 0;
                        $totalb_tunggakan = 0;
                        $totalb_semasa = 0;
                        $totalb_hadapan = 0;
                        $totalb_tertunggak = 0;
                        $totalb_income = 0;
                        $totalb_all = 0;
                        ?>

                        @foreach ($repairb as $repairbs)
                        <?php
                        $totalb_tunggakan += $repairbs['tunggakan'];
                        $totalb_semasa += $repairbs['semasa'];
                        $totalb_hadapan += $repairbs['hadapan'];
                        $totalb_tertunggak += $repairbs['tertunggak'];
                        $totalb_income += $repairbs['tunggakan'] + $repairbs['semasa'] + $repairbs['hadapan'];
                        $totalb_all += $totalb_income;
                        ?>
                        <tr id="repairb_row{{ ++$countb }}">
                            <td class="text-center padding-table">{{ $countb }}</td>
                            <td><input type="text" name="{{ $prefix2 }}name[]" class="form-control form-control-sm" value="{{ $repairbs['name'] }}" readonly=""></td>
                            <td><input type="text" name="{{ $prefix2 }}tunggakan[]" class="form-control form-control-sm text-right numeric-only" value="{{ number_format($repairbs['tunggakan'], 2) }}"></td>
                            <td><input type="text" name="{{ $prefix2 }}semasa[]" class="form-control form-control-sm text-right numeric-only" value="{{ number_format($repairbs['semasa'], 2) }}"></td>
                            <td><input type="text" name="{{ $prefix2 }}hadapan[]" class="form-control form-control-sm text-right numeric-only" value="{{ number_format($repairbs['hadapan'], 2) }}"></td>
                            <td><input type="text" name="{{ $prefix2 }}total_all[]" class="form-control form-control-sm text-right numeric-only" value="{{ number_format($totalb_income, 2) }}" readonly=""></td>
                            <td><input type="text" name="{{ $prefix2 }}tertunggak[]" class="form-control form-control-sm text-right numeric-only" value="{{ number_format($repairbs['tertunggak'], 2) }}"></td>
                            <td>&nbsp;</td>
                        </tr>
                        @endforeach

                        <tr id="repairb_row{{ ++$countb }}">
                            <td class="text-center padding-table">{{ $countb }}</td>
                            <td><input type="text" name="{{ $prefix2 }}name[]" class="form-control form-control-sm" value=""></td>
                            <td><input type="text" name="{{ $prefix2 }}tunggakan[]" class="form-control form-control-sm text-right numeric-only" value="{{ number_format(0, 2) }}"></td>
                            <td><input type="text" name="{{ $prefix2 }}semasa[]" class="form-control form-control-sm text-right numeric-only" value="{{ number_format(0, 2) }}"></td>
                            <td><input type="text" name="{{ $prefix2 }}hadapan[]" class="form-control form-control-sm text-right numeric-only" value="{{ number_format(0, 2) }}"></td>
                            <td><input type="text" name="{{ $prefix2 }}total_all[]" class="form-control form-control-sm text-right numeric-only" value="{{ number_format(0, 2) }}" readonly=""></td>
                            <td><input type="text" name="{{ $prefix2 }}tertunggak[]" class="form-control form-control-sm text-right numeric-only" value="{{ number_format(0, 2) }}"></td>
                            <td class="padding-table"><a href="javascript:void(0);" onclick="addRowRepairB()" class="btn btn-primary btn-xs">Add More</a></td>
                        </tr>

                        <tr>
                            <td>&nbsp;</td>
                            <td class="padding-form">JUMLAH</td>
                            <td><input type="text" class="form-control form-control-sm text-right" value="{{ number_format($totalb_tunggakan, 2) }}" readonly=""></td>
                            <td><input type="text" class="form-control form-control-sm text-right" value="{{ number_format($totalb_semasa, 2) }}" readonly=""></td>
                            <td><input type="text" class="form-control form-control-sm text-right" value="{{ number_format($totalb_hadapan, 2) }}" readonly=""></td>
                            <td><input type="text" class="form-control form-control-sm text-right" value="{{ number_format($totalb_income, 2) }}" readonly=""></td>
                            <td><input type="text" class="form-control form-control-sm text-right" value="{{ number_format($totalb_tertunggak, 2) }}" readonly=""></td>
                            <td>&nbsp;</td>
                        </tr>
                    </tbody>
                </table>   
            </div>

            <div class="form-actions">
                <?php if ($insert_permission == 1) { ?>
                    <input type="hidden" name="finance_file_id" value="{{$finance_file_id}}">
                    <input type="submit" value="Submit" class="btn btn-primary submit_button">
                <?php } ?>
            </div>
        </form>
    </div>
</div>

<script>
    function addRowRepairA() {
        var rowRepairANo = $("#dynamic_form_repair_a tr").length;        
        rowRepairANo = rowRepairANo - 1;
        $("#dynamic_form_repair_a tr:last").prev().after("<tr id='repaira_row" + rowRepairANo + "'><td class='text-center padding-table'>" + rowRepairANo + "</td><td><input type='text' name='{{ $prefix }}name[]' class='form-control form-control-sm' value=''></td><td><input type='text' name='{{ $prefix }}tunggakan[]' class='form-control form-control-sm text-right numeric-only' value='{{ number_format(0, 2) }}'></td><td><input type='text' name='{{ $prefix }}semasa[]' class='form-control form-control-sm text-right numeric-only' value='{{ number_format(0, 2) }}'></td><td><input type='text' name='{{ $prefix }}hadapan[]' class='form-control form-control-sm text-right numeric-only' value='{{ number_format(0, 2) }}'></td><td><input type='text' name='{{ $prefix }}total_all[]' class='form-control form-control-sm text-right numeric-only' value='{{ number_format(0, 2) }}' readonly=''></td><td><input type='text' name='{{ $prefix }}tertunggak[]' class='form-control form-control-sm text-right numeric-only' value='{{ number_format(0, 2) }}'></td><td class='padding-table'><a href='javascript:void(0);' onclick=deleteRowRepairA('repaira_row" + rowRepairANo + "') class='btn btn-danger btn-xs'>Remove</a></td></tr>");
    }

    function deleteRowRepairA(rowRepairANo) {
        $('#' + rowRepairANo).remove();
    }
    
    function addRowRepairB() {
        var rowRepairBNo = $("#dynamic_form_repair_b tr").length;        
        rowRepairBNo = rowRepairBNo - 1;
        $("#dynamic_form_repair_b tr:last").prev().after("<tr id='repairb_row" + rowRepairBNo + "'><td class='text-center padding-table'>" + rowRepairBNo + "</td><td><input type='text' name='{{ $prefix2 }}name[]' class='form-control form-control-sm' value=''></td><td><input type='text' name='{{ $prefix2 }}tunggakan[]' class='form-control form-control-sm text-right numeric-only' value='{{ number_format(0, 2) }}'></td><td><input type='text' name='{{ $prefix2 }}semasa[]' class='form-control form-control-sm text-right numeric-only' value='{{ number_format(0, 2) }}'></td><td><input type='text' name='{{ $prefix2 }}hadapan[]' class='form-control form-control-sm text-right numeric-only' value='{{ number_format(0, 2) }}'></td><td><input type='text' name='{{ $prefix2 }}total_all[]' class='form-control form-control-sm text-right numeric-only' value='{{ number_format(0, 2) }}' readonly=''></td><td><input type='text' name='{{ $prefix2 }}tertunggak[]' class='form-control form-control-sm text-right numeric-only' value='{{ number_format(0, 2) }}'></td><td class='padding-table'><a href='javascript:void(0);' onclick=deleteRowRepairB('repairb_row" + rowRepairBNo + "') class='btn btn-danger btn-xs'>Remove</a></td></tr>");
    }

    function deleteRowRepairB(rowRepairBNo) {
        $('#' + rowRepairBNo).remove();
    }    
    
    $("#financeRepairForm").submit(function (e) {
        e.preventDefault();

        $.ajax({
            method: "POST",
            url: "{{ URL::action('FinanceController@updateFinanceFileRepair') }}",
            data: $(this).serialize(),
            beforeSend: function () {
                $(".submit_button").html('Loading').prop('disabled', true);
            },
            complete: function (data) {
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
