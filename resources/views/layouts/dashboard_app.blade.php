<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Twitter -->
    <meta name="twitter:site" content="@themepixels">
    <meta name="twitter:creator" content="@themepixels">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Starlight">
    <meta name="twitter:description" content="Premium Quality and Responsive UI for Dashboard.">
    <meta name="twitter:image" content="http://themepixels.me/starlight/img/starlight-social.png">

    <!-- Facebook -->
    <meta property="og:url" content="http://themepixels.me/starlight">
    <meta property="og:title" content="Starlight">
    <meta property="og:description" content="Premium Quality and Responsive UI for Dashboard.">

    <meta property="og:image" content="http://themepixels.me/starlight/img/starlight-social.png">
    <meta property="og:image:secure_url" content="http://themepixels.me/starlight/img/starlight-social.png">
    <meta property="og:image:type" content="image/png">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="600">

    <!-- Meta -->
    <meta name="description" content="Premium Quality and Responsive UI for Dashboard.">
    <meta name="author" content="ThemePixels">

    <title>@yield('title')</title>

    <!-- vendor css -->
    <link href="{{asset('dashboard_asset')}}/lib/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="{{asset('dashboard_asset')}}/lib/Ionicons/css/ionicons.css" rel="stylesheet">
    <link href="{{asset('dashboard_asset')}}/lib/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet">
    <link href="{{asset('dashboard_asset')}}/lib/datatables/jquery.dataTables.css" rel="stylesheet">
    <link href="{{asset('dashboard_asset')}}/lib/highlightjs/github.css" rel="stylesheet">


    <!-- Starlight CSS -->
    <link rel="stylesheet" href="{{asset('dashboard_asset')}}/css/starlight.css">

    <link rel="stylesheet" type="text/css" href="{{asset('knockout-file')}}/knockout-file-bindings.css">

    <!-- Fontawesome -->
    <script src="https://kit.fontawesome.com/6437382604.js" crossorigin="anonymous"></script>
    <script src="https://cdn.ckeditor.com/4.14.1/full-all/ckeditor.js"></script>
</head>

<body>

    <!-- ########## START: LEFT PANEL ########## -->
    <div class="sl-logo"><a href=""><i class="icon ion-android-star-outline"></i> {{env('APP_NAME')}}</a></div>
    <div class="sl-sideleft">
        <div class="input-group input-group-search">
            <input type="search" name="search" class="form-control" placeholder="Search">
            <span class="input-group-btn">
                <button class="btn"><i class="fa fa-search"></i></button>
            </span><!-- input-group-btn -->
        </div><!-- input-group -->

        <label class="sidebar-label">Navigation</label>
        <div class="sl-sideleft-menu">
            @if (Auth::user()->role == 2)
            <a href="{{url('customer/home')}}" class="sl-menu-link @yield('customer_home')">
                <div class="sl-menu-item">
                    <i class="menu-item-icon icon ion-ios-home-outline tx-22"></i>
                    <span class="menu-item-label">Customer Home</span>
                </div><!-- menu-item -->
            </a><!-- sl-menu-link -->
            @else
            <a href="{{url('home')}}" class="sl-menu-link @yield('home')">
                <div class="sl-menu-item">
                    <i class="menu-item-icon icon ion-ios-home-outline tx-22"></i>
                    <span class="menu-item-label">Home</span>
                </div><!-- menu-item -->
            </a><!-- sl-menu-link -->
            <a href="{{url('add/category')}}" class="sl-menu-link @yield('category')">
                <div class="sl-menu-item">
                    <i class="menu-item-icon icon ion-ios-photos-outline tx-20"></i>
                    <span class="menu-item-label">Category</span>
                </div><!-- menu-item -->
            </a><!-- sl-menu-link -->
            <a href="{{route('product.index')}}" class="sl-menu-link @yield('product')">
                <div class="sl-menu-item">
                    <i class="menu-item-icon icon ion-ios-filing-outline tx-24"></i>
                    <span class="menu-item-label">Product</span>
                </div><!-- menu-item -->
            </a><!-- sl-menu-link -->
            <a href="{{route('order.index')}}" class="sl-menu-link @yield('order')">
                <div class="sl-menu-item">
                    <i class="menu-item-icon icon ion-ios-filing-outline tx-24"></i>
                    <span class="menu-item-label">Orders</span>
                </div><!-- menu-item -->
            </a><!-- sl-menu-link -->
            <a href="{{route('testimonial.index')}}" class="sl-menu-link @yield('testimonial')">
                <div class="sl-menu-item">
                    <i class="menu-item-icon icon ion-ios-paper-outline tx-22"></i>
                    <span class="menu-item-label">Testimonial</span>
                </div><!-- menu-item -->
            </a><!-- sl-menu-link -->
            <a href="{{route('banner.index')}}" class="sl-menu-link @yield('banner')">
                <div class="sl-menu-item">
                    <i class="menu-item-icon icon ion-ios-bookmarks-outline tx-20"></i>
                    <span class="menu-item-label">Banner</span>
                </div><!-- menu-item -->
            </a><!-- sl-menu-link -->
            <a href="#" class="sl-menu-link @yield('blog')">
                <div class="sl-menu-item">
                    <i class="menu-item-icon icon ion-ios-email-outline tx-24"></i>
                    <span class="menu-item-label">Blog</span>
                    <i class="menu-item-arrow fa fa-angle-down"></i>
                </div><!-- menu-item -->
            </a><!-- sl-menu-link -->
            <ul class="sl-menu-sub nav flex-column">
                <li class="nav-item"><a href="{{route('blog.create')}}" class="nav-link @yield('create_post')">Create
                        Post</a></li>
                <li class="nav-item"><a href="{{route('blog.index')}}" class="nav-link @yield('view_posts')">View
                        Posts</a></li>
            </ul>
            <a href="#" class="sl-menu-link @yield('contact_message') @yield('contact_message_trash')">
                <div class="sl-menu-item">
                    <i class="menu-item-icon icon ion-ios-email-outline tx-24"></i>
                    <span class="menu-item-label">Contact Message</span>
                    <i class="menu-item-arrow fa fa-angle-down"></i>
                </div><!-- menu-item -->
            </a><!-- sl-menu-link -->
            <ul class="sl-menu-sub nav flex-column">
                <li class="nav-item"><a href="{{route('message.index')}}"
                        class="nav-link @yield('contact_message')">Messages</a></li>
                <li class="nav-item"><a href="{{route('message.create')}}"
                        class="nav-link @yield('contact_message_trash')">Trash</a></li>
            </ul>
            <a href="{{route('faq.index')}}" class="sl-menu-link @yield('faq')">
                <div class="sl-menu-item">
                    <i class="menu-item-icon ion-ios-pie-outline tx-20"></i>
                    <span class="menu-item-label">FAQ</span>
                </div><!-- menu-item -->
            </a><!-- sl-menu-link -->
            <a href="{{route('coupon.index')}}" class="sl-menu-link @yield('coupon')">
                <div class="sl-menu-item">
                    <i class="menu-item-icon icon ion-ios-filing-outline tx-24"></i>
                    <span class="menu-item-label">Coupon</span>
                </div><!-- menu-item -->
            </a><!-- sl-menu-link -->
            <a href="{{route('contactinfo')}}" class="sl-menu-link @yield('contactinfo')">
                <div class="sl-menu-item">
                    <i class="menu-item-icon ion-ios-pie-outline tx-20"></i>
                    <span class="menu-item-label">Contact Info</span>
                </div><!-- menu-item -->
            </a><!-- sl-menu-link -->
            @endif

            <a href="#" class="sl-menu-link">
                <div class="sl-menu-item">
                    <i class="menu-item-icon ion-ios-pie-outline tx-20"></i>
                    <span class="menu-item-label">Reserved</span>
                    <i class="menu-item-arrow fa fa-angle-down"></i>
                </div><!-- menu-item -->
            </a><!-- sl-menu-link -->
            <ul class="sl-menu-sub nav flex-column">
                <li class="nav-item"><a href="chart-morris.html" class="nav-link">Morris Charts</a></li>
                <li class="nav-item"><a href="chart-flot.html" class="nav-link">Flot Charts</a></li>
                <li class="nav-item"><a href="chart-chartjs.html" class="nav-link">Chart JS</a></li>
                <li class="nav-item"><a href="chart-rickshaw.html" class="nav-link">Rickshaw</a></li>
                <li class="nav-item"><a href="chart-sparkline.html" class="nav-link">Sparkline</a></li>
            </ul>
        </div><!-- sl-sideleft-menu -->

        <br>
    </div><!-- sl-sideleft -->
    <!-- ########## END: LEFT PANEL ########## -->

    <!-- ########## START: HEAD PANEL ########## -->
    <div class="sl-header">
        <div class="sl-header-left">
            <div class="navicon-left hidden-md-down"><a id="btnLeftMenu" href=""><i
                        class="icon ion-navicon-round"></i></a></div>
            <div class="navicon-left hidden-lg-up"><a id="btnLeftMenuMobile" href=""><i
                        class="icon ion-navicon-round"></i></a></div>
        </div><!-- sl-header-left -->
        <div class="sl-header-right">
            <nav class="nav">
                <div class="dropdown">
                    <a href="" class="nav-link nav-link-profile" data-toggle="dropdown">
                        <span class="logged-name">{{Auth::user()->name}}</span></span>
                        <img src="{{asset('uploads/profile_photos')}}/{{Auth::user()->profile_photo}}"
                            class="wd-32 rounded-circle" alt="">
                    </a>
                    <div class="dropdown-menu dropdown-menu-header wd-200">
                        <ul class="list-unstyled user-profile-nav">
                            <li><a href="{{ url('profile') }}"><i class="icon ion-ios-person-outline"></i> Edit
                                    Profile</a></li>
                            <li><a href="{{ route('logout') }}" onclick="
                  event.preventDefault();
                  document.getElementById('logout-form').submit();">
                                    <i class="icon ion-power"></i> Sign Out</a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </div><!-- dropdown-menu -->
                </div><!-- dropdown -->
            </nav>
            <div class="navicon-right">
                <a id="btnRightMenu" href="" class="pos-relative">
                    <i class="icon ion-ios-bell-outline"></i>
                    <!-- start: if statement -->
                    <span class="square-8 bg-danger"></span>
                    <!-- end: if statement -->
                </a>
            </div><!-- navicon-right -->
        </div><!-- sl-header-right -->
    </div><!-- sl-header -->
    <!-- ########## END: HEAD PANEL ########## -->

    <!-- ########## START: RIGHT PANEL ########## -->

    <!-- ########## END: RIGHT PANEL ########## --->


    <!-- ########## START: MAIN PANEL ########## -->

    @yield('dashboard_content')

    <div style="height: 60px; width: 100%"></div>

    <!-- ########## END: MAIN PANEL ########## -->


    <script src="{{asset('dashboard_asset')}}/lib/jquery/jquery.js"></script>
    <script src="{{asset('dashboard_asset')}}/lib/popper.js/popper.js"></script>
    <script src="{{asset('dashboard_asset')}}/lib/bootstrap/bootstrap.js"></script>
    <script src="{{asset('dashboard_asset')}}/lib/perfect-scrollbar/js/perfect-scrollbar.jquery.js"></script>
    <script src="{{asset('dashboard_asset')}}/lib/datatables/jquery.dataTables.js"></script>
    <script src="{{asset('dashboard_asset')}}/lib/datatables-responsive/dataTables.responsive.js"></script>
    <script src="{{asset('dashboard_asset')}}/lib/highlightjs/highlight.pack.js"></script>
    <script src="{{asset('dashboard_asset')}}/lib/chart.js/Chart.js"></script>

    <script src="{{asset('dashboard_asset')}}/js/starlight.js"></script>
    <script src="{{asset('dashboard_asset')}}/js/chart.chartjs.js"></script>

    @yield('script')

</body>

</html>
