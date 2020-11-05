@extends('layouts.dashboard_app')


@section('title')
Banner | {{env("APP_NAME")}}
@endsection

@section('banner')
active
@endsection


@section('dashboard_content')

<div class="sl-mainpanel">
    <nav class="breadcrumb sl-breadcrumb">
        <a class="breadcrumb-item" href="{{url('home')}}">Home</a>
        <span class="breadcrumb-item active">Banner</span>
    </nav>

    <div class="sl-pagebody">
        <div class="sl-page-title">
            <h5>Banner List</h5>
            <p>Check Banner list and manage Banner.</p>
        </div><!-- sl-page-title -->


        <div class="container">
            <div class="row">
                <div class="col-md-9">
                    <div class="card pd-20 pd-sm-40">
                        <div class="card-body-title">Banner List</div>
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
                                            <th scope="col">Banner Title</th>
                                            <th scope="col">Banner Content</th>
                                            <th scope="col">Banner Photo</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($banners as $banner)
                                        <tr>
                                            <th scope="row">{{ $loop->index+1 }}</th>
                                            <td>{{ Str::title($banner->banner_title) }}</td>
                                            <td>{{$banner->banner_content}}</td>
                                            <td>
                                                <img class="img-fluid" src="{{asset('uploads/banner_photos')}}/{{$banner->banner_photo}}" alt="">
                                            </td>
                                            <td>
                                                <a href="{{ route('banner.edit',$banner->id) }}" type="button" class="btn btn-primary">Edit</a>
                                                <form method="post" action="{{ route('banner.destroy',$banner->id) }}">
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
                        <div class="card-header card-header-default bg-orange">Add Banner</div>
                        <div class="card-body">
                            @if(session('success_status'))
                            <div class="alert alert-success">
                                {{ session('success_status') }}
                            </div>
                            @endif

                            <form method="post" action="{{ route('banner.store') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label>Banner Name:</label>
                                    <input type="text" class="form-control" placeholder="Enter Banner Title" name="banner_title" value="{{ old('banner_title') }}">
                                    @error('banner_title')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Banner Content:</label>
                                    <textarea class="form-control" name="banner_content" id="" cols="30" rows="8">{{ old('banner_content') }}</textarea>
                                    @error('banner_content')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Banner Photo:</label>
                                    <input class="form-control" type="file" name="banner_photo">
                                    @error('banner_photo')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary">Add Banner</button>
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

        // Select2
        $('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });

      });
    </script>
@endsection


