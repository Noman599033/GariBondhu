<style>
@media print {
    /* Hide global layout elements like navbars and footers if they exist */
    header, footer, nav, .navbar {
        display: none !important;
    }
    /* Hide the top page header and sidebar */
    .page-header-section, .sidebar-section {
        display: none !important;
    }
    /* Make the invoice take full width */
    .invoice-container {
        width: 100% !important;
        flex: 0 0 100% !important;
        max-width: 100% !important;
        padding: 0 !important;
        margin: 0 !important;
    }
    /* Hide specific elements within the invoice (like buttons and forms) */
    .print-hide {
        display: none !important;
    }
    /* Remove shadows and borders from the card for a clean print */
    #invoice-card {
        border: none !important;
        box-shadow: none !important;
        margin: 0 !important;
    }
    body {
        background-color: white !important;
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
    }
}
</style>
@extends('layouts.customer')

@section('customer_content')
            <div class="mb-3 print-hide">
                <a href="{{ route('customer.bookings.index') }}" class="text-decoration-none text-muted"><i class="bi bi-arrow-left me-1"></i> Back to History</a>
            </div>

            <div class="card shadow-sm border-0 rounded-4 mb-4" id="invoice-card">
                <div class="card-header bg-white fw-bold py-3 fs-5 border-bottom d-flex justify-content-between align-items-center print-hide">
                    <span>Receipt / Invoice</span>
                    <button class="btn btn-outline-secondary btn-sm" onclick="window.print()"><i class="bi bi-printer me-1"></i> Print</button>
                </div>
                <div class="card-body p-4 p-md-5">
                    
                    <div class="row mb-5">
                        <div class="col-6">
                            <h2 class="fw-bold text-primary mb-0">GARI BONDHU</h2>
                            <p class="text-muted small">Premium Rental Services</p>
                        </div>
                        <div class="col-6 text-end">
                            <h5 class="fw-bold mb-1">INVOICE #{{ $booking->booking_number }}</h5>
                            <div class="text-muted small">Date Issued: {{ $booking->created_at->format('M d, Y') }}</div>
                            <div class="mt-2">
                                Status: 
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
                    </div>

                    <div class="row mb-4 border-bottom pb-4">
                        <div class="col-6">
                            <div class="text-muted fw-bold small mb-2">BILLED TO:</div>
                            <div class="fw-bold fs-5">{{ $booking->snapshot->customer_name }}</div>
                            <div>{{ $booking->snapshot->customer_email }}</div>
                            <div>{{ $booking->snapshot->customer_phone }}</div>
                        </div>
                        <div class="col-6 mt-0">
                            <div class="text-muted fw-bold small mb-2">VEHICLE DETAILS:</div>
                            <div class="d-flex align-items-center">
                                @php
                                    $primaryImage = $booking->car ? $booking->car->images->where('is_primary', true)->first() : null;
                                @endphp
                                @if($primaryImage)
                                    <img src="{{ $primaryImage->image }}" alt="{{ $booking->snapshot->car_name }}" class="rounded me-3" style="width: 80px; height: 60px; object-fit: cover;">
                                @else
                                    <div class="d-inline-flex align-items-center justify-content-center rounded bg-light text-muted me-3" style="width: 80px; height: 60px;">
                                        <i class="bi bi-car-front fs-3"></i>
                                    </div>
                                @endif
                                <div>
                                    <div class="fw-bold fs-5">{{ $booking->snapshot->car_name }}</div>
                                    <div>Registration: {{ strtoupper($booking->snapshot->car_registration_number) }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row g-4 mb-5 border-bottom pb-4">
                        <div class="col-6">
                            <div class="bg-light p-3 rounded h-100">
                                <div class="text-muted fw-bold small mb-1">PICK-UP</div>
                                <div class="fw-bold text-primary">{{ \Carbon\Carbon::parse($booking->pickup_at)->format('D, M d, Y - h:i A') }}</div>
                                <div class="small mt-1">{{ $booking->pickupLocation->name ?? 'N/A' }}</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="bg-light p-3 rounded h-100">
                                <div class="text-muted fw-bold small mb-1">DROP-OFF</div>
                                <div class="fw-bold text-primary">{{ \Carbon\Carbon::parse($booking->return_at)->format('D, M d, Y - h:i A') }}</div>
                                <div class="small mt-1">{{ $booking->dropoffLocation->name ?? 'N/A' }}</div>
                            </div>
                        </div>
                    </div>

                    <table class="table mb-4">
                        <thead>
                            <tr class="text-muted small">
                                <th>DESCRIPTION</th>
                                <th class="text-end">AMOUNT</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="py-3">
                                    <span class="fw-bold">Base Rental Charge</span>
                                    <div class="small text-muted">Vehicle rental for the specified duration.</div>
                                </td>
                                <td class="py-3 text-end fw-bold">৳{{ number_format($booking->total_amount, 2) }}</td>
                            </tr>
                            <tr>
                                <td class="py-3">
                                    <span class="fw-bold">Security Deposit</span>
                                    <div class="small text-muted">Refundable deposit for damages.</div>
                                </td>
                                <td class="py-3 text-end fw-bold">৳{{ number_format($booking->security_deposit_amount, 2) }}</td>
                            </tr>
                        </tbody>
                        @php
                            $totalRequired = $booking->total_amount + $booking->security_deposit_amount;
                            $totalPaid = $booking->payments->where('status', 'completed')->sum('amount');
                            $remainingDue = max(0, $totalRequired - $totalPaid);
                        @endphp
                        <tfoot>
                            <tr>
                                <td class="text-end py-3 text-muted">Subtotal:</td>
                                <td class="text-end py-3 fw-bold">৳{{ number_format($totalRequired, 2) }}</td>
                            </tr>
                            <tr>
                                <td class="text-end py-3 text-muted">Total Paid:</td>
                                <td class="text-end py-3 fw-bold text-success">
                                    ৳{{ number_format($totalPaid, 2) }}
                                </td>
                            </tr>
                            <tr class="border-top border-dark">
                                <td class="text-end py-3 fs-5 fw-bold">Balance Due:</td>
                                <td class="text-end py-3 fs-4 fw-bold {{ $remainingDue > 0 ? 'text-danger' : 'text-primary' }}">৳{{ number_format($remainingDue, 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                    
                    @if($booking->payments->count() > 0)
                    <div class="mt-4">
                        <h6 class="fw-bold mb-3">Payment History</h6>
                        <table class="table table-sm text-muted">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Method</th>
                                    <th>Trx ID</th>
                                    <th>Status</th>
                                    <th class="text-end">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($booking->payments as $payment)
                                <tr>
                                    <td>{{ $payment->created_at->format('M d, Y') }}</td>
                                    <td>{{ ucfirst($payment->payment_method) }}</td>
                                    <td>{{ $payment->transaction_id ?? 'N/A' }}</td>
                                    <td>
                                        @if($payment->status === 'pending')
                                            <span class="badge bg-warning text-dark">Pending Review</span>
                                        @elseif($payment->status === 'completed')
                                            <span class="badge bg-success">Verified</span>
                                        @elseif($payment->status === 'failed')
                                            <span class="badge bg-danger">Failed</span>
                                        @else
                                            <span class="badge bg-secondary">{{ ucfirst($payment->status ?? 'Completed') }}</span>
                                        @endif
                                    </td>
                                    <td class="text-end fw-bold text-success">৳{{ number_format($payment->amount, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif

                    @if($remainingDue > 0)
                        <div class="card bg-light border-0 mt-5 print-hide">
                            <div class="card-body p-4">
                                <h5 class="fw-bold mb-3"><i class="bi bi-wallet2 me-2 text-primary"></i> Make a Payment</h5>
                                <p class="small text-muted mb-4">Please send the money to our bKash (017XXXXX) or Bank Account and submit the Transaction ID below for verification.</p>
                                


                                <form action="{{ route('customer.bookings.payment.store', $booking) }}" method="POST">
                                    @csrf
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <label class="form-label small fw-bold">Payment Method</label>
                                            <select name="payment_method" class="form-select" required>
                                                <option value="bkash">bKash</option>
                                                <option value="bank_transfer">Bank Transfer</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label small fw-bold">Amount Sent (৳)</label>
                                            <input type="number" name="amount" class="form-control" value="{{ $remainingDue }}" max="{{ $remainingDue }}" min="1" step="0.01" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label small fw-bold">Transaction ID</label>
                                            <input type="text" name="transaction_id" class="form-control" placeholder="e.g. TRXD123456" required>
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <button type="submit" class="btn btn-primary fw-bold px-4">Submit Payment</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-success border-0 mt-5">
                            <h6 class="fw-bold mb-0"><i class="bi bi-check-circle-fill me-2"></i> Payment Complete</h6>
                            <p class="mb-0 small mt-1">This booking is fully paid. Thank you!</p>
                        </div>
                    @endif

                </div>
@endsection
