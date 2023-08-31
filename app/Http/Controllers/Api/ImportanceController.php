<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\JsonResponse as ApiJsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\JsonResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Question;
use App\Models\Importance;
use App\Http\Traits\JsonResponse;
use Exception;

class ImportanceController extends Controller
{
    use JsonResponseTrait;

    public function addImportance($qid){
        try{
            $user=Auth::user();
            $question=Question::FindOrFail($qid);
            $importance=Importance::create([
                'user_id'=>$user->id,
                'question_id'=>$question->id
            ]);
            return $this->successResponse('Added To Impotance Successfully');
        } catch (Exception $exception) {
            return $this->handleException($exception);
        }
    }

    public function getImportances(){
        $user=Auth::user();
        $importances=$user->questions()->with('answers')->get();
        if($importances->isEmpty()){
            return $this->errorResponse('Your Importance Questions Table is empty');
        }
        return $this->successResponse('All Importance Questions',$importances);
    }

    public function removeImportance($qid){
        try{
            $user=Auth::user();
            $question=Question::FindOrFail($qid);
            $user->questions()->detach($question->id);
            return $this->successResponse('Remove From Impotance Successfully');
        } catch (Exception $exception) {
            return $this->handleException($exception);
        }
    }
}
