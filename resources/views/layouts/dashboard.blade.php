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
    <header class="my_header d-flex justify-content-between position-fixed">
        <a class="logo-container" href="{{ route('admin.home') }}">
            <img src="../../storage/image/logo.png" alt="" srcset="">
        </a>
        {{-- Navbar desktop --}}
        <ul class="my_dashboard d-none d-md-flex d-lg-flex d-xl-flex justify-content-center align-items-center">
            <li class="nav-item">
                <a class="nav-link text-center" href="{{ route('admin.home') }}">
                    <i class="fas fa-home"></i>
                    <h6>Dashboard</h6>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-center" href="{{ route('admin.accomodations.index') }}">
                    <i class="far fa-building"></i>
                    <h6>Appartamenti</h6>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-center" href="{{ route('admin.accomodations.create') }}">
                    <i class="far fa-plus-square"></i>
                    <h6>Nuovo</h6>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-center" href="{{ route('admin.messages.index') }}">
                    <i class="fas fa-envelope"></i>
                    <h6>Messaggi</h6>
                </a>
            </li>
            {{-- <li class="nav-item">
                <a class="nav-link text-center" href="{{ route('admin.sponsors.sponsored') }}">
                    <span class="h3 d-none d-lg-block"><i class="fas fa-funnel-dollar"></i></span>
                    <span class="d-none d-lg-block">SPONSORIZZATI</span>
                </a>
            </li> --}}
        </ul>
        {{-- /Navbar Desktop --}}
        {{-- navbar mobile --}}
        <nav class="my_dashboard d-md-none d-lg-none d-xl-none d-flex justify-content-center align-items-center">
            <button
                class="dropdown"
                id="navDropdown"
                data-toggle="collapse"
                data-target="#collapseFilter"
                aria-expanded="false"
                aria-controls="collapseFilter"
            >
                <i class="fas fa-bars"></i>
            </button>
            <div class="collapse mt-3" id="collapseFilter" aria-labelledby="navDropdown">
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
            </div> 
        </nav>
        {{-- /navbar mobile --}}
        <a class="logo-container d-flex justify-content-center align-items-center" href="{{ route('logout') }}"
            onclick="event.preventDefault();
            document.getElementById('logout-form').submit();">
            <button class="btn ms-logout">Logout</button>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </header>

    {{-- /header --}}

    {{-- menu --}}

    <div class="container-fluid ms-mt-full">
        <div class="row py-4 align-items-center">
            <main role="main" class="col-md-12 col-sm-12 col-lg-12">
                @yield('content')
            </main>
        </div>
    </div>
    <footer class="align-self-end text-center text-lg-start bg-white text-muted w-100 d-flex align-items-center">
        <div class="my-footer">
            <!-- Copyright -->
            <h6>© 2021 Copyright: BoolBnB</h6>
            <div class="my_social">
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
                {{-- <a href="" class="me-4 link-secondary">
                    <i class="fab fa-github"></i>
                </a> --}}
            </div>
        </div>
    </footer>
</body>

</html>
