
        <!-- Top Bar Start -->
        <div class="topbar">           
            <!-- Navbar -->
            <nav class="navbar-custom">    
                <ul class="list-unstyled topbar-nav float-right mb-0"> 
                    

                    <li class="dropdown">
                        <a class="nav-link dropdown-toggle waves-effect waves-light nav-user" data-toggle="dropdown" href="#" role="button"
                            aria-haspopup="false" aria-expanded="false">
                            @if(Auth::user()->picture!="")
                            <img src="{{ asset('uploads/profile/'.Auth::user()->picture) }}"  class="rounded-circle">
                            
                            @else
                            <img src="{{ URL::asset('assets/images/users/user-4.jpg')}}"  class="rounded-circle" /> 
                            @endif
                            <span class="ml-1 nav-user-name hidden-sm"> {{Auth::user()->name .' '.Auth::user()->last_name}} <i class="mdi mdi-chevron-down"></i> </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="{{route(auth_info().'.my_profile',[get_route_url()])}}"><i class="dripicons-user text-muted mr-2"></i> Profile</a>
                            
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="javascript:void(0);" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="dripicons-exit text-muted mr-2"></i> Logout</a>
                            <form id="logout-form" action="{{ route('logout',[get_route_url()]) }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                    <li class="mr-2">
                        <a href="#" class="nav-link" data-toggle="modal" data-animation="fade" data-target=".modal-rightbar">
                            <i data-feather="align-right" class="align-self-center"></i>
                        </a>                  
                    </li>
                </ul><!--end topbar-nav-->
    
                <ul class="list-unstyled topbar-nav mb-0">  
                    <li>
                        <a href="javascript:void(0);">
                            <span class="responsive-logo">
                                <img src="{{ URL::asset('assets/images/logo-sm.png')}}" alt="logo-small" class="logo-sm align-self-center" height="34">
                            </span>
                        </a>                        
                    </li>                      
                    <li>
                        <button class="button-menu-mobile nav-link">
                            <i data-feather="menu" class="align-self-center"></i>
                        </button>
                    </li>
                    
                </ul>
            </nav>
            <!-- end navbar-->
        </div>
        <!-- Top Bar End -->
