<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $activeBookings = Booking::where('user_id', $user->id)
            ->whereIn('booking_status', ['pending', 'confirmed', 'active'])
            ->count();
        $pastBookings = Booking::where('user_id', $user->id)
            ->whereIn('booking_status', ['completed', 'cancelled', 'rejected'])
            ->count();
        $recentBookings = Booking::with('car')
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();
        
        return view('customer.dashboard', compact('user', 'activeBookings', 'pastBookings', 'recentBookings'));
    }
}
