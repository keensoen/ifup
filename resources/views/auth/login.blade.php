@extends('app')

@section('page_title') Login @endsection
@section('auth-content')
<div class="blankpage-form-field flex" style="background: url({{ URL::to('img/svg/pattern-1.svg') }}) no-repeat center bottom fixed; background-size: cover;">
    <div class="page-logo m-0 w-100 align-items-center justify-content-center rounded border-bottom-left-radius-0 border-bottom-right-radius-0 px-4">
        <a href="javascript:void(0)" class="page-logo-link press-scale-down d-flex align-items-center">
            <img src="{{ URL::to('img/logo.png') }}" style="height: 40px;" alt="eFellwUp" aria-roledescription="logo">
            <span class="page-logo-text mr-1">eFellowUp <sub><i>Cure for the church...</i></sub></span>
            <i class="fal fa-angle-down d-inline-block ml-1 fs-lg color-primary-300"></i>
        </a>
    </div>
    <div class="card p-4 border-top-left-radius-0 border-top-right-radius-0">
        <form novalidate="" method="POST" action="{{ route('login') }}" autocomplete="off">
            @csrf
            <div class="form-group">
                {{--  <label class="form-label hidden" for="username">Username</label>  --}}
                <input id="login" type="text" placeholder="Email/Username" name="login" class="form-control form-control-md @error('login') is-invalid @enderror" value="{{ old('login') }}">
                @error('login')
                    <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                @enderror
            </div>
            <div class="form-group">
                {{--  <label class="form-label" for="password">Password</label>  --}}
                <input id="password" type="password" class="form-control form-control-md @error('password') is-invalid @enderror" placeholder="password" name="password" required>
                @error('password')
                    <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                @enderror
            </div>
            <div class="form-group text-left">
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label class="custom-control-label" for="rememberme"> Remember me for the next 30 days</label>
                </div>
            </div>
            <div class="row no-gutters">
                <div class="col-lg-12 pl-lg-1 my-2">
                    <button id="js-login-btn" type="submit" class="btn btn-danger btn-block btn-md">Secure login</button>
                </div>
            </div>
        </form>
    </div>
    <div class="blankpage-footer text-center">
        <a href="{{ route('password.request') }}"><strong>{{ __('Forgot Your Password?') }}</strong></a> | <a href="/"><strong>Home</strong></a>
    </div>
</div>
@endsection
