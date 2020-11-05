@extends('layouts.frontend_app')


@section('title')
{{env("APP_NAME")}} | Homepage
@endsection

@section('home')
active
@endsection


@section('frontend_content')

<!-- slider-area start -->
<div class="slider-area">
    <div class="swiper-container">
        <div class="swiper-wrapper">
            @foreach ($banners as $banner)
            <div class="swiper-slide overlay">
                <div class="single-slider slide-inner"
                    style="background: url({{asset('uploads/banner_photos/'.$banner->banner_photo)}})">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12 col-lg-9 col-12">
                                <div class="slider-content">
                                    <div class="slider-shape">
                                        <h2 data-swiper-parallax="-500">{{$banner->banner_title}}</h2>
                                        <p data-swiper-parallax="-400">{{$banner->banner_content}}</p>
                                        <a href="{{route('shop_page','all')}}" data-swiper-parallax="-300">Shop Now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="swiper-pagination"></div>
    </div>
</div>
<!-- slider-area end -->
<!-- featured-area start -->
@include('frontend.includes.featured_area')
<!-- featured-area end -->
<!-- start count-down-section -->
<div class="count-down-area count-down-area-sub">
    <section class="count-down-section section-padding parallax" data-speed="7">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-12 text-center">
                    <h2 class="big">Deal Of the Day <span>Contrary to popular belief, Lorem Ipsum is not simply random
                            text. It has roots in a piece of classical Latin</span></h2>
                </div>
                <div class="col-12 col-lg-12 text-center">
                    <div class="count-down-clock text-center">
                        <div id="clock">
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </section>
</div>
<!-- end count-down-section -->
<!-- product-area start -->
<div class="product-area product-area-2">
    <div class="fluid-container">
        <div class="row">
            <div class="col-12">
                <div class="section-title">
                    <h2>Best Seller</h2>
                    <img src="{{asset('frontend_asset')}}/images/section-title.png" alt="">
                </div>
            </div>
        </div>
        <ul class="row">
            @foreach ($best_sellers_after_desc as $best_seller)
            @php
            $best_seller_product = App\Product::findOrFail($best_seller->product_id);
            @endphp
            <li class="col-xl-3 col-lg-4 col-sm-6 col-12">
                <div class="product-wrap">
                    <div class="product-img">
                        <img src="{{asset('uploads/product_photos/'.$best_seller_product->product_thumbnail_photo)}}" alt="">
                        <div class="product-icon flex-style">
                            <ul>
                                <li><a data-toggle="modal" data-target="#exampleModalCenter"
                                        href="{{ route('product_details',$best_seller_product->slug) }}"><i class="fa fa-eye"></i></a></li>
                                <li><a href="wishlist.html"><i class="fa fa-heart"></i></a></li>
                                <li><a href="cart.html"><i class="fa fa-shopping-bag"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="product-content">
                        <h3><a href="{{ route('product_details',$best_seller_product->slug) }}">{{ $best_seller_product->product_name }}</a></h3>
                        <p class="pull-left">${{ $best_seller_product->product_price }}

                        </p>
                        <ul class="pull-right d-flex">
                            @if ($best_seller_product->reviews)
                            @for ($i = 1; $i <= $best_seller_product->stars/$best_seller_product->reviews; $i++)
                                <li><i class="fa fa-star"></i></li>
                            @endfor
                            @endif
                            {{-- <li><i class="fa fa-star-half-o"></i></li> --}}
                        </ul>
                    </div>
                </div>
            </li>
            @endforeach
        </ul>
    </div>
</div>
<!-- product-area end -->
<!-- product-area start -->
<div class="product-area">
    <div class="fluid-container">
        <div class="row">
            <div class="col-12">
                <div class="section-title">
                    <h2>Our Latest Product</h2>
                    <img src="{{asset('frontend_asset')}}/images/section-title.png" alt="">
                </div>
            </div>
        </div>
        <ul class="row">
            @foreach ($products as $product)
            <li class="col-xl-3 col-lg-4 col-sm-6 col-12 {{($loop->index>3)?"moreload":""}}">
                <div class="product-wrap">
                    <div class="product-img">
                        <img src="{{asset('uploads/product_photos/'.$product->product_thumbnail_photo)}}" alt="">
                        <div class="product-icon flex-style">
                            <ul>
                                <li><a data-toggle="modal" data-target="#exampleModalCenter"
                                        href="{{ route('product_details',$product->slug) }}"><i class="fa fa-eye"></i></a></li>
                                <li><a href="wishlist.html"><i class="fa fa-heart"></i></a></li>
                                <li><a href="cart.html"><i class="fa fa-shopping-bag"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="product-content">
                        <h3><a href="{{ route('product_details',$product->slug) }}">{{$product->product_name}}</a></h3>
                        <p class="pull-left">${{$product->product_price}}

                        </p>
                        <ul class="pull-right d-flex">
                            @if ($product->reviews)
                            @for ($i = 1; $i <= $product->stars/$product->reviews; $i++)
                                <li><i class="fa fa-star"></i></li>
                            @endfor
                            @endif
                                {{-- <li><i class="fa fa-star-half-o"></i></li> --}}
                        </ul>
                    </div>
                </div>
            </li>
            @endforeach
            <li class="col-12 text-center">
                <a class="loadmore-btn" href="javascript:void(0);">Load More</a>
            </li>
        </ul>
    </div>
</div>
<!-- product-area end -->
<!-- testmonial-area start -->
<div class="testmonial-area testmonial-area2 bg-img-2 black-opacity">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="test-title text-center">
                    <h2>What Our client Says</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-10 offset-md-1 col-12">
                <div class="testmonial-active owl-carousel">
                    @foreach ($testimonials as $testimonial)
                    <div class="test-items test-items2">
                        <div class="test-content">
                            <p>{{$testimonial->client_message}}</p>
                            <h2>{{$testimonial->client_name}}</h2>
                            <p>{{$testimonial->client_about}}</p>
                        </div>
                        <div class="test-img2">
                            <img src="{{asset('uploads/testimonial_photos/'.$testimonial->client_photo)}}" alt="">
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
<!-- testmonial-area end -->

@endsection
