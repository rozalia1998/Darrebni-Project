<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Traits\JsonResponse;
use App\Http\Traits\ImageUploadTrait;
use App\Http\Requests\AboutusRequest;
use App\Http\Resources\AboutusResource;
use App\Models\Aboutus;
use Exception;

class AboutUsController extends Controller
{
    use JsonResponse;
    use ImageUploadTrait;

    public function getAboutus(){
        $aboutus=Aboutus::all();

        return $this->successResponse('About us', AboutusResource::collection($aboutus));
    }

    public function store(AboutusRequest $request){
        try{
            $image = $this->uploadImage($request, "image", "Aboutus/");
            $aboutus=Aboutus::create([
                'image'=>$image,
                'about'=>$request->about
            ]);

            return $this->successResponse('Added about us');
        }  catch (Exception $e) {
            return $this->handleException($e);
        }
    }
}
