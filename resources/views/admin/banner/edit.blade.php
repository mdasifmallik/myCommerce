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
        <a class="breadcrumb-item" href="{{route('banner.index')}}">Banner</a>
        <span class="breadcrumb-item active">{{$banner->banner_title}}</span>
    </nav>

    <div class="sl-pagebody">
        <div class="sl-page-title">
            <h5>Edit Banner</h5>
            <p>-------------</p>
        </div><!-- sl-page-title -->


        <div class="container">
            <div class="row">
                <div class="col-md-5 m-auto">
                    <div class="card bd-0">
                        <div class="card-header card-header-default bg-orange">Edit Banner</div>
                        <div class="card-body">
                            @if(session('success_status'))
                            <div class="alert alert-success">
                                {{ session('success_status') }}
                            </div>
                            @endif

                            <form method="post" action="{{ route('banner.update',$banner->id) }}" enctype="multipart/form-data">
                                @csrf
                                @method('PATCH')
                                <div class="form-group">
                                    <label>Banner Name:</label>
                                    <input type="text" class="form-control" placeholder="Enter Banner Title" name="banner_title" value="{{ $banner->banner_title }}">
                                    @error('banner_title')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Banner Content:</label>
                                    <textarea class="form-control" name="banner_content" id="" cols="30" rows="8">{{ $banner->banner_content }}</textarea>
                                    @error('banner_content')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Old Banner Photo:</label>
                                    <img class="img-fluid" src="{{asset('uploads/banner_photos/'.$banner->banner_photo)}}" alt="">
                                </div>
                                <div class="form-group">
                                    <label>Banner Photo:</label>
                                    <input class="form-control" type="file" name="banner_photo">
                                    @error('banner_photo')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary">Edit Banner</button>
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


