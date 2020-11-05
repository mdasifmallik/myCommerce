@extends('layouts.dashboard_app')


@section('title')
Customer Home | {{env("APP_NAME")}}
@endsection

@section('customer_home')
active
@endsection

@section('dashboard_content')
<div class="sl-mainpanel">
    <nav class="breadcrumb sl-breadcrumb">
        <a class="breadcrumb-item" href="{{url('home')}}">Home</a>
        <span class="breadcrumb-item active">Dashboard</span>
    </nav>

    <div class="sl-pagebody">
        <div class="sl-page-title">
            <h5>Dashboard</h5>
            <p>This is a dynamic Dashboard.</p>
        </div><!-- sl-page-title -->


        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card pd-20 pd-sm-40">
                        <div class="card-body-title">Your Orders!</div>
                        <div class="table-responsive mg-b-20 mg-t-20">
                            @if(session('edit_status'))
                            <div class="alert alert-success">
                                {{ session('edit_status') }}
                            </div>
                            @endif
                            @if(session('delete_status'))
                            <div class="alert alert-danger">
                                {{ session('delete_status') }}
                            </div>
                            @endif

                            <table class="table table-hover table-bordered mg-b-0" id="datatable1">
                                <thead class="bg-info">
                                    <tr>
                                        <th scope="col">Serial No.</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Payment Method</th>
                                        <th scope="col">Payment Status</th>
                                        <th scope="col">Subtotal</th>
                                        <th scope="col">Discount Amount</th>
                                        <th scope="col">Coupon Name</th>
                                        <th scope="col">Total</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($orders as $order)
                                    <tr>
                                        <th scope="row">{{ $loop->index+1 }}</th>
                                        <td>{{$order->created_at}}</td>
                                        <td>
                                            @if ($order->payment_option == 1)
                                            Cash On Delivery
                                            @else
                                            Card
                                            @endif
                                        </td>
                                        <td>
                                            @if ($order->payment_status == 1)
                                            <span class="badge badge-danger">Unpaid</span>
                                            @elseif ($order->payment_status == 2)
                                            <span class="badge badge-success">Paid</span>
                                            @else
                                            <span class="badge badge-success">Canceled</span>
                                            @endif
                                        </td>
                                        <td>{{$order->sub_total}} BDT</td>
                                        <td>{{$order->discount_amount}} BDT</td>
                                        <td>{{$order->coupon_name}}</td>
                                        <td>{{$order->total}} BDT</td>
                                        <td><a href="{{ url('customer/invoice/download/'.$order->id) }}"><i
                                                    class="fa fa-download"></i>Download Invoice</a></td>
                                    </tr>
                                    <tr>
                                        <td colspan="50">
                                            @foreach ($order->order_details as $order_product)
                                            <p>{{$order_product->product->product_name}}</p>
                                            @endforeach
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="20" class="text-center text-danger">Nothing to show!!</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- sl-pagebody -->
</div>
@endsection
