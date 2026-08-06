@extends('website.layouts.app')

@section('content')

<link rel="stylesheet" href="{{ asset('assets/website/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/website/css/all.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/website/css/aos.css') }}">
<link rel="stylesheet" href="{{ asset('assets/website/css/magnific-popup.css') }}">
<link rel="stylesheet" href="{{ asset('assets/website/css/swiper-bundle.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/website/css/style.css') }}">

<!-- ============================================================
            CONTACT FORM
============================================================ -->
      <section id="contact-section">
         <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
               <span class="slbl">Get In Touch</span>
               <h2 class="stitle">Contact <span>Us</span></h2>
               <div class="sline"></div>
               <p class="sdesc mx-auto" style="max-width:480px;">Have a question, feedback, or want to plan a special event? We'd love to hear from you.</p>
            </div>
            <div class="row g-4">
               <div class="col-lg-4" data-aos="fade-right">
                  <div class="ctdark">
                     <h4>Let's Talk</h4>
                     <p class="ctsub">We typically respond within 2 hours during business hours.</p>
                     <div class="ctitem">
                        <div class="cticon"><i class="fas fa-map-marker-alt"></i></div>
                        <div class="ctinfo"><strong>Address</strong><span>42 Flavor Street, Manhattan,<br/>New York, NY 10001</span></div>
                     </div>
                     <div class="ctitem">
                        <div class="cticon"><i class="fas fa-phone-alt"></i></div>
                        <div class="ctinfo"><strong>Phone</strong><span>+1 (800) 123-4567</span></div>
                     </div>
                     <div class="ctitem">
                        <div class="cticon"><i class="fas fa-envelope"></i></div>
                        <div class="ctinfo"><strong>Email</strong><span>hello@sarabfood.com</span></div>
                     </div>
                     <div class="ctitem">
                        <div class="cticon"><i class="fas fa-clock"></i></div>
                        <div class="ctinfo"><strong>Working Hours</strong><span>Wed - Sun: 9 AM - 11 PM</span></div>
                     </div>
                     <div class="ctsocrow">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                     </div>
                  </div>
               </div>
               <div class="col-lg-8" data-aos="fade-left">
         <div class="fcard">
            <form action="{{ route('contact.store') }}" method="POST">
                  @csrf

                  <div class="row g-3">

                     <div class="col-sm-6">
                        <label class="flbl">Your Name *</label>
                        <input type="text" name="name" class="fctrl" placeholder="John Doe">
                     </div>

                     <div class="col-sm-6">
                        <label class="flbl">Email Address *</label>
                        <input type="email" name="email" class="fctrl" placeholder="you@email.com">
                     </div>

                     <div class="col-sm-6">
                        <label class="flbl">Phone Number</label>
                        <input type="tel" name="phone" class="fctrl" placeholder="+1 (800) 000-0000">
                     </div>

                     <div class="col-sm-6">
                        <label class="flbl">Subject *</label>
                        <select name="subject" class="fctrl">
                              <option value="General Inquiry">General Inquiry</option>
                              <option value="Catering & Events">Catering &amp; Events</option>
                              <option value="Feedback">Feedback</option>
                              <option value="Partnership">Partnership</option>
                              <option value="Media & Press">Media &amp; Press</option>
                        </select>
                     </div>

                     <div class="col-12">
                        <label class="flbl">Message *</label>
                        <textarea name="message" class="fctrl" rows="5" placeholder="Write your message here..."></textarea>
                     </div>

                     <div class="col-12">
                        <button type="submit" class="btn-red" id="ctcBtn">
                              <i class="fas fa-paper-plane"></i> Send Message
                        </button>
                     </div>

                  </div>
            </form>

            <div class="sucmsg" id="ctcOk">
                  <i class="fas fa-check-circle"></i>
                  <p>Message sent! We'll reply within 2 hours.</p>
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

{{-- ✅ UPDATED SCRIPT WITH SWEETALERT --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        @if(session('success'))
            // ✅ Show a beautiful popup instead of the ugly alert
            Swal.fire({
                icon: 'success',
                title: 'Message Sent!',
                text: "{{ session('success') }}",
                timer: 3000,
                showConfirmButton: false,
                timerProgressBar: true,
            });
        @endif

        @if(session('error'))
            // ✅ Show a beautiful error popup if there is an error
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: "{{ session('error') }}",
                confirmButtonColor: '#d32f2f',
            });
        @endif
    });
</script>
      
@endsection