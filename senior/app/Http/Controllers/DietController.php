<?php

namespace App\Http\Controllers;

use App\Models\diet;
use App\Models\week;
use App\Models\member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class DietController extends Controller
{
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'BreakFast1' => 'required|string',
            'BreakFast2'=> 'required|string',
            'BreakFast3'=> 'required|string',
            'BreakFast1_amount' => 'required|string',
            'BreakFast2_amount' => 'required|string',
            'BreakFast3_amount' => 'required|string',
            'snack1' => 'nullable|string',
            'Lunch1' => 'required|string',
            'Lunch2' => 'required|string',
            'Lunch1_amount' => 'required|string',
            'Lunch2_amount' => 'required|string',
            'snack2' => 'nullable|string',
            'Dinner1' => 'required|string',
            'Dinner2' => 'required|string',
            'Dinner1_amount' => 'required|string',
            'Dinner2_amount' => 'required|string',
            'totalcalories' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Create a new diet record
        $diet = diet::create($request->all());

        // Return the newly created diet record
        return response()->json($diet, 201);
    }
    public function createweek($memberId, $dietId)
    {

        $week = Week::create([
            'member_id' => $memberId,
            'diet_id' => $dietId,
        ]);

        return response()->json($week, 201);
    }



    public function getWeeksByMember()
    {
        $memberId=auth()->id();
        $member = Member::find($memberId);

        if (!$member) {
            return response()->json(['error' => 'Member not found'], 404);
        }

        // Load all week IDs associated with the member
        $weekIds = $member->weeks()->pluck('id');

        // Format the week IDs as desired
        $formattedWeekIds = $weekIds->map(function ($weekId) {
            return ['weekId' => $weekId];
        });

        return response()->json($formattedWeekIds, 200);
    }






    public function getDietByWeek($weekId)
    {
        // Find the week by ID
        $week = Week::find($weekId);

        if (!$week) {
            return response()->json(['error' => 'Week not found'], 404);
        }

        // Load the diet associated with the week
        $diet = $week->diet;

        if (!$diet) {
            return response()->json(['error' => 'Diet not found for this week'], 404);
        }

        return response()->json($diet, 200);
    }




    public function getDietById($diet_id)
    {
        // Find the diet record by diet_id
        $diet = Diet::find($diet_id);

        if (!$diet) {
            return response()->json(['message' => 'Diet not found'], 404);
        }

        return response()->json($diet);
    }

}
