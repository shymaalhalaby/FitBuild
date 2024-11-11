<?php
namespace App\Http\Controllers;

use App\Models\Gym;
use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if (!$token = auth()->attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $userId = auth()->id();
        $user = User::find($userId);

        if ($user->role == 'member') {
            return $this->createNewToken($token);
        }

        $coach = $user->coach;
        $nutritionist = $user->nutritionist;

        if ($user->role == 'Coach' && $coach && $coach->status == 0) {
            return response()->json(['message' => 'Your registration is pending'], 403);
        }

        if ($user->role == 'Nutritionist' && $nutritionist && $nutritionist->status == 0) {
            return response()->json(['message' => 'Your registration is pending'], 403);
        }

        return $this->createNewToken($token);
    }

    public function register(Request $request)
    {
        $request->merge(['role' => $request->input('role', 'member')]);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|confirmed|min:6',
            'role' => 'required|in:Coach,Nutritionist,member,gym',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $status = $request->role === 'member' ? 1 : 0;

        $user = User::create(
            array_merge(
                $validator->validated(),
                ['password' => bcrypt($request->password)],
                ['status' => $status]
            )
        );


        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user
        ], 201);
    }

    public function gymregister(Request $request)
    {
        $request->merge(['role' => $request->input('role', 'gym')]);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|confirmed|min:6',
            'role' => 'required|in:coach,nutritionist,member,gym',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user = User::create(
            array_merge(
                $validator->validated(),
                ['password' => bcrypt($request->password)],

            )
        );

        if ($request->role === 'gym') {
            Gym::create([
                'user_id' => $user->id,
                'id' => $user->id,
                'name' =>  $user->name ,
                'email' => $user->email ,
                'password' =>  $user->password ,

            ]);
        }

        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user
        ], 201);
    }



    public function completeGymRegister(Request $request, $userId)
    {
        $validator = Validator::make($request->all(), [
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

        $gym = Gym::where('user_id', $userId)->firstOrFail();

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
        } else {
            $data['logo_url'] = $gym->logo ? Storage::url($gym->logo) : null;
        }

        return response()->json([
            'message' => 'Gym profile updated successfully',
            'gym' => $gym,
            'logo_url' => $data['logo_url'],
        ]);
    }


    protected function createNewToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60,
            'user' => auth()->user(),
        ]);
    }
}



