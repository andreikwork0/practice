<?php

use App\Http\Controllers\AgreementController;
use App\Http\Controllers\AjaxController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ContactPersonController;
use App\Http\Controllers\Convention\ConventionController;

use App\Http\Controllers\Convention\ConventionInterface;
use App\Http\Controllers\Convention\ConvFactory;
use App\Http\Controllers\DistributionPracticeController;
use App\Http\Controllers\GrnLetterController;
use App\Http\Controllers\PracticeController;
use App\Http\Controllers\PremiseController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserController;
use App\Models\Convention;
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


Route::get('/login', [\App\Http\Controllers\UserLoginLdap::class, 'loginPage'])->name('login')->middleware('guest');
Route::post('/login', [\App\Http\Controllers\UserLoginLdap::class, 'loginUser'])->middleware('guest');;

Route::post('/logout', [\App\Http\Controllers\UserLoginLdap::class, 'logout'])->name('logout')->middleware('auth');

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group( function (){

    Route::middleware('role:umu')->group(function (){


        Route::resource('settings',   SettingController::class)->except('show');



        //Route::resource('conventions',ConventionController::class)->except('index', 'create', 'store', 'edit');
        Route::put("/conventions/{convention}/update/def", [ConventionController::class, 'updating'])->name('conventions.update.def');

        Route::put("/conventions/{convention}", [ConventionInterface::class, 'update'])->name('conventions.update');
        Route::get("/conventions/{convention}", [ConventionInterface::class, 'edit'])->name('conventions.edit');
        Route::post("/conventions/{convention}/download", [ConventionInterface::class, 'download'])->name('conventions.download');

        Route::delete('/conventions/{convention}',[ConventionController::class, 'destroy'])->name('conventions.destroy');
        Route::post('/agreements/{ag_id}/conventions/',[ConventionController::class, 'store'])->name('conventions.store');

        Route::resource('companies', CompanyController::class);
        Route::resource('grn_letters',   GrnLetterController::class);

        Route::controller(PremiseController::class)->group(function () {
            Route::resource('premises', PremiseController::class)->except('index','show','create','store');
            Route::get('/companies/{com_id}/premises/',  'list')->name('premises.list');
            Route::post('/companies/{com_id}/premises/', 'store')->name('premises.store');
        });

        Route::controller(ContactPersonController::class)->group(function () {
            Route::resource('contact_people', ContactPersonController::class)->except('create', 'store', 'index');
            Route::post('/companies/{com_id}/contact_people/','store')->name('contact_people.store');
            Route::get('/companies/{com_id}/contact_people/create', 'create')->name('contact_people.create');
            Route::get('/companies/{com_id}/contact_people/',  'list')->name('contact_people.list');
        });

        Route::controller(AgreementController::class)->group(function () {
            Route::post('/agreements/{id}/generate',  'generate')->name('agreements.generate');
            Route::post('/agreements/{id}/download','download')->name('agreements.download');
            Route::resource('agreements',  AgreementController::class)->except('create', 'store');
            Route::post('/companies/{com_id}/agreements/', 'store')->name('agreements.store');
            Route::get('/companies/{com_id}/agreements/create',  'create')->name('agreements.create');
        });


        Route::resource('users', UserController::class)->except([
            'create', 'store', 'show'
        ]); // может только админ или менеджер

    });



    //companies.show.cp


    // store -  /companies/{com_id}/agreement/ - post

    // edit
    // update
    // delete

    // show
    // доп соглашения


    Route::resource('distribution_practices',   DistributionPracticeController::class)
        ->except([
            'show', 'create', 'store'
        ])->middleware('role:umu,kaf');

    Route::post('/practices/{pr_id}/distribution/', [DistributionPracticeController::class, 'store'])->name('distribution_practices.store')
        ->middleware('role:umu,kaf');;

    Route::resource('practices', PracticeController::class)
        ->except([
            'create', 'store', 'destroy'
        ])->middleware('role:umu,kaf');



    Route::get('/ajax/pulpitbyedtype/{id}', [AjaxController::class, 'getPulptitByEdType']);
});


//Auth::routes(['verify' => true]);


