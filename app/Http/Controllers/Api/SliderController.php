<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SliderRequest;
use App\Models\Slider;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    use JsonResponse;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sliders = Slider::all();
        return $this->successResponse('Sliders Fetched Successfully !', $sliders);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\SliderRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SliderRequest $request)
    {
        $slider = Slider::create($request->validated());
        return $this->successResponse('Slider created Successfully !', $slider, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $slider = Slider::find($id);
        if (!$slider) {
            return $this->notFoundResponse('Slider Dosent Exist');
        }
        return $this->successResponse('Slider Fetched Successfully !', $slider);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\SliderRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SliderRequest $request, $id)
    {
        $slider = Slider::find($id);
        if (!$slider) {
            return $this->notFoundResponse('Slider Dosent Exist');
        }
        $slider->update($request->validated());
        return $this->successResponse('Slider updated Successfully !', $slider);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $slider = Slider::find($id);
        if (!$slider) {
            return $this->notFoundResponse('Slider not found');
        }
        $slider->delete();
        return $this->successResponse('Slider Deleted Successfully !');
    }
}