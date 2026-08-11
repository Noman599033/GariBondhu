@extends('admin.layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold" data-i18n="bookings_mgmt">Booking Management</h2>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th data-i18n="bookings_th_ref">Booking Ref</th>
                        <th data-i18n="bookings_th_customer">Customer</th>
                        <th data-i18n="bookings_th_car">Car</th>
                        <th data-i18n="bookings_th_dates">Dates</th>
                        <th data-i18n="bookings_th_amount">Amount</th>
                        <th data-i18n="bookings_th_status">Status</th>
                        <th data-i18n="bookings_th_payment">Payment</th>
                        <th class="text-end" data-i18n="bookings_th_actions">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bookings as $booking)
                    <tr>
                        <td class="fw-bold text-primary">{{ $booking->booking_number }}</td>
                        <td>
                            @if($booking->user)
                                {{ $booking->user->name }}<br>
                                <small class="text-muted">{{ $booking->user->email }}</small>
                            @else
                                <span class="text-muted" data-i18n="bookings_guest">Guest</span>
                            @endif
                        </td>
                        <td>
                            @if($booking->car)
                                <div class="d-flex align-items-center">
                                    @php
                                        $primaryImage = $booking->car->images->where('is_primary', true)->first();
                                    @endphp
                                    @if($primaryImage)
                                        <img src="{{ $primaryImage->image }}" alt="{{ $booking->car->name }}" class="rounded-circle me-2" style="width: 32px; height: 32px; object-fit: cover;">
                                    @else
                                        <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-light text-muted me-2" style="width: 32px; height: 32px;">
                                            <i class="bi bi-car-front"></i>
                                        </div>
                                    @endif
                                    <div>
                                        {{ $booking->car->name }}<br>
                                        <small class="text-muted text-uppercase">{{ $booking->car->registration_number }}</small>
                                    </div>
                                </div>
                            @else
                                <span class="text-danger" data-i18n="bookings_car_deleted">Car Deleted</span>
                            @endif
                        </td>
                        <td>
                            <small><strong data-i18n="bookings_in">In:</strong> {{ \Carbon\Carbon::parse($booking->pickup_at)->format('M d, Y H:i') }}</small><br>
                            <small><strong data-i18n="bookings_out">Out:</strong> {{ \Carbon\Carbon::parse($booking->return_at)->format('M d, Y H:i') }}</small>
                        </td>
                        <td class="fw-bold">৳{{ number_format($booking->total_amount, 2) }}</td>
                        <td>
                            @php
                                $statusColors = [
                                    'pending' => 'warning', 'confirmed' => 'info', 'active' => 'primary',
                                    'completed' => 'success', 'cancelled' => 'danger', 'rejected' => 'secondary', 'expired' => 'secondary'
                                ];
                            @endphp
                            <span class="badge bg-{{ $statusColors[$booking->booking_status] ?? 'dark' }}">
                                {{ ucfirst($booking->booking_status) }}
                            </span>
                        </td>
                        <td>
                            @if($booking->payment_status === 'paid')
                                <span class="badge bg-success" data-i18n="bookings_paid">Paid</span>
                            @elseif($booking->payment_status === 'partial')
                                <span class="badge bg-info" data-i18n="bookings_partial">Partial</span>
                            @else
                                <span class="badge bg-danger" data-i18n="bookings_unpaid">Unpaid</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <a href="{{ route('admin.bookings.show', $booking) }}" class="btn btn-sm btn-outline-primary" data-i18n="bookings_manage_btn">Manage</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-4 text-muted" data-i18n="bookings_no_bookings">No bookings found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-4">
            {{ $bookings->links() }}
        </div>
    </div>
</div>
@endsection
