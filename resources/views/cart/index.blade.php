@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h2>Your Cart</h2>
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>Course</th>
                    <th>Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($cartItems as $item)
                    <tr>
                        <td>{{ $item->course->title ?? 'Course Title' }}</td>
                        <td>৳{{ $item->course->price ?? 0 }}</td>
                        <td>
                            <form action="{{ route('cart.remove', $item->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Remove</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center">Your cart is empty.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if($cartItems->count() > 0)
            <div class="row mt-4">
                <div class="col-md-6 offset-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Cart Summary</h5>
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Total Items:</strong></td>
                                    <td>{{ $cartItems->count() }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Total Price:</strong></td>
                                    <td>৳{{ $cartItems->sum(function ($item) {
                return $item->course->price ?? 0; }) }}</td>
                                </tr>
                            </table>
                            <form action="{{ route('checkout') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success btn-block">Complete Purchase</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection