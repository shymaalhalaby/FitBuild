<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\coach;
use App\Models\member;
use App\Models\coach_member;
use App\Models\Nutritionist;
use Illuminate\Http\Request;
use App\Models\member_nutritionist;
use Illuminate\Support\Facades\Auth;

class CoachMemberController extends Controller
{
    public function sendRequest($userId)
{
    $user = User::find($userId);

    if (!$user) {
        return response()->json(['error' => 'User not found'], 404);
    }

    $member = Auth::user()->member;

    if (strtolower($user->role) === 'coach') {
        $coach = Coach::where('user_id', $user->id)->first();

        if (!$coach) {
            return response()->json(['error' => 'Coach not found'], 404);
        }

        if (!$member->coaches->contains($coach->id)) {
            $member->coaches()->attach($coach->id, ['status' => 'pending']);
            return response()->json(['message' => 'Request sent successfully!'], 200);
        } else {
            return response()->json(['error' => 'You already have a pending request with this coach.'], 400);
        }
    } elseif (strtolower($user->role) === 'nutritionist') {
        $nutritionist = Nutritionist::where('user_id', $user->id)->first();

        if (!$nutritionist) {
            return response()->json(['error' => 'Nutritionist not found'], 404);
        }

        if (!$member->nutritionists->contains($nutritionist->id)) {
            $member->nutritionists()->attach($nutritionist->id, ['status' => 'pending']);
            return response()->json(['message' => 'Request sent successfully!'], 200);
        } else {
            return response()->json(['error' => 'You already have a pending request with this nutritionist.'], 400);
        }
    } else {
        return response()->json(['error' => 'Invalid user role'], 400);
    }
}

public function cancelRequest($userId)
{
    $member = Auth::user()->member;

    $user = User::find($userId);

    if (!$user) {
        return response()->json(['error' => 'User not found'], 404);
    }

    if (!$member) {
        return response()->json(['error' => 'Member not found'], 404);
    }

    if (strtolower($user->role) === 'coach') {
        $coach = Coach::where('user_id', $user->id)->first();

        if (!$coach) {
            return response()->json(['error' => 'Coach not found'], 404);
        }

        if ($member->coaches->contains($coach->id)) {
            $member->coaches()->detach($coach->id);
            return response()->json(['message' => 'Your request canceled successfully!'], 200);
        } else {
            return response()->json(['error' => 'No pending request found for this coach.'], 404);
        }
    } elseif (strtolower($user->role) === 'nutritionist') {
        $nutritionist = Nutritionist::where('user_id', $user->id)->first();

        if (!$nutritionist) {
            return response()->json(['error' => 'Nutritionist not found'], 404);
        }

        if ($member->nutritionists->contains($nutritionist->id)) {
            $member->nutritionists()->detach($nutritionist->id);
            return response()->json(['message' => 'Your request canceled successfully!'], 200);
        } else {
            return response()->json(['error' => 'No pending request found for this nutritionist.'], 404);
        }
    } else {
        return response()->json(['error' => 'Invalid user role'], 400);
    }
}




    public function showRequests()
    {
        $user = auth()->user();

        if ($user->role === 'coach') {
            $coach = Coach::where('user_id', $user->id)->firstOrFail();
            $requests = $coach->members()
                ->wherePivot('status', 'pending')
                ->select('members.id', 'members.name', 'coach_member.id as request_id')
                ->withPivot('status', 'id')
                ->get();

            $formattedRequests = $requests->map(function ($member) {
                return [
                    'memberId' => $member->id,
                    'name' => $member->name,
                    'request_id' => $member->pivot->id,
                ];
            });
        } elseif ($user->role === 'nutritionist') {
            $nutritionist = Nutritionist::where('user_id', $user->id)->firstOrFail();
            $requests = $nutritionist->members()
                ->wherePivot('status', 'pending')
                ->select('members.id', 'members.name', 'member_nutritionist.id as request_id')
                ->withPivot('status', 'id')
                ->get();

            $formattedRequests = $requests->map(function ($member) {
                return [
                    'id' => $member->id,
                    'name' => $member->name,
                    'request_id' => $member->pivot->id,
                ];
            });
        } else {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return response()->json($formattedRequests);
    }



    public function acceptRequest($id)
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json(['error' => 'No authenticated user'], 403);
        }

        if ($user->role === 'coach') {
            $data = coach_member::find($id);

            if (!$data) {
                return response()->json(['error' => 'Request not found'], 404);
            }

            $data->status = 'Accepted';
            $data->save();

        } elseif ($user->role === 'nutritionist') {
            $data = member_nutritionist::find($id);

            if (!$data) {
                return response()->json(['error' => 'Request not found'], 404);
            }

            $data->status = 'Accepted';
            $data->save();

        } else {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return response()->json(['message' => 'Request Accepted successfully!'], 200);
    }






    public function rejectRequest($id)
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json(['error' => 'No authenticated user'], 403);
        }

        if ($user->role === 'coach') {
            $data = coach_member::find($id);

            if (!$data) {
                return response()->json(['error' => 'Request not found'], 404);
            }

            $data->status = 'Rejected';
            $data->save();

        } elseif ($user->role === 'nutritionist') {
            $data = member_nutritionist::find($id);

            if (!$data) {
                return response()->json(['error' => 'Request not found'], 404);
            }

            $data->status = 'Rejected';
            $data->save();

        } else {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return response()->json(['message' => 'Request Rejected successfully!'], 200);
    }






    public function showSubscribers()
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json(['error' => 'No authenticated user'], 403);
        }

        if ($user->role === 'coach') {
            $coach = Coach::where('user_id', $user->id)->first();

            if (!$coach) {
                return response()->json(['error' => 'Coach not found'], 404);
            }

            $memberNames = $coach->members()
                ->wherePivot('status', 'Accepted')
                ->get(['user_id', 'name']);

            $memberData = $memberNames->map(function ($member) {
                return [
                    'memberId' => $member->pivot->member_id,
                    'name' => $member->name,
                ];
            });

        } elseif ($user->role === 'nutritionist') {
            $nutritionist = Nutritionist::where('user_id', $user->id)->first();

            if (!$nutritionist) {
                return response()->json(['error' => 'Nutritionist not found'], 404);
            }

            $memberNames = $nutritionist->members()
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

        } else {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return response()->json($memberData);
    }

}
