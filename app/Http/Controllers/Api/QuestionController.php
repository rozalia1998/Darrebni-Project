<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\QuestionRequest;
use App\Models\Question;
use App\Models\Term;
use App\Models\Answer;
use App\Models\Specialization;
use App\Models\Subject;
use App\Http\Traits\JsonResponse;
use App\Http\Resources\QuestionResource;
use Exception;

class QuestionController extends Controller
{
    use JsonResponse;

    public function store(QuestionRequest $request){
        try {
            $question=Question::create([
                'question_content'=>$request->question_content,
                'reference'=>$request->reference,
                'subject_id'=>$request->subject_id,
                'term_id'=>$request->term_id,
                'specialization_id'=>$request->specialization_id
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


    public function BankQuestions($specialization_id){
        try {
            $specialization = Specialization::where('uuid', $specialization_id)->firstOrFail();

            $questions = $specialization->questions()
                ->whereNull('term_id')
                ->inRandomOrder()
                ->limit(50)
                ->with('answers')
                ->get();

            return $this->successResponse('Random Bank Questions Depends On Specialization', QuestionResource::collection($questions));
        } catch (\Exception $exception) {
            return $this->handleException($exception);
        }

    }

    public function QuestionTermForSpecialization($termid){
        try {
            $term = Term::where('uuid', $termid)->with('questions.answers')->firstOrFail();

            $questions = $term->questions()->inRandomOrder()->paginate(50);

            return $this->successResponse('Random Question Terms',QuestionResource::collection($questions));
        }  catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            return $this->notFoundResponse('Term Not Found');
        }
    }

    public function getQuestionsBySubject($termUuid,$subjectUuid){
        try {
            $term = Term::where('uuid', $termUuid)->firstOrFail();
            $subject = Subject::where('uuid', $subjectUuid)->firstOrFail();

            $questions = $subject->questions()
                ->where('term_id', $term->id)
                ->with('answers', 'term', 'subject')
                ->get();

            return $this->successResponse('Questions For Subject', QuestionResource::collection($questions));
        } catch (\Exception $e) {
            return $this->errorResponse('Error retrieving questions');
        }

    }

    public function BookQuestion($subid){
        try {
            $subject = Subject::where('uuid', $subid)->firstOrFail();
            $questions = $subject->questions()->with('answers')->whereNull('term_id')->get();

            return $this->successResponse('Book Questions For Subject', QuestionResource::collection($questions));
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to retrieve book questions for subject.', 500);
        }
    }


}
