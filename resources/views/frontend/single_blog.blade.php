@extends('layouts.frontend_app')

@section('title')
Blog | {{env("APP_NAME")}}
@endsection

@section('blog')
active
@endsection

@section('frontend_content')
<!-- .breadcumb-area start -->
<div class="breadcumb-area bg-img-4 ptb-100">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcumb-wrap text-center">
                    <h2>Blog Details</h2>
                    <ul>
                        <li><a href="index.html">Home</a></li>
                        <li><a href="{{route('blog_posts')}}">Blog</a></li>
                        <li><span>{{$blog_post->blog_title}}</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- .breadcumb-area end -->
<!-- blog-details-area start-->
<div class="blog-details-area ptb-100">
    <div class="container">
        <div class="row">
            <div class="col-lg-9 col-12">
                <div class="blog-details-wrap">
                    <img src="{{asset('uploads/blog_photos/'.$blog_post->blog_banner)}}" alt="">
                    <h3>{{$blog_post->blog_title}}</h3>
                    <ul class="meta">
                        <li>{{$blog_post->created_at->format('d M Y')}}</li>
                        <li>By {{$blog_post->user->name}}</li>
                    </ul>
                    <p>{!! $blog_post->blog_content !!}</p>
                    <div class="share-wrap">
                        <div class="row">
                            <div class="col-sm-7 ">
                                <ul class="socil-icon d-flex">
                                    <li>share it on :</li>
                                    <li><a href="javascript:void(0);"><i class="fa fa-facebook"></i></a></li>
                                    <li><a href="javascript:void(0);"><i class="fa fa-twitter"></i></a></li>
                                    <li><a href="javascript:void(0);"><i class="fa fa-linkedin"></i></a></li>
                                    <li><a href="javascript:void(0);"><i class="fa fa-google-plus"></i></a></li>
                                    <li><a href="javascript:void(0);"><i class="fa fa-instagram"></i></a></li>
                                </ul>
                            </div>
                            <div class="col-sm-5 text-right">
                                @if ($next_blog_post_id)
                                <a href="{{route('post_details',$next_blog_post_id)}}">Next Post <i class="fa fa-long-arrow-right"></i></a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="comment-form-area" id="comment_section">
                    <div class="comment-main">
                        <h3 class="blog-title"><span>({{$blog_post->comments->count()}})</span> Comments:</h3>
                        <ol class="comments">
                            <li class="comment even thread-even depth-1">
                                @foreach ($blog_post->comments->sortDesc() as $comment)
                                    <div class="comment-wrap">
                                        <div class="comment-theme">
                                            <div class="comment-image">
                                                <img width="50" src="{{asset('uploads/profile_photos/default.jpg')}}" alt="">
                                            </div>
                                        </div>
                                        <div class="comment-main-area">
                                            <div class="comment-wrapper">
                                                <div class="sewl-comments-meta">
                                                    <h4>{{$comment->name}} </h4>
                                                    <span>{{$comment->created_at->format('d M Y')}}  at {{$comment->created_at->format('h:ia')}}</span>
                                                </div>
                                                <div class="comment-area">
                                                    <p>{{$comment->comment}}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </li>
                        </ol>
                    </div>
                    <div id="respond" class="sewl-comment-form comment-respond form-style">
                        <h3 id="reply-title" class="blog-title">Leave a <span>comment</span></h3>
                    <form novalidate="" method="post" id="commentform" class="comment-form" action="{{route('post_comment',$blog_post->id)}}">
                        @csrf
                        <div class="row">
                                <div class="col-12">
                                    <div class="sewl-form-inputs no-padding-left">
                                        <div class="row">
                                            <div class="col-sm-6 col-12">
                                                <input id="name" name="name" value="" tabindex="2" placeholder="Name" type="text">
                                            </div>
                                            <div class="col-sm-6 col-12">
                                                <input id="email" name="email" value="" tabindex="3" placeholder="Email" type="email">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="sewl-form-textarea no-padding-right">
                                        <textarea id="comment" name="comment" tabindex="4" rows="3" cols="30" placeholder="Write Your Comments..."></textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-submit">
                                        <input value="Send" type="submit">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-12">
                <aside class="sidebar-area">
                    <div class="widget widget_categories">
                        <h4 class="widget-title">Categories</h4>
                        <ul>
                            @foreach ($categories as $category)
                            <li><a href="#">{{$category->category_name}}</a></li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="widget widget_recent_entries recent_post">
                        <h4 class="widget-title">Recent Post</h4>
                        <ul>
                            @foreach ($all_posts as $post)
                                <li>
                                    <div class="post-img">
                                        <img width="100" src="{{asset('uploads/blog_photos/'.$post->blog_banner)}}" alt="">
                                    </div>
                                    <div class="post-content">
                                        <a href="{{route('post_details',$post->id)}}">{{$post->blog_title}} </a>
                                        <p>{{$post->created_at->format('d M Y')}}</p>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </aside>
            </div>
        </div>
    </div>
</div>
<!-- blog-details-area end -->
@endsection
