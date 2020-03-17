<?php
$prefix = 'staff_';
?>

<div class="tab-content padding-vertical-20">
    <div class="tab-pane active" id="buyer_tab" role="tabpanel">
        <div class="row">
            <div class="col-lg-12">
                <form id="financeFileStaff">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label style="color: red; font-style: italic;">* Mandatory Fields</label>
                            </div>
                        </div>
                    </div>   
                    <div class="row">
                        <div class="col-md-6">
                            <p>4.5 LAPORAN PERBELANJAAN PEKERJA</p>
                        </div>
                    </div>
                    <div class="row">
                        <table class="table table-bordered">
                            <thead>
                            <th>
                            <td>PERKARA</td>
                            <td width="10%">GAJI PERORANG (RM) A</td>
                            <td width="10%">BIL. PEKERJA B</td>
                            <td width="10%">JUMLAH GAJI A x B</td>
                            <td width="10%">TUNGGAKAN BULAN-BULAN TERDAHULU C</td>
                            <td width="10%">BULAN SEMASA D</td>
                            <td width="10%">BULAN HADAPAN E</td>
                            <td width="10%">JUMLAH C+D+E</td>
                            <td width="10%">BAKI BAYARAN MASIH TERTUNGGAK (BELUM BAYAR)</td>
                            </th>
                            </thead>
                            <tbody>
                                <?php
                                $t_name = '';
                                $a = 0;
                                $b = 0;
                                $c = 0;
                                $d = 0;
                                $e = 0;
                                $f = 0;
                                $g = 0;
                                $h = 0;
                                ?>
                            <input type="hidden" name="finance_file_id" value="{{$finance_file_id}}">
                            @for ($i = 0; $i <= 21; $i++)
                            <?php
                            $name = (isset($staffFile[$i]['name'])) ? $staffFile[$i]['name'] : '';
                            $gaji_perorang_a = (isset($staffFile[$i]['gaji_perorang_a'])) ? $staffFile[$i]['gaji_perorang_a'] : 0;
                            $bil_pekerja_b = (isset($staffFile[$i]['bil_pekerja_b'])) ? $staffFile[$i]['bil_pekerja_b'] : 0;
                            $jumlah_gaji_ab = $gaji_perorang_a + $bil_pekerja_b;

                            $tunggakan_c = (isset($staffFile[$i]['tunggakan_c'])) ? $staffFile[$i]['tunggakan_c'] : 0;
                            $bulan_semasa_d = (isset($staffFile[$i]['bulan_semasa_d'])) ? $staffFile[$i]['bulan_semasa_d'] : 0;
                            $bulan_hadapan_e = (isset($staffFile[$i]['bulan_hadapan_e'])) ? $staffFile[$i]['bulan_hadapan_e'] : 0;
                            $jumlahCde = $tunggakan_c + $bulan_semasa_d + $bulan_hadapan_e;

                            $tertunggak = (isset($staffFile[$i]['tertunggak'])) ? $staffFile[$i]['tertunggak'] : 0;

                            $c += $jumlah_gaji_ab;
                            $d += $tunggakan_c;
                            $e += $bulan_semasa_d;
                            $f += $bulan_hadapan_e;
                            $g += $jumlahCde;
                            $h += $tertunggak;
                            ?>

                            <tr>
                                <td width="1%" class="text-center">{{$i+1}}</td>
                                <td><input type="text" name="{{$prefix.'name[]'}}" class="form-control" value="{{ $name }}"></td>
                                <td><input type="text" name="{{$prefix.'gaji_perorang_a[]'}}" class="numeric-only form-control" value="{{ $gaji_perorang_a }}"></td>
                                <td><input type="text" name="{{$prefix.'bil_pekerja_b[]'}}" class="numeric-only form-control" value="{{ $bil_pekerja_b }}"></td>
                                <td><input type="text" name="{{$prefix.'jumlah_gaji_ab[]'}}" class="numeric-only form-control" value="{{ $jumlah_gaji_ab }}" disabled></td>
                                <td><input type="text" name="{{$prefix.'tunggakan_c[]'}}" class="numeric-only form-control" value="{{ $tunggakan_c }}"></td>
                                <td><input type="text" name="{{$prefix.'bulan_semasa_d[]'}}" class="numeric-only form-control" value="{{ $bulan_semasa_d }}"></td>
                                <td><input type="text" name="{{$prefix.'bulan_hadapan_e[]'}}" class="numeric-only form-control" value="{{ $bulan_hadapan_e }}"></td>
                                <td><input type="text" name="{{$prefix.'jumlah_cde[]'}}" class="numeric-only form-control" value="{{ $jumlahCde }}" disabled></td>
                                <td><input type="text" name="{{$prefix.'tertunggak[]'}}" class="numeric-only form-control" value="{{ $tertunggak }}"></td>
                            </tr>
                            @endfor
                            <tr>
                                <td colspan="4">JUMLAH</td>
                                <td><input type="text" class="form-control" value="{{ number_format($c) }}"disabled></td>
                                <td><input type="text" class="form-control" value="{{ number_format($d) }}"disabled></td>
                                <td><input type="text" class="form-control" value="{{ number_format($e) }}"disabled></td>
                                <td><input type="text" class="form-control" value="{{ number_format($f) }}"disabled></td>
                                <td><input type="text" class="form-control" value="{{ number_format($g) }}"disabled></td>
                                <td><input type="text" class="form-control" value="{{ number_format($h) }}"disabled></td>
                            </tr>
                            </tbody>
                        </table>    
                    </div>                                                
                    <div class="form-actions">
                        <?php if ($insert_permission == 1) { ?>
                            <input type="submit" value="Submit" class="btn btn-primary" id="btnSubmitFileStaff">
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

    $("#financeFileStaff").submit(function (e) {
        e.preventDefault();

        $.ajax({
            method: "POST",
            url: "{{ URL::action('FinanceController@updateFinanceFileStaff') }}",
            data: $(this).serialize(),
            beforeSend: function () {
                $("#btnSubmitFileStaff").html('Loading').prop('disabled', true);
            },
            complete: function (data) {
                // Hide image container
                $("#btnSubmitFileStaff").html('Submit').prop('disabled', false);
            },
            success: function (response) {
                if (response.trim() == "true") {
                    bootbox.alert("<span style='color:green;'>Finance Staff Data added successfully!</span>");
                } else {
                    bootbox.alert("<span style='color:red;'>An error occured while processing. Please try again.</span>");
                }
                console.log(response);
            }
        });
    })
</script>
