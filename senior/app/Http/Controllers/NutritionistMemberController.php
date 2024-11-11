<?php

namespace App\Http\Controllers;

use App\Models\coach;
use App\Models\member;
use App\Models\Nutritionist;
use Illuminate\Http\Request;
use App\Models\member_nutritionist;
use Illuminate\Support\Facades\Auth;

class NutritionistMemberController extends Controller
{
    public function sendRequest($NutritionistId)
    {

        $member = Auth::user()->member;

        if (!$member->nutritionists->contains($NutritionistId)) {

            $member->nutritionists()->attach($NutritionistId, ['status' => 'pending']);

            return response()->json(['message' => 'Request sent successfully!'], 200);
        } else {
            return response()->json(['error' => 'You already have a pending request with this nutritionist.'], 400);
        }
    }



    public function cancleRequest($memberId, $NutritionistId)
    {

        $member = member::find($memberId);


        if ($member && $member->nutritionists->contains($NutritionistId)) {

            $member->nutritionists()->detach($NutritionistId);

            return response()->json(['message' => 'Your Request Cancle Successfully!'], 200);
        } else {
            return response()->json(['error' => 'No pending request found for this nutritionist.'], 404);
        }
    }


    public function AcceptRequest($id)
    {
        $data = member_nutritionist::find($id);
        $data->status = 'Accepted';
        $data->save();
        return response()->json(['message' => 'Request Accepted successfully!'], 200);

    }
    public function RejectRequest($id)
    {
        $data = member_nutritionist::find($id);
        $data->status = 'Rejected';
        $data->save();
        return response()->json(['message' => 'Request Rejected successfully!'], 200);
    }




    public function showsubscribers($NutritionistId)
    {
        $Nutritionist = Nutritionist::findOrFail($NutritionistId);
        $memberNames = $Nutritionist->members()
            ->wherePivot('status', 'accepted')
            ->select('members.id', 'members.name')
            ->withPivot('status', 'id')
            ->get();


        $memberData = $memberNames->map(function ($member) {
            return [
                'member_id' => $member->id,
                'name' => $member->name,
            ];
        });

        return response()->json($memberData);
    }
}
