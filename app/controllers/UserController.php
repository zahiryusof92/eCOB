<?php

class UserController extends BaseController {

    public function __construct() {
        Session::forget('lang');
        Session::put('lang', 'en');
    }

    public function changeLanguage($lang) {
        Session::forget('lang');
        Session::put('lang', $lang);

        return Redirect::back();
    }

    //register
    public function register() {

        if (Session::get('lang') == "en") {
            $viewData = array(
                'title' => "Register",
                'panel_nav_active' => '',
                'main_nav_active' => '',
                'sub_nav_active' => '',
            );

            return View::make('user_en.register', $viewData);
        } else {
            $viewData = array(
                'title' => "Pendaftaran",
                'panel_nav_active' => '',
                'main_nav_active' => '',
                'sub_nav_active' => '',
            );

            return View::make('user_my.register', $viewData);
        }
    }

    public function submitRegister() {
        $data = Input::all();
        if (Request::ajax()) {

            $username = $data['username'];
            $password = $data['password'];
            $name = $data['name'];
            $email = $data['email'];
            $phone_no = $data['phone_no'];

            $check_username = User::where('username', $username)->count();

            if ($check_username <= 0) {
                $user = new User();
                $user->username = $username;
                $user->password = Hash::make($password);
                $user->full_name = $name;
                $user->email = $email;
                $user->phone_no = $phone_no;
                $user->remarks = "";
                $user->role = 2;
                $user->status = 0;
                $user->is_active = 0;
                $user->is_deleted = 0;
                $success = $user->save();

                if ($success) {
                    # Audit Trail
                    $remarks = 'User ' . $user->username . ' has been registered.';
                    $auditTrail = new AuditTrail();
                    $auditTrail->module = "System Administration";
                    $auditTrail->remarks = $remarks;
                    $auditTrail->audit_by = $user->id;
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

    //member login start
    public function login() {

        if (Session::get('lang') == "en") {
            $viewData = array(
                'title' => "Login",
                'panel_nav_active' => '',
                'main_nav_active' => '',
                'sub_nav_active' => '',
            );

            return View::make('user_en.login', $viewData);
        } else {
            $viewData = array(
                'title' => "Log Masuk",
                'panel_nav_active' => '',
                'main_nav_active' => '',
                'sub_nav_active' => '',
            );

            return View::make('user_my.login', $viewData);
        }
    }

    public function loginAction() {

        $form = Input::all();

        $validator = Validator::make($form, array(
                    'username' => 'required',
                    'password' => 'required'
        ));

        if ($validator->fails()) {
            return Redirect::to('/login')->withErrors($validator)->withInput();
        } else {

            $remember = (Input::has('remember')) ? true : false;
            $password = Input::get('password');

            $auth = Auth::attempt(array(
                        'username' => Input::get('username'),
                        'password' => $password,
                        'status' => 1,
                        'is_active' => 1,
                        'is_deleted' => 0,
                            ), $remember);

            if ($auth) {

                $user_account = User::where('id', Auth::user()->id)->first();
                Session::put('id', $user_account['id']);
                Session::put('username', $user_account['username']);
                Session::put('full_name', $user_account['full_name']);
                Session::put('role', $user_account['role']);

                # Audit Trail
                $remarks = 'User ' . Auth::user()->username . ' is signed.';
                $auditTrail = new AuditTrail();
                $auditTrail->module = "System Administration";
                $auditTrail->remarks = $remarks;
                $auditTrail->audit_by = Auth::user()->id;
                $auditTrail->save();

                return Redirect::to('/home');
            } else {
                if (Session::get('lang') == "en") {
                    return Redirect::to('/login')->with('login_error', 'Wrong Username/Password');
                } else {
                    return Redirect::to('/login')->with('login_error', 'Nama Pengguna/Kata Laluan salah');
                }
            }
        }
        if (Session::get('lang') == "en") {
            return Redirect::to('/login')->with('login_error', 'There was problem logging in');
        } else {
            return Redirect::to('/login')->with('login_error', 'Masalah Log Masuk');
        }
    }

    //member login end
    //edit profile
    public function editProfile() {

        $user = User::find(Auth::User()->id);
        $role = Role::find($user->role);

        if (Session::get('lang') == "en") {
            $viewData = array(
                'title' => "Edit Profile",
                'panel_nav_active' => '',
                'main_nav_active' => '',
                'sub_nav_active' => '',
                'user' => $user,
                'role' => $role,
                'image' => ""
            );
            return View::make('user_en.edit_profile', $viewData);
        } else {
            $viewData = array(
                'title' => "Profil Penyelaras",
                'panel_nav_active' => '',
                'main_nav_active' => '',
                'sub_nav_active' => '',
                'user' => $user,
                'role' => $role,
                'image' => ""
            );
            return View::make('user_my.edit_profile', $viewData);
        }
    }

    public function submitEditProfile() {
        $data = Input::all();
        if (Request::ajax()) {
            $user = User::find(Auth::User()->id);
            if (count($user) > 0) {
                $user->full_name = $data['name'];
                $user->email = $data['email'];
                $user->phone_no = $data['phone_no'];
                $success = $user->save();

                if ($success) {
                    Session::forget('full_name');
                    Session::put('full_name', $user['full_name']);

                    print "true";
                } else {
                    print "false";
                }
            } else {
                print "false";
            }
        }
    }

    //Change password

    public function changePassword() {

        $user = User::find(Auth::User()->id);

        if (Session::get('lang') == "en") {
            $viewData = array(
                'title' => "Change Password",
                'panel_nav_active' => '',
                'main_nav_active' => '',
                'sub_nav_active' => '',
                'user' => $user,
                'image' => ""
            );

            return View::make('user_en.change_password', $viewData);
        } else {
            $viewData = array(
                'title' => "Tukar Kata Laluan",
                'panel_nav_active' => '',
                'main_nav_active' => '',
                'sub_nav_active' => '',
                'user' => $user,
                'image' => ""
            );

            return View::make('user_my.change_password', $viewData);
        }
    }

    public function checkPasswordProfile() {
        $data = Input::all();
        if (Request::ajax()) {
            $old_password = $data['old_password'];

            //incase user enters lowcase
            $new_old_password = strtoupper($data['old_password']);

            $user = User::find(Auth::User()->id);

            if (Hash::check($old_password, $user->getAuthPassword())) {
                print "true";
            } else if (Hash::check($new_old_password, $user->getAuthPassword())) {
                print "true";
            } else {
                print "false";
            }
        }
    }

    public function submitChangePassword() {
        $data = Input::all();
        if (Request::ajax()) {
            $new_password = $data['new_password'];

            $user = User::find(Auth::User()->id);
            $user->password = Hash::make($new_password);
            $success = $user->save();

            if ($success) {
                print "true";
            } else {
                print "false";
            }
        }
    }

    //member logout start 
    public function logout() {
        Session::forget('id');
        Session::forget('username');
        Session::forget('role');
        Auth::logout();
        return Redirect::to('/login');
    }

}

?>