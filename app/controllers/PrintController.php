<?php

class PrintController extends BaseController {

    //audit trail
    public function printAuditTrail() {
        $data = Input::all();

        $start = $data['start'];
        $end = $data['end'];
        
        if (!Auth::user()->getAdmin()) {
            if (!empty($start) && !empty($end)) {
                if ($start == $end) {
                    $audit_trail = DB::table('audit_trail')
                            ->leftJoin('users', 'audit_trail.audit_by', '=', 'users.id')
                            ->select('audit_trail.*', 'users.full_name as name')
                            ->where('users.company_id', Auth::user()->company_id)
                            ->where('audit_trail.created_at', 'LIKE', $start . '%')
                            ->orderBy('audit_trail.id', 'desc')
                            ->get();
                } else {
                    $audit_trail = DB::table('audit_trail')
                            ->leftJoin('users', 'audit_trail.audit_by', '=', 'users.id')
                            ->select('audit_trail.*', 'users.full_name as name')
                            ->where('users.company_id', Auth::user()->company_id)
                            ->whereBetween('audit_trail.created_at', [$start, $end])
                            ->orderBy('audit_trail.id', 'desc')
                            ->get();
                }
            } else if (!empty($start)) {
                $end = date('Y-m-d');
                if ($start == $end) {
                    $audit_trail = DB::table('audit_trail')
                            ->leftJoin('users', 'audit_trail.audit_by', '=', 'users.id')
                            ->select('audit_trail.*', 'users.full_name as name')
                            ->where('users.company_id', Auth::user()->company_id)
                            ->where('audit_trail.created_at', 'LIKE', $start . '%')
                            ->orderBy('audit_trail.id', 'desc')
                            ->get();
                } else {
                    $audit_trail = DB::table('audit_trail')
                            ->leftJoin('users', 'audit_trail.audit_by', '=', 'users.id')
                            ->select('audit_trail.*', 'users.full_name as name')
                            ->where('users.company_id', Auth::user()->company_id)
                            ->whereBetween('audit_trail.created_at', [$start, $end])
                            ->orderBy('audit_trail.id', 'desc')
                            ->get();
                }
            } else if (!empty($end)) {
                $audit_trail = DB::table('audit_trail')
                        ->leftJoin('users', 'audit_trail.audit_by', '=', 'users.id')
                        ->select('audit_trail.*', 'users.full_name as name')
                        ->where('users.company_id', Auth::user()->company_id)
                        ->where('audit_trail.created_at', 'LIKE', $end . '%')
                        ->orderBy('audit_trail.id', 'desc')
                        ->get();
            } else {
                $audit_trail = DB::table('audit_trail')
                        ->leftJoin('users', 'audit_trail.audit_by', '=', 'users.id')
                        ->select('audit_trail.*', 'users.full_name as name')
                        ->where('users.company_id', Auth::user()->company_id)
                        ->orderBy('audit_trail.id', 'desc')
                        ->get();
            }
        } else {
            if (empty(Session::get('admin_cob'))) {
                if (!empty($start) && !empty($end)) {
                    if ($start == $end) {
                        $audit_trail = DB::table('audit_trail')
                                ->leftJoin('users', 'audit_trail.audit_by', '=', 'users.id')
                                ->select('audit_trail.*', 'users.full_name as name')
                                ->where('audit_trail.created_at', 'LIKE', $start . '%')
                                ->orderBy('audit_trail.id', 'desc')
                                ->get();
                    } else {
                        $audit_trail = DB::table('audit_trail')
                                ->leftJoin('users', 'audit_trail.audit_by', '=', 'users.id')
                                ->select('audit_trail.*', 'users.full_name as name')
                                ->whereBetween('audit_trail.created_at', [$start, $end])
                                ->orderBy('audit_trail.id', 'desc')
                                ->get();
                    }
                } else if (!empty($start)) {
                    $end = date('Y-m-d');
                    if ($start == $end) {
                        $audit_trail = DB::table('audit_trail')
                                ->leftJoin('users', 'audit_trail.audit_by', '=', 'users.id')
                                ->select('audit_trail.*', 'users.full_name as name')
                                ->where('audit_trail.created_at', 'LIKE', $start . '%')
                                ->orderBy('audit_trail.id', 'desc')
                                ->get();
                    } else {
                        $audit_trail = DB::table('audit_trail')
                                ->leftJoin('users', 'audit_trail.audit_by', '=', 'users.id')
                                ->select('audit_trail.*', 'users.full_name as name')
                                ->whereBetween('audit_trail.created_at', [$start, $end])
                                ->orderBy('audit_trail.id', 'desc')
                                ->get();
                    }
                } else if (!empty($end)) {
                    $audit_trail = DB::table('audit_trail')
                            ->leftJoin('users', 'audit_trail.audit_by', '=', 'users.id')
                            ->select('audit_trail.*', 'users.full_name as name')
                            ->where('audit_trail.created_at', 'LIKE', $end . '%')
                            ->orderBy('audit_trail.id', 'desc')
                            ->get();
                } else {
                    $audit_trail = DB::table('audit_trail')
                            ->leftJoin('users', 'audit_trail.audit_by', '=', 'users.id')
                            ->select('audit_trail.*', 'users.full_name as name')
                            ->orderBy('audit_trail.id', 'desc')
                            ->get();
                }
            } else {
                if (!empty($start) && !empty($end)) {
                    if ($start == $end) {
                        $audit_trail = DB::table('audit_trail')
                                ->leftJoin('users', 'audit_trail.audit_by', '=', 'users.id')
                                ->select('audit_trail.*', 'users.full_name as name')
                                ->where('users.company_id', Session::get('admin_cob'))
                                ->where('audit_trail.created_at', 'LIKE', $start . '%')
                                ->orderBy('audit_trail.id', 'desc')
                                ->get();
                    } else {
                        $audit_trail = DB::table('audit_trail')
                                ->leftJoin('users', 'audit_trail.audit_by', '=', 'users.id')
                                ->select('audit_trail.*', 'users.full_name as name')
                                ->where('users.company_id', Session::get('admin_cob'))
                                ->whereBetween('audit_trail.created_at', [$start, $end])
                                ->orderBy('audit_trail.id', 'desc')
                                ->get();
                    }
                } else if (!empty($start)) {
                    $end = date('Y-m-d');
                    if ($start == $end) {
                        $audit_trail = DB::table('audit_trail')
                                ->leftJoin('users', 'audit_trail.audit_by', '=', 'users.id')
                                ->select('audit_trail.*', 'users.full_name as name')
                                ->where('users.company_id', Session::get('admin_cob'))
                                ->where('audit_trail.created_at', 'LIKE', $start . '%')
                                ->orderBy('audit_trail.id', 'desc')
                                ->get();
                    } else {
                        $audit_trail = DB::table('audit_trail')
                                ->leftJoin('users', 'audit_trail.audit_by', '=', 'users.id')
                                ->select('audit_trail.*', 'users.full_name as name')
                                ->where('users.company_id', Session::get('admin_cob'))
                                ->whereBetween('audit_trail.created_at', [$start, $end])
                                ->orderBy('audit_trail.id', 'desc')
                                ->get();
                    }
                } else if (!empty($end)) {
                    $audit_trail = DB::table('audit_trail')
                            ->leftJoin('users', 'audit_trail.audit_by', '=', 'users.id')
                            ->select('audit_trail.*', 'users.full_name as name')
                            ->where('users.company_id', Session::get('admin_cob'))
                            ->where('audit_trail.created_at', 'LIKE', $end . '%')
                            ->orderBy('audit_trail.id', 'desc')
                            ->get();
                } else {
                    $audit_trail = DB::table('audit_trail')
                            ->leftJoin('users', 'audit_trail.audit_by', '=', 'users.id')
                            ->select('audit_trail.*', 'users.full_name as name')
                            ->where('users.company_id', Session::get('admin_cob'))
                            ->orderBy('audit_trail.id', 'desc')
                            ->get();
                }
            }
        }

        if (Session::get('lang') == "en") {
            $viewData = array(
                'title' => 'Audit Trail Report',
                'panel_nav_active' => '',
                'main_nav_active' => '',
                'sub_nav_active' => '',
                'start' => $start,
                'end' => $end,
                'audit_trail' => $audit_trail
            );

            return View::make('print_en.audit_trail', $viewData);
        } else {
            $viewData = array(
                'title' => 'Laporan Audit Trail',
                'panel_nav_active' => '',
                'main_nav_active' => '',
                'sub_nav_active' => '',
                'start' => $start,
                'end' => $end,
                'audit_trail' => $audit_trail
            );

            return View::make('print_my.audit_trail', $viewData);
        }
    }

    //file by location
    public function printFileByLocation() {
        if (Session::get('lang') == "en") {
            $viewData = array(
                'title' => 'File By Location & Facilities Report',
                'panel_nav_active' => '',
                'main_nav_active' => '',
                'sub_nav_active' => '',
            );

            return View::make('print_en.file_by_location', $viewData);
        } else {
            $viewData = array(
                'title' => 'Laporan Fail Mengikut Lokasi & Kemudahan',
                'panel_nav_active' => '',
                'main_nav_active' => '',
                'sub_nav_active' => '',
            );

            return View::make('print_my.file_by_location', $viewData);
        }
    }

    //rating summary
    public function printRatingSummary() {
        if (!Auth::user()->getAdmin()) {
            if (!empty(Auth::user()->file_id)) {
                $file = Files::where('id', Auth::user()->file_id)->where('company_id', Auth::user()->company_id)->where('is_active', 1)->where('is_deleted', 0)->orderBy('id', 'asc')->get();
            } else {
                $file = Files::where('company_id', Auth::user()->company_id)->where('is_active', 1)->where('is_deleted', 0)->orderBy('id', 'asc')->get();
            }
        } else {
            if (empty(Session::get('admin_cob'))) {
                $file = Files::where('is_active', 1)->where('is_deleted', 0)->orderBy('id', 'asc')->get();
            } else {
                $file = Files::where('company_id', Session::get('admin_cob'))->where('is_active', 1)->where('is_deleted', 0)->orderBy('id', 'asc')->get();
            }
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

                $fiveStar = Scoring::where('file_id', $files->id)->where('is_deleted', 0)->where('total_score', '>=', 81)->where('total_score', '<=', 100)->count();
                $fourStar = Scoring::where('file_id', $files->id)->where('is_deleted', 0)->where('total_score', '>=', 61)->where('total_score', '<=', 80)->count();
                $threeStar = Scoring::where('file_id', $files->id)->where('is_deleted', 0)->where('total_score', '>=', 41)->where('total_score', '<=', 60)->count();
                $twoStar = Scoring::where('file_id', $files->id)->where('is_deleted', 0)->where('total_score', '>=', 21)->where('total_score', '<=', 40)->count();
                $oneStar = Scoring::where('file_id', $files->id)->where('is_deleted', 0)->where('total_score', '>=', 1)->where('total_score', '<=', 20)->count();
                
                $stratas += $strata;
                $ratings += $rating;
                $fiveStars += $fiveStar;
                $fourStars += $fourStar;
                $threeStars += $threeStar;
                $twoStars += $twoStar;
                $oneStars += $oneStar;
            }
        }

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

            return View::make('print_en.rating_summary', $viewData);
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

            return View::make('print_my.rating_summary', $viewData);
        }
    }

    //management summary
    public function printManagementSummary() {
        if (!Auth::user()->getAdmin()) {
            if (!empty(Auth::user()->file_id)) {
                $strata = DB::table('files')
                        ->leftJoin('strata', 'strata.file_id', '=', 'files.id')
                        ->select('strata.*', 'files.id as file_id')
                        ->where('files.id', Auth::user()->file_id)
                        ->where('files.company_id', Auth::user()->company_id)
                        ->where('files.is_active', 1)
                        ->where('files.is_deleted', 0)
                        ->orderBy('strata.id')
                        ->get();

                $file = Files::where('id', Auth::user()->file_id)->where('company_id', Auth::user()->company_id)->where('is_active', 1)->where('is_deleted', 0)->orderBy('id', 'asc')->get();
            } else {
                $strata = DB::table('files')
                        ->leftJoin('strata', 'strata.file_id', '=', 'files.id')
                        ->select('strata.*', 'files.id as file_id')
                        ->where('files.company_id', Auth::user()->company_id)
                        ->where('files.is_active', 1)
                        ->where('files.is_deleted', 0)
                        ->orderBy('strata.id')
                        ->get();

                $file = Files::where('company_id', Auth::user()->company_id)->where('is_active', 1)->where('is_deleted', 0)->orderBy('id', 'asc')->get();
            }
        } else {
            if (empty(Session::get('admin_cob'))) {
                $strata = DB::table('files')
                        ->leftJoin('strata', 'strata.file_id', '=', 'files.id')
                        ->select('strata.*', 'files.id as file_id')
                        ->where('files.is_active', 1)
                        ->where('files.is_deleted', 0)
                        ->orderBy('strata.id')
                        ->get();

                $file = Files::where('is_active', 1)->where('is_deleted', 0)->orderBy('id', 'asc')->get();
            } else {
                $strata = DB::table('files')
                        ->leftJoin('strata', 'strata.file_id', '=', 'files.id')
                        ->select('strata.*', 'files.id as file_id')
                        ->where('files.company_id', Session::get('admin_cob'))
                        ->where('files.is_active', 1)
                        ->where('files.is_deleted', 0)
                        ->orderBy('strata.id')
                        ->get();

                $file = Files::where('company_id', Session::get('admin_cob'))->where('is_active', 1)->where('is_deleted', 0)->orderBy('id', 'asc')->get();
            }
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

            return View::make('print_en.management_summary', $viewData);
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

            return View::make('print_my.management_summary', $viewData);
        }
    }

    //cob file / management
    public function printCobFileManagement() {
        if (!Auth::user()->getAdmin()) {
            if (!empty(Auth::user()->file_id)) {
                $strata = DB::table('files')
                        ->leftJoin('strata', 'strata.file_id', '=', 'files.id')
                        ->select('strata.*', 'files.id as file_id')
                        ->where('files.id', Auth::user()->file_id)
                        ->where('files.company_id', Auth::user()->company_id)
                        ->where('files.is_active', 1)
                        ->where('files.is_deleted', 0)
                        ->orderBy('strata.id')
                        ->get();

                $file = Files::where('id', Auth::user()->file_id)->where('company_id', Auth::user()->company_id)->where('is_active', 1)->where('is_deleted', 0)->orderBy('id', 'asc')->get();
            } else {
                $strata = DB::table('files')
                        ->leftJoin('strata', 'strata.file_id', '=', 'files.id')
                        ->select('strata.*', 'files.id as file_id')
                        ->where('files.company_id', Auth::user()->company_id)
                        ->where('files.is_active', 1)
                        ->where('files.is_deleted', 0)
                        ->orderBy('strata.id')
                        ->get();

                $file = Files::where('company_id', Auth::user()->company_id)->where('is_active', 1)->where('is_deleted', 0)->orderBy('id', 'asc')->get();
            }
        } else {
            if (empty(Session::get('admin_cob'))) {
                $strata = DB::table('files')
                        ->leftJoin('strata', 'strata.file_id', '=', 'files.id')
                        ->select('strata.*', 'files.id as file_id')
                        ->where('files.is_active', 1)
                        ->where('files.is_deleted', 0)
                        ->orderBy('strata.id')
                        ->get();

                $file = Files::where('is_active', 1)->where('is_deleted', 0)->orderBy('id', 'asc')->get();
            } else {
                $strata = DB::table('files')
                        ->leftJoin('strata', 'strata.file_id', '=', 'files.id')
                        ->select('strata.*', 'files.id as file_id')
                        ->where('files.company_id', Session::get('admin_cob'))
                        ->where('files.is_active', 1)
                        ->where('files.is_deleted', 0)
                        ->orderBy('strata.id')
                        ->get();

                $file = Files::where('company_id', Session::get('admin_cob'))->where('is_active', 1)->where('is_deleted', 0)->orderBy('id', 'asc')->get();
            }
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

            return View::make('print_en.cob_file_management', $viewData);
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

            return View::make('print_my.cob_file_management', $viewData);
        }
    }

    public function printOwnerTenant($id) {
        //get user permission
        $user_permission = AccessGroup::getAccessPermission(Auth::user()->id);

        if (!Auth::user()->getAdmin()) {
            $cob = Company::where('id', Auth::user()->company_id)->where('is_active', 1)->where('is_main', 0)->where('is_deleted', 0)->orderBy('name')->get();

            if (!empty(Auth::user()->file_id)) {
                $files = Files::where('id', Auth::user()->file_id)->where('company_id', Auth::user()->company_id)->where('is_deleted', 0)->orderBy('status', 'asc')->get();
            } else {
                $files = Files::where('company_id', Auth::user()->company_id)->where('is_deleted', 0)->orderBy('status', 'asc')->get();
            }
        } else {
            if (empty(Session::get('admin_cob'))) {
                $cob = Company::where('is_active', 1)->where('is_main', 0)->where('is_deleted', 0)->orderBy('name')->get();
                $files = Files::where('is_deleted', 0)->orderBy('status', 'asc')->get();
            } else {
                $cob = Company::where('id', Session::get('admin_cob'))->where('is_active', 1)->where('is_main', 0)->where('is_deleted', 0)->orderBy('name')->get();
                $files = Files::where('company_id', Session::get('admin_cob'))->where('is_deleted', 0)->orderBy('status', 'asc')->get();
            }
        }

        $race = Race::where('is_active', 1)->where('is_deleted', 0)->orderBy('sort_no')->get();

        if (isset($id) && !empty($id)) {
            $file_id = $id;
            $owner = Buyer::where('file_id', $file_id)->where('is_deleted', 0)->get();
            $tenant = Tenant::where('file_id', $file_id)->where('is_deleted', 0)->get();
        } else {
            $file_id = '';
            $owner = '';
            $tenant = '';
        }

        if (Session::get('lang') == "en") {
            $viewData = array(
                'title' => 'Status Kepenghunian',
                'panel_nav_active' => 'reporting_panel',
                'main_nav_active' => 'reporting_main',
                'sub_nav_active' => 'owner_tenant_list',
                'user_permission' => $user_permission,
                'files' => $files,
                'race' => $race,
                'file_id' => $file_id,
                'owner' => $owner,
                'tenant' => $tenant,
                'image' => ''
            );

            return View::make('print_en.owner_tenant', $viewData);
        } else {
            $viewData = array(
                'title' => 'Status Kepenghunian',
                'panel_nav_active' => 'reporting_panel',
                'main_nav_active' => 'reporting_main',
                'sub_nav_active' => 'owner_tenant_list',
                'user_permission' => $user_permission,
                'files' => $files,
                'race' => $race,
                'file_id' => $file_id,
                'owner' => $owner,
                'tenant' => $tenant,
                'image' => ''
            );

            return View::make('print_my.owner_tenant', $viewData);
        }
    }

    public function printStrataProfile($id) {
        //get user permission
        $user_permission = AccessGroup::getAccessPermission(Auth::user()->id);
        $access_permission = 0;
        foreach ($user_permission as $permission) {
            if ($permission->submodule_id == 29) {
                $access_permission = $permission->access_permission;
            }
        }

        if ($access_permission) {
            $race = Race::where('is_active', 1)->where('is_deleted', 0)->orderBy('sort_no')->get();

            $files = Files::find($id);
            if ($files) {
                $pbt = '';
                $strata_name = '';
                $total_unit = 0;
                $total_block = '';
                $total_floor = '';
                $mf_rate = 0;
                $sf_rate = 0;
                $berjaya_dikutip = 0;
                $sepatut_dikutip = 0;
                $purata_dikutip = 0;
                $lif = 'TIADA';
                $lif_unit = 0;
                $type_meter = '';

                if ($files) {
                    $pbt = $files->company->short_name;
                }

                if ($files->strata) {
                    $strata_name = $files->strata->name;
                    $total_block = $files->strata->block_no;
                    $total_floor = $files->strata->total_floor;
                }

                if ($files->resident) {
                    $total_unit = $total_unit + $files->resident->unit_no;
                }
                if ($files->commercial) {
                    $total_unit = $total_unit + $files->commercial->unit_no;
                }

                if ($files->facility) {
                    $check_lif = $files->facility->lift;
                    if ($check_lif) {
                        $lif = 'ADA';
                        $lif_unit = $files->facility->lift_unit;
                    }
                }

                if ($files->other) {
                    $type_meter = $files->other->water_meter;
                }

                if ($files->finance) {
                    foreach ($files->finance as $finance) {
                        if ($finance->year == date('Y')) {
                            if ($finance->financeIncome) {
                                foreach ($finance->financeReport as $report) {
                                    if ($report->type == 'MF') {
                                        $mf_rate = $report->fee_sebulan;
                                    }
                                    if ($report->type == 'SF') {
                                        $sf_rate = $report->fee_sebulan;
                                        $sepatut_dikutip = $sepatut_dikutip + $report->fee_semasa;
                                    }
                                }
                                foreach ($finance->financeIncome as $income) {
                                    if ($income->name == 'SINKING FUND') {
                                        $berjaya_dikutip = $berjaya_dikutip + $income->semasa;
                                    }
                                }
                            }
                        }
                    }
                }

                if (!empty($berjaya_dikutip) && !empty($sepatut_dikutip)) {
                    $purata_dikutip = round(($berjaya_dikutip / $sepatut_dikutip) * 100, 2);
                }

                if ($purata_dikutip >= 80) {
                    $zone = 'BIRU';
                } else if ($purata_dikutip < 79 && $purata_dikutip >= 50) {
                    $zone = 'KUNING';
                } else {
                    $zone = 'MERAH';
                }
            }

            $result = array(
                'pbt' => $pbt,
                'strata_name' => $strata_name,
                'total_unit' => $total_unit,
                'total_block' => $total_block,
                'total_floor' => $total_floor,
                'mf_rate' => $mf_rate,
                'sf_rate' => $sf_rate,
                'zone' => $zone,
                'lif' => $lif,
                'lif_unit' => $lif_unit,
                'type_meter' => $type_meter,
                'purata_dikutip' => $purata_dikutip
            );

//            return "<pre>" . print_r($result, true) . "</pre>";

            if (Session::get('lang') == "en") {
                $viewData = array(
                    'title' => 'Strata Profile',
                    'panel_nav_active' => 'reporting_panel',
                    'main_nav_active' => 'reporting_main',
                    'sub_nav_active' => 'strata_profile_list',
                    'user_permission' => $user_permission,
                    'files' => $files,
                    'race' => $race,
                    'result' => $result,
                    'image' => '',
                );

                return View::make('print_en.strata_profile', $viewData);
            } else {
                $viewData = array(
                    'title' => 'Strata Profile',
                    'panel_nav_active' => 'reporting_panel',
                    'main_nav_active' => 'reporting_main',
                    'sub_nav_active' => 'strata_profile_list',
                    'user_permission' => $user_permission,
                    'files' => $files,
                    'race' => $race,
                    'result' => $result,
                    'image' => '',
                );

                return View::make('print_my.strata_profile', $viewData);
            }
        } else {
            $viewData = array(
                'title' => "Page not found!",
                'panel_nav_active' => '',
                'main_nav_active' => '',
                'sub_nav_active' => '',
                'image' => ""
            );
            return View::make('404_en', $viewData);
        }
    }

}
