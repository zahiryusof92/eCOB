<?php
    $prefix = 'sum_';
    $tableField = [
        'bill_air' => 'Bil Air',
        'bill_elektrik' => 'Bil. Elektrik',
        'caruman_insuran' => 'Caruman Insuran',
        'caruman_cukai' => 'Caruman Cukai Tanah',
        'fi_firma' => 'Fi Firma Kompeten Lif', 
        'pembersihan' => 'Pembersihan Termasuk potong rumput, lanskap, kutipan sampah pukal dan lain-lain',
        'keselamatan' => 'Keselamatan Termasuk Sistem CCTV, Palang Automatik, Kad Akses, Alat Pemadam Api, Penggera Kebakaran dan lain-lain	',
        'jurutera_elektrik' => 'Jurutera Elektrik',
        'mechaninal' => 'Mechaninal & Electrical Termasuk semua kerja-kerja penyenggaraan/ pembaikan /penggantian/ pembelian lampu, pendawaian elektrik, wayar bumi, kelengkapan lif, substation TNB,Genset dan lain-lain',
        'civil' => 'Civil & Structure Termasuk semua kerja-kerja penyenggaraan/ pembaikan /penggantian/ pembelian tangki air, bumbung, kolam renang, pembentung, perpaipan, tangga, pagar, longkang dan lain-lain',
        'kawalan_serangga' => 'Kawalan Serangga',
        'kos_pekerja' => 'Kos Pekerja',
        'pentadbiran' => 'Pentadbiran Termasuk telefon, internet, alat tulis pejabat, petty cash, sewaan mesin fotokopi, fi audit, caj bank dan lain-lain',
        'fi_ejen_pengurusan' => 'Fi Ejen Pengurusan',
        'lain_lain' => '',
];

?>
<form id="financeCheckForm">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label style="color: red; font-style: italic;">* Mandatory Fields</label>
            </div>
        </div>
    </div>
    <div class="row">
        <table class="table table-bordered">
            <tbody>
                <?php $no = 1; ?>
                @foreach ($tableField as $key => $val)
                    <tr>
                        <td width="1%" class="text-center">{{$no++}}</td>
                        <td>{{ $val }}</td>
                        <td><input type="text" name="{{$prefix.$key}}" class="form-control" value="0"></td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="2" class="text-right">Jumlah Pembelanjaan</td>
                    <td><input type="text" name="{{$prefix.'jumlah_pembelanjaan'}}" class="form-control" value="0"></td>
                </tr>
            </tbody>
          </table>    
    </div>                                                
    <div class="form-actions">
        <?php if ($insert_permission == 1) { ?>
        <input type="submit" value="Submit" class="btn btn-primary">
         <?php } ?>
    </div>
</form>
<script>
    $("#financeCheckForm").submit(function(e){
        e.preventDefault();
        console.log($(this).serialize());

        $("#loading").css("display", "inline-block");

        var error = 0;
        
        if ($("[name='name']").val().trim() == "") {
            $("#name_err").html('<span style="color:red;font-style:italic;font-size:13px;">Please Input Name</span>');
            $("#name_err").css("display", "block");
            error = 1;
        }

        if ($('[name=date]').val().trim() == "") {
            $("#date_err").html('<span style="color:red;font-style:italic;font-size:13px;">Please enter Date</span>');
            $("#date_err").css("display", "block");
            error = 1;
        }

        if ($('[name=position]').val().trim() == "") {
            $("#position_err").html('<span style="color:red;font-style:italic;font-size:13px;">Please input Position</span>');
            $("#position_err").css("display", "block");
            error = 1;
        }

        if ($('[name=status]').val().trim() == "") {
            $("#status_err").html('<span style="color:red;font-style:italic;font-size:13px;">Please input Status</span>');
            $("#status_err").css("display", "block");
            error = 1;
        }

        if (error == 0) {
            $.ajax({
                url: "{{ URL::action('FinanceController@updateFinanceCheck') }}",
                type: "POST",
                data: $(this).serialize(),
                success: function (data) {
                    $("#loading").css("display", "none");
                    $("#submit_button").removeAttr("disabled");
                    $("#cancel_button").removeAttr("disabled");
                    if (data.trim() == "true") {
                        bootbox.alert("<span style='color:green;'>Finance File updated successfully!</span>");
                    } else if (data.trim() == "file_already_exists") {
                        $("#file_already_exists_error").html('<span style="color:red;font-style:italic;font-size:13px;">This file already exist!</span>');
                        $("#file_already_exists_error").css("display", "block");
                    } else {
                        bootbox.alert("<span style='color:red;'>An error occured while processing. Please try again.</span>");
                    }
                }
            });
        }

    })
    
</script>