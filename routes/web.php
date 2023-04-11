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
use App\Http\Controllers\KindOfActivityController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PracticeController;
use App\Http\Controllers\PracticeTeacherController;
use App\Http\Controllers\PremiseController;

use App\Http\Controllers\PrStudentController;
use App\Http\Controllers\PrStudentMetaController;
use App\Http\Controllers\PrStudentToolController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\ToolController;
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


    Route::get('tools/export/', [ToolController::class, 'export'])->name('tools.export')->middleware('role:umu');

    Route::get('users/export/', [UserController::class, 'export'])->name('users.export')->middleware('role:umu');
    Route::get('agreements/export/', [AgreementController::class, 'export'])->name('agreements.export')->middleware('role:umu');

    Route::post('file/{id}/download', [\App\Http\Controllers\FileController::class, 'download'])
        ->name('file.download')
        ->middleware('role:umu,kaf');


    Route::get('/orders/{id}/edit', [\App\Http\Controllers\OrderController::class, 'edit'])
        ->name('orders.edit')
        ->middleware('role:umu,kaf');

    Route::put('/orders/{id}/edit', [\App\Http\Controllers\OrderController::class, 'update'])
        ->name('orders.update')
        ->middleware('role:umu,kaf');

    Route::middleware('role:umu')->group(function (){


        Route::resource('settings',   SettingController::class)->except('show');
        Route::resource('tools',   ToolController::class)->except('show');
        Route::resource('kind_of_activities',   KindOfActivityController::class)->except('show', 'destroy');



        //Route::resource('conventions',ConventionController::class)->except('index', 'create', 'store', 'edit');
        Route::put("/conventions/{convention}/update/def", [ConventionController::class, 'updating'])->name('conventions.update.def');

        Route::post("/conventions/{convention}/generate", [ConventionInterface::class, 'generate'])->name('conventions.generate');

        Route::put("/conventions/{convention}", [ConventionInterface::class, 'update'])->name('conventions.update');
        Route::get("/conventions/{convention}", [ConventionInterface::class, 'edit'])->name('conventions.edit');
        Route::post("/conventions/{convention}/download", [ConventionInterface::class, 'download'])->name('conventions.download');

        Route::delete('/conventions/{convention}',[ConventionInterface::class, 'destroy'])->name('conventions.destroy');
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


    Route::delete('/orders/{id}', [OrderController::class, 'destroy'])
        ->name('orders.destroy')
        ->middleware('role:umu,kaf');

    Route::get('/practices/{pr_id}/orders', [OrderController::class, 'index_one'])
        ->name('orders.index_one')
        ->middleware('role:umu,kaf');

    Route::post('/practices/{pr_id}/orders', [OrderController::class, 'store'])
        ->name('orders.store')
        ->middleware('role:umu,kaf');




    Route::get('/practices/{id}/student_tool', [ PrStudentToolController::class ,'edit'])
        ->name('pr_student_tool.edit')
        ->middleware('role:umu,kaf');

    Route::post('/practices/{id}/student_tool', [ PrStudentToolController::class ,'update'])
        ->name('pr_student_tool.update')
        ->middleware('role:umu,kaf');


    Route::get('/practices/{id}/student_meta', [PrStudentMetaController::class ,'edit'])
        ->name('pr_student_meta.edit')
        ->middleware('role:umu,kaf');

    Route::put('/practices/{id}/student_meta', [PrStudentMetaController::class ,'update'])
        ->name('pr_student_meta.update')
        ->middleware('role:umu,kaf');


    Route::get('/practices/{id}/teachers/', [PracticeTeacherController::class ,'show'])
        ->name('pr_teacher.list')
        ->middleware('role:umu,kaf');


    Route::resource('distribution_practices',   DistributionPracticeController::class)
        ->except([
            'show', 'create', 'store'
        ])->middleware('role:umu,kaf');

    Route::post('/practices/{pr_id}/distribution/', [DistributionPracticeController::class, 'store'])->name('distribution_practices.store')
        ->middleware('role:umu,kaf');

    Route::resource('practices', PracticeController::class)
        ->except([
            'create', 'store', 'destroy'
        ])->middleware('role:umu,kaf');


    Route::get('/distribution_practices/{id}/pr_student', [PrStudentController::class, 'edit'])->name('pr_student.edit')
        ->middleware('role:umu,kaf');

    Route::put('/distribution_practices/{id}/pr_student', [PrStudentController::class, 'update'])->name('pr_student.update')
        ->middleware('role:umu,kaf');

    Route::post('/practices/{id}/generate', [OrderController::class, 'generate'])->name('order.generate')
        ->middleware('role:umu,kaf');

    Route::get('/ajax/pulpitbyedtype/{id}', [AjaxController::class, 'getPulptitByEdType']);
});



Route::get('/api/org_str/search', [\App\Http\Controllers\OrgStructureController::class, 'getTreeForSelect']);


Route::get('/api/companies/search', function (){
    $collection  =   \App\Models\Company::filter(request(['search']))->select('id', 'name')->orderBy('name')->paginate(10);

    //$col = \Illuminate\Support\Collection::make()
    $tmp_arr = array();
    foreach ($collection as $item)
    {
        $single = new \stdClass();
        $single->id = $item->id;
        $single->text = $item->name;
        $tmp_arr[] = $single;
    }


    $col = \Illuminate\Support\Collection::make($tmp_arr);
    return response()->json(['results' =>    $col ?? '',
        "pagination" => ["more" =>  $col->count() ? true : false ]
        ]
    );
});
//Auth::routes(['verify' => true]);

