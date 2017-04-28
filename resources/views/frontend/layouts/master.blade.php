<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title',App\Models\Setting::get("title"))</title>

    <meta name="description" content="@yield('meta_description',App\Models\Setting::get("meta_description"))">

    {{--<link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">--}}

    {!! HTML::style('css/bootstrap.min.css') !!}
    {!! HTML::style('css/bootstrap-select.min.css') !!}
    {!! HTML::style('css/font-awesome.min.css') !!}
    {!! HTML::style('css/style.css') !!}

    @yield('styles')

    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>

    <div class="toppurple"></div>

    <!-- Header -->
    <div id="header">
      <div class="container">
 
        <a id="logo" class="pull-left" href="{{ URL::to('') }}"><img src="{{ URL::to('img/logo.png') }}" alt="Business Directory Logo" /></a>

        <div class="row">
          <nav class="navbar navbar-default navbar-custom">
            <div class="container-fluid">
              <!-- Brand and toggle get grouped for better mobile display -->
              <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                  <span class="sr-only">Toggle navigation</span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                </button>
                
              </div>

              <!-- Collect the nav links, forms, and other content for toggling -->
              <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

                <ul class="nav navbar-nav navbar-right">
                  <li><a class="{{ Request::is('/') ? 'active' : ''}}" href="{{ URL::to('') }}">Search</a></li>
                  <li><a class="{{ Request::is('submit-listing') ? 'active' : ''}}" href="{{ URL::to('submit-listing') }}">Submit Listing</a></li>
                  <li><a class="{{ Request::is('news') ? 'active' : ''}}" href="{{ URL::to('news') }}">News</a></li>
                  @if (Entrust::hasRole('admin'))
                    <li><a href="{{ URL::to('admin') }}">Admin Panel</a></li>
                  @endif

                  @if (!Auth::check())
                  <li><a class="{{ Request::is('register') ? 'active' : ''}}" href="{{ URL::to('register') }}">Register</a></li>
                  <li><a class="{{ Request::is('login') ? 'active' : ''}}" href="{{ URL::to('login') }}">Login</a></li>
                  @else

                  <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{Auth::user()->email}} <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                      <li><a class="{{ Request::is('my-listings') ? 'active' : ''}}" href="{{ URL::to('my-listings') }}">My Listings</a></li>
                      <li><a class="{{ Request::is('my-account') ? 'active' : ''}}" href="{{ URL::to('my-account') }}">My Account</a></li>
                      <li><a href="{{ URL::to('logout') }}">Logout</a></li>
                    </ul>
                  </li>

                  @endif


                </ul>
                
              </div><!-- /.navbar-collapse -->

            </div><!-- /.container-fluid -->
          </nav>
        </div>
       


      </div>
    </div>


    @if (Session::has('flash_notification.message'))
      <div class="container" style="margin-top:10px;">
      @include('flash::message')
      </div>
    @endif

    <!-- Content -->
    @yield('content')




    <footer id="footer">
      <div class="footer-inner container">
          <div class="pull-left">© Business Directory 2017 
            <span class="footer-nav">
              <span class="item"><a href="{{ URL::to('privacy-policy') }}">Privacy Policy</a></span>
              <span class="item"><a href="{{ URL::to('terms-conditions') }}">Terms and Conditions</a></span>
              <span class="item"><a href="{{ URL::to('faq') }}">FAQ</a></span>
              <span class="item"><a href="{{ URL::to('contact') }}">Contact</a></span>
            </span>


          </div>
          <div class="pull-right"></div>
      </div>
    </footer>
    

    <!-- Scripts -->
    {!! HTML::script('js/jquery-1.11.3.min.js') !!}
    {!! HTML::script('js/bootstrap.min.js') !!}
    {!! HTML::script('js/bootstrap-select.min.js') !!}
    

    <script>

    $("#incfont").click(function(){
           $('*').each(function(){
           var k =  parseInt($(this).css('font-size')); 
           var redSize = ((k*110)/100);
               $(this).css('font-size',redSize);  

           });
    });

    $("#decfont").click(function(){
           $('*').each(function(){
           var k =  parseInt($(this).css('font-size')); 
           var redSize = ((k*90)/100);
               $(this).css('font-size',redSize);  

           });
    });


    $('.selectpicker').selectpicker();

    function initAll(){

      $( document ).ready(function() {

        if (typeof initHomeMap != "undefined") { 
            initHomeMap();
        }
        if (typeof initSearch != "undefined") { 
            initSearch();
        }
        if (typeof initSubmitMap != "undefined") { 
            initSubmitMap();
        }

        if (typeof initViewMap != "undefined") { 
            initViewMap();
        }

      });

    }


    </script>

    <script async defer src="https://maps.googleapis.com/maps/api/js?key={{ env('GMAP_KEY') }}&libraries=places&region=AU&language=en-AU&callback=initAll"></script>

    @yield('scripts')



  </body>
</html>