@extends('admin.layouts.app')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.bookings.index') }}" class="text-decoration-none text-muted"><i class="bi bi-arrow-left me-1"></i> Back to Bookings</a>
    <div class="d-flex justify-content-between align-items-center mt-2">
        <h2 class="fw-bold mb-0">Booking #{{ $booking->booking_number }}</h2>
        <span class="badge bg-primary fs-6">{{ ucfirst($booking->booking_status) }}</span>
    </div>
</div>

<div class="row g-4">
    <!-- Booking Details Left -->
    <div class="col-md-8">
        <!-- Car & Location Details -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white fw-bold py-3">Rental Information</div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6 d-flex align-items-center">
                        @php
                            $primaryImage = $booking->car ? $booking->car->images->where('is_primary', true)->first() : null;
                        @endphp
                        @if($primaryImage)
                            <img src="{{ $primaryImage->image }}" alt="{{ $booking->snapshot->car_name ?? ($booking->car->name ?? 'N/A') }}" class="rounded me-3" style="width: 80px; height: 60px; object-fit: cover;">
                        @else
                            <div class="d-inline-flex align-items-center justify-content-center rounded bg-light text-muted me-3" style="width: 80px; height: 60px;">
                                <i class="bi bi-car-front fs-3"></i>
                            </div>
                        @endif
                        <div>
                            <small class="text-muted d-block">Car</small>
                            <span class="fw-bold fs-5">{{ $booking->snapshot->car_name ?? ($booking->car->name ?? 'N/A') }}</span> 
                            <span class="text-uppercase text-muted ms-1">({{ $booking->snapshot->car_registration_number ?? ($booking->car->registration_number ?? 'N/A') }})</span>
                        </div>
                    </div>
                </div>
                
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded border border-secondary border-opacity-10">
                            <small class="text-muted d-block fw-bold mb-1">PICK-UP</small>
                            <div class="fs-5 mb-1">{{ \Carbon\Carbon::parse($booking->pickup_at)->format('D, M j, Y') }}</div>
                            <div class="text-primary fw-bold">{{ \Carbon\Carbon::parse($booking->pickup_at)->format('h:i A') }}</div>
                            <hr class="my-2">
                            <div>{{ $booking->pickupLocation->name ?? 'N/A' }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded border border-secondary border-opacity-10">
                            <small class="text-muted d-block fw-bold mb-1">DROP-OFF</small>
                            <div class="fs-5 mb-1">{{ \Carbon\Carbon::parse($booking->return_at)->format('D, M j, Y') }}</div>
                            <div class="text-primary fw-bold">{{ \Carbon\Carbon::parse($booking->return_at)->format('h:i A') }}</div>
                            <hr class="my-2">
                            <div>{{ $booking->dropoffLocation->name ?? 'N/A' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Financial Details -->
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white fw-bold py-3">Financial Overview</div>
            <div class="card-body">
                <table class="table table-borderless table-sm mb-0">
                    <tbody>
                        <tr>
                            <td>Base Rental Amount</td>
                            <td class="text-end">৳{{ number_format($booking->total_amount, 2) }}</td>
                        </tr>
                        <tr>
                            <td>Security Deposit</td>
                            <td class="text-end text-muted">৳{{ number_format($booking->security_deposit_amount, 2) }}</td>
                        </tr>
                        @php
                            $totalRequired = $booking->total_amount + $booking->security_deposit_amount;
                            $totalPaid = $booking->payments->where('status', 'completed')->sum('amount');
                            $remainingDue = max(0, $totalRequired - $totalPaid);
                        @endphp
                        <tr class="border-top">
                            <td class="fw-bold fs-5 pt-2">Total Due</td>
                            <td class="text-end fw-bold fs-5 pt-2">৳{{ number_format($totalRequired, 2) }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold text-success">Total Paid</td>
                            <td class="text-end fw-bold text-success">৳{{ number_format($totalPaid, 2) }}</td>
                        </tr>
                        <tr class="border-top bg-light">
                            <td class="fw-bold fs-5 pt-2 text-danger">Remaining Balance</td>
                            <td class="text-end fw-bold fs-5 pt-2 text-danger">৳{{ number_format($remainingDue, 2) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Payment History -->
        @if($booking->payments->count() > 0)
        <div class="card shadow-sm border-0 mt-4">
            <div class="card-header bg-white fw-bold py-3">Payment Transactions</div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light small">
                            <tr>
                                <th class="ps-3">Date</th>
                                <th>Method</th>
                                <th>Trx ID</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th class="text-end pe-3">Action</th>
                            </tr>
                        </thead>
                        <tbody class="small">
                            @foreach($booking->payments as $payment)
                            <tr>
                                <td class="ps-3 text-muted">{{ $payment->created_at->format('M d, Y h:ia') }}</td>
                                <td>{{ ucfirst($payment->payment_method) }}</td>
                                <td class="text-muted font-monospace">{{ $payment->transaction_id ?? '-' }}</td>
                                <td class="fw-bold text-success">৳{{ number_format($payment->amount, 2) }}</td>
                                <td>
                                    @if($payment->status === 'pending')
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @elseif($payment->status === 'completed')
                                        <span class="badge bg-success">Verified</span>
                                    @elseif($payment->status === 'failed')
                                        <span class="badge bg-danger">Failed</span>
                                    @else
                                        <span class="badge bg-secondary">{{ ucfirst($payment->status ?? 'Completed') }}</span>
                                    @endif
                                </td>
                                <td class="text-end pe-3">
                                    @if($payment->status === 'pending')
                                    <form action="{{ route('admin.bookings.payments.update', [$booking, $payment]) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="completed">
                                        <button class="btn btn-sm btn-outline-success" title="Verify Payment"><i class="bi bi-check-lg"></i></button>
                                    </form>
                                    <form action="{{ route('admin.bookings.payments.update', [$booking, $payment]) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="failed">
                                        <button class="btn btn-sm btn-outline-danger" title="Reject Payment"><i class="bi bi-x-lg"></i></button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Right Sidebar -->
    <div class="col-md-4">
        <!-- Customer Info -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white fw-bold py-3">Customer</div>
            <div class="card-body">
                @if($booking->user)
                    <div class="fw-bold fs-5">{{ $booking->user->name }}</div>
                    <div class="text-muted mb-2">{{ $booking->user->email }}</div>
                    <div><i class="bi bi-telephone text-muted me-2"></i> {{ $booking->user->phone ?? 'N/A' }}</div>
                @else
                    <div class="fw-bold fs-5">{{ $booking->snapshot->customer_name ?? 'Guest User' }} <span class="badge bg-secondary ms-2" style="font-size: 0.7em;">GUEST</span></div>
                    @if(!empty($booking->snapshot->customer_email))
                        <div class="text-muted mb-2">{{ $booking->snapshot->customer_email }}</div>
                    @endif
                    @if(!empty($booking->snapshot->customer_phone))
                        <div><i class="bi bi-telephone text-muted me-2"></i> {{ $booking->snapshot->customer_phone }}</div>
                    @endif
                @endif
            </div>
        </div>
        
        <!-- Management Actions -->
        <div class="card shadow-sm border-0 bg-light">
            <div class="card-header bg-transparent fw-bold py-3 border-0">Manage Status</div>
            <div class="card-body pt-0">
                <form action="{{ route('admin.bookings.update', $booking) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold small text-muted">Booking Status</label>
                        <select name="booking_status" class="form-select">
                            <option value="pending" {{ $booking->booking_status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="confirmed" {{ $booking->booking_status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                            <option value="active" {{ $booking->booking_status == 'active' ? 'selected' : '' }}>Active (In Progress)</option>
                            <option value="completed" {{ $booking->booking_status == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled" {{ $booking->booking_status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>
                    
                        <div class="mb-4">
                            <label class="form-label fw-semibold small text-muted">Payment Status</label>
                            <select name="payment_status" class="form-select mb-2">
                                <option value="unpaid" {{ $booking->payment_status == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                                <option value="partial" {{ $booking->payment_status == 'partial' ? 'selected' : '' }}>Partial</option>
                                <option value="paid" {{ $booking->payment_status == 'paid' ? 'selected' : '' }}>Paid</option>
                                <option value="refunded" {{ $booking->payment_status == 'refunded' ? 'selected' : '' }}>Refunded</option>
                            </select>
                        </div>
                        
                        <div class="mb-3 border-top pt-3">
                            <label class="form-label fw-semibold small text-muted">Record New Payment (Optional)</label>
                            <div class="input-group mb-2">
                                <span class="input-group-text">৳</span>
                                <input type="number" name="payment_amount" class="form-control" placeholder="Amount" step="0.01" min="0">
                            </div>
                            <select name="payment_method" class="form-select form-select-sm">
                                <option value="cash">Cash</option>
                                <option value="card">Credit/Debit Card</option>
                                <option value="bkash">bKash</option>
                                <option value="bank_transfer">Bank Transfer</option>
                            </select>
                            <small class="text-muted mt-1 d-block">Adding an amount will automatically adjust the payment status above.</small>
                        </div>
                        
                        <button type="submit" class="btn btn-primary w-100 fw-bold">Update Booking</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
