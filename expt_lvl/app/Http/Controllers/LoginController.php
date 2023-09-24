<?php

namespace App\Http\Controllers;

use App\Models\ExptUsers;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
Use DB;
Use Mail;
use Session;


class LoginController extends BaseController{

    public function login() {

        // dd(Crypt::encrypt('moez123'));

        // if(!session::has('PCAdminAuthenticated')){
        //     return redirect('login');
        // }

        if(session::has('normalUserId')){
            return redirect('/dashboard');
        };

        return view('login');
    }

    public function register() {

        if(session::has('normalUserId')){
            return redirect('/dashboard');
        };

        return view('registration');
    }

    public function loginProcess(Request $request) {
        if ($request->login_process_val == "login") {
            return $this->sendLogin($request);
        }
        else if ($request->login_process_val == "register") {
            return $this->sendRegister($request);
        }
        else if ($request->login_process_val == "forgot_pass") {
            return $this->sendForgotPass($request);
        }
        else if ($request->login_process_val == "reset_pass") {
            return $this->sendResetPass($request);
        }
        else if ($request->login_process_val == "logout") {
            return $this->sendLogoutUser($request);
        }
    }

    public function sendRegister(Request $request) {
        
        $accountCheck = ExptUsers::select('id', 'user_name', 'user_email', 'user_role', 'user_password')
                        ->where('user_email', $request->getRegisterUserEmail_val)
                        ->where('active', 1)
                        ->first();

        if ($accountCheck != null) {
            return "email exists";
        } else {

            $InerContact = new ExptUsers();
            $InerContact->user_name = $request->getRegisterUserName_val;
            $InerContact->user_email = $request->getRegisterUserEmail_val;
            $InerContact->user_password = md5($request->getRegisterUserPass_val);
            $InerContact->save();

        }        

    }

    public function sendLogin(Request $request) {

        // dd(\Illuminate\Support\Facades\Crypt::encrypt('admin'));

        // dd($request->email_val . ' ' . $request->pass_val);
        $accountCheck = ExptUsers::select('id', 'user_name', 'user_email', 'user_role', 'user_password')
                        ->where('user_email', $request->userEmail_val)
                        ->where('active', 1)
                        ->first();

        if ($accountCheck == null) {
            return "Wrong email";
        } else {

            // $storedPassword = Crypt::decrypt($accountCheck->em_password);
            $storedPassword = $accountCheck->user_password;

            if ($storedPassword == md5($request->userPass_val)) {
                Session::put('normalUserId', $accountCheck->id);
                Session::put('normalUserName', $accountCheck->user_name);
                Session::put('normalUserEmail', $accountCheck->user_email);
                Session::put('normalUserRole', $accountCheck->user_role);
            }
            else {
                return "Wrong password";
            }

        }

    }
    
    public function sendLogoutUser(Request $request) {
        Session::forget('normalUserId');
        Session::forget('normalUserName');
        Session::forget('normalUserEmail');
        Session::forget('normalUserRole');

        return 'logout successfull';
    }

}