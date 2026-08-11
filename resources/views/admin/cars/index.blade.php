@extends('admin.layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold" data-i18n="cars_fleet_mgmt">Fleet Management</h2>
    <a href="{{ route('admin.cars.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i> <span data-i18n="cars_add_new">Add New Car</span></a>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body">
        <form action="{{ route('admin.cars.index') }}" method="GET" class="mb-4">
            <div class="input-group" style="max-width: 400px;">
                <input type="text" name="search" class="form-control" data-i18n-placeholder="cars_search_placeholder" placeholder="Search by name, model, registration..." value="{{ $search ?? '' }}">
                <button class="btn btn-primary" type="submit"><i class="bi bi-search"></i></button>
                @if(isset($search) && $search !== '')
                    <a href="{{ route('admin.cars.index') }}" class="btn btn-outline-secondary" data-i18n="cars_clear">Clear</a>
                @endif
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th data-i18n="cars_th_name">Name</th>
                        <th data-i18n="cars_th_model_year">Model / Year</th>
                        <th data-i18n="cars_th_registration">Registration</th>
                        <th data-i18n="cars_th_category">Category</th>
                        <th data-i18n="cars_th_status">Status</th>
                        <th class="text-end" data-i18n="cars_th_actions">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($cars as $car)
                    <tr>
                        <td>{{ $car->id }}</td>
                        <td class="fw-bold">
                            @php
                                $primaryImage = $car->images->where('is_primary', true)->first();
                            @endphp
                            @if($primaryImage)
                                <img src="{{ $primaryImage->image }}" alt="{{ $car->name }}" class="rounded-circle me-2" style="width: 32px; height: 32px; object-fit: cover;">
                            @else
                                <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-light text-muted me-2" style="width: 32px; height: 32px;">
                                    <i class="bi bi-car-front"></i>
                                </div>
                            @endif
                            {{ $car->name }}
                        </td>
                        <td>{{ $car->model }} <span class="badge bg-secondary ms-1">{{ $car->year }}</span></td>
                        <td><span class="text-uppercase">{{ $car->registration_number }}</span></td>
                        <td>{{ $car->category->name ?? 'N/A' }}</td>
                        <td>
                            @if($car->status === 'active')
                                <span class="badge bg-success" data-i18n="cars_status_active">Active</span>
                            @elseif($car->status === 'inactive')
                                <span class="badge bg-warning text-dark" data-i18n="cars_status_inactive">Inactive</span>
                            @else
                                <span class="badge bg-danger" data-i18n="cars_status_retired">Retired</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <a href="{{ route('admin.cars.edit', $car) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('admin.cars.destroy', $car) }}" method="POST" class="d-inline delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted" data-i18n="cars_no_cars">No cars found in the fleet. Click "Add New Car" to get started.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-4">
            {{ $cars->links() }}
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.querySelector('input[name="search"]');
        const form = searchInput.closest('form');
        const tableContainer = document.querySelector('.table-responsive');
        const paginationContainer = document.querySelector('.mt-4');

        let debounceTimer;

        searchInput.addEventListener('input', function() {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => {
                const url = new URL(form.action);
                url.searchParams.set('search', this.value);

                fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    
                    const newTable = doc.querySelector('.table-responsive');
                    const newPagination = doc.querySelector('.mt-4');
                    
                    if (newTable) tableContainer.innerHTML = newTable.innerHTML;
                    if (newPagination) paginationContainer.innerHTML = newPagination.innerHTML;
                    
                    // Update URL without reloading
                    window.history.pushState({}, '', url);
                });
            }, 300);
        });
    });
</script>
@endpush
