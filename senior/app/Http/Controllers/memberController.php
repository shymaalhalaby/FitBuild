<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\image;
use App\Models\member;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Resources\memberResource;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\memberCollection;
use App\Http\Requests\StorememberRequest;
use App\Http\Requests\updatememberRequest;
use Tymon\JWTAuth\Contracts\Providers\Auth;



class memberController extends Controller
{

    public function show($memberID)
    {
        $single = Member::with(['user', 'image', 'coach', 'nutritionist'])->where('id', $memberID)->first();

        if (!$single) {
            return response()->json(['error' => 'Member not found'], 404);
        }

        $imagePath = null;
        if ($single->image) {
            $imagePath = Storage::url($single->image->image_path);
        }

        $data = [
            'name' => $single->name,
            'email' => $single->email,
            'gender' => $single->gender,
            'coach_id' => $single->coach_id,
            'coach_name' => $single->coach ? $single->coach->name : null,
            'nutritionist_id' => $single->nutritionist_id,
            'nutritionist_name' => $single->nutritionist ? $single->nutritionist->name : null,
            'phone_number' => $single->phone_number,
            'age' => $single->Age,
            'Subscription_type' => $single->Subscription,
            'illness' => $single->illness,
            'goal' => $single->GOAL,
            'physical_case' => $single->Physical_case,
            'height' => $single->Hieght,
            'weight' => $single->Wieght,
            'target_weight' => $single->target_Wieght,
            'at' => $single->AT,
            'image_url' => $imagePath,
        ];

        return response()->json($data);
    }



    public function profile(Request $request, User $user)
    {

        $validated = $request->validate([

            'gender' => 'required|in:male,female',
            'phone_number' => 'required|string',
            'GOAL' => 'required|string',
            'AT' => 'required|in:Home,Gym',
            'Age' => 'required|integer|min:0',
            'illness' => 'nullable|string',
            'Physical_case' => 'nullable|string',
            'Subscription_type'=>'nullable|string',
            'Hieght' => 'required|numeric|min:0',
            'Wieght' => 'required|numeric|min:0',
            'target_Wieght' => 'required|numeric|min:0',
        ]);
        $userId = auth()->id();
        $user = User::find($userId);
        if (!$user) {
            return response()->json(['error' => 'User not found'], 400);
        }

        if ($user->role !== 'member') {
            return response()->json(['error' => 'User is not a member'], 400);
        }
        ;

        $validated = [
            'id' => $user->id,
            'user_id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'password' => $user->password,
            'gender' => $validated['gender'],
            'phone_number' => $validated['phone_number'],
            'Age' => $validated['Age'],
            'Subscription_type'=>$validated['Subscription_type'],
            'illness' => $validated['illness'],
            'Physical_case' => $validated['Physical_case'],
            'Hieght' => $validated['Hieght'],
            'Wieght' => $validated['Wieght'],
            'target_Wieght' => $validated['target_Wieght'],
            'GOAL' => $validated['GOAL'],
            'AT' => $validated['AT'],

        ];

        $member = $user->member()->create($validated);
        return new memberResource($member);

    }
    /**
     *
     */

    public function updateMemberProfile(Request $request)
    {
        $memberId = auth()->id();
        //$memberId = $user;
        $commonRules = [
            'name' => 'required|string',
            'password' => 'sometimes|required|string',
            'gender' => 'required|in:male,female',
            'phone_number' => 'required|string',
            'Subscription_type'=>'nullable',
            'GOAL' => 'required|string',
            'AT' => 'required|in:Home,Gym',
            'Age' => 'required|integer|min:0',
            'illness' => 'nullable|string',
            'Physical_case' => 'nullable|string',
            'Hieght' => 'required|numeric|min:0',
            'Wieght' => 'required|numeric|min:0',
            'target_Wieght' => 'required|numeric|min:0',
        ];

        $validated = $request->validate($commonRules);

        $member = Member::find($memberId);
        if (!$member) {
            return response()->json(['error' => 'Member not found'], 400);
        }

        $user = $member->user;

        if (!$user) {
            return response()->json(['error' => 'User not found'], 400);
        }

        if ($user->role !== 'member') {
            return response()->json(['error' => 'User is not a member'], 400);
        }

        $validatedData = [
            'name' => $validated['name'] ?? $user->name,
            'password' => $validated['password'] ?? $user->password,
            'gender' => $validated['gender'],
            'phone_number' => $validated['phone_number'],
            'GOAL' => $validated['GOAL'],
            'Subscription_type'=>$validated['subscription_type'],
            'AT' => $validated['AT'],
            'Age' => $validated['Age'],
            'illness' => $validated['illness'],
            'Physical_case' => $validated['Physical_case'],
            'Hieght' => $validated['Hieght'],
            'Wieght' => $validated['Wieght'],
            'target_Wieght' => $validated['target_Wieght'],
        ];


        $member->update($validatedData);

        return new MemberResource($member);
    }



    public function update(updatememberRequest $request, member $member)
    {
        $userId = auth()->id();
        $user = User::find($userId);
        $validated = $request->validated();

        $member->update($validated);
        return new memberResource($member);
    }
    /**
     *
     */
    public function destroy(member $member)
    {
        $member->delete();

        return response(null, 204);
    }
    public function indexspecific()
    {

        return member::all();

    }


}



