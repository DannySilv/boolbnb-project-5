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

<body style="background-color: rgb(240, 239, 239)">
    {{-- header --}}
    <div>
        <nav class="navbar navbar-expand-md flex-md-nowrap" style="height:100px !important;">
            <a class="px-4" href="{{ route('admin.home') }}">
                <img src="../../storage/image/logo.png" style="object-fit:contain" alt="" srcset="">
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
        </nav>


        <nav class="navbar navbar-expand-lg navbar-light"
            style="margin-top:100px;
                    background: rgb(248,249,250);
                    background: linear-gradient(360deg, rgb(240, 239, 239) 5%, rgba(255,255,255,1) 100%)">
            <div class="" id="navbarNav" style="margin: 0 auto;">
                <ul class=" flex-nowrap navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link text-center" href="{{ route('admin.home') }}">
                            <span class="h3 "><i class="fas fa-home"></i></span>
                            <span class="d-none d-lg-block">DASHBOARD</span>
                            <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-center" href="{{ route('admin.accomodations.index') }}">
                            <span class="h3"><i class="far fa-building"></i></span>
                            <span class="d-none d-lg-block">I MIEI APPARTAMENTI</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-center" href="{{ route('admin.accomodations.create') }}">
                            <span class="h3"><i class="far fa-plus-square"></i></span>
                            <span class="d-none d-lg-block">INSERISCI NUOVO</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-center" href="{{ route('admin.messages.index') }}">
                            <span class="h3"><i class="far fa-plus-square"></i></span>
                            <span class="d-none d-lg-block">MESSAGGI RICEVUTI</span>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>

    {{-- /header --}}

    {{-- menu --}}

    <div class="container-fluid">
        <div class="row">
            {{-- <nav class="navbar navbar-expand-lg navbar-light bg-light my-5">              
                <div class="" id="navbarNav" style="margin: 0 auto">
                    <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.home')}}">DASHBOARD <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.accomodations.index') }}">I MIEI APPARTAMENTI</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.accomodations.create') }}">INSERISCI UN NUOVO APPARTAMENTO</a>
                    </li>
                    </ul>
                </div>
            </nav> --}}


            <main role="main" class="col-md-12 col-sm-12 col-lg-12" style="padding-top:130px;">
                @yield('content')
            </main>
        </div>
    </div>
</body>

</html>
