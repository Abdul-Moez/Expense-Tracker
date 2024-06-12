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

            $regUsrDataGet = ExptUsers::select('user_role', 'first_login')->where('id', $InerContact->id)->first();

            Session::put('normalUserId', $InerContact->id);
            Session::put('normalUserName', $InerContact->user_name);
            Session::put('normalUserEmail', $InerContact->user_email);
            Session::put('normalUserRole', $regUsrDataGet->user_role);
            Session::put('normalUserFsLgin', $regUsrDataGet->first_login);

            ExptUsers::where('id', $InerContact->id)->update(array(
                'first_login' => 0,
            ));

        }        

    }

    public function sendLogin(Request $request) {

        // dd(\Illuminate\Support\Facades\Crypt::encrypt('admin'));

        // dd($request->email_val . ' ' . $request->pass_val);
        $accountCheck = ExptUsers::select('id', 'user_name', 'user_email', 'user_role', 'user_password', 'first_login')
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
                Session::put('normalUserFsLgin', $accountCheck->first_login);

                ExptUsers::where('id', $accountCheck->id)->update(array(
                    'first_login' => 0,
                ));
            }
            else {
                return "Wrong password";
            }

        }

    }
    
    public function forgotPassword(Request $request) {

        if(session::has('normalUserId')){
            return redirect('/dashboard');
        }

        return view('/forgot_password');
    }

    public function sendForgotPass(Request $request) {

        $accountCheck = ExptUsers::select('id', 'user_name', 'user_email')
                        ->where('user_email', $request->userEmail_val)
                        ->where('active', 1)
                        ->first();

        if ($accountCheck == null) {
            return "email doesn't exsist";
        } else {

            ExptUsers::where('id', $accountCheck->id)
                        ->update([
                            'is_pw_updated' => 1
                        ]);

            $userEmail = Crypt::encrypt($accountCheck->user_email);
            $URLDATA = URL('reset_password/'.$userEmail);
            $Mhtml = 'Please click on the link below to reset your password: <br><br> <a href="'.$URLDATA.'" target="_blank">Reset Password</a>';
            $NHtml = array('Content' => $Mhtml);

            Session::put('usersName', $accountCheck->user_name);
            Session::put('usersEmail', $accountCheck->user_email);
            Mail::send([], [], function ($message) use ($NHtml) {
                $message->to(Session::get('usersEmail'), Session::get('usersName'))
                ->subject('Expense Tracker - Password Reset Link')
                // ->setBody($NHtml['Content'], 'text/html');
                ->html($NHtml['Content']);
                $message->from('support@expensetracker.com', 'Expense Tracker');
                $message->replyto('no-reply@expensetracker.com', 'Expense Tracker');
                $message->priority(1);
            });
            Session::forget('usersName');
            Session::forget('usersEmail');
        }
    }

    public function resetPassword(Request $request, $link) {

        $decryptedEmail = Crypt::decrypt($link);

        $accountCheck = ExptUsers::select('is_pw_updated')->where('user_email', $decryptedEmail)->first();

        if ($accountCheck->is_pw_updated == 0) {
            return redirect('/');
        }

        if(session::has('normalUserId')){
            return redirect('/dashboard');
        }

        return view('reset_password');
    }
    
    public function sendResetPass(Request $request) {

        $decryptedEmail = Crypt::decrypt($request->urlEmail_val);

        $confirmPass = $request->confirmNewPass_val;

        $encryptedPass = md5($confirmPass);

        ExptUsers::where('user_email', $decryptedEmail)
                    ->update([
                        'user_password' => $encryptedPass,
                        'is_pw_updated' => 0
                    ]);
        
        return 'Password Updated';
    }
    
    public function sendLogoutUser(Request $request) {
        Session::forget('normalUserId');
        Session::forget('normalUserName');
        Session::forget('normalUserEmail');
        Session::forget('normalUserRole');
        Session::forget('normalUserFsLgin');

        return 'logout successfull';
    }

}