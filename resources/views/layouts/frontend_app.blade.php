<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>@yield('title')</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" type="image/png" href="assets/images/favicon.png">
    <!-- Place favicon.ico in the root directory -->
    <!-- all css here -->
    <!-- bootstrap v4.0.0-beta.2 css -->
    <link rel="stylesheet" href="{{asset('frontend_asset')}}/css/bootstrap.min.css">
    <!-- owl.carousel.2.0.0-beta.2.4 css -->
    <link rel="stylesheet" href="{{asset('frontend_asset')}}/css/owl.carousel.min.css">
    <!-- font-awesome v4.6.3 css -->
    <link rel="stylesheet" href="{{asset('frontend_asset')}}/css/font-awesome.min.css">
    <!-- flaticon.css -->
    <link rel="stylesheet" href="{{asset('frontend_asset')}}/css/flaticon.css">
    <!-- jquery-ui.css -->
    <link rel="stylesheet" href="{{asset('frontend_asset')}}/css/jquery-ui.css">
    <!-- metisMenu.min.css -->
    <link rel="stylesheet" href="{{asset('frontend_asset')}}/css/metisMenu.min.css">
    <!-- swiper.min.css -->
    <link rel="stylesheet" href="{{asset('frontend_asset')}}/css/swiper.min.css">
    <!-- style css -->
    <link rel="stylesheet" href="{{asset('frontend_asset')}}/css/styles.css">
    <!-- responsive css -->
    <link rel="stylesheet" href="{{asset('frontend_asset')}}/css/responsive.css">
    <!-- modernizr css -->
    <script src="{{asset('frontend_asset')}}/js/vendor/modernizr-2.8.3.min.js"></script>

    <!-- select2 css -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
</head>

<body>
    <!--Start Preloader-->
    <div class="preloader-wrap">
        <div class="spinner"></div>
    </div>
    <!-- search-form here -->
    <div class="search-area flex-style">
        <span class="closebar">Close</span>
        <div class="container">
            <div class="row">
                <div class="col-md-8 offset-md-2 col-12">
                    <div class="search-form">
                        <form method="POST" action="{{ route('search_products') }}">
                            @csrf
                            <input type="text" name="search_text" placeholder="Search Here...">
                            <button><i class="fa fa-search"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- search-form here -->
    <!-- header-area start -->
    <header class="header-area">
        <div class="header-top bg-2">
            <div class="fluid-container">
                <div class="row">
                    <div class="col-md-6 col-12">
                        <ul class="d-flex header-contact">
                            <li><i class="fa fa-phone"></i> {{contact_info()->phone}}</li>
                            <li><i class="fa fa-envelope"></i> {{contact_info()->email}}</li>
                        </ul>
                    </div>
                    <div class="col-md-6 col-12">
                        <ul class="d-flex account_login-area">
                            @auth
                            <li>
                                <a href="javascript:void(0);"><i class="fa fa-user"></i> {{ Auth::user()->name }} <i
                                        class="fa fa-angle-down"></i></a>
                                <ul class="dropdown_style">
                                    <li><a href="{{ route('home') }}">Dashboard</a></li>
                                </ul>
                            </li>
                            @endauth
                            @guest
                            <li><a href="{{route('login')}}"> Login/Register </a></li>
                            @endguest
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-bottom">
            <div class="fluid-container">
                <div class="row">
                    <div class="col-lg-3 col-md-7 col-sm-6 col-6">
                        <div class="logo">
                            <a href="{{url('/')}}">
                                {{-- <img src="{{asset('frontend_asset')}}/images/logo.png" alt=""> --}}
                                <h3 style="margin: 0">MyCommerce</h3>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-7 d-none d-lg-block">
                        <nav class="mainmenu">
                            <ul class="d-flex">
                                <li class="@yield('home')"><a href="{{url('/')}}">Home</a></li>
                                <li><a href="about.html">About</a></li>
                                <li class="@yield('shop')">
                                    <a href="javascript:void(0);">Shop({{numberofproducts()}}) <i
                                            class="fa fa-angle-down"></i></a>
                                    <ul class="dropdown_style">
                                        <li class="@yield('shop_page')"><a href="{{route('shop_page','all')}}">All
                                                Products</a></li>
                                    </ul>
                                </li>
                                <li>
                                    <a class="@yield('blog_posts')"><a href="{{route('blog_posts')}}">Blog</a>

                                </li>
                                <li class="@yield('contact')"><a href="{{url('contact')}}">Contact</a></li>
                            </ul>
                        </nav>
                    </div>
                    <div class="col-md-4 col-lg-2 col-sm-5 col-4">
                        <ul class="search-cart-wrapper d-flex">
                            <li class="search-tigger"><a href="javascript:void(0);"><i class="flaticon-search"></i></a>
                            </li>
                            {{-- <li class="search-tigger"><a href="javascript:void(0);"><i class="flaticon-like"></i>
                                    <span>2</span></a>
                            </li> --}}
                            <li>
                                <a href="javascript:void(0);"><i class="flaticon-shop"></i>
                                    <span id="cart_count">{{cart_count()}}</span></a>
                                <ul id="cart_content" class="cart-wrap dropdown_style">
                                    @php
                                    $subtotol = 0;
                                    @endphp
                                    @foreach(cart_items() as $cart_item)
                                    <li class="cart-items">
                                        <div class="cart-img">
                                            <img width="60"
                                                src="{{asset('uploads/product_photos/'.$cart_item->product->product_thumbnail_photo)}}"
                                                alt="">
                                        </div>
                                        <div class="cart-content">
                                            <a
                                                href="{{route('product_details',$cart_item->product->slug)}}">{{$cart_item->product->product_name}}</a>
                                            <span>QTY : {{$cart_item->product_quantity}}</span>
                                            <p>${{$cart_item->product->product_price * $cart_item->product_quantity}}
                                            </p>
                                            <a href="{{route('cart.remove',$cart_item->id)}}"><i
                                                    class="fa fa-times"></i></a>
                                        </div>
                                    </li>
                                    @php
                                    $subtotol += $cart_item->product->product_price * $cart_item->product_quantity;
                                    @endphp
                                    @endforeach
                                    <li>Subtotol: <span id="cart_total" class="pull-right">${{$subtotol}}</span></li>
                                    <li>
                                        <a class="btn btn-danger" href="{{route('cart.index')}}">Check Out</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-1 col-sm-1 col-2 d-block d-lg-none">
                        <div class="responsive-menu-tigger">
                            <a href="javascript:void(0);">
                                <span class="first"></span>
                                <span class="second"></span>
                                <span class="third"></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- responsive-menu area start -->
            <div class="responsive-menu-area">
                <div class="container">
                    <div class="row">
                        <div class="col-12 d-block d-lg-none">
                            <ul class="metismenu">
                                <li><a href="{{url('/')}}">Home</a></li>
                                <li><a href="about.html">About</a></li>
                                <li class="sidemenu-items">
                                    <a class="has-arrow" aria-expanded="false" href="javascript:void(0);">Shop </a>
                                    <ul aria-expanded="false">
                                        <li><a href="shop.html">Shop Page</a></li>
                                        <li><a href="single-product.html">Product Details</a></li>
                                        <li><a href="cart.html">Shopping cart</a></li>
                                        <li><a href="checkout.html">Checkout</a></li>
                                        <li><a href="wishlist.html">Wishlist</a></li>
                                    </ul>
                                </li>
                                <li class="sidemenu-items">
                                    <a class="has-arrow" aria-expanded="false" href="javascript:void(0);">Pages </a>
                                    <ul aria-expanded="false">
                                        <li><a href="about.html">About Page</a></li>
                                        <li><a href="single-product.html">Product Details</a></li>
                                        <li><a href="cart.html">Shopping cart</a></li>
                                        <li><a href="checkout.html">Checkout</a></li>
                                        <li><a href="wishlist.html">Wishlist</a></li>
                                        <li><a href="faq.html">FAQ</a></li>
                                    </ul>
                                </li>
                                <li class="sidemenu-items">
                                    <a class="has-arrow" aria-expanded="false" href="javascript:void(0);">Blog</a>
                                    <ul aria-expanded="false">
                                        <li><a href="blog.html">Blog</a></li>
                                        <li><a href="blog-details.html">Blog Details</a></li>
                                    </ul>
                                </li>
                                <li><a href="{{url('contact')}}">Contact</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- responsive-menu area start -->
        </div>
    </header>
    <!-- header-area end -->



    @yield('frontend_content')



    <!-- start social-newsletter-section -->
    <section class="social-newsletter-section" id="newsletter_section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    @error('newsletter_email')
                        <script>window.location.hash = '#newsletter_section';</script>
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    @if (session('success_message'))
                    <div class="alert alert-success" role="alert">
                        <h4 class="alert-heading">{{ session('success_message') }}</h4>
                    </div>
                    @endif
                    <div class="newsletter text-center">
                        <h3>Subscribe Newsletter</h3>
                        <div class="newsletter-form">
                            <form method="post" action="{{ route('newsletter_subscriber.store') }}">
                                @csrf
                                <input type="email" name="newsletter_email" class="form-control"
                                    placeholder="Enter Your Email Address...">
                                <button type="submit"><i class="fa fa-send"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end container -->
    </section>
    <!-- end social-newsletter-section -->
    <!-- .footer-area start -->
    <div class="footer-area">
        <div class="footer-top">
            <div class="container">
                <div class="footer-top-item">
                    <div class="row">
                        <div class="col-lg-12 col-12">
                            <div class="footer-top-text text-center">
                                <ul>
                                    <li><a href="{{url('/')}}">Home</a></li>
                                    <li><a href="#">About</a></li>
                                    <li><a href="{{route('shop_page','all')}}">Shop</a></li>
                                    <li><a href="{{route('blog_posts')}}">Blog</a></li>
                                    <li><a href="{{url('contact')}}">Contact</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="container">
                <div class="row">
                    <div class="col-lg-2 col-md-3 col-sm-12">
                        <div class="footer-icon">
                            <ul class="d-flex">
                                <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                                <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                                <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-8 col-sm-12">
                        <div class="footer-content">
                            <p>On the other hand, we denounce with righteous indignation and dislike men who are so
                                beguiled and demoralized by the charms of pleasure righteous indignation and dislike</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-8 col-sm-12">
                        <div class="footer-adress">
                            <ul>
                                <li><a href="#"><span>Email:</span> {{contact_info()->email}}</a></li>
                                <li><a href="#"><span>Tel:</span> {{contact_info()->phone}}</a></li>
                                <li><a href="#"><span>Adress:</span> {{contact_info()->address}}</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-12">
                        <div class="footer-reserved">
                            <ul>
                                <li>Copyright © {{ Carbon\Carbon::now()->year }} All rights reserved.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- .footer-area end -->
    <!-- Modal area start -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div class="modal-body d-flex">
                    <div class="product-single-img w-50">
                        <img src="{{asset('frontend_asset')}}/images/product/product-details.jpg" alt="">
                    </div>
                    <div class="product-single-content w-50">
                        <h3>Pure Nature Hohey</h3>
                        <div class="rating-wrap fix">
                            <span class="pull-left">$219.56</span>
                            <ul class="rating pull-right">
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                                <li>(05 Customar Review)</li>
                            </ul>
                        </div>
                        <p>On the other hand, we denounce with righteous indignation and dislike men who are so beguiled
                            and demoralized by the charms of pleasure of the moment, so blinded by desire denounce with
                            righteous indignation</p>
                        <ul class="input-style">
                            <li class="quantity cart-plus-minus">
                                <input type="text" value="1" />
                            </li>
                            <li><a href="cart.html">Add to Cart</a></li>
                        </ul>
                        <ul class="cetagory">
                            <li>Categories:</li>
                            <li><a href="#">Honey,</a></li>
                            <li><a href="#">Olive Oil</a></li>
                        </ul>
                        <ul class="socil-icon">
                            <li>Share :</li>
                            <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                            <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                            <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                            <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal area start -->
    <!-- jquery latest version -->
    <script src="{{asset('frontend_asset')}}/js/vendor/jquery-2.2.4.min.js"></script>
    <!-- bootstrap js -->
    <script src="{{asset('frontend_asset')}}/js/bootstrap.min.js"></script>
    <!-- owl.carousel.2.0.0-beta.2.4 css -->
    <script src="{{asset('frontend_asset')}}/js/owl.carousel.min.js"></script>
    <!-- scrollup.js -->
    <script src="{{asset('frontend_asset')}}/js/scrollup.js"></script>
    <!-- isotope.pkgd.min.js -->
    <script src="{{asset('frontend_asset')}}/js/isotope.pkgd.min.js"></script>
    <!-- imagesloaded.pkgd.min.js -->
    <script src="{{asset('frontend_asset')}}/js/imagesloaded.pkgd.min.js"></script>
    <!-- jquery.zoom.min.js -->
    <script src="{{asset('frontend_asset')}}/js/jquery.zoom.min.js"></script>
    <!-- countdown.js -->
    <script src="{{asset('frontend_asset')}}/js/countdown.js"></script>
    <!-- swiper.min.js -->
    <script src="{{asset('frontend_asset')}}/js/swiper.min.js"></script>
    <!-- metisMenu.min.js -->
    <script src="{{asset('frontend_asset')}}/js/metisMenu.min.js"></script>
    <!-- mailchimp.js -->
    <script src="{{asset('frontend_asset')}}/js/mailchimp.js"></script>
    <!-- jquery-ui.min.js -->
    <script src="{{asset('frontend_asset')}}/js/jquery-ui.min.js"></script>
    <!-- main js -->
    <script src="{{asset('frontend_asset')}}/js/scripts.js"></script>

    <!-- select2 css -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

    <!-- sweetalert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <script>
        const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
        })
    </script>

    @yield('script')
</body>


<!-- Mirrored from themepresss.com/tf/html/tohoney/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 13 Mar 2020 03:33:34 GMT -->

</html>
