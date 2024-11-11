<?php

namespace App\Http\Controllers;

use App\Models\member;
use App\Models\MonthlyPlan;
use Illuminate\Http\Request;
use App\Models\DailyExercise;
use App\Http\Resources\DailyExerciseResource;
use App\Http\Requests\StoreDailyExerciseRequest;

class DailyExerciseController extends Controller
{
    public function store(request $request,member $member)
    {
        $validated = $request->validate([
            'title' => 'required',
        ]);

        $dailyExercise = DailyExercise::create([
            'member_id' => $member->id,
           'title' => $validated['title'],

        ]);

        return response()->json($dailyExercise, 201);
    }
    public function finish(request $request,member $member,$day)
    {
        $dailyExercise = DailyExercise::find($day);
        $data = DailyExercise::find($day);
        $data->status = 1;
        $data->save();
        return response()->json(['message' => 'Day Done successfully!'], 200);
    }
    public function getByMember($memberId)
    {

        $member = Member::with('DailyExercise')->find($memberId);

        if (!$member) {
            return response()->json(['message' => 'DailyExercise not found'], 404);
        }
        //$dailyexersizes=DailyExercise::->get();


       // return response()->json($dailyexersizes);
         return response()->json($member->DailyExercise);
    }
}
