@extends('admin.layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <a href="{{ route('admin.customers.index') }}" class="text-decoration-none text-muted mb-2 d-inline-block"><i class="bi bi-arrow-left"></i> Back to Customers</a>
        <h2 class="fw-bold mb-0">Customer Profile</h2>
    </div>
</div>

<div class="row g-4">
    <!-- Customer Info Card -->
    <div class="col-md-4">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <div class="text-center mb-4 mt-3">
                    <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px; font-size: 2rem;">
                        {{ strtoupper(substr($customer->name, 0, 1)) }}
                    </div>
                    <h4 class="fw-bold mb-1">{{ $customer->name }}</h4>
                    <p class="text-muted mb-0">Customer ID: #{{ $customer->id }}</p>
                    <p class="small text-muted">Joined {{ $customer->created_at->format('M d, Y') }}</p>
                </div>
                
                <hr>
                
                <div class="mb-3">
                    <small class="text-muted fw-bold d-block mb-1">EMAIL ADDRESS</small>
                    <div><a href="mailto:{{ $customer->email }}">{{ $customer->email }}</a></div>
                </div>
                <div class="mb-3">
                    <small class="text-muted fw-bold d-block mb-1">PHONE NUMBER</small>
                    <div>{{ $customer->phone ?? 'Not provided' }}</div>
                </div>
                <div class="mb-3">
                    <small class="text-muted fw-bold d-block mb-1">ADDRESS</small>
                    <div>{{ $customer->address ?? 'Not provided' }}</div>
                </div>
                
                <hr>
                
                <div class="d-flex justify-content-between text-center">
                    <div>
                        <div class="fs-4 fw-bold">{{ $customer->bookings->count() }}</div>
                        <small class="text-muted">Total Bookings</small>
                    </div>
                    <div>
                        @php
                            $totalSpent = $customer->bookings->flatMap->payments->where('status', 'completed')->sum('amount');
                        @endphp
                        <div class="fs-4 fw-bold text-success">${{ number_format($totalSpent, 2) }}</div>
                        <small class="text-muted">Total Spent</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Booking History -->
    <div class="col-md-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white border-bottom pt-4 pb-3 ps-4">
                <h5 class="fw-bold mb-0">Booking History</h5>
            </div>
            <div class="card-body p-0 table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Booking ID</th>
                            <th>Car</th>
                            <th>Dates</th>
                            <th>Status</th>
                            <th class="pe-4 text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($customer->bookings as $booking)
                            <tr>
                                <td class="ps-4">
                                    <span class="fw-bold">#{{ $booking->id }}</span><br>
                                    <small class="text-muted">{{ $booking->created_at->format('M d, Y') }}</small>
                                </td>
                                <td>
                                    @if($booking->car)
                                        <div class="fw-bold">{{ $booking->car->brand->name ?? '' }} {{ $booking->car->model }}</div>
                                        <small class="text-muted">{{ $booking->car->year }}</small>
                                    @else
                                        <span class="text-muted">Car Removed</span>
                                    @endif
                                </td>
                                <td>
                                    <div>{{ \Carbon\Carbon::parse($booking->start_date)->format('M d') }} - {{ \Carbon\Carbon::parse($booking->end_date)->format('M d, Y') }}</div>
                                </td>
                                <td>
                                    @php
                                        $badgeColors = [
                                            'pending' => 'warning text-dark',
                                            'confirmed' => 'primary',
                                            'active' => 'info text-dark',
                                            'completed' => 'success',
                                            'cancelled' => 'secondary',
                                            'rejected' => 'danger'
                                        ];
                                        $badgeColor = $badgeColors[$booking->booking_status] ?? 'secondary';
                                    @endphp
                                    <span class="badge bg-{{ $badgeColor }} text-uppercase">{{ $booking->booking_status }}</span>
                                </td>
                                <td class="pe-4 text-end">
                                    <a href="{{ route('admin.bookings.show', $booking->id) }}" class="btn btn-sm btn-outline-primary">Manage</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">
                                    <i class="bi bi-calendar-x fs-2 mb-3 d-block"></i>
                                    No booking history found for this customer.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
