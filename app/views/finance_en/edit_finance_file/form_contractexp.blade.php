<?php
$prefix = 'contract_';
?>

<div class="tab-content padding-vertical-20">
    <div class="tab-pane active" id="buyer_tab" role="tabpanel">
        <div class="row">
            <div class="col-lg-12">
                <form id="financeFileContract">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label style="color: red; font-style: italic;">* Mandatory Fields</label>
                            </div>
                        </div>
                    </div>                      
                    <div class="row">
                        <div class="col-md-6">
                            <p>4.2 LAPORAN PERBELANJAAN PENYENGGARAAN</p>
                        </div>
                    </div>
                    <div class="row">
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
                            @for ($i = 0; $i < 25; $i++)
                            <?php
                            $name = (isset($contractFile[$i]['name'])) ? $contractFile[$i]['name'] : '';
                            $tunggakan_a = (isset($contractFile[$i]['tunggakan_a'])) ? $contractFile[$i]['tunggakan_a'] : 0;
                            $bulan_semasa_b = (isset($contractFile[$i]['bulan_semasa_b'])) ? $contractFile[$i]['bulan_semasa_b'] : 0;
                            $bulan_hadapan_c = (isset($contractFile[$i]['bulan_hadapan_c'])) ? $contractFile[$i]['bulan_hadapan_c'] : 0;
                            $jumlahAbc = $tunggakan_a + $bulan_semasa_b + $bulan_hadapan_c;
                            $tertunggak = (isset($contractFile[$i]['tertunggak'])) ? $contractFile[$i]['tertunggak'] : 0;

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
                    <div class="form-actions">
                        <?php if ($insert_permission == 1) { ?>
                            <input type="submit" value="Submit" class="btn btn-primary" id="btnSubmitContract">
                        <?php } ?>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(".numeric-only").on('keypress', function (e) {
        var keyCode = e.which ? e.which : e.keyCode;
        if (!(keyCode >= 48 && keyCode <= 57)) {
            return false;
        }
    });

    $("#financeFileContract").submit(function (e) {
        e.preventDefault();

        $.ajax({
            method: "POST",
            url: "{{ URL::action('FinanceController@updateFinanceFileContract') }}",
            data: $(this).serialize(),
            beforeSend: function () {
                $("#btnSubmitFileContract").html('Loading').prop('disabled', true);
            },
            complete: function (data) {
                // Hide image container
                $("#btnSubmitFileContract").html('Submit').prop('disabled', false);
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