@extends('layouts.public')

@section('content')
<div class="bg-light py-4 border-bottom">
    <div class="container">
        <h2 class="fw-bold mb-0" data-i18n="search_page_title">Search Fleet</h2>
    </div>
</div>

<div class="container my-5" id="search-app">
    <search-results 
        :locations="{{ $locations->toJson() }}" 
        :categories="{{ $categories->toJson() }}"
        :initial-params="{{ json_encode($initialParams) }}">
    </search-results>
</div>
@endsection

@push('scripts')
<script>
    app.component('search-results', {
        props: ['locations', 'categories', 'initialParams'],
        setup(props) {
            const isLoading = Vue.ref(false);
            const results = Vue.ref([]);
            const error = Vue.ref(null);

            // Form state
            const filters = Vue.reactive({
                rental_type: props.initialParams.rental_type || 'daily',
                pickup_location_id: props.initialParams.pickup_location_id || '',
                dropoff_location_id: props.initialParams.dropoff_location_id || '',
                pickup_at: props.initialParams.pickup_at || '',
                return_at: props.initialParams.return_at || '',
                category: '',
                transmission: '',
                price_max: 10000
            });

            const searchCars = async () => {
                if (!filters.pickup_location_id || !filters.dropoff_location_id || !filters.pickup_at || !filters.return_at) {
                    // Don't search if core params are missing
                    return;
                }

                isLoading.value = true;
                error.value = null;

                try {
                    const response = await axios.post('/api/search-cars', {
                        pickup_location_id: filters.pickup_location_id,
                        dropoff_location_id: filters.dropoff_location_id,
                        pickup_at: filters.pickup_at,
                        return_at: filters.return_at
                    });
                    
                    results.value = response.data.data;
                    // No external library tooltip initialization needed; native HTML title handles it
                } catch (err) {
                    error.value = err.response?.data?.message || 'Failed to fetch available cars.';
                    console.error(err);
                } finally {
                    isLoading.value = false;
                }
            };

            // Filter computed property for frontend filtering
            const filteredResults = Vue.computed(() => {
                return results.value.filter(car => {
                    // Match category if selected
                    // In a real app, API should probably return category_id and transmission in the response
                    // We'll simulate it for now assuming the API is expanded
                    return true;
                });
            });

            // Initial search if params exist
            Vue.onMounted(() => {
                if (filters.pickup_location_id && filters.pickup_at) {
                    searchCars();
                }
            });

            return {
                filters, locations: props.locations, categories: props.categories,
                searchCars, isLoading, results, error, filteredResults
            }
        },
        template: `
            <div class="row g-4">
                <!-- Sidebar Filters -->
                <div class="col-md-3">
                    <div class="card shadow-sm border-0 sticky-top" style="top: 100px; z-index: 1;">
                        <div class="card-body">
                            <h5 class="fw-bold mb-4">@{{ $t('search_modify') }}</h5>
                            
                            <form @submit.prevent="searchCars">
                                <div class="mb-3">
                                    <label class="form-label small fw-bold">@{{ $t('search_basis') }}</label>
                                    <select v-model="filters.rental_type" class="form-select form-select-sm" required>
                                        <option value="hourly">@{{ $t('search_hourly') }}</option>
                                        <option value="daily">@{{ $t('search_daily') }}</option>
                                        <option value="weekly">@{{ $t('search_weekly') }}</option>
                                        <option value="monthly">@{{ $t('search_monthly') }}</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label small fw-bold">@{{ $t('search_pickup_loc') }}</label>
                                    <select v-model="filters.pickup_location_id" class="form-select form-select-sm" required>
                                        <option value="">@{{ $t('search_select') }}</option>
                                        <option v-for="loc in locations" :key="loc.id" :value="loc.id">@{{ loc.name }}</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label small fw-bold">@{{ $t('search_dropoff_loc') }}</label>
                                    <select v-model="filters.dropoff_location_id" class="form-select form-select-sm" required>
                                        <option value="">@{{ $t('search_same_as_pickup') }}</option>
                                        <option v-for="loc in locations" :key="loc.id" :value="loc.id">@{{ loc.name }}</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label small fw-bold">@{{ $t('search_pickup_time') }}</label>
                                    <input :type="filters.rental_type === 'hourly' ? 'datetime-local' : 'date'" v-model="filters.pickup_at" class="form-control form-control-sm" required>
                                </div>
                                <div class="mb-4">
                                    <label class="form-label small fw-bold">@{{ $t('search_return_time') }}</label>
                                    <input :type="filters.rental_type === 'hourly' ? 'datetime-local' : 'date'" v-model="filters.return_at" class="form-control form-control-sm" required>
                                </div>
                                
                                <button type="submit" class="btn btn-primary w-100 btn-sm fw-bold">@{{ $t('search_update_btn') }}</button>
                            </form>
                            
                            <hr class="my-4">
                            
                            <h5 class="fw-bold mb-3">@{{ $t('search_filters') }}</h5>
                            
                            <!-- Categories (Frontend filtering placeholder) -->
                            <div class="mb-3">
                                <label class="form-label small fw-bold">@{{ $t('search_category') }}</label>
                                <select v-model="filters.category" class="form-select form-select-sm">
                                    <option value="">@{{ $t('search_all_categories') }}</option>
                                    <option v-for="cat in categories" :key="cat.id" :value="cat.id">@{{ cat.name }}</option>
                                </select>
                            </div>
                            
                            <!-- Transmission -->
                            <div class="mb-3">
                                <label class="form-label small fw-bold">@{{ $t('search_transmission') }}</label>
                                <select v-model="filters.transmission" class="form-select form-select-sm">
                                    <option value="">@{{ $t('search_any') }}</option>
                                    <option value="Automatic">@{{ $t('search_auto') }}</option>
                                    <option value="Manual">@{{ $t('search_manual') }}</option>
                                </select>
                            </div>
                            
                        </div>
                    </div>
                </div>

                <!-- Results Area -->
                <div class="col-md-9">
                    
                    <div v-if="error" class="alert alert-danger shadow-sm">
                        @{{ error }}
                    </div>

                    <div v-if="isLoading" class="text-center py-5">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">@{{ $t('search_loading') }}</span>
                        </div>
                        <p class="mt-2 text-muted">@{{ $t('search_searching') }}</p>
                    </div>

                    <div v-else-if="results.length === 0 && !error" class="text-center py-5 bg-white shadow-sm rounded border">
                        <i class="bi bi-car-front fs-1 text-muted"></i>
                        <h4 class="mt-3">@{{ $t('search_no_cars') }}</h4>
                        <p class="text-muted">@{{ $t('search_modify_dates') }}</p>
                    </div>

                    <div v-else class="row g-4">
                        <div v-for="car in filteredResults" :key="car.id" class="col-md-12">
                            <div class="card shadow-sm border-0 flex-md-row align-items-center">
                                <div class="col-md-4 p-3 text-center bg-light rounded-start h-100 d-flex align-items-center justify-content-center" style="min-height: 200px;">
                                    <img v-if="car.image" :src="car.image" class="img-fluid rounded" alt="Car Image" style="max-height: 160px; width: 100%; object-fit: cover;">
                                    <i v-else class="bi bi-car-front fs-1 text-muted"></i>
                                </div>
                                <div class="card-body col-md-8 p-4">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <div>
                                            <h4 class="card-title fw-bold mb-0">@{{ car.name }} @{{ car.model }}</h4>
                                            <p class="text-muted small mb-0">Automatic • Petrol • 4 Seats</p>
                                            
                                            <div class="mt-2" v-if="car.pricing.daily_rate > 0">
                                                <small class="text-muted d-block" style="font-size: 0.75rem;">@{{ $t('search_base_rate') }}</small>
                                                <span class="fw-bold fs-6 text-primary">৳@{{ car.pricing.daily_rate }}</span><small class="text-muted">@{{ $t('search_per_day') }}</small>
                                                <i class="bi bi-info-circle text-muted ms-1" style="cursor: pointer;" 
                                                   :title="'Hourly: ৳' + car.pricing.hourly_rate + '\\nWeekly: ৳' + (car.pricing.daily_rate * 7) + '\\nMonthly: ৳' + (car.pricing.daily_rate * 30)"></i>
                                            </div>
                                            <div class="mt-2" v-else>
                                                <span class="fw-bold fs-6 text-primary">-</span>
                                            </div>
                                        </div>
                                        <div class="text-end" v-if="car.pricing.daily_rate > 0">
                                            <div class="fs-4 fw-bold text-success">৳@{{ car.pricing.total_base_price }}</div>
                                            <small class="text-muted">@{{ $t('search_total_for') }} @{{ car.pricing.booked_days }}d @{{ car.pricing.booked_hours }}h</small>
                                        </div>
                                        <div class="text-end" v-else>
                                            <div class="fs-4 fw-bold text-success">-</div>
                                            <small class="text-muted">@{{ $t('search_pricing_unavailable') }}</small>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="small text-muted">
                                            <i class="bi bi-shield-check text-success me-1"></i> @{{ $t('search_security_deposit') }}: ৳@{{ car.pricing.security_deposit }}
                                        </div>
                                        <a :href="'/checkout?car_id='+car.id+'&pickup_location_id='+filters.pickup_location_id+'&dropoff_location_id='+filters.dropoff_location_id+'&pickup_at='+filters.pickup_at+'&return_at='+filters.return_at" class="btn btn-primary fw-bold px-4">@{{ $t('search_select_btn') }} <i class="bi bi-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        `
    });
</script>
@endpush
