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

    public function submitFinanceFile() {
        $data = Input::all();
        if (Request::ajax()) {
            $file_id = $data['file_id'];
            $year = $data['year'];
            $month = $data['month'];
            $is_active = $data['is_active'];

            $check_exist = Finance::where('file_id', $file_id)->where('year', $year)->where('month', $month)->count();
            if ($check_exist <= 0) {
                $finance = new Finance();
                $finance->file_id = $file_id;
                $finance->month = $month;
                $finance->year = $year;
                $finance->is_active = $is_active;
                $success = $finance->save();

                if ($success) {
                    /*
                     * create MF Report
                     */
                    $reportMF = new FinanceReportMf();
                    $reportMF->finance_file_id = $finance->id;
                    $createMF = $reportMF->save();

                    if ($createMF) {
                        $tableFieldMF = [
                            'UTILITI (BAHAGIAN A SAHAJA)',
                            'PENYENGGARAAN',
                            'PEMBAIKAN/PENGGANTIAN/PEMBELIAN/NAIKTARAF/PEMBAHARUAN',
                            'PEMBAIKAN/PENGGANTIAN/PEMBELIAN (VANDALISME)',
                            'PEKERJA',
                            'PENTADBIRAN'
                        ];

                        foreach ($tableFieldMF as $count => $name) {
                            $reportMF = new FinanceReportPerbelanjaan();
                            $reportMF->type = 'MF';
                            $reportMF->finance_file_id = $finance->id;
                            $reportMF->name = $name;
                            $reportMF->amount = 0;
                            $reportMF->sort_no = ++$count;
                            $reportMF->save();
                        }
                    }

                    /*
                     * create SF Report
                     */
                    $reportSF = new FinanceReportSf();
                    $reportSF->finance_file_id = $finance->id;
                    $createSF = $reportSF->save();

                    if ($createSF) {
                        $tableFieldSF = [
                            'PEMBAIKAN/PENGGANTIAN/PEMBELIAN/NAIKTARAF/PEMBAHARUAN',
                            'PEMBAIKAN/PENGGANTIAN/PEMBELIAN (VANDALISME)'
                        ];

                        foreach ($tableFieldSF as $count => $name) {
                            $reportSF = new FinanceReportPerbelanjaan();
                            $reportSF->type = 'SF';
                            $reportSF->finance_file_id = $finance->id;
                            $reportSF->name = $name;
                            $reportSF->amount = 0;
                            $reportSF->sort_no = ++$count;
                            $reportSF->save();
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
                        $vandalismeMF = new FinanceRepair();
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
                        $vandalismeSF = new FinanceRepair();
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
                        $status = "Aktif";
                        $button .= '<button type="button" class="btn btn-xs btn-default" onclick="inactiveFinanceList(\'' . $filelists->id . '\')">Tidak Aktif</button>&nbsp;';
                        $button .= '<button type="button" class="btn btn-xs btn-success" onclick="window.location=\'' . URL::action('FinanceController@house', $filelists->id) . '\'">Edit <i class="fa fa-pencil"></i></button>&nbsp;';
                    } else {
                        $status = "Tidak Aktif";
                        $button .= '<button type="button" class="btn btn-xs btn-primary" onclick="activeFinanceList(\'' . $filelists->id . '\')">Aktif</button>&nbsp;';
                    }
                    $button .= '<button type="button" class="btn btn-xs btn-danger" onclick="deleteFinanceList(\'' . $filelists->id . '\')">Padam <i class="fa fa-trash"></i></button>&nbsp;';
                }

                $data_raw = array(
                    "<a style='text-decoration:underline;' href='" . URL::action('FinanceController@editFinanceFileList', $filelists->id) . "'>" . $filelists->file->file_no . " " . $filelists->year . "-" . strtoupper($filelists->monthName()) . "</a>",
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

                    print "true";
                } else {
                    print "false";
                }
            } else {
                print "false";
            }
        }
    }

    public function editFinanceFileList($id) {
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

        $mfreport = FinanceReportMf::where('finance_file_id', $id)->first();
        $reportMF = FinanceReportPerbelanjaan::where('finance_file_id', $id)->where('type', 'MF')->orderBy('sort_no', 'asc')->get();

        $sfreport = FinanceReportSf::where('finance_file_id', $id)->first();
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
                'adminFile' => $financeFileAdmin->toArray(),
                'contractFile' => $financeFileContract->toArray(),
                'staffFile' => $financeFileStaff->toArray(),
                'vandala' => $financeFileVandalA->toArray(),
                'vandalb' => $financeFileVandalB->toArray(),
                'repaira' => $financeFileRepairA->toArray(),
                'repairb' => $financeFileRepairB->toArray(),
                'incomeFile' => $financeFileIncome->toArray(),
                'utila' => $financeFileUtilityA->toArray(),
                'utilb' => $financeFileUtilityB->toArray(),
                'mfreport' => $mfreport->toArray(),
                'reportMF' => $reportMF->toArray(),
                'sfreport' => $sfreport->toArray(),
                'reportSF' => $reportSF->toArray(),
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
                'adminFile' => $financeFileAdmin->toArray(),
                'contractFile' => $financeFileContract->toArray(),
                'staffFile' => $financeFileStaff->toArray(),
                'vandala' => $financeFileVandalA->toArray(),
                'vandalb' => $financeFileVandalB->toArray(),
                'repaira' => $financeFileRepairA->toArray(),
                'repairb' => $financeFileRepairB->toArray(),
                'incomeFile' => $financeFileIncome->toArray(),
                'utila' => $financeFileUtilityA->toArray(),
                'utilb' => $financeFileUtilityB->toArray(),
                'mfreport' => $mfreport->toArray(),
                'reportMF' => $reportMF->toArray(),
                'sfreport' => $sfreport->toArray(),
                'reportSF' => $reportSF->toArray(),
            );

            return View::make('finance_en.edit_finance_file', $viewData);
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

    public function updateFinanceCheck() {
        $data = Input::all();
        $financeFileId = $data['finance_file_id'];
        $financeCheck = FinanceCheck::where('finance_file_id', $financeFileId)->first();
        if (Input::ajax()) {
            if ($financeCheck) {
                $financeCheck->finance_file_id = $financeFileId;
                $financeCheck->date = $data['date'];
                $financeCheck->name = $data['name'];
                $financeCheck->position = $data['position'];
                $financeCheck->status = $data['status'];
                $financeCheck->remarks = $data['remarks'];
                $financeCheck->save();

                # Audit Trail
                $remarks = 'Finance File  with id : ' . $financeCheck->id . ' has been updated.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "COB Finance File  - Check";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                $fc = new FinanceCheck;
                $fc->finance_file_id = $financeFileId;
                $fc->date = $data['date'];
                $fc->name = $data['name'];
                $fc->position = $data['position'];
                $fc->status = $data['status'];
                $fc->remarks = $data['remarks'];
                $fc->save();

                # Audit Trail
                $remarks = 'Finance File  with id : ' . $fc->id . ' has been updated.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "COB Finance File  - Check";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            }
        }
    }

    public function updateFinanceFileAdmin() {
        $data = Input::all();
        $id = $data['finance_file_id'];

        FinanceAdmin::where('finance_file_id', $id)->delete();

        $names = $data['admin_name'];
        for ($i = 0; $i < 25; $i++) {
            $financeadmin = new FinanceAdmin;
            $financeadmin->finance_file_id = $id;
            $financeadmin->name = $data['admin_name'][$i];
            $financeadmin->tunggakan = $data['admin_tunggakan'][$i];
            $financeadmin->semasa = $data['admin_semasa'][$i];
            $financeadmin->hadapan = $data['admin_hadapan'][$i];
            $financeadmin->tertunggak = $data['admin_tertunggak'][$i];
            $financeadmin->sort_no = $i;
            $financeadmin->save();
        }

        if ($financeadmin) {
            echo 'true';
        } else {
            echo 'false';
        }
    }

    public function updateFinanceFileIncome() {
        $data = Input::all();
        $id = $data['finance_file_id'];

        FinanceIncome::where('finance_file_id', $id)->delete();

        for ($i = 0; $i < count($data); $i++) {
            if (!empty($data['income_name'][$i])) {
                $financeadmin = new FinanceIncome;
                $financeadmin->finance_file_id = $id;
                $financeadmin->name = $data['income_name'][$i];
                $financeadmin->tunggakan = $data['income_tunggakan'][$i];
                $financeadmin->semasa = $data['income_semasa'][$i];
                $financeadmin->hadapan = $data['income_hadapan'][$i];
                $financeadmin->sort_no = $i;
                $financeadmin->save();
            }
        }

        return 'true';
    }

    public function updateFinanceFileUtility() {
        $data = Input::all();
        $id = $data['finance_file_id'];

        FinanceUtility::where('finance_file_id', $id)->delete();

        $prefix = [
            'util_',
            'utilb_',
        ];

        for ($i = 0; $i < 2; $i++) {

            foreach ($prefix as $p) {
                $financeadmin = new FinanceUtility;
                $financeadmin->finance_file_id = $id;
                $financeadmin->name = $data[$p . 'name'][$i];

                if ($p == 'util_') {
                    $financeadmin->type = 'bagian_a';
                } else {
                    $financeadmin->type = 'bagian_b';
                }
                $financeadmin->tunggakan = $data[$p . 'tunggakan'][$i];
                $financeadmin->semasa_b = $data[$p . 'semasa_b'][$i];
                $financeadmin->hadapan_c = $data[$p . 'hadapan_c'][$i];
                $financeadmin->tertunggak = $data[$p . 'tertunggak'][$i];
                $financeadmin->sort_no = $i;
                $financeadmin->save();
            }
        }

        if ($financeadmin) {
            echo 'true';
        } else {
            echo 'false';
        }
    }

    public function updateFinanceFileReportSf() {
        $data = Input::all();
        $id = $data['finance_file_id'];

        FinanceReportPerbelanjaan::where('finance_file_id', $id)->where('type' . 'sf')->delete();
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

        for ($i = 0; $i < 6; $i++) {
            $frp = new FinanceReportPerbelanjaan;
            $frp->type = 'sf';
            $frp->finance_file_id = $id;
            $frp->name = $data['sf_name'][$i];
            $frp->amount = $data['sf_amount'][$i];
            $frp->sort_no = $i;
            $frp->save();
        }

        if ($financeReportSf) {
            echo 'true';
        } else {
            echo 'false';
        }
    }

    public function updateFinanceFileReportMf() {
        $data = Input::all();
        $id = $data['finance_file_id'];

        FinanceReportPerbelanjaan::where('finance_file_id', $id)->where('type', 'MF')->delete();
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

        for ($i = 0; $i < count($data['mf_name']); $i++) {
            $frp = new FinanceReportPerbelanjaan;
            $frp->type = 'MF';
            $frp->finance_file_id = $id;
            $frp->name = $data['mf_name'][$i];
            $frp->amount = $data['mf_amount'][$i];
            $frp->sort_no = $i;
            $frp->save();
        }

        if ($financeReportSf) {
            echo 'true';
        } else {
            echo 'false';
        }
    }

    public function updateFinanceFileVandal() {
        $data = Input::all();
        $id = $data['finance_file_id'];

        FinanceVandal::where('finance_file_id', $id)->delete();

        $prefix = [
            'maintenancefee_',
            'singkingfund_'
        ];

        for ($i = 0; $i < 21; $i++) {

            foreach ($prefix as $p) {
                $financeadmin = new FinanceVandal;
                $financeadmin->finance_file_id = $id;
                $financeadmin->name = $data[$p . 'name'][$i];

                if ($p == 'maintenancefee_') {
                    $financeadmin->type = 'maintenancefee';
                } else {
                    $financeadmin->type = 'singkingfund';
                }
                $financeadmin->tunggakan = $data[$p . 'tunggakan'][$i];
                $financeadmin->semasa = $data[$p . 'semasa'][$i];
                $financeadmin->hadapan = $data[$p . 'hadapan'][$i];
                $financeadmin->tertunggak = $data[$p . 'tertunggak'][$i];
                $financeadmin->sort_no = $i;
                $financeadmin->save();
            }
        }

        if ($financeadmin) {
            echo 'true';
        } else {
            echo 'false';
        }
    }

    public function updateFinanceFileRepair() {
        $data = Input::all();
        $id = $data['finance_file_id'];

        FinanceRepair::where('finance_file_id', $id)->delete();

        $prefix = [
            'repair_maintenancefee_',
            'repair_singkingfund_'
        ];

        for ($i = 0; $i < 21; $i++) {

            foreach ($prefix as $p) {
                $financeadmin = new FinanceRepair;
                $financeadmin->finance_file_id = $id;
                $financeadmin->name = $data[$p . 'name'][$i];

                if ($p == 'repair_maintenancefee_') {
                    $financeadmin->type = 'maintenancefee';
                } else {
                    $financeadmin->type = 'singkingfund';
                }
                $financeadmin->tunggakan = $data[$p . 'tunggakan'][$i];
                $financeadmin->semasa = $data[$p . 'semasa'][$i];
                $financeadmin->hadapan = $data[$p . 'hadapan'][$i];
                $financeadmin->tertunggak = $data[$p . 'tertunggak'][$i];
                $financeadmin->sort_no = $i;
                $financeadmin->save();
            }
        }

        if ($financeadmin) {
            echo 'true';
        } else {
            echo 'false';
        }
    }

    public function updateFinanceFileContract() {
        $data = Input::all();
        $id = $data['finance_file_id'];

        $prefix = 'contract_';
        FinanceContract::where('finance_file_id', $id)->delete();

        for ($i = 0; $i < 25; $i++) {
            $financeadmin = new FinanceContract;
            $financeadmin->finance_file_id = $id;
            $financeadmin->name = $data[$prefix . 'name'][$i];
            $financeadmin->tunggakan = $data[$prefix . 'tunggakan'][$i];
            $financeadmin->semasa = $data[$prefix . 'semasa'][$i];
            $financeadmin->hadapan = $data[$prefix . 'hadapan'][$i];
            $financeadmin->tertunggak = $data[$prefix . 'tertunggak'][$i];
            $financeadmin->sort_no = $i;
            $financeadmin->save();
        }

        if ($financeadmin) {
            echo 'true';
        } else {
            echo 'false';
        }
    }

    public function updateFinanceFileStaff() {
        $data = Input::all();
        $id = $data['finance_file_id'];

        FinanceStaff::where('finance_file_id', $id)->delete();

        for ($i = 0; $i < 21; $i++) {
            $financestaff = new FinanceStaff;
            $financestaff->finance_file_id = $id;
            $financestaff->name = $data['staff_name'][$i];
            $financestaff->gaji_perorang_a = $data['staff_gaji_perorang_a'][$i];
            $financestaff->bil_pekerja_b = $data['staff_bil_pekerja_b'][$i];
            $financestaff->tunggakan_c = $data['staff_tunggakan_c'][$i];
            $financestaff->bulan_semasa_d = $data['staff_bulan_semasa_d'][$i];
            $financestaff->bulan_hadapan_e = $data['staff_bulan_hadapan_e'][$i];
            $financestaff->tertunggak = $data['staff_tertunggak'][$i];
            $financestaff->sort_no = $i;
            $financestaff->save();
        }

        if ($financestaff) {
            echo 'true';
        } else {
            echo 'false';
        }
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

            return View::make('finance_en.finance_support_list', $viewData);
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

            return View::make('finance_en.add_finance_support', $viewData);
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

            return View::make('finance_en.edit_finance_support', $viewData);
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

}
