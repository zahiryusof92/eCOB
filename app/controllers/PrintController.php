<?php

class PrintController extends BaseController {
    
    public function __construct() {
        if (empty(Session::get('lang'))) {
            Session::put('lang', 'en');
        }
        
        $locale = Session::get('lang');
        App::setLocale($locale);
    }

    //audit trail
    public function printAuditTrail() {
        
        $audit_trail = AuditTrail::orderBy('id', 'desc')->get();
        
        if (Session::get('lang') == "en") {
            $viewData = array(
                'title' => 'Audit Trail Report',
                'panel_nav_active' => '',
                'main_nav_active' => '',
                'sub_nav_active' => '',
                'audit_trail' => $audit_trail
            );

            return View::make('print_en.audit_trail', $viewData);
        } else {
            $viewData = array(
                'title' => 'Laporan Audit Trail',
                'panel_nav_active' => '',
                'main_nav_active' => '',
                'sub_nav_active' => '',
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
        $data = Input::all();

        //get user permission
        $user_permission = AccessGroup::getAccessPermission(Auth::user()->id);

        if (!Auth::user()->getAdmin()) {
            $cob = Company::where('id', Auth::user()->company_id)->where('is_active', 1)->where('is_main', 0)->where('is_deleted', 0)->orderBy('name')->get();
            $files = Files::where('company_id', Auth::user()->company_id)->where('is_deleted', 0)->orderBy('status', 'asc')->get();
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

}
