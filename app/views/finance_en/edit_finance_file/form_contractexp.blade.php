<?php
$prefix = 'contract_';
?>

<div class="row">
    <div class="col-lg-12">

        <h6>4.2 LAPORAN PERBELANJAAN PENYENGGARAAN</h6>

        <form id="financeFileContract">
            <div class="row">
                <table class="table table-sm" id="dynamic_form_contract" style="font-size: 12px;">
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

                        @foreach ($contractFile as $contractFiles)
                        <?php
                        $total_tunggakan += $contractFiles['tunggakan'];
                        $total_semasa += $contractFiles['semasa'];
                        $total_hadapan += $contractFiles['hadapan'];
                        $total_tertunggak += $contractFiles['tertunggak'];
                        $total_income = $contractFiles['tunggakan'] + $contractFiles['semasa'] + $contractFiles['hadapan'];
                        $total_all += $total_income;
                        ?>
                        <tr id="contract_row{{ ++$count }}">
                            <td class="text-center padding-table"><input type="hidden" name="{{ $prefix }}is_custom[]" value="{{ $contractFiles['is_custom'] }}">{{ $count }}</td>
                            <td><input type="text" name="{{ $prefix }}name[]" class="form-control form-control-sm" value="{{ $contractFiles['name'] }}" readonly=""></td>
                            <td><input type="text" oninput="calculateContract('{{ $count }}')" id="{{ $prefix . 'tunggakan_' . $count }}" name="{{ $prefix }}tunggakan[]" class="form-control form-control-sm text-right numeric-only" value="{{ $contractFiles['tunggakan'] }}"></td>
                            <td><input type="text" oninput="calculateContract('{{ $count }}')" id="{{ $prefix . 'semasa_' . $count }}" name="{{ $prefix }}semasa[]" class="form-control form-control-sm text-right numeric-only" value="{{ $contractFiles['semasa'] }}"></td>
                            <td><input type="text" oninput="calculateContract('{{ $count }}')" id="{{ $prefix . 'hadapan_' . $count }}" name="{{ $prefix }}hadapan[]" class="form-control form-control-sm text-right numeric-only" value="{{ $contractFiles['hadapan'] }}"></td>
                            <td><input type="text" id="{{ $prefix . 'total_income_' . $count }}" name="{{ $prefix }}total_income[]" class="form-control form-control-sm text-right numeric-only" value="{{ $total_income }}" readonly=""></td>
                            <td><input type="text" oninput="calculateContractTotal('{{ $count }}')" id="{{ $prefix . 'tertunggak_' . $count }}" name="{{ $prefix }}tertunggak[]" class="form-control form-control-sm text-right numeric-only" value="{{ $contractFiles['tertunggak'] }}"></td>
                            @if ($contractFiles['is_custom'])
                            <td class="padding-table text-right"><a href="javascript:void(0);" onclick="deleteRowContract('contract_row<?php echo $count ?>')" class="btn btn-danger btn-xs">Remove</a></td>
                            @else
                            <td>&nbsp;</td>
                            @endif
                        </tr>
                        @endforeach

                        <tr>
                            <td class="padding-table text-right" colspan="8"><a href="javascript:void(0);" onclick="addRowContract()" class="btn btn-primary btn-xs">Add More</a></td>
                        </tr>

                        <tr>
                            <td>&nbsp;</td>
                            <th class="padding-form">JUMLAH</th>
                            <th><input type="text" id="{{ $prefix . 'total_tunggakan' }}" class="form-control form-control-sm text-right" value="{{ $total_tunggakan }}" readonly=""></th>
                            <th><input type="text" id="{{ $prefix . 'total_semasa' }}" class="form-control form-control-sm text-right" value="{{ $total_semasa }}" readonly=""></th>
                            <th><input type="text" id="{{ $prefix . 'total_hadapan' }}" class="form-control form-control-sm text-right" value="{{ $total_hadapan }}" readonly=""></th>
                            <th><input type="text" id="{{ $prefix . 'total_all' }}" class="form-control form-control-sm text-right" value="{{ $total_all }}" readonly=""></th>
                            <th><input type="text" id="{{ $prefix . 'total_tertunggak' }}" class="form-control form-control-sm text-right" value="{{ $total_tertunggak }}" readonly=""></th>
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
    calculateContractTotal();

    function calculateContract(id) {
        var contract_sum_tunggakan = 0;
        var contract_sum_semasa = 0;
        var contract_sum_hadapan = 0;
        var contract_sum_total_income = 0;

        var contract_tunggakan = document.getElementById("{{ $prefix }}tunggakan_" + id);
        contract_sum_tunggakan += parseFloat(contract_tunggakan.value);

        var contract_semasa = document.getElementById("{{ $prefix }}semasa_" + id);
        contract_sum_semasa += parseFloat(contract_semasa.value);

        var contract_hadapan = document.getElementById("{{ $prefix }}hadapan_" + id);
        contract_sum_hadapan += parseFloat(contract_hadapan.value);

        contract_sum_total_income += parseFloat(contract_sum_tunggakan) + parseFloat(contract_sum_semasa) + parseFloat(contract_sum_hadapan);
        $('#contract_total_income_' + id).val(parseFloat(contract_sum_total_income).toFixed(2)); // UPDATE JUMLAH A + B + C

        calculateContractTotal();
    }

    function calculateContractTotal() {
        var contract_total_tunggakan = document.getElementsByName("{{ $prefix }}tunggakan[]");
        var contract_sum_total_tunggakan = 0;
        for (var i = 0; i < contract_total_tunggakan.length; i++) {
            contract_sum_total_tunggakan += parseFloat(contract_total_tunggakan[i].value);
            $('#' + contract_total_tunggakan[i].id).val(parseFloat(contract_total_tunggakan[i].value).toFixed(2));
        }
        $('#contract_total_tunggakan').val(parseFloat(contract_sum_total_tunggakan).toFixed(2)); // UPDATE JUMLAH SEMUA A

        var contract_total_semasa = document.getElementsByName("{{ $prefix }}semasa[]");
        var contract_sum_total_semasa = 0;
        for (var i = 0; i < contract_total_semasa.length; i++) {
            contract_sum_total_semasa += parseFloat(contract_total_semasa[i].value);
            $('#' + contract_total_semasa[i].id).val(parseFloat(contract_total_semasa[i].value).toFixed(2));
        }
        $('#contract_total_semasa').val(parseFloat(contract_sum_total_semasa).toFixed(2)); // UPDATE JUMLAH SEMUA B

        var contract_total_hadapan = document.getElementsByName("{{ $prefix }}hadapan[]");
        var contract_sum_total_hadapan = 0;
        for (var i = 0; i < contract_total_hadapan.length; i++) {
            contract_sum_total_hadapan += parseFloat(contract_total_hadapan[i].value);
            $('#' + contract_total_hadapan[i].id).val(parseFloat(contract_total_hadapan[i].value).toFixed(2));
        }
        $('#contract_total_hadapan').val(parseFloat(contract_sum_total_hadapan).toFixed(2)); // UPDATE JUMLAH SEMUA C

        var contract_total_income = document.getElementsByName("{{ $prefix }}total_income[]");
        for (var i = 0; i < contract_total_income.length; i++) {
            $('#' + contract_total_income[i].id).val(parseFloat(contract_total_income[i].value).toFixed(2));
        }
        
        var contract_total_tertunggak = document.getElementsByName("{{ $prefix }}tertunggak[]");
        var contract_sum_total_tertunggak = 0;
        for (var i = 0; i < contract_total_tertunggak.length; i++) {
            contract_sum_total_tertunggak += parseFloat(contract_total_tertunggak[i].value);
            $('#' + contract_total_hadapan[i].id).val(parseFloat(contract_total_hadapan[i].value).toFixed(2));
        }
        $('#contract_total_tertunggak').val(parseFloat(contract_sum_total_tertunggak).toFixed(2)); // UPDATE JUMLAH TERTUNGGAK

        var contract_sum_total_all = parseFloat(contract_sum_total_tunggakan) + parseFloat(contract_sum_total_semasa) + parseFloat(contract_sum_total_hadapan); // JUMLAH SEMUA A + B + C 
        $('#contract_total_all').val(parseFloat(contract_sum_total_all).toFixed(2)); // UPDATE JUMLAH SEMUA A + B + C 
    }

    function addRowContract() {
        var rowContractNo = $("#dynamic_form_contract tr").length;
        rowContractNo = rowContractNo - 2;
        $("#dynamic_form_contract tr:last").prev().prev().after("<tr id='contract_row" + rowContractNo + "'><td class='text-center padding-table'>" + rowContractNo + "</td><td><input type='text' name='{{ $prefix }}name[]' class='form-control form-control-sm' value=''></td><td><input type='text' name='{{ $prefix }}tunggakan[]' class='form-control form-control-sm text-right numeric-only' value='{{ number_format(0, 2) }}'></td><td><input type='text' name='{{ $prefix }}semasa[]' class='form-control form-control-sm text-right numeric-only' value='{{ number_format(0, 2) }}'></td><td><input type='text' name='{{ $prefix }}hadapan[]' class='form-control form-control-sm text-right numeric-only' value='{{ number_format(0, 2) }}'></td><td><input type='text' name='{{ $prefix }}total_all[]' class='form-control form-control-sm text-right numeric-only' value='{{ number_format(0, 2) }}' readonly=''></td><td><input type='text' name='{{ $prefix }}tertunggak[]' class='form-control form-control-sm text-right numeric-only' value='{{ number_format(0, 2) }}'></td><td class='padding-table'><a href='javascript:void(0);' onclick=deleteRowContract('contract_row" + rowContractNo + "') class='btn btn-danger btn-xs'>Remove</a></td></tr>");
    }

    function deleteRowContract(rowContractNo) {
        $('#' + rowContractNo).remove();
    }

    $("#financeFileContract").submit(function (e) {
        e.preventDefault();

        $.ajax({
            method: "POST",
            url: "{{ URL::action('FinanceController@updateFinanceFileContract') }}",
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
