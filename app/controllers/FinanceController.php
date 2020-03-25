<?php

class FinanceController extends BaseController {

    public function __construct() {
        if (empty(Session::get('lang'))) {
            Session::put('lang', 'en');
        }

        $locale = Session::get('lang');
        App::setLocale($locale);
    }

    // add finance file list
    public function addFinanceFileList() {
        //get user permission
        $user_permission = AccessGroup::getAccessPermission(Auth::user()->id);
        $file_no = Files::where('is_active', 1)->where('is_deleted', 0)->orderBy('year')->get();

        if (Session::get('lang') == "en") {
            $viewData = array(
                'title' => 'Add Finance File List',
                'panel_nav_active' => 'cob_panel',
                'main_nav_active' => 'cob_main',
                'sub_nav_active' => 'add_finance_list',
                'user_permission' => $user_permission,
                'image' => "",
                'file_no' => $file_no
            );

            return View::make('finance_en.add_finance_file', $viewData);
        } else {
            $viewData = array(
                'title' => 'Add Finance File List',
                'panel_nav_active' => 'cob_panel',
                'main_nav_active' => 'cob_main',
                'sub_nav_active' => 'add_finance_list',
                'user_permission' => $user_permission,
                'image' => "",
                'file_no' => $file_no
            );

            return View::make('finance_en.add_finance_file', $viewData);
        }
    }

    public function submitAddFinanceFile() {
        $data = Input::all();
        if (Request::ajax()) {
            $file_id = $data['file_id'];
            $year = $data['year'];
            $month = $data['month'];

            $check_exist = Finance::where('file_id', $file_id)->where('year', $year)->where('month', $month)->count();
            if ($check_exist <= 0) {
                $finance = new Finance();
                $finance->file_id = $file_id;
                $finance->month = $month;
                $finance->year = $year;
                $finance->is_active = 1;
                $success = $finance->save();

                if ($success) {
                    /*
                     * create Check
                     */
                    $check = new FinanceCheck();
                    $check->finance_file_id = $finance->id;
                    $check->is_active = 1;
                    $createCheck = $check->save();

                    if ($createCheck) {
                        /*
                         * create MF Report
                         */
                        $reportMF = new FinanceReport();
                        $reportMF->finance_file_id = $finance->id;
                        $reportMF->type = 'MF';
                        $createMF = $reportMF->save();

                        if ($createMF) {
                            $tableFieldMF = [
                                'utility' => 'UTILITI (BAHAGIAN A SAHAJA)',
                                'contract' => 'PENYENGGARAAN',
                                'repair' => 'PEMBAIKAN/PENGGANTIAN/PEMBELIAN/NAIKTARAF/PEMBAHARUAN',
                                'vandalisme' => 'PEMBAIKAN/PENGGANTIAN/PEMBELIAN (VANDALISME)',
                                'staff' => 'PEKERJA',
                                'admin' => 'PENTADBIRAN'
                            ];

                            $count = 1;
                            foreach ($tableFieldMF as $key => $name) {
                                $reportMF = new FinanceReportPerbelanjaan();
                                $reportMF->type = 'MF';
                                $reportMF->finance_file_id = $finance->id;
                                $reportMF->name = $name;
                                $reportMF->key = $key;
                                $reportMF->amount = 0;
                                $reportMF->sort_no = $count;
                                $reportMF->save();

                                $count++;
                            }
                        }

                        /*
                         * create SF Report
                         */
                        $reportSF = new FinanceReport();
                        $reportSF->finance_file_id = $finance->id;
                        $reportSF->type = 'SF';
                        $createSF = $reportSF->save();

                        if ($createSF) {
                            $tableFieldSF = [
                                'repair' => 'PEMBAIKAN/PENGGANTIAN/PEMBELIAN/NAIKTARAF/PEMBAHARUAN',
                                'vandalisme' => 'PEMBAIKAN/PENGGANTIAN/PEMBELIAN (VANDALISME)'
                            ];

                            $counter = 1;
                            foreach ($tableFieldSF as $count => $name) {
                                $reportSF = new FinanceReportPerbelanjaan();
                                $reportSF->type = 'SF';
                                $reportSF->finance_file_id = $finance->id;
                                $reportSF->name = $name;
                                $reportMF->key = $key;
                                $reportSF->amount = 0;
                                $reportSF->sort_no = ++$count;
                                $reportSF->save();

                                $counter++;
                            }
                        }

                        /*
                         * create Income
                         */
                        $tableFieldIncome = [
                            'MAINTENANCE FEE',
                            'SINKING FUND',
                            'INSURAN BANGUNAN',
                            'CUKAI TANAH',
                            'PELEKAT KENDERAAN',
                            'KAD AKSES',
                            'SEWAAN TLK',
                            'SEWAAN KEDAI',
                            'SEWAAN HARTA BERSAMA',
                            'DENDA UNDANG-UNDANG KECIL',
                            'DENDA LEWAT BAYAR MAINTENANCE FEE @ SINKING FUND',
                            'BIL METER AIR PEMILIK-PEMILIK(DI BAWAH AKAUN METER PUKAL SAHAJA)',
                        ];

                        foreach ($tableFieldIncome as $count => $name) {
                            $income = new FinanceIncome();
                            $income->finance_file_id = $finance->id;
                            $income->name = $name;
                            $income->tunggakan = 0;
                            $income->semasa = 0;
                            $income->hadapan = 0;
                            $income->sort_no = ++$count;
                            $income->save();
                        }

                        /*
                         * create Utility A
                         */
                        $tableFieldUtilityA = [
                            'BIL AIR METER PUKAL',
                            'BIL ELEKTRIK HARTA BERSAMA',
                        ];

                        foreach ($tableFieldUtilityA as $count => $name) {
                            $utilityA = new FinanceUtility();
                            $utilityA->finance_file_id = $finance->id;
                            $utilityA->type = 'BHG_A';
                            $utilityA->name = $name;
                            $utilityA->tunggakan = 0;
                            $utilityA->semasa = 0;
                            $utilityA->hadapan = 0;
                            $utilityA->tertunggak = 0;
                            $utilityA->sort_no = ++$count;
                            $utilityA->save();
                        }

                        /*
                         * create Utility B
                         */
                        $tableFieldUtilityB = [
                            'BIL METER AIR PEMILIK-PEMILIK (DI BAWAH AKAUN METER PUKAL SAHAJA)',
                            'BIL CUKAI TANAH',
                        ];

                        foreach ($tableFieldUtilityB as $count => $name) {
                            $utilityB = new FinanceUtility();
                            $utilityB->finance_file_id = $finance->id;
                            $utilityB->type = 'BHG_B';
                            $utilityB->name = $name;
                            $utilityB->tunggakan = 0;
                            $utilityB->semasa = 0;
                            $utilityB->hadapan = 0;
                            $utilityB->tertunggak = 0;
                            $utilityB->sort_no = ++$count;
                            $utilityB->save();
                        }

                        /*
                         * create Contract
                         */
                        $tableFieldContract = [
                            'FI FIRMA KOMPETEN LIF',
                            'PEMBERSIHAN (KONTRAK)',
                            'KESELAMATAN',
                            'INSURANS',
                            'JURUTERA ELEKTRIK',
                            'CUCI TANGKI AIR',
                            'UJI PENGGERA KEBAKARAN',
                            'CUCI KOLAM RENANG',
                            'SEDUT PEMBETUNG',
                            'POTONG RUMPUT/LANSKAP',
                            'SISTEM KAD AKSES',
                            'SISTEM CCTV',
                            'UJI PERALATAN/ALAT PEMADAM KEBAKARAN',
                            'KUTIPAN SAMPAH PUKAL',
                            'KAWALAN SERANGGA',
                        ];

                        foreach ($tableFieldContract as $count => $name) {
                            $contract = new FinanceContract();
                            $contract->finance_file_id = $finance->id;
                            $contract->name = $name;
                            $contract->tunggakan = 0;
                            $contract->semasa = 0;
                            $contract->hadapan = 0;
                            $contract->tertunggak = 0;
                            $contract->sort_no = ++$count;
                            $contract->save();
                        }

                        /*
                         * create Repair MF
                         */
                        $tableFieldRepairMF = [
                            'LIF',
                            'TANGKI AIR',
                            'BUMBUNG',
                            'GUTTER',
                            'RAIN WATER DOWN PIPE',
                            'PEMBENTUNG',
                            'PERPAIPAN',
                            'WAYAR BUMI',
                            'PENDAWAIAN ELEKTRIK',
                            'TANGGA/HANDRAIL',
                            'JALAN',
                            'PAGAR',
                            'LONGKANG',
                            'SUBSTATION TNB',
                            'ALAT PEMADAM KEBAKARAN',
                            'SISTEM KAD AKSES',
                            'CCTV',
                            'PELEKAT KENDERAAN',
                            'GENSET',
                        ];

                        foreach ($tableFieldRepairMF as $count => $name) {
                            $repairMF = new FinanceRepair();
                            $repairMF->finance_file_id = $finance->id;
                            $repairMF->type = 'MF';
                            $repairMF->name = $name;
                            $repairMF->tunggakan = 0;
                            $repairMF->semasa = 0;
                            $repairMF->hadapan = 0;
                            $repairMF->tertunggak = 0;
                            $repairMF->sort_no = ++$count;
                            $repairMF->save();
                        }

                        /*
                         * create Repair SF
                         */
                        $tableFieldRepairSF = [
                            'LIF',
                            'TANGKI AIR',
                            'BUMBUNG',
                            'GUTTER',
                            'RAIN WATER DOWN PIPE',
                            'PEMBENTUNG',
                            'PERPAIPAN',
                            'WAYAR BUMI',
                            'PENDAWAIAN ELEKTRIK',
                            'TANGGA/HANDRAIL',
                            'JALAN',
                            'PAGAR',
                            'LONGKANG',
                            'SUBSTATION TNB',
                            'ALAT PEMADAM KEBAKARAN',
                            'SISTEM KAD AKSES',
                            'CCTV',
                            'GENSET',
                        ];

                        foreach ($tableFieldRepairSF as $count => $name) {
                            $repairSF = new FinanceRepair();
                            $repairSF->finance_file_id = $finance->id;
                            $repairSF->type = 'SF';
                            $repairSF->name = $name;
                            $repairSF->tunggakan = 0;
                            $repairSF->semasa = 0;
                            $repairSF->hadapan = 0;
                            $repairSF->tertunggak = 0;
                            $repairSF->sort_no = ++$count;
                            $repairSF->save();
                        }

                        /*
                         * create Vandalisme MF
                         */
                        $tableFieldVandalismeMF = [
                            'LIF',
                            'WAYAR BUMI',
                            'PENDAWAIAN ELEKTRIK',
                            'PAGAR',
                            'SUBSTATION TNB',
                            'PERALATAN/ALAT PEMADAM KEBAKARAN',
                            'SISTEM KAD AKSES',
                            'CCTV',
                            'GENSET',
                        ];

                        foreach ($tableFieldVandalismeMF as $count => $name) {
                            $vandalismeMF = new FinanceVandal();
                            $vandalismeMF->finance_file_id = $finance->id;
                            $vandalismeMF->type = 'MF';
                            $vandalismeMF->name = $name;
                            $vandalismeMF->tunggakan = 0;
                            $vandalismeMF->semasa = 0;
                            $vandalismeMF->hadapan = 0;
                            $vandalismeMF->tertunggak = 0;
                            $vandalismeMF->sort_no = ++$count;
                            $vandalismeMF->save();
                        }

                        /*
                         * create Vandalisme SF
                         */
                        $tableFieldVandalismeSF = [
                            'LIF',
                            'WAYAR BUMI',
                            'PENDAWAIAN ELEKTRIK',
                            'PAGAR',
                            'SUBSTATION TNB',
                            'PERALATAN/ALAT PEMADAM KEBAKARAN',
                            'SISTEM KAD AKSES',
                            'CCTV',
                            'GENSET',
                        ];

                        foreach ($tableFieldVandalismeSF as $count => $name) {
                            $vandalismeSF = new FinanceVandal();
                            $vandalismeSF->finance_file_id = $finance->id;
                            $vandalismeSF->type = 'SF';
                            $vandalismeSF->name = $name;
                            $vandalismeSF->tunggakan = 0;
                            $vandalismeSF->semasa = 0;
                            $vandalismeSF->hadapan = 0;
                            $vandalismeSF->tertunggak = 0;
                            $vandalismeSF->sort_no = ++$count;
                            $vandalismeSF->save();
                        }

                        /*
                         * create Staff
                         */
                        $tableFieldStaff = [
                            'PENGAWAL KESELAMATAN',
                            'PEMBERSIHAN',
                            'RENCAM',
                            'KERANI',
                            'JURUTEKNIK',
                            'PENYELIA',
                        ];

                        foreach ($tableFieldStaff as $count => $name) {
                            $staff = new FinanceStaff();
                            $staff->finance_file_id = $finance->id;
                            $staff->name = $name;
                            $staff->gaji_per_orang = 0;
                            $staff->bil_pekerja = 0;
                            $staff->tunggakan = 0;
                            $staff->semasa = 0;
                            $staff->hadapan = 0;
                            $staff->tertunggak = 0;
                            $staff->sort_no = ++$count;
                            $staff->save();
                        }

                        /*
                         * create Admin
                         */
                        $tableFieldAdmin = [
                            'TELEFON & INTERNET',
                            'PERALATAN',
                            'ALAT TULIS PEJABAT',
                            'PETTY CASH',
                            'SEWAAN MESIN FOTOKOPI',
                            'PERKHIDMATAN SISTEM UBS @ LAIN-LAIN SISTEM',
                            'PERKHIDMATAN AKAUN',
                            'PERKHIDMATAN AUDIT',
                            'CAJ PERUNDANGAN',
                            'CAJ PENGHANTARAN & KUTIPAN',
                            'CAJ BANK',
                            'FI EJEN PENGURUSAN',
                            'PERBELANJAAN MESYUARAT',
                            'ELAUN JMB/MC',
                            'LAIN-LAIN TUNTUTAN JMB/MC',
                        ];

                        foreach ($tableFieldAdmin as $count => $name) {
                            $admin = new FinanceAdmin();
                            $admin->finance_file_id = $finance->id;
                            $admin->name = $name;
                            $admin->tunggakan = 0;
                            $admin->semasa = 0;
                            $admin->hadapan = 0;
                            $admin->tertunggak = 0;
                            $admin->sort_no = ++$count;
                            $admin->save();
                        }
                    }

                    # Audit Trail
                    $remarks = 'Finance File with id : ' . $finance->id . ' has been created.';
                    $auditTrail = new AuditTrail();
                    $auditTrail->module = "COB Finance";
                    $auditTrail->remarks = $remarks;
                    $auditTrail->audit_by = Auth::user()->id;
                    $auditTrail->save();

                    print "true";
                } else {
                    print "false";
                }
            } else {
                print "file_already_exists";
            }
        }
    }

    // finance list
    public function financeList() {
        //get user permission
        $user_permission = AccessGroup::getAccessPermission(Auth::user()->id);
        $file = Files::where('is_deleted', 0)->get();

        if (Session::get('lang') == "en") {
            $viewData = array(
                'title' => 'Finance List',
                'panel_nav_active' => 'cob_panel',
                'main_nav_active' => 'cob_main',
                'sub_nav_active' => 'finance_file_list',
                'user_permission' => $user_permission,
                'file' => $file,
                'image' => ""
            );

            return View::make('finance_en.finance_list', $viewData);
        } else {
            $viewData = array(
                'title' => 'Finance List',
                'panel_nav_active' => 'cob_panel',
                'main_nav_active' => 'cob_main',
                'sub_nav_active' => 'finance_file_list',
                'user_permission' => $user_permission,
                'file' => $file,
                'image' => ""
            );

            return View::make('finance_my.finance_list', $viewData);
        }
    }

    public function getFinanceList() {
        $filelist = Finance::where('is_deleted', 0)->orderBy('id', 'desc')->get();

        if (count($filelist) > 0) {
            $data = Array();
            foreach ($filelist as $filelists) {
                $button = "";
                if (Session::get('lang') == "en") {
                    if ($filelists->is_active == 1) {
                        $status = "Active";
                        $button .= '<button type="button" class="btn btn-xs btn-default" onclick="inactiveFinanceList(\'' . $filelists->id . '\')">Inactive</button>&nbsp;';
                    } else {
                        $status = "Inactive";
                        $button .= '<button type="button" class="btn btn-xs btn-primary" onclick="activeFinanceList(\'' . $filelists->id . '\')">Active</button>&nbsp;';
                    }
                    $button .= '<button type="button" class="btn btn-xs btn-danger" onclick="deleteFinanceList(\'' . $filelists->id . '\')">Delete <i class="fa fa-trash"></i></button>&nbsp;';
                } else {
                    if ($filelists->is_active == 1) {
                        $status = "Active";
                        $button .= '<button type="button" class="btn btn-xs btn-default" onclick="inactiveFinanceList(\'' . $filelists->id . '\')">Inactive</button>&nbsp;';
                    } else {
                        $status = "Inactive";
                        $button .= '<button type="button" class="btn btn-xs btn-primary" onclick="activeFinanceList(\'' . $filelists->id . '\')">Active</button>&nbsp;';
                    }
                    $button .= '<button type="button" class="btn btn-xs btn-danger" onclick="deleteFinanceList(\'' . $filelists->id . '\')">Delete <i class="fa fa-trash"></i></button>&nbsp;';
                }

                $data_raw = array(
                    "<a style='text-decoration:underline;' href='" . URL::action('FinanceController@editFinanceFileList', [$filelists->id, 'home']) . "'>" . $filelists->file->file_no . " " . $filelists->year . "-" . strtoupper($filelists->monthName()) . "</a>",
                    $filelists->file->strata->strataName(),
                    $status,
                    $button
                );

                array_push($data, $data_raw);
            }
            $output_raw = array(
                "aaData" => $data
            );

            $output = json_encode($output_raw);
            return $output;
        } else {
            $output_raw = array(
                "aaData" => []
            );

            $output = json_encode($output_raw);
            return $output;
        }
    }

    public function deleteFinanceList() {
        $data = Input::all();
        if (Request::ajax()) {

            $id = $data['id'];

            $finance = Finance::find($id);
            if ($finance) {
                $finance->is_active = 0;
                $finance->is_deleted = 1;
                $deleted = $finance->save();

                if ($deleted) {
                    # Audit Trail
                    $remarks = 'Finance File with id : ' . $finance->id . ' has been deleted.';
                    $auditTrail = new AuditTrail();
                    $auditTrail->module = "COB Finance";
                    $auditTrail->remarks = $remarks;
                    $auditTrail->audit_by = Auth::user()->id;
                    $auditTrail->save();

                    return "true";
                } else {
                    return "false";
                }
            } else {
                return "false";
            }
        } else {
            return 'false';
        }
    }

    public function editFinanceFileList($id, $tab) {
        //get user permission
        $user_permission = AccessGroup::getAccessPermission(Auth::user()->id);

        $file_no = Files::where('is_active', 1)->where('is_deleted', 0)->get();
        $financeCheckData = FinanceCheck::where('finance_file_id', $id)->first();
        $financefiledata = Finance::where('id', $id)->first();
        $financeFileAdmin = FinanceAdmin::where('finance_file_id', $id)->orderBy('sort_no', 'asc')->get();
        $financeFileContract = FinanceContract::where('finance_file_id', $id)->orderBy('sort_no', 'asc')->get();
        $financeFileStaff = FinanceStaff::where('finance_file_id', $id)->orderBy('sort_no', 'asc')->get();
        $financeFileVandalA = FinanceVandal::where('finance_file_id', $id)->where('type', 'MF')->orderBy('sort_no', 'asc')->get();
        $financeFileVandalB = FinanceVandal::where('finance_file_id', $id)->where('type', 'SF')->orderBy('sort_no', 'asc')->get();
        $financeFileRepairA = FinanceRepair::where('finance_file_id', $id)->where('type', 'MF')->orderBy('sort_no', 'asc')->get();
        $financeFileRepairB = FinanceRepair::where('finance_file_id', $id)->where('type', 'SF')->orderBy('sort_no', 'asc')->get();
        $financeFileUtilityA = FinanceUtility::where('finance_file_id', $id)->where('type', 'BHG_A')->orderBy('sort_no', 'asc')->get();
        $financeFileUtilityB = FinanceUtility::where('finance_file_id', $id)->where('type', 'BHG_B')->orderBy('sort_no', 'asc')->get();
        $financeFileIncome = FinanceIncome::where('finance_file_id', $id)->orderBy('sort_no', 'asc')->get();

        $mfreport = FinanceReport::where('finance_file_id', $id)->where('type', 'MF')->first();
        $reportMF = FinanceReportPerbelanjaan::where('finance_file_id', $id)->where('type', 'MF')->orderBy('sort_no', 'asc')->get();

        $sfreport = FinanceReport::where('finance_file_id', $id)->where('type', 'SF')->first();
        $reportSF = FinanceReportPerbelanjaan::where('finance_file_id', $id)->where('type', 'SF')->orderBy('sort_no', 'asc')->get();

        if (Session::get('lang') == "en") {
            $viewData = array(
                'title' => 'Edit Finance File List',
                'panel_nav_active' => 'cob_panel',
                'main_nav_active' => 'cob_main',
                'sub_nav_active' => 'finance_file_list',
                'user_permission' => $user_permission,
                'image' => "",
                'file_no' => $file_no,
                'financefiledata' => $financefiledata,
                'checkdata' => $financeCheckData,
                'finance_file_id' => $id,
                'adminFile' => $financeFileAdmin,
                'contractFile' => $financeFileContract,
                'staffFile' => $financeFileStaff,
                'vandala' => $financeFileVandalA,
                'vandalb' => $financeFileVandalB,
                'repaira' => $financeFileRepairA,
                'repairb' => $financeFileRepairB,
                'incomeFile' => $financeFileIncome,
                'utila' => $financeFileUtilityA,
                'utilb' => $financeFileUtilityB,
                'mfreport' => $mfreport,
                'reportMF' => $reportMF,
                'sfreport' => $sfreport,
                'reportSF' => $reportSF,
                'tab' => $tab
            );

            return View::make('finance_en.edit_finance_file', $viewData);
        } else {
            $viewData = array(
                'title' => 'Edit Finance File List',
                'panel_nav_active' => 'cob_panel',
                'main_nav_active' => 'cob_main',
                'sub_nav_active' => 'finance_file_list',
                'user_permission' => $user_permission,
                'image' => "",
                'file_no' => $file_no,
                'financefiledata' => $financefiledata,
                'checkdata' => $financeCheckData,
                'finance_file_id' => $id,
                'adminFile' => $financeFileAdmin,
                'contractFile' => $financeFileContract,
                'staffFile' => $financeFileStaff,
                'vandala' => $financeFileVandalA,
                'vandalb' => $financeFileVandalB,
                'repaira' => $financeFileRepairA,
                'repairb' => $financeFileRepairB,
                'incomeFile' => $financeFileIncome,
                'utila' => $financeFileUtilityA,
                'utilb' => $financeFileUtilityB,
                'mfreport' => $mfreport,
                'reportMF' => $reportMF,
                'sfreport' => $sfreport,
                'reportSF' => $reportSF,
                'tab' => $tab
            );

            return View::make('finance_my.edit_finance_file', $viewData);
        }
    }

    public function updateFinanceCheck() {
        $data = Input::all();
        if (Request::ajax()) {
            $id = $data['finance_file_id'];

            $financeCheck = FinanceCheck::where('finance_file_id', $id)->first();
            if ($financeCheck) {
                $financeCheck->finance_file_id = $id;
                $financeCheck->date = $data['date'];
                $financeCheck->name = $data['name'];
                $financeCheck->position = $data['position'];
                $financeCheck->is_active = $data['is_active'];
                $financeCheck->remarks = $data['remarks'];
                $success = $financeCheck->save();

                if ($success) {
                    # Audit Trail
                    $remarks = 'Finance File  with id : ' . $id . ' has been updated.';
                    $auditTrail = new AuditTrail();
                    $auditTrail->module = "COB Finance File  - Check";
                    $auditTrail->remarks = $remarks;
                    $auditTrail->audit_by = Auth::user()->id;
                    $auditTrail->save();

                    return "true";
                }
            }
        }

        return "false";
    }

    public function updateFinanceFileAdmin() {
        $data = Input::all();
        $id = $data['finance_file_id'];
        $prefix = 'admin_';

        $removeOld = FinanceAdmin::where('finance_file_id', $id)->delete();

        if ($removeOld) {
            for ($i = 0; $i < count($data[$prefix . 'name']); $i++) {
                if (!empty($data[$prefix . 'name'][$i])) {
                    $finance = new FinanceAdmin;
                    $finance->finance_file_id = $id;
                    $finance->name = $data[$prefix . 'name'][$i];
                    $finance->tunggakan = $data[$prefix . 'tunggakan'][$i];
                    $finance->semasa = $data[$prefix . 'semasa'][$i];
                    $finance->hadapan = $data[$prefix . 'hadapan'][$i];
                    $finance->tertunggak = $data[$prefix . 'tertunggak'][$i];
                    $finance->sort_no = $i;
                    $finance->is_custom = $data[$prefix . 'is_custom'][$i];
                    $finance->save();
                }
            }

            if ($finance) {
                # Audit Trail
                $remarks = 'Finance File with id : ' . $id . ' has been updated.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "COB Finance";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                return 'true';
            }
        }

        return 'false';
    }

    public function updateFinanceFileIncome() {
        $data = Input::all();
        $id = $data['finance_file_id'];
        $prefix = 'income_';

        $removeOld = FinanceIncome::where('finance_file_id', $id)->delete();

        if ($removeOld) {
            for ($i = 0; $i < count($data[$prefix . 'name']); $i++) {
                if (!empty($data[$prefix . 'name'][$i])) {
                    $finance = new FinanceIncome;
                    $finance->finance_file_id = $id;
                    $finance->name = $data[$prefix . 'name'][$i];
                    $finance->tunggakan = $data[$prefix . 'tunggakan'][$i];
                    $finance->semasa = $data[$prefix . 'semasa'][$i];
                    $finance->hadapan = $data[$prefix . 'hadapan'][$i];
                    $finance->sort_no = $i;
                    $finance->is_custom = $data[$prefix . 'is_custom'][$i];
                    $finance->save();
                }
            }

            if ($finance) {
                # Audit Trail
                $remarks = 'Finance File with id : ' . $id . ' has been updated.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "COB Finance";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                return 'true';
            }
        }

        return 'false';
    }

    public function updateFinanceFileUtility() {
        $data = Input::all();
        $id = $data['finance_file_id'];
        $prefixs = [
            'util_',
            'utilb_',
        ];

        $removeOld = FinanceUtility::where('finance_file_id', $id)->delete();

        if ($removeOld) {
            foreach ($prefixs as $prefix) {
                for ($i = 0; $i < count($data[$prefix . 'name']); $i++) {
                    if (!empty($data[$prefix . 'name'][$i])) {
                        $finance = new FinanceUtility;
                        $finance->finance_file_id = $id;
                        $finance->name = $data[$prefix . 'name'][$i];
                        if ($prefix == 'util_') {
                            $finance->type = 'BHG_A';
                        } else {
                            $finance->type = 'BHG_B';
                        }
                        $finance->tunggakan = $data[$prefix . 'tunggakan'][$i];
                        $finance->semasa = $data[$prefix . 'semasa'][$i];
                        $finance->hadapan = $data[$prefix . 'hadapan'][$i];
                        $finance->tertunggak = $data[$prefix . 'tertunggak'][$i];
                        $finance->sort_no = $i;
                        $finance->is_custom = $data[$prefix . 'is_custom'][$i];
                        $finance->save();
                    }
                }
            }

            if ($finance) {
                # Audit Trail
                $remarks = 'Finance File with id : ' . $id . ' has been updated.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "COB Finance";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                return 'true';
            }
        }

        return 'false';
    }

    public function updateFinanceFileReportMf() {
        $data = Input::all();
        $id = $data['finance_file_id'];
        $type = 'MF';
        $prefix = 'mfr_';

        $removeOld = FinanceReportPerbelanjaan::where('finance_file_id', $id)->where('type', $type)->delete();

        $finance = FinanceReport::where('finance_file_id', $id)->where('type', $type)->first();
        if ($removeOld) {
            $finance->fee_sebulan = $data[$prefix . 'fee_sebulan'];
            $finance->unit = $data[$prefix . 'unit'];
            $finance->fee_semasa = $data[$prefix . 'fee_semasa'];
            $finance->no_akaun = $data[$prefix . 'no_akaun'];
            $finance->nama_bank = $data[$prefix . 'nama_bank'];
            $finance->baki_bank_awal = $data[$prefix . 'baki_bank_awal'];
            $finance->baki_bank_akhir = $data[$prefix . 'baki_bank_akhir'];
            $finance->save();

            for ($i = 0; $i < count($data[$prefix . 'name']); $i++) {
                if (!empty($data[$prefix . 'name'][$i])) {
                    $frp = new FinanceReportPerbelanjaan;
                    $frp->type = $type;
                    $frp->finance_file_id = $id;
                    $frp->name = $data[$prefix . 'name'][$i];
                    $frp->report_key = $data[$prefix . 'report_key'][$i];
                    $frp->amount = $data[$prefix . 'amount'][$i];
                    $frp->sort_no = $i;
                    $frp->is_custom = 0;
                    $frp->save();
                }
            }

            if ($finance) {
                # Audit Trail
                $remarks = 'Finance File with id : ' . $id . ' has been updated.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "COB Finance";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                return 'true';
            }
        }

        return 'false';
    }

    public function updateFinanceFileReportSf() {
        $data = Input::all();
        $id = $data['finance_file_id'];
        $type = 'SF';
        $prefix = 'sfr_';

        $removeOld = FinanceReportPerbelanjaan::where('finance_file_id', $id)->where('type', $type)->delete();

        if ($removeOld) {
            $finance = FinanceReport::where('finance_file_id', $id)->where('type', $type)->first();
            if ($finance) {
                $finance->fee_sebulan = $data[$prefix . 'fee_sebulan'];
                $finance->unit = $data[$prefix . 'unit'];
                $finance->fee_semasa = $data[$prefix . 'fee_semasa'];
                $finance->no_akaun = $data[$prefix . 'no_akaun'];
                $finance->nama_bank = $data[$prefix . 'nama_bank'];
                $finance->baki_bank_awal = $data[$prefix . 'baki_bank_awal'];
                $finance->baki_bank_akhir = $data[$prefix . 'baki_bank_akhir'];
                $finance->save();

                for ($i = 0; $i < count($data[$prefix . 'name']); $i++) {
                    if (!empty($data[$prefix . 'name'][$i])) {
                        $frp = new FinanceReportPerbelanjaan;
                        $frp->type = $type;
                        $frp->finance_file_id = $id;
                        $frp->name = $data[$prefix . 'name'][$i];
                        $frp->report_key = $data[$prefix . 'report_key'][$i];
                        $frp->amount = $data[$prefix . 'amount'][$i];
                        $frp->sort_no = $i;
                        $frp->is_custom = $data[$prefix . 'is_custom'][$i];
                        $frp->save();
                    }
                }

                if ($finance) {
                    # Audit Trail
                    $remarks = 'Finance File with id : ' . $id . ' has been updated.';
                    $auditTrail = new AuditTrail();
                    $auditTrail->module = "COB Finance";
                    $auditTrail->remarks = $remarks;
                    $auditTrail->audit_by = Auth::user()->id;
                    $auditTrail->save();

                    return 'true';
                }
            }
        }

        return 'false';
    }

    public function updateFinanceFileVandal() {
        $data = Input::all();
        $id = $data['finance_file_id'];
        $prefixs = [
            'maintenancefee_',
            'singkingfund_'
        ];

        $removeOld = FinanceVandal::where('finance_file_id', $id)->delete();

        if ($removeOld) {
            foreach ($prefixs as $prefix) {
                for ($i = 0; $i < count($data[$prefix . 'name']); $i++) {
                    if (!empty($data[$prefix . 'name'][$i])) {
                        $finance = new FinanceVandal;
                        $finance->finance_file_id = $id;
                        $finance->name = $data[$prefix . 'name'][$i];
                        if ($prefix == 'maintenancefee_') {
                            $finance->type = 'MF';
                        } else {
                            $finance->type = 'SF';
                        }
                        $finance->tunggakan = $data[$prefix . 'tunggakan'][$i];
                        $finance->semasa = $data[$prefix . 'semasa'][$i];
                        $finance->hadapan = $data[$prefix . 'hadapan'][$i];
                        $finance->tertunggak = $data[$prefix . 'tertunggak'][$i];
                        $finance->sort_no = $i;
                        $finance->is_custom = $data[$prefix . 'is_custom'][$i];
                        $finance->save();
                    }
                }
            }

            if ($finance) {
                # Audit Trail
                $remarks = 'Finance File with id : ' . $id . ' has been updated.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "COB Finance";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                return 'true';
            }
        }

        return 'false';
    }

    public function updateFinanceFileRepair() {
        $data = Input::all();
        $id = $data['finance_file_id'];
        $prefixs = [
            'repair_maintenancefee_',
            'repair_singkingfund_'
        ];

        $removeOld = FinanceRepair::where('finance_file_id', $id)->delete();

        if ($removeOld) {
            foreach ($prefixs as $prefix) {
                for ($i = 0; $i < count($data[$prefix . 'name']); $i++) {
                    if (!empty($data[$prefix . 'name'][$i])) {
                        $finance = new FinanceRepair;
                        $finance->finance_file_id = $id;
                        $finance->name = $data[$prefix . 'name'][$i];
                        if ($prefix == 'repair_maintenancefee_') {
                            $finance->type = 'MF';
                        } else {
                            $finance->type = 'SF';
                        }
                        $finance->tunggakan = $data[$prefix . 'tunggakan'][$i];
                        $finance->semasa = $data[$prefix . 'semasa'][$i];
                        $finance->hadapan = $data[$prefix . 'hadapan'][$i];
                        $finance->tertunggak = $data[$prefix . 'tertunggak'][$i];
                        $finance->sort_no = $i;
                        $finance->is_custom = $data[$prefix . 'is_custom'][$i];
                        $finance->save();
                    }
                }
            }

            if ($finance) {
                # Audit Trail
                $remarks = 'Finance File with id : ' . $id . ' has been updated.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "COB Finance";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                return 'true';
            }
        }

        return 'false';
    }

    public function updateFinanceFileContract() {
        $data = Input::all();
        $id = $data['finance_file_id'];
        $prefix = 'contract_';

        $removeOld = FinanceContract::where('finance_file_id', $id)->delete();

        if ($removeOld) {
            for ($i = 0; $i < count($data[$prefix . 'name']); $i++) {
                if (!empty($data[$prefix . 'name'][$i])) {
                    $finance = new FinanceContract;
                    $finance->finance_file_id = $id;
                    $finance->name = $data[$prefix . 'name'][$i];
                    $finance->tunggakan = $data[$prefix . 'tunggakan'][$i];
                    $finance->semasa = $data[$prefix . 'semasa'][$i];
                    $finance->hadapan = $data[$prefix . 'hadapan'][$i];
                    $finance->tertunggak = $data[$prefix . 'tertunggak'][$i];
                    $finance->sort_no = $i;
                    $finance->is_custom = $data[$prefix . 'is_custom'][$i];
                    $finance->save();
                }
            }

            if ($finance) {
                # Audit Trail
                $remarks = 'Finance File with id : ' . $id . ' has been updated.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "COB Finance";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                return 'true';
            }
        }

        return 'false';
    }

    public function updateFinanceFileStaff() {
        $data = Input::all();
        $id = $data['finance_file_id'];
        $prefix = 'staff_';

        $removeOld = FinanceStaff::where('finance_file_id', $id)->delete();

        if ($removeOld) {
            for ($i = 0; $i < count($data[$prefix . 'name']); $i++) {
                if (!empty($data[$prefix . 'name'][$i])) {
                    $finance = new FinanceStaff;
                    $finance->finance_file_id = $id;
                    $finance->name = $data[$prefix . 'name'][$i];
                    $finance->gaji_per_orang = $data[$prefix . 'gaji_per_orang'][$i];
                    $finance->bil_pekerja = $data[$prefix . 'bil_pekerja'][$i];
                    $finance->tunggakan = $data[$prefix . 'tunggakan'][$i];
                    $finance->semasa = $data[$prefix . 'semasa'][$i];
                    $finance->hadapan = $data[$prefix . 'hadapan'][$i];
                    $finance->tertunggak = $data[$prefix . 'tertunggak'][$i];
                    $finance->sort_no = $i;
                    $finance->is_custom = $data[$prefix . 'is_custom'][$i];
                    $finance->save();
                }
            }

            if ($finance) {
                # Audit Trail
                $remarks = 'Finance File with id : ' . $id . ' has been updated.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "COB Finance";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                return 'true';
            }
        }

        return 'false';
    }

    public function financeSupport() {
        //get user permission
        $user_permission = AccessGroup::getAccessPermission(Auth::user()->id);
        $file = Files::where('is_deleted', 0)->get();

        if (Session::get('lang') == "en") {
            $viewData = array(
                'title' => 'Finance Support',
                'panel_nav_active' => 'cob_panel',
                'main_nav_active' => 'cob_main',
                'sub_nav_active' => 'finance_support_list',
                'user_permission' => $user_permission,
                'file' => $file,
                'image' => ""
            );

            return View::make('finance_en.finance_support_list', $viewData);
        } else {
            $viewData = array(
                'title' => 'Finance Support',
                'panel_nav_active' => 'cob_panel',
                'main_nav_active' => 'cob_main',
                'sub_nav_active' => 'finance_support_list',
                'user_permission' => $user_permission,
                'file' => $file,
                'image' => ""
            );

            return View::make('finance_my.finance_support_list', $viewData);
        }
    }

    public function getFinanceSupportList() {
        $filelist = FinanceSupport::where('is_deleted', 0)->orderBy('id', 'desc')->get();

        if (count($filelist) > 0) {
            $data = Array();
            foreach ($filelist as $filelists) {
                $files = Files::where('id', $filelists->file_id)->first();
                $button = "";
                if (Session::get('lang') == "en") {
//                    if ($filelists->is_active == 1) {
//                        $status = "Active";
//                        $button .= '<button type="button" class="btn btn-xs btn-primary" onclick="inactiveFinanceList(\'' . $filelists->id . '\')">Inactive</button>&nbsp;';
//                    } else {
//                        $status = "Inactive";
//                        $button .= '<button type="button" class="btn btn-xs btn-primary" onclick="activeFinanceList(\'' . $filelists->id . '\')">Active</button>&nbsp;';
//                    }
                    $button .= '<button type="button" class="btn btn-xs btn-danger" onclick="deleteFinanceSupport(\'' . $filelists->id . '\')">Delete <i class="fa fa-trash"></i></button>&nbsp;';
                } else {
//                    if ($filelists->is_active == 1) {
//                        $status = "Aktif";
//                        $button .= '<button type="button" class="btn btn-xs btn-primary" onclick="inactiveFinanceList(\'' . $filelists->id . '\')">Tidak Aktif</button>&nbsp;';
//                        $button .= '<button type="button" class="btn btn-xs btn-success" onclick="window.location=\'' . URL::action('FinanceController@house', $filelists->id) . '\'">Edit <i class="fa fa-pencil"></i></button>&nbsp;';
//                    } else {
//                        $status = "Tidak Aktif";
//                        $button .= '<button type="button" class="btn btn-xs btn-primary" onclick="activeFinanceList(\'' . $filelists->id . '\')">Aktif</button>&nbsp;';
//                    }
                    $button .= '<button type="button" class="btn btn-xs btn-danger" onclick="deleteFinanceSupport(\'' . $filelists->id . '\')">Padam <i class="fa fa-trash"></i></button>&nbsp;';
                }

                $data_raw = array(
                    "<a style='text-decoration:underline;' href='" . URL::action('FinanceController@editFinanceSupport', $filelists->id) . "'>" . $files->file_no . "</a>",
                    date('d/m/Y', strtotime($filelists->date)),
                    $filelists->name,
                    number_format($filelists->amount, 2),
                    $button
                );

                array_push($data, $data_raw);
            }
            $output_raw = array(
                "aaData" => $data
            );

            $output = json_encode($output_raw);
            return $output;
        } else {
            $output_raw = array(
                "aaData" => []
            );

            $output = json_encode($output_raw);
            return $output;
        }
    }

    public function addFinanceSupport() {
        //get user permission
        $user_permission = AccessGroup::getAccessPermission(Auth::user()->id);
        $file_no = Files::where('is_active', 1)->where('is_deleted', 0)->get();

        if (Session::get('lang') == "en") {
            $viewData = array(
                'title' => 'Add Finance Support',
                'panel_nav_active' => 'cob_panel',
                'main_nav_active' => 'cob_main',
                'sub_nav_active' => 'finance_support_list',
                'user_permission' => $user_permission,
                'image' => "",
                'file_no' => $file_no
            );

            return View::make('finance_en.add_finance_support', $viewData);
        } else {
            $viewData = array(
                'title' => 'Add Finance Support',
                'panel_nav_active' => 'cob_panel',
                'main_nav_active' => 'cob_main',
                'sub_nav_active' => 'finance_support_list',
                'user_permission' => $user_permission,
                'image' => "",
                'file_no' => $file_no
            );

            return View::make('finance_my.add_finance_support', $viewData);
        }
    }

    public function submitFinanceSupport() {
        $data = Input::all();
        if (Request::ajax()) {
            $file_id = $data['file_id'];
            $is_active = $data['is_active'];

            $finance = new FinanceSupport();
            $finance->file_id = $file_id;
            $finance->date = $data['date'];
            $finance->name = $data['name'];
            $finance->amount = $data['amount'];
            $finance->remark = $data['remark'];
            $finance->is_active = $is_active;
            $success = $finance->save();


            if ($success) {
                # Audit Trail
                $remarks = 'Finance Support with id : ' . $finance->id . ' has been inserted.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "COB Finance Support";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();
                print "true";
            } else {
                print "false";
            }
        }
    }

    public function editFinanceSupport($id) {
        //get user permission
        $user_permission = AccessGroup::getAccessPermission(Auth::user()->id);
        $file_no = Files::where('is_active', 1)->where('is_deleted', 0)->get();
        $financeSupportData = FinanceSupport::where('id', $id)->first();

        if (Session::get('lang') == "en") {
            $viewData = array(
                'title' => 'Edit Finance Support',
                'panel_nav_active' => 'cob_panel',
                'main_nav_active' => 'cob_main',
                'sub_nav_active' => 'finance_support_list',
                'user_permission' => $user_permission,
                'image' => "",
                'file_no' => $file_no,
                'financesupportdata' => $financeSupportData
            );

            return View::make('finance_en.edit_finance_support', $viewData);
        } else {
            $viewData = array(
                'title' => 'Edit Finance Support',
                'panel_nav_active' => 'cob_panel',
                'main_nav_active' => 'cob_main',
                'sub_nav_active' => 'finance_support_list',
                'user_permission' => $user_permission,
                'image' => "",
                'file_no' => $file_no,
                'financesupportdata' => $financeSupportData
            );

            return View::make('finance_my.edit_finance_support', $viewData);
        }
    }

    public function updateFinanceSupport() {
        $data = Input::all();
        if (Request::ajax()) {
            $file_id = $data['file_id'];
            $id = $data['id'];

            $finance = FinanceSupport::find($id);
            if ($finance) {
                $finance->file_id = $file_id;
                $finance->date = $data['date'];
                $finance->name = $data['name'];
                $finance->amount = $data['amount'];
                $finance->remark = $data['remark'];
                $finance->is_active = 1;
                $success = $finance->save();

                if ($success) {
                    # Audit Trail
                    $remarks = 'Finance Support with id : ' . $finance->id . ' has been updated.';
                    $auditTrail = new AuditTrail();
                    $auditTrail->module = "COB Finance Support";
                    $auditTrail->remarks = $remarks;
                    $auditTrail->audit_by = Auth::user()->id;
                    $auditTrail->save();
                    print "true";
                } else {
                    print "false";
                }
            } else {
                print "false";
            }
        }
    }

    public function activeFinanceList() {
        $data = Input::all();
        if (Request::ajax()) {

            $id = $data['id'];

            $files = Finance::find($id);
            $files->is_active = 1;
            $updated = $files->save();
            if ($updated) {
                # Audit Trail
                $remarks = $files->file_no . ' has been updated.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "COB Finance File Active";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    public function inactiveFinanceList() {
        $data = Input::all();
        if (Request::ajax()) {

            $id = $data['id'];

            $prefix = Finance::find($id);
            $prefix->is_active = 0;
            $updated = $prefix->save();
            if ($updated) {
                # Audit Trail
                $remarks = 'COB Finance File has been updated.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "COB Finance File Inactive";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    public function deleteFinanceSupport() {
        $data = Input::all();
        if (Request::ajax()) {

            $id = $data['id'];

            $finance = FinanceSupport::find($id);
            $finance->is_deleted = 1;
            $deleted = $finance->save();
            if ($deleted) {
                # Audit Trail
                $remarks = 'Finance Support with id : ' . $finance->id . ' has been deleted.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "COB Finance Support";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    public function updateFinanceFileList() {
        $data = Input::all();
        if (Request::ajax()) {
            $file_id = $data['file_id'];
            $is_active = $data['is_active'];

            $financeSupportId = $data['id'];

            $finance = FinanceSupport::find($financeSupportId);
            $finance->file_id = $file_id;
            $finance->date = $data['date'];
            $finance->name = $data['name'];
            $finance->amount = $data['amount'];
            $finance->remarks = $data['remarks'];
            $finance->is_active = $is_active;
            $success = $finance->save();

            if ($success) {
                # Audit Trail
                $remarks = 'Finance Support with id : ' . $finance->id . ' has been updated.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "COB Finance Support";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();
                print "true";
            } else {
                print "false";
            }
        }
    }

}
