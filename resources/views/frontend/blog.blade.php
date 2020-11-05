@extends('layouts.frontend_app')

@section('title')
Blog | {{env("APP_NAME")}}
@endsection

@section('blog_posts')
active
@endsection

@section('frontend_content')
    <!-- .breadcumb-area start -->
    <div class="breadcumb-area bg-img-4 ptb-100">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcumb-wrap text-center">
                        <h2>Blog Page</h2>
                        <ul>
                            <li><a href="{{url('/')}}">Home</a></li>
                            <li><span>Blog</span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- .breadcumb-area end -->
    <!-- blog-area start -->
    <div class="blog-area">
        <div class="container">
            <div class="col-lg-12">
                <div class="section-title  text-center">
                    <h2>Latest News</h2>
                    <img src="{{asset('frontend_asset')}}/images/section-title.png" alt="">
                </div>
            </div>
            <div class="row">
                @foreach ($blog_posts as $blog_post)
                    <div class="col-lg-4  col-md-6 col-12">
                        <div class="blog-wrap">
                            <div class="blog-image">
                            <img src="{{asset('uploads/blog_photos/'.$blog_post->blog_banner)}}" alt="">
                                <ul>
                                    <li>{{$blog_post->created_at->format('d')}}</li>
                                    <li>{{$blog_post->created_at->format('M')}}</li>
                                </ul>
                            </div>
                            <div class="blog-content">
                                <div class="blog-meta">
                                    <ul>
                                    <li><a href="#"><i class="fa fa-user"></i> {{$blog_post->user->name}}</a></li>
                                        <li class="pull-right"><a href="#"><i class="fa fa-clock-o"></i> {{$blog_post->created_at->format('d/m/Y')}}</a></li>
                                    </ul>
                                </div>
                                <h3><a href="{{route('post_details',$blog_post->id)}}">{{Str::limit($blog_post->blog_title, 50, '...')}}</a></h3>
                                <p>{!!Str::limit($blog_post->blog_content, 200, '...')!!}</p>
                            </div>
                        </div>
                    </div>
                @endforeach

                <div class="col-12">
                    <div class="pagination-wrapper text-center mb-30">
                        {{ $blog_posts->links('frontend.paginate') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- blog-area end -->
@endsection
