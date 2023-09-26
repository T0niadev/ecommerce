<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Cashew Venture</title>

    <link rel="shortcut icon" type="image" href="">

    <!-- @notifyCss -->
    <!-- Fontawesome -->
    <link type="text/css" href="/frontend/vendor/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">

    <!-- Prism -->
    <link type="text/css" href="/frontend/vendor/prismjs/themes/prism.css" rel="stylesheet">

    <!-- Front CSS -->
    <link type="text/css" href="/frontend/css/front.css" rel="stylesheet">
    <!-- Owl CSS -->
    <link type="text/css" href="/frontend/css/owl.carousel.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link type="text/css" href="/frontend/css/custom.css" rel="stylesheet">
    <!-- Star CSS -->
    <link type="text/css" href="/frontend/css/star-rating-svg.css" rel="stylesheet">

    <!-- datatable CSS -->
    <link type="text/css" href="/frontend/css/DataTables/css/jquery.dataTables.min.css" rel="stylesheet">

    @yield('css')
</head>

<body>

    <header class="header-global">
        <nav id="navbar-main" class="navbar navbar-main navbar-expand-lg headroom py-lg-3 px-lg-6 navbar-dark navbar-theme-dark">
            <div class="container">
                <a class="text-white" href="/">
                    <h2>The Cashew Venture</h2>
                </a>
                <div class="navbar-collapse collapse" id="navbar_global">
                    <div class="navbar-collapse-header">
                        <div class="row">
                            <div class="col-6 collapse-brand">
                                <a href="/">
                                    <h2>Cashew</h2>
                                </a>
                            </div>
                            <div class="col-6 collapse-close">
                                <a href="#navbar_global" role="button" class="fas fa-times" data-toggle="collapse"
                                    data-target="#navbar_global" aria-controls="navbar_global" aria-expanded="false"
                                    aria-label="Toggle navigation"></a>
                            </div>
                        </div>
                    </div>
                    <ul class="navbar-nav navbar-nav-hover navbar-nav ml-lg-auto">

                        <li class="nav-item dropdown">
                            <a href="#" class="nav-link" data-toggle="dropdown" aria-controls="pages_submenu" aria-expanded="false" aria-label="Toggle pages menu item">
                                <span class="nav-link-inner-text">{{Auth::user()?Auth::user()->name:'My account'}}</span>
                                <span class="fas fa-angle-down nav-link-arrow ml-2"></span>
                            </a>
                            <ul class="dropdown-menu" id="pages_submenu">
                                @if (Auth::user())
                                    <li><a class="dropdown-item" href="/dashboard">Dashboard</a></li>

                                     <li><a class="dropdown-item" href="/admin">Settings</a></li>

                                    <li><a class="dropdown-item" href="#" id="logout-btn">Logout</a></li>
                                    <form id="logout-form" action="{{ url('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                @else
                                    <li><a class="dropdown-item" href="/login">Login</a></li>
                                    <li><a class="dropdown-item" href="/register">Register</a></li>
                                @endif
                            </ul>
                        </li>
                    </ul>

                </div>

                <div class="d-none d-lg-block">
                    <a href="/cart" class="text-white"><i class="fas fa-shopping-cart"></i>
                        <span class="badge badge-danger">
                            Total quantity
                        </span>
                    </a>
                </div>

                <div class="d-flex d-lg-none align-items-center">
                    <a href="/cart" class="text-white"><i class="fas fa-shopping-cart"></i>
                        <span class="badge badge-danger">
                            Total quantity
                        </span>
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar_global"
                        aria-controls="navbar_global" aria-expanded="false" aria-label="Toggle navigation"><span
                        class="navbar-toggler-icon"></span>
                    </button>
                </div>
            </div>
        </nav>

    </header>

    <main>

        <div class="preloader bg-gradient-dark flex-column justify-content-center align-items-center" >
            <div class="loader-element" >
                <span class="loader-animated-dot"></span>
                <h1 style="color: white; font-size: 80px;">The Cashew Venture</h1>
                   <div class="mr-1">
                        <a href="" class="text-white"><i class="fas fa-shopping-cart"></i>
                            <span class="badge badge-danger" style="color: white; font-size: 20px;" class="text-center">
                                Start buying now
                            </span>
                        </a>
                   </div>
            </div>
        </div>

        @yield('content')

        <footer class="footer section pt-6 pt-md-8 pt-lg-10 pb-3 bg-dark text-white overflow-hidden">
            <div class="pattern pattern-soft top"></div>
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 mb-4 mb-lg-0">
                        <a class="footer-brand mr-lg-5 d-flex" href="/">
                            <h2>Home</h2>
                        </a>
                        <p class="my-4">The best oline store</p>
                    </div>
                    <div class="col-6 col-sm-3 col-lg-2 mb-4 mb-lg-0">
                        <h4>Navigation</h4>
                        <ul class="links-vertical">
                            <li><a href="{{ url('/') }}">Home</a></li>
                            <!-- <li><a  href="{{ url('/projects') }}">Projects</a></li> -->
                            <!-- <li><a  href="{{ url('/services') }}">Services</a></li> -->
                            <li><a  href="{{ url('/about') }}">About us</a></li>
                            <li><a  href="{{ url('/contact-us') }}">Contact us</a></li>
                        </ul>
                    </div>
                    <div class="col-6 col-sm-3 col-lg-2 mb-4 mb-lg-0">
                        <h4>Useful Pages</h4>
                        <ul class="links-vertical">
                          <li><a  href="{{ url('/posts') }}">Blog</a></li>
                        </ul>
                        <ul class="links-vertical mt-2">
                            Reviews
                        </ul>
                        <ul class="links-vertical mt-2">
                            Ratings
                        </ul>
                    </div>
                    <div class="col-12 col-sm-3 col-lg-2">
                        <h4>Social</h4>
                        <ul class="links-vertical">
                            <li><a href="https://instagram.com/ttechsolution?igshid=YmMyMTA2M2Y=" target="_blank">Instagram</a></li>
                            <li><a  href="https://twitter.com/folsyolats?s=11&t=Rx1XeRtIGJMwQ0mdwhqMNw" target="_blank">Twitter</a></li>
                            <li><a  href="https://www.linkedin.com/in/ifeoluwa-odubiyi-6572431a0" target="_blank">LinkedIn</a></li>
                            <li><a  href="" target="_blank">Youtube</a></li>
                        </ul>
                    </div>
                </div>
                <hr class="my-4 my-lg-5">
                <div class="row">
                    <div class="col pb-4 mb-md-0">
                        <div class="d-flex text-center justify-content-center align-items-center">
                        <p class="font-weight-normal mb-0">© title <span class="current-year"></span>. All rights reserved.</p>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </main>
    <!-- Core -->
    <script src="/frontend/vendor/jquery/dist/jquery.min.js"></script>
    <!-- Datatables JS -->
    <script src="/frontend/assets/js/datatables.min.js"></script>

    <script src="/frontend/vendor/popper.js/dist/umd/popper.min.js"></script>
    <script src="/frontend/vendor/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="/frontend/vendor/headroom.js/dist/headroom.min.js"></script>

    <!-- Vendor JS -->
    <script src="/frontend/vendor/onscreen/dist/on-screen.umd.min.js"></script>
    <script src="/frontend/vendor/waypoints/lib/jquery.waypoints.min.js"></script>
    <script src="/frontend/vendor/jarallax/dist/jarallax.min.js"></script>
    <script src="/frontend/vendor/smooth-scroll/dist/smooth-scroll.polyfills.min.js"></script>

    <!-- Button Js -->
    <script async defer src="/frontend/assets/js/button.js"></script>

    <!-- Impact JS -->
    <script src="/frontend/assets/js/front.js"></script>
    <!-- Star JS -->
    <script src="/frontend/assets/js/jquery.star-rating-svg.js"></script>
    <!-- Owl JS -->
    <script src="/frontend/assets/js/owl.carousel.min.js"></script>
    <!-- Select2 JS -->
    <script src="/frontend/assets/js/select2.min.js"></script>
    <!-- Custom JS -->
    <script src="/frontend/assets/js/custom.js"></script>



   
    @yield('javascript')
</body>

</html>
