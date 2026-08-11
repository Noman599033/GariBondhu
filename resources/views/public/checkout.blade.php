@extends('layouts.public')

@section('content')
<div class="bg-light py-4 border-bottom mb-5">
    <div class="container">
        <h2 class="fw-bold mb-0" data-i18n="checkout_title">Secure Checkout</h2>
    </div>
</div>

<div class="container mb-5">
    <form action="{{ route('checkout.store') }}" method="POST">
        @csrf
        <input type="hidden" name="car_id" value="{{ $car->id }}">
        <input type="hidden" name="pickup_location_id" value="{{ $pickupLocation->id }}">
        <input type="hidden" name="dropoff_location_id" value="{{ $dropoffLocation->id }}">
        <input type="hidden" name="pickup_at" value="{{ $pickupAt }}">
        <input type="hidden" name="return_at" value="{{ $returnAt }}">

        <div class="row g-4">
            <!-- Left Column: Customer Details -->
            <div class="col-md-8">
                
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white fw-bold py-3 fs-5">
                        <i class="bi bi-person-badge text-primary me-2"></i> <span data-i18n="checkout_renter_details">Renter Details</span>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label fw-bold small"><span data-i18n="checkout_full_name">Full Name</span> <span class="text-danger">*</span></label>
                                <input type="text" name="customer_name" class="form-control @error('customer_name') is-invalid @enderror" value="{{ old('customer_name', auth()->guard('web')->user()->name ?? '') }}" required>
                                @error('customer_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small"><span data-i18n="checkout_email">Email Address</span> <span class="text-danger">*</span></label>
                                <input type="email" name="customer_email" class="form-control @error('customer_email') is-invalid @enderror" value="{{ old('customer_email', auth()->guard('web')->user()->email ?? '') }}" required>
                                @error('customer_email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small"><span data-i18n="checkout_phone">Phone Number</span> <span class="text-danger">*</span></label>
                                <input type="text" name="customer_phone" class="form-control @error('customer_phone') is-invalid @enderror" value="{{ old('customer_phone', auth()->guard('web')->user()->phone ?? '') }}" required placeholder="e.g. +880 1712-345678">
                                @error('customer_phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm border-0 bg-light">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-3"><i class="bi bi-shield-lock text-success me-2"></i> <span data-i18n="checkout_payment_info">Payment Information</span></h5>
                        <p class="text-muted mb-0" data-i18n="checkout_payment_desc">For this demo, no upfront payment is required. You will receive an invoice after confirmation to complete your payment.</p>
                    </div>
                </div>

            </div>

            <!-- Right Column: Booking Summary -->
            <div class="col-md-4">
                <div class="card shadow-sm border-0 sticky-top" style="top: 100px;">
                    <div class="card-header bg-white fw-bold py-3 fs-5">
                        <span data-i18n="checkout_rental_summary">Rental Summary</span>
                    </div>
                    <div class="card-body p-0">
                        <div class="p-4 bg-light text-center border-bottom">
                            <h4 class="fw-bold mb-0">{{ $car->name }} {{ $car->model }}</h4>
                            <div class="text-muted small mt-1">{{ $car->category->name ?? 'Car' }} • {{ $car->transmission }}</div>
                        </div>
                        
                        <div class="p-4 border-bottom">
                            <div class="mb-3">
                                <div class="small fw-bold text-muted mb-1" data-i18n="checkout_pickup">PICK-UP</div>
                                <div class="fw-bold">{{ \Carbon\Carbon::parse($pickupAt)->format('D, M j, Y') }}</div>
                                <div class="small">{{ $pickupLocation->name }}</div>
                            </div>
                            <div>
                                <div class="small fw-bold text-muted mb-1" data-i18n="checkout_dropoff">DROP-OFF</div>
                                <div class="fw-bold">{{ \Carbon\Carbon::parse($returnAt)->format('D, M j, Y') }}</div>
                                <div class="small">{{ $dropoffLocation->name }}</div>
                            </div>
                        </div>

                        <div class="p-4 bg-light">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted" data-i18n="checkout_rental_duration">Rental Duration</span>
                                <span class="fw-bold">{{ $pricing['booked_days'] }}d {{ $pricing['booked_hours'] }}h</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted" data-i18n="checkout_base_rate">Base Rate</span>
                                <span class="fw-bold">৳{{ number_format($pricing['total_base_price'], 2) }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <span class="text-muted" data-i18n="checkout_security_deposit">Security Deposit</span>
                                <span class="fw-bold text-muted">৳{{ number_format($pricing['security_deposit'], 2) }}</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <span class="fs-5 fw-bold" data-i18n="checkout_total_due">Total Due</span>
                                <span class="fs-4 fw-bold text-primary">৳{{ number_format($pricing['total_amount'], 2) }}</span>
                            </div>
                        </div>
                        
                        <div class="p-4">
                            <button type="submit" class="btn btn-primary w-100 fw-bold fs-5 py-2" data-i18n="checkout_confirm">Confirm Booking</button>
                            <div class="text-center mt-3">
                                <small class="text-muted"><i class="bi bi-lock-fill me-1"></i> <span data-i18n="checkout_secure_info">Your information is secure</span></small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
