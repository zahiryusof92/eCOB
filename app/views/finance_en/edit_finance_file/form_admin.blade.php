<?php
$prefix = 'admin_';
?>

<div class="row">
    <div class="col-lg-12">

        <h6>4.6 LAPORAN PERBELANJAAN PENTADBIRAN</h6>

        <form id="financeFileAdmin">
            <div class="row">
                <table class="table table-sm" id="dynamic_form_admin" style="font-size: 12px;">
                    <thead>
                        <tr>
                            <th width="5%">&nbsp;</th>
                            <th width="40%" style="text-align: center;">PERKARA</th>
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
                        $total_tunggakan = 0;
                        $total_semasa = 0;
                        $total_hadapan = 0;
                        $total_tertunggak = 0;
                        $total_all = 0;
                        ?>

                        @foreach ($adminFile as $adminFiles)
                        <?php
                        $total_tunggakan += $adminFiles['tunggakan'];
                        $total_semasa += $adminFiles['semasa'];
                        $total_hadapan += $adminFiles['hadapan'];
                        $total_tertunggak += $adminFiles['tertunggak'];
                        $total_income = $adminFiles['tunggakan'] + $adminFiles['semasa'] + $adminFiles['hadapan'];
                        $total_all += $total_income;
                        ?>

                        <tr id="admin_row{{ ++$count }}">
                            <td class="text-center padding-table">{{ $count }}</td>
                            <td><input type="text" name="{{ $prefix }}name[]" class="form-control form-control-sm" value="{{ $adminFiles['name'] }}" readonly=""></td>
                            <td><input type="text" name="{{ $prefix }}tunggakan[]" class="form-control form-control-sm text-right numeric-only" value="{{ number_format($adminFiles['tunggakan'], 2) }}"></td>
                            <td><input type="text" name="{{ $prefix }}semasa[]" class="form-control form-control-sm text-right numeric-only" value="{{ number_format($adminFiles['semasa'], 2) }}"></td>
                            <td><input type="text" name="{{ $prefix }}hadapan[]" class="form-control form-control-sm text-right numeric-only" value="{{ number_format($adminFiles['hadapan'], 2) }}"></td>
                            <td><input type="text" name="{{ $prefix }}total_all[]" class="form-control form-control-sm text-right numeric-only" value="{{ number_format($total_income, 2) }}" readonly=""></td>
                            <td><input type="text" name="{{ $prefix }}tertunggak[]" class="form-control form-control-sm text-right numeric-only" value="{{ number_format($adminFiles['tertunggak'], 2) }}"></td>
                            <td>&nbsp;</td>
                        </tr>
                        @endforeach

                        <tr id="admin_row{{ ++$count }}">
                            <td class="text-center padding-table">{{ $count }}</td>
                            <td><input type="text" name="{{ $prefix }}name[]" class="form-control form-control-sm" value=""></td>
                            <td><input type="text" name="{{ $prefix }}tunggakan[]" class="form-control form-control-sm text-right numeric-only" value="{{ number_format(0, 2) }}"></td>
                            <td><input type="text" name="{{ $prefix }}semasa[]" class="form-control form-control-sm text-right numeric-only" value="{{ number_format(0, 2) }}"></td>
                            <td><input type="text" name="{{ $prefix }}hadapan[]" class="form-control form-control-sm text-right numeric-only" value="{{ number_format(0, 2) }}"></td>
                            <td><input type="text" name="{{ $prefix }}total_all[]" class="form-control form-control-sm text-right numeric-only" value="{{ number_format(0, 2) }}" readonly=""></td>
                            <td><input type="text" name="{{ $prefix }}tertunggak[]" class="form-control form-control-sm text-right numeric-only" value="{{ number_format(0, 2) }}"></td>
                            <td class="padding-table"><a href="javascript:void(0);" onclick="addRowAdmin()" class="btn btn-primary btn-xs">Add More</a></td>
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
    function addRowAdmin() {
        var rowAdminNo = $("#dynamic_form_admin tr").length;
        rowAdminNo = rowAdminNo - 1;
        $("#dynamic_form_admin tr:last").prev().after("<tr id='admin_row" + rowAdminNo + "'><td class='text-center padding-table'>" + rowAdminNo + "</td><td><input type='text' name='{{ $prefix }}name[]' class='form-control form-control-sm' value=''></td><td><input type='text' name='{{ $prefix }}tunggakan[]' class='form-control form-control-sm text-right numeric-only' value='{{ number_format(0, 2) }}'></td><td><input type='text' name='{{ $prefix }}semasa[]' class='form-control form-control-sm text-right numeric-only' value='{{ number_format(0, 2) }}'></td><td><input type='text' name='{{ $prefix }}hadapan[]' class='form-control form-control-sm text-right numeric-only' value='{{ number_format(0, 2) }}'></td><td><input type='text' name='{{ $prefix }}total_all[]' class='form-control form-control-sm text-right numeric-only' value='{{ number_format(0, 2) }}' readonly=''></td><td><input type='text' name='{{ $prefix }}tertunggak[]' class='form-control form-control-sm text-right numeric-only' value='{{ number_format(0, 2) }}'></td><td class='padding-table'><a href='javascript:void(0);' onclick=deleteRowAdmin('admin_row" + rowAdminNo + "') class='btn btn-danger btn-xs'>Remove</a></td></tr>");
    }

    function deleteRowAdmin(rowAdminNo) {
        $('#' + rowAdminNo).remove();
    }
    
    $("#financeFileAdmin").submit(function (e) {
        e.preventDefault();

        $.ajax({
            method: "POST",
            url: "{{ URL::action('FinanceController@updateFinanceFileAdmin') }}",
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
                console.log(response);
            }
        });
    })
</script>
