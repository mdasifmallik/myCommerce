@extends('layouts.frontend_app')

@section('title')
{{env("APP_NAME")}} | Checkout
@endsection


@section('frontend_content')

<!-- .breadcumb-area start -->
<div class="breadcumb-area bg-img-4 ptb-100">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcumb-wrap text-center">
                    <h2>Checkout</h2>
                    <ul>
                        <li><a href="index.html">Home</a></li>
                        <li><span>Checkout</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- .breadcumb-area end -->
<!-- checkout-area start -->
<div class="checkout-area ptb-100">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="checkout-form form-style">
                    <h3>Billing Details</h3>
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <form action="{{route('post_checkout')}}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <p>Name *</p>
                                <input type="text" name="name" value="{{Auth::user()->name}}">
                            </div>
                            <div class="col-sm-6 col-12">
                                <p>Email Address *</p>
                                <input type="email" name="email" value="{{Auth::user()->email}}">
                            </div>
                            <div class="col-sm-6 col-12">
                                <p>Phone No. *</p>
                                <input type="text" name="phone_number">
                            </div>
                            <div class="col-sm-6 col-12">
                                <p>Country *</p>
                                <select id="country_select_1" name="country_id">
                                    <option value="1">Select a country</option>
                                    @foreach ($countries as $country)
                                    <option value="{{$country->id}}">{{$country->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-6 col-12">
                                <p>Town/City *</p>
                                <select id="city_select_1" name="city_id">
                                    <option value="1">Select a country</option>
                                    <option value="2">bangladesh</option>
                                    <option value="3">Algeria</option>
                                    <option value="4">Afghanistan</option>
                                    <option value="5">Ghana</option>
                                    <option value="6">Albania</option>
                                    <option value="7">Bahrain</option>
                                    <option value="8">Colombia</option>
                                    <option value="9">Dominican Republic</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <p>Your Address *</p>
                                <input type="text" name="address">
                            </div>
                            <div class="col-12">
                                <input id="toggle2" type="checkbox" name="shipping_address_status" value="1">
                                <label class="fontsize" for="toggle2">Ship to a different address?</label>
                                <div class="row" id="open2">
                                    <div class="col-12">
                                        <p>Name *</p>
                                        <input type="text" name="s_name" value="{{Auth::user()->name}}">
                                    </div>
                                    <div class="col-12">
                                        <p>Email Address *</p>
                                        <input type="email" name="s_email" value="{{Auth::user()->email}}">
                                    </div>
                                    <div class="col-12">
                                        <p>Phone No. *</p>
                                        <input type="text" name="s_phone_number">
                                    </div>
                                    <div class="col-12">
                                        <p>Country *</p>
                                        <select id="s_country" name="s_country_id">
                                            <option value="1">Select a country</option>
                                            <option value="2">bangladesh</option>
                                            <option value="3">Algeria</option>
                                            <option value="4">Afghanistan</option>
                                            <option value="5">Ghana</option>
                                            <option value="6">Albania</option>
                                            <option value="7">Bahrain</option>
                                            <option value="8">Colombia</option>
                                            <option value="9">Dominican Republic</option>
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <p>Town/City *</p>
                                        <select id="s_country" name="s_city_id">
                                            <option value="1">Select a country</option>
                                            <option value="2">bangladesh</option>
                                            <option value="3">Algeria</option>
                                            <option value="4">Afghanistan</option>
                                            <option value="5">Ghana</option>
                                            <option value="6">Albania</option>
                                            <option value="7">Bahrain</option>
                                            <option value="8">Colombia</option>
                                            <option value="9">Dominican Republic</option>
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <p>Your Address *</p>
                                        <input type="text" name="s_address">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <p>Order Notes </p>
                                <textarea name="notes"
                                    placeholder="Notes about Your Order, e.g.Special Note for Delivery"></textarea>
                            </div>
                        </div>

                </div>
            </div>
            <div class="col-lg-4">
                <div class="order-area">
                    <h3>Your Order</h3>
                    <ul class="total-cost">
                        @php
                        $subtotal = 0;
                        $discount_perc = session('discount_perc');
                        @endphp
                        @foreach (cart_items() as $item)
                        <li>{{$item->product->product_name}} x {{$item->product_quantity}}<span
                                class="pull-right">${{$item->product->product_price * $item->product_quantity}}</span>
                        </li>
                        @php
                        $subtotal += $item->product->product_price * $item->product_quantity;
                        @endphp
                        @endforeach
                        @php
                        $discount = ($subtotal * $discount_perc)/100;
                        $shipping = 50;
                        $total = ($subtotal - $discount) + $shipping;
                        @endphp
                        <li>Subtotal <span class="pull-right"><strong>${{$subtotal}}</strong></span></li>
                        <li>Discount <span class="pull-right">${{$discount}}</span></li>
                        <li>Shipping <span class="pull-right">${{$shipping}}</span></li>
                        <li>Total<span class="pull-right">${{$total}}</span></li>
                    </ul>
                    <ul class="payment-method">
                        <li>
                            <input name="payment_option" id="delivery" value="1" type="radio" checked>
                            <label for="delivery">Cash on Delivery</label>
                        </li>
                        <li>
                            <input name="payment_option" id="card" value="2" type="radio">
                            <label for="card">Credit Card</label>
                        </li>
                    </ul>
                    <button type="submit">Place Order</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- checkout-area end -->

@endsection


@section('script')
<script>
    $(document).ready(function () {
        $('#country_select_1').select2();
        $('#city_select_1').select2();


        $('#country_select_1').change(function () {
            var country_id = $(this).val();

            //ajax setup
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            //ajax response start
            $.ajax({
                type: 'POST',
                url: '/get/city/list/ajax',
                data: {
                    country_id: country_id
                },
                success: function (data) {
                    $('#city_select_1').html(data);
                }
            });
            //ajax response stop
        });
    });

</script>
@endsection
