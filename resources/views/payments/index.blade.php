@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h2>Payment History</h2>

        @if($payments->count() > 0)
            @foreach($payments as $payment)
                <div class="card mb-3">
                    <div class="card-header">
                        <strong>Transaction ID:</strong> {{ $payment->txnid ?? $payment->id }} |
                        <strong>Date:</strong> {{ $payment->created_at->format('M d, Y H:i') }} |
                        <strong>Total:</strong> ৳{{ number_format($payment->total_amount, 2) }}
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Course</th>
                                    <th>Price</th>
                                    <th>Instructor</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($payment->items as $item)
                                    <tr>
                                        <td>{{ $item->course->title ?? 'Course Title' }}</td>
                                        <td>৳{{ number_format($item->price, 2) }}</td>
                                        <td>{{ $item->course->instructor->name ?? 'N/A' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endforeach
        @else
            <div class="alert alert-info">
                No payment history found.
            </div>
        @endif
    </div>
@endsection