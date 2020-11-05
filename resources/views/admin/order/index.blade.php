@extends('layouts.dashboard_app')


@section('title')
Order | {{env("APP_NAME")}}
@endsection

@section('order')
active
@endsection


@section('dashboard_content')

<div class="sl-mainpanel">
    <nav class="breadcrumb sl-breadcrumb">
        <a class="breadcrumb-item" href="{{url('home')}}">Home</a>
        <span class="breadcrumb-item active">Orders</span>
    </nav>

    <div class="sl-pagebody">
        <div class="sl-page-title">
            <h5>Order List</h5>
            <p>Check order list and manage order.</p>
        </div><!-- sl-page-title -->


        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card pd-20 pd-sm-40">
                        <div class="card-body-title">Order List</div>
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
                                        <th scope="col">Order ID</th>
                                        <th scope="col">Order AT</th>
                                        <th scope="col">Order By</th>
                                        <th scope="col">Payment Type</th>
                                        <th scope="col">Payment Status</th>
                                        <th scope="col">Price</th>
                                        <th scope="col">Discount</th>
                                        <th scope="col">Coupon Name</th>
                                        <th scope="col">Total</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($orders as $order)
                                    <tr>
                                        <th scope="row">{{ $loop->index+1 }}</th>
                                        <td>{{ $order->id }}</td>
                                        <td>{{ $order->created_at }}</td>
                                        <td>{{ $order->user->name }}</td>
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
                                            <span class="badge badge-warning">Canceled</span>
                                            @endif
                                        </td>
                                        <td>{{ $order->total }}</td>
                                        <td>{{ $order->discount_amount }}</td>
                                        <td>{{ $order->coupon_name }}</td>
                                        <td>{{ $order->sub_total }}</td>
                                        <td>
                                            @if ($order->payment_status == 1)
                                            <a href="{{ route('order.show',$order->id) }}" type="button"
                                                class="btn btn-success">Paid</a>
                                            @endif
                                            @if ($order->payment_status == 1)
                                            <a href="{{ route('order.edit',$order->id) }}" type="button"
                                                class="btn btn-danger">Cancel</a>
                                            @endif
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


</div><!-- sl-mainpanel -->

@endsection




@section('script')
<script>
    $(function () {
        'use strict';

        $('#datatable1').DataTable({
            responsive: true,
            language: {
                searchPlaceholder: 'Search...',
                sSearch: '',
                lengthMenu: '_MENU_ items/page',
            }
        });

        $('#datatable2').DataTable({
            bLengthChange: false,
            searching: false,
            responsive: true
        });

        // Select2
        $('.dataTables_length select').select2({
            minimumResultsForSearch: Infinity
        });

    });

</script>
@endsection
