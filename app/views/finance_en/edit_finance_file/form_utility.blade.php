<?php
$prefix = 'util_';
$prefix2 = 'utilb_';
?>

<div class="row">
    <div class="col-lg-12">

        <h6>4.1 LAPORAN PERBELANJAAN UTILITI</h6>

        <form id="formFinanceUtility"> 
            <div class="row">
                <table class="table table-sm" id="dynamic_form_utility">
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
                        <tr>
                            <th colspan="8">BAHAGIAN A</th>
                        </tr>

                        <?php
                        $count = 0;
                        $total_tunggakan = 0;
                        $total_semasa = 0;
                        $total_hadapan = 0;
                        $total_tertunggak = 0;
                        $total_income = 0;
                        $total_all = 0;
                        ?>

                        @foreach ($utila as $utilas)
                        <?php
                        $total_tunggakan += $utilas['tunggakan'];
                        $total_semasa += $utilas['semasa'];
                        $total_hadapan += $utilas['hadapan'];
                        $total_tertunggak += $utilas['tertunggak'];
                        $total_income += $utilas['tunggakan'] + $utilas['semasa'] + $utilas['hadapan'];
                        $total_all += $total_income;
                        ?>
                        <tr id="income_row{{ ++$count }}">
                            <td class="text-center padding-table">{{ $count }}</td>
                            <td><input type="text" name="{{ $prefix }}name[]" class="form-control" value="{{ $utilas['name'] }}" readonly=""></td>
                            <td><input type="text" name="{{ $prefix }}tunggakan[]" class="form-control text-right numeric-only" value="{{ number_format($utilas['tunggakan'], 2) }}"></td>
                            <td><input type="text" name="{{ $prefix }}semasa[]" class="form-control text-right numeric-only" value="{{ number_format($utilas['semasa'], 2) }}"></td>
                            <td><input type="text" name="{{ $prefix }}hadapan[]" class="form-control text-right numeric-only" value="{{ number_format($utilas['hadapan'], 2) }}"></td>
                            <td><input type="text" name="{{ $prefix }}total_all[]" class="form-control text-right numeric-only" value="{{ number_format($total_income, 2) }}" readonly=""></td>
                            <td><input type="text" name="{{ $prefix }}tertunggak[]" class="form-control text-right numeric-only" value="{{ number_format($utilas['tertunggak'], 2) }}"></td>
                            <td>&nbsp;</td>
                        </tr>
                        @endforeach
                        <tr>
                            <td>&nbsp;</td>
                            <td class="padding-form">JUMLAH BAHAGIAN A</td>
                            <td><input type="text" class="form-control text-right" value="{{ number_format($total_tunggakan, 2) }}" readonly=""></td>
                            <td><input type="text" class="form-control text-right" value="{{ number_format($total_semasa, 2) }}" readonly=""></td>
                            <td><input type="text" class="form-control text-right" value="{{ number_format($total_hadapan, 2) }}" readonly=""></td>
                            <td><input type="text" class="form-control text-right" value="{{ number_format($total_income, 2) }}" readonly=""></td>
                            <td><input type="text" class="form-control text-right" value="{{ number_format($total_tertunggak, 2) }}" readonly=""></td>
                            <td>&nbsp;</td>
                        </tr>

                        <tr>
                            <th colspan="8">BAHAGIAN B</th>
                        </tr>

                        <?php
                        $countb = 0;
                        $totalb_tunggakan = 0;
                        $totalb_semasa = 0;
                        $totalb_hadapan = 0;
                        $totalb_tertunggak = 0;
                        $totalb_income = 0;
                        $totalb_all = 0;
                        ?>

                        @foreach ($utilb as $utilbs)
                        <?php
                        $totalb_tunggakan += $utilbs['tunggakan'];
                        $totalb_semasa += $utilbs['semasa'];
                        $totalb_hadapan += $utilbs['hadapan'];
                        $totalb_tertunggak += $utilbs['tertunggak'];
                        $totalb_income += $utilbs['tunggakan'] + $utilbs['semasa'] + $utilbs['hadapan'];
                        $totalb_all += $totalb_income;
                        ?>
                        <tr id="utility_row{{ ++$countb }}">
                            <td class="text-center padding-table">{{ $countb }}</td>
                            <td><input type="text" name="{{ $prefix2 }}name[]" class="form-control" value="{{ $utilbs['name'] }}" readonly=""></td>
                            <td><input type="text" name="{{ $prefix2 }}tunggakan[]" class="form-control text-right numeric-only" value="{{ number_format($utilbs['tunggakan'], 2) }}"></td>
                            <td><input type="text" name="{{ $prefix2 }}semasa[]" class="form-control text-right numeric-only" value="{{ number_format($utilbs['semasa'], 2) }}"></td>
                            <td><input type="text" name="{{ $prefix2 }}hadapan[]" class="form-control text-right numeric-only" value="{{ number_format($utilbs['hadapan'], 2) }}"></td>
                            <td><input type="text" name="{{ $prefix2 }}total_all[]" class="form-control text-right numeric-only" value="{{ number_format($totalb_income, 2) }}" readonly=""></td>
                            <td><input type="text" name="{{ $prefix2 }}tertunggak[]" class="form-control text-right numeric-only" value="{{ number_format($utilbs['tertunggak'], 2) }}"></td>
                            <td>&nbsp;</td>
                        </tr>
                        @endforeach
                        
                        <tr id="utility_row{{ ++$countb }}">
                            <td class="text-center padding-table">{{ $countb }}</td>
                            <td><input type="text" name="{{ $prefix2 }}name[]" class="form-control" value=""></td>
                            <td><input type="text" name="{{ $prefix2 }}tunggakan[]" class="form-control text-right numeric-only" value="{{ number_format(0, 2) }}"></td>
                            <td><input type="text" name="{{ $prefix2 }}semasa[]" class="form-control text-right numeric-only" value="{{ number_format(0, 2) }}"></td>
                            <td><input type="text" name="{{ $prefix2 }}hadapan[]" class="form-control text-right numeric-only" value="{{ number_format(0, 2) }}"></td>
                            <td><input type="text" name="{{ $prefix2 }}total_all[]" class="form-control text-right numeric-only" value="{{ number_format(0, 2) }}" readonly=""></td>
                            <td><input type="text" name="{{ $prefix2 }}tertunggak[]" class="form-control text-right numeric-only" value="{{ number_format(0, 2) }}"></td>
                            <td class="padding-table"><a href="javascript:void(0);" onclick="addRowUtility()" class="btn btn-primary btn-xs">Add More</a></td>
                        </tr>
                        
                        <tr>
                            <td>&nbsp;</td>
                            <td class="padding-form">JUMLAH BAHAGIAN B</td>
                            <td><input type="text" class="form-control text-right" value="{{ number_format($totalb_tunggakan, 2) }}" readonly=""></td>
                            <td><input type="text" class="form-control text-right" value="{{ number_format($totalb_semasa, 2) }}" readonly=""></td>
                            <td><input type="text" class="form-control text-right" value="{{ number_format($totalb_hadapan, 2) }}" readonly=""></td>
                            <td><input type="text" class="form-control text-right" value="{{ number_format($totalb_income, 2) }}" readonly=""></td>
                            <td><input type="text" class="form-control text-right" value="{{ number_format($totalb_tertunggak, 2) }}" readonly=""></td>
                            <td>&nbsp;</td>
                        </tr>

                        <tr>
                            <td>&nbsp;</td>
                            <td class="padding-form">JUMLAH BAHAGIAN A + BAHAGIAN B</td>
                            <td><input type="text"  class="form-control text-right" value="{{ number_format($total_tunggakan + $totalb_tunggakan, 2) }}" readonly=""></td>
                            <td><input type="text"  class="form-control text-right" value="{{ number_format($total_semasa + $totalb_semasa, 2) }}" readonly=""></td>
                            <td><input type="text"  class="form-control text-right" value="{{ number_format($total_hadapan + $totalb_hadapan, 2) }}" readonly=""></td>
                            <td><input type="text"  class="form-control text-right" value="{{ number_format($total_income + $totalb_income, 2) }}" readonly=""></td>
                            <td><input type="text"  class="form-control text-right" value="{{ number_format($total_tertunggak + $totalb_tertunggak, 2) }}" readonly=""></td>
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

<script type="text/javascript">
    function addRowUtility() {
        var rowno = $("#dynamic_form_utility tr").length;        
        rowno = rowno - 7;
        $("#dynamic_form_utility tr:last").prev().prev().after("<tr id='utility_row" + rowno + "'><td class='text-center padding-table'>" + rowno + "</td><td><input type='text' name='{{ $prefix2 }}name[]' class='form-control' value=''></td><td><input type='text' name='{{ $prefix2 }}tunggakan[]' class='form-control text-right numeric-only' value='{{ number_format(0, 2) }}'></td><td><input type='text' name='{{ $prefix2 }}semasa[]' class='form-control text-right numeric-only' value='{{ number_format(0, 2) }}'></td><td><input type='text' name='{{ $prefix2 }}hadapan[]' class='form-control text-right numeric-only' value='{{ number_format(0, 2) }}'></td><td><input type='text' name='{{ $prefix2 }}total_all[]' class='form-control text-right numeric-only' value='{{ number_format(0, 2) }}' readonly=''></td><td><input type='text' name='{{ $prefix2 }}tertunggak[]' class='form-control text-right numeric-only' value='{{ number_format(0, 2) }}'></td><td class='padding-table'><a href='javascript:void(0);' onclick=deleteRowUtility('utility_row" + rowno + "') class='btn btn-danger btn-xs'>Remove</a></td></tr>");
    }

    function deleteRowUtility(rowno) {
        $('#' + rowno).remove();
    }
</script>

<script>
    $("#formFinanceUtility").submit(function (e) {
        e.preventDefault();

        $.ajax({
            method: "POST",
            url: "{{ URL::action('FinanceController@updateFinanceFileUtility') }}",
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
