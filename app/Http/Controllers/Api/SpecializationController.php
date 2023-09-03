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

    public function getByCollage($uuid)
    {
        try {
            $college = Collage::where('uuid', $uuid)->firstOrFail();
            $specializationIds = $college->specializations()->pluck('id');
            $specializations = Specialization::whereIn('id', $specializationIds)->get();

            return $this->successResponse('Get Specializations By College', SpecializationResource::collection($specializations));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->notFoundResponse('College not found');
        } catch (\Exception $exception) {
            return $this->handleException($exception);
        }
    }

    public function searchBySpecialization(Request $request)
    {
        $specializationName = $request->input('specialization_name');

        if (empty($specializationName)) {
            return $this->errorResponse('Specialization name is required');
        }

        try {
            $specializations = Specialization::where('specialization_name', 'like', '%' . $specializationName . '%')
                ->paginate(10);

            if ($specializations->isEmpty()) {
                return $this->notFoundResponse('Specialization Not Found');
            }

            return $this->successResponse('Search By Specialization', SpecializationResource::collection($specializations));
        } catch (\Exception $e) {
            return $this->errorResponse('An error occurred', 500);
        }
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
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $image = $this->uploadImage($file, "specializations/");
        }
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
            return $this->notFoundResponse('Specialization Not Found');
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
