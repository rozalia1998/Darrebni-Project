<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\QuestionRequest;
use App\Models\Question;
use Exception;

class QuestionController extends Controller
{
    use JsonResponse;

    public function store(QuestionRequest $request){
        try {

            $question=َQuestion::create([
                'question_content'=>$request->question_content,
                'reference'=>$request->reference,
                'subject_id'=>$request->subject_id,
                'term_id'=>$request->term_id
            ]);
            return $this->successResponse('Question added Successfully');
        } catch (Exception $e) {
            return $this->handleException($e);
        }
    }

    public function update(QuestionRequest $request,$id){
        try {
            $question = Question::findOrFail($id);

            $res = $question->update([
                'question_content'=>$request->question_content ?? $question->question_content,
                'reference'=>$request->reference ?? $question->reference,
                'subject_id'=>$request->subject_id ?? $question->subject_id,
                'term_id'=>$request->term_id ?? $question->term_id
            ]);

            return $this->successResponse('Updated Question Successfully');
        } catch (\Exception $exception) {
            return $this->handleException($exception);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            return $this->notFoundResponse();
        }

    }

    public function destroy($id){
        try {
            $question = Question::findOrFail($id);
            $question->delete();

            return $this->successResponse('Question deleted successfully');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            return $this->notFoundResponse();
        } catch (\Exception $exception) {
            return $this->handleException($exception);
        }
    }

}
