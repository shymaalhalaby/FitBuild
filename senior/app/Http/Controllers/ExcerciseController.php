<?php

namespace App\Http\Controllers;

use App\Models\Excercise;
use Illuminate\Http\Request;
use App\Http\Resources\ExcerciseResource;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\ExcerciseCollection;
class ExcerciseController extends Controller
{
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'video' => 'required|mimes:png,jpg,gif,jpeg,mp4',
            'name' => 'required',
            'description' => 'required',
            'TargetMuscles' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ]);
        }

        $vid = $request->video;
        $ext = $vid->getClientOriginalExtension();
        $ExcerciseName = time() . '.' . $ext;

        if (!$vid->move(public_path() . '/upload2', $ExcerciseName)) {
            return response()->json([
                'status' => false,
                'message' => 'File could not be saved',
            ]);
        }

        $Excercise = new Excercise; // Assuming you have an Excercise model linked to your database
        $Excercise->video = $ExcerciseName; // The filename
        $Excercise->name = $request->name; // Set the name field
        $Excercise->description = $request->description; // Set the description field
        $Excercise->TargetMuscles = $request->TargetMuscles; // Set the TargetMuscles field

        $Excercise->save(); // Save the record to the database

        return response()->json([
            'status' => true,
            'message' => 'File uploaded successfully',
            'path' => asset('/upload2/' . $ExcerciseName),
            'data' => $Excercise
        ]);
    }


    public function index(Request $request)
    {

        return new ExcerciseCollection(Excercise::all());

    }
    public function show(Request $request, Excercise $Excercise)
    {
        return new ExcerciseResource($Excercise);

    }

}
