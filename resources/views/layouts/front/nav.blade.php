<!-- Navbar -->
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-nav-collapse" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{route('index')}}"><img src="{{ URL::to('img/logo.png')}}" height="50" width="100" alt="{{config('app.name')}}"></a>
        </div>
        <div class="collapse navbar-collapse" id="main-nav-collapse">
            <ul class="nav navbar-nav navbar-right">
                <li class="active"><a href="{{ route('index')}}">Home</a></li>
                <li><a class="smoth-scroll" href="#about-us">About</a></li>
                <li><a class="smoth-scroll" href="#special">FEATURES</a></li>
                <li><a class="smoth-scroll" href="#our-skill">Skill</a></li>
                <li><a class="smoth-scroll" href="#our-portfolio">WORKS</a></li>
                <li><a class="smoth-scroll" href="#our-team">Team</a></li>
                <li><a class="smoth-scroll" href="#our-pricing">pricing</a></li>
                <li><a class="smoth-scroll" href="#our-blog">BLOG</a></li>
                <li><a class="smoth-scroll" href="#contacts">Contacts</a></li>
                <li><a class="btn btn-xs btn-normal navbar-right" href="{{ route('login')}}">&nbsp;&nbsp; LOGIN &nbsp;&nbsp;</a></li>
            </ul>
        </div>
    </div>
</nav>
<!-- /End Navbar -->