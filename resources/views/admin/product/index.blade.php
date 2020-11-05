@extends('layouts.dashboard_app')


@section('title')
Product | {{env("APP_NAME")}}
@endsection

@section('product')
active
@endsection


@section('dashboard_content')

<div class="sl-mainpanel">
    <nav class="breadcrumb sl-breadcrumb">
        <a class="breadcrumb-item" href="{{url('home')}}">Home</a>
        <span class="breadcrumb-item active">Product</span>
    </nav>

    <div class="sl-pagebody">
        <div class="sl-page-title">
            <h5>Product List</h5>
            <p>Check product list and manage product.</p>
        </div><!-- sl-page-title -->


        <div class="container">
            <div class="row">
                <div class="col-md-9">
                    <div class="card pd-20 pd-sm-40">
                        <div class="card-body-title">Product List (Active)</div>
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
                                            <th scope="col">Product Name</th>
                                            <th scope="col">Product Category</th>
                                            {{-- <th scope="col">Product Short Description</th> --}}
                                            <th scope="col">Product Price</th>
                                            <th scope="col">Product Quantity</th>
                                            {{-- <th scope="col">Alert Quantity</th> --}}
                                            <th scope="col">Product Photo</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($products as $product)
                                        <tr>
                                            {{-- <td>
                                                <label class="ckbox mg-b-0">
                                                    <input type="checkbox" name="category_id[]" value="{{ $category->id }}">
                                                    <span></span>
                                                </label>
                                            </td> --}}
                                            <th scope="row">{{ $loop->index+1 }}</th>
                                            <td>{{ Str::title($product->product_name) }}</td>
                                            {{-- <td>{{ App\Category::findOrFail($product->category_id)->category_name }}</td> --}}
                                            <td>{{$product->category->category_name}}</td>
                                            {{-- <td>{{ $product->product_short_description }}</td> --}}
                                            <td>{{ $product->product_price }}</td>
                                            <td>{{ $product->product_quantity }}</td>
                                            {{-- <td>{{ $product->product_alert_quantity }}</td> --}}
                                            <td>
												<img class="img-fluid" src="{{asset('uploads/product_photos')}}/{{$product->product_thumbnail_photo}}" alt="">
                                            </td>
                                            <td>
                                                <a href="{{ route('product.show',$product->id) }}" type="button" class="btn btn-primary">Edit</a>
                                                <form method="post" action="{{ route('product.destroy',$product->id) }}">
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
                <div class="col-md-3">
                    <div class="card bd-0">
                        <div class="card-header card-header-default bg-orange">Add Product</div>
                        <div class="card-body">
                            @if(session('success_status'))
                            <div class="alert alert-success">
                                {{ session('success_status') }}
                            </div>
                            @endif

                            <form method="post" action="{{ route('product.store') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label>Product Category:</label>
                                    <select id="" class="form-control" name="category_id">
                                    	<option value="">-Select-One-</option>
                                    	@foreach($active_categories as $active_category)
                                    		<option value="{{$active_category->id}}">{{$active_category->category_name}}</option>
                                    	@endforeach
                                    </select>
                                    @error('category_id')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Product Name:</label>
                                    <input type="text" class="form-control" placeholder="Enter Product Name" name="product_name" value="{{ old('product_name') }}">
                                    @error('product_name')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Product Short Description:</label>
                                    <input type="text" class="form-control" placeholder="Enter Product Description" name="product_short_description" value="{{ old('product_short_description') }}">
                                    @error('product_short_description')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Product Long Description:</label>
                                    <textarea class="form-control" name="product_long_description" rows="3">{{ old('product_long_description') }}</textarea>
                                    @error('product_long_description')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Product Price:</label>
                                    <input type="text" class="form-control" placeholder="Enter Product Price" name="product_price" value="{{ old('product_price') }}">
                                    @error('product_price')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Product Quantity:</label>
                                    <input type="text" class="form-control" placeholder="Enter Product Quantity" name="product_quantity" value="{{ old('product_quantity') }}">
                                    @error('product_quantity')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Alert Quantity:</label>
                                    <input type="text" class="form-control" placeholder="Enter Alert Quantity" name="product_alert_quantity" value="{{ old('product_alert_quantity') }}">
                                    @error('product_alert_quantity')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Product Photo:</label>
                                    <input type="file" class="form-control" name="product_thumbnail_photo">
                                    @error('product_thumbnail_photo')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Product Multiple Photo:</label>
                                    <input type="file" class="form-control" name="product_multiple_photo[]" multiple>
                                    @error('product_multiple_photo')
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
