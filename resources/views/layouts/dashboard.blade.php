<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.1/axios.min.js"
        integrity="sha512-2atqUo2wS2t/OOAfm820ye6NCOVHT3f8FrproTdW/lyOswy0DB7ylSVgvW4ZrjPHgvZTtHDddpYUMWXPB5GQ8g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.7.2/css/all.min.css"
        integrity="sha512-3M00D/rn8n+2ZVXBO9Hib0GKNpkm8MSUU/e2VNthDyBYxKWG+BftNYYcuEjXlyrSO637tidzMBXfE7sQm0INUg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body class="my_scroll" style="background-color: rgb(240, 239, 239)">
    {{-- header --}}
    <div>
        <nav class="my_header navbar navbar-expand-md navbar-light flex-md-nowrap" style="padding: 0;">
            <a class="px-4" href="{{ route('admin.home') }}">
                <img src="../../storage/image/logo.png" alt="" srcset="">
            </a>

            <ul class="navbar-nav px-3 ml-auto">
                {{-- <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}">
                        Visita il sito
                    </a>
                </li> --}}
                <li class="nav-item">
                    <a class="nav-link text-dark font-weight-bold" style="" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                        Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>

            <nav class="my_dashboard navbar navbar-expand-lg navbar-light">
                <div class="" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link text-center" href="{{ route('admin.home') }}">
                                <span class="h3 d-none d-lg-block"><i class="fas fa-home"></i></span>
                                <span class="d-none d-lg-block">DASHBOARD</span>
                                <span class="sr-only">(current)</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-center" href="{{ route('admin.accomodations.index') }}">
                                <span class="h3 d-none d-lg-block"><i class="far fa-building"></i></span>
                                <span class="d-none d-lg-block">I MIEI APPARTAMENTI</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-center" href="{{ route('admin.accomodations.create') }}">
                                <span class="h3 d-none d-lg-block"><i class="far fa-plus-square"></i></span>
                                <span class="d-none d-lg-block">INSERISCI NUOVO</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-center" href="{{ route('admin.messages.index') }}">
                                <span class="h3 d-none d-lg-block"><i class="fas fa-envelope"></i></span>
                                <span class="d-none d-lg-block">MESSAGGI RICEVUTI</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            {{-- navbar mobile --}}
            <nav
                class="navbar_mobile navbar navbar-expand-lg navbar-light d-lg-none d-block d-flex justify-content-center">
                <a href="{{ route('admin.home') }}"
                    class="nav-link text-secondary text-center h3 mx-md-5 mx-sm-3 mx-xs-2">
                    <i class="fas fa-home"></i>
                </a>
                <a href="{{ route('admin.accomodations.index') }}"
                    class="nav-link text-secondary text-center h3 mx-md-5 mx-sm-3 mx-xs-2">
                    <i class="far fa-building"></i>
                </a>
                <a href="{{ route('admin.accomodations.create') }}"
                    class="nav-link text-secondary text-center h3 mx-md-5 mx-sm-3 mx-xs-2">
                    <i class="far fa-plus-square"></i>
                </a>
                <a href="{{ route('admin.messages.index') }}"
                    class="nav-link text-secondary text-center h3 mx-md-5 mx-sm-3 mx-xs-2">
                    <i class="fas fa-envelope"></i>
                </a>
            </nav>
            {{-- /navbar mobile --}}
        </nav>



    </div>

    {{-- /header --}}

    {{-- menu --}}

    <div class="container-fluid">
        <div class="row">
            <main role="main" class="col-md-12 col-sm-12 col-lg-12" style="padding-top:130px; height:100%">
                @yield('content')
            </main>

            <footer class="text-center text-lg-start bg-white text-muted w-100">

                <!-- Section: Links  -->
                <section class="">
                    <div class="container text-center text-md-start mt-5">
                        <!-- Grid row -->
                        <div class="content row mt-3">
                            <!-- Grid column -->
                            <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4">
                                <!-- Content -->
                                {{-- <h5 class="text-uppercase fw-bold mb-4">
                        <i class="fas fa-gem me-3 text-secondary"></i>BoolBnB
                        </h5> --}}
                                <p>
                                    Le nostre proposte sono esperienze da portare nell'anima. Ogni soluzione è il
                                    perfetto equilibrio tra scoperta, stupore e relax.
                                </p>
                            </div>
                            <!-- Grid column -->

                            <!-- Grid column -->
                            <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4">
                                <!-- Links -->
                                <h6 class="text-uppercase fw-bold mb-4">
                                    Products
                                </h6>
                                <p>
                                    <a href="#!" class="text-reset">Alloggi</a>
                                </p>
                                <p>
                                    <a href="#!" class="text-reset">Esperienze</a>
                                </p>
                                <p>
                                    <a href="#!" class="text-reset">Visite</a>
                                </p>
                                <p>
                                    <a href="#!" class="text-reset">Residenze</a>
                                </p>
                            </div>
                            <!-- Grid column -->

                            <!-- Grid column -->
                            <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">
                                <!-- Links -->
                                <h6 class="text-uppercase fw-bold mb-4">
                                    Useful links
                                </h6>
                                <p>
                                    <a href="#!" class="text-reset">Pricing</a>
                                </p>
                                <p>
                                    <a href="#!" class="text-reset">Settings</a>
                                </p>
                                <p>
                                    <a href="#!" class="text-reset">Orders</a>
                                </p>
                                <p>
                                    <a href="#!" class="text-reset">Help</a>
                                </p>
                            </div>
                            <!-- Grid column -->

                            <!-- Grid column -->
                            <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
                                <!-- Links -->
                                <h6 class="text-uppercase fw-bold mb-4">Contact</h6>
                                <p><i class="fas fa-home me-3 text-secondary"></i> New York, NY 10012, US</p>
                                <p>
                                    <i class="fas fa-envelope me-3 text-secondary"></i>
                                    info@example.com
                                </p>
                                <p><i class="fas fa-phone me-3 text-secondary"></i> + 01 234 567 88</p>
                                <p><i class="fas fa-print me-3 text-secondary"></i> + 01 234 567 89</p>
                            </div>
                            <!-- Grid column -->
                        </div>
                        <!-- Grid row -->
                    </div>
                </section>
                <!-- Section: Links  -->

                <!-- Copyright -->
                <div class="text-center p-4" style="background-color: rgba(0, 0, 0, 0.025);">
                    © 2021 Copyright:
                    <a class="text-reset fw-bold" href="https://mdbootstrap.com/">MDBootstrap.com</a>
                    <div>
                        <a href="" class="me-4 link-secondary">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="" class="me-4 link-secondary">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="" class="me-4 link-secondary">
                            <i class="fab fa-google"></i>
                        </a>
                        <a href="" class="me-4 link-secondary">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="" class="me-4 link-secondary">
                            <i class="fab fa-linkedin"></i>
                        </a>
                        <a href="" class="me-4 link-secondary">
                            <i class="fab fa-github"></i>
                        </a>
                    </div>
                </div>
            </footer>
        </div>
    </div>
</body>

</html>
