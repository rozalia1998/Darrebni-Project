<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\SpecializationController;
use App\Http\Controllers\Api\SubjectController;
use App\Http\Controllers\Api\AnswerController;
use App\Http\Controllers\Api\TermController;
use App\Http\Controllers\Api\SliderController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\CollageController;
use App\Http\Controllers\Api\FeedbackController;
use App\Http\Middleware\AdminMiddleware;

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
Route::prefix('/Darrebni')->group(function (){

    Route::prefix('/auth')->group(function (){
        Route::post('/register',[AuthController::class,'register']);
        Route::post('/login',[AuthController::class,'login']);
        Route::post('/UserProfile/logout',[AuthController::class, 'logout'])->middleware(['auth:sanctum']);
    });
    Route::get('/Collages/all',[CollageController::class, 'index']);
    Route::get('/Specialization/allSpecialization',[SpecializationController::class, 'index']);
    Route::get('/Collages/getSpecialization/collage={uuid}',[SpecializationController::class, 'getByCollage']);
    Route::get('/Collages/Specializations',[CollageController::class, 'getCollagesWithSpecialization']);
    Route::post('/Specialization/search',[SpecializationController::class, 'searchBySpecialization']);

    Route::group(['middleware' => ['auth:sanctum']], function () {

        Route::put('/UserProfile/update',[UserController::class, 'update']);
        Route::delete('/UserProfile/delete',[UserController::class, 'destroy']);
        Route::get('/UserProfile/Info',[UserController::class, 'getInfo']);
        Route::post('/UserProfile/Feedback',[FeedbackController::class, 'store']);

        Route::prefix('dashboard')->middleware('admin')->group(function (){

            Route::post('/Slider/create', [SliderController::class, 'store']);
            Route::put('/Slider/update/{id}', [SliderController::class, 'update']);
            Route::delete('/Slider/delete/{id}', [SliderController::class, 'destroy']);

            Route::post('/Specialization/create',[SpecializationController::class, 'store']);
            Route::put('/Specialization/update/{id}',[SpecializationController::class, 'update']);
            Route::delete('/Specialization/delete/{id}',[SpecializationController::class, 'destroy']);

            Route::post('/Subject/create',[SubjectController::class, 'store']);
            Route::put('/Subject/update/{id}',[SubjectController::class, 'update']);
            Route::delete('/Subject/delete/{id}',[SubjectController::class, 'destroy']);

            Route::post('/Term/store', [TermController::class, 'store']);
            Route::put('/Term/update/{id}', [TermController::class, 'update']);
            Route::delete('/Term/delete/{id}', [TermController::class, 'destroy']);

            Route::post('/Question/create',[QuestionController::class, 'store']);
            Route::put('/Question/update/{id}',[QuestionController::class, 'udate']);
            Route::delete('/Question/delete/{id}',[QuestionController::class, 'destroy']);

            Route::post('/Answer/store', [AnswersController::class, 'store']);
            Route::put('/Answer/update/{id}', [AnswersController::class, 'update']);
            Route::delete('/Answer/delete/{id}', [AnswersController::class, 'destroy']);

        });

    });

});
