@extends('website.layouts.app')

@section('content')

<link rel="stylesheet" href="{{ asset('assets/website/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/website/css/all.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/website/css/aos.css') }}">
<link rel="stylesheet" href="{{ asset('assets/website/css/magnific-popup.css') }}">
<link rel="stylesheet" href="{{ asset('assets/website/css/swiper-bundle.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/website/css/style.css') }}">

<section id="reservation">
   <div class="container">
      <div class="text-center mb-5" data-aos="fade-up">
         <span class="slbl">Book a Table</span>
         <h2 class="stitle">Make a <span>Reservation</span></h2>
         <div class="sline"></div>
         <p class="sdesc mx-auto" style="max-width:480px;">Reserve your table for a memorable dining experience. We recommend booking 24 hours in advance for weekend evenings.</p>
      </div>
      <div class="row g-4 align-items-start">
         <div class="col-lg-4" data-aos="fade-right">
            <div style="background:var(--dark);border-radius:18px;padding:36px;">
               <h4 style="color:#fff;font-size:1.3rem;margin-bottom:8px;">Contact Info</h4>
               <p style="color:rgba(255,255,255,.55);font-size:.85rem;margin-bottom:26px;">We're happy to help you plan the perfect dining experience.</p>
               <div class="d-flex flex-column gap-3">
                  <div class="d-flex align-items-center gap-3">
                     <div style="width:46px;height:46px;border-radius:11px;background:rgba(232,40,26,.2);display:flex;align-items:center;justify-content:center;color:var(--primary);font-size:1.1rem;flex-shrink:0;"><i class="fas fa-clock"></i></div>
                     <div><strong style="display:block;color:#ccc;font-size:.78rem;text-transform:uppercase;letter-spacing:.8px;">Opening Hours</strong><span style="color:#fff;font-size:.87rem;">Wed - Sun, 9 AM - 11 PM</span></div>
                  </div>
                  <div class="d-flex align-items-center gap-3">
                     <div style="width:46px;height:46px;border-radius:11px;background:rgba(232,40,26,.2);display:flex;align-items:center;justify-content:center;color:var(--primary);font-size:1.1rem;flex-shrink:0;"><i class="fas fa-phone-alt"></i></div>
                     <div><strong style="display:block;color:#ccc;font-size:.78rem;text-transform:uppercase;letter-spacing:.8px;">Call for Booking</strong><span style="color:#fff;font-size:.87rem;">+1 (800) 123-4567</span></div>
                  </div>
                  <div class="d-flex align-items-center gap-3">
                     <div style="width:46px;height:46px;border-radius:11px;background:rgba(232,40,26,.2);display:flex;align-items:center;justify-content:center;color:var(--primary);font-size:1.1rem;flex-shrink:0;"><i class="fas fa-users"></i></div>
                     <div><strong style="display:block;color:#ccc;font-size:.78rem;text-transform:uppercase;letter-spacing:.8px;">Group Dining</strong><span style="color:#fff;font-size:.87rem;">Special menus for 10+ guests</span></div>
                  </div>
                  <div class="d-flex align-items-center gap-3">
                     <div style="width:46px;height:46px;border-radius:11px;background:rgba(232,40,26,.2);display:flex;align-items:center;justify-content:center;color:var(--primary);font-size:1.1rem;flex-shrink:0;"><i class="fas fa-map-marker-alt"></i></div>
                     <div><strong style="display:block;color:#ccc;font-size:.78rem;text-transform:uppercase;letter-spacing:.8px;">Location</strong><span style="color:#fff;font-size:.87rem;">42 Flavor Street, NY</span></div>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-lg-8" data-aos="fade-left">
            <div class="fcard">
                <form action="{{ route('reservation.store') }}" method="POST">
                    @csrf

                    {{-- Success Message --}}
                    @if(session('success'))
                        <div class="alert alert-success text-center" style="background:#d4edda;color:#155724;padding:12px;border-radius:8px;margin-bottom:20px;">
                            {{ session('success') }}
                        </div>
                    @endif

                    {{-- Error Messages --}}
                    @if($errors->any())
                        <div class="alert alert-danger text-center" style="background:#f8d7da;color:#721c24;padding:12px;border-radius:8px;margin-bottom:20px;">
                            <ul style="list-style:none;padding:0;margin:0;">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="row g-3">

                        <div class="col-sm-6">
                            <label class="flbl">Full Name *</label>
                            <input type="text" name="name" class="fctrl" placeholder="John Doe" value="{{ old('name') }}" required/>
                        </div>

                        <div class="col-sm-6">
                            <label class="flbl">Phone Number *</label>
                            <input type="tel" name="phone" class="fctrl" placeholder="+1 (800) 000-0000" value="{{ old('phone') }}" required/>
                        </div>

                        <div class="col-sm-6">
                            <label class="flbl">Email Address *</label>
                            <input type="email" name="email" class="fctrl" placeholder="you@email.com" value="{{ old('email') }}" required/>
                        </div>

                        <div class="col-sm-6">
                            <label class="flbl">Number of Guests *</label>
                            <select name="guests" class="fctrl" required>
                                <option value="1">1 Person</option>
                                <option value="2">2 People</option>
                                <option value="4">3 - 4 People</option>
                                <option value="6">5 - 6 People</option>
                                <option value="10">7 - 10 People</option>
                                <option value="10">10+ People</option>
                            </select>
                        </div>

                        {{-- ✅ TABLE SELECTION DROPDOWN --}}
                        <div class="col-sm-6">
                            <label class="flbl">Preferred Table *</label>
                            <select name="table_id" class="fctrl" required>
                                <option value="">Select a table</option>
                                @foreach($tables as $table)
                                    <option value="{{ $table->id }}" {{ old('table_id') == $table->id ? 'selected' : '' }}>
                                        {{ $table->table_number }} (Capacity: {{ $table->capacity }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-sm-6">
                            <label class="flbl">Date *</label>
                            <input type="date" name="reservation_date" class="fctrl" value="{{ old('reservation_date') }}" required/>
                        </div>

                        <div class="col-sm-6">
                            <label class="flbl">Time *</label>
                            <select name="reservation_time" class="fctrl" required>
                                <option value="09:00">09:00 AM</option>
                                <option value="10:00">10:00 AM</option>
                                <option value="11:00">11:00 AM</option>
                                <option value="12:00">12:00 PM</option>
                                <option value="13:00">01:00 PM</option>
                                <option value="14:00">02:00 PM</option>
                                <option value="18:00">06:00 PM</option>
                                <option value="19:00">07:00 PM</option>
                                <option value="20:00">08:00 PM</option>
                                <option value="21:00">09:00 PM</option>
                                <option value="22:00">10:00 PM</option>
                            </select>
                        </div>

                        <div class="col-12">
                            <label class="flbl">Special Requests</label>
                            <textarea name="request" class="fctrl" rows="3" placeholder="Allergies, dietary needs, special occasions...">{{ old('request') }}</textarea>
                        </div>

                        <div class="col-12">
                            <button type="submit" class="btn-red w-100 justify-content-center" id="resBtn">
                                <i class="fas fa-calendar-check"></i>
                                Confirm Reservation
                            </button>
                        </div>

                    </div>

                </form>

                <div class="sucmsg" id="resOk" style="display:none;">
                    <i class="fas fa-check-circle"></i>
                    <p>Table reserved! We'll confirm via email shortly.</p>
                </div>
            </div>
        </div>
      </div>
   </div>
</section>
<br>
<!-- BLOG -->
<section id="blog">
   <div class="container">
      <div class="text-center mb-5" data-aos="fade-up">
         <span class="slbl">News &amp; Updates</span>
         <h2 class="stitle">Our Latest <span>Blog</span> Posts</h2>
         <div class="sline"></div>
      </div>
      <div class="row g-4">
         <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="0">
            <div class="blcard">
               <div class="blimg">
                  <img src="{{ asset('assets/website/img/blog/1.jpg') }}" alt="">
                  <div class="bldatebdg"><span class="bd">14</span><span class="bm">Mar</span></div>
               </div>
               <div class="blbody">
                  <div class="bltag">Food &amp; Health</div>
                  <div class="bltit"><a href="#">Healthy Fast Food: A Myth or Beautiful Reality</a></div>
                  <div class="blmeta"><span><i class="fas fa-user"></i>James Writer</span><span><i class="fas fa-comment"></i>24 Comments</span></div>
                  <a href="#" class="blmore">Read More <i class="fas fa-arrow-right"></i></a>
               </div>
            </div>
         </div>
         <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="80">
            <div class="blcard">
               <div class="blimg">
                  <img src="{{ asset('assets/website/img/blog/2.jpg') }}" alt="">
                  <div class="bldatebdg"><span class="bd">28</span><span class="bm">Feb</span></div>
               </div>
               <div class="blbody">
                  <div class="bltag">Food Science</div>
                  <div class="bltit"><a href="#">Is Fast Food Getting Healthier? Here's What We Found</a></div>
                  <div class="blmeta"><span><i class="fas fa-user"></i>Sarah Grain</span><span><i class="fas fa-comment"></i>18 Comments</span></div>
                  <a href="#" class="blmore">Read More <i class="fas fa-arrow-right"></i></a>
               </div>
            </div>
         </div>
         <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="160">
            <div class="blcard">
               <div class="blimg">
                  <img src="{{ asset('assets/website/img/blog/3.jpg') }}" alt="">
                  <div class="bldatebdg"><span class="bd">05</span><span class="bm">Jan</span></div>
               </div>
               <div class="blbody">
                  <div class="bltag">Recipes</div>
                  <div class="bltit"><a href="#">Innovative Hot Chickpeas Flake Crackin' Recipe at Home</a></div>
                  <div class="blmeta"><span><i class="fas fa-user"></i>Chef Marcus</span><span><i class="fas fa-comment"></i>32 Comments</span></div>
                  <a href="#" class="blmore">Read More <i class="fas fa-arrow-right"></i></a>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>


   <!-- Scripts from public/assets/website/js/ -->
   <script src="{{ asset('assets/website/js/jquery-3.7.1.min.js') }}"></script>
   <script src="{{ asset('assets/website/js/bootstrap.bundle.min.js') }}"></script>
   <script src="{{ asset('assets/website/js/aos.js') }}"></script>
   <script src="{{ asset('assets/website/js/swiper-bundle.min.js') }}"></script>
   <script src="{{ asset('assets/website/js/jquery.magnific-popup.min.js') }}"></script>
   <script src="{{ asset('assets/website/js/main.js') }}"></script>

@endsection