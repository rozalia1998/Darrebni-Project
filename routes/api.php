<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\SpecializationController;
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
Route::post('/register',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::prefix('dashboard')->middleware('admin')->group(function (){
        Route::post('/Specialization/create',[SpecializationController::class, 'createSpecialize']);
        Route::put('/Specialization/update/{sid}',[SpecializationController::class, 'UpdateSpecialize']);
        Route::delete('/Specialization/delete/{sid}',[SpecializationController::class, 'deleteSpecialize']);
    });

});