@extends('layouts.public')

@section('content')
<div class="container my-5 text-center">
    
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0 rounded-4 p-5">
                
                <div class="mb-4">
                    <i class="bi bi-check-circle-fill text-success" style="font-size: 5rem;"></i>
                </div>
                
                <h2 class="fw-bold mb-3" data-i18n="success_title">Booking Confirmed!</h2>
                <p class="text-muted fs-5 mb-4" data-i18n="success_message">Thank you, {{ $booking->snapshot->customer_name ?? 'Guest' }}. Your rental request has been successfully received.</p>
                
                <div class="bg-light p-4 rounded-3 border mb-4 text-start d-inline-block mx-auto" style="min-width: 300px;">
                    <div class="text-center mb-3">
                        <div class="small fw-bold text-muted mb-1" data-i18n="success_booking_ref">BOOKING REFERENCE</div>
                        <div class="fs-3 fw-bold text-primary">{{ $booking->booking_number }}</div>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted" data-i18n="success_car">Car:</span>
                        <span class="fw-bold">{{ $booking->snapshot->car_name }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted" data-i18n="success_pickup">Pick-up:</span>
                        <span class="fw-bold">{{ \Carbon\Carbon::parse($booking->pickup_at)->format('M d, Y') }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted" data-i18n="success_status">Status:</span>
                        <span class="badge bg-warning text-dark px-3 py-2">{{ ucfirst($booking->booking_status) }}</span>
                    </div>
                </div>
                
                <p class="text-muted small mb-4">
                    <span data-i18n="success_email_sent">We have sent a confirmation email to</span> <strong>{{ $booking->snapshot->customer_email }}</strong>.<br>
                    <span data-i18n="success_agent_contact">An agent will review your request and contact you shortly regarding the payment link and next steps.</span>
                </p>
                
                <div>
                    <a href="{{ route('home') }}" class="btn btn-outline-primary px-4 fw-bold" data-i18n="success_back_home">Return Home</a>
                    <button class="btn btn-primary px-4 fw-bold ms-2" onclick="window.print()"><i class="bi bi-printer me-2"></i> <span data-i18n="success_print">Print Receipt</span></button>
                </div>
                
            </div>
        </div>
    </div>
    
</div>
@endsection
