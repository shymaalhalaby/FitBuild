<?php

namespace App\Http\Controllers;

use App\Models\BreakFast;
use Illuminate\Http\Request;

class BreakFastController extends Controller
{
    public function index()
    {
        $breakFasts = BreakFast::all();

        return response()->json($breakFasts);

}}
