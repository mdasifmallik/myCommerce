@extends('layouts.dashboard_app')


@section('title')
Messages | {{env("APP_NAME")}}
@endsection

@section('contact_message')
active
@endsection


@section('dashboard_content')
    <div class="sl-mainpanel">
        <nav class="breadcrumb sl-breadcrumb">
            <a class="breadcrumb-item" href="{{url('home')}}">Home</a>
            <span class="breadcrumb-item active">Contact Message</span>
            <span class="breadcrumb-item active">Messages</span>
        </nav>

        <div class="sl-pagebody">
            <div class="sl-page-title">
                <h5>Message List</h5>
                <p>Check Message list and manage messages.</p>
            </div><!-- sl-page-title -->


            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card pd-20 pd-sm-40">
                            <div class="card-body-title">Message List</div>

                            <div class="table-responsive mg-b-20 mg-t-20">
                                @if(session('delete_status'))
                                <div class="alert alert-danger">
                                    {{ session('delete_status') }}
                                </div>
                                @endif

                                <table class="table table-hover table-bordered mg-b-0" id="datatable1">
                                    <thead class="bg-info">
                                        <tr>
                                            <th scope="col">Serial No.</th>
                                            <th scope="col">Sender Name</th>
                                            <th scope="col">Sender Email</th>
                                            <th scope="col">Subject</th>
                                            <th scope="col">Message</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($messages as $message)
                                        <tr style="background:{{($message->status == 1)?"wheat":""}}">
                                            <th scope="row">{{ $loop->index+1 }}</th>
                                            <td>{{ Str::title($message->name) }}</td>
                                            <td>{{ $message->email }}</td>
                                            <td>{{ $message->subject }}</td>
                                            <td>{{ $message->message }}</td>
                                            <td>
                                                @if ($message->status == 1)
                                                    <a href="{{ route('message.show',$message->id) }}" type="button" class="btn btn-primary">Read</a>
                                                @else
                                                    <a href="{{ route('message.show',$message->id) }}" type="button" class="btn btn-primary">Unread</a>
                                                @endif
                                                @if ($message->contact_attachment)
                                                    <a href="{{route('downloadmessage',$message->id)}}"><i class="fa fa-download"></i></a> |
                                                    <a href="{{asset('storage/'.$message->contact_attachment)}}"><i class="fa fa-file"></i></a>
                                                @endif
                                                <form method="post" action="{{ route('message.destroy',$message->id) }}">
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
