@extends('layouts.dashboard_app')


@section('title')
Blog | {{env("APP_NAME")}}
@endsection

@section('blog')
active
@endsection

@section('view_post')
active
@endsection


@section('dashboard_content')

<div class="sl-mainpanel">
    <nav class="breadcrumb sl-breadcrumb">
        <a class="breadcrumb-item" href="{{url('home')}}">Home</a>
        <span class="breadcrumb-item active">Blog</span>
        <span class="breadcrumb-item active">View Post</span>
    </nav>

    <div class="sl-pagebody">
        <div class="sl-page-title">
            <h5>Blog Posts</h5>
            <p>Check Blog posts and manage them.</p>
        </div><!-- sl-page-title -->


        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card pd-20 pd-sm-40">
                        <div class="card-body-title">Blog List</div>
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
                                            <th scope="col">Blog Title</th>
                                            <th scope="col">Blog Content</th>
                                            <th scope="col">Blog Category</th>
                                            <th scope="col">Published By</th>
                                            <th scope="col">Blog Banner</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($blog_posts as $blog_post)
                                        <tr>
                                            <th scope="row">{{ $loop->index+1 }}</th>
                                            <td>{{ Str::title($blog_post->blog_title) }}</td>
                                            <td>{{Str::limit($blog_post->blog_content, 200, '.....')}}</td>
                                            <td>{{$blog_post->category->category_name}}</td>
                                            <td>{{$blog_post->user->name}}</td>
                                            <td>
                                                <img class="img-fluid" src="{{asset('uploads/blog_photos')}}/{{$blog_post->blog_banner}}" alt="">
                                            </td>
                                            <td>
                                                <a href="{{ route('blog.edit',$blog_post->id) }}" type="button" class="btn btn-primary">Edit</a>
                                                <form method="post" action="{{ route('blog.destroy',$blog_post->id) }}">
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


