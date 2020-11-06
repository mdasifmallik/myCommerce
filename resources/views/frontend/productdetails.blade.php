@extends('layouts.frontend_app')


@section('frontend_content')

<div class="breadcumb-area bg-img-4 ptb-100">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcumb-wrap text-center">
                    <h2>Product Details</h2>
                    <ul>
                        <li><a href="{{url('/')}}">Home</a></li>
                        <li><span>{{$product_info->product_name}}</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- .breadcumb-area end -->
<!-- single-product-area start-->
<div class="single-product-area ptb-100">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="product-single-img">
                    <div class="product-active owl-carousel">
                        <div class="item">
                            <img src="{{asset('uploads/product_photos/'.$product_info->product_thumbnail_photo)}}"
                                alt="">
                        </div>
                        @foreach ($product_info->product_images as $product_image)
                        <div class="item">
                            <img src="{{asset('uploads/product_photos/'.$product_image->image_name)}}" alt="">
                        </div>
                        @endforeach
                    </div>
                    <div class="product-thumbnil-active  owl-carousel">
                        <div class="item">
                            <img src="{{asset('uploads/product_photos/'.$product_info->product_thumbnail_photo)}}"
                                alt="">
                        </div>
                        @foreach ($product_info->product_images as $product_image)
                        <div class="item">
                            <img src="{{asset('uploads/product_photos/'.$product_image->image_name)}}" alt="">
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="product-single-content">
                    <h3>{{$product_info->product_name}}</h3>
                    <div class="rating-wrap fix">
                        <span class="pull-left">${{$product_info->product_price}}</span>
                        <ul class="rating pull-right">
                            @if ($product_info->reviews)
                            @for ($i = 1; $i <= $product_info->stars/$product_info->reviews; $i++)
                                <li><i class="fa fa-star"></i></li>
                            @endfor
                            @endif
                            <li>({{ $product_info->reviews }} Customar Review)</li>
                        </ul>
                    </div>
                    <p>{{$product_info->product_short_description}}</p>
                    <ul class="input-style">
                        {{-- <form method="post" action="{{route('add_cart',$product_info->id)}}">
                            @csrf

                            <li class="quantity cart-plus-minus">
                                <input type="text" value="1" name="product_quantity" />
                            </li>
                            <li><button class="btn btn-danger" type="submit">Add to Cart</button></li>
                        </form> --}}
                        <li class="quantity cart-plus-minus">
                            <input id="product_quantity" type="text" value="1" name="product_quantity" />
                        </li>
                        <li><button id="addToCartBtn" class="btn btn-danger" type="submit">Add to Cart</button></li>
                    </ul>
                    <ul class="cetagory">
                        <li>Categories:</li>
                        <li><a href="#">{{$product_info->category->category_name}}</a></li>
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
        <div class="row mt-60">
            <div class="col-12">
                <div class="single-product-menu">
                    <ul class="nav">
                        <li><a class="active" data-toggle="tab" href="#description">Description</a> </li>
                        <li><a data-toggle="tab" href="#tag">Faq</a></li>
                        <li><a data-toggle="tab" href="#review">Review</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-12">
                <div class="tab-content">
                    <div class="tab-pane active" id="description">
                        <div class="description-wrap">
                            {{$product_info->product_long_description}}
                        </div>
                    </div>
                    <div class="tab-pane" id="tag">
                        <div class="faq-wrap" id="accordion">
                            @foreach ($faqs as $faq)
                            @php
                            $f = new NumberFormatter("en", NumberFormatter::SPELLOUT);
                            $n = Str::title($f->format($loop->iteration))
                            @endphp
                            <div class="card">
                                <div class="card-header" id="heading{{$n}}">
                                    <h5><button class="{{($n != "One")?'collapsed':''}}" data-toggle="collapse"
                                            data-target="#collapse{{$n}}" aria-expanded="true"
                                            aria-controls="collapse{{$n}}">{{$faq->question}}</button> </h5>
                                </div>
                                <div id="collapse{{$n}}" class="collapse {{($n == "One")?'show':''}}"
                                    aria-labelledby="heading{{$n}}" data-parent="#accordion">
                                    <div class="card-body">
                                        {{$faq->answer}}
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="tab-pane" id="review">
                        <div class="review-wrap">
                            <ul>
                                @foreach ($reviews as $review)
                                <li class="review-items">
                                    <div class="review-content">
                                        <h3><a href="#">{{ $review->user->name }}</a></h3>
                                        <span>{{ $review->updated_at }}</span>
                                        <p>{{ $review->review }}</p>
                                        <ul class="rating">
                                            @for ($i = 0; $i < $review->stars; $i++)
                                                <li><i class="fa fa-star"></i></li>
                                                @endfor
                                        </ul>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        @auth
                        @if ($order_detail_id)
                        <div class="add-review">
                            <h4>Add A Review</h4>
                            <form method="POST" action="{{ route('review_post') }}">
                                @csrf

                                <input type="hidden" name="order_detail_id" value="{{ $order_detail_id }}">
                                <div class="ratting-wrap">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>task</th>
                                                <th>1 Star</th>
                                                <th>2 Star</th>
                                                <th>3 Star</th>
                                                <th>4 Star</th>
                                                <th>5 Star</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>How Many Stars?</td>
                                                <td>
                                                    <input type="radio" name="stars" value="1" />
                                                </td>
                                                <td>
                                                    <input type="radio" name="stars" value="2" />
                                                </td>
                                                <td>
                                                    <input type="radio" name="stars" value="3" />
                                                </td>
                                                <td>
                                                    <input type="radio" name="stars" value="4" />
                                                </td>
                                                <td>
                                                    <input type="radio" name="stars" value="5" />
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <h4>Your Review:</h4>
                                        <textarea name="message" id="message" cols="30" rows="10"
                                            placeholder="Your review here..."></textarea>
                                    </div>
                                    <div class="col-12">
                                        <button class="btn-style">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        @else
                        <span>Buy This product first to review!</span>
                        @endif
                        @endauth
                        @guest
                        <span>Please Login first to add a review!</span>
                        @endguest
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- single-product-area end-->
<!-- featured-product-area start -->
<div class="featured-product-area">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-title text-left">
                    <h2>Related Product</h2>
                </div>
            </div>
        </div>
        <div class="row">
            @forelse ($related_products as $related_product)
            <div class="col-lg-3 col-sm-6 col-12">
                <div class="featured-product-wrap">
                    <div class="featured-product-img">
                        <img src="{{asset('uploads/product_photos/'.$related_product->product_thumbnail_photo)}}" alt="">
                    </div>
                    <div class="featured-product-content">
                        <div class="row">
                            <div class="col-7">
                                <h3><a
                                        href="{{route('product_details',$related_product->slug)}}">{{$related_product->product_name}}</a>
                                </h3>
                                <p>${{$related_product->product_price}}</p>
                            </div>
                            <div class="col-5 text-right">
                                <ul>
                                    <li><a onclick="addToCart({{ $related_product->id }})"><i class="fa fa-shopping-cart"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="alert alert-danger">
                No related products available!
            </div>
            @endforelse
        </div>
    </div>
</div>
<!-- featured-product-area end -->

@endsection


@section('script')

<script>
    $(document).ready(function (){
        $('#addToCartBtn').click(function () {
            const product_quantity = $('#product_quantity').val();

            //ajax setup
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            //ajax response start
            $.ajax({
                type: 'POST',
                url: '/add/cart/ajax/{{$product_info->id}}',
                data: {
                    product_quantity: product_quantity
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
        });
    });

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
                url: '/add/cart/ajax/'+id,
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
