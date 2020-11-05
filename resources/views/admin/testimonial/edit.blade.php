@extends('layouts.dashboard_app')


@section('title')
	Edit Testimonial | {{env("APP_NAME")}}
@endsection

@section('testimonial')
	active
@endsection


@section('dashboard_content')

	<div class="sl-mainpanel">
	  <nav class="breadcrumb sl-breadcrumb">
        <a class="breadcrumb-item" href="{{url('home')}}">Home</a>
	    <a class="breadcrumb-item" href="{{route('testimonial.index')}}">Testimonial</a>
	    <span class="breadcrumb-item active">{{ $testimonial->client_name }}</span>
	  </nav>

	  <div class="sl-pagebody">
	    <div class="sl-page-title">
	      <h5>Edit Testimonial</h5>
	      <p>------------</p>
	    </div><!-- sl-page-title -->
	  </div><!-- sl-pagebody -->

	  <div class="container">
		<div class="row">
			<div class="col-md-4 m-auto">
				<div class="card bd-0">
				  <div class="card-header card-header-default bg-teal">Edit Testimonial</div>
				  <div class="card-body">
                    @if(session('success_status'))
                    <div class="alert alert-success">
                        {{ session('success_status') }}
                    </div>
                    @endif

				    <form method="post" action="{{ route('testimonial.update',$testimonial->id) }}" enctype="multipart/form-data">
                      @csrf
                      @method('PATCH')

					  <div class="form-group">
                        <label>Client Name:</label>
                        <input type="text" class="form-control" placeholder="Enter Client Name" name="client_name" value="{{ $testimonial->client_name }}">
                        @error('client_name')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>About Client:</label>
                        <input type="text" class="form-control" placeholder="Enter Client About" name="client_about" value="{{ $testimonial->client_about }}">
                        @error('client_about')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Client Message:</label>
                        <textarea class="form-control" name="client_message" id="" cols="30" rows="10">{{ $testimonial->client_message }}</textarea>
                        @error('client_message')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Client's Old Photo:</label>
                        <img class="img-fluid" src="{{asset('uploads/testimonial_photos/'.$testimonial->client_photo)}}" alt="">
                    </div>
                    <div class="well" data-bind="fileDrag: fileData">
                        <div class="form-group">
                            <div class="">
                                <img style="height: 125px;" class="img-rounded  thumb" data-bind="attr: { src: fileData().dataURL }, visible: fileData().dataURL">
                                <div data-bind="ifnot: fileData().dataURL">
                                    <label class="drag-label">Drag Client's Photo here</label>
                                </div>
                            </div>
                            <div class="mg-t-40">
                                <input type="file" name="client_photo" data-bind="fileInput: fileData, customFileInput: {
                                  buttonClass: 'btn btn-success',
                                  fileNameClass: 'disabled form-control',
                                  onClear: onClear,
                                  onInvalidFileDrop: onInvalidFileDrop
                                }" accept="image/*">
                            </div>
                        </div>
                        @error('client_photo')
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
