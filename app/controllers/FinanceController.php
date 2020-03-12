<?php

class FinanceController extends BaseController {
    
    public function  updateFinanceCheck(){
        $data = Input::all();
        $financeFileId = $data['finance_file_id'];
        $financeCheckId = $data['finance_check_id'];
        $financeCheck = FinanceCheck::where('finance_file_id', $financeFileId)->first();
        if(Input::ajax()){
            if(is_null($financeCheck)){
                $fc = new FinanceCheck;
                $fc->finance_file_id = $financeFileId;
                $fc->date = $data['date'];
                $fc->name = $data['name'];
                $fc->position = $data['position'];
                $fc->status = $data['status'];
                $fc->save();

                 # Audit Trail
                 $remarks = 'Finance File  with id : ' . $fc->id . ' has been updated.';
                 $auditTrail = new AuditTrail();
                 $auditTrail->module = "COB Finance File  - Check";
                 $auditTrail->remarks = $remarks;
                 $auditTrail->audit_by = Auth::user()->id;
                 $auditTrail->save();
                 print "true";

            }else{
                $fc = FinanceCheck::where('id', $financeCheckId)->update([
                    'date' => $data['date'], 
                    'name' => $data['name'], 
                    'position' => $data['position'], 
                    'status' => $data['status'], 
                    'remark' => $data['remark'], 
                ]);
                 # Audit Trail
                 $remarks = 'Finance File  with id : ' . $financeCheck->id . ' has been updated.';
                 $auditTrail = new AuditTrail();
                 $auditTrail->module = "COB Finance File  - Check";
                 $auditTrail->remarks = $remarks;
                 $auditTrail->audit_by = Auth::user()->id;
                 $auditTrail->save();
                 print "true";
            }
        }
    }

    public function updateFinanceFileAdmin(){
        $data = Input::all();
        $id = $data['finance_file_id'];

        FinanceAdmin::where('finance_file_id', $id)->delete();

        $names = $data['admin_name'];
        for($i=0; $i<25; $i++){
            $financeadmin = new FinanceAdmin;
            $financeadmin->finance_file_id = $id;
            $financeadmin->name = $data['admin_name'][$i];
            $financeadmin->tunggakan_a = $data['admin_tunggakan_a'][$i];
            $financeadmin->bulan_semasa_b = $data['admin_bulan_semasa_b'][$i];
            $financeadmin->bulan_hadapan_c = $data['admin_bulan_hadapan_c'][$i];
            $financeadmin->tertunggak = $data['admin_tertunggak'][$i];
            $financeadmin->order = $i;
            $financeadmin->save();
        }

        if($financeadmin){
            echo 'true';
        }else{
            echo 'false';
        }
    }

    public function updateFinanceFileIncome(){
        $data = Input::all();
        $id = $data['finance_file_id'];

        FinanceIncome::where('finance_file_id', $id)->delete();

        for($i=0; $i<16; $i++){
            $financeadmin = new FinanceIncome;
            $financeadmin->finance_file_id = $id;
            $financeadmin->name = $data['income_name'][$i];
            $financeadmin->tunggakan_b = $data['income_tunggakan_b'][$i];
            $financeadmin->semasa_a = $data['income_semasa_a'][$i];
            $financeadmin->advanced_d = $data['income_advanced_d'][$i];
            $financeadmin->order = $i;
            $financeadmin->save();
        }

        if($financeadmin){
            echo 'true';
        }else{
            echo 'false';
        }
    }

    public function updateFinanceFileUtility(){
        $data = Input::all();
        $id = $data['finance_file_id'];

        FinanceUtility::where('finance_file_id', $id)->delete();

        $prefix = [
            'util_', 
            'utilb_', 
        ];

        for($i=0; $i<2; $i++){
            
            foreach($prefix as $p){
                $financeadmin = new FinanceUtility;
                $financeadmin->finance_file_id = $id;
                $financeadmin->name = $data[$p.'name'][$i];
                
                if($p == 'util_') {
                    $financeadmin->type = 'bagian_a';
                }else{
                    $financeadmin->type = 'bagian_b';
                }
                $financeadmin->tunggakan_a = $data[$p.'tunggakan_a'][$i];
                $financeadmin->semasa_b = $data[$p.'semasa_b'][$i];
                $financeadmin->hadapan_c = $data[$p.'hadapan_c'][$i];
                $financeadmin->tertunggak = $data[$p.'tertunggak'][$i];
                $financeadmin->order = $i;
                $financeadmin->save();
            }
        
        }

        if($financeadmin){
            echo 'true';
        }else{
            echo 'false';
        }
    }

    public function updateFinanceFileReportSf(){
        $data = Input::all();
        $id = $data['finance_file_id'];

        FinanceReportPerbelanjaan::where('finance_file_id', $id)->where('type'. 'sf')->delete();
        FinanceReportSf::where('finance_file_id', $id)->delete();

        $financeReportSf = new FinanceReportSf;
        $financeReportSf->finance_file_id = $id;
        $financeReportSf->sinkingfund_sebulan = $data['sfr_sinkingfund_sebulan'];
        $financeReportSf->unit = $data['sfr_unit'];
        $financeReportSf->sinkingfund_semasa = $data['sfr_semasa'];
        $financeReportSf->no_akaun = $data['sf_no_akaun'];
        $financeReportSf->nama_bank = $data['sf_nama_bank'];
        $financeReportSf->baki_bank_awal = $data['sf_baki_bank_awal'];
        $financeReportSf->baki_bank_akhir = $data['sf_baki_bank_akhir'];
        $financeReportSf->save();

        for($i=0; $i<6; $i++){
            $frp = new FinanceReportPerbelanjaan;
            $frp->type = 'sf';
            $frp->finance_file_id = $id;
            $frp->name = $data['sf_name'][$i];
            $frp->amount = $data['sf_amount'][$i];
            $frp->order = $i;
            $frp->save();
        }

        if($financeReportSf){
            echo 'true';
        }else{
            echo 'false';
        }
    }

    public function updateFinanceFileReportMf(){
        $data = Input::all();
        $id = $data['finance_file_id'];

        FinanceReportPerbelanjaan::where('finance_file_id', $id)->where('type'. 'mf')->delete();
        FinanceReportMf::where('finance_file_id', $id)->delete();

        $financeReportSf = new FinanceReportMf;
        $financeReportSf->finance_file_id = $id;
        $financeReportSf->maintenance_fee_sebulan = $data['mfr_maintenance_fee_sebulan'];
        $financeReportSf->unit = $data['mfr_unit'];
        $financeReportSf->servicefee_semasa = $data['mfr_semasa'];
        $financeReportSf->no_akaun = $data['mf_no_akaun'];
        $financeReportSf->nama_bank = $data['mf_nama_bank'];
        $financeReportSf->baki_bank_awal = $data['mf_baki_bank_awal'];
        $financeReportSf->baki_bank_akhir = $data['mf_baki_bank_akhir'];
        $financeReportSf->save();

        for($i=0; $i<6; $i++){
            $frp = new FinanceReportPerbelanjaan;
            $frp->type = 'mf';
            $frp->finance_file_id = $id;
            $frp->name = $data['mf_name'][$i];
            $frp->amount = $data['mf_amount'][$i];
            $frp->order = $i;
            $frp->save();
        }

        if($financeReportSf){
            echo 'true';
        }else{
            echo 'false';
        }
    }

    public function updateFinanceFileVandal(){
        $data = Input::all();
        $id = $data['finance_file_id'];

        FinanceVandal::where('finance_file_id', $id)->delete();

        $prefix = [
            'maintenancefee_', 
            'singkingfund_'
        ];

        for($i=0; $i<21; $i++){
            
            foreach($prefix as $p){
                $financeadmin = new FinanceVandal;
                $financeadmin->finance_file_id = $id;
                $financeadmin->name = $data[$p.'name'][$i];
                
                if($p == 'maintenancefee_') {
                    $financeadmin->type = 'maintenancefee';
                }else{
                    $financeadmin->type = 'singkingfund';
                }
                $financeadmin->tunggakan_a = $data[$p.'tunggakan_a'][$i];
                $financeadmin->bulan_semasa_b = $data[$p.'bulan_semasa_b'][$i];
                $financeadmin->bulan_hadapan_c = $data[$p.'bulan_hadapan_c'][$i];
                $financeadmin->tertunggak = $data[$p.'tertunggak'][$i];
                $financeadmin->order = $i;
                $financeadmin->save();
            }
        
        }

        if($financeadmin){
            echo 'true';
        }else{
            echo 'false';
        }
    }

    public function updateFinanceFileRepair(){
        $data = Input::all();
        $id = $data['finance_file_id'];

        FinanceRepair::where('finance_file_id', $id)->delete();

        $prefix = [
            'repair_maintenancefee_', 
            'repair_singkingfund_'
        ];

        for($i=0; $i<21; $i++){
            
            foreach($prefix as $p){
                $financeadmin = new FinanceRepair;
                $financeadmin->finance_file_id = $id;
                $financeadmin->name = $data[$p.'name'][$i];
                
                if($p == 'repair_maintenancefee_') {
                    $financeadmin->type = 'maintenancefee';
                }else{
                    $financeadmin->type = 'singkingfund';
                }
                $financeadmin->tunggakan_a = $data[$p.'tunggakan_a'][$i];
                $financeadmin->bulan_semasa_b = $data[$p.'bulan_semasa_b'][$i];
                $financeadmin->bulan_hadapan_c = $data[$p.'bulan_hadapan_c'][$i];
                $financeadmin->tertunggak = $data[$p.'tertunggak'][$i];
                $financeadmin->order = $i;
                $financeadmin->save();
            }
        
        }

        if($financeadmin){
            echo 'true';
        }else{
            echo 'false';
        }
    }

    public function updateFinanceFileContract(){
        $data = Input::all();
        $id = $data['finance_file_id'];

        $prefix = 'contract_';
        FinanceContract::where('finance_file_id', $id)->delete();

        for($i=0; $i<25; $i++){
            $financeadmin = new FinanceContract;
            $financeadmin->finance_file_id = $id;
            $financeadmin->name = $data[$prefix.'name'][$i];
            $financeadmin->tunggakan_a = $data[$prefix . 'tunggakan_a'][$i];
            $financeadmin->bulan_semasa_b = $data[$prefix . 'bulan_semasa_b'][$i];
            $financeadmin->bulan_hadapan_c = $data[$prefix . 'bulan_hadapan_c'][$i];
            $financeadmin->tertunggak = $data[$prefix . 'tertunggak'][$i];
            $financeadmin->order = $i;
            $financeadmin->save();
        }

        if($financeadmin){
            echo 'true';
        }else{
            echo 'false';
        }
    }

    public function updateFinanceFileStaff(){
        $data = Input::all();
        $id = $data['finance_file_id'];

        FinanceStaff::where('finance_file_id', $id)->delete();

        for($i=0; $i<21; $i++){
            $financestaff = new FinanceStaff;
            $financestaff->finance_file_id = $id;
            $financestaff->name = $data['staff_name'][$i];
            $financestaff->gaji_perorang_a = $data['staff_gaji_perorang_a'][$i];
            $financestaff->bil_pekerja_b = $data['staff_bil_pekerja_b'][$i];
            $financestaff->tunggakan_c = $data['staff_tunggakan_c'][$i];
            $financestaff->bulan_semasa_d = $data['staff_bulan_semasa_d'][$i];
            $financestaff->bulan_hadapan_e = $data['staff_bulan_hadapan_e'][$i];
            $financestaff->tertunggak = $data['staff_tertunggak'][$i];
            $financestaff->order = $i;
            $financestaff->save();
        }

        if($financestaff){
            echo 'true';
        }else{
            echo 'false';
        }
    }
    
}
