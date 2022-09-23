<?php

use App\Http\Controllers\AgreementController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ContactPersonController;
use App\Http\Controllers\GrnLetterController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {

//
//    function connect_AD()
//    {
//        $ldap_server = "ldap://192.168.20.10";
//        $ldap_user   = "AdminLMS";
//        $ldap_pass   = '1v$7$%vd2I';
//
//        $ad = ldap_connect($ldap_server) ;
//
//        ldap_set_option($ad, LDAP_OPT_PROTOCOL_VERSION, 3) ;
//        try {
//            $bound = ldap_bind($ad, $ldap_user, $ldap_pass);
//
//            $username = 'l.kurzaeva';
//            $filter="(sAMAccountName=$username)";
//
//            $ldap_search = "ou=образовательные структуры,dc=vuz,dc=magtu,dc=ru";
//            $dn=$ldap_search; //even if it seems obvious I note here that the dn is just an example, you'll have to provide an OU and DC of your own
//
//
//            $res = ldap_search($ad, $ldap_search, $filter);
//            var_dump($res);
//
//            if ($res){
//
//                $info = ldap_get_entries($ad, $res);
//
//
//                echo '<pre>';
//                print_r($info[0]["perscode"][0]);
//                echo '</pre>';
////                $data = ldap_get_dn($ad, $first);
//
//            }
//
//
//
//        }
//        catch (\Exception $e){
//
//            echo "<br>";
//            echo 'erorr';
//            print_r($e->getCode());
//            print_r($e->getMessage());
//        }
//
//
//        return $ad ;
//    }
//
//
//
//    $ldap=connect_AD();
//
//
//    var_dump(  get_resource_type($ldap)  );
//
//    foreach (['andrei.kinder170@gmail.com', 'sasuke.uchiha.2426@gmail.com'] as $recipient) {
//        Mail::to($recipient)->send(new App\Mail\OrderShipped());
//    }

    //dd($collection_practice);
    //\App\Models\Practice::insert( $pr_arr);
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group( function (){
    Route::resource('companies', CompanyController::class);
    Route::resource('contact_people', ContactPersonController::class);
    Route::resource('agreements',  AgreementController::class);
    Route::resource('grn_letters',   GrnLetterController::class);
});


Auth::routes(['verify' => true]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
