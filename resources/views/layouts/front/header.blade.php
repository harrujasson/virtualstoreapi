<header id="header-fixed">
   <div class="header-wrapper pb-3 pt-3">
      <div class="container">
            <div class="row">
               <div class="col-md-12">
                  <!-- navbar-wrapper -->


                  <nav class=" navbar navbar-expand-lg p-0 ">
                        <div class="container">

                           <div class="logo d-flex">
                              <div class="logo-img mr-4">
                                    <a href="/">
                                       <img src="{{asset('assets/front/images/Gong Cha 1.png')}}" alt="">
                                    </a>
                              </div>

                              <div class="logo-side-content d-flex flex-column justify-content-center">
                                    <h5 class="logo-title-head mb-1">{{configinfo('store_name')}} <span
                                          class="logo-badge">({{(configinfo('status') ? "Open":"Close")}})</span> </h5>

                                    <div class="logo-bottom-content">
                                       <ul class="d-flex justify-content-between">
                                          <li>Health</li>
                                          <li>Sports</li>
                                          <li>Apparel</li>
                                       </ul>
                                    </div>
                              </div>

                           </div>

                           <div class="navbar-collapse justify-content-center" id="navbarSupportedContent">
                              <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                                    <li class="nav-item">
                                       <a class="nav-link active" aria-current="page" href="/">
                                          <div class="span-icon">
                                                <span class="">
                                                   <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                                      xmlns="http://www.w3.org/2000/svg">
                                                      <path
                                                            d="M8.41301 13.8731C8.18634 13.9531 7.81301 13.9531 7.58634 13.8731C5.65301 13.2131 1.33301 10.4597 1.33301 5.79307C1.33301 3.73307 2.99301 2.06641 5.03967 2.06641C6.25301 2.06641 7.32634 2.65307 7.99967 3.55974C8.67301 2.65307 9.75301 2.06641 10.9597 2.06641C13.0063 2.06641 14.6663 3.73307 14.6663 5.79307C14.6663 10.4597 10.3463 13.2131 8.41301 13.8731Z"
                                                            stroke="#2CCA61" stroke-width="1.5"
                                                            stroke-linecap="round" stroke-linejoin="round" />
                                                   </svg>
                                                </span>
                                          </div>
                                          Fav store
                                       </a>
                                    </li>
                                    <li class="nav-item">
                                       <a class="nav-link" href="{{route('shop',[get_route_url()])}}">
                                          <div class="span-icon">
                                                <span class="">
                                                   <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                                      xmlns="http://www.w3.org/2000/svg">
                                                      <path
                                                            d="M2.00671 7.48001V10.4733C2.00671 13.4667 3.20671 14.6667 6.20005 14.6667H9.79338C12.7867 14.6667 13.9867 13.4667 13.9867 10.4733V7.48001"
                                                            stroke="white" stroke-width="1.5" stroke-linecap="round"
                                                            stroke-linejoin="round" />
                                                      <path
                                                            d="M7.99999 8.00001C9.21999 8.00001 10.12 7.00668 9.99999 5.78668L9.55999 1.33334H6.44666L5.99999 5.78668C5.87999 7.00668 6.77999 8.00001 7.99999 8.00001Z"
                                                            stroke="white" stroke-width="1.5" stroke-linecap="round"
                                                            stroke-linejoin="round" />
                                                      <path
                                                            d="M12.2067 8.00001C13.5533 8.00001 14.54 6.90668 14.4067 5.56668L14.22 3.73334C13.98 2.00001 13.3133 1.33334 11.5667 1.33334H9.53333L9.99999 6.00668C10.1133 7.10668 11.1067 8.00001 12.2067 8.00001Z"
                                                            stroke="white" stroke-width="1.5" stroke-linecap="round"
                                                            stroke-linejoin="round" />
                                                      <path
                                                            d="M3.76004 8.00001C4.86004 8.00001 5.85338 7.10668 5.96004 6.00668L6.10671 4.53334L6.42671 1.33334H4.39338C2.64671 1.33334 1.98004 2.00001 1.74004 3.73334L1.56004 5.56668C1.42671 6.90668 2.41338 8.00001 3.76004 8.00001Z"
                                                            stroke="white" stroke-width="1.5" stroke-linecap="round"
                                                            stroke-linejoin="round" />
                                                      <path
                                                            d="M8.00004 11.3333C6.88671 11.3333 6.33337 11.8867 6.33337 13V14.6667H9.66671V13C9.66671 11.8867 9.11337 11.3333 8.00004 11.3333Z"
                                                            stroke="white" stroke-width="1.5" stroke-linecap="round"
                                                            stroke-linejoin="round" />
                                                   </svg>
                                                </span>
                                          </div>
                                          Shop now

                                       </a>
                                    </li>

                                    <li class="nav-item">
                                       <a class="nav-link" href="#">
                                          <div class="span-icon">
                                                <span class="">
                                                   <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                                      xmlns="http://www.w3.org/2000/svg">
                                                      <path
                                                            d="M6.00004 14.6667H10C13.3334 14.6667 14.6667 13.3333 14.6667 10V6.00001C14.6667 2.66668 13.3334 1.33334 10 1.33334H6.00004C2.66671 1.33334 1.33337 2.66668 1.33337 6.00001V10C1.33337 13.3333 2.66671 14.6667 6.00004 14.6667Z"
                                                            stroke="white" stroke-width="1.5" stroke-linecap="round"
                                                            stroke-linejoin="round" />
                                                      <path d="M11.6667 11.3867H10.4333" stroke="white"
                                                            stroke-width="1.5" stroke-linecap="round"
                                                            stroke-linejoin="round" />
                                                      <path d="M8.64671 11.3867H4.33337" stroke="white"
                                                            stroke-width="1.5" stroke-linecap="round"
                                                            stroke-linejoin="round" />
                                                      <path d="M11.6666 8.88H7.97998" stroke="white"
                                                            stroke-width="1.5" stroke-linecap="round"
                                                            stroke-linejoin="round" />
                                                      <path d="M6.18004 8.88H4.33337" stroke="white"
                                                            stroke-width="1.5" stroke-linecap="round"
                                                            stroke-linejoin="round" />
                                                   </svg>

                                                </span>
                                          </div>
                                          Store details

                                       </a>
                                    </li>

                                    <li class="nav-item d-none">
                                       <a class="nav-link" href="#">
                                          <div class="span-icon">
                                                <span class="">
                                                   <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                                      xmlns="http://www.w3.org/2000/svg">
                                                      <path
                                                            d="M10.26 3.47398L11.2 5.35398C11.3266 5.61398 11.6666 5.86064 11.9533 5.91398L13.6533 6.19398C14.74 6.37398 14.9933 7.16065 14.2133 7.94731L12.8866 9.27398C12.6666 9.49398 12.54 9.92731 12.6133 10.2406L12.9933 11.8807C13.2933 13.174 12.6 13.6806 11.46 13.0006L9.86663 12.054C9.57996 11.8806 9.09997 11.8806 8.8133 12.054L7.21996 13.0006C6.07996 13.674 5.38663 13.174 5.68663 11.8807L6.06664 10.2406C6.13997 9.93398 6.0133 9.50065 5.7933 9.27398L4.46664 7.94731C3.68664 7.16731 3.93997 6.38064 5.02664 6.19398L6.72663 5.91398C7.0133 5.86731 7.3533 5.61398 7.47997 5.35398L8.41997 3.47398C8.91997 2.45398 9.74664 2.45398 10.26 3.47398Z"
                                                            stroke="white" stroke-width="1.5" stroke-linecap="round"
                                                            stroke-linejoin="round" />
                                                      <path d="M5.33301 3.33398H1.33301" stroke="white"
                                                            stroke-width="1.5" stroke-linecap="round"
                                                            stroke-linejoin="round" />
                                                      <path d="M3.33301 12.666H1.33301" stroke="white"
                                                            stroke-width="1.5" stroke-linecap="round"
                                                            stroke-linejoin="round" />
                                                      <path d="M1.99967 8H1.33301" stroke="white"
                                                            stroke-width="1.5" stroke-linecap="round"
                                                            stroke-linejoin="round" />
                                                   </svg>

                                                </span>
                                          </div>
                                          Stamp

                                       </a>
                                    </li>

                                    <li class="nav-item">
                                       <a class="nav-link" href="#">
                                          <div class="span-icon">
                                                <span class="">
                                                   <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                                      xmlns="http://www.w3.org/2000/svg">
                                                      <path
                                                            d="M14.667 9.46598V11.866C14.667 13.866 13.867 14.666 11.867 14.666H9.46699C7.46699 14.666 6.66699 13.866 6.66699 11.866V9.33268C6.70033 7.47268 7.47366 6.69935 9.33366 6.66602H11.867C13.867 6.66602 14.667 7.46598 14.667 9.46598Z"
                                                            stroke="white" stroke-width="1.5" stroke-linecap="round"
                                                            stroke-linejoin="round" />
                                                      <path
                                                            d="M9.97314 9.07975C9.6198 9.31975 9.15314 9.31974 8.7998 9.06641"
                                                            stroke="white" stroke-width="1.5" stroke-miterlimit="10"
                                                            stroke-linecap="round" stroke-linejoin="round" />
                                                      <path
                                                            d="M12.6401 9.07975C12.2868 9.31975 11.8201 9.31974 11.4668 9.06641"
                                                            stroke="white" stroke-width="1.5" stroke-miterlimit="10"
                                                            stroke-linecap="round" stroke-linejoin="round" />
                                                      <path
                                                            d="M9.22621 10.7871H12.1062C12.3062 10.7871 12.4662 10.9471 12.4662 11.1471C12.4662 12.1404 11.6595 12.9471 10.6662 12.9471C9.67288 12.9471 8.86621 12.1404 8.86621 11.1471C8.86621 10.9471 9.02621 10.7871 9.22621 10.7871Z"
                                                            stroke="white" stroke-width="1.5" stroke-miterlimit="10"
                                                            stroke-linecap="round" stroke-linejoin="round" />
                                                      <path
                                                            d="M5.18667 6.64067C5.08667 6.674 4.92 6.674 4.81333 6.64067C3.94667 6.34067 2 5.10732 2 3.00732C2 2.08066 2.74667 1.33398 3.66667 1.33398C4.21333 1.33398 4.69333 1.59398 5 2.00065C5.30667 1.59398 5.78667 1.33398 6.33333 1.33398C7.25333 1.33398 8 2.08066 8 3.00732C7.99333 5.10732 6.05333 6.34067 5.18667 6.64067Z"
                                                            stroke="white" stroke-width="1.5" stroke-linecap="round"
                                                            stroke-linejoin="round" />
                                                   </svg>


                                                </span>
                                          </div>
                                          Membership

                                       </a>
                                    </li>


                              </ul>

                           </div>

                           <div class="header-profile-wrapper d-flex justify-content-between">
                           @if(Auth::check())
                              <div class="user-icon p-2">
                                    <a href="{{ route('login',[get_route_url()]) }}">
                                       <span>
                                          <i class="fa fa-user-circle-o" aria-hidden="true"></i>
                                       </span>
                                    </a>

                                    <a  class="nav-link" href="{{ route('logout',[get_route_url()]) }}" onclick="event.preventDefault();
                                       document.getElementById('logout-form').submit();">Signout</a>
                                    <form id="logout-form" action="{{ route('logout',[get_route_url()]) }}" method="POST" style="display: none;">
                                       {{ csrf_field() }}
                                    </form>
                              </div>
                           @else
                           <a href="{{ route('login',[get_route_url()]) }}" data-toggle="modal" data-target="#LoginModel">Sign In</a>   
                           @endif   
                              <div class="header-serach">

                                    <!-- Button to Open the Modal -->
                                    <button type="button" id="searchTopbar" class="btn ">
                                       <i class="fa fa-search" aria-hidden="true"></i>
                                    </button>

                                    <a href="{{ route('cart_list',[get_route_url()]) }}" class="cart-box">
                                       <span class="cart"><i class="fa fa-shopping-cart" aria-hidden="true"></i></span>
                                       <span class="count">{{ Cart::count() }}</span>
                                    </a>

                              </div>
                           </div>
                        </div>
                  </nav>
               </div>
            </div>
      </div>
   </div>
</header>