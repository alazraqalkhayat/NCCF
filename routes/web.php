<?php

use App\Http\Controllers\Dashboard\Content\ADDController;
use App\Http\Controllers\Dashboard\Content\AnalysisController;
use App\Http\Controllers\Dashboard\Content\AppInfoController;
use App\Http\Controllers\Dashboard\Content\DetectionController;
use App\Http\Controllers\Dashboard\Content\DoseController;
use App\Http\Controllers\Dashboard\Content\ActivityController;
use App\Http\Controllers\Dashboard\ContentController;
use App\Http\Controllers\Dashboard\MainController;
use App\Http\Controllers\Dashboard\ReportsController;
use App\Http\Controllers\Dashboard\TypesController;
use App\Http\Controllers\Dashboard\Users\PermissionController;
use App\Http\Controllers\Dashboard\Users\RoleController;
use App\Http\Controllers\Dashboard\UsersController;
use App\Models\User;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
    Route::get('/profile', function () {
        $user = User::first();
        return Inertia::render('Dashboard');
    })->name('profile');


    Route::middleware('role:admin')->group(function () {

        // start for user management api
        Route::prefix('users')
            ->controller(UsersController::class)
            ->name('user.')
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::post('update/{id}', 'update')->name('update');
                Route::post('store', 'store')->name('store');
                Route::get('delete/{id}', 'delete')->name('delete');
                Route::post('get-recourds', 'getRecourds')->name('getRecourds');
            });

        Route::prefix('role')
            ->controller(RoleController::class)
            ->name('role.')
            ->group(function () {
                Route::post('update/{role:id}', 'update')->name('update');
                Route::post('store', 'store')->name('store');
                Route::get('delete/{role:id}', 'delete')->name('delete');
            });

        Route::prefix('permission')
            ->controller(PermissionController::class)
            ->name('permission.')
            ->group(function () {
                Route::post('update/{permission:id}', 'update')->name('update');
                Route::post('store', 'store')->name('store');
                Route::get('delete/{permission:id}', 'delete')->name('delete');
            });
        // end for user management api

        // start for patient management api

        // get main.getRecourds
        Route::post('get-records',[MainController::class , 'getRecords'])->name('main.getRecords');

        // content
        Route::get('content/', [ContentController::class, 'index'])->name('content.index');
        Route::post('content/get-records', [ContentController::class, 'getRecords'])->name('content.getRecords');

//        ADD routes
        Route::prefix('content')->name('a.d.d.')->controller(ADDController::class)->group(function (){
            Route::post('update/{id}/{type}', 'update')->name('update');
            Route::post('store/{type}', 'store')->name('store');
            Route::get('delete/{id}/{type}', 'delete')->name('delete');
        });

        // types
        Route::prefix('types')->controller(TypesController::class)->name('types.')->group(function () {
//            Route::get('/', [TypesController::class, 'index'])->name('index');
            Route::post('get-records', [TypesController::class, 'getRecords'])->name('getRecords');
            Route::post('update/{id}', 'update')->name('update');
            Route::post('store', 'store')->name('store');
            Route::post('delete/{id}', 'delete')->name('delete');
        });

//        for reports
        Route::prefix('reports')->name('reports.')->group(function(){
            Route::get('/', [ReportsController::class, 'index'])->name('index');
            Route::post('get-records', [ReportsController::class, 'getRecords'])->name('getRecords');
        });

        // for app info
        Route::post('app-info/update/{appInfo}', [AppInfoController::class,'update'])->name('app_info.update');

        // for activity
        Route::prefix('activity')
            ->controller(ActivityController::class)
            ->name('activity.')
            ->group(function () {
                Route::post('update/{activity}', 'update')->name('update');
                Route::post('store', 'store')->name('store');
                Route::get('delete/{activity}', 'delete')->name('delete');
            });


        // end for patient management api
    });
});
