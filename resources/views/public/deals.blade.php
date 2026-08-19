@extends('layouts.public')

@section('content')
<div class="container py-5 mt-5">
    <div class="text-center mb-5">
        <h1 class="fw-bold text-dark" data-i18n="deals_title">Exclusive Deals</h1>
        <p class="text-muted" data-i18n="deals_subtitle">Save more on your next ride with these special offers.</p>
    </div>

    <div class="row g-4">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100">
                <div class="row g-0 h-100">
                    <div class="col-sm-5 bg-primary d-flex align-items-center justify-content-center text-white p-4">
                        <div class="text-center">
                            <h2 class="display-4 fw-bold mb-0">15%</h2>
                            <p class="mb-0 text-uppercase fw-bold" style="letter-spacing: 2px;">OFF</p>
                        </div>
                    </div>
                    <div class="col-sm-7 p-4 d-flex flex-column justify-content-center">
                        <h4 class="fw-bold mb-2" data-i18n="deal_1_title">Weekend Getaway</h4>
                        <p class="text-muted mb-4" data-i18n="deal_1_desc">Get 15% off on all SUV rentals for weekend trips.</p>
                        <div>
                            <a href="{{ route('search') }}" class="btn btn-outline-primary rounded-pill fw-bold" data-i18n="deal_1_btn">Book SUV</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100">
                <div class="row g-0 h-100">
                    <div class="col-sm-5 bg-accent d-flex align-items-center justify-content-center text-white p-4">
                        <div class="text-center">
                            <h2 class="display-4 fw-bold mb-0">20%</h2>
                            <p class="mb-0 text-uppercase fw-bold" style="letter-spacing: 2px;">OFF</p>
                        </div>
                    </div>
                    <div class="col-sm-7 p-4 d-flex flex-column justify-content-center">
                        <h4 class="fw-bold mb-2" data-i18n="deal_2_title">First Time User</h4>
                        <p class="text-muted mb-4" data-i18n="deal_2_desc">New to Gari Bondhu? Enjoy 20% off your first booking.</p>
                        <div>
                            <a href="{{ route('login') }}" class="btn btn-outline-primary rounded-pill fw-bold" data-i18n="deal_2_btn">Sign Up Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-dark text-white">
                <div class="row g-0">
                    <div class="col-md-8 p-5 d-flex flex-column justify-content-center">
                        <span class="badge bg-primary d-inline-block mb-3 align-self-start py-2 px-3 rounded-pill" data-i18n="deal_3_badge">Most Popular</span>
                        <h3 class="fw-bold mb-3" data-i18n="deal_3_title">Long Term Rental</h3>
                        <p class="mb-4 text-light opacity-75 fs-5" data-i18n="deal_3_desc">Rent for 7+ days and get 1 day absolutely free.</p>
                        <div>
                            <a href="{{ route('search') }}" class="btn btn-primary rounded-pill fw-bold px-4 py-2" data-i18n="deal_3_btn">View Cars</a>
                        </div>
                    </div>
                    <div class="col-md-4 bg-primary d-flex align-items-center justify-content-center p-4">
                        <div class="text-center text-white">
                            <h2 class="display-2 fw-bold mb-0">+1</h2>
                            <p class="mb-0 text-uppercase fw-bold fs-5">Day Free</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
