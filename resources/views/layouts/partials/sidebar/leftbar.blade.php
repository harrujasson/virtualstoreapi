 <!-- leftbar-tab-menu -->
        <div class="leftbar-tab-menu">
            <div class="main-icon-menu">
                <a href="/crm/crm-index" class="logo logo-metrica d-block text-center">
                    <span>
                        <img src="{{ URL::asset('assets/images/logo-sm.png')}}" alt="logo-small" class="logo-sm">
                    </span>
                </a>
                <nav class="nav">
                    <a href="#Dashboard" class="nav-link" data-toggle="tooltip-custom" data-placement="right"  data-trigger="hover" title="" data-original-title="Dashboard">
                        <i data-feather="monitor" class="align-self-center menu-icon icon-dual"></i>
                    </a>
                    @if(Auth::user()->role == 1)
                    <a href="#Clients" class="nav-link" data-toggle="tooltip-custom" data-placement="right"  data-trigger="hover" title="" data-original-title="Customers">
                        <i data-feather="users" class="align-self-center menu-icon icon-dual"></i>
                    </a>
                    @endif
                    @if(Auth::user()->role == 1)
                    <a href="#Store" class="nav-link" data-toggle="tooltip-custom" data-placement="right"  data-trigger="hover" title="" data-original-title="Store Manage">
                        <i data-feather="shopping-bag" class="align-self-center menu-icon icon-dual"></i>
                    </a>
                    @endif
                    <a href="#Orders" class="nav-link" data-toggle="tooltip-custom" data-placement="right"  data-trigger="hover" title="" data-original-title="Orders Manage">
                        <i data-feather="shopping-cart" class="align-self-center menu-icon icon-dual"></i>
                    </a>

                </nav><!--end nav-->

            </div><!--end main-icon-menu-->

            <div class="main-menu-inner">
                <!-- LOGO -->
                <div class="topbar-left">
                    <a href="javascript:void(0);" class="logo">
                        <h3 class="sidebar_top_title">{{Config::get('constants.AppnameGlobe') }}</h3>
                    </a>
                </div>
                <!--end logo-->
                <div class="menu-body slimscroll">                    
                    <div id="Dashboard" class="main-icon-menu-pane">
                        <div class="title-box">
                            <h6 class="menu-title">Dashboard</h6>       
                        </div>
                        <ul class="nav">
                            @if(Auth::user()->role == 1)
                                <li class="nav-item"><a id="dashboard" class="nav-link" href="{{route('admin.home')}}">Dashboard</a></li>
                                <li class="nav-item"><a id="my_profile" class="nav-link" href="{{route('admin.my_profile')}}">My Profile</a></li>
                                <li class="nav-item"><a id="config" class="nav-link" href="{{route('admin.config')}}">Set up my Vstore</a></li>
                                
                            @endif
                            @if(Auth::user()->role == 2)
                            <li class="nav-item"><a id="my_profile" class="nav-link" href="{{route('customer.my_profile')}}">Profile</a></li>
                            <li class="nav-item"><a id="wishlist" class="nav-link" href="{{route('customer.wishlist')}}">Wishlist</a></li>
                            @endif
                        </ul>
                    </div>
                    @if(Auth::user()->role == 1)
                    <div id="Clients" class="main-icon-menu-pane">
                        <div class="title-box">
                            <h6 class="menu-title">Customers</h6>       
                        </div>
                        <ul class="nav">
                            <li class="nav-item"><a id="client_new" class="nav-link" href="{{route('admin.user.new_user')}}">Add New</a></li>
                            <li class="nav-item"><a id="client_manage" class="nav-link" href="{{route('admin.user.manage')}}">Manage</a></li>
                        </ul>
                    </div>
                    @endif
                    @if(Auth::user()->role == 1)
                    <div id="Store" class="main-icon-menu-pane">
                        <div class="title-box">
                            <h6 class="menu-title">Store Manage</h6>       
                        </div>
                        <ul class="nav">
                            <li class="nav-item"><a id="tax" class="nav-link" href="{{route('admin.tax.manage')}}">Tax</a></li>
                            <li class="nav-item"><a id="category" class="nav-link" href="{{route('admin.category.manage')}}">Category</a></li>
                            <li class="nav-item"><a id="product" class="nav-link" href="{{route('admin.product.manage')}}">Product</a></li>
                            
                        </ul>
                    </div>
                    @endif

                    <div id="Orders" class="main-icon-menu-pane">
                        <div class="title-box">
                            <h6 class="menu-title">Orders</h6>       
                        </div>
                        <ul class="nav">
                            @if(Auth::user()->role == 1)
                                <li class="nav-item"><a id="orders_manage" class="nav-link" href="{{route('admin.orders.manage')}}">Manage</a></li>
                            @endif
                            @if(Auth::user()->role == 2)
                            <li class="nav-item"><a id="orders_manage" class="nav-link" href="{{route('customer.orders')}}">Orders</a></li>
                            @endif
                        </ul>
                    </div>
                    
                </div><!--end menu-body-->
            </div><!-- end main-menu-inner-->
        </div>
        <!-- end leftbar-tab-menu-->