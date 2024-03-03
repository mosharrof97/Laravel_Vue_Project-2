<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EditorController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\EventBookingController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

///////////////////////////////////////////////
Route::prefix('admin')->group(function (){
// Route::get('/login', [AdminController::class, 'login']);
Route::post('/login', [AdminController::class, 'login_submit']);
});
///////////////////////////////////////////////
// Route::middleware('admin')->group(function (){
// Route::get('admin/dashboard', [AdminController::class, 'dashboard']);
// });

Route::prefix('admin')->middleware('admin')->group(function (){

    Route::get('/logout', [AdminController::class, 'logout']);

    Route::get('/dashboard', [AdminController::class, 'dashboard']);

    Route::get('/list', [AdminController::class, 'adminList']);
    Route::get('/view/{id}', [AdminController::class, 'adminView']);
    Route::get('/create', [AdminController::class, 'createAdmin']);
    Route::post('/create', [AdminController::class, 'storeAdmin']);
    Route::delete('/delete/{id}', [AdminController::class, 'delete']);


    /////-==========Event==========-///////
    Route::prefix('event')->group(function (){
        Route::get('/list', [EventController::class, 'list']);
        Route::get('/view/{id}', [EventController::class, 'view']);
        Route::post('/create', [EventController::class, 'create']);
        Route::put('/update/{id}', [EventController::class, 'update']);
        Route::delete('/delete/{id}', [EventController::class, 'delete']);
    });
    /////-==========Event==========-///////
});

/////////////////////////////////////////////////////////////////
///////////////////////////////////////////////
Route::middleware('student')->group(function (){
    Route::get('student/dashboard', [StudentController::class, 'dashboard']);
});

Route::prefix('student')->group(function (){
    Route::get('/login', [StudentController::class, 'login']);
    Route::get('/logout', [StudentController::class, 'logout']);
    Route::post('/login-submit', [StudentController::class, 'login_submit']);

    Route::get('/list', [StudentController::class, 'studentList']);
    Route::get('/view/{id}', [StudentController::class, 'studentView']);
    Route::get('/create', [StudentController::class, 'createStudent']);
    Route::post('/create', [StudentController::class, 'storeStudent']);
    Route::delete('/delete/{id}', [StudentController::class, 'delete']);


});
/////////////////////////////////////////////////////////////////

/////-==========Event==========-///////
Route::prefix('event')->group(function (){
    Route::get('/list', [EventBookingController::class, 'list']);
    Route::get('/view/{id}', [EventBookingController::class, 'view']);
    Route::post('/create', [EventBookingController::class, 'create']);
    Route::put('/update/{id}', [EventBookingController::class, 'update']);
    Route::delete('/delete/{id}', [EventBookingController::class, 'delete']);
});
/////-==========Event==========-///////
