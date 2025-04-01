@extends('layouts.app')

@section('title', 'Register')

@section('content')
    <!-- Custom Header pour Register -->
    <div class="custom-header" style="width: 100%; height: 300px; background-color: #f5f5f5;">
        <!-- Vous pouvez ajouter une image ici via CSS ou en modifiant ce div -->
    </div>

    <!-- Section Register -->
    <div id="register" class="register-main pad-top-100 pad-bottom-100">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-8 col-xs-12 col-lg-offset-3 col-md-offset-3 col-sm-offset-2">
                    <div class="wow fadeIn" data-wow-duration="1s" data-wow-delay="0.1s">
                        <h2 class="block-title text-center">Register</h2>
                        <p class="title-caption text-center">Create an account to enjoy our services.</p>
                    </div>
                    <form id="register-form" method="post" class="reservations-box" action="{{ route('register.submit') }}">
                        @csrf <!-- Token CSRF pour la sécurité Laravel -->
                        <div class="form-box">
                            <input type="text" name="name" id="name" placeholder="Full Name" required="required" data-error="Name is required." class="form-control">
                        </div>
                        <div class="form-box">
                            <input type="email" name="email" id="email" placeholder="E-Mail ID" required="required" data-error="Email is required." class="form-control">
                        </div>
                        <div class="form-box">
                            <input type="password" name="password" id="password" placeholder="Password" required="required" data-error="Password is required." class="form-control">
                        </div>
                        <div class="form-box">
                            <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirm Password" required="required" data-error="Password confirmation is required." class="form-control">
                        </div>
                        <div class="form-box text-center">
                            <button class="hvr-underline-from-center orange-btn" type="submit">Register</button>
                        </div>
                        <div class="text-center">
                            <p>Already have an account? <a href="{{ route('login') }}" class="orange-text">Login here</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection