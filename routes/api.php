<?php

use App\Http\Controllers\Api\AnswersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CollageController;
use App\Http\Controllers\Api\SliderController;
use App\Http\Controllers\Api\SpecializationController;
use App\Http\Controllers\Api\FeedBackController;

use App\Http\Controllers\Api\SubjectController;
use App\Http\Controllers\Api\TermController;
use App\Http\Middleware\AdminMiddleware;



Route::get('/Specialization/allwithcolleges',[CollageController::class, 'specializationsCollagess']);
Route::post('/Specialization/search',[SpecializationController::class, 'ssearchresult']);
Route::get('/Specialization/all',[SpecializationController::class, 'all']);
Route::get('/Specialization/{id}',[SpecializationController::class, 'Specific']);




Route::get('/Colleges/all',[CollageController::class, 'AllColleges']);
Route::get('/Colleges/{id}',[CollageController::class, 'FindColleges']);




Route::post('/register',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::post('/feedback',[FeedBackController::class, 'store']);

    Route::prefix('dashboard')->middleware('admin')->group(function (){



        Route::post('/Specialization/create',[SpecializationController::class, 'createSpecialize']);
        Route::put('/Specialization/update/{sid}',[SpecializationController::class, 'UpdateSpecialize']);
        Route::delete('/Specialization/delete/{sid}',[SpecializationController::class, 'deleteSpecialize']);



        Route::post('/Subject/create',[SubjectController::class, 'store']);
        Route::post('/Subject/index',[SubjectController::class, 'index']);
        Route::post('/Subject/show/{id}',[SubjectController::class, 'show']);
        Route::put('/Subject/update/{id}',[SubjectController::class, 'update']);
        Route::delete('/Subject/delete/{id}',[SubjectController::class, 'destroy']);


        Route::post('/Term/index', [TermController::class, 'index']);
        Route::post('/Term/store', [TermController::class, 'store']);
        Route::post('/Term/show/{id}', [TermController::class, 'show']);
        Route::put('/Term/update/{id}', [TermController::class, 'update']);
        Route::delete('/Term/delete/{id}', [TermController::class, 'destroy']);


        Route::post('/Answer/index', [AnswersController::class, 'index']);
        Route::post('/Answer/store', [AnswersController::class, 'store']);
        Route::post('/Answer/show/{id}', [AnswersController::class, 'show']);
        Route::put('/Answer/update/{id}', [AnswersController::class, 'update']);
        Route::delete('/Answer/delete/{id}', [AnswersController::class, 'destroy']);

        Route::post('/Slider/index', [SliderController::class, 'index']);
        Route::post('/Slider/store', [SliderController::class, 'store']);
        Route::post('/Slider/show/{id}', [SliderController::class, 'show']);
        Route::put('/Slider/update/{id}', [SliderController::class, 'update']);
        Route::delete('/Slider/delete/{id}', [SliderController::class, 'destroy']);






    });

});
