<?php
$prefix = 'maintenancefee_';
$prefix2 = 'singkingfund_';
?>

<div class="tab-content padding-vertical-20">
    <div class="tab-pane active" id="buyer_tab" role="tabpanel">
        <div class="row">
            <div class="col-lg-12">
                <form id="financeVandalForm" method="POST">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label style="color: red; font-style: italic;">* Mandatory Fields</label>
                            </div>
                        </div>
                    </div>   
                    <div class="row" style="margin-top: 10px;">
                        <p>4.4 PEMBAIKAN/PENGGANTIAN/PEMBELIAN/NAIKTARAF/PEMBAHARUAN (VANDALISME) a. Guna Duit Maintenance Fee</p>
                        <table class="table table-bordered">
                            <thead>
                            <th>
                            <td>PERKARA</td>
                            <td width="10%">TUNGGAKAN BULAN-BULAN TERDAHULU A</td>
                            <td width="10%">BULAN SEMASA B</td>
                            <td width="10%">BULAN HADAPAN C</td>
                            <td width="10%">JUMLAH A+B+C</td>
                            <td width="10%">BAKI BAYARAN MASIH TERTUNGGAK (BELUM BAYAR)</td>
                            </th>
                            </thead>
                            <tbody>
                                <?php
                                $t_name = '';
                                $t_tunggakan_a = 0;
                                $t_bulan_semasa_b = 0;
                                $t_bulan_hadapan_c = 0;
                                $t_tertunggak = 0;
                                $t_jumlahAbc = 0;
                                ?>
                            <input type="hidden" name="finance_file_id" value="{{$finance_file_id}}">
                            @for ($i = 0; $i < 21; $i++)
                            <?php
                            $name = (isset($vandala[$i]['name'])) ? $vandala[$i]['name'] : '';
                            $tunggakan_a = (isset($vandala[$i]['tunggakan_a'])) ? $vandala[$i]['tunggakan_a'] : 0;
                            $bulan_semasa_b = (isset($vandala[$i]['bulan_semasa_b'])) ? $vandala[$i]['bulan_semasa_b'] : 0;
                            $bulan_hadapan_c = (isset($vandala[$i]['bulan_hadapan_c'])) ? $vandala[$i]['bulan_hadapan_c'] : 0;
                            $jumlahAbc = $tunggakan_a + $bulan_semasa_b + $bulan_hadapan_c;
                            $tertunggak = (isset($vandala[$i]['tertunggak'])) ? $vandala[$i]['tertunggak'] : 0;

                            $t_tunggakan_a += $tunggakan_a;
                            $t_bulan_semasa_b += $bulan_semasa_b;
                            $t_bulan_hadapan_c += $bulan_hadapan_c;
                            $t_tertunggak += $tertunggak;
                            $t_jumlahAbc += $jumlahAbc;
                            ?>
                            <tr>
                                <td width="1%" class="text-center">{{$i+1}}</td>
                                <td><input type="text" name="{{$prefix.'name[]'}}" class="form-control" value="{{ $name }}"></td>
                                <td><input type="text" name="{{$prefix.'tunggakan_a[]'}}" class="form-control numeric-only" value="{{ $tunggakan_a }}"></td>
                                <td><input type="text" name="{{$prefix.'bulan_semasa_b[]'}}" class="form-control numeric-only" value="{{ $bulan_semasa_b }}"></td>
                                <td><input type="text" name="{{$prefix.'bulan_hadapan_c[]'}}" class="form-control numeric-only" value="{{ $bulan_hadapan_c }}"></td>
                                <td><input type="text" name="{{$prefix.'jumlah_abc[]'}}" class="form-control numeric-only" value="{{$jumlahAbc}}" disabled='true'></td>
                                <td><input type="text" name="{{$prefix.'tertunggak[]'}}" class="form-control numeric-only" value="{{ $tertunggak  }}"></td>
                            </tr>
                            @endfor
                            <tr>
                                <td colspan="2">JUMLAH</td>
                                <td><input type="text" class="form-control" value="{{ number_format($t_tunggakan_a) }}"disabled></td>
                                <td><input type="text" class="form-control" value="{{ number_format($t_bulan_semasa_b) }}"disabled></td>
                                <td><input type="text" class="form-control" value="{{ number_format($t_bulan_hadapan_c) }}"disabled></td>
                                <td><input type="text" class="form-control" value="{{ number_format($t_jumlahAbc) }}"disabled></td>
                                <td><input type="text" class="form-control" value="{{ number_format($t_tertunggak) }}"disabled></td>
                            </tr>
                            </tbody>
                        </table> 
                    </div>

                    <div class="row" style="margin-top: 10px;">
                        <p>4.4 PEMBAIKAN/PENGGANTIAN/PEMBELIAN/NAIKTARAF/PEMBAHARUAN (VANDALISME) b. Guna Duit Sinking Fund</p>
                        <table class="table table-bordered">
                            <thead>
                            <th>
                            <td>PERKARA</td>
                            <td width="10%">TUNGGAKAN BULAN-BULAN TERDAHULU A</td>
                            <td width="10%">BULAN SEMASA B</td>
                            <td width="10%">BULAN HADAPAN C</td>
                            <td width="10%">JUMLAH A+B+C</td>
                            <td width="10%">BAKI BAYARAN MASIH TERTUNGGAK (BELUM BAYAR)</td>
                            </th>
                            </thead>
                            <tbody>
                                <?php
                                $t_name2 = '';
                                $t_tunggakan_a2 = 0;
                                $t_bulan_semasa_b2 = 0;
                                $t_bulan_hadapan_c2 = 0;
                                $t_tertunggak2 = 0;
                                $t_jumlahAbc2 = 0;
                                ?>
                            <input type="hidden" name="finance_file_id" value="{{$finance_file_id}}">
                            @for ($i = 0; $i < 21; $i++)
                            <?php
                            $name2 = (isset($vandalb[$i]['name'])) ? $vandalb[$i]['name'] : '';
                            $tunggakan_a2 = (isset($vandalb[$i]['tunggakan_a'])) ? $vandalb[$i]['tunggakan_a'] : 0;
                            $bulan_semasa_b2 = (isset($vandalb[$i]['bulan_semasa_b'])) ? $vandalb[$i]['bulan_semasa_b'] : 0;
                            $bulan_hadapan_c2 = (isset($vandalb[$i]['bulan_hadapan_c'])) ? $vandalb[$i]['bulan_hadapan_c'] : 0;
                            $jumlahAbc2 = $tunggakan_a2 + $bulan_semasa_b2 + $bulan_hadapan_c2;
                            $tertunggak2 = (isset($vandalb[$i]['tertunggak'])) ? $vandalb[$i]['tertunggak'] : 0;

                            $t_tunggakan_a2 += $tunggakan_a2;
                            $t_bulan_semasa_b2 += $bulan_semasa_b2;
                            $t_bulan_hadapan_c2 += $bulan_hadapan_c2;
                            $t_tertunggak2 += $tertunggak2;
                            $t_jumlahAbc2 += $jumlahAbc2;
                            ?>
                            <tr>
                                <td width="1%" class="text-center">{{$i+1}}</td>
                                <td><input type="text" name="{{$prefix2.'name[]'}}" class="form-control" value="{{ $name2 }}"></td>
                                <td><input type="text" name="{{$prefix2.'tunggakan_a[]'}}" class="form-control numeric-only" value="{{ $tunggakan_a2 }}"></td>
                                <td><input type="text" name="{{$prefix2.'bulan_semasa_b[]'}}" class="form-control numeric-only" value="{{ $bulan_semasa_b2 }}"></td>
                                <td><input type="text" name="{{$prefix2.'bulan_hadapan_c[]'}}" class="form-control numeric-only" value="{{ $bulan_hadapan_c2 }}"></td>
                                <td><input type="text" name="{{$prefix2.'jumlah_abc[]'}}" class="form-control numeric-only" value="{{$jumlahAbc2}}" disabled='true'></td>
                                <td><input type="text" name="{{$prefix2.'tertunggak[]'}}" class="form-control numeric-only" value="{{ $tertunggak2  }}"></td>
                            </tr>
                            @endfor
                            <tr>
                                <td colspan="2">JUMLAH</td>
                                <td><input type="text" class="form-control" value="{{ number_format($t_tunggakan_a2) }}"disabled></td>
                                <td><input type="text" class="form-control" value="{{ number_format($t_bulan_semasa_b2) }}"disabled></td>
                                <td><input type="text" class="form-control" value="{{ number_format($t_bulan_hadapan_c2) }}"disabled></td>
                                <td><input type="text" class="form-control" value="{{ number_format($t_jumlahAbc2) }}"disabled></td>
                                <td><input type="text" class="form-control" value="{{ number_format($t_tertunggak2) }}"disabled></td>
                            </tr>
                            </tbody>
                        </table>   
                    </div>

                    <div class="form-actions">
                        <?php if ($insert_permission == 1) { ?>
                            <input type="submit" value="Submit" class="btn btn-primary" id="btnSubmitFileVandal">
                        <?php } ?>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>

    $("#financeVandalForm").submit(function (e) {
        e.preventDefault();

        $.ajax({
            method: "POST",
            url: "{{ URL::action('FinanceController@updateFinanceFileVandal') }}",
            data: $(this).serialize(),
            beforeSend: function () {
                $("#btnSubmitFileVandal").html('Loading').prop('disabled', true);
            },
            complete: function (data) {
                // Hide image container
                $("#btnSubmitFileVandal").html('Submit').prop('disabled', false);
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
