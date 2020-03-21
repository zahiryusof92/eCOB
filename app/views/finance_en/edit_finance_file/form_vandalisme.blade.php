<?php
$prefix = 'maintenancefee_';
$prefix2 = 'singkingfund_';
?>

<div class="row">
    <div class="col-lg-12">

        <h6>4.4 PEMBAIKAN/PENGGANTIAN/PEMBELIAN/NAIKTARAF/PEMBAHARUAN (VANDALISME) a. Guna Duit Maintenance Fee</h6>

        <form id="financeVandalForm" method="POST">
            <div class="row">
                <table class="table table-sm" id="dynamic_form_vandal_a" style="font-size: 12px;">
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

                        @foreach ($vandala as $vandalas)
                        <?php
                        $total_tunggakan += $vandalas['tunggakan'];
                        $total_semasa += $vandalas['semasa'];
                        $total_hadapan += $vandalas['hadapan'];
                        $total_tertunggak += $vandalas['tertunggak'];
                        $total_income = $vandalas['tunggakan'] + $vandalas['semasa'] + $vandalas['hadapan'];
                        $total_all += $total_income;
                        ?>
                        <tr id="vandala_row{{ ++$count }}">
                            <td class="text-center padding-table">{{ $count }}</td>
                            <td><input type="text" name="{{ $prefix }}name[]" class="form-control form-control-sm" value="{{ $vandalas['name'] }}" readonly=""></td>
                            <td><input type="text" name="{{ $prefix }}tunggakan[]" class="form-control form-control-sm text-right numeric-only" value="{{ number_format($vandalas['tunggakan'], 2) }}"></td>
                            <td><input type="text" name="{{ $prefix }}semasa[]" class="form-control form-control-sm text-right numeric-only" value="{{ number_format($vandalas['semasa'], 2) }}"></td>
                            <td><input type="text" name="{{ $prefix }}hadapan[]" class="form-control form-control-sm text-right numeric-only" value="{{ number_format($vandalas['hadapan'], 2) }}"></td>
                            <td><input type="text" name="{{ $prefix }}total_all[]" class="form-control form-control-sm text-right numeric-only" value="{{ number_format($total_income, 2) }}" readonly=""></td>
                            <td><input type="text" name="{{ $prefix }}tertunggak[]" class="form-control form-control-sm text-right numeric-only" value="{{ number_format($vandalas['tertunggak'], 2) }}"></td>
                            <td>&nbsp;</td>
                        </tr>
                        @endforeach

                        <tr id="vandala_row{{ ++$count }}">
                            <td class="text-center padding-table">{{ $count }}</td>
                            <td><input type="text" name="{{ $prefix }}name[]" class="form-control form-control-sm" value=""></td>
                            <td><input type="text" name="{{ $prefix }}tunggakan[]" class="form-control form-control-sm text-right numeric-only" value="{{ number_format(0, 2) }}"></td>
                            <td><input type="text" name="{{ $prefix }}semasa[]" class="form-control form-control-sm text-right numeric-only" value="{{ number_format(0, 2) }}"></td>
                            <td><input type="text" name="{{ $prefix }}hadapan[]" class="form-control form-control-sm text-right numeric-only" value="{{ number_format(0, 2) }}"></td>
                            <td><input type="text" name="{{ $prefix }}total_all[]" class="form-control form-control-sm text-right numeric-only" value="{{ number_format(0, 2) }}" readonly=""></td>
                            <td><input type="text" name="{{ $prefix }}tertunggak[]" class="form-control form-control-sm text-right numeric-only" value="{{ number_format(0, 2) }}"></td>
                            <td class="padding-table"><a href="javascript:void(0);" onclick="addRowVandalA()" class="btn btn-primary btn-xs">Add More</a></td>
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

            <h6>4.4 PEMBAIKAN/PENGGANTIAN/PEMBELIAN/NAIKTARAF/PEMBAHARUAN (VANDALISME) b. Guna Duit Sinking Fund</h6>

            <div class="row">
                <table class="table table-sm" id="dynamic_form_vandal_b" style="font-size: 12px;">
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

                        @foreach ($vandalb as $vandalbs)
                        <?php
                        $totalb_tunggakan += $vandalbs['tunggakan'];
                        $totalb_semasa += $vandalbs['semasa'];
                        $totalb_hadapan += $vandalbs['hadapan'];
                        $totalb_tertunggak += $vandalbs['tertunggak'];
                        $totalb_income += $vandalbs['tunggakan'] + $vandalbs['semasa'] + $vandalbs['hadapan'];
                        $totalb_all += $totalb_income;
                        ?>
                        <tr id="vandalb_row{{ ++$countb }}">
                            <td class="text-center padding-table">{{ $countb }}</td>
                            <td><input type="text" name="{{ $prefix2 }}name[]" class="form-control form-control-sm" value="{{ $vandalbs['name'] }}" readonly=""></td>
                            <td><input type="text" name="{{ $prefix2 }}tunggakan[]" class="form-control form-control-sm text-right numeric-only" value="{{ number_format($vandalbs['tunggakan'], 2) }}"></td>
                            <td><input type="text" name="{{ $prefix2 }}semasa[]" class="form-control form-control-sm text-right numeric-only" value="{{ number_format($vandalbs['semasa'], 2) }}"></td>
                            <td><input type="text" name="{{ $prefix2 }}hadapan[]" class="form-control form-control-sm text-right numeric-only" value="{{ number_format($vandalbs['hadapan'], 2) }}"></td>
                            <td><input type="text" name="{{ $prefix2 }}total_all[]" class="form-control form-control-sm text-right numeric-only" value="{{ number_format($totalb_income, 2) }}" readonly=""></td>
                            <td><input type="text" name="{{ $prefix2 }}tertunggak[]" class="form-control form-control-sm text-right numeric-only" value="{{ number_format($vandalbs['tertunggak'], 2) }}"></td>
                            <td>&nbsp;</td>
                        </tr>
                        @endforeach

                        <tr id="vandalb_row{{ ++$countb }}">
                            <td class="text-center padding-table">{{ $countb }}</td>
                            <td><input type="text" name="{{ $prefix2 }}name[]" class="form-control form-control-sm" value=""></td>
                            <td><input type="text" name="{{ $prefix2 }}tunggakan[]" class="form-control form-control-sm text-right numeric-only" value="{{ number_format(0, 2) }}"></td>
                            <td><input type="text" name="{{ $prefix2 }}semasa[]" class="form-control form-control-sm text-right numeric-only" value="{{ number_format(0, 2) }}"></td>
                            <td><input type="text" name="{{ $prefix2 }}hadapan[]" class="form-control form-control-sm text-right numeric-only" value="{{ number_format(0, 2) }}"></td>
                            <td><input type="text" name="{{ $prefix2 }}total_all[]" class="form-control form-control-sm text-right numeric-only" value="{{ number_format(0, 2) }}" readonly=""></td>
                            <td><input type="text" name="{{ $prefix2 }}tertunggak[]" class="form-control form-control-sm text-right numeric-only" value="{{ number_format(0, 2) }}"></td>
                            <td class="padding-table"><a href="javascript:void(0);" onclick="addRowVandalB()" class="btn btn-primary btn-xs">Add More</a></td>
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
    function addRowVandalA() {
        var rowVandalANo = $("#dynamic_form_vandal_a tr").length;
        rowVandalANo = rowVandalANo - 1;
        $("#dynamic_form_vandal_a tr:last").prev().after("<tr id='vandala_row" + rowVandalANo + "'><td class='text-center padding-table'>" + rowVandalANo + "</td><td><input type='text' name='{{ $prefix }}name[]' class='form-control form-control-sm' value=''></td><td><input type='text' name='{{ $prefix }}tunggakan[]' class='form-control form-control-sm text-right numeric-only' value='{{ number_format(0, 2) }}'></td><td><input type='text' name='{{ $prefix }}semasa[]' class='form-control form-control-sm text-right numeric-only' value='{{ number_format(0, 2) }}'></td><td><input type='text' name='{{ $prefix }}hadapan[]' class='form-control form-control-sm text-right numeric-only' value='{{ number_format(0, 2) }}'></td><td><input type='text' name='{{ $prefix }}total_all[]' class='form-control form-control-sm text-right numeric-only' value='{{ number_format(0, 2) }}' readonly=''></td><td><input type='text' name='{{ $prefix }}tertunggak[]' class='form-control form-control-sm text-right numeric-only' value='{{ number_format(0, 2) }}'></td><td class='padding-table'><a href='javascript:void(0);' onclick=deleteRowVandalA('vandala_row" + rowVandalANo + "') class='btn btn-danger btn-xs'>Remove</a></td></tr>");
    }

    function deleteRowVandalA(rowVandalANo) {
        $('#' + rowVandalANo).remove();
    }

    function addRowVandalB() {
        var rowVandalBNo = $("#dynamic_form_vandal_b tr").length;
        rowVandalBNo = rowVandalBNo - 1;
        $("#dynamic_form_vandal_b tr:last").prev().after("<tr id='vandalb_row" + rowVandalBNo + "'><td class='text-center padding-table'>" + rowVandalBNo + "</td><td><input type='text' name='{{ $prefix2 }}name[]' class='form-control form-control-sm' value=''></td><td><input type='text' name='{{ $prefix2 }}tunggakan[]' class='form-control form-control-sm text-right numeric-only' value='{{ number_format(0, 2) }}'></td><td><input type='text' name='{{ $prefix2 }}semasa[]' class='form-control form-control-sm text-right numeric-only' value='{{ number_format(0, 2) }}'></td><td><input type='text' name='{{ $prefix2 }}hadapan[]' class='form-control form-control-sm text-right numeric-only' value='{{ number_format(0, 2) }}'></td><td><input type='text' name='{{ $prefix2 }}total_all[]' class='form-control form-control-sm text-right numeric-only' value='{{ number_format(0, 2) }}' readonly=''></td><td><input type='text' name='{{ $prefix2 }}tertunggak[]' class='form-control form-control-sm text-right numeric-only' value='{{ number_format(0, 2) }}'></td><td class='padding-table'><a href='javascript:void(0);' onclick=deleteRowVandalB('vandalb_row" + rowVandalBNo + "') class='btn btn-danger btn-xs'>Remove</a></td></tr>");
    }

    function deleteRowVandalB(rowVandalBNo) {
        $('#' + rowVandalBNo).remove();
    }

    $("#financeVandalForm").submit(function (e) {
        e.preventDefault();

        $.ajax({
            method: "POST",
            url: "{{ URL::action('FinanceController@updateFinanceFileVandal') }}",
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
