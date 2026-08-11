@extends('admin.layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold" data-i18n="cust_title">Customers</h2>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body p-0 table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th class="ps-4" data-i18n="cust_th_id">ID</th>
                    <th data-i18n="cust_th_name">Name</th>
                    <th data-i18n="cust_th_email">Email</th>
                    <th data-i18n="cust_th_phone">Phone</th>
                    <th data-i18n="cust_th_joined">Joined</th>
                    <th class="pe-4 text-end" data-i18n="cust_th_action">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($customers as $customer)
                    <tr>
                        <td class="ps-4">#{{ $customer->id }}</td>
                        <td>
                            <div class="fw-bold">{{ $customer->name }}</div>
                        </td>
                        <td>{{ $customer->email }}</td>
                        <td>{{ $customer->phone ?? 'N/A' }}</td>
                        <td>{{ $customer->created_at->format('M d, Y') }}</td>
                        <td class="pe-4 text-end">
                            <a href="{{ route('admin.customers.show', $customer->id) }}" class="btn btn-sm btn-outline-primary" data-i18n="cust_view_details">View Details</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted" data-i18n="cust_no_customers">No customers found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($customers->hasPages())
    <div class="card-footer bg-white pt-3 border-0">
        {{ $customers->links() }}
    </div>
    @endif
</div>
@endsection
