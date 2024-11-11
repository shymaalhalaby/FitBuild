<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\UserImage;
use App\Models\CoachImage;
use Illuminate\Http\Request;
use App\Models\NutritionistImage;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function storeUserImage($userId, Request $request)
{
    $request->validate([
        'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'cv' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    $imagePath = null;
    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('images', 'public');
    }

    $cvPath = null;
    if ($request->hasFile('cv')) {
        $cvPath = $request->file('cv')->store('images', 'public');
    }

    $userImage = new UserImage();
    $userImage->user_id = $userId;
    $userImage->image_path = $imagePath;
    $userImage->cv_path = $cvPath;
    $userImage->save();

    $imageUrl = $imagePath ? Storage::url($imagePath) : null;
    $cvUrl = $cvPath ? Storage::url($cvPath) : null;

    return response()->json(['message' => 'Files uploaded successfully', 'data' => ['image' => $userImage, 'image_url' => $imageUrl, 'cv_url' => $cvUrl]], 201);
}



    public function store($memberID, Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);


        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');


            $image = new Image();
            $image->member_id = $memberID;
            $image->image_path = $imagePath;
            $image->save();

            $imageUrl = Storage::url($imagePath);
            return response()->json(['message' => 'Image uploaded successfully', 'data' => ['url' => $imageUrl]], 201);
        }

        return response()->json(['error' => 'Image upload failed'], 500);
    }
}

