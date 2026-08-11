@extends('layouts.public')

@section('content')
<section class="hero-section text-center position-relative">
    <div class="container position-relative z-index-1">
        <h1 class="display-4 fw-bold mb-4 text-shadow" data-i18n="hero_title">Find Your Perfect Ride</h1>
        <p class="lead mb-5 fs-4 text-shadow" data-i18n="hero_subtitle">Premium cars for your journey. Book instantly and hit the road.</p>
        
        <!-- Vue Component for Search/Booking Widget -->
        <booking-widget :locations="{{ $locations->toJson() }}"></booking-widget>
    </div>
</section>

<div class="container my-5 py-4">
    <div class="text-center mb-5">
        <h2 class="fw-bold" data-i18n="feat_title">Our Featured Fleet</h2>
        <p class="text-muted" data-i18n="feat_subtitle">Choose from our premium selection of vehicles available for rent today.</p>
    </div>

    <div class="row g-4">
        @forelse($featuredCars as $car)
            <div class="col-md-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="bg-light p-0 text-center rounded-top border-bottom d-flex align-items-center justify-content-center overflow-hidden" style="height: 200px;">
                        @if($car->images && $car->images->count() > 0)
                            <img src="{{ $car->images->first()->image }}" class="w-100 h-100" alt="{{ $car->name }}" style="object-fit: cover;">
                        @else
                            <i class="bi bi-car-front text-muted" style="font-size: 5rem;"></i>
                        @endif
                    </div>
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h5 class="fw-bold mb-0">{{ $car->name }} {{ $car->model }}</h5>
                            <span class="badge bg-secondary">{{ $car->category->name ?? 'Car' }}</span>
                        </div>
                        <ul class="list-unstyled text-muted small mb-4 mt-3">
                            <li class="mb-2"><i class="bi bi-gear me-2"></i> {{ $car->transmission }}</li>
                            <li class="mb-2"><i class="bi bi-fuel-pump me-2"></i> {{ $car->fuel_type }}</li>
                            <li><i class="bi bi-people me-2"></i> {{ $car->seats ?? 4 }} <span data-i18n="feat_seats">Seats</span></li>
                        </ul>
                        <div class="d-flex justify-content-between align-items-center mt-auto pt-3 border-top">
                            <div>
                                @php 
                                    $rule = \App\Models\PricingRule::findBestMatch($car); 
                                    $hasCustom = !is_null($car->custom_daily_rate) || !is_null($car->custom_hourly_rate);
                                    
                                    $daily = !is_null($car->custom_daily_rate) ? $car->custom_daily_rate : ($rule ? $rule->daily_rate : 0);
                                    $hourly = !is_null($car->custom_hourly_rate) ? $car->custom_hourly_rate : ($rule ? $rule->hourly_rate : 0);
                                @endphp
                                <small class="text-muted d-block" style="font-size: 0.75rem;" data-i18n="feat_from">From</small>
                                <span class="fw-bold fs-5 text-primary">
                                    {{ $daily > 0 ? '৳' . number_format($daily, 0) : '-' }}
                                </span>
                                @if($daily > 0)
                                    <small class="text-muted" data-i18n="feat_day">/day</small>
                                @endif
                                
                                @if($hasCustom || $rule)
                                    <i class="bi bi-info-circle text-muted ms-1" style="cursor: pointer;" 
                                       title="Hourly: ৳{{ number_format($hourly, 0) }}&#10;Weekly: ৳{{ number_format($daily * 7, 0) }}&#10;Monthly: ৳{{ number_format($daily * 30, 0) }}"></i>
                                @endif
                            </div>
                            <a href="#booking-search-section" class="btn btn-outline-primary btn-sm fw-bold" data-i18n="feat_check_dates">Check Dates</a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center text-muted">
                <p data-i18n="feat_no_cars">No featured cars available right now.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Initialize tooltips
    document.addEventListener('DOMContentLoaded', function () {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    });

    app.component('booking-widget', {
        props: ['locations'],
        setup(props) {
            const rentalType = Vue.ref('daily');
            const pickupLocation = Vue.ref('');
            const dropoffLocation = Vue.ref('');
            const pickupDate = Vue.ref('');
            const returnDate = Vue.ref('');

            const searchCars = () => {
                if (pickupLocation.value && dropoffLocation.value && pickupDate.value && returnDate.value) {
                    // If daily/weekly/monthly is selected and it's just a date, we could append time.
                    // But API parse works fine with Y-m-d. Let's send as is.
                    const params = new URLSearchParams({
                        pickup_location_id: pickupLocation.value,
                        dropoff_location_id: dropoffLocation.value,
                        pickup_at: pickupDate.value,
                        return_at: returnDate.value,
                        rental_type: rentalType.value
                    });
                    window.location.href = `/search?${params.toString()}`;
                } else {
                    alert('Please fill in all search fields.');
                }
            };

            return {
                rentalType, pickupLocation, dropoffLocation, pickupDate, returnDate, searchCars,
                locations: props.locations
            }
        },
        template: `
            <div class="card bg-white p-4 mx-auto shadow-lg text-start" style="max-width: 1400px; border-radius: 15px;">
                <form @submit.prevent="searchCars" class="row g-3">
                    <div class="col-md-2">
                        <label class="form-label text-dark fw-bold">@{{ $t('search_basis') }}</label>
                        <select v-model="rentalType" class="form-select" required>
                            <option value="hourly">@{{ $t('search_hourly') }}</option>
                            <option value="daily">@{{ $t('search_daily') }}</option>
                            <option value="weekly">@{{ $t('search_weekly') }}</option>
                            <option value="monthly">@{{ $t('search_monthly') }}</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label text-dark fw-bold">@{{ $t('search_pickup_loc') }}</label>
                        <select v-model="pickupLocation" class="form-select" required>
                            <option value="">@{{ $t('search_select') }}</option>
                            <option v-for="loc in locations" :key="loc.id" :value="loc.id">@{{ loc.name }}</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label text-dark fw-bold">@{{ $t('search_dropoff_loc') }}</label>
                        <select v-model="dropoffLocation" class="form-select" required>
                            <option value="">@{{ $t('search_same_as_pickup') }}</option>
                            <option v-for="loc in locations" :key="loc.id" :value="loc.id">@{{ loc.name }}</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label text-dark fw-bold">@{{ $t('search_pickup_time') }}</label>
                        <input :type="rentalType === 'hourly' ? 'datetime-local' : 'date'" v-model="pickupDate" class="form-control" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label text-dark fw-bold">@{{ $t('search_return_time') }}</label>
                        <input :type="rentalType === 'hourly' ? 'datetime-local' : 'date'" v-model="returnDate" class="form-control" required>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100 fw-bold">@{{ $t('search_btn') }}</button>
                    </div>
                </form>
            </div>
        `
    });
</script>
@endpush
