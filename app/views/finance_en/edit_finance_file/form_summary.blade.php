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
    'lain_lain' => 'Lain-Lain-sekiranya ada Termasuk sila senaraikan',
];
?>

<div class="row">
    <div class="col-lg-12">
        <h6>Summary</h6>
        <form id="summaryForm">  
            <div class="row">
                <table class="table table-sm" style="font-size: 12px;">
                    <tbody>
                        <?php $no = 1; ?>
                        @foreach ($tableField as $key => $val)
                        <tr>
                            <td width="5%" class="padding-table text-center">{{$no++}}</td>
                            <td width="85%" class="padding-table">{{ $val }}</td>
                            <td width="10%"><input type="number" step="any" class="form-control form-control-sm text-right" id="{{$prefix.$key}}" value="0.00" readonly=""></td>
                        </tr>
                        @endforeach
                        <tr>
                            <td>&nbsp;</td>
                            <th class="padding-table">JUMLAH PERBELANJAAN</th>
                            <th><input type="number" step="any" class="form-control form-control-sm text-right" id="{{$prefix.'jumlah_pembelanjaan'}}" value="0.00" readonly=""></th>
                        </tr>
                    </tbody>
                </table>    
            </div>
        </form>
    </div>
</div>