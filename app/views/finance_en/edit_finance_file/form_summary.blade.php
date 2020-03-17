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
<div class="tab-content padding-vertical-20">
    <div class="tab-pane active" id="buyer_tab" role="tabpanel">
        <div class="row">
            <div class="col-lg-12">
                <!-- Buyer Form -->
                <form id="summaryForm">  
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
            </div>
        </div>
    </div>
</div>

<script>
</script>