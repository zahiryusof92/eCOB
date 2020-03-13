<?php

class AgmController extends BaseController {

    public function __construct() {
        $locale = Session::get('lang');
        App::setLocale($locale);
    }

    public function AJK() {
        //get user permission
        $user_permission = AccessGroup::getAccessPermission(Auth::user()->id);
        $files = Files::where('is_active', 1)->where('is_deleted', 0)->orderBy('year', 'desc')->get();
        $designation = Designation::where('is_active', 1)->where('is_deleted', 0)->orderBy('description', 'asc')->get();

        if (Session::get('lang') == "en") {
            $viewData = array(
                'title' => 'Designation Submission',
                'panel_nav_active' => 'agm_panel',
                'main_nav_active' => 'agm_main',
                'sub_nav_active' => 'agmdesignsub_list',
                'user_permission' => $user_permission,
                'files' => $files,
                'designation' => $designation,
                'image' => ''
            );

            return View::make('agm_en.ajk', $viewData);
        } else {
            $viewData = array(
                'title' => 'Penyerahan Maklumat AJK',
                'panel_nav_active' => 'agm_panel',
                'main_nav_active' => 'agm_main',
                'sub_nav_active' => 'agmdesignsub_list',
                'user_permission' => $user_permission,
                'designation' => $designation,
                'image' => ''
            );

            return View::make('agm_my.ajk', $viewData);
        }
    }
    
    public function getAJK() {
        $ajk_detail = AJKDetails::where('is_deleted', 0)->orderBy('id', 'desc')->get();

        if (count($ajk_detail) > 0) {
            $data = Array();
            foreach ($ajk_detail as $ajk_details) {
                $designation = Designation::find($ajk_details->designation);

                $button = "";
                $button .= '<button type="button" class="btn btn-xs btn-success edit_ajk" title="Edit" data-toggle="modal" data-target="#edit_ajk_details"
                            data-ajk_id="' . $ajk_details->id . '" data-file_id="' . $ajk_details->file_id . '" data-designation="' . $ajk_details->designation . '" data-name="' . $ajk_details->name . '" data-phone_no="' . $ajk_details->phone_no . '" data-year="' . $ajk_details->year . '">
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

    public function addAJK() {
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

    public function editAJK() {
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

    public function deleteAJK() {
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

    //------------------------------------- RONALDO -------------------------------------------//
    //AGM Design Submission
    public function agmDesignSub() {
        //get user permission
        $user_permission = AccessGroup::getAccessPermission(Auth::user()->id);

        $viewData = array(
            'title' => trans('agm_design_sub.title'),
            'panel_nav_active' => 'agm_panel',
            'main_nav_active' => 'agm_main',
            'sub_nav_active' => 'agmdesignsub_list',
            'user_permission' => $user_permission,
            'image' => ''
        );

        return View::make('page.agm_design_sub.index', $viewData);
    }

    public function addAgmDesignSub() {
        //get user permission
        $user_permission = AccessGroup::getAccessPermission(Auth::user()->id);
        $file = Files::where('is_active', 1)->where('is_deleted', 0)->get();
        $design = Designation::where('is_active', 1)->where('is_deleted', 0)->get();

        $viewData = array(
            'title' => trans('agm_design_sub.title_add'),
            'panel_nav_active' => 'agm_panel',
            'main_nav_active' => 'agm_main',
            'sub_nav_active' => 'agmdesignsub_list',
            'user_permission' => $user_permission,
            'file' => $file,
            'design' => $design,
            'image' => ''
        );

        return View::make('page.agm_design_sub.add', $viewData);
    }

    public function submitAgmDesignSub() {
        $data = Input::all();
        if (Request::ajax()) {

            $agmDesignSub = new AgmDesignSub();
            $agmDesignSub->file_id = $data['file_id'];
            $agmDesignSub->design_id = $data['design_id'];
            $agmDesignSub->name = $data['name'];
            $agmDesignSub->phone_number = $data['phone_number'];
            $agmDesignSub->email = $data['email'];
            $agmDesignSub->ajk_year = $data['ajk_year'];
            $agmDesignSub->remark = $data['remark'];
            $success = $agmDesignSub->save();

            if ($success) {
                # Audit Trail
                $remarks = 'New AGM Designation Submission has been inserted.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "AGM Design Submission";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    public function getAgmDesignSub() {
        $agmDesignSub = AgmDesignSub::get();
        if (count($agmDesignSub) > 0) {
            $data = Array();
            foreach ($agmDesignSub as $x) {

                $button = '';
                $button .= '<button type="button" class="btn btn-xs btn-success" onclick="window.location=\'' . URL::action('AgmController@updateAgmDesignSub', $x->id) . '\'"><i class="fa fa-pencil"></i></button>&nbsp;';

                $data_raw = array(
                    $x->design->description,
                    $x->name,
                    $x->phone_number,
                    $x->email,
                    $x->ajk_year,
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

    public function inactiveAgmDesignSub() {
        $data = Input::all();
        if (Request::ajax()) {

            $id = $data['id'];

            $agmDesignSub = AgmDesignSub::find($id);
            $agmDesignSub->is_active = 0;
            $updated = $agmDesignSub->save();
            if ($updated) {
                # Audit Trail
                $remarks = $agmDesignSub->id . ' has been updated.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "AGM Design Submission";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    public function activeAgmDesignSub() {
        $data = Input::all();
        if (Request::ajax()) {

            $id = $data['id'];

            $agmDesignSub = AgmDesignSub::find($id);
            $agmDesignSub->is_active = 1;
            $updated = $agmDesignSub->save();
            if ($updated) {
                # Audit Trail
                $remarks = $agmDesignSub->id . ' has been updated.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "AGM Design Submission";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    public function deleteAgmDesignSub() {
        $data = Input::all();
        if (Request::ajax()) {

            $id = $data['id'];

            $agmDesignSub = AgmDesignSub::find($id);
            $agmDesignSub->is_deleted = 1;
            $deleted = $agmDesignSub->save();
            if ($deleted) {
                # Audit Trail
                $remarks = $agmDesignSub->id . ' has been deleted.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "AGM Design Submission";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    public function updateAgmDesignSub($id) {
        //get user permission
        $user_permission = AccessGroup::getAccessPermission(Auth::user()->id);
        $agmDesignSub = AgmDesignSub::find($id);
        $file = Files::where('is_active', 1)->where('is_deleted', 0)->get();
        $design = Designation::where('is_active', 1)->where('is_deleted', 0)->get();

        $viewData = array(
            'title' => trans('agm_design_sub.title_edit'),
            'panel_nav_active' => 'agm_panel',
            'main_nav_active' => 'agm_main',
            'sub_nav_active' => 'agmdesignsub_list',
            'user_permission' => $user_permission,
            'agmDesignSub' => $agmDesignSub,
            'file' => $file,
            'design' => $design,
            'image' => ""
        );

        return View::make('page.agm_design_sub.edit', $viewData);
    }

    public function submitUpdateAgmDesignSub() {
        $data = Input::all();
        if (Request::ajax()) {
            $id = $data['id'];
            $agmDesignSub = AgmDesignSub::find($id);
            $agmDesignSub->file_id = $data['file_id'];
            $agmDesignSub->design_id = $data['design_id'];
            $agmDesignSub->name = $data['name'];
            $agmDesignSub->phone_number = $data['phone_number'];
            $agmDesignSub->email = $data['email'];
            $agmDesignSub->ajk_year = $data['ajk_year'];
            $agmDesignSub->remark = $data['remark'];
            $success = $agmDesignSub->save();

            if ($success) {
                # Audit Trail
                $remarks = $agmDesignSub->id . ' has been updated.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "AGM Design Submission Update";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    // AGM Puchaser Submission
    public function agmPurchaseSub() {
        //get user permission
        $user_permission = AccessGroup::getAccessPermission(Auth::user()->id);

        $viewData = array(
            'title' => trans('agm_purchase_sub.title'),
            'panel_nav_active' => 'agm_panel',
            'main_nav_active' => 'agm_main',
            'sub_nav_active' => 'agmpurchasesub_list',
            'user_permission' => $user_permission,
            'image' => ''
        );

        return View::make('page.agm_purchase_sub.index', $viewData);
    }

    public function addAgmPurchaseSub() {
        //get user permission
        $user_permission = AccessGroup::getAccessPermission(Auth::user()->id);
        $file = Files::where('is_active', 1)->where('is_deleted', 0)->get();

        $viewData = array(
            'title' => trans('agm_purchase_sub.title_add'),
            'panel_nav_active' => 'agm_panel',
            'main_nav_active' => 'agm_main',
            'sub_nav_active' => 'agmpurchasesub_list',
            'user_permission' => $user_permission,
            'file' => $file,
            'image' => ''
        );

        return View::make('page.agm_purchase_sub.add', $viewData);
    }

    public function submitAgmPurchaseSub() {
        $data = Input::all();
        $fields = [
            'file_id',
            'unit_no',
            'share_unit',
            'buyer',
            'nric',
            'address1',
            'address2',
            'address3',
            'address4',
            'postcode',
            'phone_number',
            'email',
            'remark',
        ];
        if (Request::ajax()) {

            $agmPurchaseSub = new AgmPurchaseSub();
            foreach ($fields as $field) {
                $agmPurchaseSub->$field = $data[$field];
            }
            $success = $agmPurchaseSub->save();

            if ($success) {
                # Audit Trail
                $remarks = 'New AGM Purchaser Submission has been inserted.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "AGM Purchaser Submission";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    public function getAgmPurchaseSub() {
        $agmPurchaseSub = AgmPurchaseSub::get();
        if (count($agmPurchaseSub) > 0) {
            $data = Array();
            foreach ($agmPurchaseSub as $x) {

                $button = '';
                $button .= '<button type="button" class="btn btn-xs btn-success" onclick="window.location=\'' . URL::action('AgmController@updateAgmPurchaseSub', $x->id) . '\'"><i class="fa fa-pencil"></i></button>&nbsp;';

                $data_raw = array(
                    $x->unit_no,
                    $x->share_unit,
                    $x->buyer,
                    $x->nric,
                    $x->phone_number,
                    $x->email,
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

    public function inactiveAgmPurchaseSub() {
        $data = Input::all();
        if (Request::ajax()) {

            $id = $data['id'];

            $agmPurchaseSub = AgmPurchaseSub::find($id);
            $agmPurchaseSub->is_active = 0;
            $updated = $agmPurchaseSub->save();
            if ($updated) {
                # Audit Trail
                $remarks = $agmPurchaseSub->id . ' has been updated.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "AGM Purchaser Submission";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    public function activeAgmPurchaseSub() {
        $data = Input::all();
        if (Request::ajax()) {

            $id = $data['id'];

            $agmPurchaseSub = AgmPurchaseSub::find($id);
            $agmPurchaseSub->is_active = 1;
            $updated = $agmPurchaseSub->save();
            if ($updated) {
                # Audit Trail
                $remarks = $agmPurchaseSub->id . ' has been updated.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "AGM Purchaser Submission";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    public function deleteAgmPurchaseSub() {
        $data = Input::all();
        if (Request::ajax()) {

            $id = $data['id'];

            $agmPurchaseSub = AgmPurchaseSub::find($id);
            $agmPurchaseSub->is_deleted = 1;
            $deleted = $agmPurchaseSub->save();
            if ($deleted) {
                # Audit Trail
                $remarks = $agmPurchaseSub->id . ' has been deleted.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "AGM Purchaser Submission";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                print "true";
            } else {
                print "false";
            }
        }
    }

    public function updateAgmPurchaseSub($id) {
        //get user permission
        $user_permission = AccessGroup::getAccessPermission(Auth::user()->id);
        $agmPurchaseSub = AgmPurchaseSub::find($id);
        $file = Files::where('is_active', 1)->where('is_deleted', 0)->get();

        $viewData = array(
            'title' => trans('agm_purchase_sub.title_edit'),
            'panel_nav_active' => 'agm_panel',
            'main_nav_active' => 'agm_main',
            'sub_nav_active' => 'agmpurchasesub_list',
            'user_permission' => $user_permission,
            'agmPurchaseSub' => $agmPurchaseSub,
            'file' => $file,
            'image' => ""
        );
        return View::make('page.agm_purchase_sub.edit', $viewData);
    }

    public function submitUpdateAgmPurchaseSub() {
        $data = Input::all();
        if (Request::ajax()) {
            $id = $data['id'];

            $fields = [
                'file_id',
                'unit_no',
                'share_unit',
                'buyer',
                'nric',
                'address1',
                'address2',
                'address3',
                'address4',
                'postcode',
                'phone_number',
                'email',
                'remark',
            ];

            $agmPurchaseSub = AgmPurchaseSub::find($id);

            foreach ($fields as $field) {
                $agmPurchaseSub->$field = $data[$field];
            }
            $success = $agmPurchaseSub->save();

            if ($success) {
                # Audit Trail
                $remarks = $agmPurchaseSub->id . ' has been updated.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "AGM Purchaser Submission Update";
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
