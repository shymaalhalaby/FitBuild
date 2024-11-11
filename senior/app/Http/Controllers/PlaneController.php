<?php

namespace App\Http\Controllers;

use App\Models\Diet;
use App\Models\Plane;
use App\Models\member;
use App\Models\DailyDiet;
use App\Models\Excercise;
use Illuminate\Http\Request;
use App\Models\DailyExercise;
use App\Http\Resources\PlaneResource;
use App\Http\Requests\StorePlaneRequest;

class PlaneController extends Controller
{
    public function store(request $request, Excercise $Excercise, DailyExercise $DailyExercise)
    {
        $validated = $request->validate([
            'RepeatCount' => 'nullable',
            'Set' => 'nullable',
            'Duration' => 'nullable',
            'TrainingTips' => 'nullable',
            'RestBreak' => 'nullable',
            'TransitionRest' => 'nullable',
        ]);
        $Plane = Plane::create([
            'exercise_id' => $Excercise->id,
            'daily_exercise_id' => $DailyExercise->id,
            'RepeatCount' => $validated['RepeatCount'],
            'Set' => $validated['Set'],
            'Duration' => $validated['Duration'],
            'TrainingTips' => $validated['TrainingTips'],
            'RestBreak' =>4,// $validated['RestBreak'],
            'TransitionRest' => 4,//$validated['TransitionRest'],

        ]);

        return response()->json($Plane, 201);
    }




    public function update(Request $request, $planeId)
{

    $validated = $request->validate([
        'RepeatCount' => 'nullable',
        'Set' => 'nullable',
        'Duration' => 'nullable',
        'TrainingTips' => 'nullable',
        'RestBreak' => 'required',
        'TransitionRest' => 'required',
    ]);


    $Plane = Plane::find($planeId);
    if (!$Plane) {
        return response()->json(['message' => 'Plane not found'], 404);
    }


    $Plane->update([
        'RepeatCount' => $validated['RepeatCount'] ?? $Plane->RepeatCount,
        'Set' => $validated['Set'] ?? $Plane->Set,
        'Duration' => $validated['Duration'] ?? $Plane->Duration,
        'TrainingTips' => $validated['TrainingTips'] ?? $Plane->TrainingTips,
        'RestBreak' => $validated['RestBreak'],
        'TransitionRest' => $validated['TransitionRest'],
    ]);


    return response()->json($Plane, 200);
}


    public function index($PlaneId)
    {
        $Plane = Plane::with('excercise')->findOrFail($PlaneId);

        // Access the related Exercise directly
        // $excercise = $Plane->excercise;

        return response()->json($Plane);
    }

    public function getPlans($dailyExerciseId)
    {
        $dailyExercise = DailyExercise::find($dailyExerciseId);

        if (!$dailyExercise) {
            return response()->json(['message' => 'DailyExercise not found'], 404);
        }



        $Plane = $dailyExercise->Plane()->with('Excercise')->get();


        // $Plane = $dailyExercise->Plane()->get();
        $response = [
            'status' => 'success',
            'message' => 'Plans Getted successful',
            'total'=> count($Plane),
            'daystatus'=>$dailyExercise->status,
            'data' => $Plane,
        ];

        return response()->json($response);

       
    }


}

