@extends('website.layouts.app')

@section('content')

<link rel="stylesheet" href="{{ asset('assets/website/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/website/css/all.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/website/css/aos.css') }}">
<link rel="stylesheet" href="{{ asset('assets/website/css/magnific-popup.css') }}">
<link rel="stylesheet" href="{{ asset('assets/website/css/swiper-bundle.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/website/css/style.css') }}">

<section id="menu">
   <div class="container">
      <div class="text-center mb-5" data-aos="fade-up">
         <span class="slbl">What's Cooking</span>
         <h2 class="stitle">Our Delicious <span>Menu</span></h2>
         <div class="sline"></div>
      </div>
      <div class="text-center mb-4" data-aos="fade-up">
         <button class="filtbtn active" data-f="all">All</button>
         @foreach($categories as $category)
            <button class="filtbtn" data-f="{{ strtolower($category->name) }}">
               {{ $category->name }}
            </button>
         @endforeach
      </div>
      <div class="row g-4" id="mgrid">
         
         {{-- Loop through real database menu items --}}
         @foreach($menuItems as $item)
         <div class="col-sm-6 col-lg-4 mwrap" data-c="{{ strtolower($item->category->name ?? '') }}" data-aos="fade-up">
            <div class="mcard">
               <div class="mimg">
                  @if($item->image)
                     @if(str_starts_with($item->image, 'http'))
                        <img src="{{ $item->image }}" alt="{{ $item->name }}"/>
                     @else
                        <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}"/>
                     @endif
                  @else
                     <div style="background:#eee;height:100%;display:flex;align-items:center;justify-content:center;color:#999;font-size:12px;">No Image</div>
                  @endif
                  
                  <div class="mbdg"><i class="fas fa-star"></i> {{ $item->status }}</div>
                  <div class="mhrt"><i class="far fa-heart"></i></div>
               </div>
               <div class="mbody">
                  <div class="mcat">{{ $item->category->name ?? 'Uncategorized' }}</div>
                  <div class="mtit">{{ $item->name }}</div>
                  <div class="mdesc">Freshly prepared with premium ingredients.</div>
                  <div class="mfoot">
                     <div>
                        <div class="mprice">${{ number_format($item->price, 2) }}</div>
                        <div class="mstars"><i class="fas fa-star"></i> <span style="color:#bbb;font-size:.7rem;">(4.8)</span></div>
                     </div>
                     {{-- Quick View Button --}}
                     <button class="madd" title="Quick View" onclick="openQuickView({{ $item->id }})">
                        <i class="fas fa-eye"></i>
                     </button>
                  </div>
               </div>
            </div>
         </div>
         @endforeach

      </div>
      <div class="text-center mt-5"><a href="#" class="btn-red"><i class="fas fa-th-large"></i>View Full Menu</a></div>
   </div>
</section>

<!-- ============================================ -->
<!-- QUICK VIEW MODAL (No Checkout Form Inside) -->
<!-- ============================================ -->
<div id="quickViewModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius:16px;overflow:hidden;border:none;">
            <div class="row g-0">
                <!-- Left Side: Image -->
                <div class="col-md-6" style="background:#f5f5f5;min-height:400px;">
                    <img id="qvImage" src="" alt="Product Image" style="width:100%;height:100%;object-fit:cover;">
                </div>
                
                <!-- Right Side: Details -->
                <div class="col-md-6 p-4">
                    <button type="button" class="btn-close float-end" data-bs-dismiss="modal" aria-label="Close"></button>
                    
                    <!-- Category -->
                    <div id="qvCategory" style="color:#d32f2f;font-weight:700;font-size:13px;text-transform:uppercase;letter-spacing:0.5px;margin-top:10px;">Category</div>
                    
                    <!-- Title -->
                    <h2 id="qvTitle" style="font-family:serif;font-weight:700;font-size:28px;margin:8px 0 10px;">Item Name</h2>
                    
                    <!-- Rating -->
                    <div class="mb-2">
                        <span style="color:#ffc107;">⭐⭐⭐⭐⭐</span>
                        <span id="qvRating" style="color:#888;font-size:14px;">4.9 (128 reviews)</span>
                    </div>
                    
                    <!-- Description -->
                    <p id="qvDesc" style="color:#555;font-size:15px;line-height:1.6;margin-bottom:16px;">Description goes here.</p>
                    
                    <!-- Price -->
                    <div class="mb-3">
                        <span id="qvPrice" style="color:#d32f2f;font-size:28px;font-weight:700;">$14.99</span>
                        <span id="qvOldPrice" style="color:#aaa;font-size:18px;text-decoration:line-through;margin-left:10px;">$18.99</span>
                    </div>

                    <!-- Nutrients -->
                    <div class="d-flex gap-3 mb-4">
                        <div style="background:#f5f5f5;padding:8px 16px;border-radius:8px;text-align:center;min-width:70px;">
                            <div style="font-weight:700;font-size:14px;">620</div>
                            <div style="font-size:11px;color:#888;">Calories</div>
                        </div>
                        <div style="background:#f5f5f5;padding:8px 16px;border-radius:8px;text-align:center;min-width:70px;">
                            <div style="font-weight:700;font-size:14px;">12 min</div>
                            <div style="font-size:11px;color:#888;">Prep Time</div>
                        </div>
                        <div style="background:#f5f5f5;padding:8px 16px;border-radius:8px;text-align:center;min-width:70px;">
                            <div style="font-weight:700;font-size:14px;">4.9/5</div>
                            <div style="font-size:11px;color:#888;">Rating</div>
                        </div>
                    </div>

                    <!-- Quantity Selector -->
                    <div class="d-flex align-items-center gap-3 mb-4">
                        <button onclick="changeQty(-1)" style="width:32px;height:32px;border-radius:50%;border:1px solid #d32f2f;background:white;color:#d32f2f;font-size:18px;cursor:pointer;">−</button>
                        <span id="qvQty" style="font-size:18px;font-weight:600;min-width:20px;text-align:center;">1</span>
                        <button onclick="changeQty(1)" style="width:32px;height:32px;border-radius:50%;border:1px solid #d32f2f;background:white;color:#d32f2f;font-size:18px;cursor:pointer;">+</button>
                        <span style="color:#888;font-size:14px;margin-left:8px;">portion</span>
                    </div>

                    <!-- Tags -->
                    <div class="d-flex gap-2 mb-4">
                        <span style="background:#f5f0e8;padding:4px 12px;border-radius:12px;font-size:12px;font-weight:500;">Spicy</span>
                        <span style="background:#f5f0e8;padding:4px 12px;border-radius:12px;font-size:12px;font-weight:500;">Bestseller</span>
                        <span style="background:#f5f0e8;padding:4px 12px;border-radius:12px;font-size:12px;font-weight:500;">Beef</span>
                    </div>

                    <!-- ✅ Updated: Only "Add to Cart" button (No Checkout Form) -->
                    <div id="checkoutSection">
                        <button onclick="addToCart()" class="btn btn-danger w-100 py-2" style="background:#d32f2f;border:none;border-radius:8px;font-weight:600;">
                            <i class="fas fa-shopping-cart"></i> Add to Cart
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="{{ asset('assets/website/js/jquery-3.7.1.min.js') }}"></script>
<script src="{{ asset('assets/website/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/website/js/aos.js') }}"></script>
<script src="{{ asset('assets/website/js/swiper-bundle.min.js') }}"></script>
<script src="{{ asset('assets/website/js/jquery.magnific-popup.min.js') }}"></script>
<script src="{{ asset('assets/website/js/main.js') }}"></script>

<script>
    $(document).ready(function() {
        // Menu Filter Functionality
        $('.filtbtn').on('click', function() {
            $('.filtbtn').removeClass('active');
            $(this).addClass('active');
            
            var filterValue = $(this).data('f');
            
            $('.mwrap').each(function() {
                if (filterValue === 'all') {
                    $(this).fadeIn(300);
                } else {
                    if ($(this).data('c') === filterValue) {
                        $(this).fadeIn(300);
                    } else {
                        $(this).fadeOut(300);
                    }
                }
            });
        });
    });

    // ------------------------------------------------
    // QUICK VIEW & SESSION-BASED ADD TO CART
    // ------------------------------------------------
    let qty = 1;
    let currentItem = null; // To store the current item data temporarily

    function changeQty(amount) {
        qty += amount;
        if (qty < 1) qty = 1;
        document.getElementById('qvQty').textContent = qty;
    }

    function openQuickView(id) {
        // Reset UI for new item
        qty = 1;
        document.getElementById('qvQty').textContent = 1;

        fetch(`/api/menu-items/${id}`)
            .then(res => res.json())
            .then(item => {
                currentItem = item; // Save the item data globally
                
                document.getElementById('qvCategory').textContent = item.category ? item.category.name : 'Uncategorized';
                document.getElementById('qvTitle').textContent = item.name;
                document.getElementById('qvDesc').textContent = 'Freshly prepared with premium ingredients.';
                
                const img = document.getElementById('qvImage');
                if (item.image) {
                    if (item.image.startsWith('http')) {
                        img.src = item.image;
                    } else {
                        img.src = '/storage/' + item.image;
                    }
                } else {
                    img.src = 'https://via.placeholder.com/400x400?text=No+Image';
                }

                const price = parseFloat(item.price);
                document.getElementById('qvPrice').textContent = '$' + price.toFixed(2);
                const oldPrice = (price * 1.2).toFixed(2);
                document.getElementById('qvOldPrice').textContent = '$' + oldPrice;

                const modal = new bootstrap.Modal(document.getElementById('quickViewModal'));
                modal.show();
            })
            .catch(err => alert('Error loading item details'));
    }

    // ✅ NEW SESSION-BASED ADD TO CART
        // ✅ NEW SESSION-BASED ADD TO CART WITH SWEETALERT
    function addToCart() {
        if (!currentItem) {
            Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: 'No item selected.',
            });
            return;
        }

        // Send AJAX request to the new Session-based CartController
        fetch('/cart/add', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                item_id: currentItem.id,
                quantity: qty
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                // ✅ REPLACED UGLY ALERT WITH BEAUTIFUL SWEETALERT
                Swal.fire({
                    icon: 'success',
                    title: 'Added to Cart!',
                    text: data.message + " 🛒 (" + data.cart_count + " items)",
                    timer: 2000,
                    showConfirmButton: false
                });
                
                // Close the modal automatically
                const modalEl = document.getElementById('quickViewModal');
                const modal = bootstrap.Modal.getInstance(modalEl);
                modal.hide();

                // Optional: Update a navbar cart count badge if you add one later
                // const badge = document.getElementById('cart-count-badge');
                // if (badge) badge.textContent = data.cart_count;
            } else {
                // ✅ REPLACED UGLY ALERT WITH BEAUTIFUL SWEETALERT
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: data.message || 'Could not add to cart.'
                });
            }
        })
        .catch(err => {
            console.error(err);
            // ✅ REPLACED UGLY ALERT WITH BEAUTIFUL SWEETALERT
            Swal.fire({
                icon: 'error',
                title: 'Network Error',
                text: 'Please try again.'
            });
        });
    }
</script>

@endsection