<div id="site-header">
    <header id="header" class="header-block-top">
        <div class="container">
            <div class="row">
                <div class="main-menu">
                    <nav class="navbar navbar-default" id="mainNav">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                            <div class="logo">
                                <a class="navbar-brand js-scroll-trigger logo-header" href="{{ route('home') }}">
                                    <img src="{{ asset('images/logo.png') }}" alt="">
                                </a>
                            </div>
                        </div>
                        <div id="navbar" class="navbar-collapse collapse">
                            <ul class="nav navbar-nav navbar-right">
                                <li><a href="{{ route('home') }}">Home</a></li>
                                <li><a href="{{ route('about') }}">About us</a></li>
                                <li><a href="{{ route('menu') }}">Menu</a></li>
                                <li><a href="{{ route('pricing') }}">Pricing</a></li>
                                <li><a href="{{ route('contact') }}">Contact</a></li>

                                @guest
                                    <li><a href="{{ route('login') }}">Login</a></li>
                                    <li><a href="{{ route('register') }}">Register</a></li>
                                @else
                                    @if(Auth::user()->role->name === 'Client')
                                        <li class="profile-icon-container">
                                            <a href="{{ route('client.profile') }}" class="profile-icon">
                                                <div class="profile-circle">
                                                    @if(Auth::user()->getFirstMediaUrl('profile'))
                                                        <img src="{{ Auth::user()->getFirstMediaUrl('profile') }}" alt="Profile">
                                                    @else
                                                        <img src="{{ asset('images/default-profile.png') }}" alt="Profile">
                                                    @endif
                                                </div>
                                            </a>
                                        </li>
                                    @endif
                                    <li>
                                        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                    </li>
                                @endguest
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </header>
</div>