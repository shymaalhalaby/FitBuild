<?php

namespace App\Http\Controllers;

use App\Models\Dinner;
use Illuminate\Http\Request;

class DinnerController extends Controller
{
    public function index()
    {
        $Dinners = Dinner::all();

        // Return as a JSON response
        return response()->json($Dinners);

}
}
