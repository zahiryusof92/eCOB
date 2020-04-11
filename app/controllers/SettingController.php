<?php

class SettingController extends BaseController {

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

            return View::make('setting_en.area', $viewData);
        } else {
            $viewData = array(
                'title' => 'Pengurusan Daerah',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'area_list',
                'user_permission' => $user_permission,
                'image' => ""
            );

            return View::make('setting_my.area', $viewData);
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

            return View::make('setting_en.add_area', $viewData);
        } else {
            $viewData = array(
                'title' => 'Tambah Daerah',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'area_list',
                'user_permission' => $user_permission,
                'image' => ""
            );

            return View::make('setting_my.add_area', $viewData);
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
                $button .= '<button type="button" class="btn btn-xs btn-success" onclick="window.location=\'' . URL::action('SettingController@updateArea', $areas->id) . '\'"><i class="fa fa-pencil"></i></button>&nbsp;';
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

            return View::make('setting_en.update_area', $viewData);
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

            return View::make('setting_my.update_area', $viewData);
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

            return View::make('setting_en.city', $viewData);
        } else {
            $viewData = array(
                'title' => 'Pengurusan Bandar',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'city_list',
                'user_permission' => $user_permission,
                'image' => ""
            );

            return View::make('setting_my.city', $viewData);
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

            return View::make('setting_en.add_city', $viewData);
        } else {
            $viewData = array(
                'title' => 'Tambah Bandar',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'city_list',
                'user_permission' => $user_permission,
                'image' => ""
            );

            return View::make('setting_my.add_city', $viewData);
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
                $button .= '<button type="button" class="btn btn-xs btn-success" onclick="window.location=\'' . URL::action('SettingController@updateCity', $cities->id) . '\'"><i class="fa fa-pencil"></i></button>&nbsp;';
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

            return View::make('setting_en.update_city', $viewData);
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

            return View::make('setting_my.update_city', $viewData);
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

            return View::make('setting_en.country', $viewData);
        } else {
            $viewData = array(
                'title' => 'Pengurusan Bandar',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'country_list',
                'user_permission' => $user_permission,
                'image' => ""
            );

            return View::make('setting_my.country', $viewData);
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

            return View::make('setting_en.add_country', $viewData);
        } else {
            $viewData = array(
                'title' => 'Tambah Bandar',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'country_list',
                'user_permission' => $user_permission,
                'image' => ""
            );

            return View::make('setting_my.add_country', $viewData);
        }
    }

    public function submitCountry() {
        $data = Input::all();
        if (Request::ajax()) {
            $is_active = $data['is_active'];

            $country = new Country();
            $country->name = $data['name'];
            $country->sort_no = $data['sort_no'];
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
                $button .= '<button type="button" class="btn btn-xs btn-success" onclick="window.location=\'' . URL::action('SettingController@updateCountry', $cities->id) . '\'"><i class="fa fa-pencil"></i></button>&nbsp;';
                $button .= '<button class="btn btn-xs btn-danger" onclick="deleteCountry(\'' . $cities->id . '\')"><i class="fa fa-trash"></i></button>';

                $data_raw = array(
                    $cities->name,
                    $cities->sort_no,
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
                $remarks = 'Country: ' . $country->name . ' has been updated.';
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
                $remarks = 'Country: ' . $country->name . ' has been updated.';
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

            return View::make('setting_en.update_country', $viewData);
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

            return View::make('setting_my.update_country', $viewData);
        }
    }

    public function submitUpdateCountry() {
        $data = Input::all();
        if (Request::ajax()) {
            $id = $data['id'];

            $country = Country::find($id);
            $country->name = $data['name'];
            $country->sort_no = $data['sort_no'];
            $country->is_active = $data['is_active'];
            $success = $country->save();

            if ($success) {
                # Audit Trail
                $remarks = 'Country: ' . $country->name . ' has been updated.';
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

            return View::make('setting_en.formtype', $viewData);
        } else {
            $viewData = array(
                'title' => 'Jenis Form',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'formtype_list',
                'user_permission' => $user_permission,
                'image' => ""
            );

            return View::make('setting_my.formtype', $viewData);
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

            return View::make('setting_en.add_formtype', $viewData);
        } else {
            $viewData = array(
                'title' => 'Tambah Jenis Form',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'formtype_list',
                'user_permission' => $user_permission,
                'image' => ""
            );

            return View::make('setting_my.add_formtype', $viewData);
        }
    }

    public function submitFormType() {
        $data = Input::all();
        if (Request::ajax()) {

            $formtype = new FormType();
            $formtype->bi_type = $data['bi_type'];
            $formtype->bm_type = $data['bm_type'];
            $formtype->sort_no = $data['sort_no'];
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
                $button .= '<button type="button" class="btn btn-xs btn-success" onclick="window.location=\'' . URL::action('SettingController@updateFormtype', $ft->id) . '\'"><i class="fa fa-pencil"></i></button>&nbsp;';
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
                $remarks = 'FormType: ' . $formtype->name_en . ' has been updated.';
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
                $remarks = 'FormType: ' . $formtype->name_en . ' has been updated.';
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

            return View::make('setting_en.update_formtype', $viewData);
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

            return View::make('setting_my.update_formtype', $viewData);
        }
    }

    public function submitUpdateFormType() {
        $data = Input::all();
        if (Request::ajax()) {
            $id = $data['id'];

            $formtype = FormType::find($id);
            $formtype->bi_type = $data['bi_type'];
            $formtype->bm_type = $data['bm_type'];
            $formtype->sort_no = $data['sort_no'];
            $formtype->is_active = $data['is_active'];
            $success = $formtype->save();

            if ($success) {
                # Audit Trail
                $remarks = 'Form Type: ' . $formtype->name_en . ' has been updated.';
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

            return View::make('setting_en.state', $viewData);
        } else {
            $viewData = array(
                'title' => 'Pengurusan Bandar',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'state_list',
                'user_permission' => $user_permission,
                'image' => ""
            );

            return View::make('setting_my.state', $viewData);
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

            return View::make('setting_en.add_state', $viewData);
        } else {
            $viewData = array(
                'title' => 'Tambah Bandar',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'state_list',
                'user_permission' => $user_permission,
                'image' => ""
            );

            return View::make('setting_my.add_state', $viewData);
        }
    }

    public function submitState() {
        $data = Input::all();
        if (Request::ajax()) {
            $is_active = $data['is_active'];

            $state = new State();
            $state->name = $data['name'];
            $state->sort_no = $data['sort_no'];
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
            foreach ($state as $states) {
                $button = "";
                if (Session::get('lang') == "en") {
                    if ($states->is_active == 1) {
                        $status = "Active";
                        $button .= '<button type="button" class="btn btn-xs btn-primary" onclick="inactiveState(\'' . $states->id . '\')">Inactive</button>&nbsp;';
                    } else {
                        $status = "Inactive";
                        $button .= '<button type="button" class="btn btn-xs btn-primary" onclick="activeState(\'' . $states->id . '\')">Active</button>&nbsp;';
                    }
                } else {
                    if ($states->is_active == 1) {
                        $status = "Aktif";
                        $button .= '<button type="button" class="btn btn-xs btn-primary" onclick="inactiveState(\'' . $states->id . '\')">Tidak Aktif</button>&nbsp;';
                    } else {
                        $status = "Tidak Aktif";
                        $button .= '<button type="button" class="btn btn-xs btn-primary" onclick="activeState(\'' . $states->id . '\')">Aktif</button>&nbsp;';
                    }
                }
                $button .= '<button type="button" class="btn btn-xs btn-success" onclick="window.location=\'' . URL::action('SettingController@updateState', $states->id) . '\'"><i class="fa fa-pencil"></i></button>&nbsp;';
                $button .= '<button class="btn btn-xs btn-danger" onclick="deleteState(\'' . $states->id . '\')"><i class="fa fa-trash"></i></button>';

                $data_raw = array(
                    $states->name,
                    $states->sort_no,
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
                $remarks = 'State: ' . $state->name . ' has been updated.';
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
                $remarks = 'State: ' . $state->name . ' has been updated.';
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

            return View::make('setting_en.update_state', $viewData);
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

            return View::make('setting_my.update_state', $viewData);
        }
    }

    public function submitUpdateState() {
        $data = Input::all();
        if (Request::ajax()) {
            $id = $data['id'];

            $state = State::find($id);
            $state->name = $data['name'];
            $state->sort_no = $data['sort_no'];
            $state->is_active = $data['is_active'];
            $success = $state->save();

            if ($success) {
                # Audit Trail
                $remarks = 'State: ' . $state->name . ' has been updated.';
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

            return View::make('setting_en.documenttype', $viewData);
        } else {
            $viewData = array(
                'title' => 'Pengurusan Bandar',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'documenttype_list',
                'user_permission' => $user_permission,
                'image' => ""
            );

            return View::make('setting_my.documenttype', $viewData);
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

            return View::make('setting_en.add_documenttype', $viewData);
        } else {
            $viewData = array(
                'title' => 'Tambah Jenis Dokumen',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'documenttype_list',
                'user_permission' => $user_permission,
                'image' => ""
            );

            return View::make('setting_my.add_documenttype', $viewData);
        }
    }

    public function submitDocumenttype() {
        $data = Input::all();
        if (Request::ajax()) {
            $is_active = $data['is_active'];

            $documenttype = new Documenttype();
            $documenttype->name = $data['name'];
            $documenttype->sort_no = $data['sort_no'];
            $documenttype->is_active = $is_active;
            $documenttype->is_deleted = 0;
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
                $button .= '<button type="button" class="btn btn-xs btn-success" onclick="window.location=\'' . URL::action('SettingController@updateDocumenttype', $cities->id) . '\'"><i class="fa fa-pencil"></i></button>&nbsp;';
                $button .= '<button class="btn btn-xs btn-danger" onclick="deleteDocumenttype(\'' . $cities->id . '\')"><i class="fa fa-trash"></i></button>';

                $data_raw = array(
                    $cities->name,
                    $cities->sort_no,
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
                $remarks = 'Document Type: ' . $documenttype->name . ' has been updated.';
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
                $remarks = 'Document Type: ' . $documenttype->name . ' has been updated.';
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

            return View::make('setting_en.update_documenttype', $viewData);
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

            return View::make('setting_my.update_documenttype', $viewData);
        }
    }

    public function submitUpdateDocumenttype() {
        $data = Input::all();
        if (Request::ajax()) {
            $id = $data['id'];

            $documenttype = Documenttype::find($id);
            $documenttype->name = $data['name'];
            $documenttype->sort_no = $data['sort_no'];
            $documenttype->is_active = $data['is_active'];
            $success = $documenttype->save();

            if ($success) {
                # Audit Trail
                $remarks = 'Document Type: ' . $documenttype->name . ' has been updated.';
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

            return View::make('setting_en.category', $viewData);
        } else {
            $viewData = array(
                'title' => 'Pengurusan Kategori',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'category_list',
                'user_permission' => $user_permission,
                'image' => ""
            );

            return View::make('setting_my.category', $viewData);
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

            return View::make('setting_en.add_category', $viewData);
        } else {
            $viewData = array(
                'title' => 'Tambah Kategori',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'category_list',
                'user_permission' => $user_permission,
                'image' => ""
            );

            return View::make('setting_my.add_category', $viewData);
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
                $button .= '<button type="button" class="btn btn-xs btn-success" onclick="window.location=\'' . URL::action('SettingController@updateCategory', $categories->id) . '\'"><i class="fa fa-pencil"></i></button>&nbsp;';
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

            return View::make('setting_en.update_category', $viewData);
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

            return View::make('setting_my.update_category', $viewData);
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

            return View::make('setting_en.land', $viewData);
        } else {
            $viewData = array(
                'title' => 'Pengurusan Jenis Tanah',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'land_list',
                'user_permission' => $user_permission,
                'image' => ""
            );

            return View::make('setting_my.land', $viewData);
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

            return View::make('setting_en.add_land', $viewData);
        } else {
            $viewData = array(
                'title' => 'Tambah Jenis Tanah',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'land_list',
                'user_permission' => $user_permission,
                'image' => ""
            );

            return View::make('setting_my.add_land', $viewData);
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
                $button .= '<button type="button" class="btn btn-xs btn-success" onclick="window.location=\'' . URL::action('SettingController@updateLandTitle', $lands->id) . '\'"><i class="fa fa-pencil"></i></button>&nbsp;';
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

            return View::make('setting_en.update_land', $viewData);
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

            return View::make('setting_my.update_land', $viewData);
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

            return View::make('setting_en.developer', $viewData);
        } else {
            $viewData = array(
                'title' => 'Pengurusan Pemaju',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'developer_list',
                'user_permission' => $user_permission,
                'image' => ""
            );

            return View::make('setting_my.developer', $viewData);
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

            return View::make('setting_en.add_developer', $viewData);
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

            return View::make('setting_my.add_developer', $viewData);
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
                $button .= '<button type="button" class="btn btn-xs btn-success" onclick="window.location=\'' . URL::action('SettingController@updateDeveloper', $developers->id) . '\'"><i class="fa fa-pencil"></i></button>&nbsp;';
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

            return View::make('setting_en.update_developer', $viewData);
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

            return View::make('setting_my.update_developer', $viewData);
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

            return View::make('setting_en.agent', $viewData);
        } else {
            $viewData = array(
                'title' => 'Pengurusan Ejen',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'agent_list',
                'user_permission' => $user_permission,
                'image' => ""
            );

            return View::make('setting_my.agent', $viewData);
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

            return View::make('setting_en.add_agent', $viewData);
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

            return View::make('setting_my.add_agent', $viewData);
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
                $button .= '<button type="button" class="btn btn-xs btn-success" onclick="window.location=\'' . URL::action('SettingController@updateAgent', $agents->id) . '\'"><i class="fa fa-pencil"></i></button>&nbsp;';
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

            return View::make('setting_en.update_agent', $viewData);
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

            return View::make('setting_my.update_agent', $viewData);
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

            return View::make('setting_en.parliment', $viewData);
        } else {
            $viewData = array(
                'title' => 'Pengurusan Parlimen',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'parliament_list',
                'user_permission' => $user_permission,
                'image' => ""
            );

            return View::make('setting_my.parliment', $viewData);
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

            return View::make('setting_en.add_parliment', $viewData);
        } else {
            $viewData = array(
                'title' => 'Tambah Parlimen',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'parliament_list',
                'user_permission' => $user_permission,
                'image' => ""
            );

            return View::make('setting_my.add_parliment', $viewData);
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
                $button .= '<button type="button" class="btn btn-xs btn-success" onclick="window.location=\'' . URL::action('SettingController@updateParliment', $parliments->id) . '\'"><i class="fa fa-pencil"></i></button>&nbsp;';
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

            return View::make('setting_en.update_parliment', $viewData);
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

            return View::make('setting_my.update_parliment', $viewData);
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

            return View::make('setting_en.dun', $viewData);
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

            return View::make('setting_my.dun', $viewData);
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

            return View::make('setting_en.add_dun', $viewData);
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

            return View::make('setting_my.add_dun', $viewData);
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

                $button .= '<button type="button" class="btn btn-xs btn-success" onclick="window.location=\'' . URL::action('SettingController@updateDun', $duns->id) . '\'"><i class="fa fa-pencil"></i></button>&nbsp;';
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

            return View::make('setting_en.update_dun', $viewData);
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

            return View::make('setting_my.update_dun', $viewData);
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

            return View::make('setting_en.park', $viewData);
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

            return View::make('setting_my.park', $viewData);
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

            return View::make('setting_en.add_park', $viewData);
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

            return View::make('setting_my.add_park', $viewData);
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

                $button .= '<button type="button" class="btn btn-xs btn-success" onclick="window.location=\'' . URL::action('SettingController@updatePark', $parks->id) . '\'"><i class="fa fa-pencil"></i></button>&nbsp;';
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

            return View::make('setting_en.update_park', $viewData);
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

            return View::make('setting_my.update_park', $viewData);
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

            return View::make('setting_en.memotype', $viewData);
        } else {
            $viewData = array(
                'title' => 'Pengurusan Jenis Memo',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'memo_list',
                'user_permission' => $user_permission,
                'image' => ""
            );

            return View::make('setting_my.memotype', $viewData);
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

            return View::make('setting_en.add_memotype', $viewData);
        } else {
            $viewData = array(
                'title' => 'Tambah Jenis Memo',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'memo_list',
                'user_permission' => $user_permission,
                'image' => ""
            );

            return View::make('setting_my.add_memotype', $viewData);
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
                $button .= '<button type="button" class="btn btn-xs btn-success" onclick="window.location=\'' . URL::action('SettingController@updateMemoType', $memotypes->id) . '\'"><i class="fa fa-pencil"></i></button>&nbsp;';
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

            return View::make('setting_en.update_memotype', $viewData);
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

            return View::make('setting_my.update_memotype', $viewData);
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

            return View::make('setting_en.designation', $viewData);
        } else {
            $viewData = array(
                'title' => 'Pengurusan Jawatan',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'designation_list',
                'user_permission' => $user_permission,
                'image' => ""
            );

            return View::make('setting_my.designation', $viewData);
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

            return View::make('setting_en.add_designation', $viewData);
        } else {
            $viewData = array(
                'title' => 'Tambah Jawatan',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'designation_list',
                'user_permission' => $user_permission,
                'image' => ""
            );

            return View::make('setting_my.add_designation', $viewData);
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
                $button .= '<button type="button" class="btn btn-xs btn-success" onclick="window.location=\'' . URL::action('SettingController@updateDesignation', $designations->id) . '\'"><i class="fa fa-pencil"></i></button>&nbsp;';
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

            return View::make('setting_en.update_designation', $viewData);
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

            return View::make('setting_my.update_designation', $viewData);
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

            return View::make('setting_en.unitmeasure', $viewData);
        } else {
            $viewData = array(
                'title' => 'Pengurusan Unit Ukuran',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'unit_list',
                'user_permission' => $user_permission,
                'image' => ""
            );

            return View::make('setting_my.unitmeasure', $viewData);
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

            return View::make('setting_en.add_unitmeasure', $viewData);
        } else {
            $viewData = array(
                'title' => 'Tambah Unit Ukuran',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'unit_list',
                'user_permission' => $user_permission,
                'image' => ""
            );

            return View::make('setting_my.add_unitmeasure', $viewData);
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
                $button .= '<button type="button" class="btn btn-xs btn-success" onclick="window.location=\'' . URL::action('SettingController@updateUnitMeasure', $unitmeasures->id) . '\'"><i class="fa fa-pencil"></i></button>&nbsp;';
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

            return View::make('setting_en.update_unitmeasure', $viewData);
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

            return View::make('setting_my.update_unitmeasure', $viewData);
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
    
    // race
    public function race() {
        //get user permission
        $user_permission = AccessGroup::getAccessPermission(Auth::user()->id);

        if (Session::get('lang') == "en") {
            $viewData = array(
                'title' => 'Race Maintenance',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'race_list',
                'user_permission' => $user_permission,
                'image' => ""
            );

            return View::make('setting_en.race', $viewData);
        } else {
            $viewData = array(
                'title' => 'Pengurusan Bandar',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'race_list',
                'user_permission' => $user_permission,
                'image' => ""
            );

            return View::make('setting_my.race', $viewData);
        }
    }

    public function addRace() {
        //get user permission
        $user_permission = AccessGroup::getAccessPermission(Auth::user()->id);

        if (Session::get('lang') == "en") {
            $viewData = array(
                'title' => 'Add Race',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'race_list',
                'user_permission' => $user_permission,
                'image' => ""
            );

            return View::make('setting_en.add_race', $viewData);
        } else {
            $viewData = array(
                'title' => 'Tambah Bandar',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'race_list',
                'user_permission' => $user_permission,
                'image' => ""
            );

            return View::make('setting_my.add_race', $viewData);
        }
    }

    public function submitRace() {
        $data = Input::all();
        if (Request::ajax()) {
            $is_active = $data['is_active'];

            $race = new Race();
            $race->name = $data['name'];
            $race->sort_no = $data['sort_no'];
            $race->is_active = $is_active;
            $success = $race->save();

            if ($success) {
                # Audit Trail
                $remarks = 'Race: ' . $race->name . ' has been inserted.';
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

    public function getRace() {
        $race = Race::where('is_deleted', 0)->orderBy('id', 'desc')->get();

        if (count($race) > 0) {
            $data = Array();
            foreach ($race as $cities) {
                $button = "";
                if (Session::get('lang') == "en") {
                    if ($cities->is_active == 1) {
                        $status = "Active";
                        $button .= '<button type="button" class="btn btn-xs btn-primary" onclick="inactiveRace(\'' . $cities->id . '\')">Inactive</button>&nbsp;';
                    } else {
                        $status = "Inactive";
                        $button .= '<button type="button" class="btn btn-xs btn-primary" onclick="activeRace(\'' . $cities->id . '\')">Active</button>&nbsp;';
                    }
                } else {
                    if ($cities->is_active == 1) {
                        $status = "Aktif";
                        $button .= '<button type="button" class="btn btn-xs btn-primary" onclick="inactiveRace(\'' . $cities->id . '\')">Tidak Aktif</button>&nbsp;';
                    } else {
                        $status = "Tidak Aktif";
                        $button .= '<button type="button" class="btn btn-xs btn-primary" onclick="activeRace(\'' . $cities->id . '\')">Aktif</button>&nbsp;';
                    }
                }
                $button .= '<button type="button" class="btn btn-xs btn-success" onclick="window.location=\'' . URL::action('SettingController@updateRace', $cities->id) . '\'"><i class="fa fa-pencil"></i></button>&nbsp;';
                $button .= '<button class="btn btn-xs btn-danger" onclick="deleteRace(\'' . $cities->id . '\')"><i class="fa fa-trash"></i></button>';

                $data_raw = array(
                    $cities->name,
                    $cities->sort_no,
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

    public function inactiveRace() {
        $data = Input::all();
        if (Request::ajax()) {

            $id = $data['id'];

            $race = Race::find($id);
            $race->is_active = 0;
            $updated = $race->save();
            if ($updated) {
                # Audit Trail
                $remarks = 'Race: ' . $race->name . ' has been updated.';
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

    public function activeRace() {
        $data = Input::all();
        if (Request::ajax()) {

            $id = $data['id'];

            $race = Race::find($id);
            $race->is_active = 1;
            $updated = $race->save();
            if ($updated) {
                # Audit Trail
                $remarks = 'Race: ' . $race->name . ' has been updated.';
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

    public function deleteRace() {
        $data = Input::all();
        if (Request::ajax()) {

            $id = $data['id'];

            $race = Race::find($id);
            $race->is_deleted = 1;
            $deleted = $race->save();
            if ($deleted) {
                # Audit Trail
                $remarks = 'Race: ' . $race->id . ' has been deleted.';
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

    public function updateRace($id) {
        //get user permission
        $user_permission = AccessGroup::getAccessPermission(Auth::user()->id);
        $race = Race::find($id);

        if (Session::get('lang') == "en") {
            $viewData = array(
                'title' => 'Update Race',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'race_list',
                'user_permission' => $user_permission,
                'race' => $race,
                'image' => ""
            );

            return View::make('setting_en.update_race', $viewData);
        } else {
            $viewData = array(
                'title' => 'Edit Bandar',
                'panel_nav_active' => 'master_panel',
                'main_nav_active' => 'master_main',
                'sub_nav_active' => 'race_list',
                'user_permission' => $user_permission,
                'race' => $race,
                'image' => ""
            );

            return View::make('setting_my.update_race', $viewData);
        }
    }

    public function submitUpdateRace() {
        $data = Input::all();
        if (Request::ajax()) {
            $id = $data['id'];

            $race = Race::find($id);
            $race->name = $data['name'];
            $race->sort_no = $data['sort_no'];
            $race->is_active = $data['is_active'];
            $success = $race->save();

            if ($success) {
                # Audit Trail
                $remarks = 'Race: ' . $race->name . ' has been updated.';
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

}
