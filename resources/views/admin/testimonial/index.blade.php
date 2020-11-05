@extends('layouts.dashboard_app')


@section('title')
Testimonial | {{env("APP_NAME")}}
@endsection

@section('testimonial')
active
@endsection


@section('dashboard_content')

<div class="sl-mainpanel">
    <nav class="breadcrumb sl-breadcrumb">
        <a class="breadcrumb-item" href="{{url('home')}}">Home</a>
        <span class="breadcrumb-item active">Testimonial</span>
    </nav>

    <div class="sl-pagebody">
        <div class="sl-page-title">
            <h5>Testimonial List</h5>
            <p>Check Testimonial list and manage Testimonial.</p>
        </div><!-- sl-page-title -->


        <div class="container">
            <div class="row">
                <div class="col-md-9">
                    <div class="card pd-20 pd-sm-40">
                        <div class="card-body-title">Testimonial List</div>
                            <div class="table-responsive ov-auto mg-b-20 mg-t-20">
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
                                            <th scope="col">Client Photo</th>
                                            <th scope="col">Client Name</th>
                                            <th scope="col">About Client</th>
                                            <th scope="col">Client Message</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($testimonials as $testimonial)
                                        <tr>
                                            <th scope="row">{{ $loop->index+1 }}</th>
                                            <td>
												<img width="30px" src="{{asset('uploads/testimonial_photos')}}/{{$testimonial->client_photo}}" alt="">
                                            </td>
                                            <td>{{ Str::title($testimonial->client_name) }}</td>
                                            <td>{{$testimonial->client_about}}</td>
                                            <td>{{$testimonial->client_message}}</td>
                                            <td>
                                                <a href="{{ route('testimonial.edit',$testimonial->id) }}" type="button" class="btn btn-primary">Edit</a>
                                                <form method="post" action="{{ route('testimonial.destroy',$testimonial->id) }}">
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
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bd-0">
                        <div class="card-header card-header-default bg-orange">Add Testimonial</div>
                        <div class="card-body">
                            @if(session('success_status'))
                            <div class="alert alert-success">
                                {{ session('success_status') }}
                            </div>
                            @endif

                            <form method="post" action="{{ route('testimonial.store') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label>Client Name:</label>
                                    <input type="text" class="form-control" placeholder="Enter Client Name" name="client_name" value="{{ old('client_name') }}">
                                    @error('client_name')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>About Client:</label>
                                    <input type="text" class="form-control" placeholder="Enter Client About" name="client_about" value="{{ old('client_about') }}">
                                    @error('client_about')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Client Message:</label>
                                    <textarea class="form-control" name="client_message" id="" cols="30" rows="10">{{ old('client_message') }}</textarea>
                                    @error('client_message')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
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
                                <button type="submit" class="btn btn-primary">Add Testimonial</button>
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

        // Select2
        $('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });

      });
    </script>
@endsection
