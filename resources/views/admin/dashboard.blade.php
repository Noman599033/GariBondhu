@extends('admin.layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold" data-i18n="dash_overview">Dashboard Overview</h2>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card shadow-sm border-0 border-start border-primary border-4 h-100">
            <div class="card-body">
                <div class="text-muted small fw-bold mb-1" data-i18n="dash_total_bookings">TOTAL BOOKINGS</div>
                <div class="fs-2 fw-bold text-dark">{{ \App\Models\Booking::count() }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card shadow-sm border-0 border-start border-success border-4 h-100">
            <div class="card-body">
                <div class="text-muted small fw-bold mb-1" data-i18n="dash_active_rentals">ACTIVE RENTALS</div>
                <div class="fs-2 fw-bold text-dark">{{ \App\Models\Booking::where('booking_status', 'active')->count() }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card shadow-sm border-0 border-start border-info border-4 h-100">
            <div class="card-body">
                <div class="text-muted small fw-bold mb-1" data-i18n="dash_total_cars">TOTAL CARS</div>
                <div class="fs-2 fw-bold text-dark">{{ \App\Models\Car::count() }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card shadow-sm border-0 border-start border-warning border-4 h-100">
            <div class="card-body">
                <div class="text-muted small fw-bold mb-1" data-i18n="dash_pending_requests">PENDING REQUESTS</div>
                <div class="fs-2 fw-bold text-dark">{{ \App\Models\Booking::where('booking_status', 'pending')->count() }}</div>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm border-0">
    <div class="card-header bg-white fw-bold py-3">
        <span data-i18n="dash_recent_activity">Recent Activity</span>
    </div>
    <div class="card-body">
        <p class="text-muted mb-0" data-i18n="dash_welcome_msg">Welcome to the Gari Bondhu admin panel. Use the sidebar to manage your fleet and bookings.</p>
    </div>
</div>
@endsection
