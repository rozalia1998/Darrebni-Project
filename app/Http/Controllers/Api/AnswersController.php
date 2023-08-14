<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AnswesRequest;
use App\Models\Answer;
use Illuminate\Http\Request;

class AnswersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Answers=Answer::all();

        return response()->json($Answers);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AnswesRequest $request)
    {
        $add=Answer::create([
            'answer_content'=>$request->answer_content,
            'question_id'=>$request->question_id,
            'is_correct'=>$request->is_correct,
        ]);
        return response()->json('Answer added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $Answers = Answer::find($id);
    
        if (!$Answers) {
            return response()->json(['message' => 'Term not found'], 404);
        }
        
        return response()->json($Answers);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $Answers = Answer::find($id);
    
        if (!$Answers) {
            return response()->json(['message' => 'Term not found'], 404);
        }
        
        $Answers->answer_content = $request->answer_content;
        $Answers->question_id = $request->question_id;
        $Answers->is_correct = $request->is_correct;
        $Answers->save();
        
        return response()->json('Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Answers = Answer::find($id);
    
        if (!$Answers) {
            return response()->json(['message' => 'Answer not found'], 404);
        }
        
        $Answers->delete();
        
        return response()->json(['message' => 'Answer deleted successfully']);
    }
}
