<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserRegisterLdap extends Controller
{

    protected $username;
    protected $password;

    protected $ad;

    protected $userLdap = false;
    public function __construct($username, $password)
    {
        $this->username = $username;
        $this->password= $password;
        $this->ad = $this->connectionLdap();
    }


    public function findUserLdap(){

        $filter="(sAMAccountName=".$this->username.")";
        $dns = [
            'vo'    => 'ou=образовательные структуры,dc=vuz,dc=magtu,dc=ru',
            'spo'  => 'ou=многопрофильный колледж (ук№3),dc=vuz,dc=magtu,dc=ru',
            'def'   =>'ou=общеуниверситетские службы,dc=vuz,dc=magtu,dc=ru',
        ];
        foreach ($dns as $key =>  $dn ){
            try {
//                var_dump($dn);
                $res = ldap_search($this->ad, $dn, $filter);
                if ($res){
                    $info = ldap_get_entries($this->ad, $res);
                    return [$info[0], $key];
                }
            } catch (\Exception $exception){
//                var_dump($exception->getCode());
//                var_dump($exception->getMessage());
                continue;
            }
        }
        return false;
    }

    public function connectionLdap(){
        $ldap_server = "ldap://192.168.20.10";
        $ldap_user   = "AdminLMS";
        $ldap_pass   = '1v$7$%vd2I';

        $ad = ldap_connect($ldap_server) ;
        ldap_set_option($ad, LDAP_OPT_PROTOCOL_VERSION, 3) ;

        try {
            $bound = ldap_bind($ad, $ldap_user, $ldap_pass);
            return $ad;
        } catch (\Exception $exception){
//            var_dump($exception->getCode());
//            var_dump($exception->getMessage());
            return null;
        }

    }
    public function createUser(){

        [$this->userLdap, $type] =  $this->findUserLdap();
        if ($this->userLdap) {
            switch ($type){
                case 'vo':
                    $ed_type = 1;
                    break;
                case 'spo':
                    $ed_type = 2;
                    break;
                case 'def' :
                    $ed_type =  NULL;
                    break;
            }
            $givename = explode(' ',$this->userLdap["givenname"][0] );
            $args =    array(
                'username'   => $this->username,
                'password'  => Hash::make($this->password),
                'perscode'     => $this->userLdap["perscode"][0],
                'name'     => $this->userLdap["cn"][0],
                'lname'     => $this->userLdap["sn"][0],
                'fname'     => $givename[0],
                'mname'     => $givename[1],
                'domain'   =>$this->userLdap["dn"]
            );

            if ($ed_type){
                $args['education_type_id'] =  $ed_type;
            }
            return User::create( $args);
        } else {
            return false;
        }


    }
}
