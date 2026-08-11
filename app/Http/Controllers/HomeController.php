<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Location;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $locations = Location::where('status', 'active')->get();
        $featuredCars = Car::with(['category'])->where('status', 'active')->take(6)->get();

        return view('public.home', compact('locations', 'featuredCars'));
    }
}
