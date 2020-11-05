@extends('layouts.auth_app')


@section('title')
    Register | {{env("APP_NAME")}}
@endsection

@section('content')

    <div class="d-flex align-items-center justify-content-center bg-sl-primary ht-md-100v">
      <div class="login-wrapper wd-300 wd-xs-400 pd-25 pd-xs-40 bg-white">

        <div class="signin-logo tx-center tx-24 tx-bold tx-inverse">{{env('APP_NAME')}} <span class="tx-info tx-normal">Register</span></div>
        <div class="tx-center mg-b-60">Register in {{env('APP_NAME')}}.</div>

        <form method="POST" action="{{ route('register') }}">
            @csrf
            
            <div class="form-group">
              <input id="name" type="text" placeholder="Enter your fullname" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div><!-- form-group -->
            <div class="form-group">
              <input id="email" type="email" placeholder="Enter your email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div><!-- form-group -->
            <div class="form-group">
              <input id="password" type="password" placeholder="Enter your password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div><!-- form-group -->
            <div class="form-group">
              <input id="password-confirm" type="password" placeholder="Confirm your password" class="form-control" name="password_confirmation" required autocomplete="new-password">
            </div><!-- form-group -->

            <div class="form-group tx-12">By clicking the Sign Up button below, you agreed to our privacy policy and terms of use of our website.</div>
            <button type="submit" class="btn btn-info btn-block">Sign Up</button>
        </form>

        <div class="mg-t-40 tx-center">Already have an account? <a href="{{ route('login') }}" class="tx-info">Sign In</a></div>

      </div><!-- login-wrapper -->
    </div><!-- d-flex -->

@endsection      