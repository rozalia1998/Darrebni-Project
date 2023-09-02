<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Specialization;
use App\Models\Collage;
use App\Http\Requests\SpecializationRequest;
use Illuminate\Http\Request;
use App\Http\Resources\SpecializationResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Traits\JsonResponse;
use App\Http\Traits\ImageUploadTrait;

class SpecializationController extends Controller
{
    use JsonResponse,ImageUploadTrait;

    public function index(){
        $specializations=Specialization::all();
        return $this->successResponse('All Specializations',SpecializationResource::collection($specializations));
    }

    public function getByCollage($uuid){
        $collage=Collage::where('uuid',$uuid)->first();
        // $collage=Collage::findOrfail($id);
        $object=$collage->specializations()->get();
        return $this->successResponse('Get Specializations By Collage',SpecializationResource::collection($object));

    }

    public function searchBySpecialization(Request $request){
        $specialization=Specialization::where('specialization_name','like','%'.$request->specialization_name.'%')->get();
        if(!$specialization->isEmpty()){
            return $this->successResponse('Search By Specialization',SpecializationResource::collection($specialization));
        }
        return $this->notFoundResponse('Specialization Not Found');
    }


    public function CheckButtons(){
        $code = auth()->user()->code;
        $id = $code->specialization_id;
        $specialization = Specialization::FindOrFail($id);
        if($specialization->has_levels==true){

            return $this->successResponse('Show Buttons',true);
        }
        return $this->successResponse('Hide Buttons',false);
    }

    public function store(SpecializationRequest $request)
    {
        // $imageName = $this->uploadImage($request,'specialization');

         $image = $this->uploadImage($request, "image", "specializations/");

        $specialization = Specialization::create([
            'specialization_name' => $request->specialization_name,
            'image' => $image,
            'collage_id' => $request->collage_id,
            'has_levels' => $request->has_levels ?? false,
        ]);

        return $this->successResponse('Specialization Created Successfully');
    }

    public function update(SpecializationRequest $request,$id) {
        try {
            $specialization = Specialization::findOrFail($id);
            $image = $this->uploadImage($request, "image", "specializations/");
            $specialization->update([
                'specialization_name' => $request->specialization_name ?? $specialization->specialization_name,
                'image' => $image ?? $specialization->image,
                'collage_id' => $request->collage_id ?? $specialization->collage_id
            ]);

        return $this->successResponse('Updated Specialization successfully');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            return $this->notFoundResponse();
        } catch (\Exception $exception) {
            return $this->handleException($exception);
        }

    }


    public function destroy($id){
        try {
            $specialization = Specialization::findOrFail($id);
            $specialization->delete();
            $this->deleteImage($specialization->image);

            return $this->successResponse('Deleted Specialization Successfully');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            return $this->notFoundResponse();
        }
    }
}
