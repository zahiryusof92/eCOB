<?php
$prefix = 'income_';
?>

<div class="row">
    <div class="col-lg-12">

        <h6>3. LAPORAN PENDAPATAN</h6>

        <form id="financeFileIncome">                 
            <div class="row">
                <table class="table table-sm" id="dynamic_form_income">
                    <thead>
                        <tr>
                            <th width="5%">&nbsp;</th>
                            <th width="50%" style="text-align: center;">PENDAPATAN</th>
                            <th width="10%" style="text-align: center;">TUNGGAKAN<br/>B</th>
                            <th width="10%" style="text-align: center;">SEMASA<br/>A</th>
                            <th width="10%" style="text-align: center;">ADVANCED<br/>C</th>
                            <th width="10%" style="text-align: center;">JUMLAH<br/>A + B + C</th>
                            <td width="5%" style="text-align: center;">&nbsp;</td> 
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $count = 0;
                        $total_tunggakan = 0;
                        $total_semasa = 0;
                        $total_hadapan = 0;
                        $total_income = 0;
                        $total_all = 0;
                        ?>

                        @foreach ($incomeFile as $incomeFiles)
                        <?php
                        $total_tunggakan += $incomeFiles['tunggakan'];
                        $total_semasa += $incomeFiles['semasa'];
                        $total_hadapan += $incomeFiles['hadapan'];
                        $total_income += $incomeFiles['tunggakan'] + $incomeFiles['semasa'] + $incomeFiles['hadapan'];
                        $total_all += $total_income;
                        ?>
                        <tr id="income_row{{ ++$count }}">
                            <td class="text-center padding-table">{{ $count }}</td>
                            <td><input type="text" name="{{ $prefix }}name[]" class="form-control" value="{{ $incomeFiles['name'] }}" readonly=""></td>
                            <td><input type="text" name="{{ $prefix }}tunggakan[]" class="form-control text-right numeric-only" value="{{ number_format($incomeFiles['tunggakan'], 2) }}"></td>
                            <td><input type="text" name="{{ $prefix }}semasa[]" class="form-control text-right numeric-only" value="{{ number_format($incomeFiles['semasa'], 2) }}"></td>
                            <td><input type="text" name="{{ $prefix }}hadapan[]" class="form-control text-right numeric-only" value="{{ number_format($incomeFiles['hadapan'], 2) }}"></td>
                            <td><input type="text" name="{{ $prefix }}total_all[]" class="form-control text-right numeric-only" value="{{ number_format($total_income, 2) }}" readonly=""></td>
                            <td>&nbsp;</td> 
                        </tr>
                        @endforeach

                        <tr id="income_row{{ ++$count }}">
                            <td class="text-center padding-table">{{ $count }}</td>
                            <td><input type="text" name="{{ $prefix }}name[]" class="form-control" value=""></td>
                            <td><input type="text" name="{{ $prefix }}tunggakan[]" class="form-control text-right numeric-only" value="{{ number_format(0, 2) }}"></td>
                            <td><input type="text" name="{{ $prefix }}semasa[]" class="form-control text-right numeric-only" value="{{ number_format(0, 2) }}"></td>
                            <td><input type="text" name="{{ $prefix }}hadapan[]" class="form-control text-right numeric-only" value="{{ number_format(0, 2) }}"></td>
                            <td><input type="text" name="{{ $prefix }}total_all[]" class="form-control text-right numeric-only" value="{{ number_format(0, 2) }}" readonly=""></td>
                            <td class="padding-table"><a href="javascript:void(0);" onclick="addRow()" class="btn btn-primary btn-xs" id="plus5">Add More</a></td>
                        </tr>

                        <tr>
                            <td>&nbsp;</td>
                            <td class="padding-form">JUMLAH</td>
                            <td><input type="text" class="form-control text-right" value="{{ number_format($total_tunggakan, 2) }}" readonly=""></td>
                            <td><input type="text" class="form-control text-right" value="{{ number_format($total_semasa, 2) }}" readonly=""></td>
                            <td><input type="text" class="form-control text-right" value="{{ number_format($total_hadapan, 2) }}" readonly=""></td>
                            <td><input type="text" class="form-control text-right" value="{{ number_format($total_all, 2) }}" readonly=""></td>
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
    function addRow() {
        var rowno = $("#dynamic_form_income tr").length;
        rowno = rowno - 1;
        $("#dynamic_form_income tr:last").prev().after("<tr id='income_row" + rowno + "'><td class='text-center padding-table'>" + rowno + "</td><td><input type='text' name='{{ $prefix }}name[]' class='form-control' value=''></td><td><input type='text' name='{{ $prefix }}tunggakan[]' class='form-control text-right numeric-only' value='{{ number_format(0, 2) }}'></td><td><input type='text' name='{{ $prefix }}semasa[]' class='form-control text-right numeric-only' value='{{ number_format(0, 2) }}'></td><td><input type='text' name='{{ $prefix }}hadapan[]' class='form-control text-right numeric-only' value='{{ number_format(0, 2) }}'></td><td><input type='text' name='{{ $prefix }}total_all[]' class='form-control text-right numeric-only' value='{{ number_format(0, 2) }}' readonly=''></td><td class='padding-table'><a href='javascript:void(0);' onclick=deleteRow('income_row" + rowno + "') class='btn btn-danger btn-xs'>Remove</a></td></tr>");
    }

    function deleteRow(rowno) {
        $('#' + rowno).remove();
    }
</script>



<script>
    $("#financeFileIncome").submit(function (e) {
        e.preventDefault();
        $.ajax({
            method: "POST",
            url: "{{ URL::action('FinanceController@updateFinanceFileIncome') }}",
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
