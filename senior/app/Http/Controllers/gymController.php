<?php

namespace App\Http\Controllers;

use App\Models\gym;
use App\Models\User;
use App\Models\CoachRequest;
use Illuminate\Http\Request;
use App\Models\AcceptedCoach;
use App\Models\MemberRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Models\NutritionistRequest;
use Illuminate\Support\Facades\Log;
use App\Models\AcceptedNutritionist;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Notifications\CoachRequestNotification;
use App\Notifications\MemberRequestNotification;
use App\Notifications\NutritionistRequestNotification;

class gymController extends Controller
{
    public function getCoachesByGym($gymId)
    {

        $coachRequests = CoachRequest::where('gym_id', $gymId)
                                     ->where('status', 'pending')
                                     ->with(['coach.user.image'])
                                     ->get();


        if ($coachRequests->isEmpty()) {
            return response()->json(['message' => 'No coaches found for the given gym ID with status pending'], 404);
        }


        $formattedCoaches = $coachRequests->map(function($request) {
            $coach = $request->coach;
            $user = $coach->user;


            Log::info('Coach Data:', $coach->toArray());
            Log::info('Associated User:', $user ? $user->toArray() : 'No user found');


            $imagePath = null;
            if ($user && $user->image) {
                $imagePath = Storage::url($user->image->image_path);
            }


            return [
                'RequestId' => $request->id,
                'coachId' => $coach->id,
                'name' => $coach->name,
                'email' => $coach->email,
                'created_at' => $coach->created_at,
                'image_url' => $imagePath,
            ];
        });


        Log::info('Formatted Coaches for Gym ID ' . $gymId . ':', $formattedCoaches->toArray());


        return response()->json([
            'message' => 'Coaches retrieved successfully',
            'data' => $formattedCoaches,
        ], 200);
    }





    public function getNutritionistsByGym($gymId)
    {

        $NutritionistRequests = NutritionistRequest::where('gym_id', $gymId)
                                     ->where('status', 'pending')
                                     ->with(['Nutritionist.user.image'])
                                     ->get();


        if ($NutritionistRequests->isEmpty()) {
            return response()->json(['message' => 'No Nutritionist found for the given gym ID with status pending'], 404);
        }


        $formattedNutritionists = $NutritionistRequests->map(function($request) {
            $Nutritionist = $request->Nutritionist;
            $user = $Nutritionist->user;


            Log::info('Nutritionist Data:', $Nutritionist->toArray());
            Log::info('Associated User:', $user ? $user->toArray() : 'No user found');


            $imagePath = null;
            if ($user && $user->image) {
                $imagePath = Storage::url($user->image->image_path);
            }


            return [
                'RequestId' => $request->id,
                'NutritionistId' => $Nutritionist->id,
                'name' => $Nutritionist->name,
                'email' => $Nutritionist->email,
                'created_at' => $Nutritionist->created_at,
                'image_url' => $imagePath,
            ];
        });


        Log::info('Formatted Nutritionists for Gym ID ' . $gymId . ':', $formattedNutritionists->toArray());


        return response()->json([
            'message' => 'Nutritionists retrieved successfully',
            'data' => $formattedNutritionists,
        ], 200);
    }

    public function getmembersByGym($gymId)
    {

        $memberRequests = memberRequest::where('gym_id', $gymId)
                                     ->where('status', 'pending')
                                     ->with(['member.image'])
                                     ->get();


        if ($memberRequests->isEmpty()) {
            return response()->json(['message' => 'No member found for the given gym ID with status pending'], 404);
        }


        $formattedmembers = $memberRequests->map(function($request) {
            $member = $request->member;
            $user = $member->user;


            Log::info('member Data:', $member->toArray());



            $imagePath = null;
            if ($member && $member->image) {
                $imagePath = Storage::url($member->image->image_path);
            }


            return [
                'RequestId' => $request->id,
                'memberId' => $member->id,
                'name' => $member->name,
                'email' => $member->email,
                'created_at' => $member->created_at,
                'image_url' => $imagePath,
            ];
        });


        Log::info('Formatted members for Gym ID ' . $gymId . ':', $formattedmembers->toArray());


        return response()->json([
            'message' => 'members retrieved successfully',
            'data' => $formattedmembers,
        ], 200);
    }

    public function getAcceptmembersByGym($gymId)
    {

        $memberRequests = memberRequest::where('gym_id', $gymId)
                                     ->where('status', 'Accept')
                                     ->with(['member.image'])
                                     ->get();


        if ($memberRequests->isEmpty()) {
            return response()->json(['message' => 'No member found for the given gym ID with status pending'], 404);
        }


        $formattedmembers = $memberRequests->map(function($request) {
            $member = $request->member;
            $user = $member->user;


            Log::info('member Data:', $member->toArray());



            $imagePath = null;
            if ($member && $member->image) {
                $imagePath = Storage::url($member->image->image_path);
            }


            return [
                'RequestId' => $request->id,
                'memberId' => $member->id,
                'name' => $member->name,
                'email' => $member->email,
                'created_at' => $member->created_at,
                'image_url' => $imagePath,
            ];
        });


        Log::info('Formatted members for Gym ID ' . $gymId . ':', $formattedmembers->toArray());


        return response()->json([
            'message' => 'members retrieved successfully',
            'data' => $formattedmembers,
        ], 200);
    }




    public function getAcceptedCoaches($gym_id)
    {
        // Start a database transaction
        DB::beginTransaction();


            // Fetch coach requests with accepted status and eager load relationships
            $coachRequests = CoachRequest::where('status', 'Accept')
                                         ->where('gym_id', $gym_id)
                                         ->with('coach.user.image')
                                         ->get();

            // Map the results to format the response
            $formattedCoaches = $coachRequests->map(function ($coachRequest) {
                $coach = $coachRequest->coach;
                $user = $coach->user;

                $imagePath = null;
                if ($user && $user->image) {
                    $imagePath = Storage::url($user->image->image_path);
                }

                return [
                    'id' => $coach->id,
                    'name' => $user ? $user->name : null,
                    'user_id' => $user ? $user->id : null,
                    'image_url' => $imagePath,
                ];
            });

            // Log the formatted coaches for debugging
            Log::info('Formatted Coaches:', $formattedCoaches->toArray());



            // Commit the transaction
            DB::commit();


            return response()->json($formattedCoaches);
        }


        public function getAcceptedNutritionist($gym_id)
        {
            // Start a database transaction
            DB::beginTransaction();


                // Fetch nutritionist requests with accepted status and eager load relationships
                $nutritionistRequests = NutritionistRequest::where('status', 'accept')
                                             ->where('gym_id', $gym_id)
                                             ->with('nutritionist.user.image')
                                             ->get();

                // Map the results to format the response
                $formattedNutritionists = $nutritionistRequests->map(function ($nutritionistRequest) {
                    $nutritionist = $nutritionistRequest->nutritionist;
                    $user = $nutritionist->user;

                    $imagePath = null;
                    if ($user && $user->image) {
                        $imagePath = Storage::url($user->image->image_path);
                    }

                    return [
                        'id' => $nutritionist->id,
                        'name' => $user ? $user->name : null,
                        'user_id' => $user ? $user->id : null,
                        'image_url' => $imagePath,
                    ];
                });

                // Log the formatted nutritionists for debugging
                Log::info('Formatted Nutritionists:', $formattedNutritionists->toArray());


                // Commit the transaction
                DB::commit();

                // Return the formatted nutritionists as JSON response
                return response()->json($formattedNutritionists);


            }


    public function RejectCoachRequest($RequestId)
    {

        $coachRequest = CoachRequest::find($RequestId);

        $coachRequest->status = 'Reject';
        $coachRequest->save();

        return response()->json([
            'message' => 'Coach request Rejected successfully',

        ], 200);
    }

    public function RejectNutritionistRequest($RequestId)
    {

        $NutritionistRequest = NutritionistRequest::find($RequestId);

        $NutritionistRequest->status = 'Reject';
        $NutritionistRequest->save();

        return response()->json([
            'message' => 'Nutritionist request Rejected successfully',

        ], 200);
    }

    public function RejectmemberRequest($RequestId)
    {

        $memberRequest = memberRequest::find($RequestId);

        $memberRequest->status = 'Reject';
        $memberRequest->save();

        return response()->json([
            'message' => 'member request Rejected successfully',

        ], 200);
    }





    public function AcceptNutritionistRequest($RequestId)
{

    $NutritionistRequest = NutritionistRequest::find($RequestId);

    $NutritionistRequest->status = 'Accept';
    $NutritionistRequest->save();

    return response()->json([
        'message' => 'Nutritionist request accepted successfully',

    ], 200);
}

public function AcceptmemberRequest($RequestId)
{

    $memberRequest = memberRequest::find($RequestId);

    $memberRequest->status = 'Accept';
    $memberRequest->save();

    return response()->json([
        'message' => 'member request accepted successfully',

    ], 200);
}


    public function AcceptCoachRequest($RequestId)
{

    $coachRequest = CoachRequest::find($RequestId);

    $coachRequest->status = 'Accept';
    $coachRequest->save();

    return response()->json([
        'message' => 'Coach request accepted successfully',

    ], 200);
}


    public function getAllAddresses()
    {
        $addresses = Gym::select('address')->distinct()->pluck('address');

        $addresses = Gym::pluck('address')->unique();

        return response()->json($addresses);
    }
    public function getGymsNamesAndAddress()
    {
        $gyms = Gym::select('name', 'address', 'id')
            ->orderBy('name')
            ->get();

        return response()->json($gyms);
    }

    public function update(Request $request, $gymId)
    {

        $gym = Gym::findOrFail($gymId);


        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|between:2,100',
            'email' => 'sometimes|required|string|email|max:100|unique:gyms,email,' . $gymId,
            'password' => 'sometimes|required|string|confirmed|min:6',
            'address' => 'sometimes|string',
            'logo' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'phone_number' => 'sometimes|string',
            'land_number' => 'sometimes|string',
            'description' => 'sometimes|string',
            'workhours_women' => 'sometimes|string',
            'workhours_men' => 'sometimes|string',
            'subscriptionprice_daily' => 'sometimes|string',
            'subscriptionprice_3days' => 'sometimes|string',
        ]);


        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }


        $data = $validator->validated();


        if ($request->hasFile('logo')) {

            if ($gym->logo) {
                Storage::disk('public')->delete($gym->logo);
            }

            $data['logo'] = $request->file('logo')->store('logos', 'public');
        }


        $gym->update($data);


        if (isset($data['logo'])) {
            $data['logo_url'] = Storage::url($data['logo']);
        }

        return response()->json([
            'message' => 'Gym profile updated successfully',
            'gym' => $gym,
            'logo_url' => $data['logo_url'] ?? $gym->logo ? Storage::url($gym->logo) : null,
        ]);
    }

    public function getGymProfile($gymId)
    {

        $gym = Gym::find($gymId);

        if (!$gym) {
            return response()->json(['message' => 'Gym not found'], 404);
        }


        $gymData = $gym->toArray();
        $gymData['logo_url'] = $gym->logo_url;

        return response()->json($gymData);
    }




    public function MemberSendRequestToGym(Request $request, $memberID, $gymId): JsonResponse
    {
        $validator = Validator::make(compact('memberID', 'gymId'), [
            'memberID' => 'required|exists:members,id',
            'gymId' => 'required|exists:gyms,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $existingRequest = MemberRequest::where('member_id', $memberID)
            ->where('gym_id', $gymId)
            ->first();

        if ($existingRequest) {
            return response()->json(['message' => 'You already sent a request to this gym'], 400);
        }

        $memberRequest = MemberRequest::create([
            'member_id' => $memberID,
            'gym_id' => $gymId,
            'status' => 'pending',
        ]);

        $gym = Gym::find($gymId);
        $gym->notify(new MemberRequestNotification($memberRequest));

        return response()->json(['message' => 'Request sent successfully'], 201);
    }

    public function cancleMemberRequest($memberID, $gymId): JsonResponse
    {

        $validator = Validator::make(compact('memberID', 'gymId'), [
            'memberID' => 'required|exists:members,id',
            'gymId' => 'required|exists:gyms,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }


        $MemberRequest = MemberRequest::where('member_id', $memberID)
            ->where('gym_id', $gymId)
            ->first();


        if ($MemberRequest) {
            $MemberRequest->delete();
            return response()->json(['message' => 'Your Request Cancle successfully'], 200);
        }
        return response()->json(['message' => ' request not found'], 404);
    }

    public function CNsendRequest(Request $request, $gymId): JsonResponse
{
    $userId = auth()->id();
    $user = User::find($userId);

    if (!$user) {
        return response()->json(['error' => 'User not found'], 400);
    }

    $validator = Validator::make(compact('userId', 'gymId'), [
        'userId' => 'required|exists:users,id',
        'gymId' => 'required|exists:gyms,id',
    ]);

    if ($validator->fails()) {
        return response()->json(['error' => $validator->errors()], 400);
    }

    if ($user->role === 'Coach') {

        $existingRequest = CoachRequest::where('coach_id', $userId)
            ->where('gym_id', $gymId)
            ->first();

        if ($existingRequest) {
            return response()->json(['message' => 'You Already Sent A Request To This Gym'], 400);
        }

        $coachRequest = CoachRequest::create([
            'coach_id' => $userId,
            'gym_id' => $gymId,
            'status' => 'pending',
            'hidden' => false,
        ]);

        $gym = Gym::find($gymId);
        $gym->notify(new CoachRequestNotification($coachRequest));

        return response()->json(['message' => 'Coach request sent successfully'], 201);

    } elseif ($user->role === 'Nutritionist') {

        $existingRequest = NutritionistRequest::where('nutritionist_id', $userId)
            ->where('gym_id', $gymId)
            ->first();

        if ($existingRequest) {
            return response()->json(['message' => 'You Already Sent A Request To This Gym'], 400);
        }

        $nutritionistRequest = NutritionistRequest::create([
            'nutritionist_id' => $userId,
            'gym_id' => $gymId,
            'status' => 'pending',
        ]);

        $gym = Gym::find($gymId);
        $gym->notify(new NutritionistRequestNotification($nutritionistRequest));

        return response()->json(['message' => 'Nutritionist request sent successfully'], 201);
    } else {
        return response()->json(['error' => 'User role not supported'], 400);
    }
}


    public function CNcancelRequest(Request $request, $gymId): JsonResponse
    {
        $userId = auth()->id();
        $user = User::find($userId);
        if (!$user) {
            return response()->json(['error' => 'User not found'], 400);
        }


        $validator = Validator::make(compact('userId', 'gymId'), [
            'userId' => 'required|exists:users,id',
            'gymId' => 'required|exists:gyms,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }


        if ($user->role === 'coach') {

            $coachRequest = CoachRequest::where('coach_id', $userId)
                ->where('gym_id', $gymId)
                ->first();

            if ($coachRequest) {
                $coachRequest->delete();
                return response()->json(['message' => 'Your request was canceled successfully'], 200);
            } else {
                return response()->json(['message' => 'Request not found'], 404);
            }
        } elseif ($user->role === 'nutritionist') {

            $nutritionistRequest = NutritionistRequest::where('nutritionist_id', $userId)
                ->where('gym_id', $gymId)
                ->first();

            if ($nutritionistRequest) {
                $nutritionistRequest->delete();
                return response()->json(['message' => 'Your request was canceled successfully'], 200);
            } else {
                return response()->json(['message' => 'Request not found'], 404);
            }
        } else {
            return response()->json(['error' => 'User role not supported'], 400);
        }
    }
}
