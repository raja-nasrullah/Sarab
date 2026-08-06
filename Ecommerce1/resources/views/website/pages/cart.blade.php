@extends('website.layouts.app')

@section('content')

<link rel="stylesheet" href="{{ asset('assets/website/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/website/css/all.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/website/css/style.css') }}">

<section id="cart-page" style="padding: 60px 0; min-height: 70vh; background: #f8f9fa;">
    <div class="container">
        <div class="text-center mb-4" data-aos="fade-up">
            <h2 class="stitle" style="font-size: 32px;">Your <span>Cart</span></h2>
            <div class="sline"></div>
        </div>

        @if(session('success'))
            <div class="alert alert-success text-center">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger text-center">{{ session('error') }}</div>
        @endif

        <div class="row g-4">
            <!-- LEFT: Cart Items -->
            <div class="col-lg-8">
                @if(count($cart) > 0)
                    @foreach($cart as $id => $details)
                    <div class="card mb-3 border-0 shadow-sm" style="border-radius: 12px; overflow: hidden;" id="cart-item-{{ $id }}">
                        <div class="card-body d-flex align-items-center p-3">
                            <div style="width: 80px; height: 80px; flex-shrink: 0; border-radius: 8px; overflow: hidden; background: #eee;">
                                @if($details['image'])
                                    @if(str_starts_with($details['image'], 'http'))
                                        <img src="{{ $details['image'] }}" style="width:100%; height:100%; object-fit: cover;">
                                    @else
                                        <img src="{{ asset('storage/' . $details['image']) }}" style="width:100%; height:100%; object-fit: cover;">
                                    @endif
                                @else
                                    <div style="display:flex; align-items:center; justify-content:center; height:100%; color:#999; font-size:10px;">No Img</div>
                                @endif
                            </div>
                            
                            <div class="ms-3 flex-grow-1">
                                <h5 class="mb-1 fw-bold">{{ $details['name'] }}</h5>
                                <div class="text-muted small">Qty: {{ $details['quantity'] }}</div>
                            </div>
                            
                            <div class="text-end d-flex align-items-center gap-3">
                                <h5 class="mb-0 text-danger fw-bold">${{ number_format($details['price'] * $details['quantity'], 2) }}</h5>
                                
                                <!-- DELETE BUTTON -->
                                <button onclick="removeFromCart({{ $id }})" class="btn btn-sm btn-outline-danger" style="border-radius: 50%; width: 32px; height: 32px; padding: 0; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="card border-0 shadow-sm p-5 text-center" style="border-radius: 12px;">
                        <i class="fas fa-shopping-cart" style="font-size: 48px; color: #ddd; margin-bottom: 15px;"></i>
                        <h5>Your cart is empty</h5>
                        <a href="{{ route('menu') }}" class="btn btn-red mt-3" style="display:inline-block;">Go to Menu</a>
                    </div>
                @endif
            </div>

            <!-- RIGHT: Order Summary -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm p-4" style="border-radius: 12px; position: sticky; top: 20px;">
                    <h4 class="fw-bold mb-3">Order Summary</h4>
                    <hr>
                    
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Subtotal</span>
                        <span class="fw-bold">${{ number_format($total, 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Delivery</span>
                        <span class="text-success fw-bold">FREE</span>
                    </div>
                    <hr>
                    
                    <div class="d-flex justify-content-between mb-4">
                        <span class="fw-bold fs-5">Total</span>
                        <span class="fw-bold fs-5 text-danger">${{ number_format($total, 2) }}</span>
                    </div>

                    @if(count($cart) > 0)
                    <form action="{{ route('place-order') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label class="flbl">Full Name *</label>
                            <input type="text" name="customer_name" class="fctrl form-control" placeholder="John Doe" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="flbl">Email Address *</label>
                            <input type="email" name="customer_email" class="fctrl form-control" placeholder="you@email.com" required>
                        </div>

                        <!-- Hidden inputs to pass cart items to OrderController -->
                        @foreach($cart as $id => $details)
                            <input type="hidden" name="items[{{ $loop->index }}][id]" value="{{ $id }}">
                            <input type="hidden" name="items[{{ $loop->index }}][quantity]" value="{{ $details['quantity'] }}">
                        @endforeach
                        <input type="hidden" name="total_amount" value="{{ $total }}">

                        <button type="submit" class="btn btn-danger w-100 py-2 mt-2" style="background:#d32f2f; border:none; border-radius:8px; font-weight:600;">
                            <i class="fas fa-check-circle me-2"></i> Place Order
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ✅ NEW: JAVASCRIPT WITH SWEETALERT (JQ ALERT) -->
<script>
    function removeFromCart(itemId) {
        // Beautiful Confirm Popup
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d32f2f',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, remove it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Send AJAX request to delete
                fetch('/cart/remove/' + itemId, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Remove the item card from the DOM
                        const itemElement = document.getElementById('cart-item-' + itemId);
                        if (itemElement) {
                            itemElement.remove();
                        }

                        // Show success popup
                        Swal.fire({
                            icon: 'success',
                            title: 'Removed!',
                            text: data.message,
                            timer: 1500,
                            showConfirmButton: false
                        });

                        // Update the total and subtotal text
                        document.querySelector('.stat-value-row .stat-value').textContent = '$' + data.new_total;

                        // If cart is now empty, reload the page to show empty state
                        if (data.cart_count === 0) {
                            setTimeout(() => {
                                location.reload();
                            }, 1500);
                        }
                    } else {
                        // Show error popup
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.message
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Network Error',
                        text: 'An error occurred while removing the item.'
                    });
                });
            }
        });
    }
</script>

@endsection