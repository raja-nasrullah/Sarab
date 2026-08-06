@extends('website.layouts.app')

@section('content')

<link rel="stylesheet" href="{{ asset('assets/website/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/website/css/all.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/website/css/aos.css') }}">
<link rel="stylesheet" href="{{ asset('assets/website/css/style.css') }}">

<section id="order-confirmation" style="padding: 60px 0; background: #f8f9fa; min-height: 70vh;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                
                <div class="card border-0 shadow-lg" style="border-radius: 20px; overflow: hidden;">
                    <!-- Success Header -->
                    <div class="bg-success text-white text-center p-4" style="background: linear-gradient(135deg, #28a745, #1e7e34) !important;">
                        <div style="font-size: 60px; margin-bottom: 10px;">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <h2 class="fw-bold mb-0">Order Placed Successfully!</h2>
                        <p class="mb-0 opacity-75">Thank you for your order. We'll start preparing it right away.</p>
                    </div>

                    <div class="card-body p-4 p-md-5">
                        <!-- Order ID & Date -->
                        <div class="d-flex justify-content-between border-bottom pb-3 mb-4">
                            <div>
                                <small class="text-muted text-uppercase fw-bold">Order ID</small>
                                <h4 class="fw-bold text-primary">#{{ $order->id }}</h4>
                            </div>
                            <div class="text-end">
                                <small class="text-muted text-uppercase fw-bold">Date Placed</small>
                                <h5 class="fw-bold">{{ \Carbon\Carbon::parse($order->order_date)->format('M d, Y \a\t h:i A') }}</h5>
                            </div>
                        </div>

                        <!-- Customer Info -->
                        <div class="bg-light p-3 rounded-3 mb-4">
                            <h6 class="fw-bold mb-1"><i class="fas fa-user me-2 text-muted"></i> Customer Details</h6>
                            <p class="mb-0 text-secondary">
                                <strong>{{ $order->customer ? $order->customer->name : 'Guest' }}</strong><br>
                                <small>{{ $order->customer ? $order->customer->email : 'No email provided' }}</small>
                            </p>
                        </div>

                        <!-- Order Items Table -->
                        <h5 class="fw-bold mb-3">Order Summary</h5>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 50%;">Item</th>
                                        <th class="text-center">Qty</th>
                                        <th class="text-end">Price</th>
                                        <th class="text-end">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->orderItems as $item)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <span class="fw-medium">{{ $item->menuItem ? $item->menuItem->name : 'Unknown Item' }}</span>
                                            </div>
                                        </td>
                                        <td class="text-center">{{ $item->quantity }}</td>
                                        <td class="text-end">${{ number_format($item->price, 2) }}</td>
                                        <td class="text-end fw-bold">${{ number_format($item->quantity * $item->price, 2) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr class="border-top border-3">
                                        <td colspan="3" class="text-end fw-bold fs-5">Total Amount:</td>
                                        <td class="text-end fw-bold fs-5 text-success">${{ number_format($order->total_amount, 2) }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <!-- Actions -->
                        <div class="d-flex gap-3 mt-4">
                            <a href="{{ route('menu') }}" class="btn btn-outline-primary flex-grow-1 py-2 rounded-3">
                                <i class="fas fa-utensils me-2"></i> Continue Ordering
                            </a>
                            <a href="{{ route('home') }}" class="btn btn-primary flex-grow-1 py-2 rounded-3">
                                <i class="fas fa-home me-2"></i> Go to Home
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

@endsection