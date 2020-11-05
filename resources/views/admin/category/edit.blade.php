@extends('layouts.dashboard_app')


@section('title')
	Edit Category | {{env("APP_NAME")}}
@endsection

@section('category')
	active
@endsection


@section('dashboard_content')

	<div class="sl-mainpanel">
	  <nav class="breadcrumb sl-breadcrumb">
        <a class="breadcrumb-item" href="{{url('home')}}">Home</a>
	    <a class="breadcrumb-item" href="{{url('add/category')}}">Category</a>
	    <span class="breadcrumb-item active">{{ $category_info->category_name }}</span>
	  </nav>

	  <div class="sl-pagebody">
	    <div class="sl-page-title">
	      <h5>Edit Testimonial</h5>
	      <p>Change client's info and message.</p>
	    </div><!-- sl-page-title -->
	  </div><!-- sl-pagebody -->


    <div class="container">
		<div class="row">
			<div class="col-md-4 m-auto">
				<div class="card bd-0">
				  <div class="card-header card-header-default bg-teal">Edit Category</div>
				  <div class="card-body">

				    <form method="post" action="{{ url('/edit/category/post') }}" enctype="multipart/form-data">
					  @csrf

					  <input type="hidden" name="category_id" value="{{ $category_info->id }}">
					  <div class="form-group">
					    <label>Category Name:</label>
					    <input type="text" class="form-control" placeholder="Enter Category Name" name="category_name" value="{{ $category_info->category_name }}">
					    @error('category_name')
							<span class="text-danger">{{$message}}</span>
					    @enderror
					  </div>
					  <div class="form-group">
					    <label>Category Description:</label>
					    <textarea class="form-control" name="category_description" rows="3">{{ $category_info->category_description }}</textarea>
					    @error('category_description')
							<span class="text-danger">{{$message}}</span>
					    @enderror
                      </div>
					  <div class="form-group">
					    <label>Old Category Photo:</label>
                      <img class="img-fluid" src="{{asset('uploads/category_photos/'.$category_info->category_photo)}}" alt="">
                      </div>
                      <div class="form-group">
					    <label>Category Photo:</label>
					    <input class="form-control" type="file" name="category_photo">
					    @error('category_photo')
							<span class="text-danger">{{$message}}</span>
					    @enderror
                      </div>
					  <button type="submit" class="btn btn-teal">Update</button>
					</form>
				  </div>
				</div>
			</div>
		</div>
	</div>

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
