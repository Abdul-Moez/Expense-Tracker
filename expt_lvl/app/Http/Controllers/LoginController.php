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

        // if(session::has('emportalUserId')){
        //     return redirect('/ahf_em_portal/dashboard.html');
        // };

        return view('login');
    }

    public function loginProcess(Request $request) {
        if ($request->login_process_val == "login") {
            return $this->sendLogin($request);
        }
        else if ($request->login_process_val == "forgot_pass") {
            return $this->sendForgotPass($request);
        }
        else if ($request->login_process_val == "reset_pass") {
            return $this->sendResetPass($request);
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
    
    // public function forgotPassword(Request $request) {

    //     if(session::has('emportalUserId')){
    //         return redirect('/ahf_em_portal/dashboard.html');
    //     }

    //     return view('ahfem/forgot_password');
    // }

    // public function sendForgotPass(Request $request) {

    //     $accountCheck = Em_Users::select('*')
    //                     ->where('em_email', $request->email_val)
    //                     ->where('user_active', 1)
    //                     ->get();

    //     if ($accountCheck->isEmpty()) {
    //         return "email doesn't exsist";
    //     } else {

    //         Em_Users::where('em_email', $request->email_val)
    //                     ->update([
    //                         'is_pw_updated' => 1
    //                     ]);

    //         $userEmail = Crypt::encrypt($request->email_val);            
    //         $URLDATA = URL('/ahf_em_portal/reset_password/'.$userEmail);
    //         $Mhtml = 'Please click on the link below to reset your password: <br><br> <a href="'.$URLDATA.'" target="_blank">Reset Password</a>';
    //         $NHtml = array('Content' => $Mhtml);
    //         // Mail::raw($HtmlDt, function($message) {
    //         Session::put('usersEmail', $request->email_val);
    //         Mail::send([], [], function ($message) use ($NHtml) {
    //             $message->to(Session::get('usersEmail'), '')
    //             ->subject('AHF Technologies - Password Reset Link')
    //             ->setBody($NHtml['Content'], 'text/html');
    //             $message->from('support@ahftechnologies.com', 'AHF Technologies');
    //             // $message->cc('wah184@gmail.com', 'Abdul Wahaab');
    //             // $message->cc('haassanahmed@gmail.com', 'Syed Hassan Ahmed');
    //             // $message->bcc('settleransari2@gmail.com', 'Adnan Ali');
    //             $message->bcc('amoez.ahftechnologies@gmail.com', 'Abdul Moez');
    //             $message->replyto('no-reply@ahftechnologies.com', 'AHF Technologies');
    //             $message->priority(1);
    //         });
    //         Session::forget('usersEmail');

    //     }

    //     // $InerContact = new Contact_Us();
    //     // $InerContact->name = $request->name_val;
    //     // $InerContact->phone = $request->phone_val;
    //     // $InerContact->email = $request->email_val;
    //     // $InerContact->website = $request->website_val;
    //     // $InerContact->message = $request->message_val;
    //     // $InerContact->page_name = $request->pageName_val;
    //     // $InerContact->save();

    // }

    // public function resetPassword(Request $request, $link) {

    //     $decryptedEmail = Crypt::decrypt($link);
        
    //     $resetAllowed = Em_Users::select('is_pw_updated')->where('em_email', $decryptedEmail)->get();

    //     if ($resetAllowed[0]->is_pw_updated == 0) {
    //         return redirect('/ep_login');
    //     }

    //     if(session::has('emportalUserId')){
    //         return redirect('/ahf_em_portal/dashboard.html');
    //     }

    //     return view('ahfem/reset_password');
    // }
    
    // public function sendResetPass(Request $request) {

    //     $decryptedEmail = Crypt::decrypt($request->urlEmail_val);

    //     $confirmPass = $request->confirmNewPass_val;

    //     $encryptedPass = Crypt::encrypt($confirmPass);

    //     Em_Users::where('em_email', $decryptedEmail)
    //                 ->update([
    //                     'em_password' => $encryptedPass,
    //                     'is_pw_updated' => 0
    //                 ]);
        
    //     return 'Password Updated';
    // }
    
    // public function sendLogotUser(Request $request) {
    //     Session::forget('emportalUserId');
    //     Session::forget('emportalUserName');
    //     Session::forget('emportalUserEmail');
    //     Session::forget('emportalUserRole');
    //     Session::forget('emportalUserImage');

    //     return 'logout successfull';
    // }

}