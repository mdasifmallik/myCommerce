@extends('layouts.dashboard_app')


@section('title')
Blog | {{env("APP_NAME")}}
@endsection

@section('blog')
active
@endsection

@section('create_post')
active
@endsection


@section('dashboard_content')

<div class="sl-mainpanel">
    <nav class="breadcrumb sl-breadcrumb">
        <a class="breadcrumb-item" href="{{url('home')}}">Home</a>
        <span class="breadcrumb-item active">Blog</span>
        <span class="breadcrumb-item active">Create Post</span>
    </nav>

    <div class="sl-pagebody">
        <div class="sl-page-title">
            <h5>Create Post</h5>
            <p>Create new posts.</p>
        </div><!-- sl-page-title -->


        <div class="container">
            <div class="row">
                <div class="col-md-10 m-auto">
                    <div class="card bd-0">
                        <div class="card-header card-header-default bg-orange">Create New Post</div>
                        <div class="card-body">
                            @if(session('success_status'))
                            <div class="alert alert-success">
                                {{ session('success_status') }}
                            </div>
                            @endif

                            <form method="post" action="{{ route('blog.store') }}" enctype="multipart/form-data">
                                @csrf

                                <div class="form-group">
                                    <label>Blog Category:</label>
                                    <select id="" class="form-control" name="category_id">
                                    	<option value="">-Select-One-</option>
                                    	@foreach($categories as $category)
                                    		<option value="{{$category->id}}">{{$category->category_name}}</option>
                                    	@endforeach
                                    </select>
                                    @error('category_id')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Blog Title:</label>
                                    <input type="text" class="form-control" placeholder="Enter Blog Title" name="blog_title" value="{{ old('blog_title') }}">
                                    @error('blog_title')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Blog Content:</label>
                                    <textarea class="form-control" name="blog_content">{{ old('blog_content') }}</textarea>
                                    @error('blog_content')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Blog Banner:</label>
                                    <input class="form-control" type="file" name="blog_banner">
                                    @error('blog_banner')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary">Create Post</button>
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
    CKEDITOR.replace( 'blog_content' );
</script>
@endsection
