@extends('layouts.dashboard_app')


@section('title')
	Edit Profile | {{env("APP_NAME")}}
@endsection

@section('dashboard_content')
	<div class="sl-mainpanel">
      <nav class="breadcrumb sl-breadcrumb">
        <a class="breadcrumb-item" href="{{url('home')}}">Home</a>
        <span class="breadcrumb-item active">Edit Profile</span>
      </nav>

      <div class="sl-pagebody">
        <div class="sl-page-title">
          <h5>Edit Profile</h5>
          <p>Change name and password.</p>
        </div><!-- sl-page-title -->
      </div><!-- sl-pagebody -->

      <div class="container">
		<div class="row">
			<div class="col-md-6">
				<div class="card bd-0 mb-3">
				  <div class="card-header card-header-default bg-primary">Edit Name</div>
				  <div class="card-body">
					@if(session('name_change_msg'))
					    <div class="alert alert-success">
					    	{{ session('name_change_msg') }}
					    </div>
				    @endif

				    @if(session('name_change_error'))
					    <div class="alert alert-danger">
					    	{{ session('name_change_error') }}
					    </div>
				    @endif

				    @error('name')
						<div class="alert alert-danger">
							<li>{{$message}}</li>
					    </div>
				    @enderror

				    <form method="post" action="{{ url('/edit/profile/post') }}">
					  @csrf

					  <div class="form-group">
					    <label>Name:</label>
					    <input type="text" class="form-control" placeholder="Enter Your Name" name="name" value="{{ Auth::user()->name }}">
					  </div>

					  <button type="submit" class="btn btn-primary">Change Name</button>
					</form>
				  </div>
				</div>
				<div class="card">
					<div class="card-header card-header-default bg-success">Change Profile Picture
		            </div>
		            <div class="card-body">
		            	@error('profile_photo')
							<div class="alert alert-danger">
								<li>{{$message}}</li>
						    </div>
					    @enderror
		            	<form method="post" action="{{url('change/profile/photo')}}" enctype="multipart/form-data">
		            		@csrf

		            		<div class="well" data-bind="fileDrag: fileData">
			    				<div class="form-group row">
			        				<div class="col-md-6">
			            				<img style="height: 125px;" class="img-rounded  thumb" data-bind="attr: { src: fileData().dataURL }, visible: fileData().dataURL">
			            				<div data-bind="ifnot: fileData().dataURL">
			                				<label class="drag-label">Drag file here</label>
			            				</div>
			        				</div>
		        					<div class="col-md-6">
			            				<input type="file" name="profile_photo" data-bind="fileInput: fileData, customFileInput: {
			              				buttonClass: 'btn btn-success',
			              				fileNameClass: 'disabled form-control',
			              				onClear: onClear,
			             				 onInvalidFileDrop: onInvalidFileDrop
			            				}" accept="image/*">
		        					</div>
		    					</div>
							</div>
							<button type="submit" class="btn btn-success">Upload</button>
		            	</form>
		            </div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="card bd-0">
				  <div class="card-header card-header-default bg-danger">Change Password</div>
				  <div class="card-body">
					@if(session('password_error'))
					    <div class="alert alert-danger">
					    	{{ session('password_error') }}
					    </div>
				    @endif

				    @if(session('password_change'))
					    <div class="alert alert-success">
					    	{{ session('password_change') }}
					    </div>
				    @endif
				    
				    @error('password')
						<div class="alert alert-danger">
							<li>{{$message}}</li>
					    </div>
				    @enderror

				    <form method="post" action="{{ url('/edit/password/post') }}">
					  @csrf

					  <div class="form-group">
					    <label>Old Password:</label>
					    <div class="input-group">
				          <input type="password" class="form-control" id="i-1" placeholder="Old Password" name="old_password">
				          <span class="input-group-addon">
				          	<i class="fas fa-eye-slash" style="cursor: pointer;" id="s-1" onmousedown="mouseDown(id)" onmouseup="mouseUp(id)"></i>
				          </span>
				        </div>
					  </div>

					  <div class="form-group">
					    <label>New Password:</label>
					    <div class="input-group">
				          <input type="password" class="form-control" placeholder="New Password" name="password" id="i-2">
				          <span class="input-group-addon">
				          	<i class="fas fa-eye-slash" style="cursor: pointer;" id="s-2" onmousedown="mouseDown(id)" onmouseup="mouseUp(id)"></i>
				          </span>
				        </div>
					  </div>

					  <div class="form-group">
					    <label>Confirm Password:</label>
					    <div class="input-group">
				          <input type="password" class="form-control" id="i-3"placeholder="Retype New Password" name="password_confirmation">
				          <span class="input-group-addon">
				          	<i class="fas fa-eye-slash" style="cursor: pointer;" id="s-3" onmousedown="mouseDown(id)" onmouseup="mouseUp(id)"></i>
				          </span>
				        </div>
					  </div>
					  <button type="submit" class="btn btn-danger">Change Password</button>
					</form>
				  </div>
				</div>
			</div>
		</div>
	</div>

    </div><!-- sl-mainpanel -->

@endsection


{{-- JS CODE FOR SHOW/HIDE PASSWORD --}}
@section('script')
	<script>

		function mouseDown(id){
			var icon, inpfie, key;
			icon = document.getElementById(id);
			key = id.split('-');
			inpfie = document.getElementById('i-'+key[1]);

			icon.classList.remove('fa-eye-slash');
			icon.classList.add('fa-eye');

			inpfie.type = "text";
		}

		function mouseUp(id){
			var icon, inpfie, key;
			icon = document.getElementById(id);
			key = id.split('-');
			inpfie = document.getElementById('i-'+key[1]);

			icon.classList.remove('fa-eye');
			icon.classList.add('fa-eye-slash');

			inpfie.type = "password";
		}

	</script>

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