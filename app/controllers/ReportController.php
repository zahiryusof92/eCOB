<?php

class ReportController extends BaseController {

    public function __construct() {
        if (empty(Session::get('lang'))) {
            Session::put('lang', 'en');
        }

        $locale = Session::get('lang');
        App::setLocale($locale);
    }

    public function ownerTenant() {
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

        $race = Race::where('is_active', 1)->where('is_deleted', 0)->get();

        if (Session::get('lang') == "en") {
            $viewData = array(
                'title' => 'Owner / Tenant Report',
                'panel_nav_active' => 'reporting_panel',
                'main_nav_active' => 'reporting_main',
                'sub_nav_active' => 'owner_tenant_list',
                'user_permission' => $user_permission,
                'files' => $files,
                'race' => $race,
                'image' => ''
            );

            return View::make('report_en.owner_tenant', $viewData);
        } else {
            $viewData = array(
                'title' => 'Owner / Tenant Report',
                'panel_nav_active' => 'reporting_panel',
                'main_nav_active' => 'reporting_main',
                'sub_nav_active' => 'owner_tenant_list',
                'user_permission' => $user_permission,
                'files' => $files,
                'race' => $race,
                'image' => ''
            );

            return View::make('report_my.owner_tenant', $viewData);
        }
    }

    public function submitOwnerTenant() {
        $data = Input::all();
        
//        return $data['file_no'];

//        if (Request::ajax()) {
        $file_id = $data['file_no'];
        $type = $data['type'];

        if (!empty($file_id)) {
            $files = Files::find($file_id);
            if ($files) {
                if ($type == 'all') {
                    $owner = Buyer::where('file_id', $files->id)->where('is_deleted', 0)->get();
                    $tenant = Tenant::where('file_id', $files->id)->where('is_deleted', 0)->get();
                } else if ($type == 'owner') {
                    $owner = Buyer::where('file_id', $files->id)->where('is_deleted', 0)->get();
                    $tenant = '';
                } else {
                    $owner = '';
                    $tenant = Tenant::where('file_id', $files->id)->where('is_deleted', 0)->get();
                }

                $viewData = array(
                    'title' => 'Owner / Tenant Report',
                    'files' => $files,
                    'type' => $type,
                    'owner' => $owner,
                    'tenant' => $tenant
                );

                $pdf = PDF::loadView('print_en.owner_tenant', $viewData);
//                    return View::make('print_en.owner_tenant', $viewData);

                return $pdf->download('test.pdf');
            }
        }
//        }
    }

    public function strataProfile() {
        //get user permission
        $user_permission = AccessGroup::getAccessPermission(Auth::user()->id);
        $parliament = Parliment::where('is_active', 1)->where('is_deleted', 0)->get();
        $category = Category::where('is_active', 1)->where('is_deleted', 0)->get();
        $land = LandTitle::where('is_active', 1)->where('is_deleted', 0)->get();

        if (Session::get('lang') == "en") {
            $viewData = array(
                'title' => trans('report_lhps.title_strata'),
                'panel_nav_active' => 'reporting_panel',
                'main_nav_active' => 'reporting_main',
                'sub_nav_active' => 'strata_profile_list',
                'user_permission' => $user_permission,
                'parliament' => $parliament,
                'category' => $category,
                'land' => $land,
                'image' => '',
            );

            return View::make('report_en.strata_profile', $viewData);
        } else {
            $viewData = array(
                'title' => trans('report_lhps.title_strata'),
                'panel_nav_active' => 'reporting_panel',
                'main_nav_active' => 'reporting_main',
                'sub_nav_active' => 'strata_profile_list',
                'user_permission' => $user_permission,
                'parliament' => $parliament,
                'category' => $category,
                'land' => $land,
                'image' => '',
            );

            return View::make('report_my.strata_profile', $viewData);
        }
    }

    public function submitStrataProfile() {
        die();
    }

}
