<?php

class AgmController extends BaseController {

    public function __construct() {
        if (empty(Session::get('lang'))) {
            Session::put('lang', 'en');
        }

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
                'files' => $files,
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

    /*
     * Purchaser
     */

    public function purchaser() {
        //get user permission
        $user_permission = AccessGroup::getAccessPermission(Auth::user()->id);
        $files = Files::where('is_active', 1)->where('is_deleted', 0)->orderBy('year', 'desc')->get();

        if (Session::get('lang') == "en") {
            $viewData = array(
                'title' => 'Purchaser Submission',
                'panel_nav_active' => 'agm_panel',
                'main_nav_active' => 'agm_main',
                'sub_nav_active' => 'agmpurchasesub_list',
                'user_permission' => $user_permission,
                'files' => $files,
                'Uploadmessage' => '',
                'upload' => "true",
                'image' => ''
            );

            return View::make('agm_en.purchaser', $viewData);
        } else {
            $viewData = array(
                'title' => 'Penyerahan Maklumat Pembeli',
                'panel_nav_active' => 'agm_panel',
                'main_nav_active' => 'agm_main',
                'sub_nav_active' => 'agmpurchasesub_list',
                'user_permission' => $user_permission,
                'files' => $files,
                'Uploadmessage' => '',
                'upload' => "true",
                'image' => ''
            );

            return View::make('agm_my.purchaser', $viewData);
        }
    }

    public function getPurchaser() {
        $buyer_list = Buyer::where('is_deleted', 0)->orderBy('id', 'desc')->get();

        if (count($buyer_list) > 0) {
            $data = Array();
            $no = 1;
            foreach ($buyer_list as $buyer_lists) {
                $button = "";
                $button .= '<button type="button" class="btn btn-sm btn-success" title="Edit" onclick="window.location=\'' . URL::action('AgmController@editPurchaser', $buyer_lists->id) . '\'">
                                <i class="fa fa-pencil"></i>
                            </button>
                            &nbsp;';
                $button .= '<button type="button" class="btn btn-sm btn-danger" title="Delete" onclick="deletePurchaser(\'' . $buyer_lists->id . '\')">
                                <i class="fa fa-trash"></i>
                            </button>
                            &nbsp';


                $data_raw = array(
//                    $no++,
                    $buyer_lists->unit_no,
                    $buyer_lists->unit_share,
                    $buyer_lists->owner_name,
                    $buyer_lists->ic_company_no,
                    $buyer_lists->phone_no,
                    $buyer_lists->email,
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

    public function addPurchaser() {
        //get user permission
        $user_permission = AccessGroup::getAccessPermission(Auth::user()->id);
        $files = Files::where('is_active', 1)->where('is_deleted', 0)->orderBy('year', 'desc')->get();

        if (Session::get('lang') == "en") {
            $viewData = array(
                'title' => 'Add Purchaser',
                'panel_nav_active' => 'agm_panel',
                'main_nav_active' => 'agm_main',
                'sub_nav_active' => 'agmpurchasesub_list',
                'user_permission' => $user_permission,
                'files' => $files,
                'image' => ''
            );

            return View::make('agm_en.add_purchaser', $viewData);
        } else {
            $viewData = array(
                'title' => 'Tambah Pembeli',
                'panel_nav_active' => 'agm_panel',
                'main_nav_active' => 'agm_main',
                'sub_nav_active' => 'agmpurchasesub_list',
                'user_permission' => $user_permission,
                'files' => $files,
                'image' => ''
            );

            return View::make('agm_my.add_purchaser', $viewData);
        }
    }

    public function submitPurchaser() {
        $data = Input::all();
        if (Request::ajax()) {

            $file_id = $data['file_id'];
            $unit_no = $data['unit_no'];
            $unit_share = $data['unit_share'];
            $owner_name = $data['owner_name'];
            $ic_company_no = $data['ic_company_no'];
            $address = $data['address'];
            $phone_no = $data['phone_no'];
            $email = $data['email'];
            $remarks = $data['remarks'];

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
                $buyer->email = $email;
                $buyer->remarks = $remarks;
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

    public function editPurchaser($id) {
        //get user permission
        $user_permission = AccessGroup::getAccessPermission(Auth::user()->id);
        $buyer = Buyer::find($id);
        $files = Files::where('is_active', 1)->where('is_deleted', 0)->orderBy('year', 'desc')->get();

        if (Session::get('lang') == "en") {
            $viewData = array(
                'title' => 'Update COB File',
                'panel_nav_active' => 'agm_panel',
                'main_nav_active' => 'agm_main',
                'sub_nav_active' => 'agmpurchasesub_list',
                'user_permission' => $user_permission,
                'files' => $files,
                'buyer' => $buyer,
                'image' => ''
            );

            return View::make('agm_en.edit_purchaser', $viewData);
        } else {
            $viewData = array(
                'title' => 'Update COB File',
                'panel_nav_active' => 'agm_panel',
                'main_nav_active' => 'agm_main',
                'sub_nav_active' => 'agmpurchasesub_list',
                'user_permission' => $user_permission,
                'files' => $files,
                'buyer' => $buyer,
                'image' => ''
            );

            return View::make('agm_my.edit_purchaser', $viewData);
        }
    }

    public function submitEditPurchaser() {
        $data = Input::all();
        if (Request::ajax()) {

            $file_id = $data['file_id'];
            $unit_no = $data['unit_no'];
            $unit_share = $data['unit_share'];
            $owner_name = $data['owner_name'];
            $ic_company_no = $data['ic_company_no'];
            $address = $data['address'];
            $phone_no = $data['phone_no'];
            $email = $data['email'];
            $remarks = $data['remarks'];
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
                    $buyer->email = $email;
                    $buyer->remarks = $remarks;
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

    public function deletePurchaser() {
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

    public function importPurchaser() {
        //get user permission
        $user_permission = AccessGroup::getAccessPermission(Auth::user()->id);

        if (Session::get('lang') == "en") {
            $viewData = array(
                'title' => 'Import Purchaser',
                'panel_nav_active' => 'agm_panel',
                'main_nav_active' => 'agm_main',
                'sub_nav_active' => 'agmpurchasesub_list',
                'user_permission' => $user_permission,
                'Uploadmessage' => '',
                'upload' => "true",
                'image' => ''
            );

            return View::make('agm_en.import_purchaser', $viewData);
        } else {
            $viewData = array(
                'title' => 'Import Purchaser',
                'panel_nav_active' => 'agm_panel',
                'main_nav_active' => 'agm_main',
                'sub_nav_active' => 'agmpurchasesub_list',
                'user_permission' => $user_permission,
                'Uploadmessage' => '',
                'upload' => "true",
                'image' => ''
            );

            return View::make('agm_my.import_purchaser', $viewData);
        }
    }

    public function submitUploadPurchaser() {
        $data = Input::all();
        if (Request::ajax()) {

            $getAllBuyer = $data['getAllBuyer'];

            foreach ($getAllBuyer as $buyerList) {

                $check_file_id = Files::where('file_no', $buyerList[0])->first();
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
                        $buyer->email = $buyerList[7];
                        $buyer->remarks = $buyerList[8];
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

            print "true";
        } else {
            print "false";
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

    /*
     * Upload Minutes
     */

    public function minutes() {
        //get user permission
        $user_permission = AccessGroup::getAccessPermission(Auth::user()->id);
        $files = Files::where('is_active', 1)->where('is_deleted', 0)->orderBy('year', 'desc')->get();

        if (Session::get('lang') == "en") {
            $viewData = array(
                'title' => 'Upload of Minutes',
                'panel_nav_active' => 'agm_panel',
                'main_nav_active' => 'agm_main',
                'sub_nav_active' => 'agmminutesub_list',
                'user_permission' => $user_permission,
                'files' => $files,
                'image' => ""
            );

            return View::make('agm_en.minutes', $viewData);
        } else {
            $viewData = array(
                'title' => 'Upload of Minutes',
                'panel_nav_active' => 'agm_panel',
                'main_nav_active' => 'agm_main',
                'sub_nav_active' => 'agmminutesub_list',
                'user_permission' => $user_permission,
                'files' => $files,
                'image' => ""
            );

            return View::make('agm_my.minutes', $viewData);
        }
    }

    public function getMinutes() {
        $agm_detail = MeetingDocument::where('is_deleted', 0)->orderBy('id', 'desc')->get();

        if (count($agm_detail) > 0) {
            $data = Array();
            foreach ($agm_detail as $agm_details) {
                $button = "";
                $button .= '<button type="button" class="btn btn-xs btn-success edit_agm" title="Edit" onclick="window.location=\'' . URL::action('AgmController@editMinutes', $agm_details->id) . '\'"><i class="fa fa-pencil"></i></button>&nbsp;&nbsp;';
                $button .= '<button type="button" class="btn btn-xs btn-danger" title="Delete" onclick="deleteAGMDetails(\'' . $agm_details->id . '\')"><i class="fa fa-trash""></i></button>';

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
                    $status1 = '<i class="icmn-cross"></i>';
                } else {
                    $status1 = '<i class="icmn-checkmark"></i>';
                }
                if ($agm_details->egm == 0 || $agm_details->egm == "") {
                    $status2 = '<i class="icmn-cross"></i>';
                } else {
                    $status2 = '<i class="icmn-checkmark"></i>';
                }
                if ($agm_details->minit_meeting == 0 || $agm_details->minit_meeting == "") {
                    $status3 = '<i class="icmn-cross"></i>';
                } else {
                    $status3 = '<i class="icmn-checkmark"></i>';
                }
                if ($agm_details->letter_integrity_url == "") {
                    $status4 = '<i class="icmn-cross"></i>';
                } else {
                    $status4 = '<i class="icmn-checkmark"></i>';
                }
                if ($agm_details->letter_bankruptcy_url == "") {
                    $status5 = '<i class="icmn-cross"></i>';
                } else {
                    $status5 = '<i class="icmn-checkmark"></i>';
                }
                if ($agm_details->jmc_spa == 0 || $agm_details->jmc_spa == "") {
                    $status6 = '<i class="icmn-cross"></i>';
                } else {
                    $status6 = '<i class="icmn-checkmark"></i>';
                }
                if ($agm_details->identity_card == 0 || $agm_details->identity_card == "") {
                    $status7 = '<i class="icmn-cross"></i>';
                } else {
                    $status7 = '<i class="icmn-checkmark"></i>';
                }
                if ($agm_details->attendance == 0 || $agm_details->attendance == "") {
                    $status8 = '<i class="icmn-cross"></i>';
                } else {
                    $status8 = '<i class="icmn-checkmark"></i>';
                }
                if ($agm_details->financial_report == 0 || $agm_details->financial_report == "") {
                    $status9 = '<i class="icmn-cross"></i>';
                } else {
                    $status9 = '<i class="icmn-checkmark"></i>';
                }
                if ($agm_details->audit_report_url == "") {
                    $status10 = '<i class="icmn-cross"></i>';
                } else {
                    $status10 = '<i class="icmn-checkmark"></i>';
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

    public function addMinutes() {
        //get user permission
        $user_permission = AccessGroup::getAccessPermission(Auth::user()->id);
        $files = Files::where('is_active', 1)->where('is_deleted', 0)->orderBy('year', 'desc')->get();

        if (Session::get('lang') == "en") {
            $viewData = array(
                'title' => 'Add Minutes',
                'panel_nav_active' => 'agm_panel',
                'main_nav_active' => 'agm_main',
                'sub_nav_active' => 'agmminutesub_list',
                'user_permission' => $user_permission,
                'files' => $files,
                'image' => ""
            );

            return View::make('agm_en.add_minutes', $viewData);
        } else {
            $viewData = array(
                'title' => 'Upload of Minutes',
                'panel_nav_active' => 'agm_panel',
                'main_nav_active' => 'agm_main',
                'sub_nav_active' => 'agmminutesub_list',
                'user_permission' => $user_permission,
                'files' => $files,
                'image' => ""
            );

            return View::make('agm_my.add_minutes', $viewData);
        }
    }

    public function submitAddMinutes() {
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
            $remarks = $data['remarks'];

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
            $agm_detail->remarks = $remarks;
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

    public function editMinutes($id) {
        //get user permission
        $user_permission = AccessGroup::getAccessPermission(Auth::user()->id);
        $meeting_doc = MeetingDocument::find($id);
        if ($meeting_doc) {
            $files = Files::where('is_active', 1)->where('is_deleted', 0)->orderBy('year', 'desc')->get();

            if (Session::get('lang') == "en") {
                $viewData = array(
                    'title' => 'Add Minutes',
                    'panel_nav_active' => 'agm_panel',
                    'main_nav_active' => 'agm_main',
                    'sub_nav_active' => 'agmminutesub_list',
                    'user_permission' => $user_permission,
                    'meeting_doc' => $meeting_doc,
                    'files' => $files,
                    'image' => ""
                );

                return View::make('agm_en.edit_minutes', $viewData);
            } else {
                $viewData = array(
                    'title' => 'Upload of Minutes',
                    'panel_nav_active' => 'agm_panel',
                    'main_nav_active' => 'agm_main',
                    'sub_nav_active' => 'agmminutesub_list',
                    'user_permission' => $user_permission,
                    'meeting_doc' => $meeting_doc,
                    'files' => $files,
                    'image' => ""
                );

                return View::make('agm_my.edit_minutes', $viewData);
            }
        }
    }

    public function submitEditMinutes() {
        $data = Input::all();
        if (Request::ajax()) {

            $id = $data['id'];
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
            $remarks = $data['remarks'];

            $agm_detail = MeetingDocument::find($id);
            if ($agm_detail) {
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
                $agm_detail->remarks = $remarks;
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
            } else {
                print "false";
            }
        }
    }

    public function getMinuteDetails() {
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

    public function deleteMinuteDetails() {
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

}
