@extends('admin.layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold" data-i18n="pr_title">Pricing Rules</h2>
    <a href="{{ route('admin.settings.pricing_rules.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i> <span data-i18n="pr_add_btn">Add New Rule</span></a>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body">
        <form action="{{ route('admin.settings.pricing_rules.index') }}" method="GET" class="mb-4">
            <div class="input-group" style="max-width: 400px;">
                <input type="text" name="search" class="form-control" data-i18n-placeholder="pr_search_placeholder" placeholder="Search by category or brand..." value="{{ $search ?? '' }}">
                <button class="btn btn-primary" type="submit"><i class="bi bi-search"></i></button>
                @if(isset($search) && $search !== '')
                    <a href="{{ route('admin.settings.pricing_rules.index') }}" class="btn btn-outline-secondary" data-i18n="pr_clear">Clear</a>
                @endif
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th data-i18n="pr_th_criteria">Criteria</th>
                        <th data-i18n="pr_th_hourly">Hourly Rate</th>
                        <th data-i18n="pr_th_daily">Daily Rate</th>
                        <th data-i18n="pr_th_penalty">Penalty/Hr</th>
                        <th data-i18n="pr_th_status">Status</th>
                        <th class="text-end" data-i18n="pr_th_actions">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($rules as $rule)
                    <tr>
                        <td>
                            @if(!$rule->category_id && !$rule->brand_id && !$rule->year && !$rule->seats)
                                <span class="badge bg-secondary" data-i18n="pr_global_default">Global Default (All Cars)</span>
                            @else
                                @if($rule->category_id) <span class="badge bg-info text-dark"><span data-i18n="pr_criteria_cat">Category</span>: {{ $rule->category->name }}</span> @endif
                                @if($rule->brand_id) <span class="badge bg-primary"><span data-i18n="pr_criteria_brand">Brand</span>: {{ $rule->brand->name }}</span> @endif
                                @if($rule->year) <span class="badge bg-dark"><span data-i18n="pr_criteria_year">Year</span>: {{ $rule->year }}</span> @endif
                                @if($rule->seats) <span class="badge bg-secondary"><span data-i18n="pr_criteria_seats">Seats</span>: {{ $rule->seats }}</span> @endif
                            @endif
                        </td>
                        <td class="fw-bold text-success">৳{{ number_format($rule->hourly_rate, 2) }}</td>
                        <td class="fw-bold text-success">৳{{ number_format($rule->daily_rate, 2) }}</td>
                        <td class="fw-bold text-danger">৳{{ number_format($rule->hourly_penalty, 2) }}</td>
                        <td>
                            @if($rule->status === 'active')
                                <span class="badge bg-success" data-i18n="pr_status_active">Active</span>
                            @else
                                <span class="badge bg-warning text-dark" data-i18n="pr_status_inactive">Inactive</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <a href="{{ route('admin.settings.pricing_rules.edit', $rule) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('admin.settings.pricing_rules.destroy', $rule) }}" method="POST" class="d-inline delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted" data-i18n="pr_no_rules">No pricing rules found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-4">
            {{ $rules->links() }}
        </div>
    </div>
</div>
@endsection
