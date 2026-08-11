<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class CustomerController extends Controller
{
    public function index()
    {
        // Simple listing of all users
        $customers = User::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.customers.index', compact('customers'));
    }

    public function show($id)
    {
        $customer = User::with(['bookings' => function($q) {
            $q->orderBy('created_at', 'desc');
        }, 'bookings.car', 'bookings.payments'])->findOrFail($id);
        
        return view('admin.customers.show', compact('customer'));
    }
}
