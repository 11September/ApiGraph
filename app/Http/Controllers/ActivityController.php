<?php

namespace App\Http\Controllers;

use App\Activity;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function index()
    {
        $activities = Activity::all();

        return response()->json(['data' => $activities], 200);
    }

    public function activities()
    {
        $activities = Activity::all();

        return view('activities', compact('activities'));
    }
}
