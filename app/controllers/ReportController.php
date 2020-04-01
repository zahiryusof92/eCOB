<?php

class ReportController extends BaseController {

    public function __construct() {
        if (empty(Session::get('lang'))) {
            Session::put('lang', 'en');
        }

        $locale = Session::get('lang');
        App::setLocale($locale);
    }

    public function reportStrataProfile() {
        //get user permission
        $user_permission = AccessGroup::getAccessPermission(Auth::user()->id);
        $parliment = Parliment::where('is_active', 1)->where('is_deleted', 0)->get();
        $dun = Dun::where('is_active', 1)->where('is_deleted', 0)->get();
        $category = Category::where('is_active', 1)->where('is_deleted', 0)->get();
        $land = LandTitle::where('is_active', 1)->where('is_deleted', 0)->get();


        $viewData = array(
            'title' => trans('report_lhps.title_strata'),
            'panel_nav_active' => 'lhps_panel',
            'main_nav_active' => 'lhps_main',
            'sub_nav_active' => 'strataprofile_form',
            'user_permission' => $user_permission,
            'image' => '',
            'parliment' => $parliment,
            'dun' => $dun,
            'category' => $category,
            'land' => $land,
        );

        return View::make('page.report_lhps.print_strata', $viewData);
    }

    public function submitLhpsReportStrata() {
        die();
    }

}
