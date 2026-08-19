@extends('layouts.public')

@section('content')
<div class="container py-5 mt-5">
    <div class="text-center mb-5">
        <h1 class="fw-bold text-dark" data-i18n="services_title">Premium Services</h1>
        <p class="text-muted" data-i18n="services_subtitle">Tailored to meet your specific travel needs.</p>
    </div>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm p-4 text-center">
                <i class="bi bi-car-front fs-1 text-primary mb-3"></i>
                <h5 class="fw-bold" data-i18n="srv_1_title">Self-Drive Cars</h5>
                <p class="text-muted" data-i18n="srv_1_desc">Enjoy the freedom of the road with our well-maintained self-drive cars.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm p-4 text-center">
                <i class="bi bi-person-badge fs-1 text-primary mb-3"></i>
                <h5 class="fw-bold" data-i18n="srv_2_title">Chauffeur Driven</h5>
                <p class="text-muted" data-i18n="srv_2_desc">Relax while our professional drivers take you to your destination safely.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm p-4 text-center">
                <i class="bi bi-airplane fs-1 text-primary mb-3"></i>
                <h5 class="fw-bold" data-i18n="srv_3_title">Airport Transfer</h5>
                <p class="text-muted" data-i18n="srv_3_desc">Timely and comfortable airport pick-up and drop-off services.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm p-4 text-center">
                <i class="bi bi-stars fs-1 text-primary mb-3"></i>
                <h5 class="fw-bold" data-i18n="srv_4_title">Wedding Cars</h5>
                <p class="text-muted" data-i18n="srv_4_desc">Make your special day memorable with our luxury wedding car collection.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm p-4 text-center">
                <i class="bi bi-briefcase fs-1 text-primary mb-3"></i>
                <h5 class="fw-bold" data-i18n="srv_5_title">Corporate Rentals</h5>
                <p class="text-muted" data-i18n="srv_5_desc">Reliable transport solutions for businesses and corporate events.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm p-4 text-center">
                <i class="bi bi-calendar-check fs-1 text-primary mb-3"></i>
                <h5 class="fw-bold" data-i18n="srv_6_title">Long-Term Leasing</h5>
                <p class="text-muted" data-i18n="srv_6_desc">Cost-effective long-term car leasing options with full maintenance.</p>
            </div>
        </div>
    </div>
</div>
@endsection
