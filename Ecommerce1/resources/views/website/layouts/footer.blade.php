<style>
/*==========================
        FOOTER
==========================*/
footer{
    background:#1b1b1b;
    color:#999;
    padding-top:70px;
}

footer .container{
    max-width:1200px;
}

/* Logo */
.f-logo{
    font-family:"Playfair Display",serif;
    font-size:52px;
    font-weight:900;
    color:#fff;
    line-height:1;
    margin-bottom:22px;
}

.f-logo span{
    color:#e8281a;
}

.f-desc{
    font-size:16px;
    line-height:1.9;
    color:#777;
    max-width:340px;
    margin-bottom:28px;
}

/* Social */

.f-social{
    display:flex;
    gap:10px;
}

.f-social a{
    width:42px;
    height:42px;
    background:#252525;
    border-radius:10px;
    display:flex;
    justify-content:center;
    align-items:center;
    color:#777;
    transition:.35s;
    text-decoration:none;
}

.f-social a:hover{
    background:#e8281a;
    color:#fff;
    transform:translateY(-3px);
}

/* Titles */

.f-title{
    color:#fff;
    font-weight:700;
    font-size:22px;
    margin-bottom:28px;
    position:relative;
    display:inline-block;
    padding-bottom:10px;
}

.f-title::after{
    content:'';
    position:absolute;
    left:0;
    bottom:0;
    width:70px;
    height:2px;
    background:#e8281a;
}

/* Links */

.f-links{
    list-style:none;
    padding:0;
    margin:0;
}

.f-links li{
    margin-bottom:14px;
}

.f-links a{
    color:#888;
    text-decoration:none;
    transition:.3s;
    display:flex;
    align-items:center;
}

.f-links a i{
    color:#e8281a;
    font-size:11px;
    margin-right:10px;
}

.f-links a:hover{
    color:#fff;
    padding-left:8px;
}

/* Contact */

.contact-item{
    display:flex;
    margin-bottom:22px;
}

.contact-icon{
    width:42px;
    height:42px;
    background:rgba(232,40,26,.12);
    color:#e8281a;
    border-radius:10px;
    display:flex;
    justify-content:center;
    align-items:center;
    margin-right:15px;
    flex-shrink:0;
}

.contact-text strong{
    display:block;
    color:#fff;
    font-size:15px;
    margin-bottom:4px;
}

.contact-text{
    color:#888;
    line-height:1.7;
}

/* Bottom */

.footer-bottom{
    margin-top:60px;
    border-top:1px solid rgba(255,255,255,.08);
    padding:22px 0;
}

.footer-bottom p{
    margin:0;
    color:#666;
    line-height:1.8;
}

.footer-bottom span{
    color:#e8281a;
}

.footer-bottom .links{
    display:flex;
    gap:28px;
}

.footer-bottom .links a{
    color:#666;
    text-decoration:none;
    transition:.3s;
}

.footer-bottom .links a:hover{
    color:#fff;
}

@media(max-width:991px){

footer{
text-align:center;
}

.f-desc{
margin:auto auto 25px;
}

.f-social{
justify-content:center;
margin-bottom:40px;
}

.contact-item{
justify-content:center;
text-align:left;
}

.footer-bottom{
text-align:center;
}

.footer-bottom .links{
justify-content:center;
margin-top:15px;
}

}
</style>


<footer>

<div class="container">

<div class="row gy-5 justify-content-between">

<div class="col-lg-4">

<div class="f-logo">Sar<span>ab</span></div>

<p class="f-desc">
We bring the world's finest flavors together in a fast, friendly, and affordable experience. Every meal crafted with love.
</p>

<div class="f-social">

<a href="#"><i class="fab fa-facebook-f"></i></a>
<a href="#"><i class="fab fa-instagram"></i></a>
<a href="#"><i class="fab fa-twitter"></i></a>
<a href="#"><i class="fab fa-youtube"></i></a>
<a href="#"><i class="fab fa-tiktok"></i></a>

</div>

</div>

<div class="col-lg-2 col-md-6">

<h4 class="f-title">Quick Links</h4>

<ul class="f-links">

<li><a href="{{ route('home') }}"><i class="fas fa-chevron-right"></i>Home</a></li>
<li><a href="#"><i class="fas fa-chevron-right"></i>About Us</a></li>
<li><a href="{{ route('menu') }}"><i class="fas fa-chevron-right"></i>Our Menu</a></li>
<li><a href="{{ route('reservation') }}"><i class="fas fa-chevron-right"></i>Reservation</a></li>
<li><a href="#"><i class="fas fa-chevron-right"></i>Blog</a></li>
<li><a href="{{ route('contact') }}"><i class="fas fa-chevron-right"></i>Contact</a></li>

</ul>

</div>

<div class="col-lg-2 col-md-6">

<h4 class="f-title">Our Menu</h4>

<ul class="f-links">

<li><a href="#"><i class="fas fa-chevron-right"></i>Burgers</a></li>
<li><a href="#"><i class="fas fa-chevron-right"></i>Pizza</a></li>
<li><a href="#"><i class="fas fa-chevron-right"></i>Fried Chicken</a></li>
<li><a href="#"><i class="fas fa-chevron-right"></i>Wraps & Rolls</a></li>
<li><a href="#"><i class="fas fa-chevron-right"></i>Pasta</a></li>
<li><a href="#"><i class="fas fa-chevron-right"></i>Desserts</a></li>

</ul>

</div>

<div class="col-lg-3">

<h4 class="f-title">Get In Touch</h4>

<div class="contact-item">

<div class="contact-icon">
<i class="fas fa-map-marker-alt"></i>
</div>

<div class="contact-text">
<strong>Address</strong>
42 Flavor Street, Manhattan, NY 10001
</div>

</div>

<div class="contact-item">

<div class="contact-icon">
<i class="fas fa-phone-alt"></i>
</div>

<div class="contact-text">
<strong>Phone</strong>
+1 (800) 123-4567
</div>

</div>

<div class="contact-item">

<div class="contact-icon">
<i class="fas fa-envelope"></i>
</div>

<div class="contact-text">
<strong>Email</strong>
hello@sarabfood.com
</div>

</div>

<div class="contact-item">

<div class="contact-icon">
<i class="fas fa-clock"></i>
</div>

<div class="contact-text">
<strong>Hours</strong>
Wed - Sun: 09 AM - 11 PM
</div>

</div>

</div>

</div>

</div>

<div class="footer-bottom">

<div class="container">

<div class="d-flex justify-content-between align-items-center flex-wrap">

<p>
© 2026 <span>Sarab Restaurant</span>. All Rights Reserved.
Made with <span><i class="fas fa-heart"></i></span>
</p>

<div class="links">

<a href="#">Privacy Policy</a>

<a href="#">Terms</a>

<a href="#">Cookies</a>

</div>

</div>

</div>

</div>

</footer>