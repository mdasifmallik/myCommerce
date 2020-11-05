@extends('layouts.dashboard_app')


@section('title')
Category | {{env("APP_NAME")}}
@endsection

@section('category')
active
@endsection


@section('dashboard_content')

<div class="sl-mainpanel">
    <nav class="breadcrumb sl-breadcrumb">
        <a class="breadcrumb-item" href="{{url('home')}}">Home</a>
        <span class="breadcrumb-item active">Category</span>
    </nav>

    <div class="sl-pagebody">
        <div class="sl-page-title">
            <h5>Category List</h5>
            <p>Check category list and manage category.</p>
        </div><!-- sl-page-title -->


        <div class="container">
            <div class="row">
                <div class="col-md-9">
                    <div class="card pd-20 pd-sm-40">
                        <div class="card-body-title">Category List (Active)</div>
                        <form method="post" action="{{ url('mark/delete') }}">
                            @csrf
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
                                            <th scope="col">Mark</th>
                                            <th scope="col">Serial No.</th>
                                            <th scope="col">Category Name</th>
                                            {{-- <th scope="col">Category Description</th> --}}
                                            <th scope="col">Category Photo</th>
                                            <th scope="col">Created By</th>
                                            <th scope="col">Created At</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($categories as $category)
                                        <tr>
                                            <td>
                                                <label class="ckbox mg-b-0">
                                                    <input type="checkbox" name="category_id[]" value="{{ $category->id }}">
                                                    <span></span>
                                                </label>
                                            </td>
                                            <th scope="row">{{ $loop->index+1 }}</th>
                                            <td>{{ Str::title($category->category_name) }}</td>
                                            {{-- <td>{{ $category->category_description }}</td> --}}
                                            <td>
												<img width="50" src="{{asset('uploads/category_photos')}}/{{$category->category_photo}}" alt="">
                                            </td>
                                            <td>{{ Str::title(App\User::find($category->user_id)->name)  }}</td>
                                            <td>
                                            	@isset($category->created_at)
													{{ $category->created_at->diffForHumans()}}
	                                            @endisset
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group" aria-label="Basic example">
                                                    <a href="{{url('edit/category')}}/{{$category->id}}" type="button" class="btn btn-primary">Edit</a>
                                                    <a href="{{url('delete/category')}}/{{$category->id}}" type="button" class="btn btn-danger">Delete</a>
                                                </div>
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
                            @if($categories->count())
                                <button type="submit" class="btn btn-danger">Delete Marked</button>
                            @endif
                        </form>
                    </div>

                    <div class="card pd-20 pd-sm-40 mg-t-50">
                        <div class="card-body-title">Category List (Deleted)</div>
                        <div class="table-responsive mg-b-20 mg-t-20">
                            @if(session('restore_status'))
                            <div class="alert alert-success">
                                {{ session('restore_status') }}
                            </div>
                            @endif
                            @if(session('forceDelete_status'))
                            <div class="alert alert-danger">
                                {{ session('forceDelete_status') }}
                            </div>
                            @endif
                            <table class="table table-hover table-bordered" id="datatable2">
                                <thead class="bg-danger">
                                    <tr>
                                        <th scope="col">Serial No.</th>
                                        <th scope="col">Category Name</th>
                                        {{-- <th scope="col">Category Description</th> --}}
                                        <th scope="col">Created By</th>
                                        <th scope="col">Created At</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($deleted_categories as $category)
                                    <tr>
                                        <th scope="row">{{ $loop->index+1 }}</th>
                                        <td>{{ Str::title($category->category_name) }}</td>
                                        {{-- <td>{{ $category->category_description }}</td> --}}
                                        <td>{{ Str::title(App\User::find($category->user_id)->name)  }}</td>
                                        <td>{{ $category->created_at->format('d/m/Y h:i:s a') }}</td>
                                        <td>
                                            <div class="btn-group" role="group" aria-label="Basic example">
                                                <a href="{{url('restore/category')}}/{{$category->id}}" type="button" class="btn btn-success">Restore</a>
                                                <a href="{{url('force_delete/category')}}/{{$category->id}}" type="button" class="btn btn-danger">Delete Permanently</a>
                                            </div>
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
                        <div class="card-header card-header-default bg-orange">Add Category</div>
                        <div class="card-body">
                            @if(session('success_status'))
                            <div class="alert alert-success">
                                {{ session('success_status') }}
                            </div>
                            @endif

                            <form method="post" action="{{ url('/add/category/post') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label>Category Name:</label>
                                    <input type="text" class="form-control" placeholder="Enter Category Name" name="category_name" value="{{ old('category_name') }}">
                                    @error('category_name')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Category Description:</label>
                                    <textarea class="form-control" name="category_description" rows="3">{{ old('category_description') }}</textarea>
                                    @error('category_description')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Category Photo:</label>
                                    <input class="form-control" type="file" name="category_photo">
                                    @error('category_photo')
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
