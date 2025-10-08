<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Plano;

class HomeController extends Controller
{
    public function index()
    {
        $plans = Plano::all();
        return view('home', compact('plans'));
    }
}
