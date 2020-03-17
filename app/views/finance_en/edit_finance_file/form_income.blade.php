<?php
$prefix = 'income_';
?>

<div class="tab-content padding-vertical-20">
    <div class="tab-pane active" id="buyer_tab" role="tabpanel">
        <div class="row">
            <div class="col-lg-12">
                <form id="financeFileIncome">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label style="color: red; font-style: italic;">* Mandatory Fields</label>
                            </div>
                        </div>
                    </div>   
                    <div class="row">
                        <div class="col-md-6">
                            <p>3. LAPORAN PENDAPATAN</p>
                        </div>
                    </div>
                    <div class="row">
                        <table class="table table-bordered">
                            <thead>
                            <th>
                            <td>PENDAPATAN</td>
                            <td width="10%">TUNGGAKAN B</td>
                            <td width="10%">SEMASA A</td>
                            <td width="10%">ADVANCED C</td>
                            <td width="10%">JUMLAH A+B+C</td>
                            </th>
                            </thead>
                            <tbody>
                                <?php
                                $total_a = 0;
                                $total_b = 0;
                                $total_c = 0;
                                $total_d = 0;
                                ?>
                            <input type="hidden" name="finance_file_id" value="{{$finance_file_id}}">
                            @for ($i = 0; $i < 16; $i++)
                            <?php
                            $income_name = (isset($incomeFile[$i]['name'])) ? $incomeFile[$i]['name'] : '';
                            $income_tunggakan_b = (isset($incomeFile[$i]['tunggakan_b'])) ? $incomeFile[$i]['tunggakan_b'] : 0;
                            $income_semasa_a = (isset($incomeFile[$i]['income_semasa_a'])) ? $incomeFile[$i]['income_semasa_a'] : 0;
                            $income_advanced_d = (isset($incomeFile[$i]['income_advanced_d'])) ? $incomeFile[$i]['income_advanced_d'] : 0;
                            $income_jumlahAbc = $income_tunggakan_b + $income_semasa_a + $income_advanced_d;

                            $total_a += $income_tunggakan_b;
                            $total_b += $income_semasa_a;
                            $total_c += $income_advanced_d;
                            $total_d += $income_jumlahAbc;
                            ?>
                            <tr>
                                <td width="1%" class="text-center">{{$i+1}}</td>
                                <td><input type="text" name="{{$prefix.'name[]'}}" class="form-control" value="{{ $income_name }}"></td>
                                <td><input type="text" name="{{$prefix.'tunggakan_b[]'}}" class="form-control numeric-only" value="{{ $income_tunggakan_b }}"></td>
                                <td><input type="text" name="{{$prefix.'semasa_a[]'}}" class="form-control numeric-only" value="{{ $income_semasa_a }}"></td>
                                <td><input type="text" name="{{$prefix.'advanced_d[]'}}" class="form-control numeric-only" value="{{ $income_advanced_d }}"></td>
                                <td><input type="text" name="{{$prefix.'jumlah_abc[]'}}" class="form-control numeric-only" value="{{$income_jumlahAbc}}" disabled='true'></td>
                            </tr>
                            @endfor
                            <tr>
                                <td colspan="2">JUMLAH</td>
                                <td><input type="text" class="form-control" value="{{ number_format($total_a) }}"disabled></td>
                                <td><input type="text" class="form-control" value="{{ number_format($total_b) }}"disabled></td>
                                <td><input type="text" class="form-control" value="{{ number_format($total_c) }}"disabled></td>
                                <td><input type="text" class="form-control" value="{{ number_format($total_d) }}"disabled></td>
                            </tr>
                            </tbody>
                        </table>    
                    </div>                                                
                    <div class="form-actions">
                        <?php if ($insert_permission == 1) { ?>
                            <input type="submit" value="Submit" class="btn btn-primary" id="btnSubmitFileIncome">
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

    $("#financeFileIncome").submit(function (e) {
        e.preventDefault();

        $.ajax({
            method: "POST",
            url: "{{ URL::action('FinanceController@updateFinanceFileIncome') }}",
            data: $(this).serialize(),
            beforeSend: function () {
                $("#btnSubmitFileIncome").html('Loading').prop('disabled', true);
            },
            complete: function (data) {
                // Hide image container
                $("#btnSubmitFileIncome").html('Submit').prop('disabled', false);
            },
            success: function (response) {
                if (response.trim() == "true") {
                    bootbox.alert("<span style='color:green;'>Finance Income Data added successfully!</span>");
                } else {
                    bootbox.alert("<span style='color:red;'>An error occured while processing. Please try again.</span>");
                }
                console.log(response);
            }
        });
    })
</script>
