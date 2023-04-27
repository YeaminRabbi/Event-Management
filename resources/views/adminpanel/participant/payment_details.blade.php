@foreach ($payments as $payment)

<div class="card h-auto mb-4">
    <div class="card-header d-flex align-items-center justify-content-between pb-0 mb-3">
        <div class="card-title mb-0">
            <h5 class="m-0 me-2">Payment Details</h5>
        </div>

    </div>
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="">
                <h2 class="mb-2">{{ number_format($payment->amount) }} /-</h2>
                <span>Total Amount in BDT.</span>
            </div>

        </div>
        <ul class="p-0 m-0">
            <li class="row">
                <div class="col-md-6">
                    <div class="d-flex mb-4 pb-1">
                        <div class="avatar flex-shrink-0 me-3">
                            <span class="avatar-initial rounded bg-label-primary"><svg
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    style="fill: rgba(0, 0, 0, 1);transform: ;msFilter:;">
                                    <path
                                        d="M19 4h-2V2h-2v2H9V2H7v2H5c-1.103 0-2 .897-2 2v14c0 1.103.897 2 2 2h14c1.103 0 2-.897 2-2V6c0-1.103-.897-2-2-2zm.002 16H5V8h14l.002 12z">
                                    </path>
                                    <path d="m11 17.414 5.707-5.707-1.414-1.414L11 14.586l-2.293-2.293-1.414 1.414z">
                                    </path>
                                </svg></span>
                        </div>
                        <div class="me-2">
                            <h6 class="mb-0">Payment Date</h6>
                            <small class="fw-semibold">{{ $payment->created_at->format('d-M-Y ') }}</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="d-flex mb-4 pb-1">
                        <div class="avatar flex-shrink-0 me-3">
                            <span class="avatar-initial rounded bg-label-success"><i class="bx bx-code-alt"></i></span>
                        </div>
                        <div class="me-2">
                            <h6 class="mb-0">TRNXID</h6>
                            <small class="fw-semibold">{{ $payment->transaction_id }}</small>
                        </div>
                    </div>
                </div>
            </li>
            <li class="row">
                <div class="col-md-6">
                    <div class="d-flex mb-4 pb-1">
                        <div class="avatar flex-shrink-0 me-3">
                            <span class="avatar-initial rounded bg-label-info"><i class="bx bx-phone"></i></span>
                        </div>
                        <div class="me-2">
                            <h6 class="mb-0">Paid By</h6>
                            <small class="fw-semibold">{{ $payment->paid_by }}</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="d-flex mb-4 pb-1">
                        <div class="avatar flex-shrink-0 me-3">
                            <span class="avatar-initial rounded bg-label-secondary bg-label-primary"><i
                                    class="bx bx-dollar"></i></span>
                        </div>
                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                                <h6 class="mb-0">Method</h6>
                                <small class="fw-semibold">
                                    @if ($payment->payment_method_id == 1)
                                    Bkash
                                    @endif
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </li>

            <li class="row">
                <div class="col-md-6">
                    <div class="d-flex mb-4 pb-1">
                        <div class="avatar flex-shrink-0 me-3">
                            <span class="avatar-initial rounded bg-label-warning"><i class="bx bx-stats"></i></span>
                        </div>
                        <div class="me-2">
                            <h6 class="mb-0">Status</h6>
                            <small class="fw-semibold">
                                @if ($payment->status == 0)
                                    Unverified
                                @elseif ($payment->status ==1)
                                    Verified
                                @endif
                            </small>
                        </div>
                    </div>
                </div>

                @if ($payment->status == 0)
                    <div class="col-md-6">
                        <a href="{{ route('payment-verify', $payment->id ) }}" class="btn btn-sm btn-rounded btn-primary" onclick="return confirm('Are you sure you want to verify this participant?');">
                           Verify Payment
                        </a>
                    </div>
                @endif

            </li>



        </ul>


    </div>
</div>
@endforeach

