<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <title> @yield('title') | {{Config::get('constants.AppnameGlobe') }}</title>
    <meta name="description" content="@yield('description')">
    <meta name="keywords" content="@yield('keywords')">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- App favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ URL::asset('assets/front/img/favicon.png') }}">
    @include('layouts.front.head-css')
</head>


<body>
    @include('layouts.front.header')
    <main>
        @yield('content')
    </main>
    @include('layouts.front.footer')
    @include('layouts.front.scripts')

    <!--Loader-->
    <div id="loader-notificaiton" class="loading_loader">
        <div class="spinner-border" role="status">
        <span class="sr-only">Loading...</span>
        </div>
    </div>

   <!--Model Login-Form-->
   <div class="modal fade" id="LoginModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
      <div class="login_form_modal" >
         <div class="modal-dialog" role="document">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Login</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
               </div>
               <div class="modal-body">
                  <div class="Login_Form">
                     <form class="form-horizontal" id="front_login_form" method="POST" action="javascript:void(0);">
                        @csrf
                        <div class="form_group">
                           <label>Email</label>
                           <input type="email" id="email" name="email" placeholder="Enter Your Email" required>
                        </div>
                        <div class="form_group">
                           <label>Password</label>
                           <input type="Password" id="Password" name="password" placeholder="Enter Your Password" required><br>
                           
                        </div>
                        <div class="form_group form_submit_buttons">
                           <button type="submit" class="btn btn-md">Login</button>
                           <a href="{{route('register',[get_route_url()])}}">Sign Up</a>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
    <!--End Model Login-Form--> 

    <!---------Search popup--------------------->
   <form method="get" action="{{route('shop',[get_route_url()])}}">
      <div class="modal fade" id="searchModal" tabindex="-1" role="dialog" aria-labelledby="searchModalLabel" aria-hidden="true">
         <div class="modal-dialog" role="document">
            <div class="modal-content">
               <button type="button" class="close" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i>
               </button>
               <div class="modal-body">
                    <input type="text" placeholder="Search.." name="search">
                    <button type="submit"><i class="fa fa-search"></i></button>
			    </div>
		   </div>
	    </div>
   </form>
   <!---------End Search popup--------------------->
</body>

</html>
