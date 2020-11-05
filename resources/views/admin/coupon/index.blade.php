@extends('layouts.dashboard_app')


@section('title')
Coupon | {{env("APP_NAME")}}
@endsection

@section('coupon')
active
@endsection


@section('dashboard_content')

<div class="sl-mainpanel">
    <nav class="breadcrumb sl-breadcrumb">
        <a class="breadcrumb-item" href="{{url('home')}}">Home</a>
        <span class="breadcrumb-item active">Coupon</span>
    </nav>

    <div class="sl-pagebody">
        <div class="sl-page-title">
            <h5>Coupon List</h5>
            <p>Check Coupon list and manage Coupons.</p>
        </div><!-- sl-page-title -->


        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="card pd-20 pd-sm-40">
                        <div class="card-body-title">Coupon List</div>
                        {{-- <form method="post" action="{{ url('mark/delete') }}">
                            @csrf --}}
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
                                            <th scope="col">Coupon Name</th>
                                            <th scope="col">Added By</th>
                                            <th scope="col">Discount Amount</th>
                                            <th scope="col">Minimum Purchase Amount</th>
                                            <th scope="col">Valid Till</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($coupons as $coupon)
                                        <tr>
                                            <th scope="row">{{ $loop->index+1 }}</th>
                                            <td>{{ $coupon->coupon_name }}</td>
                                            <td>{{ App\User::findOrFail($coupon->added_by)->name }}</td>
                                            <td>{{ $coupon->discount_amount }}</td>
                                            <td>{{ $coupon->minimum_purchase_amount }}</td>
                                            <td>{{ $coupon->validity_till }}</td>
                                            <td>
                                                <a href="{{ route('coupon.show',$coupon->id) }}" type="button" class="btn btn-primary">Edit</a>
                                                <form method="post" action="{{ route('coupon.destroy',$coupon->id) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                </form>
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
                            {{-- @if($categories->count())
                                <button type="submit" class="btn btn-danger">Delete Marked</button>
                            @endif
                        </form> --}}
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bd-0">
                        <div class="card-header card-header-default bg-orange">Add Coupon</div>
                        <div class="card-body">
                            @if(session('success_status'))
                            <div class="alert alert-success">
                                {{ session('success_status') }}
                            </div>
                            @endif

                            <form method="post" action="{{ route('coupon.store') }}">
                                @csrf

                                <div class="form-group">
                                    <label>Coupon Name:</label>
                                    <input type="text" class="form-control" placeholder="Enter Coupon Name" name="coupon_name" value="{{ old('coupon_name') }}">
                                    @error('coupon_name')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Discount Amount:</label>
                                    <input type="text" class="form-control" placeholder="Enter Discount Amount" name="discount_amount" value="{{ old('discount_amount') }}">
                                    @error('discount_amount')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Minimum Purchase Amount:</label>
                                    <input type="text" class="form-control" placeholder="Enter Minimum Purchase Amount" name="minimum_purchase_amount" value="{{ old('minimum_purchase_amount') }}">
                                    @error('minimum_purchase_amount')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Validity Till:</label>
                                    <input type="date" class="form-control" name="validity_till" value="{{ old('validity_till') }}">
                                    @error('validity_till')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary">Add</button>
                            </form>
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
        $(function(){
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
        $('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });

      });
    </script>
@endsection
