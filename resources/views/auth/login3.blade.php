@extends('layouts.auth_app')


@section('title')
    Login | {{env("APP_NAME")}}
@endsection

@section('content')

    <div class="d-flex align-items-center justify-content-center bg-sl-primary ht-100v">
      <div class="login-wrapper wd-300 wd-xs-350 pd-25 pd-xs-40 bg-white">

        <div class="signin-logo tx-center tx-24 tx-bold tx-inverse">{{env('APP_NAME')}} <span class="tx-info tx-normal">Login</span></div>
        <div class="tx-center mg-b-60">Login to {{env('APP_NAME')}} Dashboard.</div>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
              <input id="email" type="email" placeholder="Enter your email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div><!-- form-group -->
            <div class="form-group">
              <input id="password" type="password" placeholder="Enter your password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                @if (Route::has('password.request'))
                    <a class="tx-info tx-12 d-block mg-t-10" href="{{ route('password.request') }}">
                        {{ __('Forgot Your Password?') }}
                    </a>
                @endif
            </div><!-- form-group -->
            <div class="form-group row">
                <div class="col-md-6 offset-md-4 ml-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                        <label class="ml-1" for="remember">
                            {{ __('Remember Me') }}
                        </label>
                    </div>
                </div>
            </div><!-- form-group -->
            <button type="submit" class="btn btn-info btn-block">Sign In</button>
        </form>

    <a href="{{url('login/github')}}" class="btn btn-warning btn-block mt-3">Login with Github</a>

        <div class="mg-t-60 tx-center">Not yet a member?
            @if (Route::has('register'))
                <a class="tx-info" href="{{ route('register') }}">{{ __('Register') }}</a>
            @endif
        </div>

      </div><!-- login-wrapper -->
    </div><!-- d-flex -->

@endsection
