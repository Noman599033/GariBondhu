@extends('layouts.customer')

@section('customer_content')
            <!-- Quick Stats -->
            <div class="row g-4 mb-4">
                <div class="col-md-6">
                    <div class="card shadow-sm border-0 bg-primary text-white h-100 p-3 rounded-4">
                        <div class="card-body">
                            <h6 class="fw-bold text-white-50 mb-1">ACTIVE BOOKINGS</h6>
                            <div class="display-4 fw-bold">{{ $activeBookings }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card shadow-sm border-0 bg-light h-100 p-3 rounded-4">
                        <div class="card-body">
                            <h6 class="fw-bold text-muted mb-1">PAST BOOKINGS</h6>
                            <div class="display-4 fw-bold text-dark">{{ $pastBookings }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-white fw-bold py-3 fs-5 border-bottom">
                    Recent Bookings
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush rounded-bottom">
                        @forelse($recentBookings as $booking)
                            <a href="{{ route('customer.bookings.show', $booking) }}" class="list-group-item list-group-item-action p-4">
                                <div class="d-flex w-100 justify-content-between align-items-center mb-2">
                                    <h5 class="mb-1 fw-bold">{{ $booking->snapshot?->car_name ?? ($booking->car?->name ?? 'Car') }}</h5>
                                    <small class="text-muted fw-bold">Ref: {{ $booking->booking_number }}</small>
                                </div>
                                <div class="d-flex w-100 justify-content-between align-items-end">
                                    <p class="mb-1 text-muted small">
                                        <i class="bi bi-calendar-event me-1"></i> {{ \Carbon\Carbon::parse($booking->pickup_at)->format('M d, Y') }} - {{ \Carbon\Carbon::parse($booking->return_at)->format('M d, Y') }}<br>
                                        <i class="bi bi-geo-alt me-1"></i> {{ $booking->pickupLocation->name ?? 'Location' }}
                                    </p>
                                    <div>
                                        @php
                                            $statusColors = [
                                                'pending' => 'warning', 'confirmed' => 'info', 'active' => 'primary',
                                                'completed' => 'success', 'cancelled' => 'danger', 'rejected' => 'secondary'
                                            ];
                                        @endphp
                                        <span class="badge bg-{{ $statusColors[$booking->booking_status] ?? 'dark' }}">
                                            {{ ucfirst($booking->booking_status) }}
                                        </span>
                                    </div>
                                </div>
                            </a>
                        @empty
                            <div class="p-5 text-center text-muted">
                                <i class="bi bi-journal-x fs-1 mb-3 d-block"></i>
                                <h5>No bookings found</h5>
                                <p>You haven't made any bookings yet.</p>
                                <a href="{{ route('search') }}" class="btn btn-primary mt-2">Find a Car</a>
                            </div>
                        @endforelse
                    </div>
                </div>
                @if($recentBookings->count() > 0)
                    <div class="card-footer bg-light text-center py-3 border-0 rounded-bottom">
                        <a href="{{ route('customer.bookings.index') }}" class="text-decoration-none fw-bold">View All Bookings <i class="bi bi-arrow-right"></i></a>
                    </div>
                @endif
            </div>
@endsection
