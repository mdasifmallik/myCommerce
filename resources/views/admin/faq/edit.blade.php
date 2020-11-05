@extends('layouts.dashboard_app')


@section('title')
Edit Faq | {{env("APP_NAME")}}
@endsection

@section('faq')
active
@endsection


@section('dashboard_content')

<div class="sl-mainpanel">
    <nav class="breadcrumb sl-breadcrumb">
        <a class="breadcrumb-item" href="{{url('home')}}">Home</a>
        <a class="breadcrumb-item" href="{{route('faq.index')}}">FAQ</a>
        <span class="breadcrumb-item active">Edit Faq</span>
    </nav>

    <div class="sl-pagebody">
        <div class="sl-page-title">
            <h5>Edit Faq</h5>
            <p>----------------</p>
        </div><!-- sl-page-title -->


        <div class="container">
            <div class="row">
                <div class="col-md-5 m-auto">
                    <div class="card bd-0">
                        <div class="card-header card-header-default bg-orange">Edit Faq</div>
                        <div class="card-body">
                            @if(session('success_status'))
                            <div class="alert alert-success">
                                {{ session('success_status') }}
                            </div>
                            @endif

                            <form method="post" action="{{ route('faq.update',$faq->id) }}">
                                @csrf
                                @method('PATCH')
                                <div class="form-group">
                                    <label>Question:</label>
                                    <input type="text" class="form-control" placeholder="Enter a question" name="question" value="{{ $faq->question }}">
                                    @error('question')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Answer:</label>
                                    <textarea class="form-control" name="answer" id="" cols="30" rows="8">{{ $faq->answer }}</textarea>
                                    @error('answer')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary">Edit FAQ</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- sl-pagebody -->


</div><!-- sl-mainpanel -->

@endsection
