@extends('layouts.public')

@section('content')
<!-- Hero Section -->
<section class="hero-section position-relative overflow-hidden" style="padding: 120px 0 80px 0; min-height: 80vh;">

    <!-- Abstract Background Elements -->
    <div class="position-absolute" style="top: -100px; left: -100px; width: 400px; height: 400px; background: rgba(26, 86, 219, 0.05); border-radius: 50%; filter: blur(40px);"></div>
    <div class="position-absolute" style="bottom: 100px; right: -50px; width: 300px; height: 300px; background: rgba(26, 86, 219, 0.08); border-radius: 50%; filter: blur(30px);"></div>

    <div class="container position-relative z-index-1">
        <div class="position-relative mb-5 py-4">
            <!-- Background Image Carousel -->
            <div id="heroBgCarousel" class="carousel slide carousel-fade position-absolute w-100 h-100 rounded-4 overflow-hidden" data-bs-ride="carousel" style="top: 0; left: 0; z-index: 0; opacity: 0.15; pointer-events: none;">
                <div class="carousel-inner h-100">
                    <div class="carousel-item active h-100">
                        <img src="{{ asset('images/1.jpg') }}" class="d-block w-100 h-100" style="object-fit: cover;" alt="Bg 1">
                    </div>
                    <div class="carousel-item h-100">
                        <img src="{{ asset('images/2.jpg') }}" class="d-block w-100 h-100" style="object-fit: cover;" alt="Bg 2">
                    </div>
                    <div class="carousel-item h-100">
                        <img src="{{ asset('images/3.jpg') }}" class="d-block w-100 h-100" style="object-fit: cover;" alt="Bg 3">
                    </div>
                    <div class="carousel-item h-100">
                        <img src="{{ asset('images/4.jpg') }}" class="d-block w-100 h-100" style="object-fit: cover;" alt="Bg 4">
                    </div>
                    <div class="carousel-item h-100">
                        <img src="{{ asset('images/5.jpg') }}" class="d-block w-100 h-100" style="object-fit: cover;" alt="Bg 5">
                    </div>
                </div>
            </div>

            <div class="position-relative z-index-1">
                <div class="text-center mb-5 mt-4">
                    <h1 class="display-3 fw-bold text-dark mb-4" style="letter-spacing: -1px;">
                        <span data-i18n="hero_title">Find Your Perfect Car</span><br>
                        <span class="text-accent" data-i18n="hero_subtitle_accent">Anytime, Anywhere.</span>
                    </h1>
                    <p class="lead text-muted mx-auto" style="max-width: 600px;" data-i18n="hero_desc">
                        Wide range of cars. Best prices. Easy booking. Your journey starts here.
                    </p>
                </div>
                
                <!-- Search Widget (Vue) -->
                <div class="position-relative z-index-2">
                    <booking-widget :locations="{{ $locations->toJson() }}"></booking-widget>
                </div>
            </div>
        </div>

        <!-- Hero Car Image -->
        <div class="text-center mt-4">
            <img src="{{ asset('images/premium-car-banner.jpg') }}" alt="Premium Car" class="img-fluid rounded-4 shadow-lg" style="max-height: 400px; object-fit: cover; width: 100%; max-width: 1000px;">
        </div>
    </div>
</section>

<!-- Features Strip -->
<div class="bg-white py-4 border-bottom">
    <div class="container">
        <div class="row g-4 text-center">
            <div class="col-6 col-md-3 d-flex align-items-center justify-content-center">
                <i class="bi bi-car-front fs-3 text-primary me-3"></i>
                <div class="text-start">
                    <h6 class="mb-0 fw-bold" data-i18n="feat_1_title">1000+ Cars</h6>
                    <small class="text-muted" data-i18n="feat_1_desc">Wide Range of Vehicles</small>
                </div>
            </div>
            <div class="col-6 col-md-3 d-flex align-items-center justify-content-center">
                <i class="bi bi-tag fs-3 text-primary me-3"></i>
                <div class="text-start">
                    <h6 class="mb-0 fw-bold" data-i18n="feat_2_title">Best Price</h6>
                    <small class="text-muted" data-i18n="feat_2_desc">Affordable & Transparent</small>
                </div>
            </div>
            <div class="col-6 col-md-3 d-flex align-items-center justify-content-center">
                <i class="bi bi-lightning fs-3 text-primary me-3"></i>
                <div class="text-start">
                    <h6 class="mb-0 fw-bold" data-i18n="feat_3_title">Easy Booking</h6>
                    <small class="text-muted" data-i18n="feat_3_desc">Quick & Simple Process</small>
                </div>
            </div>
            <div class="col-6 col-md-3 d-flex align-items-center justify-content-center">
                <i class="bi bi-headset fs-3 text-primary me-3"></i>
                <div class="text-start">
                    <h6 class="mb-0 fw-bold" data-i18n="feat_4_title">24/7 Support</h6>
                    <small class="text-muted" data-i18n="feat_4_desc">We are Always Here</small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Browse by Type -->
<section class="py-5 bg-light">
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-end mb-4">
            <h2 class="fw-bold mb-0" data-i18n="browse_type_title">Browse by Type</h2>
            <a href="{{ route('search') }}" class="btn btn-link text-primary text-decoration-none fw-bold"><span data-i18n="browse_type_link">View All Cars</span> <i class="bi bi-arrow-right"></i></a>
        </div>
        
        <div class="row g-4">
            <div class="col-6 col-md-2">
                <div class="card h-100 text-center border-0 shadow-sm p-3">
                    <i class="bi bi-car-front-fill text-muted mb-2" style="font-size: 2.5rem;"></i>
                    <h6 class="fw-bold mb-1" data-i18n="type_suv">SUV</h6>
                    <small class="text-muted">120+ Cars</small>
                </div>
            </div>
            <div class="col-6 col-md-2">
                <div class="card h-100 text-center border-0 shadow-sm p-3">
                    <i class="bi bi-car-front-fill text-muted mb-2" style="font-size: 2.5rem;"></i>
                    <h6 class="fw-bold mb-1" data-i18n="type_sedan">Sedan</h6>
                    <small class="text-muted">250+ Cars</small>
                </div>
            </div>
            <div class="col-6 col-md-2">
                <div class="card h-100 text-center border-0 shadow-sm p-3">
                    <i class="bi bi-car-front-fill text-muted mb-2" style="font-size: 2.5rem;"></i>
                    <h6 class="fw-bold mb-1" data-i18n="type_hatchback">Hatchback</h6>
                    <small class="text-muted">180+ Cars</small>
                </div>
            </div>
            <div class="col-6 col-md-2">
                <div class="card h-100 text-center border-0 shadow-sm p-3">
                    <i class="bi bi-car-front-fill text-muted mb-2" style="font-size: 2.5rem;"></i>
                    <h6 class="fw-bold mb-1" data-i18n="type_luxury">Luxury</h6>
                    <small class="text-muted">80+ Cars</small>
                </div>
            </div>
            <div class="col-6 col-md-2">
                <div class="card h-100 text-center border-0 shadow-sm p-3">
                    <i class="bi bi-car-front-fill text-muted mb-2" style="font-size: 2.5rem;"></i>
                    <h6 class="fw-bold mb-1" data-i18n="type_convertible">Convertible</h6>
                    <small class="text-muted">60+ Cars</small>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Special Offer Banner -->
<section class="py-5">
    <div class="container">
        <div class="rounded-4 p-5 d-flex align-items-center justify-content-between text-white" style="background: linear-gradient(135deg, var(--theme-color-dark), var(--bs-primary)); position: relative; overflow: hidden;">
            <div class="position-relative z-index-1" style="max-width: 400px;">
                <span class="badge bg-accent text-white mb-3 px-3 py-2 rounded-pill fw-bold" data-i18n="offer_badge">Special Offer</span>
                <h2 class="fw-bold display-5 mb-3" data-i18n="offer_title">Get 20% OFF</h2>
                <p class="fs-5 mb-4 opacity-75" data-i18n="offer_desc">On Your First Booking</p>
                <a href="{{ route('login') }}" class="btn btn-primary fw-bold px-4 py-2 rounded-pill" data-i18n="offer_btn">Book Now</a>
            </div>
            <div class="position-absolute end-0 bottom-0 z-index-0 d-none d-md-block" style="width: 50%;">
                <i class="bi bi-car-front-fill text-white opacity-25" style="font-size: 25rem; position: absolute; right: -50px; bottom: -100px;"></i>
            </div>
        </div>
    </div>
</section>

<!-- Why Choose Us? -->
<section class="py-5 bg-white border-top border-bottom">
    <div class="container py-4 text-center">
        <h2 class="fw-bold mb-5" data-i18n="why_title">Why Choose Gari Bondhu?</h2>
        <div class="row g-4">
            <div class="col-md-3">
                <div class="mb-3 d-inline-flex bg-primary text-white p-3 rounded-circle">
                    <i class="bi bi-cash-stack fs-4"></i>
                </div>
                <h6 class="fw-bold" data-i18n="why_1_title">No Hidden Charges</h6>
                <p class="text-muted small" data-i18n="why_1_desc">What you see is what you pay.</p>
            </div>
            <div class="col-md-3">
                <div class="mb-3 d-inline-flex bg-primary text-white p-3 rounded-circle">
                    <i class="bi bi-x-circle fs-4"></i>
                </div>
                <h6 class="fw-bold" data-i18n="why_2_title">Free Cancellation</h6>
                <p class="text-muted small" data-i18n="why_2_desc">Up to 24 hours before pick-up.</p>
            </div>
            <div class="col-md-3">
                <div class="mb-3 d-inline-flex bg-primary text-white p-3 rounded-circle">
                    <i class="bi bi-shield-fill fs-4"></i>
                </div>
                <h6 class="fw-bold" data-i18n="why_3_title">Clean & Safe Cars</h6>
                <p class="text-muted small" data-i18n="why_3_desc">Sanitized for your safety.</p>
            </div>
            <div class="col-md-3">
                <div class="mb-3 d-inline-flex bg-primary text-white p-3 rounded-circle">
                    <i class="bi bi-people-fill fs-4"></i>
                </div>
                <h6 class="fw-bold" data-i18n="why_4_title">Trusted by 10K+</h6>
                <p class="text-muted small" data-i18n="why_4_desc">Happy customers worldwide.</p>
            </div>
        </div>
    </div>
</section>

<!-- Reviews -->
<section class="py-5 bg-light">
    <div class="container py-4 text-center">
        <h2 class="fw-bold mb-5" data-i18n="reviews_title">Real Customer Reviews</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card h-100 p-4 border-0 shadow-sm text-start">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-secondary rounded-circle me-3" style="width: 50px; height: 50px;"></div>
                        <div>
                            <h6 class="fw-bold mb-0">Rasel Ahmed</h6>
                            <div class="text-warning small"><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i></div>
                        </div>
                    </div>
                    <p class="text-muted small" data-i18n="review_1">"Excellent service! The car was clean and in perfect condition. Highly recommended for trips out of Dhaka."</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 p-4 border-0 shadow-sm text-start">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-secondary rounded-circle me-3" style="width: 50px; height: 50px;"></div>
                        <div>
                            <h6 class="fw-bold mb-0">Nusrat Jahan</h6>
                            <div class="text-warning small"><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i></div>
                        </div>
                    </div>
                    <p class="text-muted small" data-i18n="review_2">"Easy booking process and friendly support team. Made my family trip very smooth."</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 p-4 border-0 shadow-sm text-start">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-secondary rounded-circle me-3" style="width: 50px; height: 50px;"></div>
                        <div>
                            <h6 class="fw-bold mb-0">Mahmudul Hasan</h6>
                            <div class="text-warning small"><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i></div>
                        </div>
                    </div>
                    <p class="text-muted small" data-i18n="review_3">"Best car rental service I've used so far. The prices are very competitive and transparent."</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Popular Cars -->
<section class="py-5">
    <div class="container py-4">
        <div class="text-center mb-5">
            <h2 class="fw-bold" data-i18n="pop_cars_title">Popular Cars for You</h2>
            <p class="text-muted" data-i18n="pop_cars_desc">Handpicked cars for your next adventure.</p>
        </div>

        <div class="row g-4">
            @forelse($featuredCars as $car)
                <div class="col-md-3">
                    <div class="card shadow-sm border-0 h-100 p-3">
                        <div class="text-center mb-3">
                            @if($car->images && $car->images->count() > 0)
                                <img src="{{ $car->images->first()->image }}" class="img-fluid rounded" alt="{{ $car->name }}" style="height: 120px; object-fit: contain;">
                            @else
                                <i class="bi bi-car-front text-muted" style="font-size: 5rem;"></i>
                            @endif
                        </div>
                        
                        <h6 class="fw-bold mb-1">{{ $car->name }} {{ $car->model }}</h6>
                        
                        @php 
                            $rule = \App\Models\PricingRule::findBestMatch($car); 
                            $daily = !is_null($car->custom_daily_rate) ? $car->custom_daily_rate : ($rule ? $rule->daily_rate : 0);
                        @endphp
                        
                        <div class="mb-3">
                            <span class="fw-bold text-primary">৳{{ number_format($daily, 0) }}</span>
                            <small class="text-muted" data-i18n="search_per_day">/day</small>
                        </div>
                        
                        <div class="d-flex justify-content-between text-muted small mt-auto border-top pt-2">
                            <span><i class="bi bi-people"></i> {{ $car->seats ?? 4 }}</span>
                            <span><i class="bi bi-gear"></i> {{ substr($car->transmission, 0, 1) }}</span>
                            <span><i class="bi bi-fuel-pump"></i> {{ substr($car->fuel_type, 0, 3) }}</span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center text-muted">
                    <p data-i18n="search_no_cars">No featured cars available right now.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- App Download -->
<section class="py-5 bg-light border-top">
    <div class="container">
        <div class="row align-items-center bg-white rounded-4 shadow-sm overflow-hidden border">
            <div class="col-md-6 p-5 text-center text-md-start">
                <h2 class="fw-bold mb-3" data-i18n="app_title">Download Gari Bondhu App For Exclusive Deals</h2>
                <p class="text-muted mb-4" data-i18n="app_desc">Get the best car rental experience right from your phone. Download our app and get an extra 20% off your first booking.</p>
                <div class="d-flex gap-3 justify-content-center justify-content-md-start">
                    <a href="#" class="btn btn-dark px-4 py-2 rounded-pill"><i class="bi bi-apple me-2"></i> App Store</a>
                    <a href="#" class="btn btn-dark px-4 py-2 rounded-pill"><i class="bi bi-google-play me-2"></i> Google Play</a>
                </div>
            </div>
            <div class="col-md-6 text-center position-relative d-none d-md-block" style="min-height: 300px;">
                 <i class="bi bi-phone text-primary opacity-25" style="font-size: 15rem; position: absolute; right: 20%; top: -20px;"></i>
                 <div class="position-absolute bg-accent text-white rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 80px; height: 80px; top: 20px; right: 10%; font-size: 1.2rem; transform: rotate(15deg);">20%<br>OFF</div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
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
            <div class="card bg-white p-3 mx-auto shadow-sm" style="max-width: 1000px; border-radius: 50px;">
                <form @submit.prevent="searchCars" class="row g-0 align-items-center px-3">
                    <div class="col-md px-2 border-end border-light d-none d-md-block">
                        <small class="text-muted d-block fw-bold mb-1" style="font-size: 0.75rem;">@{{ $t('search_basis') }}</small>
                        <select v-model="rentalType" class="form-select form-select-sm border-0 shadow-none px-0" style="background-color: transparent;" required>
                            <option value="daily">@{{ $t('search_daily') }}</option>
                            <option value="hourly">@{{ $t('search_hourly') }}</option>
                            <option value="weekly">@{{ $t('search_weekly') }}</option>
                            <option value="monthly">@{{ $t('search_monthly') }}</option>
                        </select>
                    </div>
                    <div class="col-md px-3 border-end border-light">
                        <small class="text-muted d-block fw-bold mb-1" style="font-size: 0.75rem;">@{{ $t('search_pickup_loc') }}</small>
                        <select v-model="pickupLocation" class="form-select form-select-sm border-0 shadow-none px-0" style="background-color: transparent;" required>
                            <option value="">@{{ $t('search_select') }}</option>
                            <option v-for="loc in locations" :key="loc.id" :value="loc.id">@{{ loc.name }}</option>
                        </select>
                    </div>
                    <div class="col-md px-3 border-end border-light">
                        <small class="text-muted d-block fw-bold mb-1" style="font-size: 0.75rem;">@{{ $t('search_dropoff_loc') }}</small>
                        <select v-model="dropoffLocation" class="form-select form-select-sm border-0 shadow-none px-0" style="background-color: transparent;" required>
                            <option value="">@{{ $t('search_same_as_pickup') }}</option>
                            <option v-for="loc in locations" :key="loc.id" :value="loc.id">@{{ loc.name }}</option>
                        </select>
                    </div>
                    <div class="col-md px-3 border-end border-light">
                        <small class="text-muted d-block fw-bold mb-1" style="font-size: 0.75rem;">@{{ $t('search_pickup_time') }}</small>
                        <input :type="rentalType === 'hourly' ? 'datetime-local' : 'date'" v-model="pickupDate" class="form-control form-control-sm border-0 shadow-none px-0" style="background-color: transparent;" required>
                    </div>
                    <div class="col-md px-3">
                        <small class="text-muted d-block fw-bold mb-1" style="font-size: 0.75rem;">@{{ $t('search_return_time') }}</small>
                        <input :type="rentalType === 'hourly' ? 'datetime-local' : 'date'" v-model="returnDate" class="form-control form-control-sm border-0 shadow-none px-0" style="background-color: transparent;" required>
                    </div>
                    <div class="col-md-auto ps-3 mt-3 mt-md-0">
                        <button type="submit" class="btn btn-primary rounded-pill px-4 py-2 w-100 fw-bold">@{{ $t('search_btn') }}</button>
                    </div>
                </form>
            </div>
        `
    });
</script>
@endpush
