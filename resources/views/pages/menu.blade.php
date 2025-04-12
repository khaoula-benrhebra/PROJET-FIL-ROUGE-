@extends('layouts.app')

@section('title', 'Menu')

@section('content')
    <div class="special-menu pad-top-100 parallax">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="wow fadeIn" data-wow-duration="1s" data-wow-delay="0.1s">
                        <h2 class="block-title color-white text-center">Today's Special</h2>
                        <h5 class="title-caption text-center">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusm incididunt ut labore et dolore magna aliqua. Ut enim ad minim venia,nostrud exercitation ullamco.</h5>
                    </div>
                    <div class="special-box">
                        <div id="owl-demo">
                            <div class="item item-type-zoom">
                                <a href="#" class="item-hover">
                                    <div class="item-info">
                                        <div class="headline">SALMON STEAK<div class="line"></div><div class="dit-line">Lorem ipsum dolor sit amet, consectetur adip aliqua. Ut enim ad minim venia.</div></div>
                                    </div>
                                </a>
                                <div class="item-img"><img src="{{ asset('images/special-menu-1.jpg') }}" alt="sp-menu"></div>
                            </div>
                            <div class="item item-type-zoom">
                                <a href="#" class="item-hover">
                                    <div class="item-info">
                                        <div class="headline">ITALIAN PIZZA<div class="line"></div><div class="dit-line">Lorem ipsum dolor sit amet, consectetur adip aliqua. Ut enim ad minim venia.</div></div>
                                    </div>
                                </a>
                                <div class="item-img"><img src="{{ asset('images/special-menu-2.jpg') }}" alt="sp-menu"></div>
                            </div>
                            <div class="item item-type-zoom">
                                <a href="#" class="item-hover">
                                    <div class="item-info">
                                        <div class="headline">VEG. ROLL<div class="line"></div><div class="dit-line">Lorem ipsum dolor sit amet, consectetur adip aliqua. Ut enim ad minim venia.</div></div>
                                    </div>
                                </a>
                                <div class="item-img"><img src="{{ asset('images/special-menu-3.jpg') }}" alt="sp-menu"></div>
                            </div>
                            <div class="item item-type-zoom">
                                <a href="#" class="item-hover">
                                    <div class="item-info">
                                        <div class="headline">SALMON STEAK<div class="line"></div><div class="dit-line">Lorem ipsum dolor sit amet, consectetur adip aliqua. Ut enim ad minim venia.</div></div>
                                    </div>
                                </a>
                                <div class="item-img"><img src="{{ asset('images/special-menu-1.jpg') }}" alt="sp-menu"></div>
                            </div>
                            <div class="item item-type-zoom">
                                <a href="#" class="item-hover">
                                    <div class="item-info">
                                        <div class="headline">VEG. ROLL<div class="line"></div><div class="dit-line">Lorem ipsum dolor sit amet, consectetur adip aliqua. Ut enim ad minim venia.</div></div>
                                    </div>
                                </a>
                                <div class="item-img"><img src="{{ asset('images/special-menu-2.jpg') }}" alt="sp-menu"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="menu" class="menu-main pad-top-100 pad-bottom-100">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="wow fadeIn" data-wow-duration="1s" data-wow-delay="0.1s">
                        <h2 class="block-title text-center">Our Menu</h2>
                        <p class="title-caption text-center">There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable.</p>
                    </div>
                    <div class="tab-menu">
                        <div class="slider slider-nav">
                            <div class="tab-title-menu"><h2>ITALIAN</h2><p><i class="flaticon-canape"></i></p></div>
                            <div class="tab-title-menu"><h2>JAPANESE</h2><p><i class="flaticon-dinner"></i></p></div>
                            <div class="tab-title-menu"><h2>CHINESE</h2><p><i class="flaticon-desert"></i></p></div>
                            <div class="tab-title-menu"><h2>MOROCCAN</h2><p><i class="flaticon-coffee"></i></p></div>
                        </div>
                        <div class="slider slider-single">
                            <div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <div class="offer-item">
                                        <img src="{{ asset('images/menu-item-thumbnail-01.jpg') }}" alt="" class="img-responsive">
                                        <div>
                                            <h3>GARLIC BREAD</h3>
                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc mollis eleifend dapibus.</p>
                                        </div>
                                        <span class="offer-price">$8.5</span>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <div class="offer-item">
                                        <img src="{{ asset('images/menu-item-thumbnail-02.jpg') }}" alt="" class="img-responsive">
                                        <div>
                                            <h3>MIXED SALAD</h3>
                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc mollis eleifend dapibus.</p>
                                        </div>
                                        <span class="offer-price">$25</span>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <div class="offer-item">
                                        <img src="{{ asset('images/menu-item-thumbnail-03.jpg') }}" alt="" class="img-responsive">
                                        <div>
                                            <h3>BBQ CHICKEN WINGS</h3>
                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc mollis eleifend dapibus.</p>
                                        </div>
                                        <span class="offer-price">$10</span>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <div class="offer-item">
                                        <img src="{{ asset('images/menu-item-thumbnail-04.jpg') }}" alt="" class="img-responsive">
                                        <div>
                                            <h3>MEAT FEAST PIZZA</h3>
                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc mollis eleifend dapibus.</p>
                                        </div>
                                        <span class="offer-price">$5</span>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <div class="offer-item">
                                        <img src="{{ asset('images/menu-item-thumbnail-05.jpg') }}" alt="" class="img-responsive">
                                        <div>
                                            <h3>CHICKEN TIKKA MASALA</h3>
                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc mollis eleifend dapibus.</p>
                                        </div>
                                        <span class="offer-price">$15</span>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <div class="offer-item">
                                        <img src="{{ asset('images/menu-item-thumbnail-06.jpg') }}" alt="" class="img-responsive">
                                        <div>
                                            <h3>SPICY MEATBALLS</h3>
                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc mollis eleifend dapibus.</p>
                                        </div>
                                        <span class="offer-price">$6.5</span>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <div class="offer-item">
                                        <img src="{{ asset('images/menu-item-thumbnail-07.jpg') }}" alt="" class="img-responsive">
                                        <div>
                                            <h3>CHOCOLATE FUDGECAKE</h3>
                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc mollis eleifend dapibus.</p>
                                        </div>
                                        <span class="offer-price">$4.5</span>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <div class="offer-item">
                                        <img src="{{ asset('images/menu-item-thumbnail-08.jpg') }}" alt="" class="img-responsive">
                                        <div>
                                            <h3>CHICKEN TIKKA MASALA</h3>
                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc mollis eleifend dapibus.</p>
                                        </div>
                                        <span class="offer-price">$9.5</span>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <div class="offer-item">
                                        <img src="{{ asset('images/menu-item-thumbnail-09.jpg') }}" alt="" class="img-responsive">
                                        <div>
                                            <h3>CHICKEN TIKKA MASALA</h3>
                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc mollis eleifend dapibus.</p>
                                        </div>
                                        <span class="offer-price">$10</span>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <div class="offer-item">
                                        <img src="{{ asset('images/menu-item-thumbnail-10.jpg') }}" alt="" class="img-responsive">
                                        <div>
                                            <h3>MEAT FEAST PIZZA</h3>
                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc mollis eleifend dapibus.</p>
                                        </div>
                                        <span class="offer-price">$12.5</span>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <div class="offer-item">
                                        <img src="{{ asset('images/menu-item-thumbnail-09.jpg') }}" alt="" class="img-responsive">
                                        <div>
                                            <h3>CHICKEN TIKKA MASALA</h3>
                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc mollis eleifend dapibus.</p>
                                        </div>
                                        <span class="offer-price">$9.5</span>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <div class="offer-item">
                                        <img src="{{ asset('images/menu-item-thumbnail-08.jpg') }}" alt="" class="img-responsive">
                                        <div>
                                            <h3>CHICKEN TIKKA MASALA</h3>
                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc mollis eleifend dapibus.</p>
                                        </div>
                                        <span class="offer-price">$5.5</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection