@extends('layouts.app')

@section('content')
    <style>
        /* Payment Modal Styles */
        .payment-modal {
            display: none;
            position: fixed;
            z-index: 9999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            animation: fadeIn 0.3s ease;
        }

        .payment-modal.active {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .payment-modal-content {
            background-color: white;
            border-radius: 15px;
            width: 90%;
            max-width: 650px;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
            animation: slideDown 0.3s ease;
            position: relative;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes slideDown {
            from {
                transform: translateY(-50px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .payment-modal-header {
            padding: 20px 25px;
            border-bottom: 2px solid #f0f0f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .payment-modal-header h3 {
            margin: 0;
            font-size: 1.5rem;
            font-weight: 700;
            color: #2c3e50;
        }

        .modal-close {
            background: none;
            border: none;
            font-size: 1.8rem;
            color: #999;
            cursor: pointer;
            width: 35px;
            height: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: all 0.3s ease;
        }

        .modal-close:hover {
            background: #f0f0f0;
            color: #333;
        }

        .payment-modal-body {
            padding: 25px;
        }

        .payment-methods {
            display: flex;
            gap: 10px;
            margin-bottom: 25px;
            flex-wrap: wrap;
        }

        .payment-method {
            flex: 1;
            min-width: 100px;
            padding: 12px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            background: white;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: center;
            position: relative;
        }

        .payment-method:hover {
            border-color: #175388ff;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(23, 83, 136, 0.2);
        }

        .payment-method.active {
            border-color: #175388ff;
            background: #f0f8ff;
            box-shadow: 0 0 0 3px rgba(23, 83, 136, 0.1);
        }

        .payment-method input[type="radio"] {
            position: absolute;
            opacity: 0;
        }

        .payment-method-label {
            font-weight: 600;
            font-size: 0.95rem;
            color: #2c3e50;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .payment-icon {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.75rem;
            color: white;
        }

        .payment-icon.bkash {
            background: #E2136E;
        }

        .payment-icon.nagad {
            background: #ED1C24;
        }

        .payment-icon.rocket {
            background: #8B3A8B;
        }

        .payment-icon.upay {
            background: #175388ff;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #2c3e50;
            font-size: 0.95rem;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: #175388ff;
            box-shadow: 0 0 0 3px rgba(23, 83, 136, 0.1);
        }

        .payment-info {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .payment-number {
            text-align: center;
            margin-bottom: 15px;
        }

        .payment-number h4 {
            font-size: 1.1rem;
            color: #2c3e50;
            margin-bottom: 8px;
        }

        .payment-number .number {
            font-size: 1.5rem;
            font-weight: 700;
            color: #175388ff;
            letter-spacing: 1px;
        }

        .qr-code {
            text-align: center;
            margin: 20px 0;
        }

        .qr-placeholder {
            width: 150px;
            height: 150px;
            background: white;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #999;
            font-size: 0.9rem;
        }

        .scan-text {
            color: #7f8c8d;
            font-style: italic;
            font-size: 0.9rem;
            margin-top: 8px;
        }

        .price-summary {
            background: white;
            padding: 15px;
            border-radius: 8px;
            border: 2px solid #e0e0e0;
        }

        .price-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            font-size: 0.95rem;
        }

        .price-row:last-child {
            margin-bottom: 0;
            padding-top: 0;
            font-weight: 700;
            font-size: 1.1rem;
        }

        .price-label {
            color: #7f8c8d;
        }

        .price-value {
            color: #2c3e50;
            font-weight: 600;
        }

        /* ✅ Updated to match "Complete Purchase" button */
        .proceed-btn {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #28a745 0%, #218838 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 1.1rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 20px;
        }

        .proceed-btn:hover {
            background: linear-gradient(135deg, #218838 0%, #1e7e34 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(40, 167, 69, 0.3);
        }

        .proceed-btn:disabled {
            background: #ccc;
            cursor: not-allowed;
            transform: none;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .payment-modal-content {
                width: 95%;
                max-height: 95vh;
            }

            .payment-methods {
                flex-direction: column;
            }

            .payment-method {
                min-width: 100%;
            }

            .payment-modal-header h3 {
                font-size: 1.2rem;
            }

            .payment-number .number {
                font-size: 1.2rem;
            }
        }
    </style>

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
                                    <td>৳{{ $cartItems->sum(function ($item) { return $item->course->price ?? 0; }) }}</td>
                                </tr>
                            </table>
                            <button type="button" class="btn btn-success btn-block" onclick="openPaymentModal()">
                                Complete Purchase
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Payment Modal -->
    <div id="paymentModal" class="payment-modal">
        <div class="payment-modal-content">
            <div class="payment-modal-header">
                <h3>Checkout</h3>
                <button type="button" class="modal-close" onclick="closePaymentModal()">×</button>
            </div>
            <div class="payment-modal-body">
                <form action="{{ route('checkout') }}" method="POST" id="paymentForm">
                    @csrf

                    <!-- Payment Methods -->
                    <div class="payment-methods">
                        <label class="payment-method" onclick="selectPayment('bkash')">
                            <input type="radio" name="payment_method" value="bkash" required>
                            <span class="payment-method-label">
                                <span class="payment-icon bkash">bK</span>
                                bKash
                            </span>
                        </label>
                        <label class="payment-method" onclick="selectPayment('nagad')">
                            <input type="radio" name="payment_method" value="nagad" required>
                            <span class="payment-method-label">
                                <span class="payment-icon nagad">N</span>
                                Nagad
                            </span>
                        </label>
                        <label class="payment-method" onclick="selectPayment('rocket')">
                            <input type="radio" name="payment_method" value="rocket" required>
                            <span class="payment-method-label">
                                <span class="payment-icon rocket">R</span>
                                Rocket
                            </span>
                        </label>
                        <label class="payment-method" onclick="selectPayment('upay')">
                            <input type="radio" name="payment_method" value="upay" required>
                            <span class="payment-method-label">
                                <span class="payment-icon upay">U</span>
                                Upay
                            </span>
                        </label>
                    </div>

                    <div class="payment-info">
                        <div class="payment-number">
                            <h4>Personal:</h4>
                            <div class="number">01722197936</div>
                        </div>

                        <div class="qr-code">
                            <div class="qr-placeholder">
                                <img src="{{ asset('images/QR-Code.png') }}" alt="QR Code"
                                    style="width: 100%; height: 100%; object-fit: contain;">
                            </div>
                            <div class="scan-text">Scan QR</div>
                        </div>

                        <div class="price-summary">
                            <div class="price-row">
                                <span class="price-label">Total Price:</span>
                                <span class="price-value">৳{{ $cartItems->sum(function ($item) { return $item->course->price ?? 0; }) }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Name:</label>
                        <input type="text" name="name" required placeholder="Enter your name">
                    </div>

                    <div class="form-group">
                        <label>Email - Not Required:</label>
                        <input type="email" name="email" placeholder="Enter your email (optional)">
                    </div>

                    <div class="form-group">
                        <label>Mobile:</label>
                        <input type="tel" name="mobile" required placeholder="Enter your mobile number">
                    </div>

                    <div class="form-group">
                        <label>Last 4 Digit of Payment Number:</label>
                        <input type="text" name="txnid" required placeholder="Enter last 4 digits" maxlength="4" pattern="[0-9]{4}">
                    </div>

                    <button type="submit" class="proceed-btn">Proceed to Payment</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        const basePrice = {{ $cartItems->sum(function ($item) { return $item->course->price ?? 0; }) }};

        function openPaymentModal() {
            document.getElementById('paymentModal').classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closePaymentModal() {
            document.getElementById('paymentModal').classList.remove('active');
            document.body.style.overflow = 'auto';
        }

        function selectPayment(method) {
            document.querySelectorAll('.payment-method').forEach(el => el.classList.remove('active'));
            event.currentTarget.classList.add('active');
            event.currentTarget.querySelector('input[type="radio"]').checked = true;
        }

        document.getElementById('paymentModal').addEventListener('click', function (e) {
            if (e.target === this) closePaymentModal();
        });

        document.getElementById('paymentForm').addEventListener('submit', function (e) {
            const paymentMethod = document.querySelector('input[name="payment_method"]:checked');
            if (!paymentMethod) {
                e.preventDefault();
                alert('Please select a payment method');
            }
        });
    </script>
@endsection
