@extends('layouts.frontend_app')

@section('title')
{{env("APP_NAME")}} | Cart
@endsection


@section('frontend_content')
<!-- .breadcumb-area start -->
<div class="breadcumb-area bg-img-4 ptb-100">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcumb-wrap text-center">
                    <h2>Shopping Cart</h2>
                    <ul>
                        <li><a href="{{url('/')}}">Home</a></li>
                        <li><span>Shopping Cart</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- .breadcumb-area end -->
<!-- cart-area start -->
<div class="cart-area ptb-100" id="c_cart_a">
    <div class="container">
        @if (session('error_msg'))
            <div class="alert alert-danger">{{ session('error_msg') }}</div>
        @endif
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <div class="row">
            <div class="col-12">
                <form method="post" action="{{route('update_cart')}}">
                    @csrf
                    <table class="table-responsive cart-wrap">
                        <thead>
                            <tr>
                                <th class="images">Image</th>
                                <th class="product">Product</th>
                                <th class="ptice">Price</th>
                                <th class="quantity">Quantity</th>
                                <th class="total">Total</th>
                                <th class="remove">Remove</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $subtotal = 0;
                            $flag = 0;
                            @endphp
                            @forelse(cart_items() as $cart_item)
                            <tr>
                                <td class="images"><img
                                        src="{{asset('uploads/product_photos/'.$cart_item->product->product_thumbnail_photo)}}"
                                        alt=""></td>
                                <td class="product"><a href="{{route('product_details',$cart_item->product->slug)}}"
                                        target="blank">{{$cart_item->product->product_name}}</a>
                                    @if($cart_item->product->product_quantity < $cart_item->product_quantity)
                                        <br>
                                        <span class="text-danger">{{$cart_item->product->product_quantity}} product is
                                            available. You have to reduce
                                            {{$cart_item->product_quantity - $cart_item->product->product_quantity}}
                                            products!</span>
                                        @php
                                        $flag++;
                                        @endphp
                                        @elseif($cart_item->product->product_quantity == 0)
                                        <br>
                                        <span>This product ran out of stock. You have to remove this product!</span>
                                        @php
                                        $flag++;
                                        @endphp
                                        @endif
                                </td>
                                <td class="ptice">${{$cart_item->product->product_price}}</td>
                                <td class="quantity cart-plus-minus">
                                    <input type="text" name="product_info[{{$cart_item->id}}]"
                                        value="{{$cart_item->product_quantity}}" />
                                </td>
                                <td class="total">${{$cart_item->product->product_price * $cart_item->product_quantity}}
                                </td>
                                <td class="remove"><a href="{{route('cart.remove',$cart_item->id)}}"><i
                                            class="fa fa-times"></i></a></td>
                            </tr>
                            @php
                            $subtotal += $cart_item->product->product_price * $cart_item->product_quantity;
                            @endphp
                            @empty
                            <tr>
                                <td colspan="50" class="text-center text-danger">No products to show.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="row mt-60">
                        <div class="col-xl-4 col-lg-5 col-md-6 ">
                            <div class="cartcupon-wrap">
                                <ul class="d-flex">
                                    <li>
                                        <button type="submit">Update Cart</button>
                                    </li>
                                    <li><a href="{{ route('shop_page','all') }}">Continue Shopping</a></li>
                                </ul>
                                @if($error_msg)
                                <div class="alert alert-danger" role="alert">
                                    <strong>{{$error_msg}}</strong>
                                </div>
                                @endif
                                <h3>Cupon</h3>
                                <p>Enter Your Cupon Code if You Have One</p>
                                <div class="cupon-wrap">
                                    <input type="text" placeholder="Cupon Code" id="apply_coupon_input"
                                        value="{{$coupon_name}}">
                                    <button id="apply_coupon_btn" type="button">Apply Cupon</button>
                                </div>
                                @foreach ($valid_coupons as $valid_coupon)
                                <button type="button" value="{{$valid_coupon->coupon_name}}"
                                    class="coupon_badge badge badge-warning">{{$valid_coupon->coupon_name}}</button>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-xl-3 offset-xl-5 col-lg-4 offset-lg-3 col-md-6">
                            <div class="cart-total text-right">
                                <h3>Cart Totals</h3>
                                @php
                                $discount = ($discount_perc*$subtotal)/100;

                                session(['sub_total' => $subtotal]);
                                session(['discount_amount' => $discount]);
                                session(['coupon_name' => $coupon_name]);
                                @endphp
                                <ul>
                                    <li><span class="pull-left">Subtotal </span>${{$subtotal}}</li>
                                    <li><span class="pull-left">Discount(%) </span>{{$discount_perc}}%</li>
                                    <li><span class="pull-left">Discount </span>${{$discount}}</li>
                                    <li><span class="pull-left"> Total </span>
                                        ${{($discount_perc)?$subtotal-$discount:$subtotal}}</li>
                                </ul>
                                @if($flag)
                                <button class="btn btn-danger">Solve the issue first!</button>
                                @else
                                <a href="{{route('checkout')}}">Proceed to Checkout</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- cart-area end -->
@endsection


@section('script')
<script>
    $(document).ready(function () {
        $('#apply_coupon_btn').click(function () {
            const val = $('#apply_coupon_input').val();
            const link_to_go = "{{url('cart_main')}}/" + val;

            window.location.href = link_to_go;
        });

        $('.coupon_badge').click(function () {
            $('#apply_coupon_input').val($(this).val());
        });
    });

</script>
@endsection
