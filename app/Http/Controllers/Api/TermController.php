<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TermRequest;
use App\Models\Term;
use Illuminate\Http\Request;

class TermController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $terms=Term::all();

        return response()->json($terms);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TermRequest $request)
    {
        $add=Term::create([
            'term_name'=>$request->name,
            'subject_id'=>$request->subject_id,
        ]);
        return response()->json('Term Added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $term = Term::find($id);
    
        if (!$term) {
            return response()->json(['message' => 'Term not found'], 404);
        }
        
        return response()->json($term);
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
        $term = Term::find($id);
    
    if (!$term) {
        return response()->json(['message' => 'Term not found'], 404);
    }
    
    $term->term_name = $request->term_name;
    $term->subject_id = $request->subject_id;
    $term->save();
    
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
        $term = Term::find($id);
    
    if (!$term) {
        return response()->json(['message' => 'Term not found'], 404);
    }
    
    $term->delete();
    
    return response()->json(['message' => 'Term deleted successfully']);
    }
}
