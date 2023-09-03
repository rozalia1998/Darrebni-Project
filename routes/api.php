<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\SpecializationController;
use App\Http\Controllers\Api\SubjectController;
use App\Http\Controllers\Api\AnswerController;
use App\Http\Controllers\Api\QuestionController;
use App\Http\Controllers\Api\TermController;
use App\Http\Controllers\Api\SliderController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\CollageController;
use App\Http\Controllers\Api\FeedbackController;
use App\Http\Controllers\Api\ImportanceController;
use  App\Http\Controllers\Api\AboutUsController;
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
    Route::get('/Sliders/getAll',[SliderController::class, 'index']);
    Route::get('/AboutUs/getAll',[AboutUsController::class, 'getAboutus']);

    Route::group(['middleware' => ['auth:sanctum']], function () {

        Route::PUT('/UserProfile/update',[UserController::class, 'update']);
        Route::delete('/UserProfile/delete',[UserController::class, 'destroy']);
        Route::get('/UserProfile/Info',[UserController::class, 'getInfo']);
        Route::post('/UserProfile/Feedback',[FeedbackController::class, 'store']);

        Route::get('/Specialization/checkButtons',[SpecializationController::class, 'CheckButtons']);
        Route::get('/Specialization/filters/type={type}',[SubjectController::class, 'showMasterOrGraduationSubjects']);
        Route::get('/Specialization/filters/specialization={uuid}',[SubjectController::class, 'showSubjects']);

        Route::get('/Terms/specializations/specialization_id={uuid}',[TermController::class, 'getTerm']);

        //show Questions with Answers For Terms Depends On Subject
        Route::get('/Questions/Terms/term_id={termuuid}/Subjects/subject_id={uuid}',[QuestionController::class, 'getQuestionsBySubject']);

        //Show Questions With Answers For Books
        Route::get('/Books/Questions/Subject={uuid}',[QuestionController::class, 'BookQuestion']);

        //show Questions and answers randomly Depends On Specialization
        Route::get('/BankQuestions/specialization={uuid}',[QuestionController::class, 'BankQuestions']);
        Route::get('/SpecializationTermsQuestions/term={uuid}',[QuestionController::class, 'QuestionTermForSpecialization']);
        //Add and Remove Important Questions
        Route::post('/ImportanceQuestions/addQuestion/question={id}',[ImportanceController::class, 'addImportance']);
        Route::get('/ImportanceQuestions/getImportances',[ImportanceController::class, 'getImportances']);
        Route::delete('/ImportanceQuestions/remove/question={id}',[ImportanceController::class, 'removeImportance']);

        Route::prefix('dashboard')->middleware('admin')->group(function (){

            Route::get('/feedbacks/getall',[FeedbackController::class, 'getFeedbacks']);

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

            Route::post('/Answer/create', [AnswerController::class, 'store']);
            Route::put('/Answer/update/{id}', [AnswerController::class, 'update']);
            Route::delete('/Answer/delete/{id}', [AnswerController::class, 'destroy']);

            Route::post('/AboutUs/create', [AboutUsController::class, 'store']);
            Route::delete('/AboutUs/delete/{id}', [AboutUsController::class, 'delete']);

        });

    });

});
