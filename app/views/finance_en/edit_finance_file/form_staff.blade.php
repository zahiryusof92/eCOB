<?php
$prefix = 'staff_';
?>

<div class="row">
    <div class="col-lg-12">

        <h6>4.5 LAPORAN PERBELANJAAN PEKERJA</h6>

        <form id="financeFileStaff">
            <div class="row">
                <table class="table table-sm" id="dynamic_form_staff" style="font-size: 12px;">
                    <thead>
                        <tr>
                            <th width="5%">&nbsp;</th>
                            <th width="10%" style="text-align: center;">PERKARA</th>
                            <th width="10%" style="text-align: center;">GAJI PERORANG (RM)<br/>A</th>
                            <th width="10%" style="text-align: center;">BIL. PEKERJA<br/>B</th>
                            <th width="10%" style="text-align: center;">JUMLAH GAJI<br/>A x B</th>
                            <th width="10%" style="text-align: center;">TUNGGAKAN BULAN-BULAN TERDAHULU<br/>C</th>
                            <th width="10%" style="text-align: center;">BULAN SEMASA<br/>D</th>
                            <th width="10%" style="text-align: center;">BULAN HADAPAN<br/>E</th>
                            <th width="10%" style="text-align: center;">JUMLAH<br/>C + D + E</th>
                            <th width="10%" style="text-align: center;">JUMLAH<br/>BAKI BAYARAN MASIH TERTUNGGAK<br/>(BELUM BAYAR)</th>
                            <td width="5%" style="text-align: center;">&nbsp;</td> 
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $count = 0;
                        $total_gaji = 0;
                        $total_tunggakan = 0;
                        $total_semasa = 0;
                        $total_hadapan = 0;
                        $total_tertunggak = 0;
                        $total_all = 0;
                        ?>

                        @foreach ($staffFile as $staffFiles)
                        <?php
                        $gaji_per_person = $staffFiles['gaji_per_orang'];
                        $bil_pekerja = $staffFiles['bil_pekerja'];
                        $total_gaji += $staffFiles['gaji_per_orang'] * $staffFiles['bil_pekerja'];
                        $total_tunggakan += $staffFiles['tunggakan'];
                        $total_semasa += $staffFiles['semasa'];
                        $total_hadapan += $staffFiles['hadapan'];
                        $total_tertunggak += $staffFiles['tertunggak'];
                        $total_income = $staffFiles['tunggakan'] + $staffFiles['semasa'] + $staffFiles['hadapan'];
                        $total_all += $total_income;
                        ?>

                        <tr id="staff_row{{ ++$count }}">
                            <td class="text-center padding-table">{{ $count }}</td>
                            <td><input type="text" name="{{ $prefix }}name[]" class="form-control form-control-sm" value="{{ $staffFiles['name'] }}" readonly=""></td>
                            <td><input type="text" name="{{ $prefix }}gaji_per_orang[]" class="form-control form-control-sm text-right numeric-only" value="{{ number_format($staffFiles['gaji_per_orang'], 2) }}"></td>
                            <td><input type="text" name="{{ $prefix }}bil_pekerja[]" class="form-control form-control-sm text-right numeric-only" value="{{ number_format($staffFiles['bil_pekerja'], 2) }}"></td>
                            <td><input type="text" name="{{ $prefix }}total_gaji[]" class="form-control form-control-sm text-right numeric-only" value="{{ number_format($total_gaji, 2) }}" readonly=""></td>
                            <td><input type="text" name="{{ $prefix }}tunggakan[]" class="form-control form-control-sm text-right numeric-only" value="{{ number_format($staffFiles['tunggakan'], 2) }}"></td>
                            <td><input type="text" name="{{ $prefix }}semasa[]" class="form-control form-control-sm text-right numeric-only" value="{{ number_format($staffFiles['semasa'], 2) }}"></td>
                            <td><input type="text" name="{{ $prefix }}hadapan[]" class="form-control form-control-sm text-right numeric-only" value="{{ number_format($staffFiles['hadapan'], 2) }}"></td>
                            <td><input type="text" name="{{ $prefix }}total_all[]" class="form-control form-control-sm text-right numeric-only" value="{{ number_format($total_income, 2) }}" readonly=""></td>
                            <td><input type="text" name="{{ $prefix }}tertunggak[]" class="form-control form-control-sm text-right numeric-only" value="{{ number_format($staffFiles['tertunggak'], 2) }}"></td>
                            <td>&nbsp;</td>
                        </tr>
                        @endforeach

                        <tr id="staff_row{{ ++$count }}">
                            <td class="text-center padding-table">{{ $count }}</td>
                            <td><input type="text" name="{{ $prefix }}name[]" class="form-control form-control-sm" value=""></td>
                            <td><input type="text" name="{{ $prefix }}gaji_per_orang[]" class="form-control form-control-sm text-right numeric-only" value="{{ number_format(0, 2) }}"></td>
                            <td><input type="text" name="{{ $prefix }}bil_pekerja[]" class="form-control form-control-sm text-right numeric-only" value="{{ number_format(0, 2) }}"></td>
                            <td><input type="text" name="{{ $prefix }}total_gaji[]" class="form-control form-control-sm text-right numeric-only" value="{{ number_format(0, 2) }}" readonly=""></td>
                            <td><input type="text" name="{{ $prefix }}tunggakan[]" class="form-control form-control-sm text-right numeric-only" value="{{ number_format(0, 2) }}"></td>
                            <td><input type="text" name="{{ $prefix }}semasa[]" class="form-control form-control-sm text-right numeric-only" value="{{ number_format(0, 2) }}"></td>
                            <td><input type="text" name="{{ $prefix }}hadapan[]" class="form-control form-control-sm text-right numeric-only" value="{{ number_format(0, 2) }}"></td>
                            <td><input type="text" name="{{ $prefix }}total_all[]" class="form-control form-control-sm text-right numeric-only" value="{{ number_format(0, 2) }}" readonly=""></td>
                            <td><input type="text" name="{{ $prefix }}tertunggak[]" class="form-control form-control-sm text-right numeric-only" value="{{ number_format(0, 2) }}"></td>
                            <td class="padding-table"><a href="javascript:void(0);" onclick="addRowStaff()" class="btn btn-primary btn-xs">Add More</a></td>
                        </tr>

                        <tr>
                            <td>&nbsp;</td>
                            <th class="padding-form" colspan="3">JUMLAH</th>
                            <th><input type="text" class="form-control form-control-sm text-right" value="{{ number_format($total_gaji, 2) }}" readonly=""></th>
                            <th><input type="text" class="form-control form-control-sm text-right" value="{{ number_format($total_tunggakan, 2) }}" readonly=""></th>
                            <th><input type="text" class="form-control form-control-sm text-right" value="{{ number_format($total_semasa, 2) }}" readonly=""></th>
                            <th><input type="text" class="form-control form-control-sm text-right" value="{{ number_format($total_hadapan, 2) }}" readonly=""></th>
                            <th><input type="text" class="form-control form-control-sm text-right" value="{{ number_format($total_all, 2) }}" readonly=""></th>
                            <th><input type="text" class="form-control form-control-sm text-right" value="{{ number_format($total_tertunggak, 2) }}" readonly=""></th>
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
    function addRowStaff() {
        var rowStaffNo = $("#dynamic_form_staff tr").length;
        rowStaffNo = rowStaffNo - 1;
        $("#dynamic_form_staff tr:last").prev().after("<tr id='staff_row" + rowStaffNo + "'><td class='text-center padding-table'>" + rowStaffNo + "</td><td><input type='text' name='{{ $prefix }}name[]' class='form-control form-control-sm' value=''></td><td><input type='text' name='{{ $prefix }}gaji_per_orang[]' class='form-control form-control-sm text-right numeric-only' value='{{ number_format(0, 2) }}'></td><td><input type='text' name='{{ $prefix }}bil_pekerja[]' class='form-control form-control-sm text-right numeric-only' value='{{ number_format(0, 2) }}'></td><td><input type='text' name='{{ $prefix }}total_gaji[]' class='form-control form-control-sm text-right numeric-only' value='{{ number_format(0, 2) }}' readonly=''></td><td><input type='text' name='{{ $prefix }}tunggakan[]' class='form-control form-control-sm text-right numeric-only' value='{{ number_format(0, 2) }}'></td><td><input type='text' name='{{ $prefix }}semasa[]' class='form-control form-control-sm text-right numeric-only' value='{{ number_format(0, 2) }}'></td><td><input type='text' name='{{ $prefix }}hadapan[]' class='form-control form-control-sm text-right numeric-only' value='{{ number_format(0, 2) }}'></td><td><input type='text' name='{{ $prefix }}total_all[]' class='form-control form-control-sm text-right numeric-only' value='{{ number_format(0, 2) }}' readonly=''></td><td><input type='text' name='{{ $prefix }}tertunggak[]' class='form-control form-control-sm text-right numeric-only' value='{{ number_format(0, 2) }}'></td><td class='padding-table'><a href='javascript:void(0);' onclick=deleteRowStaff('staff_row" + rowStaffNo + "') class='btn btn-danger btn-xs'>Remove</a></td></tr>");
    }

    function deleteRowStaff(rowStaffNo) {
        $('#' + rowStaffNo).remove();
    }

    $("#financeFileStaff").submit(function (e) {
        e.preventDefault();

        $.ajax({
            method: "POST",
            url: "{{ URL::action('FinanceController@updateFinanceFileStaff') }}",
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
    })
</script>
