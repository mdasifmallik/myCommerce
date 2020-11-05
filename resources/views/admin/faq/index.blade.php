@extends('layouts.dashboard_app')


@section('title')
Faq | {{env("APP_NAME")}}
@endsection

@section('faq')
active
@endsection


@section('dashboard_content')

<div class="sl-mainpanel">
    <nav class="breadcrumb sl-breadcrumb">
        <a class="breadcrumb-item" href="{{url('home')}}">Home</a>
        <span class="breadcrumb-item active">Faq</span>
    </nav>

    <div class="sl-pagebody">
        <div class="sl-page-title">
            <h5>Faq List</h5>
            <p>Check Faq list and manage Faq.</p>
        </div><!-- sl-page-title -->


        <div class="container">
            <div class="row">
                <div class="col-md-9">
                    <div class="card pd-20 pd-sm-40">
                        <div class="card-body-title">Faq List</div>
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
                                            <th scope="col">Question</th>
                                            <th scope="col">Answer</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($faqs as $faq)
                                        <tr>
                                            <th scope="row">{{ $loop->index+1 }}</th>
                                            <td>{{ $faq->question }}</td>
                                            <td>{{ $faq->answer }}</td>
                                            <td>
                                                <a href="{{ route('faq.edit',$faq->id) }}" type="button" class="btn btn-primary">Edit</a>
                                                <form method="post" action="{{ route('faq.destroy',$faq->id) }}">
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
                        <div class="card-header card-header-default bg-orange">Add Faq</div>
                        <div class="card-body">
                            @if(session('success_status'))
                            <div class="alert alert-success">
                                {{ session('success_status') }}
                            </div>
                            @endif

                            <form method="post" action="{{ route('faq.store') }}">
                                @csrf
                                <div class="form-group">
                                    <label>Question:</label>
                                    <input type="text" class="form-control" placeholder="Enter a question" name="question" value="{{ old('question') }}">
                                    @error('question')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Answer:</label>
                                    <textarea class="form-control" name="answer" id="" cols="30" rows="8">{{ old('answer') }}</textarea>
                                    @error('answer')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary">Add FAQ</button>
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


