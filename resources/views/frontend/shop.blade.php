@extends('layouts.frontend_app')

@section('shop')
active
@endsection

@section('shop_page')
active
@endsection

@section('title')
{{config('app.name')}} | Shop
@endsection


@section('frontend_content')
<!-- .breadcumb-area start -->
<div class="breadcumb-area bg-img-4 ptb-100">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcumb-wrap text-center">
                    <h2>Shop Page</h2>
                    <ul>
                        <li><a href="{{url('/')}}">Home</a></li>
                        <li><span>Shop</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- .breadcumb-area end -->
<!-- product-area start -->
<div class="product-area pt-100" id="shop_products">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-lg-12">
                <div class="product-menu">
                    <ul class="nav justify-content-center">
                        <li>
                            <a class="{{($selected_category == "all")?"active":""}}" data-toggle="tab" href="#all">All
                                product</a>
                        </li>
                        @foreach ($categories as $category)
                        <li>
                            <a class="{{($selected_category == $category->id)?"active":""}}" data-toggle="tab"
                                href="#c_{{$category->id}}">{{$category->category_name}}</a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="tab-content">
            <div class="tab-pane {{($selected_category == "all")?"active":""}}" id="all">
                <ul class="row">
                    @forelse ($all_products as $product)
                    <li class="col-xl-3 col-lg-4 col-sm-6 col-12 {{($loop->index>3)?"moreload":""}}">
                        <div class="product-wrap">
                            <div class="product-img">
                                <span>Sale</span>
                                <img src="{{asset('uploads/product_photos/'.$product->product_thumbnail_photo)}}"
                                loading="lazy" alt="">
                                <div class="product-icon flex-style">
                                    <ul>
                                        <li><a href="{{ route('product_details',$product->slug) }}"><i
                                                    class="fa fa-eye"></i></a></li>
                                        <li><a onclick="addToCart({{ $product->id }})"><i
                                                    class="fa fa-shopping-bag"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="product-content">
                                <h3><a href="{{route('product_details',$product->slug)}}">{{$product->product_name}}</a>
                                </h3>
                                <p class="pull-left">${{$product->product_price}}

                                </p>
                                <ul class="pull-right d-flex">
                                    @if ($product->reviews)
                                    @for ($i = $product->stars/$product->reviews; $i >= 0; $i--)
                                    @if ($i>0 && $i<1) <li><i class="fa fa-star-half-o"></i>
                    </li>
                    @elseif($i>0)
                    <li><i class="fa fa-star"></i></li>
                    @endif
                    @endfor
                    @endif
                </ul>
            </div>
        </div>
        </li>
        @empty
        <h3 class="text-danger m-auto">Sorry! No products found!</h3>
        @endforelse
        <li class="col-12 text-center">
            <a class="loadmore-btn" href="javascript:void(0);">Load More</a>
        </li>
        </ul>
    </div>
    @foreach ($categories as $category)
    <div class="tab-pane {{($selected_category == $category->id)?"active":""}}" id="c_{{$category->id}}">
        <ul class="row">
            @forelse ($category->products as $product)
            <li class="col-xl-3 col-lg-4 col-sm-6 col-12">
                <div class="product-wrap">
                    <div class="product-img">
                        <span>Sale</span>
                        <img src="{{asset('uploads/product_photos/'.$product->product_thumbnail_photo)}}" loading="lazy" alt="">
                        <div class="product-icon flex-style">
                            <ul>
                                <li><a href="{{ route('product_details',$product->slug) }}"><i
                                            class="fa fa-eye"></i></a></li>
                                <li><a onclick="addToCart({{ $product->id }})"><i class="fa fa-shopping-bag"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="product-content">
                        <h3><a href="{{route('product_details',$product->slug)}}">{{$product->product_name}}</a>
                        </h3>
                        <p class="pull-left">${{$product->product_price}}

                        </p>
                        <ul class="pull-right d-flex">
                            @if ($product->reviews)
                            @for ($i = $product->stars/$product->reviews; $i >= 0; $i--)
                            @if ($i>0 && $i<1) <li><i class="fa fa-star-half-o"></i>
            </li>
            @elseif($i>0)
            <li><i class="fa fa-star"></i></li>
            @endif
            @endfor
            @endif
        </ul>
                    </div>
                </div>
            </li>
            @empty
            <h3 class="text-danger m-auto">Sorry! No products found in this category.</h3>
            @endforelse
        </ul>
    </div>
    @endforeach
</div>
</div>
</div>
<!-- product-area end -->
@endsection


@section('script')
@if ($selected_category != "all")
<script>
    $(document).ready(function () {
        window.location.hash = '#shop_products';
    });
</script>
@endif
<script>
    function addToCart(id) {
        //ajax setup
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        //ajax response start
        $.ajax({
            type: 'POST',
            url: '/add/cart/ajax/' + id,
            data: {
                product_quantity: 1
            },
            success: function (data) {
                Toast.fire({
                    icon: 'success',
                    title: 'Added to cart successfully!'
                })
                $('#cart_count').text(data[0]);
                $('#cart_content').html(data[1]);
            }
        });
        //ajax response stop
    }
</script>
@endsection
