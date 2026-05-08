<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WheelController extends Controller
{
    public function index()
    {
        return Wheel::with('users')->get();
    }

    public function store(Request $request)
    {
        return Wheel::create($request->all());
    }

    public function show($id)
    {
        return Wheel::with('users', 'schedules')->findOrFail($id);
    }
}
