<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Collage;
use App\Http\Resources\CollageResource;

class CollageController extends Controller
{
    use JsonResponse;

    public function index(){
        $collages=Collage::all();
        return $this->successResponse('All collages',CollageResource::collection($collages));
    }

}
