@extends('layouts.dashboard_app')


@section('title')
Home | {{env("APP_NAME")}}
@endsection

@section('home')
active
@endsection

@section('dashboard_content')

<div class="sl-mainpanel">
    <nav class="breadcrumb sl-breadcrumb">
        <span class="breadcrumb-item active">Home</span>
    </nav>

    <div class="sl-pagebody">
        <div class="sl-page-title">
            <h5>User Info</h5>
            <p>This is user list and their information.</p>
        </div><!-- sl-page-title -->
    </div><!-- sl-pagebody -->

    <div class="container">
        <div class="row">
            <div class="col-md-5">
                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="mb-3">Order Payment chart!</h5>
                        <canvas id="chart1" height="220"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-7">
                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="mb-3">Selling Report of past 6 months!</h5>
                        <canvas id="chart2"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-3">
            <div class="card-header">
                <a href="{{url('send/newsletter')}}" class="btn btn-success">Send Newsletter to {{$num_of_users}}
                    Users</a>
            </div>
        </div>
        <div class="card mb-5">
            <div class="card-header card-header-default">Total {{$num_of_users}} Users</div>

            <div class="card-body">
                @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
                @endif

                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Serial</th>
                            <th scope="col">ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Last</th>
                            <th scope="col">Handle</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <th scope="row">{{$users->firstItem() + $loop->index}}</th>
                            <th scope="row">{{$user->id}}</th>
                            <td>{{Str::title($user->name)}}</td>
                            <td>{{$user->email}}</td>
                            <td>
                                <li>{{$user->created_at->format('d/M/Y')}}</li>
                                <li>{{$user->created_at->diffForHumans()}}</li>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{$users->links()}}
            </div>
        </div>
    </div>
</div><!-- sl-mainpanel -->

@endsection

@section('script')
<script>
    var ctx = document.getElementById('chart1').getContext('2d');
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Paid', 'Unpaid', 'Canceled'],
            datasets: [{
                label: '# of Votes',
                data: [{{ $paid }}, {{ $unpaid }}, {{ $canceled }}],
                backgroundColor: [
                    'green',
                    'red',
                    'yellow'
                ]
            }]
        }
    });

    var ctx = document.getElementById('chart2').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: <?php echo json_encode($months); ?>,
            datasets: [{
                label: 'Sale Amount',
                data: <?php echo json_encode($sales); ?>,
                backgroundColor: '#27AAC8'
            }]
        }
    });

</script>
@endsection
