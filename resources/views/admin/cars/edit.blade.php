@extends('admin.layouts.app')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.cars.index') }}" class="text-decoration-none text-muted"><i class="bi bi-arrow-left me-1"></i> <span data-i18n="cars_back_to_fleet">Back to Fleet</span></a>
    <h2 class="fw-bold mt-2"><span data-i18n="cars_edit_title">Edit Car</span>: {{ $car->name }} {{ $car->model }}</h2>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body p-4">
        <form action="{{ route('admin.cars.update', $car) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="row g-4">
                <!-- Basic Info -->
                <div class="col-md-6">
                    <h5 class="fw-bold mb-3" data-i18n="cars_basic_info">Basic Information</h5>
                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold"><span data-i18n="cars_car_name">Car Name</span> <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $car->name) }}" required>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold" data-i18n="cars_car_image">Car Image</label>
                        @if($car->images->where('is_primary', true)->first())
                            <div class="mb-2">
                                <img src="{{ $car->images->where('is_primary', true)->first()->image }}" alt="Current Image" class="img-thumbnail" style="max-height: 100px;">
                            </div>
                        @endif
                        <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                        @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        <small class="text-muted" data-i18n="cars_upload_new_img">Upload a new image to replace the current one.</small>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold"><span data-i18n="cars_model">Model</span> <span class="text-danger">*</span></label>
                            <input type="text" name="model" class="form-control @error('model') is-invalid @enderror" value="{{ old('model', $car->model) }}" required>
                            @error('model') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold"><span data-i18n="cars_year">Year</span> <span class="text-danger">*</span></label>
                            <input type="number" name="year" class="form-control @error('year') is-invalid @enderror" value="{{ old('year', $car->year) }}" required>
                            @error('year') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold" data-i18n="cars_registration">Registration Number</label>
                        <input type="text" class="form-control text-uppercase" value="{{ $car->registration_number }}" disabled>
                        <small class="text-muted" data-i18n="cars_reg_cannot_change">Registration number cannot be changed after creation.</small>
                    </div>
                </div>
                
                <!-- Classification & Specs -->
                <div class="col-md-6">
                    <h5 class="fw-bold mb-3" data-i18n="cars_status_options">Status & Options</h5>
                    
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label fw-semibold"><span data-i18n="cars_status">Status</span> <span class="text-danger">*</span></label>
                            <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                                <option value="active" {{ old('status', $car->status) == 'active' ? 'selected' : '' }} data-i18n="cars_status_active">Active</option>
                                <option value="inactive" {{ old('status', $car->status) == 'inactive' ? 'selected' : '' }} data-i18n="cars_status_inactive">Inactive</option>
                                <option value="retired" {{ old('status', $car->status) == 'retired' ? 'selected' : '' }} data-i18n="cars_status_retired">Retired</option>
                            </select>
                            @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="alert alert-info mt-3">
                        <i class="bi bi-info-circle-fill me-2"></i> <span data-i18n="cars_contact_admin_edit">To change specs, categories, or brands, please contact database administration, as this may affect historical bookings.</span>
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
                            <input type="number" step="0.01" name="custom_daily_rate" class="form-control @error('custom_daily_rate') is-invalid @enderror" value="{{ old('custom_daily_rate', $car->custom_daily_rate) }}" data-i18n-placeholder="cars_leave_blank_auto" placeholder="Leave blank for auto">
                            @error('custom_daily_rate') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-4 mb-3 mb-md-0">
                            <label class="form-label fw-semibold" data-i18n="cars_custom_hourly">Custom Hourly Rate (৳)</label>
                            <input type="number" step="0.01" name="custom_hourly_rate" class="form-control @error('custom_hourly_rate') is-invalid @enderror" value="{{ old('custom_hourly_rate', $car->custom_hourly_rate) }}" data-i18n-placeholder="cars_leave_blank_auto" placeholder="Leave blank for auto">
                            @error('custom_hourly_rate') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold" data-i18n="cars_custom_penalty">Custom Hourly Penalty (৳)</label>
                            <input type="number" step="0.01" name="custom_hourly_penalty" class="form-control @error('custom_hourly_penalty') is-invalid @enderror" value="{{ old('custom_hourly_penalty', $car->custom_hourly_penalty) }}" data-i18n-placeholder="cars_leave_blank_auto" placeholder="Leave blank for auto">
                            @error('custom_hourly_penalty') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>
            </div>
            
            <hr class="my-4">
            
            <div class="d-flex justify-content-end">
                <a href="{{ route('admin.cars.index') }}" class="btn btn-light me-2" data-i18n="cars_cancel_btn">Cancel</a>
                <button type="submit" class="btn btn-primary px-4 fw-bold" data-i18n="cars_update_btn">Update Car</button>
            </div>
            
        </form>
    </div>
</div>
@endsection
