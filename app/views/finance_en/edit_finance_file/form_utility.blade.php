<?php
$prefix = 'util_';
$prefix2 = 'utilb_';
?>

<div class="tab-content padding-vertical-20">
    <div class="tab-pane active" id="buyer_tab" role="tabpanel">
        <div class="row">
            <div class="col-lg-12">
                <form id="formFinanceUtility">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label style="color: red; font-style: italic;">* Mandatory Fields</label>
                            </div>
                        </div>
                    </div>   
                    <div class="row" style="margin-top: 10px;">
                        <p>4.1 LAPORAN PERBELANJAAN UTILITI</p>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>PERKARA</th>
                                    <th style="width: 10%">TUNGGAKAN BULAN-BULAN TERDAHULU A</th>
                                    <th style="width: 10%">BULAN SEMASA B</th>
                                    <th style="width: 10%">BULAN HADAPAN C</th>
                                    <th style="width: 10%">JUMLAH A+B+C</th>
                                    <th style="width: 10%">BAKI BAYARAN MASIH TERTUNGGAK (BELUM BAYAR)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="7">BAHAGIAN A</td>
                                </tr>

                                <?php
                                $total_a = 0;
                                $total_b = 0;
                                $total_c = 0;
                                $total_d = 0;
                                $total_e = 0;
                                $total2_a = 0;
                                $total2_b = 0;
                                $total2_c = 0;
                                $total2_d = 0;
                                $total2_e = 0;
                                ?>
                            <input type="hidden" name="finance_file_id" value="{{$finance_file_id}}">
                            @for ($i = 0; $i < 2; $i++)
                            <?php
                            $utila_name = (isset($utila[$i]['name'])) ? $utila[$i]['name'] : '';
                            $utila_tunggakan_a = (isset($utila[$i]['tunggakan_a'])) ? $utila[$i]['tunggakan_a'] : 0;
                            $utila_semasa_b = (isset($utila[$i]['semasa_b'])) ? $utila[$i]['semasa_b'] : 0;
                            $utila_hadapan_c = (isset($utila[$i]['hadapan_c'])) ? $utila[$i]['hadapan_c'] : 0;
                            $utila_tertunggak = (isset($utila[$i]['tertunggak'])) ? $utila[$i]['tertunggak'] : 0;
                            $utila_jumlahabc = $utila_tunggakan_a + $utila_semasa_b + $utila_hadapan_c;

                            $total_a += $utila_tunggakan_a;
                            $total_b += $utila_semasa_b;
                            $total_c += $utila_hadapan_c;
                            $total_d += $utila_tertunggak;
                            $total_e += $utila_jumlahabc;
                            ?>
                            <tr>
                                <td width="1%" class="text-center">{{$i+1}}</td>
                                <td><input type="text" name="{{$prefix.'name[]'}}" class="form-control" value="{{ $utila_name }}"></td>
                                <td><input type="text" name="{{$prefix.'tunggakan_a[]'}}" class="form-control numeric-only" value="{{ $utila_tunggakan_a }}"></td>
                                <td><input type="text" name="{{$prefix.'semasa_b[]'}}" class="form-control numeric-only" value="{{ $utila_semasa_b }}"></td>
                                <td><input type="text" name="{{$prefix.'hadapan_c[]'}}" class="form-control numeric-only" value="{{ $utila_hadapan_c }}"></td>
                                <td><input type="text" name="{{$prefix.'jumlah_abc[]'}}" class="form-control numeric-only" value="{{$utila_jumlahabc}}" disabled='true'></td>
                                <td><input type="text" name="{{$prefix.'tertunggak[]'}}" class="form-control numeric-only" value="{{ $utila_tertunggak  }}"></td>
                            </tr>
                            @endfor
                            <tr>
                                <td colspan="2">JUMLAH BAHAGIAN A</td>
                                <td><input type="text" class="form-control" value="{{ number_format($total_a) }}"disabled></td>
                                <td><input type="text" class="form-control" value="{{ number_format($total_b) }}"disabled></td>
                                <td><input type="text" class="form-control" value="{{ number_format($total_c) }}"disabled></td>
                                <td><input type="text" class="form-control" value="{{ number_format($total_e) }}"disabled></td>
                                <td><input type="text" class="form-control" value="{{ number_format($total_d) }}"disabled></td>
                            </tr>

                            <tr>
                                <td colspan="7">BAHAGIAN B</td>
                            </tr>

                            @for ($i = 0; $i < 2; $i++)
                            <?php
                            $utilb_name = (isset($utilb[$i]['name'])) ? $utilb[$i]['name'] : '';
                            $utilb_tunggakan_a = (isset($utilb[$i]['tunggakan_a'])) ? $utilb[$i]['tunggakan_a'] : 0;
                            $utilb_semasa_b = (isset($utilb[$i]['semasa_b'])) ? $utilb[$i]['semasa_b'] : 0;
                            $utilb_hadapan_c = (isset($utilb[$i]['hadapan_c'])) ? $utilb[$i]['hadapan_c'] : 0;
                            $utilb_tertunggak = (isset($utilb[$i]['tertunggak'])) ? $utilb[$i]['tertunggak'] : 0;
                            $utilb_jumlahabc = $utilb_tunggakan_a + $utilb_semasa_b + $utilb_hadapan_c;

                            $total2_a += $utilb_tunggakan_a;
                            $total2_b += $utilb_semasa_b;
                            $total2_c += $utilb_hadapan_c;
                            $total2_d += $utilb_tertunggak;
                            $total2_e += $utilb_jumlahabc;
                            ?>
                            <tr>
                                <td width="1%" class="text-center">{{$i+1}}</td>
                                <td><input type="text" name="{{$prefix2.'name[]'}}" class="form-control" value="{{ $utilb_name }}"></td>
                                <td><input type="text" name="{{$prefix2.'tunggakan_a[]'}}" class="form-control numeric-only" value="{{ $utilb_tunggakan_a }}"></td>
                                <td><input type="text" name="{{$prefix2.'semasa_b[]'}}" class="form-control numeric-only" value="{{ $utilb_semasa_b }}"></td>
                                <td><input type="text" name="{{$prefix2.'hadapan_c[]'}}" class="form-control numeric-only" value="{{ $utilb_hadapan_c }}"></td>
                                <td><input type="text" name="{{$prefix2.'jumlah_abc[]'}}" class="form-control numeric-only" value="{{$utilb_jumlahabc}}" disabled='true'></td>
                                <td><input type="text" name="{{$prefix2.'tertunggak[]'}}" class="form-control numeric-only" value="{{ $utilb_tertunggak  }}"></td>
                            </tr>
                            @endfor
                            <tr>
                                <td colspan="2">JUMLAH BAHAGIAN B</td>
                                <td><input type="text" class="form-control" value="{{ number_format($total2_a) }}"disabled></td>
                                <td><input type="text" class="form-control" value="{{ number_format($total2_b) }}"disabled></td>
                                <td><input type="text" class="form-control" value="{{ number_format($total2_c) }}"disabled></td>
                                <td><input type="text" class="form-control" value="{{ number_format($total2_d) }}"disabled></td>
                                <td><input type="text" class="form-control" value="{{ number_format($total2_e) }}"disabled></td>
                            </tr>

                            <tr>
                                <td colspan="2" class="text-right">JUMLAH BAHAGIAN A + BAHAGIAN B</td>
                                <td><input type="text"  class="form-control" disabled="true" value="{{ $total_a + $total2_a }}"></td>
                                <td><input type="text"  class="form-control" disabled="true" value="{{ $total_b + $total2_b }}"></td>
                                <td><input type="text"  class="form-control" disabled="true" value="{{ $total_c + $total2_c }}"></td>
                                <td><input type="text"  class="form-control" disabled="true" value="{{ $total_d + $total2_d }}"></td>
                                <td><input type="text"  class="form-control" disabled="true" value="{{ $total_e + $total2_e }}"></td>
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
            </div>
        </div>
    </div>
</div>

<script>

    $("#formFinanceUtility").submit(function (e) {
        e.preventDefault();

        $.ajax({
            method: "POST",
            url: "{{ URL::action('FinanceController@updateFinanceFileUtility') }}",
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
                    bootbox.alert("<span style='color:green;'>Finance Vandal Data added successfully!</span>");
                } else {
                    bootbox.alert("<span style='color:red;'>An error occured while processing. Please try again.</span>");
                }
                console.log(response);
            }
        });
    })
</script>
