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
                        <!-- Nouveau sélecteur de rôle stylé -->
                        <div class="form-box">
                            <div class="styled-select">
                                <select name="role" id="role" required class="form-control">
                                    <option value="" disabled selected>Select your role</option>
                                    <option value="client">Client</option>
                                    <option value="restaurant_manager">Gérant de restaurant</option>
                                </select>
                                <div class="select-arrow"></div>
                            </div>
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

<style>
    /* Style pour le sélecteur personnalisé */
    .styled-select {
        position: relative;
        width: 100%;
    }
    
    .styled-select select {
        width: 100%;
        border: 2px dotted #ccc;
        background: #f5f5f5;
        color: #202020;
        padding: 12px;
        text-transform: capitalize;
        border-radius: 4px;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        cursor: pointer;
        font-family: 'Roboto', sans-serif;
        font-size: 14px;
        transition: all 0.3s ease-in-out;
    }
    
    .styled-select select:focus {
        border-color: #e75b1e;
        outline: none;
    }
    
    .styled-select .select-arrow {
        position: absolute;
        top: 50%;
        right: 15px;
        transform: translateY(-50%);
        width: 0;
        height: 0;
        border-left: 6px solid transparent;
        border-right: 6px solid transparent;
        border-top: 6px solid #202020;
        pointer-events: none;
    }
    
    /* Style pour les options */
    .styled-select select option {
        padding: 10px;
        background: #f5f5f5;
        color: #202020;
    }
    
    .styled-select select option:hover {
        background: #e75b1e;
        color: #fff;
    }
</style>