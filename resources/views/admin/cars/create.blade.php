@extends('admin.layouts.app')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.cars.index') }}" class="text-decoration-none text-muted"><i class="bi bi-arrow-left me-1"></i> <span data-i18n="cars_back_to_fleet">Back to Fleet</span></a>
    <h2 class="fw-bold mt-2" data-i18n="cars_add_new_title">Add New Car</h2>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body p-4">
        <form action="{{ route('admin.cars.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="row g-4">
                <!-- Basic Info -->
                <div class="col-md-6">
                    <h5 class="fw-bold mb-3" data-i18n="cars_basic_info">Basic Information</h5>
                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold"><span data-i18n="cars_car_name">Car Name</span> <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required data-i18n-placeholder="cars_name_placeholder" placeholder="e.g. Toyota Corolla">
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold" data-i18n="cars_car_image">Car Image</label>
                        <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                        @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold"><span data-i18n="cars_model">Model</span> <span class="text-danger">*</span></label>
                            <input type="text" name="model" class="form-control @error('model') is-invalid @enderror" value="{{ old('model') }}" required data-i18n-placeholder="cars_model_placeholder" placeholder="e.g. XLI">
                            @error('model') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold"><span data-i18n="cars_year">Year</span> <span class="text-danger">*</span></label>
                            <input type="number" name="year" class="form-control @error('year') is-invalid @enderror" value="{{ old('year', date('Y')) }}" required>
                            @error('year') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold"><span data-i18n="cars_registration">Registration Number</span> <span class="text-danger">*</span></label>
                        <input type="text" name="registration_number" class="form-control text-uppercase @error('registration_number') is-invalid @enderror" value="{{ old('registration_number') }}" required data-i18n-placeholder="cars_reg_placeholder" placeholder="e.g. DHK-12-3456">
                        @error('registration_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
                
                <!-- Classification & Specs -->
                <div class="col-md-6">
                    <h5 class="fw-bold mb-3" data-i18n="cars_specifications">Specifications</h5>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold"><span data-i18n="cars_category">Category</span> <span class="text-danger">*</span></label>
                            <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                                <option value="" data-i18n="cars_select_category">Select Category...</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold"><span data-i18n="cars_brand">Brand</span> <span class="text-danger">*</span></label>
                            <select name="brand_id" class="form-select @error('brand_id') is-invalid @enderror" required>
                                <option value="" data-i18n="cars_select_brand">Select Brand...</option>
                                @foreach($brands as $brand)
                                    <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                                @endforeach
                            </select>
                            @error('brand_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold" data-i18n="cars_transmission">Transmission</label>
                            <select name="transmission" class="form-select">
                                <option value="Automatic" {{ old('transmission') == 'Automatic' ? 'selected' : '' }} data-i18n="cars_auto">Automatic</option>
                                <option value="Manual" {{ old('transmission') == 'Manual' ? 'selected' : '' }} data-i18n="cars_manual">Manual</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold" data-i18n="cars_fuel_type">Fuel Type</label>
                            <select name="fuel_type" class="form-select">
                                <option value="Petrol" {{ old('fuel_type') == 'Petrol' ? 'selected' : '' }} data-i18n="cars_fuel_petrol">Petrol</option>
                                <option value="Diesel" {{ old('fuel_type') == 'Diesel' ? 'selected' : '' }} data-i18n="cars_fuel_diesel">Diesel</option>
                                <option value="Hybrid" {{ old('fuel_type') == 'Hybrid' ? 'selected' : '' }} data-i18n="cars_fuel_hybrid">Hybrid</option>
                                <option value="Electric" {{ old('fuel_type') == 'Electric' ? 'selected' : '' }} data-i18n="cars_fuel_electric">Electric</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold" data-i18n="cars_seats">Seats</label>
                            <input type="number" name="seats" class="form-control" value="{{ old('seats', 4) }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold" data-i18n="cars_doors">Doors</label>
                            <input type="number" name="doors" class="form-control" value="{{ old('doors', 4) }}">
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold" data-i18n="cars_security_deposit">Security Deposit (৳)</label>
                            <input type="number" step="0.01" name="security_deposit_amount" class="form-control @error('security_deposit_amount') is-invalid @enderror" value="{{ old('security_deposit_amount', 0) }}">
                            @error('security_deposit_amount') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold" data-i18n="cars_status">Status</label>
                            <select name="status" class="form-select">
                                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }} data-i18n="cars_status_active">Active</option>
                                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }} data-i18n="cars_status_inactive">Inactive</option>
                                <option value="retired" {{ old('status') == 'retired' ? 'selected' : '' }} data-i18n="cars_status_retired">Retired</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            
            <hr class="my-4">

            <!-- Custom Pricing Override -->
            <div class="row mb-4">
                <div class="col-12">
                    <h5 class="fw-bold mb-3 text-primary"><i class="bi bi-tag me-2"></i><span data-i18n="cars_custom_pricing_title">Custom Pricing Override (Optional)</span></h5>
                    <p class="text-muted small mb-3" data-i18n="cars_custom_pricing_desc">If you leave these fields empty, the car will be priced automatically based on Global Pricing Rules (Settings > Pricing Rules).</p>
                    
                    <div class="row bg-light p-3 rounded border border-primary border-opacity-25">
                        <div class="col-md-4 mb-3 mb-md-0">
                            <label class="form-label fw-semibold" data-i18n="cars_custom_daily">Custom Daily Rate (৳)</label>
                            <input type="number" step="0.01" name="custom_daily_rate" class="form-control @error('custom_daily_rate') is-invalid @enderror" value="{{ old('custom_daily_rate') }}" data-i18n-placeholder="cars_leave_blank_auto" placeholder="Leave blank for auto">
                            @error('custom_daily_rate') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-4 mb-3 mb-md-0">
                            <label class="form-label fw-semibold" data-i18n="cars_custom_hourly">Custom Hourly Rate (৳)</label>
                            <input type="number" step="0.01" name="custom_hourly_rate" class="form-control @error('custom_hourly_rate') is-invalid @enderror" value="{{ old('custom_hourly_rate') }}" data-i18n-placeholder="cars_leave_blank_auto" placeholder="Leave blank for auto">
                            @error('custom_hourly_rate') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold" data-i18n="cars_custom_penalty">Custom Hourly Penalty (৳)</label>
                            <input type="number" step="0.01" name="custom_hourly_penalty" class="form-control @error('custom_hourly_penalty') is-invalid @enderror" value="{{ old('custom_hourly_penalty') }}" data-i18n-placeholder="cars_leave_blank_auto" placeholder="Leave blank for auto">
                            @error('custom_hourly_penalty') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>
            </div>
            
            <hr class="my-4">
            
            <div class="d-flex justify-content-end">
                <button type="reset" class="btn btn-light me-2" data-i18n="cars_clear_btn">Clear</button>
                <button type="submit" class="btn btn-primary px-4 fw-bold" data-i18n="cars_save_btn">Save Car</button>
            </div>
            
        </form>
    </div>
</div>
@endsection
