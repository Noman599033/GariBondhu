@extends('layouts.public')

@section('content')
<div class="bg-light py-4 border-bottom mb-4 mt-4">
    <div class="container d-flex justify-content-between align-items-center">
        <div>
            <h2 class="fw-bold mb-0">My Dashboard</h2>
            <p class="text-muted mb-0">Welcome back, {{ auth()->user()->name ?? 'Customer' }}!</p>
        </div>
        <!-- Mobile Toggle Button -->
        <button class="btn btn-outline-primary d-md-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#customerSidebar" aria-controls="customerSidebar">
            <i class="bi bi-layout-sidebar"></i> Menu
        </button>
    </div>
</div>

<div class="container mb-5">
    <div class="row g-4">
        
        <!-- Sidebar Navigation (Desktop) / Offcanvas (Mobile) -->
        <div class="col-md-3">
            <div class="offcanvas-md offcanvas-start shadow-sm rounded-4 bg-white" tabindex="-1" id="customerSidebar" aria-labelledby="customerSidebarLabel">
                <div class="offcanvas-header border-bottom d-md-none">
                    <h5 class="offcanvas-title fw-bold" id="customerSidebarLabel">Dashboard Menu</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#customerSidebar" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body p-0">
                    <div class="list-group list-group-flush rounded-4 w-100">
                        <a href="{{ route('customer.dashboard') }}" class="list-group-item list-group-item-action fw-bold {{ request()->routeIs('customer.dashboard') ? 'active bg-primary text-white' : '' }} py-3">
                            <i class="bi bi-speedometer2 me-2"></i> Dashboard
                        </a>
                        <a href="{{ route('customer.bookings.index') }}" class="list-group-item list-group-item-action fw-bold {{ request()->routeIs('customer.bookings.*') ? 'active bg-primary text-white' : '' }} py-3">
                            <i class="bi bi-calendar-check me-2"></i> My Bookings
                        </a>
                        <a href="{{ route('customer.profile') }}" class="list-group-item list-group-item-action fw-bold {{ request()->routeIs('customer.profile') ? 'active bg-primary text-white' : '' }} py-3">
                            <i class="bi bi-person me-2"></i> Profile Settings
                        </a>
                        <form action="{{ route('customer.logout') }}" method="POST" class="list-group-item list-group-item-action border-top py-3">
                            @csrf
                            <button type="submit" class="btn btn-link text-danger text-decoration-none p-0 fw-bold w-100 text-start">
                                <i class="bi bi-box-arrow-right me-2"></i> Sign Out
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Sticky placeholder for desktop to keep layout clean -->
            <div class="d-none d-md-block position-sticky" style="top: 80px; height: 1px;"></div>
        </div>

        <!-- Main Content Area -->
        <div class="col-md-9">
            @yield('customer_content')
        </div>
    </div>
</div>
@endsection
