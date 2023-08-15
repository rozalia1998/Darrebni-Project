<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Specialization;
use App\Models\Collage;
use App\Http\Requests\SpecializationRequest;
use App\Http\Resources\SearchResource;
use App\Http\Resources\SpecilizeResource;
use Illuminate\Http\Request;

class SpecializationController extends Controller
{
    use JsonResponse;
    

    public function createSpecialize(SpecializationRequest $request){
        if($request->hasFile('image')){
            $imagePath=$request->file('image')->store('public/images');
        }
        $specialization=Specialization::create([
            'specialization_name'=> $request->specialization_name,
            'image'=>$imagePath,
            'collage_id'=>$request->collage_id
        ]);

        return $this->successResponse('Specialization Created Successfully');

    }

    public function UpdateSpecialize(SpecializationRequest $request,$sid) {
        try {
            $specialization = Specialization::findOrFail($sid);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            return $this->notFoundResponse('Specialization not found to update it');
        }
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('public/images');
        }
        $res = $specialization->update([
            'specialization_name' => $request->input('specialization_name') ?? $specialization->specialization_name,
            'image' => $imagePath ?? $specialization->image,
            'collage_id' => $request->input('collage_id') ?? $specialization->collage_id
        ]);

            return $this->successResponse('Updated Specialization successfully');

    }


    public function deleteSpecialize($sid){
        try {
            $specialization = Specialization::findOrFail($sid);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            return $this->notFoundResponse('Specialization not found to delete it');
        }
        $specialization->delete();

        return $this->successResponse('Deleted Specialization Successfully');
    }


    public function all()
    {
        $all=Specialization::all();
        $specializations =SpecilizeResource::collection($all);


        return $this->successResponse('Success!',$specializations);

    }

    public function Specific($eid)
    {
        $college = Collage::find($eid);

        if (!$college) {
            return $this->notFoundResponse('College not found');
        }
    
        $specialization = $college->specializations()->get();
        $specialization=SpecilizeResource::collection($specialization);

        return $this->successResponse('Success!',[
            'specialization'=>$specialization,
        ]);


    }

    public function ssearchresult(Request $request)
{
    $specialization = $request->input('specialization');

    $specializationSearch = Specialization::where('specialization_name', 'like', $specialization . '%')->get();

    if ($specializationSearch->isEmpty()) {
        return $this->notFoundResponse('No specialization found');
    }

    $specializations = SearchResource::collection($specializationSearch);

    return $this->successResponse('Success', [
        'specializations' => $specializations,
    ]);
}
}
