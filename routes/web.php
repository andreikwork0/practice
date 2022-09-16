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




    foreach (['andrei.kinder170@gmail.com', 'sasuke.uchiha.2426@gmail.com'] as $recipient) {
        Mail::to($recipient)->send(new App\Mail\OrderShipped());
    }

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
