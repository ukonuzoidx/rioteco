<?php

namespace App\Http\Controllers\Auth;

use App\Models\GeneralSetting;
use App\Http\Controllers\Controller;
use App\Models\PasswordReset;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showResetForm(Request $request, $token = null)
    {

        $email = session('fpass_email');
        $token = session()->has('token') ? session('token') : $token;
        if (PasswordReset::where('token', $token)->where('email', $email)->count() != 1) {
            $notify[] = ['error', 'Invalid token'];
            return redirect()->route('user.password.request')->withNotify($notify);
        }
        return view(activeTemplate() . 'user.auth.passwords.reset')->with(
            ['token' => $token, 'email' => $email, 'page_title' => 'Reset Password']
        );
    }

    public function reset(Request $request)
    {
        session()->put('fpass_email', $request->email);
        $request->validate($this->rules(), $this->validationErrorMessages());
        $reset = PasswordReset::where('token', $request->token)->orderBy('created_at', 'desc')->first();
        if (!$reset) {
            $notify[] = ['error', 'Invalid Verification Code'];
            return redirect()->route('user.login')->withNotify($notify);
        }

        $general = GeneralSetting::first();
        if ($general->secure_password) {
            $notify = $this->strongPassCheck($request->password);
            if ($notify) {
                return back()->withNotify($notify)->withInput($request->all());
            }
        }

        $user = User::where('email', $reset->email)->first();
        $user->password = bcrypt($request->password);
        $user->save();

        $userIpInfo = getIpInfo();
        $userBrowser = osBrowser();
        sendEmail($user, 'PASS_RESET_DONE', [
            'operating_system' => @$userBrowser['os_platform'],
            'browser' => @$userBrowser['browser'],
            'ip' => @$userIpInfo['ip'],
            'time' => @$userIpInfo['time']
        ]);


        $notify[] = ['success', 'Password Changed'];
        return redirect()->route('user.login')->withNotify($notify);
    }


    protected function strongPassCheck($password){
        $password = $password;
        $capital = '/[ABCDEFGHIJKLMNOPQRSTUVWXYZ]/';
        $capital = preg_match($capital,$password);
        $notify = null;
        if (!$capital) {
            $notify[] = ['error','Minimum 1 capital word is required'];
        }
        $number = '/[123456790]/';
        $number = preg_match($number,$password);
        if (!$number) {
            $notify[] = ['error','Minimum 1 number is required'];
        }
        $special = '/[`!@#$%^&*()_+\-=\[\]{};:"\\|,.<>\/?~\']/';
        $special = preg_match($special,$password);
        if (!$special) {
            $notify[] = ['error','Minimum 1 special character is required'];
        }
        return $notify;
    }



    /**
     * Get the password reset validation rules.
     *
     * @return array
     */
    protected function rules()
    {
        return [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6',
        ];
    }

}
