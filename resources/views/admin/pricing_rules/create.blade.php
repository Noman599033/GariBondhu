@extends('admin.layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold" data-i18n="pr_add_title">Add New Pricing Rule</h2>
    <a href="{{ route('admin.settings.pricing_rules.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i> <span data-i18n="pr_back_to_list">Back to List</span></a>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body p-4">


        <form action="{{ route('admin.settings.pricing_rules.store') }}" method="POST">
            @csrf
            
            <h5 class="fw-bold mb-3 text-primary border-bottom pb-2" data-i18n="pr_rule_criteria">Rule Criteria</h5>
            <p class="text-muted small mb-4" data-i18n="pr_rule_criteria_desc">Leave fields empty if the rule should apply broadly (e.g. leave brand empty to apply to all brands in a category).</p>
            
            <div class="row g-4 mb-5">
                <div class="col-md-3">
                    <label class="form-label fw-bold" data-i18n="pr_category">Category</label>
                    <select name="category_id" class="form-select">
                        <option value="" data-i18n="pr_any_category">-- Any Category --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold" data-i18n="pr_brand">Brand</label>
                    <select name="brand_id" class="form-select">
                        <option value="" data-i18n="pr_any_brand">-- Any Brand --</option>
                        @foreach($brands as $brand)
                            <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold" data-i18n="pr_model_year">Model Year</label>
                    <input type="number" name="year" class="form-control" value="{{ old('year') }}" data-i18n-placeholder="pr_year_placeholder" placeholder="e.g. 2024">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold" data-i18n="pr_seats">Seats</label>
                    <input type="number" name="seats" class="form-control" value="{{ old('seats') }}" data-i18n-placeholder="pr_seats_placeholder" placeholder="e.g. 4">
                </div>
            </div>

            <h5 class="fw-bold mb-3 text-primary border-bottom pb-2" data-i18n="pr_rates_setup">Rates Setup</h5>
            <div class="row g-4 mb-4">
                <div class="col-md-4">
                    <label class="form-label fw-bold" data-i18n="pr_hourly_rate">Hourly Rate (৳)</label>
                    <input type="number" name="hourly_rate" class="form-control" value="{{ old('hourly_rate', 0) }}" step="0.01" min="0" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold" data-i18n="pr_daily_rate">Daily Rate (৳)</label>
                    <input type="number" name="daily_rate" class="form-control" value="{{ old('daily_rate', 0) }}" step="0.01" min="0" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold text-danger" data-i18n="pr_penalty_rate">Hourly Penalty Rate (৳)</label>
                    <input type="number" name="hourly_penalty" class="form-control border-danger" value="{{ old('hourly_penalty', 0) }}" step="0.01" min="0" required>
                    <small class="text-muted" data-i18n="pr_penalty_desc">Charged for each hour late.</small>
                </div>
            </div>

            <div class="row g-4 mb-4">
                <div class="col-md-4">
                    <label class="form-label fw-bold" data-i18n="pr_status">Status</label>
                    <select name="status" class="form-select" required>
                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }} data-i18n="pr_status_active">Active</option>
                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }} data-i18n="pr_status_inactive">Inactive</option>
                    </select>
                </div>
            </div>

            <hr class="my-4">
            
            <div class="text-end">
                <button type="submit" class="btn btn-primary px-4 fw-bold" data-i18n="pr_save_btn">Save Pricing Rule</button>
            </div>
        </form>
    </div>
</div>
@endsection
