<?php

use App\Http\Controllers\Api\FrontEndController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// login
Route::post('api-login', [UserController::class, 'login']);

Route::post('add-patient-frinds', [FrontEndController::class, 'addPatientFrinds']); // get name, phone and mimbership

// Route::post('forget-password', [FrontEndController::class, 'addPatientFrinds']); // get name, phone and mimbership


Route::middleware(['auth:sanctum'])->group(function () {
    // logout
    Route::post('logout', [UserController::class, 'logout']);

    // الكشف المبكر
    Route::post('get-detection-type', [FrontEndController::class, 'getDetectionType']);


    // detection details
    Route::post('detection-details', [FrontEndController::class, 'detectionDetails']); // return date , status and user name

    // detection cancel
    Route::post('detection-cansel', [FrontEndController::class, 'detectionCansel']); // get reson  and change status


    // analysis
    Route::post('get-analysis', [FrontEndController::class, 'getAnalysis']); // return date , status ,type and  user name

    // analysis cancel
    Route::post('analysis-cansel', [FrontEndController::class, 'analysisCansel']); // get reson  and change status


    // analysis
    Route::post('get-dose', [FrontEndController::class, 'getDose']); // return date , status ,type and  user name

    // analysis cancel
    Route::post('dose-cansel', [FrontEndController::class, 'doseCansel']); // get reson  and change status


    // add new psyological aid
    Route::post('add-psyological-aid', [FrontEndController::class, 'addPsyologicalAid']); // get reson and change status


    // add new patient frinds


    // detection details
    Route::post('events-activities', [FrontEndController::class, 'eventsActivities']); // get media type and type

});
