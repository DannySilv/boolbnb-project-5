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

</head>

<body>
    <nav class="navbar navbar-expand-md navbar-dark bg-dark flex-md-nowrap p-0">
        <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">Bool BnB</a>
        <ul class="navbar-nav px-3 ml-auto">
            {{-- <li class="nav-item">
                <a class="nav-link" href="{{ route('home') }}">
                    Visita il sito
                </a>
            </li> --}}
            <li class="nav-item">
                <a class="nav-link" href="{{ route('logout') }}"
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
    <div class="container-fluid">
        <div class="row">
            <nav class="col-md-2 d-none d-md-block bg-light sidebar py-4">
                <div class="sidebar-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item mb-3">
                            <a class="nav-link active" href="{{ route('admin.home') }}">
                                <i class="fa-solid fa-house"></i>
                                Dashboard
                            </a>
                        </li>
                        <li class="nav-item mb-3">
                            <a class="nav-link" href="{{ route('admin.accomodations.index') }}">
                                <i class="fa-solid fa-cannabis"></i>
                                I miei appartamenti
                            </a>
                        </li>
                        <li class="nav-item mb-3">
                            <a class="nav-link" href="{{ route('admin.accomodations.create') }}">
                                <i class="fa-solid fa-square-plus"></i>
                                Inserisci un nuovo appartamento
                            </a>
                        </li>
                    </ul>

                </div>
            </nav>

            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4 py-4">
                @yield('content')
            </main>
        </div>
    </div>
</body>

</html>
