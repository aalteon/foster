<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index()
    {
        return Schedule::with(['user', 'wheel', 'animal'])->get();
    }

    public function store(Request $request)
    {
        return Schedule::create($request->all());
    }
}
