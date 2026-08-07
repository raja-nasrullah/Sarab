@extends('website.layouts.app')

@section('content')

<link rel="stylesheet" href="{{ asset('assets/website/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/website/css/all.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/website/css/aos.css') }}">
<link rel="stylesheet" href="{{ asset('assets/website/css/magnific-popup.css') }}">
<link rel="stylesheet" href="{{ asset('assets/website/css/swiper-bundle.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/website/css/style.css') }}">

<!-- SEARCH OVERLAY -->
<div id="searchOv">
    <button class="sovclose" id="searchClose"><i class="fas fa-times"></i></button>
    <div class="sovbox">
        <h4>What are you craving today?</h4>
        <div class="sovinput">
            <input type="text" id="searchInput" placeholder="Search burgers, pizza, chicken..." autocomplete="off"/>
            <button><i class="fas fa-search"></i></button>
        </div>
        <div class="sovcats">
            <div class="sovcat active" data-cat="all">
                <img src="{{ asset('assets/website/img/menu/1.jpg') }}" alt=""> All Items
            </div>
            <div class="sovcat" data-cat="burgers">
                <img src="{{ asset('assets/website/img/menu/1.jpg') }}" alt=""> Burgers
            </div>
            <div class="sovcat" data-cat="pizza">
                <img src="{{ asset('assets/website/img/menu/2.jpg') }}" alt=""> Pizza
            </div>
            <div class="sovcat" data-cat="chicken">
                <img src="{{ asset('assets/website/img/menu/3.jpg') }}" alt=""> Chicken
            </div>
            <div class="sovcat" data-cat="wraps">
                <img src="{{ asset('assets/website/img/menu/4.jpg') }}" alt=""> Wraps
            </div>
            <div class="sovcat" data-cat="pasta">
                <img src="{{ asset('assets/website/img/menu/5.jpg') }}" alt=""> Pasta
            </div>
            <div class="sovcat active" data-cat="all">
                <img src="{{ asset('assets/website/img/menu/1.jpg') }}" alt=""> testing3
            </div>
            <div class="sovcat" data-cat="desserts">
                <img src="{{ asset('assets/website/img/menu/6.jpg') }}" alt=""> Desserts
            </div>
        </div>
        <div class="sovtrend">
            <p><i class="fas fa-fire me-1" style="color:var(--secondary);"></i>Trending Searches</p>
            <span class="ttag">Smash Burger</span>
            <span class="ttag">Nashville Chicken</span>
            <span class="ttag">Truffle Pizza</span>
            <span class="ttag">Lava Cake</span>
            <span class="ttag">Loaded Fries</span>
            <span class="ttag">Mango Shake</span>
        </div>
    </div>
</div>

<!-- HERO -->
<section id="hero">
    <div class="hs hs1"></div>
    <div class="hs hs2"></div>
    <div class="hbgtxt">FOOD</div>
    <div class="container">
        <div class="row align-items-center g-5" style="min-height:88vh;">
            <div class="col-lg-6">
                <div class="hbadge">
                    <div class="hbi"><i class="fas fa-star"></i></div>
                    <span>#1 Rated Fast Food Restaurant in New York</span>
                </div>
                <h1 class="htitle">Delicious <span class="hl">Fast Food</span><br/>for Every Moment</h1>
                <p class="hdesc">Experience bold flavors crafted from premium ingredients. From crispy burgers to gourmet pizzas - every bite is an adventure worth savoring.</p>
                <div class="d-flex flex-wrap gap-3 mb-2">
                    <a href="#menu" class="btn-red"><i class="fas fa-utensils"></i>Explore Menu</a>
                    <a href="https://www.youtube.com/watch?v=RXv_uIN6e-Y" class="magnific_popup btn-play popup-youtube">
                        <div class="pico"><i class="fas fa-play"></i></div>
                        <span>Watch Our Story</span>
                    </a>
                </div>
                <div class="hstats d-flex gap-3 flex-wrap mt-4">
                    <div class="hstat"><span class="snum">850<em>+</em></span><small>Happy Customers</small></div>
                    <div class="sdiv"></div>
                    <div class="hstat"><span class="snum">120<em>+</em></span><small>Menu Items</small></div>
                    <div class="sdiv"></div>
                    <div class="hstat"><span class="snum">15<em>+</em></span><small>Expert Chefs</small></div>
                    <div class="sdiv"></div>
                    <div class="hstat"><span class="snum">12<em>yr</em></span><small>Experience</small></div>
                </div>
            </div>
            <div class="col-lg-6">
                <div style="position:relative;text-align:center;">
                    <div class="hcircle">
                        <img src="{{ asset('assets/website/img/banner-img.jpg') }}" alt="Burger">
                    </div>
                    <div class="fcard fc1">
                        <div class="fcoi r"><i class="fas fa-fire"></i></div>
                        <div><span class="fcnum">Hot Deal</span><span class="fcsm">30% off today</span></div>
                    </div>
                    <div class="fcard fc2">
                        <div class="fcoi y"><i class="fas fa-star"></i></div>
                        <div><span class="fcnum">4.9/5</span><span class="fcsm">2k+ reviews</span></div>
                    </div>
                    <div class="fcard fc3">
                        <div class="fcoi g"><i class="fas fa-clock"></i></div>
                        <div><span class="fcnum">20 min</span><span class="fcsm">Fast delivery</span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- MARQUEE -->
<div class="mqsec">
    <div class="mqtrack">
        <div class="mqitem"><i class="fas fa-circle"></i>Crispy Fried Chicken</div>
        <div class="mqitem"><i class="fas fa-circle"></i>Gourmet Burgers</div>
        <div class="mqitem"><i class="fas fa-circle"></i>Artisan Pizzas</div>
        <div class="mqitem"><i class="fas fa-circle"></i>Fresh Wraps &amp; Rolls</div>
        <div class="mqitem"><i class="fas fa-circle"></i>Loaded Fries</div>
        <div class="mqitem"><i class="fas fa-circle"></i>Ice Cream Shakes</div>
        <div class="mqitem"><i class="fas fa-circle"></i>Grilled Sandwiches</div>
        <div class="mqitem"><i class="fas fa-circle"></i>Crispy Fried Chicken</div>
        <div class="mqitem"><i class="fas fa-circle"></i>Gourmet Burgers</div>
        <div class="mqitem"><i class="fas fa-circle"></i>Artisan Pizzas</div>
        <div class="mqitem"><i class="fas fa-circle"></i>Fresh Wraps &amp; Rolls</div>
        <div class="mqitem"><i class="fas fa-circle"></i>Loaded Fries</div>
        <div class="mqitem"><i class="fas fa-circle"></i>Ice Cream Shakes</div>
        <div class="mqitem"><i class="fas fa-circle"></i>Grilled Sandwiches</div>
    </div>
</div>

<!-- CATEGORY -->
<section id="category">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="slbl">What We Offering</span>
            <h2 class="stitle">Browse by <span>Category</span></h2>
            <div class="sline"></div>
            <p class="sdesc mx-auto" style="max-width:480px;">From sizzling burgers to exotic world cuisines - find your favourite in our menu</p>
        </div>
        <div class="row g-3 justify-content-center">
            <div class="col-6 col-sm-4 col-md-3 col-lg-2" data-aos="zoom-in" data-aos-delay="0">
                <div class="catcard active" data-filter="all">
                    <img class="catimg" src="{{ asset('assets/website/img/category/1.jpg') }}" alt="All Items">
                    <div class="catnm">All Items</div>
                    <div class="catct">99 items</div>
                </div>
            </div>
            <div class="col-6 col-sm-4 col-md-3 col-lg-2" data-aos="zoom-in" data-aos-delay="70">
                <div class="catcard" data-filter="burgers">
                    <img class="catimg" src="{{ asset('assets/website/img/category/2.jpg') }}" alt="Burgers">
                    <div class="catnm">Burgers</div>
                    <div class="catct">24 items</div>
                </div>
            </div>
            <div class="col-6 col-sm-4 col-md-3 col-lg-2" data-aos="zoom-in" data-aos-delay="140">
                <div class="catcard" data-filter="pizza">
                    <img class="catimg" src="{{ asset('assets/website/img/category/3.jpg') }}" alt="Pizza">
                    <div class="catnm">Pizza</div>
                    <div class="catct">18 items</div>
                </div>
            </div>
            <div class="col-6 col-sm-4 col-md-3 col-lg-2" data-aos="zoom-in" data-aos-delay="210">
                <div class="catcard" data-filter="chicken">
                    <img class="catimg" src="{{ asset('assets/website/img/category/4.jpg') }}" alt="Fried Chicken">
                    <div class="catnm">Fried Chicken</div>
                    <div class="catct">15 items</div>
                </div>
            </div>
            <div class="col-6 col-sm-4 col-md-3 col-lg-2" data-aos="zoom-in" data-aos-delay="280">
                <div class="catcard" data-filter="wraps">
                    <img class="catimg" src="{{ asset('assets/website/img/category/5.jpg') }}" alt="Wraps">
                    <div class="catnm">Wraps</div>
                    <div class="catct">12 items</div>
                </div>
            </div>
            <div class="col-6 col-sm-4 col-md-3 col-lg-2" data-aos="zoom-in" data-aos-delay="350">
                <div class="catcard" data-filter="desserts">
                    <img class="catimg" src="{{ asset('assets/website/img/category/6.jpg') }}" alt="Desserts">
                    <div class="catnm">Desserts</div>
                    <div class="catct">20 items</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ABOUT -->
<section id="about">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-5" data-aos="fade-right">
                <div class="astack">
                    <div class="aexp"><span class="anum">12+</span><small>Years of<br/>Excellence</small></div>
                    <div class="amain"><img src="{{ asset('assets/website/img/about1.jpg') }}" alt="Restaurant"></div>
                    <div class="asm"><img src="{{ asset('assets/website/img/about2.jpg') }}" alt="About"></div>
                </div>
            </div>
            <div class="col-lg-7" data-aos="fade-left">
                <span class="slbl">Our Story</span>
                <h2 class="stitle text-start">We Invite You to Visit<br/>Our <span>Food Restaurant</span></h2>
                <div class="sline lft"></div>
                <p class="sdesc mb-4">Founded in 2012, Sarab began as a small corner joint with a big dream - to serve food that brings people together. Today we're proud to serve thousands of happy customers every week with the same passion that started it all.</p>
                <div class="mb-4">
                    <div class="fti">
                        <div class="ftico r"><i class="fas fa-leaf"></i></div>
                        <div>
                            <h6>100% Fresh Ingredients</h6>
                            <p>We source locally and sustainably. Every ingredient is hand-picked daily for maximum freshness.</p>
                        </div>
                    </div>
                    <div class="fti">
                        <div class="ftico y"><i class="fas fa-award"></i></div>
                        <div>
                            <h6>Award-Winning Recipes</h6>
                            <p>Our signature recipes have won national culinary awards 5 years in a row.</p>
                        </div>
                    </div>
                    <div class="fti">
                        <div class="ftico g"><i class="fas fa-shipping-fast"></i></div>
                        <div>
                            <h6>Lightning-Fast Delivery</h6>
                            <p>Order online and get hot, fresh food at your door in under 25 minutes, guaranteed.</p>
                        </div>
                    </div>
                </div>
                <a href="#menu" class="btn-red"><i class="fas fa-book-open"></i>View Full Menu</a>
            </div>
        </div>
    </div>
</section>

<!-- MENU DETAIL POPUP -->
<div id="menuPop">
    <div class="mpbox">
        <button class="mpclose" id="mpClose"><i class="fas fa-times"></i></button>
        <div class="mpimg"><img id="mpImg" src="" alt=""/></div>
        <div class="mpbody">
            <div id="mpCat"></div>
            <div id="mpTitle"></div>
            <div id="mpStars"></div>
            <div id="mpDesc"></div>
            <div id="mpPrice"></div>
            <div class="mpmeta" id="mpMeta"></div>
            <div class="mpqty">
                <button class="mpqbtn" id="mpMinus">-</button>
                <span class="mpqnum" id="mpQnum">1</span>
                <button class="mpqbtn" id="mpPlus">+</button>
                <span style="font-size:.82rem;color:#aaa;margin-left:9px;">portion</span>
            </div>
            <div class="mptags" id="mpTags"></div>
            <button class="mpaddcart" id="mpAddCart"><i class="fas fa-shopping-cart"></i>Add to Cart</button>
        </div>
    </div>
</div>

<!-- SPECIAL OFFER -->
<section id="special">
    <div class="spbg"></div>
    <div class="container" style="position:relative;z-index:2;">
        <div class="row align-items-center g-5">
            <div class="col-lg-6" data-aos="fade-right">
                <div class="sptag"><i class="fas fa-bolt me-1"></i>Limited Time Offer</div>
                <h2 class="sptitle">Get 30% Off<br/>Our Signature<br/><span>Burger</span> Meal</h2>
                <p class="spdesc">Don't miss our weekend special - grab our award-winning signature burger combo with loaded fries and a premium shake at an unbeatable price.</p>
                <div class="cdwrap">
                    <div class="cditem"><span class="cdnum" id="cdH">08</span><span class="cdlbl">Hours</span></div>
                    <div class="cditem"><span class="cdnum" id="cdM">45</span><span class="cdlbl">Minutes</span></div>
                    <div class="cditem"><span class="cdnum" id="cdS">30</span><span class="cdlbl">Seconds</span></div>
                </div>
                <a href="#menu" class="btn-red"><i class="fas fa-shopping-cart"></i>Grab the Deal</a>
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <div class="spimgw">
                    <div class="spglow"></div>
                    <div class="sppbdg"><span class="old">$24.99</span><span class="np">$17.49</span></div>
                    <img src="{{ asset('assets/website/img/off-img.jpg') }}" alt="Special Burger"/>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- GALLERY -->
<section id="gallery">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="slbl">Food Showcase</span>
            <h2 class="stitle">Let's See Our <span>Fast Food</span></h2>
            <div class="sline"></div>
        </div>
        <div class="ggrid" data-aos="fade-up">
            <div class="gitem" data-gi="0" data-gimg="assets/website/img/portfolio/work1.jpg" data-gtitle="Gourmet Burgers" data-gdesc="Our award-winning smash burgers, hand-crafted with 100% premium beef, aged cheddar and house-made sauces.">
                <img src="{{ asset('assets/website/img/portfolio/work1.jpg') }}" alt="Burgers"/>
                <div class="gover"><span><i class="fas fa-expand-alt"></i> Gourmet Burgers</span></div>
            </div>
            <div class="gitem" data-gi="1" data-gimg="assets/website/img/portfolio/work2.jpg" data-gtitle="Wood-Fired Pizza" data-gdesc="Authentic Neapolitan-style pizzas fired at 900deg F in our wood-burning stone oven for the perfect char.">
                <img src="{{ asset('assets/website/img/portfolio/work2.jpg') }}" alt="Pizza"/>
                <div class="gover"><span><i class="fas fa-expand-alt"></i> Wood-Fired Pizza</span></div>
            </div>
            <div class="gitem" data-gi="2" data-gimg="assets/website/img/portfolio/work3.jpg" data-gtitle="Crispy Fried Chicken" data-gdesc="Double-brined, hand-battered chicken fried to golden perfection using our 15-spice secret blend.">
                <img src="{{ asset('assets/website/img/portfolio/work3.jpg') }}" alt="Chicken"/>
                <div class="gover"><span><i class="fas fa-expand-alt"></i> Crispy Fried Chicken</span></div>
            </div>
            <div class="gitem" data-gi="3" data-gimg="assets/website/img/portfolio/work4.jpg" data-gtitle="Sweet Desserts" data-gdesc="Handcrafted desserts - from molten lava cakes to artisan ice cream sundaes and seasonal pastries.">
                <img src="{{ asset('assets/website/img/portfolio/work4.jpg') }}" alt="Desserts"/>
                <div class="gover"><span><i class="fas fa-expand-alt"></i> Sweet Desserts</span></div>
            </div>
            <div class="gitem" data-gi="4" data-gimg="assets/website/img/portfolio/work5.jpg" data-gtitle="Fresh Wraps &amp; Rolls" data-gdesc="Loaded fresh wraps packed with grilled proteins, crunchy vegetables and our house-made sauces.">
                <img src="{{ asset('assets/website/img/portfolio/work5.jpg') }}" alt="Wraps"/>
                <div class="gover"><span><i class="fas fa-expand-alt"></i> Fresh Wraps &amp; Rolls</span></div>
            </div>
        </div>
    </div>
</section>

<!-- GALLERY POPUP -->
<div id="galPop">
    <div class="gpbox">
        <button class="gpclose" id="gpClose"><i class="fas fa-times"></i></button>
        <img id="gpImg" src="" alt=""/>
        <div class="gpcap">
            <h5 id="gpTitle"></h5>
            <p id="gpDesc"></p>
        </div>
        <div class="gpnav">
            <button id="gpPrev"><i class="fas fa-chevron-left me-1"></i>Prev</button>
            <button id="gpNext">Next <i class="fas fa-chevron-right ms-1"></i></button>
        </div>
    </div>
</div>

<!-- HISTORY -->
<section id="history">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="slbl">Our Journey</span>
            <h2 class="stitle">A History of <span>Restaurant</span></h2>
            <div class="sline"></div>
            <p class="sdesc mx-auto" style="max-width:480px;">From humble beginnings to the city's most beloved restaurant - every chapter written with passion.</p>
        </div>
        <div class="timeline" data-aos="fade-up">
            <div class="tli">
                <div class="tl-left">
                    <div class="tlyear">2012</div>
                    <h5>Evolution of Restaurants</h5>
                    <p>Sarab opens its first 20-seat diner on Flavor Street. Within 3 months, lines stretch around the block every evening as word of our food spreads.</p>
                </div>
                <div class="tl-center">
                    <div class="tldot"></div>
                </div>
                <div class="tl-right">
                    <div class="tlyear">2012</div>
                    <h5>Evolution of Restaurants</h5>
                    <p>Sarab opens its first 20-seat diner on Flavor Street. Within 3 months, lines stretch around the block every evening as word of our food spreads.</p>
                </div>
            </div>
            <div class="tli">
                <div class="tl-left">
                    <div class="tlyear">2015</div>
                    <h5>Fine Dining &amp; The Concept</h5>
                    <p>Expanding the vision - we introduced our signature tasting menu and hired our first Michelin-trained chef, elevating our craft to remarkable new heights.</p>
                </div>
                <div class="tl-center">
                    <div class="tldot"></div>
                </div>
                <div class="tl-right">
                    <div class="tlyear">2015</div>
                    <h5>Fine Dining &amp; The Concept</h5>
                    <p>Expanding the vision - we introduced our signature tasting menu and hired our first Michelin-trained chef, elevating our craft to remarkable new heights.</p>
                </div>
            </div>
            <div class="tli">
                <div class="tl-left">
                    <div class="tlyear">2019</div>
                    <h5>Modern Fast Food Origins</h5>
                    <p>Launched our signature fast-food line, merging gourmet quality with speed and convenience. Within 6 months we won 3 prestigious culinary awards nationally.</p>
                </div>
                <div class="tl-center">
                    <div class="tldot"></div>
                </div>
                <div class="tl-right">
                    <div class="tlyear">2019</div>
                    <h5>Modern Fast Food Origins</h5>
                    <p>Launched our signature fast-food line, merging gourmet quality with speed and convenience. Within 6 months we won 3 prestigious culinary awards nationally.</p>
                </div>
            </div>
            <div class="tli">
                <div class="tl-left">
                    <div class="tlyear">2026</div>
                    <h5>National Expansion</h5>
                    <p>Now operating in 8 cities across the US with an online delivery platform handling 10,000+ orders weekly - and growing every single day.</p>
                </div>
                <div class="tl-center">
                    <div class="tldot"></div>
                </div>
                <div class="tl-right">
                    <div class="tlyear">2026</div>
                    <h5>National Expansion</h5>
                    <p>Now operating in 8 cities across the US with an online delivery platform handling 10,000+ orders weekly - and growing every single day.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- TESTIMONIALS -->
<section id="testimonials">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="slbl">What People Say</span>
            <h2 class="stitle">Our Customers <span>Feedback</span></h2>
            <div class="sline"></div>
        </div>
        <div class="swiper tesSwiper" data-aos="fade-up">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <div class="tescard">
                        <div class="tesq">"</div>
                        <div class="tess"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
                        <p class="testxt">Honestly the best burgers I've ever had. The smash burger is incredible - perfectly crispy edges, juicy inside, and those pickles! We come every Friday now.</p>
                        <div class="tesauth">
                            <img src="{{ asset('assets/website/img/testimonial/1.jpg') }}" alt="Monica Wilber"/>
                            <div>
                                <div class="tesnm">Monica Wilber</div>
                                <div class="tesrl">Regular Customer</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="tescard">
                        <div class="tesq">"</div>
                        <div class="tess"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
                        <p class="testxt">Ordered delivery and the food arrived hot and fresh in 22 minutes. Portions are generous. Sarab has become my go-to comfort food spot without question.</p>
                        <div class="tesauth">
                            <img src="{{ asset('assets/website/img/testimonial/2.jpg') }}" alt="Cameron Fox"/>
                            <div>
                                <div class="tesnm">Cameron Fox</div>
                                <div class="tesrl">Food Blogger</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="tescard">
                        <div class="tesq">"</div>
                        <div class="tess"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
                        <p class="testxt">The truffle pasta blew my mind. I didn't expect that quality from a fast food place. Great ambiance, super friendly staff. Highly recommended!</p>
                        <div class="tesauth">
                            <img src="{{ asset('assets/website/img/testimonial/3.jpg') }}" alt="Priya Sharma"/>
                            <div>
                                <div class="tesnm">Priya Sharma</div>
                                <div class="tesrl">Food Enthusiast</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="tescard">
                        <div class="tesq">"</div>
                        <div class="tess"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
                        <p class="testxt">Catered our office party of 50 people and everything was flawless. Fresh, delicious, on time and well presented. Nashville chicken was the absolute star!</p>
                        <div class="tesauth">
                            <img src="{{ asset('assets/website/img/testimonial/4.jpg') }}" alt="David Park"/>
                            <div>
                                <div class="tesnm">David Park</div>
                                <div class="tesrl">Corporate Client</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="swiper-pagination mt-4" style="position:static;"></div>
        </div>
    </div>
</section>

<!-- NEWSLETTER -->
<section id="newsletter">
    <div class="nlbg"></div>
    <div class="container">
        <div class="nlw text-center" data-aos="zoom-in">
            <span class="slbl" style="color:rgba(255,255,255,.7);">Stay Connected</span>
            <h2 class="mb-3" style="color:#fff;">Subscribe &amp; Get Exclusive <span style="color:var(--secondary);">Deals</span></h2>
            <p class="mb-4" style="color:rgba(255,255,255,.78);">Get 15% off your first order plus early access to new menu items</p>
            <div class="nl-form-wrap">
                <input class="nlinput" type="email" id="nlEmail" placeholder="Enter your email address..."/>
                <button class="nlbtn" id="nlBtn"><i class="fas fa-paper-plane me-1"></i>Subscribe</button>
            </div>
            <p style="color:rgba(255,255,255,.45);font-size:.76rem;margin-top:11px;"><i class="fas fa-lock me-1"></i>No spam, unsubscribe anytime.</p>
        </div>
    </div>
</section>

<!-- Scripts -->
<script src="{{ asset('assets/website/js/jquery-3.7.1.min.js') }}"></script>
<script src="{{ asset('assets/website/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/website/js/aos.js') }}"></script>
<script src="{{ asset('assets/website/js/swiper-bundle.min.js') }}"></script>
<script src="{{ asset('assets/website/js/jquery.magnific-popup.min.js') }}"></script>
<script src="{{ asset('assets/website/js/main.js') }}"></script>

@endsection