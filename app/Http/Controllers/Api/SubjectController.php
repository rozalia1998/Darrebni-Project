<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubjectRequest;
use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
{
    $subjects = Subject::all();
    return response()->json($subjects);
}


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SubjectRequest $request)
    {
        Subject::create([
            'name'=>$request->name,
            'Specialization_id'=>$request->Specialization_id,
        ]);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $subject = Subject::find($id);
    
        if (!$subject) {
            return response()->json(['message' => 'Subject not found'], 404);
        }
        
        return response()->json($subject);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SubjectRequest $request, $id)
    {
        $subject = Subject::find($id);
    
    if (!$subject) {
        return response()->json(['message' => 'Subject not found'], 404);
    }
    
    $subject->name = $request->name;
    $subject->Specialization_id = $request->Specialization_id;
    $subject->save();
    
    return response()->json($subject);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $subject = Subject::find($id);
    
    if (!$subject) {
        return response()->json(['message' => 'Subject not found'], 404);
    }
    
    $subject->delete();
    
    return response()->json(['message' => 'Subject deleted successfully']);
    }
}
