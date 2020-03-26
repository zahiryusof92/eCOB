<?php

class AdminController extends BaseController {

    public function __construct() {
        if (empty(Session::get('lang'))) {
            Session::put('lang', 'en');
        }

        $locale = Session::get('lang');
        App::setLocale($locale);
    }

    public function showView($name) {
        if (View::exists($name)) {
            return View::make($name);
        } else {
            if (Session::get('lang') == "en") {
                $viewData = array(
                    'title' => "Page not found!",
                    'panel_nav_active' => '',
                    'main_nav_active' => '',
                    'sub_nav_active' => '',
                    'image' => ""
                );
                return View::make('404_en', $viewData);
            } else {
                $viewData = array(
                    'title' => "Halaman tidak dijumpai!",
                    'panel_nav_active' => '',
                    'main_nav_active' => '',
                    'sub_nav_active' => '',
                    'image' => ""
                );
                return View::make('404_my', $viewData);
            }
        }
    }

    public function home() {
        //get user permission
        $user_permission = AccessGroup::getAccessPermission(Auth::user()->id);
        if (!Auth::user()->getAdmin()) {
            $file = Files::where('created_by', Auth::user()->id)->where('is_active', 1)->where('is_deleted', 0)->where('status', 1)->orderBy('id', 'asc')->get();
        } else {
            $file = Files::where('is_active', 1)->where('is_deleted', 0)->where('status', 1)->orderBy('id', 'asc')->get();
        }

        $stratas = 0;
        $ratings = 0;
        $fiveStars = 0;
        $fourStars = 0;
        $threeStars = 0;
        $twoStars = 0;
        $oneStars = 0;
        $jmbs = 0;
        $mcs = 0;
        $agents = 0;
        $otherss = 0;

        $developer = Developer::where('is_deleted', 0)->count();

        if (count($file) > 0) {
            foreach ($file as $files) {
                $strata = Strata::where('file_id', $files->id)->count();
                $rating = Scoring::where('file_id', $files->id)->where('is_deleted', 0)->count();
                $fiveStar = Scoring::where('file_id', $files->id)->where('is_deleted', 0)->where('total_score', '<=', 100)->where('total_score', '>=', 87)->count();
                $fourStar = Scoring::where('file_id', $files->id)->where('is_deleted', 0)->where('total_score', '<', 87)->where('total_score', '>=', 73)->count();
                $threeStar = Scoring::where('file_id', $files->id)->where('is_deleted', 0)->where('total_score', '<', 73)->where('total_score', '>=', 51)->count();
                $twoStar = Scoring::where('file_id', $files->id)->where('is_deleted', 0)->where('total_score', '<', 51)->where('total_score', '>=', 26)->count();
                $oneStar = Scoring::where('file_id', $files->id)->where('is_deleted', 0)->where('total_score', '<', 26)->where('total_score', '>=', 1)->count();

                $stratas += $strata;
                $ratings += $rating;
                $fiveStars += $fiveStar;
                $fourStars += $fourStar;
                $threeStars += $threeStar;
                $twoStars += $twoStar;
                $oneStars += $oneStar;

                $jmb = ManagementJMB::where('file_id', $files->id)->count();
                $mc = ManagementMC::where('file_id', $files->id)->count();
                $agent = ManagementAgent::where('file_id', $files->id)->count();
                $others = ManagementOthers::where('file_id', $files->id)->count();

                $jmbs += $jmb;
                $mcs += $mc;
                $agents += $agent;
                $otherss += $others;
            }
        }

        if (Session::get('lang') == "en") {
            $viewData = array(
                'title' => 'eCOB System',
                'panel_nav_active' => 'home_panel',
                'main_nav_active' => 'home_main',
                'sub_nav_active' => 'home',
                'user_permission' => $user_permission,
                'strata' => $stratas,
                'rating' => $ratings,
                'fiveStar' => $fiveStars,
                'fourStar' => $fourStars,
                'threeStar' => $threeStars,
                'twoStar' => $twoStars,
                'oneStar' => $oneStars,
                'developer' => $developer,
                'jmb' => $jmbs,
                'mc' => $mcs,
                'agent' => $agents,
                'others' => $otherss,
                'image' => ""
            );

            return View::make('page_en.home', $viewData);
        } else {
            $viewData = array(
                'title' => 'Sistem eCOB',
                'panel_nav_active' => 'home_panel',
                'main_nav_active' => 'home_main',
                'sub_nav_active' => 'home',
                'user_permission' => $user_permission,
                'strata' => $stratas,
                'rating' => $ratings,
                'fiveStar' => $fiveStars,
                'fourStar' => $fourStars,
                'threeStar' => $threeStars,
                'twoStar' => $twoStars,
                'oneStar' => $oneStars,
                'developer' => $developer,
                'jmb' => $jmbs,
                'mc' => $mcs,
                'agent' => $agents,
                'others' => $otherss,
                'image' => ""
            );

            return View::make('page_my.home', $viewData);
        }
    }

    public function getAGMRemainder() {
        $oneyear = strtotime("-1 Year");
        if (!Auth::user()->getAdmin()) {
            $file = Files::where('created_by', Auth::user()->id)->where('is_active', 1)->where('is_deleted', 0)->where('status', 1)->orderBy('id', 'asc')->get();
        } else {
            $file = Files::where('is_active', 1)->where('is_deleted', 0)->where('status', 1)->orderBy('id', 'asc')->get();
        }

        if (count($file) > 0) {
            $data = Array();
            foreach ($file as $files) {
                $agm_remainder = MeetingDocument::where('file_id', $files->id)->where('is_deleted', 0)->orderBy('agm_date', 'desc')->first();
                if (count($agm_remainder) > 0) {
                    if ($agm_remainder->agm_date <= date('Y-m-d', $oneyear) && $agm_remainder->agm_date != "0000-00-00") {
                        $button = "";
                        if (Session::get('lang') == "en") {
                            $button .= '<button type="button" class="btn btn-xs btn-success" onclick="window.location=\'' . URL::action('AdminController@monitoring', $files->id) . '\'">View</button>&nbsp;';
                        } else {
                            $button .= '<button type="button" class="btn btn-xs btn-success" onclick="window.location=\'' . URL::action('AdminController@monitoring', $files->id) . '\'">Papar</button>&nbsp;';
                        }
                        $data_raw = array(
                            $files->file_no,
                            date('d-M-Y', strtotime($agm_remainder->agm_date)),
                            $button
                        );

                        array_push($data, $data_raw);
                    }
                }
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

    public function getNeverAGM() {
        if (!Auth::user()->getAdmin()) {
            $file = Files::where('created_by', Auth::user()->id)->where('is_active', 1)->where('is_deleted', 0)->where('status', 1)->orderBy('id', 'asc')->get();
        } else {
            $file = Files::where('is_active', 1)->where('is_deleted', 0)->where('status', 1)->orderBy('id', 'asc')->get();
        }

        if (count($file) > 0) {
            $data = Array();
            foreach ($file as $files) {
                $never_agm = MeetingDocument::where('file_id', $files->id)->where('is_deleted', 0)->orderBy('agm_date', 'desc')->first();

                $button = "";
                if (Session::get('lang') == "en") {
                    $button .= '<button type="button" class="btn btn-xs btn-success" onclick="window.location=\'' . URL::action('AdminController@monitoring', $files->id) . '\'">View</button>&nbsp;';
                } else {
                    $button .= '<button type="button" class="btn btn-xs btn-success" onclick="window.location=\'' . URL::action('AdminController@monitoring', $files->id) . '\'">Papar</button>&nbsp;';
                }
                if (count($never_agm) > 0) {
                    if ($never_agm->agm_date == "0000-00-00") {
                        $data_raw = array(
                            $files->file_no,
                            $button
                        );

                        array_push($data, $data_raw);
                    }
                } else {
                    $data_raw = array(
                        $files->file_no,
                        $button
                    );

                    array_push($data, $data_raw);
                }
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

    public function getAGM12Months() {
        $twelveMonths = strtotime("-12 Months");
        if (!Auth::user()->getAdmin()) {
            $file = Files::where('created_by', Auth::user()->id)->where('is_active', 1)->where('is_deleted', 0)->where('status', 1)->orderBy('id', 'asc')->get();
        } else {
            $file = Files::where('is_active', 1)->where('is_deleted', 0)->where('status', 1)->orderBy('id', 'asc')->get();
        }

        if (count($file) > 0) {
            $data = Array();
            foreach ($file as $files) {
                $agm_more12months = MeetingDocument::where('file_id', $files->id)->where('is_deleted', 0)->orderBy('agm_date', 'desc')->first();
                if (count($agm_more12months) > 0) {
                    if ($agm_more12months->agm_date <= date('Y-m-d', $twelveMonths) && $agm_more12months->agm_date != "0000-00-00") {
                        $button = "";
                        if (Session::get('lang') == "en") {
                            $button .= '<button type="button" class="btn btn-xs btn-success" onclick="window.location=\'' . URL::action('AdminController@monitoring', $files->id) . '\'">View</button>&nbsp;';
                        } else {
                            $button .= '<button type="button" class="btn btn-xs btn-success" onclick="window.location=\'' . URL::action('AdminController@monitoring', $files->id) . '\'">Papar</button>&nbsp;';
                        }
                        $data_raw = array(
                            $files->file_no,
                            date('d-M-Y', strtotime($agm_more12months->agm_date)),
                            $button
                        );

                        array_push($data, $data_raw);
                    }
                }
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

    public function getAGM15Months() {
        $fifthteenMonths = strtotime("-15 Months");
        if (!Auth::user()->getAdmin()) {
            $file = Files::where('created_by', Auth::user()->id)->where('is_active', 1)->where('is_deleted', 0)->where('status', 1)->orderBy('id', 'asc')->get();
        } else {
            $file = Files::where('is_active', 1)->where('is_deleted', 0)->where('status', 1)->orderBy('id', 'asc')->get();
        }

        if (count($file) > 0) {
            $data = Array();
            foreach ($file as $files) {
                $agm_more15months = MeetingDocument::where('file_id', $files->id)->where('is_deleted', 0)->orderBy('agm_date', 'desc')->first();
                if (count($agm_more15months) > 0) {
                    if ($agm_more15months->agm_date <= date('Y-m-d', $fifthteenMonths) && $agm_more15months->agm_date != "0000-00-00") {
                        $button = "";
                        if (Session::get('lang') == "en") {
                            $button .= '<button type="button" class="btn btn-xs btn-success" onclick="window.location=\'' . URL::action('AdminController@monitoring', $files->id) . '\'">View</button>&nbsp;';
                        } else {
                            $button .= '<button type="button" class="btn btn-xs btn-success" onclick="window.location=\'' . URL::action('AdminController@monitoring', $files->id) . '\'">Papar</button>&nbsp;';
                        }
                        $data_raw = array(
                            $files->file_no,
                            date('d-M-Y', strtotime($agm_more15months->agm_date)),
                            $button
                        );

                        array_push($data, $data_raw);
                    }
                }
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

    public function getMemoHome() {
        $memo = Memo::where('is_deleted', 0)->where('is_active', 1)->orderBy('id', 'desc')->get();

        if (count($memo) > 0) {
            $data = Array();
            foreach ($memo as $memos) {
                $button = "";
                if (Session::get('lang') == "en") {
                    $button .= '<button type="button" class="btn btn-xs btn-success" onclick="getMemoDetails(\'' . $memos->id . '\')">View</button>&nbsp;';
                } else {
                    $button .= '<button type="button" class="btn btn-xs btn-success" onclick="getMemoDetails(\'' . $memos->id . '\')">Papar</button>&nbsp;';
                }
                $data_raw = array(
                    $memos->subject,
                    date('d-M-Y', strtotime($memos->memo_date)),
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

    public function getMemoDetails() {
        $data = Input::all();
        if (Request::ajax()) {

            $result = "";
            $id = $data['id'];

            $memo = Memo::find($id);

            if (count($memo) > 0) {

                $result .= "<div class='modal-header'>";
                $result .= "<button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>";
                $result .= "<h4 class='modal-title' id='myModalLabel'>" . ($memo->subject != "" ? $memo->subject : "-") . "</h4>";
                $result .= "<h6 class='modal-title' id=''>" . (date('d-M-Y', strtotime($memo->memo_date)) != "" ? date('d-M-Y', strtotime($memo->memo_date)) : "-") . "</h6>";
                $result .= "</div>";
                $result .= "<div class='modal-body'>";
                $result .= "<p>" . ($memo->description != "" ? $memo->description : "-") . "</p>";
                $result .= "</div>";
            } else {
                $result = "No Data Found";
            }

            print $result;
        }
    }

    // --- COB Maintenance --- //
    //file prefix
    public function filePrefix() {
        //get user permission
        $user_permission = AccessGroup::getAccessPermission(Auth::user()->id);

        if (Session::get('lang') == "en") {
            $viewData = array(
                'title' => 'COB File Prefix Maintenance',
                'panel_nav_active' => 'cob_panel',
                'main_nav_active' => 'cob_main',
                'sub_nav_active' => 'prefix_file',
                'user_permission' => $user_permission,
                'image' => ""
            );

            return View::make('cob_en.fileprefix', $viewData);
        } else {
            $viewData = array(
                'title' => 'Pengurusan Awalan Fail COB',
                'panel_nav_active' => 'cob_panel',
                'main_nav_active' => 'cob_main',
                'sub_nav_active' => 'prefix_file',
                'user_permission' => $user_permission,
                'image' => ""
            );

            return View::make('cob_my.fileprefix', $viewData);
        }
    }

    public function addFilePrefix() {
        //get user permission
        $user_permission = AccessGroup::getAccessPermission(Auth::user()->id);

        if (Session::get('lang') == "en") {
            $viewData = array(
                'title' => 'Add COB File Prefix',
                'panel_nav_active' => 'cob_panel',
                'main_nav_active' => 'cob_main',
                'sub_nav_active' => 'prefix_file',
                'user_permission' => $user_permission,
                'image' => ""
            );

            return View::make('cob_en.add_fileprefix', $viewData);
        } else {
            $viewData = array(
                'title' => 'Tambah Awalan Fail COB',
                'panel_nav_active' => 'cob_panel',
                'main_nav_active' => 'cob_main',
                'sub_nav_active' => 'prefix_file',
                'user_permission' => $user_permission,
                'image' => ""
            );

            return View::make('cob_my.add_fileprefix', $viewData);
        }
    }

    public function submitFilePrefix() {
        $data = Input::all();
        if (Request::ajax()) {
            $description = $data['description'];
            $is_active = $data['is_active'];
            $sort_no = $data['sort_no'];

            $fileprefix = new FilePrefix();
            $fileprefix->description = $description;
            $fileprefix->sort_no = $sort_no;
            $fileprefix->is_active = $is_active;
            $success = $fileprefix->save();

            if ($success) {
                # Audit Trail
                $remarks = 'COB File Prefix: ' . $fileprefix->description . ' has been inserted.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "Master Setup";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->username;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    public function getFilePrefix() {
        $prefix = FilePrefix::where('is_deleted', 0)->orderBy('id', 'desc')->get();

        if (count($prefix) > 0) {
            $data = Array();
            foreach ($prefix as $fileprefixs) {
                $button = "";
                if (Session::get('lang') == "en") {
                    if ($fileprefixs->is_active == 1) {
                        $status = "Active";
                        $button .= '<button type="button" class="btn btn-xs btn-primary" onclick="inactiveFilePrefix(\'' . $fileprefixs->id . '\')">Inactive</button>&nbsp;';
                    } else {
                        $status = "Inactive";
                        $button .= '<button type="button" class="btn btn-xs btn-primary" onclick="activeFilePrefix(\'' . $fileprefixs->id . '\')">Active</button>&nbsp;';
                    }
                    $button .= '<button type="button" class="btn btn-xs btn-success" onclick="window.location=\'' . URL::action('AdminController@updateFilePrefix', $fileprefixs->id) . '\'"><i class="fa fa-pencil"></i></button>&nbsp;';
                    $button .= '<button class="btn btn-xs btn-danger" onclick="deleteFilePrefix(\'' . $fileprefixs->id . '\')"><i class="fa fa-trash"></i></button>';
                } else {
                    if ($fileprefixs->is_active == 1) {
                        $status = "Aktif";
                        $button .= '<button type="button" class="btn btn-xs btn-primary" onclick="inactiveFilePrefix(\'' . $fileprefixs->id . '\')">Tidak Aktif</button>&nbsp;';
                    } else {
                        $status = "Tidak Aktif";
                        $button .= '<button type="button" class="btn btn-xs btn-primary" onclick="activeFilePrefix(\'' . $fileprefixs->id . '\')">Aktif</button>&nbsp;';
                    }
                    $button .= '<button type="button" class="btn btn-xs btn-success" onclick="window.location=\'' . URL::action('AdminController@updateFilePrefix', $fileprefixs->id) . '\'"><i class="fa fa-pencil"></i></button>&nbsp;';
                    $button .= '<button class="btn btn-xs btn-danger" onclick="deleteFilePrefix(\'' . $fileprefixs->id . '\')"><i class="fa fa-trash"></i></button>';
                }
                $data_raw = array(
                    $fileprefixs->description,
                    $fileprefixs->sort_no,
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

    public function inactiveFilePrefix() {
        $data = Input::all();
        if (Request::ajax()) {

            $id = $data['id'];

            $prefix = FilePrefix::find($id);
            $prefix->is_active = 0;
            $updated = $prefix->save();
            if ($updated) {
                # Audit Trail
                $remarks = 'COB File Prefix: ' . $prefix->description . ' has been updated.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "Master Setup";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    public function activeFilePrefix() {
        $data = Input::all();
        if (Request::ajax()) {

            $id = $data['id'];

            $prefix = FilePrefix::find($id);
            $prefix->is_active = 1;
            $updated = $prefix->save();
            if ($updated) {
                # Audit Trail
                $remarks = 'COB File Prefix: ' . $prefix->description . ' has been updated.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "Master Setup";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    public function deleteFilePrefix() {
        $data = Input::all();
        if (Request::ajax()) {

            $id = $data['id'];

            $prefix = FilePrefix::find($id);
            $prefix->is_deleted = 1;
            $deleted = $prefix->save();
            if ($deleted) {
                # Audit Trail
                $remarks = 'COB File Prefix: ' . $prefix->description . ' has been deleted.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "Master Setup";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    public function updateFilePrefix($id) {
        //get user permission
        $user_permission = AccessGroup::getAccessPermission(Auth::user()->id);
        $prefix = FilePrefix::find($id);

        if (Session::get('lang') == "en") {
            $viewData = array(
                'title' => 'Update COB File Prefix',
                'panel_nav_active' => 'cob_panel',
                'main_nav_active' => 'cob_main',
                'sub_nav_active' => 'prefix_file',
                'user_permission' => $user_permission,
                'prefix' => $prefix,
                'image' => ""
            );

            return View::make('cob_en.update_fileprefix', $viewData);
        } else {
            $viewData = array(
                'title' => 'Edit Awalan Fail COB',
                'panel_nav_active' => 'cob_panel',
                'main_nav_active' => 'cob_main',
                'sub_nav_active' => 'prefix_file',
                'user_permission' => $user_permission,
                'prefix' => $prefix,
                'image' => ""
            );

            return View::make('cob_my.update_fileprefix', $viewData);
        }
    }

    public function submitUpdateFilePrefix() {
        $data = Input::all();
        if (Request::ajax()) {
            $id = $data['id'];
            $description = $data['description'];
            $is_active = $data['is_active'];
            $sort_no = $data['sort_no'];

            $fileprefix = FilePrefix::find($id);
            $fileprefix->description = $description;
            $fileprefix->sort_no = $sort_no;
            $fileprefix->is_active = $is_active;
            $success = $fileprefix->save();

            if ($success) {
                # Audit Trail
                $remarks = 'COB File Prefix: ' . $fileprefix->description . ' has been updated.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "Master Setup";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    // add file    
    public function addFile() {
        //get user permission
        $user_permission = AccessGroup::getAccessPermission(Auth::user()->id);
        $file_no = FilePrefix::where('is_active', 1)->where('is_deleted', 0)->get();

        if (Session::get('lang') == "en") {
            $viewData = array(
                'title' => 'Add COB File',
                'panel_nav_active' => 'cob_panel',
                'main_nav_active' => 'cob_main',
                'sub_nav_active' => 'add_cob',
                'file_no' => $file_no,
                'user_permission' => $user_permission,
                'image' => ""
            );

            return View::make('page_en.add_file', $viewData);
        } else {
            $viewData = array(
                'title' => 'Tambah Fail COB',
                'panel_nav_active' => 'cob_panel',
                'main_nav_active' => 'cob_main',
                'sub_nav_active' => 'add_cob',
                'file_no' => $file_no,
                'user_permission' => $user_permission,
                'image' => ""
            );

            return View::make('page_my.add_file', $viewData);
        }
    }

    public function submitFile() {
        $data = Input::all();
        if (Request::ajax()) {
            $file_no = $data['file_no'];
            $description = $data['description'];

            $filename = $file_no . '-' . $description;
            $year = substr($filename, strpos($filename, "/") + 1);

            $check_file = Files::where('file_no', $filename)->count();

            if ($check_file <= 0) {
                $files = new Files();
                $files->file_no = $filename;
                $files->year = $year;
                $files->is_active = 0;
                $files->status = 0;
                $files->created_by = Auth::user()->id;
                $success = $files->save();

                if ($success) {
                    $house_scheme = new HouseScheme();
                    $house_scheme->file_id = $files->id;
                    $house_scheme->is_active = "-1";
                    $created1 = $house_scheme->save();

                    if ($created1) {
                        $strata = new Strata();
                        $strata->file_id = $files->id;
                        $created2 = $strata->save();

                        if ($created2) {
                            $facility = new Facility();
                            $facility->file_id = $files->id;
                            $facility->strata_id = $strata->id;
                            $created3 = $facility->save();

                            if ($created3) {
                                $management = new Management();
                                $management->file_id = $files->id;
                                $created4 = $management->save();

                                if ($created4) {
                                    $monitor = new Monitoring();
                                    $monitor->file_id = $files->id;
                                    $created5 = $monitor->save();

                                    if ($created5) {
                                        $others = new OtherDetails();
                                        $others->file_id = $files->id;
                                        $created6 = $others->save();

                                        if ($created6) {
                                            # Audit Trail
                                            $remarks = $files->file_no . ' has been inserted.';
                                            $auditTrail = new AuditTrail();
                                            $auditTrail->module = "COB File";
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
                                } else {
                                    print "false";
                                }
                            } else {
                                print "false";
                            }
                        } else {
                            print "false";
                        }
                    } else {
                        print "false";
                    }
                } else {
                    print "false";
                }
            } else {
                print "file_already_exists";
            }
        } else {
            print "false";
        }
    }

    // file list
    public function fileList() {
        //get user permission
        $user_permission = AccessGroup::getAccessPermission(Auth::user()->id);
        $file = Files::where('is_deleted', 0)->get();

        if (Session::get('lang') == "en") {
            $viewData = array(
                'title' => 'COB File List',
                'panel_nav_active' => 'cob_panel',
                'main_nav_active' => 'cob_main',
                'sub_nav_active' => 'cob_list',
                'user_permission' => $user_permission,
                'file' => $file,
                'image' => ""
            );

            return View::make('page_en.file_list', $viewData);
        } else {
            $viewData = array(
                'title' => 'Senarai Fail COB',
                'panel_nav_active' => 'cob_panel',
                'main_nav_active' => 'cob_main',
                'sub_nav_active' => 'cob_list',
                'user_permission' => $user_permission,
                'file' => $file,
                'image' => ""
            );

            return View::make('page_my.file_list', $viewData);
        }
    }

    public function getFileList() {
        if (!Auth::user()->getAdmin()) {
            $file = Files::where('created_by', Auth::user()->id)->where('is_deleted', 0)->orderBy('status', 'asc')->get();
        } else {
            $file = Files::where('is_deleted', 0)->orderBy('status', 'asc')->get();
        }

        if (count($file) > 0) {
            $data = Array();
            foreach ($file as $files) {
                $strata = Strata::where('file_id', $files->id)->first();
                if (count($strata) > 0) {
                    $strata_name = $strata->name;
                } else {
                    $strata_name = "";
                }
                $button = "";
                if (Session::get('lang') == "en") {
                    if ($files->status == 1) {
                        $status = "Approved";
                        if ($files->is_active == 1) {
                            $button .= '<button type="button" class="btn btn-xs btn-default" onclick="inactiveFileList(\'' . $files->id . '\')">Inactive</button>&nbsp;';
                        } else {
                            $button .= '<button type="button" class="btn btn-xs btn-primary" onclick="activeFileList(\'' . $files->id . '\')">Active</button>&nbsp;';
                        }
                    } else if ($files->status == 2) {
                        $status = "Rejected";
                    } else {
                        $status = "Pending";
                    }
                    if ($files->is_active == 1) {
                        $is_active = "Yes";
                    } else {
                        $is_active = "No";
                    }

                    $button .= '<button type="button" class="btn btn-xs btn-warning" onclick="window.location=\'' . URL::action('AdminController@viewHouse', $files->id) . '\'">View <i class="fa fa-eye"></i></button>&nbsp;';
                    $button .= '<button type="button" class="btn btn-xs btn-danger" onclick="deleteFileList(\'' . $files->id . '\')">Delete <i class="fa fa-trash"></i></button>';
                } else {
                    if ($files->status == 1) {
                        $status = "Diterima";
                        if ($files->is_active == 1) {
                            $button .= '<button type="button" class="btn btn-xs btn-default" onclick="inactiveFileList(\'' . $files->id . '\')">Tidak Aktif</button>&nbsp;';
                        } else {
                            $button .= '<button type="button" class="btn btn-xs btn-primary" onclick="activeFileList(\'' . $files->id . '\')">Aktif</button>&nbsp;';
                        }
                        $button .= '<button type="button" class="btn btn-xs btn-success" onclick="window.location=\'' . URL::action('AdminController@house', $files->id) . '\'">Edit <i class="fa fa-pencil"></i></button>&nbsp;';
                    } else if ($files->status == 2) {
                        $status = "Ditolak";
                    } else {
                        $status = "Menunggu";
                        $button .= '<button type="button" class="btn btn-xs btn-success" onclick="window.location=\'' . URL::action('AdminController@house', $files->id) . '\'">Edit <i class="fa fa-pencil"></i></button>&nbsp;';
                    }
                    if ($files->is_active == 1) {
                        $is_active = "Ya";
                    } else {
                        $is_active = "Tidak";
                    }

                    $button .= '<button type="button" class="btn btn-xs btn-warning" onclick="window.location=\'' . URL::action('AdminController@viewHouse', $files->id) . '\'">View <i class="fa fa-eye"></i></button>&nbsp;';
                    $button .= '<button type="button" class="btn btn-xs btn-danger" onclick="deleteFileList(\'' . $files->id . '\')">Padam <i class="fa fa-trash"></i></button>';
                }

                $data_raw = array(
                    "<a style='text-decoration:underline;' href='" . URL::action('AdminController@house', $files->id) . "'>" . $files->file_no . "</a>",
                    $files->year,
                    $strata_name,
                    $is_active,
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

    public function inactiveFileList() {
        $data = Input::all();
        if (Request::ajax()) {

            $id = $data['id'];

            $files = Files::find($id);
            $files->is_active = 0;
            $updated = $files->save();
            if ($updated) {
                # Audit Trail
                $remarks = $files->file_no . ' has been updated.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "COB File";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    public function activeFileList() {
        $data = Input::all();
        if (Request::ajax()) {

            $id = $data['id'];

            $files = Files::find($id);
            $files->is_active = 1;
            $updated = $files->save();
            if ($updated) {
                # Audit Trail
                $remarks = $files->file_no . ' has been updated.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "COB File";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    public function deleteFileList() {
        $data = Input::all();
        if (Request::ajax()) {

            $id = $data['id'];

            $files = Files::find($id);
            $deleted = $files->delete();

            if ($deleted) {
                $house_scheme = HouseScheme::where('file_id', $files->id)->first();
                $deleted1 = $house_scheme->delete();

                if ($deleted1) {
                    $strata = Strata::where('file_id', $files->id)->first();
                    $deleted2 = $strata->delete();

                    if ($deleted2) {
                        $facility = Facility::where('file_id', $files->id)->first();
                        $deleted3 = $facility->delete();

                        if ($deleted3) {
                            $management = Management::where('file_id', $files->id)->first();
                            $deleted4 = $management->delete();

                            if ($deleted4) {
                                $monitor = Monitoring::where('file_id', $files->id)->first();
                                $deleted5 = $monitor->delete();

                                if ($deleted5) {
                                    $others = OtherDetails::where('file_id', $files->id)->first();
                                    $deleted6 = $others->delete();

                                    if ($deleted6) {
                                        # Commercial Block
                                        $commercial = Commercial::where('file_id', $files->id)->get();
                                        if (count($commercial) > 0) {
                                            foreach ($commercial as $commercials) {
                                                $commercials->delete();
                                            }
                                        }
                                        # Residential Block
                                        $residential = Residential::where('file_id', $files->id)->get();
                                        if (count($residential) > 0) {
                                            foreach ($residential as $residentials) {
                                                $residentials->delete();
                                            }
                                        }
                                        # Management JMB
                                        $managementjmb = ManagementJMB::where('file_id', $files->id)->get();
                                        if (count($managementjmb) > 0) {
                                            foreach ($managementjmb as $managementjmbs) {
                                                $managementjmbs->delete();
                                            }
                                        }
                                        # Management MC
                                        $managementmc = ManagementMC::where('file_id', $files->id)->get();
                                        if (count($managementmc) > 0) {
                                            foreach ($managementmc as $managementmcs) {
                                                $managementmcs->delete();
                                            }
                                        }
                                        # Management Agent
                                        $managementagent = ManagementAgent::where('file_id', $files->id)->get();
                                        if (count($managementagent) > 0) {
                                            foreach ($managementagent as $managementagents) {
                                                $managementagents->delete();
                                            }
                                        }
                                        # Management Other
                                        $managementother = ManagementOthers::where('file_id', $files->id)->get();
                                        if (count($managementother) > 0) {
                                            foreach ($managementother as $managementothers) {
                                                $managementothers->delete();
                                            }
                                        }
                                        # Meeting Document
                                        $meetingdocument = MeetingDocument::where('file_id', $files->id)->get();
                                        if (count($meetingdocument) > 0) {
                                            foreach ($meetingdocument as $meetingdocuments) {
                                                $meetingdocuments->delete();
                                            }
                                        }
                                        # AJK Detail
                                        $ajkdetail = AJKDetails::where('file_id', $files->id)->get();
                                        if (count($ajkdetail) > 0) {
                                            foreach ($ajkdetail as $ajkdetails) {
                                                $ajkdetails->delete();
                                            }
                                        }
                                        # Scoring
                                        $scoring = Scoring::where('file_id', $files->id)->get();
                                        if (count($scoring) > 0) {
                                            foreach ($scoring as $scorings) {
                                                $scorings->delete();
                                            }
                                        }
                                        # Buyer List
                                        $buyerlist = Buyer::where('file_id', $files->id)->get();
                                        if (count($buyerlist) > 0) {
                                            foreach ($buyerlist as $buyerlists) {
                                                $buyerlists->delete();
                                            }
                                        }

                                        # Audit Trail
                                        $remarks = $files->file_no . ' has been deleted.';
                                        $auditTrail = new AuditTrail();
                                        $auditTrail->module = "COB File";
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
                            } else {
                                print "false";
                            }
                        } else {
                            print "false";
                        }
                    } else {
                        print "false";
                    }
                } else {
                    print "false";
                }
            } else {
                print "false";
            }
        }
    }

    public function viewHouse($id) {
        //get user permission
        $user_permission = AccessGroup::getAccessPermission(Auth::user()->id);
        $file = Files::find($id);
        $house_scheme = HouseScheme::where('file_id', $file->id)->first();
        $image = OtherDetails::where('file_id', $file->id)->first();

        $developer = Developer::where('is_active', 1)->where('is_deleted', 0)->orderBy('name', 'asc')->get();
        $city = City::where('is_active', 1)->where('is_deleted', 0)->orderBy('description', 'asc')->get();
        $country = Country::where('is_active', 1)->where('is_deleted', 0)->orderBy('name', 'asc')->get();
        $state = State::where('is_active', 1)->where('is_deleted', 0)->orderBy('name', 'asc')->get();

        if (Session::get('lang') == "en") {
            $viewData = array(
                'title' => 'Update COB File',
                'panel_nav_active' => 'cob_panel',
                'main_nav_active' => 'cob_main',
                'sub_nav_active' => 'cob_list',
                'user_permission' => $user_permission,
                'developer' => $developer,
                'house_scheme' => $house_scheme,
                'city' => $city,
                'country' => $country,
                'state' => $state,
                'file' => $file,
                'image' => $image->image_url
            );

            return View::make('page_en.view_house_scheme', $viewData);
        } else {
            $viewData = array(
                'title' => 'Edit Fail COB',
                'panel_nav_active' => 'cob_panel',
                'main_nav_active' => 'cob_main',
                'sub_nav_active' => 'cob_list',
                'user_permission' => $user_permission,
                'developer' => $developer,
                'house_scheme' => $house_scheme,
                'city' => $city,
                'country' => $country,
                'state' => $state,
                'file' => $file,
                'image' => $image->image_url
            );

            return View::make('page_my.view_house_scheme', $viewData);
        }
    }

    public function house($id) {
        //get user permission
        $user_permission = AccessGroup::getAccessPermission(Auth::user()->id);
        $file = Files::find($id);
        $house_scheme = HouseScheme::where('file_id', $file->id)->first();
        $image = OtherDetails::where('file_id', $file->id)->first();

        $developer = Developer::where('is_active', 1)->where('is_deleted', 0)->orderBy('name', 'asc')->get();
        $city = City::where('is_active', 1)->where('is_deleted', 0)->orderBy('description', 'asc')->get();
        $country = Country::where('is_active', 1)->where('is_deleted', 0)->orderBy('name', 'asc')->get();
        $state = State::where('is_active', 1)->where('is_deleted', 0)->orderBy('name', 'asc')->get();

        if (Session::get('lang') == "en") {
            $viewData = array(
                'title' => 'Update COB File',
                'panel_nav_active' => 'cob_panel',
                'main_nav_active' => 'cob_main',
                'sub_nav_active' => 'cob_list',
                'user_permission' => $user_permission,
                'developer' => $developer,
                'house_scheme' => $house_scheme,
                'city' => $city,
                'country' => $country,
                'state' => $state,
                'file' => $file,
                'image' => $image->image_url
            );

            return View::make('page_en.update_house_scheme', $viewData);
        } else {
            $viewData = array(
                'title' => 'Edit Fail COB',
                'panel_nav_active' => 'cob_panel',
                'main_nav_active' => 'cob_main',
                'sub_nav_active' => 'cob_list',
                'user_permission' => $user_permission,
                'developer' => $developer,
                'house_scheme' => $house_scheme,
                'city' => $city,
                'country' => $country,
                'state' => $state,
                'file' => $file,
                'image' => $image->image_url
            );

            return View::make('page_my.update_house_scheme', $viewData);
        }
    }

    public function submitUpdateHouseScheme() {
        $data = Input::all();
        if (Request::ajax()) {
            $id = $data['id'];
            $name = $data['name'];
            $developer = $data['developer'];
            $address1 = $data['address1'];
            $address2 = $data['address2'];
            $address3 = $data['address3'];
            $city = $data['city'];
            $poscode = $data['poscode'];
            $state = $data['state'];
            $country = $data['country'];
            $phone_no = $data['phone_no'];
            $fax_no = $data['fax_no'];
            $remarks = $data['remarks'];
            $is_active = $data['is_active'];

            $house_scheme = HouseScheme::find($id);
            $house_scheme->name = $name;
            $house_scheme->developer = $developer;
            $house_scheme->address1 = $address1;
            $house_scheme->address2 = $address2;
            $house_scheme->address3 = $address3;
            $house_scheme->city = $city;
            $house_scheme->poscode = $poscode;
            $house_scheme->state = $state;
            $house_scheme->country = $country;
            $house_scheme->phone_no = $phone_no;
            $house_scheme->fax_no = $fax_no;
            $house_scheme->remarks = $remarks;
            $house_scheme->is_active = $is_active;
            $success = $house_scheme->save();

            if ($success) {
                # Audit Trail
                $file_name = Files::find($house_scheme->file_id);
                $remarks = 'House Info (' . $file_name->file_no . ') has been updated.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "COB File";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    public function viewStrata($id) {
        //get user permission
        $user_permission = AccessGroup::getAccessPermission(Auth::user()->id);
        $file = Files::find($id);
        $strata = Strata::where('file_id', $file->id)->first();
        $residential = Residential::where('file_id', $file->id)->where('strata_id', $strata->id)->first();
        $commercial = Commercial::where('file_id', $file->id)->where('strata_id', $strata->id)->first();
        $facility = Facility::where('file_id', $file->id)->where('strata_id', $strata->id)->first();
        $image = OtherDetails::where('file_id', $file->id)->first();

        $city = City::where('is_active', 1)->where('is_deleted', 0)->orderBy('description', 'asc')->get();
        $country = Country::where('is_active', 1)->where('is_deleted', 0)->orderBy('name', 'asc')->get();
        $state = State::where('is_active', 1)->where('is_deleted', 0)->orderBy('name', 'asc')->get();
        $parliament = Parliment::where('is_active', 1)->where('is_deleted', 0)->orderBy('description', 'asc')->get();

        if ($strata->dun != 0) {
            $dun = Dun::where('parliament', $strata->parliament)->where('is_active', 1)->where('is_deleted', 0)->orderBy('description', 'asc')->get();
        } else {
            $dun = Dun::where('is_active', 1)->where('is_deleted', 0)->orderBy('description', 'asc')->get();
        }
        if ($strata->park != 0) {
            $park = Park::where('dun', $strata->dun)->where('is_active', 1)->where('is_deleted', 0)->orderBy('description', 'asc')->get();
        } else {
            $park = Park::where('is_active', 1)->where('is_deleted', 0)->orderBy('description', 'asc')->get();
        }
        $area = Area::where('is_active', 1)->where('is_deleted', 0)->orderBy('description', 'asc')->get();
        $unit = UnitMeasure::where('is_active', 1)->where('is_deleted', 0)->orderBy('description', 'asc')->get();
        $land_title = LandTitle::where('is_active', 1)->where('is_deleted', 0)->orderBy('description', 'asc')->get();
        $category = Category::where('is_active', 1)->where('is_deleted', 0)->orderBy('description', 'asc')->get();
        $perimeter = Perimeter::where('is_active', 1)->where('is_deleted', 0)->orderBy('description_en', 'asc')->get();
        $unitoption = UnitOption::where('is_active', 1)->where('is_deleted', 0)->orderBy('description', 'asc')->get();
        $designation = Designation::where('is_active', 1)->where('is_deleted', 0)->orderBy('description', 'asc')->get();

        if (Session::get('lang') == "en") {
            $viewData = array(
                'title' => 'Update COB File',
                'panel_nav_active' => 'cob_panel',
                'main_nav_active' => 'cob_main',
                'sub_nav_active' => 'cob_list',
                'user_permission' => $user_permission,
                'strata' => $strata,
                'city' => $city,
                'country' => $country,
                'state' => $state,
                'parliament' => $parliament,
                'dun' => $dun,
                'park' => $park,
                'area' => $area,
                'unit' => $unit,
                'land_title' => $land_title,
                'category' => $category,
                'perimeter' => $perimeter,
                'facility' => $facility,
                'file' => $file,
                'unitoption' => $unitoption,
                'residential' => $residential,
                'commercial' => $commercial,
                'designation' => $designation,
                'image' => $image->image_url
            );

            return View::make('page_en.view_strata', $viewData);
        } else {
            $viewData = array(
                'title' => 'Edit Fail COB',
                'panel_nav_active' => 'cob_panel',
                'main_nav_active' => 'cob_main',
                'sub_nav_active' => 'cob_list',
                'user_permission' => $user_permission,
                'strata' => $strata,
                'city' => $city,
                'country' => $country,
                'state' => $state,
                'parliament' => $parliament,
                'dun' => $dun,
                'park' => $park,
                'area' => $area,
                'unit' => $unit,
                'land_title' => $land_title,
                'category' => $category,
                'perimeter' => $perimeter,
                'facility' => $facility,
                'file' => $file,
                'unitoption' => $unitoption,
                'residential' => $residential,
                'commercial' => $commercial,
                'designation' => $designation,
                'image' => $image->image_url
            );

            return View::make('page_my.view_strata', $viewData);
        }
    }

    public function strata($id) {
        //get user permission
        $user_permission = AccessGroup::getAccessPermission(Auth::user()->id);
        $file = Files::find($id);
        $strata = Strata::where('file_id', $file->id)->first();
        $residential = Residential::where('file_id', $file->id)->where('strata_id', $strata->id)->first();
        $commercial = Commercial::where('file_id', $file->id)->where('strata_id', $strata->id)->first();
        $facility = Facility::where('file_id', $file->id)->where('strata_id', $strata->id)->first();
        $image = OtherDetails::where('file_id', $file->id)->first();

        $city = City::where('is_active', 1)->where('is_deleted', 0)->orderBy('description', 'asc')->get();
        $country = Country::where('is_active', 1)->where('is_deleted', 0)->orderBy('name', 'asc')->get();
        $state = State::where('is_active', 1)->where('is_deleted', 0)->orderBy('name', 'asc')->get();
        $parliament = Parliment::where('is_active', 1)->where('is_deleted', 0)->orderBy('description', 'asc')->get();

        if ($strata->dun != 0) {
            $dun = Dun::where('parliament', $strata->parliament)->where('is_active', 1)->where('is_deleted', 0)->orderBy('description', 'asc')->get();
        } else {
            $dun = Dun::where('is_active', 1)->where('is_deleted', 0)->orderBy('description', 'asc')->get();
        }
        if ($strata->park != 0) {
            $park = Park::where('dun', $strata->dun)->where('is_active', 1)->where('is_deleted', 0)->orderBy('description', 'asc')->get();
        } else {
            $park = Park::where('is_active', 1)->where('is_deleted', 0)->orderBy('description', 'asc')->get();
        }
        $area = Area::where('is_active', 1)->where('is_deleted', 0)->orderBy('description', 'asc')->get();
        $unit = UnitMeasure::where('is_active', 1)->where('is_deleted', 0)->orderBy('description', 'asc')->get();
        $land_title = LandTitle::where('is_active', 1)->where('is_deleted', 0)->orderBy('description', 'asc')->get();
        $category = Category::where('is_active', 1)->where('is_deleted', 0)->orderBy('description', 'asc')->get();
        $perimeter = Perimeter::where('is_active', 1)->where('is_deleted', 0)->orderBy('description_en', 'asc')->get();
        $unitoption = UnitOption::where('is_active', 1)->where('is_deleted', 0)->orderBy('description', 'asc')->get();
        $designation = Designation::where('is_active', 1)->where('is_deleted', 0)->orderBy('description', 'asc')->get();

        if (Session::get('lang') == "en") {
            $viewData = array(
                'title' => 'Update COB File',
                'panel_nav_active' => 'cob_panel',
                'main_nav_active' => 'cob_main',
                'sub_nav_active' => 'cob_list',
                'user_permission' => $user_permission,
                'strata' => $strata,
                'city' => $city,
                'country' => $country,
                'state' => $state,
                'parliament' => $parliament,
                'dun' => $dun,
                'park' => $park,
                'area' => $area,
                'unit' => $unit,
                'land_title' => $land_title,
                'category' => $category,
                'perimeter' => $perimeter,
                'facility' => $facility,
                'file' => $file,
                'unitoption' => $unitoption,
                'residential' => $residential,
                'commercial' => $commercial,
                'designation' => $designation,
                'image' => $image->image_url
            );

            return View::make('page_en.update_strata', $viewData);
        } else {
            $viewData = array(
                'title' => 'Edit Fail COB',
                'panel_nav_active' => 'cob_panel',
                'main_nav_active' => 'cob_main',
                'sub_nav_active' => 'cob_list',
                'user_permission' => $user_permission,
                'strata' => $strata,
                'city' => $city,
                'country' => $country,
                'state' => $state,
                'parliament' => $parliament,
                'dun' => $dun,
                'park' => $park,
                'area' => $area,
                'unit' => $unit,
                'land_title' => $land_title,
                'category' => $category,
                'perimeter' => $perimeter,
                'facility' => $facility,
                'file' => $file,
                'unitoption' => $unitoption,
                'residential' => $residential,
                'commercial' => $commercial,
                'designation' => $designation,
                'image' => $image->image_url
            );

            return View::make('page_my.update_strata', $viewData);
        }
    }

    public function findDUN() {
        $data = Input::all();
        if (Request::ajax()) {

            $parliament_id = $data['parliament_id'];
            $dun = Dun::where('is_deleted', 0)->where('parliament', $parliament_id)->orderBy('description', 'asc')->get();
            if (count($dun) > 0) {
                if (Session::get('lang') == "en") {
                    $result = "<option value=''>Please Select</option>";
                } else {
                    $result = "<option value=''>Sila pilih</option>";
                }

                foreach ($dun as $duns) {
                    $result .= "<option value='" . $duns->id . "'>" . $duns->description . "</option>";
                }

                print $result;
            } else {
                if (Session::get('lang') == "en") {
                    print "<option value=''>Please Select</option>";
                } else {
                    print "<option value=''>Sila pilih</option>";
                }
            }
        }
    }

    public function findPark() {
        $data = Input::all();
        if (Request::ajax()) {

            $dun_id = $data['dun_id'];
            $park = Park::where('is_deleted', 0)->where('dun', $dun_id)->orderBy('description', 'asc')->get();
            if (count($park) > 0) {
                if (Session::get('lang') == "en") {
                    $result = "<option value=''>Please Select</option>";
                } else {
                    $result = "<option value=''>Sila pilih</option>";
                }

                foreach ($park as $parks) {
                    $result .= "<option value='" . $parks->id . "'>" . $parks->description . "</option>";
                }
                print $result;
            } else {
                if (Session::get('lang') == "en") {
                    print "<option value=''>Please Select</option>";
                } else {
                    print "<option value=''>Sila pilih</option>";
                }
            }
        }
    }

    public function submitUpdateStrata() {
        $data = Input::all();
        if (Request::ajax()) {

            $strata_id = $data['strata_id'];
            $file_id = $data['file_id'];
            $facility_id = $data['facility_id'];
            $name = $data['strata_name'];
            $parliament = $data['strata_parliament'];
            $dun = $data['strata_dun'];
            $park = $data['strata_park'];
            $address1 = $data['strata_address1'];
            $address2 = $data['strata_address2'];
            $address3 = $data['strata_address3'];
            $city = $data['strata_city'];
            $poscode = $data['strata_poscode'];
            $state = $data['strata_state'];
            $country = $data['strata_country'];
            $block_no = $data['strata_block_no'];
            $ownership_no = $data['strata_ownership_no'];
            $town = $data['strata_town'];
            $land_area = $data['strata_land_area'];
            $land_area_unit = $data['strata_land_area_unit'];
            $lot_no = $data['strata_lot_no'];
            $date = $data['strata_date'];
            $land_title = $data['strata_land_title'];
            $category = $data['strata_category'];
            $perimeter = $data['strata_perimeter'];
            $area = $data['strata_area'];
            $is_residential = $data['is_residential'];
            $is_commercial = $data['is_commercial'];
            $stratafile = $data['strata_file_url'];

            $strata = Strata::find($strata_id);
            $strata->name = $name;
            $strata->parliament = $parliament;
            $strata->dun = $dun;
            $strata->park = $park;
            $strata->address1 = $address1;
            $strata->address2 = $address2;
            $strata->address3 = $address3;
            $strata->city = $city;
            $strata->poscode = $poscode;
            $strata->state = $state;
            $strata->country = $country;
            $strata->block_no = $block_no;
            $strata->ownership_no = $ownership_no;
            $strata->town = $town;
            $strata->land_area = $land_area;
            $strata->land_area_unit = $land_area_unit;
            $strata->lot_no = $lot_no;
            $strata->date = $date;
            $strata->land_title = $land_title;
            $strata->category = $category;
            $strata->perimeter = $perimeter;
            $strata->area = $area;
            $strata->file_url = $stratafile;
            $strata->is_residential = $is_residential;
            $strata->is_commercial = $is_commercial;
            $success = $strata->save();

            if ($success) {
                //residential               
                $residential_unit_no = $data['residential_unit_no'];
                $residential_maintenance_fee = $data['residential_maintenance_fee'];
                $residential_maintenance_fee_option = $data['residential_maintenance_fee_option'];
                $residential_sinking_fund = $data['residential_sinking_fund'];
                $residential_sinking_fund_option = $data['residential_sinking_fund_option'];

                //commercial                          
                $commercial_unit_no = $data['commercial_unit_no'];
                $commercial_maintenance_fee = $data['commercial_maintenance_fee'];
                $commercial_maintenance_fee_option = $data['commercial_maintenance_fee_option'];
                $commercial_sinking_fund = $data['commercial_sinking_fund'];
                $commercial_sinking_fund_option = $data['commercial_sinking_fund_option'];

                //facility
                $management_office = $data['management_office'];
                $swimming_pool = $data['swimming_pool'];
                $surau = $data['surau'];
                $multipurpose_hall = $data['multipurpose_hall'];
                $gym = $data['gym'];
                $playground = $data['playground'];
                $guardhouse = $data['guardhouse'];
                $kindergarten = $data['kindergarten'];
                $open_space = $data['open_space'];
                $lift = $data['lift'];
                $rubbish_room = $data['rubbish_room'];
                $gated = $data['gated'];
                $others = $data['others'];

                $residential_old = Residential::where('file_id', $file_id)->where('strata_id', $strata->id)->first();
                if ($strata->is_residential == 1) {
                    if (count($residential_old) > 0) {
                        $residential_old->delete();
                    }
                    $residential = new Residential();
                    $residential->file_id = $file_id;
                    $residential->strata_id = $strata->id;
                    $residential->unit_no = $residential_unit_no;
                    $residential->maintenance_fee = $residential_maintenance_fee;
                    $residential->maintenance_fee_option = $residential_maintenance_fee_option;
                    $residential->sinking_fund = $residential_sinking_fund;
                    $residential->sinking_fund_option = $residential_sinking_fund_option;
                    $residential->save();
                } else {
                    if (count($residential_old) > 0) {
                        $residential_old->delete();
                    }
                }

                $commercial_old = Commercial::where('file_id', $file_id)->where('strata_id', $strata->id)->first();
                if ($strata->is_commercial == 1) {
                    if (count($commercial_old) > 0) {
                        $commercial_old->delete();
                    }
                    $commercial = new Commercial();
                    $commercial->file_id = $file_id;
                    $commercial->strata_id = $strata->id;
                    $commercial->unit_no = $commercial_unit_no;
                    $commercial->maintenance_fee = $commercial_maintenance_fee;
                    $commercial->maintenance_fee_option = $commercial_maintenance_fee_option;
                    $commercial->sinking_fund = $commercial_sinking_fund;
                    $commercial->sinking_fund_option = $commercial_sinking_fund_option;
                    $commercial->save();
                } else {
                    if (count($commercial_old) > 0) {
                        $commercial_old->delete();
                    }
                }
            }

            $facility = Facility::find($facility_id);
            $facility->management_office = $management_office;
            $facility->swimming_pool = $swimming_pool;
            $facility->surau = $surau;
            $facility->multipurpose_hall = $multipurpose_hall;
            $facility->gym = $gym;
            $facility->playground = $playground;
            $facility->guardhouse = $guardhouse;
            $facility->kindergarten = $kindergarten;
            $facility->open_space = $open_space;
            $facility->lift = $lift;
            $facility->rubbish_room = $rubbish_room;
            $facility->gated = $gated;
            $facility->others = $others;
            $saved = $facility->save();

            if ($saved) {
                # Audit Trail
                $file_name = Files::find($strata->file_id);
                $remarks = 'Strata Info (' . $file_name->file_no . ') has been updated.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "COB File";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                return "true";
            } else {
                return "false";
            }
        } else {
            print "false";
        }
    }

    public function deleteStrataFile() {
        $data = Input::all();
        if (Request::ajax()) {

            $id = $data['id'];

            $strata = Strata::find($id);
            $strata->file_url = "";
            $deleted = $strata->save();
            if ($deleted) {
                # Audit Trail
                $file_name = Files::find($strata->file_id);
                $remarks = 'Strata Info (' . $file_name->file_no . ') has been deleted.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "COB File";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    public function viewManagement($id) {
        //get user permission
        $user_permission = AccessGroup::getAccessPermission(Auth::user()->id);
        $file = Files::find($id);
        $management = Management::where('file_id', $file->id)->first();
        $management_jmb = ManagementJMB::where('management_id', $management->id)->where('file_id', $file->id)->first();
        $management_mc = ManagementMC::where('management_id', $management->id)->where('file_id', $file->id)->first();
        $management_agent = ManagementAgent::where('management_id', $management->id)->where('file_id', $file->id)->first();
        $management_others = ManagementOthers::where('management_id', $management->id)->where('file_id', $file->id)->first();
        $image = OtherDetails::where('file_id', $file->id)->first();

        $city = City::where('is_active', 1)->where('is_deleted', 0)->orderBy('description', 'asc')->get();
        $country = Country::where('is_active', 1)->where('is_deleted', 0)->orderBy('name', 'asc')->get();
        $state = State::where('is_active', 1)->where('is_deleted', 0)->orderBy('name', 'asc')->get();
        $agent = Agent::where('is_active', 1)->where('is_deleted', 0)->orderBy('name', 'asc')->get();

        if (Session::get('lang') == "en") {
            $viewData = array(
                'title' => 'Update COB File',
                'panel_nav_active' => 'cob_panel',
                'main_nav_active' => 'cob_main',
                'sub_nav_active' => 'cob_list',
                'user_permission' => $user_permission,
                'city' => $city,
                'country' => $country,
                'state' => $state,
                'file' => $file,
                'agent' => $agent,
                'management' => $management,
                'management_jmb' => $management_jmb,
                'management_mc' => $management_mc,
                'management_agent' => $management_agent,
                'management_others' => $management_others,
                'image' => $image->image_url
            );

            return View::make('page_en.view_management', $viewData);
        } else {
            $viewData = array(
                'title' => 'Edit Fail COB',
                'panel_nav_active' => 'cob_panel',
                'main_nav_active' => 'cob_main',
                'sub_nav_active' => 'cob_list',
                'user_permission' => $user_permission,
                'city' => $city,
                'country' => $country,
                'state' => $state,
                'file' => $file,
                'agent' => $agent,
                'management' => $management,
                'management_jmb' => $management_jmb,
                'management_mc' => $management_mc,
                'management_agent' => $management_agent,
                'management_others' => $management_others,
                'image' => $image->image_url
            );

            return View::make('page_my.view_management', $viewData);
        }
    }

    public function management($id) {
        //get user permission
        $user_permission = AccessGroup::getAccessPermission(Auth::user()->id);
        $file = Files::find($id);
        $management = Management::where('file_id', $file->id)->first();
        $management_jmb = ManagementJMB::where('management_id', $management->id)->where('file_id', $file->id)->first();
        $management_mc = ManagementMC::where('management_id', $management->id)->where('file_id', $file->id)->first();
        $management_agent = ManagementAgent::where('management_id', $management->id)->where('file_id', $file->id)->first();
        $management_others = ManagementOthers::where('management_id', $management->id)->where('file_id', $file->id)->first();
        $image = OtherDetails::where('file_id', $file->id)->first();

        $city = City::where('is_active', 1)->where('is_deleted', 0)->orderBy('description', 'asc')->get();
        $country = Country::where('is_active', 1)->where('is_deleted', 0)->orderBy('name', 'asc')->get();
        $state = State::where('is_active', 1)->where('is_deleted', 0)->orderBy('name', 'asc')->get();
        $agent = Agent::where('is_active', 1)->where('is_deleted', 0)->orderBy('name', 'asc')->get();

        if (Session::get('lang') == "en") {
            $viewData = array(
                'title' => 'Update COB File',
                'panel_nav_active' => 'cob_panel',
                'main_nav_active' => 'cob_main',
                'sub_nav_active' => 'cob_list',
                'user_permission' => $user_permission,
                'city' => $city,
                'country' => $country,
                'state' => $state,
                'file' => $file,
                'agent' => $agent,
                'management' => $management,
                'management_jmb' => $management_jmb,
                'management_mc' => $management_mc,
                'management_agent' => $management_agent,
                'management_others' => $management_others,
                'image' => $image->image_url
            );

            return View::make('page_en.update_management', $viewData);
        } else {
            $viewData = array(
                'title' => 'Edit Fail COB',
                'panel_nav_active' => 'cob_panel',
                'main_nav_active' => 'cob_main',
                'sub_nav_active' => 'cob_list',
                'user_permission' => $user_permission,
                'city' => $city,
                'country' => $country,
                'state' => $state,
                'file' => $file,
                'agent' => $agent,
                'management' => $management,
                'management_jmb' => $management_jmb,
                'management_mc' => $management_mc,
                'management_agent' => $management_agent,
                'management_others' => $management_others,
                'image' => $image->image_url
            );

            return View::make('page_my.update_management', $viewData);
        }
    }

    public function submitUpdateManagement() {
        $data = Input::all();
        if (Request::ajax()) {

            //jmb
            $is_jmb = $data['is_jmb'];
            $jmb_date_formed = $data['jmb_date_formed'];
            $jmb_certificate_no = $data['jmb_certificate_no'];
            $jmb_name = $data['jmb_name'];
            $jmb_address1 = $data['jmb_address1'];
            $jmb_address2 = $data['jmb_address2'];
            $jmb_address3 = $data['jmb_address3'];
            $jmb_city = $data['jmb_city'];
            $jmb_poscode = $data['jmb_poscode'];
            $jmb_state = $data['jmb_state'];
            $jmb_country = $data['jmb_country'];
            $jmb_phone_no = $data['jmb_phone_no'];
            $jmb_fax_no = $data['jmb_fax_no'];
            //mc
            $is_mc = $data['is_mc'];
            $mc_date_formed = $data['mc_date_formed'];
            $mc_first_agm = $data['mc_first_agm'];
            $mc_name = $data['mc_name'];
            $mc_address1 = $data['mc_address1'];
            $mc_address2 = $data['mc_address2'];
            $mc_address3 = $data['mc_address3'];
            $mc_city = $data['mc_city'];
            $mc_poscode = $data['mc_poscode'];
            $mc_state = $data['mc_state'];
            $mc_country = $data['mc_country'];
            $mc_phone_no = $data['mc_phone_no'];
            $mc_fax_no = $data['mc_fax_no'];
            //agent
            $is_agent = $data['is_agent'];
            $agent_selected_by = $data['agent_selected_by'];
            $agent_name = $data['agent_name'];
            $agent_address1 = $data['agent_address1'];
            $agent_address2 = $data['agent_address2'];
            $agent_address3 = $data['agent_address3'];
            $agent_city = $data['agent_city'];
            $agent_poscode = $data['agent_poscode'];
            $agent_state = $data['agent_state'];
            $agent_country = $data['agent_country'];
            $agent_phone_no = $data['agent_phone_no'];
            $agent_fax_no = $data['agent_fax_no'];
            //agent
            $is_others = $data['is_others'];
            $others_name = $data['others_name'];
            $others_address1 = $data['others_address1'];
            $others_address2 = $data['others_address2'];
            $others_address3 = $data['others_address3'];
            $others_city = $data['others_city'];
            $others_poscode = $data['others_poscode'];
            $others_state = $data['others_state'];
            $others_country = $data['others_country'];
            $others_phone_no = $data['others_phone_no'];
            $others_fax_no = $data['others_fax_no'];
            //id
            $file_id = $data['file_id'];
            $management_id = $data['management_id'];

            $management = Management::find($management_id);
            $management->is_jmb = $is_jmb;
            $management->is_mc = $is_mc;
            $management->is_agent = $is_agent;
            $management->is_others = $is_others;
            $success1 = $management->save();

            if ($success1) {
                $jmb_old = ManagementJMB::where('file_id', $file_id)->where('management_id', $management->id)->first();
                $mc_old = ManagementMC::where('file_id', $file_id)->where('management_id', $management->id)->first();
                $agent_old = ManagementAgent::where('file_id', $file_id)->where('management_id', $management->id)->first();
                $others_old = ManagementOthers::where('file_id', $file_id)->where('management_id', $management->id)->first();

                if ($management->is_jmb == 1) {
                    if (count($jmb_old) > 0) {
                        $jmb_old->delete();
                    }
                    $new_jmb = new ManagementJMB();
                    $new_jmb->file_id = $file_id;
                    $new_jmb->management_id = $management->id;
                    $new_jmb->date_formed = $jmb_date_formed;
                    $new_jmb->certificate_no = $jmb_certificate_no;
                    $new_jmb->name = $jmb_name;
                    $new_jmb->address1 = $jmb_address1;
                    $new_jmb->address2 = $jmb_address2;
                    $new_jmb->address3 = $jmb_address3;
                    $new_jmb->city = $jmb_city;
                    $new_jmb->poscode = $jmb_poscode;
                    $new_jmb->state = $jmb_state;
                    $new_jmb->country = $jmb_country;
                    $new_jmb->phone_no = $jmb_phone_no;
                    $new_jmb->fax_no = $jmb_fax_no;
                    $new_jmb->save();
                } else {
                    if (count($jmb_old) > 0) {
                        $jmb_old->delete();
                    }
                }

                if ($management->is_mc == 1) {
                    if (count($mc_old) > 0) {
                        $mc_old->delete();
                    }
                    $new_mc = new ManagementMC();
                    $new_mc->file_id = $file_id;
                    $new_mc->management_id = $management->id;
                    $new_mc->date_formed = $mc_date_formed;
                    $new_mc->first_agm = $mc_first_agm;
                    $new_mc->name = $mc_name;
                    $new_mc->address1 = $mc_address1;
                    $new_mc->address2 = $mc_address2;
                    $new_mc->address3 = $mc_address3;
                    $new_mc->city = $mc_city;
                    $new_mc->poscode = $mc_poscode;
                    $new_mc->state = $mc_state;
                    $new_mc->country = $mc_country;
                    $new_mc->phone_no = $mc_phone_no;
                    $new_mc->fax_no = $mc_fax_no;
                    $new_mc->save();
                } else {
                    if (count($mc_old) > 0) {
                        $mc_old->delete();
                    }
                }

                if ($management->is_agent == 1) {
                    if (count($agent_old) > 0) {
                        $agent_old->delete();
                    }
                    $new_agent = new ManagementAgent();
                    $new_agent->file_id = $file_id;
                    $new_agent->management_id = $management->id;
                    $new_agent->selected_by = $agent_selected_by;
                    $new_agent->agent = $agent_name;
                    $new_agent->address1 = $agent_address1;
                    $new_agent->address2 = $agent_address2;
                    $new_agent->address3 = $agent_address3;
                    $new_agent->city = $agent_city;
                    $new_agent->poscode = $agent_poscode;
                    $new_agent->state = $agent_state;
                    $new_agent->country = $agent_country;
                    $new_agent->phone_no = $agent_phone_no;
                    $new_agent->fax_no = $agent_fax_no;
                    $new_agent->save();
                } else {
                    if (count($agent_old) > 0) {
                        $agent_old->delete();
                    }
                }

                if ($management->is_others == 1) {
                    if (count($others_old) > 0) {
                        $others_old->delete();
                    }
                    $new_others = new ManagementOthers();
                    $new_others->file_id = $file_id;
                    $new_others->management_id = $management->id;
                    $new_others->name = $others_name;
                    $new_others->address1 = $others_address1;
                    $new_others->address2 = $others_address2;
                    $new_others->address3 = $others_address3;
                    $new_others->city = $others_city;
                    $new_others->poscode = $others_poscode;
                    $new_others->state = $others_state;
                    $new_others->country = $others_country;
                    $new_others->phone_no = $others_phone_no;
                    $new_others->fax_no = $others_fax_no;
                    $new_others->save();
                } else {
                    if (count($others_old) > 0) {
                        $others_old->delete();
                    }
                }
                # Audit Trail
                $file_name = Files::find($management->file_id);
                $remarks = 'Management Info (' . $file_name->file_no . ') has been updated.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "COB File";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                return "true";
            } else {
                print "false";
            }
        }
    }

    public function viewMonitoring($id) {
        //get user permission
        $user_permission = AccessGroup::getAccessPermission(Auth::user()->id);
        $file = Files::find($id);
        $monitoring = Monitoring::where('file_id', $file->id)->first();
        $designation = Designation::where('is_active', 1)->where('is_deleted', 0)->orderBy('description', 'asc')->get();
        $image = OtherDetails::where('file_id', $file->id)->first();

        if (Session::get('lang') == "en") {
            $viewData = array(
                'title' => 'Update COB File',
                'panel_nav_active' => 'cob_panel',
                'main_nav_active' => 'cob_main',
                'sub_nav_active' => 'cob_list',
                'user_permission' => $user_permission,
                'file' => $file,
                'designation' => $designation,
                'monitoring' => $monitoring,
                'image' => $image->image_url
            );

            return View::make('page_en.view_monitoring', $viewData);
        } else {
            $viewData = array(
                'title' => 'Edit Fail COB',
                'panel_nav_active' => 'cob_panel',
                'main_nav_active' => 'cob_main',
                'sub_nav_active' => 'cob_list',
                'user_permission' => $user_permission,
                'file' => $file,
                'designation' => $designation,
                'monitoring' => $monitoring,
                'image' => $image->image_url
            );

            return View::make('page_my.view_monitoring', $viewData);
        }
    }

    public function monitoring($id) {
        //get user permission
        $user_permission = AccessGroup::getAccessPermission(Auth::user()->id);
        $file = Files::find($id);
        $monitoring = Monitoring::where('file_id', $file->id)->first();
        $designation = Designation::where('is_active', 1)->where('is_deleted', 0)->orderBy('description', 'asc')->get();
        $image = OtherDetails::where('file_id', $file->id)->first();

        if (Session::get('lang') == "en") {
            $viewData = array(
                'title' => 'Update COB File',
                'panel_nav_active' => 'cob_panel',
                'main_nav_active' => 'cob_main',
                'sub_nav_active' => 'cob_list',
                'user_permission' => $user_permission,
                'file' => $file,
                'designation' => $designation,
                'monitoring' => $monitoring,
                'image' => $image->image_url
            );

            return View::make('page_en.update_monitoring', $viewData);
        } else {
            $viewData = array(
                'title' => 'Edit Fail COB',
                'panel_nav_active' => 'cob_panel',
                'main_nav_active' => 'cob_main',
                'sub_nav_active' => 'cob_list',
                'user_permission' => $user_permission,
                'file' => $file,
                'designation' => $designation,
                'monitoring' => $monitoring,
                'image' => $image->image_url
            );

            return View::make('page_my.update_monitoring', $viewData);
        }
    }

    public function submitUpdateMonitoring() {
        $data = Input::all();
        if (Request::ajax()) {
            $id = $data['id'];
            $precalculate_plan = $data['precalculate_plan'];
            $buyer_registration = $data['buyer_registration'];
            $certificate_series_no = $data['certificate_series_no'];
            $monitoring_remarks = $data['monitoring_remarks'];

            $monitor = Monitoring::find($id);
            $monitor->pre_calculate = $precalculate_plan;
            $monitor->buyer_registration = $buyer_registration;
            $monitor->certificate_no = $certificate_series_no;
            $monitor->remarks = $monitoring_remarks;
            $success = $monitor->save();

            if ($success) {
                # Audit Trail
                $file_name = Files::find($monitor->file_id);
                $remarks = 'Monitoring Info (' . $file_name->file_no . ') has been updated.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "COB File";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    public function addAGMDetails() {
        $data = Input::all();
        if (Request::ajax()) {

            $file_id = $data['file_id'];
            $agm_date = $data['agm_date'];
            $agm = $data['agm'];
            $egm = $data['egm'];
            $minit_meeting = $data['minit_meeting'];
            $jmc_copy = $data['jmc_copy'];
            $ic_list = $data['ic_list'];
            $attendance_list = $data['attendance_list'];
            $audited_financial_report = $data['audited_financial_report'];
            $audit_report = $data['audit_report'];
            $audit_start = $data['audit_start'];
            $audit_end = $data['audit_end'];
            $audit_report_file_url = $data['audit_report_file_url'];
            $letter_integrity_url = $data['letter_integrity_url'];
            $letter_bankruptcy_url = $data['letter_bankruptcy_url'];

            $agm_detail = new MeetingDocument();
            $agm_detail->file_id = $file_id;
            $agm_detail->agm_date = $agm_date;
            $agm_detail->agm = $agm;
            $agm_detail->egm = $egm;
            $agm_detail->minit_meeting = $minit_meeting;
            $agm_detail->jmc_spa = $jmc_copy;
            $agm_detail->identity_card = $ic_list;
            $agm_detail->attendance = $attendance_list;
            $agm_detail->financial_report = $audited_financial_report;
            $agm_detail->audit_report = $audit_report;
            $agm_detail->audit_start_date = $audit_start;
            $agm_detail->audit_end_date = $audit_end;
            $agm_detail->audit_report_url = $audit_report_file_url;
            $agm_detail->letter_integrity_url = $letter_integrity_url;
            $agm_detail->letter_bankruptcy_url = $letter_bankruptcy_url;
            $success = $agm_detail->save();

            if ($success) {
                # Audit Trail
                $file_name = Files::find($agm_detail->file_id);
                $remarks = 'AGM Details (' . $file_name->file_no . ')' . ' dated ' . date('d/m/Y', strtotime($agm_detail->agm_date)) . ' has been inserted.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "COB File";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    public function editAGMDetails() {
        $data = Input::all();
        if (Request::ajax()) {

            $id = $data['id'];
            $agm_date = $data['agm_date'];
            $agm = $data['agm'];
            $egm = $data['egm'];
            $minit_meeting = $data['minit_meeting'];
            $jmc_copy = $data['jmc_copy'];
            $ic_list = $data['ic_list'];
            $attendance_list = $data['attendance_list'];
            $audited_financial_report = $data['audited_financial_report'];
            $audit_report = $data['audit_report'];
            $audit_start = $data['audit_start'];
            $audit_end = $data['audit_end'];
            $audit_report_file_url = $data['audit_report_file_url'];
            $letter_integrity_url = $data['letter_integrity_url'];
            $letter_bankruptcy_url = $data['letter_bankruptcy_url'];


            $agm_detail = MeetingDocument::find($id);
            $agm_detail->agm_date = $agm_date;
            $agm_detail->agm = $agm;
            $agm_detail->egm = $egm;
            $agm_detail->minit_meeting = $minit_meeting;
            $agm_detail->jmc_spa = $jmc_copy;
            $agm_detail->identity_card = $ic_list;
            $agm_detail->attendance = $attendance_list;
            $agm_detail->financial_report = $audited_financial_report;
            $agm_detail->audit_report = $audit_report;
            $agm_detail->audit_start_date = $audit_start;
            $agm_detail->audit_end_date = $audit_end;
            $agm_detail->audit_report_url = $audit_report_file_url;
            $agm_detail->letter_integrity_url = $letter_integrity_url;
            $agm_detail->letter_bankruptcy_url = $letter_bankruptcy_url;
            $success = $agm_detail->save();

            if ($success) {
                # Audit Trail
                $file_name = Files::find($agm_detail->file_id);
                $remarks = 'AGM Details (' . $file_name->file_no . ')' . ' dated ' . date('d/m/Y', strtotime($agm_detail->agm_date)) . ' has been updated.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "COB File";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    public function getAGMDetails() {
        $data = Input::all();
        if (Request::ajax()) {

            $result = "";
            $id = $data['id'];

            $agm = MeetingDocument::find($id);

            if (count($agm) > 0) {
                $result .= '<form>';
                if (Session::get('lang') == "en") {
                    $result .= '<div class="form-group row">';
                    $result .= '<div class="col-md-6"><label class="form-control-label">Anual General Meeting (AGM)</label></div>';
                    if ($agm->agm == 1) {
                        $result .= '<div class="col-md-2"><input type="radio" class="agm_edit" id="agm_edit" name="agm_edit" value="1" checked> Yes</div>';
                        $result .= '<div class="col-md-2"><input type="radio" class="agm_edit" id="agm_edit" name="agm_edit" value="0"> No</div>';
                    } else {
                        $result .= '<div class="col-md-2"><input type="radio" class="agm_edit" id="agm_edit" name="agm_edit" value="1"> Yes</div>';
                        $result .= '<div class="col-md-2"><input type="radio" class="agm_edit" id="agm_edit" name="agm_edit" value="0" checked> No</div>';
                    }
                    $result .= '</div>';

                    $result .= '<div class="form-group row">';
                    $result .= '<div class="col-md-6"><label class="form-control-label">Extraordinary General Meeting (EGM)</label></div>';
                    if ($agm->egm == 1) {
                        $result .= '<div class="col-md-2"><input type="radio" id="egm_edit" name="egm_edit" value="1" checked> Yes</div>';
                        $result .= '<div class="col-md-2"><input type="radio" id="egm_edit" name="egm_edit" value="0"> No</div>';
                    } else {
                        $result .= '<div class="col-md-2"><input type="radio" id="egm_edit" name="egm_edit" value="1"> Yes</div>';
                        $result .= '<div class="col-md-2"><input type="radio" id="egm_edit" name="egm_edit" value="0" checked> No</div>';
                    }
                    $result .= '</div>';

                    $result .= '<div class="form-group row">';
                    $result .= '<div class="col-md-6"><label class="form-control-label">Minit Meeting</label></div>';
                    if ($agm->minit_meeting == 1) {
                        $result .= '<div class="col-md-2"><input type="radio" id="minit_meeting_edit" name="minit_meeting_edit" value="1" checked> Yes</div>';
                        $result .= '<div class="col-md-2"><input type="radio" id="minit_meeting_edit" name="minit_meeting_edit" value="0"> No</div>';
                    } else {
                        $result .= '<div class="col-md-2"><input type="radio" id="minit_meeting_edit" name="minit_meeting_edit" value="1"> Yes</div>';
                        $result .= '<div class="col-md-2"><input type="radio" id="minit_meeting_edit" name="minit_meeting_edit" value="0" checked> No</div>';
                    }
                    $result .= '</div>';

                    $result .= '<div class="form-group row">';
                    $result .= '<div class="col-md-6"><label class="form-control-label">JMC SPA Copy</label></div>';
                    if ($agm->jmc_spa == 1) {
                        $result .= '<div class="col-md-2"><input type="radio" id="jmc_copy_edit" name="jmc_copy_edit" value="1" checked>Yes</div>';
                        $result .= '<div class="col-md-2"><input type="radio" id="jmc_copy_edit" name="jmc_copy_edit" value="0">No</div>';
                    } else {
                        $result .= '<div class="col-md-2"><input type="radio" id="jmc_copy_edit" name="jmc_copy_edit" value="1">Yes</div>';
                        $result .= '<div class="col-md-2"><input type="radio" id="jmc_copy_edit" name="jmc_copy_edit" value="0" checked>No</div>';
                    }
                    $result .= '</div>';

                    $result .= '<div class="form-group row">';
                    $result .= '<div class="col-md-6"><label class="form-control-label">Identity Card List</label></div>';
                    if ($agm->identity_card == 1) {
                        $result .= '<div class="col-md-2"><input type="radio" id="ic_list_edit" name="ic_list_edit" value="1" checked> Yes</div>';
                        $result .= '<div class="col-md-2"><input type="radio" id="ic_list_edit" name="ic_list_edit" value="0"> No</div>';
                    } else {
                        $result .= '<div class="col-md-2"><input type="radio" id="ic_list_edit" name="ic_list_edit" value="1"> Yes</div>';
                        $result .= '<div class="col-md-2"><input type="radio" id="ic_list_edit" name="ic_list_edit" value="0" checked> No</div>';
                    }
                    $result .= '</div>';


                    $result .= '<div class="form-group row">';
                    $result .= '<div class="col-md-6"><label class="form-control-label">Attendance List</label></div>';
                    if ($agm->attendance == 1) {
                        $result .= '<div class="col-md-2"><input type="radio" id="attendance_list_edit" name="attendance_list_edit" value="1" checked> Yes </div>';
                        $result .= '<div class="col-md-2"><input type="radio" id="attendance_list_edit" name="attendance_list_edit" value="0"> No </div>';
                    } else {
                        $result .= '<div class="col-md-2"><input type="radio" id="attendance_list_edit" name="attendance_list_edit" value="1"> Yes </div>';
                        $result .= '<div class="col-md-2"><input type="radio" id="attendance_list_edit" name="attendance_list_edit" value="0" checked> No </div>';
                    }
                    $result .= '</div>';

                    $result .= '<div class="form-group row">';
                    $result .= '<div class="col-md-6"><label class="form-control-label">Audited Financial Report</label></div>';
                    if ($agm->financial_report == 1) {
                        $result .= '<div class="col-md-2"><input type="radio" id="audited_financial_report_edit" name="audited_financial_report_edit" value="1" checked> Yes</div>';
                        $result .= '<div class="col-md-2"><input type="radio" id="audited_financial_report_edit" name="audited_financial_report_edit" value="0"> No</div>';
                    } else {
                        $result .= '<div class="col-md-2"><input type="radio" id="audited_financial_report_edit" name="audited_financial_report_edit" value="1"> Yes</div>';
                        $result .= '<div class="col-md-2"><input type="radio" id="audited_financial_report_edit" name="audited_financial_report_edit" value="0" checked> No</div>';
                    }
                    $result .= '</div>';

                    $result .= '<div class="form-group row">';
                    $result .= '<div class="col-md-6"><label class="form-control-label">Financial Audit Report</label></div>';
                    $result .= '<div class="col-md-6"><input type="text" class="form-control" placeholder="Financial Audit Report" id="audit_report_edit" value=' . "$agm->audit_report" . '></div>';
                    $result .= '</div>';

                    $result .= '</form>';

                    $result .= '<form id="upload_audit_report_file_edit" enctype="multipart/form-data" method="post" action="' . url("uploadAuditReportFileEdit") . '" autocomplete="off">';
                    $result .= '<div class="form-group row">';
                    $result .= '<div class="col-md-6"><label class="form-control-label">&nbsp;</label></div>';
                    $result .= '<div class="col-md-6">';
                    $result .= '<button type="button" id="clear_audit_report_file_edit" class="btn btn-xs btn-danger" onclick="clearAuditFileEdit()" style="display: none;"><i class="fa fa-times"></i></button>&nbsp;';
                    $result .= '<input type="file" name="audit_report_file_edit" id="audit_report_file_edit">';
                    $result .= '<div id="validation-errors_audit_report_file_edit"></div><div id="view_audit_report_file_edit"></div>';
                    if ($agm->audit_report_url != "") {
                        $result .= '<div id="report_edit"><a href="' . asset($agm->audit_report_url) . '" target="_blank"><button type="button" class="btn btn-xs btn-primary" data-toggle="tooltip" data-placement="bottom" title="Download File"><i class="icmn-file-download2"></i> Download</button></a>&nbsp;';
                        $result .= '<button type="button" class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="bottom" title="Delete File" onclick="deleteAuditReport(\'' . $agm->id . '\')"><i class="fa fa-times"></i></button></div>';
                    }
                    $result .= '</div>';
                    $result .= '</div>';
                    $result .= '</form>';

                    $result .= '<form id="upload_letter_integrity_edit" enctype="multipart/form-data" method="post" action="' . url("uploadLetterIntegrityEdit") . '" autocomplete="off">';
                    $result .= '<div class="form-group row">';
                    $result .= '<div class="col-md-6"><label class="form-control-label">Pledge letter of integrity JMC</label></div>';
                    $result .= '<div class="col-md-6">';
                    $result .= '<button type="button" id="clear_letter_integrity_edit" class="btn btn-xs btn-danger" onclick="clearLetterIntegrityEdit()" style="display: none;"><i class="fa fa-times"></i></button>&nbsp;';
                    $result .= '<input type="file" name="letter_integrity_edit" id="letter_integrity_edit">';
                    $result .= '<div id="validation-errors_letter_integrity_edit"></div>';
                    if ($agm->letter_integrity_url != "") {
                        $result .= '<div id="integrity_edit"><a href="' . asset($agm->letter_integrity_url) . '" target="_blank"><button type="button" class="btn btn-xs btn-primary" data-toggle="tooltip" data-placement="bottom" title="Download File"><i class="icmn-file-download2"></i> Download</button></a>&nbsp;';
                        $result .= '<button type="button" class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="bottom" title="Delete File" onclick="deleteLetterIntegrity(\'' . $agm->id . '\')"><i class="fa fa-times"></i></button></div>';
                    }
                    $result .= '</div>';
                    $result .= '</div>';
                    $result .= '</form>';

                    $result .= '<form id="upload_letter_bankruptcy_edit" enctype="multipart/form-data" method="post" action="' . url("uploadLetterBankruptcyEdit") . '" autocomplete="off">';
                    $result .= '<div class="form-group row">';
                    $result .= '<div class="col-md-6"><label class="form-control-label">Declaration letter of non-bankruptcy</label></div>';
                    $result .= '<div class="col-md-6">';
                    $result .= '<button type="button" id="clear_letter_bankruptcy_edit" class="btn btn-xs btn-danger" onclick="clearLetterBankruptcyEdit()" style="display: none;"><i class="fa fa-times"></i></button>&nbsp;';
                    $result .= '<input type="file" name="letter_bankruptcy_edit" id="letter_bankruptcy_edit">';
                    $result .= '<div id="validation-errors_letter_bankruptcy_edit"></div>';
                    if ($agm->letter_bankruptcy_url != "") {
                        $result .= '<div id="bankruptcy_edit"><a href="' . asset($agm->letter_bankruptcy_url) . '" target="_blank"><button type="button" class="btn btn-xs btn-primary" data-toggle="tooltip" data-placement="bottom" title="Download File"><i class="icmn-file-download2"></i> Download</button></a>&nbsp;';
                        $result .= '<button type="button" class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="bottom" title="Delete File" onclick="deleteLetterBankruptcy(\'' . $agm->id . '\')"><i class="fa fa-times"></i></button></div>';
                    }
                    $result .= '</div>';
                    $result .= '</div>';
                } else {
                    $result .= '<div class="form-group row">';
                    $result .= '<div class="col-md-6"><label class="form-control-label">Mesyuarat Agung Tahunan (AGM)</label></div>';
                    if ($agm->agm == 1) {
                        $result .= '<div class="col-md-2"><input type="radio" class="agm_edit" id="agm_edit" name="agm_edit" value="1" checked> Ada</div>';
                        $result .= '<div class="col-md-2"><input type="radio" class="agm_edit" id="agm_edit" name="agm_edit" value="0"> Tiada</div>';
                    } else {
                        $result .= '<div class="col-md-2"><input type="radio" class="agm_edit" id="agm_edit" name="agm_edit" value="1"> Ada</div>';
                        $result .= '<div class="col-md-2"><input type="radio" class="agm_edit" id="agm_edit" name="agm_edit" value="0" checked> Tiada</div>';
                    }
                    $result .= '</div>';

                    $result .= '<div class="form-group row">';
                    $result .= '<div class="col-md-6"><label class="form-control-label">Mesyuarat Agung Luarbiasa (EGM)</label></div>';
                    if ($agm->egm == 1) {
                        $result .= '<div class="col-md-2"><input type="radio" id="egm_edit" name="egm_edit" value="1" checked> Ada</div>';
                        $result .= '<div class="col-md-2"><input type="radio" id="egm_edit" name="egm_edit" value="0"> Tiada</div>';
                    } else {
                        $result .= '<div class="col-md-2"><input type="radio" id="egm_edit" name="egm_edit" value="1"> Ada</div>';
                        $result .= '<div class="col-md-2"><input type="radio" id="egm_edit" name="egm_edit" value="0" checked> Tiada</div>';
                    }
                    $result .= '</div>';

                    $result .= '<div class="form-group row">';
                    $result .= '<div class="col-md-6"><label class="form-control-label">Minit Mesyuarat</label></div>';
                    if ($agm->minit_meeting == 1) {
                        $result .= '<div class="col-md-2"><input type="radio" id="minit_meeting_edit" name="minit_meeting_edit" value="1" checked> Ada</div>';
                        $result .= '<div class="col-md-2"><input type="radio" id="minit_meeting_edit" name="minit_meeting_edit" value="0"> Tiada</div>';
                    } else {
                        $result .= '<div class="col-md-2"><input type="radio" id="minit_meeting_edit" name="minit_meeting_edit" value="1"> Ada</div>';
                        $result .= '<div class="col-md-2"><input type="radio" id="minit_meeting_edit" name="minit_meeting_edit" value="0" checked> Tiada</div>';
                    }
                    $result .= '</div>';

                    $result .= '<div class="form-group row">';
                    $result .= '<div class="col-md-6"><label class="form-control-label">Salinan Perjanjian Jualbeli JMC</label></div>';
                    if ($agm->jmc_spa == 1) {
                        $result .= '<div class="col-md-2"><input type="radio" id="jmc_copy_edit" name="jmc_copy_edit" value="1" checked>Ada</div>';
                        $result .= '<div class="col-md-2"><input type="radio" id="jmc_copy_edit" name="jmc_copy_edit" value="0">Tiada</div>';
                    } else {
                        $result .= '<div class="col-md-2"><input type="radio" id="jmc_copy_edit" name="jmc_copy_edit" value="1">Ada</div>';
                        $result .= '<div class="col-md-2"><input type="radio" id="jmc_copy_edit" name="jmc_copy_edit" value="0" checked>Tiada</div>';
                    }
                    $result .= '</div>';

                    $result .= '<div class="form-group row">';
                    $result .= '<div class="col-md-6"><label class="form-control-label">Salinan Kad Pengenalan</label></div>';
                    if ($agm->identity_card == 1) {
                        $result .= '<div class="col-md-2"><input type="radio" id="ic_list_edit" name="ic_list_edit" value="1" checked> Ada</div>';
                        $result .= '<div class="col-md-2"><input type="radio" id="ic_list_edit" name="ic_list_edit" value="0"> Tiada</div>';
                    } else {
                        $result .= '<div class="col-md-2"><input type="radio" id="ic_list_edit" name="ic_list_edit" value="1"> Ada</div>';
                        $result .= '<div class="col-md-2"><input type="radio" id="ic_list_edit" name="ic_list_edit" value="0" checked> Tiada</div>';
                    }
                    $result .= '</div>';


                    $result .= '<div class="form-group row">';
                    $result .= '<div class="col-md-6"><label class="form-control-label">Senarai Kehadiran</label></div>';
                    if ($agm->attendance == 1) {
                        $result .= '<div class="col-md-2"><input type="radio" id="attendance_list_edit" name="attendance_list_edit" value="1" checked> Ada </div>';
                        $result .= '<div class="col-md-2"><input type="radio" id="attendance_list_edit" name="attendance_list_edit" value="0"> Tiada </div>';
                    } else {
                        $result .= '<div class="col-md-2"><input type="radio" id="attendance_list_edit" name="attendance_list_edit" value="1"> Ada </div>';
                        $result .= '<div class="col-md-2"><input type="radio" id="attendance_list_edit" name="attendance_list_edit" value="0" checked> Tiada </div>';
                    }
                    $result .= '</div>';

                    $result .= '<div class="form-group row">';
                    $result .= '<div class="col-md-6"><label class="form-control-label">Laporan Kew Teraudit</label></div>';
                    if ($agm->financial_report == 1) {
                        $result .= '<div class="col-md-2"><input type="radio" id="audited_financial_report_edit" name="audited_financial_report_edit" value="1" checked> Ada</div>';
                        $result .= '<div class="col-md-2"><input type="radio" id="audited_financial_report_edit" name="audited_financial_report_edit" value="0"> Tiada</div>';
                    } else {
                        $result .= '<div class="col-md-2"><input type="radio" id="audited_financial_report_edit" name="audited_financial_report_edit" value="1"> Ada</div>';
                        $result .= '<div class="col-md-2"><input type="radio" id="audited_financial_report_edit" name="audited_financial_report_edit" value="0" checked> Tiada</div>';
                    }
                    $result .= '</div>';

                    $result .= '<div class="form-group row">';
                    $result .= '<div class="col-md-6"><label class="form-control-label">Laporan Kewangan Audit</label></div>';
                    $result .= '<div class="col-md-6"><input type="text" class="form-control" placeholder="Laporan Kewangan Audit" id="audit_report_edit" value=' . "$agm->audit_report" . '></div>';
                    $result .= '</div>';

                    $result .= '</form>';

                    $result .= '<form id="upload_audit_report_file_edit" enctype="multipart/form-data" method="post" action="' . url("uploadAuditReportFileEdit") . '" autocomplete="off">';
                    $result .= '<div class="form-group row">';
                    $result .= '<div class="col-md-6"><label class="form-control-label">&nbsp;</label></div>';
                    $result .= '<div class="col-md-6">';
                    $result .= '<button type="button" id="clear_audit_report_file_edit" class="btn btn-xs btn-danger" onclick="clearAuditFileEdit()" style="display: none;"><i class="fa fa-times"></i></button>&nbsp;';
                    $result .= '<input type="file" name="audit_report_file_edit" id="audit_report_file_edit">';
                    $result .= '<div id="validation-errors_audit_report_file_edit"></div><div id="view_audit_report_file_edit"></div>';
                    if ($agm->audit_report_url != "") {
                        $result .= '<div id="report_edit"><a href="' . asset($agm->audit_report_url) . '" target="_blank"><button type="button" class="btn btn-xs btn-primary" data-toggle="tooltip" data-placement="bottom" title="Download File"><i class="icmn-file-download2"></i> Download</button></a>&nbsp;';
                        $result .= '<button type="button" class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="bottom" title="Padam Fail" onclick="deleteAuditReport(\'' . $agm->id . '\')"><i class="fa fa-times"></i></button></div>';
                    }
                    $result .= '</div>';
                    $result .= '</div>';
                    $result .= '</form>';

                    $result .= '<form id="upload_letter_integrity_edit" enctype="multipart/form-data" method="post" action="' . url("uploadLetterIntegrityEdit") . '" autocomplete="off">';
                    $result .= '<div class="form-group row">';
                    $result .= '<div class="col-md-6"><label class="form-control-label">Surat ikrar integriti JMC</label></div>';
                    $result .= '<div class="col-md-6">';
                    $result .= '<button type="button" id="clear_letter_integrity_edit" class="btn btn-xs btn-danger" onclick="clearLetterIntegrityEdit()" style="display: none;"><i class="fa fa-times"></i></button>&nbsp;';
                    $result .= '<input type="file" name="letter_integrity_edit" id="letter_integrity_edit">';
                    $result .= '<div id="validation-errors_letter_integrity_edit"></div>';
                    if ($agm->letter_integrity_url != "") {
                        $result .= '<div id="integrity_edit"><a href="' . asset($agm->letter_integrity_url) . '" target="_blank"><button type="button" class="btn btn-xs btn-primary" data-toggle="tooltip" data-placement="bottom" title="Download File"><i class="icmn-file-download2"></i> Download</button></a>&nbsp;';
                        $result .= '<button type="button" class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="bottom" title="Padam Fail" onclick="deleteLetterIntegrity(\'' . $agm->id . '\')"><i class="fa fa-times"></i></button></div>';
                    }
                    $result .= '</div>';
                    $result .= '</div>';
                    $result .= '</form>';

                    $result .= '<form id="upload_letter_bankruptcy_edit" enctype="multipart/form-data" method="post" action="' . url("uploadLetterBankruptcyEdit") . '" autocomplete="off">';
                    $result .= '<div class="form-group row">';
                    $result .= '<div class="col-md-6"><label class="form-control-label">Surat akuan tidak muflis</label></div>';
                    $result .= '<div class="col-md-6">';
                    $result .= '<button type="button" id="clear_letter_bankruptcy_edit" class="btn btn-xs btn-danger" onclick="clearLetterBankruptcyEdit()" style="display: none;"><i class="fa fa-times"></i></button>&nbsp;';
                    $result .= '<input type="file" name="letter_bankruptcy_edit" id="letter_bankruptcy_edit">';
                    $result .= '<div id="validation-errors_letter_bankruptcy_edit"></div>';
                    if ($agm->letter_bankruptcy_url != "") {
                        $result .= '<div id="bankruptcy_edit"><a href="' . asset($agm->letter_bankruptcy_url) . '" target="_blank"><button type="button" class="btn btn-xs btn-primary" data-toggle="tooltip" data-placement="bottom" title="Download File"><i class="icmn-file-download2"></i> Download</button></a>&nbsp;';
                        $result .= '<button type="button" class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="bottom" title="Padam Fail" onclick="deleteLetterBankruptcy(\'' . $agm->id . '\')"><i class="fa fa-times"></i></button></div>';
                    }
                    $result .= '</div>';
                    $result .= '</div>';
                }
                $result .= '</form>';
            } else {
                $result = "No Data Found";
            }
            print $result;
        }
    }

    public function getAGM($file_id) {
        $agm_detail = MeetingDocument::where('file_id', $file_id)->where('is_deleted', 0)->orderBy('id', 'desc')->get();

        if (count($agm_detail) > 0) {
            $data = Array();
            foreach ($agm_detail as $agm_details) {
                $button = "";
                $button .= '<button type="button" class="btn btn-xs btn-success edit_agm" title="Edit" onclick="getAGMDetails(\'' . $agm_details->id . '\')"
                            data-agm_id="' . $agm_details->id . '" data-agm_date="' . $agm_details->agm_date . '"                          
                            data-audit_start_date="' . $agm_details->audit_start_date . '" data-audit_end_date="' . $agm_details->audit_end_date . '"
                            data-audit_report_file_url="' . $agm_details->audit_report_url . '" data-letter_integrity_url="' . $agm_details->letter_integrity_url . '" data-letter_bankruptcy_url="' . $agm_details->letter_bankruptcy_url . '">
                                <i class="fa fa-pencil"></i>
                            </button>
                            &nbsp;';
                $button .= '<button type="button" class="btn btn-xs btn-danger" title="Delete" onclick="deleteAGMDetails(\'' . $agm_details->id . '\')">
                                <i class="fa fa-trash""></i>
                            </button>';

                if ($agm_details->agm_date == "0000-00-00") {
                    $date_agm = '';
                } else {
                    $date_agm = date('d-M-Y', strtotime($agm_details->agm_date));
                }
                if ($agm_details->audit_start_date == "0000-00-00") {
                    $date_audit_start = '';
                } else {
                    $date_audit_start = date('d-M-Y', strtotime($agm_details->audit_start_date));
                }
                if ($agm_details->audit_end_date == "0000-00-00") {
                    $date_audit_end = '';
                } else {
                    $date_audit_end = date('d-M-Y', strtotime($agm_details->audit_end_date));
                }
                if ($agm_details->agm == 0 || $agm_details->agm == "") {
                    $status1 = '';
                } else {
                    $status1 = '<i class="icmn-checkmark4"></i>';
                }
                if ($agm_details->egm == 0 || $agm_details->egm == "") {
                    $status2 = '';
                } else {
                    $status2 = '<i class="icmn-checkmark4"></i>';
                }
                if ($agm_details->minit_meeting == 0 || $agm_details->minit_meeting == "") {
                    $status3 = '';
                } else {
                    $status3 = '<i class="icmn-checkmark4"></i>';
                }
                if ($agm_details->letter_integrity_url == "") {
                    $status4 = '';
                } else {
                    $status4 = '<i class="icmn-checkmark4"></i>';
                }
                if ($agm_details->letter_bankruptcy_url == "") {
                    $status5 = '';
                } else {
                    $status5 = '<i class="icmn-checkmark4"></i>';
                }
                if ($agm_details->jmc_spa == 0 || $agm_details->jmc_spa == "") {
                    $status6 = '';
                } else {
                    $status6 = '<i class="icmn-checkmark4"></i>';
                }
                if ($agm_details->identity_card == 0 || $agm_details->identity_card == "") {
                    $status7 = '';
                } else {
                    $status7 = '<i class="icmn-checkmark4"></i>';
                }
                if ($agm_details->attendance == 0 || $agm_details->attendance == "") {
                    $status8 = '';
                } else {
                    $status8 = '<i class="icmn-checkmark4"></i>';
                }
                if ($agm_details->financial_report == 0 || $agm_details->financial_report == "") {
                    $status9 = '';
                } else {
                    $status9 = '<i class="icmn-checkmark4"></i>';
                }
                if ($agm_details->audit_report_url == "") {
                    $status10 = '';
                } else {
                    $status10 = '<i class="icmn-checkmark4"></i>';
                }

                if (Session::get('lang') == "en") {
                    $data_raw = array(
                        $date_agm,
                        'Anual General Meeting (AGM)<br/>'
                        . 'Extraordinary General Meeting (EGM)<br/>'
                        . 'Minit Meeting<br/>'
                        . 'Pledge letter of integrity JMC<br>'
                        . 'Declaration letter of non-bankruptcy',
                        $status1 . '<br/>' . $status2 . '<br/>' . $status3 . '<br/>' . $status4 . '<br/>' . $status5,
                        'JMC SPA Copy<br/>'
                        . 'Identity Card List<br/>'
                        . 'Attendance List',
                        $status6 . '<br/>' . $status7 . '<br/>' . $status8,
                        'Audited Financial Report<br/>'
                        . 'Financial Audit Start Date<br/>'
                        . 'Financial Audit End Date<br/>'
                        . 'Financial Audit Report',
                        $status9 . '<br/>' . $date_audit_start . '<br/>' . $date_audit_end . '<br/>' . $status10,
                        $button
                    );
                } else {
                    $data_raw = array(
                        $date_agm,
                        'Mesyuarat Agung Tahunan (AGM)<br/>'
                        . 'Mesyuarat Agung Luarbiasa (EGM)<br/>'
                        . 'Minit Mesyuarat<br/>'
                        . 'Surat ikrar integriti JMC<br>'
                        . 'Surat akuan tidak muflis',
                        $status1 . '<br/>' . $status2 . '<br/>' . $status3 . '<br/>' . $status4 . '<br/>' . $status5,
                        'Salinan Perjanjian Jualbeli JMC<br/>'
                        . 'Salinan Kad Pengenalan<br/>'
                        . 'Senarai Kehadiran',
                        $status6 . '<br/>' . $status7 . '<br/>' . $status8,
                        'Laporan Kew Teraudit<br/>'
                        . 'Tarikh Mula Kewangan Audit<br/>'
                        . 'Tarikh Akhir Kewangan Audit<br/>'
                        . 'Laporan Kewangan Audit',
                        $status9 . '<br/>' . $date_audit_start . '<br/>' . $date_audit_end . '<br/>' . $status10,
                        $button
                    );
                }

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

    public function deleteAGMDetails() {
        $data = Input::all();
        if (Request::ajax()) {

            $id = $data['id'];

            $agm_details = MeetingDocument::find($id);
            $agm_details->is_deleted = 1;
            $deleted = $agm_details->save();

            if ($deleted) {
                # Audit Trail
                $file_name = Files::find($agm_details->file_id);
                $remarks = 'AGM Details (' . $file_name->file_no . ')' . ' dated ' . date('d/m/Y', strtotime($agm_details->agm_date)) . ' has been deleted.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "COB File";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    public function deleteAuditReport() {
        $data = Input::all();
        if (Request::ajax()) {

            $id = $data['id'];

            $agm_details = MeetingDocument::find($id);
            $agm_details->audit_report_url = "";
            $deleted = $agm_details->save();
            if ($deleted) {
                # Audit Trail
                $file_name = Files::find($agm_details->file_id);
                $remarks = 'AGM Details (' . $file_name->file_no . ')' . ' dated ' . date('d/m/Y', strtotime($agm_details->agm_date)) . ' has been updated.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "COB File";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    public function deleteLetterIntegrity() {
        $data = Input::all();
        if (Request::ajax()) {

            $id = $data['id'];

            $agm_details = MeetingDocument::find($id);
            $agm_details->letter_integrity_url = "";
            $deleted = $agm_details->save();
            if ($deleted) {
                # Audit Trail
                $file_name = Files::find($agm_details->file_id);
                $remarks = 'AGM Details (' . $file_name->file_no . ')' . ' dated ' . date('d/m/Y', strtotime($agm_details->agm_date)) . ' has been updated.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "COB File";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    public function deleteLetterBankruptcy() {
        $data = Input::all();
        if (Request::ajax()) {

            $id = $data['id'];

            $agm_details = MeetingDocument::find($id);
            $agm_details->letter_bankruptcy_url = "";
            $deleted = $agm_details->save();
            if ($deleted) {
                # Audit Trail
                $file_name = Files::find($agm_details->file_id);
                $remarks = 'AGM Details (' . $file_name->file_no . ')' . ' dated ' . date('d/m/Y', strtotime($agm_details->agm_date)) . ' has been updated.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "COB File";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    public function addAJKDetails() {
        $data = Input::all();
        if (Request::ajax()) {

            $file_id = $data['file_id'];
            $designation = $data['ajk_designation'];
            $name = $data['ajk_name'];
            $phone_no = $data['ajk_phone_no'];
            $year = $data['ajk_year'];

            $ajk_detail = new AJKDetails();
            $ajk_detail->file_id = $file_id;
            $ajk_detail->designation = $designation;
            $ajk_detail->name = $name;
            $ajk_detail->phone_no = $phone_no;
            $ajk_detail->year = $year;
            $success = $ajk_detail->save();

            if ($success) {
                # Audit Trail
                $file_name = Files::find($ajk_detail->file_id);
                $remarks = 'AJK Details (' . $file_name->file_no . ') ' . $ajk_detail->name . ' has been inserted.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "COB File";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    public function editAJKDetails() {
        $data = Input::all();
        if (Request::ajax()) {

            $id = $data['ajk_id_edit'];
            $designation = $data['ajk_designation'];
            $name = $data['ajk_name'];
            $phone_no = $data['ajk_phone_no'];
            $year = $data['ajk_year'];

            $ajk_detail = AJKDetails::find($id);
            $ajk_detail->designation = $designation;
            $ajk_detail->name = $name;
            $ajk_detail->phone_no = $phone_no;
            $ajk_detail->year = $year;
            $success = $ajk_detail->save();

            if ($success) {
                # Audit Trail
                $file_name = Files::find($ajk_detail->file_id);
                $remarks = 'AJK Details (' . $file_name->file_no . ') ' . $ajk_detail->name . ' has been updated.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "COB File";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    public function getAJK($file_id) {
        $ajk_detail = AJKDetails::where('file_id', $file_id)->where('is_deleted', 0)->orderBy('id', 'desc')->get();

        if (count($ajk_detail) > 0) {
            $data = Array();
            foreach ($ajk_detail as $ajk_details) {
                $designation = Designation::find($ajk_details->designation);

                $button = "";
                $button .= '<button type="button" class="btn btn-xs btn-success edit_ajk" title="Edit" data-toggle="modal" data-target="#edit_ajk_details"
                            data-ajk_id="' . $ajk_details->id . '" data-designation="' . $ajk_details->designation . '" data-name="' . $ajk_details->name . '" data-phone_no="' . $ajk_details->phone_no . '" data-year="' . $ajk_details->year . '">
                                <i class="fa fa-pencil"></i>
                            </button>
                            &nbsp;';
                $button .= '<button type="button" class="btn btn-xs btn-danger" title="Delete" onclick="deleteAJKDetails(\'' . $ajk_details->id . '\')">
                                <i class="fa fa-trash"></i>
                            </button>
                            &nbsp';


                $data_raw = array(
                    $designation->description,
                    $ajk_details->name,
                    $ajk_details->phone_no,
                    $ajk_details->year,
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

    public function deleteAJKDetails() {
        $data = Input::all();
        if (Request::ajax()) {

            $id = $data['id'];

            $ajk_details = AJKDetails::find($id);
            $ajk_details->is_deleted = 1;
            $deleted = $ajk_details->save();
            if ($deleted) {
                # Audit Trail
                $file_name = Files::find($ajk_details->file_id);
                $remarks = 'AJK Details (' . $file_name->file_no . ') ' . $ajk_details->name . ' has been deleted.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "COB File";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    public function viewOthers($id) {
        //get user permission
        $user_permission = AccessGroup::getAccessPermission(Auth::user()->id);
        $files = Files::find($id);
        $other_details = OtherDetails::where('file_id', $files->id)->first();
        $image = OtherDetails::where('file_id', $files->id)->first();

        if (Session::get('lang') == "en") {
            $viewData = array(
                'title' => 'Update COB File',
                'panel_nav_active' => 'cob_panel',
                'main_nav_active' => 'cob_main',
                'sub_nav_active' => 'cob_list',
                'user_permission' => $user_permission,
                'file' => $files,
                'other_details' => $other_details,
                'image' => $image->image_url
            );

            return View::make('page_en.view_others', $viewData);
        } else {
            $viewData = array(
                'title' => 'Edit Fail COB',
                'panel_nav_active' => 'cob_panel',
                'main_nav_active' => 'cob_main',
                'sub_nav_active' => 'cob_list',
                'user_permission' => $user_permission,
                'file' => $files,
                'other_details' => $other_details,
                'image' => $image->image_url
            );

            return View::make('page_my.view_others', $viewData);
        }
    }

    public function others($id) {
        //get user permission
        $user_permission = AccessGroup::getAccessPermission(Auth::user()->id);
        $files = Files::find($id);
        $other_details = OtherDetails::where('file_id', $files->id)->first();
        $image = OtherDetails::where('file_id', $files->id)->first();

        if (Session::get('lang') == "en") {
            $viewData = array(
                'title' => 'Update COB File',
                'panel_nav_active' => 'cob_panel',
                'main_nav_active' => 'cob_main',
                'sub_nav_active' => 'cob_list',
                'user_permission' => $user_permission,
                'file' => $files,
                'other_details' => $other_details,
                'image' => $image->image_url
            );

            return View::make('page_en.update_others', $viewData);
        } else {
            $viewData = array(
                'title' => 'Edit Fail COB',
                'panel_nav_active' => 'cob_panel',
                'main_nav_active' => 'cob_main',
                'sub_nav_active' => 'cob_list',
                'user_permission' => $user_permission,
                'file' => $files,
                'other_details' => $other_details,
                'image' => $image->image_url
            );

            return View::make('page_my.update_others', $viewData);
        }
    }

    public function submitUpdateOtherDetails() {
        $data = Input::all();
        if (Request::ajax()) {
            $id = $data['id'];
            $other_details_name = $data['other_details_name'];
            $others_image_url = $data['others_image_url'];
            $latitude = $data['latitude'];
            $longitude = $data['longitude'];
            $other_details_description = $data['other_details_description'];

            $others = OtherDetails::find($id);
            $others->name = $other_details_name;
            $others->image_url = $others_image_url;
            $others->latitude = $latitude;
            $others->longitude = $longitude;
            $others->description = $other_details_description;
            $success = $others->save();

            if ($success) {
                # Audit Trail
                $file_name = Files::find($others->file_id);
                $remarks = 'Others Info (' . $file_name->file_no . ') has been updated.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "COB File";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    public function deleteImageOthers() {
        $data = Input::all();
        if (Request::ajax()) {

            $id = $data['id'];

            $others = OtherDetails::find($id);
            $others->image_url = "";
            $deleted = $others->save();
            if ($deleted) {
                # Audit Trail
                $file_name = Files::find($others->file_id);
                $remarks = 'Others Info (' . $file_name->file_no . ') has been updated.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "COB File";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    public function viewScoring($id) {
        //get user permission
        $user_permission = AccessGroup::getAccessPermission(Auth::user()->id);
        $files = Files::find($id);
        $image = OtherDetails::where('file_id', $files->id)->first();

        if (Session::get('lang') == "en") {
            $viewData = array(
                'title' => 'Update COB File',
                'panel_nav_active' => 'cob_panel',
                'main_nav_active' => 'cob_main',
                'sub_nav_active' => 'cob_list',
                'user_permission' => $user_permission,
                'files' => $files,
                'image' => $image->image_url
            );

            return View::make('page_en.view_scoring', $viewData);
        } else {
            $viewData = array(
                'title' => 'Edit Fail COB',
                'panel_nav_active' => 'cob_panel',
                'main_nav_active' => 'cob_main',
                'sub_nav_active' => 'cob_list',
                'user_permission' => $user_permission,
                'files' => $files,
                'image' => $image->image_url
            );

            return View::make('page_my.view_scoring', $viewData);
        }
    }

    public function scoring($id) {
        //get user permission
        $user_permission = AccessGroup::getAccessPermission(Auth::user()->id);
        $files = Files::find($id);
        $image = OtherDetails::where('file_id', $files->id)->first();

        if (Session::get('lang') == "en") {
            $viewData = array(
                'title' => 'Update COB File',
                'panel_nav_active' => 'cob_panel',
                'main_nav_active' => 'cob_main',
                'sub_nav_active' => 'cob_list',
                'user_permission' => $user_permission,
                'files' => $files,
                'image' => $image->image_url
            );

            return View::make('page_en.update_scoring', $viewData);
        } else {
            $viewData = array(
                'title' => 'Edit Fail COB',
                'panel_nav_active' => 'cob_panel',
                'main_nav_active' => 'cob_main',
                'sub_nav_active' => 'cob_list',
                'user_permission' => $user_permission,
                'files' => $files,
                'image' => $image->image_url
            );

            return View::make('page_my.update_scoring', $viewData);
        }
    }

    public function addScoring() {
        $data = Input::all();
        if (Request::ajax()) {

            $file_id = $data['file_id'];
            $survey = $data['survey'];
            $score1 = $data['score1'];
            $score2 = $data['score2'];
            $score3 = $data['score3'];
            $score4 = $data['score4'];
            $score5 = $data['score5'];
            $score6 = $data['score6'];
            $score7 = $data['score7'];
            $score8 = $data['score8'];
            $score9 = $data['score9'];
            $score10 = $data['score10'];
            $score11 = $data['score11'];
            $score12 = $data['score12'];
            $score13 = $data['score13'];
            $score14 = $data['score14'];
            $score15 = $data['score15'];
            $score16 = $data['score16'];
            $score17 = $data['score17'];
            $score18 = $data['score18'];
            $score19 = $data['score19'];
            $score20 = $data['score20'];
            $score21 = $data['score21'];

            $scorings_A = ((($score1 + $score2 + $score3 + $score4 + $score5) / 20) * 25);
            $scorings_B = ((($score6 + $score7 + $score8 + $score9 + $score10) / 20) * 25);
            $scorings_C = ((($score11 + $score12 + $score13 + $score14) / 16) * 20);
            $scorings_D = ((($score15 + $score16 + $score17 + $score18) / 16) * 20);
            $scorings_E = ((($score19 + $score20 + $score21) / 12) * 10);

            $total_score = $scorings_A + $scorings_B + $scorings_C + $scorings_D + $scorings_E;

            $scoring = new Scoring();
            $scoring->file_id = $file_id;
            $scoring->survey = $survey;
            $scoring->score1 = $score1;
            $scoring->score2 = $score2;
            $scoring->score3 = $score3;
            $scoring->score4 = $score4;
            $scoring->score5 = $score5;
            $scoring->score6 = $score6;
            $scoring->score7 = $score7;
            $scoring->score8 = $score8;
            $scoring->score9 = $score9;
            $scoring->score10 = $score10;
            $scoring->score11 = $score11;
            $scoring->score12 = $score12;
            $scoring->score13 = $score13;
            $scoring->score14 = $score14;
            $scoring->score15 = $score15;
            $scoring->score16 = $score16;
            $scoring->score17 = $score17;
            $scoring->score18 = $score18;
            $scoring->score19 = $score19;
            $scoring->score20 = $score20;
            $scoring->score21 = $score21;
            $scoring->total_score = $total_score;
            $success = $scoring->save();

            if ($success) {
                # Audit Trail
                $file_name = Files::find($scoring->file_id);
                $remarks = 'COB Rating (' . $file_name->file_no . ') dated ' . date('d/m/Y', strtotime($scoring->created_at)) . ' has been inserted.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "COB File";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    public function editScoring() {
        $data = Input::all();
        if (Request::ajax()) {

            $id = $data['id'];
            $score1 = $data['score1'];
            $score2 = $data['score2'];
            $score3 = $data['score3'];
            $score4 = $data['score4'];
            $score5 = $data['score5'];
            $score6 = $data['score6'];
            $score7 = $data['score7'];
            $score8 = $data['score8'];
            $score9 = $data['score9'];
            $score10 = $data['score10'];
            $score11 = $data['score11'];
            $score12 = $data['score12'];
            $score13 = $data['score13'];
            $score14 = $data['score14'];
            $score15 = $data['score15'];
            $score16 = $data['score16'];
            $score17 = $data['score17'];
            $score18 = $data['score18'];
            $score19 = $data['score19'];
            $score20 = $data['score20'];
            $score21 = $data['score21'];

            $scorings_A = ((($score1 + $score2 + $score3 + $score4 + $score5) / 20) * 25);
            $scorings_B = ((($score6 + $score7 + $score8 + $score9 + $score10) / 20) * 25);
            $scorings_C = ((($score11 + $score12 + $score13 + $score14) / 16) * 20);
            $scorings_D = ((($score15 + $score16 + $score17 + $score18) / 16) * 20);
            $scorings_E = ((($score19 + $score20 + $score21) / 12) * 10);

            $total_score = $scorings_A + $scorings_B + $scorings_C + $scorings_D + $scorings_E;

            $scoring = Scoring::find($id);
            $scoring->score1 = $score1;
            $scoring->score2 = $score2;
            $scoring->score3 = $score3;
            $scoring->score4 = $score4;
            $scoring->score5 = $score5;
            $scoring->score6 = $score6;
            $scoring->score7 = $score7;
            $scoring->score8 = $score8;
            $scoring->score9 = $score9;
            $scoring->score10 = $score10;
            $scoring->score11 = $score11;
            $scoring->score12 = $score12;
            $scoring->score13 = $score13;
            $scoring->score14 = $score14;
            $scoring->score15 = $score15;
            $scoring->score16 = $score16;
            $scoring->score17 = $score17;
            $scoring->score18 = $score18;
            $scoring->score19 = $score19;
            $scoring->score20 = $score20;
            $scoring->score21 = $score21;
            $scoring->total_score = $total_score;
            $success = $scoring->save();

            if ($success) {
                # Audit Trail
                $file_name = Files::find($scoring->file_id);
                $remarks = 'COB Rating (' . $file_name->file_no . ') dated ' . date('d/m/Y', strtotime($scoring->created_at)) . ' has been updated.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "COB File";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    public function getScoring($id) {
        $scoring = Scoring::where('file_id', $id)->where('is_deleted', 0)->orderBy('id', 'desc')->get();

        if (count($scoring) > 0) {
            $data = Array();
            foreach ($scoring as $scorings) {
                $button = "";

                $button .= '<button type="button" class="btn btn-xs btn-success edit_survey" title="Edit" onclick="editSurveyForm(\'' . $scorings->survey . '\')"'
                        . 'data-score1="' . $scorings->score1 . '" data-score2="' . $scorings->score2 . '" data-score3="' . $scorings->score3 . '"'
                        . 'data-score4="' . $scorings->score4 . '" data-score5="' . $scorings->score5 . '" data-score6="' . $scorings->score6 . '"'
                        . 'data-score7="' . $scorings->score7 . '" data-score8="' . $scorings->score8 . '" data-score9="' . $scorings->score9 . '"'
                        . 'data-score10="' . $scorings->score10 . '" data-score11="' . $scorings->score11 . '" data-score12="' . $scorings->score12 . '"'
                        . 'data-score13="' . $scorings->score13 . '" data-score14="' . $scorings->score14 . '" data-score15="' . $scorings->score15 . '"'
                        . 'data-score16="' . $scorings->score16 . '" data-score17="' . $scorings->score17 . '" data-score18="' . $scorings->score18 . '"'
                        . 'data-score19="' . $scorings->score19 . '" data-score20="' . $scorings->score20 . '" data-score21="' . $scorings->score21 . '"'
                        . 'data-id="' . $scorings->id . '"><i class="fa fa-pencil"></i></button>&nbsp;';
                $button .= '<button class="btn btn-xs btn-danger" title="Delete" onclick="deleteScoring(\'' . $scorings->id . '\')"><i class="fa fa-trash"></i></button>';

                $scorings_A = ((($scorings->score1 + $scorings->score2 + $scorings->score3 + $scorings->score4 + $scorings->score5) / 20) * 25);
                $scorings_B = ((($scorings->score6 + $scorings->score7 + $scorings->score8 + $scorings->score9 + $scorings->score10) / 20) * 25);
                $scorings_C = ((($scorings->score11 + $scorings->score12 + $scorings->score13 + $scorings->score14) / 16) * 20);
                $scorings_D = ((($scorings->score15 + $scorings->score16 + $scorings->score17 + $scorings->score18) / 16) * 20);
                $scorings_E = ((($scorings->score19 + $scorings->score20 + $scorings->score21) / 12) * 10);

                if ($scorings->total_score >= 86) {
                    $rating = '<span style="color: orange;">'
                            . '<i class="fa fa-star"></i>'
                            . '<i class="fa fa-star"></i>'
                            . '<i class="fa fa-star"></i>'
                            . '<i class="fa fa-star"></i>'
                            . '<i class="fa fa-star"></i>'
                            . '</span>';
                } else if ($scorings->total_score >= 61) {
                    $rating = '<span style="color: orange;">'
                            . '<i class="fa fa-star"></i>'
                            . '<i class="fa fa-star"></i>'
                            . '<i class="fa fa-star"></i>'
                            . '<i class="fa fa-star"></i>'
                            . '<i class="fa fa-star-o"></i>'
                            . '</span>';
                } else if ($scorings->total_score >= 41) {
                    $rating = '<span style="color: orange;">'
                            . '<i class="fa fa-star"></i>'
                            . '<i class="fa fa-star"></i>'
                            . '<i class="fa fa-star"></i>'
                            . '<i class="fa fa-star-o"></i>'
                            . '<i class="fa fa-star-o"></i>'
                            . '</span>';
                } else if ($scorings->total_score >= 21) {
                    $rating = '<span style="color: orange;">'
                            . '<i class="fa fa-star"></i>'
                            . '<i class="fa fa-star"></i>'
                            . '<i class="fa fa-star-o"></i>'
                            . '<i class="fa fa-star-o"></i>'
                            . '<i class="fa fa-star-o"></i>'
                            . '</span>';
                } else if ($scorings->total_score >= 1) {
                    $rating = '<span style="color: orange;">'
                            . '<i class="fa fa-star"></i>'
                            . '<i class="fa fa-star-o"></i>'
                            . '<i class="fa fa-star-o"></i>'
                            . '<i class="fa fa-star-o"></i>'
                            . '<i class="fa fa-star-o"></i>'
                            . '</span>';
                } else {
                    $rating = '<span style="color: orange;">'
                            . '<i class="fa fa-star-o"></i>'
                            . '<i class="fa fa-star-o"></i>'
                            . '<i class="fa fa-star-o"></i>'
                            . '<i class="fa fa-star-o"></i>'
                            . '<i class="fa fa-star-o"></i>'
                            . '</span>';
                }

                $data_raw = array(
                    $scorings->created_at->format('d-M-Y'),
                    number_format($scorings_A, 2),
                    number_format($scorings_B, 2),
                    number_format($scorings_C, 2),
                    number_format($scorings_D, 2),
                    number_format($scorings_E, 2),
                    number_format($scorings->total_score, 2),
                    $rating,
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

    public function deleteScoring() {
        $data = Input::all();
        if (Request::ajax()) {

            $id = $data['id'];

            $scoring = Scoring::find($id);
            $scoring->is_deleted = 1;
            $deleted = $scoring->save();
            if ($deleted) {
                # Audit Trail
                $file_name = Files::find($scoring->file_id);
                $remarks = 'COB Rating (' . $file_name->file_no . ') dated ' . date('d/m/Y', strtotime($scoring->created_at)) . ' has been deleted.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "COB File";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    public function viewBuyer($id) {
        //get user permission
        $user_permission = AccessGroup::getAccessPermission(Auth::user()->id);
        $files = Files::find($id);
        $image = OtherDetails::where('file_id', $files->id)->first();

        if (Session::get('lang') == "en") {
            $viewData = array(
                'title' => 'Update COB File',
                'panel_nav_active' => 'cob_panel',
                'main_nav_active' => 'cob_main',
                'sub_nav_active' => 'cob_list',
                'user_permission' => $user_permission,
                'files' => $files,
                'Uploadmessage' => '',
                'upload' => "true",
                'image' => $image->image_url
            );

            return View::make('page_en.view_buyer', $viewData);
        } else {
            $viewData = array(
                'title' => 'Edit Fail COB',
                'panel_nav_active' => 'cob_panel',
                'main_nav_active' => 'cob_main',
                'sub_nav_active' => 'cob_list',
                'user_permission' => $user_permission,
                'files' => $files,
                'Uploadmessage' => '',
                'upload' => "true",
                'image' => $image->image_url
            );

            return View::make('page_my.view_buyer', $viewData);
        }
    }

    public function buyer($id) {
        //get user permission
        $user_permission = AccessGroup::getAccessPermission(Auth::user()->id);
        $files = Files::find($id);
        $image = OtherDetails::where('file_id', $files->id)->first();

        if (Session::get('lang') == "en") {
            $viewData = array(
                'title' => 'Update COB File',
                'panel_nav_active' => 'cob_panel',
                'main_nav_active' => 'cob_main',
                'sub_nav_active' => 'cob_list',
                'user_permission' => $user_permission,
                'files' => $files,
                'Uploadmessage' => '',
                'upload' => "true",
                'image' => $image->image_url
            );

            return View::make('page_en.update_buyer', $viewData);
        } else {
            $viewData = array(
                'title' => 'Edit Fail COB',
                'panel_nav_active' => 'cob_panel',
                'main_nav_active' => 'cob_main',
                'sub_nav_active' => 'cob_list',
                'user_permission' => $user_permission,
                'files' => $files,
                'Uploadmessage' => '',
                'upload' => "true",
                'image' => $image->image_url
            );

            return View::make('page_my.update_buyer', $viewData);
        }
    }

    public function addBuyer($id) {
        $files = Files::find($id);
        $image = OtherDetails::where('file_id', $files->id)->first();

        if (Session::get('lang') == "en") {
            $viewData = array(
                'title' => 'Update COB File',
                'panel_nav_active' => 'cob_panel',
                'main_nav_active' => 'cob_main',
                'sub_nav_active' => 'cob_list',
                'files' => $files,
                'image' => $image->image_url
            );

            return View::make('page_en.add_buyer', $viewData);
        } else {
            $viewData = array(
                'title' => 'Edit Fail COB',
                'panel_nav_active' => 'cob_panel',
                'main_nav_active' => 'cob_main',
                'sub_nav_active' => 'cob_list',
                'files' => $files,
                'image' => $image->image_url
            );

            return View::make('page_my.add_buyer', $viewData);
        }
    }

    public function submitBuyer() {
        $data = Input::all();
        if (Request::ajax()) {

            $file_id = $data['file_id'];
            $unit_no = $data['unit_no'];
            $unit_share = $data['unit_share'];
            $owner_name = $data['owner_name'];
            $ic_company_no = $data['ic_company_no'];
            $address = $data['address'];
            $phone_no = $data['phone_no'];

            $checkFile = Files::find($file_id);

            if (count($checkFile) > 0) {
                $buyer = new Buyer();
                $buyer->file_id = $file_id;
                $buyer->unit_no = $unit_no;
                $buyer->unit_share = $unit_share;
                $buyer->owner_name = $owner_name;
                $buyer->ic_company_no = $ic_company_no;
                $buyer->address = $address;
                $buyer->phone_no = $phone_no;
                $success = $buyer->save();

                if ($success) {
                    # Audit Trail
                    $file_name = Files::find($buyer->file_id);
                    $remarks = 'COB Owner List (' . $file_name->file_no . ') for Unit' . $buyer->unit_no . ' has been inserted.';
                    $auditTrail = new AuditTrail();
                    $auditTrail->module = "COB File";
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

    public function editBuyer($id) {
        //get user permission
        $user_permission = AccessGroup::getAccessPermission(Auth::user()->id);
        $buyer = Buyer::find($id);
        $files = Files::find($buyer->file_id);
        $image = OtherDetails::where('file_id', $files->id)->first();

        $viewData = array(
            'title' => 'Update COB File',
            'panel_nav_active' => 'cob_panel',
            'main_nav_active' => 'cob_main',
            'sub_nav_active' => 'cob_list',
            'user_permission' => $user_permission,
            'files' => $files,
            'buyer' => $buyer,
            'image' => $image->image_url
        );

        return View::make('page_en.edit_buyer', $viewData);
    }

    public function submitEditBuyer() {
        $data = Input::all();
        if (Request::ajax()) {

            $file_id = $data['file_id'];
            $unit_no = $data['unit_no'];
            $unit_share = $data['unit_share'];
            $owner_name = $data['owner_name'];
            $ic_company_no = $data['ic_company_no'];
            $address = $data['address'];
            $phone_no = $data['phone_no'];
            $id = $data['id'];

            $checkFile = Files::find($file_id);

            if (count($checkFile) > 0) {
                $buyer = Buyer::find($id);
                if (count($buyer) > 0) {
                    $buyer->file_id = $file_id;
                    $buyer->unit_no = $unit_no;
                    $buyer->unit_share = $unit_share;
                    $buyer->owner_name = $owner_name;
                    $buyer->ic_company_no = $ic_company_no;
                    $buyer->address = $address;
                    $buyer->phone_no = $phone_no;
                    $success = $buyer->save();

                    if ($success) {
                        # Audit Trail
                        $file_name = Files::find($buyer->file_id);
                        $remarks = 'COB Owner List (' . $file_name->file_no . ') for Unit ' . $buyer->unit_no . ' has been updated.';
                        $auditTrail = new AuditTrail();
                        $auditTrail->module = "COB File";
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
            } else {
                print "false";
            }
        }
    }

    public function getBuyerList($file_id) {
        $buyer_list = Buyer::where('file_id', $file_id)->where('is_deleted', 0)->orderBy('id', 'desc')->get();

        if (count($buyer_list) > 0) {
            $data = Array();
            $no = 1;
            foreach ($buyer_list as $buyer_lists) {
                $button = "";
                $button .= '<button type="button" class="btn btn-sm btn-success" title="Edit" onclick="window.location=\'' . URL::action('AdminController@editBuyer', $buyer_lists->id) . '\'">
                                <i class="fa fa-pencil"></i>
                            </button>
                            &nbsp;';
                $button .= '<button type="button" class="btn btn-sm btn-danger" title="Delete" onclick="deleteBuyer(\'' . $buyer_lists->id . '\')">
                                <i class="fa fa-trash"></i>
                            </button>
                            &nbsp';


                $data_raw = array(
                    $no++,
                    $buyer_lists->unit_no,
                    $buyer_lists->unit_share,
                    $buyer_lists->owner_name,
                    $buyer_lists->ic_company_no,
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

    public function deleteBuyer() {
        $data = Input::all();
        if (Request::ajax()) {

            $id = $data['id'];

            $buyer = Buyer::find($id);
            $buyer->is_deleted = 1;
            $deleted = $buyer->save();
            if ($deleted) {
                # Audit Trail
                $file_name = Files::find($buyer->file_id);
                $remarks = 'COB Owner List (' . $file_name->file_no . ') for Unit ' . $buyer->unit_no . ' has been deleted.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "COB File";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    public function importBuyer($id) {
        //get user permission
        $user_permission = AccessGroup::getAccessPermission(Auth::user()->id);
        $files = Files::find($id);
        $image = OtherDetails::where('file_id', $files->id)->first();

        if (Session::get('lang') == "en") {
            $viewData = array(
                'title' => 'Update COB File',
                'panel_nav_active' => 'cob_panel',
                'main_nav_active' => 'cob_main',
                'sub_nav_active' => 'cob_list',
                'user_permission' => $user_permission,
                'files' => $files,
                'Uploadmessage' => '',
                'upload' => "true",
                'image' => $image->image_url
            );

            return View::make('page_en.import_buyer', $viewData);
        } else {
            $viewData = array(
                'title' => 'Edit Fail COB',
                'panel_nav_active' => 'cob_panel',
                'main_nav_active' => 'cob_main',
                'sub_nav_active' => 'cob_list',
                'user_permission' => $user_permission,
                'files' => $files,
                'Uploadmessage' => '',
                'upload' => "true",
                'image' => $image->image_url
            );

            return View::make('page_my.import_buyer', $viewData);
        }
    }

    public function submitUploadBuyer($id) {
        $files = Files::find($id);

        $data = Input::all();
        if (Request::ajax()) {

            $getAllBuyer = $data['getAllBuyer'];

            foreach ($getAllBuyer as $buyerList) {

                $check_file_id = Files::where('file_no', $buyerList[0])->where('id', $files->id)->first();
                if (count($check_file_id) > 0) {
                    $files_id = $check_file_id->id;

                    $check_buyer = Buyer::where('file_id', $files_id)->where('unit_no', $buyerList[1])->where('is_deleted', 0)->first();
                    if (count($check_buyer) <= 0) {
                        $buyer = new Buyer();
                        $buyer->file_id = $files_id;
                        $buyer->unit_no = $buyerList[1];
                        $buyer->unit_share = $buyerList[2];
                        $buyer->owner_name = $buyerList[3];
                        $buyer->ic_company_no = $buyerList[4];
                        $buyer->address = $buyerList[5];
                        $buyer->phone_no = $buyerList[6];
                        $buyer->save();

                        # Audit Trail
                        $file_name = Files::find($buyer->file_id);
                        $remarks = 'COB Owner List (' . $file_name->file_no . ') for Unit ' . $buyer->unit_no . ' has been inserted.';
                        $auditTrail = new AuditTrail();
                        $auditTrail->module = "COB File";
                        $auditTrail->remarks = $remarks;
                        $auditTrail->audit_by = Auth::user()->id;
                        $auditTrail->save();
                    }
                }
            }
            # Audit Trail
            $file_name = Files::find($buyer->file_id);
            $remarks = 'COB Owner List (' . $file_name->file_no . ') has been imported.';
            $auditTrail = new AuditTrail();
            $auditTrail->module = "COB File";
            $auditTrail->remarks = $remarks;
            $auditTrail->audit_by = Auth::user()->id;
            $auditTrail->save();

            print "true";
        } else {
            print "false";
        }
    }

    public function fileApproval($id) {
        //get user permission
        $user_permission = AccessGroup::getAccessPermission(Auth::user()->id);
        $files = Files::find($id);
        if ($files->status == 1) {
            $status = "Approved";
        } else if ($files->status == 2) {
            $status = "Rejected";
        } else {
            $status = "Pending";
        }
        $approveBy = User::find($files->approved_by);
        $image = OtherDetails::where('file_id', $files->id)->first();

        if (Session::get('lang') == "en") {
            $viewData = array(
                'title' => 'Update COB File',
                'panel_nav_active' => 'cob_panel',
                'main_nav_active' => 'cob_main',
                'sub_nav_active' => 'cob_list',
                'user_permission' => $user_permission,
                'files' => $files,
                'status' => $status,
                'approveBy' => $approveBy,
                'Uploadmessage' => '',
                'upload' => "true",
                'role' => Auth::user()->role,
                'image' => $image->image_url
            );

            return View::make('page_en.file_approval', $viewData);
        } else {
            $viewData = array(
                'title' => 'Edit Fail COB',
                'panel_nav_active' => 'cob_panel',
                'main_nav_active' => 'cob_main',
                'sub_nav_active' => 'cob_list',
                'user_permission' => $user_permission,
                'files' => $files,
                'status' => $status,
                'approveBy' => $approveBy,
                'Uploadmessage' => '',
                'upload' => "true",
                'role' => Auth::user()->role,
                'image' => $image->image_url
            );

            return View::make('page_my.file_approval', $viewData);
        }
    }

    public function submitFileApproval() {
        $data = Input::all();
        if (Request::ajax()) {
            $id = $data['id'];
            $status = $data['approval_status'];
            $remarks = $data['approval_remarks'];

            if ($status == 1) {
                $is_active = 1;
            } else {
                $is_active = 0;
            }

            $files = Files::find($id);
            if (count($files) > 0) {
                $files->is_active = $is_active;
                $files->status = $status;
                $files->remarks = $remarks;
                $files->approved_by = Auth::user()->id;
                $files->approved_at = date('Y-m-d H:i:s');
                $success = $files->save();

                if ($success) {
                    print "true";
                } else {
                    print "false";
                }
            } else {
                print "false";
            }
        } else {
            print "false";
        }
    }

    // --- Administrator --- //
    public function company() {
        //get user permission
        $user_permission = AccessGroup::getAccessPermission(Auth::user()->id);

        if (Session::get('lang') == "en") {
            $viewData = array(
                'title' => 'Organization Profile',
                'panel_nav_active' => 'admin_panel',
                'main_nav_active' => 'admin_main',
                'sub_nav_active' => 'profile_list',
                'user_permission' => $user_permission,
                'image' => ""
            );

            return View::make('admin_en.company', $viewData);
        } else {
            $viewData = array(
                'title' => 'Organization Profile',
                'panel_nav_active' => 'admin_panel',
                'main_nav_active' => 'admin_main',
                'sub_nav_active' => 'profile_list',
                'user_permission' => $user_permission,
                'image' => ""
            );

            return View::make('admin_my.company', $viewData);
        }
    }

    public function getCompany() {
        if (!Auth::user()->getAdmin()) {
            $company = Company::where('id', Auth::user()->company_id)->where('is_deleted', 0)->get();
        } else {
            $company = Company::where('is_deleted', 0)->orderBy('name', 'asc')->get();
        }

        if (count($company) > 0) {
            $data = Array();
            foreach ($company as $companies) {
                $button = "";
                if (Session::get('lang') == "en") {
                    if ($companies->is_active == 1) {
                        $status = "Active";
                        $button .= '<button type="button" class="btn btn-xs btn-default" onclick="inactiveCompany(\'' . $companies->id . '\')">Inactive</button>&nbsp;';
                    } else {
                        $status = "Inactive";
                        $button .= '<button type="button" class="btn btn-xs btn-primary" onclick="activeCompany(\'' . $companies->id . '\')">Active</button>&nbsp;';
                    }

                    $button .= '<button type="button" class="btn btn-xs btn-warning" onclick="window.location=\'' . URL::action('AdminController@editCompany', $companies->id) . '\'">Edit <i class="fa fa-pencil"></i></button>&nbsp;';
                    $button .= '<button type="button" class="btn btn-xs btn-danger" onclick="deleteCompany(\'' . $companies->id . '\')">Delete <i class="fa fa-trash"></i></button>';
                } else {
                    if ($companies->is_active == 1) {
                        $status = "Aktif";
                        $button .= '<button type="button" class="btn btn-xs btn-default" onclick="inactiveCompany(\'' . $companies->id . '\')">Aktif</button>&nbsp;';
                    } else {
                        $status = "Tidak Aktif";
                        $button .= '<button type="button" class="btn btn-xs btn-primary" onclick="activeCompany(\'' . $companies->id . '\')">Tidak Aktif</button>&nbsp;';
                    }

                    $button .= '<button type="button" class="btn btn-xs btn-warning" onclick="window.location=\'' . URL::action('AdminController@editCompany', $companies->id) . '\'">Edit <i class="fa fa-pencil"></i></button>&nbsp;';
                    $button .= '<button type="button" class="btn btn-xs btn-danger" onclick="deleteCompany(\'' . $companies->id . '\')">Padam <i class="fa fa-trash"></i></button>';
                }

                $data_raw = array(
                    $companies->name,
                    $companies->short_name,
                    $companies->email,
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

    public function inactiveCompany() {
        $data = Input::all();
        if (Request::ajax()) {

            $id = $data['id'];

            $company = Company::find($id);
            $company->is_active = 0;
            $updated = $company->save();
            if ($updated) {
                # Audit Trail
                $remarks = 'Company: ' . $company->description . ' has been updated.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "Master Setup";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    public function activeCompany() {
        $data = Input::all();
        if (Request::ajax()) {

            $id = $data['id'];

            $company = Company::find($id);
            $company->is_active = 1;
            $updated = $company->save();
            if ($updated) {
                # Audit Trail
                $remarks = 'Company: ' . $company->description . ' has been updated.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "Master Setup";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    public function deleteCompany() {
        $data = Input::all();
        if (Request::ajax()) {

            $id = $data['id'];

            $company = Company::find($id);
            $company->is_deleted = 1;
            $deleted = $company->save();
            if ($deleted) {
                # Audit Trail
                $remarks = 'Company: ' . $company->description . ' has been deleted.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "Master Setup";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    public function addCompany() {
        //get user permission
        $user_permission = AccessGroup::getAccessPermission(Auth::user()->id);
        $city = City::where('is_active', 1)->where('is_deleted', 0)->orderBy('description', 'asc')->get();
        $country = Country::where('is_active', 1)->where('is_deleted', 0)->orderBy('name', 'asc')->get();
        $state = State::where('is_active', 1)->where('is_deleted', 0)->orderBy('name', 'asc')->get();

        if (Session::get('lang') == "en") {
            $viewData = array(
                'title' => 'Add Organization Profile',
                'panel_nav_active' => 'admin_panel',
                'main_nav_active' => 'admin_main',
                'sub_nav_active' => 'profile_list',
                'user_permission' => $user_permission,
                'city' => $city,
                'country' => $country,
                'state' => $state,
                'image' => ""
            );

            return View::make('admin_en.add_company', $viewData);
        } else {
            $viewData = array(
                'title' => 'Add Profil Organisasi',
                'panel_nav_active' => 'admin_panel',
                'main_nav_active' => 'admin_main',
                'sub_nav_active' => 'profile_list',
                'user_permission' => $user_permission,
                'city' => $city,
                'country' => $country,
                'state' => $state,
                'image' => ""
            );

            return View::make('admin_my.add_company', $viewData);
        }
    }

    public function submitAddCompany() {
        $data = Input::all();
        if (Request::ajax()) {
            $name = $data['name'];
            $short_name = $data['short_name'];
            $rob_roc_no = $data['rob_roc_no'];
            $address1 = $data['address1'];
            $address2 = $data['address2'];
            $address3 = $data['address3'];
            $city = $data['city'];
            $poscode = $data['poscode'];
            $state = $data['state'];
            $country = $data['country'];
            $phone_no = $data['phone_no'];
            $fax_no = $data['fax_no'];
            $email = $data['email'];
            $image_url = $data['image_url'];
            $nav_image_url = $data['nav_image_url'];

            $company = new Company();
            $company->name = $name;
            $company->short_name = $short_name;
            $company->rob_roc_no = $rob_roc_no;
            $company->address1 = $address1;
            $company->address2 = $address2;
            $company->address3 = $address3;
            $company->city = $city;
            $company->poscode = $poscode;
            $company->state = $state;
            $company->country = $country;
            $company->phone_no = $phone_no;
            $company->fax_no = $fax_no;
            $company->email = $email;
            $company->image_url = $image_url;
            $company->nav_image_url = $nav_image_url;
            $success = $company->save();

            if ($success) {
                # Audit Trail
                $remarks = 'Organization Profile has been added.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "System Administration";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    public function editCompany($id) {
        //get user permission
        $user_permission = AccessGroup::getAccessPermission(Auth::user()->id);

        $company = Company::find($id);
        if ($company) {
            $city = City::where('is_active', 1)->where('is_deleted', 0)->orderBy('description', 'asc')->get();
            $country = Country::where('is_active', 1)->where('is_deleted', 0)->orderBy('name', 'asc')->get();
            $state = State::where('is_active', 1)->where('is_deleted', 0)->orderBy('name', 'asc')->get();

            if (Session::get('lang') == "en") {
                $viewData = array(
                    'title' => 'Edit Organization Profile',
                    'panel_nav_active' => 'admin_panel',
                    'main_nav_active' => 'admin_main',
                    'sub_nav_active' => 'profile_list',
                    'user_permission' => $user_permission,
                    'company' => $company,
                    'city' => $city,
                    'country' => $country,
                    'state' => $state,
                    'image' => ""
                );

                return View::make('admin_en.edit_company', $viewData);
            } else {
                $viewData = array(
                    'title' => 'Edit Profil Organisasi',
                    'panel_nav_active' => 'admin_panel',
                    'main_nav_active' => 'admin_main',
                    'sub_nav_active' => 'profile_list',
                    'user_permission' => $user_permission,
                    'company' => $company,
                    'city' => $city,
                    'country' => $country,
                    'state' => $state,
                    'image' => ""
                );

                return View::make('admin_my.edit_company', $viewData);
            }
        }
    }

    public function submitEditCompany() {
        $data = Input::all();
        if (Request::ajax()) {

            $id = $data['id'];
            $name = $data['name'];
            $short_name = $data['short_name'];
            $rob_roc_no = $data['rob_roc_no'];
            $address1 = $data['address1'];
            $address2 = $data['address2'];
            $address3 = $data['address3'];
            $city = $data['city'];
            $poscode = $data['poscode'];
            $state = $data['state'];
            $country = $data['country'];
            $phone_no = $data['phone_no'];
            $fax_no = $data['fax_no'];
            $email = $data['email'];
            $image_url = $data['image_url'];
            $nav_image_url = $data['nav_image_url'];

            $company = Company::find($id);
            if (count($company) > 0) {
                $company->name = $name;
                $company->short_name = $short_name;
                $company->rob_roc_no = $rob_roc_no;
                $company->address1 = $address1;
                $company->address2 = $address2;
                $company->address3 = $address3;
                $company->city = $city;
                $company->poscode = $poscode;
                $company->state = $state;
                $company->country = $country;
                $company->phone_no = $phone_no;
                $company->fax_no = $fax_no;
                $company->email = $email;
                $company->image_url = $image_url;
                $company->nav_image_url = $nav_image_url;
                $success = $company->save();

                if ($success) {
                    # Audit Trail
                    $remarks = 'Organization Profile has been updated.';
                    $auditTrail = new AuditTrail();
                    $auditTrail->module = "System Administration";
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

    //Access Group
    public function accessGroups() {
        //get user permission
        $user_permission = AccessGroup::getAccessPermission(Auth::user()->id);

        if (Session::get('lang') == "en") {
            $viewData = array(
                'title' => 'Access Group Management',
                'panel_nav_active' => 'admin_panel',
                'main_nav_active' => 'admin_main',
                'sub_nav_active' => 'access_group_list',
                'user_permission' => $user_permission,
                'image' => ""
            );

            return View::make('page_en.accessgroup', $viewData);
        } else {
            $viewData = array(
                'title' => 'Akses Kumpulan',
                'panel_nav_active' => 'admin_panel',
                'main_nav_active' => 'admin_main',
                'sub_nav_active' => 'access_group_list',
                'user_permission' => $user_permission,
                'image' => ""
            );

            return View::make('page_my.accessgroup', $viewData);
        }
    }

    public function addAccessGroup() {
        //get user permission
        $user_permission = AccessGroup::getAccessPermission(Auth::user()->id);
        $module = Module::get();

        if (Session::get('lang') == "en") {
            $viewData = array(
                'title' => 'Add Access Group',
                'panel_nav_active' => 'admin_panel',
                'main_nav_active' => 'admin_main',
                'sub_nav_active' => 'access_group_list',
                'user_permission' => $user_permission,
                'module' => $module,
                'image' => ""
            );

            return View::make('page_en.add_accessgroup', $viewData);
        } else {
            $viewData = array(
                'title' => 'Tambah Akses Kumpulan',
                'panel_nav_active' => 'admin_panel',
                'main_nav_active' => 'admin_main',
                'sub_nav_active' => 'access_group_list',
                'user_permission' => $user_permission,
                'module' => $module,
                'image' => ""
            );

            return View::make('page_my.add_accessgroup', $viewData);
        }
    }

    public function submitAccessGroup() {

        $data = Input::all();
        if (Request::ajax()) {

            $description = $data['description'];
            $is_active = $data['is_active'];
            $remarks = $data['remarks'];

            $role = new Role();
            $role->name = $description;
            $role->is_active = $is_active;
            $role->remarks = $remarks;
            $success = $role->save();

            if ($success) {
                # Audit Trail
                $remarks = 'Role : ' . $role->name . ' has been inserted.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "System Administration";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                $permission = array();

                $selected_access = array();
                $selected_access_raw = $data['selected_access'];
                if ($selected_access_raw != "") {
                    $selected_access2 = explode('&', $selected_access_raw);
                    foreach ($selected_access2 as $selected_access2) {
                        $selected_access3 = explode('=', $selected_access2);
                        $selected_access = array(
                            "action" => "access",
                            "module_id" => $selected_access3[1]
                        );

                        $permission[] = $selected_access;
                    }
                }

                $selected_insert = array();
                $selected_insert_raw = $data['selected_insert'];
                if ($selected_insert_raw != "") {
                    $selected_insert2 = explode('&', $selected_insert_raw);
                    foreach ($selected_insert2 as $selected_insert2) {
                        $selected_insert3 = explode('=', $selected_insert2);
                        $selected_insert = array(
                            "action" => "insert",
                            "module_id" => $selected_insert3[1]
                        );

                        $permission[] = $selected_insert;
                    }
                }

                $selected_update = array();
                $selected_update_raw = $data['selected_update'];
                if ($selected_update_raw != "") {
                    $selected_update2 = explode('&', $selected_update_raw);
                    foreach ($selected_update2 as $selected_update2) {
                        $selected_update3 = explode('=', $selected_update2);
                        $selected_update = array(
                            "action" => "update",
                            "module_id" => $selected_update3[1]
                        );

                        $permission[] = $selected_update;
                    }
                }

                $tmp = array();
                foreach ($permission as $permission) {
                    $tmp[$permission['module_id']][] = $permission['action'];
                }

                $output2 = array();
                foreach ($tmp as $type => $labels) {
                    $output2[] = array(
                        'action' => $type,
                        'module_id' => $labels
                    );
                }

                $permission_list = array();
                foreach ($output2 as $output2) {
                    $permission_list[] = array(
                        'module_id' => $output2['action'],
                        'action' => $output2['module_id']
                    );
                }

                foreach ($permission_list as $permission_lists) {
                    $new_permission = new AccessGroup();

                    $new_permission->submodule_id = $permission_lists['module_id'];
                    $new_permission->role_id = $role->id;

                    //default value is 0
                    $new_permission->access_permission = 0;
                    $new_permission->insert_permission = 0;
                    $new_permission->update_permission = 0;

                    foreach ($permission_lists['action'] as $action) {
                        if ($action == "access") {
                            $new_permission->access_permission = 1;
                        }
                        if ($action == "insert") {
                            $new_permission->insert_permission = 1;
                        }
                        if ($action == "update") {
                            $new_permission->update_permission = 1;
                        }
                    }
                    $saved = $new_permission->save();
                }
                if ($saved) {
                    # Audit Trail
                    $remarks = 'Access Permission for ' . $role->name . ' has been inserted.';
                    $auditTrail = new AuditTrail();
                    $auditTrail->module = "System Administration";
                    $auditTrail->remarks = $remarks;
                    $auditTrail->audit_by = Auth::user()->id;
                    $auditTrail->save();

                    return "true";
                } else {
                    return "false";
                }
            }
        }
    }

    public function getAccessGroups() {
        $accessgroup = Role::where('is_deleted', 0)->orderBy('id', 'desc')->get();

        if (count($accessgroup) > 0) {
            $data = Array();
            foreach ($accessgroup as $accessgroups) {
                $button = "";
                if (Session::get('lang') == "en") {
                    if ($accessgroups->is_active == 1) {
                        $status = "Active";
                        $button .= '<button type="button" class="btn btn-xs btn-primary" onclick="inactiveAccessGroup(\'' . $accessgroups->id . '\')">Inactive</button>&nbsp;';
                    } else {
                        $status = "Inactive";
                        $button .= '<button type="button" class="btn btn-xs btn-primary" onclick="activeAccessGroup(\'' . $accessgroups->id . '\')">Active</button>&nbsp;';
                    }
                } else {
                    if ($accessgroups->is_active == 1) {
                        $status = "Aktif";
                        $button .= '<button type="button" class="btn btn-xs btn-primary" onclick="inactiveAccessGroup(\'' . $accessgroups->id . '\')">Tidak Aktif</button>&nbsp;';
                    } else {
                        $status = "Tidak Aktif";
                        $button .= '<button type="button" class="btn btn-xs btn-primary" onclick="activeAccessGroup(\'' . $accessgroups->id . '\')">Aktif</button>&nbsp;';
                    }
                }
                $button .= '<button type="button" class="btn btn-xs btn-success" onclick="window.location=\'' . URL::action('AdminController@updateAccessGroup', $accessgroups->id) . '\'"><i class="fa fa-pencil"></i></button>&nbsp;';
                $button .= '<button class="btn btn-xs btn-danger" onclick="deleteAccessGroup(\'' . $accessgroups->id . '\')"><i class="fa fa-trash"></i></button>';

                $data_raw = array(
                    $accessgroups->name,
                    $accessgroups->remarks,
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

    public function inactiveAccessGroup() {
        $data = Input::all();
        if (Request::ajax()) {

            $id = $data['id'];

            $role = Role::find($id);
            if (count($role) > 0) {
                $role->is_active = 0;
                $updated = $role->save();
                if ($updated) {
                    # Audit Trail
                    $remarks = 'Role : ' . $role->name . ' has been updated.';
                    $auditTrail = new AuditTrail();
                    $auditTrail->module = "System Administration";
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

    public function activeAccessGroup() {
        $data = Input::all();
        if (Request::ajax()) {

            $id = $data['id'];

            $role = Role::find($id);
            if (count($role) > 0) {
                $role->is_active = 1;
                $updated = $role->save();
                if ($updated) {
                    # Audit Trail
                    $remarks = 'Role : ' . $role->name . ' has been updated.';
                    $auditTrail = new AuditTrail();
                    $auditTrail->module = "System Administration";
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

    public function deleteAccessGroup() {
        $data = Input::all();
        if (Request::ajax()) {

            $id = $data['id'];

            $role = Role::find($id);
            if (count($role) > 0) {
                $role->is_deleted = 1;
                $deleted = $role->save();
                if ($deleted) {
                    # Audit Trail
                    $remarks = 'Role : ' . $role->name . ' has been updated.';
                    $auditTrail = new AuditTrail();
                    $auditTrail->module = "System Administration";
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

    public function updateAccessGroup($id) {
        //get user permission
        $user_permission = AccessGroup::getAccessPermission(Auth::user()->id);
        $accessgroup = Role::find($id);
        $module = Module::get();

        if (Session::get('lang') == "en") {
            $viewData = array(
                'title' => 'Update Access Group',
                'panel_nav_active' => 'admin_panel',
                'main_nav_active' => 'admin_main',
                'sub_nav_active' => 'access_group_list',
                'user_permission' => $user_permission,
                'accessgroup' => $accessgroup,
                'module' => $module,
                'image' => ""
            );

            return View::make('page_en.update_accessgroup', $viewData);
        } else {
            $viewData = array(
                'title' => 'Edit Akses Kumpulan',
                'panel_nav_active' => 'admin_panel',
                'main_nav_active' => 'admin_main',
                'sub_nav_active' => 'access_group_list',
                'user_permission' => $user_permission,
                'accessgroup' => $accessgroup,
                'module' => $module,
                'image' => ""
            );

            return View::make('page_my.update_accessgroup', $viewData);
        }
    }

    public function submitUpdateAccessGroup() {

        $data = Input::all();
        if (Request::ajax()) {

            $role_id = $data['role_id'];
            $description = $data['description'];
            $is_active = $data['is_active'];
            $remarks = $data['remarks'];

            $role = Role::find($role_id);
            $role->name = $description;
            $role->is_active = $is_active;
            $role->remarks = $remarks;
            $success = $role->save();

            if ($success) {
                # Audit Trail
                $remarks = 'Role : ' . $role->name . ' has been updated.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "System Administration";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                $permission = array();

                $selected_access = array();
                $selected_access_raw = $data['selected_access'];
                if ($selected_access_raw != "") {
                    $selected_access2 = explode('&', $selected_access_raw);
                    foreach ($selected_access2 as $selected_access2) {
                        $selected_access3 = explode('=', $selected_access2);
                        $selected_access = array(
                            "action" => "access",
                            "module_id" => $selected_access3[1]
                        );

                        $permission[] = $selected_access;
                    }
                }

                $selected_insert = array();
                $selected_insert_raw = $data['selected_insert'];
                if ($selected_insert_raw != "") {
                    $selected_insert2 = explode('&', $selected_insert_raw);
                    foreach ($selected_insert2 as $selected_insert2) {
                        $selected_insert3 = explode('=', $selected_insert2);
                        $selected_insert = array(
                            "action" => "insert",
                            "module_id" => $selected_insert3[1]
                        );

                        $permission[] = $selected_insert;
                    }
                }

                $selected_update = array();
                $selected_update_raw = $data['selected_update'];
                if ($selected_update_raw != "") {
                    $selected_update2 = explode('&', $selected_update_raw);
                    foreach ($selected_update2 as $selected_update2) {
                        $selected_update3 = explode('=', $selected_update2);
                        $selected_update = array(
                            "action" => "update",
                            "module_id" => $selected_update3[1]
                        );

                        $permission[] = $selected_update;
                    }
                }

                $tmp = array();
                foreach ($permission as $permissions) {
                    $tmp[$permissions['module_id']][] = $permissions['action'];
                }

                $output2 = array();
                foreach ($tmp as $type => $labels) {
                    $output2[] = array(
                        'action' => $type,
                        'module_id' => $labels
                    );
                }

                $permission_list = array();
                foreach ($output2 as $output3) {
                    $permission_list[] = array(
                        'module_id' => $output3['action'],
                        'action' => $output3['module_id']
                    );
                }

                //delete the access permission in db before add new
                $deleted = AccessGroup::where('role_id', $role_id)->delete();

                foreach ($permission_list as $permission_lists) {
                    $new_permission = new AccessGroup();

                    $new_permission->submodule_id = $permission_lists['module_id'];
                    $new_permission->role_id = $role->id;

                    //default value is 0
                    $new_permission->access_permission = 0;
                    $new_permission->insert_permission = 0;
                    $new_permission->update_permission = 0;

                    foreach ($permission_lists['action'] as $actions) {
                        if ($actions == "access") {
                            $new_permission->access_permission = 1;
                        }
                        if ($actions == "insert") {
                            $new_permission->insert_permission = 1;
                        }
                        if ($actions == "update") {
                            $new_permission->update_permission = 1;
                        }
                    }
                    $saved = $new_permission->save();
                }
                if ($saved) {
                    # Audit Trail
                    $remarks = 'Access Permission for ' . $role->name . ' has been updated.';
                    $auditTrail = new AuditTrail();
                    $auditTrail->module = "System Administration";
                    $auditTrail->remarks = $remarks;
                    $auditTrail->audit_by = Auth::user()->id;
                    $auditTrail->save();

                    return "true";
                } else {
                    return "false";
                }
            }
        }
    }

    //user
    public function user() {
        //get user permission
        $user_permission = AccessGroup::getAccessPermission(Auth::user()->id);

        if (Session::get('lang') == "en") {
            $viewData = array(
                'title' => 'User Management',
                'panel_nav_active' => 'admin_panel',
                'main_nav_active' => 'admin_main',
                'sub_nav_active' => 'user_list',
                'user_permission' => $user_permission,
                'image' => ""
            );

            return View::make('admin_en.user', $viewData);
        } else {
            $viewData = array(
                'title' => 'Pengurusan Pengguna',
                'panel_nav_active' => 'admin_panel',
                'main_nav_active' => 'admin_main',
                'sub_nav_active' => 'user_list',
                'user_permission' => $user_permission,
                'image' => ""
            );

            return View::make('admin_my.user', $viewData);
        }
    }

    public function addUser() {
        //get user permission
        $user_permission = AccessGroup::getAccessPermission(Auth::user()->id);
        $company = Company::where('is_active', 1)->where('is_deleted', 0)->orderBy('name')->get();
        $role = Role::where('is_active', 1)->where('is_deleted', 0)->orderBy('name')->get();

        if (Session::get('lang') == "en") {
            $viewData = array(
                'title' => 'Add User',
                'panel_nav_active' => 'admin_panel',
                'main_nav_active' => 'admin_main',
                'sub_nav_active' => 'user_list',
                'user_permission' => $user_permission,
                'company' => $company,
                'role' => $role,
                'image' => ""
            );

            return View::make('admin_en.add_user', $viewData);
        } else {
            $viewData = array(
                'title' => 'Tambah Pengguna',
                'panel_nav_active' => 'admin_panel',
                'main_nav_active' => 'admin_main',
                'sub_nav_active' => 'user_list',
                'user_permission' => $user_permission,
                'company' => $company,
                'role' => $role,
                'image' => ""
            );

            return View::make('admin_my.add_user', $viewData);
        }
    }

    public function submitUser() {
        $data = Input::all();
        if (Request::ajax()) {

            $username = $data['username'];
            $password = $data['password'];
            $name = $data['name'];
            $email = $data['email'];
            $phone_no = $data['phone_no'];
            $role = $data['role'];
            $company = $data['company'];
            $remarks = $data['remarks'];
            $is_active = $data['is_active'];

            $check_username = User::where('username', $username)->count();

            if ($check_username <= 0) {
                $user = new User();
                $user->username = $username;
                $user->password = Hash::make($password);
                $user->full_name = $name;
                $user->email = $email;
                $user->phone_no = $phone_no;
                $user->role = $role;
                $user->company_id = $company;
                $user->remarks = $remarks;
                $user->is_active = $is_active;
                $user->status = 1;
                $user->approved_by = Auth::user()->id;
                $user->approved_at = date('Y-m-d H:i:s');
                $user->is_deleted = 0;
                $success = $user->save();

                if ($success) {
                    # Audit Trail
                    $remarks = 'User ' . $user->username . ' has been inserted.';
                    $auditTrail = new AuditTrail();
                    $auditTrail->module = "System Administration";
                    $auditTrail->remarks = $remarks;
                    $auditTrail->audit_by = Auth::user()->id;
                    $auditTrail->save();

                    print "true";
                } else {
                    print "false";
                }
            } else {
                print "username_in_use";
            }
        }
    }

    public function getUser() {
        $user = User::where('is_deleted', 0)->orderBy('id', 'desc')->get();

        if (count($user) > 0) {
            $data = Array();
            foreach ($user as $users) {
                $role = Role::find($users->role);

                $button = "";
                if (Session::get('lang') == "en") {
                    if ($users->is_active == 1) {
                        $is_active = "Yes";
                        if ($users->status == 1) {
                            $button .= '<button type="button" class="btn btn-xs btn-primary" onclick="inactiveUser(\'' . $users->id . '\')">Inactive</button>&nbsp;';
                        }
                    } else {
                        $is_active = "No";
                        if ($users->status == 1) {
                            $button .= '<button type="button" class="btn btn-xs btn-primary" onclick="activeUser(\'' . $users->id . '\')">Active</button>&nbsp;';
                        }
                    }

                    if ($users->status == 0) {
                        $status = "Pending";
                    } else if ($users->status == 1) {
                        $status = "Approved";
                    } else {
                        $status = "Rejected";
                    }
                } else {
                    if ($users->is_active == 1) {
                        $is_active = "Ya";
                        if ($users->status == 1) {
                            $button .= '<button type="button" class="btn btn-xs btn-primary" onclick="inactiveUser(\'' . $users->id . '\')">Tidak Aktif</button>&nbsp;';
                        }
                    } else {
                        $is_active = "Tidak";
                        if ($users->status == 1) {
                            $button .= '<button type="button" class="btn btn-xs btn-primary" onclick="activeUser(\'' . $users->id . '\')">Aktif</button>&nbsp;';
                        }
                    }

                    if ($users->status == 0) {
                        $status = "Menunggu";
                    } else if ($users->status == 1) {
                        $status = "Diterima";
                    } else {
                        $status = "Ditolak";
                    }
                }
                $button .= '<button type="button" class="btn btn-xs btn-success" onclick="window.location=\'' . URL::action('AdminController@updateUser', $users->id) . '\'" title="Edit"><i class="fa fa-pencil"></i></button>&nbsp;';
                $button .= '<button type="button" class="btn btn-xs btn-warning" onclick="window.location=\'' . URL::action('AdminController@getUserDetails', $users->id) . '\'" title="View"><i class="fa fa-eye"></i></button>&nbsp;';
                $button .= '<button class="btn btn-xs btn-danger" onclick="deleteUser(\'' . $users->id . '\')" title="Delete"><i class="fa fa-trash"></i></button>';

                $data_raw = array(
                    $users->username,
                    $users->full_name,
                    $users->email,
                    $role->name,
                    $is_active,
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

    public function getUserDetails($id) {
        //get user permission
        $user_permission = AccessGroup::getAccessPermission(Auth::user()->id);
        $user = User::find($id);
        $company = Company::find($user->company_id);

        if (Session::get('lang') == "en") {
            $viewData = array(
                'title' => 'User Details',
                'panel_nav_active' => 'admin_panel',
                'main_nav_active' => 'admin_main',
                'sub_nav_active' => 'user_list',
                'user_permission' => $user_permission,
                'user' => $user,
                'company' => $company,
                'image' => ""
            );

            return View::make('admin_en.user_details', $viewData);
        } else {
            $viewData = array(
                'title' => 'Maklumat Pengguna',
                'panel_nav_active' => 'admin_panel',
                'main_nav_active' => 'admin_main',
                'sub_nav_active' => 'user_list',
                'user_permission' => $user_permission,
                'user' => $user,
                'company' => $company,
                'image' => ""
            );

            return View::make('admin_my.user_details', $viewData);
        }
    }

    public function submitApprovedUser() {
        $data = Input::all();

        if (Request::ajax()) {
            $id = $data['id'];
            $status = $data['status'];
            $remark = $data['remarks'];

            $user = User::find($id);
            $user->status = $status;
            $user->approved_by = Auth::user()->id;
            $user->approved_at = date('Y-m-d H:i:s');
            $user->remarks = $remark;
            if ($status == 1) {
                $user->is_active = 1;
            }
            $success = $user->save();

            if ($success) {
                # Audit Trail
                $remarks = 'User ' . $user->username . ' has been approved.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "System Administration";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    public function inactiveUser() {
        $data = Input::all();
        if (Request::ajax()) {

            $id = $data['id'];

            $user = User::find($id);
            $user->is_active = 0;
            $updated = $user->save();
            if ($updated) {
                # Audit Trail
                $remarks = 'User ' . $user->username . ' has been updated.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "System Administration";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    public function activeUser() {
        $data = Input::all();
        if (Request::ajax()) {

            $id = $data['id'];

            $user = User::find($id);
            $user->is_active = 1;
            $updated = $user->save();
            if ($updated) {
                # Audit Trail
                $remarks = 'User ' . $user->username . ' has been updated.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "System Administration";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    public function deleteUser() {
        $data = Input::all();
        if (Request::ajax()) {

            $id = $data['id'];

            $user = User::find($id);
            $user->is_deleted = 1;
            $deleted = $user->save();
            if ($deleted) {
                # Audit Trail
                $remarks = 'User ' . $user->username . ' has been deleted.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "System Administration";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    public function updateUser($id) {
        //get user permission
        $user_permission = AccessGroup::getAccessPermission(Auth::user()->id);
        $user = User::find($id);
        $role = Role::where('is_active', 1)->where('is_deleted', 0)->orderBy('name')->get();
        $company = Company::where('is_active', 1)->where('is_deleted', 0)->orderBy('name')->get();

        if (Session::get('lang') == "en") {
            $viewData = array(
                'title' => 'Update User',
                'panel_nav_active' => 'admin_panel',
                'main_nav_active' => 'admin_main',
                'sub_nav_active' => 'user_list',
                'user_permission' => $user_permission,
                'user' => $user,
                'role' => $role,
                'company' => $company,
                'image' => ""
            );

            return View::make('admin_en.update_user', $viewData);
        } else {
            $viewData = array(
                'title' => 'Edit Pengguna',
                'panel_nav_active' => 'admin_panel',
                'main_nav_active' => 'admin_main',
                'sub_nav_active' => 'user_list',
                'user_permission' => $user_permission,
                'user' => $user,
                'role' => $role,
                'company' => $company,
                'image' => ""
            );

            return View::make('admin_my.update_user', $viewData);
        }
    }

    public function submitUpdateUser() {
        $data = Input::all();
        if (Request::ajax()) {
            $id = $data['id'];
            $name = $data['name'];
            $email = $data['email'];
            $phone_no = $data['phone_no'];
            $remarks = $data['remarks'];
            $role = $data['role'];
            $company = $data['company'];
            $is_active = $data['is_active'];

            $user = User::find($id);
            $user->full_name = $name;
            $user->email = $email;
            $user->phone_no = $phone_no;
            $user->role = $role;
            $user->company_id = $company;
            $user->remarks = $remarks;
            $user->is_active = $is_active;
            $success = $user->save();

            if ($success) {
                # Audit Trail
                $remarks = 'User ' . $user->username . ' has been updated.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "System Administration";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    //memo
    public function memo() {
        //get user permission
        $user_permission = AccessGroup::getAccessPermission(Auth::user()->id);
        $memotype = MemoType::where('is_active', 1)->where('is_deleted', 0)->get();

        if (Session::get('lang') == "en") {
            $viewData = array(
                'title' => 'Memo Management',
                'panel_nav_active' => 'admin_panel',
                'main_nav_active' => 'admin_main',
                'sub_nav_active' => 'memo_maintenence_list',
                'user_permission' => $user_permission,
                'memotype' => $memotype,
                'image' => ""
            );

            return View::make('page_en.memo', $viewData);
        } else {
            $viewData = array(
                'title' => 'Pengurusan Memo',
                'panel_nav_active' => 'admin_panel',
                'main_nav_active' => 'admin_main',
                'sub_nav_active' => 'memo_maintenence_list',
                'user_permission' => $user_permission,
                'memotype' => $memotype,
                'image' => ""
            );

            return View::make('page_my.memo', $viewData);
        }
    }

    public function addMemo() {
        //get user permission
        $user_permission = AccessGroup::getAccessPermission(Auth::user()->id);
        $memotype = MemoType::where('is_active', 1)->where('is_deleted', 0)->get();

        if (Session::get('lang') == "en") {
            $viewData = array(
                'title' => 'Add Memo',
                'panel_nav_active' => 'admin_panel',
                'main_nav_active' => 'admin_main',
                'sub_nav_active' => 'memo_maintenence_list',
                'user_permission' => $user_permission,
                'memotype' => $memotype,
                'image' => ""
            );

            return View::make('page_en.add_memo', $viewData);
        } else {
            $viewData = array(
                'title' => 'Tambah Memo',
                'panel_nav_active' => 'admin_panel',
                'main_nav_active' => 'admin_main',
                'sub_nav_active' => 'memo_maintenence_list',
                'user_permission' => $user_permission,
                'memotype' => $memotype,
                'image' => ""
            );

            return View::make('page_my.add_memo', $viewData);
        }
    }

    public function submitMemo() {
        $data = Input::all();
        if (Request::ajax()) {

            $memo_type = $data['memo_type'];
            $memo_date = $data['memo_date'];
            $publish_date = $data['publish_date'];
            $expired_date = $data['expired_date'];
            $subject = $data['subject'];
            $description = $data['description'];
            $remarks = $data['remarks'];
            $is_active = $data['is_active'];

            $memo = new Memo();
            $memo->memo_type_id = $memo_type;
            $memo->memo_date = $memo_date;
            $memo->publish_date = $publish_date;
            $memo->expired_date = $expired_date;
            $memo->subject = $subject;
            $memo->description = $description;
            $memo->remarks = $remarks;
            $memo->is_active = $is_active;
            $success = $memo->save();

            if ($success) {
                # Audit Trail
                $remarks = $memo->subject . ' has been inserted.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "Memo";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    public function getMemo() {
        $memo = Memo::where('is_deleted', 0)->orderBy('id', 'desc')->get();

        if (count($memo) > 0) {
            $data = Array();
            foreach ($memo as $memos) {
                $memotype = MemoType::find($memos->memo_type_id);

                $button = "";
                if (Session::get('lang') == "en") {
                    if ($memos->is_active == 1) {
                        $status = "Active";
                        $button .= '<button type="button" class="btn btn-xs btn-primary" onclick="inactiveMemo(\'' . $memos->id . '\')">Inactive</button>&nbsp;';
                    } else {
                        $status = "Inactive";
                        $button .= '<button type="button" class="btn btn-xs btn-primary" onclick="activeMemo(\'' . $memos->id . '\')">Active</button>&nbsp;';
                    }
                } else {
                    if ($memos->is_active == 1) {
                        $status = "Aktif";
                        $button .= '<button type="button" class="btn btn-xs btn-primary" onclick="inactiveMemo(\'' . $memos->id . '\')">Tidak Aktif</button>&nbsp;';
                    } else {
                        $status = "Tidak Aktif";
                        $button .= '<button type="button" class="btn btn-xs btn-primary" onclick="activeMemo(\'' . $memos->id . '\')">Aktif</button>&nbsp;';
                    }
                }
                $button .= '<button type="button" class="btn btn-xs btn-success" onclick="window.location=\'' . URL::action('AdminController@updateMemo', $memos->id) . '\'"><i class="fa fa-pencil"></i></button>&nbsp;';
                $button .= '<button class="btn btn-xs btn-danger" onclick="deleteMemo(\'' . $memos->id . '\')"><i class="fa fa-trash"></i></button>';

                if ($memos->expired_date != "0000-00-00") {
                    $expired_date = date('d-M-Y', strtotime($memos->expired_date));
                } else {
                    $expired_date = "";
                }

                $data_raw = array(
                    date('d-M-Y', strtotime($memos->memo_date)),
                    $memotype->description,
                    $memos->subject,
                    date('d-M-Y', strtotime($memos->publish_date)),
                    $expired_date,
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

    public function inactiveMemo() {
        $data = Input::all();
        if (Request::ajax()) {

            $id = $data['id'];

            $memo = Memo::find($id);
            $memo->is_active = 0;
            $updated = $memo->save();
            if ($updated) {
                # Audit Trail
                $remarks = $memo->subject . ' has been updated.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "Memo";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    public function activeMemo() {
        $data = Input::all();
        if (Request::ajax()) {

            $id = $data['id'];

            $memo = Memo::find($id);
            $memo->is_active = 1;
            $updated = $memo->save();
            if ($updated) {
                # Audit Trail
                $remarks = $memo->subject . ' has been updated.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "Memo";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    public function deleteMemo() {
        $data = Input::all();
        if (Request::ajax()) {

            $id = $data['id'];

            $memo = Memo::find($id);
            $memo->is_deleted = 1;
            $deleted = $memo->save();
            if ($deleted) {
                # Audit Trail
                $remarks = $memo->subject . ' has been deleted.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "Memo";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    public function updateMemo($id) {
        //get user permission
        $user_permission = AccessGroup::getAccessPermission(Auth::user()->id);
        $memo = Memo::find($id);
        $memotype = MemoType::where('is_active', 1)->where('is_deleted', 0)->get();

        if (Session::get('lang') == "en") {
            $viewData = array(
                'title' => 'Update Memo',
                'panel_nav_active' => 'admin_panel',
                'main_nav_active' => 'admin_main',
                'sub_nav_active' => 'memo_maintenence_list',
                'user_permission' => $user_permission,
                'memo' => $memo,
                'memotype' => $memotype,
                'image' => ""
            );

            return View::make('page_en.update_memo', $viewData);
        } else {
            $viewData = array(
                'title' => 'Edit Memo',
                'panel_nav_active' => 'admin_panel',
                'main_nav_active' => 'admin_main',
                'sub_nav_active' => 'memo_maintenence_list',
                'user_permission' => $user_permission,
                'memo' => $memo,
                'memotype' => $memotype,
                'image' => ""
            );

            return View::make('page_my.update_memo', $viewData);
        }
    }

    public function submitUpdateMemo() {
        $data = Input::all();
        if (Request::ajax()) {
            $id = $data['id'];
            $memo_type = $data['memo_type'];
            $memo_date = $data['memo_date'];
            $publish_date = $data['publish_date'];
            $expired_date = $data['expired_date'];
            $subject = $data['subject'];
            $description = $data['description'];
            $remarks = $data['remarks'];
            $is_active = $data['is_active'];

            $memo = Memo::find($id);
            $memo->memo_type_id = $memo_type;
            $memo->memo_date = $memo_date;
            $memo->publish_date = $publish_date;
            $memo->expired_date = $expired_date;
            $memo->subject = $subject;
            $memo->description = $description;
            $memo->remarks = $remarks;
            $memo->is_active = $is_active;
            $success = $memo->save();

            if ($success) {
                # Audit Trail
                $remarks = $memo->subject . ' has been updated.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "Memo";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    //form
    public function form() {
        //get user permission
        $user_permission = AccessGroup::getAccessPermission(Auth::user()->id);
        $formtype = FormType::where('is_active', 1)->where('is_deleted', 0)->orderby('sort_no', 'asc')->get();

        if (Session::get('lang') == "en") {
            $viewData = array(
                'title' => 'Form',
                'panel_nav_active' => 'admin_panel',
                'main_nav_active' => 'admin_main',
                'sub_nav_active' => 'form_list',
                'user_permission' => $user_permission,
                'formtype' => $formtype,
                'image' => ""
            );

            return View::make('admin_en.form', $viewData);
        } else {
            $viewData = array(
                'title' => 'Borang',
                'panel_nav_active' => 'admin_panel',
                'main_nav_active' => 'admin_main',
                'sub_nav_active' => 'form_list',
                'user_permission' => $user_permission,
                'formtype' => $formtype,
                'image' => ""
            );

            return View::make('admin_my.form', $viewData);
        }
    }

    public function getForm() {
        $form = AdminForm::where('is_deleted', 0)->orderBy('id', 'desc')->get();
        if (count($form) > 0) {
            $data = Array();

            if (Session::get('lang') == "en") {
                foreach ($form as $forms) {
                    $formtype = FormType::find($forms->form_type_id);

                    $button = "";
                    if ($forms->is_active == 1) {
                        $status = 'Active';
                        $button .= '<button type="button" class="btn btn-xs btn-default" onclick="inactiveForm(\'' . $forms->id . '\')">Inactive</button>&nbsp;';
                    } else {
                        $status = 'Inactive';
                        $button .= '<button type="button" class="btn btn-xs btn-primary" onclick="activeForm(\'' . $forms->id . '\')">Active</button>&nbsp;';
                    }

                    $button .= '<button type="button" class="btn btn-xs btn-success" onclick="window.location=\'' . URL::action('AdminController@updateForm', $forms->id) . '\'">Edit <i class="fa fa-pencil"></i></button>&nbsp;';
                    $button .= '<button class="btn btn-xs btn-danger" onclick="deleteForm(\'' . $forms->id . '\')">Delete <i class="fa fa-trash"></i></button>';

                    $data_raw = array(
                        $formtype->name_en,
                        $forms->name_en,
                        $forms->sort_no,
                        $status,
                        $button
                    );

                    array_push($data, $data_raw);
                }
            } else {
                foreach ($form as $forms) {
                    $formtype = FormType::find($forms->form_type_id);

                    $button = "";
                    if ($forms->is_active == 1) {
                        $status = 'Aktif';
                        $button .= '<button type="button" class="btn btn-xs btn-default" onclick="inactiveForm(\'' . $forms->id . '\')">Inactive</button>&nbsp;';
                    } else {
                        $status = 'Tidak Aktif';
                        $button .= '<button type="button" class="btn btn-xs btn-primary" onclick="activeForm(\'' . $forms->id . '\')">Active</button>&nbsp;';
                    }

                    $button .= '<button type="button" class="btn btn-xs btn-success" onclick="window.location=\'' . URL::action('AdminController@updateForm', $forms->id) . '\'">Edit <i class="fa fa-pencil"></i></button>&nbsp;';
                    $button .= '<button class="btn btn-xs btn-danger" onclick="deleteForm(\'' . $forms->id . '\')">Padam <i class="fa fa-trash"></i></button>';

                    $data_raw = array(
                        $formtype->name_my,
                        $forms->name_my,
                        $forms->sort_no,
                        $status,
                        $button
                    );

                    array_push($data, $data_raw);
                }
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

    public function inactiveForm() {
        $data = Input::all();
        if (Request::ajax()) {

            $id = $data['id'];

            $form = AdminForm::find($id);
            $form->is_active = 0;
            $updated = $form->save();
            if ($updated) {
                # Audit Trail
                $remarks = 'Form: ' . $form->name_en . ' has been updated.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "Form";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    public function activeForm() {
        $data = Input::all();
        if (Request::ajax()) {

            $id = $data['id'];

            $form = AdminForm::find($id);
            $form->is_active = 1;
            $updated = $form->save();
            if ($updated) {
                # Audit Trail
                $remarks = 'Form: ' . $form->name_en . ' has been updated.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "Form";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    public function deleteForm() {
        $data = Input::all();
        if (Request::ajax()) {

            $id = $data['id'];

            $form = AdminForm::find($id);
            $form->is_deleted = 1;
            $deleted = $form->save();
            if ($deleted) {
                # Audit Trail
                $remarks = 'Form: ' . $form->name_en . ' has been deleted.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "Form";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    public function deleteFormFile() {
        $data = Input::all();
        if (Request::ajax()) {

            $id = $data['id'];

            $form = AdminForm::find($id);
            $form->file_url = "";
            $deleted = $form->save();

            if ($deleted) {
                # Audit Trail
                $remarks = 'Form: ' . $form->name_en . ' has been updated.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "Form";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    public function addForm() {
        //get user permission
        $user_permission = AccessGroup::getAccessPermission(Auth::user()->id);
        $formtype = FormType::where('is_active', 1)->where('is_deleted', 0)->orderBy('sort_no')->get();

        if (Session::get('lang') == "en") {
            $viewData = array(
                'title' => 'Add Form',
                'panel_nav_active' => 'admin_panel',
                'main_nav_active' => 'admin_main',
                'sub_nav_active' => 'form_list',
                'user_permission' => $user_permission,
                'formtype' => $formtype,
                'image' => ""
            );

            return View::make('admin_en.add_form', $viewData);
        } else {
            $viewData = array(
                'title' => 'Add Form',
                'panel_nav_active' => 'admin_panel',
                'main_nav_active' => 'admin_main',
                'sub_nav_active' => 'form_list',
                'user_permission' => $user_permission,
                'formtype' => $formtype,
                'image' => ""
            );

            return View::make('admin_my.add_form', $viewData);
        }
    }

    public function submitAddForm() {
        $data = Input::all();
        if (Request::ajax()) {

            $form = new AdminForm();
            $form->form_type_id = $data['form_type'];
            $form->name_en = $data['name_en'];
            $form->name_my = $data['name_my'];
            $form->sort_no = $data['sort_no'];
            $form->is_active = $data['is_active'];
            $form->file_url = $data['form_url'];
            $success = $form->save();

            if ($success) {
                # Audit Trail
                $remarks = 'Form: ' . $form->name_en . ' has been inserted.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "Form";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    public function updateForm($id) {
        //get user permission
        $user_permission = AccessGroup::getAccessPermission(Auth::user()->id);
        $form = AdminForm::find($id);
        $formtype = FormType::where('is_active', 1)->where('is_deleted', 0)->get();

        if (Session::get('lang') == "en") {
            $viewData = array(
                'title' => 'Edit Form',
                'panel_nav_active' => 'admin_panel',
                'main_nav_active' => 'admin_main',
                'sub_nav_active' => 'form_list',
                'user_permission' => $user_permission,
                'form' => $form,
                'formtype' => $formtype,
                'image' => ""
            );

            return View::make('admin_en.edit_form', $viewData);
        } else {
            $viewData = array(
                'title' => 'Edit Form',
                'panel_nav_active' => 'admin_panel',
                'main_nav_active' => 'admin_main',
                'sub_nav_active' => 'form_list',
                'user_permission' => $user_permission,
                'form' => $form,
                'formtype' => $formtype,
                'image' => ""
            );

            return View::make('admin_my.edit_form', $viewData);
        }
    }

    public function submitUpdateForm() {
        $data = Input::all();
        if (Request::ajax()) {
            $id = $data['id'];

            $form = AdminForm::find($id);
            if ($form) {
                $form->form_type_id = $data['form_type'];
                $form->name_en = $data['name_en'];
                $form->name_my = $data['name_my'];
                $form->sort_no = $data['sort_no'];
                $form->is_active = $data['is_active'];
                $form->file_url = $data['form_url'];
                $success = $form->save();

                if ($success) {
                    # Audit Trail
                    $remarks = $form->id . ' has been updated.';
                    $auditTrail = new AuditTrail();
                    $auditTrail->module = "Form";
                    $auditTrail->remarks = $remarks;
                    $auditTrail->audit_by = Auth::user()->id;
                    $auditTrail->save();

                    return "true";
                } else {
                    return "false";
                }
            } else {
                return 'false1';
            }
        } else {
            return "false2";
        }
    }

    // --- Master Setup --- //
    //area
    public function area() {
        //get user permission
        $user_permission = AccessGroup::getAccessPermission(Auth::user()->id);

        if (Session::get('lang') == "en") {
            $viewData = array(
                'title' => 'Area Maintenance',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'area_list',
                'user_permission' => $user_permission,
                'image' => ""
            );

            return View::make('page_en.area', $viewData);
        } else {
            $viewData = array(
                'title' => 'Pengurusan Daerah',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'area_list',
                'user_permission' => $user_permission,
                'image' => ""
            );

            return View::make('page_my.area', $viewData);
        }
    }

    public function addArea() {
        //get user permission
        $user_permission = AccessGroup::getAccessPermission(Auth::user()->id);

        if (Session::get('lang') == "en") {
            $viewData = array(
                'title' => 'Add Area',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'area_list',
                'user_permission' => $user_permission,
                'image' => ""
            );

            return View::make('page_en.add_area', $viewData);
        } else {
            $viewData = array(
                'title' => 'Tambah Daerah',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'area_list',
                'user_permission' => $user_permission,
                'image' => ""
            );

            return View::make('page_my.add_area', $viewData);
        }
    }

    public function submitArea() {
        $data = Input::all();
        if (Request::ajax()) {
            $description = $data['description'];
            $is_active = $data['is_active'];

            $area = new Area();
            $area->description = $description;
            $area->is_active = $is_active;
            $success = $area->save();

            if ($success) {
                # Audit Trail
                $remarks = 'Area: ' . $area->description . ' has been inserted.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "Master Setup";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    public function getArea() {
        $area = Area::where('is_deleted', 0)->orderBy('id', 'desc')->get();

        if (count($area) > 0) {
            $data = Array();
            foreach ($area as $areas) {
                $button = "";
                if (Session::get('lang') == "en") {
                    if ($areas->is_active == 1) {
                        $status = "Active";
                        $button .= '<button type="button" class="btn btn-xs btn-primary" onclick="inactiveArea(\'' . $areas->id . '\')">Inactive</button>&nbsp;';
                    } else {
                        $status = "Inactive";
                        $button .= '<button type="button" class="btn btn-xs btn-primary" onclick="activeArea(\'' . $areas->id . '\')">Active</button>&nbsp;';
                    }
                } else {
                    if ($areas->is_active == 1) {
                        $status = "Aktif";
                        $button .= '<button type="button" class="btn btn-xs btn-primary" onclick="inactiveArea(\'' . $areas->id . '\')">Tidak Aktif</button>&nbsp;';
                    } else {
                        $status = "Tidak Aktif";
                        $button .= '<button type="button" class="btn btn-xs btn-primary" onclick="activeArea(\'' . $areas->id . '\')">Aktif</button>&nbsp;';
                    }
                }
                $button .= '<button type="button" class="btn btn-xs btn-success" onclick="window.location=\'' . URL::action('AdminController@updateArea', $areas->id) . '\'"><i class="fa fa-pencil"></i></button>&nbsp;';
                $button .= '<button class="btn btn-xs btn-danger" onclick="deleteArea(\'' . $areas->id . '\')"><i class="fa fa-trash"></i></button>';

                $data_raw = array(
                    $areas->description,
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

    public function inactiveArea() {
        $data = Input::all();
        if (Request::ajax()) {

            $id = $data['id'];

            $area = Area::find($id);
            $area->is_active = 0;
            $updated = $area->save();
            if ($updated) {
                # Audit Trail
                $remarks = 'Area: ' . $area->description . ' has been updated.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "Master Setup";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    public function activeArea() {
        $data = Input::all();
        if (Request::ajax()) {

            $id = $data['id'];

            $area = Area::find($id);
            $area->is_active = 1;
            $updated = $area->save();
            if ($updated) {
                # Audit Trail
                $remarks = 'Area: ' . $area->description . ' has been updated.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "Master Setup";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    public function deleteArea() {
        $data = Input::all();
        if (Request::ajax()) {

            $id = $data['id'];

            $area = Area::find($id);
            $area->is_deleted = 1;
            $deleted = $area->save();
            if ($deleted) {
                # Audit Trail
                $remarks = 'Area: ' . $area->description . ' has been deleted.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "Master Setup";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    public function updateArea($id) {
        //get user permission
        $user_permission = AccessGroup::getAccessPermission(Auth::user()->id);
        $area = Area::find($id);

        if (Session::get('lang') == "en") {
            $viewData = array(
                'title' => 'Update Area',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'area_list',
                'user_permission' => $user_permission,
                'area' => $area,
                'image' => ""
            );

            return View::make('page_en.update_area', $viewData);
        } else {
            $viewData = array(
                'title' => 'Edit Daerah',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'area_list',
                'user_permission' => $user_permission,
                'area' => $area,
                'image' => ""
            );

            return View::make('page_my.update_area', $viewData);
        }
    }

    public function submitUpdateArea() {
        $data = Input::all();
        if (Request::ajax()) {
            $description = $data['description'];
            $is_active = $data['is_active'];
            $id = $data['id'];

            $area = Area::find($id);
            $area->description = $description;
            $area->is_active = $is_active;
            $success = $area->save();

            if ($success) {
                # Audit Trail
                $remarks = 'Area: ' . $area->description . ' has been updated.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "Master Setup";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    //city
    public function city() {
        //get user permission
        $user_permission = AccessGroup::getAccessPermission(Auth::user()->id);

        if (Session::get('lang') == "en") {
            $viewData = array(
                'title' => 'City Maintenance',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'city_list',
                'user_permission' => $user_permission,
                'image' => ""
            );

            return View::make('page_en.city', $viewData);
        } else {
            $viewData = array(
                'title' => 'Pengurusan Bandar',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'city_list',
                'user_permission' => $user_permission,
                'image' => ""
            );

            return View::make('page_my.city', $viewData);
        }
    }

    public function addCity() {
        //get user permission
        $user_permission = AccessGroup::getAccessPermission(Auth::user()->id);

        if (Session::get('lang') == "en") {
            $viewData = array(
                'title' => 'Add City',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'city_list',
                'user_permission' => $user_permission,
                'image' => ""
            );

            return View::make('page_en.add_city', $viewData);
        } else {
            $viewData = array(
                'title' => 'Tambah Bandar',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'city_list',
                'user_permission' => $user_permission,
                'image' => ""
            );

            return View::make('page_my.add_city', $viewData);
        }
    }

    public function submitCity() {
        $data = Input::all();
        if (Request::ajax()) {
            $description = $data['description'];
            $is_active = $data['is_active'];

            $city = new City();
            $city->description = $description;
            $city->is_active = $is_active;
            $success = $city->save();

            if ($success) {
                # Audit Trail
                $remarks = 'City: ' . $city->description . ' has been inserted.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "Master Setup";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    public function getCity() {
        $city = City::where('is_deleted', 0)->orderBy('id', 'desc')->get();

        if (count($city) > 0) {
            $data = Array();
            foreach ($city as $cities) {
                $button = "";
                if (Session::get('lang') == "en") {
                    if ($cities->is_active == 1) {
                        $status = "Active";
                        $button .= '<button type="button" class="btn btn-xs btn-primary" onclick="inactiveCity(\'' . $cities->id . '\')">Inactive</button>&nbsp;';
                    } else {
                        $status = "Inactive";
                        $button .= '<button type="button" class="btn btn-xs btn-primary" onclick="activeCity(\'' . $cities->id . '\')">Active</button>&nbsp;';
                    }
                } else {
                    if ($cities->is_active == 1) {
                        $status = "Aktif";
                        $button .= '<button type="button" class="btn btn-xs btn-primary" onclick="inactiveCity(\'' . $cities->id . '\')">Tidak Aktif</button>&nbsp;';
                    } else {
                        $status = "Tidak Aktif";
                        $button .= '<button type="button" class="btn btn-xs btn-primary" onclick="activeCity(\'' . $cities->id . '\')">Aktif</button>&nbsp;';
                    }
                }
                $button .= '<button type="button" class="btn btn-xs btn-success" onclick="window.location=\'' . URL::action('AdminController@updateCity', $cities->id) . '\'"><i class="fa fa-pencil"></i></button>&nbsp;';
                $button .= '<button class="btn btn-xs btn-danger" onclick="deleteCity(\'' . $cities->id . '\')"><i class="fa fa-trash"></i></button>';

                $data_raw = array(
                    $cities->description,
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

    public function inactiveCity() {
        $data = Input::all();
        if (Request::ajax()) {

            $id = $data['id'];

            $city = City::find($id);
            $city->is_active = 0;
            $updated = $city->save();
            if ($updated) {
                # Audit Trail
                $remarks = 'City: ' . $city->description . ' has been updated.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "Master Setup";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    public function activeCity() {
        $data = Input::all();
        if (Request::ajax()) {

            $id = $data['id'];

            $city = City::find($id);
            $city->is_active = 1;
            $updated = $city->save();
            if ($updated) {
                # Audit Trail
                $remarks = 'City: ' . $city->description . ' has been updated.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "Master Setup";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    public function deleteCity() {
        $data = Input::all();
        if (Request::ajax()) {

            $id = $data['id'];

            $city = City::find($id);
            $city->is_deleted = 1;
            $deleted = $city->save();
            if ($deleted) {
                # Audit Trail
                $remarks = 'City: ' . $city->description . ' has been deleted.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "Master Setup";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    public function updateCity($id) {
        //get user permission
        $user_permission = AccessGroup::getAccessPermission(Auth::user()->id);
        $city = City::find($id);

        if (Session::get('lang') == "en") {
            $viewData = array(
                'title' => 'Update City',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'city_list',
                'user_permission' => $user_permission,
                'city' => $city,
                'image' => ""
            );

            return View::make('page_en.update_city', $viewData);
        } else {
            $viewData = array(
                'title' => 'Edit Bandar',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'city_list',
                'user_permission' => $user_permission,
                'city' => $city,
                'image' => ""
            );

            return View::make('page_my.update_city', $viewData);
        }
    }

    public function submitUpdateCity() {
        $data = Input::all();
        if (Request::ajax()) {
            $description = $data['description'];
            $is_active = $data['is_active'];
            $id = $data['id'];

            $city = City::find($id);
            $city->description = $description;
            $city->is_active = $is_active;
            $success = $city->save();

            if ($success) {
                # Audit Trail
                $remarks = 'City: ' . $city->description . ' has been updated.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "Master Setup";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    //country
    public function country() {
        //get user permission
        $user_permission = AccessGroup::getAccessPermission(Auth::user()->id);

        if (Session::get('lang') == "en") {
            $viewData = array(
                'title' => 'Country Maintenance',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'country_list',
                'user_permission' => $user_permission,
                'image' => ""
            );

            return View::make('page_en.country', $viewData);
        } else {
            $viewData = array(
                'title' => 'Pengurusan Bandar',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'country_list',
                'user_permission' => $user_permission,
                'image' => ""
            );

            return View::make('page_my.country', $viewData);
        }
    }

    public function addCountry() {
        //get user permission
        $user_permission = AccessGroup::getAccessPermission(Auth::user()->id);

        if (Session::get('lang') == "en") {
            $viewData = array(
                'title' => 'Add Country',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'country_list',
                'user_permission' => $user_permission,
                'image' => ""
            );

            return View::make('page_en.add_country', $viewData);
        } else {
            $viewData = array(
                'title' => 'Tambah Bandar',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'country_list',
                'user_permission' => $user_permission,
                'image' => ""
            );

            return View::make('page_my.add_country', $viewData);
        }
    }

    public function submitCountry() {
        $data = Input::all();
        if (Request::ajax()) {
            $is_active = $data['is_active'];

            $country = new Country();
            $country->name = $data['name'];
            $country->seq = $data['seq'];
            $country->is_active = $is_active;
            $success = $country->save();

            if ($success) {
                # Audit Trail
                $remarks = 'Country: ' . $country->name . ' has been inserted.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "Master Setup";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    public function getCountry() {
        $country = Country::where('is_deleted', 0)->orderBy('id', 'desc')->get();

        if (count($country) > 0) {
            $data = Array();
            foreach ($country as $cities) {
                $button = "";
                if (Session::get('lang') == "en") {
                    if ($cities->is_active == 1) {
                        $status = "Active";
                        $button .= '<button type="button" class="btn btn-xs btn-primary" onclick="inactiveCountry(\'' . $cities->id . '\')">Inactive</button>&nbsp;';
                    } else {
                        $status = "Inactive";
                        $button .= '<button type="button" class="btn btn-xs btn-primary" onclick="activeCountry(\'' . $cities->id . '\')">Active</button>&nbsp;';
                    }
                } else {
                    if ($cities->is_active == 1) {
                        $status = "Aktif";
                        $button .= '<button type="button" class="btn btn-xs btn-primary" onclick="inactiveCountry(\'' . $cities->id . '\')">Tidak Aktif</button>&nbsp;';
                    } else {
                        $status = "Tidak Aktif";
                        $button .= '<button type="button" class="btn btn-xs btn-primary" onclick="activeCountry(\'' . $cities->id . '\')">Aktif</button>&nbsp;';
                    }
                }
                $button .= '<button type="button" class="btn btn-xs btn-success" onclick="window.location=\'' . URL::action('AdminController@updateCountry', $cities->id) . '\'"><i class="fa fa-pencil"></i></button>&nbsp;';
                $button .= '<button class="btn btn-xs btn-danger" onclick="deleteCountry(\'' . $cities->id . '\')"><i class="fa fa-trash"></i></button>';

                $data_raw = array(
                    $cities->name,
                    $cities->seq,
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

    public function inactiveCountry() {
        $data = Input::all();
        if (Request::ajax()) {

            $id = $data['id'];

            $country = Country::find($id);
            $country->is_active = 0;
            $updated = $country->save();
            if ($updated) {
                # Audit Trail
                $remarks = 'Country: ' . $country->id . ' has been updated.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "Master Setup";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    public function activeCountry() {
        $data = Input::all();
        if (Request::ajax()) {

            $id = $data['id'];

            $country = Country::find($id);
            $country->is_active = 1;
            $updated = $country->save();
            if ($updated) {
                # Audit Trail
                $remarks = 'Country: ' . $country->id . ' has been updated.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "Master Setup";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    public function deleteCountry() {
        $data = Input::all();
        if (Request::ajax()) {

            $id = $data['id'];

            $country = Country::find($id);
            $country->is_deleted = 1;
            $deleted = $country->save();
            if ($deleted) {
                # Audit Trail
                $remarks = 'Country: ' . $country->id . ' has been deleted.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "Master Setup";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    public function updateCountry($id) {
        //get user permission
        $user_permission = AccessGroup::getAccessPermission(Auth::user()->id);
        $country = Country::find($id);

        if (Session::get('lang') == "en") {
            $viewData = array(
                'title' => 'Update Country',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'country_list',
                'user_permission' => $user_permission,
                'country' => $country,
                'image' => ""
            );

            return View::make('page_en.update_country', $viewData);
        } else {
            $viewData = array(
                'title' => 'Edit Bandar',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'country_list',
                'user_permission' => $user_permission,
                'country' => $country,
                'image' => ""
            );

            return View::make('page_my.update_country', $viewData);
        }
    }

    public function submitUpdateCountry() {
        $data = Input::all();
        if (Request::ajax()) {
            $id = $data['id'];

            $country = Country::find($id);
            $country->name = $data['name'];
            $country->seq = $data['seq'];
            $country->is_active = $data['is_active'];
            $success = $country->save();

            if ($success) {
                # Audit Trail
                $remarks = 'Country: ' . $country->id . ' has been updated.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "Master Setup";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    //language
    public function language() {
        //get user permission
        $user_permission = AccessGroup::getAccessPermission(Auth::user()->id);

        if (Session::get('lang') == "en") {
            $viewData = array(
                'title' => 'Language Master',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'language_list',
                'user_permission' => $user_permission,
                'image' => ""
            );

            return View::make('page_en.language', $viewData);
        } else {
            $viewData = array(
                'title' => 'Master Language',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'language_list',
                'user_permission' => $user_permission,
                'image' => ""
            );

            return View::make('page_en.language', $viewData);
        }
    }

    public function addLanguage() {
        //get user permission
        $user_permission = AccessGroup::getAccessPermission(Auth::user()->id);

        if (Session::get('lang') == "en") {
            $viewData = array(
                'title' => 'Add Language',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'language_list',
                'user_permission' => $user_permission,
                'image' => ""
            );

            return View::make('page_en.add_language', $viewData);
        } else {
            $viewData = array(
                'title' => 'Add Language',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'language_list',
                'user_permission' => $user_permission,
                'image' => ""
            );

            return View::make('page_en.add_language', $viewData);
        }
    }

    public function submitLanguage() {
        $data = Input::all();
        if (Request::ajax()) {
            $is_active = $data['is_active'];

            $language = new Language();
            $language->code = $data['code'];
            $language->en_gen_desc = $data['en_gen_desc'];
            $language->en_long_desc = $data['en_long_desc'];
            $language->en_short_desc = $data['en_short_desc'];
            $language->bm_gen_desc = $data['bm_gen_desc'];
            $language->bm_long_desc = $data['bm_long_desc'];
            $language->bm_short_desc = $data['bm_short_desc'];
            $language->is_active = $data['is_active'];
            $success = $language->save();

            if ($success) {
                # Audit Trail
                $remarks = 'Language: ' . $language->code . ' has been inserted.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "Master Setup";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    public function getLanguage() {
        $language = Language::where('is_deleted', 0)->orderBy('id', 'desc')->get();

        if (count($language) > 0) {
            $data = Array();
            foreach ($language as $lang) {
                $button = "";
                if (Session::get('lang') == "en") {
                    if ($lang->is_active == 1) {
                        $status = "Active";
                        $button .= '<button type="button" class="btn btn-xs btn-primary" onclick="inactiveLanguage(\'' . $lang->id . '\')">Inactive</button>&nbsp;';
                    } else {
                        $status = "Inactive";
                        $button .= '<button type="button" class="btn btn-xs btn-primary" onclick="activeLanguage(\'' . $lang->id . '\')">Active</button>&nbsp;';
                    }
                } else {
                    if ($lang->is_active == 1) {
                        $status = "Aktif";
                        $button .= '<button type="button" class="btn btn-xs btn-primary" onclick="inactiveLanguage(\'' . $lang->id . '\')">Tidak Aktif</button>&nbsp;';
                    } else {
                        $status = "Tidak Aktif";
                        $button .= '<button type="button" class="btn btn-xs btn-primary" onclick="activeLanguage(\'' . $lang->id . '\')">Aktif</button>&nbsp;';
                    }
                }
                $button .= '<button type="button" class="btn btn-xs btn-success" onclick="window.location=\'' . URL::action('AdminController@updateLanguage', $lang->id) . '\'"><i class="fa fa-pencil"></i></button>&nbsp;';
                $button .= '<button class="btn btn-xs btn-danger" onclick="deleteLanguage(\'' . $lang->id . '\')"><i class="fa fa-trash"></i></button>';

                $data_raw = array(
                    $lang->code,
                    $lang->en_gen_desc,
                    $lang->bm_gen_desc,
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

    public function inactiveLanguage() {
        $data = Input::all();
        if (Request::ajax()) {

            $id = $data['id'];

            $language = Language::find($id);
            $language->is_active = 0;
            $updated = $language->save();
            if ($updated) {
                # Audit Trail
                $remarks = 'Language: ' . $language->id . ' has been updated.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "Master Setup";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    public function activeLanguage() {
        $data = Input::all();
        if (Request::ajax()) {

            $id = $data['id'];

            $language = Language::find($id);
            $language->is_active = 1;
            $updated = $language->save();
            if ($updated) {
                # Audit Trail
                $remarks = 'Language: ' . $language->id . ' has been updated.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "Master Setup";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    public function deleteLanguage() {
        $data = Input::all();
        if (Request::ajax()) {

            $id = $data['id'];

            $language = Language::find($id);
            $language->is_deleted = 1;
            $deleted = $language->save();
            if ($deleted) {
                # Audit Trail
                $remarks = 'Language: ' . $language->id . ' has been deleted.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "Master Setup";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    public function updateLanguage($id) {
        //get user permission
        $user_permission = AccessGroup::getAccessPermission(Auth::user()->id);
        $language = Language::find($id);

        if (Session::get('lang') == "en") {
            $viewData = array(
                'title' => 'Update Language',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'language_list',
                'user_permission' => $user_permission,
                'language' => $language,
                'image' => ""
            );

            return View::make('page_en.update_language', $viewData);
        } else {
            $viewData = array(
                'title' => 'Update language',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'language_list',
                'user_permission' => $user_permission,
                'language' => $language,
                'image' => ""
            );

            return View::make('page_en.update_language', $viewData);
        }
    }

    public function submitUpdateLanguage() {
        $data = Input::all();
        if (Request::ajax()) {
            $id = $data['id'];

            $language = Language::find($id);
            $language->code = $data['code'];
            $language->en_gen_desc = $data['en_gen_desc'];
            $language->en_long_desc = $data['en_long_desc'];
            $language->en_short_desc = $data['en_short_desc'];
            $language->bm_gen_desc = $data['bm_gen_desc'];
            $language->bm_long_desc = $data['bm_long_desc'];
            $language->bm_short_desc = $data['bm_short_desc'];
            $language->is_active = $data['is_active'];
            $success = $language->save();

            if ($success) {
                # Audit Trail
                $remarks = 'Language: ' . $language->id . ' has been updated.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "Master Setup";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    //formtype
    public function formtype() {
        //get user permission
        $user_permission = AccessGroup::getAccessPermission(Auth::user()->id);

        if (Session::get('lang') == "en") {
            $viewData = array(
                'title' => 'Form Type Master',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'formtype_list',
                'user_permission' => $user_permission,
                'image' => ""
            );

            return View::make('page_en.formtype', $viewData);
        } else {
            $viewData = array(
                'title' => 'Jenis Form',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'formtype_list',
                'user_permission' => $user_permission,
                'image' => ""
            );

            return View::make('page_my.formtype', $viewData);
        }
    }

    public function addFormType() {
        //get user permission
        $user_permission = AccessGroup::getAccessPermission(Auth::user()->id);

        if (Session::get('lang') == "en") {
            $viewData = array(
                'title' => 'Add FormType',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'formtype_list',
                'user_permission' => $user_permission,
                'image' => ""
            );

            return View::make('page_en.add_formtype', $viewData);
        } else {
            $viewData = array(
                'title' => 'Tambah Jenis Form',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'formtype_list',
                'user_permission' => $user_permission,
                'image' => ""
            );

            return View::make('page_my.add_formtype', $viewData);
        }
    }

    public function submitFormType() {
        $data = Input::all();
        if (Request::ajax()) {

            $formtype = new FormType();
            $formtype->bi_type = $data['bi_type'];
            $formtype->bm_type = $data['bm_type'];
            $formtype->seq = $data['seq'];
            $formtype->is_active = $data['is_active'];
            $success = $formtype->save();

            if ($success) {
                # Audit Trail
                $remarks = 'Form Type: ' . $formtype->name . ' has been inserted.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "Master Setup";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    public function getFormType() {
        $formtype = FormType::where('is_deleted', 0)->orderBy('id', 'desc')->get();

        if (count($formtype) > 0) {
            $data = Array();
            foreach ($formtype as $ft) {
                $button = "";
                if (Session::get('lang') == "en") {
                    if ($ft->is_active == 1) {
                        $status = "Active";
                        $button .= '<button type="button" class="btn btn-xs btn-primary" onclick="inactiveFormtype(\'' . $ft->id . '\')">Inactive</button>&nbsp;';
                    } else {
                        $status = "Inactive";
                        $button .= '<button type="button" class="btn btn-xs btn-primary" onclick="activeFormtype(\'' . $ft->id . '\')">Active</button>&nbsp;';
                    }
                } else {
                    if ($ft->is_active == 1) {
                        $status = "Aktif";
                        $button .= '<button type="button" class="btn btn-xs btn-primary" onclick="inactiveFormtype(\'' . $ft->id . '\')">Tidak Aktif</button>&nbsp;';
                    } else {
                        $status = "Tidak Aktif";
                        $button .= '<button type="button" class="btn btn-xs btn-primary" onclick="activeFormtype(\'' . $ft->id . '\')">Aktif</button>&nbsp;';
                    }
                }
                $button .= '<button type="button" class="btn btn-xs btn-success" onclick="window.location=\'' . URL::action('AdminController@updateFormtype', $ft->id) . '\'"><i class="fa fa-pencil"></i></button>&nbsp;';
                $button .= '<button class="btn btn-xs btn-danger" onclick="deleteFormType(\'' . $ft->id . '\')"><i class="fa fa-trash"></i></button>';

                $data_raw = array(
                    $ft->name_en,
                    $ft->name_my,
                    $ft->sort_no,
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

    public function inactiveFormType() {
        $data = Input::all();
        if (Request::ajax()) {

            $id = $data['id'];

            $formtype = FormType::find($id);
            $formtype->is_active = 0;
            $updated = $formtype->save();
            if ($updated) {
                # Audit Trail
                $remarks = 'FormType: ' . $formtype->id . ' has been updated.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "Master Setup";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    public function activeFormType() {
        $data = Input::all();
        if (Request::ajax()) {

            $id = $data['id'];

            $formtype = FormType::find($id);
            $formtype->is_active = 1;
            $updated = $formtype->save();
            if ($updated) {
                # Audit Trail
                $remarks = 'FormType: ' . $formtype->id . ' has been updated.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "Master Setup";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    public function deleteFormType() {
        $data = Input::all();
        if (Request::ajax()) {

            $id = $data['id'];

            $formtype = FormType::find($id);
            $formtype->is_deleted = 1;
            $deleted = $formtype->save();
            if ($deleted) {
                # Audit Trail
                $remarks = 'FormType: ' . $formtype->id . ' has been deleted.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "Master Setup";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    public function updateFormType($id) {
        //get user permission
        $user_permission = AccessGroup::getAccessPermission(Auth::user()->id);
        $formtype = FormType::find($id);

        if (Session::get('lang') == "en") {
            $viewData = array(
                'title' => 'Update Form Type',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'formtype_list',
                'user_permission' => $user_permission,
                'formtype' => $formtype,
                'image' => ""
            );

            return View::make('page_en.update_formtype', $viewData);
        } else {
            $viewData = array(
                'title' => 'Edit Jenis Form',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'formtype_list',
                'user_permission' => $user_permission,
                'formtype' => $formtype,
                'image' => ""
            );

            return View::make('page_my.update_formtype', $viewData);
        }
    }

    public function submitUpdateFormType() {
        $data = Input::all();
        if (Request::ajax()) {
            $id = $data['id'];

            $formtype = FormType::find($id);
            $formtype->bi_type = $data['bi_type'];
            $formtype->bm_type = $data['bm_type'];
            $formtype->seq = $data['seq'];
            $formtype->is_active = $data['is_active'];
            $success = $formtype->save();

            if ($success) {
                # Audit Trail
                $remarks = 'Form Type: ' . $formtype->id . ' has been updated.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "Master Setup";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

//state
    public function state() {
        //get user permission
        $user_permission = AccessGroup::getAccessPermission(Auth::user()->id);

        if (Session::get('lang') == "en") {
            $viewData = array(
                'title' => 'State Maintenance',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'state_list',
                'user_permission' => $user_permission,
                'image' => ""
            );

            return View::make('page_en.state', $viewData);
        } else {
            $viewData = array(
                'title' => 'Pengurusan Bandar',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'state_list',
                'user_permission' => $user_permission,
                'image' => ""
            );

            return View::make('page_my.state', $viewData);
        }
    }

    public function addState() {
        //get user permission
        $user_permission = AccessGroup::getAccessPermission(Auth::user()->id);

        if (Session::get('lang') == "en") {
            $viewData = array(
                'title' => 'Add State',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'state_list',
                'user_permission' => $user_permission,
                'image' => ""
            );

            return View::make('page_en.add_state', $viewData);
        } else {
            $viewData = array(
                'title' => 'Tambah Bandar',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'state_list',
                'user_permission' => $user_permission,
                'image' => ""
            );

            return View::make('page_my.add_state', $viewData);
        }
    }

    public function submitState() {
        $data = Input::all();
        if (Request::ajax()) {
            $is_active = $data['is_active'];

            $state = new State();
            $state->name = $data['name'];
            $state->seq = $data['seq'];
            $state->is_active = $is_active;
            $success = $state->save();

            if ($success) {
                # Audit Trail
                $remarks = 'State: ' . $state->name . ' has been inserted.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "Master Setup";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    public function getState() {
        $state = State::where('is_deleted', 0)->orderBy('id', 'desc')->get();

        if (count($state) > 0) {
            $data = Array();
            foreach ($state as $cities) {
                $button = "";
                if (Session::get('lang') == "en") {
                    if ($cities->is_active == 1) {
                        $status = "Active";
                        $button .= '<button type="button" class="btn btn-xs btn-primary" onclick="inactiveState(\'' . $cities->id . '\')">Inactive</button>&nbsp;';
                    } else {
                        $status = "Inactive";
                        $button .= '<button type="button" class="btn btn-xs btn-primary" onclick="activeState(\'' . $cities->id . '\')">Active</button>&nbsp;';
                    }
                } else {
                    if ($cities->is_active == 1) {
                        $status = "Aktif";
                        $button .= '<button type="button" class="btn btn-xs btn-primary" onclick="inactiveState(\'' . $cities->id . '\')">Tidak Aktif</button>&nbsp;';
                    } else {
                        $status = "Tidak Aktif";
                        $button .= '<button type="button" class="btn btn-xs btn-primary" onclick="activeState(\'' . $cities->id . '\')">Aktif</button>&nbsp;';
                    }
                }
                $button .= '<button type="button" class="btn btn-xs btn-success" onclick="window.location=\'' . URL::action('AdminController@updateState', $cities->id) . '\'"><i class="fa fa-pencil"></i></button>&nbsp;';
                $button .= '<button class="btn btn-xs btn-danger" onclick="deleteState(\'' . $cities->id . '\')"><i class="fa fa-trash"></i></button>';

                $data_raw = array(
                    $cities->name,
                    $cities->seq,
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

    public function inactiveState() {
        $data = Input::all();
        if (Request::ajax()) {

            $id = $data['id'];

            $state = State::find($id);
            $state->is_active = 0;
            $updated = $state->save();
            if ($updated) {
                # Audit Trail
                $remarks = 'State: ' . $state->id . ' has been updated.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "Master Setup";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    public function activeState() {
        $data = Input::all();
        if (Request::ajax()) {

            $id = $data['id'];

            $state = State::find($id);
            $state->is_active = 1;
            $updated = $state->save();
            if ($updated) {
                # Audit Trail
                $remarks = 'State: ' . $state->id . ' has been updated.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "Master Setup";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    public function deleteState() {
        $data = Input::all();
        if (Request::ajax()) {

            $id = $data['id'];

            $state = State::find($id);
            $state->is_deleted = 1;
            $deleted = $state->save();
            if ($deleted) {
                # Audit Trail
                $remarks = 'State: ' . $state->id . ' has been deleted.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "Master Setup";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    public function updateState($id) {
        //get user permission
        $user_permission = AccessGroup::getAccessPermission(Auth::user()->id);
        $state = State::find($id);

        if (Session::get('lang') == "en") {
            $viewData = array(
                'title' => 'Update State',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'state_list',
                'user_permission' => $user_permission,
                'state' => $state,
                'image' => ""
            );

            return View::make('page_en.update_state', $viewData);
        } else {
            $viewData = array(
                'title' => 'Edit Bandar',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'state_list',
                'user_permission' => $user_permission,
                'state' => $state,
                'image' => ""
            );

            return View::make('page_my.update_state', $viewData);
        }
    }

    public function submitUpdateState() {
        $data = Input::all();
        if (Request::ajax()) {
            $id = $data['id'];

            $state = State::find($id);
            $state->name = $data['name'];
            $state->seq = $data['seq'];
            $state->is_active = $data['is_active'];
            $success = $state->save();

            if ($success) {
                # Audit Trail
                $remarks = 'State: ' . $state->id . ' has been updated.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "Master Setup";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    // Document Type
    public function documenttype() {
        //get user permission
        $user_permission = AccessGroup::getAccessPermission(Auth::user()->id);

        if (Session::get('lang') == "en") {
            $viewData = array(
                'title' => 'Document Type Maintenance',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'documenttype_list',
                'user_permission' => $user_permission,
                'image' => ""
            );

            return View::make('page_en.documenttype', $viewData);
        } else {
            $viewData = array(
                'title' => 'Pengurusan Bandar',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'documenttype_list',
                'user_permission' => $user_permission,
                'image' => ""
            );

            return View::make('page_my.documenttype', $viewData);
        }
    }

    public function addDocumenttype() {
        //get user permission
        $user_permission = AccessGroup::getAccessPermission(Auth::user()->id);

        if (Session::get('lang') == "en") {
            $viewData = array(
                'title' => 'Add Document Type',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'documenttype_list',
                'user_permission' => $user_permission,
                'image' => ""
            );

            return View::make('page_en.add_documenttype', $viewData);
        } else {
            $viewData = array(
                'title' => 'Tambah Jenis Dokumen',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'documenttype_list',
                'user_permission' => $user_permission,
                'image' => ""
            );

            return View::make('page_my.add_documenttype', $viewData);
        }
    }

    public function submitDocumenttype() {
        $data = Input::all();
        if (Request::ajax()) {
            $is_active = $data['is_active'];

            $documenttype = new Documenttype();
            $documenttype->name = $data['name'];
            $documenttype->seq = $data['seq'];
            $documenttype->is_active = $is_active;
            $success = $documenttype->save();

            if ($success) {
                # Audit Trail
                $remarks = 'Document Type: ' . $documenttype->name . ' has been inserted.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "Master Setup";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    public function getDocumenttype() {
        $documenttype = Documenttype::where('is_deleted', 0)->orderBy('id', 'desc')->get();

        if (count($documenttype) > 0) {
            $data = Array();
            foreach ($documenttype as $cities) {
                $button = "";
                if (Session::get('lang') == "en") {
                    if ($cities->is_active == 1) {
                        $status = "Active";
                        $button .= '<button type="button" class="btn btn-xs btn-primary" onclick="inactiveDocumenttype(\'' . $cities->id . '\')">Inactive</button>&nbsp;';
                    } else {
                        $status = "Inactive";
                        $button .= '<button type="button" class="btn btn-xs btn-primary" onclick="activeDocumenttype(\'' . $cities->id . '\')">Active</button>&nbsp;';
                    }
                } else {
                    if ($cities->is_active == 1) {
                        $status = "Aktif";
                        $button .= '<button type="button" class="btn btn-xs btn-primary" onclick="inactiveDocumenttype(\'' . $cities->id . '\')">Tidak Aktif</button>&nbsp;';
                    } else {
                        $status = "Tidak Aktif";
                        $button .= '<button type="button" class="btn btn-xs btn-primary" onclick="activeDocumenttype(\'' . $cities->id . '\')">Aktif</button>&nbsp;';
                    }
                }
                $button .= '<button type="button" class="btn btn-xs btn-success" onclick="window.location=\'' . URL::action('AdminController@updateDocumenttype', $cities->id) . '\'"><i class="fa fa-pencil"></i></button>&nbsp;';
                $button .= '<button class="btn btn-xs btn-danger" onclick="deleteDocumenttype(\'' . $cities->id . '\')"><i class="fa fa-trash"></i></button>';

                $data_raw = array(
                    $cities->name,
                    $cities->seq,
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

    public function inactiveDocumenttype() {
        $data = Input::all();
        if (Request::ajax()) {

            $id = $data['id'];

            $documenttype = Documenttype::find($id);
            $documenttype->is_active = 0;
            $updated = $documenttype->save();
            if ($updated) {
                # Audit Trail
                $remarks = 'Document Type: ' . $documenttype->id . ' has been updated.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "Master Setup";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    public function activeDocumenttype() {
        $data = Input::all();
        if (Request::ajax()) {

            $id = $data['id'];

            $documenttype = Documenttype::find($id);
            $documenttype->is_active = 1;
            $updated = $documenttype->save();
            if ($updated) {
                # Audit Trail
                $remarks = 'Document Type: ' . $documenttype->id . ' has been updated.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "Master Setup";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    public function deleteDocumenttype() {
        $data = Input::all();
        if (Request::ajax()) {

            $id = $data['id'];

            $documenttype = Documenttype::find($id);
            $documenttype->is_deleted = 1;
            $deleted = $documenttype->save();
            if ($deleted) {
                # Audit Trail
                $remarks = 'Document Type: ' . $documenttype->id . ' has been deleted.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "Master Setup";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    public function updateDocumenttype($id) {
        //get user permission
        $user_permission = AccessGroup::getAccessPermission(Auth::user()->id);
        $documenttype = Documenttype::find($id);

        if (Session::get('lang') == "en") {
            $viewData = array(
                'title' => 'Update Document Type',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'documenttype_list',
                'user_permission' => $user_permission,
                'documenttype' => $documenttype,
                'image' => ""
            );

            return View::make('page_en.update_documenttype', $viewData);
        } else {
            $viewData = array(
                'title' => 'Edit Jenis Dokumen',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'documenttype_list',
                'user_permission' => $user_permission,
                'documenttype' => $documenttype,
                'image' => ""
            );

            return View::make('page_my.update_documenttype', $viewData);
        }
    }

    public function submitUpdateDocumenttype() {
        $data = Input::all();
        if (Request::ajax()) {
            $id = $data['id'];

            $documenttype = Documenttype::find($id);
            $documenttype->name = $data['name'];
            $documenttype->seq = $data['seq'];
            $documenttype->is_active = $data['is_active'];
            $success = $documenttype->save();

            if ($success) {
                # Audit Trail
                $remarks = 'Document Type: ' . $documenttype->id . ' has been updated.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "Master Setup";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    //category
    public function category() {
        //get user permission
        $user_permission = AccessGroup::getAccessPermission(Auth::user()->id);

        if (Session::get('lang') == "en") {
            $viewData = array(
                'title' => 'Category Maintenance',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'category_list',
                'user_permission' => $user_permission,
                'image' => ""
            );

            return View::make('page_en.category', $viewData);
        } else {
            $viewData = array(
                'title' => 'Pengurusan Kategori',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'category_list',
                'user_permission' => $user_permission,
                'image' => ""
            );

            return View::make('page_my.category', $viewData);
        }
    }

    public function addCategory() {
        //get user permission
        $user_permission = AccessGroup::getAccessPermission(Auth::user()->id);

        if (Session::get('lang') == "en") {
            $viewData = array(
                'title' => 'Add Category',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'category_list',
                'user_permission' => $user_permission,
                'image' => ""
            );

            return View::make('page_en.add_category', $viewData);
        } else {
            $viewData = array(
                'title' => 'Tambah Kategori',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'category_list',
                'user_permission' => $user_permission,
                'image' => ""
            );

            return View::make('page_my.add_category', $viewData);
        }
    }

    public function submitCategory() {
        $data = Input::all();
        if (Request::ajax()) {
            $description = $data['description'];
            $is_active = $data['is_active'];

            $category = new Category();
            $category->description = $description;
            $category->is_active = $is_active;
            $success = $category->save();

            if ($success) {
                # Audit Trail
                $remarks = 'Category: ' . $category->description . ' has been inserted.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "Master Setup";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    public function getCategory() {
        $category = Category::where('is_deleted', 0)->orderBy('id', 'desc')->get();

        if (count($category) > 0) {
            $data = Array();
            foreach ($category as $categories) {
                $button = "";
                if (Session::get('lang') == "en") {
                    if ($categories->is_active == 1) {
                        $status = "Active";
                        $button .= '<button type="button" class="btn btn-xs btn-primary" onclick="inactiveCategory(\'' . $categories->id . '\')">Inactive</button>&nbsp;';
                    } else {
                        $status = "Inactive";
                        $button .= '<button type="button" class="btn btn-xs btn-primary" onclick="activeCategory(\'' . $categories->id . '\')">Active</button>&nbsp;';
                    }
                } else {
                    if ($categories->is_active == 1) {
                        $status = "Aktif";
                        $button .= '<button type="button" class="btn btn-xs btn-primary" onclick="inactiveCategory(\'' . $categories->id . '\')">Tidak Aktif</button>&nbsp;';
                    } else {
                        $status = "Tidak Aktif";
                        $button .= '<button type="button" class="btn btn-xs btn-primary" onclick="activeCategory(\'' . $categories->id . '\')">Aktif</button>&nbsp;';
                    }
                }
                $button .= '<button type="button" class="btn btn-xs btn-success" onclick="window.location=\'' . URL::action('AdminController@updateCategory', $categories->id) . '\'"><i class="fa fa-pencil"></i></button>&nbsp;';
                $button .= '<button class="btn btn-xs btn-danger" onclick="deleteCategory(\'' . $categories->id . '\')"><i class="fa fa-trash"></i></button>';

                $data_raw = array(
                    $categories->description,
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

    public function inactiveCategory() {
        $data = Input::all();
        if (Request::ajax()) {

            $id = $data['id'];

            $category = Category::find($id);
            $category->is_active = 0;
            $updated = $category->save();
            if ($updated) {
                # Audit Trail
                $remarks = 'Category: ' . $category->description . ' has been updated.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "Master Setup";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    public function activeCategory() {
        $data = Input::all();
        if (Request::ajax()) {

            $id = $data['id'];

            $category = Category::find($id);
            $category->is_active = 1;
            $updated = $category->save();
            if ($updated) {
                # Audit Trail
                $remarks = 'Category: ' . $category->description . ' has been updated.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "Master Setup";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    public function deleteCategory() {
        $data = Input::all();
        if (Request::ajax()) {

            $id = $data['id'];

            $category = Category::find($id);
            $category->is_deleted = 1;
            $deleted = $category->save();
            if ($deleted) {
                # Audit Trail
                $remarks = 'Category: ' . $category->description . ' has been deleted.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "Master Setup";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    public function updateCategory($id) {
        //get user permission
        $user_permission = AccessGroup::getAccessPermission(Auth::user()->id);
        $category = Category::find($id);

        if (Session::get('lang') == "en") {
            $viewData = array(
                'title' => 'Update Category',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'category_list',
                'user_permission' => $user_permission,
                'category' => $category,
                'image' => ""
            );

            return View::make('page_en.update_category', $viewData);
        } else {
            $viewData = array(
                'title' => 'Edit Kategori',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'category_list',
                'user_permission' => $user_permission,
                'category' => $category,
                'image' => ""
            );

            return View::make('page_my.update_category', $viewData);
        }
    }

    public function submitUpdateCategory() {
        $data = Input::all();
        if (Request::ajax()) {
            $description = $data['description'];
            $is_active = $data['is_active'];
            $id = $data['id'];

            $category = Category::find($id);
            $category->description = $description;
            $category->is_active = $is_active;
            $success = $category->save();

            if ($success) {
                # Audit Trail
                $remarks = 'Category: ' . $category->description . ' has been updated.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "Master Setup";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    //land title
    public function landTitle() {
        //get user permission
        $user_permission = AccessGroup::getAccessPermission(Auth::user()->id);

        if (Session::get('lang') == "en") {
            $viewData = array(
                'title' => 'Land Title Maintenance',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'land_list',
                'user_permission' => $user_permission,
                'image' => ""
            );

            return View::make('page_en.land', $viewData);
        } else {
            $viewData = array(
                'title' => 'Pengurusan Jenis Tanah',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'land_list',
                'user_permission' => $user_permission,
                'image' => ""
            );

            return View::make('page_my.land', $viewData);
        }
    }

    public function addLandTitle() {
        //get user permission
        $user_permission = AccessGroup::getAccessPermission(Auth::user()->id);

        if (Session::get('lang') == "en") {
            $viewData = array(
                'title' => 'Add Land Title',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'land_list',
                'user_permission' => $user_permission,
                'image' => ""
            );

            return View::make('page_en.add_land', $viewData);
        } else {
            $viewData = array(
                'title' => 'Tambah Jenis Tanah',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'land_list',
                'user_permission' => $user_permission,
                'image' => ""
            );

            return View::make('page_my.add_land', $viewData);
        }
    }

    public function submitLandTitle() {
        $data = Input::all();
        if (Request::ajax()) {
            $description = $data['description'];
            $is_active = $data['is_active'];

            $land = new LandTitle();
            $land->description = $description;
            $land->is_active = $is_active;
            $success = $land->save();

            if ($success) {
                # Audit Trail
                $remarks = 'Land Title: ' . $land->description . ' has been inserted.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "Master Setup";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    public function getLandTitle() {
        $land = LandTitle::where('is_deleted', 0)->orderBy('id', 'desc')->get();

        if (count($land) > 0) {
            $data = Array();
            foreach ($land as $lands) {
                $button = "";
                if (Session::get('lang') == "en") {
                    if ($lands->is_active == 1) {
                        $status = "Active";
                        $button .= '<button type="button" class="btn btn-xs btn-primary" onclick="inactiveLandTitle(\'' . $lands->id . '\')">Inactive</button>&nbsp;';
                    } else {
                        $status = "Inactive";
                        $button .= '<button type="button" class="btn btn-xs btn-primary" onclick="activeLandTitle(\'' . $lands->id . '\')">Active</button>&nbsp;';
                    }
                } else {
                    if ($lands->is_active == 1) {
                        $status = "Aktif";
                        $button .= '<button type="button" class="btn btn-xs btn-primary" onclick="inactiveLandTitle(\'' . $lands->id . '\')">Tidak Aktif</button>&nbsp;';
                    } else {
                        $status = "Tidak Aktif";
                        $button .= '<button type="button" class="btn btn-xs btn-primary" onclick="activeLandTitle(\'' . $lands->id . '\')">Aktif</button>&nbsp;';
                    }
                }
                $button .= '<button type="button" class="btn btn-xs btn-success" onclick="window.location=\'' . URL::action('AdminController@updateLandTitle', $lands->id) . '\'"><i class="fa fa-pencil"></i></button>&nbsp;';
                $button .= '<button class="btn btn-xs btn-danger" onclick="deleteLandTitle(\'' . $lands->id . '\')"><i class="fa fa-trash"></i></button>';

                $data_raw = array(
                    $lands->description,
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

    public function inactiveLandTitle() {
        $data = Input::all();
        if (Request::ajax()) {

            $id = $data['id'];

            $land = LandTitle::find($id);
            $land->is_active = 0;
            $updated = $land->save();
            if ($updated) {
                # Audit Trail
                $remarks = 'Land Title: ' . $land->description . ' has been updated.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "Master Setup";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    public function activeLandTitle() {
        $data = Input::all();
        if (Request::ajax()) {

            $id = $data['id'];

            $land = LandTitle::find($id);
            $land->is_active = 1;
            $updated = $land->save();
            if ($updated) {
                # Audit Trail
                $remarks = 'Land Title: ' . $land->description . ' has been updated.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "Master Setup";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    public function deleteLandTitle() {
        $data = Input::all();
        if (Request::ajax()) {

            $id = $data['id'];

            $land = LandTitle::find($id);
            $land->is_deleted = 1;
            $deleted = $land->save();
            if ($deleted) {
                # Audit Trail
                $remarks = 'Land Title: ' . $land->description . ' has been deleted.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "Master Setup";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    public function updateLandTitle($id) {
        //get user permission
        $user_permission = AccessGroup::getAccessPermission(Auth::user()->id);
        $land = LandTitle::find($id);

        if (Session::get('lang') == "en") {
            $viewData = array(
                'title' => 'Update Land Title',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'land_list',
                'user_permission' => $user_permission,
                'land' => $land,
                'image' => ""
            );

            return View::make('page_en.update_land', $viewData);
        } else {
            $viewData = array(
                'title' => 'Edit Jenis Tanah',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'land_list',
                'user_permission' => $user_permission,
                'land' => $land,
                'image' => ""
            );

            return View::make('page_my.update_land', $viewData);
        }
    }

    public function submitUpdateLandTitle() {
        $data = Input::all();
        if (Request::ajax()) {
            $description = $data['description'];
            $is_active = $data['is_active'];
            $id = $data['id'];

            $land = LandTitle::find($id);
            $land->description = $description;
            $land->is_active = $is_active;
            $success = $land->save();

            if ($success) {
                # Audit Trail
                $remarks = 'Land Title: ' . $land->description . ' has been updated.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "Master Setup";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    //developer
    public function developer() {
        //get user permission
        $user_permission = AccessGroup::getAccessPermission(Auth::user()->id);

        if (Session::get('lang') == "en") {
            $viewData = array(
                'title' => 'Developer Maintenance',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'developer_list',
                'user_permission' => $user_permission,
                'image' => ""
            );

            return View::make('page_en.developer', $viewData);
        } else {
            $viewData = array(
                'title' => 'Pengurusan Pemaju',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'developer_list',
                'user_permission' => $user_permission,
                'image' => ""
            );

            return View::make('page_my.developer', $viewData);
        }
    }

    public function addDeveloper() {
        //get user permission
        $user_permission = AccessGroup::getAccessPermission(Auth::user()->id);
        $city = City::where('is_active', 1)->where('is_deleted', 0)->orderBy('description', 'asc')->get();
        $country = Country::where('is_active', 1)->where('is_deleted', 0)->orderBy('name', 'asc')->get();
        $state = State::where('is_active', 1)->where('is_deleted', 0)->orderBy('name', 'asc')->get();

        if (Session::get('lang') == "en") {
            $viewData = array(
                'title' => 'Add Developer',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'developer_list',
                'user_permission' => $user_permission,
                'city' => $city,
                'country' => $country,
                'state' => $state,
                'image' => ""
            );

            return View::make('page_en.add_developer', $viewData);
        } else {
            $viewData = array(
                'title' => 'Tambah Pemaju',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'developer_list',
                'user_permission' => $user_permission,
                'city' => $city,
                'country' => $country,
                'state' => $state,
                'image' => ""
            );

            return View::make('page_my.add_developer', $viewData);
        }
    }

    public function submitDeveloper() {
        $data = Input::all();
        if (Request::ajax()) {
            $name = $data['name'];
            $address1 = $data['address1'];
            $address2 = $data['address2'];
            $address3 = $data['address3'];
            $city = $data['city'];
            $poscode = $data['poscode'];
            $state = $data['state'];
            $country = $data['country'];
            $phone_no = $data['phone_no'];
            $fax_no = $data['fax_no'];
            $remarks = $data['remarks'];
            $is_active = $data['is_active'];

            $developer = new Developer();
            $developer->name = $name;
            $developer->address1 = $address1;
            $developer->address2 = $address2;
            $developer->address3 = $address3;
            $developer->city = $city;
            $developer->poscode = $poscode;
            $developer->state = $state;
            $developer->country = $country;
            $developer->phone_no = $phone_no;
            $developer->fax_no = $fax_no;
            $developer->remarks = $remarks;
            $developer->is_active = $is_active;
            $success = $developer->save();

            if ($success) {
                # Audit Trail
                $remarks = $developer->name . ' has been inserted.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "Master Setup";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    public function getDeveloper() {
        $developer = Developer::where('is_deleted', 0)->orderBy('id', 'desc')->get();

        if (count($developer) > 0) {
            $data = Array();
            foreach ($developer as $developers) {
                $button = "";
                if (Session::get('lang') == "en") {
                    if ($developers->is_active == 1) {
                        $status = "Active";
                        $button .= '<button type="button" class="btn btn-xs btn-primary" onclick="inactiveDeveloper(\'' . $developers->id . '\')">Inactive</button>&nbsp;';
                    } else {
                        $status = "Inactive";
                        $button .= '<button type="button" class="btn btn-xs btn-primary" onclick="activeDeveloper(\'' . $developers->id . '\')">Active</button>&nbsp;';
                    }
                } else {
                    if ($developers->is_active == 1) {
                        $status = "Aktif";
                        $button .= '<button type="button" class="btn btn-xs btn-primary" onclick="inactiveDeveloper(\'' . $developers->id . '\')">Tidak Aktif</button>&nbsp;';
                    } else {
                        $status = "Tidak Aktif";
                        $button .= '<button type="button" class="btn btn-xs btn-primary" onclick="activeDeveloper(\'' . $developers->id . '\')">Aktif</button>&nbsp;';
                    }
                }
                $button .= '<button type="button" class="btn btn-xs btn-success" onclick="window.location=\'' . URL::action('AdminController@updateDeveloper', $developers->id) . '\'"><i class="fa fa-pencil"></i></button>&nbsp;';
                $button .= '<button class="btn btn-xs btn-danger" onclick="deleteDeveloper(\'' . $developers->id . '\')"><i class="fa fa-trash"></i></button>';

                $data_raw = array(
                    $developers->name,
                    $developers->phone_no,
                    $developers->fax_no,
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

    public function inactiveDeveloper() {
        $data = Input::all();
        if (Request::ajax()) {

            $id = $data['id'];

            $developer = Developer::find($id);
            $developer->is_active = 0;
            $updated = $developer->save();
            if ($updated) {
                # Audit Trail
                $remarks = $developer->name . ' has been updated.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "Master Setup";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    public function activeDeveloper() {
        $data = Input::all();
        if (Request::ajax()) {

            $id = $data['id'];

            $developer = Developer::find($id);
            $developer->is_active = 1;
            $updated = $developer->save();
            if ($updated) {
                # Audit Trail
                $remarks = $developer->name . ' has been updated.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "Master Setup";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    public function deleteDeveloper() {
        $data = Input::all();
        if (Request::ajax()) {

            $id = $data['id'];

            $developer = Developer::find($id);
            $developer->is_deleted = 1;
            $deleted = $developer->save();
            if ($deleted) {
                # Audit Trail
                $remarks = $developer->name . ' has been deleted.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "Master Setup";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    public function updateDeveloper($id) {
        //get user permission
        $user_permission = AccessGroup::getAccessPermission(Auth::user()->id);
        $developer = Developer::find($id);
        $city = City::where('is_active', 1)->where('is_deleted', 0)->orderBy('description', 'asc')->get();
        $country = Country::where('is_active', 1)->where('is_deleted', 0)->orderBy('name', 'asc')->get();
        $state = State::where('is_active', 1)->where('is_deleted', 0)->orderBy('name', 'asc')->get();

        if (Session::get('lang') == "en") {
            $viewData = array(
                'title' => 'Update Developer',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'developer_list',
                'user_permission' => $user_permission,
                'developer' => $developer,
                'city' => $city,
                'country' => $country,
                'state' => $state,
                'image' => ""
            );

            return View::make('page_en.update_developer', $viewData);
        } else {
            $viewData = array(
                'title' => 'Edit Pemaju',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'developer_list',
                'user_permission' => $user_permission,
                'developer' => $developer,
                'city' => $city,
                'country' => $country,
                'state' => $state,
                'image' => ""
            );

            return View::make('page_my.update_developer', $viewData);
        }
    }

    public function submitUpdateDeveloper() {
        $data = Input::all();
        if (Request::ajax()) {
            $id = $data['id'];
            $name = $data['name'];
            $address1 = $data['address1'];
            $address2 = $data['address2'];
            $address3 = $data['address3'];
            $city = $data['city'];
            $poscode = $data['poscode'];
            $state = $data['state'];
            $country = $data['country'];
            $phone_no = $data['phone_no'];
            $fax_no = $data['fax_no'];
            $remarks = $data['remarks'];
            $is_active = $data['is_active'];

            $developer = Developer::find($id);
            $developer->name = $name;
            $developer->address1 = $address1;
            $developer->address2 = $address2;
            $developer->address3 = $address3;
            $developer->city = $city;
            $developer->poscode = $poscode;
            $developer->state = $state;
            $developer->country = $country;
            $developer->phone_no = $phone_no;
            $developer->fax_no = $fax_no;
            $developer->remarks = $remarks;
            $developer->is_active = $is_active;
            $success = $developer->save();

            if ($success) {
                # Audit Trail
                $remarks = $developer->name . ' has been updated.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "Master Setup";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    //agent
    public function agent() {
        //get user permission
        $user_permission = AccessGroup::getAccessPermission(Auth::user()->id);

        if (Session::get('lang') == "en") {
            $viewData = array(
                'title' => 'Agent Maintenance',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'agent_list',
                'user_permission' => $user_permission,
                'image' => ""
            );

            return View::make('page_en.agent', $viewData);
        } else {
            $viewData = array(
                'title' => 'Pengurusan Ejen',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'agent_list',
                'user_permission' => $user_permission,
                'image' => ""
            );

            return View::make('page_my.agent', $viewData);
        }
    }

    public function addAgent() {
        //get user permission
        $user_permission = AccessGroup::getAccessPermission(Auth::user()->id);
        $city = City::where('is_active', 1)->where('is_deleted', 0)->orderBy('description', 'asc')->get();
        $country = Country::where('is_active', 1)->where('is_deleted', 0)->orderBy('name', 'asc')->get();
        $state = State::where('is_active', 1)->where('is_deleted', 0)->orderBy('name', 'asc')->get();

        if (Session::get('lang') == "en") {
            $viewData = array(
                'title' => 'Add Agent',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'agent_list',
                'user_permission' => $user_permission,
                'city' => $city,
                'country' => $country,
                'state' => $state,
                'image' => ""
            );

            return View::make('page_en.add_agent', $viewData);
        } else {
            $viewData = array(
                'title' => 'Tambah Ejen',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'agent_list',
                'user_permission' => $user_permission,
                'city' => $city,
                'country' => $country,
                'state' => $state,
                'image' => ""
            );

            return View::make('page_my.add_agent', $viewData);
        }
    }

    public function submitAgent() {
        $data = Input::all();
        if (Request::ajax()) {
            $name = $data['name'];
            $address1 = $data['address1'];
            $address2 = $data['address2'];
            $address3 = $data['address3'];
            $city = $data['city'];
            $poscode = $data['poscode'];
            $state = $data['state'];
            $country = $data['country'];
            $phone_no = $data['phone_no'];
            $fax_no = $data['fax_no'];
            $remarks = $data['remarks'];
            $is_active = $data['is_active'];

            $agent = new Agent();
            $agent->name = $name;
            $agent->address1 = $address1;
            $agent->address2 = $address2;
            $agent->address3 = $address3;
            $agent->city = $city;
            $agent->poscode = $poscode;
            $agent->state = $state;
            $agent->country = $country;
            $agent->phone_no = $phone_no;
            $agent->fax_no = $fax_no;
            $agent->remarks = $remarks;
            $agent->is_active = $is_active;
            $success = $agent->save();

            if ($success) {
                # Audit Trail
                $remarks = $agent->name . ' has been inserted.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "Master Setup";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    public function getAgent() {
        $agent = Agent::where('is_deleted', 0)->orderBy('id', 'desc')->get();

        if (count($agent) > 0) {
            $data = Array();
            foreach ($agent as $agents) {
                $button = "";
                if (Session::get('lang') == "en") {
                    if ($agents->is_active == 1) {
                        $status = "Active";
                        $button .= '<button type="button" class="btn btn-xs btn-primary" onclick="inactiveAgent(\'' . $agents->id . '\')">Inactive</button>&nbsp;';
                    } else {
                        $status = "Inactive";
                        $button .= '<button type="button" class="btn btn-xs btn-primary" onclick="activeAgent(\'' . $agents->id . '\')">Active</button>&nbsp;';
                    }
                } else {
                    if ($agents->is_active == 1) {
                        $status = "Aktif";
                        $button .= '<button type="button" class="btn btn-xs btn-primary" onclick="inactiveAgent(\'' . $agents->id . '\')">Tidak Aktif</button>&nbsp;';
                    } else {
                        $status = "Tidak Aktif";
                        $button .= '<button type="button" class="btn btn-xs btn-primary" onclick="activeAgent(\'' . $agents->id . '\')">Aktif</button>&nbsp;';
                    }
                }
                $button .= '<button type="button" class="btn btn-xs btn-success" onclick="window.location=\'' . URL::action('AdminController@updateAgent', $agents->id) . '\'"><i class="fa fa-pencil"></i></button>&nbsp;';
                $button .= '<button class="btn btn-xs btn-danger" onclick="deleteAgent(\'' . $agents->id . '\')"><i class="fa fa-trash"></i></button>';

                $data_raw = array(
                    $agents->name,
                    $agents->phone_no,
                    $agents->fax_no,
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

    public function inactiveAgent() {
        $data = Input::all();
        if (Request::ajax()) {

            $id = $data['id'];

            $agent = Agent::find($id);
            $agent->is_active = 0;
            $updated = $agent->save();
            if ($updated) {
                # Audit Trail
                $remarks = $agent->name . ' has been updated.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "Master Setup";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    public function activeAgent() {
        $data = Input::all();
        if (Request::ajax()) {

            $id = $data['id'];

            $agent = Agent::find($id);
            $agent->is_active = 1;
            $updated = $agent->save();
            if ($updated) {
                # Audit Trail
                $remarks = $agent->name . ' has been updated.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "Master Setup";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    public function deleteAgent() {
        $data = Input::all();
        if (Request::ajax()) {

            $id = $data['id'];

            $agent = Agent::find($id);
            $agent->is_deleted = 1;
            $deleted = $agent->save();
            if ($deleted) {
                # Audit Trail
                $remarks = $agent->name . ' has been deleted.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "Master Setup";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    public function updateAgent($id) {
        //get user permission
        $user_permission = AccessGroup::getAccessPermission(Auth::user()->id);
        $agent = Agent::find($id);
        $city = City::where('is_active', 1)->where('is_deleted', 0)->orderBy('description', 'asc')->get();
        $country = Country::where('is_active', 1)->where('is_deleted', 0)->orderBy('name', 'asc')->get();
        $state = State::where('is_active', 1)->where('is_deleted', 0)->orderBy('name', 'asc')->get();

        if (Session::get('lang') == "en") {
            $viewData = array(
                'title' => 'Update Agent',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'agent_list',
                'user_permission' => $user_permission,
                'agent' => $agent,
                'city' => $city,
                'country' => $country,
                'state' => $state,
                'image' => ""
            );

            return View::make('page_en.update_agent', $viewData);
        } else {
            $viewData = array(
                'title' => 'Edit Ejen',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'agent_list',
                'user_permission' => $user_permission,
                'agent' => $agent,
                'city' => $city,
                'country' => $country,
                'state' => $state,
                'image' => ""
            );

            return View::make('page_my.update_agent', $viewData);
        }
    }

    public function submitUpdateAgent() {
        $data = Input::all();
        if (Request::ajax()) {
            $id = $data['id'];
            $name = $data['name'];
            $address1 = $data['address1'];
            $address2 = $data['address2'];
            $address3 = $data['address3'];
            $city = $data['city'];
            $poscode = $data['poscode'];
            $state = $data['state'];
            $country = $data['country'];
            $phone_no = $data['phone_no'];
            $fax_no = $data['fax_no'];
            $remarks = $data['remarks'];
            $is_active = $data['is_active'];

            $agent = Agent::find($id);
            $agent->name = $name;
            $agent->address1 = $address1;
            $agent->address2 = $address2;
            $agent->address3 = $address3;
            $agent->city = $city;
            $agent->poscode = $poscode;
            $agent->state = $state;
            $agent->country = $country;
            $agent->phone_no = $phone_no;
            $agent->fax_no = $fax_no;
            $agent->remarks = $remarks;
            $agent->is_active = $is_active;
            $success = $agent->save();

            if ($success) {
                # Audit Trail
                $remarks = $agent->name . ' has been updated.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "Master Setup";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    //parliment
    public function parliment() {
        //get user permission
        $user_permission = AccessGroup::getAccessPermission(Auth::user()->id);

        if (Session::get('lang') == "en") {
            $viewData = array(
                'title' => 'Parliment Maintenance',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'parliament_list',
                'user_permission' => $user_permission,
                'image' => ""
            );

            return View::make('page_en.parliment', $viewData);
        } else {
            $viewData = array(
                'title' => 'Pengurusan Parlimen',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'parliament_list',
                'user_permission' => $user_permission,
                'image' => ""
            );

            return View::make('page_my.parliment', $viewData);
        }
    }

    public function addParliment() {
        //get user permission
        $user_permission = AccessGroup::getAccessPermission(Auth::user()->id);

        if (Session::get('lang') == "en") {
            $viewData = array(
                'title' => 'Add Parliament',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'parliament_list',
                'user_permission' => $user_permission,
                'image' => ""
            );

            return View::make('page_en.add_parliment', $viewData);
        } else {
            $viewData = array(
                'title' => 'Tambah Parlimen',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'parliament_list',
                'user_permission' => $user_permission,
                'image' => ""
            );

            return View::make('page_my.add_parliment', $viewData);
        }
    }

    public function submitParliment() {
        $data = Input::all();
        if (Request::ajax()) {
            $description = $data['description'];
            $is_active = $data['is_active'];

            $parliment = new Parliment();
            $parliment->description = $description;
            $parliment->is_active = $is_active;
            $success = $parliment->save();

            if ($success) {
                # Audit Trail
                $remarks = 'Parliament: ' . $parliment->description . ' has been inserted.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "Master Setup";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    public function getParliment() {
        $parliment = Parliment::where('is_deleted', 0)->orderBy('id', 'desc')->get();

        if (count($parliment) > 0) {
            $data = Array();
            foreach ($parliment as $parliments) {
                $button = "";
                if (Session::get('lang') == "en") {
                    if ($parliments->is_active == 1) {
                        $status = "Active";
                        $button .= '<button type="button" class="btn btn-xs btn-primary" onclick="inactiveParliment(\'' . $parliments->id . '\')">Inactive</button>&nbsp;';
                    } else {
                        $status = "Inactive";
                        $button .= '<button type="button" class="btn btn-xs btn-primary" onclick="activeParliment(\'' . $parliments->id . '\')">Active</button>&nbsp;';
                    }
                } else {
                    if ($parliments->is_active == 1) {
                        $status = "Aktif";
                        $button .= '<button type="button" class="btn btn-xs btn-primary" onclick="inactiveParliment(\'' . $parliments->id . '\')">Tidak Aktif</button>&nbsp;';
                    } else {
                        $status = "Tidak Aktif";
                        $button .= '<button type="button" class="btn btn-xs btn-primary" onclick="activeParliment(\'' . $parliments->id . '\')">Aktif</button>&nbsp;';
                    }
                }
                $button .= '<button type="button" class="btn btn-xs btn-success" onclick="window.location=\'' . URL::action('AdminController@updateParliment', $parliments->id) . '\'"><i class="fa fa-pencil"></i></button>&nbsp;';
                $button .= '<button class="btn btn-xs btn-danger" onclick="deleteParliment(\'' . $parliments->id . '\')"><i class="fa fa-trash"></i></button>';

                $data_raw = array(
                    $parliments->description,
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

    public function inactiveParliment() {
        $data = Input::all();
        if (Request::ajax()) {

            $id = $data['id'];

            $parliment = Parliment::find($id);
            $parliment->is_active = 0;
            $updated = $parliment->save();
            if ($updated) {
                # Audit Trail
                $remarks = 'Parliament: ' . $parliment->description . ' has been updated.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "Master Setup";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    public function activeParliment() {
        $data = Input::all();
        if (Request::ajax()) {

            $id = $data['id'];

            $parliment = Parliment::find($id);
            $parliment->is_active = 1;
            $updated = $parliment->save();
            if ($updated) {
                # Audit Trail
                $remarks = 'Parliament: ' . $parliment->description . ' has been updated.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "Master Setup";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    public function deleteParliment() {
        $data = Input::all();
        if (Request::ajax()) {

            $id = $data['id'];

            $parliment = Parliment::find($id);
            $parliment->is_deleted = 1;
            $deleted = $parliment->save();
            if ($deleted) {
                # Audit Trail
                $remarks = 'Parliament: ' . $parliment->description . ' has been deleted.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "Master Setup";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    public function updateParliment($id) {
        //get user permission
        $user_permission = AccessGroup::getAccessPermission(Auth::user()->id);
        $parliment = Parliment::find($id);

        if (Session::get('lang') == "en") {
            $viewData = array(
                'title' => 'Update Parliament',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'parliament_list',
                'user_permission' => $user_permission,
                'parliment' => $parliment,
                'image' => ""
            );

            return View::make('page_en.update_parliment', $viewData);
        } else {
            $viewData = array(
                'title' => 'Edit Parlimen',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'parliament_list',
                'user_permission' => $user_permission,
                'parliment' => $parliment,
                'image' => ""
            );

            return View::make('page_my.update_parliment', $viewData);
        }
    }

    public function submitUpdateParliment() {
        $data = Input::all();
        if (Request::ajax()) {
            $description = $data['description'];
            $is_active = $data['is_active'];
            $id = $data['id'];

            $parliment = Parliment::find($id);
            $parliment->description = $description;
            $parliment->is_active = $is_active;
            $success = $parliment->save();

            if ($success) {
                # Audit Trail
                $remarks = 'Parliament: ' . $parliment->description . ' has been updated.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "Master Setup";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    //DUN
    public function dun() {
        //get user permission
        $user_permission = AccessGroup::getAccessPermission(Auth::user()->id);
        $parliament = Parliment::where('is_active', 1)->where('is_deleted', 0)->get();

        if (Session::get('lang') == "en") {
            $viewData = array(
                'title' => 'DUN Maintenance',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'dun_list',
                'user_permission' => $user_permission,
                'parliament' => $parliament,
                'image' => ""
            );

            return View::make('page_en.dun', $viewData);
        } else {
            $viewData = array(
                'title' => 'Pengurusan DUN',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'dun_list',
                'user_permission' => $user_permission,
                'parliament' => $parliament,
                'image' => ""
            );

            return View::make('page_my.dun', $viewData);
        }
    }

    public function addDun() {
        //get user permission
        $user_permission = AccessGroup::getAccessPermission(Auth::user()->id);
        $parliament = Parliment::where('is_active', 1)->where('is_deleted', 0)->get();

        if (Session::get('lang') == "en") {
            $viewData = array(
                'title' => 'Add DUN',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'dun_list',
                'user_permission' => $user_permission,
                'parliament' => $parliament,
                'image' => ""
            );

            return View::make('page_en.add_dun', $viewData);
        } else {
            $viewData = array(
                'title' => 'Tambah DUN',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'dun_list',
                'user_permission' => $user_permission,
                'parliament' => $parliament,
                'image' => ""
            );

            return View::make('page_my.add_dun', $viewData);
        }
    }

    public function submitDun() {
        $data = Input::all();
        if (Request::ajax()) {
            $parliament = $data['parliament'];
            $description = $data['description'];
            $is_active = $data['is_active'];

            $dun = new Dun();
            $dun->parliament = $parliament;
            $dun->description = $description;
            $dun->is_active = $is_active;
            $success = $dun->save();

            if ($success) {
                # Audit Trail
                $remarks = 'DUN: ' . $dun->description . ' has been inserted.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "Master Setup";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    public function getDun() {
        $dun = Dun::where('is_deleted', 0)->orderBy('id', 'desc')->get();

        if (count($dun) > 0) {
            $data = Array();
            foreach ($dun as $duns) {
                $parliament = Parliment::find($duns->parliament);
                $button = "";
                if (Session::get('lang') == "en") {
                    if ($duns->is_active == 1) {
                        $status = "Active";
                        $button .= '<button type="button" class="btn btn-xs btn-primary" onclick="inactiveDun(\'' . $duns->id . '\')">Inactive</button>&nbsp;';
                    } else {
                        $status = "Inactive";
                        $button .= '<button type="button" class="btn btn-xs btn-primary" onclick="activeDun(\'' . $duns->id . '\')">Active</button>&nbsp;';
                    }
                } else {
                    if ($duns->is_active == 1) {
                        $status = "Aktif";
                        $button .= '<button type="button" class="btn btn-xs btn-primary" onclick="inactiveDun(\'' . $duns->id . '\')">Tidak Aktif</button>&nbsp;';
                    } else {
                        $status = "Tidak Aktif";
                        $button .= '<button type="button" class="btn btn-xs btn-primary" onclick="activeDun(\'' . $duns->id . '\')">Aktif</button>&nbsp;';
                    }
                }

                $button .= '<button type="button" class="btn btn-xs btn-success" onclick="window.location=\'' . URL::action('AdminController@updateDun', $duns->id) . '\'"><i class="fa fa-pencil"></i></button>&nbsp;';
                $button .= '<button class="btn btn-xs btn-danger" onclick="deleteDun(\'' . $duns->id . '\')"><i class="fa fa-trash"></i></button>';

                $data_raw = array(
                    $duns->description,
                    $parliament->description,
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

    public function inactiveDun() {
        $data = Input::all();
        if (Request::ajax()) {

            $id = $data['id'];

            $dun = Dun::find($id);
            $dun->is_active = 0;
            $updated = $dun->save();
            if ($updated) {
                # Audit Trail
                $remarks = 'DUN: ' . $dun->description . ' has been updated.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "Master Setup";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    public function activeDun() {
        $data = Input::all();
        if (Request::ajax()) {

            $id = $data['id'];

            $dun = Dun::find($id);
            $dun->is_active = 1;
            $updated = $dun->save();
            if ($updated) {
                # Audit Trail
                $remarks = 'DUN: ' . $dun->description . ' has been updated.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "Master Setup";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    public function deleteDun() {
        $data = Input::all();
        if (Request::ajax()) {

            $id = $data['id'];

            $dun = Dun::find($id);
            $dun->is_deleted = 1;
            $deleted = $dun->save();
            if ($deleted) {
                # Audit Trail
                $remarks = 'DUN: ' . $dun->description . ' has been deleted.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "Master Setup";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    public function updateDun($id) {
        //get user permission
        $user_permission = AccessGroup::getAccessPermission(Auth::user()->id);
        $dun = Dun::find($id);
        $parliament = Parliment::where('is_active', 1)->where('is_deleted', 0)->get();

        if (Session::get('lang') == "en") {
            $viewData = array(
                'title' => 'Update DUN',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'dun_list',
                'user_permission' => $user_permission,
                'dun' => $dun,
                'parliament' => $parliament,
                'image' => ""
            );

            return View::make('page_en.update_dun', $viewData);
        } else {
            $viewData = array(
                'title' => 'Edit DUN',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'dun_list',
                'user_permission' => $user_permission,
                'dun' => $dun,
                'parliament' => $parliament,
                'image' => ""
            );

            return View::make('page_my.update_dun', $viewData);
        }
    }

    public function submitUpdateDun() {
        $data = Input::all();
        if (Request::ajax()) {
            $parliament = $data['parliament'];
            $description = $data['description'];
            $is_active = $data['is_active'];
            $id = $data['id'];

            $dun = Dun::find($id);
            $dun->parliament = $parliament;
            $dun->description = $description;
            $dun->is_active = $is_active;
            $success = $dun->save();

            if ($success) {
                # Audit Trail
                $remarks = 'DUN: ' . $dun->description . ' has been updated.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "Master Setup";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    //Park
    public function park() {
        //get user permission
        $user_permission = AccessGroup::getAccessPermission(Auth::user()->id);
        $dun = Dun::where('is_active', 1)->where('is_deleted', 0)->orderBy('description')->get();

        if (Session::get('lang') == "en") {
            $viewData = array(
                'title' => 'Park Maintenance',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'park_list',
                'user_permission' => $user_permission,
                'dun' => $dun,
                'image' => ""
            );

            return View::make('page_en.park', $viewData);
        } else {
            $viewData = array(
                'title' => 'Pengurusan Taman',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'park_list',
                'user_permission' => $user_permission,
                'dun' => $dun,
                'image' => ""
            );

            return View::make('page_my.park', $viewData);
        }
    }

    public function addPark() {
        //get user permission
        $user_permission = AccessGroup::getAccessPermission(Auth::user()->id);
        $dun = Dun::where('is_active', 1)->where('is_deleted', 0)->orderBy('description')->get();

        if (Session::get('lang') == "en") {
            $viewData = array(
                'title' => 'Add Park',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'park_list',
                'user_permission' => $user_permission,
                'dun' => $dun,
                'image' => ""
            );

            return View::make('page_en.add_park', $viewData);
        } else {
            $viewData = array(
                'title' => 'Tambah Taman',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'park_list',
                'user_permission' => $user_permission,
                'dun' => $dun,
                'image' => ""
            );

            return View::make('page_my.add_park', $viewData);
        }
    }

    public function submitPark() {
        $data = Input::all();
        if (Request::ajax()) {
            $dun = $data['dun'];
            $description = $data['description'];
            $is_active = $data['is_active'];

            $park = new Park();
            $park->dun = $dun;
            $park->description = $description;
            $park->is_active = $is_active;
            $success = $park->save();

            if ($success) {
                # Audit Trail
                $remarks = 'Park: ' . $park->description . ' has been inserted.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "Master Setup";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    public function getPark() {
        $park = Park::where('is_deleted', 0)->orderBy('id', 'desc')->get();

        if (count($park) > 0) {
            $data = Array();
            foreach ($park as $parks) {
                $dun = Dun::find($parks->dun);
                $button = "";
                if (Session::get('lang') == "en") {
                    if ($parks->is_active == 1) {
                        $status = "Active";
                        $button .= '<button type="button" class="btn btn-xs btn-primary" onclick="inactivePark(\'' . $parks->id . '\')">Inactive</button>&nbsp;';
                    } else {
                        $status = "Inactive";
                        $button .= '<button type="button" class="btn btn-xs btn-primary" onclick="activePark(\'' . $parks->id . '\')">Active</button>&nbsp;';
                    }
                } else {
                    if ($parks->is_active == 1) {
                        $status = "Aktif";
                        $button .= '<button type="button" class="btn btn-xs btn-primary" onclick="inactivePark(\'' . $parks->id . '\')">Tidak Aktif</button>&nbsp;';
                    } else {
                        $status = "Tidak Aktif";
                        $button .= '<button type="button" class="btn btn-xs btn-primary" onclick="activePark(\'' . $parks->id . '\')">Aktif</button>&nbsp;';
                    }
                }

                $button .= '<button type="button" class="btn btn-xs btn-success" onclick="window.location=\'' . URL::action('AdminController@updatePark', $parks->id) . '\'"><i class="fa fa-pencil"></i></button>&nbsp;';
                $button .= '<button class="btn btn-xs btn-danger" onclick="deletePark(\'' . $parks->id . '\')"><i class="fa fa-trash"></i></button>';

                $data_raw = array(
                    $parks->description,
                    $dun->description,
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

    public function inactivePark() {
        $data = Input::all();
        if (Request::ajax()) {

            $id = $data['id'];

            $park = Park::find($id);
            $park->is_active = 0;
            $updated = $park->save();
            if ($updated) {
                # Audit Trail
                $remarks = 'Park: ' . $park->description . ' has been updated.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "Master Setup";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    public function activePark() {
        $data = Input::all();
        if (Request::ajax()) {

            $id = $data['id'];

            $park = Park::find($id);
            $park->is_active = 1;
            $updated = $park->save();
            if ($updated) {
                # Audit Trail
                $remarks = 'Park: ' . $park->description . ' has been updated.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "Master Setup";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    public function deletePark() {
        $data = Input::all();
        if (Request::ajax()) {

            $id = $data['id'];

            $park = Park::find($id);
            $park->is_deleted = 1;
            $deleted = $park->save();
            if ($deleted) {
                # Audit Trail
                $remarks = 'Park: ' . $park->description . ' has been deleted.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "Master Setup";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    public function updatePark($id) {
        //get user permission
        $user_permission = AccessGroup::getAccessPermission(Auth::user()->id);
        $park = Park::find($id);
        $dun = Dun::where('is_active', 1)->where('is_deleted', 0)->get();

        if (Session::get('lang') == "en") {
            $viewData = array(
                'title' => 'Update Park',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'park_list',
                'user_permission' => $user_permission,
                'park' => $park,
                'dun' => $dun,
                'image' => ""
            );

            return View::make('page_en.update_park', $viewData);
        } else {
            $viewData = array(
                'title' => 'Edit Taman',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'park_list',
                'user_permission' => $user_permission,
                'park' => $park,
                'dun' => $dun,
                'image' => ""
            );

            return View::make('page_my.update_park', $viewData);
        }
    }

    public function submitUpdatePark() {
        $data = Input::all();
        if (Request::ajax()) {
            $dun = $data['dun'];
            $description = $data['description'];
            $is_active = $data['is_active'];
            $id = $data['id'];

            $park = Park::find($id);
            $park->dun = $dun;
            $park->description = $description;
            $park->is_active = $is_active;
            $success = $park->save();

            if ($success) {
                # Audit Trail
                $remarks = 'Park: ' . $park->description . ' has been updated.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "Master Setup";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    //memo type
    public function memoType() {
        //get user permission
        $user_permission = AccessGroup::getAccessPermission(Auth::user()->id);

        if (Session::get('lang') == "en") {
            $viewData = array(
                'title' => 'Memo Type Maintenance',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'memo_list',
                'user_permission' => $user_permission,
                'image' => ""
            );

            return View::make('page_en.memotype', $viewData);
        } else {
            $viewData = array(
                'title' => 'Pengurusan Jenis Memo',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'memo_list',
                'user_permission' => $user_permission,
                'image' => ""
            );

            return View::make('page_my.memotype', $viewData);
        }
    }

    public function addMemoType() {
        //get user permission
        $user_permission = AccessGroup::getAccessPermission(Auth::user()->id);

        if (Session::get('lang') == "en") {
            $viewData = array(
                'title' => 'Add Memo Type',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'memo_list',
                'user_permission' => $user_permission,
                'image' => ""
            );

            return View::make('page_en.add_memotype', $viewData);
        } else {
            $viewData = array(
                'title' => 'Tambah Jenis Memo',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'memo_list',
                'user_permission' => $user_permission,
                'image' => ""
            );

            return View::make('page_my.add_memotype', $viewData);
        }
    }

    public function submitMemoType() {
        $data = Input::all();
        if (Request::ajax()) {
            $description = $data['description'];
            $is_active = $data['is_active'];

            $memotype = new MemoType();
            $memotype->description = $description;
            $memotype->is_active = $is_active;
            $success = $memotype->save();

            if ($success) {
                # Audit Trail
                $remarks = 'Memo Type: ' . $memotype->description . ' has been inserted.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "Master Setup";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    public function getMemoType() {
        $memotype = MemoType::where('is_deleted', 0)->orderBy('id', 'desc')->get();

        if (count($memotype) > 0) {
            $data = Array();
            foreach ($memotype as $memotypes) {
                $button = "";
                if (Session::get('lang') == "en") {
                    if ($memotypes->is_active == 1) {
                        $status = "Active";
                        $button .= '<button type="button" class="btn btn-xs btn-primary" onclick="inactiveMemoType(\'' . $memotypes->id . '\')">Inactive</button>&nbsp;';
                    } else {
                        $status = "Inactive";
                        $button .= '<button type="button" class="btn btn-xs btn-primary" onclick="activeMemoType(\'' . $memotypes->id . '\')">Active</button>&nbsp;';
                    }
                } else {
                    if ($memotypes->is_active == 1) {
                        $status = "Aktif";
                        $button .= '<button type="button" class="btn btn-xs btn-primary" onclick="inactiveMemoType(\'' . $memotypes->id . '\')">Tidak Aktif</button>&nbsp;';
                    } else {
                        $status = "Tidak Aktif";
                        $button .= '<button type="button" class="btn btn-xs btn-primary" onclick="activeMemoType(\'' . $memotypes->id . '\')">Aktif</button>&nbsp;';
                    }
                }
                $button .= '<button type="button" class="btn btn-xs btn-success" onclick="window.location=\'' . URL::action('AdminController@updateMemoType', $memotypes->id) . '\'"><i class="fa fa-pencil"></i></button>&nbsp;';
                $button .= '<button class="btn btn-xs btn-danger" onclick="deleteMemoType(\'' . $memotypes->id . '\')"><i class="fa fa-trash"></i></button>';

                $data_raw = array(
                    $memotypes->description,
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

    public function inactiveMemoType() {
        $data = Input::all();
        if (Request::ajax()) {

            $id = $data['id'];

            $memotype = MemoType::find($id);
            $memotype->is_active = 0;
            $updated = $memotype->save();
            if ($updated) {
                # Audit Trail
                $remarks = 'Memo Type: ' . $memotype->description . ' has been updated.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "Master Setup";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    public function activeMemoType() {
        $data = Input::all();
        if (Request::ajax()) {

            $id = $data['id'];

            $memotype = MemoType::find($id);
            $memotype->is_active = 1;
            $updated = $memotype->save();
            if ($updated) {
                # Audit Trail
                $remarks = 'Memo Type: ' . $memotype->description . ' has been updated.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "Master Setup";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    public function deleteMemoType() {
        $data = Input::all();
        if (Request::ajax()) {

            $id = $data['id'];

            $memotype = MemoType::find($id);
            $memotype->is_deleted = 1;
            $deleted = $memotype->save();
            if ($deleted) {
                # Audit Trail
                $remarks = 'Memo Type: ' . $memotype->description . ' has been deleted.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "Master Setup";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    public function updateMemoType($id) {
        //get user permission
        $user_permission = AccessGroup::getAccessPermission(Auth::user()->id);
        $memoType = MemoType::find($id);

        if (Session::get('lang') == "en") {
            $viewData = array(
                'title' => 'Update Memo Type',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'memo_list',
                'user_permission' => $user_permission,
                'memoType' => $memoType,
                'image' => ""
            );

            return View::make('page_en.update_memotype', $viewData);
        } else {
            $viewData = array(
                'title' => 'Edit Jenis Memo',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'memo_list',
                'user_permission' => $user_permission,
                'memoType' => $memoType,
                'image' => ""
            );

            return View::make('page_my.update_memotype', $viewData);
        }
    }

    public function submitUpdateMemoType() {
        $data = Input::all();
        if (Request::ajax()) {
            $description = $data['description'];
            $is_active = $data['is_active'];
            $id = $data['id'];

            $memotype = MemoType::find($id);
            $memotype->description = $description;
            $memotype->is_active = $is_active;
            $success = $memotype->save();

            if ($success) {
                # Audit Trail
                $remarks = 'Memo Type: ' . $memotype->description . ' has been updated.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "Master Setup";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    //Designation
    public function designation() {
        //get user permission
        $user_permission = AccessGroup::getAccessPermission(Auth::user()->id);

        if (Session::get('lang') == "en") {
            $viewData = array(
                'title' => 'Designation Maintenance',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'designation_list',
                'user_permission' => $user_permission,
                'image' => ""
            );

            return View::make('page_en.designation', $viewData);
        } else {
            $viewData = array(
                'title' => 'Pengurusan Jawatan',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'designation_list',
                'user_permission' => $user_permission,
                'image' => ""
            );

            return View::make('page_my.designation', $viewData);
        }
    }

    public function addDesignation() {
        //get user permission
        $user_permission = AccessGroup::getAccessPermission(Auth::user()->id);

        if (Session::get('lang') == "en") {
            $viewData = array(
                'title' => 'Add Designation',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'designation_list',
                'user_permission' => $user_permission,
                'image' => ""
            );

            return View::make('page_en.add_designation', $viewData);
        } else {
            $viewData = array(
                'title' => 'Tambah Jawatan',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'designation_list',
                'user_permission' => $user_permission,
                'image' => ""
            );

            return View::make('page_my.add_designation', $viewData);
        }
    }

    public function submitDesignation() {
        $data = Input::all();
        if (Request::ajax()) {
            $description = $data['description'];
            $is_active = $data['is_active'];

            $designation = new Designation();
            $designation->description = $description;
            $designation->is_active = $is_active;
            $success = $designation->save();

            if ($success) {
                # Audit Trail
                $remarks = 'Designation: ' . $designation->description . ' has been inserted.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "Master Setup";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    public function getDesignation() {
        $designation = Designation::where('is_deleted', 0)->orderBy('id', 'desc')->get();

        if (count($designation) > 0) {
            $data = Array();
            foreach ($designation as $designations) {
                $button = "";
                if (Session::get('lang') == "en") {
                    if ($designations->is_active == 1) {
                        $status = "Active";
                        $button .= '<button type="button" class="btn btn-xs btn-primary" onclick="inactiveDesignation(\'' . $designations->id . '\')">Inactive</button>&nbsp;';
                    } else {
                        $status = "Inactive";
                        $button .= '<button type="button" class="btn btn-xs btn-primary" onclick="activeDesignation(\'' . $designations->id . '\')">Active</button>&nbsp;';
                    }
                } else {
                    if ($designations->is_active == 1) {
                        $status = "Aktif";
                        $button .= '<button type="button" class="btn btn-xs btn-primary" onclick="inactiveDesignation(\'' . $designations->id . '\')">TIdak Aktif</button>&nbsp;';
                    } else {
                        $status = "Tidak Aktif";
                        $button .= '<button type="button" class="btn btn-xs btn-primary" onclick="activeDesignation(\'' . $designations->id . '\')">Aktif</button>&nbsp;';
                    }
                }
                $button .= '<button type="button" class="btn btn-xs btn-success" onclick="window.location=\'' . URL::action('AdminController@updateDesignation', $designations->id) . '\'"><i class="fa fa-pencil"></i></button>&nbsp;';
                $button .= '<button class="btn btn-xs btn-danger" onclick="deleteDesignation(\'' . $designations->id . '\')"><i class="fa fa-trash"></i></button>';

                $data_raw = array(
                    $designations->description,
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

    public function inactiveDesignation() {
        $data = Input::all();
        if (Request::ajax()) {

            $id = $data['id'];

            $designation = Designation::find($id);
            $designation->is_active = 0;
            $updated = $designation->save();
            if ($updated) {
                # Audit Trail
                $remarks = 'Designation: ' . $designation->description . ' has been updated.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "Master Setup";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    public function activeDesignation() {
        $data = Input::all();
        if (Request::ajax()) {

            $id = $data['id'];

            $designation = Designation::find($id);
            $designation->is_active = 1;
            $updated = $designation->save();
            if ($updated) {
                # Audit Trail
                $remarks = 'Designation: ' . $designation->description . ' has been updated.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "Master Setup";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    public function deleteDesignation() {
        $data = Input::all();
        if (Request::ajax()) {

            $id = $data['id'];

            $designation = Designation::find($id);
            $designation->is_deleted = 1;
            $deleted = $designation->save();
            if ($deleted) {
                # Audit Trail
                $remarks = 'Designation: ' . $designation->description . ' has been deleted.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "Master Setup";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    public function updateDesignation($id) {
        //get user permission
        $user_permission = AccessGroup::getAccessPermission(Auth::user()->id);
        $designation = Designation::find($id);

        if (Session::get('lang') == "en") {
            $viewData = array(
                'title' => 'Update Designation',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'designation_list',
                'user_permission' => $user_permission,
                'designation' => $designation,
                'image' => ""
            );

            return View::make('page_en.update_designation', $viewData);
        } else {
            $viewData = array(
                'title' => 'Edit Jawatan',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'designation_list',
                'user_permission' => $user_permission,
                'designation' => $designation,
                'image' => ""
            );

            return View::make('page_my.update_designation', $viewData);
        }
    }

    public function submitUpdateDesignation() {
        $data = Input::all();
        if (Request::ajax()) {
            $description = $data['description'];
            $is_active = $data['is_active'];
            $id = $data['id'];

            $designation = Designation::find($id);
            $designation->description = $description;
            $designation->is_active = $is_active;
            $success = $designation->save();

            if ($success) {
                # Audit Trail
                $remarks = 'Designation: ' . $designation->description . ' has been updated.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "Master Setup";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    //Unit Measure
    public function unitMeasure() {
        //get user permission
        $user_permission = AccessGroup::getAccessPermission(Auth::user()->id);

        if (Session::get('lang') == "en") {
            $viewData = array(
                'title' => 'Unit of Measure Maintenance',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'unit_list',
                'user_permission' => $user_permission,
                'image' => ""
            );

            return View::make('page_en.unitmeasure', $viewData);
        } else {
            $viewData = array(
                'title' => 'Pengurusan Unit Ukuran',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'unit_list',
                'user_permission' => $user_permission,
                'image' => ""
            );

            return View::make('page_my.unitmeasure', $viewData);
        }
    }

    public function addUnitMeasure() {
        //get user permission
        $user_permission = AccessGroup::getAccessPermission(Auth::user()->id);

        if (Session::get('lang') == "en") {
            $viewData = array(
                'title' => 'Add Unit of Measure',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'unit_list',
                'user_permission' => $user_permission,
                'image' => ""
            );

            return View::make('page_en.add_unitmeasure', $viewData);
        } else {
            $viewData = array(
                'title' => 'Tambah Unit Ukuran',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'unit_list',
                'user_permission' => $user_permission,
                'image' => ""
            );

            return View::make('page_my.add_unitmeasure', $viewData);
        }
    }

    public function submitUnitMeasure() {
        $data = Input::all();
        if (Request::ajax()) {
            $description = $data['description'];
            $is_active = $data['is_active'];

            $unitmeasure = new UnitMeasure();
            $unitmeasure->description = $description;
            $unitmeasure->is_active = $is_active;
            $success = $unitmeasure->save();

            if ($success) {
                # Audit Trail
                $remarks = 'Unit of Measure: ' . $unitmeasure->description . ' has been inserted.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "Master Setup";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    public function getUnitMeasure() {
        $unitmeasure = UnitMeasure::where('is_deleted', 0)->orderBy('id', 'desc')->get();

        if (count($unitmeasure) > 0) {
            $data = Array();
            foreach ($unitmeasure as $unitmeasures) {
                $button = "";
                if (Session::get('lang') == "en") {
                    if ($unitmeasures->is_active == 1) {
                        $status = "Active";
                        $button .= '<button type="button" class="btn btn-xs btn-primary" onclick="inactiveUnitMeasure(\'' . $unitmeasures->id . '\')">Inactive</button>&nbsp;';
                    } else {
                        $status = "Inactive";
                        $button .= '<button type="button" class="btn btn-xs btn-primary" onclick="activeUnitMeasure(\'' . $unitmeasures->id . '\')">Active</button>&nbsp;';
                    }
                } else {
                    if ($unitmeasures->is_active == 1) {
                        $status = "Aktif";
                        $button .= '<button type="button" class="btn btn-xs btn-primary" onclick="inactiveUnitMeasure(\'' . $unitmeasures->id . '\')">Tidak Aktif</button>&nbsp;';
                    } else {
                        $status = "Tidak Aktif";
                        $button .= '<button type="button" class="btn btn-xs btn-primary" onclick="activeUnitMeasure(\'' . $unitmeasures->id . '\')">Aktif</button>&nbsp;';
                    }
                }
                $button .= '<button type="button" class="btn btn-xs btn-success" onclick="window.location=\'' . URL::action('AdminController@updateUnitMeasure', $unitmeasures->id) . '\'"><i class="fa fa-pencil"></i></button>&nbsp;';
                $button .= '<button class="btn btn-xs btn-danger" onclick="deleteUnitMeasure(\'' . $unitmeasures->id . '\')"><i class="fa fa-trash"></i></button>';

                $data_raw = array(
                    $unitmeasures->description,
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

    public function inactiveUnitMeasure() {
        $data = Input::all();
        if (Request::ajax()) {

            $id = $data['id'];

            $unitmeasure = UnitMeasure::find($id);
            $unitmeasure->is_active = 0;
            $updated = $unitmeasure->save();

            if ($updated) {
                # Audit Trail
                $remarks = 'Unit of Measure: ' . $unitmeasure->description . ' has been updated.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "Master Setup";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    public function activeUnitMeasure() {
        $data = Input::all();
        if (Request::ajax()) {

            $id = $data['id'];

            $unitmeasure = UnitMeasure::find($id);
            $unitmeasure->is_active = 1;
            $updated = $unitmeasure->save();

            if ($updated) {
                # Audit Trail
                $remarks = 'Unit of Measure: ' . $unitmeasure->description . ' has been updated.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "Master Setup";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    public function deleteUnitMeasure() {
        $data = Input::all();
        if (Request::ajax()) {

            $id = $data['id'];

            $unitmeasure = UnitMeasure::find($id);
            $unitmeasure->is_deleted = 1;
            $deleted = $unitmeasure->save();

            if ($deleted) {
                # Audit Trail
                $remarks = 'Unit of Measure: ' . $unitmeasure->description . ' has been deleted.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "Master Setup";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    public function updateUnitMeasure($id) {
        //get user permission
        $user_permission = AccessGroup::getAccessPermission(Auth::user()->id);
        $unitmeasure = UnitMeasure::find($id);

        if (Session::get('lang') == "en") {
            $viewData = array(
                'title' => 'Update Unit of Measure',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'unit_list',
                'user_permission' => $user_permission,
                'unitmeasure' => $unitmeasure,
                'image' => ""
            );

            return View::make('page_en.update_unitmeasure', $viewData);
        } else {
            $viewData = array(
                'title' => 'Edit Unit Ukuran',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'unit_list',
                'user_permission' => $user_permission,
                'unitmeasure' => $unitmeasure,
                'image' => ""
            );

            return View::make('page_my.update_unitmeasure', $viewData);
        }
    }

    public function submitUpdateUnitMeasure() {
        $data = Input::all();
        if (Request::ajax()) {
            $description = $data['description'];
            $is_active = $data['is_active'];
            $id = $data['id'];

            $unitmeasure = UnitMeasure::find($id);
            $unitmeasure->description = $description;
            $unitmeasure->is_active = $is_active;
            $success = $unitmeasure->save();

            if ($success) {
                # Audit Trail
                $remarks = 'Unit of Measure: ' . $unitmeasure->description . ' has been updated.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "Master Setup";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    // --- Reporting --- //
    //audit trail
    public function auditTrail() {

        if (Session::get('lang') == "en") {
            $viewData = array(
                'title' => 'Audit Trail Report',
                'panel_nav_active' => 'reporting_panel',
                'main_nav_active' => 'reporting_main',
                'sub_nav_active' => 'audit_trail_list',
                'image' => ""
            );

            return View::make('report_en.audit_trail', $viewData);
        } else {
            $viewData = array(
                'title' => 'Laporan Audit Trail',
                'panel_nav_active' => 'reporting_panel',
                'main_nav_active' => 'reporting_main',
                'sub_nav_active' => 'audit_trail_list',
                'image' => ""
            );

            return View::make('report_my.audit_trail', $viewData);
        }
    }

    public function getAuditTrail() {
        $audit_trail = AuditTrail::orderBy('id', 'desc')->get();

        if (count($audit_trail) > 0) {
            $data = Array();
            foreach ($audit_trail as $audit_trails) {
                $user = User::find($audit_trails->audit_by);
                $data_raw = array(
                    $audit_trails->module,
                    $audit_trails->remarks,
                    $user->full_name,
                    date('Y/m/d H:i:s', strtotime($audit_trails->created_at))
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

    //file by location
    public function fileByLocation() {
        $strata = Strata::get();

        if (Session::get('lang') == "en") {
            $viewData = array(
                'title' => 'File By Location & Facilities Report',
                'panel_nav_active' => 'reporting_panel',
                'main_nav_active' => 'reporting_main',
                'sub_nav_active' => 'file_by_location_list',
                'strata' => $strata,
                'image' => ""
            );

            return View::make('report_en.file_by_location', $viewData);
        } else {
            $viewData = array(
                'title' => 'Laporan Fail Mengikut Lokasi & Kemudahan',
                'panel_nav_active' => 'reporting_panel',
                'main_nav_active' => 'reporting_main',
                'sub_nav_active' => 'file_by_location_list',
                'strata' => $strata,
                'image' => ""
            );

            return View::make('report_my.file_by_location', $viewData);
        }
    }

    public function getFileByLocation() {
        $data = Array();

        if (!Auth::user()->getAdmin()) {
            $file = Files::where('created_by', Auth::user()->id)->where('is_active', 1)->where('is_deleted', 0)->where('status', 1)->orderBy('id', 'asc')->get();
        } else {
            $file = Files::where('is_active', 1)->where('is_deleted', 0)->where('status', 1)->orderBy('id', 'asc')->get();
        }

        if (count($file) > 0) {
            foreach ($file as $files) {
                $strata = Strata::where('file_id', $files->id)->get();

                if (count($strata) > 0) {
                    foreach ($strata as $stratas) {
                        $parliament = Parliment::find($stratas->parliament);
                        $dun = Dun::find($stratas->dun);
                        $park = Park::find($stratas->park);
                        $files = Files::find($stratas->file_id);

                        if (count($parliament) > 0) {
                            $parliament_name = $parliament->description;
                        } else {
                            $parliament_name = "-";
                        }
                        if (count($dun) > 0) {
                            $dun_name = $dun->description;
                        } else {
                            $dun_name = "-";
                        }
                        if (count($park) > 0) {
                            $park_name = $dun->description;
                        } else {
                            $park_name = "-";
                        }
                        if ($stratas->name == "") {
                            $strata_name = "-";
                        } else {
                            $strata_name = $stratas->name;
                        }

                        $data_raw = array(
                            $parliament_name,
                            $dun_name,
                            $park_name,
                            $files->file_no,
                            $strata_name
                        );

                        array_push($data, $data_raw);
                    }
                }
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




//        if (count($strata) > 0) {
//            foreach ($strata as $stratas) {
//                $parliament = Parliment::find($stratas->parliament);
//                $dun = Dun::find($stratas->dun);
//                $park = Park::find($stratas->park);
//                $files = Files::find($stratas->file_id);
//
//                if (count($parliament) > 0) {
//                    $parliament_name = $parliament->description;
//                } else {
//                    $parliament_name = "-";
//                }
//                if (count($dun) > 0) {
//                    $dun_name = $dun->description;
//                } else {
//                    $dun_name = "-";
//                }
//                if (count($park) > 0) {
//                    $park_name = $dun->description;
//                } else {
//                    $park_name = "-";
//                }
//                if ($stratas->name == "") {
//                    $strata_name = "-";
//                } else {
//                    $strata_name = $stratas->name;
//                }
//
//                $data_raw = array(
//                    $parliament_name,
//                    $dun_name,
//                    $park_name,
//                    $files->file_no,
//                    $strata_name
//                );
//
//                array_push($data, $data_raw);
//            }
//
//
//            $output_raw = array(
//                "aaData" => $data
//            );
//
//            $output = json_encode($output_raw);
//            return $output;
//        } else {
//            $output_raw = array(
//                "aaData" => []
//            );
//
//            $output = json_encode($output_raw);
//            return $output;
//        }
    }

    //rating summary
    public function ratingSummary() {

        if (!Auth::user()->getAdmin()) {
            $file = Files::where('created_by', Auth::user()->id)->where('is_active', 1)->where('is_deleted', 0)->where('status', 1)->orderBy('id', 'asc')->get();
        } else {
            $file = Files::where('is_active', 1)->where('is_deleted', 0)->where('status', 1)->orderBy('id', 'asc')->get();
        }

        $stratas = 0;
        $ratings = 0;
        $fiveStars = 0;
        $fourStars = 0;
        $threeStars = 0;
        $twoStars = 0;
        $oneStars = 0;

        if (count($file) > 0) {
            foreach ($file as $files) {
                $strata = Strata::where('file_id', $files->id)->count();
                $rating = Scoring::where('file_id', $files->id)->where('is_deleted', 0)->count();
                $fiveStar = Scoring::where('file_id', $files->id)->where('is_deleted', 0)->where('total_score', '<=', 100)->where('total_score', '>=', 87)->count();
                $fourStar = Scoring::where('file_id', $files->id)->where('is_deleted', 0)->where('total_score', '<', 87)->where('total_score', '>=', 73)->count();
                $threeStar = Scoring::where('file_id', $files->id)->where('is_deleted', 0)->where('total_score', '<', 73)->where('total_score', '>=', 51)->count();
                $twoStar = Scoring::where('file_id', $files->id)->where('is_deleted', 0)->where('total_score', '<', 51)->where('total_score', '>=', 26)->count();
                $oneStar = Scoring::where('file_id', $files->id)->where('is_deleted', 0)->where('total_score', '<', 26)->where('total_score', '>=', 1)->count();

                $stratas += $strata;
                $ratings += $rating;
                $fiveStars += $fiveStar;
                $fourStars += $fourStar;
                $threeStars += $threeStar;
                $twoStars += $twoStar;
                $oneStars += $oneStar;
            }
        }

//        $strata = Strata::count();
//        $rating = Scoring::where('is_deleted', 0)->count();
//        $fiveStar = Scoring::where('is_deleted', 0)->where('total_score', '<=', 100)->where('total_score', '>=', 87)->count();
//        $fourStar = Scoring::where('is_deleted', 0)->where('total_score', '<', 87)->where('total_score', '>=', 73)->count();
//        $threeStar = Scoring::where('is_deleted', 0)->where('total_score', '<', 73)->where('total_score', '>=', 51)->count();
//        $twoStar = Scoring::where('is_deleted', 0)->where('total_score', '<', 51)->where('total_score', '>=', 26)->count();
//        $oneStar = Scoring::where('is_deleted', 0)->where('total_score', '<', 26)->where('total_score', '>=', 1)->count();
//        $fiveStar = Scoring::where('is_deleted', 0)->where('total_score', '<=', 100)->where('total_score', '>=', 86)->count();
//        $fourStar = Scoring::where('is_deleted', 0)->where('total_score', '<=', 85)->where('total_score', '>=', 61)->count();
//        $threeStar = Scoring::where('is_deleted', 0)->where('total_score', '<=', 60)->where('total_score', '>=', 41)->count();
//        $twoStar = Scoring::where('is_deleted', 0)->where('total_score', '<=', 40)->where('total_score', '>=', 21)->count();
//        $oneStar = Scoring::where('is_deleted', 0)->where('total_score', '<=', 20)->where('total_score', '>=', 1)->count();

        if (Session::get('lang') == "en") {
            $viewData = array(
                'title' => 'Rating Summary Report',
                'panel_nav_active' => 'reporting_panel',
                'main_nav_active' => 'reporting_main',
                'sub_nav_active' => 'rating_summary_list',
                'strata' => $stratas,
                'rating' => $ratings,
                'fiveStar' => $fiveStars,
                'fourStar' => $fourStars,
                'threeStar' => $threeStars,
                'twoStar' => $twoStars,
                'oneStar' => $oneStars,
                'image' => ""
            );

//            print "<pre>";
//            print_r($viewData);
//            print "</pre>";

            return View::make('report_en.rating_summary', $viewData);
        } else {
            $viewData = array(
                'title' => 'Laporan Penakrifan Bintang',
                'panel_nav_active' => 'reporting_panel',
                'main_nav_active' => 'reporting_main',
                'sub_nav_active' => 'rating_summary_list',
                'strata' => $stratas,
                'rating' => $ratings,
                'fiveStar' => $fiveStars,
                'fourStar' => $fourStars,
                'threeStar' => $threeStars,
                'twoStar' => $twoStars,
                'oneStar' => $oneStars,
                'image' => ""
            );

            return View::make('report_my.rating_summary', $viewData);
        }
    }

    //management summary
    public function managementSummary() {

        if (!Auth::user()->getAdmin()) {
            $strata = DB::table('files')
                    ->leftJoin('strata', 'strata.file_id', '=', 'files.id')
                    ->select('strata.*', 'files.id as file_id')
                    ->where('files.created_by', Auth::user()->id)
                    ->where('files.is_active', 1)
                    ->where('files.status', 1)
                    ->where('files.is_deleted', 0)
                    ->orderBy('strata.id')
                    ->get();

            $file = Files::where('created_by', Auth::user()->id)->where('is_active', 1)->where('is_deleted', 0)->where('status', 1)->orderBy('id', 'asc')->get();
        } else {
            $strata = DB::table('files')
                    ->leftJoin('strata', 'strata.file_id', '=', 'files.id')
                    ->select('strata.*', 'files.id as file_id')
                    ->where('files.is_active', 1)
                    ->where('files.status', 1)
                    ->where('files.is_deleted', 0)
                    ->orderBy('strata.id')
                    ->get();

            $file = Files::where('is_active', 1)->where('is_deleted', 0)->where('status', 1)->orderBy('id', 'asc')->get();
        }

        $jmbs = 0;
        $mcs = 0;
        $agents = 0;
        $otherss = 0;
        $residentials = 0;
        $residential_less10s = 0;
        $residential_more10s = 0;
        $commercials = 0;
        $commercial_less10s = 0;
        $commercial_more10s = 0;

        $developer = Developer::where('is_deleted', 0)->count();

        if (count($file) > 0) {
            foreach ($file as $files) {


                $jmb = ManagementJMB::where('file_id', $files->id)->count();
                $mc = ManagementMC::where('file_id', $files->id)->count();
                $agent = ManagementAgent::where('file_id', $files->id)->count();
                $others = ManagementOthers::where('file_id', $files->id)->count();
                $residential = Residential::where('file_id', $files->id)->sum('unit_no');
                $residential_less10 = Residential::where('file_id', $files->id)->where('unit_no', '<=', 10)->sum('unit_no');
                $residential_more10 = Residential::where('file_id', $files->id)->where('unit_no', '>', 10)->sum('unit_no');
                $commercial = Commercial::where('file_id', $files->id)->sum('unit_no');
                $commercial_less10 = Commercial::where('file_id', $files->id)->where('unit_no', '<=', 10)->sum('unit_no');
                $commercial_more10 = Commercial::where('file_id', $files->id)->where('unit_no', '>', 10)->sum('unit_no');

                $jmbs += $jmb;
                $mcs += $mc;
                $agents += $agent;
                $otherss += $others;
                $residentials += $residential;
                $residential_less10s += $residential_less10;
                $residential_more10s += $residential_more10;
                $commercials += $commercial;
                $commercial_less10s += $commercial_less10;
                $commercial_more10s += $commercial_more10;
            }
        }

        if (Session::get('lang') == "en") {
            $viewData = array(
                'title' => 'Management Summary Report',
                'panel_nav_active' => 'reporting_panel',
                'main_nav_active' => 'reporting_main',
                'sub_nav_active' => 'management_summary_list',
                'strata' => $strata,
                'residential' => $residentials,
                'residential_less10' => $residential_less10s,
                'residential_more10' => $residential_more10s,
                'commercial' => $commercials,
                'commercial_less10' => $commercial_less10s,
                'commercial_more10' => $commercial_more10s,
                'developer' => $developer,
                'jmb' => $jmbs,
                'mc' => $mcs,
                'agent' => $agents,
                'others' => $otherss,
                'image' => ""
            );

            return View::make('report_en.management_summary', $viewData);
        } else {
            $viewData = array(
                'title' => 'Laporan Rumusan Pengurusan',
                'panel_nav_active' => 'reporting_panel',
                'main_nav_active' => 'reporting_main',
                'sub_nav_active' => 'management_summary_list',
                'strata' => $strata,
                'residential' => $residentials,
                'residential_less10' => $residential_less10s,
                'residential_more10' => $residential_more10s,
                'commercial' => $commercials,
                'commercial_less10' => $commercial_less10s,
                'commercial_more10' => $commercial_more10s,
                'developer' => $developer,
                'jmb' => $jmbs,
                'mc' => $mcs,
                'agent' => $agents,
                'others' => $otherss,
                'image' => ""
            );

            return View::make('report_my.management_summary', $viewData);
        }
    }

    //cob file / management
    public function cobFileManagement() {

        if (!Auth::user()->getAdmin()) {
            $strata = DB::table('strata')
                    ->leftJoin('files', 'strata.file_id', '=', 'files.id')
                    ->select('strata.*', 'files.id as file_id')
                    ->where('files.created_by', Auth::user()->id)
                    ->where('files.is_active', 1)
                    ->where('files.status', 1)
                    ->where('files.is_deleted', 0)
                    ->orderBy('strata.id')
                    ->get();

            $file = Files::where('created_by', Auth::user()->id)->where('is_active', 1)->where('is_deleted', 0)->where('status', 1)->orderBy('id', 'asc')->get();
        } else {
            $strata = DB::table('strata')
                    ->leftJoin('files', 'strata.file_id', '=', 'files.id')
                    ->select('strata.*', 'files.id as file_id')
                    ->where('files.is_active', 1)
                    ->where('files.status', 1)
                    ->where('files.is_deleted', 0)
                    ->orderBy('strata.id')
                    ->get();

            $file = Files::where('is_active', 1)->where('is_deleted', 0)->where('status', 1)->orderBy('id', 'asc')->get();
        }

        $jmbs = 0;
        $mcs = 0;
        $agents = 0;
        $otherss = 0;
        $residentials = 0;
        $commercials = 0;

        $developer = Developer::where('is_deleted', 0)->count();

        if (count($file) > 0) {
            foreach ($file as $files) {

                $jmb = ManagementJMB::where('file_id', $files->id)->count();
                $mc = ManagementMC::where('file_id', $files->id)->count();
                $agent = ManagementAgent::where('file_id', $files->id)->count();
                $others = ManagementOthers::where('file_id', $files->id)->count();
                $residential = Residential::where('file_id', $files->id)->sum('unit_no');
                $commercial = Commercial::where('file_id', $files->id)->sum('unit_no');

                $jmbs += $jmb;
                $mcs += $mc;
                $agents += $agent;
                $otherss += $others;
                $residentials += $residential;
                $commercials += $commercial;
            }
        }

        $totals = $developer + $jmbs + $mcs + $agents + $otherss;
        if ($totals == 0) {
            $total = 1;
        } else {
            $total = $totals;
        }

        if (Session::get('lang') == "en") {
            $viewData = array(
                'title' => 'COB File / Management (%) Report',
                'panel_nav_active' => 'reporting_panel',
                'main_nav_active' => 'reporting_main',
                'sub_nav_active' => 'cob_file_management_list',
                'strata' => $strata,
                'developer' => $developer,
                'jmb' => $jmbs,
                'mc' => $mcs,
                'agent' => $agents,
                'others' => $otherss,
                'total' => $total,
                'residential' => $residentials,
                'commercial' => $commercials,
                'image' => ""
            );

            return View::make('report_en.cob_file_management', $viewData);
        } else {
            $viewData = array(
                'title' => 'Laporan Fail COB / Pengurusan (%)',
                'panel_nav_active' => 'reporting_panel',
                'main_nav_active' => 'reporting_main',
                'sub_nav_active' => 'cob_file_management_list',
                'strata' => $strata,
                'developer' => $developer,
                'jmb' => $jmbs,
                'mc' => $mcs,
                'agent' => $agents,
                'others' => $otherss,
                'total' => $total,
                'residential' => $residentials,
                'commercial' => $commercials,
                'image' => ""
            );

            return View::make('report_my.cob_file_management', $viewData);
        }
    }

    //form download
    public function formDownload() {
        //get user permission
        $user_permission = AccessGroup::getAccessPermission(Auth::user()->id);
        $formtype = FormType::where('is_active', 1)->where('is_deleted', 0)->orderby('sort_no', 'asc')->get();

        if (Session::get('lang') == "en") {
            $viewData = array(
                'title' => 'Form Download',
                'panel_nav_active' => 'form_panel',
                'main_nav_active' => 'form_main',
                'sub_nav_active' => 'form_download_list',
                'user_permission' => $user_permission,
                'formtype' => $formtype,
                'image' => ""
            );

            return View::make('form_en.index', $viewData);
        } else {
            $viewData = array(
                'title' => 'Form Download',
                'panel_nav_active' => 'form_panel',
                'main_nav_active' => 'form_main',
                'sub_nav_active' => 'form_download_list',
                'user_permission' => $user_permission,
                'formtype' => $formtype,
                'image' => ""
            );

            return View::make('form_my.index', $viewData);
        }
    }

}
