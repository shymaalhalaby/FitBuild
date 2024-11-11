<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\coach;
use App\Models\CoachRequest;
use App\Models\Nutritionist;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\NutritionistRequest;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\coachResource;
use App\Http\Resources\coachCollection;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\updatecoacheRequest;
use App\Http\Resources\NutritionistResource;
use App\Http\Requests\updateNutritionistRequest;

class coachController extends Controller
{
    public function getFreelanceCoaches(): JsonResponse
    {
        $coaches = Coach::where('work_type', 'Freelance')
                        ->with('user.image')
                        ->get();

        Log::info('Loaded Freelance Coaches:', $coaches->toArray());

        $formattedCoaches = $coaches->map(function ($coach) {
            $user = $coach->user;

            Log::info('Coach Data:', $coach->toArray());
            Log::info('Associated User:', $user ? $user->toArray() : 'No user found');

            $imagePath = null;
            if ($user && $user->image) {
                $imagePath = Storage::url($user->image->image_path);
            }

            return [
                'id' => $coach->id,
                'name' => $coach->name,
                'user_id' => $user ? $user->id : null,
                'image_url' => $imagePath,
            ];
        });


        Log::info('Formatted Freelance Coaches:', $formattedCoaches->toArray());

        return response()->json($formattedCoaches);
    }


    public function showProfile($userId)
{
    $user = User::with(['image'])->find($userId);

    if (!$user) {
        return response()->json(['error' => 'User not found'], 404);
    }

    $imageUrl = $user->image ? Storage::url($user->image->image_path) : null;
    $cvUrl = $user->image ? Storage::url($user->image->cv_path) : null;

    $data = [
        'name' => $user->name,
        'email' => $user->email,
        'image_url' => $imageUrl, // Return the image URL
        'cv_url' => $cvUrl,       // Return the CV URL
    ];

    if (strtolower($user->role) === 'coach') {
        $coach = Coach::where('id', $user->id)->first();

        if (!$coach) {
            return response()->json(['error' => 'Coach profile not found'], 404);
        }

        $data = array_merge($data, [
            'WorkHours' => $coach->WorkHours,
            'Age' => $coach->Age,
            'gender' => $coach->gender,
            'phone_number' => $coach->phone_number,
            'training_price' => $coach->training_price,
            'work_type' => $coach->work_type,
        ]);
    } elseif (strtolower($user->role) === 'nutritionist') {
        $nutritionist = Nutritionist::where('id', $user->id)->first();

        if (!$nutritionist) {
            return response()->json(['error' => 'Nutritionist profile not found'], 404);
        }

        $data = array_merge($data, [
            'WorkHours' => $nutritionist->WorkHours,
            'Age' => $nutritionist->Age,
            'gender' => $nutritionist->gender,
            'phone_number' => $nutritionist->phone_number,
            'training_price' => $nutritionist->training_price,
            'work_type' => $nutritionist->work_type,
        ]);
    } else {
        return response()->json(['error' => 'User role not supported'], 400);
    }

    return response()->json($data);
}


public function showCoachProfile($coachId)
{
    $coach = Coach::with(['user.image', 'members:id,coach_id,name'])
                  ->where('id', $coachId)
                  ->first();

    if (!$coach) {
        return response()->json(['error' => 'Coach profile not found'], 404);
    }

    $user = $coach->user;
    $imagePath = null;
    if ($user && $user->image) {
        $imagePath = Storage::url($user->image->image_path);
    }

    $members = $coach->members->map(function ($member) {
        return [
            'id' => $member->id,
            'name' => $member->name,
        ];
    });

    $data = [
        'WorkHours' => $coach->WorkHours,
        'Age' => $coach->Age,
        'gender' => $coach->gender,
        'phone_number' => $coach->phone_number,
        'training_price' => $coach->training_price,
        'work_type' => $coach->work_type,
        'image_url' => $imagePath,
        'members' => $members,
    ];

    return response()->json($data);
}


public function showNutritionistProfile($NutritionistId)
{
    $Nutritionist = Nutritionist::with(['user.image', 'members:id,nutritionist_id,name'])
                  ->where('id', $NutritionistId)
                  ->first();

    if (!$Nutritionist) {
        return response()->json(['error' => 'Nutritionist profile not found'], 404);
    }

    $user = $Nutritionist->user;
    $imagePath = null;
    if ($user && $user->image) {
        $imagePath = Storage::url($user->image->image_path);
    }

    $members = $Nutritionist->members->map(function ($member) {
        return [
            'id' => $member->id,
            'name' => $member->name,
        ];
    });

    $data = [
        'WorkHours' => $Nutritionist->WorkHours,
        'Age' => $Nutritionist->Age,
        'gender' => $Nutritionist->gender,
        'phone_number' => $Nutritionist->phone_number,
        'training_price' => $Nutritionist->training_price,
        'work_type' => $Nutritionist->work_type,
        'image_url' => $imagePath,
        'members' => $members,
    ];

    return response()->json($data);
}









    public function profile(Request $request, $userId)
    {

        $commonRules = [
            'WorkHours' => 'required|string',
            'gender' => 'required|in:male,female',
            'phone_number' => 'required|string',
            'Age' => 'required|integer|min:0',
            'training_price' => 'required|string',
            'work_type' => 'required|in:Freelance,WithGym',
        ];


        $user = User::find($userId);
        if (!$user) {
            return response()->json(['error' => 'User not found'], 400);
        }


        $status = $request->work_type === 'Freelance' ? 0 : 1;


        $validated = $request->validate($commonRules);


        $validatedData = [
            'user_id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'password' => $user->password,
            'gender' => $validated['gender'],
            'phone_number' => $validated['phone_number'],
            'Age' => $validated['Age'],
            'WorkHours' => $validated['WorkHours'],
            'training_price' => $validated['training_price'],
            'work_type' => $validated['work_type'],
            'status' => $status,
        ];


        if ($user->role === 'Coach') {
            $coach = $user->coach;
            if ($coach) {
                $coach->update($validatedData);
            } else {
                $validatedData['id'] = $user->id;
                $coach = $user->coach()->create($validatedData);
            }
            return new CoachResource($coach);
        } elseif ($user->role === 'Nutritionist') {
            $nutritionist = $user->nutritionist;
            if ($nutritionist) {
                $nutritionist->update($validatedData);
            } else {
                $validatedData['id'] = $user->id;
                $nutritionist = $user->nutritionist()->create($validatedData);
            }
            return new NutritionistResource($nutritionist);
        } else {
            return response()->json(['error' => 'User role not supported'], 400);
        }
    }

    public function updateProfile(Request $request, $userId)
    {

        $commonRules = [
            'WorkHours' => 'required|string',
            'gender' => 'required|in:male,female',
            'phone_number' => 'required|string',
            'Age' => 'required|integer|min:0',
            'training_price' => 'required|string',
            'work_type' => 'required|in:Freelance,WithGym',
        ];


        $validated = $request->validate($commonRules);


        $user = User::find($userId);
        if (!$user) {
            return response()->json(['error' => 'User not found'], 400);
        }


        $status = $request->work_type === 'Freelance' ? 0 : 1;


        $validatedData = [
            'user_id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'password' => $user->password,
            'gender' => $validated['gender'],
            'phone_number' => $validated['phone_number'],
            'Age' => $validated['Age'],
            'WorkHours' => $validated['WorkHours'],
            'training_price' => $validated['training_price'],
            'work_type' => $validated['work_type'],
            'status' => $status,
        ];

        if ($user->role === 'coach') {
            $coach = $user->coach;
            if ($coach) {
                $coach->update($validatedData);
            } else {
                $coach = $user->coach()->create($validatedData);
            }
            return new CoachResource($coach);
        } elseif ($user->role === 'nutritionist') {
            $nutritionist = $user->nutritionist;
            if ($nutritionist) {
                $nutritionist->update($validatedData);
            } else {
                $nutritionist = $user->nutritionist()->create($validatedData);
            }
            return new NutritionistResource($nutritionist);
        } else {
            return response()->json(['error' => 'User role not supported'], 400);
        }
    }




    /**
     * Update the specified resource in storage.
     */
    public function update(updatecoacheRequest $request, coach $coach)
    {
        $validated = $request->validated();

        $coach->update($validated);

        return new coachResource($coach);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, coach $coach)
    {
        $coach->delete();

        return response(null, 204);
    }


}
