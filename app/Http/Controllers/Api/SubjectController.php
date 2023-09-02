<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubjectRequest;
use App\Models\Subject;
use App\Models\Specialization;
use App\Http\Traits\JsonResponse;
use App\Http\Resources\SubjectResource;
use Exception;

class SubjectController extends Controller
{
    use JsonResponse;

    public function showMasterOrGraduationSubjects($type)
    {
        // Retrieve all master or graduation subjects related to the specialization with the given ID
        $user = auth()->user();
        $specialization = $user->code->specialization;

        if ($specialization) {
            $subjects = $specialization->subjects();

            if ($type == 'master') {
                $subjects = $subjects->where('has_master', true);
                $message = 'Filter Master Subjects';
            } else {
                $subjects = $subjects->where('has_graduation', true);
                $message = 'Filter Graduation Subjects';
            }

            $res = $subjects->get();
            return $this->successResponse($message, SubjectResource::collection($res));
        }

        // Handle the case when the specialization is not found
        return $this->errorResponse('Specialization not found');
    }

    public function showSubjects(string $specializationUuid)
    {
        try {
            $specialization = Specialization::where('uuid', $specializationUuid)->firstOrFail();
            $subjects = $specialization->subjects()->get();

            return $this->successResponse('All Subjects For Specialization', SubjectResource::collection($subjects));
        } catch (ModelNotFoundException $e) {
            return $this->errorResponse('Specialization not found', 404);
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SubjectRequest $request)
    {
        try {
            Subject::create([
                'name' => $request->name,
                'Specialization_id' => $request->Specialization_id,
                'has_master'=>$request->has_master,
                'has_graduation'=>$request->has_graduation
            ]);

            return $this->successResponse('Created Subject Successfully');
        } catch (Exception $e) {
            return $this->handleException($e);
        }
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
        try {
            $subject = Subject::findOrFail($id);
            $res = $subject->update([
                'name'=>$request->name ?? $subject->name,
                'Specialization_id'=>$request->Specialization_id ?? $subject->Specialization_id,
                'has_master'=>$request->has_master ?? $subject->has_master,
                'has_graduation'=>$request->has_graduation ?? $subject->has_graduation
            ]);

            return $this->successResponse('Updated Subject Successfully');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            return $this->notFoundResponse();
        } catch (\Exception $exception) {
            return $this->handleException($exception);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $subject = Subject::findOrFail($id);
            $subject->delete();

            return $this->successResponse('Deleted Subject Successfully');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            return $this->notFoundResponse();
        } catch (\Exception $exception) {
            return $this->handleException($exception);
        }
    }

}
