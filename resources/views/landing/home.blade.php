@extends('layouts.landing')

@section('page_title')
    Home
@stop

@section('content')
<!-- Start Header -->
<div id="home" class="welcome-slider-area">
    <div class="slider-active owl-carousel">
        <div class="single-slider" style="background-image:url({{ URL::to('fronts/images/slider/img/slider-1.jpg')}})">
            <div class="slider-title">
                <div class="table-cell">
                    <p>eFellowUP - <i>Cure for the Church</i></p>
                    <h2 class="slider-title-animation">WE ARE <span>CREATIVE</span> CHURCH</h2>
                    <p class="slider-animation-up">“And they continued stedfastly in the apostles' doctrine and fellowship, <br> and in breaking of bread, and in prayers.”<br>
                        ACTS 2:42. 
                    </p>
                </div>
            </div>
        </div>
        <div class="single-slider" style="background-image:url({{ URL::to('fronts/images/slider/img/slider-2.jpg')}})">
            <div class="slider-title">
                <div class="table-cell">
                    <p>eFellowUP - <i>Cure for the Church</i></p>
                    <h2 class="slider-title-animation">WE ARE <span>CREATIVE</span> TEAM</h2>
                    <p class="slider-animation-up">“And all that believed were together, and had <br>all things common;”<br>
                        ACTS 2:44. 
                    </p>
                </div>
            </div>
        </div>
        <div class="single-slider" style="background-image:url({{ URL::to('fronts/images/slider/img/slider-3.jpg')}})">
            <div class="slider-title">
                <div class="table-cell">
                    <p>eFellowUP - <i>Cure for the Church</i></p>
                    <h2 class="slider-title-animation">WE ARE <span>CREATIVE</span> FELLOW-UP</h2>
                    <p class="slider-animation-up">“And sold their possessions and goods, and parted them to <br>all men, as every man had need.”<br>
                        ACTS 2:45. 
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<!--/End Header -->
<!-- Start About us Area -->
<section id="about-us" class="">
    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <div class="about-content">
                    <h2>About <span > US </span></h2>
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only</p>
                    <p>tronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop </p>
                    <div class="about-button wow fadeIn">
                        <a class="btn btn-color" href="#">Learn More</a>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="about-images wow fadeIn">
                    <a href="#"><img src="{{ URL::to('fronts/images/about/boy.png')}}" alt="about misti"></a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /End About us Area -->
<!-- Start Our Service Area -->
<section id="special" class="section-padding">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="section-title wow fadeInDown">
                    <h2>WHAT'S <span > SPECIAL</span ></h2>
                    <div class="border-line">
                        <span class="border-box"></span>
                    </div>
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="special-item owl-carousel">
                    <div class="special-single-content text-center">
                        <i class="fa fa-mobile" aria-hidden="true"></i>
                        <h3>App Design</h3>
                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever </p>
                        <a class="btn-service" href="#"> Read More</a>
                    </div>
                    <div class="special-single-content item-open text-center">
                        <i class="fa fa-television" aria-hidden="true"></i>
                        <h3>Web Design</h3>
                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever </p>
                        <a class="btn-service" href="#"> Read More</a>
                    </div>
                    <div class="special-single-content text-center">
                        <i class="fa fa-pencil" aria-hidden="true"></i>
                        <h3>Graphic Design</h3>
                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever </p>
                        <a class="btn-service" href="#"> Read More</a>
                    </div>
                    <div class="special-single-content text-center">
                        <i class="fa fa-search" aria-hidden="true"></i>
                        <h3>SEO Service </h3>
                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever </p>
                        <a class="btn-service" href="#"> Read More</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /End Our Service Area -->
<!-- Start Our Skill Area -->
<section id="our-skill" class="section-padding overlay-color-skill">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="section-title wow fadeInDown">
                    <h2>Our <span > Skill</span ></h2>
                    <div class="border-line">
                        <span class="border-box"></span>
                    </div>
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text</p>
                </div>
            </div>
        </div>
        <div class="row skillsection text-center">
            <div class="col-xs-12 col-sm-3">
                <div class="chart" data-percent="81" data-color="4CAF50">
                    <span class="percent"></span>
                    <div class="chart-text">
                        <span>App Development</span>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-3">
                <div class="chart" data-percent="63" data-color="4CAF50">
                    <span class="percent"></span>
                    <div class="chart-text">
                        <span>Graphic Design</span>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-3">
                <div class="chart" data-percent="78" data-color="4CAF50">
                    <span class="percent"></span>
                    <div class="chart-text">
                        <span>Web Design</span>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-3">
                <div class="chart" data-percent="88">
                    <span class="percent"></span>
                    <div class="chart-text">
                        <span>Wordpress</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /End Our Skill Area  -->
<!--Start Our portfolio Area -->
<section id="our-portfolio" class="portfolio section-padding">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="section-title wow fadeInDown">
                    <h2>Our <span> portfolio</span ></h2>
                    <div class="border-line">
                        <span class="border-box"></span>
                    </div>
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <ul class="portfolio">
                    <li class="filter" data-filter="all">all Project</li>
                    <li class="filter" data-filter=".webdesign">webdesign</li>
                    <li class="filter" data-filter=".development">development</li>
                    <li class="filter" data-filter=".photography">photography</li>
                </ul>
            </div>
        </div>
        <div class="portfolio-inner">
            <div class="row portfolio-posts">
                <div class="mix photography development col-sm-6 col-md-4">
                    <div class="item">
                        <img src="{{ URL::to('fronts/images/portfolio/portfolio-1.jpg')}}" alt="">
                        <div class="portfolio-caption">
                            <a href="#" class="protfolio-link-bt"><i class="fa fa-chain"></i></a>
                            <a href="{{ URL::to('fronts/images/portfolio/portfolio-1.jpg')}}" class="protfolio-link-bt portfolio-img"><i class="fa fa-plus"></i></a>
                            <h3>Creative Business Portfolio</h3>
                        </div>
                    </div>
                </div>
                <div class="mix webdesign development col-sm-6 col-md-4">
                    <div class="item">
                        <img src="{{ URL::to('fronts/images/portfolio/portfolio-2.jpg')}}" alt="">
                        <div class="portfolio-caption">
                            <a href="#" class="protfolio-link-bt"><i class="fa fa-chain"></i></a>
                            <a href="{{ URL::to('fronts/images/portfolio/portfolio-1.jpg')}}" class="protfolio-link-bt portfolio-img"><i class="fa fa-plus"></i></a>
                            <h3>Business Creative Portfolio</h3>
                        </div>
                    </div>
                </div>
                <div class="mix webdesign development col-sm-6 col-md-4">
                    <div class="item">
                        <img src="{{ URL::to('fronts/images/portfolio/portfolio-3.jpg')}}" alt="">
                        <div class="portfolio-caption">
                            <a href="#" class="protfolio-link-bt"><i class="fa fa-chain"></i></a>
                            <a href="{{ URL::to('fronts/images/portfolio/portfolio-1.jpg')}}" class="protfolio-link-bt portfolio-img"><i class="fa fa-plus"></i></a>
                            <h3>Business Creative Portfolio</h3>
                        </div>
                    </div>
                </div>
                <div class="mix development development col-sm-6 col-md-4">
                    <div class="item">
                        <img src="{{ URL::to('fronts/images/portfolio/portfolio-4.jpg')}}" alt="">
                        <div class="portfolio-caption">
                            <a href="#" class="protfolio-link-bt"><i class="fa fa-chain"></i></a>
                            <a href="{{ URL::to('fronts/images/portfolio/portfolio-1.jpg')}}" class="protfolio-link-bt portfolio-img"><i class="fa fa-plus"></i></a>
                            <h3>Creative Business Portfolio</h3>
                        </div>
                    </div>
                </div>
                <div class="mix webdesign development col-sm-6 col-md-4">
                    <div class="item">
                        <img src="{{ URL::to('fronts/images/portfolio/portfolio-5.jpg')}}" alt="">
                        <div class="portfolio-caption">
                            <a href="#" class="protfolio-link-bt"><i class="fa fa-chain"></i></a>
                            <a href="{{ URL::to('fronts/images/portfolio/portfolio-1.jpg')}}" class="protfolio-link-bt portfolio-img"><i class="fa fa-plus"></i></a>
                            <h3>Business Creative Portfolio</h3>
                        </div>
                    </div>
                </div>
                <div class="mix development development col-sm-6 col-md-4">
                    <div class="item">
                        <img src="{{ URL::to('fronts/images/portfolio/portfolio-6.jpg')}}" alt="">
                        <div class="portfolio-caption">
                            <a href="#" class="protfolio-link-bt"><i class="fa fa-chain"></i></a>
                            <a href="{{ URL::to('fronts/images/portfolio/portfolio-1.jpg')}}" class="protfolio-link-bt portfolio-img"><i class="fa fa-plus"></i></a>
                            <h3>Business Creative Portfolio</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /End Our Portfolio Area -->
<!--Start counter Area -->
<section id="conuter" class="complete-project-conuter">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-3">
                <div class="single-counter">
                    <div class="counter-icon">
                        <i class="fa fa-thumbs-o-up" aria-hidden="true"></i>
                    </div>
                    <div class="counter-data">
                        <h2 class="counter">3,952</h2>
                        <h3>complete project</h3>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-3">
                <div class="single-counter">
                    <div class="counter-icon">
                        <i class="fa fa-users" aria-hidden="true"></i>
                    </div>
                    <div class="counter-data">
                        <h2 class="counter">9,052</h2>
                        <h3>Happy Customers</h3>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-3">
                <div class="single-counter">
                    <div class="counter-icon">
                        <i class="fa fa-clock-o" aria-hidden="true"></i>
                    </div>
                    <div class="counter-data">
                        <h2 class="counter">3,523</h2>
                        <h3>Hours worked</h3>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-3">
                <div class="single-counter">
                    <div class="counter-icon">
                        <i class="fa fa-hand-peace-o" aria-hidden="true"></i>
                    </div>
                    <div class="counter-data">
                        <h2 class="counter">6,052</h2>
                        <h3>Got Awards Top </h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /End Counter Area -->
<!--Start Our Team Area -->
<section id="our-team" class="section-padding">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="section-title wow fadeInDown">
                    <h2>Our <span>Team</span></h2>
                    <div class="border-line">
                        <span class="border-box"></span>
                    </div>
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 col-sm-6">
                <div class="single-team-item wow fadeIn" data-wow-delay="0.1s">
                    <div class="team-item-img">
                        <img src="{{ URL::to('fronts/images/team/team-1.jpg')}}" alt="">
                        <a href="#" class="team-link"><i class="fa fa-plus-square"></i></a>
                    </div>
                    <div class="team-item-description">
                        <h4>Mr. Minhajul Islam</h4>
                        <h6>Application Developer</h6>
                        <div class="team-item-social">
                            <ul>
                                <li class="facebook"><a href="#"><i class="fa fa-facebook"></i></a></li>
                                <li class="twitter"><a href="#"><i class="fa fa-twitter"></i></a></li>
                                <li class="dribbble"><a href="#"><i class="fa fa-dribbble"></i></a></li>
                                <li class="youtube"><a href="#"><i class="fa fa-youtube"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="single-team-item wow fadeIn" data-wow-delay="0.2s">
                    <div class="team-item-img">
                        <img src="{{ URL::to('fronts/images/team/team-2.jpg')}}" alt="">
                        <a href="#" class="team-link"><i class="fa fa-plus-square"></i></a>
                    </div>
                    <div class="team-item-description">
                        <h4>Taslim Hossain</h4>
                        <h6>UX/UI Designer</h6>
                        <div class="team-item-social">
                            <ul>
                                <li class="facebook"><a href="#"><i class="fa fa-facebook"></i></a></li>
                                <li class="twitter"><a href="#"><i class="fa fa-twitter"></i></a></li>
                                <li class="dribbble"><a href="#"><i class="fa fa-dribbble"></i></a></li>
                                <li class="youtube"><a href="#"><i class="fa fa-youtube"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="single-team-item wow fadeIn" data-wow-delay="0.3s">
                    <div class="team-item-img">
                        <img src="{{ URL::to('fronts/images/team/team-3.jpg')}}" alt="">
                        <a href="#" class="team-link"><i class="fa fa-plus-square"></i></a>
                    </div>
                    <div class="team-item-description">
                        <h4>Mr. Harun Ar Rashid</h4>
                        <h6>Online Marketer</h6>
                        <div class="team-item-social">
                            <ul>
                                <li class="facebook"><a href="#"><i class="fa fa-facebook"></i></a></li>
                                <li class="twitter"><a href="#"><i class="fa fa-twitter"></i></a></li>
                                <li class="dribbble"><a href="#"><i class="fa fa-dribbble"></i></a></li>
                                <li class="youtube"><a href="#"><i class="fa fa-youtube"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="single-team-item wow fadeIn" data-wow-delay="0.4s">
                    <div class="team-item-img">
                        <img src="{{ URL::to('fronts/images/team/team-4.jpg')}}" alt="">
                        <a href="#" class="team-link"><i class="fa fa-plus-square"></i></a>
                    </div>
                    <div class="team-item-description">
                        <h4>Mr. Mahadi Islam</h4>
                        <h6>Project Maneger</h6>
                        <div class="team-item-social">
                            <ul>
                                <li class="facebook"><a href="#"><i class="fa fa-facebook"></i></a></li>
                                <li class="twitter"><a href="#"><i class="fa fa-twitter"></i></a></li>
                                <li class="dribbble"><a href="#"><i class="fa fa-dribbble"></i></a></li>
                                <li class="youtube"><a href="#"><i class="fa fa-youtube"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /End Team Area -->
<!--Start Testimonial Area -->
<section id="testimonial" class="testimonial section-padding">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="section-title wow fadeInDown">
                    <h2>Our <span > Testimonial</span ></h2>
                    <div class="border-line">
                        <span class="border-box"></span>
                    </div>
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="testimonial-item owl-carousel">
                    <div class="testimonial-item-single">
                        <div class="testimonial-item-img">
                            <img src="{{ URL::to('fronts/images/testimonial/taslim.jpg')}}" alt="">
                        </div>
                        <i class="fa fa-quote-right" aria-hidden="true"></i>
                        <div class="testimonial-contact">
                            <h5>Taslim Hossain <span class="wht"> / </span> <span> UX/UI </span></h5>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Enim, magni, molestias! Similique illo mollitia accusamus, quidem laudantium amet....</p>
                        </div>
                    </div>
                    <div class="testimonial-item-single">
                        <div class="testimonial-item-img">
                            <img src="{{ URL::to('fronts/images/testimonial/minhaj.jpg"')}} alt="">
                        </div>
                        <i class="fa fa-quote-right" aria-hidden="true"></i>
                        <div class="testimonial-contact">
                            <h5>Md.Minhajul Islam <span class="wht"> / </span> <span> Developer </span></h5>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Enim, magni, molestias! Similique illo mollitia accusamus, quidem laudantium amet....</p>
                        </div>
                    </div>
                    <div class="testimonial-item-single">
                        <div class="testimonial-item-img">
                            <img src="{{ URL::to('fronts/images/testimonial/taslim.jpg')}}" alt="">
                        </div>
                        <i class="fa fa-quote-right" aria-hidden="true"></i>
                        <div class="testimonial-contact">
                            <h5>Taslim Hossain <span class="wht"> / </span> <span> UX/UI </span></h5>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Enim, magni, molestias! Similique illo mollitia accusamus, quidem laudantium amet....</p>
                        </div>
                    </div>
                    <div class="testimonial-item-single">
                        <div class="testimonial-item-img">
                            <img src="{{ URL::to('fronts/images/testimonial/minhaj.jpg')}}" alt="">
                        </div>
                        <i class="fa fa-quote-right" aria-hidden="true"></i>
                        <div class="testimonial-contact">
                            <h5>Md.Minhajul Islam <span class="wht"> / </span> <span> Developer </span></h5>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Enim, magni, molestias! Similique illo mollitia accusamus, quidem laudantium amet....</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /End Testimonial Area -->
<!-- our pricing Area -->
<section id="our-pricing" class="pricing section-padding">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="section-title wow fadeInDown">
                    <h2>Our <span > Pricing</span ></h2>
                    <div class="border-line">
                        <span class="border-box"></span>
                    </div>
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="single-pricing-box wow fadeIn" data-wow-delay="0.1s">
                    <h4>Basic</h4>
                    <div class="single-pricing-data">
                        <span class="dollar-symbol">$</span>
                        <h5>10</h5>
                        / Year
                    </div>
                    <div class="single-pricing-content">
                        <ul>
                            <li>10 GB Disk Space</li>
                            <li>100 GB Bandwidth</li>
                            <li>No Free Setup</li>
                            <li>5 Domain</li>
                            <li>5 Databases</li>
                            <li>20 Email Accounts</li>
                            <li>Automatic Cloud Backups</li>
                            <li>24 Hour Support</li>
                        </ul>
                    </div>
                    <a href="#" class="pricing-box-bt">BUY NOW</a>
                </div>
            </div>
            <div class="col-md-3">
                <div class="single-pricing-box active wow fadeIn" data-wow-delay="0.2s">
                    <h4>Standard</h4>
                    <div class="single-pricing-data">
                        <span class="dollar-symbol">$</span>
                        <h5>20</h5>
                        / Year
                    </div>
                    <div class="single-pricing-content">
                        <ul>
                            <li>20 GB Disk Space</li>
                            <li>200 GB Bandwidth</li>
                            <li>No Free Setup</li>
                            <li>5 Domain</li>
                            <li>5 Databases</li>
                            <li>20 Email Accounts</li>
                            <li>Automatic Cloud Backups</li>
                            <li>24 Hour Support</li>
                        </ul>
                    </div>
                    <a href="#" class="pricing-box-bt">BUY NOW</a>
                </div>
            </div>
            <div class="col-md-3">
                <div class="single-pricing-box wow fadeIn" data-wow-delay="0.3s">
                    <h4>Premium</h4>
                    <div class="single-pricing-data">
                        <span class="dollar-symbol">$</span>
                        <h5>30</h5>
                        / Year
                    </div>
                    <div class="single-pricing-content">
                        <ul>
                            <li>50 GB Disk Space</li>
                            <li>1000 GB Bandwidth</li>
                            <li>No Free Setup</li>
                            <li>20 Domain</li>
                            <li>100 Databases</li>
                            <li>200 Email Accounts</li>
                            <li>Automatic Cloud Backups</li>
                            <li>24 Hour Support</li>
                        </ul>
                    </div>
                    <a href="#" class="pricing-box-bt">BUY NOW</a>
                </div>
            </div>
            <div class="col-md-3">
                <div class="single-pricing-box wow fadeIn" data-wow-delay="0.4s">
                    <h4>Premium</h4>
                    <div class="single-pricing-data">
                        <span class="dollar-symbol">$</span>
                        <h5>35</h5>
                        / Year
                    </div>
                    <div class="single-pricing-content">
                        <ul>
                            <li>70 GB Disk Space</li>
                            <li>10000 GB Bandwidth</li>
                            <li>No Free Setup</li>
                            <li>30 Domain</li>
                            <li>300 Databases</li>
                            <li>500 Email Accounts</li>
                            <li>Automatic Cloud Backups</li>
                            <li>24 Hour Support</li>
                        </ul>
                    </div>
                    <a href="#" class="pricing-box-bt">BUY NOW</a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /End Our Pricing Area -->
<!--Start our Blog Area -->
<section id="our-blog" class="blog section-padding">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="section-title wow fadeInDown">
                    <h2>Our <span > Blog</span ></h2>
                    <div class="border-line">
                        <span class="border-box"></span>
                    </div>
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="single-blog-box wow fadeIn">
                    <div class="single-blog-images">
                        <img class="img-responsive" src="{{ URL::to('fronts/images/blog/blog-1.jpg')}}" alt="">
                    </div>
                    <div class="blog-data">
                        <p>10<span>SEP</span></p>
                    </div>
                    <div class="single-blog-content">
                        <h3>Top Learning Management System </h3>
                        <p class="signl-blog-meta">
                            <a href="#"><i class="fa fa-user"></i>by John Mitcher</a>
                            <a href="#"><i class="fa fa-folder-o" aria-hidden="true"></i>Office, Business</a>
                            <a href="#"><i class="fa fa-comment-o" aria-hidden="true"></i>25</a>
                        </p>
                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text</p>
                        <a href="single.html" class="sigle-blog-readmore-btn">Read more </a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="single-blog-box wow fadeIn" data-wow-duration="2s">
                    <div class="single-blog-images">
                        <img class="img-responsive" src="{{ URL::to('fronts/images/blog/blog-5.jpg')}}" alt="">
                    </div>
                    <div class="blog-data">
                        <p>10<span>SEP</span></p>
                    </div>
                    <div class="single-blog-content">
                        <h3>How to Create an Image Gallery </h3>
                        <p class="signl-blog-meta">
                            <a href="#"><i class="fa fa-user"></i>by John Mitcher</a>
                            <a href="#"><i class="fa fa-folder-o" aria-hidden="true"></i>Office, Business</a>
                            <a href="#"><i class="fa fa-comment-o" aria-hidden="true"></i>26</a>
                        </p>
                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text</p>
                        <a href="single.html" class="sigle-blog-readmore-btn">Read more </a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="single-blog-box wow fadeIn" data-wow-duration="4s">
                    <div class="single-blog-images">
                        <img class="img-responsive" src="{{ URL::to('fronts/images/blog/blog-6.jpg')}}" alt="">
                    </div>
                    <div class="blog-data">
                        <p>10<span>SEP</span></p>
                    </div>
                    <div class="single-blog-content">
                        <h3>Top Learning Management System </h3>
                        <p class="signl-blog-meta">
                            <a href="#"><i class="fa fa-user"></i>by John Mitcher</a>
                            <a href="#"><i class="fa fa-folder-o" aria-hidden="true"></i>Office, Business</a>
                            <a href="#"><i class="fa fa-comment-o" aria-hidden="true"></i>15</a>
                        </p>
                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text</p>
                        <a href="single.html" class="sigle-blog-readmore-btn">Read more </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /End Our Blog Area -->
@stop