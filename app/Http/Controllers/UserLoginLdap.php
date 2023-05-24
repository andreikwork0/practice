<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


class UserLoginLdap extends Controller
{
    //


    public function loginPage(){
        return view('auth.login');
    }

    public function checkLdap($ldap_user, $ldap_pass)
    {
//        return true;

        $ldap_server = 'ldap://' . config('ldap.ldap.host');
        try {
            $ad = ldap_connect($ldap_server) ;
            ldap_set_option($ad, LDAP_OPT_PROTOCOL_VERSION, 3) ;
            $bound = ldap_bind($ad, $ldap_user .'@vuz', $ldap_pass);
            return true;
        } catch (\Exception $exception){
            return false;
        }

    }

    public function loginUser(Request $request)
    {

        $isLdap =  $this->checkLdap($request->input('username'), $request->input('password'));

        if (!$isLdap) {
             return redirect()->route('login')->withErrors(['msg' => 'Ошибка входа. Попробуйте другой логин-пароль']);
        }

        $user = User::where('username', '=', $request->input('username'))->first();

        if ($user) {
            //Auth::login($user);
        } else {
            $user = (new UserRegisterLdap($request->input('username'), $request->input('password')))->createUser();
            if (!$user) return redirect()->route('login')->withErrors(['msg' => 'Ошибка ldap. Пользователь не найден']);
        }
        Auth::login($user);
        return redirect()->route('home');

    }

    public function logout(){

        Session::flush();

        Auth::logout();

        return redirect()->route('login');
    }

}
