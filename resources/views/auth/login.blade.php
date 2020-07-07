@extends('app')

@section('page_title') Login @endsection
@section('auth-content')
    <div class="height-10 w-100 shadow-lg px-4 bg-brand-gradient">
        <div class="d-flex align-items-center container p-0">
            @include('header')
            @if (Route::has('password.request'))
                <a class="btn btn-link text-white ml-auto" href="{{ route('password.request') }}">
                    {{ __('Forgot Your Password?') }}
                </a>
            @endif
        </div>
    </div>
    <div class="flex-1" style="background: url({{ URL::to('img/svg/pattern-1.svg') }}) no-repeat center bottom fixed; background-size: cover;">
        <div class="container py-4 py-lg-5 my-lg-5 px-4 px-sm-0">
            <div class="row">
                <div class="col col-md-6 col-lg-7 hidden-sm-down">
                    <h2 class="fs-xxl fw-500 mt-4 text-white">
                        Welcome to the world followUp
                        <small class="h3 fw-300 mt-3 mb-5 text-white opacity-60">
                            Connecting everyone everywhere!!!
                        </small>
                    </h2>
                    <a href="#" class="fs-lg fw-500 text-white opacity-70">Learn more &gt;&gt;</a>
                    <div class="d-sm-flex flex-column align-items-center justify-content-center d-md-block">
                        <div class="px-0 py-1 mt-5 text-white fs-nano opacity-50">
                            Find us on social media
                        </div>
                        <div class="d-flex flex-row opacity-70">
                            <a href="#" class="mr-2 fs-xxl text-white">
                                <i class="fab fa-facebook-square"></i>
                            </a>
                            <a href="#" class="mr-2 fs-xxl text-white">
                                <i class="fab fa-twitter-square"></i>
                            </a>
                            <a href="#" class="mr-2 fs-xxl text-white">
                                <i class="fab fa-google-plus-square"></i>
                            </a>
                            <a href="#" class="mr-2 fs-xxl text-white">
                                <i class="fab fa-linkedin"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-5 col-xl-4 ml-auto">
                    <h1 class="text-white fw-300 mb-3 d-sm-block">
                        Secure login
                    </h1>
                    <div class="card p-4 rounded-plus bg-faded">
                        <form novalidate="" method="POST" action="{{ route('login') }}" autocomplete="off">
                            @csrf
                            <div class="form-group">
                                <label class="form-label" for="username">Email/Username</label>
                                <input id="login" type="text" placeholder="Email/Username" name="login" class="form-control form-control-md @error('login') is-invalid @enderror"" value="{{ old('login') }}">
                                @error('login')
                                    <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="password">Password</label>
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
                                <div class="col-lg-6 pr-lg-1 my-2">
                                    <button type="reset" class="btn btn-info btn-block btn-md">Sign in with <i class="fab fa-google"></i></button>
                                </div>
                                <div class="col-lg-6 pl-lg-1 my-2">
                                    <button id="js-login-btn" type="submit" class="btn btn-danger btn-block btn-md">Secure login</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="position-absolute pos-bottom pos-left pos-right p-3 text-center text-white">
                {{ date('Y') }} © iFollowUP by&nbsp;<a href='https://keensoen.ng' class='text-white opacity-40 fw-500' title='KeennessSolutions' target='_blank'>KeennessSolutions</a>
            </div>
        </div>
    </div>
@endsection
