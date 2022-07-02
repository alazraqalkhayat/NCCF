<?php

use App\Http\Controllers\Dashboard\Content\AnalysisController;
use App\Http\Controllers\Dashboard\Content\DetectionController;
use App\Http\Controllers\Dashboard\Content\DoseController;
use App\Http\Controllers\Dashboard\Content\ActivityController;
use App\Http\Controllers\Dashboard\ContentController;
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

        // content
        Route::get('content/', [ContentController::class, 'index'])->name('content.index');
        Route::post('content/get-records', [ContentController::class, 'getRecords'])->name('content.getRecords');

        // types
        Route::prefix('types')->controller(TypesController::class)->name('types.')->group(function () {
            Route::get('/', [TypesController::class, 'index'])->name('index');
            Route::post('get-records', [TypesController::class, 'getRecords'])->name('getRecords');
            Route::post('update/{id}', 'update')->name('update');
            Route::post('store', 'store')->name('store');
            Route::post('delete/{id}', 'delete')->name('delete');
        });


        // for patient detection
        Route::prefix('patient-detection')
            ->controller(DetectionController::class)
            ->name('detection.')
            ->group(function () {
                Route::post('update/{detection}', 'update')->name('update');
                Route::post('store', 'store')->name('store');
                Route::get('delete/{detection}', 'delete')->name('delete');
            });

        // for patient detection type
        Route::prefix('patient-detection-type')
            ->controller(DetectionController::class)
            ->name('patient-detection-type.')
            ->group(function () {
                Route::post('update/{id}', 'update')->name('update');
                Route::post('store', 'store')->name('store');
                Route::get('delete/{id}', 'delete')->name('delete');
            });

        // for activity
        Route::prefix('activity')
            ->middleware('role:الاستقبال')
            ->controller(ActivityController::class)
            ->name('activity.')
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::post('update/{activity}', 'update')->name('update');
                Route::post('store', 'store')->name('store');
                Route::get('delete/{activity}', 'delete')->name('delete');
            });

        // for patient friends
        Route::prefix('patient-friends')
            ->controller(DoseController::class)
            ->name('patient-friends.')
            ->group(function () {
                Route::post('update/{id}', 'update')->name('update');
                Route::post('store', 'store')->name('store');
                Route::get('delete/{id}', 'delete')->name('delete');
            });


        // for dose
        Route::prefix('dose')
            ->controller(DoseController::class)
            ->name('dose.')
            ->group(function () {
                Route::post('update/{dose}', 'update')->name('update');
                Route::post('store', 'store')->name('store');
                Route::get('delete/{dose}', 'delete')->name('delete');
            });

        // for dose type


        // for analysis
        Route::prefix('analysis')
            ->controller(AnalysisController::class)
            ->name('analysis.')
            ->group(function () {
                Route::post('update/{analysis}', 'update')->name('update');
                Route::post('store', 'store')->name('store');
                Route::get('delete/{analysis}', 'delete')->name('delete');
            });

        // for analysis type
        Route::prefix('analysis-type')
            ->controller(AnalysisTypeController::class)
            ->name('analysis-type.')
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::post('update/{id}', 'update')->name('update');
                Route::post('store', 'store')->name('store');
                Route::get('delete/{id}', 'delete')->name('delete');
                Route::post('get-recourds', 'getRecourds')->name('getRecourds');
            });


        // end for patient management api
    });
});
