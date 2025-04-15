@extends('layouts.app')

@section('title', 'Login')

@section('content')
    
    <div class="custom-header login" style="width: 100%; height: 300px; background-color: #f5f5f5;">
       
    </div>

    <div id="login" class="login-main pad-top-100 pad-bottom-100">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-8 col-xs-12 col-lg-offset-3 col-md-offset-3 col-sm-offset-2">
                    <div class="wow fadeIn" data-wow-duration="1s" data-wow-delay="0.1s">
                        <h2 class="block-title text-center">Login</h2>
                        <p class="title-caption text-center">Please login to your account</p>
                    </div>
                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if(session('info'))
                        <div class="alert alert-info">
                            {{ session('info') }}
                        </div>
                    @endif
                    <form id="login-form" method="post" class="login-box" action="{{ route('login.submit') }}">
                        @csrf
                        <div class="form-box">
                            <input type="email" name="email" id="email" placeholder="Email Address" required="required"
                                class="form-control" data-error="Email is required">
                        </div>
                        <div class="form-box">
                            <input type="password" name="password" id="password" placeholder="Password" required="required"
                                class="form-control" data-error="Password is required">
                        </div>
                        <div class="form-box">
                            <label class="custom-checkbox">
                                <input type="checkbox" name="remember" id="remember">
                                <span class="checkmark"></span>
                                Remember Me
                            </label>
                            <a href="#" class="pull-right">Reset Password</a>
                        </div>
                        <div class="reserve-book-btn text-center">
                            <button class="hvr-underline-from-center orange-btn" type="submit">Login</button>
                        </div>
                        <div class="text-center pad-top-20">
                            <p>Not a member? <a href="{{ route('register') }}">Register here</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection