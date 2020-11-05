
@extends('layouts.dashboard_app')


@section('title')
Edit Product | {{env("APP_NAME")}}
@endsection

@section('product')
active
@endsection


@section('dashboard_content')

<div class="sl-mainpanel">
    <nav class="breadcrumb sl-breadcrumb">
        <a class="breadcrumb-item" href="{{url('home')}}">Home</a>
        <a class="breadcrumb-item" href="{{ route('product.index') }}">Product</a>
        <span class="breadcrumb-item active">{{$product->product_name}}</span>
    </nav>

    <div class="sl-pagebody">
        <div class="sl-page-title">
            <h5>Edit Product</h5>
            <p>Edit this product.</p>
        </div><!-- sl-page-title -->


        <div class="container">
            <div class="row">
                <div class="col-md-6 m-auto">
                    <div class="card bd-0">
                        <div class="card-header card-header-default bg-orange">Edit Product</div>
                        <div class="card-body">
                            @if(session('success_status'))
                            <div class="alert alert-success">
                                {{ session('success_status') }}
                            </div>
                            @endif

                            <form method="post" action="{{ route('product.update',$product->id) }}" enctype="multipart/form-data">
                                @csrf
                                @method('PATCH')
                                <div class="form-group">
                                    <label>Product Category:</label>
                                    <select id="" class="form-control" name="category_id">
                                    	<option value="">-Select-One-</option>
                                    	@foreach($active_categories as $active_category)
                                    		<option {{ ($active_category->id == $product->category_id) ? "selected" : "" }} value="{{$active_category->id}}">{{$active_category->category_name}}</option>
                                    	@endforeach
                                    </select>
                                    @error('category_id')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Product Name:</label>
                                    <input type="text" class="form-control" placeholder="Enter Product Name" name="product_name" value="{{ $product->product_name }}">
                                    @error('product_name')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Product Short Description:</label>
                                    <input type="text" class="form-control" placeholder="Enter Product Description" name="product_short_description" value="{{ $product->product_short_description }}">
                                    @error('product_short_description')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Product Long Description:</label>
                                    <textarea class="form-control" name="product_long_description" rows="3">{{ $product->product_long_description }}</textarea>
                                    @error('product_long_description')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Product Price:</label>
                                    <input type="text" class="form-control" placeholder="Enter Product Price" name="product_price" value="{{ $product->product_price }}">
                                    @error('product_price')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Product Quantity:</label>
                                    <input type="text" class="form-control" placeholder="Enter Product Quantity" name="product_quantity" value="{{ $product->product_quantity }}">
                                    @error('product_quantity')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Alert Quantity:</label>
                                    <input type="text" class="form-control" placeholder="Enter Alert Quantity" name="product_alert_quantity" value="{{ $product->product_alert_quantity }}">
                                    @error('product_alert_quantity')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="well" data-bind="fileDrag: fileData">
				    				<div class="form-group">
				        				<div class="">
				            				<img style="height: 125px;" class="img-rounded  thumb" data-bind="attr: { src: fileData().dataURL }, visible: fileData().dataURL">
				            				<div data-bind="ifnot: fileData().dataURL">
				                				<label class="drag-label">Drag Product Photo here</label>
				            				</div>
				        				</div>
			        					<div class="mg-t-40">
				            				<input type="file" name="product_photo" data-bind="fileInput: fileData, customFileInput: {
				              				buttonClass: 'btn btn-success',
				              				fileNameClass: 'disabled form-control',
				              				onClear: onClear,
				             				 onInvalidFileDrop: onInvalidFileDrop
				            				}" accept="image/*">
			        					</div>
                                    </div>
                                    @error('product_photo')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
								</div>
                                <button type="submit" class="btn btn-primary">Edit</button>
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
	<script src='http://cdnjs.cloudflare.com/ajax/libs/knockout/3.1.0/knockout-min.js'></script>
	<script src='{{asset('knockout-file')}}/knockout-file-bindings.js'></script>
	<script>
	    var viewModel = {};
	    viewModel.fileData = ko.observable({
	        dataURL: ko.observable(),
	        // can add "fileTypes" observable here, and it will override the "accept" attribute on the file input
	        // fileTypes: ko.observable('.xlsx,image/png,audio/*')
	    });
	    viewModel.multiFileData = ko.observable({ dataURLArray: ko.observableArray() });
	    viewModel.onClear = function (fileData) {
	        if (confirm('Are you sure?')) {
	            fileData.clear && fileData.clear();
	        }
	    };
	    viewModel.debug = function () {
	        window.viewModel = viewModel;
	        console.log(ko.toJSON(viewModel));
	        debugger;
	    };
	    viewModel.onInvalidFileDrop = function(failedFiles) {
	        var fileNames = [];
	        for (var i = 0; i < failedFiles.length; i++) {
	            fileNames.push(failedFiles[i].name);
	        }
	        var message = 'Invalid file type: ' + fileNames.join(', ');
	        alert(message)
	        console.error(message);
	    };
	    ko.applyBindings(viewModel);
	</script>
@endsection
