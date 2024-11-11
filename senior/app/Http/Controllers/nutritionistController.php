<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Nutritionist;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\NutritionistRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Tymon\JWTAuth\Contracts\Providers\Auth;
use App\Http\Resources\NutritionistResource;
use App\Http\Requests\updateNutritionistRequest;

class nutritionistController extends Controller
{
    public function getFreelanceNutritionists(): JsonResponse
    {

        $nutritionists = Nutritionist::where('work_type', 'Freelance')
                                     ->with('user.image')
                                     ->get();


        Log::info('Loaded Freelance Nutritionists:', $nutritionists->toArray());

        $formattedNutritionists = $nutritionists->map(function ($nutritionist) {

            $user = $nutritionist->user;


            Log::info('Nutritionist Data:', $nutritionist->toArray());
            Log::info('Associated User:', $user ? $user->toArray() : 'No user found');

            $imagePath = null;
            if ($user && $user->image) {
                $imagePath = Storage::url($user->image->image_path);
            }
            return [
                'id' => $nutritionist->id,
                'name' => $nutritionist->name,
                'user_id' => $user ? $user->id : null,
                'image_url' => $imagePath,
            ];
        });


        Log::info('Formatted Freelance Nutritionists:', $formattedNutritionists->toArray());

        return response()->json($formattedNutritionists);
    }



    /**
     * Store a newly created resource in storage.
     */


    /**
     * Update the specified resource in storage.
     */
    public function update(updateNutritionistRequest $request, Nutritionist $Nutritionist)
    {
        $validated = $request->validated();

        $Nutritionist->update($validated);

        return new NutritionistResource($Nutritionist);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Nutritionist $Nutritionist)
    {
        $Nutritionist->delete();

        return response(null, 204);
    }


}

