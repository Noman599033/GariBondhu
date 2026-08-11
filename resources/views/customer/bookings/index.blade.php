@extends('layouts.customer')

@section('customer_content')
            
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">Booking Ref</th>
                                    <th>Car Details</th>
                                    <th>Dates</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th class="text-end pe-4">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($bookings as $booking)
                                <tr>
                                    <td class="ps-4 fw-bold text-primary">{{ $booking->booking_number }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @php
                                                $primaryImage = $booking->car ? $booking->car->images->where('is_primary', true)->first() : null;
                                            @endphp
                                            @if($primaryImage)
                                                <img src="{{ $primaryImage->image }}" alt="{{ $booking->snapshot?->car_name ?? ($booking->car?->name ?? 'Car') }}" class="rounded-circle me-2" style="width: 32px; height: 32px; object-fit: cover;">
                                            @else
                                                <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-light text-muted me-2" style="width: 32px; height: 32px;">
                                                    <i class="bi bi-car-front"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <div class="fw-bold">{{ $booking->snapshot?->car_name ?? ($booking->car?->name ?? 'Car') }}</div>
                                                <small class="text-muted">{{ $booking->pickupLocation?->name ?? 'Location' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <small><strong>In:</strong> {{ \Carbon\Carbon::parse($booking->pickup_at)->format('M d, Y') }}</small><br>
                                        <small><strong>Out:</strong> {{ \Carbon\Carbon::parse($booking->return_at)->format('M d, Y') }}</small>
                                    </td>
                                    <td class="fw-bold">৳{{ number_format($booking->total_amount, 2) }}</td>
                                    <td>
                                        @php
                                            $statusColors = [
                                                'pending' => 'warning', 'confirmed' => 'info', 'active' => 'primary',
                                                'completed' => 'success', 'cancelled' => 'danger', 'rejected' => 'secondary'
                                            ];
                                        @endphp
                                        <span class="badge bg-{{ $statusColors[$booking->booking_status] ?? 'dark' }}">
                                            {{ ucfirst($booking->booking_status) }}
                                        </span>
                                    </td>
                                    <td class="text-end pe-4">
                                        <a href="{{ route('customer.bookings.show', $booking) }}" class="btn btn-sm btn-outline-primary">View Receipt</a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        <i class="bi bi-calendar-x fs-1 mb-3 d-block"></i>
                                        <h5>No booking history found</h5>
                                        <p>You haven't made any bookings yet.</p>
                                        <a href="{{ route('home') }}" class="btn btn-primary mt-2">Find a Car</a>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                
                @if($bookings->hasPages())
                    <div class="card-footer bg-white border-0 pt-4 pb-3">
                        {{ $bookings->links() }}
                    </div>
                @endif
            </div>
@endsection
